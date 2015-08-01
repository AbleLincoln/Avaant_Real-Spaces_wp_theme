<?php
get_header();
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
$contactBanner = $imic_options['banner_image']['url'];
echo '<!-- Site Showcase -->
    <div class="site-showcase">
    <!-- Start Page Header -->
    <div class="parallax page-header" style="background-image:url(' . $contactBanner . ');">
            <div class="container">
                    <div class="row">
                            <div class="col-md-12">
                                    <h1>' . __('Search Result', 'framework') . '</h1>
                            </div>
               </div>
       </div>
    </div>
    <!-- End Page Header -->
    </div>';
?>
  <!-- Start Content -->
  <div class="main" role="main">
    <div id="content" class="content full">
      <div class="container">

        <div class="row">
          <?php if (is_active_sidebar('main-sidebar')):
                echo '<div class="col-md-9 posts-archive">'; else:
				echo '<div class="col-md-12 posts-archive">'; endif; ?>
            <?php
                    if (have_posts()) :
                        if( 'property' == get_post_type() ):
                        if ( is_plugin_active( 'favorite_property/favorite_property.php' ) ) {
                        echo do_shortcode('[addtosearch]'); 
                        }
                        ?>
              <nav id="navbar-example" class="navbar navbar-default navbar-static" role="navigation">
                <div class="container-fluid">
                  <div class="navbar-header">
                    <button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target=".bs-example-js-navbar-collapse">
                      <span class="sr-only"><?php _e('Toggle navigation','framework'); ?></span>
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                    </button>
                    <span class="navbar-brand"><?php _e('Filters','framework'); ?></span>
                  </div>
                  <div class="collapse navbar-collapse bs-example-js-navbar-collapse">
                    <ul class="nav navbar-nav">
                      <?php $args = array('orderby' => 'count', 'hide_empty' => true);
$property_contract_type_terms = get_terms('property-contract-type', $args);
if (!empty($property_contract_type_terms)) {
echo '<li class="dropdown" id="options">';
echo '<a id="drop1" href="#" role="button" class="dropdown-toggle" data-toggle="dropdown">'.__('Type ','framework').'<span class="caret"></span></a>';
echo '<ul class="filter option-set clearfix dropdown-menu" role="menu" aria-labelledby="drop1" data-filter-group="property_type">';
foreach ($property_contract_type_terms as $term) {
$term_name = $term->name;
$term_slug = $term->slug;
echo'<li><a role="presentation" role="menuitem" tabindex="-1" href="#filter-property-'.$term_name.'" data-filter-value=".'.$term_slug.'" class="dropdown-toggle" data-toggle="dropdown">'.$term_name.'</a></li>';
}
echo'</ul></li>';
}
$args_p_t = array('orderby' => 'count', 'hide_empty' => true);
$property_type_terms = get_terms('property-type',$args_p_t);
if (!empty($property_type_terms)) {
    echo '<li class="dropdown">
<a href="#" id="drop2" role="button" class="dropdown-toggle" data-toggle="dropdown">'.__('Property type','framework').'<span class="caret"></span></a>';
    echo '<ul class="filter option-set clearfix dropdown-menu" role="menu" aria-labelledby="drop2" data-filter-group="property_type">';
foreach ($property_type_terms as $term) {
$term_name = $term->name;
$term_slug = $term->slug;
echo'<li role="presentation"><a role="menuitem" tabindex="-1" href="#filter-property-'.$term_name.'" data-filter-value=".'.$term_slug.'">'.$term_name.'</a></li>';
}
echo '</ul></li>';
}
?>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                      <li id="fat-menu" class="dropdown">
                        <a href="#" id="drop3" role="button" class="dropdown-toggle" data-toggle="dropdown">
                          <?php _e('By custom','framework');?><span class="caret"></span></a>
                        <ul class="option-set dropdown-menu" role="menu" aria-labelledby="drop3" data-option-key="sortBy">
                          <?php echo '<li role="presentation"><a role="menuitem" tabindex="-1" href="#sortBy=sort_by_price" data-option-value="price">'.__('Price','framework').'</a></li>';
     echo '<li role="presentation"><a role="menuitem" tabindex="-1" href="#sortBy=sort_by_location" data-option-value="location">'.__('Location','framework').'</a></li>';?>
                        </ul>
                      </li>
                    </ul>
                  </div>
                  <!-- /.nav-collapse -->
                </div>
                <!-- /.container-fluid -->
              </nav>
              <?php
                echo '<div class="property-listing" id="property-listing">';
  echo '<ul id="property_grid_holder" class="col-md-12">';
                        
                        endif;
                        while (have_posts()):the_post();
                        if( 'property' == get_post_type() ):
						   get_template_part('search','property');
						   else:
						   if( 'property' == get_post_type() ):
						   break; endif;
						   get_template_part('search','post');
						   endif;
                        endwhile;
						if( 'property' == get_post_type() ):
						echo '</ul></div>'; endif;
                    else:
                        get_template_part('content','none');
                        ?>
                <?php
                    endif; // end have_posts() check 
                    pagination();
                    ?>
        </div>
        <!-- Start Sidebar -->
        <?php
                if (is_active_sidebar('main-sidebar')):
                    echo '<div class="col-md-3 sidebar">';
                    dynamic_sidebar('main-sidebar');
                    echo '</div>';
                endif;
                ?>
          <!-- End Sidebar -->
      </div>
    </div>
  </div>
  </div>
  <!--Add Search Form-->
  <div id="searchmodal" class="modal fade" aria-hidden="true" aria-labelledby="mymodalLabel" role="dialog" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button class="close" aria-hidden="true" data-dismiss="modal" type="button">×</button>
          <h4 id="mymodalLabel" class="modal-title"><?php _e(' Save Search','framework'); ?></h4>
        </div>
        <div class="modal-body">
          <div class="agent-contact-form search_information">
            <h4><?php _e('Save this Search','framework'); ?></h4>
            <input type="text" id="search" name="search name" class="form-control" placeholder="<?php _e('Search Name','framework'); ?>">

            <button type="button" class="btn btn-primary pull-right search">
              <?php _e('Submit','framework'); ?>
            </button>
          </div>
          <?php   $current_user = wp_get_current_user();
