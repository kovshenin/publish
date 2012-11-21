<?php
/**
 * Publish functions and definitions
 *
 * @package Publish
 * @since Publish 1.0
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since Publish 1.0
 */
if ( ! isset( $content_width ) )
	$content_width = 525; /* pixels */

if ( ! function_exists( 'publish_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * @since Publish 1.0
 */
function publish_setup() {

	/**
	 * Custom template tags for this theme.
	 */
	require( get_template_directory() . '/inc/template-tags.php' );

	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 */
	load_theme_textdomain( 'publish', get_template_directory() . '/languages' );

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

	/**
	 * Enable Custom Backgrounds
	 */
	add_theme_support( 'custom-background' );

	/**
	 * Enable editor style
	 */
	add_editor_style();

	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'publish' ),
	) );

	/**
	 * Add support for the Aside Post Formats
	 */
	add_theme_support( 'post-formats', array( 'aside', 'link', 'gallery', 'status', 'quote', 'chat', 'image', 'video' ) );

	/**
	 * Add support for infinite scroll
	 * @since Publish 1.2, Jetpack 2.0
	 */
	add_theme_support( 'infinite-scroll', array(
		'container' => 'content',
		'footer' => 'page',
	) );
}
endif; // publish_setup
add_action( 'after_setup_theme', 'publish_setup' );

/**
 * Register widgetized area and update sidebar with default widgets
 *
 * @since Publish 1.0
 */
function publish_widgets_init() {
	register_sidebar( array(
		'name' => __( 'Sidebar', 'publish' ),
		'id' => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h1 class="widget-title">',
		'after_title' => '</h1>',
	) );
}
add_action( 'widgets_init', 'publish_widgets_init' );

/**
 * Enqueue scripts and styles
 */
function publish_scripts() {
	global $post;

	wp_enqueue_style( 'style', add_query_arg( 'v', 2, get_stylesheet_uri() ) );

	wp_enqueue_script( 'small-menu', get_template_directory_uri() . '/js/small-menu.js', array( 'jquery' ), '20120206', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image( $post->ID ) ) {
		wp_enqueue_script( 'keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
	}
}
add_action( 'wp_enqueue_scripts', 'publish_scripts' );

/**
 * Footer credits, with support for infinite scroll.
 *
 * @since Publish 1.2
 */
function publish_footer_credits() {
	echo get_publish_footer_credits();
}

function get_publish_footer_credits( $credits = '' ) {
	$credits = sprintf( __( 'Powered by %s', 'publish' ), '<a href="http://wordpress.org/" rel="generator">WordPress</a>' );
        $credits .= '<span class="sep"> | </span>';
        $credits .= sprintf( __( 'Theme: %1$s by %2$s.', 'publish' ), 'Publish', '<a href="http://kovshenin.com/" rel="designer">Konstantin Kovshenin</a>' );
	return $credits;
}
add_filter( 'infinite_scroll_credit', 'get_publish_footer_credits' );
add_action( 'publish_credits', 'publish_footer_credits' );

/**
 * Get Publish Logo (pluggable)
 *
 * Returns the markup for the theme logo, displayed in the
 * top-left area. Somewhat similar to get_avatar().
 *
 * @since Publish 1.2.2
 */
if ( ! function_exists( 'get_publish_logo' ) ) :
function get_publish_logo() {
	$email = get_option( 'admin_email' );
	$size = apply_filters( 'publish_logo_size', 100 );
	$alt = get_bloginfo( 'name' );

	$url = ( is_ssl() ) ? 'https://secure.gravatar.com' : 'http://gravatar.com';
	$url .= sprintf( '/avatar/%s/', md5( $email ) );
	$url = add_query_arg( 's', absint( $size ), $url );
	$url = add_query_arg( 'd', 'mm', $url ); // Mystery man default

	// Allow hard-core devs to use their own URL.
	$url = apply_filters( 'publish_logo_url', $url, $alt, $size );

	return sprintf( '<img src="%s" alt="%s" width="%d" height="%d" class="no-grav">', esc_url( $url ), esc_attr( $alt ), absint( $size ), absint( $size ) );
}
endif; // function_exists