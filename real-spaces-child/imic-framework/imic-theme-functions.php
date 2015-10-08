<?php

//Hide project banner
function imic_singe_property_banner($pageID) {
    $bannerHTML = '';
     /* Title/Banner Meta Box Details
======================================*/
$property_images = get_post_meta($pageID,'imic_property_sights',false);
   $property_banner_type = get_post_meta($pageID,'imic_property_banner_type',true);
if(!empty($property_banner_type)){
    switch ($property_banner_type) {
        case 'featured_image':
            if(has_post_thumbnail($pageID)){
             $src =wp_get_attachment_image_src(get_post_thumbnail_id($pageID),'600-400-size');
            }
if(!empty($src)){
$bannerHTML .= '<!-- Site Showcase -->
<div class="site-showcase avaant-hidden">
<!-- Start Page Header -->
<div class="parallax page-header" style="background-image:url('. $src[0] .');">
<div class="container">
<div class="row">
<div class="col-md-12">
<h1>'.get_the_title($pageID).'</h1>
</div>
</div>
</div>
</div>
<!-- End Page Header -->
</div>';
}
        break;
        case 'map':
            $bannerHTML .= '<!-- Site Showcase -->
<div class="site-showcase avaant-hidden"> 
<!-- Start Page Header -->
<div class="clearfix map-single-page" id="onemap"></div>                                                       
<!-- End Page Header --> 
</div>';
             break;
        default:
          global $imic_options;
             if(isset($imic_options['banner_image'])&&!empty($imic_options['banner_image'])){
                 $banner_imagesrc =$imic_options['banner_image']['url'];
            $bannerHTML .= '<!-- Site Showcase -->
<div class="site-showcase avaant-hidden">
<!-- Start Page Header -->
<div class="parallax page-header" style="background-image:url('. $banner_imagesrc .');">
<div class="container">
<div class="row">
<div class="col-md-12">
<h1>'.get_the_title($pageID).'</h1>
</div>
</div>
</div>
</div>
<!-- End Page Header -->
</div>';
                 }
            break;
            }
}else{
$property_banner_src='';
foreach ($property_images as $property_images){
$largeImage = wp_get_attachment_image_src($property_images,'full');
if(($largeImage[1]>=1200)&&($largeImage[2]>=500)){
$property_banner_src =$largeImage[0];
break;
}}
if(!empty($property_banner_src)){
$bannerHTML .= '<!-- Site Showcase -->
<div class="site-showcase avaant-hidden">
<!-- Start Page Header -->
<div class="parallax page-header" style="background-image:url('. $property_banner_src .');">
<div class="container">
<div class="row">
<div class="col-md-12">
<h1>'.get_the_title($pageID).'</h1>
</div>
</div>
</div>
</div>
<!-- End Page Header -->
</div>';
}else{
$bannerHTML .= '<!-- Site Showcase -->
<div class="site-showcase avaant-hidden"> 
<!-- Start Page Header -->
<div class="clearfix map-single-page" id="onemap"></div>                                                       
<!-- End Page Header --> 
</div>';
}    
}
echo $bannerHTML;
}

