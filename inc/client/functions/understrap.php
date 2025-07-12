<?php


/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 *
 * @return array
 */
function understrap_body_classes( $classes ) {
    // Adds a class of group-blog to blogs with more than 1 published author.
    if ( is_multi_author() ) {
        $classes[] = 'group-blog';
    }
    // Adds a class of hfeed to non-singular pages.
    if ( ! is_singular() ) {
        $classes[] = 'hfeed';
    }

    // Adds a body class based on the presence of a sidebar.
    $sidebar_pos = get_theme_mod( 'understrap_sidebar_position' );
    debug_log( array(
        'understrap_sidebar_position' => $sidebar_pos,
    ) );
    if ( is_page_template(
        array(
            'page-templates/fullwidthpage.php',
            'page-templates/no-title.php',
        )
    ) ) {
        $classes[] = 'understrap-no-sidebar';
    } elseif (
        is_page_template(
            array(
                'page-templates/both-sidebarspage.php',
                'page-templates/left-sidebarpage.php',
                'page-templates/right-sidebarpage.php',
                'page-templates/page-resources.php',
            )
        )
    ) {
        $classes[] = 'understrap-has-sidebar';
    } elseif ( 'none' !== $sidebar_pos ) {
        $classes[] = 'understrap-has-sidebar';
    } else {
        $classes[] = 'understrap-no-sidebar';
    }

    return $classes;
}




add_filter( 'theme_mod_understrap_sidebar_position', function( $position ) {
    debug_log( array(
        'theme_mod_understrap_sidebar_position' => $position,
    ) );
    if ( is_page_template( 'page-templates/page-resources.php' ) ) {
        return 'left';
    }
    return $position;
} );