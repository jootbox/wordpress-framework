<?php

namespace Framework\Translate;

class Lang {

	private $lang;

	public function __construct() {
		add_filter( 'wpf_translate_lang', [ $this, 'getCurrentSiteLang' ] );
	}

	/* ---
	  Functions
	--- */

	public function getCurrentSiteLang() {
		if ( $this->lang ) {
			return $this->lang;
		}
		$locale = ( function_exists( 'pll_current_language' ) && pll_current_language( 'locale' ) ) ? pll_current_language( 'locale' ) : get_locale();
		$locale = explode( '_', $locale );

		$this->lang = $locale[0];
		return $locale[0];
	}
}
