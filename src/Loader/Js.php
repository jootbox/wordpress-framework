<?php

namespace Framework\Loader;

class Js {

	public function __construct() {
		add_action( 'wp_enqueue_scripts', [ $this, 'loadFrontendJs' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'loadAdminJs' ] );
	}

	/* ---
	  Functions
	--- */

	public function loadFrontendJs() {
		foreach ( apply_filters( 'wpf_loader_js_frontend', [] ) as $path ) {
			$this->registerScript( $path );
		}
	}

	public function loadAdminJs( $path ) {
		foreach ( apply_filters( 'wpf_loader_js_admin', [] ) as $path ) {
			$this->registerScript( $path );
		}
	}

	private function registerScript( $source ) {
		$handle = md5( $source );

		if ( strpos( $source, 'http' ) !== false ) {
			$url   = $source;
			$parts = explode( '?ver=', $url );
			$ver   = ( count( $parts ) > 1 ) ? $parts[1] : '';
		} else {
			$url  = get_template_directory_uri() . '/' . trim( $source, '/' );
			$path = get_template_directory() . '/' . trim( $source, '/' );
			$ver  = file_exists( $path ) ? filemtime( $path ) : time();
		}

		wp_register_script( $handle, $url, [], $ver, true );
		wp_enqueue_script( $handle );
	}
}
