<?php
/**
 * @package Publish
 * @since Publish 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'publish' ), 'after' => '</div>' ) ); ?>
		<div class="clearfloat"></div>
	</div><!-- .entry-content -->

	<footer class="entry-meta">
		<?php publish_posted_on(); ?>
		<?php
			/* translators: used between list items, there is a space after the comma */
			$category_list = get_the_category_list( __( ', ', 'publish' ) );

			/* translators: used between list items, there is a space after the comma */
			$tag_list = get_the_tag_list( '', ', ' );

			if ( ! publish_categorized_blog() ) {
				// This blog only has 1 category so we just need to worry about tags in the meta text
				if ( '' != $tag_list ) {
					$meta_text = __( 'tagged %2$s.', 'publish' );
				} else {

				}

			} else {
				// But this blog has loads of categories so we should probably display them here
				if ( '' != $tag_list ) {
					$meta_text = __( 'in %1$s and tagged %2$s.', 'publish' );
				} else {
					$meta_text = __( 'in %1$s.', 'publish' );
				}

			} // end check for categories on this blog

			printf(
				$meta_text,
				$category_list,
				$tag_list,
				get_permalink(),
				the_title_attribute( 'echo=0' )
			);
		?>
	</footer><!-- .entry-meta -->
</article><!-- #post-<?php the_ID(); ?> -->
