<?php

namespace Framework\Cache;

class _Core {
	/* ---
	  Actions
	--- */

	public function action( $action, $args = false ) {
		switch ( $action ) {
			case 'config':

				( new Clear() )->configClear( $args );
				( new Config() )->addConfig( $args );
				new Generate();
				( new Widget() )->addWidget( $args );

				break;
			default:

				error_log( sprintf(
					'WordPress Framework: undefined action `%s` in Framework\\Cache\\_Core',
					$action
				) );

				break;
		}
	}
}
