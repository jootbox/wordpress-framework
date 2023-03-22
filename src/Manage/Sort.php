<?php

namespace Framework\Manage;

class Sort {

	private $slug, $columns;

	public function __construct( $slug, $columns ) {
		$this->slug    = $slug;
		$this->columns = $columns;
	}

	/* ---
	  Functions
	--- */

	public function initActions() {
		if ( ! $this->columns ) {
			return;
		}

		add_filter( 'manage_edit-' . $this->slug . '_sortable_columns', [ $this, 'addSortableColumns' ] );
		add_action( 'pre_get_posts', [ $this, 'sortPosts' ] );
		add_filter( 'get_terms', [ $this, 'sortTerms' ], 10, 3 );
	}

	public function addSortableColumns( $columns ) {
		foreach ( $this->columns as $key => $column ) {
			if ( false === $column['action_sort'] ?? false ) {
				continue;
			}
			$columns[ $key ] = $key;
		}
		return $columns;
	}

	public function sortPosts( $query ) {
		global $pagenow;
		if ( ( $pagenow !== 'edit.php' ) || ! $query->is_main_query()
			|| ! isset( $_GET['post_type'] ) || ( $_GET['post_type'] !== $this->slug )
			|| ( ! $orderby = $_GET['orderby'] ?? '' ) || ! isset( $this->columns[ $orderby ] )
			|| ( false === $this->columns[ $orderby ]['action_sort'] ?? false ) ) {
			return;
		}

		$params = [ [], $query->query_vars, $_GET['order'] ];
		$args   = call_user_func_array( $this->columns[ $orderby ]['action_sort'], $params );
		foreach ( $args as $key => $value ) $query->set( $key, $value );
	}

	public function sortTerms( $terms, $taxonomies, $args ) {
		global $pagenow;
		if ( ( $pagenow !== 'edit-tags.php' ) || ! in_array( $this->slug, $taxonomies )
			|| ( ! $orderby = $_GET['orderby'] ?? '' ) || ! isset( $this->columns[ $orderby ] )
			|| ( false === $this->columns[ $orderby ]['action_sort'] ?? false ) ) {
			return $terms;
		}

		remove_filter( 'get_terms', [ $this, 'sortTerms' ], 10, 3 );
		$params = [ [], $args, $_GET['order'] ];
		$args   = array_merge( $args, call_user_func_array( $this->columns[ $orderby ]['action_sort'], $params ) );
		$terms  = get_terms( $args );
		add_filter( 'get_terms', [ $this, 'sortTerms' ], 10, 3 );
		return $terms;
	}
}
