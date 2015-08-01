<?php 
/* Author Detail Page
=============================*/
get_header();
global $imic_options; //Theme Global Variable
$currency_symbol = imic_get_currency_symbol($imic_options['currency-select']); 
//Banner Image
$contactBanner = '';
if(!empty($imic_options['banner_image']['url'])){
$contactBanner = $imic_options['banner_image']['url'];	
}
/* Agent Details Variable 
==============================*/
$user = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author)); 
/* Display Agent Name
==========================*/
$userFirstName = get_the_author_meta('first_name', $user->ID);
$userLastName = get_the_author_meta('last_name', $user->ID);
$user_banner = get_the_author_meta('agent-banner', $user->ID);
$contactBanner = ($user_banner!='')?$user_banner:$contactBanner;
$userName = $user->display_name;
if(!empty($userFirstName) || !empty($userLastName)) {
	$userName = $userFirstName .' '. $userLastName; 
}
?> 	
   <!-- Site Showcase -->
  <div class="site-showcase">
    <!-- Start Page Header -->
    <div class="parallax page-header" style="background-image:url(<?php echo $contactBanner; ?>);">
          <div class="container">
              <div class="row">
                  <div class="col-md-12">
                      <h1><?php echo $userName; ?></h1>
                  </div>
             </div>
         </div>
    </div>
    <!-- End Page Header -->
  </div>	
  <!-- Start Content -->
  <div class="main" role="main">
      <div id="content" class="content full">
          <div class="container">
              <div class="row">
              <?php if(is_active_sidebar('inner-sidebar')) { $row_class = 9; } else { $row_class = 12; } ?>
                  <div class="col-md-<?php echo $row_class; ?>">
                      <div class="single-agent">
                          <div class="counts pull-right">
                          	<strong>
								<?php 
                                /* Display Agent's Total Properties
                                ========================================*/
                                echo imic_count_user_posts_by_type($user->ID,'property');
                                ?>
                          	</strong>
                            <span><?php _e('Properties','framework'); ?></span></div>
                          <?php
						  echo '<h2 class="page-title">'. $userName .'</h2>'; 
						  ?>
                          <div class="row">
                          	  <?php 
 							  /* Agent's Image
							  =======================*/
							  $userImageID = get_the_author_meta('agent-image', $user->ID);
							  $userDescClass = 12;
							  if (!empty($userImageID)) {
								echo '<div class="col-md-6 col-sm-6">
											<img src="'. $userImageID.'" alt="'. $userName .'" class="img-thumbnail">
									  </div>';
								$userDescClass = 6;
							  }
							  else {
								  $default_image_agent = $imic_options['default_agent_image'];
								 echo '<div class="col-md-6 col-sm-6">
											<img src="'. $default_image_agent['url'].'" alt="'. $userName .'" class="img-thumbnail">
									  </div>';
								$userDescClass = 6; 
							  }
							  ?>	
                              <div class="<?php echo 'col-md-' . $userDescClass . ' col-sm-' . $userDescClass; ?>">
								  <?php 
                                  /* Display Agent Description
                                  ==================================*/
                                  $userDesc = get_the_author_meta('description', $user->ID);
								  
                                  echo apply_filters('the_content', $userDesc);
                                  ?>
                              </div>
                          </div>
                          <div class="row">
                                  <div class="col-md-6 col-sm-6">
                                  <div class="agent-contact-details">
                                          <h4><?php _e('Contact Details','framework'); ?></h4>
                                          <?php
										  /* Display Agent Contact/Social Details
                                 		  ==========================================*/
										  //Agent Contact Details
										  $userMobileNo = get_the_author_meta('mobile-phone', $user->ID);
						  				  $userWorkNo = get_the_author_meta('work-phone', $user->ID);
										  
										  //Agent Social Details
										  $userFB = get_the_author_meta('fb-link', $user->ID);
						  				  $userTWT = get_the_author_meta('twt-link', $user->ID);
										  $userGP = get_the_author_meta('gp-link', $user->ID);
						  				  $userMSG = get_the_author_meta('msg-link', $user->ID);
										  $userLINKEDIN = get_the_author_meta('linkedin-link', $user->ID);
										  $userSocialArray = array_filter(array($userFB, $userTWT, $userGP, $userMSG, $userLINKEDIN));
										  $userSocialClass = array('fa-facebook', 'fa-twitter', 'fa-google-plus', 'fa-envelope', 'fa-linkedin');
										  if(!empty($userMobileNo) || !empty($userWorkNo) || !empty($user->user_email) || !empty($userSocialArray)) {	
										  echo '<ul class="list-group">';
                                              // Display Agent Mobile Number
											  if (!empty($userMobileNo)) {
                                              	echo '<li class="list-group-item"> <span class="badge">'. $userMobileNo .'</span> '. __('Mobile Phone','framework') .' </li>';
											  }
											  // Display Agent Work Number
											  if (!empty($userWorkNo)) {
                                              	echo '<li class="list-group-item"> <span class="badge">'.$userWorkNo.'</span> '. __('Work Phone','framework') .'</li>';
											  }
											  // Display Agent Email Address
											  if (!empty($user->user_email)) {
                                              	echo '<li class="list-group-item"> <span class="badge">'. $user->user_email .'</span> '. __('Email','framework') .' </li>';
											  }
											  // Display Agent Social Links
											  if (!empty($userSocialArray)) {
											  	echo '<li class="list-group-item">
		                                                  <div class="social-icons">';
												foreach($userSocialArray as $key => $value)	{
													if(!empty($value)) {
														echo '<a href="'. $value .'" target="_blank"><i class="fa '. $userSocialClass[$key] .'"></i></a>';
													}
												}		  
												echo '	  </div>
                                              		  </li>';  
											  }
                                           echo '</ul>';
										  } ?>
                                      </div>
                               </div>
                               <div class="col-md-6 col-sm-6">
                               <?php if (!empty($user->user_email)) {  ?>	
                                  <div class="agent-contact-form">
                                      <h4><?php _e('Contact Form','framework'); ?></h4>
                                      <form method="post" id="agentcontactform" name="agentcontactform" class="agent-contact-form" action="<?php echo get_template_directory_uri() ?>/mail/agent_contact.php">
                                          <input type="email"  id="email" name="Email Address" class="form-control" placeholder="<?php _e('Email Address','framework'); ?>">
                                      	  <textarea name="comments" id="comments" class="form-control" placeholder="<?php _e('Your message','framework'); ?>" cols="10" rows="5"></textarea>
                                          <input type="hidden" value="" name="subject" id="subject">
                                          <input type="hidden" name="image_path" id="image_path" value="<?php echo get_template_directory_uri(); ?>">
                                          <input id="agent_email" name="agent_email" type="hidden" value="<?php echo $user->user_email; ?>">
                                          <button type="submit" class="btn btn-primary pull-right"><?php _e('Submit','framework'); ?></button>
                                      </form>
                                     </div>
                                   <div class="clearfix"></div>
                                <div id="message"></div>
                               <?php } ?>   
                               </div>
                          </div>
                    </div>
                    <div class="spacer-20"></div>
                    <!-- Start Related Properties -->
                    <?php $count_author_post = imic_count_user_posts_by_type($user->ID,'property'); if($count_author_post>0) { ?>
                    <h3><?php _e('Latest properties listed by ','framework'); ?><a href="#"><?php echo $userName; ?></a></h3>
                    <hr>
                    <div class="property-grid">
                      <ul class="grid-holder col-3">
                      <?php query_posts(array('post_type'=>'property','post_status'=>'publish','posts_per_page'=>3,'author'=>$user->ID)); 
					  			if(have_posts()):while(have_posts()):the_post(); 
								$property_images = get_post_meta(get_the_ID(),'imic_property_sights',false);
								$total_images = count($property_images);
								$property_area = get_post_meta(get_the_ID(),'imic_property_area',true); 
								  $property_baths = get_post_meta(get_the_ID(),'imic_property_baths',true);
								  $property_beds = get_post_meta(get_the_ID(),'imic_property_beds',true);
								  $property_parking = get_post_meta(get_the_ID(),'imic_property_parking',true); 
								  $property_address = get_post_meta(get_the_ID(),'imic_property_site_address',true);
								  $property_city = get_post_meta(get_the_ID(),'imic_property_site_city',true);
								  $property_price = get_post_meta(get_the_ID(),'imic_property_price',true);
								  $property_area_location = wp_get_object_terms(get_the_ID(), 'city-type');
								   $sl = '';
								   $total_area_location = count($property_area_location);
								   $num = 1;
								   foreach($property_area_location as $sa) {
								   $conc = ($num!=$total_area_location)?'->':'';
								   $sl .= $sa->name.$conc; $num++; }
								   ?>
                        <li class="grid-item type-rent">
                          <div class="property-block"> <a href="<?php the_permalink(); ?>" class="property-featured-image"> <?php the_post_thumbnail('600-400-size'); ?> <span class="images-count"><i class="fa fa-picture-o"></i> <?php echo $total_images; ?></span> <span class="badges"><?php $contract = wp_get_object_terms( get_the_ID(), 'property-contract-type', array('fields'=>'ids')); $term = get_term( $contract[0], 'property-contract-type' ); echo $term->name; ?></span> </a>
                            <div class="property-info">
                              <h4><a href="<?php the_permalink(); ?>"><?php echo $property_address; ?></a></h4>
                              <?php echo '<a class="accent-color" data-original-title="'.$sl.'" data-toggle="tooltip" style="cursor:default; text-decoration:none;" href="javascript:void(0);"><span class="location sort_by_location">'.$property_city.'</span></a><br>'; ?>
                              <div class="price"><strong><?php echo $currency_symbol; ?></strong><span><?php echo $property_price; ?></span></div>
                            </div>
                            <div class="property-amenities clearfix"> <span class="area"><strong><?php echo $property_area; ?></strong><?php _e('Area','framework'); ?></span> <span class="baths"><strong><?php echo $property_baths; ?></strong><?php _e('Baths','framework'); ?></span> <span class="beds"><strong><?php echo $property_beds; ?></strong><?php _e('Beds','framework'); ?></span> <span class="parking"><strong><?php echo $property_parking; ?></strong><?php _e('Parking','framework'); ?></span> </div>
                          </div>
                        </li>
                        <?php endwhile; endif; wp_reset_query(); ?>
                      </ul>
                    </div>
                    <?php } ?>
                  </div>
                  <?php if(is_active_sidebar('inner-sidebar')) { ?>
                  <!-- Start Sidebar -->
                  <div class="sidebar right-sidebar col-md-3">
                      <?php dynamic_sidebar('inner-sidebar'); ?>
                  </div> 
                  <?php } ?> 
              </div>
          </div>
      </div>
  </div>
<?php get_footer(); ?>