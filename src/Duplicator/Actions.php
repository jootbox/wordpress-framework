<?php

namespace Framework\Duplicator;

class Actions {

	private $formsPostType = 'wpf-contact-forms', $postTypes = [];

	public function __construct() {
		add_filter( 'post_row_actions', [ $this, 'addRowActions' ], 77, 2 );
		add_filter( 'page_row_actions', [ $this, 'addRowActions' ], 77, 2 );
		add_action( 'post_submitbox_start', [ $this, 'addDuplicateButton' ] );
	}

	/* ---
	  Functions
	--- */

	public function addRowActions( $actions, $post ) {
		if ( ! $this->detectPermissions( $post->post_type ) ) {
			return $actions;
		}

		$actions['duplicate'] = sprintf(
			'<a href="%s">%s</a>',
			$this->getDuplicateLink( $post->ID ),
			__( 'Duplicate', 'wpf' )
		);
		return $actions;
	}

	private function detectPermissions( $postType ) {
		if ( ! function_exists( 'get_field' ) ) {
			return;
		}

		$list = get_field( 'wpf_duplicator_post_types', 'option' );
		if ( $list === null ) {
			$list = [ $this->formsPostType ];
		}

		return ( in_array( $postType, $list )
			&& ( current_user_can( 'administrator' ) || current_user_can( 'create_' . $postType ) ) );
	}

	private function getDuplicateLink( $postId ) {
		$url = wp_nonce_url( 'admin.php?action=wpf_duplicate_post&post_id=' . $postId, 'duplicator', 'wpf_nonce' );
		return $url;
	}

	public function addDuplicateButton() {
		$post = isset( $_GET['post'] ) ? get_post( $_GET['post'] ) : null;
		if ( ! $post || ! $this->detectPermissions( $post->post_type ) ) {
			return;
		}

		?>
		<div id="wpf-duplicator">
			<a href="<?php echo $this->getDuplicateLink( $post->ID ); ?>">
				<?php echo __( 'Duplicate as new draft', 'wpf' ); ?>
			</a>
		</div>
		<?php
	}
}
