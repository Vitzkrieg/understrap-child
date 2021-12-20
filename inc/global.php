<?php

if ( ! function_exists( 'ihl_site_info_content' ) ) {
	/**
	 * Replaces footer text
	 *
	 * @param string $site_info Markup.
	 *
	 * @return string
	 */
	function ihl_site_info_content( $site_info ) {
		
		// Check if customizer site info has value.
		if ( get_theme_mod( 'understrap_site_info_override' ) ) {
			return get_theme_mod( 'understrap_site_info_override' );
		}

		$name = esc_attr( get_bloginfo( 'name', 'display' ) );
		$year = date('Y');

		$left = '<span class="col-6 text-left">' . $name . ' &copy; ' . $year . '</span>';

		$right = '<span class="col-6 text-right">Site design by <a href="https://inharmonyarts.com" target="_blank">In Harmony Arts</a></span>';
		$site_info = '<div class="row">' . $left . $right . '</div>';

		return $site_info;
	}
}

// Filter custom logo with correct classes.
add_filter( 'understrap_site_info_content', 'ihl_site_info_content' );


if ( ! function_exists( 'ihl_theme_default_settings' ) ) {
	/**
	 * Override default theme settings
	 *
	 * @param array $settings
	 *
	 * @return string 
	 */
	function ihl_theme_default_settings( $settings ) {

		$settings['understrap_sidebar_position'] = 'none';

		return $settings;
	}
}

// Filter theme settings
add_filter( 'understrap_theme_default_settings', 'ihl_theme_default_settings', 10, 2 );


if ( ! function_exists( 'ihl_setup' ) ) {
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function ihl_setup() {
		register_nav_menus(
			array(
				'header' => __( 'Header Menu', 'inharmonylife' ),
			)
		);
	}
}

add_action( 'after_setup_theme', 'ihl_setup' );