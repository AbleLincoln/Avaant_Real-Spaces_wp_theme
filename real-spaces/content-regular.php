<?php
/**
 * The template used for displaying post in classic design
 */
?>
<?php
$post_format = get_post_format();
if($post_format=='link') { 
$post_link_url = get_post_meta(get_the_ID(),'imic_gallery_link_url',true); } else { $post_link_url = get_permalink(); } ?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> class="post format-<?php echo get_post_format(); ?>">
              <div class="row">
              <?php if ( '' != get_the_post_thumbnail() ) { $class = 4; $content_class = 8; ?>
                <div class="col-md-<?php echo $class; ?> col-sm-<?php echo $class; ?>"> <a href="<?php echo $post_link_url; ?>"><?php the_post_thumbnail('600-400-size',array('class'=>'img-thumbnail')); ?></a> </div><?php } else { $content_class = 12; } ?>
                <div class="col-md-<?php echo $content_class; ?> col-sm-<?php echo $content_class; ?>">
                  <h3><a href="<?php echo $post_link_url; ?>"><?php the_title(); ?></a></h3>
                  <span class="post-meta meta-data"> <span><i class="fa fa-calendar"></i> <?php echo get_the_date(); ?></span><span><i class="fa fa-archive"></i> <?php the_category(', '); ?></span> <span><?php comments_popup_link('<i class="fa fa-comment"></i>'.__('No comments yet','framework'), '<i class="fa fa-comment"></i>1', '<i class="fa fa-comment"></i>%', 'comments-link',__('Comments are off for this post','framework')); ?></span></span>
                  <?php if($post_format!='link') { if ( ! has_excerpt() ) { the_content(); } else { the_excerpt(); } ?>
                  <p><a href="<?php the_permalink(); ?>" class="btn btn-primary"><?php _e('Continue reading ','framework'); ?><i class="fa fa-long-arrow-right"></i></a></p><?php } ?>
                </div>
              </div>
            </article>