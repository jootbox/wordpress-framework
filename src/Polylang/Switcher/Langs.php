<?php

namespace Framework\Polylang\Switcher;

class Langs {

	private $optionName = 'wpf_polylangs_langs';

	public function __construct() {
		add_filter( 'pll_the_languages_args', [ $this, 'addArgsToHideLangs' ] );
		add_filter( 'pll_the_language_link', [ $this, 'disableTranslationLinkByLang' ], 10, 2 );
		add_action( 'parse_query', [ $this, 'disableAccessToLang' ] );
	}

	/* ---
	  Functions
	--- */

	public function addArgsToHideLangs( $args ) {
		$args['hide_if_no_translation'] = true;
		return $args;
	}

	public function disableTranslationLinkByLang( $url, $lang ) {
		if ( ( ! $langs = get_option( $this->optionName, [] ) )
			|| ! isset( $langs[ $lang ] ) || $langs[ $lang ] ) {
			return $url;
		} else {
			return '';
		}
	}

	public function disableAccessToLang( $query ) {
		if ( ! function_exists( 'pll_current_language' ) || ( ! $langs = get_option( $this->optionName, [] ) )
			|| ( ! $lang = pll_current_language() ) || ! isset( $langs[ $lang ] ) || $langs[ $lang ] ) {
			return;
		}

		$query->set_404();
		status_header( 404 );
		nocache_headers();
		add_filter( 'home_url', [ $this, 'updateHomeUrl' ], 10, 2 );
	}

	public function updateHomeUrl( $url, $path ) {
		return pll_home_url( pll_default_language() );
	}
}
