<?php

namespace Framework\Admin;

class Bar {

	public function __construct() {
		$this->hideAdminBar();
	}

	/* ---
	  Functions
	--- */

	private function hideAdminBar() {
		if ( ! current_user_can( 'administrator' ) ) {
			add_filter( 'show_admin_bar', '__return_false' );
			return;
		}

		add_action( 'get_header', [ $this, 'removeDefaultStyles' ], 100 );
		add_action( 'init', [ $this, 'loadAssets' ] );
	}

	public function removeDefaultStyles() {
		remove_action( 'wp_head', 'wp_admin_bar_header' );
		remove_action( 'wp_head', '_admin_bar_bump_cb' );
	}

	public function loadAssets() {
		$this->loadStyles();
		$this->loadScripts();
	}

	private function loadStyles() {
		$path = WPF_ASSETS . 'Admin/Bar.css';
		add_filter( 'wpf_loader_css_frontend', function ( $list ) use ( $path ) {
			return array_merge( $list, [ $path ] );
		} );
	}

	private function loadScripts() {
		$path = WPF_ASSETS . 'Admin/Bar.js';
		add_filter( 'wpf_loader_js_frontend', function ( $list ) use ( $path ) {
			return array_merge( $list, [ $path ] );
		} );
	}
}
