<?php

namespace Framework\Helpers;

class Langs {

	public function __construct() {
		add_filter( 'wpf_langs', [ $this, 'getLangs' ], 10, 2 );
	}

	/* ---
	  Actions
	--- */

	public function getLangs( $value, $sortKey ) {
		return $this->getLangsList( $value, $sortKey );
	}

	/* ---
	  Functions
	--- */

	public function getLangsList( $value, $sortKey ) {
		$langs = function_exists( 'pll_the_languages' ) ? pll_the_languages( [ 'raw' => true ] ) : [];
		if ( ! $langs ) {
			return $value;
		}

		$list = [
			'current' => [],
			'others'  => [],
		];

		foreach ( $langs as $lang ) {
			if ( $lang['no_translation'] ) {
				continue;
			}

			if ( in_array( 'current-lang', $lang['classes'] ) ) {
				$list['current'] = $this->getLang( $lang );
			} else {
				$list['others'][] = $this->getLang( $lang );
			}
		}

		if ( $list['others'] ) {
			usort( $list['others'], function ( $a, $b ) use ( $sortKey ) {
				if ( $a[ $sortKey ] === $b[ $sortKey ] ) {
					return;
				}
				return $a[ $sortKey ] > $b[ $sortKey ];
			} );
		}

		return $list;
	}

	private function getLang( $lang ) {
		$data = [
			'url'   => $lang['url'],
			'slug'  => $lang['slug'],
			'title' => $lang['name'],
		];

		$data = apply_filters( 'wpf_langs_item', $data, $lang );
		return $data;
	}
}
