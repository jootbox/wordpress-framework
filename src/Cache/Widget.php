<?php

namespace Framework\Cache;

class Widget {

	private $config;

	/* ---
	  Actions
	--- */

	public function addWidget( $config ) {
		add_action( 'wp_dashboard_setup', [ $this, 'cacheWidget' ] );
	}

	/* ---
	  Functions
	--- */

	public function cacheWidget() {
		if ( ! current_user_can( 'administrator' ) ) {
			return;
		}

		wp_add_dashboard_widget(
			'wpf_widget_cache',
			__( 'Cache management', 'wpf' ),
			[ $this, 'widgetContent' ],
			null
		);

		global $wp_meta_boxes;
		$dashboard = $wp_meta_boxes['dashboard']['normal']['core'];
		$widget    = $dashboard['wpf_widget_cache'];
		unset( $dashboard['wpf_widget_cache'] );
		$dashboard                                    = array_merge( [ 'wpf_widget_cache' => $widget ], $dashboard );
		$wp_meta_boxes['dashboard']['normal']['core'] = $dashboard;
	}

	public function widgetContent() {
		$path  = ABSPATH . 'wp-content/cache/';
		$files = glob( $path . '*.html' );
		$count = count( $files );

		?>
		<p>
			<a href="<?php echo admin_url( '/' ) . 'admin-ajax.php?action=manual_clear_cache'; ?>"
				class="button button-primary" target="_blank">
				<?php echo sprintf( __( 'Clear cache (%d)', 'wpf' ), $count ); ?>
			</a>
		</p>
		<?php
	}
}
