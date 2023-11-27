<?php

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
