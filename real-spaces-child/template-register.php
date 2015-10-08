<?php
/* Template Name: Login/Register */
get_header();
/* Site Showcase */
imic_page_banner($pageID = get_the_ID());
/* End Site Showcase */
/* Login/Register Page Design Layout 
============================================*/
$pageLayout = get_post_meta(get_the_ID(),'imic_register_layout',true);
$contentClass = 4;
if ($pageLayout != 1) { $contentClass = 6; }?>
    <!-- Start Content -->
    <div class="main" role="main">
        <div id="content" class="content full">
            <div class="container">
                <div class="page">
                    <div class="row">
                        <?php 
echo '<div class="col-md-'.$contentClass.' col-sm-'.$contentClass.'">';
/* Page Content
======================*/
while (have_posts()):the_post();
the_content();
endwhile;
echo '</div>';
/* Manage Login Form
========================*/
if ($pageLayout == 1 || $pageLayout == 2) { ?>
                            <div class="col-md-4 col-sm-4 login-form">
                                <h3><?php _e('Login','framework'); ?></h3>
                                <form id="login" action="login" method="post">
                                    <?php 
$redirect_login= get_post_meta(get_the_ID(),'imic_login_redirect_options',true);
$redirect_login=!empty($redirect_login)?$redirect_login:  home_url();
?>
                                        <input type="hidden" class="redirect_login" name="redirect_login" value="<?php echo $redirect_login ?>" />
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
                                                <?php echo '<a href="'.imic_get_template_url('template-reset_password.php').'" title="'.__('I forgot my password','framework').'">'.__('I forgot my password','framework').'</a>'; ?>
                                        </div>
                                        <input class="submit_button btn btn-primary button2" type="submit" value="<?php _e('Login Now','framework'); ?>" name="submit">
                                        <?php wp_nonce_field( 'ajax-login-nonce', 'security' ); ?>
                                            <p class="status"></p>
                                </form>
                            </div>
                            <?php } 
/* Manage Register Form
========================*/
if ($pageLayout == 1 || $pageLayout == 3) { ?>
                                <div class="col-md-4 col-sm-4 register-form">
                                    <h3><?php _e('Register','framework'); ?></h3>
                                    <form method="post" id="registerform" name="registerform" class="register-form">
                                        <?php 
$redirect_register= get_post_meta(get_the_ID(),'imic_register_redirect_options',true);
$redirect_register=(!empty($redirect_register))?$redirect_register:  home_url();
?>
                                            <input type="hidden" class="redirect_register" name="redirect_register" value="<?php echo $redirect_register ?>" />
                                            <div class="input-group avaant-hidden">
                                                <span class="input-group-addon"><i class="fa fa-users"></i></span>
                                                <select name="role" id="role" class="form-control selectpicker">
                                                    <option value="agent">
                                                        <?php _e('Agent','framework'); ?>
                                                    </option>
                                                    <option value="subscriber">
                                                        <?php _e('Buyer','framework'); ?>
                                                    </option>
                                                </select>
                                            </div>
                                            
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                                <input type="text" name="username" id="username" class="form-control" placeholder="<?php _e('Username','framework'); ?>">
                                            </div>
                                            <br>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                                <input type="email" name="email" id="email" class="form-control" placeholder="<?php _e('Email','framework'); ?>">
                                            </div>
                                            <br>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                                <input type="password" name="pwd1" id="pwd1" class="form-control" placeholder="<?php _e('Password','framework'); ?>">
                                            </div>
                                            <br>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-refresh"></i></span>
                                                <input type="password" name="pwd2" id="pwd2" class="form-control" placeholder="<?php _e('Repeat Password','framework') ?>">
                                            </div>
                                            <br>
                                            <div class="input-group">
                                              <p>Are you a...</p>
                                              <input type="checkbox" name="hacker" id="hacker" value="hacker">Hacker<br>
                                              <input type="checkbox" name="hustler" id="hustler" value="hustler">Hustler<br>
                                              <input type="checkbox" name="creative" id="creative" value="creative">Creative<br>
                                            </div>
                                            <br>
                                            <input type="hidden" name="image_path" id="image_path" value="<?php echo get_template_directory_uri(); ?>">
                                            <input type="hidden" name="task" id="task" value="register" />
                                            <button type="submit" id="submit" class="btn btn-primary">
                                                <?php _e('Register Now','framework'); ?>
                                            </button>
                                    </form>
                                    <div class="clearfix"></div>
                                    <div id="message"></div>
                                </div>
                                <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php  get_footer(); ?>
