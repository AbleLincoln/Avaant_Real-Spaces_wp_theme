<?php global $author_id, $imic_options;
if(isset($imic_options['enable_agent_details'])&&($imic_options['enable_agent_details']==1)){ ?>
  <div class="widget">
    <h3 class="widgettitle"><?php _e('Agent','framework'); ?></h3>
    <div class="agent">
      <?php $agent_image = get_the_author_meta('agent-image', $author_id);
$userFirstName = get_the_author_meta('first_name', $author_id);
$userLastName = get_the_author_meta('last_name', $author_id);
$userName = get_userdata( $author_id );
if(!empty($userFirstName) || !empty($userLastName)) {
$userName = $userFirstName .' '. $userLastName; 
} else { 
$userName = $userName->user_login; } 
$description = get_the_author_meta( 'description', $author_id ); if($agent_image!='') { ?>
        <img src="<?php echo $agent_image; ?>" alt="" class="margin-20">
        <?php } else {
	$default_image_agent = $imic_options['default_agent_image']; ?>
          <img src="<?php echo $default_image_agent['url']; ?>" alt="" class="margin-20">
          <?php } ?>
            <h4><a href="<?php echo get_author_posts_url($author_id); ?>"><?php echo $userName; ?></a></h4>
            <?php echo apply_filters('the_content', $description); ?>
              <div class="agent-contacts clearfix">
                <a href="<?php echo get_author_posts_url($author_id); ?>" class="btn btn-primary pull-right btn-sm">
                  <?php _e('Agent Information','framework'); ?>
                </a>
                <a id="show_login" data-target="#agentmodal" data-toggle="modal" class="btn btn-primary pull-right btn-sm">
                  <?php _e('Contact Agent','framework'); ?>
                </a>
                <?php $userFB = get_the_author_meta('fb-link', $author_id);
$userTWT = get_the_author_meta('twt-link', $author_id);
$userGP = get_the_author_meta('gp-link', $author_id);
$userMSG = get_the_author_meta('msg-link', $author_id);
$userSocialArray = array_filter(array($userFB,$userTWT,$userGP,$userMSG));
$userSocialClass = array('fa-facebook','fa-twitter','fa-google-plus','fa-envelope');
if(!empty($userSocialArray)) {
echo '<ul>';
foreach($userSocialArray as $key => $value)	{
if(!empty($value)) {
echo '<li><a href="'. $value .'" target="_blank"><i class="fa '. $userSocialClass[$key] .'"></i></a></li>';
}
}
echo '</ul>';
} ?>
              </div>
    </div>
  </div>
  <?php } ?>
    <div class="widget">
      <h3 class="widgettitle"><?php _e('Description','framework'); ?></h3>
      <div id="description">
        <?php the_content(); ?>
      </div>
    </div>
    <div class="widget">
      <h3 class="widgettitle"><?php _e('Seeking','framework'); ?></h3>
      <div id="amenities">
        <div class="additional-amenities">
          <?php 
$amenity_array=array();
$property_amenities = get_post_meta(get_the_ID(),'imic_property_amenities',true);
global $imic_options;		
foreach($property_amenities as $properties_amenities_temp){
if($properties_amenities_temp!='Not Selected'){
array_push($amenity_array,$properties_amenities_temp);
}}
if(isset($imic_options['properties_amenities'])&&count($imic_options['properties_amenities'])>1){
foreach($imic_options['properties_amenities'] as $properties_amenities){
 $am_name= strtolower(str_replace(' ','',$properties_amenities));
if(in_array($properties_amenities, $amenity_array)){
$class = 'available';
}else{
$class = 'navailable'; 
  }
if(!empty($properties_amenities)){
echo '<span class="'.$class.'"><i class="fa fa-check-square"></i> '.$properties_amenities.'</span>';
}}}
$author_id = $post->post_author; 
?>
        </div>
      </div>
    </div>
    <div class="widget">
      <h3 class="widgettitle"><?php _e('Project Details','framework'); ?></h3>
      <div id="address" class="tab-pane">
        <?php imicPropertyDetailById(get_the_ID()); ?>
      </div>
    </div>
