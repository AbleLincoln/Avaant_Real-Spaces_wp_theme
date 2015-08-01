<?php
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly
/*
	Here we have all the custom functions for the theme
  Please be extremely cautious editing this file,
  When things go wrong, they tend to go wrong in a big way.
  You have been warned!
 *
 * 	imic Framework Theme Functions
 * 	------------------------------------------------
 * 	imic Framework v1.0
 * 	Copyright imic  2014 - http://www.imithemes.com/
 *
 * 	imic_theme_activation()
 * 	imic_maintenance_mode()
 * 	imic_custom_login_logo()
 * 	imic_add_nofollow_cat()
 * 	imic_admin_bar_menu()
 * 	imic_admin_css()
 * 	imic_analytics()
 * 	imic_custom_styles()
 * 	imic_custom_script()
 *  imic_content_filter()
 *  imic_register_sidebars()
 *  imic_get_all_types()
 *	imic_page_banner()
 *  imic_agent_register()
 *  imic_agent_register()
 *  sight()
 *  imic_unidentified_agent()
 *  property_author_columns()
 *  property_author_column_content()
 *  add_query_vars_filter()
 *  imic_get_template_url()
 *  imic_get_all_sidebars()
 *  imic_register_meta_box()
 *  imic_country_wise_city()
 *  get_woocommerce_currency()
 *  get_woocommerce_currency_symbol()
 *  imic_agent_fields()
 *  imic_blacklist_body_class()
 *  imicAddCapToRole()
 *  imicPropertyDetailById()
 *  imic_get_multiple_city()
 *  imic_singe_property_banner()
 *  imicRevSliderShortCode()
 *  imicPropertyId()
 *  imicQuickEditProperty()
 *  imicBlogTemplateRedirect()
 *	imic_share_buttons()
 */
/* THEME ACTIVATION
  ================================================== */
if (!function_exists('imic_theme_activation')) {
    function imic_theme_activation() {
        global $pagenow;
        if (is_admin() && 'themes.php' == $pagenow && isset($_GET['activated'])) {
            #set frontpage to display_posts
            update_option('show_on_front', 'posts');
            #provide hook so themes can execute theme specific functions on activation
            do_action('imic_theme_activation');
            #redirect to options page
//            header('Location: ' . admin_url() . 'admin.php?page=imic_options&tab=0');
//            wp_redirect(admin_url() . 'admin.php?page=imic_options&tab=0');
        }
    }
    add_action('admin_init', 'imic_theme_activation');
}
/* MAINTENANCE MODE
  ================================================== */
if (!function_exists('imic_maintenance_mode')) {
    function imic_maintenance_mode() {
        $options = get_option('imic_options');
        $custom_logo = $custom_logo_output = $maintenance_mode = "";
        if (isset($options['custom_admin_login_logo'])) {
            $custom_logo = $options['custom_admin_login_logo'];
        }
        $custom_logo_output = '<img src="' . $custom_logo['url'] . '" alt="maintenance" style="height: 62px!important;margin: 0 auto; display: block;" />';
        if (isset($options['enable_maintenance'])) {
            $maintenance_mode = $options['enable_maintenance'];
        } else {
            $maintenance_mode = false;
        }
        if ($maintenance_mode) {
            if (!current_user_can('edit_themes') || !is_user_logged_in()) {
                wp_die($custom_logo_output . '<p style="text-align:center">' . __('We are currently in maintenance mode, please check back shortly.', 'framework') . '</p>', __('Maintenance Mode', 'framework'));
            }
        }
    }
    add_action('get_header', 'imic_maintenance_mode');
}
/* CUSTOM LOGIN LOGO
  ================================================== */
if (!function_exists('imic_custom_login_logo')) {
    function imic_custom_login_logo() {
        $options = get_option('imic_options');
        $custom_logo = "";
        if (isset($options['custom_admin_login_logo'])) {
            $custom_logo = $options['custom_admin_login_logo'];
        }
        echo '<style type="text/css">
			    .login h1 a { background-image:url(' . $custom_logo['url'] . ') !important; background-size: auto !important; width: auto !important; height: 95px !important; }
			</style>';
    }
    add_action('login_head', 'imic_custom_login_logo');
}
/* CATEGORY REL FIX
  ================================================== */
if (!function_exists('imic_add_nofollow_cat')) {
    function imic_add_nofollow_cat($text) {
        $text = str_replace('rel="category tag"', "", $text);
        return $text;
    }
    add_filter('the_category', 'imic_add_nofollow_cat');
}
/* ADMIN CUSTOM POST TYPE ICONS
  ================================================== */
if (!function_exists('imic_admin_css')) {
    function imic_admin_css() {
        $mywp_version = get_bloginfo('version');
        if ($mywp_version < 3.8) {
            ?>
            <style type="text/css" media="screen">
                #menu-posts-property .wp-menu-image {
                    background: url(<?php echo get_template_directory_uri(); ?>/images/wp/icon_property.png) no-repeat 6px 7px!important;
                    background-size: 17px 15px;
                }
                #menu-posts-testimonials .wp-menu-image {
                    background: url(<?php echo get_template_directory_uri(); ?>/images/wp/icon_testimonials.png) no-repeat 6px 11px!important;
                    background-size: 18px 9px;
                }
                #menu-posts-partner .wp-menu-image {
                    background: url(<?php echo get_template_directory_uri(); ?>/images/wp/icon_agents.png) no-repeat 6px 11px!important;
                    background-size: 18px 9px;
                }
                #menu-posts-slide .wp-menu-image {
                    background: url(<?php echo get_template_directory_uri(); ?>/images/wp/icon_slides.png) no-repeat 6px 11px!important;
                    background-size: 18px 9px;
                }
                #toplevel_page_imic_theme_options .wp-menu-image img {
                    width: 11px;
                    margin-top: -2px;
                    margin-left: 3px;
                }
                .toplevel_page_imic_theme_options #adminmenu li#toplevel_page_imic_theme_options.wp-has-current-submenu a.wp-has-current-submenu, .toplevel_page_imic_theme_options #adminmenu #toplevel_page_imic_theme_options .wp-menu-arrow div, .toplevel_page_imic_theme_options #adminmenu #toplevel_page_imic_theme_options .wp-menu-arrow {
                    background: #222;
                    border-color: #222;
                }
                #wpbody-content {
                    min-height: 815px;
                }
                .wp-list-table th#thumbnail, .wp-list-table td.thumbnail {
                    width: 80px;
                }
                .wp-list-table td.thumbnail img {
                    max-width: 100%;
                    height: auto;
                }
            </style>
            <?php
        } else {
            ?>
            <style type="text/css" media="screen">
                #toplevel_page_imic_theme_options .wp-menu-image img {
                    width: 11px;
                    margin-top: -2px;
                    margin-left: 3px;
                }
                .toplevel_page_imic_theme_options #adminmenu li#toplevel_page_imic_theme_options.wp-has-current-submenu a.wp-has-current-submenu, .toplevel_page_imic_theme_options #adminmenu #toplevel_page_imic_theme_options .wp-menu-arrow div, .toplevel_page_imic_theme_options #adminmenu #toplevel_page_imic_theme_options .wp-menu-arrow {
                    background: #222;
                    border-color: #222;
                }
                #wpbody-content {
                    min-height: 815px;
                }
                .wp-list-table th#thumbnail, .wp-list-table td.thumbnail {
                    width: 80px;
                }
                .wp-list-table td.thumbnail img {
                    max-width: 100%;
                    height: auto;
                }
            </style>	
            <?php
        }
    }
    add_action('admin_head', 'imic_admin_css');
}
/* ----------------------------------------------------------------------------------- */
/* Show analytics code in footer */
/* ----------------------------------------------------------------------------------- */
if (!function_exists('imic_analytics')) {
    function imic_analytics() {
        $options = get_option('imic_options');
        if ($options['tracking-code'] != "") {
            echo $options['tracking-code'];
        }
    }
    add_action('wp_head', 'imic_analytics');
}
/* CUSTOM CSS OUTPUT
  ================================================== */
if (!function_exists('imic_custom_styles')) {
    function imic_custom_styles() {
        $options = get_option('imic_options');
       
        // OPEN STYLE TAG
        echo '<style type="text/css">' . "\n";
        // Custom CSS
		$custom_user_css = $options['custom_css'];
        $custom_css = $options['theme_color_scheme'];
        if ($options['theme_color_type'][0] == 1) {
            $customColor = $options['custom_theme_color'];
            echo '.text-primary, .btn-primary .badge, .btn-link,a.list-group-item.active > .badge,.nav-pills > .active > a > .badge, p.drop-caps:first-child:first-letter, .accent-color, .post-more, ul.nav-list-primary > li a:hover, .widget_recent_comments a, .navigation > ul > li:hover > a, .flex-caption .hero-agent-contact, .property-info h4 a, .agent-info h4 a, .features-list li .icon, .property-listing h3 a, .agents-listing h3 a, .nav-tabs li.active > i, .nav-tabs li:hover > i, .location > i, .contact-info-blocks > div > i, .additional-amenities > span.available i, .error-404 h2 > i, .properties-table .action-button i, .pricing-column h3 {
	color:'.$customColor.';
}
a:hover, .testimonials > li cite a:hover, .property-listing h3 a:hover, .agents-listing h3 a:hover, .property-info h4 a:hover, .agent-info h4 a:hover{
	color:'.$customColor.';
}
.featured-gallery p, .post-more:hover, .widget_recent_comments a:hover, .property-info h4 a:hover{
	opacity:.9
}
p.drop-caps.secondary:first-child:first-letter, .accent-bg, .fa.accent-color, .btn-primary,
.btn-primary.disabled,
.btn-primary[disabled],
fieldset[disabled] .btn-primary,
.btn-primary.disabled:hover,
.btn-primary[disabled]:hover,
fieldset[disabled] .btn-primary:hover,
.btn-primary.disabled:focus,
.btn-primary[disabled]:focus,
fieldset[disabled] .btn-primary:focus,
.btn-primary.disabled:active,
.btn-primary[disabled]:active,
fieldset[disabled] .btn-primary:active,
.btn-primary.disabled.active,
.btn-primary[disabled].active,
fieldset[disabled] .btn-primary.active,
.dropdown-menu > .active > a,
.dropdown-menu > .active > a:hover,
.dropdown-menu > .active > a:focus,
.nav-pills > li.active > a,
.nav-pills > li.active > a:hover,
.nav-pills > li.active > a:focus,
.pagination > .active > a,
.pagination > .active > span,
.pagination > .active > a:hover,
.pagination > .active > span:hover,
.pagination > .active > a:focus,
.pagination > .active > span:focus,
.label-primary,
.progress-bar,
a.list-group-item.active,
a.list-group-item.active:hover,
a.list-group-item.active:focus,
.panel-primary > .panel-heading, .carousel-indicators .active, .owl-theme .owl-controls .owl-page.active span, .owl-theme .owl-controls.clickable .owl-page:hover span, hr.sm, .flex-control-nav a:hover, .flex-control-nav a.flex-active, .accordion-heading .accordion-toggle.active, .accordion-heading:hover .accordion-toggle, .accordion-heading:hover .accordion-toggle.inactive, .nav-tabs li a:hover, .nav-tabs li a:active, .nav-tabs li.active a, .fc-event, .site-header .social-icons a, .navigation > ul > li > ul > li:hover > a, .navigation > ul > li > ul > li > ul > li:hover a, .navigation > ul > li > ul > li > ul > li > ul > li:hover a, .top-header, .block-heading h4, .single-property .price, .timeline > li > .timeline-badge, .pricing-column.highlight h3, .site-footer-bottom .social-icons a:hover, .dsidx-results li.dsidx-prop-summary .dsidx-prop-title , .dsidx-results-grid #dsidx-listings .dsidx-listing .dsidx-data .dsidx-primary-data .dsidx-price, #dsidx-top-search #dsidx-search-form-wrap, .sidebar .widget .dsidx-expanded .featured-listing h4, .sidebar .widget .dsidx-expanded .featured-listing .property-item h4 a, .property-item h4 .sidebar .widget .dsidx-expanded .featured-listing a, .sidebar .widget .dsidx-slideshow .featured-listing h4, .sidebar .widget .dsidx-slideshow .featured-listing .property-item h4 a, .property-item h4 .sidebar .widget .dsidx-slideshow .featured-listing a, #dsidx-listings .dsidx-primary-data, .sidebar .widget .dsidx-search-widget .dsidx-search-button .submit, .dsidx-contact-form-submit{
  background-color: '.$customColor.';
}
.btn-primary:hover,
.btn-primary:focus,
.btn-primary:active,
.btn-primary.active,
.open .dropdown-toggle.btn-primary, .next-prev-nav a:hover, .staff-item .social-icons a:hover, .site-header .social-icons a:hover{
  background: '.$customColor.';
}
.nav .open > a,
.nav .open > a:hover,
.nav .open > a:focus,
.pagination > .active > a,
.pagination > .active > span,
.pagination > .active > a:hover,
.pagination > .active > span:hover,
.pagination > .active > a:focus,
.pagination > .active > span:focus,
a.thumbnail:hover,
a.thumbnail:focus,
a.thumbnail.active,
a.list-group-item.active,
a.list-group-item.active:hover,
a.list-group-item.active:focus,
.panel-primary,
.panel-primary > .panel-heading, .fc-event{
	border-color:'.$customColor.';
}
.panel-primary > .panel-heading + .panel-collapse .panel-body, .navigation ul > li:hover > a, .navigation ul > li.current_menu_item > a{
	border-top-color:'.$customColor.';
}
.panel-primary > .panel-footer + .panel-collapse .panel-body, .widget .widgettitle{
	border-bottom-color:'.$customColor.';
}
blockquote{
	border-left-color:'.$customColor.';
}
.share-buttons.share-buttons-tc > li > a{
  background: '.$customColor.'!important;
}
/* Color Scheme Specific Classes */';
        }
        // USER STYLES
        if ($custom_user_css) {
            echo "\n" . '/*========== User Custom CSS Styles ==========*/' . "\n";
            echo $custom_user_css;
        }
        // CLOSE STYLE TAG
        echo "</style>" . "\n";
    }
    add_action('wp_head', 'imic_custom_styles');
}
/* CUSTOM JS OUTPUT
  ================================================== */
if (!function_exists('imic_custom_script')) {
    function imic_custom_script() {
        $options = get_option('theme_options');
        $custom_js = $options['custom_js'];
        if ($custom_js) {
            echo'<script type ="text/javascript">';
            echo $custom_js;
            echo '</script>';
        }
    }
    add_action('wp_footer', 'imic_custom_script');
}
/* SHORTCODE FIX
  ================================================== */
if (!function_exists('imic_content_filter')) {
    function imic_content_filter($content) {
        // array of custom shortcodes requiring the fix 
        $block = join("|", array("htable", "thead", "tbody", "trow", "thcol", "tcol","agents","testimonial","pricingtable","headingss","reason","price","interval","row","url","imic_button","icon",  "paragraph", "divider", "heading", "alert", "blockquote", "dropcap", "code", "label", "container", "span", "one_full", "one_half", "one_third", "one_fourth", "one_sixth", "progress_bar", "imic_count", "imic_tooltip", "list", "list_item", "list_item_dt", "list_item_dd", "accordions", "accgroup", "acchead", "accbody", "toggles", "togglegroup", "togglehead", "togglebody", "tabs", "tabh", "tab", "tabc", "tabrow", "modal_box", "imic_form"));
        // opening tag
        $rep = preg_replace("/(<p>)?\[($block)(\s[^\]]+)?\](<\/p>|<br \/>)?/", "[$2$3]", $content);
        // closing tag
        $rep = preg_replace("/(<p>)?\[\/($block)](<\/p>|<br \/>)?/", "[/$2]", $rep);
        return $rep;
    }
    add_filter("the_content", "imic_content_filter");
}
/* REGISTER SIDEBARS
  ================================================== */
if (!function_exists('imic_register_sidebars')) {
    function imic_register_sidebars() {
        if (function_exists('register_sidebar')) {
			global $imic_options;
			$footerColumn = (isset($imic_options["footer_column"]))?$imic_options["footer_column"]:3;
            register_sidebar(array(
                'name' => __('Home Page Sidebar', 'framework'),
                'id' => 'main-sidebar',
                'description' => '',
                'class' => '',
                'before_widget' => '<div id="%1$s" class="widget sidebar-widget %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<h3 class="widgettitle">',
                'after_title' => '</h3>'
            ));
            register_sidebar(array(
                'name' => __('Agent Sidebar', 'framework'),
                'id' => 'agent-sidebar',
                'description' => '',
                'class' => '',
                'before_widget' => '<div id="%1$s" class="widget sidebar-widget %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<div class="sidebar-widget-title"><h3 class="widgettitle">',
                'after_title' => '</h3></div>'
            ));
            register_sidebar(array(
                'name' => __('Inner Page Sidebar', 'framework'),
                'id' => 'inner-sidebar',
                'description' => '',
                'class' => '',
                'before_widget' => '<div id="%1$s" class="widget sidebar-widget %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<div class="sidebar-widget-title"><h3 class="widgettitle">',
                'after_title' => '</h3></div>'
            ));
            register_sidebar(array(
                'name' => __('Blog Sidebar', 'framework'),
                'id' => 'blog-sidebar',
                'description' => '',
                'class' => '',
                'before_widget' => '<div class="widget sidebar-widget %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<div class="sidebar-widget-title"><h3 class="widgettitle">',
                'after_title' => '</h3></div>'
            ));
			register_sidebar(array(
                'name' => __('Post Sidebar', 'framework'),
                'id' => 'post-sidebar',
                'description' => '',
                'class' => '',
                'before_widget' => '<div class="widget sidebar-widget %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<div class="sidebar-widget-title"><h3 class="widgettitle">',
                'after_title' => '</h3></div>'
            ));
            register_sidebar(array(
                'name' => __('Footer Sidebar', 'framework'),
                'id' => 'footer-sidebar',
                'description' => '',
                'class' => '',
                'before_widget' => '<div class="col-md-'.$footerColumn.' col-sm-'.$footerColumn.' widget footer-widget %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<h3 class="widgettitle">',
                'after_title' => '</h3>'
            ));
        }
    }
    add_action('init', 'imic_register_sidebars', 35);
}
//Get All Post Types
if(!function_exists('imic_get_all_types')){
add_action( 'wp_loaded', 'imic_get_all_types');
function imic_get_all_types(){
   $args = array(
   'public'   => true,
   );
$output = 'names'; // names or objects, note names is the default
return $post_types = get_post_types($args, $output); 
}
}
/* Page Banner Code
================================================== */
if (!function_exists('imic_page_banner')) {
    function imic_page_banner($pageID) {
		global $imic_options; //Theme Global Variable
		$bannerHTML = '';
		
        /* Title/Banner Meta Box Details
		======================================*/
		$contactTitleText =  get_post_meta($pageID, 'imic_post_page_custom_title', true);
		$pageBannerType = get_post_meta($pageID, 'imic_banner_type', true);
		
		if ($pageBannerType == 'map') {
                 if(is_page_template('template-contact.php')){
                $class ="clearfix map-single-page";
				$bannerHTML .= '<!-- Site Showcase -->
							<div class="site-showcase"> 
							<!-- Start Page Header -->
                                                        <div class="'.$class.'" id="onemap"></div>                                                       
                                                        <!-- End Page Header --> 
							</div>';
            }else{
               $class="clearfix"; 
			   $bannerHTML .= '<!-- Site Showcase -->
							<div class="site-showcase"> 
							<!-- Start Page Header -->
                                                        <div class="'.$class.'" id="gmap"></div>                                                       
                                                        <!-- End Page Header --> 
							</div>';
            }
                /* Map Banner Code
			=================================*/
			
                        } else {
			$contactBannerImageID =  get_post_meta($pageID, 'imic_banner_image', true);
			$contactTitle = (empty($contactTitleText))? get_the_title($pageID) : $contactTitleText;
			$contactBanner = '';
			if(empty($contactBannerImageID)){
				$contactBanner .= $imic_options['banner_image']['url'];	
			}else{
				$customBannerImage = wp_get_attachment_image_src($contactBannerImageID, 'full');
				$contactBanner .= $customBannerImage[0];
			}
			
			/* Image Banner Code
			=================================*/
			$bannerHTML .= '<!-- Site Showcase -->
							<div class="site-showcase">
							<!-- Start Page Header -->
							<div class="parallax page-header" style="background-image:url('. $contactBanner .');">
								<div class="container">
									<div class="row">
										<div class="col-md-12">
											<h1>'. $contactTitle .'</h1>
										</div>
								   </div>
							   </div>
							</div>
							<!-- End Page Header -->
							</div>';
		} 
		
		echo $bannerHTML;
    }
}
/* Agent Register Funtion
  ================================================== */
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
/* INSERT ATTACHMENT
  ================================================== */
if(!function_exists('sight')) {
function sight($file_handler,$post_id,$set_thu=false) {
	// check to make sure its a successful upload
	if ($_FILES[$file_handler]['error'] !== UPLOAD_ERR_OK) __return_false();
	require_once(ABSPATH . "wp-admin" . '/includes/image.php');
	require_once(ABSPATH . "wp-admin" . '/includes/file.php');
	require_once(ABSPATH . "wp-admin" . '/includes/media.php');
	$attach_id = media_handle_upload( $file_handler, $post_id );
	return $attach_id;
}
}
/* UNDEFINED AGENT MESSAGE
  ===================================================*/
if(!function_exists('imic_unidentified_agent')) {
function imic_unidentified_agent(){
global $imic_options;
$content = '<div class="main" role="main">
  <div id="content" class="content full">
        <div class="container">
            <div class="page">
                <div class="row">
                    <div class="col-md-12">';
						$content .= do_shortcode($imic_options['logged_out_msg']);
					$content .= '</div>
                </div>
            </div>
        </div>
   </div>
</div>';
return $content;	
}
}
/* PROPERTY CUSTOM POST TYPE COLUMN
   =========================================================*/
if (!function_exists('property_author_columns')) {
    add_filter('manage_edit-property_columns', 'property_author_columns');
    function property_author_columns($columns) {
        $columns['author'] = __('Agent', 'framework');
		$columns['featured'] = __('Featured', 'framework');
		$columns['pid'] = __('Property ID', 'framework');
        return $columns;
    }
}
if (!function_exists('property_author_column_content')) {
    add_action('manage_property_posts_custom_column', 'property_author_column_content', 10, 2);
    function property_author_column_content($column_name, $post_id) {
        switch ($column_name) {
            case 'author':
                echo get_the_modified_author($post_id);
                break;
			case 'featured':
				$featured_box = get_post_meta($post_id,'imic_featured_property',true);
				echo ($featured_box==0)?'No':'Yes';
				break;
			case 'pid':
				$property_id = get_post_meta($post_id,'imic_property_site_id',true);
				if($property_id=='') { $new_id = 1648+$post_id; update_post_meta($post_id,'imic_property_site_id',imicPropertyIdWording().$new_id); }
				echo $property_id;
				break;
        }
    }
}
/* ADD QUERY ARGUMENTS
   =========================================================*/
if(!function_exists('add_query_vars_filter')) {
function add_query_vars_filter( $vars ){
  $vars[] = "remove";
  $vars[] = "site";
  $vars[] = "galleryPage";
  $vars[] = "all";
  return $vars;
}
add_filter( 'query_vars', 'add_query_vars_filter' );
}
/* GET TEMPLATE URL
   ================================================*/
if(!function_exists('imic_get_template_url')) {
function imic_get_template_url($TEMPLATE_NAME){
  $url;
 $pages = query_posts(array(
     'post_type' =>'page',
     'meta_key'  =>'_wp_page_template',
     'meta_value'=> $TEMPLATE_NAME
 ));
 $url = null;
 if(isset($pages[0])) {
     $url = get_page_link($pages[0]->ID);
 }
 wp_reset_query();
 return $url;
}
}
/**
 * Sidebar Meta Box.
 * @since NativeChurch 1.2
 */
if (!function_exists('imic_get_all_sidebars')) {
    function imic_get_all_sidebars() {
        $all_sidebars = array();
        global $wp_registered_sidebars;
        $all_sidebars = array('' => '');
        foreach ($wp_registered_sidebars as $sidebar) {
            $all_sidebars[$sidebar['id']] = $sidebar['name'];
        }
        return $all_sidebars;
    }
}
if (!function_exists('imic_register_meta_box')) {
    add_action('admin_init', 'imic_register_meta_box');
    function imic_register_meta_box() {
        // Check if plugin is activated or included in theme
        if (!class_exists('RW_Meta_Box'))
            return;
        $prefix = 'imic_';
        $meta_box = array(
            'id' => 'select_sidebar',
            'title' => 'Select Sidebar',
            'pages' => array('post', 'page', 'property'),
            'context' => 'normal',
            'fields' => array(
                array(
                    'name' => 'Select Sidebar from list',
                    'id' => $prefix . 'select_sidebar_from_list',
                    'desc' => __("Select Sidebar from list", 'framework'),
                    'type' => 'select',
                    'options' => imic_get_all_sidebars(),
                ),
            )
        );
        new RW_Meta_Box($meta_box);
    }
}
/* COUNTRY WISE LIST
   =======================================================*/
