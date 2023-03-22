<?php

namespace Framework\Posttype;

class Acf {

	public function __construct() {
		add_filter( 'acf/validate_field_group', [ $this, 'setLocations' ] );
		add_filter( 'acf/load_field/name=wpf_sitemap_posttypes', [ $this, 'loadValues' ] );
		add_filter( 'acf/load_field/name=wpf_seo_share_posttype', [ $this, 'loadValues' ] );
		add_filter( 'acf/load_field/name=wpf_duplicator_post_types', [ $this, 'loadValues' ] );
	}

	/* ---
	  Functions
	--- */

	public function setLocations( $group ) {
		if ( $group['key'] !== 'group_wpf8mg8yabcw7' ) {
			return $group;
		}

		$postTypes = $this->getValues();
		foreach ( $postTypes as $postType ) {
			$group['location'][] = [
				[
					'param'    => 'post_type',
					'operator' => '==',
					'value'    => $postType,
				],
			];
		}
		return $group;
	}

	public function loadValues( $field ) {
		$values = $this->getValues( true, in_array( $field['name'], [ 'wpf_duplicator_post_types' ] ) );
		ksort( $values );

		$field['choices'] = $values;
		return $field;
	}

	public function getValues( $labels = false, $showPrivate = false ) {
		$postTypes = array_filter( apply_filters( 'wpf_posttype_register', [] ), function ( $args ) use ( $showPrivate ) {
			return ( $showPrivate || ( ! isset( $args['args']['public'] ) || $args['args']['public'] ) );
		} );
		$postTypes = array_keys( $postTypes );
		$list      = array_merge( $this->getDefault(), array_combine( $postTypes, $postTypes ) );

		if ( $labels ) {
			$list = $this->getLabels( $list );
		}
		return $list;
	}

	private function getDefault() {
		$list = get_post_types( [
			'public'   => true,
			'_builtin' => true,
		] );

		if ( ! $list ) {
			return $list;
		}

		foreach ( $list as $index => $slug ) {
			if ( ! in_array( $slug, [ 'post', 'page' ] ) ) {
				unset( $list[ $index ] );
			}
		}

		return $list;
	}

	private function getLabels( $items ) {
		$list = [];

		foreach ( $items as $slug ) {
			$object        = get_post_type_object( $slug );
			$list[ $slug ] = sprintf( '%s (%s)', $object->labels->name, $slug );
		}

		return $list;
	}
}
