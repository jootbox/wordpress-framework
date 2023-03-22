<?php

namespace Framework\Helpers;

class Upload {

	public function __construct() {
		add_filter( 'wpf_upload_files', [ $this, 'uploadFiles' ], 10, 2 );
	}

	/* ---
	  Functions
	--- */

	public function uploadFiles( $value, $filesArrayIndex ) {
		$files    = $this->getFilesItem( $filesArrayIndex );
		$statuses = [];
		foreach ( $files as $file ) {
			$statuses[] = $this->uploadFile( $file );
		}
		return $statuses;
	}

	private function getFilesItem( $key ) {
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

	private function uploadFile( $file ) {
		if ( ! $file || ! file_exists( $file['tmp_name'] ) ) {
			return false;
		}

		$uploadDir = wp_upload_dir();
		$filename  = $this->makeUniqueFilename( basename( $file['name'] ), $uploadDir['path'] );
		$url       = $uploadDir['url'] . '/' . $filename;
		$path      = $uploadDir['path'] . '/' . $filename;

		$args = [
			'guid'           => $url,
			'post_mime_type' => $file['type'],
			'post_title'     => preg_replace( '/\.[^.]+$/', '', $filename ),
			'post_content'   => '',
			'post_status'    => 'inherit',
		];
		copy( $file['tmp_name'], $path );

		$fileId = wp_insert_attachment( $args, $path );
		if ( ! $fileId ) {
			return false;
		}

		require_once ABSPATH . 'wp-admin/includes/image.php';
		$fileData = wp_generate_attachment_metadata( $fileId, $path );
		wp_update_attachment_metadata( $fileId, $fileData );

		return $fileId;
	}

	private function makeUniqueFilename( $original, $directory ) {
		$filename = preg_replace( '/[^a-zA-Z0-9_.-]+/', '-', $original );
		$name     = pathinfo( $filename, PATHINFO_FILENAME );
		$ext      = pathinfo( $original, PATHINFO_EXTENSION );
		$path     = sprintf( '%s/%s.%s', $directory, $name, $ext );
		$index    = 1;

		while ( file_exists( $path ) ) {
			$path = sprintf( '%s/%s-%s.%s', $directory, $name, ++$index, $ext );
		}
		return ( $index === 1 ) ? $filename : sprintf( '%s-%s.%s', $name, $index, $ext );
	}
}