if(!function_exists('imic_country_wise_city')) {
function imic_country_wise_city($country) {
	switch($country) {
	case 'Algeria':
return array(8=>"Algeria","Alger" => "Alger" ,"Oran" => "Oran" ,"Constantine" => "Constantine" ,"Ouargla" => "Ouargla" ,"Medea" => "Medea" ,"Adrar" => "Adrar" ,"Laghouat" => "Laghouat" ,"Tizi" => "Tizi" ,"Ouzou" => "Ouzou" ,"Mostaganem" => "Mostaganem" ,"Bejaia" => "Bejaia" ,"Boumerdes" => "Boumerdes" ,"Chlef" => "Chlef" ,"Djelfa" => "Djelfa" ,"El" => "El" ,"Bayadh" => "Bayadh" ,"Oued" => "Oued" ,"Tarf" => "Tarf" ,"Ghardaia" => "Ghardaia" ,"Guelma" => "Guelma" ,"Illizi" => "Illizi" ,"Jijel" => "Jijel" ,"Khenchela" => "Khenchela" ,"Mascara" => "Mascara" ,"Mila" => "Mila" ,"M'sila" => "M'sila" ,"Naama" => "Naama" ,"Oum" => "Oum" ,"el" => "el" ,"Bouaghi" => "Bouaghi" ,"Relizane" => "Relizane" ,"Saida" => "Saida" ,"Setif" => "Setif" ,"Sidi" => "Sidi" ,"Bel" => "Bel" ,"Abbes" => "Abbes" ,"Skikda" => "Skikda" ,"Souk" => "Souk" ,"Ahras" => "Ahras" ,"Tamanghasset" => "Tamanghasset" ,"Tebessa" => "Tebessa" ,"Tiaret" => "Tiaret" ,"Tindouf" => "Tindouf" ,"Tipaza" => "Tipaza" ,"Tissemsilt" => "Tissemsilt" ,"Tlemcen" => "Tlemcen" ,"Ain" => "Ain" ,"Defla" => "Defla" ,"Temouchent" => "Temouchent" ,"Annaba" => "Annaba" ,"Batna" => "Batna" ,"Bechar" => "Bechar" ,"Biskra" => "Biskra" ,"Blida" => "Blida" ,"Bordj" => "Bordj" ,"Bou" => "Bou" ,"Arreridj" => "Arreridj" ,"Bouira" => "Bouira" );
break;
case 'Angola':
return array(8=>"Angola","Luanda" => "Luanda" ,"Benguela" => "Benguela" ,"Huambo" => "Huambo" ,"Bie" => "Bie" ,"Huila" => "Huila" ,"Malanje" => "Malanje" ,"Namibe" => "Namibe" ,"Zaire" => "Zaire" ,"Cabinda" => "Cabinda" ,"Uige" => "Uige" ,"Moxico" => "Moxico" ,"Lunda" => "Lunda" ,"Sul" => "Sul" ,"Cuanza" => "Cuanza" ,"Bengo" => "Bengo" ,"Norte" => "Norte" ,"Cuando" => "Cuando" ,"Cubango" => "Cubango" ,"Cunene" => "Cunene" );
break;
case 'Benin':
return array(8=>"Benin","Littoral" => "Littoral" ,"Zou" => "Zou" ,"Donga" => "Donga" ,"Borgou" => "Borgou" ,"Alibori" => "Alibori" ,"Collines" => "Collines" ,"Mono" => "Mono" ,"Atlanyique" => "Atlanyique" ,"Atakora" => "Atakora" ,"Plateau" => "Plateau" ,"Kouffo" => "Kouffo" ,"Oueme" => "Oueme" );
break;
case 'Botswana':
return array(8=>"Botswana","South-East" => "South-East" ,"Central" => "Central" ,"Kweneng" => "Kweneng" ,"North-East" => "North-East" ,"North-West" => "North-West" ,"Southern" => "Southern" ,"Kgatleng" => "Kgatleng" ,"Ghanzi" => "Ghanzi" ,"Kgalagadi" => "Kgalagadi" );
break;
case 'Burkina-Faso':
return array(8=>"Burkina Faso","Yatenga" => "Yatenga" ,"Sourou" => "Sourou" ,"Tapoa" => "Tapoa" ,"Tuy" => "Tuy" ,"Soum" => "Soum" ,"Sissili" => "Sissili" ,"Zondoma" => "Zondoma" ,"Zoundweogo" => "Zoundweogo" ,"Bale" => "Bale" ,"Ziro" => "Ziro" ,"Yagha" => "Yagha" );
break;
case 'Burundi':
return array(8=>"Burundi","Bujumbura" => "Bujumbura" ,"Muyinga" => "Muyinga" ,"Ruyigi" => "Ruyigi" ,"Bururi" => "Bururi" ,"Gitega" => "Gitega" ,"Ngozi" => "Ngozi" ,"Rutana" => "Rutana" ,"Makamba" => "Makamba" ,"Kayanza" => "Kayanza" ,"Muramvya" => "Muramvya" ,"Cibitoke" => "Cibitoke" ,"Bubanza" => "Bubanza" ,"Karuzi" => "Karuzi" ,"Cankuzo" => "Cankuzo" ,"Kirundo" => "Kirundo" ,"Mwaro" => "Mwaro" );
break;
case 'Cameroon':
return array(8=>"Cameroon","Littoral" => "Littoral" ,"Centre" => "Centre" ,"Extreme-Nord" => "Extreme-Nord" ,"Ouest" => "Ouest" ,"Nord-Ouest" => "Nord-Ouest" ,"Nord" => "Nord" ,"Sud-Ouest" => "Sud-Ouest" ,"Adamaoua" => "Adamaoua" ,"Est" => "Est" ,"Sud" => "Sud" );
break;
case 'Cape-Verde':
return array(8=>"Cape Verde","Sao Domingos" => "Sao Domingos" ,"Brava" => "Brava" ,"Maio" => "Maio" ,"Mosteiros" => "Mosteiros" ,"Paul" => "Paul" ,"Praia" => "Praia" ,"Ribeira Grande" => "Ribeira Grande" ,"Sal" => "Sal" ,"Santa Catarina" => "Santa Catarina" ,"Santa Cruz" => "Santa Cruz" ,"Sao Filipe" => "Sao Filipe" ,"Sao Miguel" => "Sao Miguel" ,"Sao Nicolau" => "Sao Nicolau" ,"Sao Vicente" => "Sao Vicente" ,"Boa Vista" => "Boa Vista" ,"Tarrafal" => "Tarrafal" );
break;
case 'Central-African-Republic':
return array(8=>"Central African Republic","Bangui" => "Bangui" ,"Mambere-Kadei" => "Mambere-Kadei" ,"Ouaka" => "Ouaka" ,"Ombella-Mpoko" => "Ombella-Mpoko" ,"Lobaye" => "Lobaye" ,"Ouham-Pende" => "Ouham-Pende" ,"Nana-Mambere" => "Nana-Mambere" ,"Mbomou" => "Mbomou" ,"Ouham" => "Ouham" ,"Sangha-Mbaere" => "Sangha-Mbaere" ,"Kemo" => "Kemo" ,"Haute-Kotto" => "Haute-Kotto" ,"Nana-Grebizi" => "Nana-Grebizi" ,"Basse-Kotto" => "Basse-Kotto" ,"Haut-Mbomou" => "Haut-Mbomou" ,"Bamingui-Bangoran" => "Bamingui-Bangoran" ,"Cuvette-Ouest" => "Cuvette-Ouest" );
break;
case 'Chad':
return array(8=>"Chad","Moyen-Chari" => "Moyen-Chari" ,"Logone Occidental" => "Logone Occidental" ,"Chari-Baguirmi" => "Chari-Baguirmi" ,"Mayo-Kebbi" => "Mayo-Kebbi" ,"Ouaddai" => "Ouaddai" ,"Tandjile" => "Tandjile" ,"Guera" => "Guera" ,"Batha" => "Batha" ,"Logone Oriental" => "Logone Oriental" ,"Kanem" => "Kanem" ,"Salamat" => "Salamat" ,"Borkou-Ennedi-Tibesti" => "Borkou-Ennedi-Tibesti" ,"Biltine" => "Biltine" ,"Lac" => "Lac" );
break;
case 'Comoros':
return array(8=>"Comoros","Grande Comore" => "Grande Comore" ,"Anjouan" => "Anjouan" ,"Moheli" => "Moheli" );
break;
case 'Congo':
return array(8=>"Congo","Brazzaville" => "Brazzaville" ,"Niari" => "Niari" ,"Bouenza" => "Bouenza" ,"Plateaux" => "Plateaux" ,"Kouilou" => "Kouilou" ,"Likouala" => "Likouala" ,"Sangha" => "Sangha" ,"Lekoumou" => "Lekoumou" ,"Cuvette" => "Cuvette" ,"Pool" => "Pool" ,"Cuvette-Ouest" => "Cuvette-Ouest" );
break;
case 'democratic-republic-of-the-congo':
return array(8=>"democratic republic of the congo","Kinshasa" => "Kinshasa" ,"Lubumbashi" => "Lubumbashi" ,"Mbuji-Mayi" => "Mbuji-Mayi" ,"Kisangani" => "Kisangani" ,"Likasi" => "Likasi" ,"Boma" => "Boma" ,"Bukavu" => "Bukavu" ,"Kikwit" => "Kikwit" ,"Mbandaka" => "Mbandaka" ,"Matadi" => "Matadi" ,"Uvira" => "Uvira" ,"Butembo" => "Butembo" ,"Gandajika" => "Gandajika" ,"Kalemie" => "Kalemie" ,"Goma" => "Goma" ,"Kindu" => "Kindu" ,"Bandundu" => "Bandundu" ,"Gemena" => "Gemena" ,"Bunia" => "Bunia" ,"Bumba" => "Bumba" ,"Beni" => "Beni" ,"Mbanza-Ngungu" => "Mbanza-Ngungu" ,"Kamina" => "Kamina" ,"Lisala" => "Lisala" ,"Kipushi" => "Kipushi" ,"Kabinda" => "Kabinda" ,"Kasongo" => "Kasongo" ,"Bulungu" => "Bulungu" ,"Basoko" => "Basoko" ,"Nioki" => "Nioki" ,"Inongo" => "Inongo" ,"Tshela" => "Tshela" ,"Bukama" => "Bukama" ,"Mangai" => "Mangai" ,"Kabare" => "Kabare" );
break;
case 'Djibouti':
return array(8=>"Djibouti","Ali Sabieh" => "Ali Sabieh" );
break;
case 'Egypt':
return array(8=>"Egypt","Al" => "Al" ,"Qahirah" => "Qahirah" ,"Al" => "Al" ,"Iskandariyah" => "Iskandariyah" ,"Jizah" => "Jizah" ,"Gharbiyah" => "Gharbiyah" ,"Qina" => "Qina" ,"Bur" => "Bur" ,"Sa'id" => "Sa'id" ,"Asyut" => "Asyut" ,"As" => "As" ,"Suways" => "Suways" ,"Ad" => "Ad" ,"Daqahliyah" => "Daqahliyah" ,"Fayyum" => "Fayyum" ,"Isma'iliyah" => "Isma'iliyah" ,"Matruh" => "Matruh" ,"Qalyubiyah" => "Qalyubiyah" ,"Bani" => "Bani" ,"Suwayf" => "Suwayf" ,"Aswan" => "Aswan" ,"Suhaj" => "Suhaj" ,"Bahr" => "Bahr" ,"al" => "al" ,"Ahmar" => "Ahmar" ,"Minya" => "Minya" ,"Dumyat" => "Dumyat" ,"Buhayrah" => "Buhayrah" ,"Kafr" => "Kafr" ,"ash" => "ash" ,"Shaykh" => "Shaykh" ,"Minufiyah" => "Minufiyah" ,"Ash" => "Ash" ,"Sharqiyah" => "Sharqiyah" ,"Janub" => "Janub" ,"Sina" => "Sina" ,"Shamal" => "Shamal" ,"Wadi" => "Wadi" ,"Jadid" => "Jadid" );
break;
case 'Equatorial-Guinea':
return array(8=>"Equatorial Guinea","Litoral" => "Litoral" ,"Bioko Norte" => "Bioko Norte" ,"Kie-Ntem" => "Kie-Ntem" ,"Centro Sur" => "Centro Sur" ,"Bioko Sur" => "Bioko Sur" ,"Wele-Nzas" => "Wele-Nzas" ,"Annobon" => "Annobon" );
break;
case 'Eritrea':
return array(8=>"Eritrea","Anseba" => "Anseba" ,"Debub" => "Debub" ,"Debubawi K'eyih Bahri" => "Debubawi K'eyih Bahri" ,"Gash Barka" => "Gash Barka" ,"Ma'akel" => "Ma'akel" ,"Semenawi K'eyih Bahri" => "Semenawi K'eyih Bahri" );
break;
case 'Ethiopia':
return array(8=>"Ethiopia","Dire Dawa" => "Dire Dawa" ,"Afar" => "Afar" ,"Amara" => "Amara" ,"Binshangul Gumuz" => "Binshangul Gumuz" ,"Gambela Hizboch" => "Gambela Hizboch" ,"Hareri Hizb" => "Hareri Hizb" ,"Oromiya" => "Oromiya" ,"Sumale" => "Sumale" ,"Tigray" => "Tigray" ,"Adis Abeba" => "Adis Abeba" ,"YeDebub Biheroch Bihereseboch na Hizboch" => "YeDebub Biheroch Bihereseboch na Hizboch" );
break;
case 'Gabon':
return array(8=>"Gabon","Estuaire" => "Estuaire" ,"Ogooue-Maritime" => "Ogooue-Maritime" ,"Haut-Ogooue" => "Haut-Ogooue" ,"Woleu-Ntem" => "Woleu-Ntem" ,"Ngounie" => "Ngounie" ,"Nyanga" => "Nyanga" ,"Moyen-Ogooue" => "Moyen-Ogooue" ,"Ogooue-Lolo" => "Ogooue-Lolo" ,"Ogooue-Ivindo" => "Ogooue-Ivindo" );
break;
case 'Gambia':
return array(8=>"Gambia","Western" => "Western" ,"Lower River" => "Lower River" ,"Banjul" => "Banjul" ,"Upper River" => "Upper River" ,"Central River" => "Central River" ,"North Bank" => "North Bank" );
break;
case 'Ghana':
return array(8=>"Ghana","Greater Accra" => "Greater Accra" ,"Ashanti" => "Ashanti" ,"Volta" => "Volta" ,"Western" => "Western" ,"Northern" => "Northern" ,"Central" => "Central" ,"Brong-Ahafo" => "Brong-Ahafo" ,"Upper East" => "Upper East" ,"Eastern" => "Eastern" ,"Upper West" => "Upper West" );
break;
case 'Guinea':
return array(8=>"Guinea","National Capital" => "National Capital" ,"Morobe" => "Morobe" ,"North Solomons" => "North Solomons" ,"Southern Highlands" => "Southern Highlands" ,"East New Britain" => "East New Britain" ,"Northern" => "Northern" ,"Western Highlands" => "Western Highlands" ,"Western" => "Western" ,"Madang" => "Madang" ,"Eastern Highlands" => "Eastern Highlands" ,"East Sepik" => "East Sepik" ,"West New Britain" => "West New Britain" ,"Sandaun" => "Sandaun" ,"New Ireland" => "New Ireland" ,"Milne Bay" => "Milne Bay" ,"Chimbu" => "Chimbu" ,"Enga" => "Enga" ,"Manus" => "Manus" ,"Gulf" => "Gulf" ,"Central" => "Central" );
break;
case 'Guinea-Bissau':
return array(8=>"Guinea Bissau","Bissau" => "Bissau" ,"Oio" => "Oio" ,"Cacheu" => "Cacheu" ,"Bafata" => "Bafata" ,"Gabu" => "Gabu" ,"Bolama" => "Bolama" ,"Tombali" => "Tombali" ,"Quinara" => "Quinara" ,"Biombo" => "Biombo" );
break;
case 'ivory-coast':
return array(8=>"ivory coast","Lagunes" => "Lagunes" ,"Vallee du Bandama" => "Vallee du Bandama" ,"Bas-Sassandra" => "Bas-Sassandra" ,"Haut-Sassandra" => "Haut-Sassandra" ,"Savanes" => "Savanes" ,"Fromager" => "Fromager" ,"Sud-Bandama" => "Sud-Bandama" ,"Moyen-Comoe" => "Moyen-Comoe" ,"Marahoue" => "Marahoue" ,"Dix-Huit Montagnes" => "Dix-Huit Montagnes" ,"Agneby" => "Agneby" ,"N'zi-Comoe" => "N'zi-Comoe" ,"Worodougou" => "Worodougou" ,"Zanzan" => "Zanzan" ,"Denguele" => "Denguele" ,"Moyen-Cavally" => "Moyen-Cavally" ,"Lacs" => "Lacs" ,"Sud-Comoe" => "Sud-Comoe" ,"Bafing" => "Bafing" );
break;
case 'Kenya':
return array(8=>"Kenya","Nairobi Area" => "Nairobi Area" ,"Coast" => "Coast" ,"Rift Valley" => "Rift Valley" ,"Nyanza" => "Nyanza" ,"Central" => "Central" ,"Western" => "Western" ,"Eastern" => "Eastern" ,"North-Eastern" => "North-Eastern" );
break;
case 'Lesotho':
return array(8=>"Lesotho","Maseru" => "Maseru" ,"Leribe" => "Leribe" ,"Mafeteng" => "Mafeteng" ,"Berea" => "Berea" ,"Quthing" => "Quthing" ,"Mokhotlong" => "Mokhotlong" ,"Thaba-Tseka" => "Thaba-Tseka" ,"Qachas Nek" => "Qachas Nek" ,"Mohales Hoek" => "Mohales Hoek" ,"Butha-Buthe" => "Butha-Buthe" );
break;
case 'Liberia':
return array(8=>"Liberia","Montserrado" => "Montserrado" ,"Bong" => "Bong" ,"Nimba" => "Nimba" ,"Maryland" => "Maryland" ,"Grand Bassa" => "Grand Bassa" ,"Grand Gedeh" => "Grand Gedeh" ,"Grand Cape Mount" => "Grand Cape Mount" ,"Monrovia" => "Monrovia" ,"Lofa" => "Lofa" ,"Gbarpolu" => "Gbarpolu" ,"River Cess" => "River Cess" ,"River Gee" => "River Gee" ,"Margibi" => "Margibi" ,"Sino" => "Sino" );
break;
case 'Libya':
return array(8=>"Libya","Tarabulus" => "Tarabulus" ,"Banghazi" => "Banghazi" ,"Misratah" => "Misratah" ,"An Nuqat al Khams" => "An Nuqat al Khams" ,"Tarhunah" => "Tarhunah" ,"Ajdabiya" => "Ajdabiya" ,"Tubruq" => "Tubruq" ,"Surt" => "Surt" ,"Sabha" => "Sabha" ,"Zlitan" => "Zlitan" ,"Darnah" => "Darnah" ,"Murzuq" => "Murzuq" ,"Yafran" => "Yafran" ,"Ghadamis" => "Ghadamis" ,"Al Jufrah" => "Al Jufrah" ,"Awbari" => "Awbari" ,"Az Zawiyah" => "Az Zawiyah" ,"Al Fatih" => "Al Fatih" ,"Al Aziziyah" => "Al Aziziyah" ,"Gharyan" => "Gharyan" ,"Ash Shati" => "Ash Shati" ,"Al Kufrah" => "Al Kufrah" ,"Sawfajjin" => "Sawfajjin" ,"Al Khums" => "Al Khums" ,"Al Jabal al Akhdar" => "Al Jabal al Akhdar" );
break;
case 'Madagascar':
return array(8=>"Madagascar","Antananarivo" => "Antananarivo" ,"Toamasina" => "Toamasina" ,"Fianarantsoa" => "Fianarantsoa" ,"Toliara" => "Toliara" ,"Mahajanga" => "Mahajanga" ,"Antsiranana" => "Antsiranana" );
break;
case 'Malawi':
return array(8=>"Malawi","Lilongwe" => "Lilongwe" ,"Blantyre" => "Blantyre" ,"Zomba" => "Zomba" ,"Mangochi" => "Mangochi" ,"Kasungu" => "Kasungu" ,"Balaka" => "Balaka" ,"Salima" => "Salima" ,"Karonga" => "Karonga" ,"Mulanje" => "Mulanje" ,"Rumphi" => "Rumphi" ,"Nkhotakota" => "Nkhotakota" ,"Nsanje" => "Nsanje" ,"Mzimba" => "Mzimba" ,"Ntchisi" => "Ntchisi" ,"Mchinji" => "Mchinji" ,"Dedza" => "Dedza" ,"Nkhata Bay" => "Nkhata Bay" ,"Mwanza" => "Mwanza" ,"Ntcheu" => "Ntcheu" ,"Chikwawa" => "Chikwawa" ,"Chitipa" => "Chitipa" ,"Thyolo" => "Thyolo" ,"Dowa" => "Dowa" ,"Phalombe" => "Phalombe" ,"Chiradzulu" => "Chiradzulu" ,"Machinga" => "Machinga" ,"Likoma" => "Likoma" );
break;
case 'Mali':
return array(8=>"Mali","Bamako" => "Bamako" ,"Sikasso" => "Sikasso" ,"Koulikoro" => "Koulikoro" ,"Kayes" => "Kayes" ,"Segou" => "Segou" ,"Mopti" => "Mopti" ,"Tombouctou" => "Tombouctou" ,"Gao" => "Gao" ,"Kidal" => "Kidal" );
break;
case 'Mauritania':
return array(8=>"Mauritania","Trarza" => "Trarza" ,"Dakhlet Nouadhibou" => "Dakhlet Nouadhibou" ,"Adrar" => "Adrar" ,"Brakna" => "Brakna" ,"Gorgol" => "Gorgol" ,"Guidimaka" => "Guidimaka" ,"Hodh Ech Chargui" => "Hodh Ech Chargui" ,"Hodh El Gharbi" => "Hodh El Gharbi" ,"Inchiri" => "Inchiri" ,"Tagant" => "Tagant" ,"Tiris Zemmour" => "Tiris Zemmour" ,"Assaba" => "Assaba" );
break;
case 'Mauritius':
return array(8=>"Mauritius","Plaines Wilhems" => "Plaines Wilhems" ,"Port Louis" => "Port Louis" ,"Flacq" => "Flacq" ,"Riviere du Rempart" => "Riviere du Rempart" ,"Pamplemousses" => "Pamplemousses" ,"Grand Port" => "Grand Port" ,"Moka" => "Moka" ,"Savanne" => "Savanne" ,"Black River" => "Black River" ,"Rodrigues" => "Rodrigues" ,"Agalega Islands" => "Agalega Islands" );
break;
case 'Morocco':
return array(8=>"Morocco","Chaouia-Ouardigha" => "Chaouia-Ouardigha" ,"Doukkala-Abda" => "Doukkala-Abda" ,"Fes-Boulemane" => "Fes-Boulemane" ,"Gharb-Chrarda-Beni Hssen" => "Gharb-Chrarda-Beni Hssen" ,"Grand Casablanca" => "Grand Casablanca" ,"Guelmim-Es Smara" => "Guelmim-Es Smara" ,"Marrakech-Tensift-Al Haouz" => "Marrakech-Tensift-Al Haouz" ,"Meknes-Tafilalet" => "Meknes-Tafilalet" ,"Oriental" => "Oriental" ,"Rabat-Sale-Zemmour-Zaer" => "Rabat-Sale-Zemmour-Zaer" ,"Tadla-Azilal" => "Tadla-Azilal" ,"Tanger-Tetouan" => "Tanger-Tetouan" ,"Taza-Al Hoceima-Taounate" => "Taza-Al Hoceima-Taounate" );
break;
case 'Mozambique':
return array(8=>"Mozambique","Maputo" => "Maputo" ,"Nampula" => "Nampula" ,"Sofala" => "Sofala" ,"Gaza" => "Gaza" ,"Manica" => "Manica" ,"Zambezia" => "Zambezia" ,"Inhambane" => "Inhambane" ,"Niassa" => "Niassa" ,"Cabo Delgado" => "Cabo Delgado" ,"Tete" => "Tete" );
break;
case 'Namibia':
return array(8=>"Namibia","Windhoek" => "Windhoek" ,"Erongo" => "Erongo" ,"Otjozondjupa" => "Otjozondjupa" ,"Karas" => "Karas" ,"Okavango" => "Okavango" ,"Oshana" => "Oshana" ,"Hardap" => "Hardap" ,"Caprivi" => "Caprivi" ,"Kunene" => "Kunene" ,"Omaheke" => "Omaheke" ,"Oshikoto" => "Oshikoto" ,"Ohangwena" => "Ohangwena" ,"Omusati" => "Omusati" ,"Okahandja" => "Okahandja" ,"Omaruru" => "Omaruru" ,"Otjiwarongo" => "Otjiwarongo" ,"Outjo" => "Outjo" ,"Rehoboth" => "Rehoboth" ,"Swakopmund" => "Swakopmund" ,"Tsumeb" => "Tsumeb" ,"Maltahohe" => "Maltahohe" ,"Boesmanland" => "Boesmanland" ,"Damaraland" => "Damaraland" ,"Gobabis" => "Gobabis" ,"Grootfontein" => "Grootfontein" ,"Kaokoland" => "Kaokoland" ,"Karasburg" => "Karasburg" ,"Karibib" => "Karibib" ,"Kavango" => "Kavango" ,"Keetmanshoop" => "Keetmanshoop" ,"Luderitz" => "Luderitz" ,"Bethanien" => "Bethanien" ,"Mariental" => "Mariental" );
break;
case 'Niger':
return array(8=>"Niger","Niamey" => "Niamey" ,"Maradi" => "Maradi" ,"Zinder" => "Zinder" ,"Agadez" => "Agadez" ,"Tahoua" => "Tahoua" ,"Dosso" => "Dosso" ,"Diffa" => "Diffa" );
break;
case 'Nigeria':
return array(8=>"Nigeria","Lagos" => "Lagos" ,"Oyo" => "Oyo" ,"Kano" => "Kano" ,"Kaduna" => "Kaduna" ,"Edo" => "Edo" ,"Borno" => "Borno" ,"Rivers" => "Rivers" ,"Osun" => "Osun" ,"Enugu" => "Enugu" ,"Ogun" => "Ogun" ,"Delta" => "Delta" ,"Plateau" => "Plateau" ,"Kwara" => "Kwara" ,"Yobe" => "Yobe" ,"Anambra" => "Anambra" ,"Adamawa" => "Adamawa" ,"Nassarawa" => "Nassarawa" ,"Cross" => "Cross" ,"River" => "River" ,"Sokoto" => "Sokoto" ,"Niger" => "Niger" ,"Bauchi" => "Bauchi" ,"Ondo" => "Ondo" ,"Katsina" => "Katsina" ,"Gombe" => "Gombe" ,"Ekiti" => "Ekiti" ,"Abia" => "Abia" ,"Federal" => "Federal" ,"Capital" => "Capital" ,"Territory" => "Territory" ,"Ebonyi" => "Ebonyi" ,"Benue" => "Benue" ,"Zamfara" => "Zamfara" ,"Imo" => "Imo" ,"Jigawa" => "Jigawa" ,"Akwa" => "Akwa" ,"Ibom" => "Ibom" ,"Taraba" => "Taraba" ,"Kebbi" => "Kebbi" ,"Kogi" => "Kogi" );
break;
case 'Rwanda':
return array(8=>"Rwanda","Kigali" => "Kigali" ,"Butare" => "Butare" ,"Kibungo" => "Kibungo" ,"Gitarama" => "Gitarama" ,"Est" => "Est" ,"Nord" => "Nord" ,"Ouest" => "Ouest" ,"Sud" => "Sud" );
break;
case 'saint-helena':
return array(8=>"saint helena","Ascension" => "Ascension" ,"Saint Helena" => "Saint Helena" ,"Tristan da Cunha" => "Tristan da Cunha" );
break;
case 'Sao-Tome-Principe':
return array(8=>"Sao Tome Principe","Principe" => "Principe" ,"Sao Tome" => "Sao Tome" );
break;
case 'Senegal':
return array(8=>"Senegal","Dakar" => "Dakar" ,"Thies" => "Thies" ,"Kaolack" => "Kaolack" ,"Ziguinchor" => "Ziguinchor" ,"Diourbel" => "Diourbel" ,"Saint-Louis" => "Saint-Louis" ,"Kolda" => "Kolda" ,"Fatick" => "Fatick" ,"Louga" => "Louga" ,"Tambacounda" => "Tambacounda" ,"Matam" => "Matam" );
break;
case 'Seychelles':
return array(8=>"Seychelles","Beau Vallon" => "Beau Vallon" ,"Anse Boileau" => "Anse Boileau" ,"Anse Etoile" => "Anse Etoile" ,"Anse Louis" => "Anse Louis" ,"Anse Royale" => "Anse Royale" ,"Baie Lazare" => "Baie Lazare" ,"Baie Sainte Anne" => "Baie Sainte Anne" ,"Bel Air" => "Bel Air" ,"Bel Ombre" => "Bel Ombre" ,"Cascade" => "Cascade" ,"Glacis" => "Glacis" ,"Grand' Anse" => "Grand' Anse" ,"La Digue" => "La Digue" ,"La Riviere Anglaise" => "La Riviere Anglaise" ,"Mont Buxton" => "Mont Buxton" ,"Mont Fleuri" => "Mont Fleuri" ,"Plaisance" => "Plaisance" ,"Pointe La Rue" => "Pointe La Rue" ,"Port Glaud" => "Port Glaud" ,"Saint Louis" => "Saint Louis" ,"Anse aux Pins" => "Anse aux Pins" ,"Takamaka" => "Takamaka" );
break;
case 'Sierra-Leone':
return array(8=>"Sierra Leone","Eastern" => "Eastern" ,"Northern" => "Northern" ,"Southern" => "Southern" ,"Western" => "Western" );
break;
case 'Somalia':
return array(8=>"Somalia","Banaadir" => "Banaadir" ,"Woqooyi Galbeed" => "Woqooyi Galbeed" ,"Jubbada Hoose" => "Jubbada Hoose" ,"Shabeellaha Hoose" => "Shabeellaha Hoose" ,"Bari" => "Bari" ,"Nugaal" => "Nugaal" ,"Shabeellaha Dhexe" => "Shabeellaha Dhexe" ,"Jubbada Dhexe" => "Jubbada Dhexe" ,"Bakool" => "Bakool" ,"Bay" => "Bay" ,"Mudug" => "Mudug" ,"Galguduud" => "Galguduud" ,"Sanaag" => "Sanaag" ,"Hiiraan" => "Hiiraan" ,"Gedo" => "Gedo" );
break;
case 'South-Africa':
return array(8=>"South Africa","Gauteng" => "Gauteng" ,"KwaZulu-Natal" => "KwaZulu-Natal" ,"Western" => "Western" ,"Cape" => "Cape" ,"Eastern" => "Eastern" ,"Free" => "Free" ,"State" => "State" ,"North-West" => "North-West" ,"Mpumalanga" => "Mpumalanga" ,"Limpopo" => "Limpopo" ,"Northern" => "Northern" ,"North-Western" => "North-Western" ,"Province" => "Province" );
break;
case 'Sudan':
return array(8=>"Sudan","Al Khartum" => "Al Khartum" ,"Al Wusta" => "Al Wusta" ,"Central Equatoria State" => "Central Equatoria State" ,"Upper Nile" => "Upper Nile" ,"Kurdufan" => "Kurdufan" ,"Al Istiwa'iyah" => "Al Istiwa'iyah" ,"Bahr al Ghazal" => "Bahr al Ghazal" ,"Ash Sharqiyah" => "Ash Sharqiyah" ,"Ash Shamaliyah" => "Ash Shamaliyah" ,"Darfur" => "Darfur" ,"Al Wahadah State" => "Al Wahadah State" );
break;
case 'Swaziland':
return array(8=>"Swaziland","Manzini" => "Manzini" ,"Hhohho" => "Hhohho" ,"Shiselweni" => "Shiselweni" ,"Lubombo" => "Lubombo" );
break;
case 'Tanzania':
return array(8=>"Tanzania","Dar es Salaam" => "Dar es Salaam" ,"Mbeya" => "Mbeya" ,"Mwanza" => "Mwanza" ,"Shinyanga" => "Shinyanga" ,"Morogoro" => "Morogoro" ,"Zanzibar Urban" => "Zanzibar Urban" ,"Arusha" => "Arusha" ,"Iringa" => "Iringa" ,"Tanga" => "Tanga" ,"Kagera" => "Kagera" ,"Kigoma" => "Kigoma" ,"Singida" => "Singida" ,"Mara" => "Mara" ,"Ruvuma" => "Ruvuma" ,"Mtwara" => "Mtwara" ,"Dodoma" => "Dodoma" ,"Tabora" => "Tabora" ,"Kilimanjaro" => "Kilimanjaro" ,"Rukwa" => "Rukwa" ,"Lindi" => "Lindi" ,"Manyara" => "Manyara" ,"Pwani" => "Pwani" ,"Pemba North" => "Pemba North" ,"Pemba South" => "Pemba South" ,"Zanzibar North" => "Zanzibar North" ,"Zanzibar Central" => "Zanzibar Central" );
break;
case 'Togo':
return array(8=>"Togo","Kara" => "Kara" ,"Centrale" => "Centrale" ,"Plateaux" => "Plateaux" ,"Savanes" => "Savanes" ,"Maritime" => "Maritime" );
break;
case 'Tunisia':
return array(8=>"Tunisia","Tunis" => "Tunis" ,"Sfax" => "Sfax" ,"Sousse" => "Sousse" ,"Nabeul" => "Nabeul" ,"Bizerte" => "Bizerte" ,"Al Munastir" => "Al Munastir" ,"Gabes" => "Gabes" ,"Jendouba" => "Jendouba" ,"Madanin" => "Madanin" ,"Qafsah" => "Qafsah" ,"Tataouine" => "Tataouine" ,"Bajah" => "Bajah" ,"Tozeur" => "Tozeur" ,"Kebili" => "Kebili" ,"Sidi Bou Zid" => "Sidi Bou Zid" ,"Kasserine" => "Kasserine" ,"Siliana" => "Siliana" ,"El Kef" => "El Kef" ,"Zaghouan" => "Zaghouan" ,"Al Mahdia" => "Al Mahdia" ,"Ben Arous" => "Ben Arous" ,"Kairouan" => "Kairouan" ,"Manouba" => "Manouba" ,"Aiana" => "Aiana" );
break;
case 'Uganda':
return array(8=>"Uganda","Kampala" => "Kampala" ,"Mukono" => "Mukono" ,"Gulu" => "Gulu" ,"Lira" => "Lira" ,"Arua" => "Arua" ,"Jinja" => "Jinja" ,"Mbarara" => "Mbarara" ,"Kasese" => "Kasese" ,"Luwero" => "Luwero" ,"Masaka" => "Masaka" ,"Mbale" => "Mbale" ,"Kalangala" => "Kalangala" ,"Kitgum" => "Kitgum" ,"Iganga" => "Iganga" ,"Mubende" => "Mubende" ,"Nebbi" => "Nebbi" ,"Tororo" => "Tororo" ,"Hoima" => "Hoima" ,"Soroti" => "Soroti" ,"Kabarole" => "Kabarole" ,"Busia" => "Busia" ,"Rukungiri" => "Rukungiri" ,"Pallisa" => "Pallisa" ,"Masindi" => "Masindi" ,"Wakiso" => "Wakiso" ,"Kaberamaido" => "Kaberamaido" ,"Adjumani" => "Adjumani" ,"Bushenyi" => "Bushenyi" ,"Rakai" => "Rakai" ,"Kayunga" => "Kayunga" ,"Kyenjojo" => "Kyenjojo" ,"Kotido" => "Kotido" ,"Yumbe" => "Yumbe" ,"Kamwenge" => "Kamwenge" ,"Bundibugyo" => "Bundibugyo" ,"Sironko" => "Sironko" ,"Kiboga" => "Kiboga" ,"Moyo" => "Moyo" ,"Kanungu" => "Kanungu" ,"Kamuli" => "Kamuli" ,"Apac" => "Apac" ,"Kisoro" => "Kisoro" ,"Mayuge" => "Mayuge" ,"Mpigi" => "Mpigi" ,"Kapchorwa" => "Kapchorwa" ,"Kumi" => "Kumi" ,"Katakwi" => "Katakwi" ,"Moroto" => "Moroto" ,"Nakasongola" => "Nakasongola" ,"Sembabule" => "Sembabule" ,"Nakapiripirit" => "Nakapiripirit" ,"Kibale" => "Kibale" ,"Ntungamo" => "Ntungamo" ,"Pader" => "Pader" ,"Bugiri" => "Bugiri" );
break;
case 'Zambia':
return array(8=>"Zambia","Central" => "Central" ,"Lusaka" => "Lusaka" ,"Luapula" => "Luapula" ,"Northern" => "Northern" ,"Southern" => "Southern" ,"North-Western" => "North-Western" ,"Eastern" => "Eastern" ,"Copperbelt" => "Copperbelt" ,"Western" => "Western" );
break;
case 'Zimbabwe':
return array(8=>"Zimbabwe","Mashonaland East" => "Mashonaland East" ,"Matabeleland North" => "Matabeleland North" ,"Matabeleland South" => "Matabeleland South" ,"Mashonaland Central" => "Mashonaland Central" ,"Masvingo" => "Masvingo" ,"Bulawayo" => "Bulawayo" ,"Midlands" => "Midlands" ,"Harare" => "Harare" ,"Manicaland" => "Manicaland" ,"Mashonaland West" => "Mashonaland West" );
break;
case 'Bangladesh':
return array(8=>"Bangladesh","Dhaka" => "Dhaka" ,"Khulna" => "Khulna" ,"Rajshahi" => "Rajshahi" ,"Chittagong" => "Chittagong" ,"Sylhet" => "Sylhet" ,"Barisal" => "Barisal" );
break;
case 'Bhutan':
return array(8=>"Bhutan","Chhukha" => "Chhukha" ,"Punakha" => "Punakha" ,"Samdrup" => "Samdrup" ,"Geylegphug" => "Geylegphug" ,"Bumthang" => "Bumthang" ,"Paro" => "Paro" ,"Tashigang" => "Tashigang" ,"Wangdi Phodrang" => "Wangdi Phodrang" ,"Daga" => "Daga" ,"Tongsa" => "Tongsa" ,"Chirang" => "Chirang" ,"Lhuntshi" => "Lhuntshi" ,"Pemagatsel" => "Pemagatsel" ,"Ha" => "Ha" ,"Mongar" => "Mongar" ,"Shemgang" => "Shemgang" ,"Thimphu" => "Thimphu" ,"Samchi" => "Samchi" );
break;
case 'Brunei':
return array(8=>"Brunei","Belait" => "Belait" ,"Brunei and Muara" => "Brunei and Muara" ,"Plateau" => "Plateau" ,"Temburong" => "Temburong" ,"Tutong" => "Tutong" );
break;
case 'Myanmar':
return array(8=>"Myanmar","Mandalay" => "Mandalay" ,"Irrawaddy" => "Irrawaddy" ,"Mon State" => "Mon State" ,"Sagaing" => "Sagaing" ,"Shan State" => "Shan State" ,"Pegu" => "Pegu" ,"Rakhine State" => "Rakhine State" ,"Kachin State" => "Kachin State" ,"Magwe" => "Magwe" ,"Kayah State" => "Kayah State" ,"Chin State" => "Chin State" ,"Karan State" => "Karan State" ,"Rangoon" => "Rangoon" );
break;
case 'Cambodia':
return array(8=>"Cambodia","Phnum Penh" => "Phnum Penh" ,"Kampong Cham" => "Kampong Cham" ,"Kampong Chhnang" => "Kampong Chhnang" ,"Pursat" => "Pursat" ,"Kandal" => "Kandal" ,"Svay Rieng" => "Svay Rieng" ,"Batdambang" => "Batdambang" ,"Kampot" => "Kampot" ,"Kracheh" => "Kracheh" ,"Kampong Thum" => "Kampong Thum" ,"Ratanakiri Kiri" => "Ratanakiri Kiri" ,"Mondulkiri" => "Mondulkiri" ,"Takeo" => "Takeo" ,"Kampong Speu" => "Kampong Speu" ,"Koh Kong" => "Koh Kong" ,"Pailin" => "Pailin" ,"Preah Vihear" => "Preah Vihear" ,"Prey Veng" => "Prey Veng" ,"Siem Reap" => "Siem Reap" ,"Stung Treng" => "Stung Treng" ,"Banteay Meanchey" => "Banteay Meanchey" );
break;
case 'China':
return array(8=>"China","Guangdong" => "Guangdong" ,"Liaoning" => "Liaoning" ,"Shanghai" => "Shanghai" ,"Jiangsu" => "Jiangsu" ,"Shandong" => "Shandong" ,"Heilongjiang" => "Heilongjiang" ,"Hubei" => "Hubei" ,"Henan" => "Henan" ,"Hebei" => "Hebei" ,"Jilin" => "Jilin" ,"Sichuan" => "Sichuan" ,"Beijing" => "Beijing" ,"Anhui" => "Anhui" ,"Zhejiang" => "Zhejiang" ,"Hunan" => "Hunan" ,"Shaanxi" => "Shaanxi" ,"Shanxi" => "Shanxi" ,"Chongqing" => "Chongqing" ,"Tianjin" => "Tianjin" ,"Xinjiang" => "Xinjiang" ,"Jiangxi" => "Jiangxi" ,"Fujian" => "Fujian" ,"Guangxi" => "Guangxi" ,"Nei Mongol" => "Nei Mongol" ,"Guizhou" => "Guizhou" ,"Gansu" => "Gansu" ,"Yunnan" => "Yunnan" ,"Hainan" => "Hainan" ,"Ningxia" => "Ningxia" ,"Qinghai" => "Qinghai" ,"Xizang" => "Xizang" );
break;
case 'India':
return array(8=>"India","Maharashtra" => "Maharashtra" ,"Uttar Pradesh" => "Uttar Pradesh" ,"Delhi" => "Delhi" ,"West Bengal" => "West Bengal" ,"Gujarat" => "Gujarat" ,"Tamil Nadu" => "Tamil Nadu" ,"Andhra Pradesh" => "Andhra Pradesh" ,"Karnataka" => "Karnataka" ,"Madhya Pradesh" => "Madhya Pradesh" ,"Rajasthan" => "Rajasthan" ,"Bihar" => "Bihar" ,"Punjab" => "Punjab" ,"Haryana" => "Haryana" ,"Kerala" => "Kerala" ,"Jharkhand" => "Jharkhand" ,"Orissa" => "Orissa" ,"Chhattisgarh" => "Chhattisgarh" ,"Assam" => "Assam" ,"Jammu and Kashmir" => "Jammu and Kashmir" ,"Uttarakhand" => "Uttarakhand" ,"Chandigarh" => "Chandigarh" ,"Goa" => "Goa" ,"Himachal Pradesh" => "Himachal Pradesh" ,"Manipur" => "Manipur" ,"Mizoram" => "Mizoram" ,"Tripura" => "Tripura" ,"Meghalaya" => "Meghalaya" ,"Nagaland" => "Nagaland" ,"Puducherry" => "Puducherry" ,"Daman and Diu" => "Daman and Diu" ,"Arunachal Pradesh" => "Arunachal Pradesh" ,"Andaman and Nicobar Islands" => "Andaman and Nicobar Islands" ,"Dadra and Nagar Haveli" => "Dadra and Nagar Haveli" ,"Sikkim" => "Sikkim" ,"Lakshadweep" => "Lakshadweep" );
break;
case 'Indonesia':
return array(8=>"Indonesia","Jawa Barat" => "Jawa Barat" ,"Jakarta Raya" => "Jakarta Raya" ,"Jawa Timur" => "Jawa Timur" ,"Jawa Tengah" => "Jawa Tengah" ,"Sumatera Utara" => "Sumatera Utara" ,"Yogyakarta" => "Yogyakarta" ,"Kalimantan Timur" => "Kalimantan Timur" ,"Sumatera Barat" => "Sumatera Barat" ,"Banten" => "Banten" ,"Lampung" => "Lampung" ,"Kalimantan Selatan" => "Kalimantan Selatan" ,"Sulawesi Utara" => "Sulawesi Utara" ,"Bali" => "Bali" ,"Kalimantan Barat" => "Kalimantan Barat" ,"Jambi" => "Jambi" ,"Nusa Tenggara Timur" => "Nusa Tenggara Timur" ,"Nusa Tenggara Barat" => "Nusa Tenggara Barat" ,"Aceh" => "Aceh" ,"Sulawesi Tengah" => "Sulawesi Tengah" ,"Bengkulu" => "Bengkulu" ,"Sulawesi Tenggara" => "Sulawesi Tenggara" ,"Kalimantan Tengah" => "Kalimantan Tengah" ,"Papua" => "Papua" ,"Riau" => "Riau" ,"Sulawesi Barat" => "Sulawesi Barat" ,"Maluku" => "Maluku" ,"Irian Jaya Barat" => "Irian Jaya Barat" ,"Sumatera Selatan" => "Sumatera Selatan" ,"Gorontalo" => "Gorontalo" ,"Sulawesi Selatan" => "Sulawesi Selatan" ,"Maluku Utara" => "Maluku Utara" ,"Kepulauan Riau" => "Kepulauan Riau" ,"Kepulauan Bangka Belitung" => "Kepulauan Bangka Belitung" );
break;
case 'Japan':
return array(8=>"Japan","Tokyo" => "Tokyo" ,"Kanagawa" => "Kanagawa" ,"Osaka" => "Osaka" ,"Aichi" => "Aichi" ,"Chiba" => "Chiba" ,"Hyogo" => "Hyogo" ,"Saitama" => "Saitama" ,"Hokkaido" => "Hokkaido" ,"Fukuoka" => "Fukuoka" ,"Shizuoka" => "Shizuoka" ,"Hiroshima" => "Hiroshima" ,"Kyoto" => "Kyoto" ,"Ibaraki" => "Ibaraki" ,"Miyagi" => "Miyagi" ,"Niigata" => "Niigata" ,"Tochigi" => "Tochigi" ,"Nagano" => "Nagano" ,"Okayama" => "Okayama" ,"Gumma" => "Gumma" ,"Mie" => "Mie" ,"Fukushima" => "Fukushima" ,"Gifu" => "Gifu" ,"Yamaguchi" => "Yamaguchi" ,"Kagoshima" => "Kagoshima" ,"Kumamoto" => "Kumamoto" ,"Ehime" => "Ehime" ,"Nagasaki" => "Nagasaki" ,"Okinawa" => "Okinawa" ,"Aomori" => "Aomori" ,"Nara" => "Nara" ,"Yamagata" => "Yamagata" ,"Ishikawa" => "Ishikawa" ,"Oita" => "Oita" ,"Iwate" => "Iwate" ,"Shiga" => "Shiga" ,"Toyama" => "Toyama" ,"Miyazaki" => "Miyazaki" ,"Akita" => "Akita" ,"Wakayama" => "Wakayama" ,"Fukui" => "Fukui" ,"Kagawa" => "Kagawa" ,"Tokushima" => "Tokushima" ,"Saga" => "Saga" ,"Kochi" => "Kochi" ,"Shimane" => "Shimane" ,"Yamanashi" => "Yamanashi" ,"Tottori" => "Tottori" );
break;
case 'Kazakhstan':
return array(8=>"Kazakhstan","Almaty City" => "Almaty City" ,"East Kazakhstan" => "East Kazakhstan" ,"South Kazakhstan" => "South Kazakhstan" ,"Pavlodar" => "Pavlodar" ,"Zhambyl" => "Zhambyl" ,"Qaraghandy" => "Qaraghandy" ,"Astana" => "Astana" ,"Qostanay" => "Qostanay" ,"Aqtobe" => "Aqtobe" ,"Almaty" => "Almaty" ,"Mangghystau" => "Mangghystau" ,"North Kazakhstan" => "North Kazakhstan" ,"Atyrau" => "Atyrau" ,"Aqmola" => "Aqmola" ,"Qyzylorda" => "Qyzylorda" ,"West Kazakhstan" => "West Kazakhstan" ,"Bayqonyr" => "Bayqonyr" );
break;
case 'Korea-north':
return array(8=>"Korea north","Chagang-do" => "Chagang-do" ,"Hamgyong-bukto" => "Hamgyong-bukto" ,"Hamgyong-namdo" => "Hamgyong-namdo" ,"Hwanghae-bukto" => "Hwanghae-bukto" ,"Hwanghae-namdo" => "Hwanghae-namdo" ,"Kaesong-si" => "Kaesong-si" ,"Kangwon-do" => "Kangwon-do" ,"Najin Sonbong-si" => "Najin Sonbong-si" ,"Namp'o-si" => "Namp'o-si" ,"P'yongan-bukto" => "P'yongan-bukto" ,"P'yongan-namdo" => "P'yongan-namdo" ,"P'yongyang-si" => "P'yongyang-si" ,"Yanggang-do" => "Yanggang-do" );
break;
case 'Korea-south':
return array(8=>"Korea south","Seoul-t'ukpyolsi" => "Seoul-t'ukpyolsi" ,"Cholla-bukto" => "Cholla-bukto" ,"Cholla-namdo" => "Cholla-namdo" ,"Ch'ungch'ong-bukto" => "Ch'ungch'ong-bukto" ,"Ch'ungch'ong-namdo" => "Ch'ungch'ong-namdo" ,"Inch'on-jikhalsi" => "Inch'on-jikhalsi" ,"Kangwon-do" => "Kangwon-do" ,"Kwangju-jikhalsi" => "Kwangju-jikhalsi" ,"Kyonggi-do" => "Kyonggi-do" ,"Kyongsang-bukto" => "Kyongsang-bukto" ,"Kyongsang-namdo" => "Kyongsang-namdo" ,"Pusan-jikhalsi" => "Pusan-jikhalsi" ,"Taegu-jikhalsi" => "Taegu-jikhalsi" ,"Taejon-jikhalsi" => "Taejon-jikhalsi" ,"Cheju-do" => "Cheju-do" ,"Ulsan-gwangyoksi" => "Ulsan-gwangyoksi" );
break;
case 'Laos':
return array(8=>"Laos","Vientiane" => "Vientiane" ,"Champasak" => "Champasak" ,"Savannakhet" => "Savannakhet" ,"Louangphrabang" => "Louangphrabang" ,"Houaphan" => "Houaphan" ,"Saravan" => "Saravan" ,"Khammouan" => "Khammouan" ,"Xiangkhoang" => "Xiangkhoang" ,"Louang Namtha" => "Louang Namtha" ,"Oudomxai" => "Oudomxai" ,"Phongsali" => "Phongsali" ,"Xaignabouri" => "Xaignabouri" ,"Attapu" => "Attapu" );
break;
case 'Malaysia':
return array(8=>"Malaysia","Johor" => "Johor" ,"Kuala Lumpur" => "Kuala Lumpur" ,"Selangor" => "Selangor" ,"Sabah" => "Sabah" ,"Perak" => "Perak" ,"Sarawak" => "Sarawak" ,"Kedah" => "Kedah" ,"Pahang" => "Pahang" ,"Negeri Sembilan" => "Negeri Sembilan" ,"Pulau Pinang" => "Pulau Pinang" ,"Melaka" => "Melaka" ,"Terengganu" => "Terengganu" ,"Kelantan" => "Kelantan" ,"Perlis" => "Perlis" ,"Labuan" => "Labuan" ,"Putrajaya" => "Putrajaya" );
break;
case 'Maldives':
return array(8=>"Maldives","Maale" => "Maale" ,"Seenu" => "Seenu" ,"Faafu" => "Faafu" ,"Gaafu Alifu" => "Gaafu Alifu" ,"Gaafu Dhaalu" => "Gaafu Dhaalu" ,"Gnaviyani" => "Gnaviyani" ,"Haa Alifu" => "Haa Alifu" ,"Haa Dhaalu" => "Haa Dhaalu" ,"Kaafu" => "Kaafu" ,"Laamu" => "Laamu" ,"Lhaviyani" => "Lhaviyani" ,"Meemu" => "Meemu" ,"Noonu" => "Noonu" ,"Raa" => "Raa" ,"Shaviyani" => "Shaviyani" ,"Thaa" => "Thaa" ,"Baa" => "Baa" ,"Vaavu" => "Vaavu" ,"Dhaalu" => "Dhaalu" );
break;
case 'Mongolia':
return array(8=>"Mongolia","Ulaanbaatar" => "Ulaanbaatar" ,"Hentiy" => "Hentiy" ,"Orhon" => "Orhon" ,"Uvs" => "Uvs" ,"Ovorhangay" => "Ovorhangay" ,"Hovsgol" => "Hovsgol" ,"Selenge" => "Selenge" ,"Bulgan" => "Bulgan" ,"Suhbaatar" => "Suhbaatar" ,"Dundgovi" => "Dundgovi" ,"Arhangay" => "Arhangay" ,"Hovd" => "Hovd" ,"Omnogovi" => "Omnogovi" ,"Tov" => "Tov" ,"Govisumber" => "Govisumber" ,"Bayanhongor" => "Bayanhongor" ,"Bayan-Olgiy" => "Bayan-Olgiy" ,"Darhan" => "Darhan" ,"Darhan-Uul" => "Darhan-Uul" ,"Dornod" => "Dornod" ,"Dornogovi" => "Dornogovi" ,"Dzavhan" => "Dzavhan" ,"Erdenet" => "Erdenet" ,"Govi-Altay" => "Govi-Altay" );
break;
case 'Nepal':
return array(8=>"Nepal","Janakpur" => "Janakpur" ,"Bheri" => "Bheri" ,"Dhawalagiri" => "Dhawalagiri" ,"Gandaki" => "Gandaki" ,"Karnali" => "Karnali" ,"Kosi" => "Kosi" ,"Lumbini" => "Lumbini" ,"Mahakali" => "Mahakali" ,"Mechi" => "Mechi" ,"Narayani" => "Narayani" ,"Rapti" => "Rapti" ,"Sagarmatha" => "Sagarmatha" ,"Bagmati" => "Bagmati" ,"Seti" => "Seti" );
break;
case 'Philippines':
return array(8=>"Philippines","Manila" => "Manila" ,"Laguna" => "Laguna" ,"Rizal" => "Rizal" ,"Pangasinan" => "Pangasinan" ,"Davao City" => "Davao City" ,"Cavite" => "Cavite" ,"Pampanga" => "Pampanga" ,"Negros Occidental" => "Negros Occidental" ,"Cebu" => "Cebu" ,"Nueva Ecija" => "Nueva Ecija" ,"Cebu City" => "Cebu City" ,"Tarlac" => "Tarlac" ,"Davao" => "Davao" ,"South Cotabato" => "South Cotabato" ,"Quezon" => "Quezon" ,"Zamboanga del Sur" => "Zamboanga del Sur" ,"Zamboanga" => "Zamboanga" ,"General Santos" => "General Santos" ,"Isabela" => "Isabela" ,"Negros Oriental" => "Negros Oriental" ,"Leyte" => "Leyte" ,"Iloilo" => "Iloilo" ,"Davao del Sur" => "Davao del Sur" ,"Iloilo City" => "Iloilo City" ,"Iligan" => "Iligan" ,"Misamis Oriental" => "Misamis Oriental" ,"Maguindanao" => "Maguindanao" ,"Mandaue" => "Mandaue" ,"Palawan" => "Palawan" ,"Zambales" => "Zambales" ,"Sulu" => "Sulu" ,"Lipa" => "Lipa" ,"North Cotabato" => "North Cotabato" ,"Sorsogon" => "Sorsogon" ,"La Union" => "La Union" ,"Mindoro Oriental" => "Mindoro Oriental" ,"Surigao del Sur" => "Surigao del Sur" ,"Lapu-Lapu" => "Lapu-Lapu" ,"Davao Oriental" => "Davao Oriental" ,"Lucena" => "Lucena" ,"Mindoro Occidental" => "Mindoro Occidental" ,"San Pablo" => "San Pablo" ,"Olongapo" => "Olongapo" ,"Legaspi" => "Legaspi" ,"Agusan del Sur" => "Agusan del Sur" ,"Tacloban" => "Tacloban" ,"Cotabato" => "Cotabato" ,"Masbate" => "Masbate" ,"Sultan Kudarat" => "Sultan Kudarat" ,"Toledo" => "Toledo" ,"Puerto Princesa" => "Puerto Princesa" ,"Northern Samar" => "Northern Samar" ,"Nueva Vizcaya" => "Nueva Vizcaya" ,"Naga" => "Naga" ,"Marawi" => "Marawi" ,"Ilocos Sur" => "Ilocos Sur" ,"Samar" => "Samar" ,"Ormoc" => "Ormoc" ,"San Carlos" => "San Carlos" ,"Surigao del Norte" => "Surigao del Norte" ,"Roxas" => "Roxas" ,"Eastern Samar" => "Eastern Samar" ,"Cavite City" => "Cavite City" ,"Zamboanga del Norte" => "Zamboanga del Norte" ,"Dumaguete" => "Dumaguete" ,"Ilocos Norte" => "Ilocos Norte" ,"Silay" => "Silay" ,"Agusan del Norte" => "Agusan del Norte" ,"Ozamis" => "Ozamis" ,"Laoag" => "Laoag" ,"Dipolog" => "Dipolog" ,"Lanao del Norte" => "Lanao del Norte" ,"Iriga" => "Iriga" ,"Romblon" => "Romblon" ,"Surigao" => "Surigao" ,"Tagbilaran" => "Tagbilaran" ,"Danao" => "Danao" ,"Tawitawi" => "Tawitawi" ,"Lanao del Sur" => "Lanao del Sur" ,"Gingoog" => "Gingoog" ,"Kalinga-Apayao" => "Kalinga-Apayao" ,"Misamis Occidental" => "Misamis Occidental" ,"Dapitan" => "Dapitan" ,"Tagaytay" => "Tagaytay" ,"Marinduque" => "Marinduque" ,"Oroquieta" => "Oroquieta" ,"Quirino" => "Quirino" ,"La Carlota" => "La Carlota" ,"Southern Leyte" => "Southern Leyte" ,"Abra" => "Abra" ,"Mountain" => "Mountain" ,"Tangub" => "Tangub" ,"Palayan" => "Palayan" ,"Ifugao" => "Ifugao" ,"Siquijor" => "Siquijor" ,"Pagadian" => "Pagadian" ,"Trece Martires" => "Trece Martires" ,"Quezon City" => "Quezon City" ,"San Jose" => "San Jose" ,"Pasay" => "Pasay" ,"Dagupan" => "Dagupan" );
break;
case 'russia':
return array(8=>"russia","Moskau" => "Moskau" ,"Moskovskaja Oblast" => "Moskovskaja Oblast" ,"Krasnodar" => "Krasnodar" ,"Sankt Petersburg" => "Sankt Petersburg" ,"Sverdlovsk" => "Sverdlovsk" ,"Tatarstan" => "Tatarstan" ,"Rostov" => "Rostov" ,"Samara" => "Samara" ,"Baskortostan" => "Baskortostan" ,"Kemerovo" => "Kemerovo" ,"Niznij Novgorod" => "Niznij Novgorod" ,"Dagestan" => "Dagestan" ,"Stavropol" => "Stavropol" ,"Volgograd" => "Volgograd" ,"Saratov" => "Saratov" ,"Perm" => "Perm" ,"Irkutsk" => "Irkutsk" ,"Krasnojarsk" => "Krasnojarsk" ,"Orenburg" => "Orenburg" ,"Novosibirsk" => "Novosibirsk" ,"Omsk" => "Omsk" ,"Altaj" => "Altaj" ,"Primorje" => "Primorje" ,"Voronez" => "Voronez" ,"Leningrad" => "Leningrad" ,"Tula" => "Tula" ,"Belgorod" => "Belgorod" ,"Vladimir" => "Vladimir" ,"Hanty-Mansija" => "Hanty-Mansija" ,"Kirov" => "Kirov" ,"Penza" => "Penza" ,"Vologda" => "Vologda" ,"Habarovsk" => "Habarovsk" ,"Udmurtija" => "Udmurtija" ,"Kursk" => "Kursk" ,"Tambov" => "Tambov" ,"Jaroslavl" => "Jaroslavl" ,"Tomsk" => "Tomsk" ,"Tver" => "Tver" ,"Tjumen" => "Tjumen" ,"Uljanovsk" => "Uljanovsk" ,"Arhangelsk" => "Arhangelsk" ,"Smolensk" => "Smolensk" ,"Brjansk" => "Brjansk" ,"Ivanovo" => "Ivanovo" ,"Amur" => "Amur" ,"Murmansk" => "Murmansk" ,"Lipeck" => "Lipeck" ,"Rjazan" => "Rjazan" ,"Kabardino-Balkarija" => "Kabardino-Balkarija" ,"Kaluga" => "Kaluga" ,"Komi" => "Komi" ,"Astrahan" => "Astrahan" ,"Kaliningrad" => "Kaliningrad" ,"Saha" => "Saha" ,"Pskov" => "Pskov" ,"Kostroma" => "Kostroma" ,"Burjatija" => "Burjatija" ,"Kurgan" => "Kurgan" ,"Alanija" => "Alanija" ,"Mordovija" => "Mordovija" ,"Orjol" => "Orjol" ,"Karelija" => "Karelija" ,"Jamalo-Nenets" => "Jamalo-Nenets" ,"Ingusetija" => "Ingusetija" ,"Novgorod" => "Novgorod" ,"Marij El" => "Marij El" ,"Sahalin" => "Sahalin" ,"Hakasija" => "Hakasija" ,"Adygeja" => "Adygeja" ,"Tyva" => "Tyva" ,"Kalmykija" => "Kalmykija" ,"Magadan" => "Magadan" ,"Jevrej" => "Jevrej" ,"Gorno-Altaj" => "Gorno-Altaj" ,"Komi-Permjak" => "Komi-Permjak" ,"Ust-Orda" => "Ust-Orda" ,"Aga" => "Aga" ,"Tajmyr" => "Tajmyr" ,"Nenets" => "Nenets" ,"Evenkija" => "Evenkija" ,"Korjakija" => "Korjakija" ,"Indiana" => "Indiana" ,"Ohio" => "Ohio" ,"Alaska" => "Alaska" ,"Sector claimed by Australia" => "Sector claimed by Australia" );
break;
case 'Sri-Lanka':
return array(8=>"Sri Lanka","Western" => "Western" ,"Northern" => "Northern" ,"Central" => "Central" ,"Southern" => "Southern" ,"North Central" => "North Central" ,"Uva" => "Uva" ,"Sabaragamuwa" => "Sabaragamuwa" ,"North Western" => "North Western" ,"Jaffna" => "Jaffna" ,"Kalutara" => "Kalutara" ,"Kandy" => "Kandy" ,"Kegalla" => "Kegalla" ,"Kurunegala" => "Kurunegala" ,"Mannar" => "Mannar" ,"Matale" => "Matale" ,"Amparai" => "Amparai" ,"Moneragala" => "Moneragala" ,"Mullaittivu" => "Mullaittivu" ,"Nuwara Eliya" => "Nuwara Eliya" ,"Polonnaruwa" => "Polonnaruwa" ,"Puttalam" => "Puttalam" ,"Ratnapura" => "Ratnapura" ,"Trincomalee" => "Trincomalee" ,"Vavuniya" => "Vavuniya" ,"Matara" => "Matara" ,"Anuradhapura" => "Anuradhapura" ,"Badulla" => "Badulla" ,"Batticaloa" => "Batticaloa" ,"Colombo" => "Colombo" ,"Galle" => "Galle" ,"Gampaha" => "Gampaha" ,"Hambantota" => "Hambantota" );
break;
case 'Taiwan':
return array(8=>"Taiwan","T'ai-wan" => "T'ai-wan" ,"T'ai-pei" => "T'ai-pei" ,"Kao-hsiung" => "Kao-hsiung" ,"Fu-chien" => "Fu-chien" );
break;
case 'Thailand':
return array(8=>"Thailand","Krung Thep" => "Krung Thep" ,"Chon Buri" => "Chon Buri" ,"Nonthaburi" => "Nonthaburi" ,"Samut Prakan" => "Samut Prakan" ,"Nakhon Ratchasima" => "Nakhon Ratchasima" ,"Songkhla" => "Songkhla" ,"Pathum Thani" => "Pathum Thani" ,"Udon Thani" => "Udon Thani" ,"Khon Kaen" => "Khon Kaen" ,"Ratchaburi" => "Ratchaburi" ,"Surat Thani" => "Surat Thani" ,"Chiang Mai" => "Chiang Mai" ,"Ubon Ratchathani" => "Ubon Ratchathani" ,"Nakhon Si Thammarat" => "Nakhon Si Thammarat" ,"Rayong" => "Rayong" ,"Chiang Rai" => "Chiang Rai" ,"Phra Nakhon Si Ayutthaya" => "Phra Nakhon Si Ayutthaya" ,"Samut Sakhon" => "Samut Sakhon" ,"Lampang" => "Lampang" ,"Nakhon Pathom" => "Nakhon Pathom" ,"Kanchanaburi" => "Kanchanaburi" ,"Kalasin" => "Kalasin" ,"Prachuap Khiri Khan" => "Prachuap Khiri Khan" ,"Phetchabun" => "Phetchabun" ,"Chanthaburi" => "Chanthaburi" ,"Phitsanulok" => "Phitsanulok" ,"Saraburi" => "Saraburi" ,"Nakhon Sawan" => "Nakhon Sawan" ,"Narathiwat" => "Narathiwat" ,"Chaiyaphum" => "Chaiyaphum" ,"Nong Khai" => "Nong Khai" ,"Phuket" => "Phuket" ,"Yala" => "Yala" ,"Chachoengsao" => "Chachoengsao" ,"Phetchaburi" => "Phetchaburi" ,"Pattani" => "Pattani" ,"Tak" => "Tak" ,"Trang" => "Trang" ,"Sukhothai" => "Sukhothai" ,"Sakon Nakhon" => "Sakon Nakhon" ,"Phichit" => "Phichit" ,"Suphan Buri" => "Suphan Buri" ,"Lop Buri" => "Lop Buri" ,"Maha Sarakham" => "Maha Sarakham" ,"Roi Et" => "Roi Et" ,"Kamphaeng Phet" => "Kamphaeng Phet" ,"Phrae" => "Phrae" ,"Chumphon" => "Chumphon" ,"Lamphun" => "Lamphun" ,"Nakhon Phanom" => "Nakhon Phanom" ,"Ang Thong" => "Ang Thong" ,"Uttaradit" => "Uttaradit" ,"Sisaket" => "Sisaket" ,"Prachin Buri" => "Prachin Buri" ,"Loei" => "Loei" ,"Phayao" => "Phayao" ,"Buriram" => "Buriram" ,"Surin" => "Surin" ,"Krabi" => "Krabi" ,"Phatthalung" => "Phatthalung" ,"Mukdahan" => "Mukdahan" ,"Uthai Thani" => "Uthai Thani" ,"Nan" => "Nan" ,"Sing Buri" => "Sing Buri" ,"Trat" => "Trat" ,"Samut Songkhram" => "Samut Songkhram" ,"Amnat Charoen" => "Amnat Charoen" ,"Satun" => "Satun" ,"Sa Kaeo" => "Sa Kaeo" ,"Ranong" => "Ranong" ,"Yasothon" => "Yasothon" ,"Nakhon Nayok" => "Nakhon Nayok" ,"Chai Nat" => "Chai Nat" ,"Phangnga" => "Phangnga" ,"Mae Hong Son" => "Mae Hong Son" ,"Nong Bua Lamphu" => "Nong Bua Lamphu" );
break;
case 'Vietnam':
return array(8=>"Vietnam","Ho Chi Minh" => "Ho Chi Minh" ,"Dac Lac" => "Dac Lac" ,"An Giang" => "An Giang" ,"Hai Phong" => "Hai Phong" ,"Binh Dinh" => "Binh Dinh" ,"Kien Giang" => "Kien Giang" ,"Quang Ninh" => "Quang Ninh" ,"Nghe An" => "Nghe An" ,"Can Tho" => "Can Tho" ,"Dong Thap" => "Dong Thap" ,"Dong Nai" => "Dong Nai" ,"Nam Dinh" => "Nam Dinh" ,"Thai Nguyen" => "Thai Nguyen" ,"Lam Dong" => "Lam Dong" ,"Tien Giang" => "Tien Giang" ,"Nam Ha" => "Nam Ha" ,"Song Be" => "Song Be" ,"Thanh Hoa" => "Thanh Hoa" ,"Vinh Long" => "Vinh Long" ,"Soc Trang" => "Soc Trang" ,"Ha Giang" => "Ha Giang" ,"Ba Ria-Vung Tau" => "Ba Ria-Vung Tau" ,"Phu Yen" => "Phu Yen" ,"Quang Binh" => "Quang Binh" ,"Quang Nam" => "Quang Nam" ,"Ha Tinh" => "Ha Tinh" ,"Phu Tho" => "Phu Tho" ,"Hoa Binh" => "Hoa Binh" ,"Long An" => "Long An" ,"Ben Tre" => "Ben Tre" ,"Hai Duong" => "Hai Duong" ,"Ninh Binh" => "Ninh Binh" ,"Quang Ngai" => "Quang Ngai" ,"Thai Binh" => "Thai Binh" ,"Tay Ninh" => "Tay Ninh" ,"Binh Thuan" => "Binh Thuan" ,"Kon Tum" => "Kon Tum" ,"Thua Thien" => "Thua Thien" ,"Cao Bang" => "Cao Bang" ,"Ha Noi" => "Ha Noi" ,"Dien Bien" => "Dien Bien" ,"Ha Tay" => "Ha Tay" ,"Lao Cai" => "Lao Cai" ,"Ninh Thuan" => "Ninh Thuan" ,"Lang Son" => "Lang Son" ,"Vinh Phu" => "Vinh Phu" ,"Ha Nam" => "Ha Nam" ,"Khanh Hoa" => "Khanh Hoa" ,"Tuyen Quang" => "Tuyen Quang" ,"Quang Tri" => "Quang Tri" ,"Son La" => "Son La" ,"Vinh Puc Province" => "Vinh Puc Province" ,"Dak Lak" => "Dak Lak" ,"Dak Nong" => "Dak Nong" ,"Tra Vinh" => "Tra Vinh" ,"Da Nang" => "Da Nang" ,"Hau Giang" => "Hau Giang" ,"Hung Yen" => "Hung Yen" ,"Lai Chau" => "Lai Chau" );
break;
case 'Australia':
return array(8=>"Australia","New South Wales" => "New South Wales" ,"Victoria" => "Victoria" ,"Queensland" => "Queensland" ,"Western Australia" => "Western Australia" ,"South Australia" => "South Australia" ,"Tasmania" => "Tasmania" ,"Australian Capital Territory" => "Australian Capital Territory" ,"Northern Territory" => "Northern Territory" ,"Christmas Island" => "Christmas Island" ,"Cocos Islands" => "Cocos Islands" );
break;
case 'Fiji':
return array(8=>"Fiji","Central" => "Central" ,"Eastern" => "Eastern" ,"Northern" => "Northern" ,"Rotuma" => "Rotuma" ,"Western" => "Western" );
break;
case 'Kiribati':
return array(8=>"Kiribati","Gilbert Islands" => "Gilbert Islands" ,"Line Islands" => "Line Islands" ,"Phoenix Islands" => "Phoenix Islands" );
break;
case 'Micronesia':
return array(8=>"Micronesia","Chuuk" => "Chuuk" ,"Kosrae" => "Kosrae" ,"Pohnpei" => "Pohnpei" ,"Yap" => "Yap" );
break;
case 'Nauru':
return array(8=>"Nauru","Aiwo" => "Aiwo" ,"Anabar" => "Anabar" ,"Anetan" => "Anetan" ,"Anibare" => "Anibare" ,"Baiti" => "Baiti" ,"Boe" => "Boe" ,"Buada" => "Buada" ,"Denigomodu" => "Denigomodu" ,"Ewa" => "Ewa" ,"Ijuw" => "Ijuw" ,"Meneng" => "Meneng" ,"Nibok" => "Nibok" ,"Uaboe" => "Uaboe" ,"Yaren" => "Yaren" );
break;
case 'New-Zealand':
return array(8=>"New Zealand","Auckland" => "Auckland" ,"Canterbury" => "Canterbury" ,"Wellington" => "Wellington" ,"Waikato" => "Waikato" ,"Bay of Plenty" => "Bay of Plenty" ,"Manawatu-Wanganui" => "Manawatu-Wanganui" ,"Otago" => "Otago" ,"Hawke's Bay" => "Hawke's Bay" ,"Northland" => "Northland" ,"Taranaki" => "Taranaki" ,"Southland" => "Southland" ,"Nelson" => "Nelson" ,"Gisborne" => "Gisborne" ,"Marlborough" => "Marlborough" ,"Tasman" => "Tasman" ,"West Coast" => "West Coast" );
break;
case 'Palau':
return array(8=>"Palau","Koror" => "Koror" ,"Aimeliik" => "Aimeliik" ,"Airai" => "Airai" ,"Angaur" => "Angaur" ,"Hatobohei" => "Hatobohei" ,"Kayangel" => "Kayangel" ,"Melekeok" => "Melekeok" ,"Ngaraard" => "Ngaraard" ,"Ngarchelong" => "Ngarchelong" ,"Ngardmau" => "Ngardmau" ,"Ngatpang" => "Ngatpang" ,"Ngchesar" => "Ngchesar" ,"Ngeremlengui" => "Ngeremlengui" ,"Ngiwal" => "Ngiwal" ,"Peleliu" => "Peleliu" ,"Sonsoral" => "Sonsoral" );
break;
case 'Papua-New-Guinea':
return array(8=>"Papua New Guinea","Port-Moresby" => "Port Moresby" ,"Bougainville" => "Bougainville" ,"Central" => "Central" ,"Chimbu" => "Chimbu" ,"Eastern-Highlands" => "Eastern Highlands" ,"East-New-Britain" => "East New Britain" ,"East-Sepik" => "East Sepik" ,"Enga" => "Enga" ,"Gulf" => "Gulf" ,"Madang" => "Madang" ,"Manus" => "Manus" ,"Milne-Bay" => "Milne Bay" ,"Morobe" => "Morobe" ,"National-Capital" => "National Capital" ,"New-Ireland" => "New Ireland" ,"Northern" => "Northern" ,"Sandaun" => "Sandaun" ,"Southern-Highlands" => "Southern Highlands" ,"Western" => "Western" ,"Western-Highlands" => "Western Highlands" ,"West-New-Britain" => "West New Britain" );
break;
case 'Samoa':
return array(8=>"Samoa","Aiga-i-le-Tai" => "Aiga-i-le-Tai" ,"Atua" => "Atua" ,"Fa" => "Fa" ,"Gaga" => "Gaga" ,"Gagaifomauga" => "Gagaifomauga" ,"Palauli" => "Palauli" ,"Satupa" => "Satupa" ,"Tuamasaga" => "Tuamasaga" ,"Va" => "Va" ,"Vaisigano" => "Vaisigano" );
break;
case 'solomon-islands':
return array(8=>"solomon islands","Central" => "Central" ,"Choiseul" => "Choiseul" ,"Isabel" => "Isabel" );
break;
case 'Tonga':
return array(8=>"Tonga","Vava" => "Vava" ,"Tongatapu" => "Tongatapu" ,"Ha" => "Ha" );
break;
case 'Tuvalu':
return array(8=>"Tuvalu","Fongafale" => "Fongafale" );
break;
case 'Vanuatu':
return array(8=>"Vanuatu","Efate" => "Efate" ,"Sanma" => "Sanma" ,"Malakula" => "Malakula" ,"Tafea" => "Tafea" ,"Torba" => "Torba" ,"Ambrym" => "Ambrym" ,"Pentecote" => "Pentecote" ,"Shefa" => "Shefa" ,"Shepherd" => "Shepherd" ,"Penama" => "Penama" ,"Aoba" => "Aoba" ,"Epi" => "Epi" ,"Malampa" => "Malampa" ,"Paama" => "Paama" );
break;
case 'Anguilla':
return array(8=>"Anguilla","The-Valley" => "The Valley" );
break;
case 'Aruba':
return array(8=>"Aruba","Oranjestad" => "Oranjestad" );
break;
case 'Bahamas':
return array(8=>"Bahamas","New Providence" => "New Providence" ,"Freeport" => "Freeport" ,"Marsh Harbour" => "Marsh Harbour" ,"High Rock" => "High Rock" ,"Fresh Creek" => "Fresh Creek" ,"Long Island" => "Long Island" ,"Harbour Island" => "Harbour Island" ,"Rock Sound" => "Rock Sound" ,"Bimini" => "Bimini" ,"San Salvador and Rum Cay" => "San Salvador and Rum Cay" ,"Acklins and Crooked Islands" => "Acklins and Crooked Islands" ,"Green Turtle Cay" => "Green Turtle Cay" ,"Inagua" => "Inagua" ,"Nichollstown and Berry Islands" => "Nichollstown and Berry Islands" ,"Mayaguana" => "Mayaguana" ,"Ragged Island" => "Ragged Island" ,"Cat Island" => "Cat Island" ,"Governor's Harbour" => "Governor's Harbour" ,"Exuma" => "Exuma" ,"Sandy Point" => "Sandy Point" ,"Kemps Bay" => "Kemps Bay" );
break;
case 'Barbados':
return array(8=>"Barbados","Saint Michael" => "Saint Michael" ,"Saint Peter" => "Saint Peter" ,"Saint Joseph" => "Saint Joseph" ,"Christ Church" => "Christ Church" ,"Saint James" => "Saint James" ,"Saint Andrew" => "Saint Andrew" ,"Saint Lucy" => "Saint Lucy" ,"Saint Thomas" => "Saint Thomas" ,"Saint George" => "Saint George" ,"Saint John" => "Saint John" ,"Saint Philip" => "Saint Philip" );
break;
case 'Cuba':
return array(8=>"Cuba","Santiago de Cuba" => "Santiago de Cuba" ,"Villa Clara" => "Villa Clara" ,"Holguin" => "Holguin" ,"Camaguey" => "Camaguey" ,"Matanzas" => "Matanzas" ,"La Habana" => "La Habana" ,"Granma" => "Granma" ,"Pinar del Rio" => "Pinar del Rio" ,"Guantanamo" => "Guantanamo" ,"Sancti Spiritus" => "Sancti Spiritus" ,"Las Tunas" => "Las Tunas" ,"Cienfuegos" => "Cienfuegos" ,"Ciego de Avila" => "Ciego de Avila" ,"Ciudad de la Habana" => "Ciudad de la Habana" ,"Isla de la Juventud" => "Isla de la Juventud" );
break;
case 'Dominica':
return array(8=>"Dominica","Saint George" => "Saint George" ,"Saint Patrick" => "Saint Patrick" ,"Saint Andrew" => "Saint Andrew" ,"Saint David" => "Saint David" ,"Saint John" => "Saint John" ,"Saint Paul" => "Saint Paul" ,"Saint Peter" => "Saint Peter" ,"Saint Joseph" => "Saint Joseph" ,"Saint Luke" => "Saint Luke" ,"Saint Mark" => "Saint Mark" );
break;
case 'Dominican-Republic':
return array(8=>"Dominican Republic","Distrito Nacional" => "Distrito Nacional" ,"Santiago" => "Santiago" ,"San Cristobal" => "San Cristobal" ,"San Pedro De Macoris" => "San Pedro De Macoris" ,"La Romana" => "La Romana" ,"La Vega" => "La Vega" ,"Puerto Plata" => "Puerto Plata" ,"Duarte" => "Duarte" ,"La Altagracia" => "La Altagracia" ,"San Juan" => "San Juan" ,"Barahona" => "Barahona" ,"Valverde" => "Valverde" ,"Peravia" => "Peravia" ,"Monsenor Nouel" => "Monsenor Nouel" ,"Espaillat" => "Espaillat" ,"Azua" => "Azua" ,"Monte Plata" => "Monte Plata" ,"Sanchez Ramirez" => "Sanchez Ramirez" ,"Hato Mayor" => "Hato Mayor" ,"Maria Trinidad Sanchez" => "Maria Trinidad Sanchez" ,"Monte Cristi" => "Monte Cristi" ,"Baoruco" => "Baoruco" ,"El Seibo" => "El Seibo" ,"Samana" => "Samana" ,"Independencia" => "Independencia" ,"Dajabon" => "Dajabon" ,"Santiago Rodriguez" => "Santiago Rodriguez" ,"Elias Pina" => "Elias Pina" ,"Salcedo" => "Salcedo" ,"Pedernales" => "Pedernales" ,"San Jose de Ocoa" => "San Jose de Ocoa" ,"Santo Domingo" => "Santo Domingo" );
break;
case 'Grenada':
return array(8=>"Grenada","Saint John" => "Saint John" ,"Saint Andrew" => "Saint Andrew" ,"Saint Mark" => "Saint Mark" ,"Saint Patrick" => "Saint Patrick" ,"Saint David" => "Saint David" ,"Saint George" => "Saint George" );
break;
case 'Guadeloupe':
return array(8=>"Guadeloupe","Basse-Terre" => "Basse-Terre" );
break;
case 'Haiti':
return array(8=>"Haiti","Artibonite" => "Artibonite" );
break;
case 'Jamaica':
return array(8=>"Jamaica","Saint Andrew" => "Saint Andrew" ,"Saint Catherine" => "Saint Catherine" ,"Saint James" => "Saint James" ,"Manchester" => "Manchester" ,"Clarendon" => "Clarendon" ,"Saint Ann" => "Saint Ann" ,"Portland" => "Portland" ,"Trelawny" => "Trelawny" ,"Saint Elizabeth" => "Saint Elizabeth" ,"Saint Thomas" => "Saint Thomas" ,"Saint Mary" => "Saint Mary" ,"Hanover" => "Hanover" ,"Kingston" => "Kingston" ,"Westmoreland" => "Westmoreland" );
break;
case 'Martinique':
return array(8=>"Martinique","Fort-de-France" => "Fort-de-France" );
break;
case 'Montserrat':
return array(8=>"Montserrat","Saint Anthony" => "Saint Anthony" ,"Saint Georges" => "Saint Georges" ,"Saint Peter" => "Saint Peter" );
break;
case 'Puerto-Rico':
return array(8=>"Puerto Rico","San-Juan" => "San Juan" ,"Adjuntas" => "Adjuntas" ,"Aguada" => "Aguada" ,"Aguadilla" => "Aguadilla" ,"Aguas-Buenas" => "Aguas Buenas" ,"Aibonito" => "Aibonito" ,"Anasco" => "Anasco" ,"Arecibo" => "Arecibo" ,"Arroyo" => "Arroyo" ,"Barceloneta" => "Barceloneta" ,"Barranquitas" => "Barranquitas" ,"Bayamon" => "Bayamon" ,"Cabo-Rojo" => "Cabo Rojo" ,"Caguas" => "Caguas" ,"Camuy" => "Camuy" ,"Canovanas" => "Canovanas" ,"Carolina" => "Carolina" ,"Catano" => "Catano" ,"Cayey" => "Cayey" ,"Ceiba" => "Ceiba" ,"Ciales" => "Ciales" ,"Cidra" => "Cidra" ,"Coamo" => "Coamo" ,"Comerio" => "Comerio" ,"Corozal" => "Corozal" ,"Culebra" => "Culebra" ,"Dorado" => "Dorado" ,"Fajardo" => "Fajardo" ,"Florida" => "Florida" ,"Guanica" => "Guanica" ,"Guayama" => "Guayama" ,"Guayanilla" => "Guayanilla" ,"Guaynabo" => "Guaynabo" ,"Gurabo" => "Gurabo" ,"Hatillo" => "Hatillo" ,"Hormigueros" => "Hormigueros" ,"Humacao" => "Humacao" ,"Isabela" => "Isabela" ,"Jayuya" => "Jayuya" ,"Juana-Diaz" => "Juana Diaz" ,"Juncos" => "Juncos" ,"Lajas" => "Lajas" ,"Lares" => "Lares" ,"Las-Marias" => "Las Marias" ,"Las-Piedras" => "Las Piedras" ,"Loiza" => "Loiza" ,"Luquillo" => "Luquillo" ,"Manati" => "Manati" ,"Maricao" => "Maricao" ,"Maunabo" => "Maunabo" ,"Mayaguez" => "Mayaguez" ,"Moca" => "Moca" ,"Morovis" => "Morovis" ,"Naguabo" => "Naguabo" ,"Naranjito" => "Naranjito" ,"Orocovis" => "Orocovis" ,"Patillas" => "Patillas" ,"Penuelas" => "Penuelas" ,"Ponce" => "Ponce" ,"Quebradillas" => "Quebradillas" ,"Rincon" => "Rincon" ,"Rio-Grande" => "Rio Grande" ,"Sabana-Grande" => "Sabana Grande" ,"Salinas" => "Salinas" ,"San-German" => "San German" ,"San-Lorenzo" => "San Lorenzo" ,"San-Sebastian" => "San Sebastian" ,"Santa-Isabel" => "Santa Isabel" ,"Toa-Alta" => "Toa Alta" ,"Toa-Baja" => "Toa Baja" ,"Trujillo-Alto" => "Trujillo Alto" ,"Utuado" => "Utuado" ,"Vega-Alta" => "Vega Alta" ,"Vega-Baja" => "Vega Baja" ,"Vieques" => "Vieques" ,"Villalba" => "Villalba" ,"Yabucoa" => "Yabucoa" ,"Yauco" => "Yauco" );
break;
case 'St-Kitts-Nevis':
return array(8=>"St Kitts Nevis","Saint George Basseterre" => "Saint George Basseterre" ,"Saint John Figtree" => "Saint John Figtree" ,"Saint John Capisterre" => "Saint John Capisterre" ,"Saint Anne Sandy Point" => "Saint Anne Sandy Point" ,"Saint Thomas Middle Island" => "Saint Thomas Middle Island" ,"Saint Mary Cayon" => "Saint Mary Cayon" ,"Christ Church Nichola Town" => "Christ Church Nichola Town" ,"Saint Peter Basseterre" => "Saint Peter Basseterre" ,"Saint James Windward" => "Saint James Windward" ,"Saint George Gingerland" => "Saint George Gingerland" ,"Saint Thomas Lowland" => "Saint Thomas Lowland" ,"Saint Paul Capisterre" => "Saint Paul Capisterre" ,"Saint Paul Charlestown" => "Saint Paul Charlestown" ,"Trinity Palmetto Point" => "Trinity Palmetto Point" );
break;
case 'St-Lucia':
return array(8=>"St Lucia","Castries" => "Castries" ,"Vieux-Fort" => "Vieux-Fort" ,"Micoud" => "Micoud" ,"Gros-Islet" => "Gros-Islet" ,"Dennery" => "Dennery" ,"Soufriere" => "Soufriere" ,"Laborie" => "Laborie" ,"Anse-la-Raye" => "Anse-la-Raye" ,"Choiseul" => "Choiseul" ,"Dauphin" => "Dauphin" ,"Praslin" => "Praslin" );
break;
case 'Trinidad-Tobago':
return array(8=>"Trinidad Tobago","San Fernando" => "San Fernando" ,"Caroni" => "Caroni" ,"Saint George" => "Saint George" ,"Arima" => "Arima" ,"Saint Patrick" => "Saint Patrick" ,"Saint Andrew" => "Saint Andrew" ,"Victoria" => "Victoria" ,"Tobago" => "Tobago" ,"Nariva" => "Nariva" ,"Saint David" => "Saint David" ,"Port-of-Spain" => "Port-of-Spain" ,"Mayaro" => "Mayaro" );
break;
case 'Turks-Caicos':
return array(8=>"Turks Caicos","Grand-Turk-(Cockburn-Town)" => "Grand Turk (Cockburn Town)" );
break;
case 'Belize':
return array(8=>"Belize","Belize" => "Belize" ,"Cayo" => "Cayo" ,"Orange Walk" => "Orange Walk" ,"Stann Creek" => "Stann Creek" ,"Corozal" => "Corozal" ,"Toledo" => "Toledo" );
break;
case 'Costa-Rica':
return array(8=>"Costa Rica","San Jose" => "San Jose" ,"Heredia" => "Heredia" ,"Alajuela" => "Alajuela" ,"Cartago" => "Cartago" ,"Puntarenas" => "Puntarenas" ,"Limon" => "Limon" ,"Guanacaste" => "Guanacaste" );
break;
case 'El-Salvador':
return array(8=>"El Salvador","San Salvador" => "San Salvador" ,"La Libertad" => "La Libertad" ,"Santa Ana" => "Santa Ana" ,"Sonsonate" => "Sonsonate" ,"Usulutan" => "Usulutan" ,"Cuscatlan" => "Cuscatlan" ,"La Paz" => "La Paz" ,"Ahuachapan" => "Ahuachapan" ,"La Union" => "La Union" ,"San Vicente" => "San Vicente" ,"San Miguel" => "San Miguel" ,"Morazan" => "Morazan" ,"Chalatenango" => "Chalatenango" ,"Cabanas" => "Cabanas" );
break;
case 'Guatemala':
return array(8=>"Guatemala","Guatemala" => "Guatemala" ,"Quetzaltenango" => "Quetzaltenango" ,"Escuintla" => "Escuintla" ,"Chimaltenango" => "Chimaltenango" ,"Sacatepequez" => "Sacatepequez" ,"Huehuetenango" => "Huehuetenango" ,"San Marcos" => "San Marcos" ,"Quiche" => "Quiche" ,"Suchitepequez" => "Suchitepequez" ,"Totonicapan" => "Totonicapan" ,"Solola" => "Solola" ,"Alta Verapaz" => "Alta Verapaz" ,"Peten" => "Peten" ,"Jutiapa" => "Jutiapa" ,"Santa Rosa" => "Santa Rosa" ,"Izabal" => "Izabal" ,"Retalhuleu" => "Retalhuleu" ,"Zacapa" => "Zacapa" ,"Chiquimula" => "Chiquimula" ,"Jalapa" => "Jalapa" ,"Baja Verapaz" => "Baja Verapaz" ,"El Progreso" => "El Progreso" );
break;
case 'Honduras':
return array(8=>"Honduras","Francisco Morazan" => "Francisco Morazan" ,"Cortes" => "Cortes" ,"Yoro" => "Yoro" ,"Atlantida" => "Atlantida" ,"Comayagua" => "Comayagua" ,"Choluteca" => "Choluteca" ,"Olancho" => "Olancho" ,"Santa Barbara" => "Santa Barbara" ,"El Paraiso" => "El Paraiso" ,"Copan" => "Copan" ,"Colon" => "Colon" ,"Valle" => "Valle" ,"Ocotepeque" => "Ocotepeque" ,"La Paz" => "La Paz" ,"Intibuca" => "Intibuca" ,"Lempira" => "Lempira" ,"Gracias a Dios" => "Gracias a Dios" ,"Islas de la Bahia" => "Islas de la Bahia" );
break;
case 'Nicaragua':
return array(8=>"Nicaragua","Managua" => "Managua" ,"Chinandega" => "Chinandega" ,"Leon" => "Leon" ,"Masaya" => "Masaya" ,"Matagalpa" => "Matagalpa" ,"Granada" => "Granada" ,"Region Autonoma Atlantico Sur" => "Region Autonoma Atlantico Sur" ,"Esteli" => "Esteli" ,"Carazo" => "Carazo" ,"Nueva Segovia" => "Nueva Segovia" ,"Chontales" => "Chontales" ,"Autonoma Atlantico Norte" => "Autonoma Atlantico Norte" ,"Rivas" => "Rivas" ,"Boaco" => "Boaco" ,"Jinotega" => "Jinotega" ,"Madriz" => "Madriz" ,"Rio San Juan" => "Rio San Juan" ,"Zelaya" => "Zelaya" );
break;
case 'Panama':
return array(8=>"Panama","Panama" => "Panama" ,"Chiriqui" => "Chiriqui" ,"Colon" => "Colon" ,"Cocle" => "Cocle" ,"Veraguas" => "Veraguas" ,"Herrera" => "Herrera" ,"Bocas del Toro" => "Bocas del Toro" ,"Los Santos" => "Los Santos" ,"San Blas" => "San Blas" ,"Darien" => "Darien" );
break;
case 'Albania':
return array(8=>"Albania","Tirane" => "Tirane" ,"Durres" => "Durres" ,"Elbasan" => "Elbasan" ,"Fier" => "Fier" ,"Vlore" => "Vlore" ,"Korce" => "Korce" ,"Shkoder" => "Shkoder" ,"Berat" => "Berat" ,"Lezhe" => "Lezhe" ,"Gjirokaster" => "Gjirokaster" ,"Diber" => "Diber" ,"Kukes" => "Kukes" );
break;
case 'Andorra':
return array(8=>"Andorra","Andorra la Vella" => "Andorra la Vella" ,"Escaldes-Engordany" => "Escaldes-Engordany" ,"Encamp" => "Encamp" ,"Sant Julia de Loria" => "Sant Julia de Loria" ,"La Massana" => "La Massana" ,"Canillo" => "Canillo" ,"Ordino" => "Ordino" );
break;
case 'Austria':
return array(8=>"Austria","Wien" => "Wien" ,"Niederosterreich" => "Niederosterreich" ,"Oberosterreich" => "Oberosterreich" ,"Steiermark" => "Steiermark" ,"Karnten" => "Karnten" ,"Tirol" => "Tirol" ,"Salzburg" => "Salzburg" ,"Vorarlberg" => "Vorarlberg" ,"Burgenland" => "Burgenland" );
break;
case 'Belarus':
return array(8=>"Belarus","Minsk" => "Minsk" ,"Homyel'skaya Voblasts" => "Homyel'skaya Voblasts" ,"Hrodzyenskaya Voblasts" => "Hrodzyenskaya Voblasts" ,"Brestskaya Voblasts" => "Brestskaya Voblasts" ,"Vitsyebskaya Voblasts" => "Vitsyebskaya Voblasts" ,"Mahilyowskaya Voblasts" => "Mahilyowskaya Voblasts" ,"Minskaya Voblasts" => "Minskaya Voblasts" );
break;
case 'Belgium':
return array(8=>"Belgium","Antwerpen" => "Antwerpen" ,"Oost-Vlaanderen" => "Oost-Vlaanderen" ,"Hainaut" => "Hainaut" ,"West-Vlaanderen" => "West-Vlaanderen" ,"Brussels Hoofdstedelijk Gewest" => "Brussels Hoofdstedelijk Gewest" ,"Liege" => "Liege" ,"Limburg" => "Limburg" ,"Namur" => "Namur" ,"Luxembourg" => "Luxembourg" ,"Vlaams-Brabant" => "Vlaams-Brabant" ,"Brabant Wallon" => "Brabant Wallon" );
break;
case 'Bosnia-Herzegovina':
return array(8=>"Bosnia Herzegovina","Federation of Bosnia and Herzegovina" => "Federation of Bosnia and Herzegovina" ,"Republika Srpska" => "Republika Srpska" );
break;
case 'Bulgaria':
return array(8=>"Bulgaria","Grad Sofiya" => "Grad Sofiya" ,"Plovdiv" => "Plovdiv" ,"Varna" => "Varna" ,"Burgas" => "Burgas" ,"Stara Zagora" => "Stara Zagora" ,"Khaskovo" => "Khaskovo" ,"Pleven" => "Pleven" ,"Pazardzhik" => "Pazardzhik" ,"Ruse" => "Ruse" ,"Blagoevgrad" => "Blagoevgrad" ,"Sofiya" => "Sofiya" ,"Sliven" => "Sliven" ,"Lovech" => "Lovech" ,"Dobrich" => "Dobrich" ,"Shumen" => "Shumen" ,"Pernik" => "Pernik" ,"Gabrovo" => "Gabrovo" ,"Kyustendil" => "Kyustendil" ,"Yambol" => "Yambol" ,"Vratsa" => "Vratsa" ,"Montana" => "Montana" ,"Smolyan" => "Smolyan" ,"Veliko Turnovo" => "Veliko Turnovo" ,"Vidin" => "Vidin" ,"Silistra" => "Silistra" ,"Razgrad" => "Razgrad" ,"Turgovishte" => "Turgovishte" ,"Kurdzhali" => "Kurdzhali" ,"Mikhaylovgrad" => "Mikhaylovgrad" );
break;
case 'Croatia':
return array(8=>"Croatia","Grad Zagreb" => "Grad Zagreb" ,"Splitsko-Dalmatinska" => "Splitsko-Dalmatinska" ,"Primorsko-Goranska" => "Primorsko-Goranska" ,"Zagrebacka" => "Zagrebacka" ,"Osjecko-Baranjska" => "Osjecko-Baranjska" ,"Istarska" => "Istarska" ,"Sisacko-Moslavacka" => "Sisacko-Moslavacka" ,"Vukovarsko-Srijemska" => "Vukovarsko-Srijemska" ,"Brodsko-Posavska" => "Brodsko-Posavska" ,"Dubrovacko-Neretvanska" => "Dubrovacko-Neretvanska" ,"Karlovacka" => "Karlovacka" ,"Varazdinska" => "Varazdinska" ,"Koprivnicko-Krizevacka" => "Koprivnicko-Krizevacka" ,"Sibensko-Kninska" => "Sibensko-Kninska" ,"Viroviticko-Podravska" => "Viroviticko-Podravska" ,"Bjelovarsko-Bilogorska" => "Bjelovarsko-Bilogorska" ,"Pozesko-Slavonska" => "Pozesko-Slavonska" ,"Medimurska" => "Medimurska" ,"Licko-Senjska" => "Licko-Senjska" ,"Krapinsko-Zagorska" => "Krapinsko-Zagorska" ,"Zadarska" => "Zadarska" );
break;
case 'Czech-Republic':
return array(8=>"Czech Republic","Hlavni mesto Praha" => "Hlavni mesto Praha" ,"Moravskoslezsky kraj" => "Moravskoslezsky kraj" ,"Jihomoravsky kraj" => "Jihomoravsky kraj" ,"Ustecky kraj" => "Ustecky kraj" ,"Stredocesky kraj" => "Stredocesky kraj" ,"Jihocesky kraj" => "Jihocesky kraj" ,"Zlinsky kraj" => "Zlinsky kraj" ,"Olomoucky kraj" => "Olomoucky kraj" ,"Plzensky kraj" => "Plzensky kraj" ,"Vysocina" => "Vysocina" ,"Pardubicky kraj" => "Pardubicky kraj" ,"Karlovarsky kraj" => "Karlovarsky kraj" ,"Kralovehradecky kraj" => "Kralovehradecky kraj" ,"Liberecky kraj" => "Liberecky kraj" );
break;
case 'Denmark':
return array(8=>"Denmark","Hovedstaden" => "Hovedstaden" ,"Midtjylland" => "Midtjylland" ,"Syddanmark" => "Syddanmark" ,"Sjelland" => "Sjelland" ,"Nordjylland" => "Nordjylland" );
break;
case 'Estonia':
return array(8=>"Estonia","Harjumaa" => "Harjumaa" ,"Ida-Virumaa" => "Ida-Virumaa" ,"Tartumaa" => "Tartumaa" ,"Parnumaa" => "Parnumaa" ,"Laane-Virumaa" => "Laane-Virumaa" ,"Viljandimaa" => "Viljandimaa" ,"Jarvamaa" => "Jarvamaa" ,"Vorumaa" => "Vorumaa" ,"Jogevamaa" => "Jogevamaa" ,"Raplamaa" => "Raplamaa" ,"Valgamaa" => "Valgamaa" ,"Saaremaa" => "Saaremaa" ,"Laanemaa" => "Laanemaa" ,"Polvamaa" => "Polvamaa" ,"Hiiumaa" => "Hiiumaa" ,"Kohtla-Jarve" => "Kohtla-Jarve" ,"Narva" => "Narva" ,"Sillamae" => "Sillamae" ,"Tallinn" => "Tallinn" ,"Tartu" => "Tartu" ,"Parnu" => "Parnu" );
break;
case 'Finland':
return array(8=>"Finland","Southern Finland" => "Southern Finland" ,"Western Finland" => "Western Finland" ,"Eastern Finland" => "Eastern Finland" ,"Oulu" => "Oulu" ,"Lapland" => "Lapland" ,"Aland" => "Aland" );
break;
case 'France':
return array(8=>"France","Ile-de-France" => "Ile-de-France" ,"Bretagne" => "Bretagne" ,"Rhone-Alpes" => "Rhone-Alpes" ,"Provence-Alpes-Cote-d'Azur" => "Provence-Alpes-Cote-d'Azur" ,"Nord-Pas-de-Calais" => "Nord-Pas-de-Calais" ,"Pays-de-la-Loire" => "Pays-de-la-Loire" ,"Aquitaine" => "Aquitaine" ,"Midi-Pyrenees" => "Midi-Pyrenees" ,"Languedoc-Roussillon" => "Languedoc-Roussillon" ,"Centre" => "Centre" ,"Lorraine" => "Lorraine" ,"Picardie" => "Picardie" ,"Alsace" => "Alsace" ,"Haute-Normandie" => "Haute-Normandie" ,"Poitou-Charentes" => "Poitou-Charentes" ,"Bourgogne" => "Bourgogne" ,"Basse-Normandie" => "Basse-Normandie" ,"Champagne-Ardenne" => "Champagne-Ardenne" ,"Auvergne" => "Auvergne" ,"Franche-Comte" => "Franche-Comte" ,"Corse" => "Corse" ,"Limousin" => "Limousin" ,"Fort-de-France" => "Fort-de-France" ,"Haut-Ogooue" => "Haut-Ogooue" ,"Goa" => "Goa" ,"Ontario" => "Ontario" ,"Grand Port" => "Grand Port" ,"Piemonte" => "Piemonte" ,"New Hampshire" => "New Hampshire" ,"Indiana" => "Indiana" ,"Sector claimed by France" => "Sector claimed by France" );
break;
case 'Georgia':
return array(8=>"Georgia","Dushet'is Raioni" => "Dushet'is Raioni" ,"Abkhazia" => "Abkhazia" ,"Zestap'onis Raioni" => "Zestap'onis Raioni" ,"Goris Raioni" => "Goris Raioni" ,"Khashuris Raioni" => "Khashuris Raioni" ,"Akhmetis Raioni" => "Akhmetis Raioni" ,"Sagarejos Raioni" => "Sagarejos Raioni" ,"Samtrediis Raioni" => "Samtrediis Raioni" ,"Borjomis Raioni" => "Borjomis Raioni" ,"Tsalkis Raioni" => "Tsalkis Raioni" ,"K'ut'aisi" => "K'ut'aisi" ,"Ajaria" => "Ajaria" ,"Kaspis Raioni" => "Kaspis Raioni" ,"Ts'ageris Raioni" => "Ts'ageris Raioni" ,"T'ianet'is Raioni" => "T'ianet'is Raioni" ,"Zugdidis Raioni" => "Zugdidis Raioni" ,"Lanch'khut'is Raioni" => "Lanch'khut'is Raioni" ,"Qazbegis Raioni" => "Qazbegis Raioni" ,"Dedop'listsqaros Raioni" => "Dedop'listsqaros Raioni" ,"Akhalts'ikhis Raioni" => "Akhalts'ikhis Raioni" ,"Abashis Raioni" => "Abashis Raioni" ,"Mts'khet'is Raioni" => "Mts'khet'is Raioni" ,"K'arelis Raioni" => "K'arelis Raioni" ,"Marneulis Raioni" => "Marneulis Raioni" ,"Khobis Raioni" => "Khobis Raioni" ,"Kharagaulis Raioni" => "Kharagaulis Raioni" ,"Tsalenjikhis Raioni" => "Tsalenjikhis Raioni" ,"Onis Raioni" => "Onis Raioni" ,"Tsqaltubo" => "Tsqaltubo" ,"Aspindzis Raioni" => "Aspindzis Raioni" ,"Ninotsmindis Raioni" => "Ninotsmindis Raioni" ,"Martvilis Raioni" => "Martvilis Raioni" ,"Ambrolauris Raioni" => "Ambrolauris Raioni" ,"Vanis Raioni" => "Vanis Raioni" ,"Akhalgoris Raioni" => "Akhalgoris Raioni" ,"Javis Raioni" => "Javis Raioni" ,"Tqibuli" => "Tqibuli" ,"Rust'avi" => "Rust'avi" ,"Ch'khorotsqus Raioni" => "Ch'khorotsqus Raioni" ,"Chiat'ura" => "Chiat'ura" ,"T'bilisi" => "T'bilisi" ,"T'elavis Raioni" => "T'elavis Raioni" ,"T'et'ritsqaros Raioni" => "T'et'ritsqaros Raioni" ,"Baghdat'is Raioni" => "Baghdat'is Raioni" ,"Ch'okhatauris Raioni" => "Ch'okhatauris Raioni" ,"P'ot'i" => "P'ot'i" ,"Mestiis Raioni" => "Mestiis Raioni" ,"Lentekhis Raioni" => "Lentekhis Raioni" ,"Gori" => "Gori" ,"Lagodekhis Raioni" => "Lagodekhis Raioni" ,"Akhalk'alak'is Raioni" => "Akhalk'alak'is Raioni" ,"Zugdidi" => "Zugdidi" ,"Qvarlis Raioni" => "Qvarlis Raioni" );
break;
case 'Germany':
return array(8=>"Germany","Nordrhein-Westfalen" => "Nordrhein-Westfalen" ,"Bayern" => "Bayern" ,"Niedersachsen" => "Niedersachsen" ,"Baden-Wurttemberg" => "Baden-Wurttemberg" ,"Rheinland-Pfalz" => "Rheinland-Pfalz" ,"Hessen" => "Hessen" ,"Sachsen" => "Sachsen" ,"Thuringen" => "Thuringen" ,"Berlin" => "Berlin" ,"Schleswig-Holstein" => "Schleswig-Holstein" ,"Mecklenburg-Vorpommern" => "Mecklenburg-Vorpommern" ,"Brandenburg" => "Brandenburg" ,"Sachsen-Anhalt" => "Sachsen-Anhalt" ,"Hamburg" => "Hamburg" ,"Saarland" => "Saarland" ,"Bremen" => "Bremen" ,"Minnesota" => "Minnesota" ,"Sector claimed by Norway" => "Sector claimed by Norway" );
break;
case 'Greece':
return array(8=>"Greece","Attiki" => "Attiki" ,"Thessaloniki" => "Thessaloniki" ,"Akhaia" => "Akhaia" ,"Larisa" => "Larisa" ,"Iraklion" => "Iraklion" ,"Dhodhekanisos" => "Dhodhekanisos" ,"Magnisia" => "Magnisia" ,"Evvoia" => "Evvoia" ,"Serrai" => "Serrai" ,"Aitolia kai Akarnania" => "Aitolia kai Akarnania" ,"Imathia" => "Imathia" ,"Kavala" => "Kavala" ,"Ilia" => "Ilia" ,"Korinthia" => "Korinthia" ,"Pieria" => "Pieria" ,"Evros" => "Evros" ,"Pella" => "Pella" ,"Khania" => "Khania" ,"Kozani" => "Kozani" ,"Ioannina" => "Ioannina" ,"Messinia" => "Messinia" ,"Voiotia" => "Voiotia" ,"Trikala" => "Trikala" ,"Fthiotis" => "Fthiotis" ,"Argolis" => "Argolis" ,"Kardhitsa" => "Kardhitsa" ,"Lesvos" => "Lesvos" ,"Drama" => "Drama" ,"Xanthi" => "Xanthi" ,"Rodhopi" => "Rodhopi" ,"Kikladhes" => "Kikladhes" ,"Kilkis" => "Kilkis" ,"Lasithi" => "Lasithi" ,"Kerkira" => "Kerkira" ,"Arkadhia" => "Arkadhia" ,"Rethimni" => "Rethimni" ,"Lakonia" => "Lakonia" ,"Khalkidhiki" => "Khalkidhiki" ,"Khios" => "Khios" ,"Arta" => "Arta" ,"Preveza" => "Preveza" ,"Kastoria" => "Kastoria" ,"Kefallinia" => "Kefallinia" ,"Samos" => "Samos" ,"Zakinthos" => "Zakinthos" ,"Thesprotia" => "Thesprotia" ,"Florina" => "Florina" ,"Grevena" => "Grevena" ,"Fokis" => "Fokis" ,"Evritania" => "Evritania" ,"Levkas" => "Levkas" );
break;
case 'Hungary':
return array(8=>"Hungary","Budapest" => "Budapest" ,"Pest" => "Pest" ,"Bacs-Kiskun" => "Bacs-Kiskun" ,"Szabolcs-Szatmar-Bereg" => "Szabolcs-Szatmar-Bereg" ,"Borsod-Abauj-Zemplen" => "Borsod-Abauj-Zemplen" ,"Jasz-Nagykun-Szolnok" => "Jasz-Nagykun-Szolnok" ,"Fejer" => "Fejer" ,"Bekes" => "Bekes" ,"Hajdu-Bihar" => "Hajdu-Bihar" ,"Veszprem" => "Veszprem" ,"Komarom-Esztergom" => "Komarom-Esztergom" ,"Heves" => "Heves" ,"Csongrad" => "Csongrad" ,"Debrecen" => "Debrecen" ,"Somogy" => "Somogy" ,"Tolna" => "Tolna" ,"Gyor-Moson-Sopron" => "Gyor-Moson-Sopron" ,"Miskolc" => "Miskolc" ,"Vas" => "Vas" ,"Szeged" => "Szeged" ,"Pecs" => "Pecs" ,"Zala" => "Zala" ,"Nograd" => "Nograd" ,"Gyor" => "Gyor" ,"Baranya" => "Baranya" ,"Eger" => "Eger" ,"Sopron" => "Sopron" ,"Dunaujvaros" => "Dunaujvaros" ,"Szekesfehervar" => "Szekesfehervar" ,"Szekszard" => "Szekszard" ,"Szolnok" => "Szolnok" ,"Szombathely" => "Szombathely" ,"Tatabanya" => "Tatabanya" ,"Bekescsaba" => "Bekescsaba" ,"Kaposvar" => "Kaposvar" ,"Zalaegerszeg" => "Zalaegerszeg" ,"Kecskemet" => "Kecskemet" ,"Hodmezovasarhely" => "Hodmezovasarhely" ,"Nagykanizsa" => "Nagykanizsa" ,"Nyiregyhaza" => "Nyiregyhaza" ,"Erd" => "Erd" ,"Salgotarjan" => "Salgotarjan" );
break;
case 'Iceland':
return array(8=>"Iceland","Gullbringusysla" => "Gullbringusysla" ,"Eyjafjardarsysla" => "Eyjafjardarsysla" ,"Arnessysla" => "Arnessysla" ,"Borgarfjardarsysla" => "Borgarfjardarsysla" ,"Rangarvallasysla" => "Rangarvallasysla" ,"Sudur-Tingeyjarsysla" => "Sudur-Tingeyjarsysla" ,"Snafellsnes- og Hnappadalssysla" => "Snafellsnes- og Hnappadalssysla" ,"Myrasysla" => "Myrasysla" ,"Austur-Skaftafellssysla" => "Austur-Skaftafellssysla" ,"Vestur-Isafjardarsysla" => "Vestur-Isafjardarsysla" ,"Austur-Hunavatnssysla" => "Austur-Hunavatnssysla" ,"Vestur-Hunavatnssysla" => "Vestur-Hunavatnssysla" ,"Strandasysla" => "Strandasysla" ,"Sudur-Mulasysla" => "Sudur-Mulasysla" ,"Nordur-Tingeyjarsysla" => "Nordur-Tingeyjarsysla" ,"Skagafjardarsysla" => "Skagafjardarsysla" ,"Vestur-Bardastrandarsysla" => "Vestur-Bardastrandarsysla" ,"Vestur-Skaftafellssysla" => "Vestur-Skaftafellssysla" ,"Suournes" => "Suournes" ,"Vestfiroir" => "Vestfiroir" ,"Norourland Eystra" => "Norourland Eystra" ,"Nordur-Mulasysla" => "Nordur-Mulasysla" ,"Kjosarsysla" => "Kjosarsysla" ,"Vesturland" => "Vesturland" ,"Norourland Vestra" => "Norourland Vestra" );
break;
case 'Ireland':
return array(8=>"Ireland","Dublin" => "Dublin" ,"Cork" => "Cork" ,"Kildare" => "Kildare" ,"Galway" => "Galway" ,"Wicklow" => "Wicklow" ,"Meath" => "Meath" ,"Louth" => "Louth" ,"Waterford" => "Waterford" ,"Limerick" => "Limerick" ,"Donegal" => "Donegal" ,"Wexford" => "Wexford" ,"Clare" => "Clare" ,"Westmeath" => "Westmeath" ,"Kerry" => "Kerry" ,"Tipperary South Riding" => "Tipperary South Riding" ,"Offaly" => "Offaly" ,"Kilkenny" => "Kilkenny" ,"Mayo" => "Mayo" ,"Laois" => "Laois" ,"Carlow" => "Carlow" ,"Tipperary North Riding" => "Tipperary North Riding" ,"Sligo" => "Sligo" ,"Cavan" => "Cavan" ,"Monaghan" => "Monaghan" ,"Longford" => "Longford" ,"Roscommon" => "Roscommon" ,"Leitrim" => "Leitrim" );
break;
case 'Italy':
return array(8=>"Italy","Lombardei" => "Lombardei" ,"Lazio" => "Lazio" ,"Campania" => "Campania" ,"Sizilien" => "Sizilien" ,"Veneto" => "Veneto" ,"Piemonte" => "Piemonte" ,"Emilia-Romagna" => "Emilia-Romagna" ,"Apulien" => "Apulien" ,"Toscana" => "Toscana" ,"Calabria" => "Calabria" ,"Sardinien" => "Sardinien" ,"Ligurien" => "Ligurien" ,"Marken" => "Marken" ,"Abruzzen" => "Abruzzen" ,"Friuli-Venezia Giulia" => "Friuli-Venezia Giulia" ,"Trentino-Alto Adige" => "Trentino-Alto Adige" ,"Umbria" => "Umbria" ,"Basilicata" => "Basilicata" ,"Molise" => "Molise" ,"Valle d'Aosta" => "Valle d'Aosta" ,"Texas" => "Texas" );
break;
case 'Latvia':
return array(8=>"Latvia","Riga" => "Riga" ,"Daugavpils" => "Daugavpils" ,"Liepaja" => "Liepaja" ,"Jelgavas" => "Jelgavas" ,"Rigas" => "Rigas" ,"Ventspils" => "Ventspils" ,"Rezekne" => "Rezekne" ,"Ogres" => "Ogres" ,"Valmieras" => "Valmieras" ,"Tukuma" => "Tukuma" ,"Cesu" => "Cesu" ,"Preilu" => "Preilu" ,"Talsu" => "Talsu" ,"Limbazu" => "Limbazu" ,"Valkas" => "Valkas" ,"Kuldigas" => "Kuldigas" ,"Saldus" => "Saldus" ,"Madonas" => "Madonas" ,"Ludzas" => "Ludzas" ,"Dobeles" => "Dobeles" ,"Kraslavas" => "Kraslavas" ,"Aizkraukles" => "Aizkraukles" ,"Bauskas" => "Bauskas" ,"Balvu" => "Balvu" ,"Liepajas" => "Liepajas" ,"Gulbenes" => "Gulbenes" ,"Rezeknes" => "Rezeknes" ,"Aluksnes" => "Aluksnes" ,"Jekabpils" => "Jekabpils" ,"Jelgava" => "Jelgava" ,"Jurmala" => "Jurmala" );
break;
case 'Liechtenstein':
return array(8=>"Liechtenstein","Schaan" => "Schaan" ,"Vaduz" => "Vaduz" ,"Triesen" => "Triesen" ,"Balzers" => "Balzers" ,"Eschen" => "Eschen" ,"Mauren" => "Mauren" ,"Triesenberg" => "Triesenberg" ,"Ruggell" => "Ruggell" ,"Gamprin" => "Gamprin" ,"Schellenberg" => "Schellenberg" ,"Planken" => "Planken" );
break;
case 'Lithuania':
return array(8=>"Lithuania","Vilniaus Apskritis" => "Vilniaus Apskritis" ,"Kauno Apskritis" => "Kauno Apskritis" ,"Panevezio Apskritis" => "Panevezio Apskritis" ,"Klaipedos Apskritis" => "Klaipedos Apskritis" ,"Siauliu Apskritis" => "Siauliu Apskritis" ,"Telsiu Apskritis" => "Telsiu Apskritis" ,"Alytaus Apskritis" => "Alytaus Apskritis" ,"Marijampoles Apskritis" => "Marijampoles Apskritis" ,"Taurages Apskritis" => "Taurages Apskritis" ,"Utenos Apskritis" => "Utenos Apskritis" );
break;
case 'Luxembourg':
return array(8=>"Luxembourg","Luxembourg" => "Luxembourg" ,"Diekirch" => "Diekirch" ,"Grevenmacher" => "Grevenmacher" );
break;
case 'Macedonia':
return array(8=>"Macedonia","Karpos" => "Karpos" ,"Kumanovo" => "Kumanovo" ,"Bitola" => "Bitola" ,"Prilep" => "Prilep" ,"Tetovo" => "Tetovo" ,"Veles" => "Veles" ,"Ohrid" => "Ohrid" ,"Gostivar" => "Gostivar" ,"Stip" => "Stip" ,"Strumica" => "Strumica" ,"Kavadarci" => "Kavadarci" ,"Struga" => "Struga" ,"Kocani" => "Kocani" ,"Kicevo" => "Kicevo" ,"Lipkovo" => "Lipkovo" ,"Zelino" => "Zelino" ,"Saraj" => "Saraj" ,"Radovis" => "Radovis" ,"Tearce" => "Tearce" ,"Zrnovci" => "Zrnovci" ,"Kriva Palanka" => "Kriva Palanka" ,"Gevgelija" => "Gevgelija" ,"Negotino" => "Negotino" ,"Sveti Nikole" => "Sveti Nikole" ,"Studenicani" => "Studenicani" ,"Debar" => "Debar" ,"Negotino-Polosko" => "Negotino-Polosko" ,"Delcevo" => "Delcevo" ,"Resen" => "Resen" ,"Ilinden" => "Ilinden" ,"Brvenica" => "Brvenica" ,"Kamenjane" => "Kamenjane" ,"Bogovinje" => "Bogovinje" ,"Berovo" => "Berovo" ,"Aracinovo" => "Aracinovo" ,"Probistip" => "Probistip" ,"Cegrane" => "Cegrane" ,"Bosilovo" => "Bosilovo" ,"Vasilevo" => "Vasilevo" ,"Zajas" => "Zajas" ,"Valandovo" => "Valandovo" ,"Novo Selo" => "Novo Selo" ,"Dolneni" => "Dolneni" ,"Oslomej" => "Oslomej" ,"Kratovo" => "Kratovo" ,"Dolna Banjica" => "Dolna Banjica" ,"Sopiste" => "Sopiste" ,"Rostusa" => "Rostusa" ,"Labunista" => "Labunista" ,"Vrapciste" => "Vrapciste" ,"Cucer-Sandevo" => "Cucer-Sandevo" ,"Velesta" => "Velesta" ,"Bogdanci" => "Bogdanci" ,"Delogozdi" => "Delogozdi" ,"Petrovec" => "Petrovec" ,"Sipkovica" => "Sipkovica" ,"Dzepciste" => "Dzepciste" ,"Makedonska Kamenica" => "Makedonska Kamenica" ,"Jegunovce" => "Jegunovce" ,"Demir Hisar" => "Demir Hisar" ,"Murtino" => "Murtino" ,"Krivogastani" => "Krivogastani" ,"Makedonski Brod" => "Makedonski Brod" ,"Oblesevo" => "Oblesevo" ,"Bistrica" => "Bistrica" ,"Plasnica" => "Plasnica" ,"Demir Kapija" => "Demir Kapija" ,"Mogila" => "Mogila" ,"Kuklis" => "Kuklis" ,"Orizari" => "Orizari" ,"Staro Nagoricane" => "Staro Nagoricane" ,"Rosoman" => "Rosoman" ,"Rankovce" => "Rankovce" ,"Zelenikovo" => "Zelenikovo" ,"Karbinci" => "Karbinci" ,"Podares" => "Podares" ,"Gradsko" => "Gradsko" ,"Vratnica" => "Vratnica" ,"Srbinovo" => "Srbinovo" ,"Konce" => "Konce" ,"Star Dojran" => "Star Dojran" ,"Zletovo" => "Zletovo" ,"Drugovo" => "Drugovo" ,"Caska" => "Caska" ,"Lozovo" => "Lozovo" ,"Belcista" => "Belcista" ,"Topolcani" => "Topolcani" ,"Miravci" => "Miravci" ,"Meseista" => "Meseista" ,"Vevcani" => "Vevcani" ,"Kukurecani" => "Kukurecani" ,"Cesinovo" => "Cesinovo" ,"Novaci" => "Novaci" ,"Zitose" => "Zitose" ,"Sopotnica" => "Sopotnica" ,"Dobrusevo" => "Dobrusevo" ,"Blatec" => "Blatec" ,"Klecevce" => "Klecevce" ,"Samokov" => "Samokov" ,"Lukovo" => "Lukovo" ,"Capari" => "Capari" ,"Kosel" => "Kosel" ,"Vranestica" => "Vranestica" ,"Bogomila" => "Bogomila" ,"Orasac" => "Orasac" ,"Mavrovi Anovi" => "Mavrovi Anovi" ,"Bac" => "Bac" ,"Vitoliste" => "Vitoliste" ,"Konopiste" => "Konopiste" ,"Staravina" => "Staravina" ,"Cair" => "Cair" ,"Suto Orizari" => "Suto Orizari" ,"Centar" => "Centar" ,"Centar Zupa" => "Centar Zupa" ,"Vrutok" => "Vrutok" ,"Kisela Voda" => "Kisela Voda" ,"Izvor" => "Izvor" ,"Gazi Baba" => "Gazi Baba" ,"Krusevo" => "Krusevo" ,"Kondovo" => "Kondovo" ,"Pehcevo" => "Pehcevo" ,"Vinica" => "Vinica" );
break;
case 'Moldova':
return array(8=>"Moldova","Chisinau" => "Chisinau" ,"Balti" => "Balti" ,"Cahul" => "Cahul" ,"Ungheni" => "Ungheni" ,"Soroca" => "Soroca" ,"Gagauzia" => "Gagauzia" ,"Drochia" => "Drochia" ,"Straseni" => "Straseni" ,"Edinet" => "Edinet" ,"Falesti" => "Falesti" ,"Calarasi" => "Calarasi" ,"Floresti" => "Floresti" ,"Dubasari" => "Dubasari" ,"Cimislia" => "Cimislia" ,"Rezina" => "Rezina" ,"Nisporeni" => "Nisporeni" ,"Taraclia" => "Taraclia" ,"Basarabeasca" => "Basarabeasca" ,"Glodeni" => "Glodeni" ,"Leova" => "Leova" ,"Briceni" => "Briceni" ,"Ocnita" => "Ocnita" ,"Donduseni" => "Donduseni" ,"Telenesti" => "Telenesti" ,"Singerei" => "Singerei" ,"Soldanesti" => "Soldanesti" ,"Stefan-Voda" => "Stefan-Voda" ,"Bender" => "Bender" ,"Criuleni" => "Criuleni" ,"Riscani" => "Riscani" ,"Hincesti" => "Hincesti" ,"Ialoveni" => "Ialoveni" ,"Anenii Noi" => "Anenii Noi" ,"Causeni" => "Causeni" ,"Cantemir" => "Cantemir" );
break;
case 'Monaco':
return array(8=>"Monaco","La Condamine" => "La Condamine" ,"Monaco" => "Monaco" ,"Monte-Carlo" => "Monte-Carlo" );
break;
case 'Netherlands':
return array(8=>"Netherlands","Zuid-Holland" => "Zuid-Holland" ,"Noord-Holland" => "Noord-Holland" ,"Noord-Brabant" => "Noord-Brabant" ,"Gelderland" => "Gelderland" ,"Overijssel" => "Overijssel" ,"Utrecht" => "Utrecht" ,"Limburg" => "Limburg" ,"Groningen" => "Groningen" ,"Flevoland" => "Flevoland" ,"Drenthe" => "Drenthe" ,"Zeeland" => "Zeeland" ,"Friesland" => "Friesland" );
break;
case 'northern-ireland':
return array(8=>"northern ireland","Belfast" => "Belfast" ,"Londonderry" => "Londonderry" ,"Lisburn" => "Lisburn" ,"North Down" => "North Down" ,"Newtownabbey" => "Newtownabbey" ,"Castlereagh" => "Castlereagh" ,"Craigavon" => "Craigavon" ,"Ards" => "Ards" ,"Newry and Mourne" => "Newry and Mourne" ,"Coleraine" => "Coleraine" ,"Ballymena" => "Ballymena" ,"Antrim" => "Antrim" ,"Carrickfergus" => "Carrickfergus" ,"Down" => "Down" ,"Banbridge" => "Banbridge" ,"Armagh" => "Armagh" ,"Omagh" => "Omagh" ,"Fermanagh" => "Fermanagh" ,"Strabane" => "Strabane" ,"Dungannon and South Tyrone" => "Dungannon and South Tyrone" ,"Larne" => "Larne" ,"Magherafelt" => "Magherafelt" ,"Limavady" => "Limavady" ,"Cookstown" => "Cookstown" ,"Ballymoney" => "Ballymoney" ,"Moyle" => "Moyle" );
break;
case 'Norway':
return array(8=>"Norway","Oslo" => "Oslo" ,"Hordaland" => "Hordaland" ,"Rogaland" => "Rogaland" ,"Sor-Trondelag" => "Sor-Trondelag" ,"Buskerud" => "Buskerud" ,"Nordland" => "Nordland" ,"Vest-Agder" => "Vest-Agder" ,"Akershus" => "Akershus" ,"Troms" => "Troms" ,"More og Romsdal" => "More og Romsdal" ,"Vestfold" => "Vestfold" ,"Oppland" => "Oppland" ,"Nord-Trondelag" => "Nord-Trondelag" ,"Hedmark" => "Hedmark" ,"Ostfold" => "Ostfold" ,"Finnmark" => "Finnmark" ,"Sogn og Fjordane" => "Sogn og Fjordane" ,"Telemark" => "Telemark" ,"Aust-Agder" => "Aust-Agder" );
break;
case 'Poland':
return array(8=>"Poland","Mazowieckie" => "Mazowieckie" ,"Slaskie" => "Slaskie" ,"Dolnoslaskie" => "Dolnoslaskie" ,"Zachodniopomorskie" => "Zachodniopomorskie" ,"Pomorskie" => "Pomorskie" ,"Malopolskie" => "Malopolskie" ,"Podlaskie" => "Podlaskie" ,"Wielkopolskie" => "Wielkopolskie" ,"Kujawsko-Pomorskie" => "Kujawsko-Pomorskie" ,"Lubelskie" => "Lubelskie" ,"Warminsko-Mazurskie" => "Warminsko-Mazurskie" ,"Lodzkie" => "Lodzkie" ,"Podkarpackie" => "Podkarpackie" ,"Swietokrzyskie" => "Swietokrzyskie" ,"Opolskie" => "Opolskie" ,"Lubuskie" => "Lubuskie" );
break;
case 'Portugal':
return array(8=>"Portugal","Lisboa" => "Lisboa" ,"Porto" => "Porto" ,"Setubal" => "Setubal" ,"Aveiro" => "Aveiro" ,"Braga" => "Braga" ,"Faro" => "Faro" ,"Santarem" => "Santarem" ,"Leiria" => "Leiria" ,"Coimbra" => "Coimbra" ,"Madeira" => "Madeira" ,"Evora" => "Evora" ,"Azores" => "Azores" ,"Viseu" => "Viseu" ,"Castelo Branco" => "Castelo Branco" ,"Beja" => "Beja" ,"Portalegre" => "Portalegre" ,"Guarda" => "Guarda" ,"Vila Real" => "Vila Real" ,"Viana do Castelo" => "Viana do Castelo" ,"Braganca" => "Braganca" );
break;
case 'Romania':
return array(8=>"Romania","Bucuresti" => "Bucuresti" ,"Giurgiu" => "Giurgiu" ,"Mehedinti" => "Mehedinti" ,"Vaslui" => "Vaslui" ,"Iasi" => "Iasi" ,"Constanta" => "Constanta" ,"Timis" => "Timis" ,"Arad" => "Arad" ,"Mures" => "Mures" ,"Bihor" => "Bihor" ,"Suceava" => "Suceava" ,"Cluj" => "Cluj" ,"Bacau" => "Bacau" ,"Brasov" => "Brasov" ,"Maramures" => "Maramures" ,"Prahova" => "Prahova" ,"Galati" => "Galati" ,"Dolj" => "Dolj" ,"Buzau" => "Buzau" ,"Botosani" => "Botosani" ,"Arges" => "Arges" ,"Neamt" => "Neamt" ,"Braila" => "Braila" ,"Calarasi" => "Calarasi" ,"Bistrita-Nasaud" => "Bistrita-Nasaud" ,"Valcea" => "Valcea" ,"Harghita" => "Harghita" ,"Vrancea" => "Vrancea" ,"Sibiu" => "Sibiu" ,"Caras-Severin" => "Caras-Severin" ,"Olt" => "Olt" ,"Dambovita" => "Dambovita" ,"Alba" => "Alba" ,"Satu Mare" => "Satu Mare" ,"Gorj" => "Gorj" ,"Salaj" => "Salaj" ,"Teleorman" => "Teleorman" ,"Tulcea" => "Tulcea" ,"Ialomita" => "Ialomita" ,"Covasna" => "Covasna" ,"Ilfov" => "Ilfov" ,"Hunedoara" => "Hunedoara" );
break;
case 'San-Marino':
return array(8=>"San Marino","Serravalle" => "Serravalle" ,"San Marino" => "San Marino" ,"Acquaviva" => "Acquaviva" ,"Chiesanuova" => "Chiesanuova" ,"Domagnano" => "Domagnano" ,"Faetano" => "Faetano" ,"Fiorentino" => "Fiorentino" ,"Borgo Maggiore" => "Borgo Maggiore" );
break;
case 'scotland':
return array(8=>"scotland","Glasgow" => "Glasgow" ,"Edinburgh" => "Edinburgh" ,"Fife" => "Fife" ,"North Lanarkshire" => "North Lanarkshire" ,"South Lanarkshire" => "South Lanarkshire" ,"Aberdeen" => "Aberdeen" ,"West Lothian" => "West Lothian" ,"Aberdeenshire" => "Aberdeenshire" ,"Renfrewshire" => "Renfrewshire" ,"Dundee" => "Dundee" ,"North Ayrshire" => "North Ayrshire" ,"Highland" => "Highland" ,"Falkirk" => "Falkirk" ,"Perth and Kinross" => "Perth and Kinross" ,"East Ayrshire" => "East Ayrshire" ,"South Ayrshire" => "South Ayrshire" ,"Dumfries and Galloway" => "Dumfries and Galloway" ,"East Dunbartonshire" => "East Dunbartonshire" ,"West Dunbartonshire" => "West Dunbartonshire" ,"East Lothian" => "East Lothian" ,"Inverclyde" => "Inverclyde" ,"Angus" => "Angus" ,"Scottish Borders" => "Scottish Borders" ,"Stirling" => "Stirling" ,"East Renfrewshire" => "East Renfrewshire" ,"Moray" => "Moray" ,"Argyll and Bute" => "Argyll and Bute" ,"Midlothian" => "Midlothian" ,"Clackmannanshire" => "Clackmannanshire" ,"Orkney Islands" => "Orkney Islands" ,"Shetland Islands" => "Shetland Islands" ,"Eilean Siar" => "Eilean Siar" );
break;
case 'Serbia':
return array(8=>"Serbia","Vojvodina" => "Vojvodina" ,"Kosovo" => "Kosovo" );
break;
case 'Slovakia':
return array(8=>"Slovakia","Bratislava" => "Bratislava" ,"Kosice" => "Kosice" ,"Banska Bystrica" => "Banska Bystrica" ,"Zilina" => "Zilina" ,"Presov" => "Presov" ,"Nitra" => "Nitra" ,"Trencin" => "Trencin" ,"Trnava" => "Trnava" );
break;
case 'Slovenia':
return array(8=>"Slovenia","Bohinj" => "Bohinj" ,"Brezovica" => "Brezovica" ,"Bled" => "Bled" ,"Borovnica" => "Borovnica" ,"Bovec" => "Bovec" ,"Brda" => "Brda" ,"Brezice" => "Brezice" ,"Celje" => "Celje" ,"Cerklje na Gorenjskem" => "Cerklje na Gorenjskem" ,"Cerknica" => "Cerknica" ,"Cerkno" => "Cerkno" ,"Crensovci" => "Crensovci" ,"Crna na Koroskem" => "Crna na Koroskem" ,"Crnomelj" => "Crnomelj" ,"Divaca" => "Divaca" ,"Dobrepolje" => "Dobrepolje" ,"Dobrova-Horjul-Polhov Gradec" => "Dobrova-Horjul-Polhov Gradec" ,"Dol pri Ljubljani" => "Dol pri Ljubljani" ,"Domzale" => "Domzale" ,"Dornava" => "Dornava" ,"Dravograd" => "Dravograd" ,"Duplek" => "Duplek" ,"Gorenja Vas-Poljane" => "Gorenja Vas-Poljane" ,"Gorisnica" => "Gorisnica" ,"Gornja Radgona" => "Gornja Radgona" ,"Gornji Grad" => "Gornji Grad" ,"Gornji Petrovci" => "Gornji Petrovci" ,"Grosuplje" => "Grosuplje" ,"Hrastnik" => "Hrastnik" ,"Hrpelje-Kozina" => "Hrpelje-Kozina" ,"Idrija" => "Idrija" ,"Ig" => "Ig" ,"Ilirska Bistrica" => "Ilirska Bistrica" ,"Ivancna Gorica" => "Ivancna Gorica" ,"Izola-Isola" => "Izola-Isola" ,"Jesenice" => "Jesenice" ,"Jursinci" => "Jursinci" ,"Kamnik" => "Kamnik" ,"Kanal" => "Kanal" ,"Kidricevo" => "Kidricevo" ,"Kobarid" => "Kobarid" ,"Kobilje" => "Kobilje" ,"Kocevje" => "Kocevje" ,"Komen" => "Komen" ,"Koper-Capodistria" => "Koper-Capodistria" ,"Kozje" => "Kozje" ,"Kranj" => "Kranj" ,"Kranjska Gora" => "Kranjska Gora" ,"Krsko" => "Krsko" ,"Kungota" => "Kungota" ,"Kuzma" => "Kuzma" ,"Lasko" => "Lasko" ,"Lenart" => "Lenart" ,"Litija" => "Litija" ,"Ljubljana" => "Ljubljana" ,"Ljubno" => "Ljubno" ,"Ljutomer" => "Ljutomer" ,"Logatec" => "Logatec" ,"Loska Dolina" => "Loska Dolina" ,"Loski Potok" => "Loski Potok" ,"Luce" => "Luce" ,"Lukovica" => "Lukovica" ,"Majsperk" => "Majsperk" ,"Maribor" => "Maribor" ,"Medvode" => "Medvode" ,"Menges" => "Menges" ,"Metlika" => "Metlika" ,"Mezica" => "Mezica" ,"Miren-Kostanjevica" => "Miren-Kostanjevica" ,"Mislinja" => "Mislinja" ,"Moravce" => "Moravce" ,"Moravske Toplice" => "Moravske Toplice" ,"Mozirje" => "Mozirje" ,"Murska Sobota" => "Murska Sobota" ,"Muta" => "Muta" ,"Naklo" => "Naklo" ,"Nazarje" => "Nazarje" ,"Nova Gorica" => "Nova Gorica" ,"Novo Mesto" => "Novo Mesto" ,"Odranci" => "Odranci" ,"Ormoz" => "Ormoz" ,"Osilnica" => "Osilnica" ,"Pesnica" => "Pesnica" ,"Piran" => "Piran" ,"Pivka" => "Pivka" ,"Podcetrtek" => "Podcetrtek" ,"Postojna" => "Postojna" ,"Preddvor" => "Preddvor" ,"Ptuj" => "Ptuj" ,"Puconci" => "Puconci" ,"Radece" => "Radece" ,"Radenci" => "Radenci" ,"Radlje ob Dravi" => "Radlje ob Dravi" ,"Radovljica" => "Radovljica" ,"Ribnica" => "Ribnica" ,"Rogaska Slatina" => "Rogaska Slatina" ,"Rogasovci" => "Rogasovci" ,"Rogatec" => "Rogatec" ,"Ruse" => "Ruse" ,"Semic" => "Semic" ,"Sencur" => "Sencur" ,"Sentilj" => "Sentilj" ,"Sentjernej" => "Sentjernej" ,"Sentjur pri Celju" => "Sentjur pri Celju" ,"Sevnica" => "Sevnica" ,"Sezana" => "Sezana" ,"Skocjan" => "Skocjan" ,"Skofja Loka" => "Skofja Loka" ,"Skofljica" => "Skofljica" ,"Slovenj Gradec" => "Slovenj Gradec" ,"Slovenska Bistrica" => "Slovenska Bistrica" ,"Slovenske Konjice" => "Slovenske Konjice" ,"Smarje pri Jelsah" => "Smarje pri Jelsah" ,"Smartno ob Paki" => "Smartno ob Paki" ,"Sostanj" => "Sostanj" ,"Starse" => "Starse" ,"Sveti Jurij" => "Sveti Jurij" ,"Tolmin" => "Tolmin" ,"Trbovlje" => "Trbovlje" ,"Trebnje" => "Trebnje" ,"Trzic" => "Trzic" ,"Turnisce" => "Turnisce" ,"Velenje" => "Velenje" ,"Velike Lasce" => "Velike Lasce" ,"Videm" => "Videm" ,"Vipava" => "Vipava" ,"Vitanje" => "Vitanje" ,"Vodice" => "Vodice" ,"Vojnik" => "Vojnik" ,"Vrhnika" => "Vrhnika" ,"Vuzenica" => "Vuzenica" ,"Zagorje ob Savi" => "Zagorje ob Savi" ,"Zalec" => "Zalec" ,"Zavrc" => "Zavrc" ,"Zelezniki" => "Zelezniki" ,"Ziri" => "Ziri" ,"Ajdovscina" => "Ajdovscina" ,"Zrece" => "Zrece" ,"Beltinci" => "Beltinci" );
break;
case 'Spain':
return array(8=>"Spain","Andalusien" => "Andalusien" ,"Katalonien" => "Katalonien" ,"Madrid" => "Madrid" ,"Valencia" => "Valencia" ,"Galizien" => "Galizien" ,"Baskenland" => "Baskenland" ,"Kastilien-Leon" => "Kastilien-Leon" ,"Kastilien-La Mancha" => "Kastilien-La Mancha" ,"Kanaren" => "Kanaren" ,"Murcia" => "Murcia" ,"Aragonien" => "Aragonien" ,"Extremadura" => "Extremadura" ,"Balearen" => "Balearen" ,"Asturien" => "Asturien" ,"Navarra" => "Navarra" ,"Kantabrien" => "Kantabrien" ,"La Rioja" => "La Rioja" ,"Ceuta" => "Ceuta" ,"Melilla" => "Melilla" ,"Port of Spain" => "Port of Spain" );
break;
case 'Sweden':
return array(8=>"Sweden","Stockholms Lan" => "Stockholms Lan" ,"Vastra Gotaland" => "Vastra Gotaland" ,"Skane Lan" => "Skane Lan" ,"Ostergotlands Lan" => "Ostergotlands Lan" ,"Uppsala Lan" => "Uppsala Lan" ,"Vastmanlands Lan" => "Vastmanlands Lan" ,"Jonkopings Lan" => "Jonkopings Lan" ,"Orebro Lan" => "Orebro Lan" ,"Sodermanlands Lan" => "Sodermanlands Lan" ,"Gavleborgs Lan" => "Gavleborgs Lan" ,"Hallands Lan" => "Hallands Lan" ,"Vasterbottens Lan" => "Vasterbottens Lan" ,"Norrbottens Lan" => "Norrbottens Lan" ,"Vasternorrlands Lan" => "Vasternorrlands Lan" ,"Dalarnas Lan" => "Dalarnas Lan" ,"Varmlands Lan" => "Varmlands Lan" ,"Kalmar Lan" => "Kalmar Lan" ,"Kronobergs Lan" => "Kronobergs Lan" ,"Blekinge Lan" => "Blekinge Lan" ,"Jamtlands Lan" => "Jamtlands Lan" ,"Gotlands Lan" => "Gotlands Lan" );
break;
case 'Switzerland':
return array(8=>"Switzerland","Zurich" => "Zurich" ,"Bern" => "Bern" ,"Vaud" => "Vaud" ,"Geneve" => "Geneve" ,"Aargau" => "Aargau" ,"Basel-Stadt" => "Basel-Stadt" ,"Luzern" => "Luzern" ,"Valais" => "Valais" ,"Basel-Landschaft" => "Basel-Landschaft" ,"Ticino" => "Ticino" ,"Sankt Gallen" => "Sankt Gallen" ,"Thurgau" => "Thurgau" ,"Neuchatel" => "Neuchatel" ,"Solothurn" => "Solothurn" ,"Zug" => "Zug" ,"Schwyz" => "Schwyz" ,"Fribourg" => "Fribourg" ,"Graubunden" => "Graubunden" ,"Ausser-Rhoden" => "Ausser-Rhoden" ,"Schaffhausen" => "Schaffhausen" ,"Inner-Rhoden" => "Inner-Rhoden" ,"Jura" => "Jura" ,"Obwalden" => "Obwalden" ,"Nidwalden" => "Nidwalden" ,"Glarus" => "Glarus" ,"Uri" => "Uri" );
break;
case 'Ukraine':
return array(8=>"Ukraine","Kyyivs'ka Oblast" => "Kyyivs'ka Oblast" ,"Odes'ka Oblast" => "Odes'ka Oblast" ,"Donets'ka Oblast" => "Donets'ka Oblast" ,"L'vivs'ka Oblast" => "L'vivs'ka Oblast" ,"Zaporiz'ka Oblast" => "Zaporiz'ka Oblast" ,"Dnipropetrovs'ka Oblast" => "Dnipropetrovs'ka Oblast" ,"Vinnyts'ka Oblast" => "Vinnyts'ka Oblast" ,"Poltavs'ka Oblast" => "Poltavs'ka Oblast" ,"Sums'ka Oblast" => "Sums'ka Oblast" ,"Krym" => "Krym" ,"Chernihivs'ka Oblast" => "Chernihivs'ka Oblast" ,"Kharkivs'ka Oblast" => "Kharkivs'ka Oblast" ,"Khersons'ka Oblast" => "Khersons'ka Oblast" ,"Cherkas'ka Oblast" => "Cherkas'ka Oblast" ,"Zhytomyrs'ka Oblast" => "Zhytomyrs'ka Oblast" ,"Kirovohrads'ka Oblast" => "Kirovohrads'ka Oblast" ,"Luhans'ka Oblast" => "Luhans'ka Oblast" ,"Zakarpats'ka Oblast" => "Zakarpats'ka Oblast" ,"Rivnens'ka Oblast" => "Rivnens'ka Oblast" ,"Ivano-Frankivs'ka Oblast" => "Ivano-Frankivs'ka Oblast" ,"Chernivets'ka Oblast" => "Chernivets'ka Oblast" ,"Khmel'nyts'ka Oblast" => "Khmel'nyts'ka Oblast" ,"Mykolayivs'ka Oblast" => "Mykolayivs'ka Oblast" ,"Ternopil's'ka Oblast" => "Ternopil's'ka Oblast" ,"Volyns'ka Oblast" => "Volyns'ka Oblast" ,"Sevastopol" => "Sevastopol" ,"Kyyiv" => "Kyyiv" );
break;
case 'wales':
return array(8=>"wales","Cardiff" => "Cardiff" ,"Swansea" => "Swansea" ,"Rhondda Cynon Taff" => "Rhondda Cynon Taff" ,"Caerphilly" => "Caerphilly" ,"Newport" => "Newport" ,"Carmarthenshire" => "Carmarthenshire" ,"Neath Port Talbot" => "Neath Port Talbot" ,"Bridgend" => "Bridgend" ,"Vale of Glamorgan" => "Vale of Glamorgan" ,"Flintshire" => "Flintshire" ,"Wrexham" => "Wrexham" ,"Torfaen" => "Torfaen" ,"Conwy" => "Conwy" ,"Denbighshire" => "Denbighshire" ,"Pembrokeshire" => "Pembrokeshire" ,"Blaenau Gwent" => "Blaenau Gwent" ,"Gwynedd" => "Gwynedd" ,"Powys" => "Powys" ,"Monmouthshire" => "Monmouthshire" ,"Merthyr Tydfil" => "Merthyr Tydfil" ,"Ceredigion" => "Ceredigion" ,"Anglesey" => "Anglesey" );
break;
case 'United-Kingdom':
return array(8=>"United Kingdom","London" => "London" ,"West Midlands" => "West Midlands" ,"Greater Manchester" => "Greater Manchester" ,"West Yorkshire" => "West Yorkshire" ,"Kent" => "Kent" ,"Merseyside" => "Merseyside" ,"Essex" => "Essex" ,"South Yorkshire" => "South Yorkshire" ,"Hampshire" => "Hampshire" ,"Surrey" => "Surrey" ,"Tyne and Wear" => "Tyne and Wear" ,"Hertfordshire" => "Hertfordshire" ,"Lancashire" => "Lancashire" ,"Nottinghamshire" => "Nottinghamshire" ,"Cheshire" => "Cheshire" ,"Staffordshire" => "Staffordshire" ,"Derbyshire" => "Derbyshire" ,"Norfolk" => "Norfolk" ,"West Sussex" => "West Sussex" ,"Northamptonshire" => "Northamptonshire" ,"Oxfordshire" => "Oxfordshire" ,"Devon" => "Devon" ,"Suffolk" => "Suffolk" ,"Lincolnshire" => "Lincolnshire" ,"Gloucestershire" => "Gloucestershire" ,"Leicestershire" => "Leicestershire" ,"Cambridgeshire" => "Cambridgeshire" ,"East Sussex" => "East Sussex" ,"Durham" => "Durham" ,"Bristol" => "Bristol" ,"Warwickshire" => "Warwickshire" ,"Buckinghamshire" => "Buckinghamshire" ,"North Yorkshire" => "North Yorkshire" ,"Bedfordshire" => "Bedfordshire" ,"Cumbria" => "Cumbria" ,"Somerset" => "Somerset" ,"Cornwall" => "Cornwall" ,"Wiltshire" => "Wiltshire" ,"Shropshire" => "Shropshire" ,"Leicester" => "Leicester" ,"Worcestershire" => "Worcestershire" ,"Kingston upon Hull" => "Kingston upon Hull" ,"Plymouth" => "Plymouth" ,"Stoke-on-Trent" => "Stoke-on-Trent" ,"Derby" => "Derby" ,"Dorset" => "Dorset" ,"Nottingham" => "Nottingham" ,"Southampton" => "Southampton" ,"Brighton and Hove" => "Brighton and Hove" ,"Herefordshire" => "Herefordshire" ,"Northumberland" => "Northumberland" ,"Portsmouth" => "Portsmouth" ,"East Riding of Yorkshire" => "East Riding of Yorkshire" ,"Luton" => "Luton" ,"Swindon" => "Swindon" ,"Southend-on-Sea" => "Southend-on-Sea" ,"York" => "York" ,"South Gloucestershire" => "South Gloucestershire" ,"Milton Keynes" => "Milton Keynes" ,"Bournemouth" => "Bournemouth" ,"North Somerset" => "North Somerset" ,"Warrington" => "Warrington" ,"Peterborough" => "Peterborough" ,"Reading" => "Reading" ,"Blackpool" => "Blackpool" ,"North East Lincolnshire" => "North East Lincolnshire" ,"Middlesbrough" => "Middlesbrough" ,"Stockton-on-Tees" => "Stockton-on-Tees" ,"Blackburn with Darwen" => "Blackburn with Darwen" ,"Torbay" => "Torbay" ,"Poole" => "Poole" ,"Windsor and Maidenhead" => "Windsor and Maidenhead" ,"North Lincolnshire" => "North Lincolnshire" ,"Bath and North East Somerset" => "Bath and North East Somerset" ,"Slough" => "Slough" ,"Halton" => "Halton" ,"Isle of Wight" => "Isle of Wight" ,"Bracknell Forest" => "Bracknell Forest" ,"Hartlepool" => "Hartlepool" ,"Darlington" => "Darlington" ,"West Berkshire" => "West Berkshire" ,"Redcar and Cleveland" => "Redcar and Cleveland" ,"Wokingham" => "Wokingham" ,"Rutland" => "Rutland" );
break;
case 'Arctic-Ocean':
return array(8=>"Arctic-Ocean","Franz-Josef-Land" => "Franz Josef Land" ,"Svalbard" => "Svalbard" );
break;
case 'Atlantic-Ocean-North':
return array(8=>"Atlantic-Ocean-North","Alderney" => "Alderney" ,"Azores" => "Azores" ,"Baixo" => "Baixo" ,"Belle-Ile" => "Belle-Ile" ,"Bermuda" => "Bermuda" ,"Bioko" => "Bioko" ,"Block" => "Block" ,"Boa-Vista" => "Boa Vista" ,"Borduy" => "Borduy" ,"Bugio" => "Bugio" ,"Canary-Islands" => "Canary Islands" ,"Cape-Breton" => "Cape Breton" ,"Cape-Verde-Islands" => "Cape Verde Islands" ,"Channel-Islands" => "Channel Islands" ,"Corvo" => "Corvo" ,"Deer-Isle" => "Deer Isle" ,"Eysturoy" => "Eysturoy" ,"Faeroe-Islands" => "Faeroe Islands" ,"Fago" => "Fago" ,"Faial" => "Faial" ,"Flores" => "Flores" ,"Fuerteventura" => "Fuerteventura" ,"Fugloy" => "Fugloy" ,"Gomera" => "Gomera" ,"Graciosa" => "Graciosa" ,"Gran-Canaria" => "Gran Canaria" ,"Grand-Manan" => "Grand Manan" ,"Grande" => "Grande" ,"Greenland" => "Greenland" ,"Guernsey" => "Guernsey" ,"Hebrides" => "Hebrides" ,"Herm" => "Herm" ,"Hestur" => "Hestur" ,"Hierro" => "Hierro" ,"Iceland" => "Iceland" ,"Iles-De-La-Madeleine" => "Iles De La Madeleine" ,"Ile-de-Noirmoutier" => "Ile de Noirmoutier" ,"Ile-de'-Re" => "Ile de' Re" ,"Ile-d'-OlÃ¢â‚¬Å¡ron" => "Ile d' OlÃ¢â‚¬Å¡ron" ,"Ile-d'-Yeu" => "Ile d' Yeu" ,"Ilhas-Desertas" => "Ilhas Desertas" ,"Ireland" => "Ireland" ,"Isle-au-Haut" => "Isle au Haut" ,"Isle-of-Lewis" => "Isle of Lewis" ,"Isle-of-Mull" => "Isle of Mull" ,"Isle-of-Skye" => "Isle of Skye" ,"Jersey" => "Jersey" ,"Kalsoy" => "Kalsoy" ,"Koltur" => "Koltur" ,"Kunoy" => "Kunoy" ,"Lanzarote" => "Lanzarote" ,"La-Palma" => "La Palma" ,"Litla-Dimun" => "Litla Dimun" ,"Long-Island" => "Long Island" ,"Jan-Mayen" => "Jan Mayen" ,"Madeira-Islands" => "Madeira Islands" ,"Maio" => "Maio" ,"Martha's-Vineyard" => "Martha's Vineyard" ,"Matinicus" => "Matinicus" ,"Monhegan" => "Monhegan" ,"Mount-Desert" => "Mount Desert" ,"Mykines" => "Mykines" ,"Nantucket-Island" => "Nantucket Island" ,"Newfoundland" => "Newfoundland" ,"Nolsoy" => "Nolsoy" ,"Orkney-Islands" => "Orkney Islands" ,"Pico" => "Pico" ,"Porto-Santo" => "Porto Santo" ,"Prince-Edward-Island" => "Prince Edward Island" ,"St.-Peter/St.-Paul-Rocks" => "St. Peter/St. Paul Rocks" ,"St.-Pierre/Miquelon" => "St.-Pierre/Miquelon" ,"Praia" => "Praia" ,"Sable-Island" => "Sable Island" ,"Sal" => "Sal" ,"Sandoy" => "Sandoy" ,"Santo-Antao" => "Santo Antao" ,"Santa-Maria" => "Santa Maria" ,"Sao-Jorge" => "Sao Jorge" ,"Sao-Miguel" => "Sao Miguel" ,"Sao-Nicolau" => "Sao Nicolau" ,"Sao-Tiago" => "Sao Tiago" ,"Sao-Tome/Principe" => "Sao Tome/Principe" ,"Sao-Vicente" => "Sao Vicente" ,"Sark" => "Sark" ,"Scilly-Isles" => "Scilly Isles" ,"Shetland-Islands" => "Shetland Islands" ,"Skuvoy" => "Skuvoy" ,"Stora-Dimun" => "Stora Dimun" ,"Streymoy" => "Streymoy" ,"Sumba" => "Sumba" ,"Svinoy" => "Svinoy" ,"Swans" => "Swans" ,"Tenerife" => "Tenerife" ,"Terceira" => "Terceira" ,"Uist-Islands" => "Uist Islands" ,"Vagar" => "Vagar" ,"Viday" => "Viday" ,"Vinalhaven" => "Vinalhaven" );
break;
case 'Atlantic-Ocean-South':
return array(8=>"Atlantic-Ocean-South","Amsterdam" => "Amsterdam" ,"Andaman-Islands" => "Andaman Islands" ,"Annobon" => "Annobon" ,"Ascension" => "Ascension" ,"Bouvet" => "Bouvet" ,"Falkland-Islands" => "Falkland Islands" ,"Gough" => "Gough" ,"Martin-Vas-Islands" => "Martin Vas Islands" ,"Nightingale" => "Nightingale" ,"St.-Helena" => "St. Helena" ,"Shag/Black-Rocks" => "Shag/Black Rocks" ,"South-Georgia" => "South Georgia" ,"South-Orkney-Islands" => "South Orkney Islands" ,"South-Sandwich-Islands" => "South Sandwich Islands" ,"Traversay" => "Traversay" ,"Trindade" => "Trindade" ,"Tristan-da-Cunha" => "Tristan da Cunha" );
break;
case 'Assorted':
return array(8=>"Assorted","Akimiski" => "Akimiski" ,"Aland" => "Aland" ,"Alcatraz" => "Alcatraz" ,"Apostle-Islands" => "Apostle Islands" ,"Baffin" => "Baffin" ,"Banka" => "Banka" ,"Banks" => "Banks" ,"Beaver" => "Beaver" ,"Belcher-Islands" => "Belcher Islands" ,"Belitung" => "Belitung" ,"Borneo" => "Borneo" ,"Bornholm" => "Bornholm" ,"Brac" => "Brac" ,"Coats" => "Coats" ,"Cres" => "Cres" ,"Devon" => "Devon" ,"East-Frisian-Islands" => "East Frisian Islands" ,"Ellesmere" => "Ellesmere" ,"Fyn" => "Fyn" ,"Galveston" => "Galveston" ,"Gotland" => "Gotland" ,"Groote-Eylandt" => "Groote Eylandt" ,"Hiiumaa" => "Hiiumaa" ,"Hong-Kong-Island" => "Hong Kong Island" ,"Ile-d'-Anticosti" => "Ile d' Anticosti" ,"Ile-d'-Orleans" => "Ile d' Orleans" ,"Isla-de-Ometepe" => "Isla de Ometepe" ,"Isla-Del-Ray" => "Isla Del Ray" ,"Isle-of-Man" => "Isle of Man" ,"Isle-of-Wight" => "Isle of Wight" ,"Isle-Royale" => "Isle Royale" ,"Jutland" => "Jutland" ,"Key-Largo" => "Key Largo" ,"Key-West" => "Key West" ,"King-William" => "King William" ,"Krek" => "Krek" ,"Langeland" => "Langeland" ,"Lantau" => "Lantau" ,"Lolland" => "Lolland" ,"Lundy" => "Lundy" ,"Mackinac" => "Mackinac" ,"Madeleine-Islands" => "Madeleine Islands" ,"Manhattan-Island" => "Manhattan Island" ,"Manitoulin" => "Manitoulin" ,"Marsh" => "Marsh" ,"Matagorda" => "Matagorda" ,"Melville" => "Melville" ,"North-Hero" => "North Hero" ,"Oland" => "Oland" ,"Paracel-Islands" => "Paracel Islands" ,"Pelee" => "Pelee" ,"Prince-Charles" => "Prince Charles" ,"Prince-of-Wales" => "Prince of Wales" ,"Queen-Elizabeth-Islands" => "Queen Elizabeth Islands" ,"Saaremaa" => "Saaremaa" ,"Sjaelland" => "Sjaelland" ,"Somerset" => "Somerset" ,"Southhampton" => "Southhampton" ,"South-Hero" => "South Hero" ,"Spratley-Islands" => "Spratley Islands" ,"Sulawesi" => "Sulawesi" ,"Victoria" => "Victoria" ,"Washington" => "Washington" ,"Wellesley-Islands" => "Wellesley Islands" );
break;
case 'Caribbean-Sea':
return array(8=>"Caribbean Sea","Abaco-(great)" => "Abaco (great)" ,"Abaco-(little)" => "Abaco (little)" ,"Acklins" => "Acklins" ,"Andros" => "Andros" ,"Anegada" => "Anegada" ,"Anguilla" => "Anguilla" ,"Antigua" => "Antigua" ,"Aruba" => "Aruba" ,"Bahamas" => "Bahamas" ,"Barbados" => "Barbados" ,"Barbuda" => "Barbuda" ,"Bimini-Islands" => "Bimini Islands" ,"Bonaire" => "Bonaire" ,"Caicos-Islands" => "Caicos Islands" ,"Cat" => "Cat" ,"Cayman-Brac" => "Cayman Brac" ,"Cayman-Islands" => "Cayman Islands" ,"Cozumel" => "Cozumel" ,"Crooked" => "Crooked" ,"Cuba" => "Cuba" ,"Curacao" => "Curacao" ,"Dominica" => "Dominica" ,"Exuma" => "Exuma" ,"Grand-Bahama" => "Grand Bahama" ,"Grand-Cayman" => "Grand Cayman" ,"Grand-Turk" => "Grand Turk" ,"Greater-Antilles" => "Greater Antilles" ,"Great-Inagua" => "Great Inagua" ,"Grenada" => "Grenada" ,"Guadeloupe" => "Guadeloupe" ,"Hispaniola-(Haiti/DOR)" => "Hispaniola (Haiti/DOR)" ,"Isla-de-Margarita" => "Isla de Margarita" ,"Isla-Mujeres" => "Isla Mujeres" ,"Isla-La-Tortuga" => "Isla La Tortuga" ,"Isle-of-Youth" => "Isle of Youth" ,"Jamaica" => "Jamaica" ,"Lesser-Antilles" => "Lesser Antilles" ,"Little-Cayman" => "Little Cayman" ,"Little-Inagua" => "Little Inagua" ,"Long" => "Long" ,"Marie-Galante" => "Marie-Galante" ,"Martinique" => "Martinique" ,"Mayaguana" => "Mayaguana" ,"Montserrat" => "Montserrat" ,"Navassa" => "Navassa" ,"Nevis" => "Nevis" ,"New-Providence" => "New Providence" ,"Providencia" => "Providencia" ,"Puerto-Rico" => "Puerto Rico" ,"Roatan" => "Roatan" ,"Rum-Cay" => "Rum Cay" ,"St.-Barts" => "St. Barts" ,"St.-Croix" => "St. Croix" ,"St.-Eustatius" => "St. Eustatius" ,"St.-John" => "St. John" ,"St.-Kitts" => "St. Kitts" ,"St.-Lucia" => "St. Lucia" ,"St.-Martin/Sint-Maartan" => "St. Martin/Sint Maartan" ,"St.-Thomas" => "St. Thomas" ,"St-Vincent-and-the-Grenadines" => "St Vincent and the Grenadines" ,"Saba" => "Saba" ,"San-Blas-Islands" => "San Blas Islands" ,"San-Salvador" => "San Salvador" ,"San-Andres" => "San Andres" ,"Santa-Catilina-(St.-Catherine)" => "Santa Catilina (St. Catherine)" ,"Tobago" => "Tobago" ,"Tortola" => "Tortola" ,"Trinidad" => "Trinidad" ,"Virgin-Gorda" => "Virgin Gorda" ,"West-Indies" => "West Indies" );
break;
case 'Greek-Isles':
return array(8=>"Greek Isles","Aegina" => "Aegina" ,"Alonissos" => "Alonissos" ,"Amorgos" => "Amorgos" ,"Andros" => "Andros" ,"Angistri" => "Angistri" ,"Astipalea" => "Astipalea" ,"Carpathos" => "Carpathos" ,"Cephalonia" => "Cephalonia" ,"Chios-(Hios)" => "Chios (Hios)" ,"Corfu" => "Corfu" ,"Cos-(Kos)" => "Cos (Kos)" ,"Crete-(Kriti)" => "Crete (Kriti)" ,"Cyclades-Islands" => "Cyclades Islands" ,"Dodecanese-Islands" => "Dodecanese Islands" ,"Dokos" => "Dokos" ,"Eubaea-(Evia)" => "Eubaea (Evia)" ,"Evia" => "Evia" ,"Hydra" => "Hydra" ,"Ikaria" => "Ikaria" ,"Ionian-Islands" => "Ionian Islands" ,"Ios" => "Ios" ,"Ithaca" => "Ithaca" ,"Kea" => "Kea" ,"Kefalonia" => "Kefalonia" ,"Kefalos" => "Kefalos" ,"Kalimnos" => "Kalimnos" ,"Kassos" => "Kassos" ,"Kithnos" => "Kithnos" ,"Kos" => "Kos" ,"Kythnos" => "Kythnos" ,"Kythria" => "Kythria" ,"Lefkada" => "Lefkada" ,"Lemnos" => "Lemnos" ,"Leros" => "Leros" ,"Lesvos" => "Lesvos" ,"Leucas" => "Leucas" ,"Limnos" => "Limnos" ,"Lipsi" => "Lipsi" ,"Los" => "Los" ,"Melos" => "Melos" ,"Mykonos" => "Mykonos" ,"Naxos" => "Naxos" ,"Nisyros" => "Nisyros" ,"Paros" => "Paros" ,"Patmos" => "Patmos" ,"Poros" => "Poros" ,"Pothia" => "Pothia" ,"Rhodes-(Rodos)" => "Rhodes (Rodos)" ,"Salamina" => "Salamina" ,"Samos" => "Samos" ,"Samothrace" => "Samothrace" ,"Santorini" => "Santorini" ,"Serifos" => "Serifos" ,"Seriphos" => "Seriphos" ,"Sifnos" => "Sifnos" ,"Sikinos" => "Sikinos" ,"Skiros" => "Skiros" ,"Skiathos" => "Skiathos" ,"Skopelos" => "Skopelos" ,"Skyros" => "Skyros" ,"Spetses" => "Spetses" ,"Sporades-Islands" => "Sporades Islands" ,"Syros" => "Syros" ,"Tenos-(Tinos)" => "Tenos (Tinos)" ,"Thassos" => "Thassos" ,"Tzia" => "Tzia" ,"Zakinthos" => "Zakinthos" ,"Zante" => "Zante" );
break;
case 'Indian-Ocean':
return array(8=>"Indian Ocean","Addu-Atoll" => "Addu Atoll" ,"Agalega-Islands" => "Agalega Islands" ,"Amsterdam" => "Amsterdam" ,"Andaman-Islands" => "Andaman Islands" ,"Anjouan-(Nzwani)" => "Anjouan (Nzwani)" ,"Ari-Atoll" => "Ari Atoll" ,"Ashmore/Cartier-Islands" => "Ashmore/Cartier Islands" ,"Bali" => "Bali" ,"Barrow" => "Barrow" ,"Bathurst" => "Bathurst" ,"Bompoka" => "Bompoka" ,"Cape-Barren" => "Cape Barren" ,"Car-Nicobar" => "Car Nicobar" ,"Chagos-Archipelago" => "Chagos Archipelago" ,"Christmas" => "Christmas" ,"Comoros" => "Comoros" ,"Crozet-Islands" => "Crozet Islands" ,"Danger" => "Danger" ,"Diego-Garcia" => "Diego Garcia" ,"Eagle-Islands" => "Eagle Islands" ,"Egmont-Islands" => "Egmont Islands" ,"Faadhippolhu-Atoll" => "Faadhippolhu Atoll" ,"Felidhoo-Atoll" => "Felidhoo Atoll" ,"Flinders" => "Flinders" ,"Goidhoo-Atoll" => "Goidhoo Atoll" ,"Grand-Comore-(Njazidja)" => "Grand Comore (Njazidja)" ,"Great-Nicobar" => "Great Nicobar" ,"Hadhdhunmathee" => "Hadhdhunmathee" ,"Heard" => "Heard" ,"Huvadhoo-Atoll" => "Huvadhoo Atoll" ,"Ihavandhippolhu-Atoll" => "Ihavandhippolhu Atoll" ,"Java" => "Java" ,"Kangaroo" => "Kangaroo" ,"Katchall" => "Katchall" ,"Keeling-Islands-(Cocos)" => "Keeling Islands (Cocos)" ,"King" => "King" ,"Kolhumadulu-Atoll" => "Kolhumadulu Atoll" ,"Lakshadweep-Islands" => "Lakshadweep Islands" ,"Little-Andaman" => "Little Andaman" ,"Little-Nicobar" => "Little Nicobar" ,"Lower-Andaman" => "Lower Andaman" ,"Maalhosmadulu-Atoll" => "Maalhosmadulu Atoll" ,"Maamakunudhoo-Atoll" => "Maamakunudhoo Atoll" ,"Madagascar" => "Madagascar" ,"Mahe" => "Mahe" ,"Maldives" => "Maldives" ,"Male'-Atoll" => "Male' Atoll" ,"Mauritius" => "Mauritius" ,"Mayotte" => "Mayotte" ,"McDonald-Islands" => "McDonald Islands" ,"Melville" => "Melville" ,"Middle-Andaman" => "Middle Andaman" ,"Miladhunmafulu-Atoll" => "Miladhunmafulu Atoll" ,"Moheli-(Mwali)" => "Moheli (Mwali)" ,"Molaku-Atoll" => "Molaku Atoll" ,"Nancowry" => "Nancowry" ,"Nelsons-Island" => "Nelsons Island" ,"Nias" => "Nias" ,"Nicobar-Islands" => "Nicobar Islands" ,"Nilandhoo-Atoll" => "Nilandhoo Atoll" ,"North-Andaman" => "North Andaman" ,"Peros-Banhos" => "Peros Banhos" ,"Phuket" => "Phuket" ,"Prince-Edward-Islands" => "Prince Edward Islands" ,"Reunion" => "Reunion" ,"Rodrigues" => "Rodrigues" ,"St.-Paul" => "St. Paul" ,"Salomon-Islands" => "Salomon Islands" ,"Seychelles" => "Seychelles" ,"Shag" => "Shag" ,"Siberut" => "Siberut" ,"Simeulue" => "Simeulue" ,"Sipura" => "Sipura" ,"Socotra" => "Socotra" ,"Sumatra" => "Sumatra" ,"Sri-Lanka" => "Sri Lanka" ,"Tarasa-Dwip" => "Tarasa Dwip" ,"Tasmania" => "Tasmania" ,"Thiladhunmathee-Atoll" => "Thiladhunmathee Atoll" ,"Three-Brothers" => "Three Brothers" ,"Timor" => "Timor" ,"Tromelin" => "Tromelin" ,"Zanzibar" => "Zanzibar" );
break;
case 'Mediterranean-Sea':
return array(8=>"Mediterranean Sea","Aeolian-Islands" => "Aeolian Islands" ,"Alboran" => "Alboran" ,"Balearic-Islands" => "Balearic Islands" ,"Cabrera" => "Cabrera" ,"Capraia" => "Capraia" ,"Capri" => "Capri" ,"Corse-(Corsica)" => "Corse (Corsica)" ,"Cyprus" => "Cyprus" ,"Elba" => "Elba" ,"Formentera" => "Formentera" ,"Gozo" => "Gozo" ,"Ibiza-(Ivisa)" => "Ibiza (Ivisa)" ,"Iles-d'-Hyeres" => "Iles d' Hyeres" ,"Jalitah" => "Jalitah" ,"Lampedusa" => "Lampedusa" ,"Lipari-Islands" => "Lipari Islands" ,"Mallorca-(Majorca)" => "Mallorca (Majorca)" ,"Malta" => "Malta" ,"Maltese-Islands" => "Maltese Islands" ,"Menorca-(Minorca)" => "Menorca (Minorca)" ,"Pantelleria" => "Pantelleria" ,"Ponziane" => "Ponziane" ,"Salina" => "Salina" ,"Sant'-Antioca" => "Sant' Antioca" ,"San-Pietro" => "San Pietro" ,"Sardinia-(Sardegna)" => "Sardinia (Sardegna)" ,"Sicily-(Sicilia)" => "Sicily (Sicilia)" ,"Stromboli" => "Stromboli" ,"Vulcano" => "Vulcano" ,"Zembra" => "Zembra" );
break;
case 'Oceania':
return array(8=>"Oceania","Abaiang" => "Abaiang" ,"Admiralty-Islands" => "Admiralty Islands" ,"Aitutaki" => "Aitutaki" ,"Alofi" => "Alofi" ,"Ambrym" => "Ambrym" ,"American-Samoa" => "American Samoa" ,"Antipodes" => "Antipodes" ,"Atafu-Atoll" => "Atafu Atoll" ,"Atiu" => "Atiu" ,"Auckland-Islands" => "Auckland Islands" ,"Aunu'u" => "Aunu'u" ,"Austral-Islands" => "Austral Islands" ,"Banaba" => "Banaba" ,"Bega" => "Bega" ,"Bora-Bora" => "Bora Bora" ,"Bougainville" => "Bougainville" ,"Bounty-Islands" => "Bounty Islands" ,"Campbell" => "Campbell" ,"Chatham-Islands" => "Chatham Islands" ,"Choiseul" => "Choiseul" ,"Cook-Islands" => "Cook Islands" ,"Coral-Sea-Islands" => "Coral Sea Islands" ,"Efate" => "Efate" ,"Elao" => "Elao" ,"Erromango" => "Erromango" ,"Espiritu-Santo" => "Espiritu Santo" ,"'-Eua" => "' Eua" ,"Faioa" => "Faioa" ,"Fakaofo-Atoll" => "Fakaofo Atoll" ,"Fatu-Hiva" => "Fatu Hiva" ,"Fiji" => "Fiji" ,"French-Polynesia" => "French Polynesia" ,"Funafuti-Atoll" => "Funafuti Atoll" ,"Futuna" => "Futuna" ,"Gambier-Islands" => "Gambier Islands" ,"Gau" => "Gau" ,"Gilbert-Islands" => "Gilbert Islands" ,"Gizo" => "Gizo" ,"Grand-Terre" => "Grand Terre" ,"Great-Barrier-Reef" => "Great Barrier Reef" ,"Guadacanal" => "Guadacanal" ,"Ha'apai-Island-Group" => "Ha'apai Island Group" ,"Hatutu" => "Hatutu" ,"Hiva-Oa" => "Hiva Oa" ,"Horne-Islands" => "Horne Islands" ,"Huahine" => "Huahine" ,"Isle-of-Pines" => "Isle of Pines" ,"Kadavu" => "Kadavu" ,"Karkar" => "Karkar" ,"Kioa" => "Kioa" ,"Kiribati" => "Kiribati" ,"Kiritamati" => "Kiritamati" ,"Koro" => "Koro" ,"Lakeba" => "Lakeba" ,"Lau-Group" => "Lau Group" ,"Lifou" => "Lifou" ,"Line-Islands" => "Line Islands" ,"Loyalty-Islands" => "Loyalty Islands" ,"Malaita" => "Malaita" ,"Malekula" => "Malekula" ,"Malolo" => "Malolo" ,"Mangaia" => "Mangaia" ,"Manihiki" => "Manihiki" ,"Manu'a-Group" => "Manu'a Group" ,"Manuae" => "Manuae" ,"Mare" => "Mare" ,"Marquises-Islands" => "Marquises Islands" ,"Mata-Utu" => "Mata Utu" ,"Matuku" => "Matuku" ,"Mauke" => "Mauke" ,"Maupiti" => "Maupiti" ,"Melanesia" => "Melanesia" ,"Mitiaro" => "Mitiaro" ,"Moala" => "Moala" ,"Mohotani" => "Mohotani" ,"Moorea" => "Moorea" ,"Nairai" => "Nairai" ,"Nanumea-Atoll" => "Nanumea Atoll" ,"Nassau" => "Nassau" ,"Nauru" => "Nauru" ,"Naviti" => "Naviti" ,"Nepean" => "Nepean" ,"New-Britain" => "New Britain" ,"New-Caledonia" => "New Caledonia" ,"New-Georgia-Islands" => "New Georgia Islands" ,"New-Guinea" => "New Guinea" ,"New-Ireland" => "New Ireland" ,"Niuafo'ou" => "Niuafo'ou" ,"Niuas-Islands" => "Niuas Islands" ,"Niuatoputapu" => "Niuatoputapu" ,"Niue" => "Niue" ,"Niulakita-Atoll" => "Niulakita Atoll" ,"Nomuka-Island-Group" => "Nomuka Island Group" ,"Norfolk-Islands" => "Norfolk Islands" ,"Nukuaeta" => "Nukuaeta" ,"Nukufetau-Atoll" => "Nukufetau Atoll" ,"Nuku-Hiva" => "Nuku Hiva" ,"Nukulaelae-Atoll" => "Nukulaelae Atoll" ,"Nukunono-Atoll" => "Nukunono Atoll" ,"Ofu" => "Ofu" ,"Olasega" => "Olasega" ,"Ono" => "Ono" ,"Ouvea" => "Ouvea" ,"Ovalau" => "Ovalau" ,"Palmerston" => "Palmerston" ,"Pangai" => "Pangai" ,"Penrhyn" => "Penrhyn" ,"Philip" => "Philip" ,"Phoenix-Islands" => "Phoenix Islands" ,"Pitcairn" => "Pitcairn" ,"Pitt-Island" => "Pitt Island" ,"Polynesia" => "Polynesia" ,"Pukapuka" => "Pukapuka" ,"Rabi" => "Rabi" ,"Raiatea" => "Raiatea" ,"Rakahanga" => "Rakahanga" ,"Rangiroa" => "Rangiroa" ,"Rarotonga" => "Rarotonga" ,"Rotuma" => "Rotuma" ,"Samao" => "Samao" ,"San-Cristobal" => "San Cristobal" ,"Santa-Cruz-Islands" => "Santa Cruz Islands" ,"Santa-Isabel" => "Santa Isabel" ,"Savai-'i" => "Savai 'i" ,"Society-Islands" => "Society Islands" ,"Solomon-Islands" => "Solomon Islands" ,"Stewart" => "Stewart" ,"Suwarrow" => "Suwarrow" ,"Tabuaeran" => "Tabuaeran" ,"Tahaa" => "Tahaa" ,"Tahiti" => "Tahiti" ,"Tahuata" => "Tahuata" ,"Taiohae" => "Taiohae" ,"Tanna" => "Tanna" ,"Tarawa" => "Tarawa" ,"Tasmania" => "Tasmania" ,"Tau" => "Tau" ,"Taveuni" => "Taveuni" ,"Tetiaroa" => "Tetiaroa" ,"Tokelau" => "Tokelau" ,"Tonga" => "Tonga" ,"Tongatapu" => "Tongatapu" ,"Totoya" => "Totoya" ,"Tuamotu-Islands" => "Tuamotu Islands" ,"Tubuai" => "Tubuai" ,"Tupai" => "Tupai" ,"Tutuila" => "Tutuila" ,"Tuvalu" => "Tuvalu" ,"Ua-Huka" => "Ua Huka" ,"Ua-Pou" => "Ua Pou" ,"Upolu" => "Upolu" ,"'-Uta-Vava'u" => "' Uta Vava'u" ,"Uvea" => "Uvea" ,"Vaiaku" => "Vaiaku" ,"Vanua-Balavu" => "Vanua Balavu" ,"Vanua-Levu" => "Vanua Levu" ,"Vanuatu" => "Vanuatu" ,"Vatulele" => "Vatulele" ,"Vava'u-Island-Group" => "Vava'u Island Group" ,"Vita-Levu" => "Vita Levu" ,"Wallis-Islands" => "Wallis Islands" ,"Wallis-and-Futuna" => "Wallis and Futuna" ,"Waya" => "Waya" ,"Yasawa" => "Yasawa" ,"Yasawa-Group" => "Yasawa Group" );
break;
case 'Pacific-Ocean-North':
return array(8=>"Pacific Ocean North","Aleutian-Islands" => "Aleutian Islands" ,"Alexander-Islands" => "Alexander Islands" ,"Andreanof-Islands" => "Andreanof Islands" ,"Babelthuap" => "Babelthuap" ,"Baker" => "Baker" ,"Bikini" => "Bikini" ,"Bohol" => "Bohol" ,"Bonin-Islands" => "Bonin Islands" ,"Cabras" => "Cabras" ,"Caroline-Islands" => "Caroline Islands" ,"Cebu" => "Cebu" ,"Channel-Islands-(US)" => "Channel Islands (US)" ,"Cheju-Do" => "Cheju Do" ,"Chuuk" => "Chuuk" ,"Diomede-Islands" => "Diomede Islands" ,"Guam" => "Guam" ,"Hainan" => "Hainan" ,"Hawaii-(big-island)" => "Hawaii (big island)" ,"Hawaiian-Islands" => "Hawaiian Islands" ,"Hokkaido" => "Hokkaido" ,"Honshu" => "Honshu" ,"Howland" => "Howland" ,"Jaluit-Atoll" => "Jaluit Atoll" ,"Japan" => "Japan" ,"Johnston-Atoll" => "Johnston Atoll" ,"Kahoolawe" => "Kahoolawe" ,"Kauai" => "Kauai" ,"Kodiak" => "Kodiak" ,"Kosrae" => "Kosrae" ,"Kwajalein-Atoll" => "Kwajalein Atoll" ,"Kyushu" => "Kyushu" ,"Lanai" => "Lanai" ,"Lifou" => "Lifou" ,"Loyalty-Islands" => "Loyalty Islands" ,"Luzon" => "Luzon" ,"Maloelap-Atoll" => "Maloelap Atoll" ,"Majuro-Atoll" => "Majuro Atoll" ,"Mare" => "Mare" ,"Marshall-Islands" => "Marshall Islands" ,"Maui" => "Maui" ,"Micronesia" => "Micronesia" ,"Midway-Islands" => "Midway Islands" ,"Mili-Atoll" => "Mili Atoll" ,"Mindanao" => "Mindanao" ,"Mindoro" => "Mindoro" ,"Molakai" => "Molakai" ,"Niihau" => "Niihau" ,"Near-Islands" => "Near Islands" ,"Negros" => "Negros" ,"Northern-Marianas" => "Northern Marianas" ,"Nunivak" => "Nunivak" ,"Oahu" => "Oahu" ,"Okinawa" => "Okinawa" ,"Ostrov-Sakhalin" => "Ostrov Sakhalin" ,"Pagan" => "Pagan" ,"Palau" => "Palau" ,"Palawan" => "Palawan" ,"Palmyra-Atoll" => "Palmyra Atoll" ,"Panay" => "Panay" ,"Philippines" => "Philippines" ,"Pohnpei" => "Pohnpei" ,"Queen-Charlotte-Islands" => "Queen Charlotte Islands" ,"Rat" => "Rat" ,"Rongelap-Atoll" => "Rongelap Atoll" ,"St.-Lawrence" => "St. Lawrence" ,"St.-Matthew" => "St. Matthew" ,"St.-Paul" => "St. Paul" ,"Saipan" => "Saipan" ,"Samar" => "Samar" ,"San-Clemente" => "San Clemente" ,"San-Miguel" => "San Miguel" ,"San-Nicolas" => "San Nicolas" ,"Santa-Catalina" => "Santa Catalina" ,"Santa-Cruz" => "Santa Cruz" ,"Santa-Rosa" => "Santa Rosa" ,"Shikoku" => "Shikoku" ,"Taiwan" => "Taiwan" ,"Tinian" => "Tinian" ,"Vancouver" => "Vancouver" ,"Volcano-Islands" => "Volcano Islands" ,"Wake-Island" => "Wake Island" ,"Yap" => "Yap" );
break;
case 'Afghanistan':
return array(8=>"Afghanistan","Kabol" => "Kabol" ,"Kandahar" => "Kandahar" ,"Herat" => "Herat" ,"Nangarhar" => "Nangarhar" ,"Kondoz" => "Kondoz" ,"Baghlan" => "Baghlan" ,"Ghazni" => "Ghazni" ,"Paktia" => "Paktia" ,"Takhar" => "Takhar" ,"Khowst" => "Khowst" ,"Balkh" => "Balkh" ,"Jowzjan" => "Jowzjan" ,"Konar" => "Konar" ,"Nimruz" => "Nimruz" ,"Helmand" => "Helmand" ,"Farah" => "Farah" ,"Samangan" => "Samangan" ,"Oruzgan" => "Oruzgan" ,"Faryab" => "Faryab" ,"Sar-e Pol" => "Sar-e Pol" ,"Badakhshan" => "Badakhshan" ,"Lowgar" => "Lowgar" ,"Paktika" => "Paktika" ,"Laghman" => "Laghman" ,"Ghowr" => "Ghowr" ,"Bamian" => "Bamian" ,"Vardak" => "Vardak" ,"Kapisa" => "Kapisa" ,"Zabol" => "Zabol" ,"Nurestan" => "Nurestan" ,"Panjshir" => "Panjshir" ,"Parvan" => "Parvan" ,"Daykondi" => "Daykondi" ,"Badghis" => "Badghis" );
break;
case 'Armenia':
return array(8=>"Armenia","Yerevan" => "Yerevan" ,"Shirak" => "Shirak" ,"Lorri" => "Lorri" ,"Armavir" => "Armavir" ,"Kotayk" => "Kotayk" ,"Ararat" => "Ararat" ,"Geghark'unik" => "Geghark'unik" ,"Syunik" => "Syunik" ,"Aragatsotn" => "Aragatsotn" ,"Tavush" => "Tavush" ,"Vayots' Dzor" => "Vayots' Dzor" );
break;
case 'Azerbaijan':
return array(8=>"Azerbaijan","Baki" => "Baki" ,"Yevlax" => "Yevlax" ,"Xacmaz" => "Xacmaz" ,"Salyan" => "Salyan" ,"Agdam" => "Agdam" ,"Goycay" => "Goycay" ,"Imisli" => "Imisli" ,"Sabirabad" => "Sabirabad" ,"Tovuz" => "Tovuz" ,"Agdas" => "Agdas" ,"Naxcivan" => "Naxcivan" ,"Abseron" => "Abseron" ,"Quba" => "Quba" ,"Astara" => "Astara" ,"Qazax" => "Qazax" ,"Susa" => "Susa" ,"Neftcala" => "Neftcala" ,"Zaqatala" => "Zaqatala" ,"Bilasuvar" => "Bilasuvar" ,"Xanlar" => "Xanlar" ,"Qusar" => "Qusar" ,"Agsu" => "Agsu" ,"Ucar" => "Ucar" ,"Agstafa" => "Agstafa" ,"Qax" => "Qax" ,"Sumqayit" => "Sumqayit" ,"Goranboy" => "Goranboy" ,"Lerik" => "Lerik" ,"Naftalan" => "Naftalan" ,"Zangilan" => "Zangilan" ,"Samux" => "Samux" ,"Haciqabul" => "Haciqabul" ,"Fuzuli" => "Fuzuli" ,"Xocavand" => "Xocavand" ,"Lankaran" => "Lankaran" ,"Xizi" => "Xizi" ,"Balakan" => "Balakan" ,"Daskasan" => "Daskasan" ,"Ismayilli" => "Ismayilli" ,"Kalbacar" => "Kalbacar" ,"Qobustan" => "Qobustan" ,"Qubadli" => "Qubadli" ,"Qabala" => "Qabala" ,"Saatli" => "Saatli" ,"Oguz" => "Oguz" ,"Saki" => "Saki" ,"Mingacevir" => "Mingacevir" ,"Samaxi" => "Samaxi" ,"Samkir" => "Samkir" ,"Masalli" => "Masalli" ,"Siyazan" => "Siyazan" ,"Lacin" => "Lacin" ,"Kurdamir" => "Kurdamir" ,"Tartar" => "Tartar" ,"Ganca" => "Ganca" ,"Gadabay" => "Gadabay" ,"Davaci" => "Davaci" ,"Xankandi" => "Xankandi" ,"Calilabad" => "Calilabad" ,"Cabrayil" => "Cabrayil" ,"Xocali" => "Xocali" ,"Beylaqan" => "Beylaqan" ,"Yardimli" => "Yardimli" ,"Barda" => "Barda" ,"Ali Bayramli" => "Ali Bayramli" ,"Agcabadi" => "Agcabadi" ,"Zardab" => "Zardab" );
break;
case 'Bahrain':
return array(8=>"Bahrain","Al Manamah" => "Al Manamah" ,"Sitrah" => "Sitrah" ,"Al Mintaqah al Gharbiyah" => "Al Mintaqah al Gharbiyah" ,"Al Mintaqah al Wusta" => "Al Mintaqah al Wusta" ,"Al Mintaqah ash Shamaliyah" => "Al Mintaqah ash Shamaliyah" ,"Al Muharraq" => "Al Muharraq" ,"Al Asimah" => "Al Asimah" ,"Ash Shamaliyah" => "Ash Shamaliyah" ,"Jidd Hafs" => "Jidd Hafs" ,"Madinat" => "Madinat" ,"Madinat Hamad" => "Madinat Hamad" ,"Mintaqat Juzur Hawar" => "Mintaqat Juzur Hawar" ,"Ar Rifa" => "Ar Rifa" ,"Al Hadd" => "Al Hadd" );
break;
case 'Cyprus':
return array(8=>"Cyprus","Limassol" => "Limassol" ,"Larnaca" => "Larnaca" ,"Nicosia" => "Nicosia" ,"Famagusta" => "Famagusta" ,"Paphos" => "Paphos" ,"Kyrenia" => "Kyrenia" );
break;
case 'Iran':
return array(8=>"Iran","Tehran" => "Tehran" ,"Ardabil" => "Ardabil" ,"Azarbayjan-e-Gharbi" => "Azarbayjan-e Gharbi" ,"Azarbayjan-e-Sharqi" => "Azarbayjan-e Sharqi" ,"Bushehr" => "Bushehr" ,"Chahar-Mahall-va-Bakhtiari" => "Chahar Mahall va Bakhtiari" ,"Esfahan" => "Esfahan" ,"Fars" => "Fars" ,"Gilan" => "Gilan" ,"Golestan" => "Golestan" ,"Hamadan" => "Hamadan" ,"Hormozgan" => "Hormozgan" ,"Ilam" => "Ilam" ,"Kerman" => "Kerman" ,"Kermanshah" => "Kermanshah" ,"Khorasan" => "Khorasan" ,"Khuzestan" => "Khuzestan" ,"Kohkiluyeh-va-Buyer-Ahmad" => "Kohkiluyeh va Buyer Ahmad" ,"Kordestan" => "Kordestan" ,"Lorestan" => "Lorestan" ,"Markazi" => "Markazi" ,"Mazandaran" => "Mazandaran" ,"Qazvin" => "Qazvin" ,"Qom" => "Qom" ,"Semnan" => "Semnan" ,"Sistan-va-Baluchestan" => "Sistan va Baluchestan" ,"Yazd" => "Yazd" ,"Zanjan" => "Zanjan" );
break;
case 'Iraq':
return array(8=>"Iraq","Baghdad" => "Baghdad" ,"Arbil" => "Arbil" ,"At Ta'mim" => "At Ta'mim" ,"Diyala" => "Diyala" ,"Salah ad Din" => "Salah ad Din" ,"Ninawa" => "Ninawa" ,"Al Anbar" => "Al Anbar" ,"As Sulaymaniyah" => "As Sulaymaniyah" ,"Babil" => "Babil" ,"An Najaf" => "An Najaf" ,"Dahuk" => "Dahuk" ,"Dhi Qar" => "Dhi Qar" ,"Al Qadisiyah" => "Al Qadisiyah" ,"Karbala" => "Karbala" ,"Maysan" => "Maysan" ,"Al Muthanna" => "Al Muthanna" ,"Al Basrah" => "Al Basrah" ,"Wasit" => "Wasit" );
break;
case 'Israel':
return array(8=>"Israel","Tel Aviv" => "Tel Aviv" ,"HaMerkaz" => "HaMerkaz" ,"Yerushalayim" => "Yerushalayim" ,"HaDarom" => "HaDarom" ,"Hefa" => "Hefa" ,"HaZafon" => "HaZafon" );
break;
case 'Jordan':
return array(8=>"Jordan","Irbid" => "Irbid" ,"Amman Governorate" => "Amman Governorate" ,"Ma" => "Ma" ,"Al Balqa" => "Al Balqa" ,"At Tafilah" => "At Tafilah" ,"Al Mafraq" => "Al Mafraq" ,"Al Karak" => "Al Karak" ,"Amman" => "Amman" ,"Az Zarqa" => "Az Zarqa" );
break;
case 'Kuwait':
return array(8=>"Kuwait","Al Kuwayt" => "Al Kuwayt" ,"Al Jahra" => "Al Jahra" ,"Al Ahmadi" => "Al Ahmadi" ,"Al Farwaniyah" => "Al Farwaniyah" ,"Hawalli" => "Hawalli" ,"Mubarak al Kabir" => "Mubarak al Kabir" );
break;
case 'Kyrgyzstan':
return array(8=>"Kyrgyzstan","Ysyk-Kol" => "Ysyk-Kol" ,"Chuy" => "Chuy" ,"Osh" => "Osh" ,"Talas" => "Talas" ,"Bishkek" => "Bishkek" ,"Jalal-Abad" => "Jalal-Abad" ,"Naryn" => "Naryn" ,"Batken" => "Batken" );
break;
case 'Lebanon':
return array(8=>"Lebanon","Beyrouth" => "Beyrouth" ,"Al Janub" => "Al Janub" ,"Mont-Liban" => "Mont-Liban" ,"Beqaa" => "Beqaa" ,"Liban-Nord" => "Liban-Nord" ,"Liban-Sud" => "Liban-Sud" ,"Nabatiye" => "Nabatiye" );
break;
case 'macao':
return array(8=>"macao","Ilhas" => "Ilhas" ,"Macau" => "Macau" );
break;
case 'Oman':
return array(8=>"Oman","Masqat" => "Masqat" ,"Zufar" => "Zufar" ,"Ash Sharqiyah" => "Ash Sharqiyah" ,"Al Batinah" => "Al Batinah" ,"Az Zahirah" => "Az Zahirah" ,"Al Wusta" => "Al Wusta" ,"Ad Dakhiliyah" => "Ad Dakhiliyah" ,"Musandam" => "Musandam" );
break;
case 'Pakistan':
return array(8=>"Pakistan","Punjab" => "Punjab" ,"Sindh" => "Sindh" ,"North-West Frontier" => "North-West Frontier" ,"Balochistan" => "Balochistan" ,"Northern Areas" => "Northern Areas" ,"Federally Administered Tribal Areas" => "Federally Administered Tribal Areas" ,"Islamabad" => "Islamabad" );
break;
case 'Qatar':
return array(8=>"Qatar","Ad Dawhah" => "Ad Dawhah" ,"Al Khawr" => "Al Khawr" ,"Al Jumaliyah" => "Al Jumaliyah" ,"Ar Rayyan" => "Ar Rayyan" ,"Madinat ach Shamal" => "Madinat ach Shamal" ,"Umm Sa'id" => "Umm Sa'id" ,"Umm Salal" => "Umm Salal" ,"Al Wakrah" => "Al Wakrah" ,"Al Wakrah Municipality" => "Al Wakrah Municipality" );
break;
case 'Saudi-Arabia':
return array(8=>"Saudi Arabia","Makkah" => "Makkah" ,"Ar Riyad" => "Ar Riyad" ,"Al Jawf" => "Al Jawf" ,"Jizan" => "Jizan" ,"Al Qasim" => "Al Qasim" ,"Ash Sharqiyah" => "Ash Sharqiyah" ,"Tabuk" => "Tabuk" ,"Al Qurayyat" => "Al Qurayyat" ,"Ha'il" => "Ha'il" ,"Al Madinah" => "Al Madinah" ,"Al Hudud ash Shamaliyah" => "Al Hudud ash Shamaliyah" ,"Najran" => "Najran" ,"Al Bahah" => "Al Bahah" );
break;
case 'Syria':
return array(8=>"Syria","Halab" => "Halab" ,"Dimashq" => "Dimashq" ,"Tartus" => "Tartus" ,"Rif Dimashq" => "Rif Dimashq" ,"Hamah" => "Hamah" ,"Idlib" => "Idlib" ,"Dayr az Zawr" => "Dayr az Zawr" ,"Al Ladhiqiyah" => "Al Ladhiqiyah" ,"Dar" => "Dar" ,"Al Hasakah" => "Al Hasakah" ,"As Suwayda" => "As Suwayda" ,"Al Qunaytirah" => "Al Qunaytirah" ,"Hims" => "Hims" ,"Ar Raqqah" => "Ar Raqqah" );
break;
case 'Tajikistan':
return array(8=>"Tajikistan","Khatlon" => "Khatlon" ,"Sughd" => "Sughd" ,"Kuhistoni Badakhshon" => "Kuhistoni Badakhshon" );
break;
case 'Turkey':
return array(8=>"Turkey","Istanbul" => "Istanbul" ,"Ankara" => "Ankara" ,"Izmir" => "Izmir" ,"Bursa" => "Bursa" ,"Adana" => "Adana" ,"Gaziantep" => "Gaziantep" ,"Mersin" => "Mersin" ,"Antalya" => "Antalya" ,"Konya" => "Konya" ,"Sanliurfa" => "Sanliurfa" ,"Manisa" => "Manisa" ,"Kayseri" => "Kayseri" ,"Kocaeli" => "Kocaeli" ,"Hatay" => "Hatay" ,"Samsun" => "Samsun" ,"Erzurum" => "Erzurum" ,"Kahramanmaras" => "Kahramanmaras" ,"Malatya" => "Malatya" ,"Eskisehir" => "Eskisehir" ,"Van" => "Van" ,"Tekirdag" => "Tekirdag" ,"Bolu" => "Bolu" ,"Tokat" => "Tokat" ,"Trabzon" => "Trabzon" ,"Isparta" => "Isparta" ,"Ordu" => "Ordu" ,"Sivas" => "Sivas" ,"Denizli" => "Denizli" ,"Batman" => "Batman" ,"Corum" => "Corum" ,"Kutahya" => "Kutahya" ,"Agri" => "Agri" ,"Sirnak" => "Sirnak" ,"Afyonkarahisar" => "Afyonkarahisar" ,"Bitlis" => "Bitlis" ,"Mardin" => "Mardin" ,"Nevsehir" => "Nevsehir" ,"Kastamonu" => "Kastamonu" ,"Mugla" => "Mugla" ,"Diyarbakir" => "Diyarbakir" ,"Giresun" => "Giresun" ,"Yozgat" => "Yozgat" ,"Aydin" => "Aydin" ,"Edirne" => "Edirne" ,"Rize" => "Rize" ,"Amasya" => "Amasya" ,"Siirt" => "Siirt" ,"Canakkale" => "Canakkale" ,"Erzincan" => "Erzincan" ,"Usak" => "Usak" ,"Kirsehir" => "Kirsehir" ,"Hakkari" => "Hakkari" ,"Balikesir" => "Balikesir" ,"Nigde" => "Nigde" ,"Karaman" => "Karaman" ,"Bingol" => "Bingol" ,"Kirklareli" => "Kirklareli" ,"Bilecik" => "Bilecik" ,"Burdur" => "Burdur" ,"Kilis" => "Kilis" ,"Adiyaman" => "Adiyaman" ,"Yalova" => "Yalova" ,"Osmaniye" => "Osmaniye" ,"Sinop" => "Sinop" ,"Sakarya" => "Sakarya" ,"Tunceli" => "Tunceli" ,"Mus" => "Mus" ,"Artvin" => "Artvin" ,"Ardahan" => "Ardahan" ,"Zonguldak" => "Zonguldak" ,"Kars" => "Kars" ,"Karabuk" => "Karabuk" ,"Kirikkale" => "Kirikkale" ,"Aksaray" => "Aksaray" ,"Igdir" => "Igdir" ,"Bartin" => "Bartin" ,"Gumushane" => "Gumushane" ,"Bayburt" => "Bayburt" ,"Elazig" => "Elazig" ,"Duzce" => "Duzce" ,"Cankiri" => "Cankiri" );
break;
case 'Turkmenistan':
return array(8=>"Turkmenistan","Ahal" => "Ahal" ,"Lebap" => "Lebap" ,"Dashoguz" => "Dashoguz" ,"Balkan" => "Balkan" ,"Mary" => "Mary" );
break;
case 'United-Arab-Emirates':
return array(8=>"United Arab Emirates","Dubai" => "Dubai" ,"Abu Dhabi" => "Abu Dhabi" ,"Sharjah" => "Sharjah" ,"Umm Al Quwain" => "Umm Al Quwain" ,"Fujairah" => "Fujairah" ,"Ajman" => "Ajman" ,"Ras Al Khaimah" => "Ras Al Khaimah" );
break;
case 'Uzbekistan':
return array(8=>"Uzbekistan","Toshkent" => "Toshkent" ,"Namangan" => "Namangan" ,"Andijon" => "Andijon" ,"Samarqand" => "Samarqand" ,"Qoraqalpoghiston" => "Qoraqalpoghiston" ,"Surkhondaryo" => "Surkhondaryo" ,"Nawoiy" => "Nawoiy" ,"Qashqadaryo" => "Qashqadaryo" ,"Farghona" => "Farghona" ,"Bukhoro" => "Bukhoro" ,"Khorazm" => "Khorazm" ,"Sirdaryo" => "Sirdaryo" ,"Jizzakh" => "Jizzakh" );
break;
case 'Yemen':
return array(8=>"Yemen","Adan" => "Adan" ,"Ibb" => "Ibb" ,"Al Hudaydah" => "Al Hudaydah" ,"San'a'" => "San'a'" ,"Lahij" => "Lahij" ,"Al Mahwit" => "Al Mahwit" ,"Amran" => "Amran" ,"Dhamar" => "Dhamar" ,"Hadramawt" => "Hadramawt" ,"Hajjah" => "Hajjah" ,"Ma'rib" => "Ma'rib" ,"Sa'dah" => "Sa'dah" ,"Shabwah" => "Shabwah" ,"Abyan" => "Abyan" ,"Taizz" => "Taizz" ,"Ad Dali" => "Ad Dali" ,"Al Bayda" => "Al Bayda" ,"Al Jawf" => "Al Jawf" ,"Al Mahrah" => "Al Mahrah" );
break;
case 'Bermuda':
return array(8=>"Bermuda","Saint George" => "Saint George" ,"Hamilton" => "Hamilton" ,"Pembroke" => "Pembroke" ,"Saint George's" => "Saint George's" ,"Sandys" => "Sandys" ,"Smiths" => "Smiths" ,"Southampton" => "Southampton" ,"Devonshire" => "Devonshire" ,"Warwick" => "Warwick" ,"Paget" => "Paget" );
break;
case 'Canada':
return array(8=>"Canada","Ontario" => "Ontario" ,"Quebec" => "Quebec" ,"British Columbia" => "British Columbia" ,"Alberta" => "Alberta" ,"Manitoba" => "Manitoba" ,"Saskatchewan" => "Saskatchewan" ,"Nova Scotia" => "Nova Scotia" ,"New Brunswick" => "New Brunswick" ,"Newfoundland and Labrador" => "Newfoundland and Labrador" ,"Prince Edward Island" => "Prince Edward Island" ,"Northwest Territories" => "Northwest Territories" ,"Yukon" => "Yukon" ,"Nunavut" => "Nunavut" ,"Minnesota" => "Minnesota" ,"Michigan" => "Michigan" );
break;
case 'cayman-islands':
return array(8=>"cayman islands","Creek" => "Creek" ,"Eastern" => "Eastern" ,"Midland" => "Midland" ,"Spot Bay" => "Spot Bay" ,"Stake Bay" => "Stake Bay" ,"West End" => "West End" );
break;
case 'Greenland':
return array(8=>"Greenland","Vestgronland" => "Vestgronland" ,"Ostgronland" => "Ostgronland" ,"Nordgronland" => "Nordgronland" );
break;
case 'Mexico':
return array(8=>"Mexico","Mexico" => "Mexico" ,"Distrito Federal" => "Distrito Federal" ,"Jalisco" => "Jalisco" ,"Nuevo Leon" => "Nuevo Leon" ,"Veracruz-Llave" => "Veracruz-Llave" ,"Puebla" => "Puebla" ,"Guanajuato" => "Guanajuato" ,"Baja California" => "Baja California" ,"Michoacan de Ocampo" => "Michoacan de Ocampo" ,"Coahuila de Zaragoza" => "Coahuila de Zaragoza" ,"Tamaulipas" => "Tamaulipas" ,"Sonora" => "Sonora" ,"Sinaloa" => "Sinaloa" ,"Guerrero" => "Guerrero" ,"Chiapas" => "Chiapas" ,"Yucatan" => "Yucatan" ,"Oaxaca" => "Oaxaca" ,"Morelos" => "Morelos" ,"Chihuahua" => "Chihuahua" ,"San Luis Potosi" => "San Luis Potosi" ,"Hidalgo" => "Hidalgo" ,"Durango" => "Durango" ,"Queretaro de Arteaga" => "Queretaro de Arteaga" ,"Quintana Roo" => "Quintana Roo" ,"Tabasco" => "Tabasco" ,"Aguascalientes" => "Aguascalientes" ,"Zacatecas" => "Zacatecas" ,"Tlaxcala" => "Tlaxcala" ,"Campeche" => "Campeche" ,"Colima" => "Colima" ,"Nayarit" => "Nayarit" ,"Baja California Sur" => "Baja California Sur" );
break;
case 'Brazil':
return array(8=>"Brazil","Sao Paulo" => "Sao Paulo" ,"Rio de Janeiro" => "Rio de Janeiro" ,"Minas Gerais" => "Minas Gerais" ,"Bahia" => "Bahia" ,"Rio Grande do Sul" => "Rio Grande do Sul" ,"Parana" => "Parana" ,"Pernambuco" => "Pernambuco" ,"Ceara" => "Ceara" ,"Santa Catarina" => "Santa Catarina" ,"Para" => "Para" ,"Goias" => "Goias" ,"Maranhao" => "Maranhao" ,"Espirito Santo" => "Espirito Santo" ,"Amazonas" => "Amazonas" ,"Distrito Federal" => "Distrito Federal" ,"Paraiba" => "Paraiba" ,"Alagoas" => "Alagoas" ,"Rio Grande do Norte" => "Rio Grande do Norte" ,"Mato Grosso do Sul" => "Mato Grosso do Sul" ,"Piaui" => "Piaui" ,"Mato Grosso" => "Mato Grosso" ,"Sergipe" => "Sergipe" ,"Rondonia" => "Rondonia" ,"Tocantins" => "Tocantins" ,"Acre" => "Acre" ,"Amapa" => "Amapa" ,"Roraima" => "Roraima" );
break;
case 'United-States':
return array(8=>"United States",8=>"United States","California" => "California" ,"Texas" => "Texas" ,"New York" => "New York" ,"Florida" => "Florida" ,"Illinois" => "Illinois" ,"Ohio" => "Ohio" ,"Pennsylvania" => "Pennsylvania" ,"Massachusetts" => "Massachusetts" ,"New Jersey" => "New Jersey" ,"Arizona" => "Arizona" ,"Michigan" => "Michigan" ,"Washington" => "Washington" ,"North Carolina" => "North Carolina" ,"Virginia" => "Virginia" ,"Maryland" => "Maryland" ,"Georgia" => "Georgia" ,"Minnesota" => "Minnesota" ,"Indiana" => "Indiana" ,"Colorado" => "Colorado" ,"Missouri" => "Missouri" ,"Wisconsin" => "Wisconsin" ,"Tennessee" => "Tennessee" ,"Alabama" => "Alabama" ,"Oregon" => "Oregon" ,"Connecticut" => "Connecticut" ,"Oklahoma" => "Oklahoma" ,"Louisiana" => "Louisiana" ,"Utah" => "Utah" ,"Nevada" => "Nevada" ,"Kentucky" => "Kentucky" ,"Iowa" => "Iowa" ,"Kansas" => "Kansas" ,"South Carolina" => "South Carolina" ,"Arkansas" => "Arkansas" ,"Mississippi" => "Mississippi" ,"New Mexico" => "New Mexico" ,"Nebraska" => "Nebraska" ,"New Hampshire" => "New Hampshire" ,"Maine" => "Maine" ,"Rhode Island" => "Rhode Island" ,"Hawaii" => "Hawaii" ,"Idaho" => "Idaho" ,"West Virginia" => "West Virginia" ,"Montana" => "Montana" ,"Alaska" => "Alaska" ,"District of Columbia" => "District of Columbia" ,"South Dakota" => "South Dakota" ,"North Dakota" => "North Dakota" ,"Wyoming" => "Wyoming" ,"Delaware" => "Delaware" ,"Vermont" => "Vermont" );
break;
case 'us-virgin-islands':
return array(8=>"us virgin islands","St. Thomas" => "St. Thomas" ,"St. Croix" => "St. Croix" ,"St. John" => "St. John" );
break;
case 'Argentina':
return array(8=>"Argentina","Buenos Aires" => "Buenos Aires" ,"Santa Fe" => "Santa Fe" ,"Cordoba" => "Cordoba" ,"Mendoza" => "Mendoza" ,"Tucuman" => "Tucuman" ,"Salta" => "Salta" ,"Entre Rios" => "Entre Rios" ,"Corrientes" => "Corrientes" ,"Chaco" => "Chaco" ,"San Juan" => "San Juan" ,"Misiones" => "Misiones" ,"Santiago del Estero" => "Santiago del Estero" ,"Jujuy" => "Jujuy" ,"Neuquen" => "Neuquen" ,"San Luis" => "San Luis" ,"Rio Negro" => "Rio Negro" ,"Formosa" => "Formosa" ,"Chubut" => "Chubut" ,"Catamarca" => "Catamarca" ,"La Rioja" => "La Rioja" ,"La Pampa" => "La Pampa" ,"Distrito Federal" => "Distrito Federal" ,"Santa Cruz" => "Santa Cruz" ,"Tierra del Fuego" => "Tierra del Fuego" );
break;
case 'Bolivia':
return array(8=>"Bolivia","Cochabamba" => "Cochabamba" ,"La Paz" => "La Paz" ,"Santa Cruz" => "Santa Cruz" ,"Tarija" => "Tarija" ,"Potosi" => "Potosi" ,"Chuquisaca" => "Chuquisaca" ,"Oruro" => "Oruro" ,"El Beni" => "El Beni" ,"Pando" => "Pando" );
break;
case 'Chile':
return array(8=>"Chile","Region Metropolitana" => "Region Metropolitana" ,"Bio-Bio" => "Bio-Bio" ,"Valparaiso" => "Valparaiso" ,"Los Lagos" => "Los Lagos" ,"Maule" => "Maule" ,"Antofagasta" => "Antofagasta" ,"Araucania" => "Araucania" ,"Coquimbo" => "Coquimbo" ,"Tarapaca" => "Tarapaca" ,"Libertador General Bernardo O'Higgins" => "Libertador General Bernardo O'Higgins" ,"Atacama" => "Atacama" ,"Magallanes y de la Antartica Chilena" => "Magallanes y de la Antartica Chilena" ,"Aisen del General Carlos Ibanez del Campo" => "Aisen del General Carlos Ibanez del Campo" ,"Los Rios" => "Los Rios" ,"Arica y Parinacota" => "Arica y Parinacota" );
break;
case 'Colombia':
return array(8=>"Colombia","Cundinamarca" => "Cundinamarca" ,"Antioquia" => "Antioquia" ,"Valle del Cauca" => "Valle del Cauca" ,"Atlantico" => "Atlantico" ,"Bolivar Department" => "Bolivar Department" ,"Santander" => "Santander" ,"Norte de Santander" => "Norte de Santander" ,"Magdalena Department" => "Magdalena Department" ,"Tolima" => "Tolima" ,"Narino" => "Narino" ,"Risaralda" => "Risaralda" ,"Caldas Department" => "Caldas Department" ,"Boyaca Department" => "Boyaca Department" ,"Cesar" => "Cesar" ,"Cordoba" => "Cordoba" ,"Huila" => "Huila" ,"Sucre" => "Sucre" ,"Quindio" => "Quindio" ,"Meta" => "Meta" ,"La Guajira" => "La Guajira" ,"Cauca" => "Cauca" ,"Caqueta" => "Caqueta" ,"Choco" => "Choco" ,"Casanare" => "Casanare" ,"Arauca" => "Arauca" ,"Putumayo" => "Putumayo" ,"San Andres y Providencia" => "San Andres y Providencia" ,"Guaviare" => "Guaviare" ,"Amazonas" => "Amazonas" ,"Guainia" => "Guainia" ,"Vaupes" => "Vaupes" ,"Vichada" => "Vichada" ,"Caldas" => "Caldas" ,"Magdalena" => "Magdalena" ,"Bolivar" => "Bolivar" ,"Boyaca" => "Boyaca" ,"Distrito Especial" => "Distrito Especial" );
break;
case 'Ecuador':
return array(8=>"Ecuador","Guayas" => "Guayas" ,"Pichincha" => "Pichincha" ,"Manabi" => "Manabi" ,"El Oro" => "El Oro" ,"Los Rios" => "Los Rios" ,"Azuay" => "Azuay" ,"Loja" => "Loja" ,"Tungurahua" => "Tungurahua" ,"Esmeraldas" => "Esmeraldas" ,"Imbabura" => "Imbabura" ,"Chimborazo" => "Chimborazo" ,"Cotopaxi" => "Cotopaxi" ,"Canar" => "Canar" ,"Morona-Santiago" => "Morona-Santiago" ,"Bolivar" => "Bolivar" ,"Zamora-Chinchipe" => "Zamora-Chinchipe" ,"Pastaza" => "Pastaza" ,"Napo" => "Napo" ,"Sucumbios" => "Sucumbios" ,"Galapagos" => "Galapagos" ,"Carchi" => "Carchi" ,"Orellana" => "Orellana" );
break;
case 'Guyana':
return array(8=>"Guyana","Demerara-Mahaica" => "Demerara-Mahaica" ,"Upper Demerara-Berbice" => "Upper Demerara-Berbice" ,"East Berbice-Corentyne" => "East Berbice-Corentyne" ,"Cuyuni-Mazaruni" => "Cuyuni-Mazaruni" ,"Mahaica-Berbice" => "Mahaica-Berbice" ,"Essequibo Islands-West Demerara" => "Essequibo Islands-West Demerara" ,"Barima-Waini" => "Barima-Waini" ,"Upper Takutu-Upper Essequibo" => "Upper Takutu-Upper Essequibo" ,"Potaro-Siparuni" => "Potaro-Siparuni" ,"Pomeroon-Supenaam" => "Pomeroon-Supenaam" );
break;
case 'Paraguay':
return array(8=>"Paraguay","Alto Parana" => "Alto Parana" ,"Alto Paraguay" => "Alto Paraguay" );
break;
case 'Peru':
return array(8=>"Peru","Lima" => "Lima" ,"La Libertad" => "La Libertad" ,"Piura" => "Piura" ,"Arequipa" => "Arequipa" ,"Lambayeque" => "Lambayeque" ,"Junin" => "Junin" ,"Ica" => "Ica" ,"Loreto" => "Loreto" ,"Ancash" => "Ancash" ,"Puno" => "Puno" ,"Cusco" => "Cusco" ,"Ucayali" => "Ucayali" ,"Tacna" => "Tacna" ,"Cajamarca" => "Cajamarca" ,"San Martin" => "San Martin" ,"Huanuco" => "Huanuco" ,"Ayacucho" => "Ayacucho" ,"Pasco" => "Pasco" ,"Tumbes" => "Tumbes" ,"Moquegua" => "Moquegua" ,"Apurimac" => "Apurimac" ,"Madre de Dios" => "Madre de Dios" ,"Amazonas" => "Amazonas" ,"Huancavelica" => "Huancavelica" ,"Callao" => "Callao" );
break;
case 'Suriname':
return array(8=>"Suriname","Paramaribo" => "Paramaribo" ,"Wanica" => "Wanica" ,"Nickerie" => "Nickerie" ,"Commewijne" => "Commewijne" ,"Marowijne" => "Marowijne" ,"Saramacca" => "Saramacca" ,"Brokopondo" => "Brokopondo" ,"Para" => "Para" ,"Coronie" => "Coronie" ,"Sipaliwini" => "Sipaliwini" );
break;
case 'Uruguay':
return array(8=>"Uruguay","Montevideo" => "Montevideo" ,"Canelones" => "Canelones" ,"Salto" => "Salto" ,"Maldonado" => "Maldonado" ,"Paysandu" => "Paysandu" ,"Cerro Largo" => "Cerro Largo" ,"Rivera" => "Rivera" ,"Colonia" => "Colonia" ,"Artigas" => "Artigas" ,"Soriano" => "Soriano" ,"San Jose" => "San Jose" ,"Tacuarembo" => "Tacuarembo" ,"Durazno" => "Durazno" ,"Rio Negro" => "Rio Negro" ,"Lavalleja" => "Lavalleja" ,"Rocha" => "Rocha" ,"Florida" => "Florida" ,"Treinta y Tres" => "Treinta y Tres" ,"Flores" => "Flores" );
break;
case 'Venezuela':
return array(8=>"Venezuela","Zulia" => "Zulia" ,"Miranda" => "Miranda" ,"Carabobo" => "Carabobo" ,"Distrito Federal" => "Distrito Federal" ,"Aragua" => "Aragua" ,"Lara" => "Lara" ,"Bolivar" => "Bolivar" ,"Anzoategui" => "Anzoategui" ,"Tachira" => "Tachira" ,"Monagas" => "Monagas" ,"Falcon" => "Falcon" ,"Sucre" => "Sucre" ,"Portuguesa" => "Portuguesa" ,"Barinas" => "Barinas" ,"Guarico" => "Guarico" ,"Yaracuy" => "Yaracuy" ,"Vargas" => "Vargas" ,"Merida" => "Merida" ,"Cojedes" => "Cojedes" ,"Trujillo" => "Trujillo" ,"Nueva Esparta" => "Nueva Esparta" ,"Amazonas" => "Amazonas" ,"Delta Amacuro" => "Delta Amacuro" ,"Apure" => "Apure" ,"Dependencias Federales" => "Dependencias Federales" );
break;
default:
return array("Select"=>"Select");
break;
}
}
}
if(!function_exists('imic_get_currency')){
function imic_get_currency() {
	return array_unique(
		apply_filters( '',
			array(
				'AED' => __( 'United Arab Emirates Dirham', 'woocommerce' ),
				'AUD' => __( 'Australian Dollars', 'woocommerce' ),
				'BDT' => __( 'Bangladeshi Taka', 'woocommerce' ),
				'BRL' => __( 'Brazilian Real', 'woocommerce' ),
				'BGN' => __( 'Bulgarian Lev', 'woocommerce' ),
				'CAD' => __( 'Canadian Dollars', 'woocommerce' ),
				'CLP' => __( 'Chilean Peso', 'woocommerce' ),
				'CNY' => __( 'Chinese Yuan', 'woocommerce' ),
				'COP' => __( 'Colombian Peso', 'woocommerce' ),
				'CZK' => __( 'Czech Koruna', 'woocommerce' ),
				'DKK' => __( 'Danish Krone', 'woocommerce' ),
				'EUR' => __( 'Euros', 'woocommerce' ),
				'HKD' => __( 'Hong Kong Dollar', 'woocommerce' ),
				'HRK' => __( 'Croatia kuna', 'woocommerce' ),
				'HUF' => __( 'Hungarian Forint', 'woocommerce' ),
				'ISK' => __( 'Icelandic krona', 'woocommerce' ),
				'IDR' => __( 'Indonesia Rupiah', 'woocommerce' ),
				'INR' => __( 'Indian Rupee', 'woocommerce' ),
				'ILS' => __( 'Israeli Shekel', 'woocommerce' ),
				'JMD' => __( 'Jamaica Dollar', 'woocommerce' ),
				'JPY' => __( 'Japanese Yen', 'woocommerce' ),
				'KRW' => __( 'South Korean Won', 'woocommerce' ),
				'MYR' => __( 'Malaysian Ringgits', 'woocommerce' ),
				'MXN' => __( 'Mexican Peso', 'woocommerce' ),
				'NGN' => __( 'Nigerian Naira', 'woocommerce' ),
				'NOK' => __( 'Norwegian Krone', 'woocommerce' ),
				'NZD' => __( 'New Zealand Dollar', 'woocommerce' ),
				'PHP' => __( 'Philippine Pesos', 'woocommerce' ),
				'PLN' => __( 'Polish Zloty', 'woocommerce' ),
				'PKR' => __( 'Pakistan Rupee', 'woocommerce' ),
				'GBP' => __( 'Pounds Sterling', 'woocommerce' ),
				'RON' => __( 'Romanian Leu', 'woocommerce' ),
				'RUB' => __( 'Russian Ruble', 'woocommerce' ),
				'SGD' => __( 'Singapore Dollar', 'woocommerce' ),
				'ZAR' => __( 'South African rand', 'woocommerce' ),
				'SEK' => __( 'Swedish Krona', 'woocommerce' ),
				'CHF' => __( 'Swiss Franc', 'woocommerce' ),
				'TWD' => __( 'Taiwan New Dollars', 'woocommerce' ),
				'THB' => __( 'Thai Baht', 'woocommerce' ),
				'TRY' => __( 'Turkish Lira', 'woocommerce' ),
				'USD' => __( 'US Dollars', 'woocommerce' ),
				'VND' => __( 'Vietnamese Dong', 'woocommerce' ),
			)
		)
	);
}
}
/**
 * Get Currency symbol.
 * @param string $currency (default: '')
 * @return string
 */
