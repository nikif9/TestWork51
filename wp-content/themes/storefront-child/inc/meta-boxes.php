<?php
/**
 * Метабоксы для типа записи "Cities".
 *
 * @package YourChildTheme
 */

/**
 * Регистрирует метабокс для координат города.
 */
function child_theme_add_meta_boxes() {
    add_meta_box(
        'city_coordinates_meta_box',
        __('City Coordinates', 'your-child-theme'),
        'child_theme_render_city_coordinates_meta_box',
        'cities',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'child_theme_add_meta_boxes');

/**
 * Отображает содержимое метабокса для ввода координат.
 *
 * @param WP_Post $post Объект записи.
 */
function child_theme_render_city_coordinates_meta_box($post) {
    // Добавляем nonce для проверки.
    wp_nonce_field('child_theme_save_city_coordinates', 'child_theme_city_coordinates_nonce');

    // Получаем существующие значения.
    $latitude  = get_post_meta($post->ID, '_city_latitude', true);
    $longitude = get_post_meta($post->ID, '_city_longitude', true);
    ?>
    <p>
        <label for="city_latitude"><?php esc_html_e('Latitude:', 'your-child-theme'); ?></label>
        <input type="text" name="city_latitude" id="city_latitude" value="<?php echo esc_attr($latitude); ?>" style="width:100%;" />
    </p>
    <p>
        <label for="city_longitude"><?php esc_html_e('Longitude:', 'your-child-theme'); ?></label>
        <input type="text" name="city_longitude" id="city_longitude" value="<?php echo esc_attr($longitude); ?>" style="width:100%;" />
    </p>
    <?php
}

/**
 * Сохраняет данные метабокса при сохранении записи.
 *
 * @param int $post_id ID записи.
 */
function child_theme_save_city_coordinates($post_id) {
    // Проверяем nonce.
    if ( ! isset( $_POST['child_theme_city_coordinates_nonce'] ) || ! wp_verify_nonce( $_POST['child_theme_city_coordinates_nonce'], 'child_theme_save_city_coordinates' ) ) {
        return;
    }

    // Игнорируем автосохранение.
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    // Проверяем права пользователя.
    if ( isset( $_POST['post_type'] ) && 'cities' === $_POST['post_type'] ) {
        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }
    }

    // Сохраняем latitude.
    if ( isset( $_POST['city_latitude'] ) ) {
        update_post_meta( $post_id, '_city_latitude', sanitize_text_field( $_POST['city_latitude'] ) );
    }

    // Сохраняем longitude.
    if ( isset( $_POST['city_longitude'] ) ) {
        update_post_meta( $post_id, '_city_longitude', sanitize_text_field( $_POST['city_longitude'] ) );
    }
}
add_action('save_post', 'child_theme_save_city_coordinates');
