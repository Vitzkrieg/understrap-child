<?php

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;


$section = 'header_image';


$wp_customize->add_setting(
    'inharmony_header_placement',
    array(
        'default'           => 'above',
        'type'              => 'theme_mod',
        'sanitize_callback' => 'inharmony_theme_slug_sanitize_select',
        'capability'        => 'edit_theme_options',
    )
);

$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'inharmony_header_placement',
        array(
            'label'       => __( 'Header Placement', 'inharmonylife' ),
            'description' => __( 'Where to place the header image.', 'inharmonylife' ),
            'section'     => $section,
            'settings'    => 'inharmony_header_placement',
            'type'        => 'select',
            'choices'     => array(
                'above'     => __( 'Above header', 'inharmonylife' ),
                'below'     => __( 'Below header', 'inharmonylife' ),
                'behind'    => __( 'Behind header', 'inharmonylife' ),
            ),
            'priority'    => apply_filters( 'inharmony_header_placement_priority', 10 ),
        )
    )
);

$wp_customize->add_setting(
    'inharmony_header_image_size',
    array(
        'default'           => 'cover',
        'type'              => 'theme_mod',
        'sanitize_callback' => 'inharmony_theme_slug_sanitize_select',
        'capability'        => 'edit_theme_options',
    )
);

$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'inharmony_header_image_size',
        array(
            'label'       => __( 'Header Placement', 'inharmonylife' ),
            'description' => __( 'Where to place the header image.', 'inharmonylife' ),
            'section'     => $section,
            'settings'    => 'inharmony_header_image_size',
            'type'        => 'select',
            'choices'     => array(
                'cover'     => __( 'Fill Header', 'inharmonylife' ),
                'contain'     => __( 'Fit Image to Header', 'inharmonylife' ),
                'auto'    => __( 'Original Image Size', 'inharmonylife' ),
            ),
            'priority'    => apply_filters( 'inharmony_header_image_size_priority', 10 ),
        )
    )
);


$wp_customize->add_setting(
    'inharmony_header_show_title',
    array(
        'default'           => '',
        'type'              => 'theme_mod',
        'sanitize_callback' => 'wp_kses_post',
        'capability'        => 'edit_theme_options',
    )
);

$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'inharmony_header_show_title',
        array(
            'label'       => __( 'Show Site Title', 'inharmonylife' ),
            'section'     => $section,
            'settings'    => 'inharmony_header_show_title',
            'type'        => 'checkbox',
            'priority'    => 20,
        )
    )
);


$wp_customize->add_setting(
    'inharmony_header_show_tagline',
    array(
        'default'           => '',
        'type'              => 'theme_mod',
        'sanitize_callback' => 'wp_kses_post',
        'capability'        => 'edit_theme_options',
    )
);

$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'inharmony_header_show_tagline',
        array(
            'label'       => __( 'Show Site Tagline', 'inharmonylife' ),
            'section'     => $section,
            'settings'    => 'inharmony_header_show_tagline',
            'type'        => 'checkbox',
            'priority'    => 20,
        )
    )
);


$wp_customize->add_setting(
    'inharmony_header_custom_text',
    array(
        'default'           => '',
        'type'              => 'theme_mod',
        'sanitize_callback' => 'wp_kses_post',
        'capability'        => 'edit_theme_options',
    )
);

$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'inharmony_header_custom_text',
        array(
            'label'       => __( 'Custom Header Text', 'inharmonylife' ),
            'description' => __( 'Add custom text to the header.', 'inharmonylife' ),
            'section'     => $section,
            'settings'    => 'inharmony_header_custom_text',
            'type'        => 'textarea',
            'priority'    => 20,
        )
    )
);