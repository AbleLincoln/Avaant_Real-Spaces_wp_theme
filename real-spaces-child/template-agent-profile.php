<?php
/* Template Name: Agent Profile */
get_header();
/* Site Showcase */
imic_page_banner($pageID = get_the_ID());
/* End Site Showcase */
if ( is_user_logged_in() ) {
global $userdata;
get_currentuserinfo();
if (!empty($_POST['action'])) {
    require_once(ABSPATH . 'wp-admin/includes/user.php');
    check_admin_referer('update-profile_' . $user_ID);
    $errors = edit_user($user_ID);
	$agentMobileNo = esc_sql(trim($_POST['mobile-phone']));
	$agentWorkNo = esc_sql(trim($_POST['work-phone']));
	$agentFBLink = esc_sql(trim($_POST['fb-link']));
	$agentTWTLink = esc_sql(trim($_POST['twt-link']));
	$agentGPLink = esc_sql(trim($_POST['gp-link']));
	$agentMSGLink = esc_sql(trim($_POST['msg-link']));
    $agentRole = esc_sql(trim($_POST['change_role_member']));
    $agentHacker = esc_sql(trim($_POST['hacker']));
    $agentHustler = esc_sql(trim($_POST['hustler']));
    $agentCreative = esc_sql(trim($_POST['creative']));
	$agentDataKeys = array('mobile-phone', 'work-phone', 'fb-link', 'twt-link', 'gp-link', 'msg-link','role', 'hacker', 'hustler', 'creative');
	$agentDataValues = array($agentMobileNo, $agentWorkNo, $agentFBLink, $agentTWTLink, $agentGPLink, $agentMSGLink,$agentRole, $agentHacker, $agentHustler, $agentCreative);
	foreach (array_combine($agentDataKeys, $agentDataValues) as $agentKey => $agentValue) {
		update_user_meta($user_ID, $agentKey, $agentValue);
               }
               $updateUserdata = array();
               $updateUserdata['ID'] = $user_ID;
              $updateUserdata['role'] = $_POST['change_role_member'];
   if(!empty($_POST['change_role_member'])&&($_POST['change_role_member']!=__('Change Your Role','framework'))&&! current_user_can( 'administrator' )){
      wp_update_user($updateUserdata);
   }
        //Image
	if(!empty($_FILES)) {
		$allowedExts = array("jpeg", "jpg");
		$temp = explode(".", $_FILES["agent-image"]["name"]);
		$extension = end($temp);
		if (( ($_FILES["agent-image"]["type"] == "image/jpeg")
		|| ($_FILES["agent-image"]["type"] == "image/jpg") ) && ($_FILES["agent-image"]["size"] < 256000) && in_array($extension, $allowedExts))
		{
			if ($_FILES["agent-image"]["error"] > 0)
			{
				$message = __("Return Code: ","framework") . $_FILES["agent-image"]["error"] . "<br>";
			}
			else
			{		
			$user_image = sight('agent-image',$user_ID);
			$user_image = wp_get_attachment_image_src($user_image,'full');
			update_user_meta($user_ID,'agent-image',$user_image[0]);
			
			}
		}
	}
	$errmsg = '';
    if (is_wp_error($errors)) {
        foreach ($errors->get_error_messages() as $message)
            $errmsg = "$message";
    }
    if ($errmsg == '') {
        //do_action('personal_options_update', $user_ID);
        $successMsg="<div id=\"message\"><div class=\"alert alert-success\">".__('Profile Successfully Updated','framework')."</div></div>";
      } else {
          $successMsg='';
      }
}
get_currentuserinfo();
?>
<!-- Start Content -->
<div class="main" role="main">
  <div id="content" class="content full">
        <div class="container">
            <div class="page">
                <div class="row">
                    <div class="col-md-12">
                         <?php if(!empty($successMsg)):
                          echo $successMsg;
                      endif; ?>
                      <div class="single-agent">	
                          <div class="counts pull-right">
                          		<strong><?php _e('Member Since','framework'); ?>
                                </strong>
                                <span><?php echo date("l, M d, Y", strtotime(get_userdata(get_current_user_id())->user_registered));?></span></div>
                          <h2 class="page-title">
						  <?php
						  if(!empty($userdata->first_name)) {
								echo $userdata->first_name;   
						  } else {
								echo $userdata->user_login;
						  }
						  ?>
                          </h2>	
                      </div>    
                      <form name="profile" action="" method="post" id="agent-profile-form" enctype="multipart/form-data"> <?php wp_nonce_field('update-profile_' . $user_ID) ?>
	                      <input type="hidden" name="from" value="profile" /> 
                          <input type="hidden" name="action" value="update" /> 
                          <input type="hidden" name="checkuser_id" value="<?php echo $user_ID ?>" /> 
                          <input type="hidden" name="dashboard_url" value="<?php echo get_option("dashboard_url"); ?>" /> 
                          <input type="hidden" name="user_id" id="user_id" value="<?php echo $user_ID; ?>" /> 
                      <div class="block-heading" id="details">
                           <h4><span class="heading-icon"><i class="fa fa-user"></i></span><?php _e('Profile Details','framework'); echo ' ( '. $userdata->user_login .' )';   ?></h4>
                      </div>
                          <?php 
                          global $current_user;
                         
                        $user_roles = $current_user->roles;
                        $user_role = array_shift($user_roles);
                        if($user_role=='subscriber'){
                              $become_member_as =__('Agent');
                              $change_role='agent';
                          }else{
                              $become_member_as =__('Buyer');
                              $change_role='subscriber';
                          } ?>
                          <div class ="change_user_info">
                              <select name ="change_role_member" class ="form-control input-lg selectpicker">
                                  <option><?php _e('Change Your Role','framework'); ?></option>
                                  <option value ="<?php echo $change_role; ?>"><?php echo __('Change to ','framework').$become_member_as; ?></option>
                              </select>
                              
                           
                      </div>
                      <div class="padding-as25 margin-30 lgray-bg">
                          <div class="row">
                              <div class="col-md-4 col-sm-4">
                                  <input type="text" name="first_name" id="first_name" value="<?php echo $userdata->first_name ?>" class="form-control first_name" placeholder="<?php _e('First Name','framework'); ?>">
                              </div>
                                  <div class="col-md-4 col-sm-4">
                                  <input type="text" name="last_name" id="last_name" value="<?php echo $userdata->last_name ?>"  class="form-control last_name" placeholder="<?php _e('Last Name','framework'); ?>">
                              </div>
                                  <div class="col-md-4 col-sm-4">
                                  <input type="email" id="email" value="<?php echo $userdata->user_email ?>" name="email" class="form-control email1" placeholder="<?php _e('Email','framework'); ?>">
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-md-4 col-sm-4">
                                  <label for="password"><?php _e('Change Password','framework'); ?></label>
                              </div>
                                  <div class="col-md-4 col-sm-4">
                                  <input type="password" value="" name="pass1" id="pass1" class="form-control pwd1" placeholder="<?php _e('New password','framework'); ?>">
                              </div>
                                  <div class="col-md-4 col-sm-4">
                                  <input type="password" value="" name="pass2" id="pass2" class="form-control pwd2" placeholder="<?php _e('Confirm password','framework'); ?>">
                              </div>
                          </div>
                      </div>
                      <div class="block-heading" id="additionalinfo">
                          <h4><span class="heading-icon"><i class="fa fa-plus"></i></span><?php _e('Personal Info','framework'); ?></h4>
                      </div>
                      <div class="padding-as25 margin-30 lgray-bg">
                          <div class="row">
                              <div class="col-md-4 col-sm-4 ">
                                    <label><?php _e('Biographical Info','framework'); ?></label>
                              </div>
                              <div class="col-md-8 col-sm-8 submit-description">
                                    <textarea name="description" id="description" class="form-control margin-0" rows="5" cols="10" placeholder="<?php _e('Description','framework'); ?>" ><?php echo $userdata->description; ?></textarea>
                              </div>
                          </div>	<hr>
                          <div class="row">
                              <div class="col-md-4 col-sm-4">
                                    <label><?php _e('Upload Image','framework'); ?></label>
                                    <p><?php _e('Upload image that are best clicked for better appearance of your profile','framework'); ?></p> 
                              </div>
                              <div class="col-md-8 col-sm-8 submit-image">
                                   <?php $userImgSrc='';
									$userImg = get_the_author_meta('agent-image', $user_ID);
                                                                        if(!empty($userImg)) {
										//$userLoadedImgSrc = wp_get_attachment_image_src($userImg, '600-400-size');
										//$userImgSrc = $userLoadedImgSrc[0];
									}
                                                                        echo '<div class="image-placeholder"><img src="'.$userImg.'" class="image-placeholder" id="agent-image" alt="IMAGE NOT FOUND"/></div>';
									?>
                                                                        <input type="file" name="agent-image" id="agent-image" onChange="readURL(this);">
                              </div>
                          </div>
                      </div>
                      <div class="block-heading" id="amenities">
                          <h4><span class="heading-icon"><i class="fa fa-phone"></i></span><?php _e('Contact Details','framework'); ?></h4>
                      </div>
                      <div class="padding-as25 margin-30 lgray-bg">
                      	  <div class="row">
                              <div class="col-md-6 col-sm-6">
                                  <input type="text" value="<?php echo esc_attr(get_the_author_meta('mobile-phone', $user_ID)); ?>" name="mobile-phone"  id="mobile-phone" class="form-control" placeholder="<?php _e('Mobile Phone','framework'); ?>">
                              </div>
                                  <div class="col-md-6 col-sm-6">
                                      <input type="text" value="<?php echo esc_attr(get_the_author_meta('work-phone', $user_ID)); ?>" name="work-phone" id="work-phone" class="form-control" placeholder="<?php _e('Work Phone','framework'); ?>">
                              </div>
                          </div>
                      </div>
                      <div class="block-heading" id="amenities">
                          <h4><span class="heading-icon"><i class="fa fa-group"></i></span><?php _e('Social Links','framework'); ?></h4>
                      </div>
                      <div class="padding-as25 margin-30 lgray-bg">    	
                          <div class="row">
                             <div class="col-md-3 col-sm-3">
                                    <input type="text" value="<?php echo esc_attr(get_the_author_meta('fb-link', $user_ID)); ?>" name="fb-link" id="fb-link" class="form-control" placeholder="<?php _e('Facebook','framework'); ?>"> 	
                              </div>
                              <div class="col-md-3 col-sm-3">
                                    <input type="text" value="<?php echo esc_attr(get_the_author_meta('twt-link', $user_ID)); ?>" name="twt-link" id="twt-link" class="form-control" placeholder="<?php _e('Twitter','framework'); ?>"> 	
                              </div>
                              <div class="col-md-3 col-sm-3">
                                    <input type="text" value="<?php echo esc_attr(get_the_author_meta('gp-link', $user_ID)); ?>" name="gp-link" id="gp-link" class="form-control" placeholder="<?php _e('Google Plus','framework'); ?>">	
                              </div>
                              <div class="col-md-3 col-sm-3">
                                    <input type="text" value="<?php echo esc_attr(get_the_author_meta('msg-link', $user_ID)); ?>" name="msg-link" id="msg-link" class="form-control" placeholder="<?php _e('Message','framework'); ?>"> 	
                              </div>
                          </div>
                      </div>
                        
                      <div class="row">
                        <h4>Your Talent</h4>
                        <div class="col-md-4">
                          <h5>Hacker</h5>
                          <input type="checkbox" name="hacker"
                                 <?php if (get_the_author_meta('hacker', $user_ID)=='hacker') { ?> 
                                    checked="checked"
                                 <?php }?> 
                                 value="hacker">
                        </div>
                        <div class="col-md-4">
                          <h5>Hustler</h5>
                          <input type="checkbox" name="hustler"
                                 <?php if (get_the_author_meta('hustler', $user_ID)=='hustler') { ?> 
                                    checked="checked"
                                 <?php }?> 
                                 value="hustler">
                        </div>
                        <div class="col-md-4">
                          <h5>Creative</h5>
                          <input type="checkbox" name="creative"
                                 <?php if (get_the_author_meta('creative', $user_ID)=='creative') { ?> 
                                    checked="checked"
                                 <?php }?> 
                                 value="creative">
                        </div>
                      </div>
                     <div class="text-align-center" id="submit-property">
                    <button type="submit" name="submit" class="btn btn-primary btn-lg cus_submit"><i class="fa fa-check"></i><?php _e(' Update','framework'); ?></button>
                    </div>
                      </form>	
                     
                </div>
            </div>
        </div>
    </div>
</div> 
<?php } else { echo imic_unidentified_agent(); }
get_footer(); ?>