<?php

namespace Framework\Taxonomy;

class Acf {

	public function __construct() {
		add_filter( 'acf/validate_field_group', [ $this, 'setLocations' ] );
		add_filter( 'acf/load_field/name=wpf_sitemap_taxonomies', [ $this, 'loadValues' ] );
		add_filter( 'acf/load_field/name=wpf_seo_share_taxonomy', [ $this, 'loadValues' ] );
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
		$values = $this->getValues( true );
		ksort( $values );

		$field['choices'] = $values;
		return $field;
	}

	public function getValues( $labels = false ) {
		$taxonomies = array_filter( apply_filters( 'wpf_taxonomy_register', [] ), function ( $args ) {
			return ( ! isset( $args['args']['public'] ) || $args['args']['public'] );
		} );
		$taxonomies = array_keys( $taxonomies );
		$list       = array_merge( $this->getDefault(), array_combine( $taxonomies, $taxonomies ) );

		if ( $labels ) {
			$list = $this->getLabels( $list );
		}
		return $list;
	}

	private function getDefault() {
		$list = get_taxonomies( [
			'public'   => true,
			'_builtin' => true,
		] );

		if ( ! $list ) {
			return $list;
		}

		foreach ( $list as $index => $slug ) {
			if ( ! in_array( $slug, [ 'category' ] ) ) {
				unset( $list[ $index ] );
			}
		}

		return $list;
	}

	private function getLabels( $items ) {
		$list = [];

		foreach ( $items as $slug ) {
			$object        = get_taxonomy( $slug );
			$list[ $slug ] = sprintf( '%s (%s)', $object->labels->name, $slug );
		}

		return $list;
	}
}
