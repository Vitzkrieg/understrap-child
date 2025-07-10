<?php

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;


$section = 'header_image';

inharmony_add_select_setting($section,
    'inharmony_header_placement',
    'above',
    'Header Placement',
    'Where to place the header image.',
    array(
        'above'     => __( 'Above header', 'inharmonylife' ),
        'below'     => __( 'Below header', 'inharmonylife' ),
        'behind'    => __( 'Behind header', 'inharmonylife' ),
    )
);

inharmony_add_checkbox_setting($section,
    'inharmony_header_show_widget_column',
    false,
    'Show Header Widget Column',
    'Show the widget column in the header area.'
);

inharmony_add_select_setting($section,
    'inharmony_header_image_size',
    'cover',
    'Header Image Size',
    'How the image displays in the area.',
    array(
        'cover'     => __( 'Fill Header', 'inharmonylife' ),
        'contain'   => __( 'Fit Image to Header', 'inharmonylife' ),
        'auto'      => __( 'Original Image Size', 'inharmonylife' ),
    )
);

inharmony_add_text_setting($section,
    'inharmony_header_image_height',
    '800px',
    'inharmony_theme_slug_sanitize_height',
    'Image Height',
    'Use px, em, rem for static height, vh or vw for responsive height.',
);


inharmony_add_checkbox_setting($section,
    'inharmony_header_show_title',
    false,
    'Show Site Title'
);

inharmony_add_checkbox_setting($section,
    'inharmony_header_show_tagline',
    false,
    'Show Site Tagline'
);

inharmony_add_textarea_setting($section,
    'inharmony_header_custom_text',
    '',
    'Custom Header Text',
    'Add custom text to the header.'
);
