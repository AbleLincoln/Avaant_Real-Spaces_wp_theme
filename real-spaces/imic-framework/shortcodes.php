<?php
       load_theme_textdomain('imic-framework-admin', IMIC_FILEPATH. '/language/');
	// Create TinyMCE's editor button & plugin for IMIC Framework Shortcodes
	add_action('init', 'imic_sc_button'); 
	
	function imic_sc_button() {  
	   if ( current_user_can('edit_posts') &&  current_user_can('edit_pages') )  
	   {  
	     add_filter('mce_external_plugins', 'imic_add_tinymce_plugin');  
	     add_filter('mce_buttons', 'imic_register_shortcode_button');  
	   }  
	} 
	
	function imic_register_shortcode_button($button) {  
	    array_push($button, 'separator', 'imicframework_shortcodes' );  
	    return $button;  
	}
	
	function imic_add_tinymce_plugin($plugins) {  
	    $plugins['imicframework_shortcodes'] = get_template_directory_uri() . '/imic-framework/imic-shortcodes/imic-tinymce.editor.plugin.js';  
	    return $plugins;  
	} 
	
	
	
	/* ==================================================
	
	SHORTCODES OUTPUT
	
	================================================== */
	
	/* AGENTS SHORTCODE
	================================================== */
	
	function imic_agents($atts, $content = null) {
		extract(shortcode_atts(array(
			"number"			=> "",
		), $atts));
		
		$output = '';
		$user_number = 1;
		global $imic_options;
        $users = get_users(array('meta_key' => 'popular', 'meta_value' => 'Popular','orderby' => 'display_name'));
        if(!empty($users)){
		foreach($users as $user) {
			$User_Phone = get_user_meta($user->ID,'mobile-phone',true);
			$User_Pic = get_user_meta($user->ID,'agent-image',true);
			if(!empty($User_Pic)) {
										$output .= '<a href="'.get_author_posts_url($user->ID).'"><img src="'.$User_Pic.'" alt="" class="img-thumbnail"></a>';
									}
			else {
				$default_image_agent = $imic_options['default_agent_image'];
				$output .= '<a href="'.get_author_posts_url($user->ID).'"><img src="'.$default_image_agent['url'].'" alt="" class="img-thumbnail"></a>';
			}
				$output .= '<div class="row">
                      <div class="col-md-6 col-sm-6 col-xs-6">
                          <h4><a href="'.get_author_posts_url($user->ID).'">'.$user->display_name.'</a></h4>
                              <a href="'.get_author_posts_url($user->ID).'" class="btn btn-sm btn-primary">'.__('more details','framework').'</a>
                       </div>
                       <div class="col-md-6 col-sm-6 col-xs-6">
                              <ul class="contact-info">
                                  <li><i class="fa fa-phone"></i> '.$User_Phone.'</li>
                               <li><i class="fa fa-envelope"></i> '.$user->user_email.'</li>
                           </ul>
                       </div>
                    </div>';
				if (++$user_number > $number)
            break;
		}
        }
		else {
			$output .= '<div class="row">
                      <div class="col-md-6 col-sm-6 col-xs-6">
                          <h4>'.__('There is no popular agent.','framework').'</h4></div></div>';
		}
		return $output;
	}
	add_shortcode('agents', 'imic_agents');
	
	/* TESTIMONIALS SHORTCODE
	================================================== */
	
	function imic_testimonial($atts, $content = null) {
		extract(shortcode_atts(array(
			"number"			=> "",
			"slider" => "no",
			"pagination" => "yes",
			"scroll" => "yes"
		), $atts));
		
		$output = '';
		$owl = ($slider=="yes")?'owl-carousel':'';
		$pagination = ($pagination=="yes")?'data-pagination="yes"':'';
		$auto_scroll = ($scroll=="yes")?'data-autoplay="5000"':'';
		$output .= '<ul class="testimonials '.$owl.'" '.$pagination.' '.$auto_scroll.'>';
		query_posts(array('post_type'=>'testimonials','posts_per_page'=>$number));
		if(have_posts()):while(have_posts()):the_post();
		$company = get_post_meta(get_the_ID(),'imic_client_company',true);
		$Client_Url = get_post_meta(get_the_ID(),'imic_client_co_url',true);
		$domain_url=$url_html = '';
		if(filter_var($Client_Url, FILTER_VALIDATE_URL)){ 
		$domain_url = parse_url($Client_Url);
		$domain_url = $domain_url['host'];
		$url_html = '<br><a href="'.$Client_Url.'">'.$domain_url.'</a>';
		 }
				$output .= '<li>
                              '.imic_excerpt(50).get_the_post_thumbnail(get_the_ID(),'full',array('class'=>'testimonial-sender')).'
                              <cite>'.get_the_title().' - <strong>'.$company.'</strong>'.$url_html.'
                           </cite>
                        </li>';
					endwhile; endif; wp_reset_query();
		$output .= '</ul>';
		return $output;
	}
	add_shortcode('testimonial', 'imic_testimonial');
	/* 
	/* PRICING TABLE SHORTCODE
	================================================== */
	function imic_pricing_table($atts, $content = null) {
		extract(shortcode_atts(array(
		'column' => '',
		),$atts));
		$output = '';
		$column = ($column==4)?'four':'three';
		$output = '<div class="pricing-table '.$column.'-cols margin-40">'. do_shortcode($content).'</div>';
		return $output;
	}
	add_shortcode('pricingtable', 'imic_pricing_table');
	
	function imic_pricing_table_heading( $atts, $content = null ) {
		extract(shortcode_atts(array(
		'active' => '',
		),$atts));
		$output = '';
		$active_class = '';
		if($active!='') { $active_class = ' highlight accent-color'; }
		$output = '<div class="pricing-column '.$active_class.'"><h3>'. do_shortcode($content);		
		return $output;
	}
	add_shortcode('headingss', 'imic_pricing_table_heading');
	function imic_pricing_table_reason( $atts, $content = null ) {
		$output = '<span class="highlight-reason">'. do_shortcode($content).'</span>';		
		return $output;
	}
	add_shortcode('reason', 'imic_pricing_table_reason');
	function imic_pricing_table_price( $atts, $content = null ) {
		extract(shortcode_atts(array(
		'currency' => '',
		),$atts));
		$output = '</h3><div class="pricing-column-content"><h4> <span class="dollar-sign">'.$currency.' </span> '. do_shortcode($content);		
		return $output;
	}
	add_shortcode('price', 'imic_pricing_table_price');
	
	function imic_pricing_table_interval( $atts, $content = null ) {
		$output = '</h4><span class="interval">';
		$output .= do_shortcode($content) .'</span><ul class="features" style="height: 157px;">';
		
		return $output;
	}
	add_shortcode('interval', 'imic_pricing_table_interval');
	function imic_pricing_table_row( $atts, $content = null ) {
		$output = '<li>';
		$output .= do_shortcode($content) .'</li>';
		
		return $output;
	}
	add_shortcode('row', 'imic_pricing_table_row');
	function imic_pricing_table_url( $atts, $content = null ) {
		$output = '</ul><a class="btn btn-primary" href="'.do_shortcode($content) .'">'.__('Sign up now!','framework').'</a></div></div>';
		
		return $output;
	}
	add_shortcode('url', 'imic_pricing_table_url');
	
	/* BUTTON SHORTCODE
	================================================== */
	
	function imic_button($atts, $content = null) {
		extract(shortcode_atts(array(
			"colour"		=> "",
			"type"			=> "",
			"link" 			=> "#",
			"target"		=> '_self',
			"size"		=> '',
			"extraclass"   => ''
		), $atts));
		
		$button_output = "";
		$button_class = 'btn '. $colour .' '. $extraclass .' '. $size;
		$buttonType = ($type == 'disabled')? 'disabled="disabled"' : '';
						
		$button_output .= '<a class="'.$button_class.'" href="'.$link.'" target="'.$target.'" '.$buttonType.'>' . do_shortcode($content) . '</a>';		
		return $button_output;
	}
	add_shortcode('imic_button', 'imic_button');
	
	
	/* ICON SHORTCODE
	================================================== */
		
	function imic_icon($atts, $content = null) {
		extract(shortcode_atts(array(
			"image"			=> ""
		), $atts));
		
		return '<i class="fa ' .$image. '"></i>';
	}
	add_shortcode('icon', 'imic_icon');
	
	/* ICON BOX SHORTCODE
	================================================== */
		
	function imic_icon_box($atts, $content = null) {
		extract(shortcode_atts(array(
			"icon_image"	=> "",
			"title"			=> "",
			"description"	=> "",
			"start"			=> "",
			"end"			=> ""
		), $atts));
		$start = ($start!='')?'<ul>':'';
		$end = ($end!='')?'</ul>':'';
		return $start.'<li class="cust-icon-box">
			<div class="icon">
			<i class="fa '.$icon_image.'"></i>
			</div>
			<div class="text">
			<h4>'.$title.'</h4>
			<p>'.$description.'</p>
			</div>
			</li>'.$end;
	}
	add_shortcode('icon_box', 'imic_icon_box');
	/* COLUMN SHORTCODES
	================================================== */
	function imic_one_full( $atts, $content = null ) {
		extract(shortcode_atts(array(
			"extra" => '',
			"anim" => '',
		), $atts));
		$animation = (!empty($anim)) ? 'data-appear-animation="'.$anim.'"' : '';
	    return '<div class="col-md-12 ' . $extra . '" '. $animation .'>' . do_shortcode($content) . '</div>';
	}
	add_shortcode('one_full', 'imic_one_full');
	
	function imic_one_half( $atts, $content = null ) {
		extract(shortcode_atts(array(
			"extra" => '',
			"anim" => '',
		), $atts));
		$animation = ($anim != 0) ? 'data-appear-animation="bounceInRight"' : '';
	    return '<div class="col-md-6 ' . $extra . '" '. $animation .'>' . do_shortcode($content) . '</div>';
	}
	add_shortcode('one_half', 'imic_one_half');
	
	function imic_one_third( $atts, $content = null ) {
	   extract(shortcode_atts(array(
			"extra" => '',
			"anim" => ''
		), $atts));
		$animation = ($anim != 0) ? 'data-appear-animation="bounceInRight"' : '';
	    return '<div class="col-md-4 ' . $extra . '" '. $animation .'>' . do_shortcode($content) . '</div>';
	}
	add_shortcode('one_third', 'imic_one_third');
	function imic_one_fourth( $atts, $content = null ) {
	   extract(shortcode_atts(array(
			"extra" => '',
			"anim" => ''
		), $atts));
		$animation = ($anim != 0) ? 'data-appear-animation="bounceInRight"' : '';
	    return '<div class="col-md-3 ' . $extra . '" '. $animation .'>' . do_shortcode($content) . '</div>';
	}
	add_shortcode('one_fourth', 'imic_one_fourth');
	function imic_one_sixth( $atts, $content = null ) {
	   extract(shortcode_atts(array(
			"extra" => '',
			"anim" => ''
		), $atts));
		$animation = ($anim != 0) ? 'data-appear-animation="bounceInRight"' : '';
	    return '<div class="col-md-2 ' . $extra . '" '. $animation .'>' . do_shortcode($content) . '</div>';
	}
	add_shortcode('one_sixth', 'imic_one_sixth');
	
	function imic_two_third( $atts, $content = null ) {
	   extract(shortcode_atts(array(
			"extra" => '',
			"anim" => ''
		), $atts));
		$animation = ($anim != 0) ? 'data-appear-animation="bounceInRight"' : '';
	    return '<div class="col-md-8 ' . $extra . '" '. $animation .'>' . do_shortcode($content) . '</div>';
	}
	add_shortcode('two_third', 'imic_two_third');
	/* TABLE SHORTCODES
	================================================= */
	function imic_table_wrap( $atts, $content = null ) {
		extract(shortcode_atts(array(
			"type" => ''
		), $atts));
		$output = '<table class="table '.$type.'">';
		$output .= do_shortcode($content) .'</table>';
		
		return $output;
		
	}
	add_shortcode('htable', 'imic_table_wrap');
	function imic_table_headtag( $atts, $content = null ) {
		$output = '<thead>'. do_shortcode($content) .'</thead>';		
		return $output;
	}
	add_shortcode('thead', 'imic_table_headtag');
	function imic_table_body( $atts, $content = null ) {
		$output = '<tbody>'. do_shortcode($content) .'</tbody>';		
		return $output;
	}
	add_shortcode('tbody', 'imic_table_body');
	
	function imic_table_row( $atts, $content = null ) {
		$output = '<tr>';
		$output .= do_shortcode($content) .'</tr>';
		
		return $output;
	}
	add_shortcode('trow', 'imic_table_row');
	
	function imic_table_column( $atts, $content = null ) {
	
		$output = '<td>';
		$output .= do_shortcode($content) .'</td>';
		
		return $output;
	}
	add_shortcode('tcol', 'imic_table_column');
	function imic_table_head( $atts, $content = null ) {
		$output = '<th>';
		$output .= do_shortcode($content) .'</th>';
		
		return $output;
	}
	add_shortcode('thcol', 'imic_table_head');
	
	/* TYPOGRAPHY SHORTCODES
	================================================= */
	// Anchor tag
	function imic_anchor( $atts, $content = null ) {
		extract(shortcode_atts(array(
			"href"			=> '',
			"extra"			=> ''
		), $atts));
	   return '<a href="'.$href.'" class="'.$extra.'" >' . do_shortcode($content) . ' </a>';
	}
	add_shortcode('anchor', 'imic_anchor');
	// Alert tag
	function imic_alert( $atts, $content = null ) {
		extract(shortcode_atts(array(
			"type"			=> '',
			"close"			=> ''
		), $atts));
		$closeButton = ($close == 'true') ? '<a class="close" data-dismiss="alert" href="#">&times;</a>' : '';
	   return '<div class="alert '. $type .' fade in">  ' .$closeButton . do_shortcode($content) . ' </div>';
	}
	add_shortcode('alert', 'imic_alert');
	
	// Heading Tag
	function imic_heading_tag($atts, $content = null) {
		extract(shortcode_atts(array(
		   "size" => '',
		   "extra" => '',
		   "icon" => '',
		   "type" => ''
		), $atts));
		if($type=='block') {
		$output = '<div class="block-heading"><'.$size.' class="'.$extra.'"><span class="heading-icon"><i class="fa '.$icon.'"></i></span>'.do_shortcode($content).'</'.$size.'></div>';
		}
		else {
		$output = '<'.$size.' class="'.$extra.'">' . do_shortcode($content) .'</'.$size.'>';
		}
		return $output;
	}
	add_shortcode("heading", "imic_heading_tag");
	
	// Divider Tag
	function imic_divider_tag($atts, $content = null) {
		extract(shortcode_atts(array(
		   "extra" => '',
		), $atts));
		
		return '<hr class="'. $extra .'">';
	}
	add_shortcode("divider", "imic_divider_tag");
	
	// Paragraph type 
	function imic_paragraph($atts, $content = null) {
		extract(shortcode_atts(array(
		   "extra" => '',
		), $atts));
		
		return '<p class="' . $extra . '">'. do_shortcode($content) .'</p>';
	}
	add_shortcode("paragraph", "imic_paragraph");
	
	// Span type 
	function imic_span($atts, $content = null) {
		extract(shortcode_atts(array(
		   "extra" => '',
		), $atts));
		
		return '<span class="' . $extra . '">'. do_shortcode($content) .'</span>';
	}
	add_shortcode("span", "imic_span");	
	
	// Container type 
	function imic_container($atts, $content = null) {
		extract(shortcode_atts(array(
		   "extra" => '',
		), $atts));
		
		return '<div class="' . $extra . '">'. do_shortcode($content) .'</div>';
	}
	add_shortcode("container", "imic_container");
	
	// Dropcap type 
	function imic_dropcap($atts, $content = null) {
		extract(shortcode_atts(array(
		   "type" => '',
		), $atts));
		
		return '<p class="drop-caps ' . $type . '">'. do_shortcode($content) .'</p>';
	}
	add_shortcode("dropcap", "imic_dropcap");
		
	// Blockquote type
	function imic_blockquote($atts, $content = null) {
		extract(shortcode_atts(array(
		   "name" => '',
		), $atts));
		if(!empty($name)){ $authorName= '<cite>- '.$name.'</cite>'; }else{ $authorName= ''; } 
		return '<blockquote><p>'. do_shortcode($content) .'</p>' . $authorName . '</blockquote>';
	}
	add_shortcode("blockquote", "imic_blockquote");
	
	// Code type
	function imic_code($atts, $content = null) {
		extract(shortcode_atts(array(
		   "type" => '',
		), $atts));
		
		if($type=='inline'){ 
			return '<code>'. do_shortcode($content) .'</code>'; 
		}else{ 
			return '<pre>'. do_shortcode($content) .'</pre>'; 
		} 
		
	}
	add_shortcode("code", "imic_code");
		
	// Label Tag
	function imic_label_tag($atts, $content = null) {
		extract(shortcode_atts(array(
		   "type" => '',
		), $atts));
		$output = '<span class="label '.$type.'">' . do_shortcode($content) .'</span>';
		
		return $output;
	}
	add_shortcode("label", "imic_label_tag");	
	
	
	/* LISTS SHORTCODES
	================================================= */
	function imic_list( $atts, $content = null ) {
		extract(shortcode_atts(array(
			"type" => '',
			"extra" => '',
			"icon" => ''
		), $atts));
				
		if($type == 'ordered'){
			$output = '<ol>' . do_shortcode($content) .'</ol>';
		}else if($type == 'desc'){
			$output = '<dl>' . do_shortcode($content) .'</dl>';
		} else{
			$output = '<ul class="chevrons '.$type .' '. $extra .'">' . do_shortcode($content) .'</ul>';		
		}
		
		return $output;		
	}
	add_shortcode('list', 'imic_list');
	
	function imic_list_item( $atts, $content = null ) {
		extract(shortcode_atts(array(
			"icon" => '',
			"type" => ''
		), $atts));
		
		if(($type == 'icon')||($type == 'inline')){
			$output = '<li><i class="fa '.$icon.'"></i> ' . do_shortcode($content) .'</li>';
		}else{
			$output = '<li>' . do_shortcode($content) .'</li>';
		}
		return $output;		
	}
	add_shortcode('list_item', 'imic_list_item');
	
	function imic_list_item_dt( $atts, $content = null ) {		
		$output = '<dt>' . do_shortcode($content) .'</dt>';
		
		return $output;		
	}
	add_shortcode('list_item_dt', 'imic_list_item_dt');
	
	function imic_list_item_dd( $atts, $content = null ) {		
		$output = '<dd>' . do_shortcode($content) .'</dd>';
		
		return $output;		
	}
	add_shortcode('list_item_dd', 'imic_list_item_dd');
	function imic_page_first( $atts, $content = null ) {
		return '<li><a href="#"><i class="fa fa-chevron-left"></i></a></li>';		
	}
	add_shortcode('page_first', 'imic_page_first');
	
	function imic_page_last( $atts, $content = null ) {
		return '<li><a href="#"><i class="fa fa-chevron-right"></i></a></li>';		
	}
	add_shortcode('page_last', 'imic_page_last');	
	
	function imic_page( $atts, $content = null ) {
		extract(shortcode_atts(array(
			"class" => ''
		), $atts));
		
		return '<li class="'.$class.'"><a href="#">'. do_shortcode($content) .' </a></li>';		
	}
	add_shortcode('page', 'imic_page');	
	
	/* TABS SHORTCODES
	================================================= */
	function imic_tabs( $atts, $content = null ) {
		return '<div class="tabs">'. do_shortcode($content) .'</div>';
	}
	add_shortcode('tabs', 'imic_tabs');
	
	function imic_tabh( $atts, $content = null ) {
		return '<ul class="nav nav-tabs">'. do_shortcode($content) .'</ul>';		
	}
	add_shortcode('tabh', 'imic_tabh');
	
	function imic_tab( $atts, $content = null ) {
		extract(shortcode_atts(array(
			"id" => '',
			"class" => ''
		), $atts));
		
		return '<li class="'.$class.'"> <a data-toggle="tab" href="#'.$id.'"> '. do_shortcode($content) .' </a> </li>';		
	}
	add_shortcode('tab', 'imic_tab');	
	
	function imic_tabc( $atts, $content = null ) {		
		return '<div class="tab-content">'. do_shortcode($content) .'</div>';	
	}
	add_shortcode('tabc', 'imic_tabc');
	
	function imic_tabrow( $atts, $content = null ) {
		extract(shortcode_atts(array(
			"id" => '',
			"class" => ''
		), $atts));
				
		$output = '<div id="'.$id.'" class="tab-pane '.$class.'">' . do_shortcode($content) .'</div>';
		
		return $output;		
	}
	add_shortcode('tabrow', 'imic_tabrow');
	/* ACCORDION SHORTCODES
	================================================= */
	function imic_accordions( $atts, $content = null ) {
		extract(shortcode_atts(array(
			"id" => ''
		), $atts));
		
		return '<div class="accordion" id="accordion' .$id. '">'. do_shortcode($content) .'</div>';
	}
	add_shortcode('accordions', 'imic_accordions');
	
	function imic_accgroup( $atts, $content = null ) {
		return '<div class="accordion-group panel">'. do_shortcode($content) .'</div>';		
	}
	add_shortcode('accgroup', 'imic_accgroup');
	
	function imic_acchead( $atts, $content = null ) {
		extract(shortcode_atts(array(
			"id" => '',
			"class" => '',
			"tab_id" =>''
		), $atts));
		
		$output = '<div class="accordion-heading accordionize"> <a class="accordion-toggle '. $class .'" data-toggle="collapse" data-parent="#accordion' .$id. '" href="#' .$tab_id. '"> '. do_shortcode($content) .' <i class="fa fa-angle-down"></i> </a> </div>';
		
		return $output;
	}
	add_shortcode('acchead', 'imic_acchead');	
	
	function imic_accbody( $atts, $content = null ) {
		extract(shortcode_atts(array(
			"tab_id" => '',
			"in" => ''
		), $atts));
		
		$output = '<div id="' . $tab_id . '" class="accordion-body ' . $in . ' collapse">
					  <div class="accordion-inner"> '. do_shortcode($content) .' </div>
					</div>';
		
		return $output;		
	}
	add_shortcode('accbody', 'imic_accbody');
	/* TOGGLE SHORTCODES
	================================================= */
	function imic_toggles( $atts, $content = null ) {
		extract(shortcode_atts(array(
			"id" => ''
		), $atts));
		
		return '<div class="accordion" id="toggle' .$id. '">'. do_shortcode($content) .'</div>';
	}
	add_shortcode('toggles', 'imic_toggles');
	
	function imic_togglegroup( $atts, $content = null ) {
		return '<div class="accordion-group panel">'. do_shortcode($content) .'</div>';		
	}
	add_shortcode('togglegroup', 'imic_togglegroup');
	
	function imic_togglehead( $atts, $content = null ) {
		extract(shortcode_atts(array(
			"id" => '',
			"tab_id" =>''
		), $atts));
		
		$output = '<div class="accordion-heading togglize"> <a class="accordion-toggle" data-toggle="collapse" data-parent="#" href="#' .$tab_id. '"> '. do_shortcode($content) .' <i class="fa fa-plus-circle"></i> <i class="fa fa-minus-circle"></i> </a> </div>';
	
		return $output;
	}
	add_shortcode('togglehead', 'imic_togglehead');	
	
	function imic_togglebody( $atts, $content = null ) {
		extract(shortcode_atts(array(
			"tab_id" => ''
		), $atts));
		
		$output = '<div id="' . $tab_id . '" class="accordion-body collapse">
              <div class="accordion-inner"> '. do_shortcode($content) .'  </div>
            </div>';
		
		return $output;		
	}
	add_shortcode('togglebody', 'imic_togglebody');
	/* PROGRESS BAR SHORTCODE
	================================================= */
	function imic_progress_bar($atts) {
		extract(shortcode_atts(array(
			"percentage" => '',
			"name" => '',
			"type" => '',
			"value" => '',
			"colour" => ''
		), $atts));
		
		if ($type == 'progress-striped') { $typeClass = $type; } else { $typeClass = ""; }
		if ($colour == 'progress-bar-warning' ) { $warningText = '(warning)'; } else { $warningText = ""; }
		
		$service_bar_output = '';
		$progress_text = '';
		if($name!='') {
				$service_bar_output = '<div class="progress-label"> <span>' . $name . '</span> </div>';
		}
		$service_bar_output .= '<div class="progress '. $typeClass .'">';
		
		if($type == 'progress-striped'){
        	$service_bar_output .= '<div class="progress-bar ' . $colour . '" style="width: ' . $value . '%">';
			$service_bar_output .= '<span class="sr-only">' . $value . '% Complete (success)</span>';
			$service_bar_output .= '</div>';        
		}else if($type == 'colored'){
			if(!empty($warningText)){ $spanClass=''; $progress_text = $value.'% Complete '.$warningText; }else{ $spanClass='sr-only'; $progress_text = ''; }
          	$service_bar_output .= '<div class="progress-bar ' . $colour . '" style="width: ' . $value . '%"> <span class="'.$spanClass.'">' . $progress_text.'</span> </div>';
		}else{
			$service_bar_output .= '<div class="progress-bar progress-bar-primary" data-appear-progress-animation="'.$value.'%"> <span class="progress-bar-tooltip">' . $value . '%</span> </div>';
		}
        $service_bar_output .= '</div>';
		
		return $service_bar_output;
	}
	
	add_shortcode('progress_bar', 'imic_progress_bar');
	
	
	/* TOOLTIP SHORTCODE
	================================================= */
	function imic_tooltip($atts, $content = null) {
		extract(shortcode_atts(array(
			"title" => '',
			"link" => '#',
			"direction" => 'top'
		), $atts));
				
		$tooltip_output = '<a href="'.$link.'" rel="tooltip" data-toggle="tooltip" data-original-title="'.$title.'" data-placement="'.$direction.'">'.do_shortcode($content).'</a>';
		return $tooltip_output;
	}
	
	add_shortcode('imic_tooltip', 'imic_tooltip');
	/* WORDPRESS LINK SHORTCODE
	================================================= */
	function imic_wordpress_link() {
		return '<a href="http://wordpress.org/" target="_blank">WordPress</a>';
	}
	add_shortcode('wp-link', 'imic_wordpress_link');
	
	/* COUNT SHORTCODE
	================================================= */
	function imic_count($atts) {
		extract(shortcode_atts(array(
			"speed" => '2000',
			"to" => '',
			"icon" => '',
			"subject" => '',
			"textstyle" => ''
		), $atts));
		
		$count_output = '';
		if ($speed == "") {$speed = '2000'; }
		$count_output .= '<div class="col-lg-3 col-md-3 col-sm-3 cust-counter">';
		$count_output .= '<div class="fact-ico"> <i class="fa ' . $icon . ' fa-4x"></i> </div>';
		$count_output .= '<div class="clearfix"></div>';
		$count_output .= '<div class="timer" data-perc="'.$speed.'"> <span class="count">' .$to. '</span></div>';
		$count_output .= '<div class="clearfix"></div>';
		if ($textstyle == "h3") {
			$count_output .= '<h3>'.$subject.'</h3></div>';		
		} else if ($textstyle == "h6") {
			$count_output .= '<h6>'.$subject.'</h6></div>';		
		} else {
			$count_output .= '<span class="fact">'.$subject.'</span></div>';
		}
		
		return $count_output;
	}
	
	add_shortcode('imic_count', 'imic_count');
	
	/* MODAL BOX SHORTCODE
	================================================== */
	function imic_modal_box($atts, $content = null) {
		extract(shortcode_atts(array(
			"id"			=> "",
			"title" 	=> "",
			"text"	=> "",
			"button" => ""
		), $atts));
		
		$modalBox = '<button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#'.$id.'">'.$button.'</button>
            <div class="modal fade" id="'.$id.'" tabindex="-1" role="dialog" aria-labelledby="'.$id.'Label" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="'.$id.'Label">'.$title.'</h4>
                  </div>
                  <div class="modal-body"> '. $text .' </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default inverted" data-dismiss="modal">Close</button>
                  </div>
                </div>
              </div>
            </div>';
				
		return $modalBox;
		
	}
	add_shortcode('modal_box', 'imic_modal_box');
	
	/* FORM SHORTCODE
	================================================== */
	function imic_form_code($atts, $content = null) {
            $admin_email = get_option('admin_email');
      $subject_email = __('Contact Form','framework'); 
   $formCode = '<form action="'.get_template_directory_uri().'/mail/contact.php" type="post" class="contact-form">
					  <div class="row">
						<div class="form-group">
						  <div class="col-md-6">
							<label>'.__('Your name','framework').' *</label>
							<input type="text" value="" maxlength="100" class="form-control" name="name" id="name">
						  </div>
						  <div class="col-md-6">
							<label>'.__('Your email address','framework').' *</label>
							<input type="email" value="" maxlength="100" class="form-control" name="email" id="email">
						  </div>
                                                  <div class="col-md-12">
							<label>'.__('Your Phone Number','framework').'</label>
							<input type="text" id="phone" name="phone" class="form-control input-lg">
						  </div>
						</div>
					  </div>
					  <div class="row">
                                          <input type ="hidden" name ="image_path" id="image_path" value ="'.IMIC_THEME_PATH.'/">
                                          <input type="hidden" id="phone" name="phone" class="form-control input-lg" placeholder="">
                                          <input id="admin_email" name="admin_email" type="hidden" value ="'.$admin_email.'">
                                              <input id="subject" name="subject" type="hidden" value ="'.$subject_email.'">
						<div class="form-group">
						  <div class="col-md-12">
							<label>'.__('Comment','framework').'</label>
							<textarea maxlength="5000" rows="10" class="form-control" name="comments" id="comments" style="height: 138px;"></textarea>
						  </div>
						</div>
					  </div>
					  <div class="row">
						<div class="col-md-12">
						  <input type="submit" name ="submit" id ="submit" value="'.__('Submit','framework').'" class="btn btn-primary" data-loading-text="'.__('Loading...','framework').'">
						</div>
					  </div>
					</form><div class="clearfix"></div>
                    <div id="message"></div>';
    return $formCode;
}
	add_shortcode('imic_form', 'imic_form_code');
?>