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