<?php

namespace Framework\Forms;

class Scripts {

	public function __construct( $globalVue = false ) {
		add_action( 'wp_footer', [ $this, 'loadVueJs' ], 0 );
		add_action( 'wp_footer', [ $this, 'loadForms' ], 77 );
	}

	/* ---
	  Load Vue.js
	--- */

	public function loadVueJs() {
		if ( ! apply_filters( 'wpf_forms_scripts', [] ) ) {
			return;
		}

		$path    = WPF_ASSETS_PATH . 'Forms/Scripts.js';
		$ver     = file_exists( $path ) ? filemtime( $path ) : time();

		?>
		<script src="<?php echo WPF_ASSETS . 'Forms/Scripts.js?ver=' . $ver; ?>"></script>
		<?php
	}

	/* ---
	  Load forms
	--- */

	public function loadForms() {
		if ( ! $forms = apply_filters( 'wpf_forms_scripts', [] ) ) {
			return;
		}

		foreach ( $forms as $formId => $fields ) {
			$this->showScripts( $formId, $fields );
		}
	}

	/* ---
	  Load form
	--- */

	public function showScripts( $formId, $data ) {
		$messages = $this->getMessages( $formId );
		$fields   = [];

		foreach ( $data as $field ) {
			$key            = $field['name'];
			$fields[ $key ] = ! in_array( $field['type'], [ 'multiselect', 'checkbox', 'file' ] ) ? '' : [];

			if ( isset( $field['values_default'] ) && $field['values_default']
				&& in_array( $field['type'], [ 'select', 'multiselect', 'checkbox', 'radio' ] ) ) {
				$fields[ $key ] = is_array( $fields[ $key ] ) ? explode( '|', $field['values_default'] ) : $field['values_default'];
			} else {
				if ( isset( $field['value_default'] ) && $field['value_default']
					&& in_array( $field['type'], [ 'hidden' ] ) ) {
					$fields[ $key ] = $field['value_default'];
				}
			}

			$fields[ $key ] = apply_filters( 'wpf_filter_data',
				'wpf_forms_field_value', $fields[ $key ], [ $field, $formId ], $formId );
		}

		$config = [
			'api_url'       => apply_filters( 'wpf_forms_api_url', '', $formId ),
			'form_id'       => $formId,
			'data'          => [
				'form'     => $fields,
				'response' => [
					'submit_error'   => '',
					'submit_success' => '',
				],
				'status'   => [
					'errors'            => false,
					'errors_validation' => false,
					'errors_response'   => false,
					'sending'           => false,
					'sent'              => false,
					'type'              => null,
				],
			],
			'fields_keys'   => array_keys( $fields ),
			'messages'      => $messages,
			'recaptcha_key' => $this->getRecaptchaField( $data ),
			'options'       => [
				'submit_no_clear' => get_field( 'settings_submit_no_clear', $formId ) ? true : false,
			],
		];
		$config = apply_filters( 'wpf_filter_data',
			'wpf_forms_config', $config, [ $formId ], $formId );

		?>
		<script>
			(function () {
				new WordPressFrameworkForms(<?php echo json_encode( $config ); ?>);
			}());
		</script>
		<?php
	}

	private function getMessages( $formId ) {
		$list = [
			'send'     => [
				'success'  => get_field( 'messages_send_success', $formId ),
				'error'    => get_field( 'messages_send_error', $formId ),
				'validate' => get_field( 'messages_send_validate', $formId ),
			],
			'validate' => [
				'before'      => get_field( 'messages_date_before', $formId ),
				'after'       => get_field( 'messages_date_after', $formId ),
				'date_format' => get_field( 'messages_validate_date_format', $formId ),
				'email'       => get_field( 'messages_validate_email', $formId ),
				'ext'         => get_field( 'messages_validate_file_extension', $formId ),
				'max'         => get_field( 'messages_validate_value_long', $formId ),
				'max_value'   => get_field( 'messages_validate_number_max', $formId ),
				'min'         => get_field( 'messages_validate_value_short', $formId ),
				'min_value'   => get_field( 'messages_validate_number_min', $formId ),
				'numeric'     => get_field( 'messages_validate_number', $formId ),
				'decimal'     => get_field( 'messages_validate_number', $formId ),
				'regex'       => get_field( 'messages_validate_regex', $formId ),
				'required'    => get_field( 'messages_validate_required', $formId ),
				'size'        => get_field( 'messages_validate_file_size', $formId ),
				'url'         => get_field( 'messages_validate_url', $formId ),
				'step'        => get_field( 'messages_validate_number_step', $formId ),
			],
		];

		return $list;
	}

	private function getRecaptchaField( $fields ) {
		foreach ( $fields as $field ) {
			if ( $field['type'] == 'recaptcha' ) {
				return $field['name'];
			}
		}

		return '';
	}
}
