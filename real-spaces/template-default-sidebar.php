<?php 
/*
Template Name: with default sidebar
*/
get_header();  
global $imic_options; //Theme Global Variable
/* Page Banner HTML
=============================*/
imic_page_banner($pageID = get_the_ID()); ?>
  <!-- Start Content -->
  <div class="main" role="main">
      <div id="content" class="content full">
          <div class="container">
              <div class="row">
              <div class="col-md-9">
                  <?php if(have_posts()):while(have_posts()):the_post();
				  the_content();
				  endwhile; endif; ?>
                  </div>
                  <!-- Start Sidebar -->
                  <div class="sidebar right-sidebar col-md-3">
                      <?php dynamic_sidebar('inner-sidebar'); ?>
                  </div> 
                  </div> 
              </div>
          </div>
      </div>
  </div>
<?php get_footer(); ?>