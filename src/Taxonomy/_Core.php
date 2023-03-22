<?php

namespace Framework\Taxonomy;

class _Core {

	public function __construct() {
		new Acf();
		new Labels();
		new Register();
	}

	/* ---
	  Actions
	--- */

	public function action( $action, $args = false ) {
		switch ( $action ) {
			case 'register':

				add_filter( 'wpf_taxonomy_register', function ( $list ) use ( $args ) {
					return array_merge( $list, [ $args['slug'] => $args ] );
				} );
				add_filter( 'pll_get_taxonomies', function ( $taxonomies, $isSettings ) use ( $args ) {
					return ! $isSettings ? $taxonomies : array_merge( $taxonomies, [ $args['slug'] => $args['slug'] ] );
				}, 10, 2 );

				break;
			default:

				error_log( sprintf(
					'WordPress Framework: undefined action `%s` in Framework\\Taxonomy\\_Core',
					$action
				) );

				break;
		}
	}
}
