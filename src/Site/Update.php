<?php

namespace Framework\Site;

class Update {

	public function __construct() {
		add_filter( 'auto_core_update_send_email', [ $this, 'disableUpdateEmails' ], 10, 4 );
	}

	/* ---
	  Functions
	--- */

	public function disableUpdateEmails( $send, $type, $coreUpdate, $result ) {
		if ( $type === 'success' ) {
			return false;
		} else {
			return $send;
		}
	}
}
