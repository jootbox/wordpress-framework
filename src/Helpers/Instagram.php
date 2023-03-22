<?php

namespace Framework\Helpers;

class Instagram {

	private $path = 'https://api.instagram.com/v1/users/self/media/recent?access_token=%s&count=%d';

	public function __construct() {
		add_filter( 'wpf_instagram', [ $this, 'getFromInstagram' ], 10, 3 );
	}

	/* ---
	  Actions
	--- */

	public function getFromInstagram( $value, $token, $limit ) {
		return $this->getInstagramImages( $value, $token, $limit );
	}

	/* ---
	  Functions
	--- */

	public function getInstagramImages( $value, $token, $limit ) {
		$list    = [];
		$content = $this->getPage( $token, $limit );
		if ( ! $content ) {
			return $value;
		}

		foreach ( $content as $index => $image ) {
			$sizes = [];

			foreach ( $image['images'] as $size ) {
				$width           = $size['width'];
				$sizes[ $width ] = $size['url'];
			}

			$data = [
				'url'      => $image['link'],
				'src'      => end( $sizes ),
				'sizes'    => $sizes,
				'caption'  => isset( $image['caption']['text'] ) ? $image['caption']['text'] : '',
				'date'     => $image['created_time'],
				'stats'    => [
					'comments' => $image['comments']['count'],
					'likes'    => $image['likes']['count'],
				],
				'is_video' => ( $image['type'] == 'video' ) ? true : false,
			];

			$data   = apply_filters( 'wpf_instagram_item', $data, $image );
			$list[] = $data;
		}

		return $list;
	}

	private function getPage( $token, $count ) {
		$url = sprintf( $this->path, $token, $count );
		$ch  = curl_init();
		curl_setopt( $ch, CURLOPT_URL, $url );
		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 0 );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
		$response = curl_exec( $ch );
		if ( ! $response ) {
			return [];
		}

		$json = json_decode( $response, true );
		if ( ! $json || ! isset( $json['data'] ) ) {
			return [];
		}

		return $json['data'];
	}
}
