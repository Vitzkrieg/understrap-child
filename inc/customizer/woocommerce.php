<?php

/**
 * @snippet       WordPress Customizer Setting - WooCommerce
 * @how-to        businessbloomer.com/woocommerce-customization
 * @author        Rodolfo Melogli, Business Bloomer
 * @compatible    WooCommerce 4.6
 * @community     https://businessbloomer.com/club/
 */
 
add_action( 'customize_register', 'inharmony_woocommerce_settings', 99999 );
 
function inharmony_woocommerce_settings( $wp_customize ) {
    $section = 'inharmony_woocommerce_settings';

    $wp_customize->add_section(
        $section,
        array(
            'title'    => __( 'In Harmony', 'inharmony' ),
            'priority' => 20,
            'panel'    => 'woocommerce',
        )
    );

    // Register settings.
    inharmony_add_checkbox_setting($section,
        'inharmony_show_wc_breadcrumbs',
        true,
        'Show Breadcrumbs'
    );
}
