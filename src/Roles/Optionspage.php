<?php

namespace Framework\Roles;

class Optionspage {

	public function __construct() {
		add_filter( 'acf/validate_options_page', [ $this, 'addCapabilitiesToSubpages' ] );
	}

	/* ---
	  Functions
	--- */

	public function addCapabilitiesToSubpages( $args ) {
		if ( current_user_can( 'administrator' ) || ! $args['parent_slug'] ) {
			return $args;
		}

		$args['capability'] = 'options_subpage_' . $args['menu_slug'];
		return $args;
	}
}
