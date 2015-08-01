<?php
if (!defined('ABSPATH'))
exit; // Exit if accessed directly
define('ImicFrameworkPath', dirname(__FILE__) . '/');
/*
* Here you include files which is required by theme
*/
/* Revslider INCLUDES
================================================== */
include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); 
if(is_plugin_inactive('revslider/revslider.php')){
/* Revslider INCLUDES
================================================== */
require_once(IMIC_FILEPATH . '/revslider/revslider.php');
}
require_once(ImicFrameworkPath . 'imic-theme-functions.php');
/* META BOX FRAMEWORK
================================================== */
require_once(ImicFrameworkPath . '/meta-box/meta-box.php');
require_once(ImicFrameworkPath . '/meta-boxes.php');
//require_once(ImicFrameworkPath . '/map-google.php');
/* SHORTCODES
 ================================================== */
require_once (ImicFrameworkPath . 'shortcodes.php');
/* CUSTOM POST TYPES
================================================== */
require_once(ImicFrameworkPath . '/custom-post-types/property-type.php');
require_once(ImicFrameworkPath . '/custom-post-types/testimonials-type.php');
require_once(ImicFrameworkPath . '/custom-post-types/partner-type.php');
/* WIDGETS INCLUDES
================================================== */
include_once(ImicFrameworkPath . '/widgets/agents.php');
include_once(ImicFrameworkPath . '/widgets/properties.php');
include_once(ImicFrameworkPath . '/widgets/property-slide.php');
include_once(ImicFrameworkPath . '/widgets/recent-posts.php');
include_once(ImicFrameworkPath . '/widgets/latest-news.php');
include_once(ImicFrameworkPath . '/widgets/testimonial.php');
include_once(ImicFrameworkPath . '/widgets/popular_agent.php');
include_once(ImicFrameworkPath . '/widgets/twitter_feeds/twitter_feeds.php');
include_once(ImicFrameworkPath . '/widgets/Newsletter/newsletter.php');
include_once(ImicFrameworkPath . '/widgets/search_properties.php');
/* PLUGIN INCLUDES
================================================== */
require_once(ImicFrameworkPath . '/plugin-includes.php');
/* LOAD STYLESHEETS
================================================== */
if (!function_exists('imic_enqueue_styles')) {
	function imic_enqueue_styles() {
		global $imic_options;
		$theme_info = wp_get_theme();
		wp_register_style('imic_bootstrap', IMIC_THEME_PATH . '/css/bootstrap.css', array(), $theme_info->get( 'Version' ), 'all');
		wp_register_style('imic_animations', IMIC_THEME_PATH . '/css/animations.css', array(), $theme_info->get( 'Version' ), 'all');
		wp_register_style('imic_font_awesome', IMIC_THEME_PATH . '/css/font-awesome.css', array(), $theme_info->get( 'Version' ), 'all');
        wp_register_style('imic_main', get_stylesheet_uri(), array(), $theme_info->get( 'Version' ), 'all');
        wp_register_style('imic_prettyPhoto', IMIC_THEME_PATH . '/plugins/prettyphoto/css/prettyPhoto.css', array(), $theme_info->get( 'Version' ), 'all');
		wp_register_style('imic_owl_carousel', IMIC_THEME_PATH . '/plugins/owl-carousel/css/owl.carousel.css', array(), $theme_info->get( 'Version' ), 'all');
		wp_register_style('imic_owl_theme', IMIC_THEME_PATH . '/plugins/owl-carousel/css/owl.theme.css', array(), $theme_info->get( 'Version' ), 'all');
		wp_register_style('imic_colors', IMIC_THEME_PATH . '/colors/' . $imic_options['theme_color_scheme'], array(), $theme_info->get( 'Version' ), 'all');
        wp_register_style('imic_bootstraprtl_css', IMIC_THEME_PATH . '/css/bootstrap-rtl.min.css', array(), $theme_info->get( 'Version' ), 'all');
        wp_register_style('imic_rtl_css', IMIC_THEME_PATH . '/css/rtl.css', array(), $theme_info->get( 'Version' ), 'all');
		//wp_register_style('imic_style_rtl', IMIC_THEME_PATH . '/style-rtl.css', array(), NULL, 'all');
        //**Enqueue STYLESHEETPATH**//
        wp_enqueue_style('imic_bootstrap');
        wp_enqueue_style('imic_animations');
        wp_enqueue_style('imic_font_awesome');
        wp_enqueue_style('imic_main');
        wp_enqueue_style('imic_prettyPhoto');
        wp_enqueue_style('imic_owl_carousel');
        wp_enqueue_style('imic_owl_theme');
        if ($imic_options['theme_color_type'][0] == 0) {
            wp_enqueue_style('imic_colors');
        }
		if ($imic_options['enable_rtl'] == 1) {
        	wp_enqueue_style('imic_bootstraprtl_css');
        	wp_enqueue_style('imic_rtl_css');
		}
        //**End Enqueue STYLESHEETPATH**//
    }
    add_action('wp_enqueue_scripts', 'imic_enqueue_styles', 99);
}
if (!function_exists('imic_enqueue_scripts')) {
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
		wp_localize_script('imic_jquery_init', 'urlajax', array('url' => admin_url('admin-ajax.php'),'tmpurl' => get_template_directory_uri(),'is_property'=>is_singular('property'),'sticky'=>$sticky_menu,'is_contact'=>is_page_template('template-contact.php'),'home_url'=>  site_url(),'is_payment'=>is_page_template('template-payment.php'),'register_url'=>imic_get_template_url('template-register.php'),'is_register'=>is_page_template('template-register.php'),'is_login'=>is_user_logged_in(),'is_submit_property'=>is_page_template('template-submit-property.php'),'basic'=>$basic,'advanced'=>$advanced));
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
}
/* LOAD BACKEND SCRIPTS
  ================================================== */
