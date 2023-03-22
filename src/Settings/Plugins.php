<?php

namespace Framework\Settings;

class Plugins {

	private $list;

	/* ---
	  Actions
	--- */

	public function lockUpdatePlugins( $list ) {
		$this->list = $list;
		add_action( 'site_transient_update_plugins', [ $this, 'lockUpdateSelectedPlugins' ], 10 );
		add_action( 'wp_loaded', [ $this, 'lockPluginNotices' ] );
	}

	/* ---
	  Functions
	--- */

	public function lockUpdateSelectedPlugins( $value ) {
		if ( ! $this->list ) {
			return $value;
		}

		if ( $value ) {
			foreach ( $this->list as $directory => $file ) {
				$plugin = $directory . '/' . $file;
				unset( $value->response[ $plugin ] );
			}
		}

		return $value;
	}

	public function lockPluginNotices() {
		if ( ! $this->list ) {
			return;
		}

		foreach ( $this->list as $directory => $file ) {
			$plugin = $directory . '/' . $file;
			remove_all_actions( 'after_plugin_row_' . $plugin );
		}
	}
}
