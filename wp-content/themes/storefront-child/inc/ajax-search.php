<?php
/**
 * AJAX-обработчик для поиска городов.
 *
 * @package YourChildTheme
 */

/**
 * Обрабатывает AJAX-запрос поиска городов.
 */
function child_theme_ajax_city_search() {
    // Проверка nonce для безопасности.
    check_ajax_referer( 'child_theme_ajax_nonce', 'nonce' );

    $search_query = isset( $_POST['query'] ) ? sanitize_text_field( $_POST['query'] ) : '';

    global $wpdb;

    // Формируем запрос для поиска городов по заголовку.
    $query = $wpdb->prepare(
        "SELECT ID, post_title FROM {$wpdb->posts} WHERE post_type = %s AND post_status = 'publish' AND post_title LIKE %s",
        'cities',
        '%' . $wpdb->esc_like( $search_query ) . '%'
    );
    $results = $wpdb->get_results( $query );

    $cities = array();
    if ( $results ) {
        foreach ( $results as $city ) {
            $cities[] = array(
                'id'    => $city->ID,
                'title' => $city->post_title,
            );
        }
    }
    wp_send_json_success( $cities );
}
add_action( 'wp_ajax_city_search', 'child_theme_ajax_city_search' );
add_action( 'wp_ajax_nopriv_city_search', 'child_theme_ajax_city_search' );
