<?php


/**
 * Select sanitization function
 *
 * @param string               $input   Slug to sanitize.
 * @param WP_Customize_Setting $setting Setting instance.
 * @return string Sanitized slug if it is a valid choice; otherwise, the setting default.
 */
function inharmony_theme_slug_sanitize_select( $input, $setting ) {

    // Ensure input is a slug (lowercase alphanumeric characters, dashes and underscores are allowed only).
    $input = sanitize_key( $input );

    // Get the list of possible select options.
    $choices = $setting->manager->get_control( $setting->id )->choices;

    // If the input is a valid key, return it; otherwise, return the default.
    return ( array_key_exists( $input, $choices ) ? $input : $setting->default );

}


/**
 * Height sanitization function
 *
 * @param string               $input   Slug to sanitize.
 * @param WP_Customize_Setting $setting Setting instance.
 * @return string Sanitized slug if it is a valid choice; otherwise, the setting default.
 */
function inharmony_theme_slug_sanitize_height( $input, $setting ) {

    // Ensure input is a slug (lowercase alphanumeric characters, dashes and underscores are allowed only).
    $input = sanitize_key( $input );

    // If the input is a valid max-height value, return it; otherwise, return the default.
    return ( preg_match('/^(\d+)(px|vh|vw|em|rem)$/', $input ) ? $input : $setting->default );

}
 
 /**
 * Validation: Twitter image
 * Control: text, WP_Customize_Image_Control, WP_Customize_Cropped_Image_Control
 *
 * @uses    wp_check_filetype()        https://developer.wordpress.org/reference/functions/wp_check_filetype/
 * @uses    in_array()                http://php.net/manual/en/function.in-array.php
 */
 function inharmony_sanitize_image( $file, $setting ) {
 
    $mimes = array(
        'jpg|jpeg|jpe' => 'image/jpeg',
        'gif'          => 'image/gif',
        'png'          => 'image/png',
        'webp'         => 'image/webp',
    );
 
    if ( ! str_contains( $setting->id, 'twitter_image' ) ) {
        $mimes = array_merge( $mimes, array(
            'bmp'          => 'image/bmp',
            'tif|tiff'     => 'image/tiff',
            'ico'          => 'image/x-icon'
        ) );
    }
 
    //check file type from file name
    $file_ext = wp_check_filetype( $file, $mimes );
 
    //if file has a valid mime type return it, otherwise return default
    return ( $file_ext['ext'] ? $file : $setting->default );
 }