<?php

namespace Framework\Redirects;

class Cache {

	private $optionName = 'wpf_rewrites_list';

	public function __construct() {
		add_action( 'acf/save_post', [ $this, 'updateRedirectsList' ], 0 );
	}

	/* ---
	  Functions
	--- */

	public function updateRedirectsList( $postId ) {
		if ( ( strpos( $postId, 'options' ) === false )
			|| ! isset( $_GET['page'] ) || ( $_GET['page'] !== 'wpf-redirects_301' ) ) {
			return;
		}

		$list = $this->getPaths();
		$this->saveRedirectsList( $list );

		$_POST['acf'] = [];
		flush_rewrite_rules( true );
	}

	private function getPaths() {
		$form = apply_filters( 'wpf_acf_form_values', [] );
		$list = [];
		$list = (array) $form['wpf_rewrites_list'] ?? [];
		$list = array_merge( $list, $this->getOverwriteList( $form ) );
		$list = array_filter( $list );
		if ( isset( $form['wpf_rewrites_is_clear'] ) && $form['wpf_rewrites_is_clear'] ) {
			$list = [];
		}

		return $list;
	}

	private function getOverwriteList( $form ) {
		$paths = $this->getPathsFromTextarea( $form );
		$list  = [];

		foreach ( $paths as $key => $path ) {
			$parts  = explode( ' : ', $path );
			$list[] = [
				'old' => $parts[0],
				'new' => $parts[1],
			];
		}
		return $list;
	}

	private function getPathsFromTextarea( $form ) {
		if ( ! isset( $form['wpf_rewrites_paths'] ) ) {
			return [];
		}

		$domain = isset( $form['wpf_rewrites_paths_domain'] ) ? $form['wpf_rewrites_paths_domain'] : '';
		$paths  = explode( PHP_EOL, trim( $form['wpf_rewrites_paths'] ) );
		$paths  = array_filter( $paths );

		foreach ( $paths as $key => $path ) {
			$parts = $this->getPartsFromLine( $path, $domain );
			if ( ! $parts || in_array( $parts[0], [ '', '/' ] ) ) {
				unset( $paths[ $key ] );
			} else {
				$paths[ $key ] = implode( ' : ', $parts );
			}
		}

		natsort( $paths );
		return $paths;
	}

	private function getPartsFromLine( $line, $domain ) {
		$line  = preg_replace( '/\s+/', ' ', $line );
		$line  = str_replace( $domain, '', $line );
		$parts = explode( ' : ', $line );
		$parts = [
			trim( $parts[0] ?? '/' ),
			trim( $parts[1] ?? '/' ),
		];

		if ( trim( $parts[0], '/' ) === trim( $parts[1], '/' ) ) {
			return false;
		} else {
			return $parts;
		}
	}

	private function saveRedirectsList( $value ) {
		if ( get_option( $this->optionName ) !== false ) {
			update_option( $this->optionName, $value );
		} else {
			add_option( $this->optionName, $value, '', 'no' );
		}
	}
}
