<?php
/**
 * List Events
 */
add_action('ihk_dashboard_content_dashboard', 'ihk_dashboard_home');

function ihk_dashboard_home() {
    ob_start();

    do_action('ihk_dashboard_bulletins_list');

    $content = ob_get_clean();
    echo html_entity_decode( $content );
    
}
