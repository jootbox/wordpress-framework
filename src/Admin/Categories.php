<?php

namespace Framework\Admin;

class Categories {

	public function __construct() {
		add_filter( 'wp_terms_checklist_args', [ $this, 'termsChecklistFilter' ] );
	}

	/* ---
	  Functions
	--- */

	public function termsChecklistFilter( $args ) {
		$args['checked_ontop'] = false;
		return $args;
	}
}
