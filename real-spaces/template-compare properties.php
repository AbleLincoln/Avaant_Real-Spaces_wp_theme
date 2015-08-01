<?php 
/* 
 Template Name:Compare Properties
 * and open the template in the editor.
 */
get_header();  
global $imic_options; //Theme Global Variable
/* Page Banner HTML
=============================*/
$currency_symbol = imic_get_currency_symbol($imic_options['currency-select']);
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
endwhile; endif; 
if(isset($_POST['submit'])){
query_posts(array('post_type'=>'property','post_status'=>'publish',
'meta_query' => array(
'relation' => 'OR',
array(
'key' => 'imic_property_site_id',
'value' =>$_POST['compare1'],
),
array(
'key' => 'imic_property_site_id',
'value' =>$_POST['compare2'],
),
array(
'key' => 'imic_property_site_id',
'value' =>$_POST['compare3'],
),
array(
'key' => 'imic_property_site_id',
'value' =>$_POST['compare4'],
)
),));
if(have_posts()){
echo '<h2></h2>';
echo'<div class="pricing-table five-cols margin-40">';
echo '<div class="pricing-column">';
echo '<h3>'.__('ID','framework').'</h3>';
echo'<div class="pricing-column-content">';
echo'<ul class="features">
<li>'.__('Property Address','framework').'</li>
<li>'.__('Province','framework').'</li>
<li>'.__('Property Area','framework').'</li>
<li>'.__('Property Value('.$currency_symbol.')','framework').'</li>
<li>'.__('Baths','framework').'</li>
<li>'.__('Beds','framework').'</li>
<li>'.__('Parking','framework').'</li>
<li>'.__('Property Pincode','framework').'</li>
</ul>
</div>
</div>';
while (have_posts()):the_post();
$add = get_post_meta(get_the_ID(),'imic_property_site_address',true);
$city = get_post_meta(get_the_ID(),'imic_property_site_city',true);
$price = get_post_meta(get_the_ID(),'imic_property_price',true);
$area = get_post_meta(get_the_ID(),'imic_property_area',true);
$baths = get_post_meta(get_the_ID(),'imic_property_baths',true);
$beds = get_post_meta(get_the_ID(),'imic_property_beds',true);
$park = get_post_meta(get_the_ID(),'imic_property_parking',true);
$pin = get_post_meta(get_the_ID(),'imic_property_pincode',true);
$add = ($add!='')?$add:'N/A';
$city = ($city!='')?$city:'N/A';
$price = ($price!='')?$price:'N/A';
$area = ($area!='')?$area:'N/A';
$baths = ($baths!='')?$baths:'N/A';
$beds = ($beds!='')?$beds:'N/A';
$park = ($park!='')?$park:'N/A';
$pin = ($pin!='')?$pin:'N/A';
echo'<div class="pricing-column ">
<h3><a href ="'.get_permalink().'">'.get_post_meta(get_the_ID(),'imic_property_site_id',true).'</a></h3>
<div class="pricing-column-content">';
echo'<ul class="features">
<li>'.$add.'</li>
<li>'.$city.'</li>
<li>'.$price.'</li>
<li>'.$area.'</li>
<li>'.$baths.'</li>
<li>'.$beds.'</li>
<li>'.$park.'</li>
<li>'.$pin.'</li>
</ul>
<a class="btn btn-primary" href="'.get_permalink().'">'.__('Details','framework').'</a> </div>
 </div>';
endwhile;
echo '</div>';
}
else{
echo '<h2>'.__('There is no property  with your selected criteria please try again','framework').'</h2>';
$flag=1;
}
}
if(empty($_POST)||isset($flag)){
?>
<form method="post" id="contactform" name="contactform"  action="">
<div class="row">
<div class="col-md-4">
<div class="form-group">            
<input type="text" name ="compare1" class="form-control input-lg1" placeholder="<?php _e('Enter property id to compare','framework'); ?>"/>
</div>
<div class="form-group">  
<input type="text" name ="compare2" class="form-control input-lg1" placeholder="<?php _e('Enter property id to compare','framework'); ?>"/>
</div>
<div class="form-group">  
<input type="text" name ="compare3" class="form-control input-lg1" placeholder="<?php _e('Enter property id to compare','framework'); ?>"/>
</div>
<div class="form-group"> <input type="text" name ="compare4" class="form-control input-lg1" placeholder="<?php _e('Enter property id to compare','framework'); ?>"/>
</div>
<div class="form-group">
<input id="submit" name="submit" type="submit"  class="btn btn-primary btn-lg btn-block">
</div>
</div>
</div>
</form>
<?php 
}
?>
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