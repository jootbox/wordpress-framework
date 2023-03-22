<?php

namespace Framework\Helpers;

class Favicons {

	public function __construct() {
		add_action( 'wpf_favicons', [ $this, 'showFavicons' ] );
		add_filter( 'mod_rewrite_rules', [ $this, 'redirectFavicon' ] );
	}

	/* ---
	  Actions
	--- */

	public function showFavicons( $path ) {
		$this->savePath( $path );
		echo $this->getFaviconsMetaTags( $path );
	}

	/* ---
	  Functions
	--- */

	public function redirectFavicon( $rules ) {
		$directory = get_option( 'wpf_favicons_path', '' );
		if ( ! $directory ) {
			return $rules;
		}

		$directory = '/' . trim( $directory, '/' ) . '/';
		$path      = str_replace( site_url( '/' ), '/', get_template_directory_uri() ) . $directory;

		$content = PHP_EOL;
		$content .= '# BEGIN Favicon (Redirect file)' . PHP_EOL;
		$content .= '  <IfModule mod_rewrite.c>' . PHP_EOL;
		$content .= '    RewriteEngine On' . PHP_EOL;
		$content .= '    RewriteRule ^favicon.ico$ ' . $path . 'favicon.ico [NC,L]' . PHP_EOL;
		$content .= '  </IfModule>' . PHP_EOL;
		$content .= '# END Favicon (Redirect file)' . PHP_EOL;
		$content .= PHP_EOL;
		$content = apply_filters( 'wpf_htaccess_favicons', $content );

		return $content . $rules;
	}

	private function savePath( $path ) {
		$value = get_option( 'wpf_favicons_path', null );
		if ( $value === $path ) {
			return;
		}

		if ( $value !== null ) {
			update_option( 'wpf_favicons_path', $path );
		} else {
			add_option( 'wpf_favicons_path', $path );
		}
	}

	public function getFaviconsMetaTags( $path ) {
		$content = '';
		$url     = get_template_directory_uri() . '/' . trim( $path, '/' );

		$content .= PHP_EOL;
		$content .= '<link rel="apple-touch-icon" sizes="57x57" href="' . $url . '/apple-icon-57x57.png">' . PHP_EOL;
		$content .= '<link rel="apple-touch-icon" sizes="60x60" href="' . $url . '/apple-icon-60x60.png">' . PHP_EOL;
		$content .= '<link rel="apple-touch-icon" sizes="72x72" href="' . $url . '/apple-icon-72x72.png">' . PHP_EOL;
		$content .= '<link rel="apple-touch-icon" sizes="76x76" href="' . $url . '/apple-icon-76x76.png">' . PHP_EOL;
		$content .= '<link rel="apple-touch-icon" sizes="114x114" href="' . $url . '/apple-icon-114x114.png">' . PHP_EOL;
		$content .= '<link rel="apple-touch-icon" sizes="120x120" href="' . $url . '/apple-icon-120x120.png">' . PHP_EOL;
		$content .= '<link rel="apple-touch-icon" sizes="144x144" href="' . $url . '/apple-icon-144x144.png">' . PHP_EOL;
		$content .= '<link rel="apple-touch-icon" sizes="152x152" href="' . $url . '/apple-icon-152x152.png">' . PHP_EOL;
		$content .= '<link rel="apple-touch-icon" sizes="180x180" href="' . $url . '/apple-icon-180x180.png">' . PHP_EOL;
		$content .= '<link rel="icon" type="image/png" sizes="192x192"  href="' . $url . '/android-icon-192x192.png">' . PHP_EOL;
		$content .= '<link rel="icon" type="image/png" sizes="32x32" href="' . $url . '/favicon-32x32.png">' . PHP_EOL;
		$content .= '<link rel="icon" type="image/png" sizes="96x96" href="' . $url . '/favicon-96x96.png">' . PHP_EOL;
		$content .= '<link rel="icon" type="image/png" sizes="16x16" href="' . $url . '/favicon-16x16.png">' . PHP_EOL;
		$content .= '<link rel="manifest" href="' . $url . '/site.webmanifest">' . PHP_EOL;
		$content .= '<meta name="msapplication-TileColor" content="#ffffff">' . PHP_EOL;
		$content .= '<meta name="msapplication-TileImage" content="' . $url . '/ms-icon-144x144.png">' . PHP_EOL;
		$content .= '<meta name="theme-color" content="#ffffff">' . PHP_EOL;
		$content .= PHP_EOL;

		return $content;
	}
}