if(!function_exists('imic_get_currency_symbol')){
function imic_get_currency_symbol( $currency = '' ) {
	if ( ! $currency ) {
		$currency = imic_get_currency();
	}
	switch ( $currency ) {
		case 'AED' :
			$currency_symbol = 'AED';
			break;
		case 'BDT':
			$currency_symbol = '&#2547;&nbsp;';
			break;
		case 'BRL' :
			$currency_symbol = '&#82;&#36;';
			break;
		case 'BGN' :
			$currency_symbol = '&#1083;&#1074;.';
			break;
		case 'AUD' :
		case 'CAD' :
		case 'CLP' :
		case 'MXN' :
		case 'NZD' :
		case 'HKD' :
		case 'SGD' :
                case 'COP' :
		case 'USD' :
			$currency_symbol = '&#36;';
			break;
		case 'EUR' :
			$currency_symbol = '&euro;';
			break;
		case 'CNY' :
		case 'RMB' :
		case 'JPY' :
			$currency_symbol = '&yen;';
			break;
		case 'RUB' :
			$currency_symbol = '&#1088;&#1091;&#1073;.';
			break;
		case 'KRW' : $currency_symbol = '&#8361;'; break;
		case 'TRY' : $currency_symbol = '&#84;&#76;'; break;
		case 'NOK' : $currency_symbol = '&#107;&#114;'; break;
		case 'ZAR' : $currency_symbol = '&#82;'; break;
		case 'CZK' : $currency_symbol = '&#75;&#269;'; break;
		case 'MYR' : $currency_symbol = '&#82;&#77;'; break;
		case 'DKK' : $currency_symbol = 'kr.'; break;
		case 'HUF' : $currency_symbol = '&#70;&#116;'; break;
		case 'IDR' : $currency_symbol = 'Rp'; break;
		case 'INR' : $currency_symbol = '&#x20B9;'; break;
		case 'ISK' : $currency_symbol = 'Kr.'; break;
		case 'ILS' : $currency_symbol = '&#8362;'; break;
		case 'JMD' : $currency_symbol = '&#74;&#36;'; break;
		case 'PHP' : $currency_symbol = '&#8369;'; break;
		case 'PLN' : $currency_symbol = '&#122;&#322;'; break;
		case 'PKR' : $currency_symbol = '&#8360;'; break;
		case 'SEK' : $currency_symbol = '&#107;&#114;'; break;
		case 'CHF' : $currency_symbol = '&#67;&#72;&#70;'; break;
		case 'TWD' : $currency_symbol = '&#78;&#84;&#36;'; break;
		case 'THB' : $currency_symbol = '&#3647;'; break;
		case 'GBP' : $currency_symbol = '&pound;'; break;
		case 'RON' : $currency_symbol = 'lei'; break;
		case 'VND' : $currency_symbol = '&#8363;'; break;
		case 'NGN' : $currency_symbol = '&#8358;'; break;
		case 'HRK' : $currency_symbol = 'Kn'; break;
		default    : $currency_symbol = ''; break;
	}
	return $currency_symbol;
}
}
/*AGENT FIELDS
  ===========================================================*/
