<?php

namespace Framework\Forms;

use Framework\Options as GlobalOptions;

class _Core {
	/* ---
	  Actions
	--- */

	public function action( $action, $args = false ) {
		switch ( $action ) {
			case 'load':

				new Scripts( $args );
				new GlobalOptions\Forms();
				new Endpoint();
				new Form();
				new Optionspage();
				new Posttype();

				break;
			default:

				error_log( sprintf(
					'WordPress Framework: undefined action `%s` in Framework\\Forms\\_Core',
					$action
				) );

				break;
		}
	}
}
