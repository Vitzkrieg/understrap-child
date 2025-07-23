<?php

/**
 * This file is used to enqueue the child theme's styles and scripts.
 *
 * @package UnderstrapChild
 */
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// define constants
define( 'IHL_VERSION', '0.2.0' );
// server filesystem directory
define( 'IHL_DIR', get_stylesheet_directory() );
// web frontend directory
define( 'IHL_URL', get_stylesheet_directory_uri() );
// js directory
define( 'IHL_JS_DIR', IHL_URL . '/js' );
// css directory
define( 'IHL_CSS_DIR', IHL_URL . '/css' );



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
	
	/* move jQuery to footer */
	remove_action('wp_head', 'wp_print_scripts');
    remove_action('wp_head', 'wp_print_head_scripts', 9);
    remove_action('wp_head', 'wp_enqueue_scripts', 1);
    add_action('wp_footer', 'wp_print_scripts', 5);
    add_action('wp_footer', 'wp_print_head_scripts', 5);
    add_action('wp_footer', 'wp_enqueue_scripts', 5);

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
	
	$cp_count = 6;
	$cp_index = 1;

	while ( $cp_index <= $cp_count ) {
		$cp_color = get_theme_mod( 'inharmony_color_picker_' . $cp_index, '');
		if ( !empty( $cp_color) && !in_array($cp_color, $colors) ) $colors[] = $cp_color;
		$cp_index++;
	}

	if ( count($colors) < 8) {
		$colors[] = '#333';
	}
	if ( count($colors) < 8) {
		$colors[] = '#fafafa';
	}

	wp_localize_script( 'customize-preview', 'ihl_admin', array(
		'colors' => $colors
	));


	wp_enqueue_script( 'ihl-admin', IHL_JS_DIR.'/admin.js', array(), '0.1.0' );
	wp_enqueue_style( 'ihl-admin-stylesheet', IHL_CSS_DIR.'/admin.min.css', array(), '0.1.0' );
}
add_action( 'admin_enqueue_scripts', 'inharmony_admin_enqueue_scripts' );


add_action( 'wp_head', function() {
	$path = IHK_URL . "/framework/fonts/line-awesome/fonts/la-regular-400.woff2";
	echo "<link as='font' rel='preload' type='font/woff2' href='" . $path . "'>";
	$path = IHK_URL . "/framework/fonts/line-awesome/fonts/la-solid-900.woff2";
	echo "<link as='font' rel='preload' type='font/woff2' href='" . $path . "'>";
} );


function preload_filter( $html, $handle ) {
	// Add the preload attribute
	$html = str_replace( "rel='stylesheet", "rel='preload stylesheet' as='style", $html );

	return $html;
}
add_filter( 'style_loader_tag', 'preload_filter', 10, 2 );