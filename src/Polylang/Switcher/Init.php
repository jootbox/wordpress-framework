<?php

namespace Framework\Polylang\Switcher;

class Init {

	private $whiteCaps = [ 'administrator', 'loco_admin' ];

	public function __construct() {
		add_action( 'after_setup_theme', [ $this, 'initSwitchActions' ] );
	}

	/* ---
	  Functions
	--- */

	public function initSwitchActions() {
		if ( ( $user = wp_get_current_user() )
			&& ( $caps = apply_filters( 'wpf_polylang_switcher_caps', $this->whiteCaps, $user ) )
			&& ( $userCaps = array_keys( array_filter( $user->allcaps ) ) )
			&& ( array_intersect( $userCaps, $caps ) !== [] ) ) {
			return;
		}

		new Exclude();
		new Langs();
	}
}
