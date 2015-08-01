<?php
/**
 * The template for displaying a "No posts found" message
 *
 */
?>
<article class="post format-<?php echo get_post_format(); ?>">
              <div class="row">
                <div class="col-md-8 col-sm-8">
                  <h3><?php _e( 'Nothing Found', 'framework' ); ?></h3>
                  <?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>
                  <p><?php printf( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'framework' ), admin_url( 'post-new.php' ) ); ?></p>
                  <?php else : ?>
	<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'framework' ); ?></p>
                  <?php endif; ?>
				  </div>
                  </div>
                  </article>