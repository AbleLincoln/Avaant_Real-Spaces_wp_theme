<?php
/* Template Name:Favorite Properties */
get_header();
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
if ( is_plugin_active( 'favorite_property/favorite_property.php' ) ) {
if ( is_user_logged_in() ) {
/* Site Showcase */
imic_page_banner($pageID = get_the_ID());
/* End Site Showcase */
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
global $imic_options, $current_user;
$currency_symbol = imic_get_currency_symbol($imic_options['currency-select']);
get_currentuserinfo(); 
$edit_url = imic_get_template_url('template-submit-property.php');
$sidebar = get_post_meta(get_the_ID(),'imic_select_sidebar_from_list',false); 
$class = (empty($sidebar)||!is_active_sidebar($sidebar[0]))?12:9;
?>
<!-- Start Content -->
<div class="main" role="main">
<div id="content" class="content full">
<div class="container">
<div class="page">
<div class="row">
<div class="col-md-<?php echo $class; ?>">
<div class="block-heading" id="details">
<h4><span class="heading-icon"><i class="fa fa-heart"></i></span><?php _e('Favorite Properties','framework'); ?></h4>
</div>
<?php 
global $wpdb;
$table_name = $wpdb->prefix . "favorite_property_search";
if(get_query_var('remove')){
$delete_id = get_query_var('remove');
$post_author = get_post_field('post_author',$delete_id);
$user_name= $current_user->ID;
$sql_select="select property_name from $table_name WHERE `user_name` = '$user_name'";
$q =$wpdb->get_results($sql_select,ARRAY_A)or print mysql_error();
if(!empty($q)){
foreach($q[0] as $data)
{ 
$array_update= unserialize($data);
unset($array_update[$delete_id]);
$array_string=serialize($array_update);
$sql_update ="UPDATE $table_name 
SET property_name = '$array_string'
WHERE `user_name` = '$user_name'"; 
$wpdb->query($sql_update);
}}}
$sql_select="select property_name from $table_name WHERE `user_name` = '$current_user->ID'";
$q =$wpdb->get_results($sql_select,ARRAY_A)or print mysql_error();
$array_id =array();
if(!empty($q)){
foreach($q[0] as $data)
{ 
$array_update= unserialize($data);
if(!empty($array_update)){
foreach($array_update as $key=>$value){
array_push($array_id,$key);
}
}}}
query_posts(array('post_type'=>'property','post__in' => $array_id,'paged'=>$paged));
if(have_posts()&&!empty($array_id)):?>
<div class="properties-table">
<table class="table table-striped">
<thead>
<tr>
<th><?php _e('Image','framework'); ?></th>
<th><?php _e('Name','framework'); ?></th>
<th><?php _e('Type','framework'); ?></th>
<th><?php _e('Contract','framework'); ?></th>
<th><?php _e('Price','framework'); ?></th>
<th><?php _e('Actions','framework'); ?></th>
</tr>
</thead>
<tbody>
<?php 
while(have_posts()):the_post(); 
$current_id=  get_the_ID();
$property_area = get_post_meta(get_the_ID(),'imic_property_area',true); 
$property_baths = get_post_meta(get_the_ID(),'imic_property_baths',true);
$property_beds = get_post_meta(get_the_ID(),'imic_property_beds',true);
$property_parking = get_post_meta(get_the_ID(),'imic_property_parking',true); 
$property_address = get_post_meta(get_the_ID(),'imic_property_site_address',true);
$property_city = get_post_meta(get_the_ID(),'imic_property_site_city',true);
$property_price = get_post_meta(get_the_ID(),'imic_property_price',true); 
$type = wp_get_object_terms( get_the_ID(), 'property-type', array('fields'=>'ids')); 
if(!empty($type)) {
$term = get_term( $type[0], 'property-type' ); } 
$contract = wp_get_object_terms( get_the_ID(), 'property-contract-type', array('fields'=>'ids')); 
if(!empty($contract)) {
$terms = get_term( $contract[0], 'property-contract-type' ); }?>
<tr>
<td>
<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('100-67-size'); ?></a>
</td>
<td><a href="<?php the_permalink(); ?>"><?php echo $property_address; ?></a></td>
<td><?php if(!empty($term)) { echo $term->name; } ?></td>
<td><?php if(!empty($terms)) { echo $terms->name; } ?></td>
<td>
<?php if(!empty($property_price)):
echo '<div class="price"><strong>'.$currency_symbol.'</strong><span>'.$property_price.'</span></div>'; 
endif; ?>
</td>
<td>
<a href="<?php the_permalink(); ?>" class="action-button"><i class="fa fa-eye"></i> <span><?php _e('View','framework'); ?></span></a>
<a href="<?php echo esc_url(add_query_arg( 'remove', get_the_ID() )); ?>" class="action-button"><i class="fa fa-ban"></i> <span><?php _e('Remove','framework'); ?></span></a>
</td>
</tr>
<?php endwhile; ?>
</tbody>
</table>
</div>
<?php 
echo'<div class="text-align-center">';
pagination(); wp_reset_query();
echo'</div>';
else:
echo '<h3>'.__("You do not have any Property in favorite",'framework').'</h3>';
endif;
 ?>
</div>
<!-- Start Sidebar -->
<?php if(!empty($sidebar)&&is_active_sidebar($sidebar[0])) { 
echo '<div class="sidebar right-sidebar col-md-3">';
dynamic_sidebar($sidebar[0]);
echo '</div>';
} ?>
</div>
</div>
</div>
</div>
</div>
<?php } else{
echo imic_unidentified_agent();
} } get_footer(); ?>