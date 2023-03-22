<?php

namespace Framework\Roles;

class Update {

	public function __construct() {
		add_action( 'acf/save_post', [ $this, 'manageRoles' ], 0 );
	}

	/* ---
	  Functions
	--- */

	public function manageRoles( $postId ) {
		if ( ( strpos( $postId, 'options' ) === false )
			|| ! isset( $_GET['page'] ) || ( $_GET['page'] !== 'wpf-user_roles' ) ) {
			return;
		}

		$form = apply_filters( 'wpf_acf_form_values', [], true );
		$this->restoreDefaultRoles( $form );
		$this->removeSelectedRoles( $form );
		$this->removeAddedRoles();
		$this->addNewRoles( $form );
	}

	private function restoreDefaultRoles( $form ) {
		if ( ! isset( $form['data']['wpf_roles_restore_roles'] ) ) {
			return;
		}
		$index = array_search( 'wpf_roles_restore_roles', array_keys( $form['data'] ) );
		unset( $_POST['acf'][ $form['keys'][ $index ] ] );
		if ( ! $form['data']['wpf_roles_restore_roles'] ) {
			return;
		}

		$roles = $GLOBALS['wp_roles']->roles ?? [];
		foreach ( $roles as $role => $object ) {
			remove_role( $role );
		}

		if ( ! function_exists( 'populate_roles' ) ) {
			require_once ABSPATH . '/wp-admin/includes/schema.php';
		}
		populate_roles();
		update_option( 'default_role', 'subscriber' );
	}

	private function removeSelectedRoles( $form ) {
		if ( ! isset( $form['data']['wpf_roles_remove_roles'] ) ) {
			return;
		}
		$index = array_search( 'wpf_roles_remove_roles', array_keys( $form['data'] ) );
		unset( $_POST['acf'][ $form['keys'][ $index ] ] );
		if ( ! $form['data']['wpf_roles_remove_roles'] ) {
			return;
		}

		foreach ( $form['data']['wpf_roles_remove_roles'] as $role ) {
			remove_role( $role );
		}
	}

	private function removeAddedRoles() {
		$roles = $GLOBALS['wp_roles'] ?? [];
		$roles = isset( $roles->roles ) ? array_keys( $roles->roles ) : [];
		if ( ! $roles ) {
			return;
		}

		foreach ( $roles as $role ) {
			if ( strpos( $role, 'wpf_' ) !== 0 ) {
				continue;
			}
			remove_role( $role );
		}
	}

	private function addNewRoles( $form ) {
		$roles = $form['data']['wpf_roles'] ?? [];
		if ( ! $roles ) {
			return;
		}

		foreach ( $roles as $role ) {
			( new Add() )->addUserRole( $role );
		}
	}
}
