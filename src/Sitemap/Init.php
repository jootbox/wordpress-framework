<?php

namespace Framework\Sitemap;

class Init {

	public function __construct() {
		add_action( 'acf/init', [ $this, 'initIntegartions' ] );
	}

	/* ---
	  Functions
	--- */

	public function initIntegartions() {
		$enable = ( function_exists( 'get_field' ) && get_field( 'wpf_sitemap_active', 'option' ) );
		if ( ! $enable ) {
			return;
		}

		new Output();
		new Rewrite();
		new Robots();
		new Stylesheet();
	}
}
