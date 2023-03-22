<?php

namespace Framework\Manage;

class Columns {

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

		add_filter( 'manage_edit-' . $this->slug . '_columns', [ $this, 'addColumns' ], 100 );
		add_action( 'manage_' . $this->slug . '_posts_custom_column', [ $this, 'printColumnValueForPosttype' ], 10, 2 );
		add_action( 'manage_' . $this->slug . '_custom_column', [ $this, 'printColumnValueForTaxonomy' ], 10, 3 );
	}

	public function addColumns( $columns ) {
		if ( isset( $columns['description'] ) ) {
			unset( $columns['description'] );
		}
		$newColumns = array_merge(
			array_slice( $columns, 0, 2 ),
			array_combine( array_keys( $this->columns ), array_column( $this->columns, 'label' ) ),
			array_slice( $columns, 2 )
		);
		return $this->reorderColumns( $newColumns );
	}

	private function reorderColumns( $columns ) {
		$keys = apply_filters( 'wpf_manage-' . $this->slug . '_columns_order', array_keys( $columns ) );
		$list = [];
		foreach ( $keys as $key ) {
			if ( ! isset( $columns[ $key ] ) ) {
				continue;
			}
			$list[ $key ] = $columns[ $key ];
		}
		return $list;
	}

	public function printColumnValueForPosttype( $column, $postId ) {
		if ( ! isset( $this->columns[ $column ] ) ) {
			return;
		} else {
			echo call_user_func_array( $this->columns[ $column ]['action_value'], [ $postId ] );
		}
	}

	public function printColumnValueForTaxonomy( $content, $column, $termId ) {
		if ( ! isset( $this->columns[ $column ] ) ) {
			return;
		} else {
			return call_user_func_array( $this->columns[ $column ]['action_value'], [ $termId ] );
		}
	}
}
