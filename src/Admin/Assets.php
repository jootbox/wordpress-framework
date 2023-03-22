<?php

namespace Framework\Admin;

class Assets {

	public function __construct() {
		add_action( 'admin_init', [ $this, 'loadAssets' ] );
	}

	/* ---
	  Functions
	--- */

	public function loadAssets() {
		$this->loadStyles();
		$this->loadScripts();
	}

	private function loadStyles() {
		$path = WPF_ASSETS . 'Admin/Assets.css?ver=' . WPF_VERSION;
		add_filter( 'wpf_loader_css_admin', function ( $list ) use ( $path ) {
			return array_merge( $list, [ $path ] );
		} );
	}

	private function loadScripts() {
		$path = WPF_ASSETS . 'Admin/Assets.js?ver=' . WPF_VERSION;
		add_filter( 'wpf_loader_js_admin', function ( $list ) use ( $path ) {
			return array_merge( $list, [ $path ] );
		} );
	}
}
