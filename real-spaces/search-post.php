<?php
echo'<article class="post">
                            <div class="row">';
                            if (has_post_thumbnail()):
							$class = 8;
                                echo '<div class="col-md-4 col-sm-4">
                    	<a href="' . get_permalink() . '">';
                                the_post_thumbnail('full', array('class' => "img-thumbnail"));
                                echo'</a></div>';
								else : $class = 12;
                            endif;
                            echo '<div class="col-md-'.$class.' col-sm-'.$class.'">';
                            echo '<h3><a href="' . get_permalink() . '">' . get_the_title() . '</a></h3>';
                            echo '<span class="post-meta meta-data"> <span><i class="fa fa-calendar"></i>';
                            echo get_the_date();
                            echo '</span><span><i class="fa fa-archive"></i>';
                            echo imic_custom_taxonomies_terms_links();
                            echo'</span> <span>';
                            comments_popup_link('<i class="fa fa-comment"></i>' . __('No comments yet', 'framework'), '<i class="fa fa-comment"></i>1', '<i class="fa fa-comment"></i>%', 'comments-link', __('Comments are off for this post', 'framework'));
                            echo'</span></span>';
                            echo imic_excerpt(50);
                            echo '<p><a href="' . get_permalink() . '" class="btn btn-primary">' . __('Continue reading', 'framework') . '<i class="fa fa-long-arrow-right"></i></a></p>';
                            echo '</div></div>';
                            echo '</article>';
?>