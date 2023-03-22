<?php

namespace Framework\Loader;

class _Core {

	public function __construct() {
		new Css();
		new Cssinline();
		new Js();
	}

	/* ---
	  Actions
	--- */

	public function action( $action, $args = false ) {
		switch ( $action ) {
			case 'css':

				add_filter( 'wpf_loader_css_frontend', function ( $list ) use ( $args ) {
					return array_merge( $list, (array) $args );
				} );

				break;
			case 'inline-css':

				if ( apply_filters( 'wpf_loader_cssinline_allowed', false ) === true ) {
					add_filter( 'wpf_loader_cssinline', function ( $list ) use ( $args ) {
						return array_merge( $list, (array) $args );
					} );
				} else {
					$this->action( 'css', $args );
				}

				break;
			case 'admin-css':

				add_filter( 'wpf_loader_css_admin', function ( $list ) use ( $args ) {
					return array_merge( $list, (array) $args );
				} );

				break;
			case 'js':

				add_filter( 'wpf_loader_js_frontend', function ( $list ) use ( $args ) {
					return array_merge( $list, (array) $args );
				} );

				break;
			case 'admin-js':

				add_filter( 'wpf_loader_js_admin', function ( $list ) use ( $args ) {
					return array_merge( $list, (array) $args );
				} );

				break;
			case 'php':

				foreach ( (array) $args as $arg ) {
					( new Php() )->loadPhp( $arg );
				}

				break;
			default:

				error_log( sprintf(
					'WordPress Framework: undefined action `%s` in Framework\\Loader\\_Core',
					$action
				) );

				break;
		}
	}
}
