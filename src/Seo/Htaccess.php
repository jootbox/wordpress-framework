<?php

namespace Framework\Seo;

class Htaccess {

	public function __construct() {
		add_filter( 'mod_rewrite_rules', [ $this, 'cacheControlHeaders' ] );
	}

	/* ---
	  Functions
	--- */

	public function cacheControlHeaders( $rules ) {
		if ( ( substr( $_SERVER['REMOTE_ADDR'], 0, 4 ) == '127.' ) || ( $_SERVER['REMOTE_ADDR'] == '::1' ) ) {
			return $rules;
		}

		$content = PHP_EOL;
		$content .= '# BEGIN (Cache-Control)' . PHP_EOL;
		$content .= '  <IfModule mod_rewrite.c>' . PHP_EOL;
		$content .= '    RewriteEngine on' . PHP_EOL;
		$content .= '    RewriteCond %{REQUEST_URI} \.(gif|ico|jp?g|png|svg|webp|mp3|mp4|ogg|wav)$' . PHP_EOL;
		$content .= '    RewriteCond %{HTTP_REFERER} !(wp-admin)' . PHP_EOL;
		$content .= '    RewriteRule ^.*$ - [E=CACHE_EXISTS,E=CACHE_MEDIA]' . PHP_EOL;
		$content .= '    RewriteCond %{REQUEST_URI} \.(css|js|eot|otf|ttf|woff|woff2)$' . PHP_EOL;
		$content .= '    RewriteCond %{HTTP_REFERER} !(wp-admin)' . PHP_EOL;
		$content .= '    RewriteRule ^.*$ - [E=CACHE_EXISTS,E=CACHE_ASSETS]' . PHP_EOL;
		$content .= '  </IfModule>' . PHP_EOL;
		$content .= '  <IfModule mod_headers.c>' . PHP_EOL;
		$content .= '    Header set Cache-Control "max-age=31557600, public, must-revalidate" env=CACHE_MEDIA' . PHP_EOL;
		$content .= '    Header set Cache-Control "max-age=2592000, private, must-revalidate" env=CACHE_ASSETS' . PHP_EOL;
		$content .= '    Header unset Cache-Control env=!CACHE_EXISTS' . PHP_EOL;
		$content .= '  </IfModule>' . PHP_EOL;
		$content .= '# END SEO (Cache-Control)' . PHP_EOL;
		$content .= PHP_EOL;
		$content = apply_filters( 'wpf_htaccess_seo/cache_control', $content );

		return $content . $rules;
	}
}
