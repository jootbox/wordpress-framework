<?php

namespace Framework\Acf;

class Json {

	public function __construct() {
		$this->createJsonDirectory();
	}

	/* ---
	  Functions
	--- */

	public function createJsonDirectory() {
		$path = get_stylesheet_directory() . '/acf-json/';
		if ( file_exists( $path ) ) {
			return;
		}

		mkdir( $path, 0777, true );
		$this->createIndexFile( $path );
	}

	public function createIndexFile( $path ) {
		$path .= 'index.php';
		if ( file_exists( $path ) ) {
			return;
		}

		$file    = fopen( $path, 'w' );
		$content = '<?php' . PHP_EOL . '// Silence is golden.';
		fwrite( $file, $content );
	}
}
