<?php

namespace Framework\Forms;

class Data {

	private $files;
	private $filesList = [];

	public function __construct() {
		$this->files = new Files();
	}

	/* ---
	  Functions
	--- */

	public function getFormValues( $formId, $params, $fields, $settings ) {
		$list = $this->getValuesList( $params, $fields, $settings, $formId );

		try {

			if ( ! is_array( $list ) ) {
				$message = sprintf( get_field( 'messages_send_error_field', $formId ), $list );
				throw new \Exception( $message );
			}

			/* ---
			  Validate filters
			--- */

			$filters = apply_filters( 'wpf_filter_data',
				'wpf_forms_validation', true, [ $fields, $list, $formId ], $formId );
			if ( $filters !== true ) {
				throw new \Exception( $filters );
			}

			/* ---
			  Values filters
			--- */

			$list = apply_filters( 'wpf_filter_data',
				'wpf_forms_values', $list, [ $fields, $formId ], $formId );

			return $list;

		} catch ( \Exception $error ) {

			$this->clearFormData();

			$message = $error->getMessage();
			$message = $message ? $message : get_field( 'messages_send_validate', $formId );
			return $message;

		}
	}

	private function getValuesList( $params, $fields, $settings, $formId ) {
		$validate = new Validate();
		$values   = $this->getFormData( $params, $fields );
		$list     = [
			'fields' => [],
			'files'  => [],
		];

		foreach ( $fields as $field ) {
			$key = $field['name'];

			if ( ! $validate->validateField( $field, $values[ $key ], $values, $settings ) ) {
				return $key;
			}
			if ( in_array( $field['type'], [ 'recaptcha' ] ) ) {
				continue;
			}

			$data = $values[ $key ];

			if ( $field['type'] === 'file' ) {
				$files                 = $this->files->uploadFiles( $values[ $key ] );
				$data                  = array_column( $files, 'file' );
				$list['files'][ $key ] = array_column( $files, 'path' );
				$this->filesList       = array_merge( $this->filesList, array_column( $files, 'path' ) );
			}

			if ( in_array( $field['type'], [ 'select', 'checkbox', 'radio' ] ) ) {
				foreach ( $field['values'] as $value ) {
					if ( $value['value'] !== $data ) {
						continue;
					}
					$list['fields'][ $key . '__label' ] = $value['label'];
				}
			} else {
				if ( in_array( $field['type'], [ 'agreement' ] ) ) {
					$list['fields'][ $key . '__label' ] = strip_tags( $field['agreement_html'] );
				}
			}

			$list['fields'][ $key ] = $data;
		}

		return $list;
	}

	private function getFormData( $params, $fields ) {
		$list = [];

		foreach ( $fields as $field ) {
			$key = $field['name'];

			if ( ! in_array( $field['type'], [ 'file' ] ) ) {
				$list[ $key ] = isset( $params[ $key ] ) ? $params[ $key ] : '';
			} else {
				$list[ $key ] = $this->files->getFieldFiles( $key );
			}
		}

		return $list;
	}

	public function clearFormData() {
		$this->files->removeFiles( $this->filesList );
	}
}