if(!function_exists('imic_agent_fields')) {
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
?>
<h3><?php _e('Agent Social','framework'); ?></h3>
<table class="form-table">
<tr>
<th>
<label for="Agent Facebook Url"><?php _e('Agent Facebook Url','framework'); ?></label>
</th>
<td>
<label><input type="text" name="fb-link" value ="<?php echo $userFB; ?>" </label>
</td>
</tr>
<tr>
<th>
<label for="Agent Twitter Url"><?php _e('Agent Twitter Url','framework'); ?></label>
</th>
<td>
<label><input type="text" name="twt-link" value ="<?php echo $userTWT; ?>" </label>
</td>
</tr>
<tr>
<th>
<label for="Agent Google Plus Url"><?php _e('Agent Google Plus Url','framework'); ?></label>
</th>
<td>
<label><input type="text" name="gp-link" value ="<?php echo $userGP; ?>" </label>
</td>
</tr>
<tr>
<th>
<label for="Agent Msg Link Url"><?php _e('Agent Msg Link Url','framework'); ?></label>
</th>
<td>
<label><input type="text" name="msg-link" value ="<?php echo $userMSG; ?>" </label>
</td>
</tr>
<tr>
<th>
<label for="Agent linkedin Link Url"><?php _e('Linkedin Url','framework'); ?></label>
</th>
<td>
<label><input type="text" name="linkedin-link" value ="<?php echo $userLINKEDIN; ?>" </label>
</td>
</tr>
</table>
<h3><?php _e('Agent Contact Details','framework'); ?></h3>
<table class="form-table">
<tr>
<th>
<label for="Agent Mobile Number"><?php _e('Agent Mobile Number','framework'); ?></label>
</th>
<td>
<label><input type="text" name="mobile-phone" value ="<?php echo $userMobileNo; ?>" </label>
</td>
</tr>
<tr>
<th>
<label for="Agent Work Phone"><?php _e('Agent Work Phone','framework'); ?></label>
</th>
<td>
<label><input type="text" name="work-phone" value ="<?php echo $userWorkNo; ?>" </label>
</td>
</tr>
</table>
<h3><?php _e('Agent Plan Details','framework'); ?></h3>
<table class="form-table">
<tr>
<th>
<label for="property_number"><?php _e('Number of Property','framework'); ?></label>
</th>
<td>
<label><input type="text" name="agent_number_of_plan" readonly value ="<?php echo $userPropertyValue; ?>" </label>
</td>
</tr>
</table>
<h3><?php _e('Agent Image','framework'); ?></h3>
<table class="form-table">
<tr>
<th>
<label for="Agent Image"><?php _e('Agent Image','framework'); ?></label>
</th>
<td><?php
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
                   <p class="description"><?php _e('Upload an image for the agent .', 'framework'); ?></p>
<input type="hidden" id="agent_url" name="agent-image" value="<?php echo esc_url($agent_image); ?>" /></td>
</tr>
</table>
<h3><?php _e('Agent banner Image','framework'); ?></h3>
<table class="form-table">
<tr>
<th>
<label for="Agent Banner"><?php _e('Agent banner image','framework'); ?></label>
</th>
<td><?php
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
                   <p class="description"><?php _e('Upload an image for the agent page banner.', 'framework'); ?></p>
<input type="hidden" id="agent_banner" name="agent-banner" value="<?php echo esc_url($agent_banner); ?>" /></td>
</tr>
</table>
<h3><?php _e('Popular Agent','framework'); ?></h3>
    <table class="form-table">
        <tr>
            <th>
                <label for="Popular Agent"><?php _e('Popular Agent','framework'); ?>
            </label></th>
            <td><span class="description"><?php _e('Check this box to create agent popular.','framework'); ?></span><br>
            <label><input type="checkbox" name="popular" <?php if ($value == 'Popular' ) { ?>checked="checked"<?php }?> value="Popular"><?php _e('Popular Agent','framework'); ?><br /></label>
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
}
add_action( 'show_user_profile', 'imic_agent_fields');
add_action( 'edit_user_profile', 'imic_agent_fields');
add_action( 'personal_options_update', 'imic_save_agent_field' );
add_action( 'edit_user_profile_update', 'imic_save_agent_field' );
}
/*GET USER BY META FIELD
  ============================================================*/
