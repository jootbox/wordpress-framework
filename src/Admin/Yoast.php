<?php

namespace Framework\Admin;

class Yoast {

	public function __construct() {
		add_filter( 'wpseo_metabox_prio', [ $this, 'moveYoastToBottom' ] );

		add_action( 'admin_init', [ $this, 'yoastColumns' ], 100 );
		add_action( 'admin_init', [ $this, 'yoastFilters' ] );

		add_action( 'admin_init', [ $this, 'removeDefaultRoles' ] );
	}

	/* ---
	  Box
	--- */

	public function moveYoastToBottom() {
		return 'low';
	}

	/* ---
	  Columns & filters
	--- */

	public function yoastColumns() {
		$postTypes = get_post_types( [
			'public' => true,
		] );

		$taxonomies = get_taxonomies( [
			'public' => true,
		] );

		if ( $postTypes ) {
			foreach ( $postTypes as $slug ) {
				add_filter( 'manage_edit-' . $slug . '_columns', [ $this, 'removeYoastColumns' ] );
			}
		}

		if ( $taxonomies ) {
			foreach ( $taxonomies as $slug ) {
				add_filter( 'manage_edit-' . $slug . '_columns', [ $this, 'removeYoastColumns' ] );
			}
		}
	}

	public function removeYoastColumns( $columns ) {
		unset( $columns['wpseo-links'] );
		unset( $columns['wpseo-score'] );
		unset( $columns['wpseo-score-readability'] );
		unset( $columns['wpseo-title'] );
		unset( $columns['wpseo-metadesc'] );
		unset( $columns['wpseo-focuskw'] );

		return $columns;
	}

	public function yoastFilters() {
		global $wpseo_meta_columns;
		if ( ! $wpseo_meta_columns ) {
			return;
		}

		remove_action( 'restrict_manage_posts', [ $wpseo_meta_columns, 'posts_filter_dropdown' ] );
		remove_action( 'restrict_manage_posts', [ $wpseo_meta_columns, 'posts_filter_dropdown_readability' ] );
	}

	/* ---
	  User roles
	--- */

	public function removeDefaultRoles() {
		remove_role( 'wpseo_manager' );
		remove_role( 'wpseo_editor' );
	}
}
