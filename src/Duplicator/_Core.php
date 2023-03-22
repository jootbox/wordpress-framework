<?php

namespace Framework\Duplicator;

class _Core {

	public function __construct() {
		new Actions();
		new Duplicate();
	}

	/* ---
	  Actions
	--- */

	public function action( $action, $args = false ) {
		switch ( $action ) {
			default:

				error_log( sprintf(
					'WordPress Framework: undefined action `%s` in Framework\\Duplicator\\_Core',
					$action
				) );

				break;
		}
	}
}
