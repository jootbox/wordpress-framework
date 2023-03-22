<?php

namespace Framework\Seo;

class Attachment {

	public function __construct() {
		add_action( 'template_redirect', [ $this, 'attachmentRedirect' ] );
		add_filter( 'wpseo_sitemap_exclude_post_type', [ $this, 'excludeAttachmentFromSitemap' ], 10, 2 );
	}

	/* ---
	  Functions
	--- */

	public function attachmentRedirect() {
		global $post;
		if ( ! is_attachment() ) {
			return;
		}

		if ( isset( $post->post_parent ) && is_numeric( $post->post_parent ) && ( $post->post_parent != 0 ) ) {
			$url = get_permalink( $post->post_parent );
		} else {
			$url = home_url( '/' );
		}

		wp_redirect( $url, 301 );
		exit();
	}

	public function excludeAttachmentFromSitemap( $value, $postType ) {
		return ( $postType === 'attachment' );
	}
}
