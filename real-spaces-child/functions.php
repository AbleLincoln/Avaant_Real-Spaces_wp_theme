<?php

//add_action( 'wp_enqueue_scripts', 'add_my_script' );
//function add_my_script() {
//  wp_enqueue_script(
//    'avnt-script',
//    get_stylesheet_directory_uri() . '/avnt-js/avnt-script.js',
//    array('jquery')
//    );
//}

//Enqueue Scripts
function imic_enqueue_scripts() {
        global $imic_options;
		$theme_info = wp_get_theme();
		$sticky_menu = $imic_options['enable-header-stick'];
		$basic = __('Basic','framework');
        $advanced = __('Advanced','framework');
        //**register script**//
        wp_register_script('imic_jquery_modernizr', IMIC_THEME_PATH . '/js/modernizr.js', $theme_info->get( 'Version' ),'jquery');
        wp_register_script('imic_jquery_prettyphoto', IMIC_THEME_PATH . '/plugins/prettyphoto/js/prettyphoto.js', array(), $theme_info->get( 'Version' ), true);
		wp_register_script('imic_jquery_owl_carousel', IMIC_THEME_PATH . '/plugins/owl-carousel/js/owl.carousel.min.js', array(), $theme_info->get( 'Version' ), true);
        wp_register_script('imic_jquery_flexslider', IMIC_THEME_PATH . '/plugins/flexslider/js/jquery.flexslider.js', array(), $theme_info->get( 'Version' ), true);
		wp_register_script('imic_jquery_helper_plugins', IMIC_THEME_PATH . '/js/helper-plugins.js', array(), $theme_info->get( 'Version' ), true);
		wp_register_script('imic_jquery_bootstrap', IMIC_THEME_PATH . '/js/bootstrap.js', array(), $theme_info->get( 'Version' ), true);
        wp_register_script('imic_jquery_waypoints', IMIC_THEME_PATH . '/js/waypoints.js', array(), $theme_info->get( 'Version' ), true);
        wp_register_script('imic_jquery_init', IMIC_THEME_PATH . '/js/init.js', array(), $theme_info->get( 'Version' ), true);
		wp_register_script('imic_google_map','http://maps.google.com/maps/api/js?sensor=false',array(), $theme_info->get( 'Version' ),true);
		wp_register_script('imic_profile_validate', IMIC_THEME_PATH . '/js/profile_validate.js', array(), $theme_info->get( 'Version' ), true);
		wp_register_script('imic_jquery_mediaelement_and_player', IMIC_THEME_PATH . '/plugins/mediaelement/mediaelement-and-player.min.js', array(), $theme_info->get( 'Version' ), true);
        wp_register_script('avnt-script', get_stylesheet_directory_uri() . '/avnt-js/avnt-script.js', array(), null, true);
        //**End register script**//
        //**Enqueue script**//
        wp_enqueue_script('imic_jquery_modernizr');
        wp_enqueue_script('jquery');
        wp_enqueue_script('imic_jquery_prettyphoto');
        wp_enqueue_script('imic_jquery_owl_carousel');
		wp_enqueue_script('imic_jquery_flexslider');
		wp_enqueue_script('imic_jquery_helper_plugins');
        wp_enqueue_script('imic_jquery_bootstrap');
        wp_enqueue_script('imic_jquery_waypoints');
		wp_enqueue_script('imic_google_map');
        wp_enqueue_script('imic_jquery_init');
		wp_enqueue_script('imic_profile_validate');
        wp_enqueue_script('avnt-script');
		
        if (is_singular() && comments_open() && get_option('thread_comments')) {
            wp_enqueue_script('comment-reply');
        }
        //**End Enqueue script**//
		if ( is_page_template('template-register.php') ) {
			wp_enqueue_script('avnt-agent-register', get_stylesheet_directory_uri() . '/js/agent-register.js', '', '', true);
	        wp_localize_script('avnt-agent-register', 'avnt_agent_register', array('ajaxurl' => admin_url('admin-ajax.php')));
		}
	}
  add_action('wp_enqueue_scripts', 'imic_enqueue_scripts');

//Dequeue scripts
if(!function_exists('imicChildOptions')):
  add_action('after_setup_theme', 'imicChildOptions');
  function imicChildOptions() {
     update_option('show_on_front','page');
  }
