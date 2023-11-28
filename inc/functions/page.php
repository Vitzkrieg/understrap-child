<?php

function inharmony_visually_hide_entry_header() {
    //TODO: setting - hide page title ['', 'home', 'blog', 'pages', 'homeblog', 'posts', 'homeposts', 'blogposts', 'all' ]; or custom array?
    $hide_page_title = get_theme_mod( 'inharmony_hide_entry_header', 'pages' );
    echo "<script id='ivheh'>let mod=" . json_encode($hide_page_title) . "</script>";
    $do_hide = false;

    if (
        ( $hide_page_title['all'] ) ||
        ( $hide_page_title['pages'] && ( 'page' == get_post_type() )) ||
        ( $hide_page_title['posts'] && ( 'post' == get_post_type() )) ||
        ( $hide_page_title['frontpageblog'] && ( is_front_page() && is_home() )) ||
        ( $hide_page_title['frontpage'] && is_front_page()) ||
        ( $hide_page_title['blog'] && is_home())
    ) {
        $do_hide = true;
    }

    if ( !$do_hide ) {
        return;
    }

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

add_action( 'wp_head', 'inharmony_visually_hide_entry_header' );