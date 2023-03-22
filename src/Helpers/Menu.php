<?php

namespace Framework\Helpers;

class Menu {

	private $default = [];

	public function __construct() {
		add_filter( 'theme_mod_nav_menu_locations', [ $this, 'getDefaultValues' ], 0 );
		add_filter( 'theme_mod_nav_menu_locations', [ $this, 'loadDefaultValues' ], 77 );

		add_filter( 'wpf_menu', [ $this, 'getMenu' ], 10, 2 );
	}

	/* ---
	  Functions
	--- */

	public function getDefaultValues( $menus ) {
		$this->default = $menus;
		return $menus;
	}

	public function loadDefaultValues( $menus ) {
		foreach ( $menus as $location => $id ) {
			if ( ( $id !== 0 ) || ! isset( $this->default[ $location ] ) ) {
				continue;
			}
			$menus[ $location ] = $this->default[ $location ];
		}
		return $menus;
	}

	public function getMenu( $value, $location ) {
		$locations = get_nav_menu_locations();
		if ( ! isset( $locations[ $location ] ) ) {
			return $value;
		}

		$items = wp_get_nav_menu_items( $locations[ $location ] );
		if ( ! $items ) {
			return $value;
		}

		_wp_menu_item_classes_by_context( $items );

		$items = $this->navTree( $items, $location );
		return $items;
	}

	private function navTree( $items, $location, $parentId = 0 ) {
		$list = [];

		foreach ( $items as $index => $item ) {
			if ( $item->menu_item_parent != $parentId ) {
				continue;
			}
			$list[] = $this->parseItem( $item, $items, $location );
		}

		return $list;
	}

	private function parseItem( $item, $items, $location ) {
		$object   = (object) [
			'ID'        => $item->ID,
			'post_type' => $item->post_type,
		];
		$children = $this->navTree( $items, $location, $item->ID );
		$active   = (
			in_array( 'current-menu-parent', $item->classes )
			|| in_array( 'current-menu-item', $item->classes )
			|| in_array( 'current-page-ancestor', $item->classes )
		);

		if ( ! $active && ( $item->type == 'post_type_archive' ) ) {
			global $post;
			if ( is_object( $post ) && ( $post->post_type == $item->object ) ) {
				$active = true;
			}
		}

		$data = [
			'object'   => $object,
			'url'      => $item->url,
			'title'    => $item->title,
			'target'   => $item->target ? $item->target : '_self',
			'active'   => $active,
			'children' => $children ? $children : [],
		];

		$data = apply_filters( 'wpf_menu_item', $data, $item, $location );
		return $data;
	}
}