global $wpdb;
echo '<span class ="f_author_n" id ="' . $current_user->ID . '"></span>'; ?>
            <div class="clearfix"></div>
            <div id="message"></div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-default inverted" data-dismiss="modal" type="button">Close</button>
        </div>
      </div>
    </div>
  </div>
  <!--Search Login Form-->
  <div id="mymodal" class="modal fade" aria-hidden="true" aria-labelledby="mymodalLabel" role="dialog" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button class="close" aria-hidden="true" data-dismiss="modal" type="button">×</button>
          <h4 id="mymodalLabel" class="modal-title"><?php _e(' Login','framework'); ?></h4>
        </div>
        <div class="modal-body">
          <form id="login" action="login" method="post">
            <?php 
$redirect_login= get_post_meta(get_the_ID(),'imic_login_redirect_options',true);
$redirect_login=!empty($redirect_login)?$redirect_login:  home_url();
?>
              <input type="hidden" class="redirect_login" name="redirect_login" value="" />
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                <input class="form-control input1" id="loginname" type="text" name="loginname">
              </div>
              <br>
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                <input class="form-control input1" id="password" type="password" name="password">
              </div>
              <div class="checkbox">
                <input type="checkbox" checked="checked" value="true" name="rememberme" id="rememberme" class="checkbox">
                <?php _e('Remember Me!','framework'); ?>
              </div>
              <input class="submit_button btn btn-primary button2" type="submit" value="<?php _e('Login Now','framework'); ?>" name="submit">
              <?php wp_nonce_field( 'ajax-login-nonce', 'security' ); ?>
                <p class="status"></p>
          </form>
        </div>
        <div class="modal-footer">
          <button class="btn btn-default inverted" data-dismiss="modal" type="button">Close</button>
        </div>
      </div>
    </div>
  </div>
  <?php get_footer(); ?>
