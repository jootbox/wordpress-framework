<?php

namespace Framework\Forms;

class Files {
	/* ---
	  Files list
	--- */

	public function getFieldFiles( $key ) {
		$list = [];
		if ( ! isset( $_FILES[ $key ] ) ) {
			return $list;
		}

		foreach ( $_FILES[ $key ] as $var => $files ) {
			foreach ( $files as $index => $value ) {
				$list[ $index ][ $var ] = $value;
			}
		}

		return $list;
	}

	/* ---
	  Upload files
	--- */

	public function uploadFiles( $files ) {
		$path = $this->uploadDirectory();
		$list = [];
		if ( ! $files ) {
			return $list;
		}

		foreach ( $files as $file ) {
			$list[] = $this->uploadFile( $file, $path );
		}

		return $list;
	}

	private function uploadFile( $file, $path ) {
		$filename = preg_replace( '/[^a-zA-Z0-9_.-]+/', '-', $file['name'] );

		while ( file_exists( $filename ) ) {
			$rand     = '-' . str_pad( rand( 0, 999 ), 3, '0', STR_PAD_LEFT );
			$filename = implode( '', [
				pathinfo( $filename, PATHINFO_FILENAME ),
				$rand,
				'.' . pathinfo( $filename, PATHINFO_EXTENSION ),
			] );
		}

		$path   .= $filename;
		$handle = copy( $file['tmp_name'], $path );
		$data   = [
			'file' => $filename,
			'path' => $path,
		];

		return $handle ? $data : '';
	}

	private function uploadDirectory() {
		$uploadDir = wp_upload_dir();
		$path      = $uploadDir['basedir'] . '/wpf-uploads/';

		if ( ! file_exists( $path ) ) {
			wp_mkdir_p( $path );

			if ( $handle = fopen( $path . '.htaccess', 'w' ) ) {
				fwrite( $handle, 'Deny from all' );
				fclose( $handle );
			}
		}

		return $path;
	}

	/* ---
	  Remove uploaded files
	--- */

	public function removeFiles( $list ) {
		if ( ! $list ) {
			return;
		}

		foreach ( $list as $file ) {
			if ( file_exists( $file ) ) {
				unlink( $file );
			}
		}
	}
}
