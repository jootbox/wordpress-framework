<?php

namespace Framework\Share;

class _Core {

	public function __construct() {
		new Cache();
		new Data();
		new Og();
	}

	/* ---
	  Actions
	--- */

	public function action( $action, $args = false ) {
		switch ( $action ) {
			default:

				error_log( sprintf(
					'WordPress Framework: undefined action `%s` in Framework\\Share\\_Core',
					$action
				) );

				break;
		}
	}
}
