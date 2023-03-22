<?php

namespace Framework\Share;

class Cache {

	public function __construct() {
		add_action( 'acf/save_post', [ $this, 'cacheSettings' ] );
	}

	/* ---
	  Functions
	--- */

	public function cacheSettings( $postId ) {
		if ( ( strpos( $postId, 'options' ) === false )
			|| ! isset( $_GET['page'] ) || ( $_GET['page'] !== 'wpf-seo_share' ) ) {
			return;
		}

		$settings = $this->getSettings();
		$this->saveSettings( $settings );
	}

	private function getSettings() {
		$default    = get_field( 'wpf_seo_share_default', 'option' );
		$posttypes  = get_field( 'wpf_seo_share_posttypes', 'option' );
		$taxonomies = get_field( 'wpf_seo_share_taxonomies', 'option' );

		$list = [
			'default' => apply_filters( 'wpf_share_parse_data', $default ),
		];
		$list = $this->getSettingsForObject( $list, $posttypes, 'posttype' );
		$list = $this->getSettingsForObject( $list, $taxonomies, 'taxonomy' );

		return $list;
	}

	private function getSettingsForObject( $list, $values, $prefix ) {
		if ( ! $values ) {
			return $list;
		}

		foreach ( $values as $value ) {
			$key = sprintf( '%s-%s', $prefix, $value[ 'wpf_seo_share_' . $prefix ] );
			if ( ! $data = apply_filters( 'wpf_share_parse_data', $value ) ) {
				continue;
			}
			$list[ $key ] = $data;
		}

		return $list;
	}

	private function saveSettings( $list ) {
		if ( get_option( 'wpf_og_settings', null ) !== null ) {
			update_option( 'wpf_og_settings', $list );
		} else {
			add_option( 'wpf_og_settings', $list );
		}
	}
}
