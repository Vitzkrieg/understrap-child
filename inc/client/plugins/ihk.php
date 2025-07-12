<?php
/**
 * IHK code for plugins
 */

function ihk_get_account_nav_items() {
    $ihk_account_nav_items = array(
        'ihk-dashboard'     => __( 'Dashboard', 'ihk' ),
        'dashboard'         => __( 'My Account', 'ihk' ),
        'orders'            => __( 'Orders', 'ihk' ),
        'downloads'         => __( 'Downloads', 'ihk' ),
        'subscriptions'     => __( 'Subscriptions', 'ihk' ),
        'payments'          => __( 'Payments', 'ihk' ),
        'edit-address'      => __( 'Addresses', 'ihk' ),
        'payment-methods'   => __( 'Payment Methods', 'ihk' ),
        'subscriptions'     => __( 'Subscriptions', 'ihk' ),
        'edit-account'      => __( 'Edit Account', 'ihk' ),
        'customer-logout'   => __( 'Log out', 'ihk' ),
    );

    return $ihk_account_nav_items;
}
