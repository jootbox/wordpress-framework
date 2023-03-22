<?php

namespace Framework\Options;

use Framework\Acf as GlobalAcf;

class Page {

	public function __construct() {
		add_action( 'after_setup_theme', [ $this, 'loadFields' ], 100 );
		add_action( 'admin_menu', [ $this, 'addLinkToDocs' ], 100 );
	}

	/* ---
	  Functions
	--- */

	public function loadFields() {
		$args = apply_filters( 'wpf_options_page_args', [
			'title'       => __( 'WP Framework', 'wpf' ),
			'slug'        => 'wpf',
			'icon'        => 'dashicons-wordpress',
			'pages'       => [
				'redirects_301' => __( '301 Redirects', 'wpf' ),
				'duplicator'    => __( 'Duplicator', 'wpf' ),
				'integrations'  => __( 'Integrations', 'wpf' ),
				'phpmailer'     => __( 'PHPMailer', 'wpf' ),
				'sitemap'       => __( 'Sitemap', 'wpf' ),
				'seo_share'     => __( 'SEO settings', 'wpf' ),
				'translations'  => __( 'Translations', 'wpf' ),
				'user_roles'    => __( 'User roles', 'wpf' ),
			],
			'notranslate' => [
				'redirects_301',
				'duplicator',
				'integrations',
				'phpmailer',
				'sitemap',
				'user_roles',
			],
		] );
		asort( $args['pages'] );

		$optionspage = new GlobalAcf\Optionspage();
		$optionspage->registerOptionsPage( $args, true );
	}

	public function addLinkToDocs() {
		if ( ! current_user_can( 'edit_posts' ) ) {
			return;
		}
		global $submenu;
		$submenu['wpf-seo-share'][] = [
			__( 'Docs', 'wpf' ),
			'manage_options',
			'https://framework.gbiorczyk.pl',
		];
	}
}
