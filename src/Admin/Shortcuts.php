<?php

namespace Framework\Admin;

class Shortcuts {

	public function __construct() {
		add_action( 'admin_menu', [ $this, 'addMenuPosition' ] );
	}

	/* ---
	  Functions
	--- */

	public function addMenuPosition() {
		add_menu_page(
			'',
			__( 'Quick access', 'wpf' ),
			'manage_options',
			'wpf_shortcuts',
			'',
			'dashicons-networking',
			56
		);

		$this->addShortcutHome();
		$this->addShortcutMenu();
		$this->addShortcutTranslate();

		$this->removeFirstMenuItem();
	}

	private function addShortcutHome() {
		$pageId = get_option( 'page_on_front' );
		if ( function_exists( 'pll_get_post' ) ) {
			$pageId = pll_get_post( $pageId );
		}
		if ( ! $pageId ) {
			return;
		}

		add_submenu_page(
			'wpf_shortcuts',
			'',
			get_the_title( $pageId ),
			'manage_options',
			sprintf( 'post.php?post=%s&action=edit', $pageId )
		);
	}

	private function addShortcutMenu() {
		$pageId = get_option( 'page_on_front' );
		if ( function_exists( 'pll_get_post' ) ) {
			$pageId = pll_get_post( $pageId );
		}
		if ( ! $pageId ) {
			return;
		}

		add_submenu_page(
			'wpf_shortcuts',
			'',
			__( 'Menu', 'wpf' ),
			'manage_options',
			'nav-menus.php'
		);
	}

	private function addShortcutTranslate() {
		if ( ! is_plugin_active( 'loco-translate/loco.php' ) ) {
			return;
		}

		$theme = wp_get_theme();
		add_submenu_page(
			'wpf_shortcuts',
			'',
			__( 'Theme translation', 'wpf' ),
			'manage_options',
			sprintf( 'admin.php?bundle=%s&page=loco-theme&action=view', $theme->get_stylesheet() )
		);
	}

	private function removeFirstMenuItem() {
		global $submenu;
		if ( isset( $submenu['wpf_shortcuts'] ) ) {
			$submenu['wpf_shortcuts'] = array_slice( $submenu['wpf_shortcuts'], 1 );
		}
	}
}
