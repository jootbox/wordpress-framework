<?php

namespace Framework\Redirects;

class _Core {

	public function __construct() {
		new Cache();
		new Export();
		new Fields();
		new Rewrites();
	}

	/* ---
	  Actions
	--- */

	public function action( $action, $args = false ) {
		switch ( $action ) {
			default:

				error_log( sprintf(
					'WordPress Framework: undefined action `%s` in Framework\\Redirects\\_Core',
					$action
				) );

				break;
		}
	}
}
