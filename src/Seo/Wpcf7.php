<?php

namespace Framework\Seo;

class Wpcf7 {

	public function __construct() {
		add_filter( 'wpcf7_load_css', '__return_false' );
		add_action( 'wp_footer', [ $this, 'loadWpcf7InFooter' ] );
	}

	/* ---
	  Functions
	--- */

	public function loadWpcf7InFooter() {
		if ( ! function_exists( 'wpcf7_enqueue_styles' ) ) {
			return;
		}
		wpcf7_enqueue_styles();
	}
}
