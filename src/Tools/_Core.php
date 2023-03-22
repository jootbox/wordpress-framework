<?php

namespace Framework\Tools;

class _Core {
	/* ---
	  Actions
	--- */

	public function action( $action, $args = false ) {
		switch ( $action ) {
			case 'cleaner':

				new Cleaner();

				break;
			case 'stats':

				( new Stats() )->configStats( $args );

				break;
			case 'validate-categories':

				( new Categories() )->addValidation( $args );

				break;
			default:

				error_log( sprintf(
					'WordPress Framework: undefined action `%s` in Framework\\Tools\\_Core',
					$action
				) );

				break;
		}
	}
}
