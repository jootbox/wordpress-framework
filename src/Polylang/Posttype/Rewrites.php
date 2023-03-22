<?php

namespace Framework\Polylang\Posttype;

class Rewrites {

	public function __construct() {
		add_filter( 'init', [ $this, 'getPostTypes' ] );

		add_filter( 'generate_rewrite_rules', [ $this, 'generateRewriteRules' ], 9, 1 );
		add_filter( 'post_type_link', [ $this, 'postTypeLinkFilter' ], 10, 3 );
		add_filter( 'post_type_archive_link', [ $this, 'postTypeArchiveLinkFilter' ], 10, 2 );
		add_filter( 'pll_translation_url', [ $this, 'translationUrlFilter' ], 10, 2 );
	}

	/* ---
	  Functions
	--- */

	public function getPostTypes() {
		$this->list = apply_filters( 'wpf_posttype_translate', [] );
	}

	/* ---
	  Rewrite rules
	--- */

	public function generateRewriteRules( $rewriteObject ) {
		if ( ! $this->list ) {
			return;
		}

		$list = [];
		foreach ( $this->list as $postType => $data ) {
			foreach ( $data['translations'] as $lang => $slug ) {
				if ( $data['has_archive'] ) {
					$list["${lang}/${slug}/page/([0-9]{1,})/?$"] = "index.php?post_type=${postType}&paged=\$matches[1]";
					$list["${slug}/page/([0-9]{1,})/?$"]         = "index.php?post_type=${postType}&paged=\$matches[1]";
					$list["${lang}/${slug}/?$"]                  = "index.php?post_type=${postType}";
					$list["${slug}/?$"]                          = "index.php?post_type=${postType}";
				}

				$list["${lang}/${slug}(/([^/]+))+/?$"] = "index.php?post_type=${postType}&name=\$matches[1]";
				$list["${slug}(/([^/]+))+/?$"]         = "index.php?post_type=${postType}&name=\$matches[1]";
			}
		}

		$rewriteObject->rules = $list + $rewriteObject->rules;
		return $rewriteObject->rules;
	}

	/* ---
	  Links
	--- */

	public function postTypeLinkFilter( $link, $post, $leavename ) {
		if ( ! $this->list || ! isset( $this->list[ $post->post_type ] )
			|| ! in_array( $post->post_status, [ 'publish', 'future' ] ) ) {
			return $link;
		}

		$lang = pll_get_post_language( $post->ID );
		return $this->replaceSlugInLink( $link, $post->post_type, $lang );
	}

	private function replaceSlugInLink( $link, $postType, $lang ) {
		if ( ! isset( $this->list[ $postType ]['translations'][ $lang ] )
			|| ! $this->list[ $postType ]['translations'][ $lang ] ) {
			return $link;
		}

		$object = get_post_type_object( $postType );
		$slug   = str_replace( '/', '\/', $object->rewrite['slug'] );
		return preg_replace(
			"/\/({$slug})\//",
			"/{$this->list[$postType]['translations'][$lang]}/",
			$link,
			1 );
	}

	public function postTypeArchiveLinkFilter( $link, $postType ) {
		if ( ! $this->list || ! isset( $this->list[ $postType ] ) ) {
			return $link;
		}

		$lang = pll_current_language();
		return $this->replaceSlugInLink( $link, $postType, $lang );
	}

	public function translationUrlFilter( $url, $lang ) {
		if ( ! is_archive() ) {
			return $url;
		}

		global $wp_query;
		$postType = $wp_query->query_vars['post_type'];
		if ( ! isset( $this->list[ $postType ] ) ) {
			return $url;
		}

		return $this->replaceSlugInLink( $url, $postType, $lang );
	}
}
