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
			wp_enqueue_script('agent-register', IMIC_THEME_PATH . '/js/agent-register.js', '', '', true);
	        wp_localize_script('agent-register', 'agent_register', array('ajaxurl' => admin_url('admin-ajax.php')));
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

?>