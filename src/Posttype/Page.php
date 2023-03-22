<?php

namespace Framework\Posttype;

class Page {

	public function __construct() {
		add_filter( 'register_post_type_args', [ $this, 'posttypeFilter' ], 10, 2 );
	}

	/* ---
	  Functions
	--- */

	public function posttypeFilter( $args, $postType ) {
		if ( ! in_array( $postType, [ 'page' ] ) ) {
			return $args;
		}

		$args['public']  = false;
		$args['show_ui'] = false;
		return $args;
	}
}
