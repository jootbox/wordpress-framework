<?php

namespace Framework\Redirects;

class Rewrites {

	private $optionName = 'wpf_rewrites_list';

	public function __construct() {
		add_filter( 'mod_rewrite_rules', [ $this, 'rewriteOldUrls' ], 0 );
	}

	/* ---
	  Functions
	--- */

	public function rewriteOldUrls( $rules ) {
		$paths = get_option( $this->optionName, [] );
		if ( $paths === [] ) {
			return $rules;
		}

		$content = PHP_EOL;
		$content .= '# BEGIN SEO (Redirects 301)' . PHP_EOL;
		$content .= '  <IfModule mod_rewrite.c>' . PHP_EOL;
		$content .= '    RewriteEngine on' . PHP_EOL;
		$content .= '    RewriteCond %{REQUEST_FILENAME} -f [OR]' . PHP_EOL;
		$content .= '    RewriteCond %{REQUEST_URI} ^/wp-admin' . PHP_EOL;
		$content .= '    RewriteRule ^ - [L,QSA]' . PHP_EOL;

		foreach ( $paths as $path ) {
			$oldPath = '/?' . trim( $path['old'], '/ ' ) . '/?';
			$content .= '    RewriteRule ^' . $oldPath . '$ ' . $path['new'] . ' [R=301,L,NC]' . PHP_EOL;
		}

		$content .= '  </IfModule>' . PHP_EOL;
		$content .= '# END SEO (Redirects 301)' . PHP_EOL;
		$content .= PHP_EOL;
		$content = apply_filters( 'wpf_htaccess_redirects_301', $content );

		return $content . $rules;
	}
}
