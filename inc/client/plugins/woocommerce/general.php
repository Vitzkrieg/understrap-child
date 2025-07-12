<?php


add_filter( 'woocommerce_get_availability', 'custom_get_availability', 1, 2);
  
function custom_get_availability( $availability, $_product ) {
    //change text "In Stock' to 'Available'
    if ( $_product->is_in_stock() ) $availability['availability'] = __('Available', 'woocommerce');
  
    //change text "Out of Stock' to 'Sold out'
    if ( !$_product->is_in_stock() ) $availability['availability'] = __('Sold out', 'woocommerce');
    
    return $availability;
}

add_filter( 'woocommerce_register_post_type_product', 'ihk_modify_product_post_type' );
 
function ihk_modify_product_post_type( $args ) {
     $args['supports'][] = 'revisions';
     return $args;
}

// enable gutenberg for woocommerce products
function activate_gutenberg_product( $can_edit, $post_type ) {
    if ( $post_type == 'product' ) {
        $can_edit = true;
    }
    return $can_edit;
}
add_filter( 'use_block_editor_for_post_type', 'activate_gutenberg_product', 10, 2 );
   
// enable taxonomy fields for woocommerce with gutenberg on rest api
function enable_taxonomy_rest( $args ) {
    $args['show_in_rest'] = true;
    return $args;
}

add_filter( 'woocommerce_taxonomy_args_product_cat', 'enable_taxonomy_rest' );
add_filter( 'woocommerce_taxonomy_args_product_tag', 'enable_taxonomy_rest' );


/*
 * Single Product Page
 */
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
add_action( 'woocommerce_after_single_product', 'woocommerce_upsell_display', 5 );
add_action('woocommerce_after_single_product', 'woocommerce_output_product_data_tabs', 10);


/*
 * My Account Page
 */

// Add navigation menu item to membership page
function ihk_my_account_menu_items( $items ) {
    return ihk_get_account_nav_items();
    // Add membership account menu item after orders menu item
    $new_items = array();
    foreach ( $items as $key => $value ) {
        $new_items[ $key ] = $value;
        if ( $key == 'downloads' ) {
            $new_items['subscriptions'] = __( 'Subscriptions', 'ihk' );
            $new_items['payments'] = __( 'Payments', 'ihk' );
        }
    }
    $items = $new_items;

    return $items;
}
add_filter( 'woocommerce_account_menu_items', 'ihk_my_account_menu_items' );


function ihk_my_account_membership_endpoint_url( $url, $endpoint, $value, $permalink ) {
    if ( $endpoint == 'subscriptions' || $endpoint == 'payments' ) {
        // Change the URL to point to the membership page
        $url = str_replace( 'my-account', 'subscriptions', $url );
    }
    return $url;
}
// add_filter('woocommerce_get_endpoint_url', 'ihk_my_account_membership_endpoint_url', 10, 4);

// add_action( 'woocommerce_account_subscriptions_endpoint', 'ihk_my_account_subscriptions_endpoint' );
// function ihk_my_account_membership_endpoint() {
//     // Display the membership account page content
//     echo '<h3>' . __( 'Subscriptions', 'ihk' ) . '</h3>';
//     echo '<p>' . __( 'This is your subscriptions page.', 'ihk' ) . '</p>';
// }


/**
 * Add custom fields to WooCommerce products
 */

function ihk_add_wc_custom_inventory_fields() {
    global $woocommerce, $post;
    echo '<div class="product_ihk_fields">';

    // Coming soon field
    woocommerce_wp_checkbox( 
        array( 
            'id'            => '_coming_soon',
            'value'         => get_post_meta( $post->ID, '_coming_soon', true ),
            'cbvalue'       => 'yes',
            'desc_tip'      => true,
            'description'   => __( 'Check this if product is still in the works', 'ihk' ),
            'type'          => 'checkbox',
            'label'         => __('Coming Soon', 'ihk' ),
            )
        );

    // Release date field
    woocommerce_wp_text_input( 
        array( 
            'id'            => '_release_date', 
            'value'         => get_post_meta( $post->ID, '_coming_soon', true ),
            'description'   => __( 'Enter the release date for this product.', 'ihk' ),
            'desc_tip'      => true,
            'type'          => 'date',
            'label'         => __( 'Release Date', 'ihk' ), 
        )
    );
    echo '</div>';
}
add_action( 'woocommerce_product_options_inventory_product_data', 'ihk_add_wc_custom_inventory_fields' );

