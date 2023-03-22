<?php

namespace Framework\Tools;

class Categories {

	private $list;

	/* ---
	  Actions
	--- */

	public function addValidation( $list ) {
		$this->list = $list;
		add_action( 'admin_footer', [ $this, 'showValidatedCategories' ] );
	}

	/* ---
	  Functions
	--- */

	public function showValidatedCategories() {
		if ( ! $this->list ) {
			return;
		}

		$errors = [
			'min' => __( 'Validation failed. The minimum number of selected categories in section %s is %d.', 'wpf' ),
			'max' => __( 'Validation failed. The maximum number of selected categories in section %s is %d.', 'wpf' ),
		];

		?>
		<script>
			if (typeof wpF === 'undefined')
				var wpF = {};

			wpF.categories        = {};
			wpF.categories.list   = <?php echo json_encode( $this->list ); ?>;
			wpF.categories.alerts = <?php echo json_encode( $errors ); ?>;
		</script>
		<?php
	}
}