endif;
if(!function_exists('imic_dequeue_script')):
  function imic_dequeue_script() {
   wp_dequeue_script('imic_jquery_init');
  }
  add_action( 'wp_print_scripts', 'imic_dequeue_script', 100 );
endif;
if (!function_exists('imic_enqueue_child_scripts')) {
    function imic_enqueue_child_scripts() {
    wp_register_script('imic_jquery_child_init', get_stylesheet_directory_uri() . '/js/init.js', array(), '', true);
    wp_enqueue_script('imic_jquery_child_init');
    wp_localize_script('imic_jquery_child_init', 'urlajax', array('url' => admin_url('admin-ajax.php'),'tmpurl' => get_template_directory_uri(),'is_property'=>is_singular('property'),'sticky'=>$sticky_menu,'is_contact'=>is_page_template('template-contact.php'),'home_url'=>  site_url(),'is_payment'=>is_page_template('template-payment.php'),'register_url'=>imic_get_template_url('template-register.php'),'is_register'=>is_page_template('template-register.php'),'is_login'=>is_user_logged_in(),'is_submit_property'=>is_page_template('template-submit-property.php'),'basic'=>$basic,'advanced'=>$advanced));
}}
 add_action('wp_enqueue_scripts','imic_enqueue_child_scripts');

//Social Media Buttons
function imic_share_buttons(){
  $posttitle = get_the_title();
  $postpermalink = get_permalink();
  $postexcerpt = get_the_excerpt();
  global $imic_options;
			
            echo '<div class="share-bar">';
			if($imic_options['sharing_style'] == '0'){
				if($imic_options['sharing_color'] == '0'){
            		echo '<ul class="share-buttons">';
				}elseif($imic_options['sharing_color'] == '1'){
            		echo '<ul class="share-buttons share-buttons-tc">';
				}elseif($imic_options['sharing_color'] == '2'){
            		echo '<ul class="share-buttons share-buttons-gs">';
				}
			} elseif($imic_options['sharing_style'] == '1'){
				if($imic_options['sharing_color'] == '0'){
            		echo '<ul class="share-buttons share-buttons-squared">';
				}elseif($imic_options['sharing_color'] == '1'){
            		echo '<ul class="share-buttons share-buttons-tc share-buttons-squared">';
				}elseif($imic_options['sharing_color'] == '2'){
            		echo '<ul class="share-buttons share-buttons-gs share-buttons-squared">';
				}
			};
                	//echo '<li class="share-title"><i class="fa fa-share-alt fa-2x"></i></li>';
					if($imic_options['share_icon']['1'] == '1'){
                   		echo '<li class="facebook-share"><a href="https://www.facebook.com/sharer/sharer.php?u=' . $postpermalink . '&t=' . $posttitle . '" target="_blank" title="Share on Facebook"><i class="fa fa-facebook"></i></a></li>';
					}
					if($imic_options['share_icon']['2'] == '1'){
                     	echo '<li class="twitter-share"><a href="https://twitter.com/intent/tweet?source=' . $postpermalink . '&text=' . $posttitle . ':' . $postpermalink . '" target="_blank" title="Tweet"><i class="fa fa-twitter"></i></a></li>';
					}
					if($imic_options['share_icon']['3'] == '1'){
                    echo '<li class="google-share"><a href="https://plus.google.com/share?url=' . $postpermalink . '" target="_blank" title="Share on Google+"><i class="fa fa-google-plus"></i></a></li>';
					}
					if($imic_options['share_icon']['4'] == '1'){
                    	echo '<li class="tumblr-share"><a href="http://www.tumblr.com/share?v=3&u=' . $postpermalink . '&t=' . $posttitle . '&s=" target="_blank" title="Post to Tumblr"><i class="fa fa-tumblr"></i></a></li>';
					}
					if($imic_options['share_icon']['5'] == '1'){
                    	echo '<li class="pinterest-share"><a href="http://pinterest.com/pin/create/button/?url=' . $postpermalink . '&description=' . $postexcerpt . '" target="_blank" title="Pin it"><i class="fa fa-pinterest"></i></a></li>';
					}
					if($imic_options['share_icon']['6'] == '1'){
                    	echo '<li class="reddit-share"><a href="http://www.reddit.com/submit?url=' . $postpermalink . '&title="" target="_blank" title="Submit to Reddit"><i class="fa fa-reddit"></i></a></li>';
					}
					if($imic_options['share_icon']['7'] == '1'){
                    	echo '<li class="linkedin-share"><a href="http://www.linkedin.com/shareArticle?mini=true&url=' . $postpermalink . '&title=' . $posttitle . '&summary=' . $postexcerpt . '&source=' . $postpermalink . '" target="_blank" title="Share on LinkedIn"><i class="fa fa-linkedin"></i></a></li>';
					}
					if($imic_options['share_icon']['8'] == '1'){
                    	echo '<li class="email-share"><a href="mailto:?subject=' . $posttitle . '&body=' . $postexcerpt . ':' . $postpermalink . '" target="_blank" title="Email"><i class="fa fa-envelope"></i></a></li>';
					}
                echo '</ul>
            </div>';
}

