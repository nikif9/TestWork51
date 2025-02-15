<?php
/**
 * Регистрация пользовательской таксономии "Countries".
 *
 * @package YourChildTheme
 */

/**
 * Регистрирует таксономию "Countries" для Cities.
 */
function child_theme_register_countries_taxonomy() {
    $labels = array(
        'name'                       => _x('Countries', 'Taxonomy General Name', 'your-child-theme'),
        'singular_name'              => _x('Country', 'Taxonomy Singular Name', 'your-child-theme'),
        'menu_name'                  => __('Countries', 'your-child-theme'),
        'all_items'                  => __('All Countries', 'your-child-theme'),
        'parent_item'                => __('Parent Country', 'your-child-theme'),
        'parent_item_colon'          => __('Parent Country:', 'your-child-theme'),
        'new_item_name'              => __('New Country Name', 'your-child-theme'),
        'add_new_item'               => __('Add New Country', 'your-child-theme'),
        'edit_item'                  => __('Edit Country', 'your-child-theme'),
        'update_item'                => __('Update Country', 'your-child-theme'),
        'view_item'                  => __('View Country', 'your-child-theme'),
        'separate_items_with_commas' => __('Separate countries with commas', 'your-child-theme'),
        'add_or_remove_items'        => __('Add or remove countries', 'your-child-theme'),
        'choose_from_most_used'      => __('Choose from the most used', 'your-child-theme'),
        'popular_items'              => __('Popular Countries', 'your-child-theme'),
        'search_items'               => __('Search Countries', 'your-child-theme'),
        'not_found'                  => __('Not Found', 'your-child-theme'),
        'no_terms'                   => __('No countries', 'your-child-theme'),
        'items_list'                 => __('Countries list', 'your-child-theme'),
        'items_list_navigation'      => __('Countries list navigation', 'your-child-theme'),
    );
    $args = array(
        'labels'            => $labels,
        'hierarchical'      => true,
        'public'            => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'show_in_nav_menus' => true,
        'show_tagcloud'     => true,
        'show_in_rest'      => true,
    );
    register_taxonomy('countries', array('cities'), $args);
}
add_action('init', 'child_theme_register_countries_taxonomy', 0);
