<?php

namespace Framework\Integration;

class TagManager {

	public function __construct() {
		add_action( 'wp_head', [ $this, 'installationCode' ], 0 );
		add_action( 'wp_footer', [ $this, 'noscriptCode' ] );
	}

	/* ---
	  Functions
	--- */

	public function installationCode() {
		if ( ! $code = get_field( 'wpf_integration_tag_manager', 'options' ) ) {
			return;
		}

		?>
		<!-- BEGIN Tag Manager -->
		<script>
			(function (w, d, s, l, i) {
				w[l] = w[l] || [];
				w[l].push({
					'gtm.start':
						new Date().getTime(), event: 'gtm.js'
				});
				var f                          = d.getElementsByTagName(s)[0],
					j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : '';
				j.async = true;
				j.src =
					'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
				f.parentNode.insertBefore(j, f);
			})(window, document, 'script', 'dataLayer', '<?php echo $code; ?>');
		</script>
		<!-- END Tag Manager -->
		<?php
	}

	public function noscriptCode() {
		if ( ! $code = get_field( 'wpf_integration_tag_manager', 'options' ) ) {
			return;
		}

		?>
		<!-- BEGIN Tag Manager -->
		<noscript>
			<iframe src="https://www.googletagmanager.com/ns.html?id=<?php echo $code; ?>" height="0" width="0"
				style="display:none;visibility:hidden"></iframe>
		</noscript>
		<!-- END Tag Manager -->
		<?php
	}
}
