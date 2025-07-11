<?php

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;


function inharmony_get_control_class($type) {
    $accepted_control_types = [
        'checkbox'	     => WP_Customize_Control::class,
        'color'		     => WP_Customize_Color_Control::class,
        'default'		 => WP_Customize_Control::class,
        'dropdown-pages' => WP_Customize_Control::class,
        // 'heading'		 => Heading::class,
        'image'		     => WP_Customize_Image_Control::class,
        'cropped-image'  => WP_Customize_Cropped_Image_Control::class,
        // 'radio'		     => Radio::class,
        'select'		 => WP_Customize_Control::class,
        // 'separator'	     => Separator::class,
        'text'	         => WP_Customize_Control::class,
        'textarea'	     => WP_Customize_Control::class,
        'number'	     => WP_Customize_Control::class,
        // 'range-slider'   => Range_Slider::class,
        // 'toggle'         => Toggle::class,
    ];

    return $accepted_control_types[$type] ?? $accepted_control_types['default'];
}


function inharmony_add_theme_mod(string $section, string $setting, string $default, string $sanitize, string $type, string $label, string $desc, array $choices, $active_cb = null, $atts = array()) {
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
                'label'             => __( $label, 'inharmonylife' ),
                'description'       => __( $desc, 'inharmony' ),
                'section'           => $section,
                'settings'          => $setting,
                'type'              => $type,
                'choices'           => $choices,
                'active_callback'   => $active_cb,
                'input_attrs'       => $atts,
                'priority'          => apply_filters( $setting . '_priority', 10 ),
            )
        )
    );

}


function inharmony_add_color_setting(string $section, string $setting, string $default, string $label, string $desc = '', $active_cb = null) {
    inharmony_add_theme_mod($section, $setting, $default, 'sanitize_hex_color', 'color', $label, $desc, array(), $active_cb);
}


function inharmony_add_select_setting(string $section, string $setting, string $default, string $label, string $desc, array $choices, $active_cb = null) {
    inharmony_add_theme_mod($section, $setting, $default, 'understrap_customize_sanitize_select', 'select', $label, $desc, $choices, $active_cb);
}


function inharmony_add_checkbox_setting(string $section, string $setting, string $default, string $label, string $desc = '', $active_cb = null) {
    inharmony_add_theme_mod($section, $setting, $default, 'wp_kses_post', 'checkbox', $label, $desc, array(), $active_cb);
}


function inharmony_add_textarea_setting(string $section, string $setting, string $default, string $label, string $desc = '', $active_cb = null) {
    inharmony_add_theme_mod($section, $setting, $default, 'wp_kses_post', 'textarea', $label, $desc, array(), $active_cb);
}


function inharmony_add_text_setting(string $section, string $setting, string $default, string $sanitize, string $label, string $desc = '', $atts = array(), $active_cb = null) {
    if ( empty($sanitize) ) $sanitize = 'wp_kses_post';
    inharmony_add_theme_mod($section, $setting, $default, $sanitize, 'text', $label, $desc, array(), $active_cb, $atts);
}


function inharmony_add_number_setting(string $section, string $setting, string $default, string $label, string $desc = '', $active_cb = null) {
    inharmony_add_theme_mod($section, $setting, $default, 'wp_kses_post', 'number', $label, $desc, array(), $active_cb);
}


function inharmony_add_cropped_image_setting(string $section, string $setting, string $default, string $label, string $desc, int $width, int $height, bool $flex_width = true, bool $flex_height = true, $active_cb = null) {
    global $wp_customize;

    $sanitize = 'absint';
    $type = 'cropped-image';

    $wp_customize->add_setting(
        $setting,
        array(
            'default'           => 0,
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
				'label'             => __( $label, 'inharmonylife' ),
                'description'       => __( $desc, 'inharmony' ),
				'section'           => $section,
				'width'             => $width, // Cropper Width
				'height'            => $height, // cropper Height
				'flex_width'        => $flex_width, //Flexible Width
				'flex_height'       => $flex_height, // Flexible Heiht
                'active_callback'   => $active_cb,
			)
		)
	);

}
