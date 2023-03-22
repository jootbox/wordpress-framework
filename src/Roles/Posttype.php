<?php

namespace Framework\Roles;

class Posttype {

	public function __construct() {
		add_filter( 'register_post_type_args', [ $this, 'addCapabilitiesToCustomPostType' ], 10, 2 );
		add_filter( 'register_post_type_args', [ $this, 'addCapabilitiesDefaultTypes' ], 10, 2 );
	}

	/* ---
	  Functions
	--- */

	public function addCapabilitiesToCustomPostType( $args, $postType ) {
		if ( current_user_can( 'administrator' )
			|| ! array_key_exists( $postType, apply_filters( 'wpf_posttype_register', [] ) ) ) {
			return $args;
		}

		$args = array_merge( $args, [
			'map_meta_cap'    => true,
			'capability_type' => $postType,
			'capabilities'    => [
				'create_posts'           => 'create_' . $postType,
				'delete_others_posts'    => 'delete_others_' . $postType,
				'delete_post'            => 'delete_post',
				'delete_posts'           => 'delete_' . $postType,
				'delete_private_posts'   => 'delete_private_' . $postType,
				'delete_published_posts' => 'delete_published_' . $postType,
				'edit_others_posts'      => 'edit_others_' . $postType,
				'edit_post'              => 'edit_post',
				'edit_posts'             => 'edit_' . $postType,
				'edit_private_posts'     => 'edit_private_' . $postType,
				'edit_published_posts'   => 'edit_published_' . $postType,
				'publish_posts'          => 'publish_' . $postType,
				'read'                   => 'read',
				'read_post'              => 'read_post',
				'read_private_posts'     => 'read_private_' . $postType,
			],
		] );
		return $args;
	}

	public function addCapabilitiesDefaultTypes( $args, $postType ) {
		if ( current_user_can( 'administrator' )
			|| ! in_array( $postType, [ 'post', 'page' ] ) ) {
			return $args;
		}

		if ( $postType === 'post' ) {
			$slug = 'posts';
		} elseif ( $postType === 'page' ) {
			$slug = 'pages';
		}
		$args = array_merge( $args, [
			'capabilities' => [
				'create_posts' => 'create_' . $slug,
			],
		] );
		return $args;
	}
}
