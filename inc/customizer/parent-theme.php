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

// Remove Bootstrap option
$wp_customize->remove_control('understrap_bootstrap_version');

// Remove Footer Site Info Override
$wp_customize->remove_control('understrap_site_info_override');
