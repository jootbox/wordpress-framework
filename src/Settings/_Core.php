<?php

namespace Framework\Settings;

class _Core {

	public function __construct() {
		new Browsersync();
		new Cron();
		new Error404();
		new Phpmailer();
		new Polylang();
	}

	/* ---
	  Actions
	--- */

	public function action( $action, $args = false ) {
		switch ( $action ) {
			case 'images':

				( new Images() )->addImageSizes( $args );

				break;
			case 'nav':

				( new Nav() )->addnavMenus( $args );

				break;
			case 'plugins-update':

				( new Plugins() )->lockUpdatePlugins( $args );

				break;
			case 'security':

				( new Security() )->configSecurity( $args );

				break;
			case 'upload':

				( new Upload() )->addTypesForUpload( $args );

				break;
			default:

				error_log( sprintf(
					'WordPress Framework: undefined action `%s` in Framework\\Settings\\_Core',
					$action
				) );

				break;
		}
	}
}
