<?php

namespace Framework\Settings;

class Nav {

	private $list;

	/* ---
	  Actions
	--- */

	public function addnavMenus( $list ) {
		$this->list = $list;
		add_action( 'after_setup_theme', [ $this, 'registerNavMenus' ] );
	}

	/* ---
	  Functions
	--- */

	public function registerNavMenus() {
		if ( ! $this->list ) {
			return;
		}
		register_nav_menus( $this->list );
	}
}
