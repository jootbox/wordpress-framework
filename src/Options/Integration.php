<?php

namespace Framework\Options;

class Integration {

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
			'key'      => 'group_wpf4udppo7yjo',
			'title'    => __( 'Settings', 'wpf' ),
			'fields'   => [
				[
					'key'   => 'field_wpff2sxq5aevj',
					'label' => __( 'Module active?', 'wpf' ),
					'name'  => 'wpf_integration_active',
					'type'  => 'true_false',
				],
				[
					'key'   => 'field_wpfz7yrxmbpb9',
					'label' => __( 'Analytics', 'wpf' ),
					'name'  => '',
					'type'  => 'tab',
					'logic' => [
						[
							[
								'field'    => 'field_wpff2sxq5aevj',
								'operator' => '==',
								'value'    => 1,
							],
						],
					],
				],
				[
					'key'          => 'field_wpfsm8pbg5vfm',
					'label'        => __( 'Google Analytics UA code', 'wpf' ),
					'name'         => 'wpf_integration_google_analytics',
					'type'         => 'text',
					'instructions' => __( '(optionally; allowed value format: UA-000000-0)', 'wpf' ),
					'logic'        => [
						[
							[
								'field'    => 'field_wpff2sxq5aevj',
								'operator' => '==',
								'value'    => 1,
							],
						],
					],
				],
				[
					'key'          => 'field_wpfavkfv8s6e2',
					'label'        => __( 'Google Tag Manager GTM code', 'wpf' ),
					'name'         => 'wpf_integration_tag_manager',
					'type'         => 'text',
					'instructions' => __( '(optionally; allowed value format: GTM-XXXXXX)', 'wpf' ),
					'logic'        => [
						[
							[
								'field'    => 'field_wpff2sxq5aevj',
								'operator' => '==',
								'value'    => 1,
							],
						],
					],
				],
				[
					'key'          => 'field_wpf2ge9ywjv7c',
					'label'        => __( 'Facebook Pixel ID', 'wpf' ),
					'name'         => 'wpf_integration_pixel',
					'type'         => 'text',
					'instructions' => __( '(optionally; allowed value format: 000000000000000)', 'wpf' ),
					'logic'        => [
						[
							[
								'field'    => 'field_wpff2sxq5aevj',
								'operator' => '==',
								'value'    => 1,
							],
						],
					],
				],
				[
					'key'          => 'field_wpf2rjemz5gmf',
					'label'        => __( 'Hotjar', 'wpf' ),
					'name'         => 'wpf_integration_hotjar',
					'type'         => 'group',
					'instructions' => __( '(optionally)', 'wpf' ),
					'layout'       => 'row',
					'sub_fields'   => [
						[
							'key'   => 'field_wpfr578agesh5',
							'label' => __( 'Hotjar ID', 'wpf' ),
							'name'  => 'id',
							'type'  => 'text',
						],
						[
							'key'           => 'field_wpfq259k4u67z',
							'label'         => __( 'Hotjar Snippet Version', 'wpf' ),
							'name'          => 'snippet_version',
							'type'          => 'text',
							'default_value' => 5,
						],
					],
					'logic'        => [
						[
							[
								'field'    => 'field_wpff2sxq5aevj',
								'operator' => '==',
								'value'    => 1,
							],
						],
					],
				],
				[
					'key'   => 'field_wpf689y6d324w',
					'label' => __( 'Chat', 'wpf' ),
					'name'  => '',
					'type'  => 'tab',
					'logic' => [
						[
							[
								'field'    => 'field_wpff2sxq5aevj',
								'operator' => '==',
								'value'    => 1,
							],
						],
					],
				],
				[
					'key'          => 'field_wpf8t7casqskg',
					'label'        => __( 'LiveChat license number', 'wpf' ),
					'name'         => 'wpf_integration_livechat',
					'type'         => 'text',
					'instructions' => __( '(optionally; allowed value format: 00000000)', 'wpf' ),
					'logic'        => [
						[
							[
								'field'    => 'field_wpff2sxq5aevj',
								'operator' => '==',
								'value'    => 1,
							],
						],
					],
				],
				[
					'key'          => 'field_wpfc1fafbee6c',
					'label'        => __( 'Facebook Customer Chat', 'wpf' ),
					'name'         => 'facebook_customerchat',
					'type'         => 'group',
					'instructions' => __( '(optionally)', 'wpf' ),
					'layout'       => 'row',
					'sub_fields'   => [
						[
							'key'          => 'field_wpfryb8zur77n',
							'label'        => __( 'Facebook Page ID', 'wpf' ),
							'name'         => 'page_id',
							'type'         => 'text',
							'instructions' => __( '(allowed value format: 000000000000000; remember to add domain to white list in Facebook Page settings)', 'wpf' ),
						],
						[
							'key'          => 'field_wpferokremsya',
							'label'        => __( 'Theme color', 'wpf' ),
							'name'         => 'theme_color',
							'type'         => 'color_picker',
							'instructions' => __( '(optionally)', 'wpf' ),
						],
						[
							'key'          => 'field_wpf3opzxgr65w',
							'label'        => __( 'Greeting messages', 'wpf' ),
							'name'         => 'greeting',
							'type'         => 'group',
							'instructions' => __( '(optionally)', 'wpf' ),
							'layout'       => 'row',
							'sub_fields'   => [
								[
									'key'   => 'field_wpfeeo3yefj6',
									'label' => __( 'Logged in users', 'wpf' ),
									'name'  => 'logged_in_users',
									'type'  => 'text',
								],
								[
									'key'   => 'field_wpf64nz2osd53',
									'label' => __( 'Logged out users', 'wpf' ),
									'name'  => 'logged_out_users',
									'type'  => 'text',
								],
							],
						],
						[
							'key'           => 'field_wpf4rmqqmdhxh',
							'label'         => __( 'Hide by default?', 'wpf' ),
							'name'          => 'hide_default',
							'type'          => 'true_false',
							'default_value' => 1,
						],
					],
					'logic'        => [
						[
							[
								'field'    => 'field_wpff2sxq5aevj',
								'operator' => '==',
								'value'    => 1,
							],
						],
					],
				],
			],
			'location' => [
				[
					[
						'param'    => 'options_page',
						'operator' => '==',
						'value'    => 'wpf-integrations',
					],
				],
			],
		];

		$list = json_encode( $list );
		$list = str_replace( '"logic":', '"conditional_logic":', $list );
		$list = json_decode( $list, true );

		acf_add_local_field_group( $list );
	}
}
