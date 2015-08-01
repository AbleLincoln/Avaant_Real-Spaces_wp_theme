<?php global $imic_options; ?>  
<!-- Start Site Footer -->
<?php 
/* Footer Columns Sidebar
===========================*/
if ( is_active_sidebar('footer-sidebar') ) {
$footer_sidebar_background_color='';
if(isset($imic_options['footer_sidebar_background_color'])&&!empty($imic_options['footer_sidebar_background_color'])){
$footer_sidebar_background_color='style="background-color: '.$imic_options['footer_sidebar_background_color'].'"';
}
?>
<footer class="site-footer" <?php echo $footer_sidebar_background_color; ?>>
<div class="container">
<div class="row">
<?php dynamic_sidebar('footer-sidebar'); ?>
</div>
</div>
</footer>
<?php }
$footer_style='';
if(isset($imic_options['footer_background_color'])&&!empty($imic_options['footer_background_color'])){
$footer_style='style="background-color: '.$imic_options['footer_background_color'].'"';
}
?>
<footer class="site-footer-bottom" <?php echo $footer_style; ?>>
<div class="container">
<div class="row">
<?php
/* Display Footer Copyright Text
=======================================*/
if (!empty($imic_options['footer_copyright_text'])) { ?>
<div class="copyrights-col-left col-md-6 col-sm-6">
<p><?php _e('&copy; ','framework'); echo date('Y '); bloginfo('name'); _e('. ','framework'); echo $imic_options['footer_copyright_text']; ?></p>
 </div>
<?php } ?>
  <div class="copyrights-col-right col-md-6 col-sm-6">
<div class="social-icons">
<?php
/* Display Footer Social Links
=======================================*/
$socialSites = $imic_options['footer_social_links'];
foreach($socialSites as $key => $value) {
if(filter_var($value, FILTER_VALIDATE_URL)){ 
echo '<a href="'. $value .'" target="_blank"><i class="fa '. $key .'"></i></a>';
}
}
?>
</div>
</div>
</div>
</div>
</footer>
<!-- End Site Footer -->
<?php 
/* Enable BacktoTop
  =======================*/
if ($imic_options['enable_backtotop'] == 1) { 
echo'<a id="back-to-top"><i class="fa fa-angle-double-up"></i></a>';
}
?>  
</div>
<?php wp_footer(); ?>
</body>
</html>