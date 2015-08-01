<?php
$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
require_once( $parse_uri[0] . 'wp-config.php' );
$table_name = FAVORITE__TABLE_NAME;
if(isset($_POST['f_author_n_remove'])){
$delete_id = $_POST['f_search_url'];
$user_name= $_POST['f_author_n_remove'];
$sql_select="select search_name from $table_name WHERE `user_name` = '$user_name'";
$q =$wpdb->get_results($sql_select,ARRAY_A)or print mysql_error();
if(!empty($q)){
foreach($q[0] as $data)
{ 
$array_update= unserialize($data);
unset($array_update[$delete_id]);
$array_string=serialize($array_update);
$sql_update ="UPDATE $table_name 
SET search_name = '$array_string'
WHERE `user_name` = '$user_name'"; 
$wpdb->query($sql_update);
}}
return false;
}
if(!$_POST['f_author_n']){
_e('Please Login to add to search','framework');
return false;
}
require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
$flag=0;
$user_name=$_POST['f_author_n'];
$f_search_title=$_POST['f_search_title'];
$user_info = get_userdata($user_name);
$sql_select="select user_name from $table_name WHERE `user_name` = '$user_name'";
$q=$wpdb->get_results($sql_select,ARRAY_A)or print mysql_error();
$search_url=$_POST['f_search_url'];
if(empty($q[0])){
$array_insert = array($search_url=>$f_search_title);
$array_string_insert=serialize($array_insert);
$wpdb->query("insert into $table_name (user_name,search_name) values('$user_name','$array_string_insert')");
$flag=1;
}else{
$sql_select="select search_name from $table_name WHERE `user_name` = '$user_name'";
$q_search_name=$wpdb->get_results($sql_select,ARRAY_A)or print mysql_error();
foreach($q_search_name[0] as $data)
{ 
$array_update= unserialize($data);
if(array_key_exists($search_url,$array_update)){
echo __('You have Already Added this search, try with another keywords.','framework');
}else{
$array_update[$search_url]=$f_search_title;
$array_string=serialize($array_update);
$sql_update ="UPDATE $table_name 
SET search_name = '$array_string'
WHERE `user_name` = '$user_name'"; 
$wpdb->query($sql_update);
echo __("You added ",'framework').$f_search_title.__(' to your search.','framework');
}
}}