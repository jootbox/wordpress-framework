<?php

namespace Framework\Seo;

class Jquery {

	public function __construct() {
		add_action( 'wp_enqueue_scripts', [ $this, 'jQueryToFooter' ] );
	}

	/* ---
	  Functions
	--- */

	public function jQueryToFooter() {
		if ( ! is_admin() ) {
			wp_scripts()->add_data( 'jquery', 'group', 1 );
			wp_scripts()->add_data( 'jquery-core', 'group', 1 );
			wp_scripts()->add_data( 'jquery-migrate', 'group', 1 );
		}
	}
}
