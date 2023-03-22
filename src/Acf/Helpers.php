<?php

namespace Framework\Acf;

class Helpers {

	public function __construct() {
		add_filter( 'wpf_acf_form_values', [ $this, 'getFormValues' ], 10, 2 );
	}

	/* ---
	  Functions
	--- */

	public function getFormValues( $value, $returnArray = false ) {
		$fields = $_POST['acf'];
		$keys   = [];
		$values = [];

		foreach ( $fields as $key => $value ) {
			$field = get_field_object( $key );
			$value = acf_format_value( $value, 'option', $field );

			$keys[]                   = $key;
			$values[ $field['name'] ] = $value;
		}

		if ( ! $returnArray ) {
			return $values;
		} else {
			return [
				'data' => $values,
				'keys' => $keys,
			];
		}
	}
}
