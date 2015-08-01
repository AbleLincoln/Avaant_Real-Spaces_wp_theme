<?php
/*** Widget code for Sliding Properties ***/
class featured_properties_widget extends WP_Widget {
	// constructor
	function featured_properties_widget() {
		 $widget_ops = array('description' => __( "Properties Slider.", 'framework') );
         parent::WP_Widget(false, $name = 'Properties Slider Widget', $widget_ops);
	}
	// widget form creation
	function form($instance) {
	
		// Check values
		if( $instance) {
			 $title = esc_attr($instance['title']);
			 $number = esc_attr($instance['number']);
			 $type = esc_attr($instance['type']);
		} else {
			 $title = '';
			 $number = 3;
			 $type = 'recent';
		}
	?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'framework'); ?></label>
            <input class="spTitle" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>    
        <p>
            <label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of Porperties', 'framework'); ?></label>
            <input class="spTitle" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" />
        </p> 
        <p>
            <label for="<?php echo $this->get_field_id('type'); ?>"><?php _e('Select Type', 'framework'); ?></label>
            <select class='widefat' id="<?php echo $this->get_field_id('city'); ?>"
                name="<?php echo $this->get_field_name('type'); ?>" type="text">
          <option value='recent'<?php echo ($type=='recent')?'selected':''; ?>><?php _e('Recent','framework'); ?>
          </option>
          <option value='featured'<?php echo ($type=='featured')?'selected':''; ?>><?php _e('Featured','framework'); ?>
          </option>
        </select>        
        </p>       
	<?php
	}
	// update widget
	function update($new_instance, $old_instance) {
		  $instance = $old_instance;
		  // Fields
		  $instance['title'] = strip_tags($new_instance['title']);
		  $instance['number'] = strip_tags($new_instance['number']);
		  $instance['type'] = strip_tags($new_instance['type']);
		 return $instance;
	}
	// display widget
	function widget($args, $instance) {
	   extract( $args );
	   // these are the widget options
	   $post_title = apply_filters('widget_title', $instance['title']);
	   $number = $instance['number'];
	   $type = apply_filters('widget-type', empty($instance['type']) ? '' : $instance['type'], $instance, $this->id_base);
	   echo $args['before_widget'];
		if( !empty($instance['title']) ){
			echo '';
			echo $args['before_title'];
			echo apply_filters('widget_title',$post_title, $instance, $this->id_base);
			echo $args['after_title'];
			echo '';
		}
		echo '<ul class="owl-carousel owl-alt-controls1 single-carousel" data-columns="1" data-autoplay="no" data-pagination="no" data-arrows="yes" data-single-item="yes">';
		if($type=='featured') {
		query_posts(array('post_type'=>'property','post_status'=>'publish','posts_per_page'=>$number,'meta_query' => array(array('key' => 'imic_featured_property','value' => 1,'compare' => '=='),),)); } else {
		query_posts(array('post_type'=>'property','post_status'=>'publish','posts_per_page'=>$number)); }
		global $imic_options;
		$currency_symbol = imic_get_currency_symbol($imic_options['currency-select']);
		if(have_posts()):while(have_posts()):the_post();
		$property_images = get_post_meta(get_the_ID(),'imic_property_sights',false);
		$total_images = count($property_images);
		$property_type = '';
		$property_address = get_post_meta(get_the_ID(),'imic_property_site_address',true);
		$property_city = get_post_meta(get_the_ID(),'imic_property_site_city',true);
		$property_price = get_post_meta(get_the_ID(),'imic_property_price',true); 
		$contract = wp_get_object_terms( get_the_ID(), 'property-contract-type', array('fields'=>'ids')); 
								  if(!empty($contract)) {
								  $terms = get_term( $contract[0], 'property-contract-type' ); 
								  $property_type = $terms->name; }
				echo '<li class="item property-block">
                              <a href="'.get_permalink().'" class="property-featured-image"> '.get_the_post_thumbnail(get_the_ID(),'600-400-size').' <span class="images-count"><i class="fa fa-picture-o"></i> '.$total_images.'</span> <span class="badges">'.$property_type.'</span> </a>
                            <div class="property-info">
                              <h4><a href="'.get_permalink().'">'.$property_address.'</a></h4>
                              <span class="location">'.$property_city.'</span>
                              <div class="price"><strong>'.$currency_symbol.'</strong><span>'.$property_price.'</span></div>
                            </div>
                          </li>';
					endwhile; endif; wp_reset_query();
		echo '</ul>';
          echo $args['after_widget'];
	}
}
// register widget
add_action('widgets_init', create_function('', 'return register_widget("featured_properties_widget");'));
?>