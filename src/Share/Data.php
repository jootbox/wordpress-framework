<?php

namespace Framework\Share;

class Data {

	public function __construct() {
		add_filter( 'wpf_share_parse_data', [ $this, 'parseData' ] );
	}

	/* ---
	  Functions
	--- */

	public function parseData( $value ) {
		$data = [
			'title'         => $value['title'] ?? '',
			'is_meta_title' => $value['is_meta_title'] ?? false,
			'desc'          => $value['desc'] ?? '',
			'desc_search'   => $value['desc_search'] ?: ( $value['desc'] ?? '' ),
			'image'         => [],
		];

		if ( isset( $value['image'] ) && $value['image'] ) {
			$data['image'] = [
				'url'    => $value['image']['url'] ?? '',
				'width'  => $value['image']['width'] ?? '',
				'height' => $value['image']['height'] ?? '',
			];
		}

		foreach ( $data as $key => $value ) {
			if ( ! $value ) {
				unset( $data[ $key ] );
			}
		}
		return $data;
	}
}
