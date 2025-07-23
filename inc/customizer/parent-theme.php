<?php

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Overrides the theme_mod to default to Bootstrap 5
 *
 * This function uses the `theme_mod_{$name}` hook and
 * can be duplicated to override other theme settings.
 *
 * @return string
 */
function inharmony_default_bootstrap_version() {
	return 'bootstrap5';
}
add_filter( 'theme_mod_understrap_bootstrap_version', 'inharmony_default_bootstrap_version', 20 );

if ( !is_admin() ) {
	global $inharmony_container_type;
	$inharmony_container_type = get_theme_mod( 'inharmony_container_type', 'container-xl' );
	function inharmony_default_container_type() {
		global $inharmony_container_type;
		return $inharmony_container_type;
	}
	add_filter( 'theme_mod_inharmony_container_type', 'inharmony_default_container_type', 20 );
}

// Remove Bootstrap option
$wp_customize->remove_control('understrap_bootstrap_version');

// Remove Container option
$wp_customize->remove_control('understrap_container_type');

// Remove Footer Site Info Override
$wp_customize->remove_control('understrap_site_info_override');
