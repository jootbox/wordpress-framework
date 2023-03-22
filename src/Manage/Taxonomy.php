<?php

namespace Framework\Manage;

class Taxonomy {

	public function __construct() {
		add_action( 'admin_init', [ $this, 'loadTaxonomies' ] );
	}

	/* ---
	  Functions
	--- */

	public function loadTaxonomies() {
		$objects = apply_filters( 'wpf_taxonomy_register', [] );
		$slugs   = array_merge( [ 'category', 'post_tag' ], array_keys( $objects ) );

		foreach ( $slugs as $slug ) {
			$columns = apply_filters( 'wpf_manage-' . $slug . '_columns', [] );
			( new Columns( $slug, $columns ) )->initActions();
			( new Sort( $slug, $columns ) )->initActions();
		}
	}
}
