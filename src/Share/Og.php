<?php

namespace Framework\Share;

class Og {

	private $data;

	public function __construct() {
		add_action( 'wp_head', [ $this, 'savePageSettings' ], 0 );
	}

	/* ---
	  Functions
	--- */

	public function savePageSettings() {
		if ( ! $data = $this->getPageSettings() ) {
			return;
		}

		$this->data = $data;
		add_filter( 'pre_get_document_title', [ $this, 'replacePageTitle' ] );
		add_action( 'wp_head', [ $this, 'showTags' ] );
	}

	public function replacePageTitle( $title ) {
		if ( ! isset( $this->data['is_meta_title'] ) || ! $this->data['is_meta_title']
			|| ! isset( $this->data['title'] ) || ! $this->data['title'] ) {
			return $title;
		}
		return $this->data['title'];
	}

	public function showTags() {
		?>
		<?php if ( isset( $this->data['title'] ) ) : ?>
			<meta property="og:title" content="<?php echo $this->data['title']; ?>"/>
		<?php endif; ?>
		<?php if ( isset( $this->data['desc_search'] ) ) : ?>
			<meta name="description" content="<?php echo $this->data['desc_search']; ?>"/>
		<?php endif; ?>
		<?php if ( isset( $this->data['desc'] ) ) : ?>
			<meta property="og:description" content="<?php echo $this->data['desc']; ?>"/>
		<?php endif; ?>
		<?php if ( isset( $this->data['image'] ) ) : ?>
			<meta property="og:image" content="<?php echo $this->data['image']['url']; ?>"/>
			<meta property="og:image:width" content="<?php echo $this->data['image']['width']; ?>"/>
			<meta property="og:image:height" content="<?php echo $this->data['image']['height']; ?>"/>
		<?php endif; ?>

		<?php if ( isset( $this->data['image'] ) ) : ?>
			<meta property="twitter:card" content="summary_large_image"/>
		<?php elseif ( isset( $this->data['desc'] ) ) : ?>
			<meta property="twitter:card" content="summary"/>
		<?php endif; ?>
		<?php
	}

	private function getPageSettings() {
		if ( ! function_exists( 'get_field' ) || ! get_field( 'wpf_seo_share_active', 'option' ) ) {
			return;
		}

		$global = $this->getGlobalSettings();
		if ( is_singular() ) {
			$global = isset( $global['image'] ) ? [ 'image' => $global['image'] ] : [];
		}

		if ( ! $current = get_field( 'wpf_seo_share', get_queried_object() ) ) {
			return $global;
		}
		return array_merge( $global, apply_filters( 'wpf_share_parse_data', $current ) );
	}

	private function getGlobalSettings() {
		global $wp_query;
		if ( ! isset( $wp_query->queried_object ) ) {
			return [];
		}

		$settings = get_option( 'wpf_og_settings', [] );
		$object   = $wp_query->queried_object;
		if ( ! is_object( $object ) ) {
			return [];
		}

		switch ( get_class( $object ) ) {
			case 'WP_Term':
				$key = 'taxonomy-' . $object->taxonomy;
				break;
			case 'WP_Post_Type':
				$key = 'posttype-' . $object->query_var;
				break;
			case 'WP_Post':
				$key = 'posttype-' . $object->post_type;
				break;
		}

		$data = $settings[ $key ] ?? [];
		if ( $data ) {
			return array_merge( $settings['default'], $data );
		} else {
			return $settings['default'] ?? [];
		}
	}
}
