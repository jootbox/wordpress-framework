<?php

namespace Framework\Forms;

class Optionspage {

	public function __construct() {
		add_action( 'wpf_options_page_args', [ $this, 'addNewOptionsPage' ] );
	}

	/* ---
	  Functions
	--- */

	public function addNewOptionsPage( $args ) {
		if ( ! isset( $args['pages'] ) ) {
			$args['pages'] = [];
		}
		$args['pages']['contact_forms'] = __( 'Contact Forms', 'wpf' );

		if ( ! isset( $args['notranslate'] ) ) {
			$args['notranslate'] = [];
		}
		$args['notranslate'][] = 'contact_forms';

		return $args;
	}
}
