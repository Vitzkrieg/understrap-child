<?php

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;


$section = 'static_front_page';

inharmony_add_checkbox_setting($section,
    'inharmony_home_hide_header',
    false,
    'Hide Header on Homepage'
);



inharmony_add_select_setting($section,
    'inharmony_home_widget_container',
    'center',
    'Home Widget Container',
    '',
    array(
        'container'      => __( 'Container', 'inharmonylife' ),
        'container-fluid'   => __( 'Container Fluid', 'inharmonylife' ),
    )
);