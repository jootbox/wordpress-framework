<?php

namespace Framework\Acf;

class _Core {

	public function __construct() {
		new Flexible();
		new Groups();
		new Helpers();
		new Json();
		new Link();
		new Locale();
		new Location();
		new Wysiwyg();
	}

	/* ---
	  Actions
	--- */

	public function action( $action, $args = false ) {
		switch ( $action ) {
			case 'icons':

				( new Icons() )->setIconsList( $args );

				break;
			case 'optionspage':

				( new Optionspage() )->registerOptionsPage( $args );

				break;
			default:

				error_log( sprintf(
					'WordPress Framework: undefined action `%s` in Framework\\Acf\\_Core',
					$action
				) );

				break;
		}
	}
}
