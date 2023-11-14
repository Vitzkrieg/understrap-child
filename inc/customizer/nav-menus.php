<?php

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;


//$section = 'nav_menus'; //doesn't work
$section = 'understrap_theme_layout_options';


$wp_customize->add_setting(
    'inharmony_logo_placement',
    array(
        'default'           => 'left',
        'type'              => 'theme_mod',
        'sanitize_callback' => 'inharmony_theme_slug_sanitize_select',
        'capability'        => 'edit_theme_options',
    )
);

$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'inharmony_logo_placement',
        array(
            'label'       => __( 'Logo Placement', 'inharmonylife' ),
            'section'     => $section,
            'settings'    => 'inharmony_logo_placement',
            'type'        => 'select',
            'choices'     => array(
                'left'     => __( 'Left', 'inharmonylife' ),
                'center'     => __( 'Center', 'inharmonylife' ),
                'right'    => __( 'Right', 'inharmonylife' ),
                'above'    => __( 'Above', 'inharmonylife' ),
            ),
            'priority'    => apply_filters( 'inharmony_logo_placement_priority', 100 ),
        )
    )
);

$wp_customize->add_setting(
    'inharmony_menu_align',
    array(
        'default'           => 'center',
        'type'              => 'theme_mod',
        'sanitize_callback' => 'inharmony_theme_slug_sanitize_select',
        'capability'        => 'edit_theme_options',
    )
);

$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'inharmony_menu_align',
        array(
            'label'       => __( 'Menu Alignment', 'inharmonylife' ),
            'section'     => $section,
            'settings'    => 'inharmony_menu_align',
            'type'        => 'select',
            'choices'     => array(
                'left'     => __( 'Left', 'inharmonylife' ),
                'center'     => __( 'Center', 'inharmonylife' ),
                'right'    => __( 'Right', 'inharmonylife' ),
            ),
            'priority'    => apply_filters( 'inharmony_menu_align_priority', 100 ),
        )
    )
);


$wp_customize->add_setting(
    'inharmony_header_show_widgets',
    array(
        'default'           => '1',
        'type'              => 'theme_mod',
        'sanitize_callback' => 'wp_kses_post',
        'capability'        => 'edit_theme_options',
    )
);

$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'inharmony_header_show_widgets',
        array(
            'label'       => __( 'Show Widgets', 'inharmonylife' ),
            'section'     => $section,
            'settings'    => 'inharmony_header_show_widgets',
            'type'        => 'checkbox',
            'priority'    => apply_filters( 'inharmony_header_show_widgets_priority', 100 ),
        )
    )
);