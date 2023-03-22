<?php

namespace Framework\Seo;

class Search {

	public function __construct() {
		add_action( 'wp_head', [ $this, 'noIndexSearchPage' ] );
	}

	/* ---
	  Functions
	--- */

	public function noIndexSearchPage() {
		if ( is_admin() || ! is_search() ) {
			return;
		}

		?>
		<meta name="robots" content="noindex, follow"/>
		<?php
	}
}
