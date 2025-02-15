<?php
/**
 * Функции дочерней темы.
 *
 * @package YourChildTheme
 */

// Подключение файлов с функционалом.
require_once get_stylesheet_directory() . '/inc/custom-post-types.php';
require_once get_stylesheet_directory() . '/inc/meta-boxes.php';
require_once get_stylesheet_directory() . '/inc/taxonomies.php';
require_once get_stylesheet_directory() . '/inc/widgets.php';
require_once get_stylesheet_directory() . '/inc/ajax-search.php';


function storefront_child_enqueue_styles() {
    // Имя стиля родительской темы.
    $parent_style = 'storefront-style';

    // Подключаем стиль родительской темы.
    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );

    // Подключаем стиль дочерней темы и делаем его зависимым от родительского.
    wp_enqueue_style( 'storefront-child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style ),
        wp_get_theme()->get('Version')
    );
}

/**
 * Регистрирует и подключает JS для AJAX-поиска.
 */
function child_theme_enqueue_scripts() {
    wp_enqueue_script(
        'child-theme-ajax',
        get_stylesheet_directory_uri() . '/js/ajax-search.js',
        array('jquery'),
        null,
        true
    );
    
    // Передаём переменные в скрипт.
    wp_localize_script('child-theme-ajax', 'childThemeAjax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('child_theme_ajax_nonce')
    ));
}

add_action('wp_enqueue_scripts', 'child_theme_enqueue_scripts');
add_action( 'wp_enqueue_scripts', 'storefront_child_enqueue_styles' );
