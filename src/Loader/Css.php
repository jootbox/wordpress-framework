<?php

namespace Framework\Loader;

class Css {

	public function __construct() {
		add_action( 'wp_enqueue_scripts', [ $this, 'loadFrontendCss' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'loadAdminCss' ] );
	}

	/* ---
	  Functions
	--- */

	public function loadFrontendCss() {
		foreach ( apply_filters( 'wpf_loader_css_frontend', [] ) as $path ) {
			$this->registerStyle( $path );
		}
	}

	public function loadAdminCss( $path ) {
		foreach ( apply_filters( 'wpf_loader_css_admin', [] ) as $path ) {
			$this->registerStyle( $path );
		}
	}

	private function registerStyle( $source ) {
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

		wp_register_style( $handle, $url, '', $ver );
		wp_enqueue_style( $handle );
	}
}
