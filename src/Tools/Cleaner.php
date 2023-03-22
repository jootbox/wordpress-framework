<?php

namespace Framework\Tools;

class Cleaner {

	public function __construct() {
		$this->initAutoClear();

		add_action( 'wp_ajax_manual_clear_revisions', [ $this, 'manualRemoveRevisions' ] );
		add_action( 'wp_ajax_manual_clear_autodrafts', [ $this, 'manualRemoveAutodrafts' ] );

		add_action( 'wp_dashboard_setup', [ $this, 'addWidget' ] );
	}

	/* ---
	  Clear database
	--- */

	private function initAutoClear() {
		if ( get_transient( 'wpf_remove_revisions' ) === false ) {
			$this->removeRevisions();
		}

		if ( get_transient( 'wpf_remove_autodrafts' ) === false ) {
			$this->removeAutodrafts();
		}
	}

	public function manualRemoveRevisions() {
		$this->removeRevisions( true );

		?>
		<script>window.close();</script>
		<?php
	}

	private function removeRevisions( $manual = false ) {
		set_transient( 'wpf_remove_revisions', true, HOUR_IN_SECONDS );

		global $wpdb;

		$prefix = $wpdb->prefix;
		$date   = $manual ? '3000-01-01' : date( 'Y-m-d H:i:s', ( current_time( 'timestamp' ) - ( 5 * 24 * 60 * 60 ) ) );
		$sql    = 'DELETE a, b, c FROM ' . $prefix . 'posts a LEFT JOIN ' . $prefix . 'term_relationships b ON (a.ID = b.object_id) LEFT JOIN ' . $prefix . 'postmeta c ON (a.ID = c.post_id) WHERE a.post_type = \'revision\' AND a.post_modified < \'' . $date . '\'';
		$wpdb->query( $sql );
	}

	public function manualRemoveAutodrafts() {
		$this->removeAutodrafts();

		?>
		<script>window.close();</script>
		<?php
	}

	private function removeAutodrafts() {
		set_transient( 'wpf_remove_autodrafts', true, DAY_IN_SECONDS );

		global $wpdb;
		$prefix = $wpdb->prefix;
		$sql    = 'DELETE a, b, c FROM ' . $prefix . 'posts a LEFT JOIN ' . $prefix . 'term_relationships b ON (a.ID = b.object_id) LEFT JOIN ' . $prefix . 'postmeta c ON (a.ID = c.post_id) WHERE a.post_status = \'auto-draft\'';
		$wpdb->query( $sql );
	}

	/* ---
	  Widget
	--- */

	public function addWidget() {
		if ( ! current_user_can( 'administrator' ) ) {
			return;
		}

		wp_add_dashboard_widget(
			'wpf_widget_cleaner',
			__( 'Site management', 'wpf' ),
			[ $this, 'widgetContent' ],
			null
		);

		global $wp_meta_boxes;
		$dashboard = $wp_meta_boxes['dashboard']['normal']['core'];
		$widget    = $dashboard['wpf_widget_cleaner'];
		unset( $dashboard['wpf_widget_cleaner'] );
		$dashboard                                    = array_merge( [ 'wpf_widget_cleaner' => $widget ], $dashboard );
		$wp_meta_boxes['dashboard']['normal']['core'] = $dashboard;
	}

	public function widgetContent() {
		global $wpdb;
		$prefix = $wpdb->prefix;

		$sql         = 'SELECT count(distinct ID) as count FROM ' . $prefix . 'posts WHERE post_status = \'auto-draft\'';
		$result      = $wpdb->get_results( $sql );
		$draftsCount = $result ? $result[0]->count : 0;

		$sql            = 'SELECT count(distinct ID) as count FROM ' . $prefix . 'posts WHERE post_type = \'revision\'';
		$result         = $wpdb->get_results( $sql );
		$revisionsCount = $result ? $result[0]->count : 0;

		?>
		<p>
			<a href="<?php echo admin_url( '/' ) . 'admin-ajax.php?action=manual_clear_autodrafts'; ?>"
				class="button button-primary" target="_blank">
				<?php echo sprintf( __( 'Clear autodrafts (%d)', 'wpf' ), $draftsCount ); ?>
			</a>
		</p>
		<p>
			<a href="<?php echo admin_url( '/' ) . 'admin-ajax.php?action=manual_clear_revisions'; ?>"
				class="button button-primary" target="_blank">
				<?php echo sprintf( __( 'Clear post revisions (%d)', 'wpf' ), $revisionsCount ); ?>
			</a>
		</p>
		<?php
	}
}
