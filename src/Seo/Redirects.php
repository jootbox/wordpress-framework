<?php

namespace Framework\Seo;

class Redirects {

	public function __construct() {
		add_action( 'template_redirect', [ $this, 'redirectFromIndex' ] );
		add_action( 'template_redirect', [ $this, 'addTrailingSlash' ] );
	}

	/* ---
	  Functions
	--- */

	public function redirectFromIndex() {
		$url = $_SERVER['REQUEST_URI'];

		if ( substr( $url, -9 ) == 'index.php' ) {
			$url = str_replace( '/index.php', '/', $url );
			wp_redirect( $url, 301 );
		} else {
			if ( substr( $url, -10 ) == 'index.html' ) {
				$url = str_replace( '/index.html', '/', $url );
				wp_redirect( $url, 301 );
			}
		}
	}

	public function addTrailingSlash() {
		$url = $_SERVER['REQUEST_URI'];

		if ( ( ! isset( $_GET ) ) && ( substr( $url, -1 ) != '/' ) ) {
			$url = $url . '/';
			wp_redirect( $url, 301 );
		}
	}
}
