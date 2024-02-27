<?php

namespace Framework\Tools;

class Stats {
	private $config;
	private $list;
	/* ---
	  Actions
	--- */

	public function configStats( $config ) {
		$this->config = $config;

		add_action( 'init', [ $this, 'createTableInDatabase' ] );

		add_action( 'wp', [ $this, 'updatePageStats' ] );
		add_action( 'template_redirect', [ $this, 'updatePostStats' ] );

		add_action( 'wp_dashboard_setup', [ $this, 'addWidget' ] );
	}

	/* ---
	  Table in database
	--- */

	public function createTableInDatabase() {
		global $wpdb;
		$table = $wpdb->prefix . 'wpf_stats';

		if ( $wpdb->get_var( 'SHOW TABLES LIKE \'' . $table . '\'' ) == $table ) {
			return;
		}

		$charset = $wpdb->get_charset_collate();
		$sql     = 'CREATE TABLE ' . $table . ' (
          date_id bigint UNSIGNED NOT NULL,
          users int UNSIGNED NOT NULL,
          views int UNSIGNED NOT NULL,
          UNIQUE KEY (date_id), PRIMARY KEY (date_id)
        ) ' . $charset . ';';

		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		dbDelta( $sql );
	}

	/* ---
	  Count stats
	--- */

	public function updatePageStats() {
		if ( $this->detectCrawler() || is_admin() || wp_doing_ajax() || is_404() ) {
			return;
		}
		global $wpdb;

		$isUnique = ( defined( 'WPF_UNIQUE_USER' ) || ! isset( $_COOKIE['wpf_stats_visit'] ) );
		$date     = strtotime( date( 'Y-m-d 00:00:00', current_time( 'timestamp' ) ) );
		$expires  = $date + ( DAY_IN_SECONDS - 1 );

		$sql = sprintf(
			'INSERT INTO %s (date_id, views, users) VALUES (%s, 1, 1) ON DUPLICATE KEY UPDATE views = (views + 1) %s',
			$wpdb->prefix . 'wpf_stats',
			$date,
			$isUnique ? ', users = (users + 1)' : ''
		);
		$wpdb->query( $sql );

		if ( ! defined( 'WPF_CACHE_LOADED' ) ) {
			setcookie( 'wpf_stats_visit', 1, $expires, '/' );
		}
	}

	public function updatePostStats() {
		if ( $this->detectCrawler() || ! is_single() && ! is_page() ) {
			return;
		}

		$postId = get_the_ID();
		if ( ! add_post_meta( $postId, 'views_count', 1, true ) ) {
			$views = get_post_meta( $postId, 'views_count', true );
			update_post_meta( $postId, 'views_count', ( $views + 1 ) );
		}
	}

	private function detectCrawler() {
		return ( isset( $_SERVER['HTTP_USER_AGENT'] ) && preg_match( '/bot|crawl|slurp|spider|mediapartners/i', $_SERVER['HTTP_USER_AGENT'] ) );
	}

	/* ---
	  Widget
	--- */

	public function addWidget() {
		if ( ! current_user_can( 'administrator' ) ) {
			return;
		}

		$this->list = $this->getStatsData();
		if ( ! $this->list ) {
			return;
		}

		wp_add_dashboard_widget(
			'wpf_widget_stats',
			__( 'Visit statistics', 'wpf' ),
			[ $this, 'widgetContent' ],
			null
		);

		global $wp_meta_boxes;

		$dashboard = $wp_meta_boxes['dashboard']['normal']['core'];
		$widget    = $dashboard['wpf_widget_stats'];
		unset( $dashboard['wpf_widget_stats'] );
		$dashboard                                    = array_merge( [ 'wpf_widget_stats' => $widget ], $dashboard );
		$wp_meta_boxes['dashboard']['normal']['core'] = $dashboard;
	}

	public function widgetContent() {
		$list   = $this->list;
		$tables = $this->config;

		?>
		<div class="wpfStatsBox">
			<div class="wpfStatsBox__buttons">
				<a href="#" class="button button-primary"><?php echo __( 'Daily', 'wpf' ); ?></a>
				<a href="#" class="button"><?php echo __( 'Monthly', 'wpf' ); ?></a>
				<a href="#" class="button"><?php echo __( 'Yearly', 'wpf' ); ?></a>
			</div>
			<div class="wpfStatsBox__tables">
				<?php
				$index = 0;
				foreach ( $tables as $type => $limit ) :

					$type = str_replace( 'limit_', '', $type );
					if ( ! isset( $list[ $type ] ) ) {
						continue;
					}

					$index++;
					?>
					<div class="wpfStatsBox__table <?php echo ( $index == 1 ) ? 'wpfStatsBox__table--active' : ''; ?>">
						<div class="wpfStatsBox__header">
							<div class="wpfStatsBox__row">
								<div class="wpfStatsBox__cell"><?php echo __( 'Date', 'wpf' ); ?></div>
								<div class="wpfStatsBox__cell"><?php echo __( 'Users', 'wpf' ); ?></div>
								<div class="wpfStatsBox__cell"><?php echo __( 'Views', 'wpf' ); ?></div>
							</div>
						</div>
						<div class="wpfStatsBox__list">
							<?php
							foreach ( $list[ $type ] as $date => $result ) :

								$limit--;
								if ( $limit < 0 ) {
									break;
								}
								?>
								<div class="wpfStatsBox__row">
									<div class="wpfStatsBox__cell"><?php echo $date; ?></div>
									<div
										class="wpfStatsBox__cell"><?php echo number_format( $result['users'], 0, '', ' ' ); ?></div>
									<div
										class="wpfStatsBox__cell"><?php echo number_format( $result['views'], 0, '', ' ' ); ?></div>
								</div>
							<?php endforeach; ?>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
		<?php
	}

	private function getStatsData() {
		global $wpdb;

		$sql     = sprintf(
			'SELECT * FROM %s ORDER BY date_id DESC',
			$wpdb->prefix . 'wpf_stats'
		);
		$results = $wpdb->get_results( $sql, OBJECT );
		$list    = [];

		if ( ! $results ) {
			return $list;
		}
		foreach ( $results as $result ) {
			$year  = date( 'Y', $result->date_id );
			$month = date( 'm', $result->date_id );
			$day   = date( 'd', $result->date_id );

			if ( ! isset( $list['yearly'][ $year ] ) ) {
				$list['yearly'][ $year ] = [
					'users' => 0,
					'views' => 0,
				];
			}

			if ( ! isset( $list['monthly'][ $year . '-' . $month ] ) ) {
				$list['monthly'][ $year . '-' . $month ] = [
					'users' => 0,
					'views' => 0,
				];
			}

			$list['daily'][ $year . '-' . $month . '-' . $day ] = [
				'users' => $result->users,
				'views' => $result->views,
			];

			$list['yearly'][ $year ]['users']                 += $result->users;
			$list['yearly'][ $year ]['views']                 += $result->views;
			$list['monthly'][ $year . '-' . $month ]['users'] += $result->users;
			$list['monthly'][ $year . '-' . $month ]['views'] += $result->views;
		}

		return $list;
	}
}
