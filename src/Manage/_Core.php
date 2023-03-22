<?php

namespace Framework\Manage;

class _Core {

	public function __construct() {
		new Defaults();
		new Posttype();
		new Taxonomy();
	}

	/* ---
	  Actions
	--- */

	public function action( $action, $args = false ) {
		switch ( $action ) {
			default:

				error_log( sprintf(
					'WordPress Framework: undefined action `%s` in Framework\\Manage\\_Core',
					$action
				) );

				break;
		}
	}
}
