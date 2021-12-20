<?php

/*
 * Debugging
 */
if ( ! function_exists( 'write_to_log' ) ) {

	function write_to_log( $log ) {
		if ( true === WP_DEBUG && true === WP_DEBUG_LOG) {
			error_log( (is_array( $log ) || is_object( $log )) ? print_r( $log, true ) : $log );
		}
	}

}