if(!function_exists('get_user_by_meta_data')) {
function get_user_by_meta_data( $meta_key, $meta_value ) {
	$user_query = new WP_User_Query(
		array(
			'meta_key'	  =>	$meta_key,
			'meta_value'	=>	$meta_value
		)
	);
	$users = $user_query->get_results();
	return $user = empty ( $users[0] ) ? null : $users[0];
} // end get_user_by_meta_data
}
/*AJAX LOGIN FORM FUNCTION
  ================================================================*/
if(!function_exists('ajax_login_init')) {
function ajax_login_init(){
    wp_register_script('ajax-login-script', get_template_directory_uri() . '/js/ajax-login-script.js', array('jquery') ); 
    wp_enqueue_script('ajax-login-script');
    wp_localize_script( 'ajax-login-script', 'ajax_login_object', array( 
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
        'loadingmessage' => __('Sending user info, please wait...','framework')
    ));
    add_action( 'wp_ajax_nopriv_ajaxlogin', 'ajax_login' );
}
if (!is_user_logged_in()) {
    add_action('init', 'ajax_login_init');
} }
if(!function_exists('ajax_login')) {
function ajax_login(){
    check_ajax_referer( 'ajax-login-nonce', 'security' );
    $info = array();
    $info['user_login'] = $_POST['username'];
    $info['user_password'] = $_POST['password'];
	if($_POST['rememberme']=='true') {
    $info['remember'] = true; }
	else{
	$info['remember'] = false; }
    $user_signon = wp_signon( $info, false );
    if ( is_wp_error($user_signon) ){
        echo json_encode(array('loggedin'=>false, 'message'=>__('Wrong username or password.','framework')));
    } else {
        echo json_encode(array('loggedin'=>true, 'message'=>__('Login successful, redirecting...','framework')));
    }
    die();
} }
/* Display Agent User Description Excerpt
============================================*/
if(!function_exists('imic_agent_excerpt')){
 function imic_agent_excerpt ($agentID, $limit = 30){ 
        $agentExcerpt = wp_trim_words(strip_tags(get_the_author_meta('description', $agentID)), $limit, '...');
		echo $agentExcerpt;         
 }
}
/* Add new Agent User Role
=================================*/
if(!function_exists('imic_add_agent_role')) {
function imic_add_agent_role() {
remove_role('agent');
add_role('agent', 'Agent', array('read' => true));
}
add_action("after_switch_theme", "imic_add_agent_role", 10 ,  2);  
}
/* Restrict Dashboard Access
   ======================================*/
