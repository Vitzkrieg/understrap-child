<?php

add_filter( 'heartbeat_settings', 'reduce_heartbeat_frequency' );
function reduce_heartbeat_frequency( $settings ) {
    $settings['interval'] = 45; //Set the frequency to every 45 seconds
    return $settings;
}


if ( !defined('DISABLE_WP_CRON') ) {
    // Disable WP Cron to prevent it from running on every page load
    // This is useful for performance optimization, especially on high-traffic sites
    define('DISABLE_WP_CRON', true);
}

add_action( 'after_setup_theme', function() {
    add_theme_support( 'woocommerce' );
} );

add_action( 'after_setup_theme', function() {
    add_theme_support( 'wc-product-gallery-slider' );
    add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-lightbox' );
} );