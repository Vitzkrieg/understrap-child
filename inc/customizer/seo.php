<?php

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;


$section = 'inharmony_seo_options';

// Blog layout settings.
$wp_customize->add_section(
    $section,
    array(
        'title'       => __( 'SEO Settings', 'inharmony' ),
        'capability'  => 'edit_theme_options',
        'description' => __( 'Meta data options for the site', 'inharmony' ),
        'priority'    => apply_filters( $section . '_priority', 170 ),
        'panel'       => 'inharmony',
    )
);


inharmony_add_text_setting($section,
    "inharmony_open_graph_type",
    "website",
    "",
    "Open Graph Type",
    "<a href='https://ogp.me/#types' target='_blank'>https://ogp.me/#types</a>",
    array(
        'placeholder' => 'website',
    )
);

inharmony_add_text_setting($section,
    "inharmony_twitter_handle",
    "",
    "",
    "Twitter Handle",
);

inharmony_add_select_setting($section,
    'inharmony_twitter_card',
    'summary_large_image',
    'Twitter Card Type',
    'How the site displays on Twitter',
    array(
        'summary_large_image'   => __( 'Summary Large Image', 'inharmonylife' ),
        'summary'               => __( 'Summary', 'inharmonylife' ),
    )
);

inharmony_add_cropped_image_setting($section,
    'inharmony_twitter_image',
    '',
    'Twitter Image',
    '1:1 ratio, max 5MB',
    512,
    512,
    true,
    true,
    'inharmony_show_twitter_image'
);

function inharmony_show_twitter_image() {
    return get_theme_mod( 'inharmony_twitter_card', 'summary_large_image' ) == 'summary';
}

inharmony_add_cropped_image_setting($section,
    'inharmony_twitter_image_large',
    '',
    'Default Twitter Image Large',
    '2:1 ratio, max 5MB',
    1024,
    512,
    true,
    true,
    'inharmony_show_twitter_image_large'
);

function inharmony_show_twitter_image_large() {
    return get_theme_mod( 'inharmony_twitter_card', 'summary_large_image' ) == 'summary_large_image';
}