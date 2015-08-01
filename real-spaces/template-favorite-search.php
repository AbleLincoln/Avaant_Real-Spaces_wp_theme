<?php
/* Template Name:Saved Searches */
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
<h4><span class="heading-icon"><i class="fa fa-search"></i></span><?php _e('Saved Searches','framework'); ?></h4>
</div>
<?php global $wpdb;
$table_name = $wpdb->prefix . "favorite_property_search";
$current_id=  get_the_ID();
$sql_select="select search_name from $table_name WHERE `user_name` = '$current_user->ID'";
$q =$wpdb->get_results($sql_select,ARRAY_A)or print mysql_error();
if(!empty($q)):?>
<div class="properties-table">
<span id ="<?php echo $current_user->ID; ?>" class ="f_author_n"></span>
<table class="table table-striped">
<thead>
<tr>
<th><?php _e('S.No','framework'); ?></th>
<th><?php _e('Search Name','framework'); ?></th>
<th><?php _e('Actions','framework'); ?></th>
</tr>
</thead>
<tbody>
<?php 
foreach($q[0] as $data){
$array_update= unserialize($data);
if(!empty($array_update)){
$i=1;
foreach($array_update as $key=>$value){
?>
<tr>
<td>
<?php echo $i; ?>
</td>
<td><a href="<?php echo $key; ?>" target="_blank"><?php echo $value; ?></a></td>
<td>
<a id="<?php echo $key; ?>" class="remove-search action-button"><div class="search-strings" style="display:none;"><span class="search-title"><?php _e(' Removing ...','framework'); ?></span></div><i class="fa fa-times"></i><span><?php _e('Remove','framework'); ?><span></a>
<a href="<?php echo $key; ?>" target="_blank" class="action-button"><i class="fa fa-search"></i><span><?php _e('Search','framework'); ?><span></a></td>
</tr>
<?php $i++; }}
} ?>
</tbody>
</table>
</div>
<?php 
else:
    echo '<h3>'.__("You do not have any Saved Search",'framework').'</h3>';
endif; ?>
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