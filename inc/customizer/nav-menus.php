<?php

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;


//$section = 'nav_menus'; //doesn't work
$section = 'understrap_theme_layout_options';

inharmony_add_select_setting($section,
    'inharmony_logo_placement',
    'left',
    'Logo Placement',
    '',
    array(
        'left'      => __( 'Left', 'inharmonylife' ),
        'center'    => __( 'Center', 'inharmonylife' ),
        'right'     => __( 'Right', 'inharmonylife' ),
        'above'     => __( 'Above', 'inharmonylife' ),
    )
);

inharmony_add_select_setting($section,
    'inharmony_menu_align',
    'center',
    'Menu Alignment',
    '',
    array(
        'left'      => __( 'Left', 'inharmonylife' ),
        'center'    => __( 'Center', 'inharmonylife' ),
        'right'     => __( 'Right', 'inharmonylife' ),
    )
);

inharmony_add_checkbox_setting($section,
    'inharmony_header_show_widgets',
    '1',
    'Show Widgets',
    ''
);
