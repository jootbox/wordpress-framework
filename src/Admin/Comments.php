<?php

namespace Framework\Admin;

class Comments {

	public function __construct() {
		add_filter( 'init', [ $this, 'removeCommentSupport' ], 100 );
	}

	/* ---
	  Functions
	--- */

	public function removeCommentSupport() {
		remove_post_type_support( 'page', 'comments' );
	}
}
