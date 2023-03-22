<?php

namespace Framework\Manage;

class Filters {

	private $slug, $filters;

	public function __construct( $slug, $filters ) {
		$this->slug    = $slug;
		$this->filters = $filters;
	}

	/* ---
	  Functions
	--- */

	public function initActions() {
		if ( ! $this->filters ) {
			return;
		}

		add_action( 'restrict_manage_posts', [ $this, 'addFilters' ] );
		add_action( 'pre_get_posts', [ $this, 'filterByOption' ] );
	}

	public function addFilters() {
		global $pagenow;
		if ( ( $pagenow !== 'edit.php' ) || ! isset( $_GET['post_type'] ) || ( $_GET['post_type'] !== $this->slug ) ) {
			return;
		}

		foreach ( $this->filters as $key => $filter ) :
			$selected = $_GET[ 'filter_' . $key ] ?? null;
			$values = $this->parseValuesToTree( $filter['values'] );
			?>
			<select name="filter_<?php echo $key; ?>">
				<option value=""><?php echo $filter['label']; ?></option>
				<?php $this->printFilterLevel( $values, $selected ); ?>
			</select>
		<?php
		endforeach;
	}

	private function parseValuesToTree( $values, $parentId = 0 ) {
		$list = [];
		foreach ( $values as $valueId => $value ) {
			if ( ! is_array( $value ) ) {
				$list[ $valueId ] = $value;
			} else {
				$current = (object) $value;
				if ( $current->parent != $parentId ) {
					continue;
				}
				$list[ $valueId ] = [
					$current,
					$this->parseValuesToTree( $values, $valueId ),
				];
			}
		}
		return $list;
	}

	private function printFilterLevel( $values, $selected, $level = 0 ) {
		foreach ( $values as $value => $data ) : ?>
			<?php if ( ! is_array( $data ) ) : ?>
				<option value="<?php echo $value; ?>" <?php echo ( (string) $value === $selected ) ? 'selected' : ''; ?>>
					<?php echo ( ( $level > 0 ) ? ( str_repeat( '-', $level ) . ' ' ) : '' ) . $data; ?>
				</option>
			<?php else : ?>
				<option value="<?php echo $value; ?>" <?php echo ( (string) $value === $selected ) ? 'selected' : ''; ?>>
					<?php echo ( ( $level > 0 ) ? ( str_repeat( '-', $level ) . ' ' ) : '' ) . $data[0]->name; ?>
				</option>
				<?php $this->printFilterLevel( $data[1], $selected, ( $level + 1 ) ); ?>
			<?php endif; ?>
		<?php endforeach;
	}

	public function filterByOption( $query ) {
		global $pagenow;
		if ( ( $pagenow !== 'edit.php' ) || ! $query->is_main_query()
			|| ! isset( $_GET['post_type'] ) || ( $_GET['post_type'] !== $this->slug ) ) {
			return;
		}

		foreach ( $this->filters as $key => $filter ) {
			$value = $_GET[ 'filter_' . $key ] ?? '';
			if ( $value === '' ) {
				continue;
			}
			$params = [ [], $query->query_vars, $value ];
			$args   = call_user_func_array( $filter['action_query'], $params );
			foreach ( $args as $key => $value ) {
				if ( ( $current = $query->get( $key ) ) && is_array( $current ) && is_array( $value ) ) {
					$value = array_merge_recursive( $current, $value );
				}
				$query->set( $key, $value );
			}
		}
	}
}
