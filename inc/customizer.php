<?php

/**
 * In Harmony Theme Customizer
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;


// Import parent customizer settings
require get_parent_theme_file_path( '/inc/customizer.php' );



$defaults = array(
	'default-image'          => '',
	'width'                  => 2000,
	'height'                 => 800,
	'flex-height'            => true,
	'flex-width'             => true,
	'uploads'                => true,
	'random-default'         => false,
	'header-text'            => true,
	'default-text-color'     => '',
	'wp-head-callback'       => '',
	'admin-head-callback'    => '',
	'admin-preview-callback' => '',
);
add_theme_support( 'custom-header', $defaults );




/**
 * Select sanitization function
 *
 * @param string               $input   Slug to sanitize.
 * @param WP_Customize_Setting $setting Setting instance.
 * @return string Sanitized slug if it is a valid choice; otherwise, the setting default.
 */
function inharmony_theme_slug_sanitize_select( $input, $setting ) {

    // Ensure input is a slug (lowercase alphanumeric characters, dashes and underscores are allowed only).
    $input = sanitize_key( $input );

    // Get the list of possible select options.
    $choices = $setting->manager->get_control( $setting->id )->choices;

    // If the input is a valid key, return it; otherwise, return the default.
    return ( array_key_exists( $input, $choices ) ? $input : $setting->default );

}


function inharmony_customizer_options( $wp_customize ) {

    $inharmonylife_customizer_dir = 'customizer/';

    // Include files.
    foreach ( glob( dirname( __FILE__ ) . '/' . $inharmonylife_customizer_dir . '*.php' ) as $file ) {
        require_once $file;
    }

}

add_action('customize_register','inharmony_customizer_options');