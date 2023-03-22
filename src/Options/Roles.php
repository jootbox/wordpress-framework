<?php

namespace Framework\Options;

class Roles {

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
			'key'                   => 'group_wpf9s29pewzo8',
			'title'                 => __( 'User roles', 'wpf' ),
			'fields'                => [
				[
					'key'   => 'field_wpf86ezb4xoke',
					'label' => __( 'User roles', 'wpf' ),
					'name'  => '',
					'type'  => 'tab',
				],
				[
					'key'          => 'field_wpf7qcz89rqnt',
					'label'        => __( 'List', 'wpf' ),
					'name'         => 'wpf_roles',
					'type'         => 'repeater',
					'instructions' => '',
					'min'          => 0,
					'layout'       => 'row',
					'button_label' => __( 'Add role', 'wpf' ),
					'sub_fields'   => [
						[
							'key'          => 'field_wpf7hymezv346',
							'label'        => __( 'Role name', 'wpf' ),
							'name'         => 'role_name',
							'type'         => 'text',
							'instructions' => __( '(use only lowercase letters and underscores)', 'wpf' ),
							'required'     => 1,
						],
						[
							'key'      => 'field_wpf4d7xma4yec',
							'label'    => __( 'Display name', 'wpf' ),
							'name'     => 'display_name',
							'type'     => 'text',
							'required' => 1,
						],
						[
							'key'   => 'field_wpf6g57sbnpaw',
							'label' => __( 'Post Types', 'wpf' ),
							'name'  => '',
							'type'  => 'tab',
						],
						[
							'key'          => 'field_wpf2w22qwpwoc',
							'label'        => __( 'List', 'wpf' ),
							'name'         => 'wpf_roles_posttypes',
							'type'         => 'repeater',
							'instructions' => '',
							'min'          => 0,
							'layout'       => 'row',
							'button_label' => __( 'Add post type', 'wpf' ),
							'sub_fields'   => [
								[
									'key'     => 'field_wpf5ndgxzndqf',
									'label'   => __( 'Post type', 'wpf' ),
									'name'    => 'wpf_roles_posttype',
									'type'    => 'select',
									'choices' => [
										'post'       => 'post',
										'attachment' => 'attachment',
									],
								],
								[
									'key'      => 'field_wpf8ted4rs85h',
									'label'    => __( 'Capabilities', 'wpf' ),
									'name'     => 'capabilities_post',
									'type'     => 'checkbox',
									'required' => 1,
									'choices'  => [
										'create_%s'           => 'create_posts',
										'delete_others_%s'    => 'delete_others_posts',
										'delete_%s'           => 'delete_posts',
										'delete_private_%s'   => 'delete_private_posts',
										'delete_published_%s' => 'delete_published_posts',
										'edit_others_%s'      => 'edit_others_posts',
										'edit_%s'             => 'edit_posts',
										'edit_private_%s'     => 'edit_private_posts',
										'edit_published_%s'   => 'edit_published_posts',
										'publish_%s'          => 'publish_posts',
										'read_private_%s'     => 'read_private_posts',
									],
									'logic'    => [
										[
											[
												'field'    => 'field_wpf5ndgxzndqf',
												'operator' => '!=',
												'value'    => 'attachment',
											],
										],
									],
									'toggle'   => 1,
								],
								[
									'key'      => 'field_wpf4q5b8dmypz',
									'label'    => __( 'Capabilities', 'wpf' ),
									'name'     => 'capabilities_attachment',
									'type'     => 'checkbox',
									'required' => 1,
									'choices'  => [
										'upload_files'           => 'upload_files',
										'delete_others_posts_%s' => 'delete_others_posts',
										'delete_posts_%s'        => 'delete_posts',
										'edit_others_posts_%s'   => 'edit_others_posts',
										'edit_posts_%s'          => 'edit_posts',
									],
									'logic'    => [
										[
											[
												'field'    => 'field_wpf5ndgxzndqf',
												'operator' => '==',
												'value'    => 'attachment',
											],
										],
									],
									'toggle'   => 1,
								],
								[
									'key'          => 'field_wpf48dhzs5bz9',
									'label'        => __( 'Access only to selected posts', 'wpf' ),
									'name'         => 'selected_ids',
									'type'         => 'text',
									'instructions' => __( '(list of post IDs, separated by space)', 'wpf' ),
									'required'     => 0,
									'logic'        => [
										[
											[
												'field'    => 'field_wpf5ndgxzndqf',
												'operator' => '!=',
												'value'    => 'attachment',
											],
										],
									],
								],
							],
						],
						[
							'key'   => 'field_wpf4eyswb3eod',
							'label' => __( 'Taxonomies', 'wpf' ),
							'name'  => '',
							'type'  => 'tab',
						],
						[
							'key'          => 'field_wpf8ftzeg2aws',
							'label'        => __( 'List', 'wpf' ),
							'name'         => 'wpf_roles_taxonomies',
							'type'         => 'repeater',
							'instructions' => '',
							'min'          => 0,
							'layout'       => 'row',
							'button_label' => __( 'Add taxonomy', 'wpf' ),
							'sub_fields'   => [
								[
									'key'     => 'field_wpf8hdfbcqdsf',
									'label'   => __( 'Taxonomy', 'wpf' ),
									'name'    => 'wpf_roles_taxonomy',
									'type'    => 'select',
									'choices' => [],
								],
								[
									'key'     => 'field_wpf5zukhsn2n4',
									'label'   => __( 'Capabilities', 'wpf' ),
									'name'    => 'capabilities_category',
									'type'    => 'checkbox',
									'choices' => [
										'manage_categories' => 'manage_categories',
									],
									'logic'   => [
										[
											[
												'field'    => 'field_wpf8hdfbcqdsf',
												'operator' => '==',
												'value'    => 'category / post_tag',
											],
										],
									],
									'toggle'  => 1,
								],
								[
									'key'     => 'field_wpf9d4hz6u9ny',
									'label'   => __( 'Capabilities', 'wpf' ),
									'name'    => 'capabilities_taxonomy',
									'type'    => 'checkbox',
									'choices' => [
										'manage_%s' => 'manage_terms',
										'edit_%s'   => 'edit_terms',
										'delete_%s' => 'delete_terms',
										'assign_%s' => 'assign_terms',
									],
									'logic'   => [
										[
											[
												'field'    => 'field_wpf8hdfbcqdsf',
												'operator' => '!=',
												'value'    => 'category / post_tag',
											],
										],
									],
									'toggle'  => 1,
								],
							],
						],
						[
							'key'   => 'field_wpf87kydrg22h',
							'label' => __( 'Options Pages', 'wpf' ),
							'name'  => '',
							'type'  => 'tab',
						],
						[
							'key'     => 'field_wpf54wz3sppf7',
							'label'   => __( 'Capabilities', 'wpf' ),
							'name'    => 'wpf_roles_optionspages',
							'type'    => 'checkbox',
							'choices' => [
								'upload_files'           => 'upload_files',
								'delete_others_posts_%s' => 'delete_others_posts_attachment',
								'delete_posts_%s'        => 'delete_posts_attachment',
								'edit_others_posts_%s'   => 'edit_others_posts_attachment',
								'edit_posts_%s'          => 'edit_posts_attachment',
							],
						],
						[
							'key'   => 'field_wpf9qhw84ezab',
							'label' => __( 'Custom', 'wpf' ),
							'name'  => '',
							'type'  => 'tab',
						],
						[
							'key'     => 'field_wpf67zet9mmht',
							'label'   => __( 'Capabilities', 'wpf' ),
							'name'    => 'wpf_roles_custom',
							'type'    => 'checkbox',
							'choices' => [],
						],
						[
							'key'   => 'field_wpf9odexv34ev',
							'label' => __( 'Languages', 'wpf' ),
							'name'  => '',
							'type'  => 'tab',
						],
						[
							'key'          => 'field_wpf4trb6tge4o',
							'label'        => __( 'List', 'wpf' ),
							'name'         => 'wpf_roles_langs',
							'instructions' => __( '(leave empty to give access to all)', 'wpf' ),
							'type'         => 'checkbox',
							'choices'      => [],
						],
					],
				],
				[
					'key'   => 'field_wpf47xspoo4ot',
					'label' => __( 'Settings', 'wpf' ),
					'name'  => '',
					'type'  => 'tab',
				],
				[
					'key'           => 'field_wpf6cex66kwj5',
					'label'         => __( 'Restore default roles?', 'wpf' ),
					'name'          => 'wpf_roles_restore_roles',
					'type'          => 'true_false',
					'instructions'  => __( '(removes all user roles and restores defaults; also resets capabilities for all roles)', 'wpf' ),
					'default_value' => 0,
				],
				[
					'key'          => 'field_wpf262f3jjxyo',
					'label'        => __( 'Remove others roles', 'wpf' ),
					'name'         => 'wpf_roles_remove_roles',
					'type'         => 'checkbox',
					'instructions' => __( '(deletes selected roles - administrator and subscriber role can not be removed)', 'wpf' ),
					'choices'      => [],
				],
			],
			'location'              => [
				[
					[
						'param'    => 'options_page',
						'operator' => '==',
						'value'    => 'wpf-user_roles',
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
