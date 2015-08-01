<?php
get_header(); ?>
<!-- Site Showcase -->
<?php
/* Page Banner HTML
=============================*/
//Banner Image
$contactBanner = '';
if(!empty($imic_options['banner_image']['url'])){
$contactBanner = $imic_options['banner_image']['url'];	?>
 <!-- Site Showcase -->
  <div class="site-showcase">
    <!-- Start Page Header -->
    <div class="parallax page-header" style="background-image:url(<?php echo $contactBanner; ?>);">
          <div class="container">
              <div class="row">
                  <div class="col-md-12">
                      <h1><?php echo single_term_title("", false); ?></h1>
                  </div>
             </div>
         </div>
    </div>
    <!-- End Page Header -->
  </div>
<?php }
global $imic_options;
$currency_symbol = imic_get_currency_symbol($imic_options['currency-select']); 
$listing_url = imic_get_template_url('template-property-listing.php'); ?>
 <!-- Start Content -->
  <div class="main" role="main">
      <div id="content" class="content full">
          <div class="container">
              <div class="row">
              <?php if(is_active_sidebar('')) { ?>
                  <div class="col-md-9"><?php } else { ?>
                  <div class="col-md-12"><?php } ?>
                      <div class="block-heading">
                          <a href="<?php echo $listing_url; ?>" class="btn btn-primary btn-sm pull-right"><?php _e('View all types ','framework'); ?><i class="fa fa-long-arrow-right"></i></a>
                          <h4><span class="heading-icon"><i class="fa fa-home"></i></span><?php echo single_term_title("", false); ?></h4>
                      </div>
                    <div class="property-grid">
                      <ul class="grid-holder col-3">
                      <?php if(have_posts()):while(have_posts()):the_post();
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
								  $property_area_location = wp_get_object_terms(get_the_ID(), 'city-type');
								   $sl = '';
								   $total_area_location = count($property_area_location);
								   $num = 1;
								   foreach($property_area_location as $sa) {
								   $conc = ($num!=$total_area_location)?'->':'';
								   $sl .= $sa->name.$conc; $num++; } 
								  if(!empty($contract)) {
								  $term = get_term( $contract[0], 'property-contract-type' ); $contract_name = $term->name; } ?>
                        <li class="grid-item type-<?php echo $contract_name; ?>">
                          <div class="property-block"><?php if ( '' != get_the_post_thumbnail() ) { ?><a href="<?php the_permalink(); ?>" class="property-featured-image"> <?php the_post_thumbnail('600-400-size'); ?> <span class="images-count"><i class="fa fa-picture-o"></i> <?php echo $total_images; ?></span> <span class="badges"><?php echo $contract_name; ?></span> </a><?php } ?>
                            <div class="property-info">
                              <h4><a href="<?php the_permalink(); ?>"><?php echo get_the_title(); ?></a><?php echo imicPropertyId(get_the_ID()); ?></h4>
                              <?php echo '<a class="accent-color" data-original-title="'.$sl.'" data-toggle="tooltip" style="cursor:default; text-decoration:none;" href="javascript:void(0);"><span class="location sort_by_location">'.$property_city.'</span></a><br>';  ?>
                              <div class="price"><strong><?php echo $currency_symbol; ?></strong><span><?php echo $property_price; ?></span></div>
                            </div>
                            <div class="property-amenities clearfix"> <span class="area"><strong><?php echo $property_area; ?></strong><?php _e('Area','framework'); ?></span> <span class="baths"><strong><?php echo $property_baths; ?></strong><?php _e('Baths','framework'); ?></span> <span class="beds"><strong><?php echo $property_beds; ?></strong><?php _e('Beds','framework'); ?></span> <span class="parking"><strong><?php echo $property_parking; ?></strong><?php _e('Parking','framework'); ?></span> </div>
                          </div>
                        </li>
                        <?php endwhile; endif; ?>
                      </ul>
                    </div>
                   <?php pagination(); ?>
                  </div>
                  <!-- Start Sidebar -->
                  <?php if(is_active_sidebar('')) { ?>
                  <div class="sidebar right-sidebar col-md-3">
                      <?php dynamic_sidebar('inner-sidebar'); ?>
                  </div> 
                  <?php } ?> 
              </div>
          </div>
      </div>
  </div>
<?php get_footer(); ?>