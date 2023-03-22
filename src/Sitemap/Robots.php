<?php

namespace Framework\Sitemap;

class Robots {

	public function __construct() {
		add_filter( 'wpf_htaccess_security/robots_txt', [ $this, 'addSitemapUrl' ] );
	}

	/* ---
	  Functions
	--- */

	public function addSitemapUrl( $content ) {
		$url = sprintf( '%s/sitemap.xml', site_url( '' ) );

		$content .= PHP_EOL . 'Sitemap: ' . $url . PHP_EOL;
		return $content;
	}
}
