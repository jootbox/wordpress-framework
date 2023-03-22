<?php

namespace Framework\Manage;

class Posttype {

	public function __construct() {
		add_action( 'admin_init', [ $this, 'loadPosttypes' ] );
	}

	/* ---
	  Functions
	--- */

	public function loadPosttypes() {
		$objects = apply_filters( 'wpf_posttype_register', [] );
		$slugs   = array_merge( [ 'post', 'page' ], array_keys( $objects ) );

		foreach ( $slugs as $slug ) {
			$columns = apply_filters( 'wpf_manage-' . $slug . '_columns', [] );
			( new Columns( $slug, $columns ) )->initActions();
			( new Sort( $slug, $columns ) )->initActions();

			$filters = apply_filters( 'wpf_manage-' . $slug . '_filters', [] );
			( new Filters( $slug, $filters ) )->initActions();
		}
	}
}
