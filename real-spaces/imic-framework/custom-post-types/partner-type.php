<?php
/* ==================================================
  Partner Post Type Functions
  ================================================== */
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly
add_action('init', 'partner_register');
function partner_register() {
    $labels = array(
        'name' => __('Partners', 'framework'),
        'singular_name' => __('Partner', 'framework'),
        'all_items'=> __('Partners', 'framework'),
        'add_new' => __('Add New', 'framework'),
        'add_new_item' => __('Add New Partner', 'framework'),
        'edit_item' => __('Edit Partner', 'framework'),
        'new_item' => __('New Partner', 'framework'),
        'view_item' => __('View Partner', 'framework'),
        'search_items' => __('Search Partner', 'framework'),
        'not_found' => __('No partner have been added yet', 'framework'),
        'not_found_in_trash' => __('Nothing found in Trash', 'framework'),
        'parent_item_colon' => ''
    );
    $args = array(
        'labels' => $labels,
		'menu_icon' => 'dashicons-groups',
		'capability_type' => 'page',
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => false,
        'rewrite' => false,
        'supports' => array('title'),
        'has_archive' => true,
    );
    register_post_type('partner', $args);
}
?>