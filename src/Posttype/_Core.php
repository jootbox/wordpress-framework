<?php

namespace Framework\Posttype;

class _Core {

	public function __construct() {
		new Acf();
		new Labels();
		new Menu();
		new Register();
	}

	/* ---
	  Actions
	--- */

	public function action( $action, $args = false ) {
		switch ( $action ) {
			case 'register':

				add_filter( 'wpf_posttype_register', function ( $list ) use ( $args ) {
					return array_merge( $list, [ $args['slug'] => $args ] );
				} );
				add_filter( 'pll_get_post_types', function ( $postTypes, $isSettings ) use ( $args ) {
					return ! $isSettings ? $postTypes : array_merge( $postTypes, [ $args['slug'] => $args['slug'] ] );
				}, 10, 2 );

				break;
			default:

				error_log( sprintf(
					'WordPress Framework: undefined action `%s` in Framework\\Posttype\\_Core',
					$action
				) );

				break;
		}
	}
}
