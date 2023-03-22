<?php

namespace Framework\Sitemap;

class Rewrite {

	public function __construct() {
		add_action( 'init', [ $this, 'addRewrites' ], 100 );
		add_action( 'admin_init', [ $this, 'initFlushRewrites' ] );
		add_action( 'init', [ $this, 'flushRewrites' ], 999 );
	}

	/* ---
	  Functions
	--- */

	public function addRewrites() {
		global $wp;
		$wp->add_query_var( 'wpf_sitemap_type' );
		$wp->add_query_var( 'wpf_sitemap_slug' );
		$wp->add_query_var( 'wpf_sitemap_page' );

		$posttypes  = get_field( 'wpf_sitemap_posttypes', 'option' );
		$taxonomies = get_field( 'wpf_sitemap_taxonomies', 'option' );

		add_rewrite_rule( 'sitemap\.xml$', 'index.php?wpf_sitemap_type=index', 'top' );
		add_rewrite_rule( 'sitemap-stylesheet\.xsl$', 'index.php?wpf_sitemap_type=stylesheet', 'top' );

		$this->typeRewriteRules( $posttypes, 'posttypes' );
		$this->typeRewriteRules( $taxonomies, 'taxonomies' );
	}

	private function typeRewriteRules( $list, $type ) {
		if ( ! $list ) {
			return;
		}

		foreach ( $list as $slug ) {
			add_rewrite_rule(
				sprintf( 'sitemap-%s-%s-([0-9]{1,})\.xml$', $type, $slug ),
				sprintf( 'index.php?wpf_sitemap_type=%s&wpf_sitemap_slug=%s&wpf_sitemap_page=$matches[1]', $type, $slug ),
				'top'
			);

			add_rewrite_rule(
				sprintf( 'sitemap-%s-%s\.xml$', $type, $slug ),
				sprintf( 'index.php?wpf_sitemap_type=%s&wpf_sitemap_slug=%s', $type, $slug ),
				'top'
			);
		}
	}

	public function initFlushRewrites() {
		if ( ! isset( $_GET['page'] ) || ( $_GET['page'] != 'wpf-sitemap' ) || ! isset( $_GET['message'] )
			|| get_option( 'wpf_sitemap_flush_rewrites' ) ) {
			return;
		}

		add_option( 'wpf_sitemap_flush_rewrites', true );
	}

	public function flushRewrites() {
		if ( ! get_option( 'wpf_sitemap_flush_rewrites' ) ) {
			return;
		}

		add_action( 'shutdown', 'flush_rewrite_rules' );

		if ( $this->sendSitemap() ) {
			delete_option( 'wpf_sitemap_flush_rewrites' );
		}
	}

	private function sendSitemap() {
		if ( ( substr( $_SERVER['REMOTE_ADDR'], 0, 4 ) == '127.' ) || ( $_SERVER['REMOTE_ADDR'] == '::1' ) ) {
			return true;
		}

		$ch = curl_init( sprintf(
			'http://www.google.com/ping?sitemap=%s',
			site_url( '/' ) . 'sitemap.xml'
		) );

		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );

		$content = curl_exec( $ch );
		$status  = curl_getinfo( $ch );
		curl_close( $ch );

		return ( isset( $status['http_code'] ) && ( $status['http_code'] === 200 ) );
	}
}