//Agent fields
function imic_agent_fields( $user ) {
  $value = get_the_author_meta( 'popular', $user->ID);
  $userFB = get_the_author_meta('fb-link', $user->ID);
  $userTWT = get_the_author_meta('twt-link', $user->ID);
  $userGP = get_the_author_meta('gp-link', $user->ID);
  $userMSG = get_the_author_meta('msg-link', $user->ID);
  $userLINKEDIN = get_the_author_meta('linkedin-link', $user->ID);
   //Agent Contact Details
  $userMobileNo = get_the_author_meta('mobile-phone', $user->ID);
  $userWorkNo = get_the_author_meta('work-phone', $user->ID);
  $userPropertyValue = get_the_author_meta('property_value', $user->ID);
  
  $avnt_hacker = get_the_author_meta( 'hacker', $user->ID);
  $avnt_hustler = get_the_author_meta( 'hustler', $user->ID);
  $avnt_creative = get_the_author_meta( 'creative', $user->ID);
?>

  <h3><?php _e('User Talent', 'framework'); ?></h3>
  <table class="form-table">
    <tr>
      <th><label for="hacker">Hacker</label></th>
      <td><input type="checkbox" name="hacker"
                <?php if ($avnt_hacker=='hacker' ) { ?> 
                  checked="checked"
                <?php }?> 
                value="hacker">
                <?php _e('Hacker?','framework'); ?>
      </td>
    </tr>
    <tr>
      <th><label for="hustler">Hustler</label></th>
      <td><input type="checkbox" name="hustler"
                <?php if ($avnt_hustler=='hustler' ) { ?> 
                  checked="checked"
                <?php }?> 
                value="hustler">
                <?php _e('Hustler?','framework'); ?>
      </td>
    </tr>
    <tr>
      <th><label for="creative">Creative</label></th>
      <td><input type="checkbox" name="creative"
                <?php if ($avnt_creative=='creative' ) { ?> 
                  checked="checked"
                <?php }?> 
                value="creative">
                <?php _e('Creative?','framework'); ?>
      </td>
    </tr>
  </table>

  <h3><?php _e('Agent Social','framework'); ?></h3>
  <table class="form-table">
    <tr>
      <th>
        <label for="Agent Facebook Url">
          <?php _e('Agent Facebook Url','framework'); ?>
        </label>
      </th>
      <td>
        <label>
          <input type="text" name="fb-link" value="<?php echo $userFB; ?>" ></label>
      </td>
    </tr>
    <tr>
      <th>
        <label for="Agent Twitter Url">
          <?php _e('Agent Twitter Url','framework'); ?>
        </label>
      </th>
      <td>
        <label>
          <input type="text" name="twt-link" value="<?php echo $userTWT; ?>" ></label>
      </td>
    </tr>
    <tr>
      <th>
        <label for="Agent Google Plus Url">
          <?php _e('Agent Google Plus Url','framework'); ?>
        </label>
      </th>
      <td>
        <label>
          <input type="text" name="gp-link" value="<?php echo $userGP; ?>" </label>
      </td>
    </tr>
    <tr>
      <th>
        <label for="Agent Msg Link Url">
          <?php _e('Agent Msg Link Url','framework'); ?>
        </label>
      </th>
      <td>
        <label>
          <input type="text" name="msg-link" value="<?php echo $userMSG; ?>" </label>
      </td>
    </tr>
    <tr>
      <th>
        <label for="Agent linkedin Link Url">
          <?php _e('Linkedin Url','framework'); ?>
        </label>
      </th>
      <td>
        <label>
          <input type="text" name="linkedin-link" value="<?php echo $userLINKEDIN; ?>" </label>
      </td>
    </tr>
  </table>
  <h3><?php _e('Agent Contact Details','framework'); ?></h3>
  <table class="form-table">
    <tr>
      <th>
        <label for="Agent Mobile Number">
          <?php _e('Agent Mobile Number','framework'); ?>
        </label>
      </th>
      <td>
        <label>
          <input type="text" name="mobile-phone" value="<?php echo $userMobileNo; ?>" </label>
      </td>
    </tr>
    <tr>
      <th>
        <label for="Agent Work Phone">
          <?php _e('Agent Work Phone','framework'); ?>
        </label>
      </th>
      <td>
        <label>
          <input type="text" name="work-phone" value="<?php echo $userWorkNo; ?>" </label>
      </td>
    </tr>
  </table>
  <h3><?php _e('Agent Plan Details','framework'); ?></h3>
  <table class="form-table">
    <tr>
      <th>
        <label for="property_number">
          <?php _e('Number of Property','framework'); ?>
        </label>
      </th>
      <td>
        <label>
          <input type="text" name="agent_number_of_plan" readonly value="<?php echo $userPropertyValue; ?>" </label>
      </td>
    </tr>
  </table>
  <h3><?php _e('Agent Image','framework'); ?></h3>
  <table class="form-table">
    <tr>
      <th>
        <label for="Agent Image">
          <?php _e('Agent Image','framework'); ?>
        </label>
      </th>
      <td>
        <?php
$agent_image = get_the_author_meta('agent-image', $user->ID);
 if (!empty($agent_image)) {
          $agent_image=  $agent_image;
       } else {
           $agent_image = '';
       }
                       echo '<div><img id ="upload_image_preview" src ="' . $agent_image . '" width ="150px" height ="150px"/></div>';
                       echo '<input id="upload_agent_button" type="button" class="button button-primary" value="'.__('Upload Image', 'framework').'" /> ';
                       if (!empty($agent_image)) {
                       echo '<input id="upload_agent_button_remove" type="button" class="button button-primary" value="'.__('Remove Image', 'framework').'" />';
                      }
                       ?>
          <p class="description">
            <?php _e('Upload an image for the agent .', 'framework'); ?>
          </p>
          <input type="hidden" id="agent_url" name="agent-image" value="<?php echo esc_url($agent_image); ?>" />
      </td>
    </tr>
  </table>
  <h3><?php _e('Agent banner Image','framework'); ?></h3>
  <table class="form-table">
    <tr>
      <th>
        <label for="Agent Banner">
          <?php _e('Agent banner image','framework'); ?>
        </label>
      </th>
      <td>
        <?php
$agent_banner = get_the_author_meta('agent-banner', $user->ID);
 if (!empty($agent_banner)) {
          $agent_banner=  $agent_banner;
       } else {
           $agent_banner = '';
       }
                       echo '<div><img id ="upload_banner_preview" src ="' . $agent_banner . '" width ="150px" height ="150px"/></div>';
                       echo '<input id="upload_agent_banner" type="button" class="button button-primary" value="'.__('Upload Banner', 'framework').'" /> ';
                       if (!empty($agent_banner)) {
						
                       echo '<input id="upload_agent_banner_remove" type="button" class="button button-primary" value="'.__('Remove Banner', 'framework').'" />';
                      }
                       ?>
          <p class="description">
            <?php _e('Upload an image for the agent page banner.', 'framework'); ?>
          </p>
          <input type="hidden" id="agent_banner" name="agent-banner" value="<?php echo esc_url($agent_banner); ?>" />
      </td>
    </tr>
  </table>
  <h3><?php _e('Popular Agent','framework'); ?></h3>
  <table class="form-table">
    <tr>
      <th>
        <label for="Popular Agent">
          <?php _e('Popular Agent','framework'); ?>
        </label>
      </th>
      <td><span class="description"><?php _e('Check this box to create agent popular.','framework'); ?></span>
        <br>
        <label>
          <input type="checkbox" name="popular"
                <?php if ($value=='Popular' ) { ?> 
                  checked="checked"
                <?php }?> 
                value="Popular">
            <?php _e('Popular Agent','framework'); ?>
              <br />
        </label>
      </td>
    </tr>
  </table>
  <?php 
}
function imic_save_agent_field( $user_id ) {
    if ( !current_user_can( 'edit_user', $user_id ) )
        return FALSE;
   
  $popular = isset($_POST['popular']) ? wp_filter_post_kses($_POST['popular']) : '';
  $fb_link = isset($_POST['fb-link']) ? wp_filter_post_kses($_POST['fb-link']) : '';
  $twt_link = isset($_POST['twt-link']) ? wp_filter_post_kses($_POST['twt-link']) : '';
  $gp_link = isset($_POST['gp-link']) ? wp_filter_post_kses($_POST['gp-link']) : '';
  $msg_link = isset($_POST['msg-link']) ? wp_filter_post_kses($_POST['msg-link']) : '';
  $linkedin_link = isset($_POST['linkedin-link']) ? wp_filter_post_kses($_POST['linkedin-link']) : '';
  $mobile_phone = isset($_POST['mobile-phone']) ? wp_filter_post_kses($_POST['mobile-phone']) : '';
  $work_phone = isset($_POST['work-phone']) ? wp_filter_post_kses($_POST['work-phone']) : '';
  $agent_image = isset($_POST['agent-image']) ? wp_filter_post_kses($_POST['agent-image']) : '';
  $agent_banner = isset($_POST['agent-banner']) ? wp_filter_post_kses($_POST['agent-banner']) : '';
  $avnt_hacker = isset($_POST['hacker']) ? wp_filter_post_kses($_POST['hacker']) : '';
  $avnt_hustler = isset($_POST['hustler']) ? wp_filter_post_kses($_POST['hustler']) : '';
  $avnt_creative = isset($_POST['creative']) ? wp_filter_post_kses($_POST['creative']) : '';
  update_user_meta( $user_id, 'popular', $popular);
  update_user_meta( $user_id,'fb-link', $fb_link);
  update_user_meta( $user_id,'twt-link',$twt_link);
  update_user_meta( $user_id,'gp-link',$gp_link);
  update_user_meta( $user_id,'msg-link',$msg_link);
  update_user_meta( $user_id,'linkedin-link',$linkedin_link);
  update_user_meta( $user_id,'mobile-phone',$mobile_phone);
  update_user_meta( $user_id,'work-phone',$work_phone);
  update_user_meta( $user_id,'agent-image',$agent_image);
  update_user_meta( $user_id,'agent-banner',$agent_banner);
  update_user_meta( $user_id,'hacker', $avnt_hacker);
  update_user_meta( $user_id,'hustler', $avnt_hustler);
  update_user_meta( $user_id,'creative', $avnt_creative);
}
add_action( 'show_user_profile', 'imic_agent_fields');
add_action( 'edit_user_profile', 'imic_agent_fields');
add_action( 'personal_options_update', 'imic_save_agent_field' );
add_action( 'edit_user_profile_update', 'imic_save_agent_field' );

