<?php

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;


$section = 'understrap_element_style_options';

// Element style settings.
$wp_customize->add_section(
    $section,
    array(
        'title'       => __( 'Element Style Settings', 'inharmony' ),
        'capability'  => 'edit_theme_options',
        'description' => __( 'Customize the styles for various elements.', 'inharmony' ),
        'priority'    => apply_filters( $section . '_priority', 170 ),
    )
);

inharmony_add_text_setting($section,
    'inharmony_button_border_radius',
    '375rem',
    'inharmony_theme_slug_sanitize_height',
    'Button Border Radius',
    'Use px, em, rem for static size, vh or vw for responsive size.',
);