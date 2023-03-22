<?php

namespace Framework\Integration;

class Hotjar {

	public function __construct() {
		add_action( 'wp_head', [ $this, 'installationCode' ] );
	}

	/* ---
	  Functions
	--- */

	public function installationCode() {
		if ( ( ! $code = get_field( 'wpf_integration_hotjar', 'options' ) )
			|| ! $code['id'] || ! $code['snippet_version'] ) {
			return;
		}

		?>
		<!-- BEGIN Hotjar -->
		<script>
			(function (h, o, t, j, a, r) {
				h.hj          = h.hj || function () {
					(h.hj.q = h.hj.q || []).push(arguments)
				};
				h._hjSettings = {hjid: <?php echo $code['id']; ?>, hjsv: <?php echo $code['snippet_version']; ?>};
				a             = o.getElementsByTagName('head')[0];
				r             = o.createElement('script');
				r.async       = 1;
				r.src         = t + h._hjSettings.hjid + j + h._hjSettings.hjsv;
				a.appendChild(r);
			})(window, document, '//static.hotjar.com/c/hotjar-', '.js?sv=');
		</script>
		<!-- END Hotjar -->
		<?php
	}
}
