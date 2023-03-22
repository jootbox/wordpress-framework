<?php

namespace Framework\Options;

class Phpmailer {

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
			'key'                   => 'group_wpfsec69vjrfq',
			'title'                 => __( 'Settings', 'wpf' ),
			'fields'                => [
				[
					'key'   => 'field_wpf9bzgqsaudq',
					'label' => __( 'Module active?', 'wpf' ),
					'name'  => 'wpf_phpmailer_active',
					'type'  => 'true_false',
				],
				[
					'key'        => 'field_wpfnpfqffre7f',
					'label'      => __( 'Settings', 'wpf' ),
					'name'       => 'wpf_phpmailer',
					'type'       => 'group',
					'layout'     => 'row',
					'sub_fields' => [
						[
							'key'      => 'field_wpfqbg5jggvy6',
							'label'    => __( 'Host', 'wpf' ),
							'name'     => 'host',
							'type'     => 'text',
							'required' => 1,
						],
						[
							'key'      => 'field_wpf8qkjvsdejt',
							'label'    => __( 'Username', 'wpf' ),
							'name'     => 'username',
							'type'     => 'text',
							'required' => 1,
						],
						[
							'key'      => 'field_wpf45gjtwxkb5',
							'label'    => __( 'Password', 'wpf' ),
							'name'     => 'password',
							'type'     => 'password',
							'required' => 1,
						],
						[
							'key'      => 'field_wpfyzef4wvksu',
							'label'    => __( 'Secure', 'wpf' ),
							'name'     => 'secure',
							'type'     => 'select',
							'choices'  => [
								'ssl' => __( 'SSL', 'wpf' ),
								'tls' => __( 'TLS', 'wpf' ),
							],
							'required' => 1,
						],
						[
							'key'      => 'field_wpfqyk9he2vtj',
							'label'    => __( 'Port', 'wpf' ),
							'name'     => 'port',
							'type'     => 'number',
							'required' => 1,
							'min'      => 1,
							'step'     => 1,
						],
						[
							'key'      => 'field_wpfovn5efzbza',
							'label'    => __( 'Debug level', 'wpf' ),
							'name'     => 'debug_level',
							'type'     => 'select',
							'choices'  => [
								0 => __( 'DEBUG_OFF', 'wpf' ),
								1 => __( 'DEBUG_CLIENT', 'wpf' ),
								2 => __( 'DEBUG_SERVER', 'wpf' ),
								3 => __( 'DEBUG_CONNECTION', 'wpf' ),
								4 => __( 'DEBUG_LOWLEVEL', 'wpf' ),
							],
							'required' => 1,
						],
					],
					'logic'      => [
						[
							[
								'field'    => 'field_wpf9bzgqsaudq',
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
						'value'    => 'wpf-phpmailer',
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
