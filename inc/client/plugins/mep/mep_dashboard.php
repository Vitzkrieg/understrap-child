<?php


// add_action( 'wp_head', 'mep_remove_my_event_order_list_from_my_account_page_action' );
// function mep_remove_my_event_order_list_from_my_account_page_action() {
// 	remove_action( 'woocommerce_account_dashboard', 'mep_ticket_lits_users' );
// }


function ihk_get_list_thumbnail_src( $event_id, $size = 'full' ) {
    $thumbnail_id = get_post_meta( $event_id, 'mep_list_thumbnail', true ) ?: 0;
    if ( ($thumbnail_id == 0) || !( $thumbnail = ihk_get_attatchement_src( $thumbnail_id, $size ) ) ) {
        $thumbnail = ihk_get_attatchement_src( get_post_thumbnail_id( $event_id ), $size );
    }

    echo esc_attr( $thumbnail );
}


function ihk_get_attatchement_src( $attachment_id, $size = 'full' ) {
    $thumbnail = wp_get_attachment_image_src( $attachment_id, $size );
    return ( is_array( $thumbnail ) && !empty( $thumbnail[0] ) ) ? $thumbnail[0] : '';
}