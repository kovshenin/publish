<?php

if ( ! isset( $content_width ) ) {
	$content_width = 580;
}

class Publish_Theme {
	var $options = array();
	var $defaults = array();

	// Runs during after_setup_theme
	function __construct() {

		$this->defaults = array(
			'footer-note' => __( 'This is a footer note which you can easily edit through the Theme Options in Appearance in your admin panel. A copyright notice or a short about me note will do fine.', 'publish' ),
			'custom-css' => '',
			'display-author' => true,
			'display-tags' => true,
			'display-categories' => true
		);
		$this->load_options();

		// Localization
		load_theme_textdomain( 'publish', TEMPLATEPATH . '/languages' );

		$locale = get_locale();
		$locale_file = TEMPLATEPATH . "/languages/$locale.php";
		if ( is_readable( $locale_file ) )
			require_once( $locale_file );

		add_editor_style();
		register_nav_menu( 'primary', __( 'Primary Menu', 'publish' ) );
		add_theme_support( 'post-formats', array( 'aside', 'link', 'gallery', 'status', 'quote', 'image', 'video' ) );
		add_custom_background();
		add_theme_support( 'automatic-feed-links' );

		add_action( 'admin_init', array( &$this, 'register_admin_settings' ) );
		add_action( 'admin_menu', array( &$this, 'add_admin_options' ) );
		add_action( 'wp_head', array( &$this, 'custom_css' ) );
		add_filter( 'the_title', array( &$this, 'the_title' ) );
	}

	public function the_title( $title ) {

		if ( strlen( trim( $title ) ) < 1 ) {
			$words = preg_split( "/[\n\r\t ]+/", get_the_excerpt(), 15, PREG_SPLIT_NO_EMPTY );
			array_pop( $words );
			$title = implode( ' ', $words ) . ' ...';
		}

		return $title;
	}

	public function load_options() {
		$this->options = (array) get_option( 'publish-theme-options' );
		$this->options = array_merge( $this->defaults, $this->options );
	}

	function update_options() {
		return update_option( 'publish-theme-options', $this->options );
	}

	/*
	 * Register Settings
	 *
	 * Fired during admin_init, this function registers the settings used
	 * in the Theme options section, as well as attaches a validator to
	 * clean up the icoming data.
	 *
	 */
	function register_admin_settings() {
		register_setting( 'publish-theme-options', 'publish-theme-options', array( &$this, 'validate_options' ) );

		// Settings fields and sections
		add_settings_section( 'section_general', __( 'General Settings', 'publish' ), array( &$this, 'section_general' ), 'publish-theme-options' );
		add_settings_field( 'footer-note', __( 'Footer Note', 'publish' ), array( &$this, 'setting_footer_note' ), 'publish-theme-options', 'section_general' );
		add_settings_field( 'custom-css', __( 'Custom CSS', 'publish' ), array( &$this, 'setting_custom_css' ), 'publish-theme-options', 'section_general' );
		add_settings_field( 'display-author', __( 'Display Author', 'publish' ), array( &$this, 'setting_display_author' ), 'publish-theme-options', 'section_general' );
		add_settings_field( 'display-tags', __( 'Display Tags', 'publish' ), array( &$this, 'setting_display_tags' ), 'publish-theme-options', 'section_general' );
		add_settings_field( 'display-categories', __( 'Display Categories', 'publish' ), array( &$this, 'setting_display_categories' ), 'publish-theme-options', 'section_general' );

		do_action( 'publish_register_admin_settings' );
	}

	function section_general() {
		_e( 'These settings affect the general look of your theme.', 'sanfran' );
	}

	function setting_footer_note() {
	?>
		<textarea rows="5" class="large-text code" name="publish-theme-options[footer-note]"><?php echo esc_textarea( $this->options['footer-note'] ); ?></textarea><br />
		<span class="description"><?php _e( 'This is the text that appears at the bottom of every page.', 'publish' ); ?></span>
	<?php
	}

	 function setting_custom_css() {
	 ?>
		<textarea rows="5" class="large-text code" name="publish-theme-options[custom-css]"><?php echo esc_textarea( $this->options['custom-css'] ); ?></textarea><br />
		<span class="description"><?php _e( 'Custom stylesheets are included in the head section after all the theme stylesheets are loaded.', 'publish' ); ?></span>
	<?php
	}

	function setting_display_author() {
	?>
		<label for="display-author">
			<input type="checkbox" id="display-author" name="publish-theme-options[display-author]" <?php checked( $this->options['display-author'] ); ?> value="1" />
			Display author name in the post meta
		</label>
	<?php
	}

	function setting_display_tags() {
	?>
		<label for="display-tags">
			<input type="checkbox" id="display-tags" name="publish-theme-options[display-tags]" <?php checked( $this->options['display-tags'] ); ?> value="1" />
			Display tags at the end of each post
		</label>
	<?php
	}

