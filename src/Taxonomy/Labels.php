<?php

namespace Framework\Taxonomy;

class Labels {

	public function __construct() {
		add_filter( 'wpf_taxonomy_labels', [ $this, 'getTaxonomyLabels' ], 10, 2 );
	}

	/* ---
	  Functions
	--- */

	public function getTaxonomyLabels( $labels, $settings ) {
		return [
			'name'          => $settings['name'],
			'singular_name' => $settings['name'],
			'menu_name'     => '- ' . ( isset( $settings['menu'] ) ? $settings['menu'] : $settings['name'] ),
		];
	}
}
