<?php

namespace Framework\Site;

class Notifications {

	public function __construct() {
		$this->disableNotificationsForAutoUpdate();
		$this->disableNotificationsForNewUser();

		add_action( 'register_new_user', [ $this, 'setNotificationsForNewUser' ] );
		add_action( 'edit_user_created_user', [ $this, 'setNotificationsForNewUser' ], 10, 2 );
		add_action( 'network_site_new_created_user', [ $this, 'setNotificationsForNewUser' ] );
		add_action( 'network_site_users_created_user', [ $this, 'setNotificationsForNewUser' ] );
		add_action( 'network_user_new_created_user', [ $this, 'setNotificationsForNewUser' ] );
	}

	/* ---
	  Functions
	--- */

	public function disableNotificationsForAutoUpdate() {
		add_filter( 'auto_plugin_update_send_email', '__return_false' );
		add_filter( 'auto_theme_update_send_email', '__return_false' );
	}

	public function disableNotificationsForNewUser() {
		remove_action( 'register_new_user', 'wp_send_new_user_notifications' );
		remove_action( 'edit_user_created_user', 'wp_send_new_user_notifications', 10, 2 );
		remove_action( 'network_site_new_created_user', 'wp_send_new_user_notifications' );
		remove_action( 'network_site_users_created_user', 'wp_send_new_user_notifications' );
		remove_action( 'network_user_new_created_user', 'wp_send_new_user_notifications' );
	}

	public function setNotificationsForNewUser( $user_id, $notify = 'both' ) {
		if ( $notify === 'admin' ) {
			return;
		}
		wp_new_user_notification( $user_id, null, 'user' );
	}
}
