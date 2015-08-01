<?php
/* Template Name: Agent */
get_header();
global $imic_options;
/* Site Showcase */
imic_page_banner($pageID = get_the_ID());
/* End Site Showcase */
$sidebar = get_post_meta(get_the_ID(), 'imic_select_sidebar_from_list', false);
$class = (empty($sidebar) || !is_active_sidebar($sidebar[0])) ? 12 : 9;
//-- Start Content --
echo '<div class="main" role="main"><div id="content" class="content full"><div class="container"><div class="row">';
echo '<div class="col-md-'.$class.'">';
echo '<div class="block-heading">';
/* Become an agent details
================================ */
$becomeAgentText = get_post_meta(get_the_ID(), 'imic_agent_become_agent_text', true);
$becomeAgentURL = get_post_meta(get_the_ID(), 'imic_agent_become_agent_url', true);
if (!empty($becomeAgentText) && !empty($becomeAgentURL) && (!is_user_logged_in())) {
	echo '<a href="' . $becomeAgentURL . '" class="btn btn-sm btn-primary pull-right">' . $becomeAgentText . ' <i class="fa fa-long-arrow-right"></i></a>';
}
echo '<h4><span class="heading-icon"><i class="fa fa-users"></i></span>' . __('All Agents', 'framework') . '</h4>';
echo '</div>';
echo '<div class="agents-listing">';
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$per_page = get_option('posts_per_page');
$pages = $paged - 1;
$args = array(
'blog_id' => $GLOBALS['blog_id'],
'role' => 'agent',
'order' => 'ASC',
'orderby' => 'registered',
'number' => $per_page,
'offset' => $pages * $per_page
);
$blogusers = new WP_User_Query($args);
$Count_Agent = count(get_users(array('role' => 'agent')));
if (!empty($blogusers->results)) {
	echo '<ul>';
	foreach ($blogusers->results as $user) {
	echo '<li class="col-md-12">';
	/* Agent's Image
	======================= */
		$userImageID = get_the_author_meta('agent-image', $user->ID);
		$userDescClass = 12;
		if (!empty($userImageID)) {
			$image_id = imic_get_src_image_id($userImageID);
			$userImage = wp_get_attachment_image_src($image_id, '150-150-size');
			echo '<div class="col-md-4">
			<a href="' . get_author_posts_url($user->ID) . '" class="agent-featured-image"> <img src="' . $userImage[0] . '" alt="agent"></a>
			</div>';
           $userDescClass = 8;
		}
		else {
			$default_image_agent = $imic_options['default_agent_image'];
			echo '<div class="col-md-4">
			<a href="' . get_author_posts_url($user->ID) . '" class="agent-featured-image"> <img src="' . $default_image_agent['url'] . '" alt="agent"></a>
			</div>';
           $userDescClass = 8;
		}
		echo '<div class="col-md-' . $userDescClass . '">';
		echo '<div class="agent-info">';
		echo '<div class="counts">';
		echo '<strong>';
		/* Display Agent's Total Properties
		======================================== */
		echo imic_count_user_posts_by_type($user->ID,'property');
		echo '</strong>';
		echo'<span>' . __('Properties', 'framework') . '</span>';
		echo '</div>';
		echo '<h3><a href="' . get_author_posts_url($user->ID) . '">';
		/* Display Agent Name
		========================== */
		$userFirstName = get_the_author_meta('first_name', $user->ID);
		$userLastName = get_the_author_meta('last_name', $user->ID);
		$userName = $user->display_name;
		if (!empty($userFirstName) || !empty($userLastName)) {
			$userName = $userFirstName . ' ' . $userLastName;
		}
		echo $userName;
		echo '</a></h3>';
		/* Display Agent Description
		================================== */
		imic_agent_excerpt($user->ID);
		echo '</div>';
		/* Display Agent Social Links
		=================================== */
		$userFB = get_the_author_meta('fb-link', $user->ID);
		$userTWT = get_the_author_meta('twt-link', $user->ID);
		$userGP = get_the_author_meta('gp-link', $user->ID);
		$userMSG = get_the_author_meta('msg-link', $user->ID);
		$userLINKEDIN = get_the_author_meta('linkedin-link', $user->ID);
		$userSocialArray = array_filter(array($userFB, $userTWT, $userGP, $userMSG, $userLINKEDIN));
		$userSocialClass = array('fa-facebook', 'fa-twitter', 'fa-google-plus', 'fa-envelope', 'fa-linkedin');
		echo '<div class="agent-contacts clearfix">';
		if (!empty($userSocialArray)) {
			echo '<ul>';
			foreach ($userSocialArray as $key => $value) {
				if (!empty($value)) {
					echo '<li><a href="' . $value . '" target="_blank"><i class="fa ' . $userSocialClass[$key] . '"></i></a></li>';
				}
			}
			echo '</ul>';
		}
		echo '</div></div></li>';
	}
	echo '</ul>';

echo '</div>';
$Total_Pages = $Count_Agent / $per_page;
if(is_float($Total_Pages)) { $Total_Pages = $Total_Pages+1; }
if ($Count_Agent > $per_page) {
	pagination($Total_Pages, $per_page);
}
}
else {
	echo do_shortcode($imic_options['no_agents_msg']);
}
echo '</div>';
/* Start Sidebar
================================== */
if (!empty($sidebar) && is_active_sidebar($sidebar[0])) { 
	echo'<div class="sidebar right-sidebar col-md-3">';
    dynamic_sidebar($sidebar[0]); 
    echo'</div>'; 
}
echo '</div></div></div>';
get_footer(); ?>