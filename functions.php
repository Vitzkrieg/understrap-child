<?php
/**
 * Understrap Child Theme functions and definitions
 *
 * @package UnderstrapChild
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

define('SCRIPT_DEBUG', true);



/**
 * Removes the parent themes stylesheet and scripts from inc/enqueue.php
 */
function understrap_remove_scripts() {
	wp_dequeue_style( 'understrap-styles' );
	wp_deregister_style( 'understrap-styles' );

	wp_dequeue_script( 'understrap-scripts' );
	wp_deregister_script( 'understrap-scripts' );
}
add_action( 'wp_enqueue_scripts', 'understrap_remove_scripts', 20 );



/**
 * Enqueue our stylesheet and javascript file
 */
function inharmony_enqueue_styles() {

	// Get the theme data.
	$the_theme     = wp_get_theme();
	$theme_version = $the_theme->get( 'Version' );

	$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
	$suffix = '';
	// Grab asset urls.
	$theme_styles  = "/css/child-theme{$suffix}.css";
	$theme_scripts = "/js/child-theme{$suffix}.js";
	
	$css_version = $theme_version . '.' . filemtime( get_stylesheet_directory() . $theme_styles );

	wp_enqueue_style( 'inharmony-styles', get_stylesheet_directory_uri() . $theme_styles, array(), $css_version );
	wp_enqueue_script( 'jquery' );
	
	$js_version = $theme_version . '.' . filemtime( get_stylesheet_directory() . $theme_scripts );
	
	wp_enqueue_script( 'inharmony-scripts', get_stylesheet_directory_uri() . $theme_scripts, array( 'jquery' ), $js_version, true );
	
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'inharmony_enqueue_styles' );

function inharmony_admin_enqueue_scripts() {

	$colors = array();
	$primary_hex = get_theme_mod( 'inharmony_color_primary', '#78939e');
	if ( !in_array($primary_hex, $colors) ) $colors[] = $primary_hex;
	$secondary_hex = get_theme_mod( 'inharmony_color_secondary', '#82b3b4');
	if ( !in_array($secondary_hex, $colors) ) $colors[] = $secondary_hex;
	$link_hex = get_theme_mod( 'inharmony_color_links', '#78939e');
	if ( !in_array($link_hex, $colors) ) $colors[] = $link_hex;
	$button_text_hex = get_theme_mod( 'inharmony_color_buttons_text', '#fff');
	if ( !in_array($button_text_hex, $colors) ) $colors[] = $button_text_hex;
	$button_bg_hex = get_theme_mod( 'inharmony_color_buttons_bg', '#82b3b4');
	if ( !in_array($button_bg_hex, $colors) ) $colors[] = $button_bg_hex;
	$button_bg_hover_hex = get_theme_mod( 'inharmony_color_buttons_bg_hover', '#82b3b4');
	if ( !in_array($button_bg_hover_hex, $colors) ) $colors[] = $button_bg_hover_hex;
	
	if ( count($colors) < 8) {
		$colors[] = '#fafafa';
	}
	if ( count($colors) < 8) {
		$colors[] = '#333';
	}

	wp_localize_script( 'inharmony-admin-scripts', 'ihl_admin', array(
		'colors' => $colors
	));
}
add_action( 'admin_enqueue_scripts', 'inharmony_admin_enqueue_scripts' );



/**
 * Load the child theme's text domain
 */
function add_child_theme_textdomain() {
    load_child_theme_textdomain( 'inharmonylife', get_stylesheet_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'add_child_theme_textdomain' );




// Include folder
$inharmonylife_inc_dir = 'inc/';


// Include files.
foreach ( glob( dirname( __FILE__ ) . '/' . $inharmonylife_inc_dir . '*.php' ) as $file ) {
	require_once $file;
}


/**
 * Overrides the theme_mod to default to Bootstrap 5
 *
 * This function uses the `theme_mod_{$name}` hook and
 * can be duplicated to override other theme settings.
 *
 * @return string
 */
function understrap_child_default_bootstrap_version() {
	return 'bootstrap5';
}
add_filter( 'theme_mod_understrap_bootstrap_version', 'understrap_child_default_bootstrap_version', 20 );



/**
 * Loads javascript for showing customizer warning dialog.
 */
function understrap_child_customize_controls_js() {
	wp_enqueue_script(
		'understrap_child_customizer',
		get_stylesheet_directory_uri() . '/js/customizer-controls.js',
		array( 'customize-preview' ),
		'20130508',
		true
	);
}
add_action( 'customize_controls_enqueue_scripts', 'understrap_child_customize_controls_js' );
