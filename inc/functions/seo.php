<?php

/**
 * Adds SEO information about the site/page to each page
 */
function seo_information(){
    $og_type = get_theme_mod( 'inharmony_open_graph_type', 'website'); //change base on your site's purpose, see the Open Graph documentation
    
    $seo_site_name = get_bloginfo('name');
    
    $twitter_card = get_theme_mod( 'inharmony_twitter_card', 'summary_large_image'); //look up twitter's card documentation for the type you want
    $twitter_site = get_theme_mod( 'inharmony_twitter_handle', ''); // e.g. @someone

    $image_info = inharmony_get_seo_image_info(($twitter_card == 'summary_large_image'));
    $seo_image = $image_info['url'];
    $seo_image_alt = $image_info['alt'];

    if ( is_single() ){
        $qpost = get_queried_object();
        $seo_descript = $qpost->post_excerpt;
        $seo_title = $qpost->post_title;
        $seo_url = esc_url( get_permalink( $qpost->ID ) );;
    } else {
        $seo_title = get_the_title();
        $seo_descript = get_bloginfo('description');
        $seo_url = home_url('/');
    }
    //assemble meta in array.
    $seo__array = array(
        'og-type' => $og_type,
        'og-url' => $seo_url,
        'og-site_name' => $seo_site_name,
        'og-description' => $seo_descript,
        'og-title' => $seo_title,
        'og-image' => $seo_image,
        'twitter-card' => $twitter_card,
        'twitter-site' => $twitter_site,
        'twitter-title' => $seo_title,
        'twitter-description' => $seo_descript,
        'twitter-url' => $seo_url,
        'twitter-image' => $seo_image,
        'twitter-image-alt' => $seo_image_alt,
        'description' => $seo_descript,
    );
    //echo meta
    foreach($seo__array as $key => $value) {
        if ( empty( $value ) || ! is_string( $key ) ) {
            continue;
        }

        $prop = array_slice( explode( '-', $key ), 0, 3);
        $type = $prop[0] == "og" ? "property" : "name";
        $prop = join(':', $prop );
        echo "<meta $type='$prop' content='$value'>";
    }
}
add_action('wp_head','seo_information');


/**
 * Gets the SEO image for the page
 * 
 * @order page featured image, default seo theme mod, site icon
 */
function inharmony_get_seo_image_info($is_large) {

    $icon_size = $is_large ? 'full' : array(512,512);
    
    // Post featured image
    $image_id = get_post_thumbnail_id();
    
    if ( $image_id == 0 ) {
        // SEO default image
        $image_id = $is_large ? get_theme_mod( 'inharmony_twitter_image_large', '' ) : get_theme_mod( 'inharmony_twitter_image', '' ) ;    
    }
    
    if ( $image_id == 0 ){
        // Site icon
        $image_id = (int) get_option( 'site_icon' );
    }
    
    return array(
        'url'   =>  wp_get_attachment_image_url( $image_id, $icon_size ),
        'alt'   => get_post_meta($image_id, '_wp_attachment_image_alt', TRUE),
    );
}