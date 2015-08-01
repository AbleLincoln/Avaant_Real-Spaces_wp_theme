<?php
$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
require_once( $parse_uri[0] . 'wp-config.php' );
require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
$table_name = FAVORITE__TABLE_NAME;
$favorite_post_id=$_POST['favorite_post_id'];
$checked=$_POST['checked'];
$checked =($checked=='checked')?'yes':'no';
$user_info=wp_get_current_user();
$user_name=$user_info->ID;
$sql_select="select property_name from $table_name WHERE `user_name` = '$user_name'";
$q =$wpdb->get_results($sql_select,ARRAY_A)or print mysql_error();
if(!empty($q)){
foreach($q[0] as $data)
{ 
$array_update= unserialize($data);
$array_update[$favorite_post_id]=$checked;
$array_string=serialize($array_update);
$sql_update ="UPDATE $table_name 
SET property_name = '$array_string'
WHERE `user_name` = '$user_name'"; 
$wpdb->query($sql_update);
if($checked=='yes'){
$msg =__('Favorite Action Added','framework');
}else{
  $msg =__('Favorite Action Removed','framework');  
}
echo $msg;
}}
