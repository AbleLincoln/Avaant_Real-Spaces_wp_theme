<?php
$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
require_once( $parse_uri[0] . 'wp-config.php' );
if(!$_POST['f_author_n']){
_e('Please Login to add to favorite','framework');
 return false;
}
require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
$table_name = FAVORITE__TABLE_NAME;
$flag=0;
$user_name=$_POST['f_author_n'];
$user_info = get_userdata($user_name);
$sql_select="select user_name from $table_name WHERE `user_name` = '$user_name'";
$q =$wpdb->get_results($sql_select,ARRAY_A)or print mysql_error();
$current_id=$_POST['f_property_n'];
$property_name=get_the_title($current_id);
if(empty($q)){
$array_insert = array($current_id=>"yes");
$array_string_insert=mysql_escape_string(serialize($array_insert));
$wpdb->query("insert into $table_name (user_name,property_name) values('$user_name','$array_string_insert')");
$flag=1;
}else{
$sql_select="select property_name from $table_name WHERE `user_name` = '$user_name'";
$q =$wpdb->get_results($sql_select,ARRAY_A)or print mysql_error();
foreach($q[0] as $data)
{ 
$array_update= unserialize($data);
if(array_key_exists($current_id,$array_update)){
echo __('You Already Added','framework').' '.$property_name.' '.__('to favorite','framework');
}else{
$array_update[$current_id]='yes';
$array_string=serialize($array_update);
$sql_update ="UPDATE $table_name 
SET property_name = '$array_string'
WHERE `user_name` = '$user_name'"; 
$wpdb->query($sql_update);
$flag=1;
}
}}
if($flag==1){
$email = get_option('admin_email');
$address=$user_info->user_email;
$e_subject = __('Favorite Sheet','framework');
global $imic_options;
			if(!empty($imic_options['favorite_property_email'])){	
				$property_link = '<a href ="'.get_the_permalink($current_id).'">'.get_the_permalink($current_id).'</a>';
				$fav_shortcode = array('[title]','[url]');
				$fav_output = array($property_name,$property_link);
				$e_body = str_replace($fav_shortcode,$fav_output,$imic_options['favorite_property_email']);
			}else{
			$e_body=__("You added",'framework').' '.$property_name.__(' to your favorite.Click here to see property detail','framework').' <a href ="'.get_the_permalink($current_id).'">'.get_the_permalink($current_id).'</a>';
			}			
$msg = wordwrap( $e_body, 70 );
$headers = "From: $email" . PHP_EOL;
$headers .= "Reply-To: $email" . PHP_EOL;
$headers .= "MIME-Version: 1.0" . PHP_EOL;
$headers.="Content-Type: text/html; charset=\"iso-8859-1\"\n";
if(mail($address, $e_subject, $msg, $headers)) {
// Email has sent successfully, echo a success page.
echo __("You added ",'framework').$property_name.__(' to your favorite.','framework');
} else {
_e('ERROR!','framework');
}
}