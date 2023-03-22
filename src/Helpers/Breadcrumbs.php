<?php

namespace Framework\Helpers;

class Breadcrumbs {

	public function __construct() {
		add_filter( 'wpf_breadcrumbs', [ $this, 'getBreadcrumbs' ] );
	}

	/* ---
	  Actions
	--- */

	public function getBreadcrumbs( $value ) {
		return $this->getBreadcrumbsList();
	}

	/* ---
	  Functions
	--- */

	private function getBreadcrumbsList() {
		$data   = $this->getQueryObject();
		$list   = [];
		$list[] = [
			'url'   => home_url( '/' ),
			'title' => get_the_title( get_option( 'page_on_front' ) ),
		];

		if ( isset( $data['post_type'] ) ) {

			if ( $data['post_type'] == 'page' ) {
				$list = array_merge( $list, $this->getPageBreadcrumbs( $data ) );
			} else {
				if ( $data['post_type'] == 'post' ) {
					$list = array_merge( $list, $this->getPostBreadcrumbs( $data ) );
				} else {
					if ( isset( $data['post_id'] ) ) {
						$list = array_merge( $list, $this->getSingularBreadcrumbs( $data ) );
					} else {
						$list = array_merge( $list, $this->getArchiveBreadcrumbs( $data ) );
					}
				}
			}

		} else {
			if ( isset( $data['taxonomy'] ) ) {

				$list = array_merge( $list, $this->getTaxonomyBreadcrumbs( $data ) );

			} else {
				if ( is_search() ) {

					$title  = function_exists( 'get_field' ) ? get_field( 'wpf_translations_search_title', 'option' ) : '';
					$list[] = [
						'url'   => home_url( '/?s=' . isset( $_GET['s'] ) ? $_GET['s'] : '' ),
						'title' => $title ? $title : __( 'Search Results', 'lang' ),
					];

				}
			}
		}

		$list = array_filter( $list );
		return $list;
	}

	private function getQueryObject() {
		$object = get_queried_object();
		$class  = is_object( $object ) ? get_class( $object ) : '';

		switch ( $class ) {
			case 'WP_Term':

				$data = [
					'taxonomy' => $object->taxonomy,
					'term_id'  => $object->term_id,
				];

				break;
			case 'WP_Post_Type':

				$data = [
					'post_type' => $object->name,
				];

				break;
			case 'WP_Post':

				$data = [
					'post_type' => $object->post_type,
					'post_id'   => $object->ID,
				];

				break;
		}

		return isset( $data ) ? $data : [];
	}

	/* ---
	  Page
	--- */

	private function getPageBreadcrumbs( $data ) {
		$list = [];
		if ( $data['post_id'] == get_option( 'page_on_front' ) ) {
			return $list;
		}

		$list   = array_merge( $list, $this->getPageParents( $data['post_id'] ) );
		$list[] = [
			'url'   => get_permalink( $data['post_id'] ),
			'title' => get_the_title( $data['post_id'] ),
		];

		return $list;
	}

	private function getPageParents( $pageId ) {
		$parents = get_post_ancestors( $pageId );
		if ( ! $parents ) {
			return [];
		}

		$list = [];

		foreach ( $parents as $parent ) {
			$list[] = [
				'url'   => get_permalink( $parent ),
				'title' => get_the_title( $parent ),
			];
		}

		$list = array_reverse( $list );
		return $list;
	}

	/* ---
	  Post
	--- */

	private function getPostBreadcrumbs( $data ) {
		$list = [];

		$postsPage = get_option( 'page_for_posts' );
		$postType  = get_post_type_object( $data['post_type'] );

		$list[] = [
			'url'   => get_post_type_archive_link( $postType->name ),
			'title' => $postsPage ? get_the_title( $postsPage ) : $postType->labels->name,
		];
		$list   = array_merge( $list, $this->getPostTerms( $data['post_id'], 'category' ) );
		$list[] = [
			'url'   => get_permalink( $data['post_id'] ),
			'title' => get_the_title( $data['post_id'] ),
		];

		return $list;
	}

	private function getPostTerms( $postId, $taxonomy ) {
		$terms = wp_get_post_terms( $postId, $taxonomy, [ 'orderby' => 'term_id', 'order' => 'asc' ] );
		if ( ! $terms || is_wp_error( $terms ) ) {
			return [];
		}

		$yoastCategory = get_post_meta( $postId, '_yoast_wpseo_primary_' . $taxonomy, true );

		if ( $yoastCategory ) {
			$term = get_term_by( 'id', $yoastCategory, $taxonomy );
		} else {
			foreach ( $terms as $term ) {
				if ( $term->term_id == 1 ) {
					continue;
				}
				$list[ $term->term_id ] = $term->parent;
			}
			if ( ! $list ) {
				return [];
			}

			foreach ( $list as $termId => $parentId ) {
				if ( isset( $list[ $parentId ] ) ) {
					unset( $list[ $parentId ] );
				}
			}

			$list = array_keys( $list );
			$term = get_term_by( 'id', $list[0], $taxonomy );
		}

		$terms   = [];
		$terms[] = [
			'url'   => get_term_link( $term, $taxonomy ),
			'title' => $term->name,
		];

		$terms = array_merge( $this->getTermParents( $term ), $terms );
		return $terms;
	}

	/* ---
	  Post type
	--- */

	private function getSingularBreadcrumbs( $data ) {
		$list = [];

		$postType = get_post_type_object( $data['post_type'] );
		$list[]   = [
			'url'   => get_post_type_archive_link( $postType->name ),
			'title' => $postType->labels->name,
		];

		$taxonomy = $data['post_type'] . '-category';
		$list     = array_merge( $list, $this->getPostTerms( $data['post_id'], $taxonomy ) );
		$list[]   = [
			'url'   => get_permalink( $data['post_id'] ),
			'title' => get_the_title( $data['post_id'] ),
		];

		return $list;
	}

	/* ---
	  Archive
	--- */

	private function getArchiveBreadcrumbs( $data ) {
		$list = [];

		$postType = get_post_type_object( $data['post_type'] );
		$list[]   = [
			'url'   => get_post_type_archive_link( $data['post_type'] ),
			'title' => $postType->labels->name,
		];

		return $list;
	}

	/* ---
	  Taxonomies
	--- */

	private function getTaxonomyBreadcrumbs( $data ) {
		$list = [];

		$term   = get_term_by( 'id', $data['term_id'], $data['taxonomy'] );
		$list[] = $this->findPostTypeForTaxonomy( $data['taxonomy'] );

		$list   = array_merge( $list, $this->getTermParents( $term ) );
		$list[] = [
			'url'   => get_term_link( $term ),
			'title' => $term->name,
		];

		return $list;
	}

	private function findPostTypeForTaxonomy( $taxonomy ) {
		$postTypes = get_post_types();

		foreach ( $postTypes as $postType ) {
			$taxonomies = get_object_taxonomies( $postType );
			if ( ! in_array( $taxonomy, $taxonomies ) ) {
				continue;
			}

			return [
				'url'   => get_post_type_archive_link( $postType ),
				'title' => get_post_type_object( $postType )->labels->name,
			];
		}

		return [];
	}

	private function getTermParents( $term ) {
		if ( ! $term->parent ) {
			return [];
		}
		$list = [];

		while ( $term->parent ) {
			$term = get_term_by( 'id', $term->parent, $term->taxonomy );
			if ( ! is_object( $term ) ) {
				break;
			}

			$list[] = [
				'url'   => get_term_link( $term, $term->taxonomy ),
				'title' => $term->name,
			];
		}

		$list = array_reverse( $list );
		return $list;
	}
}
