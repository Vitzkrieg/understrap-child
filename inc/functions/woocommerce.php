<?php

add_filter( 'woocommerce_quantity_input_type', 'inharmony_wc_quantity_input_type', 1);
global $ihl_cart_has_quantity_input;
$ihl_cart_has_quantity_input = false;
function inharmony_wc_quantity_input_type($input_type) {
	global $ihl_cart_has_quantity_input;

	if ( $input_type != 'hidden') {
		$ihl_cart_has_quantity_input = true;
	}

	return $input_type;
}

/**
 * Insert the opening anchor tag for products in the loop.
 */
function woocommerce_template_loop_product_link_open() {
	global $product;

	if ( ! ( $product instanceof WC_Product ) ) {
		return;
	}

	$link = apply_filters( 'woocommerce_loop_product_link', get_the_permalink(), $product );

	echo '<div class="card">';
	echo '<div class="card-body">';
	echo '<a href="' . esc_url( $link ) . '" class="woocommerce-LoopProduct-link woocommerce-loop-product__link">';
}

/**
 * Insert the closing anchor tag for products in the loop.
 */
function woocommerce_template_loop_product_link_close() {
	echo '</a>';
	echo '</div>';
}


add_filter( 'woocommerce_post_class', 'inharmony_woocommerce_post_class', 1);
function inharmony_woocommerce_post_class($classes) {

	$classes[] = 'col';

	return $classes;
}



remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart');
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price');
function inharmony_price_add_to_cart_wrapper_1(){
	echo '<div class="card-footer add_to_cart_wrapper d-flex justify-content-between align-items-center p-3">';
}
function inharmony_price_add_to_cart_wrapper_2(){
	echo '</div>';
}
add_action( 'woocommerce_after_shop_loop_item', 'inharmony_price_add_to_cart_wrapper_1', 10);
add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_price', 11);
add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 12);
add_action( 'woocommerce_after_shop_loop_item', 'inharmony_price_add_to_cart_wrapper_2', 15);


/**
 * Add Bootstrap button classes to add to cart link.
 *
 * @param array<string,mixed> $args Array of add to cart link arguments.
 * @return array<string,mixed> Array of add to cart link arguments.
 */
function understrap_loop_add_to_cart_args( $args ) {
	$btn_classes = 'btn btn-outline-primary bg-white';

	if ( isset( $args['class'] ) && ! empty( $args['class'] ) ) {
		if ( ! is_string( $args['class'] ) ) {
			return $args;
		}

		// Remove the `button` class if it exists.
		if ( false !== strpos( $args['class'], 'button' ) ) {
			$args['class'] = explode( ' ', $args['class'] );
			$args['class'] = array_diff( $args['class'], array( 'button' ) );
			$args['class'] = implode( ' ', $args['class'] );
		}

		$args['class'] .= ' ' . $btn_classes;
	} else {
		$args['class'] = $btn_classes;
	}

	return $args;
}


add_filter( 'woocommerce_dropdown_variation_attribute_options_args', 'inharmony_wc_dropdown_variation_attribute_options_args');
function inharmony_wc_dropdown_variation_attribute_options_args($args) {

	if ( !isset($args['class'])) {
		$args['class'] = '';
	}

	$args['class'] .= ' form-select';

	return $args;
}


$show_wc_breadcrumbs = get_theme_mod( 'inharmony_show_wc_breadcrumbs', true);
if ( !$show_wc_breadcrumbs) {
	remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
}