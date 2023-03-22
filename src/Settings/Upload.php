<?php

namespace Framework\Settings;

class Upload {

	private $list;

	/* ---
	  Actions
	--- */

	public function addTypesForUpload( $list ) {
		$this->list = $list;

		add_action( 'upload_mimes', [ $this, 'setAllowTypes' ] );
		add_filter( 'wp_check_filetype_and_ext', [ $this, 'checkMimes' ], 10, 4 );
	}

	/* ---
	  Functions
	--- */

	public function setAllowTypes( $mimes ) {
		if ( ! $this->list ) {
			return $mimes;
		}

		foreach ( $this->list as $extension => $type ) {
			$mimes[ $extension ] = $type;
		}

		return $mimes;
	}

	public function checkMimes( $check, $file, $filename, $mimes ) {
		if ( ! empty( $check['ext'] ) || ! empty( $check['type'] ) || ! $this->list ) {
			return $check;
		}

		$detect = wp_check_filetype( $filename, $this->list );
		return [
			'ext'             => $detect['ext'],
			'type'            => $detect['type'],
			'proper_filename' => $check['proper_filename'],
		];
	}
}
