<?php

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;



$color_primary = '#78939e';
$color_secondary = '#82b3b4';
$color_white = '#fff';
$color_white_off = '#fafafa';
$color_grey_dark = '#333';

$text_color_choices = array(
    'primary'       => 'Primary',
    'secondary'     => 'Secondary',
    'light'         => 'Light',
    'dark'          => 'Dark',
    'white'         => 'White',
    'black'         => 'Black',
);
$bg_color_choices = array(
    'primary'       => 'Primary',
    'secondary'     => 'Secondary',
    'light'         => 'Light',
    'dark'          => 'Dark',
    'white'         => 'White',
    'transparent'   => 'Transparent',
);
$bg_opacity_choices = array(
    '10'    => '10',
    '25'    => '25',
    '50'    => '50',
    '75'    => '75',
    '100'   => '100'
);
$bs_spacers = array(
    '0'    => '0',
    '1'    => '1',
    '2'    => '2',
    '3'    => '3',
    '4'    => '4',
    '5'    => '5'
);


$bs_container_choices = array(
    'container'         => __( 'Fixed width container', 'inharmony' ),
    'container-fluid'   => __( 'Fluid width container', 'inharmony' ),
    'container-sm'      => __( 'Fluid width small only', 'inharmony' ),
    'container-md'      => __( 'Fluid width up to medium', 'inharmony' ),
    'container-lg'      => __( 'Fluid width up to large', 'inharmony' ),
);

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