if(!function_exists('')) {
function imic_restrict_admin_access()
{
 if (!current_user_can( 'administrator' )&&! current_user_can( 'editor' )&&! ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
wp_redirect( home_url() );
exit;
}
 
}
//add_action( 'admin_init', 'imic_restrict_admin_access', 1 );
}
//Hide Admin Bar for Agents
if( ! current_user_can( 'administrator' ) ) {
        add_filter( 'show_admin_bar', '__return_false' );
    }
// get taxonomies terms links
if (!function_exists('imic_custom_taxonomies_terms_links')) {
    function imic_custom_taxonomies_terms_links() {
        global $post;
        // get post by post id
        $post = get_post($post->ID);
        // get post type by post
        $post_type = $post->post_type;
        // get post type taxonomies
        $taxonomies = get_object_taxonomies($post_type, 'objects');
        $out = array();
        foreach ($taxonomies as $taxonomy_slug => $taxonomy) {
            // get the terms related to post
            $terms = get_the_terms($post->ID, $taxonomy_slug);
            if (!empty($terms)) {
                $i = 1;
                foreach ($terms as $term) {
                    if ($i == 1) {
                        $out[] =
                                ' <a href="'
                                . get_term_link($term->slug, $taxonomy_slug) . '">'
                                . $term->name
                                . "</a>";
                    }
                    $i++;
                }
            }
        }
        return implode('', $out);
    }
}
if(!function_exists('getLongitudeLatitudeByAddress')){
function getLongitudeLatitudeByAddress($Address){
    $latitude=$longitude='';
 $Address = urlencode($Address);
  $request_url = "http://maps.googleapis.com/maps/api/geocode/xml?address=".$Address."&sensor=true";
  $xml = simplexml_load_file($request_url) or die("url not loading");
  $status = $xml->status;
  if ($status=="OK") {
      $latitude = $xml->result->geometry->location->lat;
      $longitude = $xml->result->geometry->location->lng;
}
return array($latitude,$longitude);
  }
}
//Return Post Count by Custom Post Type
if(!function_exists('imic_count_user_posts_by_type')){
function imic_count_user_posts_by_type( $userid, $post_type = 'post' ) {
	global $wpdb;
	$where = get_posts_by_author_sql( $post_type, true, $userid );
	$count = $wpdb->get_var( "SELECT COUNT(*) FROM $wpdb->posts $where" );
  	return apply_filters( 'get_usernumposts', $count, $userid );
}}
if(!function_exists('imic_blacklist_body_class')){
function imic_blacklist_body_class($wp_classes, $extra_classes) {
if(is_singular('property')) :
// List of the classes to remove from the WP generated classes
$blacklist = array('single-property');
// Filter the body classes
  foreach( $blacklist as $val ) {
    if (!in_array($val, $wp_classes)) : continue;
    else:
      foreach($wp_classes as $key => $value) {
      if ($value == $val) unset($wp_classes[$key]);
      }
    endif;
  }
endif;   // Add the extra classes back untouched
return array_merge($wp_classes, (array) $extra_classes);
}
add_filter('body_class', 'imic_blacklist_body_class', 20, 2);
}
/* Search Filter for property
      ================================= */   
