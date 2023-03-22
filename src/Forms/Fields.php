<?php

namespace Framework\Forms;

class Fields {
	/* ---
	  Functions
	--- */

	public function printFields( $content, $fields, $settings, $formId ) {
		$fields = $this->checkFields( $fields );
		$keys   = array_column( $fields, 'name' );

		foreach ( $fields as $field ) {
			$data    = $this->getFieldData( $field, $formId );
			$content = str_replace(
				'[' . $field['name'] . ']',
				$this->getField( $data, $settings, $keys, $formId ),
				$content
			);

			$this->fields[ $field['name'] ] = ( $field['type'] != 'file' ) ? '' : [];
		}

		$content = str_replace(
			'[submit_error]',
			sprintf(
				'<div role="alert" aria-live="polite"
              class="%s" v-show="status.errors && response.submit_error" v-html="response.submit_error"></div>',
				$settings['classes']['submit_error']
			),
			$content
		);

		$content = str_replace(
			'[submit_success]',
			sprintf(
				'<div role="alert" aria-live="polite"
              class="%s" v-show="!status.errors && response.submit_success" v-html="response.submit_success"></div>',
				$settings['classes']['submit_success']
			),
			$content
		);

		return $content;
	}

	private function checkFields( $fields ) {
		$uniqueNames     = [];
		$recaptchaExists = false;

		foreach ( $fields as $key => $field ) {
			if ( $field['type'] == 'recaptcha' ) {
				if ( $recaptchaExists ) {
					unset( $fields[ $key ] );
					error_log( sprintf(
						'WordPress Framework: duplicated reCAPTCHA field named `%s` in Framework\\Forms\\Form',
						$field['name']
					) );
				}

				$recaptchaExists = true;
			}

			if ( in_array( $field['name'], $uniqueNames ) ) {
				unset( $fields[ $key ] );
				error_log( sprintf(
					'WordPress Framework: duplicated field name `%s` in Framework\\Forms\\Form',
					$field['name']
				) );
			}

			$uniqueNames[] = $field['name'];
		}

		return $fields;
	}

	private function getFieldData( $defaultData, $formId ) {
		$data = array_merge( $defaultData, [
			'_input_name' => $defaultData['name'],
		] );
		return apply_filters( 'wpf_filter_data',
			'wpf_forms_field', $data, [ $formId ], $formId );
	}

	/* ---
	  Field
	--- */

