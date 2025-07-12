<?php

  // For logged-in users
add_action('wp_ajax_ihk_account_status', 'ihk_ajax_account_status');
// For non-logged-in users
add_action('wp_ajax_nopriv_ihk_account_status', 'ihk_ajax_account_status');
function ihk_ajax_account_status() {

    $logged_in = is_user_logged_in();
    $title = $logged_in ? "My Account" : "Login";
    $icon = $logged_in ? 'fa-solid fa-user' : 'fa-regular fa-user';
    $account_link = $logged_in ? get_permalink( get_page_by_path( 'ihk-dashboard' ) ) : get_permalink( get_page_by_path( 'member-login' ) );
    $cart_count = (function_exists( 'WC' ) && WC()->cart) ? WC()->cart->cart_contents_count : 0;

    $ajaxobj = array(
        'loggedin'      => $logged_in,
        'title'         => $title,
        'icon'          => $icon,
        'account_link'  => $account_link,
        'cart_count'    => $cart_count,
    );

    wp_send_json_success($ajaxobj);
}