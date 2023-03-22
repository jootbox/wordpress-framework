<?php

namespace Framework\Roles;

class Values {

	public function __construct() {
		add_filter( 'acf/load_field/name=wpf_roles_posttype', [ $this, 'getPosttypes' ] );
		add_filter( 'acf/load_field/name=wpf_roles_taxonomy', [ $this, 'getTaxonomies' ] );
		add_filter( 'acf/load_field/name=wpf_roles_optionspages', [ $this, 'getOptionspages' ] );
		add_filter( 'acf/load_field/name=wpf_roles_custom', [ $this, 'getCustomCaps' ] );
		add_filter( 'acf/load_field/name=wpf_roles_langs', [ $this, 'getLangs' ] );
		add_filter( 'acf/load_field/name=wpf_roles_remove_roles', [ $this, 'getRoles' ] );
	}

	/* ---
	  Functions
	--- */

	public function getPosttypes( $field ) {
		$postTypes = apply_filters( 'wpf_posttype_register', [] );
		$postTypes = array_merge( [ 'post', 'page', 'attachment' ], array_keys( $postTypes ) );

		$field['choices'] = array_combine( $postTypes, $postTypes );
		return $field;
	}

	public function getTaxonomies( $field ) {
		$taxonomies = apply_filters( 'wpf_taxonomy_register', [] );
		$taxonomies = array_merge( [ 'category / post_tag' ], array_keys( $taxonomies ) );

		$field['choices'] = array_combine( $taxonomies, $taxonomies );
		return $field;
	}

	public function getOptionspages( $field ) {
		$pages = apply_filters( 'wpf_acf_optionspage', [] );
		asort( $pages );

		$field['choices'] = array_combine( $pages, $pages );
		return $field;
	}

	public function getLangs( $field ) {
		if ( ( ! $terms = get_terms( 'language', [ 'hide_empty' => false ] ) )
			|| is_wp_error( $terms ) ) {
			return $field;
		}

		$list = [];
		foreach ( $terms as $term ) {
			$list[ $term->slug ] = sprintf( '%s (%s)', $term->name, $term->slug );
		}

		$field['choices'] = $list;
		return $field;
	}

	public function getCustomCaps( $field ) {
		$caps = $GLOBALS['wp_roles']->roles['administrator']['capabilities'] ?? [];
		$list = array_diff_key( $caps, [
			'read'                   => 1,
			'level_10'               => 1,
			'level_9'                => 1,
			'level_8'                => 1,
			'level_7'                => 1,
			'level_6'                => 1,
			'level_5'                => 1,
			'level_4'                => 1,
			'level_3'                => 1,
			'level_2'                => 1,
			'level_1'                => 1,
			'level_0'                => 1,
			'delete_others_posts'    => 1,
			'delete_posts'           => 1,
			'delete_private_posts'   => 1,
			'delete_published_posts' => 1,
			'edit_others_posts'      => 1,
			'edit_posts'             => 1,
			'edit_private_posts'     => 1,
			'edit_published_posts'   => 1,
			'publish_posts'          => 1,
			'read_private_posts'     => 1,
			'delete_others_pages'    => 1,
			'delete_pages'           => 1,
			'delete_private_pages'   => 1,
			'delete_published_pages' => 1,
			'edit_others_pages'      => 1,
			'edit_pages'             => 1,
			'edit_private_pages'     => 1,
			'edit_published_pages'   => 1,
			'publish_pages'          => 1,
			'read_private_pages'     => 1,
			'upload_files'           => 1,
		] );
		$list = array_keys( $list );
		asort( $list );

		$field['choices'] = array_combine( $list, $list );
		return $field;
	}

	public function getRoles( $field ) {
		$roles = $GLOBALS['wp_roles']->roles ?? [];
		$roles = array_diff( array_keys( $roles ), [
			'administrator',
			'subscriber',
		] );
		$roles = array_filter( $roles, function ( $role ) {
			return ( strpos( $role, 'wpf_' ) !== 0 );
		} );
		asort( $roles );

		$field['choices'] = array_combine( $roles, $roles );
		return $field;
	}
}
