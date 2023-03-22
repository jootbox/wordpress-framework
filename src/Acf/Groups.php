<?php

namespace Framework\Acf;

class Groups {

	public function __construct() {
		add_action( 'admin_init', [ $this, 'changeGroupsNames' ] );
	}

	/* ---
	  Functions
	--- */

	public function changeGroupsNames() {
		if ( ( basename( $_SERVER['PHP_SELF'] ) !== 'edit.php' )
			|| ! isset( $_GET['post_type'] ) || ( $_GET['post_type'] !== 'acf-field-group' ) ) {
			return;
		}

		add_action( 'the_post', [ $this, 'changeGroupTitle' ], 1000, 1 );
		add_filter( 'esc_html', [ $this, 'changeTitle' ], 10, 2 );
	}

	public function changeGroupTitle( $post ) {
		if ( $post->post_type !== 'acf-field-group' ) {
			return $post;
		}

		$options  = unserialize( $post->post_content );
		$location = $options['location'];

		if ( ( count( $location ) !== 1 ) || ( count( $location[0] ) !== 1 ) ) {
			return $post;
		}

		switch ( $location[0][0]['param'] ) {
			case 'options_page':
				$post->post_title = sprintf(
					'%s[Options Page]%s %s',
					'<span style="font-weight: 400; font-size: 12px;">',
					'</span>',
					$post->post_title
				);
				break;
			case 'post_type':
				$post->post_title = sprintf(
					'%s[Post Type]%s %s',
					'<span style="font-weight: 400; font-size: 12px;">',
					'</span>',
					$post->post_title
				);
				break;
		}

		return $post;
	}

	public function changeTitle( $safeText, $text ) {
		if ( ( strpos( $text, '[Options Page]' ) === false )
			&& ( strpos( $text, '[Post Type]' ) === false ) ) {
			return $safeText;
		}
		return $text;
	}
}
