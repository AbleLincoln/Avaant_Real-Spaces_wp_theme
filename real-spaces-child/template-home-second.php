<?php
/*
  Template Name: Home Second
 */
get_header(); 
/* Hero Slider Options
===========================*/
global $imic_options;
$currency_symbol = imic_get_currency_symbol($imic_options['currency-select']);
$homeID = get_the_ID();
$autoSlide = get_post_meta($homeID,'imic_slider_auto_slide',true);
$sliderArrows = get_post_meta($homeID,'imic_slider_direction_arrows',true);
$sliderEffect = get_post_meta($homeID,'imic_slider_effects',true);
?>
<!-- Site Showcase -->
<div class="site-showcase">
  <?php
    $imic_slider_with_property= get_post_meta($homeID,'imic_slider_with_property',true);
    if($imic_slider_with_property==1){
      $imic_slider_image=get_post_meta($homeID,'imic_slider_image',false);
      if(count($imic_slider_image)>0){
        echo '<div class="slider-mask overlay-transparent"></div>
        <!-- Start Hero Slider -->
        <div class="hero-slider flexslider clearfix" data-autoplay='.$autoSlide.' data-pagination="no" data-arrows='.$sliderArrows.' data-style='. $sliderEffect.' data-pause="yes">';
        echo '<ul class="slides">';
        foreach ($imic_slider_image as $custom_home_image) {
          $image = wp_get_attachment_image_src($custom_home_image, '1200-500-size' ); 
          echo '<li class=" parallax" style="background-image:url('.$image[0].')">';
          echo '</li>';  
        }
        echo '</ul></div>';
      }
    }
    else if($imic_slider_with_property==2){
      $imic_select_revolution_from_list = get_post_meta($homeID, 'imic_pages_select_revolution_from_list', true);
      echo '<div class="slider-revolution-new">';
      echo do_shortcode($imic_select_revolution_from_list);
      echo '</div>';
    }
    else {
      query_posts(array('post_type'=>'property','post_status'=>'publish','posts_per_page'=>-1,'meta_query' => array(array('key' => 'imic_slide_property','value' => 1,'compare' => '=='),),)); 
	  if(have_posts()):
	  echo '<div class="slider-mask overlay-transparent"></div>
        <!-- Start Hero Slider -->
        <div class="hero-slider flexslider clearfix" data-autoplay='.$autoSlide.' data-pagination="no" data-arrows='.$sliderArrows.' data-style='. $sliderEffect.' data-pause="yes">';
      echo '<ul class="slides">';
      while(have_posts()):the_post(); 
        $image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), '1200-500-size' );
        echo '<li class=" parallax" style="background-image:url('.$image[0].')">';
        echo '<div class="flex-caption">';
        $imic_property_site_address= get_post_meta(get_the_ID(),'imic_property_site_address',true);
        if(!empty($imic_property_site_address)):
          echo '<strong class="title">'.$imic_property_site_address;
          $imic_property_site_city=get_post_meta(get_the_ID(),'imic_property_site_city',true); if(!empty($imic_property_site_city)){ echo ', <em>'.$imic_property_site_city.'</em>'; }
          echo '</strong>';
        endif;
        $imic_property_price = get_post_meta(get_the_ID(),'imic_property_price',true);
        if(!empty($imic_property_price)):
          echo '<div class="price"><strong>'.$currency_symbol.'</strong><span>'.$imic_property_price.'</span></div>';
        endif;
        echo '<a href="'.get_permalink(get_the_ID()).'" class="btn btn-primary btn-block">'.__('Details','framework').'</a>';
        echo '<div class="hero-agent">';
        $post_author_id = get_post_field( 'post_author', get_the_ID() );
        $userImg = esc_attr(get_the_author_meta('agent-image', $post_author_id)); 
        if(!empty($userImg)):
          echo '<img src="'.$userImg.'" alt="" class="hero-agent-pic"/>';
        else:
          echo '<img src="'. get_template_directory_uri() . '/images/default_agent.png" alt="" class="hero-agent-pic"/>';
        endif;
        echo '<a href="'.get_author_posts_url($post_author_id).'" class="hero-agent-contact" data-placement="left"  data-toggle="tooltip" title="" data-original-title="'.__('Contact Agent','framework').'"><i class="fa fa-envelope"></i></a>';
        echo '</div></div>';
        echo '</li>';
      endwhile;
      echo '</ul></div>';
    endif;
    wp_reset_query();
    }
  ?>
  
  <!-- Site Search Module -->
  <?php   $output = '';
  global $imic_options;
  $search_home_blocks = $imic_options['search-home-blocks']['Enabled'];
  if (count($search_home_blocks)>1):
    foreach ($search_home_blocks as $key => $value) {
      switch ($key) {
        case 'property_type':
          $output .= '<span>I want to work for a </span>';
          $args_terms = array('orderby' => 'count', 'hide_empty' => true);
          $propertyterms = get_terms('property-type', $args_terms);
          if (!empty($propertyterms)) {
            $output.= '<div class="search-field"><label class="avnt-hidden">'.__('Property Type', 'framework').'</label><select name="propery_type" class="form-control selectpicker">';
            $output .='<option>' . __(' ', 'framework') . '</option>';
            foreach ($propertyterms as $term) {
              $term_name = $term->name;
              $term_slug = $term->slug;
              $output .="<option value='" . $term_slug . "'>" . $term_name . "</option>";
            }
            $output .="</select></div>";
            $output .= "<span> startup.</span>";
          }
          break;
                case 'contract': $args_contract = array('orderby' => 'count', 'hide_empty' => true);
                        $property_contract_type_terms = get_terms('property-contract-type', $args_contract);
                        if (!empty($property_contract_type_terms)) {
                            $output.= '<div class="search-field"><label>'.__('Contract Type', 'framework').'</label><select name="propery_contract_type" class="form-control selectpicker">';
                            $output .='<option selected>' . __('Contract', 'framework') . '</option>';
                            foreach ($property_contract_type_terms as $term) {
                                $term_name = $term->name;
                                $term_slug = $term->slug;
                                $output .="<option value='" . $term_slug . "'>" . $term_name . "</option>";
                            }
                            $output .="</select></div>";
                           
                        }
                break;
                case 'location': $imic_country_wise_city = imic_get_multiple_city();
                        if (!empty($imic_country_wise_city)) {
                            $output .='<div class="search-field"><label>'.__('State', 'framework').'</label><select name="propery_location" class="form-control selectpicker">
                          <option selected>' . __('State', 'framework') . '</option>';
                            foreach ($imic_country_wise_city as $key => $value) {
								if(is_int($key)) { $output .= '<optgroup label="'.$value.'">'; }
								else {
                                $output .="<option value='" . $key . "'>" . $value . "</option>"; }
                            }
                            $output .='</select></div>';
                        }
                break;
                case 'baths':
                         $output .= '<div class="search-field"><label>' . __('Min Baths', 'framework') . '</label>
                              <select name="baths" class="form-control selectpicker">';
                         $output .='<option selected>' . __('Any', 'framework') . '</option>';
                            $baths_options = $imic_options['properties_baths'];
    						foreach ($baths_options as $baths) {
                                $output .= "<option value='" . $baths . "'>" . $baths . "</option>";
                            }
                         $output .='</select></div>';
                break;
                case 'city':
                        $args_c = array('orderby' => 'count', 'hide_empty' => true);
                        $terms = get_terms(array('city-type'), $args_c);
                        if (!empty($terms)) {
                            $output .= '<div class="search-field"><label>'.__('City', 'framework').'</label><select name="property_city" class="form-control selectpicker">
                    <option selected>' . __('City', 'framework') . '</option>';
                            foreach ($terms as $term_data) {
                                $output .= "<option value='" . $term_data->slug . "'>" . $term_data->name . "</option>";
                            }
                            $output .='</select></div>';
                        }
                break;
                case 'beds':
                        $output .= '<div class="search-field"><label>' . __('Min Beds', 'framework') . '</label>
                                <select name="beds" class="form-control selectpicker">';
                        $output .='<option selected>' . __('Any', 'framework') . '</option>';
                        $beds_options = $imic_options['properties_beds'];
    					foreach ($beds_options as $beds) {
                            $output .= "<option value='" . $beds . "'>" . $beds . "</option>";
                        }
                        $output .='</select></div>';
                break;
                case 'price':
                        $output .= '<div class="search-field"><label>' . __('Min Price', 'framework') . '</label>
                                <select name="min_price" class="form-control selectpicker">';
                        $output .='<option selected>' . __('Any', 'framework') . '</option>';
                        $m_price_value = $imic_options['properties_price_range'];
                        foreach ($m_price_value as $price_value) {
                            $output .= "<option value='" . $price_value . "'>" . $currency_symbol . " " . $price_value . "</option>";
                        }
                        $output .='</select></div>';
                        $output .= '<div class="search-field">
                            <label>' . __('Max Price', 'framework') . '</label>
                            <select name="max_price" class="form-control selectpicker">';
                        $output .='<option selected>' . __('Any', 'framework') . '</option>';
                        $max_price_value = $imic_options['properties_price_range'];
                        foreach ($max_price_value as $price_value) {
                            $output .= "<option value='" . $price_value . "'>" . $currency_symbol . " " . $price_value . "</option>";
                        }
                        $output .='</select>
                            </div>';
                    break;
                    case 'area':
                        $output .= '<div class="search-field">
                                <label>' . __('Min Area (Sq Ft)', 'framework') . '</label>
                                <input type="text" name="min_area" class="form-control input-lg" placeholder="' . __('Any', 'framework') . '">
                            </div>
                            <div class="search-field">
                                <label>' . __('Max Area (Sq Ft)', 'framework') . '</label>
                                <input type="text" name="max_area" class="form-control input-lg" placeholder="' . __('Any', 'framework') . '">
                            </div>';
                    break;
                    case 'search_by':
                        $output .= '<div class="search_by">
                            <div class="search-field">
                                <label>' . __('Search By', 'framework') . '</label>
                                <select name="search_by" class="form-control selectpicker">';
                        $output .='<option selected>' . __('Search By', 'framework') . '</option>';
                        $output .= "<option value='Id'>" . __('Id', 'framework') . "</option>";
                        $output .= "<option value='Address'>" . __('Address', 'framework') . "</option>";
                        $output .= "<option value='Pincode'>" . __('Pincode', 'framework') . "</option>";
                        $output .='</select>
                            </div>
                            <div class="search-field">';
                        $output .='<label>' . __('Keyword', 'framework') . '</label>
                             	<input type="text" name="search_by_keyword" class="form-control input-lg search_by_keyword" placeholder="' . __('Please enter ', 'framework') . '">
                            </div>
                            </div>';
                    break;
                }
            }
	
	
	
