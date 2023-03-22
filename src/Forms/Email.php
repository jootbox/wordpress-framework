<?php

namespace Framework\Forms;

class Email {

	private $data;

	public function __construct( $formId, $values, $config, $settings ) {
		$this->data = $this->getEmailData( $formId, $values, $config, $settings );
	}

	/* ---
	  Data
	--- */

	private function getEmailData( $formId, $values, $config, $settings ) {
		$data = [
			'to'          => $this->printData( $config['to'], $values ),
			'subject'     => $this->printData( $config['subject'], $values ),
			'message'     => $this->getMessage( $config['message'], $config['is_html'] ?? false, $values ),
			'headers'     => $this->getHeaders( $config, $values ),
			'attachments' => $this->getAttachments( $config, $values ),
			'status'      => ( ! $settings['conditions'] || ! $config['condition_group']
				|| ( isset( $settings['conditions'][ $config['condition_group'] ] )
					&& $settings['conditions'][ $config['condition_group'] ] ) ),
		];

		if ( $data['status'] ) {
			$data = apply_filters( 'wpf_filter_data',
				'wpf_forms_email', $data, [ $values, $formId ], $formId );
		}

		return $data;
	}

	private function getMessage( $template, $isHtml, $values ) {
		$content  = $this->printData( $template, $values );
		$siteName = wp_specialchars_decode( get_option( 'blogname' ), ENT_QUOTES );
		$siteUrl  = site_url( '/' );

		$content = preg_replace( '/%site_name%/', $siteName, $content );
		$content = preg_replace( '/%site_url%/', sprintf( '<a href="%s">%s</a>', $siteUrl, $siteUrl ), $content );
		if ( ! $isHtml ) {
			$content = nl2br( $content );
		}
		$content .= sprintf( '<span style="display: none; opacity: 0;">%s</span>', date( 'Y-m-d H:i:s' ) );
		return $content;
	}

	private function printData( $content, $values ) {
		foreach ( $values['fields'] as $key => $value ) {
			if ( is_array( $value ) ) {
				if ( count( $value ) > 1 ) {
					$value = '- ' . implode( PHP_EOL . '- ', $value );
				} else {
					$value = implode( PHP_EOL, $value );
				}
			}

			$content = str_replace( '[' . $key . ']', $value, $content );
		}

		return $content;
	}

	private function getHeaders( $email, $values ) {
		$list = [];

		$list[] = 'From: ' . $email['from'];
		$list   = array_merge( $list, explode( PHP_EOL, $email['additional_headers'] ) );

		foreach ( $list as $key => $header ) {
			$list[ $key ] = $this->printData( $header, $values );
		}

		$list = implode( PHP_EOL, $list );
		return $list;
	}

	private function getAttachments( $email, $values ) {
		$list = [];
		if ( ! $attachments = $email['attachments'] ?? [] ) {
			return $list;
		}

		foreach ( $attachments as $attachment ) {
			extract( $attachment );
			if ( ( $type === 'field' ) && ( $files = $values['files'][ $name ] ?? ( $values['fields'][ $name ] ?? [] ) ) ) {
				$list = array_merge( $list, array_filter( (array) $files ) );
			} elseif ( ( $type === 'file' ) && ( $file = get_attached_file( $file['id'] ) ) ) {
				$list[] = $file;
			}
		}

		return $list;
	}

	/* ---
	  Sending
	--- */

	public function sendEmail() {
		if ( ! $this->data ) {
			return false;
		}
		if ( ! $this->data['status'] ) {
			return null;
		}

		add_filter( 'wp_mail_content_type', [ $this, 'setHtmlContentType' ] );
		$response = wp_mail(
			$this->data['to'],
			$this->data['subject'],
			$this->data['message'],
			$this->data['headers'],
			$this->data['attachments']
		);
		remove_filter( 'wp_mail_content_type', [ $this, 'setHtmlContentType' ] );

		return $response;
	}

	public function setHtmlContentType() {
		return 'text/html';
	}
}
