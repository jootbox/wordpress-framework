<?php

namespace Framework\Cache;

class Clear {

	private $config;

	/* ---
	  Actions
	--- */

	public function configClear( $config ) {
		$this->config = $config;

		add_action( 'init', [ $this, 'initClearActions' ] );
		add_action( 'wpf_cache_clear', [ $this, 'clearCache' ] );
		add_action( 'wp_ajax_manual_clear_cache', [ $this, 'manualClearCache' ] );
	}

	/* ---
	  Functions
	--- */

	public function initClearActions() {
		if ( ! isset( $this->config['clear_actions'] ) || ! $this->config['clear_actions'] ) {
			return;
		}

		foreach ( $this->config['clear_actions'] as $action ) {
			add_action( $action, [ $this, 'scheduleClearCache' ] );
		}
	}

	public function scheduleClearCache() {
		wp_schedule_single_event( ( time() + 1 ), 'wpf_cache_clear' );
	}

	public function clearCache() {
		$path  = ABSPATH . '/wp-content/cache/';
		$files = file_exists( $path ) ? glob( $path . '*' ) : [];
		if ( ! $files ) {
			return;
		}

		foreach ( $files as $file ) unlink( $file );
	}

	public function manualClearCache() {
		$this->clearCache();

		?>
		<script>window.close();</script>
		<?php
	}
}
