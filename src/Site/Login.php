<?php

namespace Framework\Site;

class Login {

	public function __construct() {
		add_filter( 'login_headerurl', [ $this, 'customLoginUrl' ] );
	}

	/* ---
	  Functions
	--- */

	public function customLoginUrl() {
		return home_url( '/' );
	}
}
