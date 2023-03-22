<?php

namespace Framework\Forms;

class Validate {
	/* ---
	  Functions
	--- */

	public function getVueValidation( $field, $fieldsKeys, $settings ) {
		$rules = [];

		/* ---
		  Required
		--- */

		if ( in_array( $field['type'], [ 'recaptcha' ] ) || $field['validate_required'] ) {

			$rules[] = "required: true";

		}

		/* ---
		  Length
		--- */

		if ( in_array( $field['type'], [ 'text', 'password', 'textarea' ] ) ) {

			if ( $field['validate_length_min'] != '' ) {
				$rules[] = "min: {$field['validate_length_min']}";
			}

			if ( $field['validate_length_max'] != '' ) {
				$rules[] = "max: {$field['validate_length_max']}";
			}

		}

		/* ---
		  Number
		--- */

		if ( in_array( $field['type'], [ 'number' ] ) ) {

			$rules[] = "numeric: true";

			if ( $field['number_min'] != '' ) {
				$rules[] = "min_value: {$field['number_min']}";
			}

			if ( $field['number_max'] ) {
				$rules[] = "max_value: {$field['number_max']}";
			}

			if ( $field['number_step'] ) {
				$rules[] = "step: [{$field['number_step']}, {$field['number_min']}]";
			}

		}

		/* ---
		  Date
		--- */

		if ( in_array( $field['type'], [ 'date' ] ) ) {

			$rules[] = "date_format: '{$field['date_format']}'";

			if ( $field['date_before'] ) {
				if ( in_array( $field['date_before'], $fieldsKeys ) ) {
					$rules[] = "before: [form.{$field['date_before']}, true]";
				} else {
					$rules[] = "before: ['{$field['date_before']}', true]";
				}
			}

			if ( $field['date_after'] ) {
				if ( in_array( $field['date_after'], $fieldsKeys ) ) {
					$rules[] = "after: [form.{$field['date_after']}, true]";
				} else {
					$rules[] = "after: ['{$field['date_after']}', true]";
				}
			}

		}

		/* ---
		  File
		--- */

		if ( in_array( $field['type'], [ 'file' ] ) ) {

			if ( $field['validate_file_size'] ) {
				$rules[] = "size: {$field['validate_file_size']}";
			}

			if ( $field['validate_file_extensions'] ) {
				$extensions = [];
				foreach ( $field['validate_file_extensions'] as $value ) {
					$extensions[] = $value['label'];
				}

				$values  = implode( '\', \'', $extensions );
				$rules[] = "ext: ['{$values}']";
			}

		}

		/* ---
		  Regex
		--- */

		if ( in_array( $field['type'], [ 'text', 'email', 'url', 'tel', 'number', 'password' ] ) && $field['validate_regex'] ) {

			$rules[] = "regex: /{$field['validate_regex']}/";

		}

		/* ---
		  File type
		--- */

		if ( in_array( $field['type'], [ 'email' ] ) ) {
			$rules[] = "email: true";
		}

		if ( in_array( $field['type'], [ 'url' ] ) ) {
			$rules[] = "url: true";
		}

		if ( ! $rules ) {
			return '';
		} else {
			if ( $settings['conditions'] && $field['validate_ignore'] ) {
				return 'showValidate({' . implode( ', ', $rules ) . '}, [condition=' . $field['validate_ignore'] . '])';
			} else {
				return '{' . implode( ', ', $rules ) . '}';
			}
		}
	}

