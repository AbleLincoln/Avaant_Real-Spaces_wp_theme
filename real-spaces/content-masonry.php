<?php
/**
 * The template used for displaying post in masonry design
*/
?>
<?php $post_format = get_post_format(get_the_ID());
global $more; $more=0;
$cats = get_the_category();
//Content for gallery post format
if($post_format=='gallery') {
$slider_pagination = get_post_meta(get_the_ID(),'imic_gallery_slider_pagination',true);
$slider_auto_slide = get_post_meta(get_the_ID(),'imic_gallery_slider_auto_slide',true);
$slider_arrows = get_post_meta(get_the_ID(),'imic_gallery_slider_direction_arrows',true);
$slider_effect = get_post_meta(get_the_ID(),'imic_gallery_slider_effects',true); ?>
<li class="grid-item post format-<?php echo get_post_format(); ?>">
              <?php $post_gallery_ids = get_post_meta(get_the_ID(),'imic_gallery_images',false); ?>
                <div class="grid-item-inner">
                  <div class="media-box">
                  <?php if(count($post_gallery_ids)>0) { ?>
                    <div class="flexslider" data-autoplay="<?php echo $slider_auto_slide; ?>" data-pagination="<?php echo $slider_pagination; ?>" data-arrows="<?php echo $slider_arrows; ?>" data-style="<?php echo $slider_effect; ?>" data-pause="yes">
                      <ul class="slides">
                      <?php foreach($post_gallery_ids as $post_gallery_id) { 
					  			$image = wp_get_attachment_image_src($post_gallery_id,'600-400-size'); ?>
                        <li class="item"><a href="<?php echo $image[0]; ?>" data-rel="prettyPhoto[postname-<?php get_the_ID(); ?>]"><img src="<?php echo $image[0]; ?>" alt=""></a></li>
                        <?php } ?>
                      </ul>
                    </div>
                    <?php } ?>
                  </div>
                  <div class="grid-content">
                    <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                    <span class="meta-data"><span><i class="fa fa-calendar"></i> <?php echo get_the_date(); ?></span><?php if($cats){ ?><span><a href="<?php echo get_category_link($cats[0]->term_id);  ?>"><i class="fa fa-tag"></i><?php echo $cats[0]->name; ?></a></span><?php } ?></span> 
                    <?php if ( ! has_excerpt() ) { the_content(); } else { the_excerpt(); } ?>
                    </div>
                </div>
              </li>
              <?php //Content for link post format
			  	} elseif($post_format=='link') {  ?>
              <li class="grid-item post format-<?php echo $post_format; ?>">
              <?php $post_link_url = get_post_meta(get_the_ID(),'imic_gallery_link_url',true); 
			  		if ( '' != get_the_post_thumbnail() ) { ?>
                <div class="grid-item-inner"> <a href="<?php $image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()),'full'); echo $image[0]; ?>" data-rel="prettyPhoto" class="media-box"> <?php the_post_thumbnail('600-400-size'); ?> </a><?php } ?>
                  <div class="grid-content">
                    <h4><a href="<?php echo $post_link_url; ?>"><?php the_title(); ?></a></h4>
                    <span class="meta-data"><span><i class="fa fa-calendar"></i> <?php echo get_the_date(); ?></span><?php if($cats){ ?><span><a href="<?php echo get_category_link($cats[0]->term_id);  ?>"><i class="fa fa-tag"></i><?php echo $cats[0]->name; ?></a></span><?php } ?></span>
                  </div>
                </div>
              </li>
              <?php //Content for quote post format
			  	} elseif($post_format=='quote') { ?>
              <li class="grid-item post format-<?php echo $post_format; ?>">
                <div class="grid-item-inner">
                  <div class="grid-content">
                    <?php if ( ! has_excerpt() ) { the_content(); } else { the_excerpt(); } ?>
                    <span class="meta-data"><span><i class="fa fa-calendar"></i> <?php echo get_the_date(); ?></span><?php if($cats){ ?><span><a href="<?php echo get_category_link($cats[0]->term_id);  ?>"><i class="fa fa-tag"></i><?php echo $cats[0]->name; ?></a></span><?php } ?></span>
                  </div>
                </div>
              </li>
              <?php //Content for image and other post formats
			  	} else { ?>
<li class="grid-item post format-<?php echo get_post_format(get_the_ID()); ?>">
                <div class="grid-item-inner"> <?php if ( '' != get_the_post_thumbnail() ) { ?><a href="<?php $image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()),'full'); echo $image[0]; ?>" data-rel="prettyPhoto" class="media-box"> <?php the_post_thumbnail('600-400-size'); ?> </a><?php } ?>
                  <div class="grid-content">
                    <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                    <span class="meta-data"><span><i class="fa fa-calendar"></i> <?php echo get_the_date(); ?></span><?php if($cats){ ?><span><a href="<?php echo get_category_link($cats[0]->term_id);  ?>"><i class="fa fa-tag"></i><?php echo $cats[0]->name; ?></a></span><?php } ?></span>
                    <?php if ( ! has_excerpt() ) { the_content(); } else { the_excerpt(); } ?>
                  </div>
                </div>
              </li>
              <?php } ?>