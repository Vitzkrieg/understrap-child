<?php
/**
 * IHK Child Theme Scripts and Styles
 *
 * @package ihk
 * @since 0.1.0
 */
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// define constants
define( 'IHK_VERSION', '0.2.2' );
// server filesystem directory
define( 'IHK_DIR', get_stylesheet_directory() );
// web frontend directory
define( 'IHK_URL', get_stylesheet_directory_uri() );
// js directory
define( 'IHK_JS_DIR', IHK_URL . '/dist/js' );
// css directory
define( 'IHK_CSS_DIR', IHK_URL . '/dist/css' );

function ihk_enqueue_scripts_styles()  
{
	// dequeue styles
	wp_dequeue_style( 'woocommerce-general' );
	wp_dequeue_style( 'woocommerce-layout' );
	wp_dequeue_style( 'woocommerce-smallscreen' );

	/* ------------------------------------------------------------------------ */
	/* Register Scripts */
	/* ------------------------------------------------------------------------ */
	wp_register_script( 'ihk', IHK_JS_DIR.'/ihk.min.js', array(), IHK_VERSION, true );

	// Replace MEP Calendar Script
	wp_dequeue_script( 'mep-calendar-scripts' );
	wp_register_script( 'ihk-calendar-scripts', IHK_JS_DIR.'/partial/calendar.js', array('jquery', 'mep-moment-js'), 1, true );

	wp_dequeue_style( 'line-awesome' );
	wp_enqueue_style( 'ihk-line-awesome', IHK_URL . '/framework/fonts/line-awesome/css/line-awesome.min.css', array(), '2.0', 'all' );
	/* ------------------------------------------------------------------------ */
	/* AJAX */
	/* ------------------------------------------------------------------------ */
}
add_action( 'wp_enqueue_scripts', 'ihk_enqueue_scripts_styles', 99 );



// if(!function_exists('malina_ihk_scripts_basic')){
// 	function malina_ihk_scripts_basic() { 
// 		if ( is_singular() ) { 
// 			wp_enqueue_script( 'comment-reply' ); 
// 		} 
// 		wp_enqueue_script('ihk', IHK_JS_DIR.'/ihk.min.js', array(), '0.1.0' );
// 	}
// 	add_action( 'wp_enqueue_scripts', 'malina_ihk_scripts_basic', 11 );
// }

// enqueuqe admin scripts
function ihk_enqueue_admin_scripts_styles() {
	wp_enqueue_script( 'ihk-admin', IHK_JS_DIR.'/ihk-admin.min.js', array(), '0.1.0' );

	wp_enqueue_style( 'child-admin-stylesheet', IHK_CSS_DIR.'/ihk-admin.min.css', array(), '0.1.0' );
}
add_action( 'admin_enqueue_scripts', 'ihk_enqueue_admin_scripts_styles' );

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