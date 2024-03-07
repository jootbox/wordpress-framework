<?php

namespace Framework\Duplicator;

class Duplicate {

	public function __construct() {
		add_action( 'admin_action_wpf_duplicate_post', [ $this, 'duplicatePost' ] );
	}

	/* ---
	  Functions
	--- */

	public function duplicatePost() {
		try {
			if ( ! wp_verify_nonce( $_GET['wpf_nonce'], 'duplicator' )
				|| ! isset( $_GET['post_id'] ) || ! $_GET['post_id'] || ! isset( $_GET['wpf_nonce'] ) || ! $_GET['wpf_nonce'] ) {
				throw new \Exception();
			}

			$post = get_post( $_GET['post_id'] );
			if ( ! $post ) {
				throw new \Exception();
			}

			$postId = $this->addNewPost( $post );
			$this->duplicateTaxonomies( $post, $postId );

			if ( ! $this->duplicatePostMeta( $post->ID, $postId ) ) {
				wp_delete_post( $postId, true );
				throw new \Exception();
			}

			$url = admin_url( sprintf( 'post.php?action=edit&post=%s', $postId ) );
			wp_redirect( $url );
		} catch ( \Exception $error ) {
			wp_die( __( 'An unexpected error occurred!', 'wpf' ) );
		}
	}

	private function addNewPost( $post ) {
		$user   = wp_get_current_user();
		$args   = [
			'comment_status' => $post->comment_status,
			'ping_status'    => $post->ping_status,
			'post_author'    => $user->ID,
			'post_content'   => addslashes($post->post_content),
			'post_excerpt'   => $post->post_excerpt,
			'post_name'      => '',
			'post_parent'    => $post->post_parent,
			'post_password'  => $post->post_password,
			'post_status'    => 'draft',
			'post_title'     => $post->post_title,
			'post_type'      => $post->post_type,
			'to_ping'        => $post->to_ping,
			'menu_order'     => $post->menu_order,
		];
		$postId = wp_insert_post( $args );
		return $postId;
	}

	private function duplicateTaxonomies( $post, $newId ) {
		$taxonomies = get_object_taxonomies( $post->post_type );
		if ( ! $taxonomies ) {
			return;
		}

		foreach ( $taxonomies as $taxonomy ) {
			$terms = wp_get_object_terms( $post->ID, $taxonomy, [ 'fields' => 'slugs' ] );
			if ( ! $terms ) {
				continue;
			}
			wp_set_object_terms( $newId, $terms, $taxonomy, false );
		}
	}

	private function duplicatePostMeta( $oldId, $newId ) {
		global $wpdb;

		$items = $wpdb->get_results( sprintf(
			'SELECT meta_key, meta_value FROM %s WHERE post_id = %s',
			$wpdb->postmeta,
			$oldId
		) );
		if ( ! $items ) {
			return;
		}

		$query = sprintf( 'INSERT INTO %s (post_id, meta_key, meta_value) ', $wpdb->postmeta );
		$list  = [];

		foreach ( $items as $item ) {
			$key = $item->meta_key;
			if ( in_array( $key, [ '_wp_old_slug' ] ) ) {
				continue;
			}
			$value  = addslashes( $item->meta_value );
			$list[] = sprintf( 'SELECT %s, \'%s\', \'%s\'', $newId, $key, $value );
		}

		$query .= implode( ' UNION ALL ', $list );
		$wpdb->query( $query );
		return true;
	}
}
