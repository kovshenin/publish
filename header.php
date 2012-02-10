<?php global $publish; ?><!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="en"> <!--<![endif]-->
<head>

	<!-- Basic Page Needs
  ================================================== -->
	<meta charset="utf-8">
	<title><?php wp_title(''); ?></title>
	<meta name="description" content="">
	<meta name="author" content="">
	<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<!-- Mobile Specific Metas
  ================================================== -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<!-- Favicons
	================================================== -->
	<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/images/favicon.ico">
	<link rel="apple-touch-icon" href="images/apple-touch-icon.png">
	<link rel="apple-touch-icon" sizes="72x72" href="images/apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="114x114" href="images/apple-touch-icon-114x114.png">
	<link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>">
	<?php
	if ( is_singular() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );
	?>

	<?php wp_head(); ?>

</head>
<body>

	<!-- Primary Page Layout
	================================================== -->

	<div class="container">
		<div id="header" class="ten columns offset-by-four">
			<?php $tag = ( is_home() ) ? 'h1' : 'div'; ?>
			<<?php echo $tag; ?> id="site-title" style="margin-top: 40px"><a href="<?php echo home_url( '/' ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></<?php echo $tag; ?>>

			<h5 id="site-description"><?php echo $publish->random_description(); ?></h5>

			<nav id="navigation">
				<?php wp_nav_menu( array( 'depth' => 1, 'theme_location' => 'primary' ) ); ?>

				<div class="twitter-follow-container" style="float: left; width: 150px;">
					<a href="https://twitter.com/soulseekah" class="twitter-follow-button" data-show-count="true" data-show-screen-name="false">Follow @soulseekah</a>
					<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
				</div>

			</nav>

		</div>

		<div class="sixteen columns">

			<div id="page-title" class="ten columns offset-by-four alpha">
				<strong>
					<?php if ( is_day() ) : ?>
						<?php printf( __( 'Daily Archives: %s', 'publish' ), '<span>' . get_the_date() . '</span>' ); ?>
					<?php elseif ( is_month() ) : ?>
						<?php printf( __( 'Monthly Archives: %s', 'publish' ), '<span>' . get_the_date( 'F Y' ) . '</span>' ); ?>
					<?php elseif ( is_year() ) : ?>
						<?php printf( __( 'Yearly Archives: %s', 'publish' ), '<span>' . get_the_date( 'Y' ) . '</span>' ); ?>
					<?php elseif ( is_category() ) : ?>
						<?php printf( __( 'Category Archives: %s', 'publish' ), '<span>' . single_cat_title( '', false ) . '</span>' ); ?>
					<?php elseif ( is_tag() ) : ?>
						<?php printf( __( 'Tag Archives: %s', 'publish' ), '<span>' . single_tag_title( '', false ) . '</span>' ); ?>
					<?php elseif ( is_author() ): the_post(); ?>
						<?php printf( __( 'Author Archives: %s', 'publish' ), '<span>' . get_the_author() . '</span>' ); ?>
					<?php elseif ( is_archive() ): ?>
						<?php _e( 'Blog Archives', 'publish' ); ?>
					<?php elseif ( is_search() ) : ?>
						<?php printf( __( 'Search Results for: %s', 'publish' ), get_search_query() ); ?>
					<?php endif; ?>
				</strong>
			</div>
			<br class="clear" />
