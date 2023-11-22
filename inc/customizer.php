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


/**
 * Height sanitization function
 *
 * @param string               $input   Slug to sanitize.
 * @param WP_Customize_Setting $setting Setting instance.
 * @return string Sanitized slug if it is a valid choice; otherwise, the setting default.
 */
function inharmony_theme_slug_sanitize_height( $input, $setting ) {

    // Ensure input is a slug (lowercase alphanumeric characters, dashes and underscores are allowed only).
    $input = sanitize_key( $input );

    // If the input is a valid max-height value, return it; otherwise, return the default.
    return ( preg_match('/^(\d+)(px|vh|vw|em|rem)$/', $input ) ? $input : $setting->default );

}


/*
Title 					ID 					Priority (Order)
Site Title & Tagline 	title_tagline 						20
Colors 					colors 								40
Header Image 			header_image 						60
Background Image 		background_image 					80
Menus (Panel) 			nav_menus 							100
Widgets (Panel) 		widgets 							110
Static Front Page 		static_front_page 					120
default 													160
Theme Options			understrap_theme_layout_options		160
Additional CSS 			custom_css 							200
*/
function inharmony_customizer_options( $wp_customize ) {

    $inharmonylife_customizer_dir = 'customizer/';

    // Include files.
    foreach ( glob( dirname( __FILE__ ) . '/' . $inharmonylife_customizer_dir . '*.php' ) as $file ) {
        require_once $file;
    }

	unset($section);

}

add_action('customize_register','inharmony_customizer_options');



function inharmony_custom_colors() {
	$primary_hex = get_theme_mod( 'inharmony_color_primary', '#78939e');
	$primary_rgb = HexToRGB( $primary_hex );
	$secondary_hex = get_theme_mod( 'inharmony_color_secondary', '#82b3b4');
	$secondary_rgb = HexToRGB( $secondary_hex );
	$link_hex = get_theme_mod( 'inharmony_color_links', '#78939e');
	$link_rgb = HexToRGB( $link_hex );
	$button_hex = get_theme_mod( 'inharmony_color_buttons', '#82b3b4');
	$button_rgb = HexToRGB( $button_hex );
	$button_hover_hex = get_theme_mod( 'inharmony_color_buttons_hover', '#82b3b4');
	$button_hover_rgb = HexToRGB( $button_hex );

	echo "<style id='inharmony-theme-css' type='text/css'>";
	echo ":root {";
		echo "--bs-primary: $primary_hex !important;";
		echo "--bs-primary-rgb: $primary_rgb !important;";
		echo "--bs-secondary: $secondary_hex !important;";
		echo "--bs-secondary-rgb: $secondary_rgb !important;";
		echo "--bs-link-color: $link_hex !important;";
		echo "--bs-link-color-rgb: $link_rgb !important;";
		echo "--bs-button-color: $button_hex !important;";
		echo "--bs-button-color-rgb: $button_rgb !important;";
		echo "--bs-button-color-hover: $button_hover_hex !important;";
		echo "--bs-button-color-hover-rgb: $button_hover_rgb !important;";
		echo "--tec-color-button-primary: $button_hex !important;";
		echo "--tec-color-button-primary-hover: $button_hex !important;";
	echo "}";
	echo "</style>";
}

add_action('wp_head', 'inharmony_custom_colors');