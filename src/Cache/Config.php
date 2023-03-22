<?php

namespace Framework\Cache;

class Config {

	private $config;

	/* ---
	  Actions
	--- */

	public function addConfig( $config ) {
		$this->config = $config;
		add_filter( 'mod_rewrite_rules', [ $this, 'configCache' ] );
	}

	/* ---
	  Functions
	--- */

	public function configCache( $rules ) {
		if ( ( substr( $_SERVER['REMOTE_ADDR'], 0, 4 ) == '127.' ) || ( $_SERVER['REMOTE_ADDR'] == '::1' ) ) {
			return $rules;
		}

		$this->editHtaccess();
		$this->editCacheFile();

		return $rules;
	}

	/* ---
	  .htaccess
	--- */

	private function editHtaccess() {
		if ( isset( $this->config['timeout'] ) && defined( 'WPF_CACHE_TIMEOUT' )
			&& ( $this->config['timeout'] === WPF_CACHE_TIMEOUT ) ) {
			return;
		}

		$path    = ABSPATH . 'wp-config.php';
		$content = ( file_exists( $path ) && is_readable( $path ) && is_writable( $path ) ) ? file_get_contents( $path ) : '';
		if ( ! $content ) {
			return;
		}

		$content = $this->removeExistsConfig( $content );
		$content = $this->saveConfig( $content );

		$file = fopen( $path, 'w' );
		fwrite( $file, $content );
		fclose( $file );
	}

	private function removeExistsConfig( $content ) {
		$content = preg_replace( '/\s{0,}define\(\'WP_CACHE\',\s(.*)\);(.*)/', '', $content );
		$content = preg_replace( '/\s{0,}define\(\'(WPF_){0,}CACHE_TIMEOUT\',\s(.*)\);(.*)/', '', $content );

		return $content;
	}

	private function saveConfig( $content ) {
		if ( ! isset( $this->config['timeout'] ) || ( $this->config['timeout'] < 0 ) ) {
			return $content;
		}

		$content = str_replace(
			'<?php',
			sprintf(
				'<?php%sdefine(\'WP_CACHE\', true); %s%sdefine(\'WPF_CACHE_TIMEOUT\', %s); %s',
				PHP_EOL,
				'// Added by WordPress Framework',
				PHP_EOL,
				$this->config['timeout'],
				'// Added by WordPress Framework'
			),
			$content
		);

		return $content;
	}

	/* ---
	  wp-content/advanced-cache.php
	--- */

	private function editCacheFile() {
		if ( ! isset( $this->config['timeout'] ) || ( $this->config['timeout'] < 0 ) ) {
			$this->removeCacheFile();
			return;
		}

		$path    = ABSPATH . 'wp-content/advanced-cache.php';
		$content = file_get_contents( __DIR__ . '/Code.txt' );
		$content = $this->replaceVariables( $content );

		$file = fopen( $path, 'w' );
		fwrite( $file, $content );
	}

	private function replaceVariables( $content ) {
		$content = str_replace(
			'// %timezone%',
			'date_default_timezone_set(\'' . get_option( 'timezone_string' ) . '\');',
			$content
		);

		$cookie  = apply_filters( 'wpf_cache_logged_cookie', null );
		$content = str_replace(
			'// %logged%',
			$cookie ? sprintf(
				'if (isset($_COOKIE[\'%s\'])) return true;%s',
				$cookie,
				PHP_EOL
			) : '',
			$content
		);
		return $content;
	}

	private function removeCacheFile() {
		$path = ABSPATH . 'wp-content/advanced-cache.php';
		if ( file_exists( $path ) ) {
			unlink( $path );
		}
	}

}
