<?php

namespace Framework\Forms;

class Form {

	public function __construct() {
		add_action( 'wpf_forms_load', [ $this, 'loadForm' ] );
	}

	/* ---
	  Functions
	--- */

	public function loadForm( $formId ) {
		if ( ! $formId ) {
			return;
		}

		$fields   = $this->getFormFields( $formId );
		$settings = $this->getFormSettings( $formId );
		$template = $this->getFormTemplate( $formId, $fields, $settings );
		if ( ! $fields || ! $template ) {
			return;
		}

		add_filter( 'wpf_forms_scripts', function ( $list ) use ( $formId, $fields ) {
			return $list += [ $formId => $fields ];
		} );
		echo $this->getFormHtml( $formId, $template );
	}

	private function getFormFields( $formId ) {
		$fields = get_field( 'fields', $formId );
		$fields = apply_filters( 'wpf_filter_data',
			'wpf_forms_fields', $fields, [ $formId ], $formId );
		return $fields;
	}

	private function getFormSettings( $formId ) {
		$settings = [
			'classes'    => [
				'input_error'    => get_field( 'settings_class_input_error', $formId ),
				'submit_error'   => get_field( 'settings_class_submit_error', $formId ),
				'submit_success' => get_field( 'settings_class_submit_success', $formId ),
			],
			'recaptcha'  => [
				'site_key' => get_field( 'wpf_recapchta_site_key', 'option' ),
			],
			'conditions' => get_field( 'conditions', $formId ),
		];
		$settings = apply_filters( 'wpf_filter_data',
			'wpf_forms_settings', $settings, [ $formId ], $formId );
		return $settings;
	}

	private function getFormTemplate( $formId, $fields, $settings ) {
		$template = get_field( 'template', $formId );
		$template = apply_filters( 'wpf_filter_data',
			'wpf_forms_template', $template, [ $formId ], $formId );
		if ( ! $template ) {
			return $template;
		}

		$template = $this->loadTemplateFields( $template, $fields, $settings, $formId );
		$template = $this->loadTemplateConditions( $template, $formId );
		return $template;
	}

	private function loadTemplateFields( $template, $fields, $settings, $formId ) {
		$api    = new Fields();
		$output = $api->printFields( $template, $fields, $settings, $formId );
		return $output;
	}

	private function loadTemplateConditions( $template, $formId ) {
		$api    = new Conditions();
		$output = $api->printConditions( $template, $formId );
		return $output;
	}

	private function getFormHtml($formId, $template) {
	  $formTitle = get_the_title($formId);
	  $formClass = 'form-' . strtolower(preg_replace('/[^a-zA-Z0-9]+/', '-', $formTitle));
	
	  $output = '<div id="wpf-contact-form-' . $formId . '" data-form-id="' . $formId . '" v-cloak>';
	  $output .= '<form class="vue-form ' . $formClass . '" v-on:submit="onSubmit" :data-status="$data.status.type" ref="_form" novalidate>';
	  $output .= $template;
	  $output .= '</form>';
	  $output .= '</div>';
	  $output .= '<style>[v-cloak] { display: none !important; }</style>';
	
	  $output = apply_filters('wpf_filter_data',
	    'wpf_forms_form_html', $output, [$formId], $formId);
	  return $output;
	}
}
