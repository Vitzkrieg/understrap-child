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


inharmony_add_select_setting($section,
    'inharmony_post_title_decoration',
    'none',
    'Post Title Transformation',
    'How the Post title gets displayed across the site.',
    array(
        'none'          => 'None',
        'capitalize'    => 'Capitalize',
        'uppercase'     => 'UPPERCASE',
        'lowercase'     => "lowercase"
    )
);

inharmony_add_number_setting($section,
    'inharmony_post_list_count',
    6,
    'Posts Per Page Count',
    'How many Posts to display per page.'
);