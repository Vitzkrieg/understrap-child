<?php

function get_entry_header_style() {
    $header_style = 'entry-header';
    //TODO: setting - hide page title ['', 'home', 'blog', 'pages', 'homeblog', 'posts', 'homeposts', 'blogposts', 'homeposts' 'all' ]; or custom array?
    $hide_page_title = get_theme_mod( 'inharmony_hide_page_title', 'page' );
    $header_style .= ' ' . $hide_page_title;

    switch($hide_page_title) {
        case 'all':
            $header_style .= ' visually-hidden';
            break;
        case 'home':
        case 'homeblog':
            if ( is_front_page() && is_home() ) {
                $header_style .= ' visually-hidden';
            }
            break;
        case 'blog':
        case 'homeblog':
            if ( is_page( 'blog' ) ) {
                $header_style .= ' visually-hidden';
            }
        break;
        case 'page':
            if (( is_front_page() && is_home() ) || !is_single( ) ) {
                $header_style .= ' visually-hidden';
            }
            break;
    }

    return $header_style;
}