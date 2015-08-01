<?php
/**
 * The template used for displaying post in timeline design
 */
?>
<?php
$post_format = get_post_format();
if($post_format=='link') { 
$post_link_url = get_post_meta(get_the_ID(),'imic_gallery_link_url',true); } else { $post_link_url = get_permalink(); }
global $more,$month_tag,$i,$month_check;
$more = 0;
if($month_tag!=get_the_time('M')) { $month_check=1; }
		if($month_check==1) {
		$month_tag = get_the_time('M'); } if($month_check==1) { $tag = '<div class="timeline-badge">'.  __(get_the_time('M'),'framework').'<span>'.get_the_time('Y').'</span></div>'; } else { $tag = ''; } $month_check++;
         if($i%2==0){
             $class =" class='timeline-inverted'";
         }
         else{
             $class ='';
         }
            echo '<li'.$class.'>';
            echo $tag;
            echo'<div class="timeline-panel">
                <div class="timeline-heading">
                  <h3 class="timeline-title"><a href="'.$post_link_url.'">'.get_the_title().'</a></h3>
                  <p><small class="text-muted"><i class="fa fa-calendar"></i> '.get_the_date().'</small></p>
                </div>';
				if($post_format!='link') {
                echo '<div class="timeline-body">';
                   if ( ! has_excerpt() ) { the_content(); } else { the_excerpt(); }
                echo'</div>'; }
              echo '</div>
            </li>';
                $i++; ?>