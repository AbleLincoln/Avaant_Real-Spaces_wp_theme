<?php
/* Template Name: Contact */
get_header();
/* Site Showcase */
imic_page_banner($pageID = get_the_ID());
/* End Site Showcase */
?>
  <!-- Start Content -->
  <div class="main" role="main">
    <div id="content" class="content full">
        <?php $property_zoom_value=get_post_meta(get_the_ID(),'imic_contact_zoom_option',true);
                $property_zoom_value=!empty($property_zoom_value)?$property_zoom_value:4;
                echo '<span class ="property_zoom_level" id ="'.$property_zoom_value.'"></span>'; ?>
      <div class="container">
        <div class="page">
          <div class="row">
            <div class="col-md-6 col-sm-6">
              <h3><?php _e('Quick Contact Form', 'framework'); ?></h3>
              <div class="row">
              	<?php
				/* Contact Form Details
				=================================*/
				$contactFormEmailAdd = get_post_meta(get_the_ID(), 'imic_contact_email_us', true);
				$contactFormSubjectText = get_post_meta(get_the_ID(), 'imic_contact_subject', true);
				$contactFormEmail = (!empty($contactFormEmailAdd))? $contactFormEmailAdd : get_option('admin_email');
				$contactFormSubject = (!empty($contactFormSubjectText))? $contactFormSubjectText : __('Contact Form','framework');
				?>
                <form method="post" id="contactform" name="contactform" class="contact-form" action="<?php echo get_template_directory_uri() ?>/mail/contact.php">
                  <div class="col-md-6 margin-15">
                    <div class="form-group">
                      <input type="text" id="name" name="name"  class="form-control input-lg" placeholder="<?php _e('Name*','framework'); ?>">
                    </div>
                    <div class="form-group">
                      <input type="email" id="email" name="email"  class="form-control input-lg" placeholder="<?php _e('Email*','framework'); ?>">
                    </div>
                    <div class="form-group">
                      <input type="text" id="phone" name="phone" class="form-control input-lg" placeholder="<?php _e('Phone','framework'); ?>">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <textarea cols="6" rows="5" id="comments" name="comments" class="form-control input-lg" placeholder="<?php _e('Message','framework'); ?>"></textarea>
                      <input type="hidden" name="image_path" id="image_path" value="<?php echo IMIC_THEME_PATH; ?>/">
                      <input id="admin_email" name="admin_email" type="hidden" value="<?php echo $contactFormEmail; ?>">
                      <input id="subject" name="subject" type="hidden" value="<?php echo $contactFormSubject; ?>">
                      <input id="submit" name="submit" type="submit" class="btn btn-primary btn-lg btn-block" value="<?php _e('Submit now!','framework'); ?>">
                    </div>
                  </div>
                </form>
              </div>
              <div class="clearfix"></div>
              <div id="message"></div>
            </div>
            <div class="col-md-6 col-sm-6">
            	<h3><?php _e('Our Location', 'framework'); ?></h3>
              <div class="padding-as25 lgray-bg">
              		<?php
					/* Contact Page Details
		 			=================================*/
					$address = '';
					$address_for_map = get_post_meta(get_the_ID(), 'imic_our_location_address', true);
					if(have_posts()):while(have_posts()):the_post();
					the_content();
					endwhile; endif;
                                        
                                         $property_longitude_and_latitude=get_post_meta(get_the_ID(),'imic_contact_lat_long',true);
                                                                 if(!empty($property_longitude_and_latitude)){
                                                                      $property_longitude_and_latitude = explode(',', $property_longitude_and_latitude); 
                                                                  }else{
                                        $property_longitude_and_latitude=getLongitudeLatitudeByAddress($address_for_map);
                                                                 }
                                         echo '<div id="contact'.get_the_ID().'" class ="property_container" style="display:none;"><span class ="property_address">'.$address_for_map.'</span><span class ="latitude">'.$property_longitude_and_latitude[0].'</span><span class ="longitude">'.$property_longitude_and_latitude[1].'</span><span class ="property_image_url">'.IMIC_THEME_PATH.'/images/map-marker.png</span></div>';
                    ?>
              </div>
					<?php if ($imic_options['switch_sharing'] == 1 && $imic_options['share_post_types']['2'] == '1') {
						imic_share_buttons();
					} ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php get_footer(); ?>