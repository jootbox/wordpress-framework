<?php

namespace Framework\Admin;

class Gutenberg {

	public function __construct() {
		add_filter( 'use_block_editor_for_post_type', [ $this, 'disableGutenberg' ], 10, 2 );
		add_filter( 'gutenberg_can_edit_post_type', [ $this, 'disableGutenberg' ], 10, 2 );
		add_action( 'wp_print_styles', [ $this, 'removeGutenbergStyles' ], 100 );
	}

	/* ---
	  Functions
	--- */

	public function disableGutenberg( $isEnabled, $postType ) {
		return apply_filters( 'wpf_admin_gutenberg_active', false );
	}

	public function removeGutenbergStyles() {
		if ( apply_filters( 'wpf_admin_gutenberg_active', false ) !== false ) {
			return;
		}
		wp_dequeue_style( 'wp-block-library' );
	}
}
