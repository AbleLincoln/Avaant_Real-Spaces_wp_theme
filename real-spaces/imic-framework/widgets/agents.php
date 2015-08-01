<?php
/*** Widget code for Agent ***/
class agents extends WP_Widget {
	// constructor
	function agents() {
		 $widget_ops = array('description' => __( "Display Recent Added Agents.", 'framework') );
         parent::WP_Widget(false, $name = 'Agents', $widget_ops);
	}
	// widget form creation
	function form($instance) {
	
		// Check values
		if( $instance) {
			 $title = esc_attr($instance['title']);
		} else {
			 $title = '';
		}
		if ( isset( $instance[ 'agent' ] ) ) {
			$agent = $instance[ 'agent' ];
		}
		else {
			$agent = 3;
		}
	?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'framework'); ?></label>
            <input class="spTitle" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>    
        <p>
            <label for="<?php echo $this->get_field_id('agent'); ?>"><?php _e('Number of Agent', 'framework'); ?></label>
            <input class="spTitle" id="<?php echo $this->get_field_id('agent'); ?>" name="<?php echo $this->get_field_name('agent'); ?>" type="text" value="<?php echo $agent; ?>" />
        </p>       
	<?php
	}
	// update widget
	function update($new_instance, $old_instance) {
		  $instance = $old_instance;
		  // Fields
		  $instance['title'] = strip_tags($new_instance['title']);
		  $instance['agent'] = strip_tags($new_instance['agent']);
		 return $instance;
	}
	// display widget
	function widget($args, $instance) {
	   extract( $args );
	   // these are the widget options
	   $post_title = apply_filters('widget_title', $instance['title']);
	   $agent = $instance['agent'];
	   echo $args['before_widget'];
		if( !empty($instance['title']) ){
			echo '';
			echo $args['before_title'];
			echo apply_filters('widget_title',$post_title, $instance, $this->id_base);
			echo $args['after_title'];
			echo '';
		}
		$arg = array('blog_id' => $GLOBALS['blog_id'],'role' => 'agent','order' => 'ASC','posts_per_page'=>$agent);
		$blogusers = new WP_User_Query($arg);
		if (!empty($blogusers->results)) {
			echo '<ul>';
			foreach ($blogusers->results as $user) {
				$userImageID = get_the_author_meta('agent-image', $user->ID);
							  $userDescClass = 12;
							  	$userImage = wp_get_attachment_image_src($userImageID, '600-400-size'); 
								$userFirstName = get_the_author_meta('first_name', $user->ID);
											$userLastName = get_the_author_meta('last_name', $user->ID);
											$userName = $user->display_name;
											if(!empty($userFirstName) || !empty($userLastName)) {
												$userName = $userFirstName .' '. $userLastName; 
											}
											$userMobileNo = get_the_author_meta('mobile-phone', $user->ID);
			echo '<li>
                                  <div class="row">
                                      <div class="col-md-5 col-sm-5 col-xs-5">
                                          <a href="'.get_author_posts_url($user->ID).'"><img src="'. $userImageID.'" alt="agent" class="img-thumbnail"></a>
                                  </div>
                                  <div class="col-md-7 col-sm-7 col-xs-7">
                                      <strong><a href="'.get_author_posts_url($user->ID).'">'. $userName .'</a></strong>
                                      <span class="badge"><i class="fa fa-phone"></i> '.$userMobileNo.'</span>
                                  </div>
                                  </div>
                              </li>';
							  }
				echo '</ul>';
		}
          echo $args['after_widget'];
	}
}
// register widget
add_action('widgets_init', create_function('', 'return register_widget("agents");'));
?>