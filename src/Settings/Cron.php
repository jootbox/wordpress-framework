<?php

namespace Framework\Settings;

class Cron {

	public function __construct() {
		add_filter( 'mod_rewrite_rules', [ $this, 'removeCronGetParametr' ] );
	}

	/* ---
	  Functions
	--- */

	public function removeCronGetParametr( $rules ) {
		if ( ! defined( 'ALTERNATE_WP_CRON' ) || ! ALTERNATE_WP_CRON ) {
			return $rules;
		}

		$content = PHP_EOL;
		$content .= '# BEGIN Alternate Cron' . PHP_EOL;
		$content .= '  <IfModule mod_rewrite.c>' . PHP_EOL;
		$content .= '    RewriteEngine on' . PHP_EOL;
		$content .= '    RewriteCond %{QUERY_STRING} ^(.*)&?doing_wp_cron=[^&]+&?(.*)$ [NC]' . PHP_EOL;
		$content .= '    RewriteRule ^/?(.*)$ /$1?%1%2 [R=301,L]' . PHP_EOL;
		$content .= '  </IfModule>' . PHP_EOL;
		$content .= '# END Alternate Cron' . PHP_EOL;
		$content .= PHP_EOL;
		$content = apply_filters( 'wpf_htaccess_cron', $content );

		return $content . $rules;
	}
}
