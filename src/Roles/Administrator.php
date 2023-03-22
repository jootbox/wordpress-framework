<?php

namespace Framework\Roles;

class Administrator {

	public function __construct() {
		add_filter( 'user_has_cap', [ $this, 'addAdminCapabilities' ], 10, 4 );
	}

	/* ---
	  Functions
	--- */

	public function addAdminCapabilities( $allcaps, $cap, $args, $user ) {
		if ( ! in_array( 'administrator', $user->roles ) ) {
			return $allcaps;
		}

		$adminCaps  = array_unique( apply_filters( 'wpf_roles_admin_caps', [] ) );
		$capsValues = array_fill_keys( $adminCaps, true );
		return array_merge( $allcaps, $capsValues );
	}
}
