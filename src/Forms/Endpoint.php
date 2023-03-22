<?php

namespace Framework\Forms;

class Endpoint {

	public function __construct() {
		add_action( 'rest_api_init', [ $this, 'registerApiEndpoint' ] );
		add_filter( 'wpf_forms_api_url', [ $this, 'getRestApiUrl' ], 10, 2 );
	}

	/* ---
	  Functions
	--- */

	public function registerApiEndpoint() {
		register_rest_route(
			'wpf/v1',
			'forms/(?P<_form_id>\d+)',
			[
				'methods'             => 'POST',
				'callback'            => function ( $request ) {
					return ( new Send() )->sendForm( $request );
				},
				'permission_callback' => function () {
					return true;
				},
				'args'                => [],
			]
		);
	}

	public function getRestApiUrl( $value, $formId ) {
		$path = implode( '/', [ 'wpf/v1', 'forms', $formId ] );
		return get_rest_url( null, $path . '/' );
	}
}
