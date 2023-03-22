<?php

namespace Framework\Posttype;

class Menu {

	public function __construct() {
		add_filter( 'admin_menu', [ $this, 'newSeparator' ] );
	}

	/* ---
	  Functions
	--- */

	public function newSeparator() {
		global $menu;
		$menu[29] = $menu[59];
	}
}
