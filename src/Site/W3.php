<?php

namespace Framework\Site;

class W3 {

	public function __construct() {
		add_action( 'get_header', [ $this, 'parseCodeStart' ] );
		add_action( 'wp_head', [ $this, 'parseCodeEnd' ], 999 );
		add_action( 'get_footer', [ $this, 'parseCodeStart' ] );
		add_action( 'wp_footer', [ $this, 'parseCodeEnd' ], 999 );
	}

	/* ---
	  Functions
	--- */

	public function parseCodeStart() {
		ob_start( function ( $output ) {
			return preg_replace( '/ type=[\'"]text\/javascript[\'"]/i', '', $output );
		} );
	}

	public function parseCodeEnd() {
		if ( ob_get_length() > 0 ) {
			ob_end_flush();
		}
	}
}
