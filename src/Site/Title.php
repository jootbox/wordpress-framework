<?php

namespace Framework\Site;

class Title {

	public function __construct() {
		add_action( 'after_setup_theme', [ $this, 'addTitleTag' ] );
	}

	/* ---
	  Functions
	--- */

	public function addTitleTag() {
		add_theme_support( 'title-tag' );
	}
}
