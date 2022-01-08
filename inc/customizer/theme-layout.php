<?php
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$wp_customize->add_setting(
    'inharmony_header_container_type',
    array(
        'default'           => 'container',
        'type'              => 'theme_mod',
        'sanitize_callback' => 'understrap_theme_slug_sanitize_select',
        'capability'        => 'edit_theme_options',
    )
);

$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'inharmony_header_container_type',
        array(
            'label'       => __( 'Header Container Width', 'understrap' ),
            'description' => __( 'Choose between Bootstrap\'s container and container-fluid', 'understrap' ),
            'section'     => 'understrap_theme_layout_options',
            'settings'    => 'inharmony_header_container_type',
            'type'        => 'select',
            'choices'     => array(
                'container'       => __( 'Fixed width container', 'understrap' ),
                'container-fluid' => __( 'Full width container', 'understrap' ),
            ),
            'priority'    => apply_filters( 'inharmony_header_container_type_priority', 10 ),
        )
    )
);

$wp_customize->add_setting(
    'inharmony_header_menu_container_type',
    array(
        'default'           => 'container',
        'type'              => 'theme_mod',
        'sanitize_callback' => 'understrap_theme_slug_sanitize_select',
        'capability'        => 'edit_theme_options',
    )
);

$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'inharmony_header_menu_container_type',
        array(
            'label'       => __( 'Header Menu Container Width', 'understrap' ),
            'description' => __( 'Choose between Bootstrap\'s container and container-fluid', 'understrap' ),
            'section'     => 'understrap_theme_layout_options',
            'settings'    => 'inharmony_header_menu_container_type',
            'type'        => 'select',
            'choices'     => array(
                'container'       => __( 'Fixed width container', 'understrap' ),
                'container-fluid' => __( 'Full width container', 'understrap' ),
            ),
            'priority'    => apply_filters( 'inharmony_header_menu_container_type_priority', 10 ),
        )
    )
);