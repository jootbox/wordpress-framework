<?php

namespace Framework\Translate;

class Theme {

	public function __construct() {
		$this->setTextdomain();
	}

	/* ---
	  Functions
	--- */

	public function setTextdomain() {
		load_theme_textdomain( 'lang', get_template_directory() . '/langs' );
		load_theme_textdomain( 'wpf', WPF_PATH . 'langs' );
	}
}
