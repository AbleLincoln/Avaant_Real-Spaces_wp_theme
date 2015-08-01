<?php
/**
 * Plugin Name: Favorite Property
 * Plugin URI: 
 * Description: Favorite Property and search.
 * Version: 1.1.0
 * Author: Favorite Property
 * Author URI: http://URI_Of_The_Plugin_Author
 */
global $wpdb;
define( 'FAVORITE_VERSION', '1.1.0' );
define( 'FAVORITE__PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'FAVORITE__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'FAVORITE__TABLE_NAME', $wpdb->prefix . "favorite_property_search" );
add_shortcode('favorite','favoriteShortcode');
function favoriteShortcode(){
$output='<div class ="favorite_information">';
$output.= '<a class ="favorite">' . __('Favorite', 'framework') . '</a>';
$current_user = wp_get_current_user();
global $wpdb;
$output.='<span class ="f_author_n" id ="' . $current_user->ID . '"></span>';
$output.='<span class ="f_property_n" id ="' . get_the_ID() . '"></span>';
$output.='</div>';
return $output;
}
add_shortcode('addtosearch','addtosearchShortcode');
function addtosearchShortcode(){
	$output = '';
	$output='<div class="search_information block-heading" id="details">
<h4><span class="heading-icon"><i class="fa fa-search"></i></span>'.__('Property Results','framework').'</h4>';
	if(is_user_logged_in()) {
$output.= '<a class="btn btn-primary btn-sm pull-right" data-target="#searchmodal" data-toggle="modal">' . __('Save Search', 'framework') . '</a>';
$current_user = wp_get_current_user();
global $wpdb;
$output.='<span class ="f_author_n" id ="' . $current_user->ID . '"></span>';
 }
else {
	$output .= '<a class="btn btn-primary btn-sm pull-right" id="show_login" data-target="#mymodal" data-toggle="modal" title="'.__('Login to Save Search','framework').'">'.__('Login','framework').'</a>
';
}
$output.='</div>';
return $output;
}
/** -------------------------------------------------------------------------------------
 * Create Transaction Table
 * @since Real-spaces 1.2
 ----------------------------------------------------------------------------------- */
if(!function_exists('create_favorite_table')){
function create_favorite_table() {
require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
global $wpdb;
$db_table_name = FAVORITE__TABLE_NAME;
if( $wpdb->get_var( "SHOW TABLES LIKE '$db_table_name'" ) != $db_table_name ) {
if ( ! empty( $wpdb->charset ) )
$charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
if ( ! empty( $wpdb->collate ) )
$charset_collate .= " COLLATE $wpdb->collate";
$sql = "CREATE TABLE " . $db_table_name . " (
id int(11) NOT NULL AUTO_INCREMENT,
user_name varchar(60) NOT NULL,
property_name longtext NOT NULL,
search_name longtext NOT NULL,
PRIMARY KEY (id)
) $charset_collate;";
dbDelta( $sql );
}
}
}
/**
 * Function to forcely delete any page by their slug 
 */
if(!function_exists('favoriteDelete')){
function favoriteDelete($slug){
$found_post = null;
if($posts = get_posts( array( 
'name' => $slug, 
'post_type' => 'page',
'post_status' => 'publish',
'posts_per_page' => 1
) ) )
$found_post = $posts[0];
if ( ! is_null( $found_post ) ){
wp_delete_post($found_post->ID,true);
}}}
/**
 * Function to Add any page by their $title,$slug and $template 
 */
if(!function_exists('favoriteAdd')){
function favoriteAdd($title,$slug,$template){
$post_data = array(
'post_title'=>$title,
'post_name' => $slug,
'post_type' => 'page',
'post_author'=> 1,
'post_status'   => 'publish',
);
$id =wp_insert_post( $post_data);
update_post_meta($id,'_wp_page_template',$template);
}}
/**
 * To create page to show Favorite Properties
 */
if(!function_exists('favorite_activation')){
function favorite_activation(){
/*
 * Add Favorite Properties page
 */
favoriteAdd(__('Favorite Properties','framework'),'favorite-properties','template-favorite-properties.php');
/*
 * Favorite search page
 */
favoriteAdd(__('Favorite Search','framework'),'favorite-search','template-favorite-search.php');
/*
 * Create table on activation
 */
create_favorite_table();
}
}
if(!function_exists('favorite_deactivation')){
function favorite_deactivation(){
/*
* To delete Favorite Properties page
*/   
favoriteDelete('favorite-properties');
/*
* To delete Favorite Search page
*/
favoriteDelete('favorite-search');
}}
register_activation_hook(__FILE__,'favorite_activation');
register_deactivation_hook(__FILE__,'favorite_deactivation');
if(!function_exists('favorite_load_js')):
function favorite_load_js(){
wp_register_script('favorite',FAVORITE__PLUGIN_URL . 'js/favorite.js', array(),FAVORITE_VERSION, true);
wp_enqueue_script( 'favorite');
wp_localize_script('favorite', 'tmpurl', array('plugin_path' => FAVORITE__PLUGIN_URL));
}
add_action('wp_enqueue_scripts', 'favorite_load_js');
endif;
?>