<?php


$wp_customize->add_panel(
    'inharmony',
    array(
        'priority'       => 200,
        'capability'     => 'manage_theme',
        'theme_supports' => '',
        'title'          => __( 'In Harmony', 'inharmony' ),
    )
);