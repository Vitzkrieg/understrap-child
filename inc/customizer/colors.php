<?php

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;



$wp_customize->add_setting(
    'inharmony_color_primary',
    array(
        'default'           => '#78939e',
        'type'              => 'theme_mod',
        'sanitize_callback' => 'sanitize_hex_color',
        'capability'        => 'edit_theme_options',
    )
);

$wp_customize->add_control(
    new WP_Customize_Color_Control(
        $wp_customize,
        'inharmony_color_primary',
        array(
            'label'       => __( 'Primary Color', 'inharmonylife' ),
            'description' => __( 'The dominant color of the theme', 'inharmonylife' ),
            'section'     => 'colors',
            'settings'    => 'inharmony_color_primary',
            'priority'    => apply_filters( 'inharmony_color_primary_priority', 10 ),
        )
    )
);

$wp_customize->add_setting(
    'inharmony_color_secondary',
    array(
        'default'           => '#82b3b4',
        'type'              => 'theme_mod',
        'sanitize_callback' => 'sanitize_hex_color',
        'capability'        => 'edit_theme_options',
    )
);

$wp_customize->add_control(
    new WP_Customize_Color_Control(
        $wp_customize,
        'inharmony_color_secondary',
        array(
            'label'       => __( 'Secondary Color', 'inharmonylife' ),
            'description' => __( 'The complimentary color of the theme', 'inharmonylife' ),
            'section'     => 'colors',
            'settings'    => 'inharmony_color_secondary',
            'priority'    => apply_filters( 'inharmony_color_secondary_priority', 10 ),
        )
    )
);

$wp_customize->add_setting(
    'inharmony_color_links',
    array(
        'default'           => '#78939e',
        'type'              => 'theme_mod',
        'sanitize_callback' => 'sanitize_hex_color',
        'capability'        => 'edit_theme_options',
    )
);

$wp_customize->add_control(
    new WP_Customize_Color_Control(
        $wp_customize,
        'inharmony_color_links',
        array(
            'label'       => __( 'Link Color', 'inharmonylife' ),
            'description' => __( 'The link color of the theme', 'inharmonylife' ),
            'section'     => 'colors',
            'settings'    => 'inharmony_color_links',
            'priority'    => apply_filters( 'inharmony_color_links_priority', 10 ),
        )
    )
);

$wp_customize->add_setting(
    'inharmony_color_buttons',
    array(
        'default'           => '#78939e',
        'type'              => 'theme_mod',
        'sanitize_callback' => 'sanitize_hex_color',
        'capability'        => 'edit_theme_options',
    )
);

$wp_customize->add_control(
    new WP_Customize_Color_Control(
        $wp_customize,
        'inharmony_color_buttons',
        array(
            'label'       => __( 'Button Color', 'inharmonylife' ),
            'description' => __( 'The button color of the theme', 'inharmonylife' ),
            'section'     => 'colors',
            'settings'    => 'inharmony_color_buttons',
            'priority'    => apply_filters( 'inharmony_color_buttons_priority', 10 ),
        )
    )
);

//TODO: secondary, links, headers, etc