if(!function_exists('imic_search_filter')){
    function imic_search_filter($query) {
   global $imic_options;
        if($query->is_search()) {
            $propery_contract_type=$propery_type=$propery_location=$beds=$baths=$min_price=$max_price=$min_area=$max_area='';
            $propery_contract_type = isset($_GET['propery_contract_type'])?$_GET['propery_contract_type']:"";
            $propery_contract_type= ($propery_contract_type == __('Contract', 'framework')) ? '' :$propery_contract_type;
            $propery_type = isset($_GET['propery_type'])?$_GET['propery_type']:'';
            $propery_type= ($propery_type == __('Property Type', 'framework')) ? '' :$propery_type;
            $propery_location = isset($_GET['propery_location'])?$_GET['propery_location']:'';
            $propery_location = ($propery_location == __('State', 'framework')) ? '' : $propery_location;
            $propery_city = isset($_GET['property_city'])?$_GET['property_city']:'';
            $propery_city = ($propery_city == __('City', 'framework')) ? '' :$propery_city;
            $beds = isset($_GET['beds'])?$_GET['beds']:'';
            $beds = ($beds == __('Any', 'framework')) ? '' : $beds;
            $baths = isset($_GET['baths'])?$_GET['baths']:'';
            $baths = ($baths == __('Any', 'framework')) ? '' : $baths;
            $min_price = isset($_GET['min_price'])?$_GET['min_price']:'';
            $min_price = ($min_price == __('Any', 'framework')) ? '' :$min_price;
            $max_price = isset($_GET['max_price'])?$_GET['max_price']:'';
            $max_price = ($max_price == __('Any', 'framework')) ? '' :$max_price;
            $min_area = isset($_GET['min_area'])?$_GET['min_area']:'';
            $min_area = ($min_area == __('Any', 'framework')) ? '' :$min_area;
            $max_area = isset($_GET['max_area'])?$_GET['max_area']:'';
            $max_area = ($max_area == __('Any', 'framework')) ? '' :$max_area;
           $id = isset($_GET['id'])?$_GET['id']:'';
            $pincode = isset($_GET['pincode'])?$_GET['pincode']:'';
            $address = isset($_GET['address'])?$_GET['address']:'';
            // If the default text is in the box
            if (!empty($propery_contract_type)||!empty($propery_type)|| !empty($propery_location) || !empty($baths) ||!empty($beds)||(!empty($min_price)||!empty($max_price))||(!empty($min_area)||!empty($max_area))||!empty($id)||!empty($pincode)||!empty($address)||!empty($propery_city)) {
                 $s = $_GET['s'];
                 $meta_query=array();
            if ($s == __('Search1', 'framework')) {
                $query->set('s', '');
            }
              $query->set('post_type', 'property');
              $query->set('post_status','publish');
              if (!empty($propery_type)) {
               $query->set('property-type', $propery_type);
                }
                if (!empty($propery_city)) {
               $query->set('city-type',$propery_city);
                }
              if (!empty($propery_contract_type)) {
                 $query->set('property-contract-type', $propery_contract_type);
                }
             if (!empty($baths)) {
                     array_push($meta_query, array(
                            'key' => 'imic_property_baths',
                            'value' => $baths,
                             'type' => 'numeric',
                            'compare' => '>='
                        ));
                }
                if (!empty($beds)) { 
                    array_push($meta_query,array(
                            'key' => 'imic_property_beds',
                            'value' => $beds,
                            'type' => 'numeric',
                            'compare' => '>='
                        ));
                }
            if(!empty($min_price)&&!empty($max_price)){
             array_push($meta_query,array(
	     'key' =>'imic_property_price',
             'value'=>array($min_price,$max_price),
             'type' =>'numeric',
	     'compare'=> 'BETWEEN'
            ));
            }
            else{
               if(!empty($min_price)){
             array_push($meta_query,array(
	     'key' =>'imic_property_price',
             'value'=>$min_price,
             'type' =>'numeric',
	     'compare'=> '>='
            ));
            }
            if(!empty($max_price)){
             array_push($meta_query,array(
	     'key' =>'imic_property_price',
             'value'=>$max_price,
             'type' =>'numeric',
	     'compare'=> '<='
            ));
            }
            }if(!empty($min_area)&&!empty($max_area)){
              array_push($meta_query,array(
	     'key' => 'imic_property_area',
             'value' => array($min_area,$max_area),
             'type' => 'numeric',
	     'compare' => 'BETWEEN'
            ));
            }
            else{
                if(!empty($min_area)){
                array_push($meta_query,array(
	     'key' => 'imic_property_area',
             'value' => $min_area,
             'type' => 'numeric',
	     'compare' => '>='
            ));
            }
            if(!empty($max_area)){
                array_push($meta_query,array(
	     'key' => 'imic_property_area',
             'value' => $max_area,
             'type' => 'numeric',
	     'compare' => '<='
            ));
            }
            }
             if (!empty($propery_location)) {
                 array_push($meta_query,array(
                'key' => 'imic_property_site_city',
                'value' => $propery_location
            ));
            }
            if (!empty($id)) {
              array_push($meta_query,array(
                'key' => 'imic_property_site_id',
                'value' => $id,
                 'compare'=>'LIKE'
            ));
             }
             if (!empty($pincode)) {
                array_push($meta_query,array(
                'key' => 'imic_property_pincode',
                'value' => $pincode
            ));
            }
              if (!empty($address)) {
                array_push($meta_query,array(
                'key' => 'imic_property_site_address',
                'value' => $address,
                'compare' => 'LIKE',
            ));
            }
            $query->set('meta_query',$meta_query);
            }else {
               $s = $_GET['s'];
                 if ($s == __('Search1', 'framework')) {
                      $query->set('s', '');
                $query->set('post_type', 'property');
            }else{
             $query->set('post_type', 'post');    
            } }
            
            }
          return $query;
    }
# Add Filters
if(!is_admin()) {
   add_filter('pre_get_posts', 'imic_search_filter'); }
       }
	   
