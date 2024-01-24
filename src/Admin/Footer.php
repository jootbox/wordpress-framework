<?php

namespace Framework\Admin;

class Footer {

	public function __construct() {
//		add_filter( 'admin_footer_text', [ $this, 'changeFooterText' ] );
	}

	/* ---
	  Functions
	--- */

	public function changeFooterText( $text ) {
		echo $text . sprintf(
				__( '%sThis site is built using %sWordPress Framework%s (v%s).', 'wpf' ),
				'<br>',
				WPF_VERSION
			);
	}
}
