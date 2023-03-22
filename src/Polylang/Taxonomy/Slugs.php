<?php

namespace Framework\Polylang\Taxonomy;

class Slugs {

	private $slug;

	public function __construct() {
		add_filter( 'wp_unique_term_slug', [ $this, 'findUniqueSlug' ], 10, 3 );
	}

	/* ---
	  Functions
	--- */

	public function findUniqueSlug( $slug, $term, $original ) {
		if ( ! $langId = $term->term_lang_choice ?? null ) {
			return $slug;
		}

		global $wpdb;
		$sql = "SELECT terms.slug FROM $wpdb->terms as terms
          INNER JOIN $wpdb->term_relationships AS lang ON lang.object_id = terms.term_id
          INNER JOIN $wpdb->term_taxonomy AS taxonomy ON taxonomy.term_id = terms.term_id
          WHERE slug = '%s'
            AND lang.term_taxonomy_id = $langId
            AND taxonomy.taxonomy = 'shops-category' LIMIT 1";

		$value = sanitize_title( $term->name );
		while ( $wpdb->get_results( sprintf( $sql, $value ) ) ) {
			$value .= '-2';
		}

		add_filter( 'wp_insert_term_duplicate_term_check', [ $this, 'allowDuplicatedTerm' ], 10, 3 );
		$this->slug = $value;
		return $value;
	}

	public function allowDuplicatedTerm( $term, $name, $taxonomy ) {
		if ( ! $term || ( $term->slug !== $this->slug ) ) {
			return $term;
		}
		remove_filter( 'wp_insert_term_duplicate_term_check', [ $this, 'allowDuplicatedTerm' ], 10, 3 );
	}
}
