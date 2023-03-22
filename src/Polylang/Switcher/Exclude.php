<?php

namespace Framework\Polylang\Switcher;

class Exclude {

	private $optionName = 'wpf_polylangs_langs';

	public function __construct() {
		add_filter( 'parse_query', [ $this, 'excludeLangForPosts' ], 1 );
		add_filter( 'get_terms_args', [ $this, 'excludeLangForTerms' ], 1, 2 );
	}

	/* ---
	  Functions
	--- */

	public function excludeLangForPosts( $query ) {
		if ( ! isset( $query->query_vars['lang'] ) || ! function_exists( 'pll_languages_list' )
			|| ( ! $config = get_option( 'polylang', [] ) )
			|| ( ! $translated = array_merge( $config['post_types'] ?? [], [ 'post', 'page' ] ) )
			|| ! in_array( $query->get( 'post_type' ), $translated ) ) {
			return $query;
		}

		$value = $this->getAvailableLangsList( $query->query_vars['lang'] );
		$query->set( 'lang', $value );
	}

	public function excludeLangForTerms( $args, $taxonomies ) {
		if ( ! isset( $args['lang'] ) || ! function_exists( 'pll_languages_list' )
			|| ( ! $config = get_option( 'polylang', [] ) )
			|| ( ! $translated = array_merge( $config['taxonomies'] ?? [], [ 'category', 'post_tag' ] ) )
			|| ( array_diff( $taxonomies, $translated ) !== [] ) ) {
			return $args;
		}

		$args['lang'] = $this->getAvailableLangsList( $args['lang'] );
		return $args;
	}

	private function getAvailableLangsList( $current ) {
		if ( ! $current ) {
			$value = pll_languages_list();
		} else {
			if ( is_array( $current ) ) {
				$value = array_filter( $current );
			} else {
				$value = array_filter( explode( ',', str_replace( ' ', '', $current ) ) );
			}
		}

		$config = get_option( $this->optionName, [] );
		$langs  = array_filter( pll_languages_list(), function ( $lang ) use ( $config ) {
			return ( ! isset( $config[ $lang ] ) || $config[ $lang ] );
		} );
		$value  = array_filter( $value, function ( $lang ) use ( $langs ) {
			return ( in_array( $lang, $langs ) );
		} );

		return $value ?: [ [] ];
	}
}
