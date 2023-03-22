<?php

namespace Framework\Acf;

class Optionspage {

	private $args, $isDefault;

	public function __construct() {
		add_filter( 'admin_menu', [ $this, 'newSeparator' ] );
		add_filter( 'admin_menu', [ $this, 'removeDuplicatedLinks' ], 100 );
	}

	/* ---
	  Functions
	--- */

	public function newSeparator() {
		global $menu;
		$menu[51] = $menu[59];
	}

	public function removeDuplicatedLinks() {
		remove_submenu_page( $this->args['slug'], $this->args['slug'] );
	}

	public function registerOptionsPage( $args, $isDefault = false ) {
		if ( ! function_exists( 'acf_add_options_page' ) || ! function_exists( 'acf_add_options_sub_page' ) ) {
			return;
		}

		$this->args      = $args;
		$this->isDefault = $isDefault;
		add_action( 'init', [ $this, 'addNewOptionsPage' ], 0 );

		add_filter( 'wpf_acf_optionspage', function ( $list ) use ( $args ) {
			return array_merge( $list, preg_filter( '/^/', $args['slug'] . '-', array_keys( $args['pages'] ) ) );
		} );

		if ( ! isset( $args['notranslate'] ) ) {
			return;
		}
		add_filter( 'wpf_acf_optionspage_notranslate', function ( $list ) use ( $args ) {
			return array_merge( $list, preg_filter( '/^/', $args['slug'] . '-', $args['notranslate'] ) );
		} );
	}

	public function addNewOptionsPage() {
		$this->addOptionsPage( $this->args );
		$this->addOptionSubPages( $this->args['pages'], $this->args['slug'] );
	}

	private function addOptionsPage( $args ) {
		acf_add_options_page( [
			'page_title' => $args['title'],
			'menu_slug'  => $args['slug'],
			'capability' => 'manage_options',
			'position'   => $this->isDefault ? 58 : 57,
			'icon_url'   => $args['icon'],
			'redirect'   => false,
		] );
	}

	private function addOptionSubPages( $pages, $parent ) {
		foreach ( $pages as $slug => $title ) {
			acf_add_options_sub_page( [
				'page_title'  => $title,
				'menu_slug'   => sprintf( '%s-%s', $parent, $slug ),
				'parent_slug' => $parent,
			] );
		}
	}
}
