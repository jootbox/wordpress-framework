<?php

namespace Framework\Polylang\Taxonomy;

class Rewrites {

	private $list;

	public function __construct() {
		add_filter( 'init', [ $this, 'getTaxonomies' ] );

		add_filter( 'generate_rewrite_rules', [ $this, 'generateRewriteRules' ], 8, 1 );
		add_filter( 'term_link', [ $this, 'termLinkFilter' ], 10, 3 );
	}

	/* ---
	  Functions
	--- */

	public function getTaxonomies() {
		$this->list = apply_filters( 'wpf_taxonomy_translate', [] );
	}

	/* ---
	  Rewrite rules
	--- */

	public function generateRewriteRules( $rewriteObject ) {
		if ( ! $this->list ) {
			return;
		}

		$list = [];
		foreach ( $this->list as $taxonomy => $translations ) {
			foreach ( $translations as $lang => $slug ) {
				$list["${lang}/${slug}(/([^/]+))+/page/([0-9]{1,})/?$"] = "index.php?${taxonomy}=\$matches[1]&paged=\$matches[2]";
				$list["${slug}(/([^/]+))+/page/([0-9]{1,})/?$"]         = "index.php?${taxonomy}=\$matches[1]&paged=\$matches[2]";
				$list["${lang}/${slug}(/([^/]+))+/?$"]                  = "index.php?${taxonomy}=\$matches[1]";
				$list["${slug}(/([^/]+))+/?$"]                          = "index.php?${taxonomy}=\$matches[1]";
			}
		}

		$rewriteObject->rules = $list + $rewriteObject->rules;
		return $rewriteObject->rules;
	}

	/* ---
	  Links
	--- */

	public function termLinkFilter( $link, $term, $taxonomy ) {
		if ( ! $this->list || ! isset( $this->list[ $taxonomy ] ) ) {
			return $link;
		}

		$lang = pll_get_term_language( $term->term_id );
		if ( ! isset( $this->list[ $taxonomy ][ $lang ] ) || ! $this->list[ $taxonomy ][ $lang ] ) {
			return $link;
		}

		$object = get_taxonomy( $taxonomy );
		$slug   = str_replace( '/', '\/', $object->rewrite['slug'] );
		return preg_replace(
			"/\/({$slug})\//",
			"/{$this->list[$taxonomy][$lang]}/",
			$link,
			1 );
	}
}