// Save Fields
add_action( 'woocommerce_process_product_meta', 'ihk_add_wc_custom_inventory_fields_save' );
function ihk_add_wc_custom_inventory_fields_save( $post_id ) {

    // Save coming soon field
    $coming_soon = isset( $_POST['_coming_soon'] ) ? 'yes' : 'no';
    update_post_meta( $post_id, '_coming_soon', $coming_soon );

    // Save release date field
    $release_date = isset( $_POST['_release_date'] ) ? $_POST['_release_date'] : '';
    update_post_meta( $post_id, '_release_date', sanitize_text_field( $release_date ) );
}


// Display custom fields on the product page
add_action( 'woocommerce_get_price_html', 'ihk_wc_get_price_html', 25 );
function ihk_wc_get_price_html($price) {
    global $post;

    if ( ! is_a( $post, 'WP_Post' ) || $post->post_type !== 'product' ) {
        return $price; // Return original price if not a product post
    }

    // Get the custom fields
    $coming_soon = get_post_meta( $post->ID, '_coming_soon', true );
    // $release_date = get_post_meta( $post->ID, '_release_date', true );

    // Check if the product is coming soon
    if ( $coming_soon == 'yes' ) {
        // Add the coming soon message
        $price = '<p class="coming-soon">' . __( 'Coming Soon', 'ihk' ) . '</p>';
    }
    // // Check if the product has a release date
    // if ( ! empty( $release_date ) ) {
    //     // Add the release date message
    //     $price .= '<p class="release-date">' . __( 'Release Date:', 'ihk' ) . ' ' . date_i18n( get_option( 'date_format' ), strtotime( $release_date ) ) . '</p>';
    // }
    return $price;
}

/**
 * Get the product coming soon status
 *
 * @param int $product_id The product ID.
 * @return bool True if the product is coming soon, false otherwise.
 */
function ihk_get_product_coming_soon($product_id) {
    static $coming_soon;

    if ( ! isset( $coming_soon ) ) {
        $coming_soon = array();
    }

    // Check if the product ID is valid
    if ( ! $product_id || ! is_numeric( $product_id ) ) {

        // If no product ID is provided, use the global product object
        if ( !$product_id ) {
            global $product;
            if ( ! $product ) {
                return false;
            }
        
            $product_id = $product->get_id();
        }
    }

    // Check if the product ID is already cached
    if ( isset( $coming_soon[$product_id] ) ) {
        return $coming_soon[$product_id];
    }

    // Evaluate the product coming soon status from the post meta
    $product_coming_soon = ( get_post_meta( $product_id, '_coming_soon', true )  == 'yes' );

    // Apply filters to the product coming soon status
    $product_coming_soon = apply_filters( 'ihk_get_coming_soon', $product_coming_soon, $product_id );

    // Cache the result for future calls
    $coming_soon[$product_id] = $product_coming_soon;

    // Return the product coming soon status
    return $product_coming_soon;
}



function woocommerce_single_variation(){
    global $product;
    $product_id = $product->get_id();
    $coming_soon = ihk_get_product_coming_soon( $product_id );
    if ( $coming_soon ) {
        echo '<p class="coming-soon">' . __( 'Coming Soon', 'ihk' ) . '</p>';
    }
}

function woocommerce_single_variation_add_to_cart_button() {
    global $product;
    $product_id = $product->get_id();
    $coming_soon = ihk_get_product_coming_soon( $product_id );
    
    if ( !$coming_soon ) {
        wc_get_template( 'single-product/add-to-cart/variation-add-to-cart-button.php' );
    }
}


remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
add_action( 'woocommerce_before_shop_loop_item_title', 'ihk_woocommerce_template_loop_product_thumbnail', 10 );
function ihk_woocommerce_template_loop_product_thumbnail() {
    global $product;
    $product_id = $product->get_id();
    $coming_soon = ihk_get_product_coming_soon( $product_id );
    
    echo '<div class="ihk-product-image">';
        woocommerce_template_loop_product_thumbnail();
    echo '</div>';
}