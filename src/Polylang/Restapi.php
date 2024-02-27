<?php

namespace Framework\Polylang;

class Restapi {

	private $mofile;

	public function __construct() {
		$this->initInternationalization();
	}

	/* ---
	  Functions
	--- */

	public function initInternationalization() {
		if ( ! isset( $_REQUEST['lang'] )
			|| ( strpos( trim( $_SERVER['REQUEST_URI'], '/' ), rest_get_url_prefix() ) !== 0 ) ) {
			return;
		}

		add_filter( 'load_textdomain_mofile', [ $this, 'saveMofile' ], 0, 2 );
		add_filter( 'load_textdomain_mofile', [ $this, 'restoreMofile' ], 10, 2 );

		add_filter( 'locale', [ $this, 'getCurrentLocale' ] );
		add_action( 'rest_api_init', [ $this, 'setLocaleForRestApi' ] );

		add_action( 'pre_get_posts', [ $this, 'addLangArgForPosts' ], 0 );
		add_filter( 'get_terms_args', [ $this, 'addLangArgForTerms' ], 0, 2 );
	}

	/* ---
	  MO files
	--- */

	public function saveMofile( $mofile, $domain ) {
		$this->mofile = $mofile;

		return $this->mofile;
	}

	public function restoreMofile( $mofile, $domain ) {
		return $this->mofile;
	}

	/* ---
	  Locale
	--- */

	public function getCurrentLocale( $locale ) {
		$codes   = pll_languages_list( [ 'fields' => 'slug' ] );
		$locales = pll_languages_list( [ 'fields' => 'locale' ] );

		foreach ( $codes as $index => $code ) {
			if ( $code === $_REQUEST['lang'] ) {
				return $locales[ $index ];
			}
		}
		return $locale;
	}

	public function setLocaleForRestApi() {
		$locale = $this->getCurrentLocale( null );
		if ( $locale === null ) {
			return;
		}

		load_default_textdomain( $locale );
		global $wp_locale;
		$wp_locale = new \WP_Locale();
	}

	/* ---
	  get_posts() & get_terms()
	--- */

	public function addLangArgForPosts( $query ) {
		if ( ! isset( $_REQUEST['lang'] ) || isset( $query->query['lang'] ) ) {
			return;
		}
		$query->set( 'lang', $_REQUEST['lang'] );
	}

	public function addLangArgForTerms( $args, $taxonomies ) {
		if ( ! isset( $_REQUEST['lang'] ) || isset( $args['lang'] ) ) {
			return;
		}
		$args['lang'] = $_REQUEST['lang'];
		return $args;
	}
}