?>
    <div class="site-search-module">
        <div class="container">
            <div class="site-search-module-inside">
                <form method="get" action="<?php echo home_url(); ?>/">
                    <input type="hidden" class="form-control" name="s" id="s" value="<?php _e('Search1', 'framework'); ?>" />
                    <div class="row">
                    
                            <?php
                            echo '<div class="col-md-8 search-fields">';
							echo $output;
							
							echo '</div><div class="col-md-4 search-buttons"><div class="search-button"> <button type="submit" class="btn btn-primary btn-block btn-lg"><i class="fa fa-search"></i> '.__('Search','framework').' </button> </div>';
							echo '<div class="search-button avnt-hidden"> <a href="#" id="ads-trigger" class="btn btn-default btn-block"><i class="fa fa-plus"></i> <span>'.__('Advanced','framework').'</span></a> </div></div>';
							?>
                             </div>
                </form>
            </div>
        </div>
    </div>
    
         
    <?php endif; ?>
    </div>
   
   <!-- Start Content -->
          <?php
		  echo '<div class="main" role="main">';
          echo '<div class="container">';
		  echo '<div class="row">';
		  echo '<div class="col-md-12 col-sm-12">';
		  if(have_posts()):while(have_posts()):the_post();
		  the_content();
		  endwhile; endif;
		  echo '</div></div></div></div>';
          echo '<div class="main" id="avnt-homepage" role="main">';
          echo '<div id="content" class="content full">';
          global $imic_options; 
          if(isset($imic_options['opt-slides'])){
            $fblocks= $imic_options['opt-slides']; 
          }else{
              $fblocks='';
          }
          if(!empty($fblocks[0]['title'])){  echo '<div class="featured-blocks"><div class="container"><div class="row">';
          foreach($fblocks as $fblock) { $link=$link_close=''; if($fblock['url']!='') { $link = '<a href="'.$fblock['url'].'">'; $link_close = '</a>'; }  echo $link;
            echo '<div class="col-md-4 col-sm-4 featured-block">';
          if(!empty($fblock['image'])){
                echo '<img alt="featured block" src="'.$fblock['image'].'" class="img-thumbnail">';
            }
            if(!empty($fblock['title'])){
            echo '<h3>'.$fblock['title'].'</h3>';
            }
            if(!empty($fblock['description'])){
                echo $fblock['description'];
            }
            echo '</div>';
            echo $link_close; } echo '</div></div></div><div class="spacer-40"></div>'; } ?>
      <?php $Featured_List = get_post_meta(get_the_ID(),'imic_home_featured_section',true); 
	  if($Featured_List==1) { 
       echo '<div id="featured-properties">
        <div class="container">';
//            echo '<div class="row">
//            <div class="col-md-12">
//              <div class="block-heading">';
//            $imic_home_featured_heading=get_post_meta(get_the_ID(),'imic_home_featured_heading',true);
//            $imic_home_featured_heading=!empty($imic_home_featured_heading)?$imic_home_featured_heading:__('Featured Section Heading','framework');
//           echo '<h4><span class="heading-icon"><i class="fa fa-star"></i></span>'.$imic_home_featured_heading.'</h4>';
//           echo ' </div></div></div>';
          echo '<h2>Featured Projects</h2>';
           query_posts(array('post_type'=>'property','post_status'=>'publish','posts_per_page'=>-1,'meta_query' => array(array('key' => 'imic_featured_property','value' => 1,'compare' => '=='),),)); 
			  if(have_posts()): ?>
                              <?php $data_rtl = ($imic_options['enable_rtl'] == 1)?'data-rtl="rtl"':'';
echo '<div class="row"><ul class="owl-carousel owl-alt-controls" data-columns="4" data-autoplay="no" data-pagination="no" data-arrows="yes" data-single-item="no" '.$data_rtl.'>';
                              while(have_posts()):the_post();
							  $property_images = get_post_meta(get_the_ID(),'imic_property_sights',false);
								$total_images = count($property_images);
                           echo '<li class="item property-block">';
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
                          } echo '<div class="container avnt-hidden">'; 
                        $Recent_List = get_post_meta(get_the_ID(),'imic_home_recent_section',true); 
                        $sidebar = get_post_meta(get_the_ID(),'imic_select_sidebar_from_list',false); 
                         $class = (empty($sidebar)||!is_active_sidebar($sidebar[0]))?12:9;
                        if($Recent_List==1) {
                        echo'<div class="row"><div class="col-md-'.$class.'"><div class="block-heading">';
                    $imic_home_recent_heading=get_post_meta(get_the_ID(),'imic_home_recent_heading',true);
                    $imic_home_recent_heading=!empty($imic_home_recent_heading)?$imic_home_recent_heading:__('Recent Listed','framework');
                    echo '<h4><span class="heading-icon"><i class="fa fa-leaf"></i></span>'.$imic_home_recent_heading.'</h4>';
                     $imic_home_recent_more=get_post_meta(get_the_ID(),'imic_home_recent_more',true);
                     if(!empty($imic_home_recent_more)){
                   echo '<a href="'.$imic_home_recent_more.'" class="btn btn-primary btn-sm pull-right">'.__('View more properties ','framework').'<i class="fa fa-long-arrow-right"></i></a>';   
                    } 
                  echo ' </div><div class="property-listing">';
                  $Recent_Page = get_post_meta(get_the_ID(),'imic_home_recent_property_no',true);
			  query_posts(array('post_type'=>'property','post_status'=>'publish','posts_per_page'=>$Recent_Page)); 
			  if(have_posts()):
                              echo '<ul>';
                          while(have_posts()):the_post(); 
				$property_images = get_post_meta(get_the_ID(),'imic_property_sights',false);
								$total_images = count($property_images);
								$property_area = get_post_meta(get_the_ID(),'imic_property_area',true); 
			  $property_baths = get_post_meta(get_the_ID(),'imic_property_baths',true);
			  $property_beds = get_post_meta(get_the_ID(),'imic_property_beds',true);
			  $property_parking = get_post_meta(get_the_ID(),'imic_property_parking',true); 
			  $property_address = get_post_meta(get_the_ID(),'imic_property_site_address',true);
			  $property_city = get_post_meta(get_the_ID(),'imic_property_site_city',true);
			  $property_price = get_post_meta(get_the_ID(),'imic_property_price',true); 
			  $contract = wp_get_object_terms( get_the_ID(), 'property-contract-type', array('fields'=>'ids')); 
                         if(!empty($contract)) {
			  $term = get_term( $contract[0], 'property-contract-type' ); }
                          echo '<li class="type-rent col-md-12">';
                          if(has_post_thumbnail()):
                          echo '<div class="col-md-4">
                    		<a href="'.get_permalink().'" class="property-featured-image">';
                             the_post_thumbnail('600-400-size');
                            	echo'<span class="images-count"><i class="fa fa-picture-o"></i> '.$total_images.'</span>';
                            	if(!empty($term)) { echo'<span class="badges">'.$term->name.'</span>'; }
                       	echo'</a>
                   	</div>';
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
                               echo '<div class="col-md-8">';
                               if(true){
                                echo '<div class="property-info">';
                                 if(!empty($imic_property_price)){
                              echo '<div class="price"><strong>'.$currency_symbol.'</strong><span>'.$imic_property_price.'</span></div>';
                          }
                            echo '<h3><a href="'.get_permalink().'">'.get_the_title().'</a>'.imicPropertyId(get_the_ID()).'</h3>'; 
                          if(!empty($imic_property_site_city)){
                            echo '<a class="accent-color" data-original-title="'.$sl.'" data-toggle="tooltip" style="cursor:default; text-decoration:none;" href="javascript:void(0);"><span class="location">'.$imic_property_site_city.'</span></a>';  
                          }
                          echo imic_excerpt(10);
                          echo '</div>';
  }
                          $imic_property_area= get_post_meta(get_the_ID(),'imic_property_area',true);
                          $imic_property_baths= get_post_meta(get_the_ID(),'imic_property_baths',true);
                          $imic_property_beds= get_post_meta(get_the_ID(),'imic_property_beds',true);
                          $imic_property_parking= get_post_meta(get_the_ID(),'imic_property_parking',true);
                           if(!empty($imic_property_area)||!empty($imic_property_baths)||!empty($imic_property_beds)||!empty($imic_property_parking)):
                          echo '<div class="property-amenities clearfix">';
                          if(!empty($imic_property_area)):
                             echo '<span class="area">'.$imic_property_area.'<strong></strong>'.__('Area','framework').'</span>'; 
                          endif;
                          if(!empty($imic_property_baths)):
                            echo '<span class="baths"><strong>'.$imic_property_baths.'</strong>'.__('Baths','framework').'</span>';  
                          endif;
                          if(!empty($imic_property_beds)):
                            echo '<span class="beds"><strong>'.$imic_property_beds.'</strong>'.__('Beds','framework').'</span>';  
                          endif;
                          if(!empty($imic_property_parking)):
                              echo '<span class="parking"><strong>'.$imic_property_parking.'</strong>'.__('Parking','framework').'</span>';
                          endif;
                          echo '</div>';
                          endif;
                         echo '</div></li>';
                       endwhile;
                       echo '</ul>';
                      endif;
                      echo '</div></div>';
             }
