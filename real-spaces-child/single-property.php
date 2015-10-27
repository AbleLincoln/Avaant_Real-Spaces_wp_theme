<?php get_header();
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

//-- Site Showcase --
//imic_singe_property_banner(get_the_ID());
function imic_match_favourite_property($user_id, $property_id) {
  global $wpdb;
  $table_name = $wpdb->prefix . "favorite_property_search";
  $sql_select="select property_name from $table_name WHERE `user_name` = '$user_id'";
  $q =$wpdb->get_results($sql_select,ARRAY_A)or print mysql_error();
  $array_id =array();
  if(!empty($q)){
    foreach($q[0] as $data) { 
      $array_update= unserialize($data);
      if(!empty($array_update)) {
        foreach($array_update as $key=>$value) {
          array_push($array_id,$key); 
        }
      }
    }
  }	
  if (in_array($property_id, $array_id)) {
    $output='<div class ="favorite_information">';
    $output.= '<a href="javascript:void(0);" class="accent-color" style="cursor:default; text-decoration:none;" data-toggle="tooltip" data-original-title="'.__('In your favorites','framework').'"><button class="btn btn-default btn-block" type="submit">Favorited</button></a>';
    $output.='</div>';
    return $output;
  } else {
    $output='<div class ="favorite_information">';
    $output.= '<span class ="favorite"><div class="favorite-strings" style="display:none;"><span class="favorite-title">' . __('Add to Favourite','framework') . '</span><span class="favorite-body">' . __(' Sending Request To Add this Property ...','framework') . '</span><span class="favorite-success">' . __('In your favorites','framework') . '</span></div><a href="#" class="accent-color" style="text-decoration:none;" data-toggle="tooltip" data-original-title="'.__('Add this project to your favorites','framework').'"><button class="btn btn-default btn-block" type="submit">Favorite</button></a></span>';
    $output.='<span class ="f_author_n" id ="' . $user_id . '"></span>';
    $output.='<span class ="f_property_n" id ="' . $property_id . '"></span>';
    $output.='</div>';
    return $output; 
  }
}
//-- End Site Showcase --

$property_type = $property_term_type = '';
$sidebar = get_post_meta(get_the_ID(),'imic_select_sidebar_from_list',false); 
$class = (empty($sidebar)||!is_active_sidebar($sidebar[0]))?8:9;
$sidebar_class = (empty($sidebar)||!is_active_sidebar($sidebar[0]))?4:3;
global $imic_options;
$currency_symbol = imic_get_currency_symbol($imic_options['currency-select']); ?>
  
<!--Get project meta info-->
<?php 
  $property_zoom_value=get_post_meta(get_the_ID(),'imic_property_zoom_option',true);
  $property_zoom_value=!empty($property_zoom_value)?$property_zoom_value:4;
  echo '<span class ="property_zoom_level" id ="'.$property_zoom_value.'"></span>';
  if(have_posts()):while(have_posts()):the_post(); 
  $this_property_id = get_the_ID();
  $property_area = get_post_meta(get_the_ID(),'imic_property_area',true); 
  $property_baths = get_post_meta(get_the_ID(),'imic_property_baths',true);
  $property_beds = get_post_meta(get_the_ID(),'imic_property_beds',true);
  $property_parking = get_post_meta(get_the_ID(),'imic_property_parking',true); 
  $property_address = get_post_meta(get_the_ID(),'imic_property_site_address',true);
  $property_city = get_post_meta(get_the_ID(),'imic_property_site_city',true);
  $property_price = get_post_meta(get_the_ID(),'imic_property_price',true); 
  $contract = wp_get_object_terms( get_the_ID(), 'property-contract-type', array('fields'=>'ids')); 
  $property_area_location = wp_get_object_terms(get_the_ID(), 'city-type');
  $avnt_contact_email = get_post_meta(get_the_ID(), 'imic_project_email', true);
  $sl = '';
  $total_area_location = count($property_area_location);
  $num = 1;
  foreach($property_area_location as $sa) {
    $conc = ($num!=$total_area_location)?'->':'';
    $sl .= $sa->name.$conc; $num++; 
  }
  $property_longitude_and_latitude=get_post_meta(get_the_ID(),'imic_lat_long',true);
  if(!empty($property_longitude_and_latitude)) {
    $property_longitude_and_latitude = explode(',', $property_longitude_and_latitude); 
  } else {
    $property_longitude_and_latitude=getLongitudeLatitudeByAddress($property_address);
  }
  $src = wp_get_attachment_image_src(get_post_thumbnail_id(),'150-100-size');
  if(!empty($src)):
    $image_container= '<span class ="property_image_map">'.$src[0].'</span>';
  else:
    $image_container='';
  endif; 
  echo '<div id="property'.get_the_ID().'" style="display:none;"><span class ="property_address">'.$property_address.'</span><span class ="property_price"><strong>$</strong> <span> '.$property_price.'</span></span><span class ="latitude">'.$property_longitude_and_latitude[0].'</span><span class ="longitude">'.$property_longitude_and_latitude[1].'</span>'.$image_container.'<span class ="property_url">'.get_permalink(get_the_ID()).'</span><span class ="property_image_url">'.IMIC_THEME_PATH.'/images/map-marker.png</span></div>';
  if(!empty($contract)) {
    $term = get_term( $contract[0], 'property-contract-type' ); $property_term_type = $term->name;
  }
  $contract_type = wp_get_object_terms( get_the_ID(), 'property-type', array('fields'=>'ids')); 
  if(!empty($contract_type)) {
    $terms = get_term( $contract_type[0], 'property-type' );  
    $property_type = $terms->slug;
  }
