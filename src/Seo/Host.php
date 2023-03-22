<?php

namespace Framework\Seo;

class Host {

	public function __construct() {
		add_filter( 'mod_rewrite_rules', [ $this, 'redirectHost' ] );
	}

	/* ---
	  Functions
	--- */

	public function redirectHost( $rules ) {
		$siteUrl = site_url( '/' );
		$isHttps = ( strpos( $siteUrl, 'https' ) !== false );
		$isWww   = ( strpos( $siteUrl, 'www.' ) !== false );

		$content = PHP_EOL;
		$content .= '# BEGIN SEO (Redirect host)' . PHP_EOL;
		$content .= '  <IfModule mod_rewrite.c>' . PHP_EOL;
		$content .= '    RewriteEngine On' . PHP_EOL;
		$content .= '    RewriteCond %{SERVER_PORT} ' . ( $isHttps ? '80' : '443' ) . ' [OR]' . PHP_EOL;
		$content .= '    RewriteCond %{HTTP_HOST} ' . ( $isWww ? '!' : '' ) . '^www\. [NC]' . PHP_EOL;
		$content .= '    RewriteCond %{HTTP_HOST} ^(?:www\.)?(.+)$ [NC]' . PHP_EOL;
		$content .= '    RewriteRule ^ ' . ( $isHttps ? 'https' : 'http' ) . '://' . ( $isWww ? 'www.' : '' ) . '%1%{REQUEST_URI} [L,NE,R=301]' . PHP_EOL;
		$content .= '  </IfModule>' . PHP_EOL;
		$content .= '# END SEO (Redirect host)' . PHP_EOL;
		$content .= PHP_EOL;
		$content = apply_filters( 'wpf_htaccess_seo/redirect_host', $content );

		return $content . $rules;
	}
}
