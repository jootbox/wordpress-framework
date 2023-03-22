<?php

namespace Framework\Acf;

class Location {

	private $filtered;

	public function __construct() {
		add_filter( 'acf/location/rule_types', [ $this, 'addCustomLocationRules' ] );
		add_filter( 'acf/location/rule_values/menu_level', [ $this, 'addValuesForMenu' ] );
		add_filter( 'acf/location/rule_values/options_page', [ $this, 'removeValuesForOptionsPage' ] );
		add_filter( 'acf/location/rule_match/menu_level', [ $this, 'matchValueForMenu' ], 10, 3 );
		add_filter( 'acf/location/rule_match/page_type', [ $this, 'matchValueForFrontPage' ], 0 );
	}

	/* ---
	  Functions
	--- */

	public function addCustomLocationRules( $choices ) {
		$choices['Custom']['menu_level'] = 'Menu depth level';
		return $choices;
	}

	public function addValuesForMenu( $choices ) {
		$list = [];
		for ( $i = 0; $i <= 10; $i++ ) $list[ $i ] = $i;
		return $list;
	}

	public function removeValuesForOptionsPage( $values ) {
		foreach ( $values as $key => $value ) {
			if ( ! in_array( $key, [ 'options', 'wpf' ] ) && ( strpos( $key, 'wpf-' ) === false ) ) {
				continue;
			}
			unset( $values[ $key ] );
		}
		return $values;
	}

	public function matchValueForMenu( $match, $rule, $options ) {
		return ( isset( $options['nav_menu_item_depth'] ) && ( $rule['value'] == $options['nav_menu_item_depth'] ) );
	}

	public function matchValueForFrontPage( $match ) {
		if ( $this->filtered ) {
			return $match;
		}

		add_filter( 'option_page_on_front', [ $this, 'translateFrontPage' ] );
		$this->filtered = true;
		return $match;
	}

	public function translateFrontPage( $value ) {
		if ( function_exists( 'pll_get_post' ) ) {
			$value = pll_get_post( $value );
		}
		return $value;
	}
}
