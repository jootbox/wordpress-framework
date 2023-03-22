<?php

namespace Framework\Helpers;

class Terms {

	public function __construct() {
		add_filter( 'wpf_terms', [ $this, 'getTerms' ], 10, 4 );
	}

	/* ---
	  Actions
	--- */

	public function getTerms( $value, $slug, $sortField = false, $sortOrder = 'asc' ) {
		$items = $this->getTermsList( $slug, $sortField, $sortOrder );
		return $items;
	}

	/* ---
	  Functions
	--- */

	public function getTermsList( $slug, $sortField, $sortOrder ) {
		global $wp;

		$current = is_tax() ? get_queried_object()->term_id : 0;
		$terms   = get_terms( [
			'taxonomy' => $slug,
		] );
		if ( is_wp_error( $terms ) || ! $terms ) {
			return [];
		}

		$terms = $this->termsTree( $terms, $slug, $sortField, $sortOrder );
		$terms = $this->termsActive( $terms, $current )['items'];

		return $terms;
	}

	/* ---
	  Parse items
	--- */

	private function termsActive( $terms, $currentTerm ) {
		$isActive = false;

		foreach ( $terms as $index => $term ) {
			if ( $term['id'] == $currentTerm ) {
				$terms[ $index ]['active'] = true;
				$isActive                  = true;
				continue;
			}
			if ( ! $term['children'] ) {
				continue;
			}

			$children = $this->termsActive( $term['children'], $currentTerm );
			if ( ! $children['active'] ) {
				continue;
			}

			$terms[ $index ]['active']   = true;
			$terms[ $index ]['children'] = $children['items'];
			$isActive                    = false;
		}

		return [
			'active' => $isActive,
			'items'  => $terms,
		];
	}

	private function termsTree( $terms, $slug, $sortField, $sortOrder, $parentId = 0 ) {
		$sortOrder = strtolower( $sortOrder );
		$list      = [];

		foreach ( $terms as $index => $term ) {
			if ( $term->parent != $parentId ) {
				continue;
			}
			$list[] = $this->parseTerm( $term, $terms, $slug, $sortField, $sortOrder );
		}

		if ( ! $sortField ) {
			return $list;
		}

		usort( $list, function ( $a, $b ) use ( $sortField, $sortOrder ) {
			if ( $a[ $sortField ] == $b[ $sortField ] ) {
				if ( $a['title'] == $b['title'] ) {
					return;
				}
				return $a['title'] > $b['title'];
			}
			return ( $sortOrder === 'asc' ) ? $a[ $sortField ] > $b[ $sortField ] : $a[ $sortField ] < $b[ $sortField ];
		} );

		return $list;
	}

	private function parseTerm( $term, $terms, $slug, $sortField, $sortOrder ) {
		$children = $this->termsTree( $terms, $slug, $sortField, $sortOrder, $term->term_id );
		$url      = get_term_link( $term );
		$object   = (object) [
			'term_id'  => $term->term_id,
			'taxonomy' => $term->taxonomy,
		];

		$data = [
			'id'       => $term->term_id,
			'url'      => $url,
			'title'    => $term->name,
			'active'   => false,
			'children' => $children ? $children : [],
		];
		if ( $sortField ) {
			$data[ $sortField ] = get_field( $sortField, $object );
		}

		$data = apply_filters( 'wpf_terms_item', $data, $slug );
		return $data;
	}
}