function add_property_id($post_id) {
    global $wpdb;
    global $imic_options;
	$property_id = 1648+$post_id;
         if(isset($imic_options['property_id_wording'])&&!empty($imic_options['property_id_wording'])){
              $property_id_wording=$imic_options['property_id_wording']; 
            }
            else{
                $property_id_wording=__('rs-','framework');
            }
    update_post_meta($post_id, 'imic_property_site_id',$property_id_wording.$property_id); }
add_action('save_post', 'add_property_id');
/* Add capabilities to clients
      ================================= */   
function imicAddCapToRole() {
global $current_user;
global $wp_roles;
$user_roles = $current_user->roles;
$user_role = array_shift($user_roles);
$wp_roles->add_cap($user_role,'read_private_posts');   
}
add_action( 'init', 'imicAddCapToRole');
/* Property Detail By Id
      ================================= */   
if(!function_exists('imicPropertyDetailById')):
function imicPropertyDetailById($id){
$property_pin = get_post_meta($id,'imic_property_pincode',true);
$property_address = get_post_meta($id,'imic_property_site_address',true);
$city_type = wp_get_object_terms($id, 'city-type', array('fields'=>'ids')); 
$property_city='';
	if(!empty($city_type)) {
	$city_term = get_term( $city_type[0], 'city-type');
        $property_city = $city_term->name;
}
$property_id =imicPropertyId($id);
if(!empty($property_id)){
 echo '<strong>'.__('Property ID','framework').':</strong> '.get_post_meta($id,'imic_property_site_id',true).'<br/>';   
}
if(!empty($property_address)){
echo '<strong>'.__('Property Address','framework').':</strong> '.$property_address;
}
if($property_pin!='') { echo '<br/><strong>'.__('Pin Code ','framework').':</strong> '.$property_pin; }
if($property_city!='') { echo '<br/><strong>'.__('Property City ','framework').':</strong> '.$property_city; }
}
endif;
/* 
 * Get Multiple City by selected country
 */
if(!function_exists('imic_get_multiple_city')):
function imic_get_multiple_city(){
global $imic_options;
$custom_array = array();
$country_array_temp=array();
$country_array=array();
$custom = 0;
if(isset($imic_options['country-select'])&&(!empty($imic_options['country-select'])&&!is_string($imic_options['country-select']))){
foreach($imic_options['country-select'] as $key=>$value){
	if($value=="tocustom") { $custom++; break; }
$country_array_temp[]=imic_country_wise_city($value);
}
foreach($country_array_temp as $data){
$country_array=array_merge($data,$country_array);
}}
if($custom>0) 
{ //echo "saibaba";
	$states = $imic_options['custom_province'];
	if($states!='')
	{
		$provinces = explode(',', $states);
		foreach($provinces as $provine)
		{
			$custom_array[$provine]=$provine;
		}
	}
	return $custom_array;
}
else
{
	return $country_array;
}
}
endif;
/* 
 * Get Singe Property Banner
 */
if (!function_exists('imic_singe_property_banner')) {
function imic_singe_property_banner($pageID) {
    $bannerHTML = '';
     /* Title/Banner Meta Box Details
======================================*/
$property_images = get_post_meta($pageID,'imic_property_sights',false);
   $property_banner_type = get_post_meta($pageID,'imic_property_banner_type',true);
if(!empty($property_banner_type)){
    switch ($property_banner_type) {
        case 'featured_image':
            if(has_post_thumbnail($pageID)){
             $src =wp_get_attachment_image_src(get_post_thumbnail_id($pageID),'600-400-size');
            }
if(!empty($src)){
$bannerHTML .= '<!-- Site Showcase -->
<div class="site-showcase">
<!-- Start Page Header -->
<div class="parallax page-header" style="background-image:url('. $src[0] .');">
<div class="container">
<div class="row">
<div class="col-md-12">
<h1>'.get_the_title($pageID).'</h1>
</div>
</div>
</div>
</div>
<!-- End Page Header -->
</div>';
}
        break;
        case 'map':
            $bannerHTML .= '<!-- Site Showcase -->
<div class="site-showcase"> 
<!-- Start Page Header -->
<div class="clearfix map-single-page" id="onemap"></div>                                                       
<!-- End Page Header --> 
</div>';
             break;
        default:
          global $imic_options;
             if(isset($imic_options['banner_image'])&&!empty($imic_options['banner_image'])){
                 $banner_imagesrc =$imic_options['banner_image']['url'];
            $bannerHTML .= '<!-- Site Showcase -->
<div class="site-showcase">
<!-- Start Page Header -->
<div class="parallax page-header" style="background-image:url('. $banner_imagesrc .');">
<div class="container">
<div class="row">
<div class="col-md-12">
<h1>'.get_the_title($pageID).'</h1>
</div>
</div>
</div>
</div>
<!-- End Page Header -->
</div>';
                 }
            break;
            }
}else{
$property_banner_src='';
foreach ($property_images as $property_images){
$largeImage = wp_get_attachment_image_src($property_images,'full');
if(($largeImage[1]>=1200)&&($largeImage[2]>=500)){
$property_banner_src =$largeImage[0];
break;
}}
if(!empty($property_banner_src)){
$bannerHTML .= '<!-- Site Showcase -->
<div class="site-showcase">
<!-- Start Page Header -->
<div class="parallax page-header" style="background-image:url('. $property_banner_src .');">
<div class="container">
<div class="row">
<div class="col-md-12">
<h1>'.get_the_title($pageID).'</h1>
</div>
</div>
</div>
</div>
<!-- End Page Header -->
</div>';
}else{
$bannerHTML .= '<!-- Site Showcase -->
<div class="site-showcase"> 
<!-- Start Page Header -->
<div class="clearfix map-single-page" id="onemap"></div>                                                       
<!-- End Page Header --> 
</div>';
}    
}
echo $bannerHTML;
}
}
/* -------------------------------------------------------------------------------------
  RevSlider ShortCode
  @since Real Space 1.3
  ----------------------------------------------------------------------------------- */
if(!function_exists('imicRevSliderShortCode')){
function imicRevSliderShortCode(){
     $slidernames = array();
    if(class_exists('RevSlider')){
     $sld = new RevSlider();
                $sliders = $sld->getArrSliders();
        if(!empty($sliders)){
           
        foreach($sliders as $slider){
          $title=$slider->getParam('title','false');
           $shortcode=$slider->getParam('shortcode','false');
            $slidernames[$shortcode]=$title;
        }}
           
}
return $slidernames;
        }}
/* -------------------------------------------------------------------------------------
  Show Hide Property Id
  @since Real Space 1.3
  ----------------------------------------------------------------------------------- */
if(!function_exists('imicPropertyId')){
function imicPropertyId($id){
    global $imic_options;
    $property_id = get_post_meta($id,'imic_property_site_id',true);
     if(isset($imic_options['enable_property_id'])&&$imic_options['enable_property_id']==1){        
    return '<span class="pid"> ('.$property_id.')</span></h4>'; 
    }
}}
/* -------------------------------------------------------------------------------------
  Change Property Agent by  Quick Edit Option
  @since Real Space 1.3
  ----------------------------------------------------------------------------------- */
if(!function_exists('imicQuickEditProperty')){
add_filter('wp_dropdown_users', 'imicQuickEditProperty');
function imicQuickEditProperty($output)
{ global $post;
//global $post is available here, hence you can check for the post type here
$user_query = get_users( array( 'role' => 'subscriber' ) );
// This gets the array of ids of the subscribers
$subscribers_id = wp_list_pluck( $user_query, 'ID' );
// Now use the exclude parameter to exclude the subscribers
$users = get_users( array( 'exclude' => $subscribers_id ) );
$output = "<select id=\"post_author_override\" name=\"post_author_override\" class=\"\">";
foreach($users as $user)
{ 
$sel = ($post->post_author == $user->ID)?"selected='selected'":'';
$output .= '<option value="'.$user->ID.'"'.$sel.'>'.$user->user_login.'</option>';
}
$output .= "</select>";
return $output;
}} 
/** -------------------------------------------------------------------------------------
 * Blog Template Redirect
 @since Real Space 1.3
 ----------------------------------------------------------------------------------- */
if(!function_exists('imicBlogTemplateRedirect')){
function imicBlogTemplateRedirect()
{   
$page_for_posts= get_option('page_for_posts');  
//check by Blog
if(is_home()&&!empty($page_for_posts)){
$page_for_posts= get_option('page_for_posts');
$page_template= get_post_meta(get_option('page_for_posts'),'_wp_page_template',true);
if($page_template!='default'){
include (TEMPLATEPATH . '/'.$page_template);
exit;
}}
 }
// add our function to template_redirect hook
add_action('template_redirect', 'imicBlogTemplateRedirect');
}
function update_property_featured_image() {
	$property_id = $_POST['property_id'];
	$thumb_id = $_POST['thumb_id'];
	update_post_meta($property_id,'_thumbnail_id',$thumb_id);
	echo "success";
	die();
}
add_action('wp_ajax_nopriv_update_property_featured_image', 'update_property_featured_image');
add_action('wp_ajax_update_property_featured_image', 'update_property_featured_image');
/* Add to subcity dropdown in submit property
================================================*/
function property_sub_cities() {
	$city_slug = $_POST['city_slug'];
        $city_type_value = $_POST['city_type_value'];
	$select_id = $_POST['select_id'];
	$city_id = get_term_by('slug', $city_slug, 'city-type');
        if(!empty($city_id)){
        if($select_id=='subcity'){
            $var_parenr_child_arg ='child_of';
            $last_select_value='last_select';
        }else{
         $var_parenr_child_arg ='parent'; 
          $last_select_value='';
        }
	$args = array('orderby' => 'count', 'hide_empty' => false,$var_parenr_child_arg=>$city_id->term_id);
    $terms=get_terms(array('city-type'), $args);
 
    if(count($terms)>0){
     $subcities_html = '<div class="sub_child_show col-md-4 col-sm-4"><select name="textonomies_city[]" data-city-type-value="'. $city_type_value .'" data-last-select_value="'. $last_select_value .'"  data-id="subcity" class="textonomies_subcity form-control margin-0 selectpicker"><option value="">' . __('Sub City', 'framework') . '</option>';
    foreach ($terms as $term_data) {
    	$subcities_html .="<option value='" .$term_data->slug. "' ".selected($city_type_value,$term_data->slug,false).">" . $term_data->name . "</option>";
    }
    $subcities_html .='</select></div>';
	echo $subcities_html;
	die();
}}}
add_action('wp_ajax_nopriv_property_sub_cities', 'property_sub_cities');
add_action('wp_ajax_property_sub_cities', 'property_sub_cities');
function property_sub_cities_at_start(){
     $subcities_html='';
     $last_select_value="last_select";
    if(isset($_POST['othertextonomies_meta'])&&!empty($_POST['othertextonomies_meta'])){
    $othertextonomies_meta = $_POST['othertextonomies_meta'];
    $subcities_html.='<div class="col-md-4 col-sm-4"><input type="text" name="othertextonomies" value ="'.$othertextonomies_meta.'"  class ="form-control othertextonomies margin-0" placeholder="Enter city name"></div>';
    }
    if(isset($_POST['sub_sub_category_id'])&&!empty($_POST['sub_sub_category_id'])){
  
        $sub_sub_category_id = $_POST['sub_sub_category_id'];
   $city_current_id = get_term_by('term_id',$sub_sub_category_id, 'city-type');
   $second_parent  = get_term_by('term_id',$sub_sub_category_id, 'city-type');
   $sub_sub_parent_id =$city_current_id->parent;
   $data = get_term_top_most_parent($sub_sub_category_id,'city-type');
   $parent_category_id=$data->term_id;
   while ($second_parent->parent != $parent_category_id){
        $second_parent  = get_term_by( 'id', $second_parent->parent,'city-type');
        $sub_sub_parent_id =$second_parent->term_id;
    }
   if($parent_category_id!=$sub_sub_parent_id){
         $var_parenr_child_arg ='child_of';
          $last_select_value='last_select';
        }else{
        $var_parenr_child_arg ='parent';
         $last_select_value='';
       }
  if(!empty($parent_category_id)&&!empty($sub_sub_parent_id)&&($parent_category_id!=$sub_sub_parent_id)){
  $args = array('orderby' => 'count', 'hide_empty' => false,'parent'=>$parent_category_id);
    $terms=get_terms(array('city-type'), $args);
    if(count($terms)>0){
        $city_type_value='';
     $subcities_html = '<div class="sub_child_show col-md-4 col-sm-4"><select name="textonomies_city[]" data-city-type-value="'. $city_type_value .'" data-last-select_value="'.$last_select_value.'"  data-id="subcity" class="textonomies_subcity form-control margin-0 selectpicker"><option value="">' . __('Sub City', 'framework') . '</option>';
    foreach ($terms as $term_data) {
      $subcities_html .="<option value='" .$term_data->slug. "' ".selected($sub_sub_parent_id,$term_data->term_id,false).">" . $term_data->name . "</option>";
    }
    $subcities_html .='</select></div>';
}
}
if(!empty($sub_sub_parent_id)){
    $args_sub = array('orderby' => 'count', 'hide_empty' => false,$var_parenr_child_arg=>$sub_sub_parent_id);
    $terms=get_terms(array('city-type'), $args_sub);
    if(count($terms)>0){
        $city_type_value='';
       $subcities_html .= '<div class="sub_child_show col-md-4 col-sm-4"><select name="textonomies_city[]" data-city-type-value="'. $city_type_value .'" data-last-select_value="'. $last_select_value .'"  data-id="subcity" class="textonomies_subcity form-control margin-0 selectpicker"><option value="">' . __('Sub City', 'framework') . '</option>';
    foreach ($terms as $term_data) {
       $subcities_html .="<option value='" .$term_data->slug. "' ".selected($sub_sub_category_id,$term_data->term_id,false).">" . $term_data->name . "</option>";
    }
    $subcities_html .='</select></div>';
}
}
}
echo $subcities_html;
die();
    }
add_action('wp_ajax_nopriv_property_sub_cities_at_start', 'property_sub_cities_at_start');
add_action('wp_ajax_property_sub_cities_at_start', 'property_sub_cities_at_start');
function get_term_top_most_parent($term_id, $taxonomy){
$parent  = get_term_by( 'id', $term_id, $taxonomy);
    while ($parent->parent != 0){
        $parent  = get_term_by( 'id', $parent->parent,$taxonomy);
    }
    return $parent;
}
 /**
 * IMIC SHARE BUTTONS
 */
if(!function_exists('imic_share_buttons')){
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
                	echo '<li class="share-title"><i class="fa fa-share-alt fa-2x"></i></li>';
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
}
//Remove Property Image using ajax
if(!function_exists('imic_remove_property_image')) {
	function imic_remove_property_image() {
		$thumb = $_POST['thumb_id'];
		$property = $_POST['property_id'];
		delete_post_meta($property,'imic_property_sights',$thumb);
		die();
	}
add_action('wp_ajax_nopriv_imic_remove_property_image', 'imic_remove_property_image');
add_action('wp_ajax_imic_remove_property_image', 'imic_remove_property_image');
}
/* On Property Draft to Publish
======================================*/
if (!function_exists('imic_on_draft_to_publish_property')) {
	function imic_on_draft_to_publish_property( $post ) {
		if (!defined("PHP_EOL")) define("PHP_EOL", "\r\n");
		if($post->post_type=='property'){
			$email = get_option('admin_email');
			$address = get_the_author_meta('user_email',$post->post_author);
			$e_subject = $post->post_title . __(' property goes live.','framework');
			
			global $imic_options;
			if(!empty($imic_options['publish_property_email'])){	
				$property_link = '<a href ="'.get_the_permalink($post->ID).'">'.get_the_permalink($post->ID).'</a>';
				$fav_shortcode = array('[title]','[url]');
				$fav_output = array($post->post_title,$property_link);
				$e_body = str_replace($fav_shortcode,$fav_output,$imic_options['publish_property_email']);
			}else{
			$e_body=__("Now property ",'framework').$post->post_title.__(' goes live on website. Click here to see property details ','framework').' <a href ="'.get_the_permalink($post->ID).'">'.get_the_permalink($post->ID).'</a>';
			}			
			$msg = wordwrap( $e_body, 70 );
			$headers = "From: $email" . PHP_EOL;
			$headers .= "Reply-To: $email" . PHP_EOL;
			$headers .= "MIME-Version: 1.0" . PHP_EOL;
			$headers.="Content-Type: text/html; charset=\"iso-8859-1\"\n";
			mail($address, $e_subject, $msg, $headers);					
		}
	}
}
add_action('draft_to_publish','imic_on_draft_to_publish_property',10,3);
if(!function_exists('imic_get_src_image_id')) {
function imic_get_src_image_id($image) {
	global $wpdb;
	$attachment_id = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $image )); 
        return $attachment_id[0]; 
}
}
?>