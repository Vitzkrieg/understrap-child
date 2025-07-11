<?php

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;


$section = 'inharmony_blog_layout_options';

// Blog layout settings.
$wp_customize->add_section(
    $section,
    array(
        'title'       => __( 'Blog Layout Settings', 'inharmony' ),
        'capability'  => 'edit_theme_options',
        'description' => __( 'Container width and sidebar defaults', 'inharmony' ),
        'priority'    => apply_filters( $section . '_priority', 170 ),
    )
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
inharmony_add_checkbox_setting($section,
    'inharmony_post_list_ski_first',
    true,
    'Skip First Post When Loading More'
);


inharmony_add_select_setting($section,
    'inharmony_color_blog_buttons_text',
    'light',
    'Blog Button Text Color',
    '',
    $text_color_choices
);
inharmony_add_select_setting($section,
    'inharmony_color_blog_buttons_bg',
    $color_secondary,
    'Blog Button BG Color',
    '',
    $bg_color_choices
);


inharmony_add_checkbox_setting($section,
    'inharmony_post_single_display_excerpt',
    true,
    'Show Post Excerpt'
);
inharmony_add_checkbox_setting($section,
    'inharmony_post_single_display_read_time',
    true,
    'Show Post Read Time'
);


inharmony_add_checkbox_setting($section,
    'inharmony_auto_format_post',
    false,
    'Auto Format Posts'
);

inharmony_add_checkbox_setting($section,
    'inharmony_post_sticky_image',
    false,
    'Sticky Post Image',
    '',
    'inharmony_is_auto_format_post'
);

function inharmony_is_auto_format_post() {
    return get_theme_mod( 'inharmony_auto_format_post', true );
}


inharmony_add_select_setting($section,
    'inharmony_post_block_bg',
    'transparent',
    'Post Block BG Color',
    '',
    $bg_color_choices
);

inharmony_add_select_setting($section,
    'inharmony_post_block_bg_opacity',
    '100',
    'Post Block BG Opacity',
    '',
    $bg_opacity_choices
);

inharmony_add_select_setting($section,
    'inharmony_post_block_border_size',
    'primary',
    'Post Block Border Size',
    '',
    $bs_spacers
);

inharmony_add_select_setting($section,
    'inharmony_post_block_border_color',
    'primary',
    'Post Block Border Color',
    '',
    $bg_color_choices
);

inharmony_add_select_setting($section,
    'inharmony_post_block_color',
    'black',
    'Post Block Text Color',
    '',
    $text_color_choices
);

inharmony_add_select_setting($section,
    'inharmony_post_block_padding',
    '4',
    'Post Block Padding',
    '',
    $bs_spacers
);

inharmony_add_select_setting($section,
    'inharmony_post_block_border_radius',
    '0',
    'Post Block Corner Radius',
    '',
    $bs_spacers
);

inharmony_add_text_setting($section,
    'inharmony_post_block_image_height',
    '300px',
    'inharmony_theme_slug_sanitize_height',
    'Post Block Image Height',
    'Use px, em, rem for static height, vh or vw for responsive height.',
);