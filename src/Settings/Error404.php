<?php

namespace Framework\Settings;

class Error404 {

	public function __construct() {
		add_filter( 'mod_rewrite_rules', [ $this, 'notExistsFileRedirect' ], 0 );
	}

	/* ---
	  Functions
	--- */

	public function notExistsFileRedirect( $rules ) {
		$content = PHP_EOL;
		$content .= '# BEGIN 404' . PHP_EOL;
		$content .= '  <IfModule mod_rewrite.c>' . PHP_EOL;
		$content .= '    RewriteEngine on' . PHP_EOL;
		$content .= '    RewriteCond %{REQUEST_FILENAME} !-f' . PHP_EOL;
		$content .= '    RewriteCond %{REQUEST_URI} ^/.*\.(gif|ico|jp?g|png|svg|webp|mp3|mp4|ogg|wav|css|js|eot|otf|ttf|woff|woff2)$ [NC]' . PHP_EOL;
		$content .= '    RewriteRule ^ - [L,R=404]' . PHP_EOL;
		$content .= '  </IfModule>' . PHP_EOL;
		$content .= '# END 404' . PHP_EOL;
		$content .= PHP_EOL;
		$content = apply_filters( 'wpf_htaccess_404', $content );

		return $content . $rules;
	}
}
