<?php
/* ==================================================
  Properties Post Type Functions
  ================================================== */
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly
$args = array(
	"label" 			=> __('Types', 'framework'), 
	"singular_label" 	=> __('Type', 'framework'), 
	'public'            => true,
	'hierarchical'      => true,
	'show_ui'           => true,
	'show_in_nav_menus' => true,
	'args'              => array( 'orderby' => 'term_order' ),
	'rewrite'           => false,
	'query_var'         => true,
	'show_admin_column' => true,
);
register_taxonomy( 'property-type', 'property', $args );
$args = array(
	"label" 			=> __('Contract Types', 'framework'), 
	"singular_label" 	=> __('Contract Type', 'framework'), 
	'public'            => true,
	'hierarchical'      => true,
	'show_ui'           => true,
	'show_in_nav_menus' => true,
	'args'              => array( 'orderby' => 'term_order' ),
	'rewrite'           => false,
	'query_var'         => true,
	'show_admin_column' => true,
);
register_taxonomy( 'property-contract-type', 'property', $args );
$args_c = array(
	"label" 			=> __('Cities', 'framework'), 
	"singular_label" 	=> __('City', 'framework'), 
	'public'            => true,
	'hierarchical'      => true,
	'show_ui'           => true,
	'show_in_nav_menus' => true,
	'args'              => array( 'orderby' => 'term_order' ),
	'rewrite'           => false,
	'query_var'         => true,
	'show_admin_column' => true,
);
register_taxonomy( 'city-type', 'property', $args_c );	
add_action('init', 'property_register');  
	  
function property_register() {  
	$labels = array(
		'name' => __('Properties', 'framework'),
		'singular_name' => __('Property', 'framework'),
		'add_new' => __('Add New', 'framework'),
		'add_new_item' => __('Add New Property', 'framework'),
		'edit_item' => __('Edit Property', 'framework'),
		'new_item' => __('New Property', 'framework'),
		'view_item' => __('View Property', 'framework'),
		'search_items' => __('Search Properties', 'framework'),
		'not_found' =>  __('No Properties have been added yet', 'framework'),
		'not_found_in_trash' => __('Nothing found in Trash', 'framework'),
		'parent_item_colon' => ''
	);
	$args = array(  
		'labels' => $labels, 
		'menu_icon' => 'dashicons-location-alt', 
		'public' => true,  
		'show_ui' => true,
		'show_in_menu' => true,
		'show_in_nav_menus' => true,
            
		'rewrite' => false,
		'supports' => array('title', 'editor', 'thumbnail','author'),
		'has_archive' => true,
		'taxonomies' => array('property-type', 'property-contract-type')
	   );  
  
	register_post_type( 'property' , $args );  
}  
?>