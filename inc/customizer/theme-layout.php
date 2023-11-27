<?php

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;


$section = 'understrap_theme_layout_options';

inharmony_add_select_setting($section,
    'inharmony_header_container_type',
    'container',
    'Header Container Width',
    'Choose between Bootstrap\'s container and container-fluid',
    $bs_container_choices
);
inharmony_add_select_setting($section,
    'inharmony_header_menu_container_type',
    'container',
    'Header Menu Container Width',
    'Choose between Bootstrap\'s container and container-fluid',
    $bs_container_choices
);

inharmony_add_select_setting($section,
    'inharmony_header_menu_layout_desktop',
    'row-end',
    'Header Menu Layout - Desktop',
    'How to layout the header menu and widget area on desktop.',
    $bs_flex_choices
);
inharmony_add_select_setting($section,
    'inharmony_header_menu_layout_mobile',
    'row-center',
    'Header Menu Layout - Mobile',
    'How to layout the header menu and widget area on mobile.',
    $bs_flex_choices
);


