<?php

namespace Framework\Settings;

class Browsersync {

	public function __construct() {
		$this->removeCanonicalRedirect();
	}

	/* ---
	  Functions
	--- */

	public function removeCanonicalRedirect() {
		if ( ! defined( 'WP_DEBUG' ) || ! WP_DEBUG ) {
			return;
		}
		remove_action( 'template_redirect', 'redirect_canonical' );
	}


}
