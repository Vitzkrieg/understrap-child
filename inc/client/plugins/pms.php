<?php
/**
 * Add custom tabs to the PMS member account page.
 *
 * @param array $tabs Existing tabs.
 * @return array Modified tabs.
 */
function ihk_pms_member_account_tabs($tabs) {
    // return IHK set of WC/PMS tabs
    return ihk_get_account_nav_items();
}
add_filter('pms_member_account_tabs', 'ihk_pms_member_account_tabs');

/**
 * Remove the logout tab from the PMS member account page navigation.
 *
 * @param array $tab Existing tab.
 * @return bool False to remove the tab.
 */
function ihk_pms_member_account_logout_tab($tab) {
    return false;
}
add_filter('pms_member_account_logout_tab', 'ihk_pms_member_account_logout_tab');

/**
 * Modify the URL for the PMS member account page tabs.
 *
 * @param string $url Existing URL.
 * @param string $tab Tab name.
 * @return string Modified URL.
 */
function ihk_pms_account_get_tab_url($url, $tab) {
    if ($tab != 'subscriptions' && $tab != 'payments') {
        // Change the URL to point to the membership page
        $url = str_replace( 'subscriptions', 'my-account', $url );
    }
    return $url;
}
add_filter('pms_account_get_tab_url', 'ihk_pms_account_get_tab_url', 10, 2);