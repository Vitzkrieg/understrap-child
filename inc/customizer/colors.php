<?php

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;


$section = 'colors';

inharmony_add_color_setting($section,
    'inharmony_color_primary',
    $color_primary,
    'Primary Color'
);
inharmony_add_color_setting($section,
    'inharmony_color_secondary',
    $color_secondary,
    'Secondary Color'
);
inharmony_add_color_setting($section,
    'inharmony_color_links',
    $color_primary,
    'Link Color'
);
inharmony_add_color_setting($section,
    'inharmony_color_buttons_text',
    $color_white,
    'Button Text Color'
);
inharmony_add_color_setting($section,
    'inharmony_color_buttons_bg',
    $color_secondary,
    'Button BG Color'
);
inharmony_add_color_setting($section,
    'inharmony_color_buttons_bg_hover',
    $color_secondary,
    'Button BG Hover Color'
);


inharmony_add_select_setting($section,
    'inharmony_footer_text',
    'light',
    'Footer Text Color',
    '',
    $text_color_choices
);
inharmony_add_select_setting($section,
    'inharmony_footer_bg',
    'primary',
    'Footer BG Color',
    '',
    $bg_color_choices
);


inharmony_add_select_setting($section,
    'inharmony_color_blog_buttons_text',
    'light',
    'Blog Button Text Color',
    '',
    $text_color_choices
);
inharmony_add_select_setting($section,
    'inharmony_color_blog_buttons_bg',
    $color_secondary,
    'Blog Button BG Color',
    '',
    $bg_color_choices
);