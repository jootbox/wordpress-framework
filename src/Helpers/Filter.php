<?php

namespace Framework\Helpers;

class Filter {

	public function __construct() {
		add_filter( 'wpf_filter_data', [ $this, 'addFiltersForData' ], 10, 4 );
	}

	/* ---
	  Functions
	--- */

	public function addFiltersForData( $name, $data, $args, $nesting = null ) {
		if ( $nesting ) {
			$params = array_merge( [ sprintf( '%s_%s', $name, $nesting ), $data ], $args );
			$data   = call_user_func_array( 'apply_filters', $params );
		}
		$params = array_merge( [ $name, $data ], $args );
		$data   = call_user_func_array( 'apply_filters', $params );
		return $data;
	}
}