?>

<!-- Start Content -->
<div class="main" role="main">
  <div id="content" class="content full avnt-project">
    <div class="container">
      <div class="row avnt-title-bar single-property">
        <div class="col-md-12">
          <h2 class="page-title"><?php echo get_the_title(); ?> <?php if(!empty($property_city)) { echo ', <a class="accent-color" data-original-title="'.$sl.'" data-toggle="tooltip" style="cursor:default; text-decoration:none;" href="javascript:void(0);"><span class="location sort_by_location">'.$property_city.'</span></a>'; } ?></h2>
        </div>
        <div class="col-md-7">
          <div class="property-slider">
            <div id="property-images" class="flexslider">
              <?php $property_sights = get_post_meta(get_the_ID(),'imic_property_sights',false); ?>
                <ul class="slides">
                  <?php foreach($property_sights as $property_sight) {
                    $image = wp_get_attachment_image_src($property_sight,'600-400-size',''); ?>
                    <li class="item"> <img src="<?php echo $image[0]; ?>" alt=""> </li>
                  <?php } ?>
                </ul>
            </div>
            <?php if(count($property_sights)>1) { ?>
              <div id="property-thumbs" class="flexslider">
                <?php $property_sights = get_post_meta(get_the_ID(),'imic_property_sights',false); ?>
                  <ul class="slides">
                    <?php foreach($property_sights as $property_sight) {
                      $image = wp_get_attachment_image_src($property_sight,'600-400-size',''); ?>
                      <li class="item"> <img src="<?php echo $image[0]; ?>" alt=""> </li>
                    <?php } $author_id = $post->post_author; ?>
                  </ul>
              </div>
            <?php } ?>
          </div>
        </div>
        <div class="col-md-5">
          <div class="avnt-seeking">
            <h3>Seeking</h3>
            <div>
              <?php
                $avnt_hacker = get_post_meta(get_the_ID(), 'avnt_hacker', true);
                $avnt_hustler = get_post_meta(get_the_ID(), 'avnt_hustler', true);
                $avnt_creative = get_post_meta(get_the_ID(), 'avnt_creative', true);
                if($avnt_hacker) {
                  echo '<span class="available"><i class="fa fa-code"></i> Hacker</span><br>';
                }
                if($avnt_hustler) {
                  echo '<span class="available"><i class="fa fa-line-chart"></i> Hustler</span><br>';
                }
                if($avnt_creative) {
                  echo '<span class="available"><i class="fa fa-paint-brush"></i>  Creative</span><br>';
                }
              ?>
              <?php 
                $amenity_array=array();
                $property_amenities = get_post_meta(get_the_ID(),'imic_property_amenities',true);
                global $imic_options;		
                foreach($property_amenities as $properties_amenities_temp) {
                  if($properties_amenities_temp!='Not Selected'){
                    array_push($amenity_array,$properties_amenities_temp);
                  }
                }
                if(isset($imic_options['properties_amenities'])&&count($imic_options['properties_amenities'])>1) {
                  foreach($imic_options['properties_amenities'] as $properties_amenities){
                    $am_name= strtolower(str_replace(' ','',$properties_amenities));
                    if(in_array($properties_amenities, $amenity_array)){
                      $class = 'available';
                      echo '<span class="'.$class.'"><i class="fa fa-user"></i> '.$properties_amenities.'</span><br>';
                    } else {
                      $class = 'navailable'; 
                    }
                  }
                }
                $author_id = $post->post_author; 
              ?>
            </div>
          </div>
          <div class="avnt-description">
            <h3>Project Description</h3>
              <?php the_content(); ?>
          </div>
          <div class="avnt-contact">
            <h3 style="display: inline-block">Contact:</h3>
            <?php echo '<a href="mailto:'.$avnt_contact_email.'">'.$avnt_contact_email.'</a></p>'; ?>
          </div>
          <div>
            <h3>Share</h3>
              <?php 
                if ($imic_options['switch_sharing'] == 1 && $imic_options['share_post_types']['3'] == '1') {
                  imic_share_buttons(); } 
              ?>
          </div>
        </div>
      </div>

      <div class="row avnt-hidden">
        <div class="col-md-7">
          <div class="single-property">
            
            <?php if(!empty($property_price)) { ?>
              <div class="price">
                <strong><?php echo $currency_symbol; ?></strong><span><?php echo $property_price; ?></span>
              </div>
            <?php } ?>
            <div class="property-amenities clearfix avaant-hidden">
              <?php if(!empty($property_term_type)) { ?>
                <span class="area"><strong><?php _e('For','framework'); ?></strong><?php echo $property_term_type; ?></span>
              <?php } ?>
              <?php if(!empty($property_area)) { ?>
                <span class="area"><strong><?php echo $property_area; ?></strong><?php _e('Area','framework'); ?></span>
              <?php } ?>
              <?php if(!empty($property_baths)) { ?>
                <span class="baths"><strong><?php echo $property_baths; ?></strong><?php _e('Baths','framework'); ?></span>
              <?php } ?>
              <?php if(!empty($property_beds)) { ?>
                <span class="beds"><strong><?php echo $property_beds; ?></strong><?php _e('Beds','framework'); ?></span>
              <?php } ?>
              <?php if(!empty($property_parking)) { ?>
                <span class="parking"><strong><?php echo $property_parking; ?></strong><?php _e('Parking','framework'); ?></span>
              <?php } ?>
              <span class="parking">
                <?php if ( is_plugin_active( 'favorite_property/favorite_property.php' ) ) { 
                  if(is_user_logged_in()) { 
                    $current_user = wp_get_current_user();
                    echo imic_match_favourite_property($current_user->ID, get_the_ID()); } 
                  else {
                    echo '<a id="show_login" data-target="#login-modal" data-toggle="modal" title="'.__('Login to Add in Favourite','framework').'">'.__('Login','framework').'</a>'; 
                  } } ?>
              </span>
            </div>

            <?php if(!empty($sidebar)) { ?>
              <div class="tabs">
                <ul class="nav nav-tabs">
                  <li class="active">
                    <a data-toggle="tab" href="#description">
                      <?php _e(' Description ','framework'); ?>
                    </a>
                  </li>
                  <li>
                    <a data-toggle="tab" href="#amenities">
                      <?php _e(' Looking for ','framework'); ?>
                    </a>
                  </li>
                  <li>
                    <a data-toggle="tab" href="#address">
                      <?php _e(' Project Details ','framework'); ?>
                    </a>
                  </li>
                </ul>
                <div class="tab-content">
                  <div id="description" class="tab-pane active">
                    <?php the_content(); ?>
                  </div>
                  <div id="amenities" class="tab-pane">
                    <div class="additional-amenities">
                      <?php 
                        $amenity_array=array();
                        $property_amenities = get_post_meta(get_the_ID(),'imic_property_amenities',true);
                        global $imic_options;		
                        foreach($property_amenities as $properties_amenities_temp){
                          if($properties_amenities_temp!='Not Selected'){
                            array_push($amenity_array,$properties_amenities_temp);
                          }
                        }
                        if(isset($imic_options['properties_amenities'])&&count($imic_options['properties_amenities'])>1) {
                          foreach($imic_options['properties_amenities'] as $properties_amenities){
                            $am_name= strtolower(str_replace(' ','',$properties_amenities));
                            if(in_array($properties_amenities, $amenity_array)) {
                              $class = 'available';
                            } else{
                              $class = 'navailable'; 
                            }
                            if(!empty($properties_amenities)) {
                              echo '<span class="'.$class.'"><i class="fa fa-check-square"></i> '.$properties_amenities.'</span>';
                            }
                          }
                        }
                        $author_id = $post->post_author; 
                      ?>
                    </div>
                  </div>
                  <div id="address">
                    <?php imicPropertyDetailById(get_the_ID()); ?>
                  </div>
                </div>
              </div>
              <?php
                global $imic_options;
                if(isset($imic_options['enable_agent_details'])&&($imic_options['enable_agent_details']==1)){ ?>
                  <h3> <?php _e('Agent','framework'); ?> </h3>
                  <div class="agent">
                    <div class="row">
                      <div class="col-md-4">
                        <?php
                        $agent_image = get_the_author_meta('agent-image', $author_id); 
                        $userFirstName = get_the_author_meta('first_name', $author_id);
                        $userLastName = get_the_author_meta('last_name', $author_id);
                        $userName = get_userdata( $author_id );
                        if(!empty($userFirstName) || !empty($userLastName)) {
                          $userName = $userFirstName .' '. $userLastName; 
                        } else { 
                          $userName = $userName->user_login;
                        } 
                        $description = get_the_author_meta( 'description', $author_id );
                        if(!empty($agent_image)) { ?>
                          <img src="<?php echo $agent_image; ?>">
                        <?php } else {
                          $default_image_agent = $imic_options['default_agent_image']; ?>
                          <img src="<?php echo $default_image_agent['url']; ?>">
                        <?php } ?>
                      </div>
                      <div class="col-md-8">
                        <h4><a href="<?php echo get_author_posts_url($author_id); ?>"><?php echo $userName; ?></a></h4>
                        <?php echo apply_filters('the_content', $description); ?>
                        <div class="agent-contacts clearfix">
                          <a href="<?php echo get_author_posts_url($author_id); ?>" class="btn btn-primary pull-right btn-sm">
                            <?php _e('Agent Information','framework'); ?>
                          </a>&nbsp;
                          <a data-target="#agentmodal" data-toggle="modal" class="btn btn-primary pull-right btn-sm">
                            <?php _e('Contact Agent','framework'); ?>
                          </a>
                          <?php $userFB = get_the_author_meta('fb-link', $author_id);
                            $userTWT = get_the_author_meta('twt-link', $author_id);
                            $userGP = get_the_author_meta('gp-link', $author_id);
                            $userMSG = get_the_author_meta('msg-link', $author_id);
                            $userSocialArray = array_filter(array($userFB,$userTWT,$userGP,$userMSG));
                            $userSocialClass = array('fa-facebook','fa-twitter','fa-google-plus','fa-envelope');
                            if(!empty($userSocialArray)) {
                              echo '<ul>';
                              foreach($userSocialArray as $key => $value)	{
                                if(!empty($value)) {
                                  echo '<li><a href="'. $value .'" target="_blank"><i class="fa '. $userSocialClass[$key] .'"></i></a></li>';
                                }
                              }
                              echo '</ul>';
                            }
                          ?>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php }} endwhile; endif; ?>
          </div>
          
        <div class="sidebar right-sidebar">
          <h3>Team Details</h3>
          <div class="avnt-box avnt-team-details">
            <div class="agent">
              <div class="row">
                <div class="col-md-12">
                  <?php
                  $agent_image = get_the_author_meta('agent-image', $author_id); 
                  $userFirstName = get_the_author_meta('first_name', $author_id);
                  $userLastName = get_the_author_meta('last_name', $author_id);
                  $userName = get_userdata( $author_id );
                  if(!empty($userFirstName) || !empty($userLastName)) {
                    $userName = $userFirstName .' '. $userLastName; 
                  } else { 
                    $userName = $userName->user_login;
                  } 
                  $description = get_the_author_meta( 'description', $author_id );
                  if(!empty($agent_image)) { ?>
                    <img src="<?php echo $agent_image; ?>">
                  <?php } else {
                    $default_image_agent = $imic_options['default_agent_image']; ?>
                    <img src="<?php echo $default_image_agent['url']; ?>">
                  <?php } ?>
                  <h4><a href="<?php echo get_author_posts_url($author_id); ?>"><?php echo $userName; ?></a></h4>
                  <?php echo apply_filters('the_content', $description); ?>
                </div>
              </div>
            </div>
          </div>
        </div>
          
          <!-- Start Related Properties -->
          <?php query_posts(array('post_type'=>'property','post_status'=>'publish','property-type'=>$property_type,'posts_per_page'=>3,'post__not_in'=>array($this_property_id)));
            if($wp_query->post_count!=0) { ?>
              <h3><?php _e('Related Projects','framework'); ?></h3>
              <hr>
              <div class="property-grid">
                <ul class="grid-holder col-3">
                  <?php 
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
                        $sl .= $sa->name.$conc; $num++;
                      }
                      $contract = wp_get_object_terms( get_the_ID(), 'property-contract-type', array('fields'=>'ids')); 
                      if(!empty($contract)) {
                        $term = get_term( $contract[0], 'property-contract-type' ); 
                      } 
                  ?>
                      <li class="grid-item type-<?php if(!empty($term)) { echo $term->name; } ?>">
                        <div class="property-block">
                          <a href="<?php the_permalink(); ?>" class="property-featured-image">
                            <?php the_post_thumbnail('600-400-size'); ?> 
                            <span class="images-count"><i class="fa fa-picture-o"></i> <?php echo $total_images; ?></span>
                            <?php if(!empty($term)) { ?>
                              <span class="badges"><?php echo $term->name; ?></span>
                            <?php } ?>
                          </a>
                          <div class="property-info">
                            <h4><a href="<?php the_permalink(); ?>">  <?php echo get_the_title(); ?></a></h4>
                            <?php if(!empty($property_city)) {
                              echo '<a class="accent-color" data-original-title="'.$sl.'" data-toggle="tooltip" style="cursor:default; text-decoration:none;" href="javascript:void(0);"><span class="location sort_by_location">'.$property_city.'</span></a><br>';
                            } ?>
                            <?php if(!empty($property_price)) { ?>
                              <div class="price">
                                <strong><?php echo $currency_symbol; ?></strong><span><?php echo $property_price; ?></span>
                              </div>
                            <?php } ?>
                          </div>
                          <div class="property-amenities clearfix">
                            <?php if(!empty($property_area)) { ?>
                              <span class="area"><strong><?php echo $property_area; ?></strong><?php _e('Area','framework'); ?></span>
                            <?php } ?>
                            <?php if(!empty($property_baths)) { ?>
                              <span class="baths"><strong><?php echo $property_baths; ?></strong><?php _e('Baths','framework'); ?></span>
                            <?php } ?>
                            <?php if(!empty($property_beds)) { ?>
                              <span class="beds"><strong><?php echo $property_beds; ?></strong><?php _e('Beds','framework'); ?></span>
                            <?php } ?>
                            <?php if(!empty($property_parking)) { ?>
                              <span class="parking"><strong><?php echo $property_parking; ?></strong><?php _e('Parking','framework'); ?></span>
                            <?php } ?>
                          </div>
                        </div>
                      </li>
                    <?php endwhile; endif; wp_reset_query(); ?>
                  </ul>
                </div>
            <?php } ?>
          </div>
        
        <!-- Start Sidebar -->
