<?php

function inharmony_visually_hide_entry_header() {

    $settings = array(
        'all' => false,
        'pages' => false,
        'posts' => false,
        'frontpageblog' => false,
        'frontpage' => false,
        'blog' => false
    );
    
    $hide_page_title = get_theme_mod( 'inharmony_hide_entry_header', 'pages' );

    if ( is_string( $hide_page_title ) ) {
        $settings[$hide_page_title] = true;
    } else if ( is_array( $hide_page_title ) ) {
        $settings = array_merge( $settings, $hide_page_title );
    }   

    if (
        ( $settings['all'] ) ||
        ( $settings['pages'] && ( 'page' == get_post_type() )) ||
        ( $settings['posts'] && ( 'post' == get_post_type() )) ||
        ( $settings['frontpageblog'] && ( is_front_page() && is_home() )) ||
        ( $settings['frontpage'] && is_front_page()) ||
        ( $settings['blog'] && is_home())
    ) {

    echo "<style id='get-entry-header-style'>.entry-header{
        position: absolute !important;
        width: 1px !important;
        height: 1px !important;
        padding: 0 !important;
        margin: -1px !important;
        overflow: hidden !important;
        clip: rect(0, 0, 0, 0) !important;
        white-space: nowrap !important;
        border: 0 !important;
        }</style>";
    }
}

add_action( 'wp_head', 'inharmony_visually_hide_entry_header' );


function inharmony_get_title($position = 'article', $title_style = 'entry-title') {
    $title_position = get_theme_mod( 'inharmony_title_position', 'article' );

    if ( $title_position != $position ) {
        return;
    }

    echo "<header class=\"post-content entry-header\">";

    $title_tag_open = '<h1 class="'. $title_style . '">';
    $title_tag_close = '</h1>';
    the_title( $title_tag_open, $title_tag_close );

    echo "</header>";
}