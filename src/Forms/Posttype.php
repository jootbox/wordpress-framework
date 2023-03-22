<?php

namespace Framework\Forms;

class Posttype {

	public function __construct() {
		add_action( 'after_setup_theme', [ $this, 'registerPostType' ] );
	}

	/* ---
	  Functions
	--- */

	public function registerPostType() {
		$args = [
			'slug'    => 'wpf-contact-forms',
			'rewrite' => 'wpf-contact-forms',
			'icon'    => 'dashicons-email-alt',
			'labels'  => [
				'name'     => __( 'Contact Forms', 'wpf' ),
				'menu'     => __( 'Contact Forms', 'wpf' ),
				'singular' => __( 'Contact Form', 'wpf' ),
				'add'      => __( 'Add new form', 'wpf' ),
			],
			'args'    => [
				'public'  => false,
				'show_ui' => true,
			],
		];

		add_filter( 'wpf_posttype_register', function ( $list ) use ( $args ) {
			return array_merge( $list, [ $args['slug'] => $args ] );
		} );
	}
}