//            -- Start Sidebar --
             if(!empty($sidebar)&&is_active_sidebar($sidebar[0])) { 
                      echo '<div class="sidebar right-sidebar col-md-3">';
                      dynamic_sidebar($sidebar[0]);
                      echo '</div>';
                      }
            echo '</div></div>';
                 $Partner_Heading = get_post_meta($homeID,'imic_home_partner_heading',true); 
                        $Partner_Heading_Url = get_post_meta($homeID,'imic_home_partner_url',true);
                        $Partner_Section = get_post_meta($homeID,'imic_home_partners_section',true);
                        $Partner_Heading=!empty($Partner_Heading)?$Partner_Heading:__('Our Partners','framework');
                        if($Partner_Section!=0) { echo '<div class="container"><div class="block-heading">'; 
                        echo '<h4><span class="heading-icon"><i class="fa fa-users"></i></span>'.$Partner_Heading.'</h4>';
                        if($Partner_Heading_Url!='') {
                        echo '<a href="'.$Partner_Heading_Url.'" class="btn btn-primary btn-sm pull-right">'.__('All partners ','framework').'<i class="fa fa-long-arrow-right"></i></a>';
                        } 
                        echo '</div>';
                        query_posts(array('post_type'=>'partner','posts_per_page'=>-1));
			if(have_posts()):
                            echo '<div class="row">' ?>
                            <?php $data_rtl = ($imic_options['enable_rtl'] == 1)?'data-rtl="rtl"':'';
echo '<ul class="owl-carousel owl-alt-controls" data-columns="4" data-autoplay="no" data-pagination="no" data-arrows="no" data-single-item="no" '.$data_rtl.'>';
                            while(have_posts()):the_post(); 
                            $partner_logo = get_post_meta(get_the_ID(),'imic_partner_logo',true);
                            $partner_url = get_post_meta(get_the_ID(),'imic_partner_url',true);
                            if(!empty($partner_logo)) {
                            $userLoadedImgSrc = wp_get_attachment_image_src($partner_logo, '140-47-size');
                            $userImgSrc = $userLoadedImgSrc[0];
                            }
                            $target = get_post_meta(get_the_ID(),'imic_partner_target',true); 
                            if($target==1) { $target = "self"; } else{ $target = "blank"; }
                            if($partner_url!='') {
                                echo '<li class="item"> <a href="'.$partner_url.'" target="_'.$target.'"><img src="'.$userImgSrc.'" alt=""></a> </li>'; } else { 
                                echo '<li class="item"> <img src="'.$userImgSrc.'" alt=""></li>';  
                                    } endwhile; echo '</ul></div>';
                            endif; wp_reset_query();
                            echo '</div>'; } echo '</div>'; ?>

                    <div id="avnt-about" class="container">
                      <h2>Avaant is simple.</h2>
                      <div class="row">
                        <div class="col-md-4 col-sm-4">
                          <h3>1</h3>
                          <p>
                            It all starts when you sign-up and build your profile. With Avaant, your profile is more than a resume, it's a portfolio of your ambitions, personality, and passions.
                          </p>
                        </div>
                        <div class="col-md-4 col-sm-4">
                          <h3>2</h3>
                          <p>
                            Using your profile, discover exciting ideas and projects around you. Apply for and join the positions you love.
                          </p>
                        </div>
                        <div class="col-md-4 col-sm-4">
                          <h3>3</h3>
                          <p>
                            Have an idea? Create a project page and showcase your vision. Display what you are comfortable with and decide who and what skills are needed to help realize your goal.
                          </p>
                        </div>
                      </div>
                      </div>

<?php
                            get_footer(); ?>