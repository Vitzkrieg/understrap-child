<?php

/**
 * Adds SEO information about the site/page to each page
 */
function seo_information(){
    //TODO: add SEO section to Customizer for this information
    //some of this can be customized.
    $og_property_1 = 'website'; //change base on your site's purpose, see the Open Graph documentation
    $og_property_2 = 'homestead'; // "
    $twitter_card = 'summary_large_image'; //look up twitter's card documentation for the type you want
    $twitter_site = 'inharmonylife'; // e.g. @someone
    $seo_image = get_site_icon_url(null, 'https://inharmonylife.com/wp-content/uploads/2022/01/ih-life-site-icon.png'); //site icon!
    $seo_site_name = get_bloginfo('name');
    if ( is_single() ){
        $qpost = get_queried_object();
        $seo_descript = $qpost->post_excerpt;
        $seo_title = $qpost->post_title;
        $seo_name = $qpost->post_name;
        $seo_url = esc_url( get_permalink( $qpost->ID ) );;
    } else {
        $seo_title = get_the_title();
        $seo_descript = get_bloginfo('description');
        $seo_name = get_bloginfo('name');
        $seo_url = home_url('/');
    }
    //assemble meta in array.
    //TODO: check "og:type" duplicate values is valid
    $seo__array = array(
        'og-type-1' => $og_property_1,
        'og-type-2' => $og_property_2,
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
        'description' => $seo_descript,
    );
     //echo meta
    foreach($seo__array as $key => $value) {
        if ( empty( $value ) || ! is_string( $key ) ) {
            continue;
        }

        // work-around for duplicate "og:type" values
        $prop = array_slice( explode( '-', $key ), 0, 2);
        $type = $prop[0] == "og" ? "property" : "name";
        $prop = join(':', $prop );
        echo "<meta $type='$prop' content='$value'>";
    }
}
add_action('wp_head','seo_information');