function imic_admin_scripts() {
     wp_register_script('imic-admin-functions', IMIC_THEME_PATH . '/js/imic_admin.js', 'jquery', NULL, TRUE);
    global $imic_options;
    $amenity_array_output='';
     if(isset($imic_options['properties_amenities'])&&count($imic_options['properties_amenities'])>1){
         $amenity_array_output.="<div id=\"amenity_array\"><div class=\"inside\"><div class=\"rwmb-meta-box\"><div class=\"rwmb-field rwmb-select-wrapper\"><div class=\"rwmb-label\"><label for=\"select_amenities\">".__('Select Amenities','framework')."</label></div><div class=\"rwmb-input\">";
         $amenity_array_output.='<select name ="amenity_array" id ="amenity_select_array">';
         $amenity_array_output.='<option value"select"="">'.__('Select','framework').'</option>';
         foreach($imic_options['properties_amenities'] as $properties_amenities){
         $am_name= strtolower(str_replace(' ','',$properties_amenities));
         $amenity_array_output.='<option value ="'.$am_name.'">'.$properties_amenities.'</option>';
         }
$amenity_array_output.='</select>';
 $amenity_array_output.='</div></div></div></div></div></div>';
    }
     $profile_page_condition =basename($_SERVER["SCRIPT_FILENAME"]);
if(($profile_page_condition=='user-edit.php')||($profile_page_condition=='profile.php'))
{
wp_enqueue_media();
}
   wp_enqueue_script('imic-admin-functions');
   wp_localize_script('imic-admin-functions', 'amenity_array', array('value' => $amenity_array_output));
}
add_action('admin_init', 'imic_admin_scripts');
/* LOAD BACKEND STYLE
  ================================================== */
function imic_admin_styles() {
    add_editor_style(IMIC_THEME_PATH . '/css/editor-style.css');
    echo '<style>.imic-image-select-repeatable-bg-image{width:50px;}</style>';
}
add_action('admin_head', 'imic_admin_styles');
?>