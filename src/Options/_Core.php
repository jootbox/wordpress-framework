<?php

namespace Framework\Options;

class _Core {

	public function __construct() {
		new Duplicator();
		new Integration();
		new Page();
		new Phpmailer();
		new Translations();
		new Redirects();
		new Roles();
		new Share();
		new Sitemap();
	}

	/* ---
	  Actions
	--- */

	public function action( $action, $args = false ) {
		switch ( $action ) {
			default:

				error_log( sprintf(
					'WordPress Framework: undefined action `%s` in Framework\\Options\\_Core',
					$action
				) );

				break;
		}
	}
}
