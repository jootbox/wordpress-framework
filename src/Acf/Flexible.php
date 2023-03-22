<?php

namespace Framework\Acf;

class Flexible {

	public function __construct() {
		add_action( 'after_setup_theme', [ $this, 'addFieldsToFlexible' ] );
		add_action( 'acf/render_field/type=flexible_content', [ $this, 'markPopularLayouts' ], 20 );
	}

	/* ---
	  Fields for each layout
	--- */

	public function addFieldsToFlexible() {
		if ( ! function_exists( 'acf_get_local_fields' ) ) {
			return;
		}

		$fields = acf_get_local_fields();
		foreach ( $fields as $field ) {
			if ( ( $field['type'] !== 'flexible_content' ) ||
				( ! $list = apply_filters( 'wpf_acf_flexible_fields', [], $field ) ) ) {
				continue;
			}

			$list = array_reverse( $list );
			add_filter( 'acf/prepare_field/key=' . $field['key'], [ $this, 'reorderFields' ] );

			$index = 0;
			foreach ( $field['layouts'] as $layout ) {
				foreach ( $list as $item ) {
					if ( ! isset( $item['name'] ) || ! $item['name'] ) {
						continue;
					}
					$this->addField( $item, $field['key'], $layout['key'], ++$index );
				}
			}
		}
	}

	private function addField( $data, $keyField, $keyLayout, $index ) {
		$field = array_merge( $data, [
			'wpf_auto_field' => true,
			'key'            => sprintf( 'wpf_field_%s_%s_%s', $keyField, $keyLayout, $data['name'] ),
			'parent'         => $keyField,
			'parent_layout'  => $keyLayout,
		] );
		acf_add_local_field( $field );
	}

	public function reorderFields( $field ) {
		foreach ( $field['layouts'] as $key => $layout ) {
			foreach ( $layout['sub_fields'] as $item ) {
				if ( ! isset( $item['wpf_auto_field'] ) ) {
					continue;
				}
				array_splice( $field['layouts'][ $key ]['sub_fields'], -1 );
				array_unshift( $field['layouts'][ $key ]['sub_fields'], $item );
			}
		}
		return $field;
	}

	/* ---
	  Popular layouts
	--- */

	private function getLayouts( $name ) {
		$list = $this->getLayoutsFromDatabase( $name );
		return $this->filterLayouts( $list );
	}

	private function getLayoutsFromDatabase( $name ) {
		$transient = 'wpf_acf_flexible_layouts_' . $name;
		if ( ( $list = get_transient( $transient ) ) !== false ) {
			return $list;
		}

		global $wpdb;
		$results = $wpdb->get_results( "SELECT m.* FROM {$wpdb->prefix}postmeta as m LEFT JOIN {$wpdb->prefix}posts as p ON p.ID = m.post_id WHERE m.meta_key = '{$name}' AND p.post_status = 'publish'", OBJECT );

		$list = [];
		foreach ( $results as $result ) {
			$sections = unserialize( $result->meta_value );
			if ( ! $sections ) {
				continue;
			}

			foreach ( $sections as $section ) {
				if ( ! isset( $list[ $section ] ) ) {
					$list[ $section ] = 0;
				}
				$list[ $section ]++;
			}
		}

		arsort( $list );
		set_transient( $transient, $list, HOUR_IN_SECONDS );
		return $list;
	}

	private function filterLayouts( $layouts ) {
		$min  = apply_filters( 'wpf_acf_flexible_layouts_min', 10, array_sum( $layouts ) );
		$list = array_filter( $layouts, function ( $value ) use ( $min ) {
			return ( $value >= $min );
		} );

		$list = array_slice( $list, 0, apply_filters( 'wpf_acf_flexible_layouts_top', 7 ) );
		return $list;
	}

	public function markPopularLayouts( $field ) {
		if ( ! $field['layouts'] || ( ! $list = $this->getLayouts( $field['_name'] ) ) ) {
			return;
		}
		$list = array_keys( $list );
		?>
		<style>
			<?php echo '.acf-tooltip [data-layout="' . implode('"], .acf-tooltip [data-layout="', $list) . '"]'; ?>
			{
				background-color: rgba(255, 255, 255, 0.1)
			;
			}
			<?php echo '.acf-tooltip [data-layout="' . implode('"]:before, .acf-tooltip [data-layout="', $list) . '"]:before'; ?>
			{
				float: left
			;
				margin-right: 10px
			;
				content: "\f155"
			;
				font-family: dashicons
			;
				color: #FFB900
			;
			}
		</style>
		<?php
	}
}
