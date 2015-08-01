<?php get_header(); 
/* Page Banner HTML
=============================*/
imic_page_banner($pageID = get_the_ID());
$image = '';
$sidebar = get_post_meta(get_the_ID(),'imic_select_sidebar_from_list',false); 
$class = (empty($sidebar)||!is_active_sidebar($sidebar[0]))?12:9;
$thumb_size = (empty($sidebar)||!is_active_sidebar($sidebar[0]))?'full':'600-400-size';
$post_format = get_post_format(get_the_ID());
if($post_format=='gallery') {
$image = get_post_meta(get_the_ID(),'imic_gallery_images',true);
$image = wp_get_attachment_image_src($image,$thumb_size,true);
$image = $image[0];
}
else {
if ( '' != get_the_post_thumbnail() ) {
$image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()),$thumb_size);
$image = $image[0]; }
} ?>
<div class="main" role="main">
    <div id="content" class="content full">
      <div class="container">
        <div class="row">
          <div class="col-md-<?php echo $class; ?>">
            <header class="single-post-header clearfix">
            <?php while(have_posts()):the_post(); ?>
              <h2 class="post-title"><?php the_title(); ?></h2>
            </header>
            <article class="post-content">
                  <div class="post-meta meta-data">
                      <span><i class="fa fa-calendar"></i><?php _e(' Posted on ','framework'); echo get_the_date(); ?></span>
                      <span><i class="fa fa-user"></i><?php _e(' By ','framework'); $author_id = $post->post_author;
the_author_meta('user_nicename', $author_id); ?></span>
                    <span><i class="fa fa-tag"></i><?php _e(' Categories: ','framework'); ?><?php the_category(', '); ?></span>
                    <span><?php comments_popup_link('<i class="fa fa-comment"></i>'.__('No comments yet','framework'), '<i class="fa fa-comment"></i>1', '<i class="fa fa-comment"></i>%', 'comments-link',__('Comments are off for this post','framework')); ?></span>
                </div>
                <?php if ( '' != get_the_post_thumbnail() ) { ?>
              <div class="featured-image"> <img src="<?php echo $image; ?>" alt=""> </div>
              <?php } the_content();
					if ($imic_options['switch_sharing'] == 1 && $imic_options['share_post_types']['1'] == '1') {
						imic_share_buttons();
					}
			  
			  
			   wp_link_pages();
			   endwhile;
              if (has_tag()) {
                    echo'<div class="post-meta">';
                    echo'<i class="fa fa-tags"></i>';
                    the_tags('', ', ');
                    echo'</div>';
                } ?>
            </article>
            <?php comments_template('', true); ?> 
          </div>
          <!-- Start Sidebar -->
           <?php if(!empty($sidebar)&&is_active_sidebar($sidebar[0])) { ?>
                  <div class="sidebar col-md-3">
                      <?php dynamic_sidebar($sidebar[0]); ?>
                  </div> 
                  <?php } else { ?>
					<?php dynamic_sidebar("Post Sidebar") ?>  
				 <?php } ?> 
        </div>
      </div>
    </div>
  </div>
<?php get_footer(); ?>