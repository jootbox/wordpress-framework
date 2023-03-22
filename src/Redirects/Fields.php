<?php

namespace Framework\Redirects;

class Fields {

	private $optionName = 'wpf_rewrites_list';

	public function __construct() {
		add_filter( 'acf/load_value/name=wpf_rewrites_list', [ $this, 'loadRedirectsList' ], 10, 3 );
	}

	/* ---
	  Functions
	--- */

	public function loadRedirectsList( $value, $postId, $field ) {
		$paths = get_option( $this->optionName, [] );
		if ( ! $paths ) {
			return [];
		}

		$items = [];
		foreach ( $paths as $value ) {
			$items[] = [
				$field['sub_fields'][0]['key'] => $value['old'],
				$field['sub_fields'][1]['key'] => $value['new'],
			];
		}
		return $items;
	}
}
