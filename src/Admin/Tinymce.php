<?php

namespace Framework\Admin;

class Tinymce {

	private $config;

	/* ---
	  Actions
	--- */

	public function configTinymce( $config ) {
		$this->config = $config;

		add_action( 'init', [ $this, 'editorSupport' ] );

		add_filter( 'mce_buttons', [ $this, 'firstLineButtons' ], 99 );
		add_filter( 'mce_buttons_2', [ $this, 'secondLineButtons' ], 99 );

		add_action( 'tiny_mce_before_init', [ $this, 'changeBlockFormats' ] );

		add_action( 'tiny_mce_before_init', [ $this, 'forcePasteAsText' ] );
	}

	/* ---
	  Editor
	--- */

	public function editorSupport() {
		if ( ! isset( $this->config['pages_editor'] ) || $this->config['pages_editor'] ) {
			return;
		}
		remove_post_type_support( 'page', 'editor' );
	}

	/* ---
	  Buttons
	--- */

	public function firstLineButtons( $buttons ) {
		if ( ! isset( $this->config['buttons_1'] ) ) {
			return $buttons;
		}
		return $this->config['buttons_1'];
	}

	public function secondLineButtons( $buttons ) {
		if ( ! isset( $this->config['buttons_2'] ) ) {
			return $buttons;
		}
		return $this->config['buttons_2'];
	}

	/* ---
	  Formats
	--- */

	public function changeBlockFormats( $settings ) {
		if ( ! isset( $this->config['formats'] ) || ! $this->config['formats'] ) {
			return $settings;
		}

		$formats = [];
		foreach ( $this->config['formats'] as $block => $name ) {
			$formats[] = $name . '=' . $block . ';';
		}

		$settings['block_formats'] = implode( '', $formats );
		return $settings;
	}

	/* ---
	  Paste as text
	--- */

	public function forcePasteAsText( $init ) {
		$init['paste_as_text'] = true;
		return $init;
	}
}
