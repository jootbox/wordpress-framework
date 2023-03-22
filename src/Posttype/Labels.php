<?php

namespace Framework\Posttype;

class Labels {

	public function __construct() {
		add_filter( 'wpf_posttype_labels', [ $this, 'getPostTypeLabels' ], 10, 2 );
	}

	/* ---
	  Functions
	--- */

	public function getPostTypeLabels( $labels, $settings ) {
		return [
			'name'               => $settings['name'],
			'singular_name'      => $settings['name'],
			'add_new'            => __( 'Add new', 'wpf' ),
			'add_new_item'       => __( 'Add new', 'wpf' ),
			'edit_item'          => __( 'Edit', 'wpf' ),
			'new_item'           => __( 'Add new', 'wpf' ),
			'view_item'          => __( 'View', 'wpf' ),
			'all_items'          => __( 'List', 'wpf' ),
			'search_items'       => __( 'Search', 'wpf' ),
			'not_found'          => __( 'No items found.', 'wpf' ),
			'not_found_in_trash' => __( 'No items found in Trash.', 'wpf' ),
			'menu_name'          => isset( $settings['menu'] ) ? $settings['menu'] : $settings['name'],
		];
	}
}
