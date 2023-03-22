<?php

namespace Framework\Roles;

class _Core {

	public function __construct() {
		new Access();
		new Attachment();
		new Langs();
		new Optionspage();
		new Posttype();
		new Taxonomy();
		new Update();
		new Values();
	}

	/* ---
	  Actions
	--- */

	public function action( $action, $args = false ) {
		switch ( $action ) {
			default:

				error_log( sprintf(
					'WordPress Framework: undefined action `%s` in Framework\\Roles\\_Core',
					$action
				) );

				break;
		}
	}
}
