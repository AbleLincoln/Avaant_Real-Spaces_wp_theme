<?php
/*
Template Name: Property Listing
*/
get_header(); 
/* Site Showcase */
imic_page_banner($pageID = get_the_ID());
/* End Site Showcase */
$sidebar = get_post_meta(get_the_ID(),'imic_select_sidebar_from_list',false); 
$design_type = get_post_meta(get_the_ID(),'imic_property_design_layout',true);
$class = (empty($sidebar)||!is_active_sidebar($sidebar[0]))?12:9;
$div = ($design_type=='grid')?'<div class="property-grid"><ul id="property_grid_holder" class="grid-holder col-3">':'<div class="property-listing row"><ul class="col-md-12" id="property_grid_holder">'; 
$layout = ($design_type=='grid')?'<i class="fa fa-th-large"></i></span>'.__('Property Grid','framework').'':'<i class="fa fa-th-list"></i></span>'.__('Property Listing','framework'); 
$listing_layout_url = get_post_meta(get_the_ID(),'imic_property_listing_url',true); 
$grid_layout_url = get_post_meta(get_the_ID(),'imic_property_grid_url',true); 
$listing_url = ($design_type=='listing')?$listing_layout_url:''; 
$grid_url = ($design_type=='grid')?$grid_layout_url:''; 
$listing_class = ($design_type=='listing')?'active':''; 
$grid_class = ($design_type=='grid')?'active':''; ?>
<!-- Start Content -->
  <div class="main" role="main">
      <div id="content" class="content full">
          <div class="container">
              <div class="row">
           <div class="col-md-<?php echo $class; ?>">
                      <div class="block-heading">
                          <h4><span class="heading-icon"><?php echo $layout; ?></h4>
                          <div class="toggle-view pull-right">
                              <a href="<?php echo $grid_url; ?>" class="<?php echo $grid_class; ?>"><i class="fa fa-th-large"></i></a>
                              <a href="<?php echo $listing_url; ?>" class="<?php echo $listing_class; ?>"><i class="fa fa-th-list"></i></a>
                          </div>
                      </div>
                    <?php echo $div; $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                       query_posts(array('post_type'=>'property','post_status'=>'publish','paged'=>$paged));
								if(have_posts()):while(have_posts()):the_post(); 
								$property_images = get_post_meta(get_the_ID(),'imic_property_sights',false);
								$total_images = count($property_images);
								$property_term_type = '';
								$property_area = get_post_meta(get_the_ID(),'imic_property_area',true); 
								  $property_baths = get_post_meta(get_the_ID(),'imic_property_baths',true);
								  $property_beds = get_post_meta(get_the_ID(),'imic_property_beds',true);
								  $property_parking = get_post_meta(get_the_ID(),'imic_property_parking',true); 
								  $property_address = get_post_meta(get_the_ID(),'imic_property_site_address',true);
								  $property_city = get_post_meta(get_the_ID(),'imic_property_site_city',true);
								  $property_price = get_post_meta(get_the_ID(),'imic_property_price',true); 
								  $contract = wp_get_object_terms( get_the_ID(), 'property-contract-type', array('fields'=>'ids')); 
								  $property_id = get_post_meta(get_the_ID(),'imic_property_site_id',true);
								  $property_area_location = wp_get_object_terms(get_the_ID(), 'city-type');
								   $sl = '';
								   $total_area_location = count($property_area_location);
								   $num = 1;
								   foreach($property_area_location as $sa) {
								   $conc = ($num!=$total_area_location)?'->':'';
								   $sl .= $sa->name.$conc; $num++; }
								 // We get Longitude & Latitude By Property Address
                                                                   $property_longitude_and_latitude=get_post_meta(get_the_ID(),'imic_lat_long',true);
                                                                 if(!empty($property_longitude_and_latitude)){
                                                                      $property_longitude_and_latitude = explode(',', $property_longitude_and_latitude); 
                                                                  }else{
                                                                  $property_longitude_and_latitude=getLongitudeLatitudeByAddress($property_address);
                                                                 }
                                                                  global $imic_options;
                                                                  $currency_symbol = imic_get_currency_symbol($imic_options['currency-select']);
                                                                  $src = wp_get_attachment_image_src(get_post_thumbnail_id(),'150-100-size');
                                                                  if(!empty($src)):
                                                                    $image_container= '<span class ="property_image_map">'.$src[0].'</span>';
                                                                    else:
                                                                    $image_container='';
                                                                    endif;  
                                                                    if(!empty($contract)) {
								  $term = get_term( $contract[0], 'property-contract-type'); $property_term_type = $term->name; } 
								  if($design_type=='listing') { ?>
                                                                 <li class="type-rent col-md-12">
                                                                <?php 
                                                               echo '<div id="property'.get_the_ID().'" style="display:none;"><span class ="property_address">'.$property_address.'</span><span class ="property_price"><strong>'.$currency_symbol.'</strong> <span> '.$property_price.'</span></span><span class ="latitude">'.$property_longitude_and_latitude[0].'</span><span class ="longitude">'.$property_longitude_and_latitude[1].'</span>'.$image_container.'<span class ="property_url">'.get_permalink(get_the_ID()).'</span><span class ="property_image_url">'.IMIC_THEME_PATH.'/images/map-marker.png</span></div>'; ?>
                                                                     <div class="col-md-4"> <a href="<?php the_permalink(); ?>" class="property-featured-image"><?php the_post_thumbnail('600-400-size'); ?><span class="images-count"><i class="fa fa-picture-o"></i> <?php echo $total_images; ?></span> <span class="badges"><?php echo $property_term_type; ?></span> </a> </div>
                                                               <div class="col-md-8">
                                                               <div class="property-info">
                                                               <?php if(!empty($property_price)) { ?><div class="price"><strong><?php echo $currency_symbol; ?></strong><span><?php echo $property_price; ?></span></div><?php } ?>
                                                               <h3><a href="<?php the_permalink();?>"><?php echo get_the_title(); ?></a><?php echo imicPropertyId(get_the_ID()); ?></h3>
                                                               <?php if(!empty($property_city)) { echo '<a class="accent-color" data-original-title="'.$sl.'" data-toggle="tooltip" style="cursor:default; text-decoration:none;" href="javascript:void(0);"><span class="location">'.$property_city.'</span></a><br>'; } ?>
                                                               <?php echo imic_excerpt(50); ?>
                                                               </div>
                                                               <?php } else { ?>
                                                               <li id="<?php echo get_the_ID(); ?>" class="grid-item type-rent">
                                                               <?php echo'<div id="property'.get_the_ID().'" style="display:none;"><span class ="property_address">'.$property_address.'</span><span class ="property_price"><strong>'.$currency_symbol.'</strong> <span> '.$property_price.'</span></span><span class ="latitude">'.$property_longitude_and_latitude[0].'</span><span class ="longitude">'.$property_longitude_and_latitude[1].'</span>'.$image_container.'<span class ="property_url">'.get_permalink(get_the_ID()).'</span><span class ="property_image_url">'.IMIC_THEME_PATH.'/images/map-marker.png</span></div>'; ?>
                                                                   <div class="property-block"> <a href="<?php the_permalink(); ?>" class="property-featured-image"> <?php the_post_thumbnail('600-400-size'); ?> <span class="images-count"><i class="fa fa-picture-o"></i> <?php echo $total_images; ?></span> <span class="badges"><?php echo $property_term_type; ?></span> </a>
                                                              <div class="property-info">
                                                                  <h4><a href="<?php the_permalink();?>"><?php echo get_the_title(); ?></a><?php echo imicPropertyId(get_the_ID()); ?></h4>
                                                              <?php if(!empty($property_city)):
                                                                  echo '<a class="accent-color" data-original-title="'.$sl.'" data-toggle="tooltip" style="cursor:default; text-decoration:none;" href="javascript:void(0);"><span class="location">'.$property_city.'</span></a><br>'; 
                                                              endif;
                                                              if(!empty($property_price)){
                                                               echo '<div class="price"><strong>'.$currency_symbol.'</strong><span>'.$property_price.'</span></div>';   
                                                              } ?>
                                                              </div>
                                                             <?php }
                                                             if(!empty($property_area)||!empty($property_baths)||!empty($property_beds)||!empty($property_parking)){
                                                             echo '<div class="property-amenities clearfix">';
                                                            if(!empty($property_area)){
                                                                echo '<span class="area"><strong>'.$property_area.'</strong>'.__('Area','framework').'</span>';
                                                            }
                                                            if(!empty($property_baths)){
                                                              echo '<span class="baths"><strong>'.$property_baths.'</strong>'.__('Baths','framework').'</span>';  
                                                            }
                                                            if(!empty($property_beds)):
                                                              echo '<span class="beds"><strong>'.$property_beds.'</strong>'.__('Beds','framework').'</span>';  
                                                            endif;
                                                            if(!empty($property_parking)):
                                                            echo '<span class="parking"><strong>'.$property_parking.'</strong>'.__('Parking','framework').'</span>';
                                                            endif;
                                                            echo '</div>';
                                                             }?>
                                                          </div>
                                                        </li>
                                       <?php endwhile; endif;
                                       echo '</ul>';?>
                       </div>
                      <?php pagination(); wp_reset_query(); ?>
                  </div>
                  <!-- Start Sidebar -->
                  <?php if(!empty($sidebar)&&is_active_sidebar($sidebar[0])) { 
                      echo '<div class="sidebar right-sidebar col-md-3">';
                      dynamic_sidebar($sidebar[0]);
                      echo '</div>';
                      } ?> 
              </div>
          </div>
      </div>
  <?php get_footer(); ?>