	function setting_display_categories() {
	?>
		<label for="display-categories">
			<input type="checkbox" id="display-categories" name="publish-theme-options[display-categories]" <?php checked( $this->options['display-categories'] ); ?> value="1" />
			Display categories at the end of each post
		</label>
	<?php
	}



	/*
	 * Options Validation
	 *
	 * This function is used to validate the incoming options, mostly from
	 * the Theme Options admin page. We make sure that the 'activated' array
	 * is untouched and then verify the rest of the options.
	 *
	 */
	function validate_options($options) {

		$options['footer-note'] = trim( strip_tags( $options['footer-note'], '<a><b><strong><em><ol><li><div><span>' ) );
		$options['custom-css'] = trim( strip_tags( $options['custom-css'] ) );
		$options['display-author'] = isset( $options['display-author'] ) && $options['display-author'] == 1 ? true : false;
		$options['display-tags'] = isset( $options['display-tags'] ) && $options['display-tags'] == 1 ? true : false;
		$options['display-categories'] = isset( $options['display-categories'] ) && $options['display-categories'] == 1 ? true : false;

		return $options;
	}

	/*
	 * Add Menu Options
	 *
	 * Registers a Theme Options page that appears under the Appearance
	 * menu in the WordPress dashboard. Uses the theme_options to render
	 * the page contents, requires edit_theme_options capabilities.
	 *
	 */
	function add_admin_options() {
		add_theme_page( __( 'Theme Options', 'publish' ), __('Theme Options', 'publish' ), 'edit_theme_options', 'publish-theme-options', array( &$this, 'theme_options' ) );
	}

	function theme_options() {
	?>
	<div class="wrap">
		<?php screen_icon(); ?>
		<h2><?php _e( 'Publish Theme Options', 'publish' ); ?></h2>

		<form method="post" action="options.php">
			<?php wp_nonce_field( 'update-options' ); ?>
			<?php settings_fields( 'publish-theme-options' ); ?>
			<?php do_settings_sections( 'publish-theme-options' ); ?>
			<?php submit_button(); ?>
		</form>
	</div>
	<?php
	}

	function custom_css() {
		if ( isset( $this->options['custom-css'] ) && strlen( $this->options['custom-css'] ) )
			echo "<style>\n" . $this->options['custom-css'] . "\n</style>\n";
	}

	// The time difference X ago
	public function get_the_time_diff( $from = false ) {
		if ( $from === false ) $from = get_the_time( 'U' );
		$diff = (int) abs( current_time( 'timestamp' ) - $from );

		$year 	= 29030400;
		$month 	= 2419200;
   		$week 	= 604800;
		$day 	= 86400;
 		$hour 	= 3600;
 		$minute = 60;
 		$second = 1;

		if ( $diff <= $hour ) {
			$minutes = round( $diff / $minute );
			return sprintf( _n( '%s minute ago', '%s minutes ago', $minutes, 'publish' ), $minutes );

		} elseif ( $diff <= $day && $diff > $hour ) {
			$hours = round( $diff / $hour );
			return sprintf( _n( '%s hour ago', '%s hours ago', $hours, 'publish' ), $hours );

		} elseif ( $diff <= $week && $diff > $day ) {
			$days = round( $diff / $day );
			return sprintf( _n( '%s day ago', '%s days ago', $days, 'publish' ), $days );

		} elseif ( $diff <= $month && $diff > $week ) {
			$weeks = round( $diff / $week );
			return sprintf( _n( '%s week ago', '%s weeks ago', $weeks, 'publish' ), $weeks );

		} elseif ( $diff <= $year && $diff > $month ) {
			$months = round( $diff / $month );
			return sprintf( _n( '%s month ago', '%s months ago', $months, 'publish' ), $months );

		} elseif ( $diff > $year ) {
			$years = round( $diff / $year );
			return sprintf( _n( '%s year ago', '%s years ago', $years, 'publish' ), $years );
		}
	}

	public function the_time_diff( $from = false ) {
		echo $this->get_the_time_diff( $from );
	}


	/* Randomizes the blog description, probably best done via a hook instead */
	public function random_description() {

		$descriptions = array_fill( 0, 15, get_bloginfo( 'description' ) );

		$descriptions []= '01100011 01101111 01100100 01100101';
		$descriptions []= 'int 0x80';
		$descriptions []= '#define TRUE 1';
		$descriptions []= '\' OR 1=1; --';
		$descriptions []= '0xfffffff0';

		return $descriptions[array_rand($descriptions)];
	}
};

add_action( 'after_setup_theme', create_function( '', 'global $publish; $publish = new Publish_Theme;' ) );
