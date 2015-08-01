<?php
/*** Widget code for Recent posts ***/
class recent_posts extends WP_Widget {
	// constructor
	function recent_posts() {
		 $widget_ops = array('description' => __( "Recent Posts with Thumbnail.", 'framework') );
         parent::WP_Widget(false, $name = 'Recent Posts with Thumbnail', $widget_ops);
	}
	// widget form creation
	function form($instance) {
	
		// Check values
		if( $instance) {
			 $title = esc_attr($instance['title']);
			 $number = esc_attr($instance['number']);
		} else {
			 $title = '';
			 $number = 3;
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
	<?php
	}
	// update widget
	function update($new_instance, $old_instance) {
		  $instance = $old_instance;
		  // Fields
		  $instance['title'] = strip_tags($new_instance['title']);
		  $instance['number'] = strip_tags($new_instance['number']);
		 return $instance;
	}
	// display widget
	function widget($args, $instance) {
	   extract( $args );
	   // these are the widget options
	   $post_title = apply_filters('widget_title', $instance['title']);
	   $number = $instance['number'];
	   echo $args['before_widget'];
		if( !empty($instance['title']) ){
			echo '';
			echo $args['before_title'];
			echo apply_filters('widget_title',$post_title, $instance, $this->id_base);
			echo $args['after_title'];
			echo '';
		}
		echo '<ul>';
		query_posts(array('post_type'=>'post','posts_per_page'=>$number));
		if(have_posts()):while(have_posts()):the_post();
				echo '<li class="clearfix">';
                      if ( '' != get_the_post_thumbnail() ) { echo '<a href="'.get_permalink().'" class="media-box post-image">
                              '.get_the_post_thumbnail(get_the_ID(),'600-400-size',array('class'=>'img-thumbnail')).'
                        </a>'; }
                          echo '<div class="widget-blog-content">
                          <a href="'.get_permalink().'">'.get_the_title().'</a>
                          </div>
                    </li>';
					endwhile; endif; wp_reset_query();
		echo '</ul>';
          echo $args['after_widget'];
	}
}
// register widget
add_action('widgets_init', create_function('', 'return register_widget("recent_posts");'));
?>