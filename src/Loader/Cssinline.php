<?php

namespace Framework\Loader;

class Cssinline {

	public function __construct() {
		add_filter( 'wpf_loader_cssinline_allowed', [ $this, 'isInlineAllowed' ] );
		add_action( 'wp_head', [ $this, 'printStyles' ], 1000 );
	}

	/* ---
	  Functions
	--- */

	public function isInlineAllowed() {
		return ( ( substr( $_SERVER['REMOTE_ADDR'], 0, 4 ) != '127.' ) && ( $_SERVER['REMOTE_ADDR'] != '::1' )
			&& ( isset( $_SERVER['HTTP_USER_AGENT'] ) && ( strpos( $_SERVER['HTTP_USER_AGENT'], 'validator.w3.org' ) === false ) ) );
	}

	public function printStyles() {
		foreach ( apply_filters( 'wpf_loader_cssinline', [] ) as $path ) {
			$this->printStyle( $path );
		}
	}

	private function printStyle( $source ) {
		$path     = trim( $source, '/' );
		$handle   = md5( $source );
		$themeUrl = get_template_directory_uri() . '/';
		$filePath = get_template_directory() . '/' . $path;
		$nesting  = explode( '/', dirname( $path ) );
		$content  = file_exists( $filePath ) ? file_get_contents( $filePath ) : '';
		$count    = count( $nesting );

		for ( $i = $count; $i > 0; $i-- ) {
			$replace = $themeUrl;

			if ( $i < $count ) {
				$replace .= implode( '/', array_slice( $nesting, 0, ( $count - $i ) ) ) . '/';
			}

			$content = preg_replace( '/(\.\.\/){' . $i . '}/i', $replace, $content );
		}

		?>
		<style id="css-<?php echo $handle; ?>"><?php echo $content; ?></style>
		<?php
	}
}
