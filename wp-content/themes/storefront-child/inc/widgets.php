<?php
/**
 * Виджет для отображения города и его текущей температуры.
 *
 * @package YourChildTheme
 */

/**
 * Класс виджета "City Temperature Widget".
 */
class City_Temperature_Widget extends WP_Widget {

    /**
     * Инициализация виджета.
     */
    public function __construct() {
        parent::__construct(
            'city_temperature_widget', // ID виджета.
            __('City Temperature Widget', 'your-child-theme'), // Название.
            array( 'description' => __('Displays selected city and current temperature using OpenWeatherMap API.', 'your-child-theme') )
        );
    }

    /**
     * Форма настроек виджета в админке.
     *
     * @param array $instance Текущие настройки виджета.
     */
    public function form( $instance ) {
        $selected_city = ! empty( $instance['selected_city'] ) ? $instance['selected_city'] : '';
        $api_key       = ! empty( $instance['api_key'] ) ? $instance['api_key'] : '';
        ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'selected_city' ) ); ?>">
                <?php esc_html_e( 'Select City:', 'your-child-theme' ); ?>
            </label>
            <select id="<?php echo esc_attr( $this->get_field_id( 'selected_city' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'selected_city' ) ); ?>" style="width:100%;">
                <option value=""><?php esc_html_e( '-- Select --', 'your-child-theme' ); ?></option>
                <?php
                $cities = get_posts( array(
                    'post_type'      => 'cities',
                    'posts_per_page' => -1,
                    'orderby'        => 'title',
                    'order'          => 'ASC',
                ) );
                foreach ( $cities as $city ) {
                    printf(
                        '<option value="%s" %s>%s</option>',
                        esc_attr( $city->ID ),
                        selected( $selected_city, $city->ID, false ),
                        esc_html( get_the_title( $city->ID ) )
                    );
                }
                ?>
            </select>
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'api_key' ) ); ?>">
                <?php esc_html_e( 'OpenWeatherMap API Key:', 'your-child-theme' ); ?>
            </label>
            <input type="text" id="<?php echo esc_attr( $this->get_field_id( 'api_key' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'api_key' ) ); ?>" value="<?php echo esc_attr( $api_key ); ?>" style="width:100%;" />
        </p>
        <?php
    }

    /**
     * Сохраняет настройки виджета.
     *
     * @param array $new_instance Новые настройки.
     * @param array $old_instance Старые настройки.
     * @return array Обновлённые настройки.
     */
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['selected_city'] = ( ! empty( $new_instance['selected_city'] ) ) ? absint( $new_instance['selected_city'] ) : '';
        $instance['api_key']       = ( ! empty( $new_instance['api_key'] ) ) ? sanitize_text_field( $new_instance['api_key'] ) : '';
        return $instance;
    }

    /**
     * Выводит содержимое виджета на сайте.
     *
     * @param array $args     Аргументы отображения виджета.
     * @param array $instance Настройки виджета.
     */
    public function widget( $args, $instance ) {
        echo $args['before_widget'];

        $city_id = ! empty( $instance['selected_city'] ) ? absint( $instance['selected_city'] ) : 0;
        $api_key = ! empty( $instance['api_key'] ) ? sanitize_text_field( $instance['api_key'] ) : '';

        if ( $city_id && $api_key ) {
            $city_title = get_the_title( $city_id );
            // Получаем координаты города.
            $latitude  = get_post_meta( $city_id, '_city_latitude', true );
            $longitude = get_post_meta( $city_id, '_city_longitude', true );

            if ( $latitude && $longitude ) {
                // Получаем данные о погоде.
                $weather = child_theme_get_weather( $latitude, $longitude, $api_key );
                if ( $weather && isset( $weather['main']['temp'] ) ) {
                    $temperature = $weather['main']['temp'];
                    echo '<div class="city-temperature-widget">';
                    echo '<h3>' . esc_html( $city_title ) . '</h3>';
                    echo '<p>' . sprintf( esc_html__( 'Current Temperature: %s °C', 'your-child-theme' ), esc_html( $temperature ) ) . '</p>';
                    echo '</div>';
                } else {
                    echo '<p>' . esc_html__( 'Weather data not available.', 'your-child-theme' ) . '</p>';
                }
            } else {
                echo '<p>' . esc_html__( 'Coordinates not set for this city.', 'your-child-theme' ) . '</p>';
            }
        } else {
            echo '<p>' . esc_html__( 'Please configure the widget settings.', 'your-child-theme' ) . '</p>';
        }

        echo $args['after_widget'];
    }
}

/**
 * Получает данные о погоде с помощью OpenWeatherMap API.
 *
 * @param string $latitude  Широта.
 * @param string $longitude Долгота.
 * @param string $api_key   Ключ API.
 * @return array|false      Массив с данными о погоде или false при ошибке.
 */
function child_theme_get_weather( $latitude, $longitude, $api_key ) {
    $endpoint = 'https://api.openweathermap.org/data/2.5/weather';
    $params   = array(
        'lat'   => $latitude,
        'lon'   => $longitude,
        'appid' => $api_key,
        'units' => 'metric',
    );
    $url = add_query_arg( $params, $endpoint );

    $response = wp_remote_get( $url, array( 'timeout' => 10 ) );

    if ( is_wp_error( $response ) ) {
        return false;
    }

    $body = wp_remote_retrieve_body( $response );
    $data = json_decode( $body, true );

    return $data;
}

/**
 * Регистрирует виджет.
 */
function child_theme_register_widgets() {
    register_widget( 'City_Temperature_Widget' );
}
add_action( 'widgets_init', 'child_theme_register_widgets' );