	public function validateField( $field, $value, $values, $settings ) {
		if ( in_array( $field['type'], [ 'hidden' ] ) || ( $field['validate_ignore']
				&& isset( $settings['conditions'][ $field['validate_ignore'] ] )
				&& $settings['conditions'][ $field['validate_ignore'] ] ) ) {
			return true;
		}

		/* ---
		  Required
		--- */

		if ( in_array( $field['type'], [ 'recaptcha' ] ) || $field['validate_required'] ) {

			if ( ( $value === '' ) || ( $value === [] ) ) {
				return;
			}

		}

		/* ---
		  Length
		--- */

		if ( in_array( $field['type'], [ 'text', 'password', 'textarea' ] ) ) {

			if ( ! empty( $field['validate_length_min'] ) && ( strlen( $value ) < $field['validate_length_min'] ) ) {
				return;
			}

			if ( ! empty( $field['validate_length_max'] ) && ( strlen( $value ) > $field['validate_length_max'] ) ) {
				return;
			}

		}

		/* ---
		  Number
		--- */

		if ( in_array( $field['type'], [ 'number' ] ) ) {

			if ( ! preg_match( '/^[0-9]+(\.[0-9]+)?$/i', $value ) ) {
				return;
			}

			if ( ! empty( $field['number_min'] ) && ( $value < $field['number_min'] ) ) {
				return;
			}

			if ( ! empty( $field['number_max'] ) && ( $value > $field['number_max'] ) ) {
				return;
			}

			if ( $field['number_step'] ) {
				$number = ( $value - $field['number_min'] ) * 1e5;
				$step   = $field['number_step'] * 1e5;

				if ( fmod( $number, $step ) != 0 ) {
					return;
				}
			}

		}

		/* ---
		  Date
		--- */

		if ( in_array( $field['type'], [ 'date' ] ) ) {

			$timeBefore = isset( $values[ $field['date_before'] ] ) ? $values[ $field['date_before'] ] : $field['date_before'];
			if ( ! empty( $field['date_before'] ) && ( strtotime( $value ) > strtotime( $timeBefore ) ) ) {
				return;
			}

			$timeAfter = isset( $values[ $field['date_after'] ] ) ? $values[ $field['date_after'] ] : $field['date_after'];
			if ( ! empty( $field['date_after'] ) && ( strtotime( $value ) < strtotime( $timeAfter ) ) ) {
				return;
			}

		}

		/* ---
		  File
		--- */

		if ( in_array( $field['type'], [ 'file' ] ) ) {

			foreach ( $value as $file ) {
				if ( ! isset( $file['tmp_name'] ) || ! isset( $file['name'] ) || ! is_readable( $file['tmp_name'] ) || ! is_file( $file['tmp_name'] ) ) {
					return;
				}

				if ( $field['validate_file_size'] && ( filesize( $file['tmp_name'] ) > ( $field['validate_file_size'] * 1024 ) ) ) {
					return;
				}

				if ( $field['validate_file_extensions'] ) {
					$types = array_column( $field['validate_file_extensions'], 'value' );
					$exts  = array_column( $field['validate_file_extensions'], 'label' );
					$type  = mime_content_type( $file['tmp_name'] );
					$ext   = strtolower( pathinfo( $file['name'], PATHINFO_EXTENSION ) );

					if ( ! in_array( $type, $types ) || ! in_array( $ext, $exts ) ) {
						return;
					}
				}
			}

		}

		/* ---
		  Regex
		--- */

		if ( in_array( $field['type'], [ 'text', 'email', 'url', 'tel', 'number', 'password' ] ) && $field['validate_regex'] ) {

			if ( ! preg_match( '/' . $field['validate_regex'] . '/', $value ) ) {
				return;
			}

		}

		/* ---
		  File type
		--- */

		if ( in_array( $field['type'], [ 'email' ] ) && ! filter_var( $value, FILTER_VALIDATE_EMAIL ) ) {
			return;
		}

		if ( in_array( $field['type'], [ 'url' ] ) && ! filter_var( $value, FILTER_VALIDATE_URL ) ) {
			return;
		}

		/* ---
		  reCAPTCHA
		--- */

		if ( in_array( $field['type'], [ 'recaptcha' ] ) ) {

			$url      = sprintf(
				'https://www.google.com/recaptcha/api/siteverify?secret=%s&response=%s&remoteip=%s',
				$settings['recaptcha']['secret'],
				$value,
				isset( $_SERVER['REMOTE_ADDR'] ) ? $_SERVER['REMOTE_ADDR'] : ''
			);
			$content  = file_get_contents( $url );
			$response = json_decode( $content, true );

			if ( ! isset( $response['success'] ) || ! $response['success'] ) {
				return;
			}

		}

		return true;
	}
}
