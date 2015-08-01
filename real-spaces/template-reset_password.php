<?php
/* Template Name: Reset Password */
get_header();
?>
<div class="main" role="main"><div id="content" class="content full"><div class="container">
<?php 
$p_flag=0;
if(isset($_GET['action'])&&$_GET['action']=='resetpass'){
if(isset($_POST['pass1'])){
$pwd1=$_POST['pass1'];
$pwd2=$_POST['pass2'];
if(trim($pwd1) == '') {
echo '<div class="alert alert-error">'.__('You must enter password.','framework').'</div>';
$p_flag=1;
}else if(trim($pwd2) == '') {
echo '<div class="alert alert-error">'.__('You must enter repeat password.','framework').'</div>';
$p_flag=1;
}else if(trim($pwd1) != trim($pwd2)) {
echo '<div class="alert alert-error">'.__('You must enter a same password.','framework').'</div>';
$p_flag=1;	
}
if($p_flag!=1&&isset($_POST['user_login'])){
$user_login=$_POST['user_login'];
$password=$_POST['pass1'];
global $wpdb;
$wpdb->update($wpdb->users, array('user_pass' => md5($password)), array('user_login' => $user_login));
echo '<div class="alert">';
_e('Your password succefully updated','framework');
echo ' <a href ="'.imic_get_template_url('template-register.php').'" class ="class="submit_button btn btn-primary button2">'.__('Login Here','framework').'</a>';
echo '</div>';
}}}
if(isset($_GET['login'])||($p_flag==1)){
?>
<form name="resetpassform" id="register-form" action="<?php echo imic_get_template_url('template-reset_password.php');?>?action=resetpass" method="post" autocomplete="off">
<input type="hidden" id="user_login" name ="user_login" value="<?php echo $_GET['login']; ?>" autocomplete="off">
<div class="input-group">
<span class="input-group-addon"><i class="fa fa-lock"></i></span>
<input type="password" name="pass1" id="pwd1" class="form-control" value ="<?php echo (isset($_POST['pass1'])?$_POST['pass1']:''); ?>" placeholder="<?php _e('Password','framework'); ?>">
</div>
<br>
<div class="input-group">
<span class="input-group-addon"><i class="fa fa-refresh"></i></span>
<input type="password" name="pass2" id="pwd2" value ="<?php echo (isset($_POST['pass2'])?$_POST['pass2']:''); ?>" class="form-control" placeholder="<?php _e('Repeat Password','framework') ?>">
</div>
<br/>
<input type="submit" name="wp-submit" id="wp-submit" class="submit_button btn btn-primary button2" value="Reset Password">
</form>
<?php
}
elseif(isset($_GET['action'])&&$_GET['action']=='resetpass'){
}
else {
?>
<form method="post" class ="register-form" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
<div class="input-group">
<input type="text" name="user_login" id="username" class="form-control" placeholder="<?php _e('Username or Email','framework'); ?>">
</div>
<br>
<?php do_action('login_form', 'resetpass'); ?>
<input type="submit" name="user-submit" value="<?php _e('Reset password','framework'); ?>" class="submit_button btn btn-primary button2"/>
<?php
if (isset($_POST['reset_pass']))
{
global $wpdb;
$username = trim($_POST['user_login']);
$user_exists = false;
// First check by username
if ( username_exists( $username ) ){
$user_exists = true;
$user = get_user_by('login', $username);
}
// Then, by e-mail address
elseif( email_exists($username) ){
$user_exists = true;
$user = get_user_by('email',$username);
}else{
$msg ='<p>'.__('Username or Email was not found, try again!','framework').'</p>';
echo '<div class="alert">'.$msg.'</div>';
}
if ($user_exists){
$user_login = $user->user_login;
$user_email = $user->user_email;
$key = $wpdb->get_var($wpdb->prepare("SELECT user_activation_key FROM $wpdb->users WHERE user_login = %s", $user_login));
if ( empty($key) ) {
// Generate something random for a key...
$key = wp_generate_password(20, false);
do_action('retrieve_password_key', $user_login, $key);
// Now insert the new md5 key into the db
$wpdb->update($wpdb->users, array('user_activation_key' => $key), array('user_login' => $user_login));
}
//create email message
$message = __('Someone has asked to reset the password for the following site and username.') . "\r\n\r\n";
$message .= get_option('siteurl') . "\r\n\r\n";
$message .= sprintf(__('Username: %s'), $user_login) . "\r\n\r\n";
$message .= __('To reset your password visit the following address, otherwise just ignore this email and nothing will happen.') . "\r\n\r\n";
$message .= network_site_url("reset-password?action=rp&key=$key&login=" . rawurlencode($user_login), 'login')."\r\n";
//send email meassage
if (wp_mail($user_email, sprintf(__('[%s] Password Reset'), get_option('blogname')), $message))
{
$mesg = '<p>'.__('A message will be sent to your email address.','framework').'</p>'; 
}else{
$mesg= '<p>' . __('The e-mail could not be sent.') . "<br />\n" . __('Possible reason: your host may have disabled the mail() function...') . '</p>';
}
if(isset($mesg)){
echo '<div class="alert">'.$mesg.'</div>';
}
}}
?> 
<input type="hidden" name="reset_pass" value="1" />
<input type="hidden" name="user-cookie" value="1" />
</form>
<?php } ?>
</div></div></div>
<?php get_footer(); ?>
 