<?php
/**
 * Understrap Child Theme functions and definitions
 *
 * @package UnderstrapChild
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;


if ( !defined( 'SCRIPT_DEBUG' ) ) {
	define( 'SCRIPT_DEBUG', is_local() );
}

if ( !defined( 'THEME_URL' ) ) {
	define( 'THEME_URL', get_stylesheet_directory_uri() );
}


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
	