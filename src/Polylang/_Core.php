<?php

namespace Framework\Polylang;

class _Core {

	public function __construct() {
		if ( ! function_exists( 'pll_current_language' ) ) {
			return;
		}

		new Posttype\Rewrites();
		new Posttype\Slugs();
		new Switcher\Admin();
		new Switcher\Init();
		new Taxonomy\Rewrites();
		new Taxonomy\Slugs();
		new Redirect();
		new Restapi();
	}

	/* ---
	  Actions
	--- */

	public function action( $action, $args ) {
		switch ( $action ) {
			default:

				error_log( sprintf(
					'WordPress Framework: undefined action `%s` in Framework\\Polylang\\_Core',
					$action
				) );

				break;
		}
	}
}
