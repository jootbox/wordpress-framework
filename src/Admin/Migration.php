<?php

namespace Framework\Admin;

class Migration {

	public function __construct() {
		add_filter( 'ai1wm_exclude_content_from_export', [ $this, 'excludePaths' ], 10, 1 );
	}

	/* ---
	  Functions
	--- */

	public function excludePaths( $list ) {
		$list[] = 'cache';
		$list[] = 'logs';
		$list[] = implode( DIRECTORY_SEPARATOR, [
			'themes',
			wp_get_theme()->template,
			'node_modules',
		] );
		return $list;
	}
}
