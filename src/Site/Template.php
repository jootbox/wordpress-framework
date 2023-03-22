<?php

namespace Framework\Site;

class Template {

	public function __construct() {
		add_filter( 'single_template', [ $this, 'singleTemplate' ], 10, 3 );
		add_filter( 'archive_template', [ $this, 'archiveTemplate' ], 10, 3 );
		add_filter( 'taxonomy_template', [ $this, 'taxonomyTemplate' ], 10, 3 );
		add_filter( 'category_template', [ $this, 'defaultTemplate' ], 10, 3 );
		add_filter( 'tag_template', [ $this, 'defaultTemplate' ], 10, 3 );
	}

	/* ---
	  Functions
	--- */

	public function singleTemplate( $template, $type, $templates ) {
		$filename = basename( $templates[ count( $templates ) - 2 ] ?? '', '.php' );
		$slug     = str_replace( 'single-', '', $filename );

		$path = sprintf(
			'%s/templates/%s/single.php',
			get_template_directory(),
			$slug
		);
		if ( ! file_exists( $path ) ) {
			return $template;
		}
		return $path;
	}

	public function archiveTemplate( $template, $type, $templates ) {
		$filename = basename( $templates[0], '.php' );
		$slug     = str_replace( 'archive-', '', $filename );

		$path = sprintf(
			'%s/templates/%s/archive.php',
			get_template_directory(),
			$slug
		);
		if ( ! file_exists( $path ) ) {
			return $template;
		}
		return $path;
	}

	public function taxonomyTemplate( $template, $type, $templates ) {
		$filename = basename( $templates[1], '.php' );
		$slug     = str_replace( 'taxonomy-', '', $filename );

		$path = sprintf(
			'%s/templates/%s/index.php',
			get_template_directory(),
			$slug
		);
		if ( ! file_exists( $path ) ) {
			return $template;
		}
		return $path;
	}

	public function defaultTemplate( $template, $type, $templates ) {
		$filename = basename( $templates[2], '.php' );
		$slug     = str_replace( 'taxonomy-', '', $filename );

		$path = sprintf(
			'%s/templates/%s/index.php',
			get_template_directory(),
			$slug
		);
		if ( ! file_exists( $path ) ) {
			return $template;
		}
		return $path;
	}
}
