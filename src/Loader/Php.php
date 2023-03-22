<?php

namespace Framework\Loader;

class Php {
	/* ---
	  Actions
	--- */

	public function loadPhp( $path ) {
		$this->includeFiles( $path );
	}

	/* ---
	  Functions
	--- */

	private function includeFiles( $source ) {
		if ( ! $source ) {
			return;
		}

		$path  = get_template_directory() . '/' . trim( $source, '/' );
		$files = file_exists( $path ) ? scandir( $path ) : [];
		if ( ! $files ) {
			return;
		}

		foreach ( $files as $file ) {
			if ( pathinfo( $file, PATHINFO_EXTENSION ) != 'php' ) {
				continue;
			}
			require_once $path . '/' . $file;
		}
	}
}
