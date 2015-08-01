<?php
/*** Widget code for Testimonials ***/
class testimonial extends WP_Widget {
	// constructor
	function testimonial() {
		 $widget_ops = array('description' => __( "Testimonial.", 'framework') );
         parent::WP_Widget(false, $name = 'Testimonials', $widget_ops);
	}
	// widget form creation
	function form($instance) {
	
		// Check values
		if( $instance) {
			 $title = esc_attr($instance['title']);
		} else {
			 $title = '';
		}
		if ( isset( $instance[ 'testimonial' ] ) ) {
			$testimonial = $instance[ 'testimonial' ];
		}
		else {
			$testimonial = 1;
		}
	?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'framework'); ?></label>
            <input class="spTitle" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>    
        <p>
            <label for="<?php echo $this->get_field_id('testimonial'); ?>"><?php _e('Number of Testimonial', 'framework'); ?></label>
            <input class="spTitle" id="<?php echo $this->get_field_id('testimonial'); ?>" name="<?php echo $this->get_field_name('testimonial'); ?>" type="text" value="<?php echo $testimonial; ?>" />
        </p>       
	<?php
	}
	// update widget
	function update($new_instance, $old_instance) {
		  $instance = $old_instance;
		  // Fields
		  $instance['title'] = strip_tags($new_instance['title']);
		  $instance['testimonial'] = strip_tags($new_instance['testimonial']);
		 return $instance;
	}
	// display widget
	function widget($args, $instance) {
	   extract( $args );
	   // these are the widget options
	   $post_title = apply_filters('widget_title', $instance['title']);
	   $testimonial = $instance['testimonial'];
	   echo $args['before_widget'];
		if( !empty($instance['title']) ){
			echo '';
			echo $args['before_title'];
			echo apply_filters('widget_title',$post_title, $instance, $this->id_base);
			echo $args['after_title'];
			echo '';
		}
		echo '<ul class="testimonials">';
		query_posts(array('post_type'=>'testimonials','posts_per_page'=>$testimonial));
		if(have_posts()):while(have_posts()):the_post();
		$company = get_post_meta(get_the_ID(),'imic_client_company',true);
		$Client_Url = get_post_meta(get_the_ID(),'imic_client_co_url',true);
		$domain_url=$url_html = '';
		if(filter_var($Client_Url, FILTER_VALIDATE_URL)){ 
		$domain_url = parse_url($Client_Url);
		$domain_url = $domain_url['host'];
		$url_html = '<br><a href="'.$Client_Url.'">'.$domain_url.'</a>';
		 }
				echo '<li>
                              '.imic_excerpt(50).get_the_post_thumbnail(get_the_ID(),'80-80-size',array('class'=>'testimonial-sender')).'
                              <cite>'.get_the_title().' - <strong>'.$company.'</strong>'.$url_html.'
                           </cite>
                        </li>';
					endwhile; endif; wp_reset_query();
		echo '</ul>';
          echo $args['after_widget'];
	}
}
// register widget
add_action('widgets_init', create_function('', 'return register_widget("testimonial");'));
?>