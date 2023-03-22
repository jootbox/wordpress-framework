<?php

namespace Framework\Options;

class Duplicator {

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
			'key'                   => 'group_wpf6jaajhcrjc',
			'title'                 => __( 'Duplicator', 'wpf' ),
			'fields'                => [
				[
					'key'           => 'field_wpf8pxxtyj3dv',
					'label'         => __( 'Post types', 'wpf' ),
					'name'          => 'wpf_duplicator_post_types',
					'type'          => 'checkbox',
					'instructions'  => __( '(list of Post Types for which will be given to possibility of post cloning)', 'wpf' ),
					'default_value' => [ 'wpf-contact-forms' ],
				],
			],
			'location'              => [
				[
					[
						'param'    => 'options_page',
						'operator' => '==',
						'value'    => 'wpf-duplicator',
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
