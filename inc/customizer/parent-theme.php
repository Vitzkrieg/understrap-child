<?php

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Remove Bootstrap option
$wp_customize->remove_control('understrap_bootstrap_version');

// Remove Footer Site Info Override
$wp_customize->remove_control('understrap_site_info_override');
