<?php
/* ==================================================
  Agent Post Type Functions
  ================================================== */
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly
add_action('init', 'slide_register');
function slide_register() {
    $labels = array(
        'name' => __('Slides', 'framework'),
        'singular_name' => __('Slide', 'framework'),
        'all_items'=> __('Slides', 'framework'),
        'add_new' => __('Add New', 'framework'),
        'add_new_item' => __('Add New Slide', 'framework'),
        'edit_item' => __('Edit Slide', 'framework'),
        'new_item' => __('New Slide', 'framework'),
        'view_item' => __('View Slide', 'framework'),
        'search_items' => __('Search Slide', 'framework'),
        'not_found' => __('No slide have been added yet', 'framework'),
        'not_found_in_trash' => __('Nothing found in Trash', 'framework'),
        'parent_item_colon' => ''
    );
    $args = array(
        'labels' => $labels,
		'menu_icon' => 'dashicons-format-gallery',
		'capability_type' => 'page',
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'rewrite' => false,
        'supports' => array('title'),
        'has_archive' => true,
    );
    register_post_type('slide', $args);
}
?>