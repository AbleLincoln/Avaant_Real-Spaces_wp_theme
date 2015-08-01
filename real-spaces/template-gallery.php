<?php
/*
  Template Name: Gallery
 */
get_header();
/* Site Showcase */
imic_page_banner($pageID = get_the_ID());
/* End Site Showcase */
$imic_gallery_images = get_post_meta(get_the_ID(),'imic_gallery_images',false);
$imic_gallery_pagination_columns_layout = get_post_meta(get_the_ID(),'imic_gallery_pagination_columns_layout',true);
$imagesPerPage = get_post_meta(get_the_ID(),'imic_gallery_pagination_to_show_on',true);
$imagesPerPage = (!empty($imagesPerPage))?$imagesPerPage:6;
$imic_gallery_type = get_post_meta(get_the_ID(),'imic_gallery_type',true);
$imic_gallery_image_size = ($imic_gallery_type==0)?'600-400-size':'full';
$imic_gallery_types = ($imic_gallery_type==0)?'<ul class="gallery-listed">':'<div class="col-md-12"><ul class="grid-holder col-3">';
$imic_gallery_closing_div = ($imic_gallery_type==0)?'':'</div></div>';
if ($imic_gallery_pagination_columns_layout == 3) {
    $class = 'col-md-4 col-sm-4';
} elseif ($imic_gallery_pagination_columns_layout == 4) {
    $class = 'col-md-3 col-sm-3';
} else {
    $class = 'col-md-6 col-sm-6';
} 
$noclass = '';
$class = ($imic_gallery_type==0)?$class:$noclass; ?>
    <div class="main" role="main">
    <div id="content" class="content full">
      <div class="container">
        <div class="row">
    <?php echo $imic_gallery_types;
        $imageCount = count($imic_gallery_images);
	$pageCount = ceil($imageCount / $imagesPerPage);
	$currentPage = '';
	$currentPage = get_query_var('paged')?get_query_var('paged'):1;
	$maxImage = $currentPage * $imagesPerPage;
	$minImage = ($currentPage-1) * $imagesPerPage; ?>
    <?php $k = 0; foreach($imic_gallery_images as $image) {
		if ($k >= $minImage && $k < $maxImage) {
		$image_src = wp_get_attachment_image_src($image,$imic_gallery_image_size);
	echo '<li class="' . $class . ' grid-item post format-image">';
            echo'<div class="grid-item-inner">';
			echo '<a href="' . $image_src[0] . '" data-rel="prettyPhoto[' . get_the_ID() . ']" class="media-box">';
                            echo '<img src="'.$image_src[0].'">';
                            echo'</a>';
            echo '</div>
                </li>'; 
	} $k++; } ?>
        </ul>
					<?php if ($imic_options['switch_sharing'] == 1 && $imic_options['share_post_types']['2'] == '1') {
						imic_share_buttons();
					} ?>
    
    <?php echo ($imic_gallery_type==0)?'</div>':''; 
	echo '<div class="text-align-center">'; 
	pagination($pageCount,$imagesPerPage); 
	echo '</div>'; 
	echo $imic_gallery_closing_div;
    echo '</div>';
echo'</div>';
get_footer(); ?>