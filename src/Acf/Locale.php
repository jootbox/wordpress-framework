<?php

namespace Framework\Acf;

class Locale {

	public function __construct() {
		add_filter( 'acf/get_locale', [ $this, 'setDefaultLocale' ] );
	}

	/* ---
	  Functions
	--- */

	public function setDefaultLocale( $locale ) {
		$postType = $_GET['post_type'] ?? get_post_type( $_GET['post'] ?? null );
		$action   = $_REQUEST['action'] ?? null;
		if ( ( $postType !== 'acf-field-group' )
			&& ( $action !== 'acf/field_group/render_field_settings' ) ) {
			return $locale;
		}
		remove_action( 'acf/validate_field', 'acf_translate_field' );
		return null;
	}
}
