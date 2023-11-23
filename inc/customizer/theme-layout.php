<?php

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;


$section = 'understrap_theme_layout_options';

$setting = 'inharmony_header_container_type';
$wp_customize->add_setting(
    $setting,
    array(
        'default'           => 'container',
        'type'              => 'theme_mod',
        'sanitize_callback' => 'understrap_customize_sanitize_select',
        'capability'        => 'edit_theme_options',
    )
);

$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        $setting,
        array(
            'label'       => __( 'Header Container Width', 'inharmony' ),
            'description' => __( 'Choose between Bootstrap\'s container and container-fluid', 'inharmony' ),
            'section'     => $section,
            'settings'    => $setting,
            'type'        => 'select',
            'choices'     => array(
                'container'       => __( 'Fixed width container', 'inharmony' ),
                'container-fluid' => __( 'Full width container', 'inharmony' ),
            ),
            'priority'    => apply_filters( $setting . '_priority', 10 ),
        )
    )
);

$setting = 'inharmony_header_menu_container_type';
$wp_customize->add_setting(
    $setting,
    array(
        'default'           => 'container',
        'type'              => 'theme_mod',
        'sanitize_callback' => 'understrap_customize_sanitize_select',
        'capability'        => 'edit_theme_options',
    )
);

$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        $setting,
        array(
            'label'       => __( 'Header Menu Container Width', 'inharmony' ),
            'description' => __( 'Choose between Bootstrap\'s container and container-fluid', 'inharmony' ),
            'section'     => $section,
            'settings'    => $setting,
            'type'        => 'select',
            'choices'     => array(
                'container'       => __( 'Fixed width container', 'inharmony' ),
                'container-fluid' => __( 'Full width container', 'inharmony' ),
            ),
            'priority'    => apply_filters( $setting . '_priority', 10 ),
        )
    )
);

// $wp_customize->add_setting(
//     'inharmony_fixed_width',
//     array(
//         'default'           => 'container',
//         'type'              => 'theme_mod',
//         'sanitize_callback' => 'understrap_customize_sanitize_select',
//         'capability'        => 'edit_theme_options',
//     )
// );

// $wp_customize->add_control(
//     new WP_Customize_Control(
//         $wp_customize,
//         'inharmony_fixed_width',
//         array(
//             'label'       => __( 'Header Menu Container Width', 'inharmony' ),
//             'description' => __( 'Choose between Bootstrap\'s container and container-fluid', 'inharmony' ),
//             'section'     => $section,
//             'settings'    => 'inharmony_fixed_width',
//             'type'        => 'select',
//             'choices'     => array(
//                 'container'       => __( 'Fixed width container', 'inharmony' ),
//                 'container-fluid' => __( 'Full width container', 'inharmony' ),
//             ),
//             'priority'    => apply_filters( 'inharmony_fixed_width_priority', 10 ),
//         )
//     )
// );

$bs_flex_choices = array(
    'row-center'                => __( 'Row Center', 'inharmony' ),
    'row-end'                   => __( 'Row End', 'inharmony' ),
    'row-start'                 => __( 'Row Start', 'inharmony' ),
    'row-between'               => __( 'Row Between', 'inharmony' ),
    'row-reverse-center'        => __( 'Row Reverse Center', 'inharmony' ),
    'row-reverse-end'           => __( 'Row Reverse End', 'inharmony' ),
    'row-reverse-start'         => __( 'Row Reverse Start', 'inharmony' ),
    'row-reverse-between'       => __( 'Row Reverse Between', 'inharmony' ),
    'column-center'             => __( 'Column Center', 'inharmony' ),
    'column-end'                => __( 'Column End', 'inharmony' ),
    'column-start'              => __( 'Column Start', 'inharmony' ),
    'column-reverse-center'     => __( 'Column Reverse Center', 'inharmony' ),
    'column-reverse-end'        => __( 'Column Reverse End', 'inharmony' ),
    'column-reverse-start'      => __( 'Column Reverse Start', 'inharmony' ),
); 

$setting = 'inharmony_header_menu_layout_desktop';
$wp_customize->add_setting(
    $setting,
    array(
        'default'           => 'row-end',
        'type'              => 'theme_mod',
        'sanitize_callback' => 'understrap_customize_sanitize_select',
        'capability'        => 'edit_theme_options',
    )
);

$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        $setting,
        array(
            'label'       => __( 'Header Menu Layout - Desktop', 'inharmony' ),
            'description' => __( 'How to layout the header menu and widget area on desktop.', 'inharmony' ),
            'section'     => $section,
            'settings'    => $setting,
            'type'        => 'select',
            'choices'     => $bs_flex_choices,
            'priority'    => apply_filters( $setting . '_priority', 10 ),
        )
    )
);

$setting = 'inharmony_header_menu_layout_mobile';
$wp_customize->add_setting(
    $setting,
    array(
        'default'           => 'row-center',
        'type'              => 'theme_mod',
        'sanitize_callback' => 'understrap_customize_sanitize_select',
        'capability'        => 'edit_theme_options',
    )
);

$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        $setting,
        array(
            'label'       => __( 'Header Menu Layout - Mobile', 'inharmony' ),
            'description' => __( 'How to layout the header menu and widget area on mobile.', 'inharmony' ),
            'section'     => $section,
            'settings'    => $setting,
            'type'        => 'select',
            'choices'     => $bs_flex_choices,
            'priority'    => apply_filters( $setting . '_priority', 10 ),
        )
    )
);