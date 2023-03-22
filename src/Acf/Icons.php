<?php

namespace Framework\Acf;

class Icons {

	private $list;

	/* ---
	  Actions
	--- */

	public function setIconsList( $list ) {
		$this->list = $list;
		add_filter( 'acf/load_field/name=icon', [ $this, 'iconsList' ] );
	}

	/* ---
	  Functions
	--- */

	public function iconsList( $field ) {
		$field['choices'] = [];

		foreach ( $this->list as $icon ) {
			$icon                      = str_replace( 'icon-', '', $icon );
			$field['choices'][ $icon ] = $icon;
		}

		return $field;
	}
}
