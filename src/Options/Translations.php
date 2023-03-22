<?php

namespace Framework\Options;

class Translations {

	public function __construct() {
		add_action( 'init', [ $this, 'loadFields' ] );
	}

	/* ---
	  Functions
	--- */

	public function loadFields() {
		if ( ! function_exists( 'acf_add_local_field_group' ) ) {
			return;
		}

		$list = [
			'key'                   => 'group_wpf5kn9cqz4t2',
			'title'                 => __( 'Translations', 'wpf' ),
			'fields'                => [
				[
					'key'   => 'field_wpf8gztqbhqdb',
					'label' => __( 'Helpers', 'wpf' ),
					'name'  => '',
					'type'  => 'tab',
				],
				[
					'key'          => 'field_wpffjk8pr59mh',
					'label'        => __( 'Search Results', 'wpf' ),
					'name'         => 'wpf_translations_search_title',
					'type'         => 'text',
					'instructions' => sprintf(
						__( 'Default value: %s%s%s', 'wpf' ),
						'<strong>',
						__( 'Search results', 'wpf' ),
						'</strong>'
					),
				],
				[
					'key'   => 'field_wpfosxnkow3ca',
					'label' => __( 'Settings', 'wpf' ),
					'name'  => '',
					'type'  => 'tab',
				],
				[
					'key'          => 'field_wpf886xac9zfm',
					'label'        => __( 'Login page locked', 'wpf' ),
					'name'         => 'wpf_translations_login_page',
					'type'         => 'text',
					'instructions' => sprintf(
						__( 'Default value: %s%s%s', 'wpf' ),
						'<strong>',
						__( 'This page is locked.', 'wpf' ),
						'</strong>'
					),
				],
				[
					'key'          => 'field_wpf4ch89skhsy',
					'label'        => __( 'Login error', 'wpf' ),
					'name'         => 'wpf_translations_login_message',
					'type'         => 'text',
					'instructions' => sprintf(
						__( 'Default value: %s%s%s', 'wpf' ),
						'<strong>',
						__( '%sERROR%s: An error occured. Try again.', 'wpf' ),
						'</strong>'
					),
				],
			],
			'location'              => [
				[
					[
						'param'    => 'options_page',
						'operator' => '==',
						'value'    => 'wpf-translations',
					],
				],
			],
			'menu_order'            => 0,
			'position'              => 'normal',
			'style'                 => 'default',
			'label_placement'       => 'top',
			'instruction_placement' => 'label',
			'hide_on_screen'        => '',
			'active'                => 1,
			'description'           => '',
		];

		$list = json_encode( $list );
		$list = str_replace( '"logic":', '"conditional_logic":', $list );
		$list = json_decode( $list, true );

		acf_add_local_field_group( $list );
	}
}
