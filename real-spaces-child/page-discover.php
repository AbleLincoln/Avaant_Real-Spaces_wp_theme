<?php 
get_header();  
global $imic_options; //Theme Global Variable
/* Page Banner HTML
=============================*/
imic_page_banner($pageID = get_the_ID()); 
$sidebar = get_post_meta(get_the_ID(),'imic_select_sidebar_from_list',false); 
$class = (empty($sidebar)||!is_active_sidebar($sidebar[0]))?12:9; ?>
  <!-- Start Content -->
  <div class="main" role="main">
      <div id="content" class="content full">
          <div class="container">
              <div class="row">
                <?php
                          echo '<h2>Projects</h2>';
           query_posts(array('post_type'=>'property','post_status'=>'publish','posts_per_page'=>-1)); 
			  if(have_posts()): ?>
                              <?php $data_rtl = ($imic_options['enable_rtl'] == 1)?'data-rtl="rtl"':'';
echo '<div class="row"><ul class="avnt-discover" data-columns="4" data-autoplay="no" data-pagination="no" data-arrows="yes" data-single-item="no" '.$data_rtl.'>';
                              while(have_posts()):the_post();
							  $property_images = get_post_meta(get_the_ID(),'imic_property_sights',false);
								$total_images = count($property_images);
                           echo '<li class="item property-block col-md-3">';
                     if(has_post_thumbnail()):
                          echo'<a href="'.get_permalink().'" class="property-featured-image">';
                              the_post_thumbnail('600-400-size');
                              echo'<span class="images-count"><i class="fa fa-picture-o"></i> '.$total_images.'</span>';
							  $contract = wp_get_object_terms( get_the_ID(), 'property-contract-type', array('fields'=>'ids'));
							  if(!empty($contract)) { 
                              echo'<span class="badges">'; $term = get_term( $contract[0], 'property-contract-type' ); echo $term->name;
                              echo'</span></a>'; }
                              endif; 
			      $imic_property_site_address= get_post_meta(get_the_ID(),'imic_property_site_address',true);
                               $imic_property_site_city=get_post_meta(get_the_ID(),'imic_property_site_city',true);
                               $imic_property_price= get_post_meta(get_the_ID(),'imic_property_price',true);
							   $property_area_location = wp_get_object_terms(get_the_ID(), 'city-type');
							   $sl = '';
							   $total_area_location = count($property_area_location);
							   $num = 1;
							   foreach($property_area_location as $sa) {
								   $conc = ($num!=$total_area_location)?'->':'';
								   $sl .= $sa->name.$conc; $num++; }
                          if(true){
                          echo '<div class="property-info">';
                            echo '<h4><a href="'.get_permalink().'">'.get_the_title().'</a>'.imicPropertyId(get_the_ID()).'</h4>';
                            
                          if(!empty($imic_property_site_city)){
                            echo '<a class="accent-color" data-original-title="'.$sl.'" data-toggle="tooltip" style="cursor:default; text-decoration:none;" href="javascript:void(0);"><span class="location">'.$imic_property_site_city.'</span></a><br>';  
                          }
                          if(!empty($imic_property_price)){
                              echo '<div class="price"><strong>'.$currency_symbol.'</strong><span>'.$imic_property_price.'</span></div>';
                          }
                          echo imic_excerpt(10);
                          
                          echo '<div class="avnt-home-seeking"><h5>Seeking:</h5>';
                            $avnt_hacker = get_post_meta(get_the_ID(), 'avnt_hacker', true);
                            $avnt_hustler = get_post_meta(get_the_ID(), 'avnt_hustler', true);
                            $avnt_creative = get_post_meta(get_the_ID(), 'avnt_creative', true);
                            if($avnt_hacker) {
                              echo '<p><i class="fa fa-code"></i> Hacker</p><br>';
                            }
                            if($avnt_hustler) {
                              echo '<p><i class="fa fa-line-chart"></i> Hustler</p><br>';
                            }
                            if($avnt_creative) {
                              echo '<p><i class="fa fa-paint-brush"></i>  Creative</p><br>';
                            }
                          echo '</div>';
                            
                          echo '<div class="avnt-hidden"><h5>Seeking:</h5>';
                            $amenity_array=array();
                            $property_amenities = get_post_meta(get_the_ID(),'imic_property_amenities',true);
                            global $imic_options;		
                            foreach($property_amenities as $properties_amenities_temp){
                            if($properties_amenities_temp!='Not Selected'){
                            array_push($amenity_array,$properties_amenities_temp);
                            }}
                            if(isset($imic_options['properties_amenities'])&&count($imic_options['properties_amenities'])>1){
                            foreach($imic_options['properties_amenities'] as $properties_amenities){
                             $am_name= strtolower(str_replace(' ','',$properties_amenities));
                            if(in_array($properties_amenities, $amenity_array)){
                            $class = 'available';
                            }else{
                            $class = 'navailable'; 
                              }
                            if(!empty($properties_amenities)){
                            echo '<span class="'.$class.'"><i class="fa fa-user"></i> '.$properties_amenities.'</span>';
                            }}}
                            $author_id = $post->post_author;
                          echo '</div>';
                          echo '</div>';
                          }echo '</li>';  endwhile; 
                          echo '</ul></div>';
                          endif; wp_reset_query();
                          echo '</div>
                          </div>';
                ?>

                  <!-- Start Sidebar -->
                  <?php if(!empty($sidebar)&&is_active_sidebar($sidebar[0])) { ?>
                  <div class="sidebar right-sidebar col-md-3">
                      <?php dynamic_sidebar($sidebar[0]); ?>
                  </div> 
                  <?php } ?> 
              </div>
          </div>
      </div>
  </div>
<?php get_footer(); ?>