//Register user
function imic_agent_register() {
	if(!$_POST) exit;
	// Email address verification, do not edit.
	function isEmail($email) {
		return(preg_match("/^[-_.[:alnum:]]+@((([[:alnum:]]|[[:alnum:]][[:alnum:]-]*[[:alnum:]])\.)+(ad|ae|aero|af|ag|ai|al|am|an|ao|aq|ar|arpa|as|at|au|aw|az|ba|bb|bd|be|bf|bg|bh|bi|biz|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|com|coop|cr|cs|cu|cv|cx|cy|cz|de|dj|dk|dm|do|dz|ec|edu|ee|eg|eh|er|es|et|eu|fi|fj|fk|fm|fo|fr|ga|gb|gd|ge|gf|gh|gi|gl|gm|gn|gov|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|in|info|int|io|iq|ir|is|it|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|me|mg|mh|mil|mk|ml|mm|mn|mo|mp|mq|mr|ms|mt|mu|museum|mv|mw|mx|my|mz|na|name|nc|ne|net|nf|ng|ni|nl|no|np|nr|nt|nu|nz|om|org|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|pro|ps|pt|pw|py|qa|re|ro|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|sk|sl|sm|sn|so|sr|st|su|sv|sy|sz|tc|td|tf|tg|th|tj|tk|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|um|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|yu|za|zm|zw)$|(([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5])\.){3}([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5]))$/i",$email));
	}
	
	if (!defined("PHP_EOL")) define("PHP_EOL", "\r\n");
	
	$username     = $_POST['username'];
	$email    = $_POST['email'];
	$pwd1  = $_POST['pwd1'];
	$pwd2 = $_POST['pwd2'];
	$role = $_POST['role'];
    $hacker = $_POST['hacker'];
    $hustler = $_POST['hustler'];
    $creative = $_POST['creative'];
	
	if(trim($username) == '') {
		echo '<div class="alert alert-error">'.__('You must enter your username.','framework').'</div>';
		exit();
	} else if(trim($email) == '') {
		echo '<div class="alert alert-error">'.__('You must enter email address.','framework').'</div>';
		exit();
	} else if(!isEmail($email)) {
		echo '<div class="alert alert-error">'.__('You must enter a valid email address.','framework').'</div>';
		exit();
	}else if(trim($pwd1) == '') {
		echo '<div class="alert alert-error">'.__('You must enter password.','framework').'</div>';
		exit();
	}else if(trim($pwd2) == '') {
		echo '<div class="alert alert-error">'.__('You must enter repeat password.','framework').'</div>';
		exit();
	}else if(trim($pwd1) != trim($pwd2)) {
		echo '<div class="alert alert-error">'.__('You must enter a same password.','framework').'</div>';
		exit();
	}
	
	
	$err = '';
	$success = '';
	
	global $wpdb, $PasswordHash, $current_user, $user_ID;
	
	if (isset($_POST['task']) && $_POST['task'] == 'register') {
		$username = esc_sql(trim($_POST['username']));
		$pwd1 = esc_sql(trim($_POST['pwd1']));
		$pwd2 = esc_sql(trim($_POST['pwd2']));
		$email = esc_sql(trim($_POST['email']));
        $hacker = esc_sql(trim($_POST['hacker']));
        $hustler = esc_sql(trim($_POST['hustler']));
        $creative = esc_sql(trim($_POST['creative']));
	   
		if ($email == "" || $pwd1 == "" || $pwd2 == "" || $username == "") {
			$err = 'Please don\'t leave the required fields.';
		} else if ($pwd1 <> $pwd2) {
			$err = 'Password do not match.';
		} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$err = 'Invalid email address.';
		} else if (email_exists($email)) {
			$err = 'Email already exist.';
		} else {
	
			$user_id = wp_insert_user(
							array(
								'user_pass' => apply_filters('pre_user_user_pass', $pwd1), 
								'user_login' => apply_filters('pre_user_user_login', $username), 
								'user_email' => apply_filters('pre_user_user_email', $email), 
								'role' => $role)
							);
            update_user_meta($user_id, 'hacker', $hacker);
            update_user_meta($user_id, 'hustler', $hustler);
            update_user_meta($user_id, 'creative', $creative);
							
			if (is_wp_error($user_id)) {
				$err = 'Error on user creation.';
			} else {
				do_action('user_register', $user_id);
				$success = 'You\'re successfully register';
                                $info_register = array();
                                $info_register['user_login'] = $username;
                                $info_register['user_password'] = $pwd1;
                                wp_signon( $info_register, false );
                               }
		}
	}
	
	if (!empty($err)) :
		echo '<div class="alert alert-error">' . $err . '</div>';
	endif;
	
	if (!empty($success)) :
		echo '<div class="alert alert-success">' . $success . '</div>';
	endif;
    die();
}
add_action('wp_ajax_nopriv_imic_agent_register', 'imic_agent_register');
add_action('wp_ajax_imic_agent_register', 'imic_agent_register');

?>