<?php
/*** Widget code for Properties ***/
class properties extends WP_Widget {
	// constructor
	function properties() {
		 $widget_ops = array('description' => __( "Properties Listing.", 'framework') );
         parent::WP_Widget(false, $name = 'Properties', $widget_ops);
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
		echo '<ul>';
		if($type=='featured') {
		query_posts(array('post_type'=>'property','post_status'=>'publish','posts_per_page'=>$number,'meta_query' => array(array('key' => 'imic_featured_property','value' => 1,'compare' => '=='),),)); } else {
		query_posts(array('post_type'=>'property','post_status'=>'publish','posts_per_page'=>$number)); }
		global $imic_options;
		$currency_symbol = imic_get_currency_symbol($imic_options['currency-select']);
		if(have_posts()):while(have_posts()):the_post();
		$property_address = get_post_meta(get_the_ID(),'imic_property_site_address',true);
		$property_price = get_post_meta(get_the_ID(),'imic_property_price',true); 
				echo '<li>
                              <div class="row">
                                      <div class="col-md-5 col-sm-5 col-xs-5">
                                      <a href="'.get_permalink().'">'.get_the_post_thumbnail(get_the_ID(),'600-400-size',array('class'=>'img-thumbnail')).'</a>
                                  </div>
                                  <div class="col-md-7 col-sm-7 col-xs-7">
                                      <strong><a href="'.get_permalink().'">'.$property_address.'</a></strong>
                                      <div class="price"><strong>'.$currency_symbol.'</strong><span>'.$property_price.'</span></div>
                                  </div>
                                  </div>
                        </li>';
					endwhile; endif; wp_reset_query();
		echo '</ul>';
          echo $args['after_widget'];
	}
}
// register widget
add_action('widgets_init', create_function('', 'return register_widget("properties");'));
?>