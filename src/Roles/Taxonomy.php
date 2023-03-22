<?php

namespace Framework\Roles;

class Taxonomy {

	public function __construct() {
		add_filter( 'register_taxonomy_args', [ $this, 'addCapabilitiesToTaxonomy' ], 10, 3 );
	}

	/* ---
	  Functions
	--- */

	public function addCapabilitiesToTaxonomy( $args, $taxonomy, $objectType ) {
		if ( current_user_can( 'administrator' )
			|| ! array_key_exists( $taxonomy, apply_filters( 'wpf_taxonomy_register', [] ) ) ) {
			return $args;
		}

		$args = array_merge( $args, [
			'capabilities' => [
				'assign_terms' => 'assign_' . $taxonomy,
				'delete_terms' => 'delete_' . $taxonomy,
				'edit_terms'   => 'edit_' . $taxonomy,
				'manage_terms' => 'manage_' . $taxonomy,
			],
		] );
		return $args;
	}
}
