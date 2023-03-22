<?php

namespace Framework\Seo;

class _Core {

	public function __construct() {
		new Attachment();
		new Host();
		new Htaccess();
		new Jquery();
		new Redirects();
		new Search();
		new Wpcf7();
	}

	/* ---
	  Actions
	--- */

	public function action( $action, $args = false ) {
		switch ( $action ) {
			default:

				error_log( sprintf(
					'WordPress Framework: undefined action `%s` in Framework\\Seo\\_Core',
					$action
				) );

				break;
		}
	}
}
