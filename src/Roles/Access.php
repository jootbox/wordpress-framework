<?php

namespace Framework\Roles;

class Access {

	public function __construct() {
		add_filter( 'user_has_cap', [ $this, 'addAccessToSpecificPosts' ], 10, 3 );
		add_action( 'pre_get_posts', [ $this, 'excludePostsList' ] );
	}

	/* ---
	  Functions
	--- */

	public function addAccessToSpecificPosts( $allcaps, $caps, $args ) {
		if ( array_key_exists( 'administrator', $allcaps )
			|| ( ! $postId = $args[2] ?? 0 ) || ( ! $postType = get_post_type( $postId ) )
			|| ! array_key_exists( sprintf( 'access_%s_%s', $postType, $postId ), $allcaps ) ) {
			return $allcaps;
		}

		foreach ( $caps as $cap ) {
			if ( strpos( $cap, 'delete_' ) === 0 ) {
				continue;
			}
			$allcaps[ $cap ] = true;
		}
		return $allcaps;
	}

	public function excludePostsList( $query ) {
		if ( ! is_admin() || ! $query->is_main_query() || ( ! $postType = $query->query['post_type'] )
			|| current_user_can( 'administrator' ) || ( ! $user = wp_get_current_user() ) ) {
			return;
		}

		$prefix  = sprintf( 'access_%s_', $postType );
		$matches = preg_grep( '/' . $prefix . '[0-9]+/', array_keys( $user->allcaps ) );
		if ( ! $matches ) {
			return;
		}

		$postIds = array_map( function ( $value ) use ( $prefix ) {
			return str_replace( $prefix, '', $value );
		}, $matches );
		$query->set( 'post__in', $postIds );
	}
}
