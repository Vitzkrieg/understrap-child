<?php

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;


$section = 'understrap_theme_layout_options';

$bs_container_choices = array(
    'container'       => __( 'Fixed width container', 'inharmony' ),
    'container-fluid' => __( 'Full width container', 'inharmony' ),
);

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

$bs_flex_choices = array(
    'row-center'                => __( 'Row Center', 'inharmony' ),
    'row-end'                   => __( 'Row End', 'inharmony' ),
    'row-start'                 => __( 'Row Start', 'inharmony' ),
    'row-between'               => __( 'Row Between', 'inharmony' ),
    'row-reverse-center'        => __( 'Row Reverse Center', 'inharmony' ),
    'row-reverse-end'           => __( 'Row Reverse End', 'inharmony' ),
    'row-reverse-start'         => __( 'Row Reverse Start', 'inharmony' ),
    'row-reverse-between'       => __( 'Row Reverse Between', 'inharmony' ),
    'column-center'             => __( 'Column Center', 'inharmony' ),
    'column-end'                => __( 'Column End', 'inharmony' ),
    'column-start'              => __( 'Column Start', 'inharmony' ),
    'column-reverse-center'     => __( 'Column Reverse Center', 'inharmony' ),
    'column-reverse-end'        => __( 'Column Reverse End', 'inharmony' ),
    'column-reverse-start'      => __( 'Column Reverse Start', 'inharmony' ),
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
