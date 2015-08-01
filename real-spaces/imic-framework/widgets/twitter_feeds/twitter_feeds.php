<?php
/*** Widget code for Twitter Feeds ***/
class twitter_feeds extends WP_Widget {
	// constructor
	function twitter_feeds() {
		 $widget_ops = array('description' => __( "Show latest twitter feeds.", 'twitter_feeds') );
         parent::WP_Widget(false, $name = 'Twitter Feeds', $widget_ops);
	}
	// widget form creation
	function form($instance) {
		// Check values
		if( $instance) {
			 $title = esc_attr($instance['title']);
			 $username = esc_attr($instance['username']);
			 $count = esc_attr($instance['count']);
			 $consumerKey = esc_attr($instance['consumerKey']);
			 $consumerKeySecret = esc_attr($instance['consumerKeySecret']);
			 $accessToken = esc_attr($instance['accessToken']);
			 $accessTokenSecret = esc_attr($instance['accessTokenSecret']);
		} else {
			 $title = '';
			 $username = '';
			 $count = '';
			 $consumerKey = '';
			 $consumerKeySecret = '';
			 $accessToken = '';
			 $accessTokenSecret = '';
		}
	?>
        <p>
        	<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'twitter_feeds'); ?></label>
        	<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
        <p>
        	<label for="<?php echo $this->get_field_id('username'); ?>"><?php _e('Twitter Username', 'twitter_feeds'); ?></label>
        	<input class="widefat" id="<?php echo $this->get_field_id('username'); ?>" name="<?php echo $this->get_field_name('username'); ?>" type="text" value="<?php echo $username; ?>" />
        </p>
        <p>
        	<label for="<?php echo $this->get_field_id('count'); ?>"><?php _e('Number of Feeds', 'twitter_feeds'); ?></label>
        	<input class="widefat" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" type="text" value="<?php echo $count; ?>" />
        </p>
        <p>
        	<label for="<?php echo $this->get_field_id('consumerKey'); ?>"><?php _e('Consumer Key', 'twitter_feeds'); ?></label>
        	<input class="widefat" id="<?php echo $this->get_field_id('consumerKey'); ?>" name="<?php echo $this->get_field_name('consumerKey'); ?>" type="text" value="<?php echo $consumerKey; ?>" />
        </p>
        <p>
        	<label for="<?php echo $this->get_field_id('consumerKeySecret'); ?>"><?php _e('Consumer Key Secret', 'twitter_feeds'); ?></label>
        	<input class="widefat" id="<?php echo $this->get_field_id('consumerKeySecret'); ?>" name="<?php echo $this->get_field_name('consumerKeySecret'); ?>" type="text" value="<?php echo $consumerKeySecret; ?>" />
        </p>
        <p>
        	<label for="<?php echo $this->get_field_id('accessToken'); ?>"><?php _e('Access Token', 'twitter_feeds'); ?></label>
        	<input class="widefat" id="<?php echo $this->get_field_id('accessToken'); ?>" name="<?php echo $this->get_field_name('accessToken'); ?>" type="text" value="<?php echo $accessToken; ?>" />
        </p>
        <p>
        	<label for="<?php echo $this->get_field_id('accessTokenSecret'); ?>"><?php _e('Access Token Secret', 'twitter_feeds'); ?></label>
        	<input class="widefat" id="<?php echo $this->get_field_id('accessTokenSecret'); ?>" name="<?php echo $this->get_field_name('accessTokenSecret'); ?>" type="text" value="<?php echo $accessTokenSecret; ?>" />
        </p>
	<?php
	}
	// update widget
	function update($new_instance, $old_instance) {
		  $instance = $old_instance;
		  // Fields
		  $instance['title'] = strip_tags($new_instance['title']);
		  $instance['username'] = strip_tags($new_instance['username']);
		  $instance['count'] = strip_tags($new_instance['count']);
		  $instance['consumerKey'] = strip_tags($new_instance['consumerKey']);
		  $instance['consumerKeySecret'] = strip_tags($new_instance['consumerKeySecret']);
		  $instance['accessToken'] = strip_tags($new_instance['accessToken']);
		  $instance['accessTokenSecret'] = strip_tags($new_instance['accessTokenSecret']);
		 return $instance;
	}
	// display widget
	function widget($args, $instance) {
	   extract( $args );
	   // these are the widget options
	   $title = apply_filters('widget_title', $instance['title']);
	   $username = apply_filters('widget_username', $instance['username']);
	   $count = apply_filters('widget_count', $instance['count']);
	   $consumerKey = apply_filters('widget_consumerKey', $instance['consumerKey']);
	   $consumerKeySecret = apply_filters('widget_consumerKeySecret', $instance['consumerKeySecret']);
	   $accessToken = apply_filters('widget_accessToken', $instance['accessToken']);
	   $accessTokenSecret = apply_filters('widget_accessTokenSecret', $instance['accessTokenSecret']);
	   echo $args['before_widget'];
	   	if( !empty($instance['title']) ){
			echo $args['before_title'];
			echo apply_filters('widget_title',$instance['title'], $instance, $this->id_base);
			echo $args['after_title'];
		}
		require_once('tweets.php');
	    $config = array();
		$config['username'] = $username;
		$config['count'] = $count;
		$config['consumer_key'] = $consumerKey; //'djwVth5AYjwRkuR7NnOqg';
		$config['consumer_key_secret'] = $consumerKeySecret; //'woYhNbIvPwf5Hyt2xi17H31uvxhu8oEacDE1jGE';
		$config['access_token'] = $accessToken; //'1918993890-FIT26JDDlUfKjEYmuWwtKOn64t4RTaxIX2bRcMK';
		$config['access_token_secret'] = $accessTokenSecret; //'PjqwpUwnORn9sPV8CtP3gdOa9B5yscxiffWr7rUx19Tll';
		$result = oauthGetTweets($config);
		if( isset($result['errors']) ){
			$result = NULL; 
		} else {
			$result = parseTweets( $result );
		}	
		echo '<ul>';
		if($result!==NULL){
			if(count($result)>0){
				foreach($result as $feed){
					echo '<li><i class="fa fa-twitter"></i> '.$feed['text'].'</li>';	
				}
			}else{
				echo '<li>Loading ...</li>';	
			}	
		}else{
			echo '<li>Loading ...</li>';	
		}
		echo '</ul>';
	   echo $args['after_widget'];
	}
}
// register widget
add_action('widgets_init', create_function('', 'return register_widget("twitter_feeds");'));
?>