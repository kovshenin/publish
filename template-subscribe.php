<?php 
/* Template Name: Subscribe */
get_header(); 
?>
			
			<?php if ( have_posts() ) : ?>
				<?php while ( have_posts() ) : the_post(); ?>
					
					<div <?php post_class(); ?>>
						<div class="four columns alpha">
							<div class="post-meta hide-when-narrow">

								<?php if ( get_post_type() == 'page' ) : ?>
									
									<?php if ( is_search() ) : ?>
										Page
									<?php endif; ?>
									
								<?php else : ?>
									
									<a href="<?php the_permalink(); ?>" rel="bookmark"><?php $publish->the_time_diff(); ?></a><br />
						
									<?php if ( $publish->options['display-author'] ): ?>
									<?php
										// Translators: by <author display name>
										printf( __( 'by %s', 'publish' ),
											sprintf( '<a href="%s" rel="author">%s</a>',
												get_author_posts_url( get_the_author_meta( 'ID' ) ),
												get_the_author()
											)
										);
									?><br />
									<?php endif; ?>
									<a href="<?php comments_link(); ?>"><?php comments_number( __( 'no comments', 'publish' ), __( 'one comment', 'publish' ), __( '% comments', 'publish' ) ); ?></a>
								<?php endif; ?>
							</div>
						</div>
					
						<div class="ten columns omega post-content">
							
							<?php get_template_part( 'content', get_post_format() ); ?>

<form class="subscription-form" method="POST" style="background: lightYellow; border: solid 1px #E6DB55; padding: 20px;">
	<?php $status = isset( $_REQUEST['subscribe'] ) ? $_REQUEST['subscribe'] : false; ?>
	<?php if ( $status == 'invalid_email' ) : ?>
	<p><strong>Sorry!</strong> The e-mail you have entered does not seem to be valid! Please try again.</p>
	<?php elseif ( $status == 'already' ) : ?>
	<p style="margin: 0;">Looks like you have already subscribed, thanks!</p>
	<?php elseif ( $status == 'error' ) : ?>
	<p><strong>Hmmm</strong>... Something went terribly wrong. Care to try again?</p>
	<?php elseif ( $status == 'success' ) : ?>
	<p style="margin: 0;">Thank you so much for subscribing! You should be receiving an e-mail soon, with some instructions to confirm your subscription.</p>
	<?php endif; ?>

	<?php if ( in_array( $status, array( false, 'error', 'invalid_email' ) ) ) : ?>
	<input type="hidden" name="subscribe-form-action" value="subscribe" />
	<label for="subscribe-email">E-mail Address</label>
	<input type="text" name="subscribe-email" id="subscribe-email" value="" placeholder="" style="display: inline-block;" />
	<input type="submit" value="Subscribe" style="padding-top: 3px; padding-bottom: 3px; margin-bottom: 6px;" />
	<div style="font-size: 85%; color: #777;">You will receive an e-mail with a link to confirm your subscription.</div>
	<?php endif; ?>
</form>

<p>Alternatively, you can subscribe to the <a href="<?php bloginfo( 'rss2_url' ); ?>">RSS feed</a>.</p>

							<hr class="show-when-narrow" />
						</div>
						
						<br class="clear" />
					</div>
			
				<?php endwhile; ?>
			<?php endif; ?>
			
			
				<?php if ( is_singular() && ( ( is_page() && comments_open() ) || ! is_page() ) ) : ?>
					<br class="clear">
					<div id="comments-template" class="ten columns alpha offset-by-four <?php if ( comments_open() ) echo ' comments-open '; ?>">
						<hr />
						<?php comments_template(); ?>
					</div>
				<?php endif; ?>
					
					<br class="clear" />
					<div class="ten columns alpha offset-by-four">
						<p class="pagination">
							<?php next_posts_link( __( '&larr; older posts', 'publish' ) ); ?>
							<?php previous_posts_link( __( 'newer posts &rarr;', 'publish' ) ); ?>
							<a class="show-when-narrow inline" href="#"><?php _e( 'back to top', 'publish' ); ?></a>
						</p>
					</div>

<?php get_footer(); ?>
