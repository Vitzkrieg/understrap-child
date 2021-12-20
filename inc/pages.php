<?php

/**
 * this breaks the plugin 'Meny In Post' for displaying menus on the home page
 */
// if ( ! function_exists( 'ihl_the_title' ) ) {
// 	/**
// 	 * Replaces title text
// 	 *
// 	 * @param string $title
// 	 * @param int $id
// 	 *
// 	 * @return string 
// 	 */
// 	function ihl_the_title( $title, $id = null ) {

// 		if (is_front_page()) {
// 			return '';
// 		}

// 		return $title;
// 	}
// }

// // Filter page titles
// add_filter( 'the_title', 'ihl_the_title', 10, 2 );