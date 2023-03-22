<?php

namespace Framework\Polylang\Switcher;

class Admin {

	private $optionName = 'wpf_polylangs_langs';

	public function __construct() {
		add_filter( 'pll_languages_row_actions', [ $this, 'addButtonForSwitchAction' ], 10, 2 );
		add_action( 'admin_init', [ $this, 'initSwitchAction' ] );
		add_filter( 'pll_languages_row_classes', [ $this, 'addClassesByLangs' ], 10, 2 );
		add_action( 'admin_print_styles', [ $this, 'printStylesForPolylang' ] );
	}

	/* ---
	  Functions
	--- */

	public function addButtonForSwitchAction( $actions, $lang ) {
		if ( $lang->slug === pll_default_language() ) {
			return $actions;
		}

		$path   = admin_url( 'admin.php?page=mlang&wpf_action=%s&lang=' . $lang->term_id );
		$langs  = get_option( $this->optionName, [] );
		$action = ( isset( $langs[ $lang->slug ] ) && ! $langs[ $lang->slug ] ) ? 'lang_enable' : 'lang_disable';

		$actions[ $action ] = sprintf( '<a href="%s">%s</a>',
			wp_nonce_url( sprintf( $path, $action ), 'lang-' . $action ),
			( isset( $langs[ $lang->slug ] ) && ! $langs[ $lang->slug ] ) ? __( 'Enable', 'wpf' ) : __( 'Disable', 'wpf' )
		);
		return $actions;
	}

	public function initSwitchAction() {
		if ( ! isset( $_REQUEST['wpf_action'] ) || ! in_array( $_REQUEST['wpf_action'], [ 'lang_enable', 'lang_disable' ] )
			|| ( ! $lang = get_term( $_REQUEST['lang'], 'language' ) )
			|| ! wp_verify_nonce( $_REQUEST['_wpnonce'], 'lang-' . $_REQUEST['wpf_action'] ) ) {
			return;
		}

		$langs                = get_option( $this->optionName, [] );
		$langs[ $lang->slug ] = ( $_REQUEST['wpf_action'] === 'lang_enable' );

		if ( get_option( $this->optionName, false ) !== false ) {
			update_option( $this->optionName, $langs );
		} else {
			add_option( $this->optionName, $langs );
		}
		wp_redirect( wp_get_referer() );
	}

	public function addClassesByLangs( $classes, $lang ) {
		if ( ( ! $langs = get_option( $this->optionName, [] ) )
			|| ( ! isset( $langs[ $lang->slug ] ) || $langs[ $lang->slug ] ) ) {
			return $classes;
		}

		$classes[] = 'inactive';
		return $classes;
	}

	public function printStylesForPolylang() {
		?>
		<style>
			#the-list .name {
				padding-left: 20px;
			}

			#the-list .inactive .name {
				padding-left: 16px;
				border-left: 4px solid #dc3232;
			}
		</style>
		<?php
	}
}
