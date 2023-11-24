<?php


function inharmony_add_color_setting(string $section, string $setting, string $default, string $label) {
    global $wp_customize;

    $wp_customize->add_setting(
        $setting,
        array(
            'default'           => $default,
            'type'              => 'theme_mod',
            'sanitize_callback' => 'sanitize_hex_color',
            'capability'        => 'edit_theme_options',
        )
    );
    
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            $setting,
            array(
                'label'       => __( $label, 'inharmonylife' ),
                'section'     => $section,
                'settings'    => $setting,
                'priority'    => apply_filters( $setting . '_priority', 10 ),
            )
        )
    );

}



/**
 *  
 */
function inharmony_add_select_setting(string $section, string $setting, string $default, string $label, string $desc, array $choices) {
    global $wp_customize;

    $wp_customize->add_setting(
        $setting,
        array(
            'default'           => $default,
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
                'label'       => __( $label, 'inharmony' ),
                'description' => __( $desc, 'inharmony' ),
                'section'     => $section,
                'settings'    => $setting,
                'type'        => 'select',
                'choices'     => $choices,
                'priority'    => apply_filters( $setting . '_priority', 10 ),
            )
        )
    );
}