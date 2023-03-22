<?php

namespace Framework\Integration;

class Init {

	public function __construct() {
		add_action( 'acf/init', [ $this, 'initIntegartions' ] );
	}

	/* ---
	  Functions
	--- */

	public function initIntegartions() {
		$enable = ( function_exists( 'get_field' ) && get_field( 'wpf_integration_active', 'options' ) );
		if ( ! $enable ) {
			return;
		}

		new GoogleAnalytics();
		new TagManager();
		new FacebookPixel();
		new Hotjar();
		new LiveChat();
		new MessengerCustomerchat();
	}
}
