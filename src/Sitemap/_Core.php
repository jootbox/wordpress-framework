<?php

namespace Framework\Sitemap;

class _Core {

	public function __construct() {
		new Init();
	}

	/* ---
	  Actions
	--- */

	public function action( $action, $args = false ) {
		switch ( $action ) {
			default:

				error_log( sprintf(
					'WordPress Framework: undefined action `%s` in Framework\\Sitemap\\_Core',
					$action
				) );

				break;
		}
	}
}
