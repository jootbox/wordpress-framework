<?php

namespace Framework\Acf;

class Link {

	public function __construct() {
		add_filter( 'wp_link_query', [ $this, 'linkFieldResults' ], 100, 2 );

		add_filter( 'acf/load_value/type=link', [ $this, 'linkFieldValue' ], 10, 3 );
	}

	/* ---
	  Results
	--- */

	public function linkFieldResults( $results, $query ) {
		if ( isset( $_POST['page'] ) && ( $_POST['page'] != '1' ) ) {
			return $results;
		}

		$search  = isset( $_POST['search'] ) ? mb_strtolower( $_POST['search'] ) : '';
		$results = array_merge( $this->getTaxonomies( $search ), $results );
		$results = array_merge( $this->getPostTypes( $search ), $results );

		return $results;
	}

	private function getPostTypes( $search ) {
		$postTypes = get_post_types( [
			'public'   => true,
			'_builtin' => false,
		] );
		if ( ! $postTypes ) {
			return [];
		}

		$list = [];
		foreach ( $postTypes as $item ) {
			$object = get_post_type_object( $item );

			if ( $search && ( strpos( mb_strtolower( $object->labels->name ), $search ) === false ) ) {
				continue;
			}
			$list[] = [
				'ID'        => 0,
				'title'     => $object->labels->name,
				'permalink' => get_post_type_archive_link( $item ),
				'info'      => __( 'Archive', 'wpf' ),
			];
		}

		return $list;
	}

	private function getTaxonomies( $search ) {
		$taxonomies = get_taxonomies( [
			'public'   => true,
			'_builtin' => false,
		] );

		if ( ! $taxonomies ) {
			return [];
		}

		$list = [];
		foreach ( $taxonomies as $item ) {
			$object = get_taxonomy( $item );
			$terms  = get_terms( [
				'taxonomy'   => $item,
				'hide_empty' => false,
			] );
			if ( ! $terms ) {
				continue;
			}

			foreach ( $terms as $term ) {
				if ( $search && ( strpos( mb_strtolower( $term->name ), $search ) === false )
					&& ( strpos( mb_strtolower( $object->labels->name ), $search ) === false ) ) {
					continue;
				}

				$list[] = [
					'ID'        => 0,
					'title'     => $term->name,
					'permalink' => get_term_link( $term ),
					'info'      => $object->labels->name,
				];
			}
		}

		return $list;
	}

	/* ---
	  Value
	--- */

	public function linkFieldValue( $value, $postId, $field ) {
		if ( ! isset( $value['target'] ) || $value['target'] ) {
			return $value;
		}

		$value['target'] = '_self';
		return $value;
	}
}
