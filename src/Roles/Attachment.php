<?php

namespace Framework\Roles;

class Attachment {

	public function __construct() {
		add_filter( 'register_post_type_args', [ $this, 'addCapabilitiesToAttachment' ], 10, 2 );
	}

	/* ---
	  Functions
	--- */

	public function addCapabilitiesToAttachment( $args, $postType ) {
		if ( current_user_can( 'administrator' ) || ( $postType !== 'attachment' ) ) {
			return $args;
		}

		$args = array_merge( $args, [
			'capability_type' => $postType,
			'capabilities'    => [
				'create_posts'           => 'edit_posts_' . $postType,
				'delete_others_posts'    => 'delete_others_posts_' . $postType,
				'delete_post'            => '',
				'delete_posts'           => 'delete_posts_' . $postType,
				'delete_private_posts'   => '',
				'delete_published_posts' => '',
				'edit_others_posts'      => 'edit_others_posts_' . $postType,
				'edit_post'              => '',
				'edit_posts'             => 'edit_posts_' . $postType,
				'edit_private_posts'     => '',
				'edit_published_posts'   => '',
				'publish_posts'          => '',
				'read'                   => '',
				'read_post'              => '',
				'read_private_posts'     => '',
			],
		] );
		return $args;
	}
}
