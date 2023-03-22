<?php

namespace Framework\Admin;

use Framework\Posttype as GlobalPosttype;

class Menu {

	private $config;

	public function __construct() {
		add_filter( 'get_user_option_metaboxhidden_nav-menus', [ $this, 'showAllBoxes' ] );
		add_filter( 'nav_menu_meta_box_object', [ $this, 'updateNavLabels' ] );
	}

	/* ---
	  Actions
	--- */

	public function configAdminMenu( $config ) {
		$this->config = $config;
		if ( isset( $config['posts'] ) && ! $config['posts'] ) {
			new GlobalPosttype\Post();
		}
		if ( isset( $config['pages'] ) && ! $config['pages'] ) {
			new GlobalPosttype\Page();
		}

		add_filter( 'admin_menu', [ $this, 'adminMenu' ] );
		add_filter( 'admin_init', [ $this, 'adminMenuTools' ] );
	}

	/* ---
	  Functions
	--- */

	public function showAllBoxes( $value ) {
		foreach ( $value as $key => $item ) {
			if ( $item === 'pll_lang_switch_box' ) {
				continue;
			}
			unset( $value[ $key ] );
		}
		return $value;
	}

	public function updateNavLabels( $object ) {
		$object->labels->name     .= sprintf( ' [%s]', $object->name );
		$object->labels->archives = sprintf( '- %s', __( 'Archive', 'wpf' ) );
		return $object;
	}

	public function adminMenu() {
		if ( ! isset( $this->config ) || ! $this->config ) {
			return;
		}

		$options = $this->config;
		global $menu;
		global $submenu;

		if ( isset( $options['comments'] ) && ! $options['comments'] ) {
			remove_menu_page( 'edit-comments.php' );
		}

		if ( isset( $options['customize'] ) && ! $options['customize'] ) {
			unset( $submenu['themes.php'][6] );
		}

		if ( isset( $options['wp_tools'] ) && ! $options['wp_tools'] ) {
			remove_submenu_page( 'tools.php', 'tools.php' );
			remove_submenu_page( 'tools.php', 'import.php' );
			remove_submenu_page( 'tools.php', 'export.php' );
		}
	}

	public function adminMenuTools() {
		if ( ! isset( $this->config ) || ! $this->config ) {
			return;
		}

		$options = $this->config;
		global $menu;
		global $submenu;

		if ( isset( $options['wp_tools'] ) && ! $options['wp_tools'] && ( isset( $submenu['tools.php'] ) && ! $submenu['tools.php'] ) ) {
			unset( $menu[75] );
		}
	}
}
