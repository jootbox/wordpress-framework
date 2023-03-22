<?php

namespace Framework\Site;

class Ajax {

	public function __construct() {
		add_action( 'init', [ $this, 'disableWptexturize' ] );
		add_filter( 'wp_head', [ $this, 'showAjaxUrl' ] );
	}

	/* ---
	  Functions
	--- */

	public function disableWptexturize() {
		if ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX || ! isset( $_REQUEST['action'] ) ) {
			return;
		}

		$response = apply_filters( 'wpf_ajax_noparse_' . $_REQUEST['action'], null );
		if ( $response ) {
			add_filter( 'run_wptexturize', '__return_false' );
		}
	}

	public function showAjaxUrl() {
		?>
		<script>
			if (typeof wpF === 'undefined')
				var wpF = {};

			wpF.ajaxurl = '<?php echo admin_url( 'admin-ajax.php' ); ?>';
		</script>
		<?php
	}
}
