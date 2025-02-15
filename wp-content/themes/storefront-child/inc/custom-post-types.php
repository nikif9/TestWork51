<?php
/**
 * Регистрация пользовательского типа записей "Cities".
 *
 * @package YourChildTheme
 */

/**
 * Регистрирует тип записи "Cities".
 */
function child_theme_register_cities_cpt() {
    $labels = array(
        'name'                  => _x('Cities', 'Post Type General Name', 'your-child-theme'),
        'singular_name'         => _x('City', 'Post Type Singular Name', 'your-child-theme'),
        'menu_name'             => __('Cities', 'your-child-theme'),
        'name_admin_bar'        => __('City', 'your-child-theme'),
        'archives'              => __('City Archives', 'your-child-theme'),
        'attributes'            => __('City Attributes', 'your-child-theme'),
        'parent_item_colon'     => __('Parent City:', 'your-child-theme'),
        'all_items'             => __('All Cities', 'your-child-theme'),
        'add_new_item'          => __('Add New City', 'your-child-theme'),
        'add_new'               => __('Add New', 'your-child-theme'),
        'new_item'              => __('New City', 'your-child-theme'),
        'edit_item'             => __('Edit City', 'your-child-theme'),
        'update_item'           => __('Update City', 'your-child-theme'),
        'view_item'             => __('View City', 'your-child-theme'),
        'view_items'            => __('View Cities', 'your-child-theme'),
        'search_items'          => __('Search City', 'your-child-theme'),
        'not_found'             => __('Not found', 'your-child-theme'),
        'not_found_in_trash'    => __('Not found in Trash', 'your-child-theme'),
        'featured_image'        => __('Featured Image', 'your-child-theme'),
        'set_featured_image'    => __('Set featured image', 'your-child-theme'),
        'remove_featured_image' => __('Remove featured image', 'your-child-theme'),
        'use_featured_image'    => __('Use as featured image', 'your-child-theme'),
        'insert_into_item'      => __('Insert into city', 'your-child-theme'),
        'uploaded_to_this_item' => __('Uploaded to this city', 'your-child-theme'),
        'items_list'            => __('Cities list', 'your-child-theme'),
        'items_list_navigation' => __('Cities list navigation', 'your-child-theme'),
        'filter_items_list'     => __('Filter cities list', 'your-child-theme'),
    );
    $args = array(
        'label'                 => __('City', 'your-child-theme'),
        'description'           => __('Custom post type for cities', 'your-child-theme'),
        'labels'                => $labels,
        'supports'              => array('title', 'editor', 'thumbnail'),
        'taxonomies'            => array('countries'),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-location-alt',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'post',
        'show_in_rest'          => true,
    );
    register_post_type('cities', $args);
}
add_action('init', 'child_theme_register_cities_cpt', 0);
