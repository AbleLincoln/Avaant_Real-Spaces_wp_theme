<!DOCTYPE HTML>
<html <?php language_attributes(); ?> class="no-js">

<head>
  <?php global $imic_options; 
$bodyClass = ($imic_options['site_layout'] == 'boxed') ? ' boxed' : '';
        $style='';
       if($imic_options['site_layout'] == 'boxed'){
            if (!empty($imic_options['upload-repeatable-bg-image']['id'])) {
            $style = ' style="background-image:url(' . $imic_options['upload-repeatable-bg-image']['url'] . '); background-repeat:repeat; background-size:auto;"';
        } else if (!empty($imic_options['full-screen-bg-image']['id'])) {
            $style = ' style="background-image:url(' . $imic_options['full-screen-bg-image']['url'] . '); background-repeat: no-repeat; background-size:cover;"';
        }
           else if(!empty($imic_options['repeatable-bg-image'])) {
            $style = ' style="background-image:url(' . get_template_directory_uri() . '/images/patterns/' . $imic_options['repeatable-bg-image'] . '); background-repeat:repeat; background-size:auto;"';
        }
        } ?>
    <!-- Basic Page Needs
  ================================================== -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>
      <?php wp_title('|', true, 'right'); bloginfo('name'); ?>
    </title>
    <meta charset="<?php bloginfo('charset'); ?>" />
    <?php $responsive = $imic_options['switch-responsive']; if($responsive==1) { ?>
      <!-- Mobile Specific Metas
  ================================================== -->
      <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">
      <meta name="format-detection" content="telephone=no">
      <?php } 
if (isset($imic_options['custom_favicon']) && $imic_options['custom_favicon'] != "") { ?>
        <link rel="shortcut icon" href="<?php echo $imic_options['custom_favicon']['url']; ?>" />
        <?php } ?>
          <!-- CSS
  ================================================== -->
          <!--[if lte IE 8]><link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/ie8.css" media="screen" /><![endif]-->
          <!-- Color Style -->
          <!-- SCRIPTS
  ================================================== -->
        <?php wp_head(); //WORDPRESS HEAD HOOK ?>
</head>
<?php 
global $imic_options;
$header_style='';
if(isset($imic_options['header_background_color'])&&!empty($imic_options['header_background_color'])){
$header_style='style="background-color: '.$imic_options['header_background_color'].'"';
}if(is_page_template('template-home.php')||is_page_template('template-home-second.php')){
  $home_class = 'home';
}else{
    $home_class='';
} ?>

  <body <?php body_class($home_class. ' '.$bodyClass); echo $style; ?>>
    <!--[if lt IE 7]>
	<p class="chromeframe">You are using an outdated browser. <a href="http://browsehappy.com/">Upgrade your browser today</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to better experience this site.</p>
