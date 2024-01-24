<?php

namespace Framework\Admin;

class _Core {
	private $menu;

	public function __construct() {
		new Assets();
		new Bar();
		new Categories();
		new Comments();
		new Footer();
		new Gutenberg();
		$this->menu = new Menu();
		new Migration();
		new Shortcuts();
		new Yoast();
	}

	/* ---
	  Actions
	--- */

	public function action( $action, $args = false ) {
		switch ( $action ) {
			case 'gutenberg':

				if ( $args === true ) {
					add_filter( 'wpf_admin_gutenberg_active', '__return_true' );
				}

				break;
			case 'menu':

				$this->menu->configAdminMenu( $args );

				break;
			case 'tinymce':

				( new Tinymce() )->configTinymce( $args );

				break;
			default:

				error_log( sprintf(
					'WordPress Framework: undefined action `%s` in Framework\\Admin\\_Core',
					$action
				) );

				break;
		}
	}
}