<!--
        <?php // if(!empty($sidebar)&&is_active_sidebar($sidebar[0])) { ?>
          <div class="sidebar right-sidebar col-md-<?php // echo $sidebar_class; ?>">
            <?php // dynamic_sidebar($sidebar[0]); ?>
          </div>
          <?php // } else { ?>
            <div class="sidebar right-sidebar col-md-<?php // echo $sidebar_class; ?>">
              <?php // get_template_part('loop','fw'); ?>
            </div>
            <?php // } ?>
-->
        
                
<!--        social buttons-->
        <div class="col-md-5">
          <div class="row social-buttons">
            <div class="col-md-4">
              <?php 
                if ( is_plugin_active( 'favorite_property/favorite_property.php' ) ) { 
                  if(is_user_logged_in()) { 
                    $current_user = wp_get_current_user();
                    echo imic_match_favourite_property($current_user->ID, get_the_ID());
                  } else {
                    echo '<a id="show_login" data-target="#login-modal" data-toggle="modal" title="'.__('Login to Add in Favourite','framework').'">'.__('Login','framework').'</a>'; 
                  }
                }
              ?>
            </div>
            <div class="col-md-4">
              <button class="btn btn-default btn-block" id="share">Share</button>
            </div>
            <div class="col-md-4">
              <button class="btn btn-default btn-block" type="submit">Contact</button>
            </div>
            <div class="share-box col-md-12" id="share-box">
              <?php 
                if ($imic_options['switch_sharing'] == 1 && $imic_options['share_post_types']['3'] == '1') {
                  imic_share_buttons(); } 
              ?>
            </div>
            <div class="avnt-slide-box col-md-12">
              
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!--Favourite Login Form-->
<div id="login-modal" class="modal fade" aria-hidden="true" aria-labelledby="mymodalLabel" role="dialog" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button class="close" aria-hidden="true" data-dismiss="modal" type="button">×</button>
        <h4 id="mymodalLabel" class="modal-title"><?php _e(' Login','framework'); ?></h4>
      </div>
      <div class="modal-body">
        <form id="login" action="login" method="post">
          <?php 
            $redirect_login= get_post_meta(get_the_ID(),'imic_login_redirect_options',true);
            $redirect_login=!empty($redirect_login)?$redirect_login:  home_url();
          ?>
          <input type="hidden" class="redirect_login" name="redirect_login" value="" />
          <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-user"></i></span>
            <input class="form-control input1" id="loginname" type="text" name="loginname">
          </div>
          <br>
          <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-lock"></i></span>
            <input class="form-control input1" id="password" type="password" name="password">
          </div>
          <div class="checkbox">
            <input type="checkbox" checked="checked" value="true" name="rememberme" id="rememberme" class="checkbox">
            <?php _e('Remember Me!','framework'); ?>
          </div>
          <input class="submit_button btn btn-primary button2" type="submit" value="<?php _e('Login Now','framework'); ?>" name="submit">
          <?php wp_nonce_field( 'ajax-login-nonce', 'security' ); ?>
          <p class="status"></p>
        </form>
      </div>
      <div class="modal-footer">
        <button class="btn btn-default inverted" data-dismiss="modal" type="button">Close</button>
      </div>
    </div>
  </div>
