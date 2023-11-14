<?php

$section = 'static_front_page';

$wp_customize->add_setting(
    'inharmony_home_hide_header',
    array(
        'default'           => '0',
        'type'              => 'theme_mod',
        'sanitize_callback' => 'wp_kses_post',
        'capability'        => 'edit_theme_options',
    )
);

$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'inharmony_home_hide_header',
        array(
            'label'       => __( 'Hide Header on Homepage', 'inharmonylife' ),
            'section'     => $section,
            'settings'    => 'inharmony_home_hide_header',
            'type'        => 'checkbox',
            'priority'    => 20,
        )
    )
);