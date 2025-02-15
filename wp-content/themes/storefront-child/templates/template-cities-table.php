<?php
/**
 * Template Name: Cities Table
 *
 * Шаблон для вывода таблицы стран, городов и температуры.
 *
 * Для получения данных используется прямой SQL-запрос через $wpdb.
 * Над таблицей выводится поле поиска (AJAX), а до и после таблицы – custom action hook.
 *
 * @package YourChildTheme
 */

get_header();

// Задайте ваш ключ OpenWeatherMap API.
$api_key = 'd158d9ef98129c8759a3890087a25d1c'; // Замените на актуальный ключ.

// Custom action hook перед таблицей.
do_action('child_theme_before_cities_table');
?>

<div class="city-search-container">
    <input type="text" id="city-search-input" placeholder="<?php esc_attr_e('Search cities...', 'your-child-theme'); ?>">
    <div id="city-search-results"></div>
</div>

<?php
global $wpdb;
$query = "
    SELECT p.ID as city_id, p.post_title as city_name, 
           pm_lat.meta_value as latitude, pm_lon.meta_value as longitude, 
           t.name as country_name
    FROM {$wpdb->posts} p
    LEFT JOIN {$wpdb->postmeta} pm_lat ON (p.ID = pm_lat.post_id AND pm_lat.meta_key = '_city_latitude')
    LEFT JOIN {$wpdb->postmeta} pm_lon ON (p.ID = pm_lon.post_id AND pm_lon.meta_key = '_city_longitude')
    LEFT JOIN {$wpdb->term_relationships} tr ON (p.ID = tr.object_id)
    LEFT JOIN {$wpdb->term_taxonomy} tt ON (tr.term_taxonomy_id = tt.term_taxonomy_id AND tt.taxonomy = 'countries')
    LEFT JOIN {$wpdb->terms} t ON (tt.term_id = t.term_id)
    WHERE p.post_type = %s AND p.post_status = 'publish'
    ORDER BY t.name, p.post_title
";
$prepared_query = $wpdb->prepare( $query, 'cities' );
$cities = $wpdb->get_results( $prepared_query );
?>

<table class="cities-table" border="1" cellspacing="0" cellpadding="5">
    <thead>
        <tr>
            <th><?php esc_html_e('Country', 'your-child-theme'); ?></th>
            <th><?php esc_html_e('City', 'your-child-theme'); ?></th>
            <th><?php esc_html_e('Temperature (°C)', 'your-child-theme'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php if ( $cities ) : ?>
            <?php foreach ( $cities as $city ) : ?>
                <tr>
                    <td><?php echo esc_html( $city->country_name ? $city->country_name : __( 'N/A', 'your-child-theme' ) ); ?></td>
                    <td><?php echo esc_html( $city->city_name ); ?></td>
                    <td>
                        <?php
                        if ( $city->latitude && $city->longitude && $api_key !== 'YOUR_OPENWEATHERMAP_API_KEY' ) {
                            $weather = child_theme_get_weather( $city->latitude, $city->longitude, $api_key );
                            if ( $weather && isset( $weather['main']['temp'] ) ) {
                                echo esc_html( $weather['main']['temp'] );
                            } else {
                                esc_html_e( 'N/A', 'your-child-theme' );
                            }
                        } else {
                            esc_html_e( 'N/A', 'your-child-theme' );
                        }
                        ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else : ?>
            <tr>
                <td colspan="3"><?php esc_html_e( 'No cities found.', 'your-child-theme' ); ?></td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<?php
// Custom action hook после таблицы.
do_action('child_theme_after_cities_table');

get_footer();
