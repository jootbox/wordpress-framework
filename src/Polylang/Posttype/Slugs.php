<?php

namespace Framework\Polylang\Posttype;

class Slugs {

	public function __construct() {
		add_filter( 'wp_unique_post_slug', [ $this, 'findUniqueSlug' ], 10, 6 );
		add_filter( 'do_parse_request', [ $this, 'findPostByCurrentLang' ], 10, 3 );
		add_action( 'wp', [ $this, 'removeFindAction' ] );
	}

	/* ---
	  Functions
	--- */

	public function findUniqueSlug( $slug, $postId, $postStatus, $postType, $postParent, $original ) {
		if ( ( $slug === $original ) || in_array( $postType, [ 'attachment' ] )
			|| ( ! $lang = pll_get_post_language( $postId ) )
			|| ( ! $langId = $this->getLanguageId( $lang ) ) ) {
			return $slug;
		}

		global $wpdb;
		$sql = "SELECT post_name FROM $wpdb->posts
          INNER JOIN $wpdb->term_relationships AS lang ON lang.object_id = ID
          WHERE ID != $postId AND post_type = '$postType'
            AND post_name = '%s'
            AND lang.term_taxonomy_id = $langId LIMIT 1";

		$value = $original;
		while ( $wpdb->get_results( sprintf( $sql, $value ) ) ) {
			$value .= '-2';
		}
		return $value;
	}

	private function getLanguageId( $slug ) {
		$langs = get_terms( [
			'taxonomy'   => 'language',
			'slug'       => $slug,
			'hide_empty' => false,
			'fields'     => 'ids',
		] );
		return $langs[0] ?? null;
	}

	public function findPostByCurrentLang( $status, $instance, $queryVars ) {
		if ( ! function_exists( 'PLL' ) ) {
			return $status;
		}

		add_filter( 'query', [ $this, 'replaceSqlRequestForCurrentLang' ] );
		return $status;
	}

	public function replaceSqlRequestForCurrentLang( $sql ) {
		global $wpdb;
		preg_match( "/SELECT\s*{$wpdb->posts}.* FROM {$wpdb->posts}\s*WHERE 1=1\s*AND {$wpdb->posts}.post_name = '(?:.*?)' AND {$wpdb->posts}.post_type = '(.*?)'\s*ORDER BY {$wpdb->posts}.post_date DESC/", $sql, $matches );

		if ( ! $matches || ! pll_is_translated_post_type( $matches[1] ) ) {
			return $sql;
		}
		remove_filter( 'query', [ $this, 'replaceSqlRequestForCurrentLang' ] );

		$join  = PLL()->model->post->join_clause();
		$where = PLL()->model->post->where_clause( pll_current_language() );
		return str_replace( ' WHERE 1=1 ', $join . ' WHERE 1=1 ' . $where, $sql );
	}

	public function removeFindAction() {
		remove_filter( 'query', [ $this, 'replaceSqlRequestForCurrentLang' ] );
	}
}
