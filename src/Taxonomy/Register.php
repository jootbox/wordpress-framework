<?php

namespace Framework\Taxonomy;

class Register {

	public function __construct() {
		add_filter( 'init', [ $this, 'registerNewTaxonomies' ], 0 );
	}

	/* ---
	  Functions
	--- */

	public function registerNewTaxonomies() {
		$taxonomies = apply_filters( 'wpf_taxonomy_register', [] );
		foreach ( $taxonomies as $taxonomy => $args ) {
			register_taxonomy( $taxonomy, $args['posttypes'], $this->getTaxonomyArgs( $args ) );
		}
	}

	/* ---
	  Functions
	--- */

	public function getTaxonomyArgs( $config ) {
		$args      = isset( $config['args'] ) ? $config['args'] : [];
		$slug      = $config['slug'];
		$rewrite   = $config['rewrite'] ? $config['rewrite'] : $slug;
		$langs     = ( isset( $config['langs'] ) && $config['langs'] ) ? $config['langs'] : [];
		$postTypes = $config['posttypes'];

		$settings = [
			'labels'       => apply_filters( 'wpf_taxonomy_labels', [], $config['labels'] ),
			'hierarchical' => isset( $config['is_category'] ) ? $config['is_category'] : true,
			'rewrite'      => [
				'slug' => $rewrite,
			],
		];

		foreach ( $args as $key => $value ) {
			if ( ! isset( $settings[ $key ] ) ) {
				$settings[ $key ] = $value;
			} else {
				$settings[ $key ] = is_array( $value ) ? array_unique( array_merge( $settings[ $key ], $value ) ) : $value;
			}
		}

		add_filter( 'wpf_taxonomy_translate', function ( $list ) use ( $slug, $langs ) {
			if ( ! $langs ) {
				return $list;
			} else {
				return array_merge( $list, [ $slug => $langs ] );
			}
		} );

		return $settings;
	}
}
