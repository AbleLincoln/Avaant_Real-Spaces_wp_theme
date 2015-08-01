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
              <div class="col-md-<?php echo $class; ?>">
                  <?php if(have_posts()):while(have_posts()):the_post();
				  the_content();
					if ($imic_options['switch_sharing'] == 1 && $imic_options['share_post_types']['2'] == '1') {
						imic_share_buttons();
					}
				  endwhile; endif; ?>
                  </div>
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