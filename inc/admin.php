<?php

add_filter( 'show_admin_bar', 'inharmony_show_admin_bar' );

if ( ! function_exists( 'inharmony_show_admin_bar' ) ) {
	/**
	 * Hides admin bar
	 *
	 * @return boolean
	 */
	function inharmony_show_admin_bar() {

		return false;
	}
}