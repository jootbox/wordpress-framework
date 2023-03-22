<?php

namespace Framework\Options;

class Sitemap {

	public function __construct() {
		$this->loadFields();
	}

	/* ---
	  Functions
	--- */

	public function loadFields() {
		if ( ! function_exists( 'acf_add_local_field_group' ) ) {
			return;
		}

		$list = [
			'key'                   => 'group_wpf4qy7hvxv9a',
			'title'                 => __( 'Settings', 'wpf' ),
			'fields'                => [
				[
					'key'   => 'field_wpfbeg5yjoydv',
					'label' => __( 'Module active?', 'wpf' ),
					'name'  => 'wpf_sitemap_active',
					'type'  => 'true_false',
				],
				[
					'key'           => 'field_wpfrhzxcjx8cn',
					'label'         => __( 'Sitemap path', 'wpf' ),
					'name'          => 'wpf_sitemap_path',
					'type'          => 'text',
					'required'      => 1,
					'readonly'      => 1,
					'default_value' => '/sitemap.xml',
					'logic'         => [
						[
							[
								'field'    => 'field_wpfbeg5yjoydv',
								'operator' => '==',
								'value'    => 1,
							],
						],
					],
				],
				[
					'key'   => 'field_wpf65nrw6waga',
					'label' => __( 'Posttypes in sitemap', 'wpf' ),
					'name'  => 'wpf_sitemap_posttypes',
					'type'  => 'checkbox',
					'logic' => [
						[
							[
								'field'    => 'field_wpfbeg5yjoydv',
								'operator' => '==',
								'value'    => 1,
							],
						],
					],
				],
				[
					'key'   => 'field_wpf8wfm5gc236',
					'label' => __( 'Taxonomies in sitemap', 'wpf' ),
					'name'  => 'wpf_sitemap_taxonomies',
					'type'  => 'checkbox',
					'logic' => [
						[
							[
								'field'    => 'field_wpfbeg5yjoydv',
								'operator' => '==',
								'value'    => 1,
							],
						],
					],
				],
			],
			'location'              => [
				[
					[
						'param'    => 'options_page',
						'operator' => '==',
						'value'    => 'wpf-sitemap',
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
