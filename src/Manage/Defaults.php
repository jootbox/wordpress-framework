<?php

namespace Framework\Manage;

class Defaults {

	public function __construct() {
		add_action( 'admin_init', [ $this, 'loadColumnsForPosttypes' ], 0 );
	}

	/* ---
	  Functions
	--- */

	public function loadColumnsForPosttypes() {
		$taxonomies = apply_filters( 'wpf_taxonomy_register', [] );

		foreach ( $taxonomies as $taxonomy ) {
			foreach ( $taxonomy['posttypes'] as $posttype ) {
				add_filter( 'wpf_manage-' . $posttype . '_columns', function ( $columns ) use ( $taxonomy, $posttype ) {
					return $this->addColumnForTaxonomy( $columns, $taxonomy, $posttype );
				} );
				add_filter( 'wpf_manage-' . $posttype . '_filters', function ( $columns ) use ( $taxonomy, $posttype ) {
					return $this->addFilterForTaxonomy( $columns, $taxonomy, $posttype );
				} );
			}
		}
	}

	private function addColumnForTaxonomy( $columns, $taxonomy, $posttype ) {
		return array_merge( $columns, [
			'wpf_' . $taxonomy['slug'] => [
				'label'        => $taxonomy['labels']['name'],
				'action_value' => function ( $objectId ) use ( $taxonomy, $posttype ) {
					return implode( ', ', $this->getTermsListForPost( $objectId, $posttype, $taxonomy['slug'] ) );
				},
				'action_sort'  => false,
			],
		] );
	}

	private function getTermsListForPost( $postId, $posttype, $taxonomy ) {
		$list  = [];
		$terms = wp_get_post_terms( $postId, $taxonomy );
		if ( ! $terms ) {
			return $list;
		}

		foreach ( $terms as $term ) {
			$list[] = sprintf(
				'<a href="?post_type=%s&filter_wpf_%s=%s">%s</a>',
				$posttype,
				$taxonomy,
				$term->term_id,
				$term->name
			);
		}
		return $list;
	}

	private function addFilterForTaxonomy( $filters, $taxonomy, $posttype ) {
		$terms = $this->getTermsForFilter( $taxonomy );
		return array_merge( $filters, [
			'wpf_' . $taxonomy['slug'] => [
				'label'        => sprintf( __( 'Filter by "%s"', 'wpf' ), $taxonomy['labels']['name'] ),
				'values'       => $terms,
				'action_query' => function ( $args, $defaultArgs, $value ) use ( $taxonomy, $posttype ) {
					$args['tax_query'] = [
						[
							'taxonomy' => $taxonomy['slug'],
							'field'    => 'id',
							'terms'    => [ $value ],
							'operator' => 'IN',
						],
					];
					return $args;
				},
			],
		] );
	}

	private function getTermsForFilter( $taxonomy ) {
		$terms = get_terms( [
			'taxonomy'   => $taxonomy['slug'],
			'hide_empty' => false,
		] );
		if ( ! $terms ) {
			return [];
		}

		$keys   = array_map( function ( $object ) {
			return $object->term_id;
		}, $terms );
		$values = array_map( function ( $object ) {
			return [
				'name'   => sprintf( '%s (%d)&nbsp;', $object->name, $object->count ),
				'parent' => $object->parent,
			];
		}, $terms );

		return array_combine( $keys, $values );
	}
}
