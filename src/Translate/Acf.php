<?php

namespace Framework\Translate;

class Acf {

	public function __construct() {
		add_filter( 'acf/settings/l10n', '__return_true' );
		add_filter( 'acf/settings/l10n_textdomain', [ $this, 'acfLocalization' ] );
		add_filter( 'acf/translate_field', [ $this, 'acfFieldTranslate' ] );
	}

	/* ---
	  Functions
	--- */

	public function acfLocalization() {
		return 'wpf';
	}

	public function acfFieldTranslate( $field ) {
		if ( ! isset( $field['default_value'] ) ) {
			return $field;
		}

		$field['default_value'] = acf_translate( $field['default_value'] );
		return $field;
	}
}
