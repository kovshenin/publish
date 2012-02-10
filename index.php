<?php get_header(); ?>
			
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