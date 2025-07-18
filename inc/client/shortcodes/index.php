<?php

// add shortcode for search and open
function ihk_search_and_open_shortcode() {
    ob_start();

    // get child template directory
    $template_path = get_stylesheet_directory() . '/inc/client/shortcodes/search-and-open.php';

    // include the search and open template
    if ( file_exists( $template_path ) ) {
        include $template_path;
    } else {
        echo '<p>Error: Search and Open template not found.</p>';
        echo '<p>Template Path: ' . esc_html( $template_path ) . '</p>';
    }

    return ob_get_clean();
}
add_shortcode('ihk_search_and_open', 'ihk_search_and_open_shortcode');