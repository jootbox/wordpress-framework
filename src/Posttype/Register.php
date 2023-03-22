<?php

namespace Framework\Posttype;

class Register {

	public function __construct() {
		add_filter( 'init', [ $this, 'registerNewPostTypes' ], 0 );
	}

	/* ---
	  Functions
	--- */

	public function registerNewPostTypes() {
		$postTypes = apply_filters( 'wpf_posttype_register', [] );
		foreach ( $postTypes as $postType => $args ) {
			register_post_type( $postType, $this->getPostTypeArgs( $args ) );
		}
	}

	private function getPostTypeArgs( $config ) {
		$args    = isset( $config['args'] ) ? $config['args'] : [];
		$slug    = $config['slug'];
		$rewrite = $config['rewrite'] ? $config['rewrite'] : $slug;
		$langs   = ( isset( $config['langs'] ) && $config['langs'] ) ? $config['langs'] : [];
		$labels  = new Labels( $config['labels'] );

		$settings = [
			'labels'        => apply_filters( 'wpf_posttype_labels', [], $config['labels'] ),
			'public'        => true,
			'has_archive'   => true,
			'rewrite'       => [
				'slug' => $rewrite,
			],
			'menu_position' => 30,
			'menu_icon'     => $config['icon'],
			'supports'      => [ 'title', 'revisions' ],
		];

		foreach ( $args as $key => $value ) {
			if ( ! isset( $settings[ $key ] ) ) {
				$settings[ $key ] = $value;
			} else {
				$settings[ $key ] = is_array( $value ) ? array_unique( array_merge( $settings[ $key ], $value ) ) : $value;
			}
		}

		add_filter( 'wpf_posttype_translate', function ( $list ) use ( $slug, $langs, $settings ) {
			if ( ! $langs ) {
				return $list;
			} else {
				return array_merge( $list, [ $slug => [
					'translations' => $langs,
					'has_archive'  => $settings['has_archive'],
				] ] );
			}
		} );

		return $settings;
	}
}
