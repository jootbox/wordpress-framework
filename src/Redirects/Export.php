<?php

namespace Framework\Redirects;

class Export {

	private $optionName = 'wpf_rewrites_list';
	private $filename = 'redirect_list';

	public function __construct() {
		add_action( 'acf/render_field/name=wpf_rewrites_save_as_csv', [ $this, 'renderField' ] );
		add_action( 'wp_ajax_wpf_redirects_export', [ $this, 'saveDataToCsv' ] );
	}

	/* ---
	  Functions
	--- */

	public function renderField( $field ) {
		$url = admin_url( 'admin-ajax.php?action=wpf_redirects_export' );
		?>
		<a href="<?php echo $url; ?>" target="_blank" class="button"><?php echo __( 'Export redirect list', 'wpf' ); ?></a>
		<?php
	}

	public function saveDataToCsv() {
		$paths = get_option( $this->optionName, [] );
		if ( $paths === [] ) {
			_default_wp_die_handler( __( 'An error occurred while exporting.', 'wpf' ) );
		}

		$file = $this->createCsvFile();
		$this->printDataToCsv( $file, $paths );
		exit;
	}

	private function createCsvFile() {
		$this->showHeadersForCsv( $this->filename );

		$file = fopen( 'php://output', 'w' );
		fprintf( $file, chr( 0xEF ) . chr( 0xBB ) . chr( 0xBF ) );
		fwrite( $file, "sep=,\n" );
		return $file;
	}

	private function showHeadersForCsv( $filename ) {
		header( 'Content-Encoding: UTF-8' );
		header( 'Content-Type: application/csv; charset = UTF-8' );
		header( 'Content-Disposition: attachment; filename=' . $filename . '.csv' );
		header( 'Pragma: no-cache' );
		header( 'Expires: 0' );
	}

	private function printDataToCsv( $file, $data ) {
		foreach ( $data as $row ) {
			fputcsv( $file, [
				$row['old'],
				' : ',
				$row['new'],
			] );
		}
	}
}