<![endif]-->
    <div class="body">
      <!-- Start Site Header -->
      <header class="site-header" <?php echo $header_style; ?>>
        <?php 
      $menu_locations =get_nav_menu_locations();
      ?>
          <div class="top-header hidden-xs avaant-hidden">
            <div class="container">
              <div class="row">
                
                <div class="col-md-8 col-sm-6">
                  <ul class="horiz-nav pull-right">
                    <?php
				/* Display Top Bar Social Links
				=======================================*/
				$socialSites = $imic_options['top_social_links'];
				if(!empty($socialSites)) {
				foreach($socialSites as $key => $value) {
					if(filter_var($value, FILTER_VALIDATE_URL)){ 
						echo '<li><a href="'. $value .'" target="_blank"><i class="fa '. $key .'"></i></a></li>';
					}
				} }
				?>
                  </ul>

                </div>
              </div>
            </div>
          </div>

          <div class="middle-header">
            <div class="container">
              <div class="row">
                <div class="col-md-4 col-sm-8 col-xs-8">
                  <h1 class="logo"> 
            	<?php
				/* Display Site Logo
				==========================*/
				echo '<a href="' . esc_url( home_url() ) . '" title="' . get_bloginfo('name') . '">';
				echo (!empty($imic_options['logo_upload']['url'])) ? '<img src="' . $imic_options['logo_upload']['url'] . '" alt="Logo">' : '<img src="' . get_template_directory_uri() . '/images/logo.png" alt="Logo">';
				echo '</a>';
				?>
            </h1>
                </div>
                <div class="col-md-8 col-sm-4 col-xs-4">
                  <div class="contact-info-blocks hidden-sm hidden-xs">
                    <?php
				/* Display Header Content Info Block
				===========================================*/ 
				if ($imic_options['header_free_line_icon'] != '') {
					$hinfo1icon = $imic_options['header_free_line_icon'];
				}
				if ($imic_options['header_email_us_icon'] != '') {
					$hinfo2icon = $imic_options['header_email_us_icon'];
				}
				if ($imic_options['header_working_hours_icon'] != '') {
					$hinfo3icon = $imic_options['header_working_hours_icon'];
				}
				
				if ($imic_options['header_free_line_title'] != '') {
					$hinfo1title = $imic_options['header_free_line_title'];
				}
				if ($imic_options['header_email_us_title'] != '') {
					$hinfo2title = $imic_options['header_email_us_title'];
				}
				if ($imic_options['header_working_hours_title'] != '') {
					$hinfo3title = $imic_options['header_working_hours_title'];
				}
				
				if ($imic_options['header_free_line'] != '') {
					echo '<div>
							<i class="fa fa-'.$hinfo1icon.'"></i> '.$hinfo1title.'
							<span>'.$imic_options['header_free_line'].'</span>
						  </div>';
				}
				if ($imic_options['header_email_us'] != '') {
					echo '<div>
							<i class="fa fa-'.$hinfo2icon.'"></i> '.$hinfo2title.'
							<span>'.$imic_options['header_email_us'].'</span>
						  </div>';
				}
				if ($imic_options['header_working_hours'] != '') {
					echo '<div>
							<i class="fa fa-'.$hinfo3icon.'"></i> '.$hinfo3title.'
							<span>'.$imic_options['header_working_hours'].'</span>
						  </div>';	
				}
				?>
                  </div>
                  <a href="#" class="visible-sm visible-xs menu-toggle"><i class="fa fa-bars"></i></a>
                </div>
              </div>
            </div>
          </div>
          <?php  ?>
            <div class="main-menu-wrapper">
              <div class="container">
                <div class="row">
                  <div class="col-md-4">
                    <nav class="navigation">
                      <h1 class="avnt-logo">
                        <a href="http://avaant.co" title="Avaant">
                          <img src="http://avaant.co/wp-content/uploads/2015/09/Screen-Shot-2015-09-01-at-3.00.08-PM.png" alt="Logo">
                        </a>
                      </h1>
                      <?php if(!empty($menu_locations['primary-menu'])){
			  /* Display Header Primary Menu
			  ===========================================*/
			  wp_nav_menu(array('theme_location' => 'primary-menu', 'menu_class' => 'sf-menu', 'container' => '')); ?>
                        <?php } else { echo '<ul class="sf-menu sf-js-enabled">'; wp_list_pages('number=8&title_li='); echo '</ul>'; } ?>
                      
                <div class="col-md-8 col-sm-6 avaant-hidden">
                  <ul class="horiz-nav pull-right">
                    <?php
				/* Display Top Bar Social Links
				=======================================*/
				$socialSites = $imic_options['top_social_links'];
				if(!empty($socialSites)) {
				foreach($socialSites as $key => $value) {
					if(filter_var($value, FILTER_VALIDATE_URL)){ 
						echo '<li><a href="'. $value .'" target="_blank"><i class="fa '. $key .'"></i></a></li>';
					}
				} }
				?>
                  </ul>
                      </div>  
                    </nav>
                  </div>
                  
                    <!-- Site Search Module -->
  <?php   $output = '';
  global $imic_options;
  $search_home_blocks = $imic_options['search-home-blocks']['Enabled'];
  if (count($search_home_blocks)>1):
    foreach ($search_home_blocks as $key => $value) {
      switch ($key) {
        case 'property_type':
          $output .= '<span>I want to work for a </span>';
          $args_terms = array('orderby' => 'count', 'hide_empty' => true);
          $propertyterms = get_terms('property-type', $args_terms);
          if (!empty($propertyterms)) {
            $output.= '<div class="search-field"><label class="avnt-hidden">'.__('Property Type', 'framework').'</label><select name="propery_type" class="form-control selectpicker">';
            $output .='<option>' . __(' ', 'framework') . '</option>';
            foreach ($propertyterms as $term) {
              $term_name = $term->name;
              $term_slug = $term->slug;
              $output .="<option value='" . $term_slug . "'>" . $term_name . "</option>";
            }
            $output .="</select></div>";
            $output .= "<span> startup.</span>";
          }
          break;
                case 'contract': $args_contract = array('orderby' => 'count', 'hide_empty' => true);
                        $property_contract_type_terms = get_terms('property-contract-type', $args_contract);
                        if (!empty($property_contract_type_terms)) {
                            $output.= '<div class="search-field"><label>'.__('Contract Type', 'framework').'</label><select name="propery_contract_type" class="form-control selectpicker">';
                            $output .='<option selected>' . __('Contract', 'framework') . '</option>';
                            foreach ($property_contract_type_terms as $term) {
                                $term_name = $term->name;
                                $term_slug = $term->slug;
                                $output .="<option value='" . $term_slug . "'>" . $term_name . "</option>";
                            }
                            $output .="</select></div>";
                           
                        }
                break;
                case 'location': $imic_country_wise_city = imic_get_multiple_city();
                        if (!empty($imic_country_wise_city)) {
                            $output .='<div class="search-field"><label>'.__('State', 'framework').'</label><select name="propery_location" class="form-control selectpicker">
                          <option selected>' . __('State', 'framework') . '</option>';
                            foreach ($imic_country_wise_city as $key => $value) {
								if(is_int($key)) { $output .= '<optgroup label="'.$value.'">'; }
								else {
                                $output .="<option value='" . $key . "'>" . $value . "</option>"; }
                            }
                            $output .='</select></div>';
                        }
                break;
                case 'baths':
                         $output .= '<div class="search-field"><label>' . __('Min Baths', 'framework') . '</label>
                              <select name="baths" class="form-control selectpicker">';
                         $output .='<option selected>' . __('Any', 'framework') . '</option>';
                            $baths_options = $imic_options['properties_baths'];
    						foreach ($baths_options as $baths) {
                                $output .= "<option value='" . $baths . "'>" . $baths . "</option>";
                            }
                         $output .='</select></div>';
                break;
                case 'city':
                        $args_c = array('orderby' => 'count', 'hide_empty' => true);
                        $terms = get_terms(array('city-type'), $args_c);
                        if (!empty($terms)) {
                            $output .= '<div class="search-field"><label>'.__('City', 'framework').'</label><select name="property_city" class="form-control selectpicker">
                    <option selected>' . __('City', 'framework') . '</option>';
                            foreach ($terms as $term_data) {
                                $output .= "<option value='" . $term_data->slug . "'>" . $term_data->name . "</option>";
                            }
                            $output .='</select></div>';
                        }
                break;
                case 'beds':
                        $output .= '<div class="search-field"><label>' . __('Min Beds', 'framework') . '</label>
                                <select name="beds" class="form-control selectpicker">';
                        $output .='<option selected>' . __('Any', 'framework') . '</option>';
                        $beds_options = $imic_options['properties_beds'];
    					foreach ($beds_options as $beds) {
                            $output .= "<option value='" . $beds . "'>" . $beds . "</option>";
                        }
                        $output .='</select></div>';
                break;
                case 'price':
                        $output .= '<div class="search-field"><label>' . __('Min Price', 'framework') . '</label>
                                <select name="min_price" class="form-control selectpicker">';
                        $output .='<option selected>' . __('Any', 'framework') . '</option>';
                        $m_price_value = $imic_options['properties_price_range'];
                        foreach ($m_price_value as $price_value) {
                            $output .= "<option value='" . $price_value . "'>" . $currency_symbol . " " . $price_value . "</option>";
                        }
                        $output .='</select></div>';
                        $output .= '<div class="search-field">
                            <label>' . __('Max Price', 'framework') . '</label>
                            <select name="max_price" class="form-control selectpicker">';
                        $output .='<option selected>' . __('Any', 'framework') . '</option>';
                        $max_price_value = $imic_options['properties_price_range'];
                        foreach ($max_price_value as $price_value) {
                            $output .= "<option value='" . $price_value . "'>" . $currency_symbol . " " . $price_value . "</option>";
                        }
                        $output .='</select>
                            </div>';
                    break;
                    case 'area':
                        $output .= '<div class="search-field">
                                <label>' . __('Min Area (Sq Ft)', 'framework') . '</label>
                                <input type="text" name="min_area" class="form-control input-lg" placeholder="' . __('Any', 'framework') . '">
                            </div>
                            <div class="search-field">
                                <label>' . __('Max Area (Sq Ft)', 'framework') . '</label>
                                <input type="text" name="max_area" class="form-control input-lg" placeholder="' . __('Any', 'framework') . '">
                            </div>';
                    break;
                    case 'search_by':
                        $output .= '<div class="search_by">
                            <div class="search-field">
                                <label>' . __('Search By', 'framework') . '</label>
                                <select name="search_by" class="form-control selectpicker">';
                        $output .='<option selected>' . __('Search By', 'framework') . '</option>';
                        $output .= "<option value='Id'>" . __('Id', 'framework') . "</option>";
                        $output .= "<option value='Address'>" . __('Address', 'framework') . "</option>";
                        $output .= "<option value='Pincode'>" . __('Pincode', 'framework') . "</option>";
                        $output .='</select>
                            </div>
                            <div class="search-field">';
                        $output .='<label>' . __('Keyword', 'framework') . '</label>
                             	<input type="text" name="search_by_keyword" class="form-control input-lg search_by_keyword" placeholder="' . __('Please enter ', 'framework') . '">
                            </div>
                            </div>';
                    break;
                }
            }
	
	
	
