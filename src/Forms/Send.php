<?php

namespace Framework\Forms;

class Send {
	/* ---
	  Functions
	--- */

	public function sendForm( $request ) {
		$params     = $request->get_params();
		$formId     = $params['_form_id'] ?? null;
		$fields     = [];
		$values     = [];
		$conditions = new Conditions();
		$settings   = [
			'conditions' => $conditions->detectConditions( $formId, $params ),
			'recaptcha'  => [
				'secret' => get_field( 'wpf_recapchta_secret', 'option' ),
			],
		];
		$settings   = apply_filters( 'wpf_filter_data',
			'wpf_forms_settings', $settings, [ $formId ], $formId );

		try {

			/* ---
			  Check form ID
			--- */

			if ( ! $formId || is_integer( $formId ) ) {
				$e         = new \Exception( sprintf( 'Undefined form ID', $formId ) );
				$e->status = 400;
				throw $e;
			}

			/* ---
			  Check form fields
			--- */

			$fields = $this->getFormFields( $formId );
			if ( ! $fields ) {
				$e         = new \Exception( sprintf( 'Form [#%s] not found', $formId ) );
				$e->status = 403;
				throw $e;
			}

			/* ---
			  Fields validation
			--- */

			$data   = new Data();
			$values = $data->getFormValues( $formId, $params, $fields, $settings );

			if ( ! is_array( $values ) ) {
				$e         = new \Exception( sprintf( 'Data validation', $formId ) );
				$e->status = 422;
				$e->data   = $values;
				throw $e;
			}

			/* ---
			  Send actions
			--- */

			$response = $this->handleFormRequest( $formId, $fields, $values, $settings );
			$data->clearFormData();
			return $this->sendResponse( $response['success'], $response['message'], $response['status'],
				$fields, $values, $settings['conditions'], $formId );

		} catch ( \Exception $e ) {

			error_log( sprintf(
				'WordPress Framework: error `%s` when sending form in Framework\\Forms\\Send',
				$e->getMessage()
			) );

			$response = isset( $e->data ) ? $e->data : get_field( 'messages_send_error', $formId );
			$status   = isset( $e->status ) ? $e->status : 500;
			return $this->sendResponse( false, $response, $status,
				$fields, $values, $settings['conditions'], $formId );

		}
	}

	private function getFormFields( $formId ) {
		$fields = get_field( 'fields', $formId );
		$fields = apply_filters( 'wpf_filter_data',
			'wpf_forms_fields', $fields, [ $formId ], $formId );
		return $fields;
	}

	private function handleFormRequest( $formId, $fields, $values, $settings ) {
		$response = $this->initSendActions( $formId, $fields, $values, $settings );
		$data     = [
			'success' => ( $response === true ),
			'message' => is_string( $response ) ? $response : null,
			'status'  => ( $response === true ) ? 202 : 502,
		];
		return $data;
	}

	private function sendResponse( $isSuccess, $message, $statusCode, $fields, $values, $conditions, $formId ) {
		$status  = ( $isSuccess === true );
		$message = apply_filters( 'wpf_filter_data',
			'wpf_forms_response',
			$message,
			[ $status, $statusCode, $fields, $values, $conditions, $formId ],
			$formId
		);
		return new \WP_REST_Response( [
			'message' => $message,
		], $statusCode );
	}

	private function initSendActions( $formId, $fields, $values, $settings ) {
		$error  = get_field( 'messages_send_error', $formId );
		$filter = $this->sendFilters( $formId, $fields, $values );

		if ( ( $filter !== null ) && ( $filter !== true ) ) {
			return $filter;
		}

		$email    = $this->sendEmails( $formId, $values, $settings );
		$response = ( ( ( $filter === true ) && ( $email !== false ) ) || ( $email === true ) );

		if ( $response === true ) {
			return true;
		} else {
			return get_field( 'messages_send_error', $formId );
		}
	}

	private function sendFilters( $formId, $fields, $values ) {
		$status = apply_filters( 'wpf_filter_data',
			'wpf_forms_send_' . $formId, null, [ $fields, $values, $formId ] );
		if ( $status !== null ) {
			return $status;
		}

		$status = apply_filters( 'wpf_filter_data',
			'wpf_forms_send', null, [ $fields, $values, $formId ] );
		if ( $status !== null ) {
			return $status;
		}

		return null;
	}

	private function sendEmails( $formId, $values, $settings ) {
		$list = get_field( 'mail_list', $formId );
		if ( ! $list ) {
			return null;
		}

		$isSent = false;
		foreach ( $list as $email ) {
			$mail   = new Email( $formId, $values, $email, $settings );
			$status = $mail->sendEmail();
			if ( $status === false ) {
				return false;
			} else {
				if ( $status === true ) {
					$isSent = true;
				}
			}
		}

		return $isSent ? true : null;
	}
}
