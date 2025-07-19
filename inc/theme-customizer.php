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


//Change the Customizer color palette presets
function inharmony_customize_controls() {
?>
	<script>
		function update_iris($) {
			var $pickers = $('.wp-picker-container .color-picker-hex');
			// check if iris is initialized
			try {
				$($pickers[0]).iris('option', 'width');
			} catch (e) {
				setTimeout( function() { update_iris($); }, 250 );
				return;
			}
	
			$pickers.iris('option', 'palettes', ihl_admin['colors']);
		}
	
		jQuery(document).ready(function($){
			update_iris($);
		});
	</script>
<?php
}
add_action('customize_controls_print_footer_scripts', 'inharmony_customize_controls');



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
	$primary_rgb = inharmony_HexToRGB( $primary_hex );
	$secondary_hex = get_theme_mod( 'inharmony_color_secondary', '#82b3b4');
	$secondary_rgb = inharmony_HexToRGB( $secondary_hex );
	$body_hex = get_theme_mod( 'inharmony_color_body', '#333');
	$title_hex = get_theme_mod( 'inharmony_color_title', '#333');
	// Link colors
	$link_hex = get_theme_mod( 'inharmony_color_links', '#78939e');
	$link_rgb = inharmony_HexToRGB( $link_hex );
	// Button colors
	$button_text_hex = get_theme_mod( 'inharmony_color_buttons_text', '#fff');
	$button_bg_hex = get_theme_mod( 'inharmony_color_buttons_bg', '#82b3b4');
	$button_bg_rgb = inharmony_HexToRGB( $button_bg_hex );
	$button_bg_hover_hex = get_theme_mod( 'inharmony_color_buttons_bg_hover', '#82b3b4');
	$button_bg_hover_rgb = inharmony_HexToRGB( $button_bg_hover_hex );
	$button_border_radius = get_theme_mod( 'inharmony_button_border_radius', '375rem') ?: '375rem';
	// Navigation colors
	$nav_link_color = get_theme_mod( 'inharmony_nav_link_color', '#333');
	$nav_link_hover_color = get_theme_mod( 'inharmony_nav_link_hover_color', '#82b3b4');

	echo "<style id='inharmony-theme-css' type='text/css'>";
	echo ":root {";
		echo "--bs-primary: $primary_hex !important;";
		echo "--bs-primary-rgb: $primary_rgb !important;";
		echo "--bs-secondary: $secondary_hex !important;";
		echo "--bs-secondary-rgb: $secondary_rgb !important;";
		echo "--bs-navbar-color: $nav_link_color !important;";
		echo "--bs-navbar-hover-color: $nav_link_hover_color !important;";
		echo "--bs-nav-link-color: $nav_link_color !important;";
		echo "--bs-headings-color: $title_hex !important;";
		echo "--bs-body-color: $body_hex !important;";
		echo "--bs-link-color: $link_hex !important;";
		echo "--bs-link-color-rgb: $link_rgb !important;";
		echo "--bs-btn-color: $button_text_hex !important;";
		echo "--bs-button-color: $button_bg_hex !important;";
		echo "--bs-button-color-rgb: $button_bg_rgb !important;";
		echo "--bs-button-color-hover: $button_bg_hover_hex !important;";
		echo "--bs-button-color-hover-rgb: $button_bg_hover_rgb !important;";
		echo "--tec-color-button-primary: $button_bg_hex !important;";
		echo "--tec-color-button-primary-hover: $button_bg_hex !important;";
	echo "}";
	echo ".btn {";
		echo "--bs-btn-border-radius: $button_border_radius !important;";
	echo "}";
	echo ".navbar-nav {";
		echo "--bs-nav-link-color: $nav_link_color !important;";
		echo "--bs-nav-link-hover-color: $nav_link_hover_color !important;";
		echo "--bs-navbar-toggler-border-radius: $button_border_radius !important;";
	echo "}";
	echo "</style>";
}

add_action('wp_head', 'inharmony_custom_colors', 100);

function inharmony_menu_classes($classes, $item, $args, $depth) {

  if ( $args->theme_location == 'primary' ) {
	if ( $depth == 0 ) {
		$px_md = get_theme_mod('inharmony_menu_item_margin_medium', '2');
		$px_lg = get_theme_mod('inharmony_menu_item_margin_large', '3');
		$classes[] = 'px-md-' . $px_md . ' px-lg-' . $px_lg;
	}
  }
  return $classes;
}
add_filter('nav_menu_css_class', 'inharmony_menu_classes', 1, 4);