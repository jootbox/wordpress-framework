<?php

namespace Framework\Options;

class Redirects {

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
			'key'                   => 'group_wpf6qto9exj62',
			'title'                 => __( '301 Redirects', 'wpf' ),
			'fields'                => [
				[
					'key'          => 'field_wpf25ajauae9e',
					'label'        => __( 'Append new paths', 'wpf' ),
					'name'         => 'wpf_rewrites_paths',
					'instructions' => sprintf(
						__( '(enter each link in new line; links will be sorted and added to list below)%sExample single line: %s', 'wpf' ),
						'<br>',
						'<code>/about-us.html : /about-us</code>'
					),
					'type'         => 'textarea',
					'logic'        => [
						[
							[
								'field'    => 'field_wpf7qwjsbfdmb',
								'operator' => '!=',
								'value'    => '1',
							],
						],
					],
				],
				[
					'key'          => 'field_wpf7ef5agy9tz',
					'label'        => __( 'Remove domain prefix', 'wpf' ),
					'name'         => 'wpf_rewrites_paths_domain',
					'instructions' => sprintf(
						__( '(example: %s - add if redirects are for one domain)', 'wpf' ),
						'<code>https://domain.com</code>'
					),
					'type'         => 'text',
					'logic'        => [
						[
							[
								'field'    => 'field_wpf25ajauae9e',
								'operator' => '!=',
								'value'    => '',
							],
							[
								'field'    => 'field_wpf7qwjsbfdmb',
								'operator' => '!=',
								'value'    => '1',
							],
						],
					],
				],
				[
					'key'          => 'field_wpf7qwjsbfdmb',
					'label'        => __( 'Clear all redirects list?', 'wpf' ),
					'name'         => 'wpf_rewrites_is_clear',
					'instructions' => sprintf(
						__( '(this option will %sclear entire redirects list%s)', 'wpf' ),
						'<u>',
						'</u>'
					),
					'type'         => 'true_false',
					'logic'        => [
						[
							[
								'field'    => 'field_wpf25ajauae9e',
								'operator' => '==',
								'value'    => '',
							],
						],
					],
				],
				[
					'key'   => 'field_wpf7zresafxnu',
					'label' => __( 'Save as CSV', 'wpf' ),
					'name'  => 'wpf_rewrites_save_as_csv',
					'type'  => 'message',
					'logic' => [
						[
							[
								'field'    => 'field_wpf7qwjsbfdmb',
								'operator' => '==',
								'value'    => '',
							],
						],
					],
				],
				[
					'key'          => 'field_wpf8g4opg2jwz',
					'label'        => __( 'Redirects list', 'wpf' ),
					'name'         => 'wpf_rewrites_list',
					'instructions' => __( '(check Homepage after saving - if it does not work, it means that one of redirect contains forbidden chars)', 'wpf' ),
					'type'         => 'repeater',
					'layout'       => 'table',
					'button_label' => __( 'Add new redirect', 'wpf' ),
					'sub_fields'   => [
						[
							'key'          => 'field_wpf8um7nxw2ke',
							'label'        => __( 'Old path', 'wpf' ),
							'name'         => 'old',
							'type'         => 'text',
							'instructions' => sprintf(
								__( '(examples: %s)', 'wpf' ),
								'<code>/about-us.html</code>, <code>/products/([0-9]+)</code> / <code>/products/([^/]+)</code>'
							),
						],
						[
							'key'           => 'field_wpf5o4gsnbt2z',
							'label'         => __( 'New path', 'wpf' ),
							'name'          => 'new',
							'type'          => 'text',
							'default_value' => '/',
							'instructions'  => sprintf(
								__( '(examples: %s)', 'wpf' ),
								'<code>/about-us</code>, <code>/products/$1</code>, <code>https://domain.com/about-us</code>'
							),
						],
					],
				],
			],
			'location'              => [
				[
					[
						'param'    => 'options_page',
						'operator' => '==',
						'value'    => 'wpf-redirects_301',
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
