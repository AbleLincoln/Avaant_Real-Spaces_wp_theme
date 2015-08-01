<?php get_header(); 
/* Page Banner HTML
=============================*/
$blog_id = get_option('page_for_posts');
imic_page_banner($pageID = $blog_id);
$sidebar = get_post_meta($blog_id,'imic_select_sidebar_from_list',false); 
$class = (empty($sidebar)||!is_active_sidebar($sidebar[0]))?12:9; 
?>
<!-- Start Content -->
  <div class="main" role="main">
    <div id="content" class="content full">
      <div class="container">
      <div class="row">
          <div class="col-md-<?php echo $class; ?> posts-archive">
        <?php if(have_posts()):while(have_posts()):the_post();
				get_template_part( 'content', 'regular' );
				endwhile;
				else:
				get_template_part( 'content', 'none' );
				endif;
				if(function_exists('pagination')) { pagination(); } else { next_posts_link(); previous_posts_link(); } ?>
                </div>
       <?php if(!empty($sidebar)&&is_active_sidebar($sidebar[0])) { ?>
                  <div class="sidebar right-sidebar col-md-3">
                      <?php dynamic_sidebar($sidebar[0]); ?>
                  </div> 
                  <?php } ?> 
      </div>
    </div>
  </div>
<?php get_footer(); ?>