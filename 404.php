<?php get_header(); ?>
			
<div class="ten columns alpha offset-by-four">
	<h2><?php _e( 'Ooops! Not Found!', 'publish' ); ?></h2>
	<p><?php _e( "We're deeply sorry, but the page you were looking for was not found. Perhaps you should try a search using the form below, or return home.", 'publish' ); ?></p>
	<?php get_search_form(); ?>
</div>

<?php get_footer(); ?>