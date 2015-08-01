<?php
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
?>