?>
  <div class="col-md-6">
    <div class="site-search-module">
        <div class="container">
            <div class="site-search-module-inside">
                <form method="get" action="<?php echo home_url(); ?>/">
                    <input type="hidden" class="form-control" name="s" id="s" value="<?php _e('Search1', 'framework'); ?>" />
                    <div class="row">
                    
                            <?php
                            echo '<div class="col-md-8 search-fields">';
							echo $output;
							
							echo '</div><div class="col-md-4 search-buttons"><div class="search-button"> <button type="submit" class="btn btn-primary btn-block btn-lg"><i class="fa fa-search"></i> '.__('Search','framework').' </button> </div>';
							echo '<div class="search-button avnt-hidden"> <a href="#" id="ads-trigger" class="btn btn-default btn-block"><i class="fa fa-plus"></i> <span>'.__('Advanced','framework').'</span></a> </div></div>';
							?>
                             </div>
                </form>
            </div>
        </div>
    </div>
    
         
    <?php endif; ?>
  </div>
                  
                  <div class="col-md-2 col-sm-6 pull-right">
                  <?php if($imic_options['enable-top-header-login-dropdown']==1){ ?>
                    <ul class="horiz-nav pull-right">
                      <li class="dropdown">
                        <?php 
					if (is_user_logged_in()) { 
						global $current_user;
      					get_currentuserinfo();
						
						/* Display Current Agent Options
						=========================================*/
						echo '<a data-toggle="dropdown">
			                	<i class="fa fa-user"></i> ';
									if(!empty($current_user->user_firstname)) {
										echo $current_user->user_firstname;   
									} else {
										echo $current_user->user_login;
									}
						echo '	<b class="caret"></b>
                			  </a>';			
					} else {
						//Agent login page link
						$agent_register_url = imic_get_template_url('template-register.php');
						
						/* Display Agent Login Options
						=========================================*/
						echo '<a href="'. $agent_register_url .'">
			                	<i class="fa fa-user"></i>'
									. __(' Login/Register ','framework') .
							 '</a>';	
					}
					
				/* Current Agent Options
				=========================================*/
				global $current_user; // Use global
				get_currentuserinfo(); // Make sure global is set, if not set it.
				if((user_can( $current_user, "agent" ) )||(user_can( $current_user, "administrator" ) )) { ?>
                          <ul class="dropdown-menu">
                            <?php
				  //Agent Profile page link
				  $agent_properties = imic_get_template_url('template-agent-properties.php');
				  $add_property = imic_get_template_url('template-submit-property.php');
                  	echo '<li><a href="'. $agent_properties.'">'. __('My projects','framework') .'</a></li>';
				  ?>
                              <li>
                                <a href="<?php echo $add_property; ?>">
                                  <?php _e('Add a project','framework'); ?>
                                </a>
                              </li>
                              <?php
				  $agent_favourite_properties = imic_get_template_url('template-favorite-properties.php');
				  echo '<li><a href="'. $agent_favourite_properties .'" title="'. __('Favorite Properties','framework') .'">'. __('Favorite Projects','framework') .'</a></li>';
				  $agent_favourite_searches = imic_get_template_url('template-favorite-search.php');
				  echo '<li><a href="'. $agent_favourite_searches .'" title="'. __('Saved Searches','framework') .'">'. __('Saved Searches','framework') .'</a></li>';
				  //Agent Profile page link
				  $agent_profile = imic_get_template_url('template-agent-profile.php');
                  	echo '<li class="register"><a href="'. $agent_profile .'" title="'. __('My Profile','framework') .'">'. __('My Profile','framework') .'</a></li>';
                  ?>
                                <li class="login">
                                  <a href="<?php echo wp_logout_url(home_url()); ?>" title="<?php _e('Logout','framework'); ?>">
                                    <?php _e('Logout','framework'); ?>
                                  </a>
                                </li>
                          </ul>
                          <?php } 
				else { ?>
                            <ul class="dropdown-menu">
                              <?php
				  $add_property = imic_get_template_url('template-submit-property.php');
				  $agent_favourite_properties = imic_get_template_url('template-favorite-properties.php');
				  echo '<li><a href="'. $agent_favourite_properties .'" title="'. __('Favorite Properties','framework') .'">'. __('Favorite Properties','framework') .'</a></li>';
				  if($imic_options['buyer_rights']==1) {
				  echo '<li><a href="'.$add_property.'">'.__('Add a property','framework').'</a></li>'; }
				  $agent_favourite_searches = imic_get_template_url('template-favorite-search.php');
				  echo '<li><a href="'. $agent_favourite_searches .'" title="'. __('Saved Searches','framework') .'">'. __('Saved Searches','framework') .'</a></li>';
				  //Agent Profile page link
				  $agent_profile = imic_get_template_url('template-agent-profile.php');
                  	echo '<li class="register"><a href="'. $agent_profile .'" title="'. __('My Profile','framework') .'">'. __('My Profile','framework') .'</a></li>';
                  ?>
                                <li class="login">
                                  <a href="<?php echo wp_logout_url(home_url()); ?>" title="<?php _e('Logout','framework'); ?>">
                                    <?php _e('Logout','framework'); ?>
                                  </a>
                                </li>
                            </ul>
                            <?php } ?>
                      </li>
                    </ul>
                    <?php } else { 
			 wp_nav_menu(array('theme_location' => 'top-menu', 'menu_class' => 'sf-menu', 'container' => '','items_wrap' => '<ul id="%1$s" class="horiz-nav pull-left">%3$s</ul>','walker'=>new My_Walker_Nav_Menu())); } ?>
                </div>
                  
                </div>
              </div>
            </div>
      </header>
      <!-- End Site Header -->
