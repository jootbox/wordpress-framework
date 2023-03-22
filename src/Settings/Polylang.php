<?php

namespace Framework\Settings;

class Polylang {

	public function __construct() {
		add_action( 'wp_loaded', [ $this, 'lockRowsUpdate' ] );
	}

	/* ---
	  Functions
	--- */

	public function lockRowsUpdate() {
		remove_all_actions( 'wp_ajax_pll_update_post_rows' );
		remove_all_actions( 'wp_ajax_pll_update_term_rows' );
	}
}
