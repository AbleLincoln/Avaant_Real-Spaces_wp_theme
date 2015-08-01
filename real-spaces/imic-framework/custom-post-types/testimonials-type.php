<?php
/* ==================================================
   Testimonials Post Type Functions
================================================== */
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly
    add_action('init', 'testimonials_register');  
  function testimonials_register() {  
	$labels = array(
		'name' => __('Testimonials', 'framework'),
		'singular_name' => __('Testimonial', 'framework'),
		'add_new' => __('Add New', 'framework'),
		'add_new_item' => __('Add New Testimonial', 'framework'),
		'edit_item' => __('Edit Testimonial', 'framework'),
		'new_item' => __('New Testimonial', 'framework'),
		'view_item' => __('View Testimonial', 'framework'),
		'search_items' => __('Search Testimonials', 'framework'),
		'not_found' =>  __('No testimonials have been added yet', 'framework'),
		'not_found_in_trash' => __('Nothing found in Trash', 'framework'),
		'parent_item_colon' => ''
	);
	$args = array(  
		'labels' => $labels, 
		'menu_icon' => 'dashicons-format-quote', 
		'public' => true,  
		'show_ui' => true,
		'show_in_menu' => true,
		'show_in_nav_menus' => false,
		'rewrite' => false,
		'supports' => array('title', 'editor', 'thumbnail'),
		'has_archive' => true
	   );  
  
	register_post_type( 'testimonials' , $args );  
}  
?>