function imic_agent_fields( $user ) {
  $value = get_the_author_meta( 'popular', $user->ID);
  $userFB = get_the_author_meta('fb-link', $user->ID);
  $userTWT = get_the_author_meta('twt-link', $user->ID);
  $userGP = get_the_author_meta('gp-link', $user->ID);
  $userMSG = get_the_author_meta('msg-link', $user->ID);
  $userLINKEDIN = get_the_author_meta('linkedin-link', $user->ID);
   //Agent Contact Details
  $userMobileNo = get_the_author_meta('mobile-phone', $user->ID);
  $userWorkNo = get_the_author_meta('work-phone', $user->ID);
  $userPropertyValue = get_the_author_meta('property_value', $user->ID);
  
  $avnt_hacker = get_the_author_meta( 'hacker', $user->ID);
?>

  <h3><?php _e('User Talent', 'framework'); ?></h3>
  <table class="form-table">
    <tr>
      <th><label for="hacker">Hacker</label></th>
      <td><input type="checkbox" name="talent"
                <?php if ($avnt_hacker=='hacker' ) { ?> 
                  checked="checked"
                <?php }?> 
                value="hacker">
                <?php _e('Hacker?','framework'); ?>
      </td>
    </tr>
  </table>

  <h3><?php _e('Agent Social fart','framework'); ?></h3>
  <table class="form-table">
    <tr>
      <th>
        <label for="Agent Facebook Url">
          <?php _e('Agent Facebook Url','framework'); ?>
        </label>
      </th>
      <td>
        <label>
          <input type="text" name="fb-link" value="<?php echo $userFB; ?>" </label>
      </td>
    </tr>
    <tr>
      <th>
        <label for="Agent Twitter Url">
          <?php _e('Agent Twitter Url','framework'); ?>
        </label>
      </th>
      <td>
        <label>
          <input type="text" name="twt-link" value="<?php echo $userTWT; ?>" </label>
      </td>
    </tr>
    <tr>
      <th>
        <label for="Agent Google Plus Url">
          <?php _e('Agent Google Plus Url','framework'); ?>
        </label>
      </th>
      <td>
        <label>
          <input type="text" name="gp-link" value="<?php echo $userGP; ?>" </label>
      </td>
    </tr>
    <tr>
      <th>
        <label for="Agent Msg Link Url">
          <?php _e('Agent Msg Link Url','framework'); ?>
        </label>
      </th>
      <td>
        <label>
          <input type="text" name="msg-link" value="<?php echo $userMSG; ?>" </label>
      </td>
    </tr>
    <tr>
      <th>
        <label for="Agent linkedin Link Url">
          <?php _e('Linkedin Url','framework'); ?>
        </label>
      </th>
      <td>
        <label>
          <input type="text" name="linkedin-link" value="<?php echo $userLINKEDIN; ?>" </label>
      </td>
    </tr>
  </table>
  <h3><?php _e('Agent Contact Details','framework'); ?></h3>
  <table class="form-table">
    <tr>
      <th>
        <label for="Agent Mobile Number">
          <?php _e('Agent Mobile Number','framework'); ?>
        </label>
      </th>
      <td>
        <label>
          <input type="text" name="mobile-phone" value="<?php echo $userMobileNo; ?>" </label>
      </td>
    </tr>
    <tr>
      <th>
        <label for="Agent Work Phone">
          <?php _e('Agent Work Phone','framework'); ?>
        </label>
      </th>
      <td>
        <label>
          <input type="text" name="work-phone" value="<?php echo $userWorkNo; ?>" </label>
      </td>
    </tr>
  </table>
  <h3><?php _e('Agent Plan Details','framework'); ?></h3>
  <table class="form-table">
    <tr>
      <th>
        <label for="property_number">
          <?php _e('Number of Property','framework'); ?>
        </label>
      </th>
      <td>
        <label>
          <input type="text" name="agent_number_of_plan" readonly value="<?php echo $userPropertyValue; ?>" </label>
      </td>
    </tr>
  </table>
  <h3><?php _e('Agent Image','framework'); ?></h3>
  <table class="form-table">
    <tr>
      <th>
        <label for="Agent Image">
          <?php _e('Agent Image','framework'); ?>
        </label>
      </th>
      <td>
        <?php
$agent_image = get_the_author_meta('agent-image', $user->ID);
 if (!empty($agent_image)) {
          $agent_image=  $agent_image;
       } else {
           $agent_image = '';
       }
                       echo '<div><img id ="upload_image_preview" src ="' . $agent_image . '" width ="150px" height ="150px"/></div>';
                       echo '<input id="upload_agent_button" type="button" class="button button-primary" value="'.__('Upload Image', 'framework').'" /> ';
                       if (!empty($agent_image)) {
                       echo '<input id="upload_agent_button_remove" type="button" class="button button-primary" value="'.__('Remove Image', 'framework').'" />';
                      }
                       ?>
          <p class="description">
            <?php _e('Upload an image for the agent .', 'framework'); ?>
          </p>
          <input type="hidden" id="agent_url" name="agent-image" value="<?php echo esc_url($agent_image); ?>" />
      </td>
    </tr>
  </table>
  <h3><?php _e('Agent banner Image','framework'); ?></h3>
  <table class="form-table">
    <tr>
      <th>
        <label for="Agent Banner">
          <?php _e('Agent banner image','framework'); ?>
        </label>
      </th>
      <td>
        <?php
$agent_banner = get_the_author_meta('agent-banner', $user->ID);
 if (!empty($agent_banner)) {
          $agent_banner=  $agent_banner;
       } else {
           $agent_banner = '';
       }
                       echo '<div><img id ="upload_banner_preview" src ="' . $agent_banner . '" width ="150px" height ="150px"/></div>';
                       echo '<input id="upload_agent_banner" type="button" class="button button-primary" value="'.__('Upload Banner', 'framework').'" /> ';
                       if (!empty($agent_banner)) {
						
                       echo '<input id="upload_agent_banner_remove" type="button" class="button button-primary" value="'.__('Remove Banner', 'framework').'" />';
                      }
                       ?>
          <p class="description">
            <?php _e('Upload an image for the agent page banner.', 'framework'); ?>
          </p>
          <input type="hidden" id="agent_banner" name="agent-banner" value="<?php echo esc_url($agent_banner); ?>" />
      </td>
    </tr>
  </table>
  <h3><?php _e('Popular Agent','framework'); ?></h3>
  <table class="form-table">
    <tr>
      <th>
        <label for="Popular Agent">
          <?php _e('Popular Agent','framework'); ?>
        </label>
      </th>
      <td><span class="description"><?php _e('Check this box to create agent popular.','framework'); ?></span>
        <br>
        <label>
          <input type="checkbox" name="popular"
                <?php if ($value=='Popular' ) { ?> 
                  checked="checked"
                <?php }?> 
                value="Popular">
            <?php _e('Popular Agent','framework'); ?>
              <br />
        </label>
      </td>
    </tr>
  </table>
  <?php 
}
?>
