<?php
/*** Widget code for Popular Agent ***/
class popular_agent extends WP_Widget {
	// constructor
	function popular_agent() {
		 $widget_ops = array('description' => __( "Display Popular Agent.", 'framework') );
         parent::WP_Widget(false, $name = 'Popular Agent', $widget_ops);
	}
	// widget form creation
	function form($instance) {
	
		// Check values
		if( $instance) {
			 $title = esc_attr($instance['title']);
		} else {
			 $title = '';
		}
	?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'framework'); ?></label>
            <input class="spTitle" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>        
	<?php
	}
	// update widget
	function update($new_instance, $old_instance) {
		  $instance = $old_instance;
		  // Fields
		  $instance['title'] = strip_tags($new_instance['title']);
		 return $instance;
	}
	// display widget
	function widget($args, $instance) {
	   extract( $args );
	   // these are the widget options
	   $post_title = apply_filters('widget_title', $instance['title']);
	   $agent = 1;
	   echo $args['before_widget'];
		if( !empty($instance['title']) ){
			echo '';
			echo $args['before_title'];
			echo apply_filters('widget_title',$post_title, $instance, $this->id_base);
			echo $args['after_title'];
			echo '';
		}
		$user_number = 1;
        $users = get_user_by_meta_data('popular','Popular');
		if(!empty($users)) {
		foreach($users as $user) {
		        $User_Pic = get_user_meta($user->ID,'agent-image',true);
			if(!empty($User_Pic)) {
										$userLoadedImgSrc = wp_get_attachment_image_src($User_Pic, '600-400-size');
										$userImgSrc = $userLoadedImgSrc[0];
										echo '<a href="'.get_author_posts_url($user->ID).'"><img src="'.$User_Pic.'" alt="" class="img-thumbnail"></a>';
									}
				
                echo '<a href="'.get_author_posts_url($user->ID).'" class="btn btn-sm btn-primary pull-right">'.__('more details','framework').'</a>
             	  <h4><a href="'.get_author_posts_url($user->ID).'">'.$user->display_name.'</a></h4>';
				if (++$user_number > $agent)
            break;
		} }
		else {
			echo '<h4>There is no popular agent.</h4>';
		}
          echo $args['after_widget'];
	}
}
// register widget
add_action('widgets_init', create_function('', 'return register_widget("popular_agent");'));
?>