<?php
/* Template Name: Payment */
get_header();
global $current_user, $imic_options;
get_currentuserinfo();
 $current_user_id =$current_user->ID;
 /* Site Showcase */
imic_page_banner($pageID = get_the_ID());
$flag_show = 0;
$st = '';
$transaction_id=isset($_REQUEST['tx'])?$_REQUEST['tx']:'';
if($transaction_id!='') {
global $wpdb;
$table_name = $wpdb->prefix . "imic_payment_transaction";
$payment_array=imic_validate_payment($transaction_id);
$st = $payment_array['payment_status'];
$user_id=isset($_REQUEST['item_number'])?$_REQUEST['item_number']:'';
if(!empty($transaction_id)&&!empty($st)){
$sql_select="select transaction_id from $table_name WHERE `transaction_id` = '$transaction_id'";
$data =$wpdb->get_results($sql_select,ARRAY_A)or print mysql_error();
if(empty($data)){
$amt=isset($_REQUEST['amt'])?$_REQUEST['amt']:'';
$total_property_value = get_user_meta($current_user_id,'property_value',true);
if($st=='Completed') {
updateUserPlanValueAfterPayment($current_user_id,$user_id);
}
$sql = "UPDATE $table_name SET transaction_id='$transaction_id',status='$st' WHERE property_plan='$user_id'";
require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
dbDelta($sql);
}else{}
}
}
/* End Site Showcase */
?>
<!-- Start Content -->
<div class="main" role="main"><div id="content" class="content full"><div class="container">
<?php if($st=='Completed') { ?>
                <div class="col-md-12 appear-animation bounceInRight appear-animation-visible" data-appear-animation="bounce-in-up">
                    <div class="alert alert-info fade in">
                        <?php echo $imic_options['paypal_thanks']; ?>
                        </div>
                </div>
                <?php } ?>
<div class="page"><div class="row">
<?php 
$payment =get_query_var('payment');
$payment = str_replace('-' , ' ', $payment);
if(empty($payment)&&isset($_GET['item_number'])){
$payment=$_GET['item_number'];
}
if(current_user_can( 'administrator' )||current_user_can( 'agent' )){
if(!empty($payment)||!empty($transaction_id)){
 global $imic_options; 
if(isset($imic_options['plan_group'])){
$plan_group= $imic_options['plan_group']; 
}else{
$plan_group='';
} 
$plan_price=$plan_description='';
if(!empty($plan_group)){
$payment_option =$payment;
foreach($plan_group as $new_plan_group){
if(in_array($payment, $new_plan_group)){
$plan_price =$new_plan_group['property_price'];
$plan_description =$new_plan_group['property_description'];
$number_of_property =$new_plan_group['number_of_property'];
$property_price =$new_plan_group['property_price'];
$flag_show=1;
}
}
}
if($flag_show==1){
echo '<div class="col-md-4 col-sm-4">';
/* Page Content
======================*/
echo '<div class="alert alert-default fade in">';
if(!empty($payment)){
echo '<h4>'.__('Plan Name: ','framework').$payment.'</h4>';
}
if(!empty($number_of_property)){
echo '<h4>'.__('Number of property: ','framework').$number_of_property.'</h4>';
}
if(!empty($property_price)){
echo '<h4>'.__('Plan Price: ','framework').$property_price.'</h4>';
}
if(!empty($plan_description)){
echo apply_filters('the_content',$plan_description);
}
echo'</div>';
echo '</div>';
}
$subclass =($flag_show==1)?8:12;
?>
<div class="col-md-<?php echo $subclass; ?> col-sm-<?php echo $subclass; ?> login-form">
<?php echo do_shortcode('[imic_property property_id="'.get_the_ID().'" property_price ="'.$plan_price.'" plan_name="'.$payment.'" description="'.$payment_option.'"]'); ?>
</div>
<?php }
else{
echo '<div class="text-align-center"><h2>'.__('You are not authorize to access this Page','framework').'</h2></div>';   
}}
else{
echo '<div class="text-align-center"><h2>'.__('You are not agent for this site','framework').'</h2></div>';   
}
?>
</div></div></div></div></div>
<?php get_footer(); ?>