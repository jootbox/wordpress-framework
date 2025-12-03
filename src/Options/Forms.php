<?php

namespace Framework\Options;

class Forms {

	public function __construct() {
		add_action( 'init', [ $this, 'loadGlobalFields' ] );
		add_action( 'init', [ $this, 'loadFields' ] );
	}

	/* ---
	  Functions
	--- */

	public function loadGlobalFields() {
		if ( ! function_exists( 'acf_add_local_field_group' ) ) {
			return;
		}

		$list = [
			'key'                   => 'group_wpfqfhafn3gs8',
			'title'                 => __( 'Contact Forms', 'wpf' ),
			'fields'                => [
				[
					'key'   => 'field_wpf8d9dwgqp7d',
					'label' => __( 'reCAPTCHA', 'wpf' ),
					'name'  => '',
					'type'  => 'tab',
				],
				[
					'key'          => 'field_wpf3o2ztahgph',
					'label'        => __( 'Site key', 'wpf' ),
					'name'         => 'wpf_recapchta_site_key',
					'type'         => 'text',
					'instructions' => __( '(get from website: <a href="https://www.google.com/recaptcha/" target="_blank">google.com/recaptcha</a>; use reCAPTCHA v2)', 'wpf' ),
					'required'     => 1,
				],
				[
					'key'          => 'field_wpfa79fssdots',
					'label'        => __( 'Secret', 'wpf' ),
					'name'         => 'wpf_recapchta_secret',
					'type'         => 'text',
					'instructions' => __( '(get from website: <a href="https://www.google.com/recaptcha/" target="_blank">google.com/recaptcha</a>; use reCAPTCHA v2)', 'wpf' ),
					'required'     => 1,
				],
			],
			'location'              => [
				[
					[
						'param'    => 'options_page',
						'operator' => '==',
						'value'    => 'wpf-contact_forms',
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

	public function loadFields() {
		if ( ! function_exists( 'acf_add_local_field_group' ) ) {
			return;
		}

		$list = [
			'key'                   => 'group_wpf2gwyc8qhmm',
			'title'                 => __( 'Contact Forms', 'wpf' ),
			'fields'                => [
				[
					'key'     => 'field_wpf04fae41f14',
					'label'   => __( 'Allowed shortcodes', 'wpf' ),
					'type'    => 'message',
					'message' => __( 'Loading...', 'wpf' ),
				],
				[
					'key'       => 'field_wpf009248e8c6',
					'label'     => __( 'Fields', 'wpf' ),
					'type'      => 'tab',
					'logic'     => [
						[
							[
								'field'    => 'field_wpf0092e8e8c7',
								'operator' => '!=empty',
							],
						],
					],
					'placement' => 'top',
					'endpoint'  => 0,
				],
				[
					'key'          => 'field_wpf0092e8e8c7',
					'label'        => __( 'List', 'wpf' ),
					'name'         => 'fields',
					'type'         => 'repeater',
					'required'     => 1,
					'min'          => 1,
					'max'          => 0,
					'layout'       => 'row',
					'button_label' => __( 'Add field', 'wpf' ),
					'sub_fields'   => [
						[
							'key'           => 'field_wpf009418e8c8',
							'label'         => __( 'Type', 'wpf' ),
							'name'          => 'type',
							'type'          => 'select',
							'required'      => 1,
							'choices'       => [
								'text'        => __( 'Text', 'wpf' ),
								'email'       => __( 'E-mail', 'wpf' ),
								'url'         => __( 'Url', 'wpf' ),
								'tel'         => __( 'Telephone', 'wpf' ),
								'number'      => __( 'Number', 'wpf' ),
								'date'        => __( 'Date', 'wpf' ),
								'password'    => __( 'Password', 'wpf' ),
								'textarea'    => __( 'Textarea', 'wpf' ),
								'select'      => __( 'Select', 'wpf' ),
								'multiselect' => __( 'Multiselect', 'wpf' ),
								'checkbox'    => __( 'Checkbox', 'wpf' ),
								'radio'       => __( 'Radio', 'wpf' ),
								'file'        => __( 'File', 'wpf' ),
								'recaptcha'   => __( 'reCAPTCHA', 'wpf' ),
								'agreement'   => __( 'Agreement', 'wpf' ),
								'hidden'      => __( 'Hidden', 'wpf' ),
							],
							'default_value' => [
							],
							'allow_null'    => 0,
							'multiple'      => 0,
							'return_format' => 'value',
						],
						[
							'key'          => 'field_wpf04c0300808',
							'label'        => __( 'Name', 'wpf' ),
							'name'         => 'name',
							'type'         => 'text',
							'instructions' => __( '(use only lowercase letters and underscores)', 'wpf' ),
							'required'     => 1,
						],
						[
							'key'           => 'field_wpf0a5151ed87',
							'label'         => __( 'Is grouped options?', 'wpf' ),
							'name'          => 'is_values_group',
							'type'          => 'true_false',
							'logic'         => [
								[
									[
										'field'    => 'field_wpf009418e8c8',
										'operator' => '==',
										'value'    => 'select',
									],
								],
								[
									[
										'field'    => 'field_wpf009418e8c8',
										'operator' => '==',
										'value'    => 'multiselect',
									],
								],
							],
							'default_value' => 0,
						],
						[
							'key'          => 'field_wpf6djsoumrps',
							'label'        => __( 'Different labels than values?', 'wpf' ),
							'name'         => 'is_different_labels',
							'type'         => 'true_false',
							'instructions' => sprintf(
								__( '(to show label instead of value use %s[{field_name}__label]%s)', 'wpf' ),
								'<strong>',
								'</strong>'
							),
							'logic'        => [
								[
									[
										'field'    => 'field_wpf009418e8c8',
										'operator' => '==',
										'value'    => 'select',
									],
								],
								[
									[
										'field'    => 'field_wpf009418e8c8',
										'operator' => '==',
										'value'    => 'checkbox',
									],
								],
								[
									[
										'field'    => 'field_wpf009418e8c8',
										'operator' => '==',
										'value'    => 'radio',
									],
								],
							],
						],
						[
							'key'          => 'field_wpf158f8142b2',
							'label'        => __( 'Values', 'wpf' ),
							'name'         => 'values',
							'type'         => 'repeater',
							'required'     => 1,
							'logic'        => [
								[
									[
										'field'    => 'field_wpf009418e8c8',
										'operator' => '==',
										'value'    => 'select',
									],
								],
								[
									[
										'field'    => 'field_wpf009418e8c8',
										'operator' => '==',
										'value'    => 'multiselect',
									],
								],
								[
									[
										'field'    => 'field_wpf009418e8c8',
										'operator' => '==',
										'value'    => 'checkbox',
									],
								],
								[
									[
										'field'    => 'field_wpf009418e8c8',
										'operator' => '==',
										'value'    => 'radio',
									],
								],
							],
							'min'          => 0,
							'max'          => 0,
							'layout'       => 'row',
							'button_label' => __( 'Add value', 'wpf' ),
							'sub_fields'   => [
								[
									'key'      => 'field_wpf15907142b3',
									'label'    => __( 'Value', 'wpf' ),
									'name'     => 'value',
									'type'     => 'text',
									'required' => 1,
								],
								[
									'key'          => 'field_wpf0a58b1ed89',
									'label'        => __( 'List', 'wpf' ),
									'name'         => 'list',
									'type'         => 'repeater',
									'required'     => 1,
									'logic'        => [
										[
											[
												'field'    => 'field_wpf0a5151ed87',
												'operator' => '==',
												'value'    => '1',
											],
										],
									],
									'min'          => 0,
									'max'          => 0,
									'layout'       => 'row',
									'button_label' => __( 'Add value', 'wpf' ),
									'sub_fields'   => [
										[
											'key'      => 'field_wpf0a58b1ed8a',
											'label'    => __( 'Value', 'wpf' ),
											'name'     => 'value',
											'type'     => 'text',
											'required' => 1,
										],
										[
											'key'          => 'field_wpf0a58b1ed8b',
											'label'        => __( 'Label', 'wpf' ),
											'name'         => 'label',
											'type'         => 'text',
											'instructions' => sprintf(
												__( '(optionally)', 'wpf' ),
												'<strong>',
												'</strong>'
											),
											'logic'        => [
												[
													[
														'field'    => 'field_wpf009418e8c8',
														'operator' => '==',
														'value'    => 'select',
													],
													[
														'field'    => 'field_wpf6djsoumrps',
														'operator' => '==',
														'value'    => '1',
													],
												],
												[
													[
														'field'    => 'field_wpf009418e8c8',
														'operator' => '==',
														'value'    => 'radio',
													],
													[
														'field'    => 'field_wpf6djsoumrps',
														'operator' => '==',
														'value'    => '1',
													],
												],
											],
										],
									],
								],
								[
									'key'          => 'field_wpf097aacda29',
									'label'        => __( 'Label', 'wpf' ),
									'name'         => 'label',
									'type'         => 'text',
									'instructions' => sprintf(
										__( '(optionally)', 'wpf' ),
										'<strong>',
										'</strong>'
									),
									'logic'        => [
										[
											[
												'field'    => 'field_wpf009418e8c8',
												'operator' => '==',
												'value'    => 'select',
											],
											[
												'field'    => 'field_wpf0a5151ed87',
												'operator' => '!=',
												'value'    => '1',
											],
											[
												'field'    => 'field_wpf6djsoumrps',
												'operator' => '==',
												'value'    => '1',
											],
										],
										[
											[
												'field'    => 'field_wpf009418e8c8',
												'operator' => '==',
												'value'    => 'checkbox',
											],
											[
												'field'    => 'field_wpf6djsoumrps',
												'operator' => '==',
												'value'    => '1',
											],
										],
										[
											[
												'field'    => 'field_wpf009418e8c8',
												'operator' => '==',
												'value'    => 'radio',
											],
											[
												'field'    => 'field_wpf6djsoumrps',
												'operator' => '==',
												'value'    => '1',
											],
										],
									],
								],
							],
						],
						[
							'key'          => 'field_wpfpf7mbkqxdr',
							'label'        => __( 'Default values', 'wpf' ),
							'name'         => 'values_default',
							'type'         => 'text',
							'instructions' => __( '(separate each value with | char)', 'wpf' ),
							'logic'        => [
								[
									[
										'field'    => 'field_wpf009418e8c8',
										'operator' => '==',
										'value'    => 'select',
									],
								],
								[
									[
										'field'    => 'field_wpf009418e8c8',
										'operator' => '==',
										'value'    => 'multiselect',
									],
								],
								[
									[
										'field'    => 'field_wpf009418e8c8',
										'operator' => '==',
										'value'    => 'checkbox',
									],
								],
								[
									[
										'field'    => 'field_wpf009418e8c8',
										'operator' => '==',
										'value'    => 'radio',
									],
								],
							],
						],
						[
							'key'   => 'field_wpf2dk8pwv2ju',
							'label' => __( 'Default value', 'wpf' ),
							'name'  => 'value_default',
							'type'  => 'text',
							'logic' => [
								[
									[
										'field'    => 'field_wpf009418e8c8',
										'operator' => '==',
										'value'    => 'hidden',
									],
								],
							],
						],
						[
							'key'   => 'field_wpf042638ba69',
							'label' => __( 'Minimum value', 'wpf' ),
							'name'  => 'number_min',
							'type'  => 'number',
							'logic' => [
								[
									[
										'field'    => 'field_wpf009418e8c8',
										'operator' => '==',
										'value'    => 'number',
									],
								],
							],
						],
						[
							'key'   => 'field_wpf40f0018f0e',
							'label' => __( 'Maximum value', 'wpf' ),
							'name'  => 'number_max',
							'type'  => 'number',
							'logic' => [
								[
									[
										'field'    => 'field_wpf009418e8c8',
										'operator' => '==',
										'value'    => 'number',
									],
								],
							],
						],
						[
							'key'   => 'field_wpf40f0918f0f',
							'label' => __( 'Step value', 'wpf' ),
							'name'  => 'number_step',
							'type'  => 'number',
							'logic' => [
								[
									[
										'field'    => 'field_wpf009418e8c8',
										'operator' => '==',
										'value'    => 'number',
									],
									[
										'field'    => 'field_wpf042638ba69',
										'operator' => '!=',
										'value'    => '',
									],
								],
							],
						],
						[
							'key'          => 'field_wpfuecre7up53',
							'label'        => __( 'Date format', 'wpf' ),
							'name'         => 'date_format',
							'type'         => 'text',
							'instructions' => sprintf(
								__( '(examples of patterns:%s %syyyy-MM-dd%s (2019-04-30)%s %sHH:mm%s (21:45)%s %syyyy-MM-dd HH:mm%s (2019-04-30 21:45)%s %syyyy-MM-dd hh:mm a%s (2019-04-30 09:45 PM)', 'wpf' ),
								'<br>&nbsp;&nbsp;• ',
								'<strong>',
								'</strong>',
								'<br>&nbsp;&nbsp;• ',
								'<strong>',
								'</strong>',
								'<br>&nbsp;&nbsp;• ',
								'<strong>',
								'</strong>',
								'<br>&nbsp;&nbsp;• ',
								'<strong>',
								'</strong>'
							),
							'required'     => 1,
							'logic'        => [
								[
									[
										'field'    => 'field_wpf009418e8c8',
										'operator' => '==',
										'value'    => 'date',
									],
								],
							],
						],
						[
							'key'          => 'field_wpfe570993764',
							'label'        => __( 'Date minimum', 'wpf' ),
							'name'         => 'date_after',
							'type'         => 'text',
							'instructions' => __( '(optionally; name of field in which user selects date or date as string)', 'wpf' ),
							'logic'        => [
								[
									[
										'field'    => 'field_wpf009418e8c8',
										'operator' => '==',
										'value'    => 'date',
									],
								],
							],
						],
						[
							'key'          => 'field_wpfe56c293763',
							'label'        => __( 'Date maximum', 'wpf' ),
							'name'         => 'date_before',
							'type'         => 'text',
							'instructions' => __( '(optionally; name of field in which user selects date or date as string)', 'wpf' ),
							'logic'        => [
								[
									[
										'field'    => 'field_wpf009418e8c8',
										'operator' => '==',
										'value'    => 'date',
									],
								],
							],
						],
						[
							'key'           => 'field_wpfc1b45968d6',
							'label'         => __( 'First empty option?', 'wpf' ),
							'name'          => 'select_first_empty',
							'type'          => 'true_false',
							'logic'         => [
								[
									[
										'field'    => 'field_wpf009418e8c8',
										'operator' => '==',
										'value'    => 'select',
									],
								],
							],
							'default_value' => 0,
						],
						[
							'key'          => 'field_wpf5n3wg257dg',
							'label'        => __( 'Content of consent', 'wpf' ),
							'name'         => 'agreement_html',
							'type'         => 'wysiwyg',
							'required'     => 1,
							'logic'        => [
								[
									[
										'field'    => 'field_wpf009418e8c8',
										'operator' => '==',
										'value'    => 'agreement',
									],
								],
							],
							'media_upload' => 0,
						],
						[
							'key'   => 'field_wpf3dc8bksjrm',
							'label' => __( 'Additional expanded content?', 'wpf' ),
							'name'  => 'is_agreement_html_expanded',
							'type'  => 'true_false',
							'logic' => [
								[
									[
										'field'    => 'field_wpf009418e8c8',
										'operator' => '==',
										'value'    => 'agreement',
									],
								],
							],
						],
						[
							'key'          => 'field_wpf2dhynr3r4b',
							'label'        => __( 'Expanded content', 'wpf' ),
							'name'         => 'agreement_html_expanded',
							'type'         => 'wysiwyg',
							'instructions' => sprintf(
								__( '(displayed in %sdata-expanded%s attribute in label)', 'wpf' ),
								'<strong>',
								'</strong>'
							),
							'required'     => 1,
							'logic'        => [
								[
									[
										'field'    => 'field_wpf3dc8bksjrm',
										'operator' => '==',
										'value'    => '1',
									],
								],
							],
							'media_upload' => 0,
						],
						[
							'key'   => 'field_wpf00a1cbb56a',
							'label' => __( 'Placeholder', 'wpf' ),
							'name'  => 'placeholder',
							'type'  => 'text',
							'logic' => [
								[
									[
										'field'    => 'field_wpf009418e8c8',
										'operator' => '==',
										'value'    => 'text',
									],
								],
								[
									[
										'field'    => 'field_wpf009418e8c8',
										'operator' => '==',
										'value'    => 'email',
									],
								],
								[
									[
										'field'    => 'field_wpf009418e8c8',
										'operator' => '==',
										'value'    => 'url',
									],
								],
								[
									[
										'field'    => 'field_wpf009418e8c8',
										'operator' => '==',
										'value'    => 'tel',
									],
								],
								[
									[
										'field'    => 'field_wpf009418e8c8',
										'operator' => '==',
										'value'    => 'number',
									],
								],
								[
									[
										'field'    => 'field_wpf009418e8c8',
										'operator' => '==',
										'value'    => 'date',
									],
								],
								[
									[
										'field'    => 'field_wpf009418e8c8',
										'operator' => '==',
										'value'    => 'password',
									],
								],
								[
									[
										'field'    => 'field_wpf009418e8c8',
										'operator' => '==',
										'value'    => 'textarea',
									],
								],
								[
									[
										'field'    => 'field_wpf009418e8c8',
										'operator' => '==',
										'value'    => 'select',
									],
									[
										'field'    => 'field_wpfc1b45968d6',
										'operator' => '==',
										'value'    => '1',
									],
								],
							],
						],
						[
							'key'          => 'field_wpf2e63f8a051',
							'label'        => __( 'Custom classes', 'wpf' ),
							'name'         => 'classes',
							'type'         => 'text',
							'instructions' => __( '(separate each class with a space)', 'wpf' ),
							'logic'        => [
								[
									[
										'field'    => 'field_wpf009418e8c8',
										'operator' => '!=',
										'value'    => 'hidden',
									],
								],
							],
						],
						[
							'key'           => 'field_wpf00a5025087',
							'label'         => __( 'Is required?', 'wpf' ),
							'name'          => 'validate_required',
							'type'          => 'true_false',
							'logic'         => [
								[
									[
										'field'    => 'field_wpf009418e8c8',
										'operator' => '!=',
										'value'    => 'recaptcha',
									],
									[
										'field'    => 'field_wpf009418e8c8',
										'operator' => '!=',
										'value'    => 'hidden',
									],
								],
							],
							'default_value' => 0,
						],
						[
							'key'   => 'field_wpf2b7b437ef1',
							'label' => __( 'Minimum length', 'wpf' ),
							'name'  => 'validate_length_min',
							'type'  => 'number',
							'logic' => [
								[
									[
										'field'    => 'field_wpf009418e8c8',
										'operator' => '==',
										'value'    => 'text',
									],
								],
								[
									[
										'field'    => 'field_wpf009418e8c8',
										'operator' => '==',
										'value'    => 'password',
									],
								],
								[
									[
										'field'    => 'field_wpf009418e8c8',
										'operator' => '==',
										'value'    => 'textarea',
									],
								],
							],
							'min'   => 0,
							'step'  => 1,
						],
						[
							'key'   => 'field_wpf2b7c437ef3',
							'label' => __( 'Maximum length', 'wpf' ),
							'name'  => 'validate_length_max',
							'type'  => 'number',
							'logic' => [
								[
									[
										'field'    => 'field_wpf009418e8c8',
										'operator' => '==',
										'value'    => 'text',
									],
								],
								[
									[
										'field'    => 'field_wpf009418e8c8',
										'operator' => '==',
										'value'    => 'password',
									],
								],
								[
									[
										'field'    => 'field_wpf009418e8c8',
										'operator' => '==',
										'value'    => 'textarea',
									],
								],
							],
							'min'   => 0,
							'step'  => 1,
						],
						[
							'key'           => 'field_wpf314efe8569',
							'label'         => __( 'Multiple files?', 'wpf' ),
							'name'          => 'validate_file_multiple',
							'type'          => 'true_false',
							'logic'         => [
								[
									[
										'field'    => 'field_wpf009418e8c8',
										'operator' => '==',
										'value'    => 'file',
									],
								],
							],
							'default_value' => 0,
						],
						[
							'key'          => 'field_wpf040af8ba5f',
							'label'        => __( 'File max size', 'wpf' ),
							'name'         => 'validate_file_size',
							'type'         => 'number',
							'instructions' => __( '(value in KB)', 'wpf' ),
							'logic'        => [
								[
									[
										'field'    => 'field_wpf009418e8c8',
										'operator' => '==',
										'value'    => 'file',
									],
								],
							],
							'min'          => 0,
							'step'         => 1,
						],
						[
							'key'           => 'field_wpf043a88ba6d',
							'label'         => __( 'File extensions', 'wpf' ),
							'name'          => 'validate_file_extensions',
							'type'          => 'checkbox',
							'logic'         => [
								[
									[
										'field'    => 'field_wpf009418e8c8',
										'operator' => '==',
										'value'    => 'file',
									],
								],
							],
							'choices'       => [
								'audio/aac'                                                                 => 'aac',
								'video/x-msvideo'                                                           => 'avi',
								'image/bmp'                                                                 => 'bmp',
								'text/csv'                                                                  => 'csv',
								'application/msword'                                                        => 'doc',
								'application/vnd.openxmlformats-officedocument.wordprocessingml.document'   => 'docx',
								'image/gif'                                                                 => 'gif',
								'image/jpg' 																=> 'jpg',
								'image/jpeg' 																=> 'jpeg',
								'image/heif'																=> 'heif',
								'image/heic'																=> 'heic',
								'application/json'                                                          => 'json',
								'video/mpeg'                                                                => 'mpeg',
								'application/vnd.oasis.opendocument.presentation'                           => 'odp',
								'application/vnd.oasis.opendocument.spreadsheet'                            => 'ods',
								'application/vnd.oasis.opendocument.text'                                   => 'odt',
								'audio/ogg'                                                                 => 'oga',
								'video/ogg'                                                                 => 'ogv',
								'application/ogg'                                                           => 'ogx',
								'image/png'                                                                 => 'png',
								'application/pdf'                                                           => 'pdf',
								'application/vnd.ms-powerpoint'                                             => 'ppt',
								'application/vnd.openxmlformats-officedocument.presentationml.presentation' => 'pptx',
								'application/x-rar-compressed'                                              => 'rar',
								'image/svg+xml'                                                             => 'svg',
								'image/tiff'                                                                => 'tiff',
								'text/plain'                                                                => 'txt',
								'audio/wav'                                                                 => 'wav',
								'audio/webm'                                                                => 'weba',
								'video/webm'                                                                => 'webm',
								'image/webp'                                                                => 'webp',
								'application/vnd.ms-excel'                                                  => 'xls',
								'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'         => 'xlsx',
								'application/xml'                                                           => 'xml',
								'application/zip'                                                           => 'zip',
								'video/3gpp,audio/3gpp'                                                     => '3gp',
								'application/x-7z-compressed'                                               => '7z',
							],
							'allow_custom'  => 0,
							'default_value' => [
							],
							'layout'        => 'vertical',
							'toggle'        => 1,
							'return_format' => 'array',
							'save_custom'   => 0,
						],
						[
							'key'          => 'field_wpf0415a8ba62',
							'label'        => __( 'Regex', 'wpf' ),
							'name'         => 'validate_regex',
							'type'         => 'text',
							'instructions' => __( '(e.g. <strong>^([0-9]+)$</strong>)', 'wpf' ),
							'logic'        => [
								[
									[
										'field'    => 'field_wpf009418e8c8',
										'operator' => '==',
										'value'    => 'text',
									],
								],
								[
									[
										'field'    => 'field_wpf009418e8c8',
										'operator' => '==',
										'value'    => 'email',
									],
								],
								[
									[
										'field'    => 'field_wpf009418e8c8',
										'operator' => '==',
										'value'    => 'url',
									],
								],
								[
									[
										'field'    => 'field_wpf009418e8c8',
										'operator' => '==',
										'value'    => 'tel',
									],
								],
								[
									[
										'field'    => 'field_wpf009418e8c8',
										'operator' => '==',
										'value'    => 'number',
									],
								],
								[
									[
										'field'    => 'field_wpf009418e8c8',
										'operator' => '==',
										'value'    => 'password',
									],
								],
							],
						],
						[
							'key'          => 'field_wpf976ag6yzon',
							'label'        => __( 'Error message', 'wpf' ),
							'name'         => 'validate_regex_error',
							'type'         => 'text',
							'instructions' => __( '(for regex error)', 'wpf' ),
							'logic'        => [
								[
									[
										'field'    => 'field_wpf009418e8c8',
										'operator' => '==',
										'value'    => 'text',
									],
									[
										'field'    => 'field_wpf0415a8ba62',
										'operator' => '!=',
										'value'    => '',
									],
								],
								[
									[
										'field'    => 'field_wpf009418e8c8',
										'operator' => '==',
										'value'    => 'email',
									],
									[
										'field'    => 'field_wpf0415a8ba62',
										'operator' => '!=',
										'value'    => '',
									],
								],
								[
									[
										'field'    => 'field_wpf009418e8c8',
										'operator' => '==',
										'value'    => 'url',
									],
									[
										'field'    => 'field_wpf0415a8ba62',
										'operator' => '!=',
										'value'    => '',
									],
								],
								[
									[
										'field'    => 'field_wpf009418e8c8',
										'operator' => '==',
										'value'    => 'tel',
									],
									[
										'field'    => 'field_wpf0415a8ba62',
										'operator' => '!=',
										'value'    => '',
									],
								],
								[
									[
										'field'    => 'field_wpf009418e8c8',
										'operator' => '==',
										'value'    => 'number',
									],
									[
										'field'    => 'field_wpf0415a8ba62',
										'operator' => '!=',
										'value'    => '',
									],
								],
								[
									[
										'field'    => 'field_wpf009418e8c8',
										'operator' => '==',
										'value'    => 'password',
									],
									[
										'field'    => 'field_wpf0415a8ba62',
										'operator' => '!=',
										'value'    => '',
									],
								],
							],
						],
						[
							'key'          => 'field_wpf2PwpDw3QWf',
							'label'        => __( 'Name of conditions collection to ignore field validation', 'wpf' ),
							'name'         => 'validate_ignore',
							'type'         => 'text',
							'instructions' => sprintf(
								__( '(optionally; unique collection name given in %sConditions%s tab)', 'wpf' ),
								'<strong>',
								'</strong>'
							),
							'logic'        => [
								[
									[
										'field'    => 'field_wpf6nE3qC9e9X',
										'operator' => '!=empty',
									],
									[
										'field'    => 'field_wpf009418e8c8',
										'operator' => '!=',
										'value'    => 'recaptcha',
									],
								],
							],
						],
					],
				],
				[
					'key'       => 'field_wpf04cb1f4fac',
					'label'     => __( 'Form', 'wpf' ),
					'type'      => 'tab',
					'placement' => 'top',
					'endpoint'  => 0,
				],
				[
					'key'       => 'field_wpfe70e3d7de6',
					'label'     => __( 'Submit', 'wpf' ),
					'type'      => 'message',
					'message'   => __( "Enter <strong>[submit_error]</strong> tag where you want to show error message when sending the form and <strong>[submit_success]</strong> for success message.\nAdd anywhere button to send form (you can use <strong>input</strong> or <strong>button</strong>).\nAdd code <strong>v-hide=&#34;[condition=name]&#34;</strong> to any container to hide its contents <em>(instead of \"name\" enter unique collection name given in \"Conditions\" tab)</em>.", 'wpf' ),
					'new_lines' => 'br',
					'esc_html'  => 0,
				],
				[
					'key'           => 'field_wpf04cb9f4fad',
					'label'         => __( 'Template', 'wpf' ),
					'name'          => 'template',
					'type'          => 'textarea',
					'default_value' => __( "<label>\n  <span>Your name</span>\n  [name]\n</label>\n\n<label>\n  <span>Your e-mail</span>\n  [email]\n</label>\n\n<label>\n  <span>Subject</span>\n  [subject]\n</label>\n\n<label>\n  <span>Message</span>\n  [message]\n</label>\n\n<button type=\"submit\">Submit</button>\n[submit_error]\n[submit_success]", 'wpf' ),
				],
				[
					'key'   => 'field_wpf4reb42vfxu',
					'label' => __( 'Input error class', 'wpf' ),
					'name'  => 'settings_class_input_error',
					'type'  => 'text',
				],
				[
					'key'   => 'field_wpfe7a0fb562e',
					'label' => __( 'Submit error class', 'wpf' ),
					'name'  => 'settings_class_submit_error',
					'type'  => 'text',
				],
				[
					'key'   => 'field_wpf01f8908b0f',
					'label' => __( 'Submit success class', 'wpf' ),
					'name'  => 'settings_class_submit_success',
					'type'  => 'text',
				],
				[
					'key'   => 'field_wpf5b9dbggmj8',
					'label' => __( 'Disable clearing form after sending?', 'wpf' ),
					'name'  => 'settings_submit_no_clear',
					'type'  => 'true_false',
				],
				[
					'key'       => 'field_wpf04db47c090',
					'label'     => __( 'Mail', 'wpf' ),
					'type'      => 'tab',
					'placement' => 'top',
					'endpoint'  => 0,
				],
				[
					'key'          => 'field_wpf04db97c091',
					'label'        => __( 'List', 'wpf' ),
					'name'         => 'mail_list',
					'type'         => 'repeater',
					'min'          => 0,
					'max'          => 0,
					'layout'       => 'row',
					'button_label' => __( 'Add mail', 'wpf' ),
					'sub_fields'   => [
						[
							'key'          => 'field_wpf7bdkufTh2H',
							'label'        => __( 'Name of conditions collection to use current template', 'wpf' ),
							'name'         => 'condition_group',
							'type'         => 'text',
							'instructions' => sprintf(
								__( '(optionally; unique collection name given in %sConditions%s tab)', 'wpf' ),
								'<strong>',
								'</strong>'
							),
							'logic'        => [
								[
									[
										'field'    => 'field_wpf6nE3qC9e9X',
										'operator' => '!=empty',
									],
								],
							],
						],
						[
							'key'           => 'field_wpf04dd87c092',
							'label'         => __( 'To', 'wpf' ),
							'name'          => 'to',
							'type'          => 'text',
							'required'      => 1,
							'default_value' => 'mail@example.com',
						],
						[
							'key'           => 'field_wpf04de47c093',
							'label'         => __( 'From', 'wpf' ),
							'name'          => 'from',
							'type'          => 'text',
							'required'      => 1,
							'default_value' => '[name] <[email]>',
						],
						[
							'key'           => 'field_wpf04e167c094',
							'label'         => __( 'Subject', 'wpf' ),
							'name'          => 'subject',
							'type'          => 'text',
							'required'      => 1,
							'default_value' => __( 'Message "[subject]"', 'wpf' ),
						],
						[
							'key'           => 'field_wpf04e247c095',
							'label'         => __( 'Additional headers', 'wpf' ),
							'name'          => 'additional_headers',
							'type'          => 'textarea',
							'default_value' => 'Reply-To: [email]',
						],
						[
							'key'           => 'field_wpf04ed8e95f6',
							'label'         => __( 'Message', 'wpf' ),
							'name'          => 'message',
							'type'          => 'textarea',
							'instructions'  => __( '(you can use HTML tags, e.q. strong)', 'wpf' ),
							'default_value' => __( "From: [name] <[email]>\nMessage:\n[message]\n\n--\n\nThis message was sent automatically using the form on website %site_name% (%site_url%).", 'wpf' ),
						],
						[
							'key'   => 'field_wpf3c3d6ntdos',
							'label' => __( 'Format as HTML?', 'wpf' ),
							'name'  => 'is_html',
							'type'  => 'true_false',
						],
						[
							'key'          => 'field_wpf8pzwoxs8kx',
							'label'        => __( 'Attachments', 'wpf' ),
							'name'         => 'attachments',
							'type'         => 'repeater',
							'min'          => 0,
							'max'          => 0,
							'layout'       => 'row',
							'button_label' => __( 'Add attachment', 'wpf' ),
							'sub_fields'   => [
								[
									'key'      => 'field_wpf783zkn2a4j',
									'label'    => __( 'Type', 'wpf' ),
									'name'     => 'type',
									'type'     => 'select',
									'required' => 1,
									'choices'  => [
										'field' => __( 'Value of field', 'wpf' ),
										'file'  => __( 'File', 'wpf' ),
									],
								],
								[
									'key'          => 'field_wpf2495nqbfmy',
									'label'        => __( 'Field name', 'wpf' ),
									'name'         => 'name',
									'type'         => 'text',
									'instructions' => sprintf(
										__( '(field name given in %sFields%s tab)', 'wpf' ),
										'<strong>',
										'</strong>'
									),
									'required'     => 1,
									'logic'        => [
										[
											[
												'field'    => 'field_wpf783zkn2a4j',
												'operator' => '==',
												'value'    => 'field',
											],
										],
									],
								],
								[
									'key'      => 'field_wpf34behtsfo9',
									'label'    => __( 'File', 'wpf' ),
									'name'     => 'file',
									'type'     => 'file',
									'required' => 1,
									'logic'    => [
										[
											[
												'field'    => 'field_wpf783zkn2a4j',
												'operator' => '==',
												'value'    => 'file',
											],
										],
									],
								],
							],
						],
					],
				],
				[
					'key'       => 'field_wpf162da84301',
					'label'     => __( 'Messages', 'wpf' ),
					'type'      => 'tab',
					'placement' => 'top',
					'endpoint'  => 0,
				],
				[
					'key'           => 'field_wpf162e384302',
					'label'         => __( 'Send success', 'wpf' ),
					'name'          => 'messages_send_success',
					'type'          => 'text',
					'required'      => 1,
					'default_value' => __( 'Thank you for your message. It has been sent.', 'wpf' ),
				],
				[
					'key'           => 'field_wpf1630884303',
					'label'         => __( 'Send error', 'wpf' ),
					'name'          => 'messages_send_error',
					'type'          => 'text',
					'required'      => 1,
					'default_value' => __( 'The error occurred while sending your message. Please try again later.', 'wpf' ),
				],
				[
					'key'           => 'field_wpfe2339e5d86',
					'label'         => __( 'Send validate field', 'wpf' ),
					'name'          => 'messages_send_error_field',
					'type'          => 'text',
					'instructions'  => __( '(use <strong>%s</strong> for show dynamic value)', 'wpf' ),
					'required'      => 1,
					'default_value' => __( 'The error occurred while validating "%s" field. Enter the value again and try submit form.', 'wpf' ),
				],
				[
					'key'           => 'field_wpf1630f84304',
					'label'         => __( 'Validation error', 'wpf' ),
					'name'          => 'messages_send_validate',
					'type'          => 'text',
					'required'      => 1,
					'default_value' => __( 'One or more fields have an error. Please check and try again.', 'wpf' ),
				],
				[
					'key'           => 'field_wpf16338149de',
					'label'         => __( 'Required field', 'wpf' ),
					'name'          => 'messages_validate_required',
					'type'          => 'text',
					'required'      => 1,
					'default_value' => __( 'This field is required.', 'wpf' ),
				],
				[
					'key'           => 'field_wpf163f3149e5',
					'label'         => __( 'Minimum field length', 'wpf' ),
					'name'          => 'messages_validate_value_short',
					'type'          => 'text',
					'instructions'  => __( '(use <strong>%s</strong> for show dynamic value)', 'wpf' ),
					'required'      => 1,
					'default_value' => __( 'This field must be at least %s characters.', 'wpf' ),
				],
				[
					'key'           => 'field_wpf16400149e6',
					'label'         => __( 'Maximum field length', 'wpf' ),
					'name'          => 'messages_validate_value_long',
					'type'          => 'text',
					'instructions'  => __( '(use <strong>%s</strong> for show dynamic value)', 'wpf' ),
					'required'      => 1,
					'default_value' => __( 'This field must be at maximum %s characters.', 'wpf' ),
				],
				[
					'key'           => 'field_wpf163b5149df',
					'label'         => __( 'Invalid e-mail', 'wpf' ),
					'name'          => 'messages_validate_email',
					'type'          => 'text',
					'required'      => 1,
					'default_value' => __( 'E-mail address is invalid.', 'wpf' ),
				],
				[
					'key'           => 'field_wpf163bd149e0',
					'label'         => __( 'Incorrect URL', 'wpf' ),
					'name'          => 'messages_validate_url',
					'type'          => 'text',
					'required'      => 1,
					'default_value' => __( 'URL is incorrect.', 'wpf' ),
				],
				[
					'key'           => 'field_wpf163e2149e3',
					'label'         => __( 'Incorrect number', 'wpf' ),
					'name'          => 'messages_validate_number',
					'type'          => 'text',
					'required'      => 1,
					'default_value' => __( 'This value must be number.', 'wpf' ),
				],
				[
					'key'           => 'field_wpf163cf149e1',
					'label'         => __( 'Too small number value', 'wpf' ),
					'name'          => 'messages_validate_number_min',
					'type'          => 'text',
					'instructions'  => __( '(use <strong>%s</strong> for show dynamic value)', 'wpf' ),
					'required'      => 1,
					'default_value' => __( 'This field value must be %s or more.', 'wpf' ),
				],
				[
					'key'           => 'field_wpf163da149e2',
					'label'         => __( 'Too large number value', 'wpf' ),
					'name'          => 'messages_validate_number_max',
					'type'          => 'text',
					'instructions'  => __( '(use <strong>%s</strong> for show dynamic value)', 'wpf' ),
					'required'      => 1,
					'default_value' => __( 'This field value must be %s or less.', 'wpf' ),
				],
				[
					'key'           => 'field_wpf41e4f4766d',
					'label'         => __( 'Invalid step in number', 'wpf' ),
					'name'          => 'messages_validate_number_step',
					'type'          => 'text',
					'instructions'  => __( '(use <strong>%s</strong> for show dynamic value)', 'wpf' ),
					'required'      => 1,
					'default_value' => __( 'Step value is %s from minimum value.', 'wpf' ),
				],
				[
					'key'           => 'field_wpf163e9149e4',
					'label'         => __( 'Invalid date format', 'wpf' ),
					'name'          => 'messages_validate_date_format',
					'type'          => 'text',
					'instructions'  => __( '(use <strong>%s</strong> for show dynamic value)', 'wpf' ),
					'required'      => 1,
					'default_value' => __( 'Date must be in format %s.', 'wpf' ),
				],
				[
					'key'           => 'field_wpf2f4da9bb91',
					'label'         => __( 'Too early date in range', 'wpf' ),
					'name'          => 'messages_date_before',
					'type'          => 'text',
					'instructions'  => __( '(use <strong>%s</strong> for show dynamic value)', 'wpf' ),
					'required'      => 1,
					'default_value' => __( 'Date can not be later than %s.', 'wpf' ),
				],
				[
					'key'           => 'field_wpf2f4a19bb90',
					'label'         => __( 'Too late date in range', 'wpf' ),
					'name'          => 'messages_date_after',
					'type'          => 'text',
					'instructions'  => __( '(use <strong>%s</strong> for show dynamic value)', 'wpf' ),
					'required'      => 1,
					'default_value' => __( 'Date can not be earlier than %s.', 'wpf' ),
				],
				[
					'key'           => 'field_wpf16409149e7',
					'label'         => __( 'Invalid file extension', 'wpf' ),
					'name'          => 'messages_validate_file_extension',
					'type'          => 'text',
					'required'      => 1,
					'default_value' => __( 'Extension of file is invalid.', 'wpf' ),
				],
				[
					'key'           => 'field_wpf16413149e8',
					'label'         => __( 'Too large file size', 'wpf' ),
					'name'          => 'messages_validate_file_size',
					'type'          => 'text',
					'instructions'  => __( '(use <strong>%s</strong> for show dynamic value)', 'wpf' ),
					'required'      => 1,
					'default_value' => __( 'Size of file is larger than allowed %sKB.', 'wpf' ),
				],
				[
					'key'           => 'field_wpf1641d149e9',
					'label'         => __( 'Regex error', 'wpf' ),
					'name'          => 'messages_validate_regex',
					'type'          => 'text',
					'required'      => 1,
					'default_value' => __( 'Field value is invalid.', 'wpf' ),
				],
				[
					'key'       => 'field_wpffQQegxmku8',
					'label'     => __( 'Conditions', 'wpf' ),
					'type'      => 'tab',
					'placement' => 'top',
					'endpoint'  => 0,
				],
				[
					'key'          => 'field_wpf6nE3qC9e9X',
					'label'        => __( 'Collections of conditions', 'wpf' ),
					'name'         => 'conditions',
					'type'         => 'repeater',
					'instructions' => __( '(list of collections used for validation)', 'wpf' ),
					'min'          => 0,
					'max'          => 0,
					'layout'       => 'row',
					'button_label' => __( 'Add collection', 'wpf' ),
					'sub_fields'   => [
						[
							'key'          => 'field_wpf6aMmtVkTHQ',
							'label'        => __( 'Name', 'wpf' ),
							'name'         => 'name',
							'type'         => 'text',
							'instructions' => __( '(enter unique name, use only lowercase letters and underscores)', 'wpf' ),
							'required'     => 1,
						],
						[
							'key'          => 'field_wpf46G8PLjUuv',
							'label'        => __( 'Groups of conditions', 'wpf' ),
							'name'         => 'groups',
							'type'         => 'repeater',
							'instructions' => __( '(all groups must be satisfied)', 'wpf' ),
							'min'          => 1,
							'max'          => 0,
							'layout'       => 'row',
							'button_label' => __( 'Add group', 'wpf' ),
							'sub_fields'   => [
								[
									'key'          => 'field_wpfo8HUC7xsa3',
									'label'        => __( 'Relation', 'wpf' ),
									'name'         => 'relation',
									'type'         => 'select',
									'instructions' => __( '(logical relationship between each items of list)', 'wpf' ),
									'required'     => 1,
									'choices'      => [
										'and' => __( 'All satisfies condition', 'wpf' ),
										'or'  => __( 'At least one satisfies condition', 'wpf' ),
									],
								],
								[
									'key'          => 'field_wpf3vh2mVZbHJ',
									'label'        => __( 'Conditions', 'wpf' ),
									'name'         => 'list',
									'type'         => 'repeater',
									'min'          => 1,
									'max'          => 0,
									'layout'       => 'table',
									'button_label' => __( 'Add condition', 'wpf' ),
									'sub_fields'   => [
										[
											'key'          => 'field_wpf3cVz2xhJwS',
											'label'        => __( 'Field name', 'wpf' ),
											'name'         => 'field',
											'type'         => 'text',
											'instructions' => sprintf(
												__( '(field name given in %sFields%s tab)', 'wpf' ),
												'<strong>',
												'</strong>'
											),
											'required'     => 1,
										],
										[
											'key'      => 'field_wpf9KLjLk8BXb',
											'label'    => __( 'Operator', 'wpf' ),
											'name'     => 'operator',
											'type'     => 'select',
											'required' => 1,
											'choices'  => [
												'=='           => '==',
												'!='           => '!=',
												'<'            => __( '< (for Number and Date)', 'wpf' ),
												'>'            => __( '> (for Number and Date)', 'wpf' ),
												'contains'     => __( 'contains (for Multiselect and Checkbox)', 'wpf' ),
												'not_contains' => __( 'not contains (for Multiselect and Checkbox)', 'wpf' ),
												'empty'        => __( 'empty', 'wpf' ),
												'not_empty'    => __( 'not empty', 'wpf' ),
											],
										],
										[
											'key'      => 'field_wpf2qPd9ZXF3m',
											'label'    => __( 'Value', 'wpf' ),
											'name'     => 'value',
											'type'     => 'text',
											'required' => 1,
											'logic'    => [
												[
													[
														'field'    => 'field_wpf9KLjLk8BXb',
														'operator' => '!=',
														'value'    => 'empty',
													],
													[
														'field'    => 'field_wpf9KLjLk8BXb',
														'operator' => '!=',
														'value'    => 'not_empty',
													],
												],
											],
										],
									],
								],
							],
						],
					],
				],
			],
			'location'              => [
				[
					[
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'wpf-contact-forms',
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
