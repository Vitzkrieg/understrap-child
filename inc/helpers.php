<?php

// Convert Hex to RGB Value
function ih_inharmony_HexToRGB($hex) {

    $hex = preg_replace("/#/i", "", $hex);
    $color = array();

    if(strlen($hex) == 3) {
        $color['r'] = hexdec(substr($hex, 0, 1) . $r);
        $color['g'] = hexdec(substr($hex, 1, 1) . $g);
        $color['b'] = hexdec(substr($hex, 2, 1) . $b);
    }
    else if(strlen($hex) == 6) {
        $color['r'] = hexdec(substr($hex, 0, 2));
        $color['g'] = hexdec(substr($hex, 2, 2));
        $color['b'] = hexdec(substr($hex, 4, 2));
    }

    return $color['r'] . "," . $color['g'] . "," . $color['b'];

}


/**
 * Returns the bs flex css from the value
 * 
 * @param string $value theme mod value
 * @param string $size Bootstrap size
 * 
 * @return string Bootstrap css settings
 */
function inharmony_get_bs_css_from_theme_mod( string $value, string $size = '' ) {

    $dir = '';
    $layout = '';

    // bs size
    $size = !empty($size) ? '-' . $size : $size;

    // flex-direction
    if (str_starts_with($value, 'row')) {
        $dir = 'flex' . $size . '-row';
        $layout = 'justify-content';
    }
    if (str_starts_with($value, 'column')) {
        $dir = 'flex' . $size . '-column';
        $layout = 'align-items';
    }
    if (str_starts_with($value, 'row-reverse')) {
        $dir = 'flex' . $size . '-row-reverse';
        $layout = 'justify-content';
    }
    if (str_starts_with($value, 'column-reverse')) {
        $dir = 'flex' . $size . '-column-reverse';
        $layout = 'align-items';
    }

    // flex-layout
    if (str_ends_with($value, 'center')) $layout .= $size . '-center';
    if (str_ends_with($value, 'end')) $layout .= $size . '-end';
    if (str_ends_with($value, 'start')) $layout .= $size . '-start';
    if (str_ends_with($value, 'between')) $layout .= $size . '-between';
    if (str_ends_with($value, 'around')) $layout .= $size . '-around';
    if (str_ends_with($value, 'evenly')) $layout .= $size . '-evenly';

    $css = !empty($dir) ? $dir . ' ' . $layout : '';

    return $css;

}



if (!function_exists('str_contains')) {
    function str_contains(string $haystack, string $needle) : bool {
        return $needle !== '' && mb_strpos($haystack, $needle) !== false;
    }
}

if ( !function_exists( 'str_starts_with' ) ) {
	function str_starts_with(string $haystack, string $needle): bool {
		return \strncmp($haystack, $needle, \strlen($needle)) === 0;
	}
}

if ( !function_exists( 'str_ends_with' ) ) {
	function str_ends_with(string $haystack, string $needle): bool {
		return $needle === '' || $needle === \substr($haystack, - \strlen($needle));
	}
}