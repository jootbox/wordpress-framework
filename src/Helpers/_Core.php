<?php

namespace Framework\Helpers;

class _Core {

	public function __construct() {
		new Breadcrumbs();
		new Date();
		new Favicons();
		new Filter();
		new Instagram();
		new Langs();
		new Menu();
		new Terms();
		new Upload();
	}

	/* ---
	  Actions
	--- */

	public function action( $action, $args = false ) {
		switch ( $action ) {
			default:

				error_log( sprintf(
					'WordPress Framework: undefined action `%s` in Framework\\Helpers\\_Core',
					$action
				) );

				break;
		}
	}
}
