<?php

namespace Framework\Integration;

class GoogleAnalytics {

	public function __construct() {
		add_action( 'wp_head', [ $this, 'installationCode' ], 0 );
	}

	/* ---
	  Functions
	--- */

	public function installationCode() {
		if ( ! $code = get_field( 'wpf_integration_google_analytics', 'options' ) ) {
			return;
		}

		?>
		<!-- BEGIN Google Analytics -->
		<script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo $code; ?>"></script>
		<script>
			window.dataLayer = window.dataLayer || [];

			function gtag() {
				dataLayer.push(arguments);
			}

			gtag('js', new Date());

			gtag('config', '<?php echo $code; ?>', {
				'cookie_domain': '<?php echo parse_url( site_url( '/' ), PHP_URL_HOST ); ?>'
			});
		</script>
		<!-- END Google Analytics -->
		<?php
	}
}
