<?php

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;


$section = 'understrap_theme_layout_options';

inharmony_add_select_setting($section,
    'inharmony_header_container_type',
    'container',
    'Header Container Width',
    'Choose between Bootstrap\'s container and container-fluid options',
    $bs_container_choices
);
inharmony_add_select_setting($section,
    'inharmony_header_menu_container_type',
    'container',
    'Header Menu Container Width',
    'Choose between Bootstrap\'s container and container-fluid options',
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
    true,
    'Show Widgets',
    ''
);


inharmony_add_checkbox_setting($section,
    'inharmony_enable_comments',
    false,
    'Enable Comments'
);


inharmony_add_checkbox_setting($section,
    'inharmony_hide_entry_header[all]',
    false,
    'Hide Titles Everywhere'
);
inharmony_add_checkbox_setting($section,
    'inharmony_hide_entry_header[pages]',
    false,
    'Hide Titles on Pages'
);
inharmony_add_checkbox_setting($section,
    'inharmony_hide_entry_header[posts]',
    false,
    'Hide Titles on Posts'
);
inharmony_add_checkbox_setting($section,
    'inharmony_hide_entry_header[blog]',
    false,
    'Hide Titles on Blog Page'
);
inharmony_add_checkbox_setting($section,
    'inharmony_hide_entry_header[frontpage]',
    false,
    'Hide Titles on Front Page'
);
inharmony_add_checkbox_setting($section,
    'inharmony_hide_entry_header[frontpageblog]',
    false,
    'Hide Titles on Front Blog Page'
);