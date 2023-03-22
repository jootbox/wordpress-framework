<?php

namespace Framework\Integration;

class LiveChat {

	public function __construct() {
		add_action( 'wp_footer', [ $this, 'installationCode' ], 1000 );
	}

	/* ---
	  Functions
	--- */

	public function installationCode() {
		if ( ! $code = get_field( 'wpf_integration_livechat', 'options' ) ) {
			return;
		}

		?>
		<!-- BEGIN LiveChat -->
		<script>
			window.__lc         = window.__lc || {};
			window.__lc.license = <?php echo $code; ?>;
			(function () {
				var lc   = document.createElement('script');
				lc.type  = 'text/javascript';
				lc.async = true;
				lc.src   = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'cdn.livechatinc.com/tracking.js';
				var s    = document.getElementsByTagName('script')[0];
				s.parentNode.insertBefore(lc, s);
			})();
		</script>
		<!-- END LiveChat -->
		<?php
	}
}
