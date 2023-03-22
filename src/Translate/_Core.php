<?php

namespace Framework\Translate;

class _Core {

	public function __construct() {
		new Acf();
		new Js();
		new Lang();
		new Optionspages();
		new Theme();
	}

	/* ---
	  Actions
	--- */

	public function action( $action, $args ) {
		switch ( $action ) {
			case 'js':

				add_filter( 'wpf_translate_js_phrases', function ( $list ) use ( $args ) {
					return array_merge( $list, $args );
				} );

				break;
			default:

				error_log( sprintf(
					'WordPress Framework: undefined action `%s` in Framework\\Translate\\_Core',
					$action
				) );

				break;
		}
	}
}
