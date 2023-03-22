<?php

namespace Framework\Settings;

class Images {

	private $list = [];

	/* ---
	  Actions
	--- */

	public function addImageSizes( $list ) {
		$this->list = $list;

		add_action( 'after_setup_theme', [ $this, 'registerImageSizes' ] );
		add_filter( 'intermediate_image_sizes_advanced', [ $this, 'removeDefaultImageSizes' ] );
		add_filter( 'image_size_names_choose', [ $this, 'editorImageSizes' ] );
		add_filter( 'acf/get_image_sizes', [ $this, 'removeAcfImageSizes' ] );
	}

	/* ---
	  Functions
	--- */

	public function registerImageSizes() {
		if ( ! $this->list ) {
			return;
		}

		add_theme_support( 'post-thumbnails' );

		foreach ( $this->list as $name => $size ) {
			add_image_size( $name, $size['width'], $size['height'], $size['crop'] );
		}
	}

	public function removeDefaultImageSizes( $sizes ) {
		$allowed = [ 'thumbnail' ];
		$allowed = array_merge( $allowed, array_keys( $this->list ) );

		foreach ( $sizes as $slug => $size ) {
			if ( ! in_array( $slug, $allowed ) ) {
				unset( $sizes[ $slug ] );
			}
		}

		return $sizes;
	}

	public function editorImageSizes( $sizes ) {
		unset( $sizes['thumbnail'] );
		unset( $sizes['medium'] );
		unset( $sizes['medium_large'] );
		unset( $sizes['large'] );

		foreach ( $this->list as $slug => $size ) {
			if ( isset( $size['editor'] ) && $size['editor'] ) {
				$sizes[ $slug ] = $size['editor'];
			}
		}

		return $sizes;
	}

	public function removeAcfImageSizes( $sizes ) {
		unset( $sizes['medium'] );
		unset( $sizes['medium_large'] );
		unset( $sizes['large'] );

		return $sizes;
	}
}
