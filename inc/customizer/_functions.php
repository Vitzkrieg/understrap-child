<?php

function inharmony_get_control_class($type) {
    $accepted_control_types = [
        'checkbox'	     => WP_Customize_Control::class,
        'color'		     => WP_Customize_Color_Control::class,
        'default'		 => WP_Customize_Control::class,
        'dropdown-pages' => WP_Customize_Control::class,
        // 'heading'		 => Heading::class,
        'image'		     => WP_Customize_Image_Control::class,
        // 'radio'		     => Radio::class,
        'select'		 => WP_Customize_Control::class,
        // 'separator'	     => Separator::class,
        'text'	         => WP_Customize_Control::class,
        'textarea'	     => WP_Customize_Control::class,
        // 'number'	     => Number::class,
        // 'range-slider'   => Range_Slider::class,
        // 'toggle'         => Toggle::class,
    ];

    return $accepted_control_types[$type] ?? $accepted_control_types['default'];
}

function inharmony_add_theme_mod(string $section, string $setting, string $default, string $sanitize, string $type, string $label, string $desc, array $choices) {
    global $wp_customize;

    $wp_customize->add_setting(
        $setting,
        array(
            'default'           => $default,
            'type'              => 'theme_mod',
            'sanitize_callback' => $sanitize,
            'capability'        => 'edit_theme_options',
        )
    );

    $class = inharmony_get_control_class($type);
    
    $wp_customize->add_control(
        new $class(
            $wp_customize,
            $setting,
            array(
                'label'         => __( $label, 'inharmonylife' ),
                'description'   => __( $desc, 'inharmony' ),
                'section'       => $section,
                'settings'      => $setting,
                'type'          => $type,
                'choices'       => $choices,
                'priority'      => apply_filters( $setting . '_priority', 10 ),
            )
        )
    );

}


function inharmony_add_color_setting(string $section, string $setting, string $default, string $label) {
    inharmony_add_theme_mod($section, $setting, $default, 'sanitize_hex_color', 'color', $label, '', array());
}



function inharmony_add_select_setting(string $section, string $setting, string $default, string $label, string $desc, array $choices) {
    inharmony_add_theme_mod($section, $setting, $default, 'understrap_customize_sanitize_select', 'select', $label, $desc, $choices);
}



function inharmony_add_checkbox_setting(string $section, string $setting, string $default, string $label, string $desc = '') {
    inharmony_add_theme_mod($section, $setting, $default, 'wp_kses_post', 'checkbox', $label, $desc, array());
}



function inharmony_add_textarea_setting(string $section, string $setting, string $default, string $label, string $desc = '') {
    inharmony_add_theme_mod($section, $setting, $default, 'wp_kses_post', 'textarea', $label, $desc, array());
}



function inharmony_add_text_setting(string $section, string $setting, string $default, string $sanitize, string $label, string $desc = '') {
    inharmony_add_theme_mod($section, $setting, $default, $sanitize, 'text', $label, $desc, array());
}