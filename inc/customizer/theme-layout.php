<?php

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;


$section = 'understrap_theme_layout_options';

inharmony_add_select_setting($section,
    'inharmony_container_type',
    'container',
    'Container Width',
    'Choose between Bootstrap\'s container and container-fluid options',
    $bs_container_choices
);

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
        'inline'      => __( 'Inline', 'inharmonylife' ),
        'above'     => __( 'Above', 'inharmonylife' ),
    )
);

inharmony_add_select_setting($section,
    'inharmony_logo_alignment',
    'left',
    'Logo Alignment',
    '',
    array(
        'flex-start'      => __( 'Left', 'inharmonylife' ),
        'center'          => __( 'Center', 'inharmonylife' ),
        'flex-end'        => __( 'Right', 'inharmonylife' ),
    )
);

inharmony_add_select_setting($section,
    'inharmony_logo_size_desktop',
    'md',
    'Logo Size',
    '',
    array_merge($bs_sizes , array(
        'custom' => __( 'Custom', 'inharmonylife' ),
    ))
);

inharmony_add_text_setting($section,
    'inharmony_logo_size_custom',
    '100px',
    'inharmony_theme_slug_sanitize_height',
    'Custom Logo Size',
    'Use px, em, rem for static size, vh or vw for responsive size.',
    'get_inharmony_logo_size_desktop',
);

function get_inharmony_logo_size_desktop() {
    return get_theme_mod('inharmony_logo_size_desktop') == 'custom';
}

inharmony_add_select_setting($section,
    'inharmony_logo_size_mobile',
    'left',
    'Logo Size - Mobile',
    '',
    $bs_sizes 
);

inharmony_add_select_setting($section,
    'inharmony_menu_align',
    'center',
    'Menu Alignment',
    '',
    $bs_flex_align
);

inharmony_add_select_setting($section,
    'inharmony_menu_item_margin_large',
    '3',
    'Menu Item Margin - Large',
    '',
    $bs_spacers
);

inharmony_add_select_setting($section,
    'inharmony_menu_item_margin_medium',
    '2',
    'Menu Item Margin - Medium',
    '',
    $bs_spacers
);

inharmony_add_select_setting($section,
    'inharmony_menu_margin_bottom_desktop',
    '4',
    'Menu Margin Bottom - Desktop',
    '',
    $bs_spacers
);

inharmony_add_select_setting($section,
    'inharmony_menu_margin_bottom_mobile',
    '2',
    'Menu Margin Bottom - Mobile',
    '',
    $bs_spacers
);

inharmony_add_checkbox_setting($section,
    'inharmony_header_show_widgets',
    true,
    'Show Widgets',
    ''
);

inharmony_add_checkbox_setting($section,
    'inharmony_header_shopping_cart',
    false,
    'Show Shopping Cart',
);

inharmony_add_checkbox_setting($section,
    'inharmony_header_search_button',
    false,
    'Show Search Button',
);


inharmony_add_checkbox_setting($section,
    'inharmony_enable_comments',
    false,
    'Enable Comments'
);


inharmony_add_select_setting($section,
    'inharmony_title_position',
    'article',
    'Title Position',
    '',
    array(
        'article'     => __( 'In Content', 'inharmonylife' ),
        'above'       => __( 'Above Content', 'inharmonylife' ),
    )
);


inharmony_add_checkbox_setting($section,
    'inharmony_hide_entry_header[all]',
    false,
    'Hide Titles Everywhere'
);

function get_inharmony_hide_entry_header_all() {
    return get_theme_mod('inharmony_hide_entry_header[all]', false);
}

inharmony_add_checkbox_setting($section,
    'inharmony_hide_entry_header[pages]',
    false,
    'Hide Titles on Pages',
    '',
    '',
    'get_inharmony_hide_entry_header_all'
);
inharmony_add_checkbox_setting($section,
    'inharmony_hide_entry_header[posts]',
    false,
    'Hide Titles on Posts',
    '',
    '',
    'get_inharmony_hide_entry_header_all'
);
inharmony_add_checkbox_setting($section,
    'inharmony_hide_entry_header[blog]',
    false,
    'Hide Titles on Blog Page',
    '',
    '',
    'get_inharmony_hide_entry_header_all'
);
inharmony_add_checkbox_setting($section,
    'inharmony_hide_entry_header[frontpage]',
    false,
    'Hide Titles on Front Page',
    '',
    '',
    'get_inharmony_hide_entry_header_all'
);
inharmony_add_checkbox_setting($section,
    'inharmony_hide_entry_header[frontpageblog]',
    false,
    'Hide Titles on Front Blog Page',
    '',
    '',
    'get_inharmony_hide_entry_header_all'
);

inharmony_add_select_setting($section,
    'inharmony_footer_widget_layout_direction',
    'center',
    'Footer Widget Layout Direction',
    '',
    array(
        'row'      => __( 'Row', 'inharmonylife' ),
        'column'   => __( 'Column', 'inharmonylife' ),
    )
);
