<?php

namespace Framework\Sitemap;

class Output {

	public function __construct() {
		add_action( 'pre_get_posts', [ $this, 'showSitemap' ] );
	}

	/* ---
	  Functions
	--- */

	public function showSitemap( $query ) {
		$type = get_query_var( 'wpf_sitemap_type' );
		$slug = get_query_var( 'wpf_sitemap_slug' );
		$page = max( intval( get_query_var( 'wpf_sitemap_page' ) ), 1 ) - 1;

		if ( ! $query->is_main_query() || ! $type || ( $type == 'stylesheet' ) ) {
			return;
		}

		if ( ! headers_sent() ) {
			header( 'HTTP/1.1 200 OK', true, 200 );
			header( 'X-Robots-Tag: noindex, follow', true );
			header( 'Content-Type: text/xml; charset=UTF-8' );
		}

		switch ( $type ) {
			case 'index':
				$content = $this->printLinks();
				break;
			case 'posttypes':
				$content = $this->printPosts( $slug, $page );
				break;
			case 'taxonomies':
				$content = $this->printTerms( $slug, $page );
				break;
		}

		echo $content;
		die();
	}

	private function printLinks() {
		$posttypes  = get_field( 'wpf_sitemap_posttypes', 'option' );
		$taxonomies = get_field( 'wpf_sitemap_taxonomies', 'option' );

		$content = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
		$content .= '<?xml-stylesheet type="text/xsl" href="' . site_url( '/' ) . 'sitemap-stylesheet.xsl"?>' . PHP_EOL;
		$content .= '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL;

		$content .= $this->printMaps( $posttypes, 'posttypes' );
		$content .= $this->printMaps( $taxonomies, 'taxonomies' );

		$content .= '</sitemapindex>';
		return $content;
	}

	private function printMaps( $list, $type ) {
		$content = '';
		if ( ! $list ) {
			return $content;
		}

		foreach ( $list as $slug ) {
			if ( $type == 'posttypes' ) {
				$count = wp_count_posts( $slug );
				$pages = $count ? ceil( ( $count->publish / 250 ) ) : 0;
			} else {
				$count = wp_count_terms( $slug );
				$pages = $count ? ceil( ( $count / 250 ) ) : 0;
			}

			for ( $i = 1; $i <= $pages; $i++ ) {
				$content .= '  <sitemap>' . PHP_EOL;
				$content .= sprintf(
					'    <loc>%ssitemap-%s-%s%s.xml</loc>' . PHP_EOL,
					site_url( '/' ),
					$type,
					$slug,
					( $i > 1 ) ? ( '-' . str_pad( $i, 2, '0', STR_PAD_LEFT ) ) : ''
				);
				$content .= '  </sitemap>' . PHP_EOL;
			}
		}

		return $content;
	}

	private function getActiveLanguages() {
		if ( function_exists( 'pll_languages_list' ) ) {
			return pll_languages_list( [
				'fields' => 'slug',
			] );
		}

		return [];
	}

	private function printPosts( $slug, $page ) {
		$content = '';
		$items   = get_posts( [
			'post_type'      => $slug,
			'posts_per_page' => 250,
			'offset'         => ( $page * 250 ),
			'lang'           => $this->getActiveLanguages(),
			'orderby'        => 'date',
			'order'          => 'DESC',
			'fields'         => 'ids',
		] );

		$content .= '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
		$content .= '<?xml-stylesheet type="text/xsl" href="' . site_url( '/' ) . 'sitemap-stylesheet.xsl"?>' . PHP_EOL;
		$content .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL;

		foreach ( $items as $postId ) {
			$content .= '  <url>' . PHP_EOL;
			$content .= '  <loc>' . get_permalink( $postId ) . '</loc>' . PHP_EOL;
			$content .= '  <lastmod>' . get_post_modified_time( 'c', false, $postId ) . '</lastmod>' . PHP_EOL;
			$content .= '  </url>' . PHP_EOL;
		}

		$content .= '</urlset>';
		return $content;
	}

	private function printTerms( $slug, $page ) {
		$content = '';
		$items   = get_terms( [
			'taxonomy' => $slug,
			'number'   => 250,
			'offset'   => ( $page * 250 ),
			'lang' => $this->getActiveLanguages(),
			'orderby'  => 'id',
			'order'    => 'DESC',
		] );

		$content .= '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
		$content .= '<?xml-stylesheet type="text/xsl" href="' . site_url( '/' ) . 'sitemap-stylesheet.xsl"?>' . PHP_EOL;
		$content .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL;

		foreach ( $items as $item ) {
			$content .= '  <url>' . PHP_EOL;
			$content .= '  <loc>' . get_term_link( $item ) . '</loc>' . PHP_EOL;
			$content .= '  <lastmod>' . $this->getTermsModifiedDate( $item ) . '</lastmod>' . PHP_EOL;
			$content .= '  </url>' . PHP_EOL;
		}

		$content .= '</urlset>';
		return $content;
	}

	private function getTermsModifiedDate( $term ) {
		$args = [
			'posts_per_page' => 1,
			'post_type'      => 'any',
			'lang' => $this->getActiveLanguages(),
			'orderby'        => 'modified',
			'order'          => 'DESC',
		];

		if ( $term->taxonomy != 'category' ) {
			$args['tax_query'] = [
				[
					'taxonomy' => $term->taxonomy,
					'field'    => 'slug',
					'terms'    => [ $term->slug ],
					'operator' => 'IN',
				],
			];
		} else {
			$args['cat'] = $term->term_id;
		}

		$post = get_posts( $args );
		$date = $post ? $post[0]->post_modified : date( 'Y-m-d' );
		$date = date( 'c', strtotime( $date ) );

		return $date;
	}
}