	private function getField( $field, $settings, $fieldsKeys, $formId ) {
		$html     = '';
		$validate = new Validate();
		$validate = $validate->getVueValidation( $field, $fieldsKeys, $settings );
		$inputId  = sprintf( 'wpf-%s-%s', $formId, $field['_input_name'] );

		if ( in_array( $field['type'], [ 'text', 'email', 'url', 'tel', 'password' ] ) ) {

			$html = sprintf(
				'<input %s>',
				$this->getFieldAtts( [
					'type'    => $field['type'],
					'data'    => $field['type'],
					'id'      => $inputId,
					'name'    => $field['_input_name'],
					'model'   => 'form.' . $field['_input_name'],
					'ref'     => $field['_input_name'],
					'class'   => $field['classes'],
					'place'   => $field['placeholder'],
					'valid'   => $validate,
					'arianow' => 'form.' . $field['_input_name'],
				] )
			);

		} else {
			if ( in_array( $field['type'], [ 'number' ] ) ) {

				$html = sprintf(
					'<input %s min="%s" max="%s" step="%s">',
					$this->getFieldAtts( [
						'type'    => $field['type'],
						'data'    => $field['type'],
						'id'      => $inputId,
						'name'    => $field['_input_name'],
						'model'   => 'form.' . $field['_input_name'],
						'ref'     => $field['_input_name'],
						'class'   => $field['classes'],
						'place'   => $field['placeholder'],
						'valid'   => $validate,
						'arianow' => 'form.' . $field['_input_name'],
					] ),
					$field['number_min'],
					$field['number_max'],
					$field['number_step']
				);

			} else {
				if ( $field['type'] == 'date' ) {

					$html = sprintf(
						'<input %s autocomplete="off">',
						$this->getFieldAtts( [
							'type'    => 'text',
							'data'    => $field['type'],
							'id'      => $inputId,
							'name'    => $field['_input_name'],
							'model'   => 'form.' . $field['_input_name'],
							'ref'     => $field['_input_name'],
							'class'   => $field['classes'],
							'place'   => $field['placeholder'],
							'valid'   => $validate,
							'arianow' => 'form.' . $field['_input_name'],
						] )
					);

				} else {
					if ( $field['type'] == 'textarea' ) {

						$html = sprintf(
							'<textarea %s></textarea>',
							$this->getFieldAtts( [
								'data'    => $field['type'],
								'id'      => $inputId,
								'name'    => $field['_input_name'],
								'model'   => 'form.' . $field['_input_name'],
								'ref'     => $field['_input_name'],
								'class'   => $field['classes'],
								'place'   => $field['placeholder'],
								'valid'   => $validate,
								'arianow' => 'form.' . $field['_input_name'],
							] )
						);

					} else {
						if ( in_array( $field['type'], [ 'select', 'multiselect' ] ) ) {

							$html = sprintf(
								'<select %s %s>%s</select>',
								$this->getFieldAtts( [
									'data'    => $field['type'],
									'id'      => $inputId,
									'name'    => $field['_input_name'],
									'model'   => 'form.' . $field['_input_name'],
									'ref'     => $field['_input_name'],
									'class'   => $field['classes'],
									'valid'   => $validate,
									'arianow' => 'form.' . $field['_input_name'],
								] ),
								( $field['type'] == 'multiselect' ) ? 'multiple' : '',
								implode( PHP_EOL, $this->getSelectOptions( $field ) )
							);

						} else {
							if ( in_array( $field['type'], [ 'checkbox', 'radio' ] ) ) {

								foreach ( $field['values'] as $index => $value ) {
									$html .= sprintf(
										'<p><input %s value="%s">
              <label for="%s" tabindex="0">%s</label></p>',
										$this->getFieldAtts( [
											'type'  => $field['type'],
											'data'  => $field['type'],
											'id'    => sprintf( '%s-%s', $inputId, $index ),
											'name'  => $field['_input_name'],
											'model' => 'form.' . $field['_input_name'],
											'ref'   => sprintf( '%s[%d]', $field['_input_name'], $index ),
											'class' => $field['classes'],
											'valid' => $validate,
										] ),
										$value['value'],
										sprintf( '%s-%s', $inputId, $index ),
										( $value['label'] ) ? $value['label'] : $value['value']
									);
								}

							} else {
								if ( $field['type'] == 'file' ) {

									$extensions = [];
									foreach ( $field['validate_file_extensions'] as $value ) {
										$extensions[] = $value['value'];
									}

									$html = sprintf(
										'<input %s accept="%s" %s v-on:change="uploadFiles(\'%s\', %s)">',
										$this->getFieldAtts( [
											'type'  => $field['type'],
											'data'  => $field['type'],
											'id'    => $inputId,
											'name'  => $field['_input_name'],
											'ref'   => $field['_input_name'],
											'class' => $field['classes'],
											'valid' => $validate,
										] ),
										implode( ',', $extensions ),
										( $field['validate_file_multiple'] ) ? 'multiple' : '',
										$field['_input_name'],
										( $field['validate_file_multiple'] ) ? 'true' : 'false'
									);

								} else {
									if ( $field['type'] == 'recaptcha' ) {

										$html = sprintf(
											'<vue-recaptcha %s @verify="onCaptchaVerified" @expired="onCaptchaExpired" sitekey="%s"></vue-recaptcha>
            <input %s>',
											$this->getFieldAtts( [
												'ref'   => $field['_input_name'] . '-widget',
												'class' => $field['classes'],
											] ),
											$settings['recaptcha']['site_key'],
											$this->getFieldAtts( [
												'type'  => 'hidden',
												'data'  => $field['type'],
												'name'  => $field['_input_name'],
												'ref'   => $field['_input_name'],
												'valid' => $validate,
											] )
										);

									} else {
										if ( in_array( $field['type'], [ 'agreement' ] ) ) {

											$html = sprintf(
												'<input %s>
            <label for="%s" %s>%s</label>',
												$this->getFieldAtts( [
													'type'  => 'checkbox',
													'data'  => $field['type'],
													'id'    => $inputId,
													'name'  => $field['_input_name'],
													'model' => 'form.' . $field['_input_name'],
													'ref'   => $field['_input_name'],
													'class' => $field['classes'],
													'valid' => $validate,
												] ),
												$inputId,
												$field['is_agreement_html_expanded'] ? 'data-expanded="' . htmlspecialchars( $field['agreement_html_expanded'] ) . '"' : '',
												$field['agreement_html']
											);

										} else {
											if ( in_array( $field['type'], [ 'hidden' ] ) ) {

												$html = sprintf(
													'<input %s>',
													$this->getFieldAtts( [
														'type'  => 'hidden',
														'data'  => $field['type'],
														'id'    => $inputId,
														'name'  => $field['_input_name'],
														'model' => 'form.' . $field['_input_name'],
														'ref'   => $field['_input_name'],
													] )
												);

											}
										}
									}
								}
							}
						}
					}
				}
			}
		}

		if ( ! $html ) {
			return '';
		}

		$regexError = $field['validate_regex_error'] ?? '';
		$html       .= sprintf(
			'%s<div id="%s-error" aria-live="assertive" class="%s" v-show="errors.has(\'%s\')">
            {{ showError(errors.items, \'%s\', \'%s\') }}
          </div>',
			PHP_EOL,
			$inputId,
			$settings['classes']['input_error'],
			$field['_input_name'],
			$field['_input_name'],
			$regexError ? addslashes( $regexError ) : ''
		);

		$html = apply_filters( 'wpf_filter_data',
			'wpf_forms_field_html', $html, [ $field, $formId ] );
		return $html;
	}

	private function getFieldAtts( $args ) {
		$list = [];
		$atts = [
			'type'    => 'type',
			'data'    => 'data-field-type',
			'id'      => 'id',
			'name'    => 'name',
			'model'   => 'v-model',
			'ref'     => 'ref',
			'class'   => 'class',
			'place'   => 'placeholder',
			'valid'   => 'v-validate',
			'arianow' => 'v-bind:aria-valuenow',
		];

		foreach ( $atts as $key => $attr ) {
			if ( ! isset( $args[ $key ] ) || ! $args[ $key ] ) {
				continue;
			}
			$list[] = sprintf( '%s="%s"', $attr, $args[ $key ] );
		}
		if ( isset( $args['id'] ) ) {
			$list[] = sprintf( 'aria-describedby="%s-error"', $args['id'] );
		}

		return implode( ' ', $list );
	}

	private function getSelectOptions( $field ) {
		$options = [];

		if ( $field['select_first_empty'] ) {
			$options[] = sprintf(
				'<option disabled value="">%s</option>',
				$field['placeholder']
			);
		}

		if ( ! $field['is_values_group'] ) {
			$options = array_merge( $options, $this->getSelectOptionsList( $field, $field['values'] ) );
		} else {
			foreach ( $field['values'] as $value ) {
				$options[] = sprintf(
					'<optgroup label="%s">%s</optgroup>',
					$value['value'],
					implode( PHP_EOL, $this->getSelectOptionsList( $field, $value['list'] ) )
				);
			}
		}

		return $options;
	}

	private function getSelectOptionsList( $field, $list ) {
		$options  = [];
		$isLabels = ( isset( $field['is_different_labels'] ) && $field['is_different_labels'] );

		foreach ( $list as $value ) {
			$options[] = sprintf(
				'<option value="%s">%s</option>',
				$value['value'],
				( ( $field['type'] == 'select' ) && $isLabels && $value['label'] ) ? $value['label'] : $value['value']
			);
		}

		return $options;
	}
}
