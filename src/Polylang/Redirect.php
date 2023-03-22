<?php

namespace Framework\Polylang;

class Redirect {

	public function __construct() {
		add_filter( 'admin_init', [ $this, 'redirectToDefaultLang' ] );
		add_filter( 'admin_init', [ $this, 'redirectPostLang' ] );
	}

	/* ---
	  Functions
	--- */

	public function redirectToDefaultLang() {
		if ( ( ! in_array( basename( $_SERVER['PHP_SELF'] ), [ 'admin.php' ] ) || ! isset( $_GET['page'] ) )
			|| ( ! function_exists( 'pll_current_language' ) || pll_current_language( 'locale' ) ) ) {
			return;
		}

		$url  = ( isset( $_SERVER['HTTPS'] ) ? 'https' : 'http' ) . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		$lang = pll_default_language();
		$url  .= ( ( strpos( $url, '?' ) !== false ) ? '&' : '?' ) . 'lang=' . $lang;

		if ( ! $lang ) {
			return;
		}
		wp_redirect( $url );
	}

	public function redirectPostLang() {
		if ( ! isset( $_GET['post'] ) || ! isset( $_GET['action'] ) || ( $_GET['action'] !== 'edit' )
			|| ! isset( $_GET['lang'] ) || ( $_GET['lang'] === 'all' )
			|| ( $_GET['lang'] === pll_get_post_language( $_GET['post'], 'slug' ) ) ) {
			return;
		}

		$translation = pll_get_post( $_GET['post'], $_GET['lang'] );
		$url         = get_edit_post_link( $translation, '' );

		if ( ! $translation || ! $url ) {
			return;
		}
		wp_redirect( $url );
	}
}