</div>

<!--Contact Agent Form-->
<div id="agentmodal" class="modal fade" aria-hidden="true" aria-labelledby="mymodalLabel" role="dialog" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button class="close" aria-hidden="true" data-dismiss="modal" type="button">×</button>
        <h4 id="mymodalLabel" class="modal-title"><?php _e(' Contact Agent','framework'); ?></h4>
      </div>
      <div class="modal-body">
        <div class="agent-contact-form">
          <h4><?php _e('Contact Agent For ','framework'); ?><span class="accent-color"><?php echo get_the_title(); ?></span></h4>
          <form method="post" id="agentcontactform" name="agentcontactform" class="agent-contact-form" action="<?php echo get_template_directory_uri() ?>/mail/agent_contact.php">
            <input type="email" id="email" name="Email Address" class="form-control" placeholder="<?php _e('Email Address','framework'); ?>">
            <textarea name="comments" id="comments" class="form-control" placeholder="<?php _e('Your message','framework'); ?>" cols="10" rows="5"></textarea>
            <input type="hidden" name="image_path" id="image_path" value="<?php echo get_template_directory_uri(); ?>">
            <input id="agent_email" name="agent_email" type="hidden" value="<?php echo get_the_author_meta( 'user_email', $author_id ); ?>">
            <input type="hidden" value="<?php echo get_the_title(); ?>" name="subject" id="subject">
            <button type="submit" class="btn btn-primary pull-right">
              <?php _e('Submit','framework'); ?>
            </button>
          </form>
        </div>
        <div class="clearfix"></div>
        <div id="message"></div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-default inverted" data-dismiss="modal" type="button">Close</button>
      </div>
    </div>
  </div>
</div>

<?php get_footer(); ?>
