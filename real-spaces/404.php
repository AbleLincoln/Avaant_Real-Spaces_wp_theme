<?php
header("HTTP/1.1 404 Not Found");
header("Status: 404 Not Found");
get_header();
//Global Theme Options Variable
global $imic_options;
//Banner Image from Theme Options
if(!empty($imic_options['banner_image']['url'])) {
?>
  <!-- Site Showcase -->
  <div class="site-showcase">
  <!-- Start Page Header -->
  <div class="parallax page-header" style="background-image:url(<?php echo $imic_options['banner_image']['url']; ?>);">
  		<div class="container">
        	<div class="row">
            	<div class="col-md-12">
  					<h1><?php _e('404 Error','framework'); ?></h1>
        		</div>
           </div>
       </div>
  </div>
  <!-- End Page Header -->
  </div>
  <?php } ?>
  <!-- Start Content -->
  <div class="main" role="main">
      <div id="content" class="content full">
        	<div class="container">
          		<div class="page error-404">
        			<div class="row">
                  	<div class="col-md-12">
                    	<h2><i class="fa fa-exclamation-triangle"></i> <?php _e('404','framework'); ?></h2>
                  		<p><?php _e('Sorry, the page you are looking for cannot be found! Trying search for a page or return to the <a href="' .site_url(). '">home</a>.','framework'); ?></p>
                    	</div>
                  </div>
        		</div>
      		</div>
    	</div>
  </div>
<?php get_footer(); ?>