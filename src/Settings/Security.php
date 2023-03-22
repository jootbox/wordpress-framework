<?php

namespace Framework\Settings;

class Security {

	private $config;

	/* ---
	  Actions
	--- */

	public function configSecurity( $config ) {
		$this->config = $config;

		$this->htaccessRules();
		$this->secureWordPress();
		$this->accessLog();
	}

	/* ---
	  .htaccess
	--- */

	private function htaccessRules() {
		add_filter( 'mod_rewrite_rules', [ $this, 'disablePHPErrors' ] );
		add_filter( 'mod_rewrite_rules', [ $this, 'disableIndexes' ] );
		add_filter( 'mod_rewrite_rules', [ $this, 'directoryAccess' ] );
		add_filter( 'mod_rewrite_rules', [ $this, 'lockAccessToFiles' ] );
		add_filter( 'mod_rewrite_rules', [ $this, 'repairDatabase' ] );
		add_filter( 'mod_rewrite_rules', [ $this, 'urlHacking' ] );
		add_filter( 'mod_rewrite_rules', [ $this, 'HTTPHeaders' ] );
		add_filter( 'mod_rewrite_rules', [ $this, 'userEnumeration' ] );
	}

	/* ---
	  PHP errors
	--- */

	public function disablePHPErrors( $rules ) {
		$content = PHP_EOL;
		$content .= '# BEGIN Security (PHP errors)' . PHP_EOL;
		$content .= '  <IfModule mod_php5.c>' . PHP_EOL;
		$content .= '    php_value display_startup_errors off' . PHP_EOL;
		$content .= '    php_value display_errors off' . PHP_EOL;
		$content .= '  </IfModule>' . PHP_EOL;
		$content .= '  <IfModule mod_php7.c>' . PHP_EOL;
		$content .= '    php_value display_startup_errors off' . PHP_EOL;
		$content .= '    php_value display_errors off' . PHP_EOL;
		$content .= '  </IfModule>' . PHP_EOL;
		$content .= '# END Security (PHP errors)' . PHP_EOL;
		$content .= PHP_EOL;
		$content = apply_filters( 'wpf_htaccess_security/php_errors', $content );

		return $content . $rules;
	}

	/* ---
	  Directory listing
	--- */

	public function disableIndexes( $rules ) {
		$content = PHP_EOL;
		$content .= '# BEGIN Security (Indexes)' . PHP_EOL;
		$content .= '  Options All -Indexes' . PHP_EOL;
		$content .= '# END Security (Indexes)' . PHP_EOL;
		$content .= PHP_EOL;
		$content = apply_filters( 'wpf_htaccess_security/indexes', $content );

		return $content . $rules;
	}

	/* ---
	  WordPress directories
	--- */

	public function directoryAccess( $rules ) {
		$this->robotsDirectories();

		$content = PHP_EOL;
		$content .= '# BEGIN Security (Directory access)' . PHP_EOL;
		$content .= '  <IfModule mod_rewrite.c>' . PHP_EOL;
		$content .= '    RewriteEngine On' . PHP_EOL;
		$content .= '    RewriteBase /' . PHP_EOL;
		$content .= '    RewriteRule ^wp-admin/includes/ - [L,R=404]' . PHP_EOL;
		$content .= '    RewriteRule !^wp-includes/ - [S=3]' . PHP_EOL;
		$content .= '    RewriteRule ^wp-includes/([^/]+)\.php$ - [L,R=404]' . PHP_EOL;
		$content .= '    RewriteRule ^wp-includes/js/tinymce/langs/.+\.php - [L,R=404]' . PHP_EOL;
		$content .= '    RewriteRule ^wp-includes/theme-compat/ - [L,R=404]' . PHP_EOL;

		if ( $this->config['wpc_path_allow'] ) {
			foreach ( $this->config['wpc_path_allow'] as $path ) {
				$path    = trim( $path, '/' );
				$content .= '    RewriteCond %{REQUEST_URI} !^/' . $path . '?$' . PHP_EOL;
			}
		}

		$content .= '    RewriteRule ^wp-content/([^.]+).php?$ - [L,R=404]' . PHP_EOL;
		$content .= '    RewriteRule ^wp-content/(([^/]+)/)+$ - [L,R=404]' . PHP_EOL;
		$content .= '  </IfModule>' . PHP_EOL;
		$content .= '# END Security (Directory access)' . PHP_EOL;
		$content .= PHP_EOL;
		$content = apply_filters( 'wpf_htaccess_security/access_directories', $content );

		return $content . $rules;
	}

	private function robotsDirectories() {
		$content = 'User-agent: *' . PHP_EOL;
		$content .= 'Disallow: /wp-admin/' . PHP_EOL;
		$content .= 'Allow: /wp-includes/*/*.css' . PHP_EOL;
		$content .= 'Allow: /wp-includes/*/*.js' . PHP_EOL;
		$content .= 'Disallow: /wp-includes/' . PHP_EOL;
		$content .= 'Disallow: /wp-content/cache/' . PHP_EOL;
		$content .= 'Disallow: /wp-content/languages/' . PHP_EOL;
		$content .= 'Allow: /wp-content/plugins/*/*.css' . PHP_EOL;
		$content .= 'Allow: /wp-content/plugins/*/*.js' . PHP_EOL;
		$content .= 'Disallow: /wp-content/plugins/' . PHP_EOL;
		$content .= 'Disallow: /wp-content/upgrade/' . PHP_EOL;
		$content .= 'Allow: /wp-content/themes/*/*.css' . PHP_EOL;
		$content .= 'Allow: /wp-content/themes/*/*.js' . PHP_EOL;
		$content .= 'Allow: /wp-content/themes/*/*.eot' . PHP_EOL;
		$content .= 'Allow: /wp-content/themes/*/*.svg' . PHP_EOL;
		$content .= 'Allow: /wp-content/themes/*/*.ttf' . PHP_EOL;
		$content .= 'Allow: /wp-content/themes/*/*.woff' . PHP_EOL;
		$content .= 'Allow: /wp-content/themes/*/*.woff2' . PHP_EOL;
		$content .= 'Allow: /wp-content/themes/*/*.gif' . PHP_EOL;
		$content .= 'Allow: /wp-content/themes/*/*.jpg' . PHP_EOL;
		$content .= 'Allow: /wp-content/themes/*/*.jpeg' . PHP_EOL;
		$content .= 'Allow: /wp-content/themes/*/*.png' . PHP_EOL;
		$content .= 'Disallow: /wp-content/themes/' . PHP_EOL;
		$content .= 'Disallow: *?replytocom' . PHP_EOL;
		$content .= 'Disallow: /archives/' . PHP_EOL;
		$content .= 'Disallow: /comments/feed/' . PHP_EOL;
		$content = apply_filters( 'wpf_htaccess_security/robots_txt', $content );

		$file = fopen( ABSPATH . '/robots.txt', 'w+' );
		fwrite( $file, $content );
	}

	/* ---
	  Safe files
	--- */

	public function lockAccessToFiles( $rules ) {
		$content = PHP_EOL;
		$content .= '# BEGIN Security (Files)' . PHP_EOL;
		$content .= '  <FilesMatch "^(?i).*\.(htaccess|htpasswd|ini|phps|fla|log|sh|bak|git|svn|sql|tar|tar\.gz)$">' . PHP_EOL;
		$content .= '    order allow,deny' . PHP_EOL;
		$content .= '    deny from all' . PHP_EOL;
		$content .= '  </FilesMatch>' . PHP_EOL;
		$content .= '  <FilesMatch "^(?i)(wp-config\.php|xmlrpc\.php|install\.php)$">' . PHP_EOL;
		$content .= '    order allow,deny' . PHP_EOL;
		$content .= '    deny from all' . PHP_EOL;
		$content .= '  </FilesMatch>' . PHP_EOL;
		$content .= '  <FilesMatch "^(?i)(error_log|changelog\.txt|license\.(html|txt|commercial\.txt)|readme\.(html|md|txt))$">' . PHP_EOL;
		$content .= '    order allow,deny' . PHP_EOL;
		$content .= '    deny from all' . PHP_EOL;
		$content .= '  </FilesMatch>' . PHP_EOL;
		$content .= '# END Security (Files)' . PHP_EOL;
		$content .= PHP_EOL;
		$content = apply_filters( 'wpf_htaccess_security/access_files', $content );

		return $content . $rules;
	}

	/* ---
	  Repair database
	--- */

	public function repairDatabase( $rules ) {
		$content = PHP_EOL;
		$content .= '# BEGIN Security (Repair database)' . PHP_EOL;
		$content .= '  <IfModule mod_rewrite.c>' . PHP_EOL;
		$content .= '    RewriteEngine On' . PHP_EOL;
		$content .= '    RewriteBase /' . PHP_EOL;
		$content .= '    RewriteRule ^wp-admin/maint/repair.php?$ - [L,R=404]' . PHP_EOL;
		$content .= '  </IfModule>' . PHP_EOL;
		$content .= '# END Security (Repair database)' . PHP_EOL;
		$content .= PHP_EOL;
		$content = apply_filters( 'wpf_htaccess_security/maint_repair', $content );

		return $content . $rules;
	}

	/* ---
	  URL Hacking
	--- */

	public function urlHacking( $rules ) {
		$content = PHP_EOL;
		$content .= '# BEGIN Security (URL Hacking)' . PHP_EOL;
		$content .= '  <IfModule mod_rewrite.c>' . PHP_EOL;
		$content .= '    RewriteEngine On' . PHP_EOL;
		$content .= '    RewriteCond %{REQUEST_METHOD} ^(TRACE|TRACK) [NC]' . PHP_EOL;
		$content .= '    RewriteRule ^(.*)$ - [F,L]' . PHP_EOL;
		$content .= '  </IfModule>' . PHP_EOL;
		$content .= '# END Security (URL Hacking)' . PHP_EOL;
		$content .= PHP_EOL;
		$content = apply_filters( 'wpf_htaccess_security/url_hacking', $content );

		return $content . $rules;
	}

	/* ---
	  Clickjacking, XSS, MIME types
	--- */

	public function HTTPHeaders( $rules ) {
		$content = PHP_EOL;
		$content .= '# BEGIN Security (HTTP headers)' . PHP_EOL;
		$content .= '  <ifModule mod_headers.c>' . PHP_EOL;
		$content .= '    Header set X-XSS-Protection "1; mode=block"' . PHP_EOL;
		$content .= '    Header set X-Frame-Options "sameorigin"' . PHP_EOL;
		$content .= '    Header set X-Content-Type-Options "nosniff"' . PHP_EOL;
		$content .= '  </IfModule>' . PHP_EOL;
		$content .= '# END Security (HTTP headers)' . PHP_EOL;
		$content .= PHP_EOL;
		$content = apply_filters( 'wpf_htaccess_security/http_headers', $content );

		return $content . $rules;
	}

	/* ---
	  User enumeration
	--- */

	public function userEnumeration( $rules ) {
		$content = PHP_EOL;
		$content .= '# BEGIN Security (User enumeration)' . PHP_EOL;
		$content .= '  <IfModule mod_rewrite.c>' . PHP_EOL;
		$content .= '    RewriteEngine On' . PHP_EOL;
		$content .= '    RewriteCond %{REQUEST_URI} ^/$' . PHP_EOL;
		$content .= '    RewriteCond %{QUERY_STRING} ^/?author=\d' . PHP_EOL;
		$content .= '    RewriteRule ^ - [L,R=404]' . PHP_EOL;
		$content .= '  </IfModule>' . PHP_EOL;
		$content .= '# END Security (User enumeration)' . PHP_EOL;
		$content .= PHP_EOL;
		$content = apply_filters( 'wpf_htaccess_security/user_enumeration', $content );

		return $content . $rules;
	}

	/* ---
	  Secure WordPress
	--- */

	private function secureWordPress() {
		$this->PHPErrors();
		$this->autoUpdateWordpress();
		$this->WPVersion();
		$this->WPHeaders();
		$this->hideLoginPage();
		$this->loginErrors();
		$this->limitLoginAttempts();
		$this->xmlRpc();
		$this->fileEdit();
		$this->loadScriptsAndStyles();
		$this->sqlInjectionForAttachment();
		$this->disableAccessToUsersInRestApi();
		$this->searchReferer();
		$this->searchString();
		$this->commentReferer();
		$this->trackback();
		$this->targetBlank();
	}

	/* ---
	  PHP errors
	--- */

	private function PHPErrors() {
		if ( defined( 'WP_DEBUG' ) && ( WP_DEBUG === true ) ) {
			return;
		}

		error_reporting( 0 );
		@ini_set( 'display_errors', 0 );
	}

	/* ---
	  Auto-update core
	--- */

	private function autoUpdateWordpress() {
		add_filter( 'auto_update_core', '__return_true' );
	}

	/* ---
	  WP version
	--- */

	private function WPVersion() {
		add_filter( 'script_loader_src', [ $this, 'removeWPVersion' ] );
		add_filter( 'style_loader_src', [ $this, 'removeWPVersion' ] );
		add_filter( 'the_generator', '__return_empty_string' );
	}

	public function removeWPVersion( $src ) {
		global $wp_version;
		parse_str( parse_url( $src, PHP_URL_QUERY ), $query );

		if ( ! empty( $query['ver'] ) && $query['ver'] === $wp_version ) {
			$src = remove_query_arg( 'ver', $src );
		}

		return $src;
	}

	/* ---
	  Headers
	--- */

	private function WPHeaders() {
		/* REST API */
		remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
		remove_action( 'wp_head', 'wp_oembed_add_discovery_links', 10 );

		/* XML-RPC */
		remove_action( 'wp_head', 'rsd_link' );

		/* RSS feed */
		remove_action( 'wp_head', 'feed_links', 2 );
		remove_action( 'wp_head', 'feed_links_extra', 3 );

		/* Windows Live Writer */
		remove_action( 'wp_head', 'wlwmanifest_link' );

		/* Link do index page */
		remove_action( 'wp_head', 'index_rel_link' );

		/* Post Relational Links */
		remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
		remove_action( 'wp_head', 'index_rel_link', 10, 0 );
		remove_action( 'wp_head', 'adjacent_posts_rel_link', 10, 0 );
		remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );

		/* Shortlink */
		remove_action( 'wp_head', 'wp_shortlink_wp_head' );

		/* Emojicons */
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
	}

	/* ---
	  Hide login page
	--- */

	private function hideLoginPage() {
		if ( $this->config['login_url'] === null ) {
			return;
		}

		add_filter( 'mod_rewrite_rules', [ $this, 'newLoginUrlRewrite' ], 1000 );
		if ( ! $this->checkNewLoginUrlRewriteExists() ) {
			return;
		}

		add_action( 'init', [ $this, 'disableDefaultPages' ] );
		add_action( 'init', [ $this, 'redirectToAdminPanel' ] );
		add_filter( 'site_url', [ $this, 'replaceLoginUrl' ], 10, 1 );
		add_filter( 'admin_url', [ $this, 'replaceAdminUrl' ], 10, 1 );
		add_filter( 'network_admin_url', [ $this, 'replaceAdminUrl' ], 10, 1 );
	}

	public function newLoginUrlRewrite( $rules ) {
		$loginUrl = trim( $this->config['login_url'], '/' );

		$content = PHP_EOL;
		$content .= '# BEGIN Security (Login page)' . PHP_EOL;
		$content .= '  <IfModule mod_rewrite.c>' . PHP_EOL;
		$content .= '    RewriteEngine on' . PHP_EOL;
		$content .= '    RewriteRule ^' . $loginUrl . ' /wp-login.php [QSA,L]' . PHP_EOL;
		$content .= '  </IfModule>' . PHP_EOL;
		$content .= '# END Security (Login page)' . PHP_EOL;
		$content .= PHP_EOL;

		return $content . $rules;
	}

	public function checkNewLoginUrlRewriteExists() {
		$path    = ABSPATH . '/.htaccess';
		$content = file_exists( $path ) ? file_get_contents( $path ) : '';

		$loginUrl = trim( $this->config['login_url'], '/' );
		return ( strpos( $content, 'RewriteRule ^' . $loginUrl ) !== false );
	}

	public function disableDefaultPages() {
		$isAdmin = ( is_admin() && ! is_user_logged_in() && ! defined( 'DOING_AJAX' ) );
		$isLogin = $this->checkIfLoginPage();

		if ( $isAdmin || $isLogin ) {
			wp_die( __( 'This page is locked.', 'lang' ), 404 );
		}
	}

	private function checkIfLoginPage() {
		$current = trim( parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH ), '/' );
		$paths   = apply_filters( 'wpf_security_login_paths', [ '/login', '/wp-login.php' ] );
		foreach ( $paths as $path ) {
			if ( $current === trim( $path, '/' ) ) {
				return true;
			}
		}
		return false;
	}

	public function redirectToAdminPanel() {
		if ( ! is_user_logged_in() || ! isset( $_SERVER['SCRIPT_FILENAME'] )
			|| ( strpos( $_SERVER['SCRIPT_FILENAME'], 'wp-login.php' ) === false ) ) {
			return;
		}

		if ( isset( $_GET['redirect_to'] ) ) {
			wp_redirect( $_GET['redirect_to'] );
		} else {
			wp_redirect( admin_url() );
		}
	}

	public function replaceLoginUrl( $url ) {
		$loginUrl = trim( $this->config['login_url'], '/' ) . '/';
		$url      = str_replace( 'wp-login.php', $loginUrl, $url );
		return $url;
	}

	public function replaceAdminUrl( $url ) {
		if ( ! preg_match( '/(adminhash=|network_admin_hash=|newuseremail=)/', $url )
			&& ! apply_filters( 'wpf_security_login_redirect', false, $url ) ) {
			return $url;
		}
		return wp_login_url( $url );
	}

	/* ---
	  Limit login attempts
	--- */

	private function limitLoginAttempts() {
		add_action( 'wp_login_failed', [ $this, 'detectFailedLogin' ] );
		add_action( 'init', [ $this, 'protectBruteForce' ] );
	}

	public function detectFailedLogin() {
		$key   = 'failed_login_' . base64_encode( $_SERVER['REMOTE_ADDR'] );
		$value = get_transient( $key );
		$value = ( $value && is_numeric( $value ) ) ? ( $value + 1 ) : 1;

		delete_transient( $key );
		set_transient( $key, $value, ( 15 * MINUTE_IN_SECONDS ) );
	}

	public function protectBruteForce() {
		if ( ! isset( $_SERVER['SCRIPT_FILENAME'] )
			|| ( strpos( $_SERVER['SCRIPT_FILENAME'], 'wp-login.php' ) === false ) ) {
			return;
		}

		$key   = 'failed_login_' . base64_encode( $_SERVER['REMOTE_ADDR'] );
		$value = get_transient( $key );

		if ( ! $value || ( $value < 5 ) ) {
			return;
		}
		$message = function_exists( 'get_field' ) ? get_field( 'wpf_translations_login_page', 'option' ) : '';
		wp_die( $message ? $message : __( 'This page is locked.', 'wpf' ), 404 );
	}

	/* ---
	  Login errors
	--- */

	private function loginErrors() {
		add_filter( 'login_errors', function ( $error ) {
			global $errors;
			if ( ( $errors === null ) || ! method_exists( $errors, 'get_error_codes' ) ) {
				return $error;
			}

			$errCodes = $errors->get_error_codes();
			if ( ( count( $errCodes ) !== 1 )
				|| ! in_array( $errCodes[0], [ 'invalid_username', 'incorrect_password', 'invalid_email' ] ) ) {
				return $error;
			} else {
				$message = function_exists( 'get_field' ) ? get_field( 'wpf_translations_login_message', 'option' ) : '';
				return sprintf(
					$message ? $message : __( '%sERROR%s: An error occured. Try again.', 'wpf' ),
					'<strong>',
					'</strong>'
				);
			}
		} );
	}

	/* ---
	  XML-RPC
	--- */

	private function xmlRpc() {
		add_filter( 'xmlrpc_enabled', '__return_false' );
		add_filter( 'pre_update_option_enable_xmlrpc', '__return_false' );
		add_filter( 'pre_option_enable_xmlrpc', '__return_zero' );
		add_filter( 'xmlrpc_methods', '__return_empty_array', PHP_INT_MAX );
	}

	/* ---
	  File edit
	--- */

	private function fileEdit() {
		if ( defined( 'DISALLOW_FILE_EDIT' ) ) {
			return;
		}
		define( 'DISALLOW_FILE_EDIT', true );
	}

	/* ---
	  Load concatenate JS & CSS files
	--- */

	private function loadScriptsAndStyles() {
		add_filter( 'mod_rewrite_rules', [ $this, 'lockLoadScriptsAndStylesFiles' ] );

		if ( ! is_user_logged_in() ) {
			define( 'CONCATENATE_SCRIPTS', false );
		}
	}

	public function lockLoadScriptsAndStylesFiles( $rules ) {
		$content = PHP_EOL;
		$content .= '# BEGIN Security (load JS & CSS)' . PHP_EOL;
		$content .= '  <IfModule mod_rewrite.c>' . PHP_EOL;
		$content .= '    RewriteEngine on' . PHP_EOL;
		$content .= '    RewriteCond %{REQUEST_FILENAME} ^.*wp-admin/load-scripts.php$ [OR]' . PHP_EOL;
		$content .= '    RewriteCond %{REQUEST_FILENAME} ^.*wp-admin/load-styles.php$' . PHP_EOL;
		$content .= '    RewriteCond %{HTTP_COOKIE} !^.*wordpress_logged_in.*$ [NC]' . PHP_EOL;
		$content .= '    RewriteRule ^ - [L,R=404]' . PHP_EOL;
		$content .= '  </IfModule>' . PHP_EOL;
		$content .= '# END Security (load JS & CSS)' . PHP_EOL;
		$content .= PHP_EOL;
		$content = apply_filters( 'wpf_htaccess_security/load_scripts_styles', $content );

		return $content . $rules;
	}

	/* ---
	  SQL Injection for attachment
	--- */

	private function sqlInjectionForAttachment() {
		add_action( 'pre_get_posts', function ( $query ) {
			if ( is_admin() || ! $query->is_main_query() || ! $query->query_vars['attachment'] ) {
				return;
			}

			$value = stripslashes( $query->query_vars['attachment'] );
			$query->set( 'attachment', $value );
		} );
	}

	/* ---
	  /wp-json/wp/v2/users/
	--- */

	private function disableAccessToUsersInRestApi() {
		add_filter( 'rest_authentication_errors', function ( $status ) {
			if ( ! preg_match( '/wp\/v2\/users/', $_SERVER['REQUEST_URI'] )
				|| is_user_logged_in() ) {
				return $status;
			}

			return new \WP_Error(
				'rest_not_logged_in',
				__( 'You are not currently logged in.' ),
				[ 'status' => 403 ]
			);
		} );
	}

	/* ---
	  Search verify
	--- */

	private function searchReferer() {
		add_action( 'parse_query', [ $this, 'verifySearchReferer' ] );
	}

	public function verifySearchReferer() {
		if ( ! is_search() || ! isset( $_SERVER['HTTP_REFERER'] ) || ! $_SERVER['HTTP_REFERER'] ) {
			return;
		}

		if ( parse_url( $_SERVER['HTTP_REFERER'], PHP_URL_HOST ) != parse_url( home_url( '/' ), PHP_URL_HOST ) ) {
			die();
		}
	}

	/* ---
	  Search string
	--- */

	private function searchString() {
		if ( ! isset( $_GET['s'] ) || ! $_GET['s'] ) {
			return;
		}

		$_GET['s'] = htmlspecialchars( $_GET['s'], ENT_NOQUOTES );
	}

	/* ---
	  Comment verify
	--- */

	private function commentReferer() {
		add_filter( 'comment_form', [ $this, 'commentTemplate' ] );
		add_filter( 'pre_comment_on_post', [ $this, 'checkCommentReferer' ] );
	}

	public function commentTemplate() {
		?>
		<input type="hidden" name="comment_referer" value="1">
		<?php
	}

	public function checkCommentReferer() {
		if ( ! isset( $_POST['comment_referer'] ) ) {
			die();
		}
	}

	/* ---
	  Disable trackbacks
	--- */

	private function trackback() {
		add_action( 'wp', function () {
			if ( is_trackback() ) {
				die();
			}
		} );
	}

	/* ---
	  a[target="_blank"]
	--- */

	private function targetBlank() {
		add_action( 'wp_footer', function () {
			?>
			<script>
				(function () {
					var links = document.querySelectorAll('a[target="_blank"]');
					var count = links.length;
					for (var i = 0; i < count; i++) {
						links[i].setAttribute('rel', 'noopener noreferrer');
					}
				}());
			</script>
			<?php
		}, 1000 );
	}

	/* ---
	  Access log
	--- */

	private function accessLog() {
		$this->removeOlderLogs();

		add_action( 'template_redirect', [ $this, 'addAccessLog' ] );
		add_action( 'shutdown', [ $this, 'addAccessLog' ] );
	}

	private function removeOlderLogs() {
		if ( get_transient( 'wpf_remove_logs' ) !== false ) {
			return;
		}

		set_transient( 'wpf_remove_logs', true, DAY_IN_SECONDS );
		$path = ABSPATH . 'wp-content/logs/';

		if ( ! file_exists( $path ) ) {
			return;
		}

		$expires = time() - ( 3 * MONTH_IN_SECONDS );
		$path    .= '*-{users,visitors}.log';
		$files   = glob( $path, GLOB_BRACE );

		if ( ! $files ) {
			return;
		}

		foreach ( $files as $file ) {
			if ( filemtime( $file ) < $expires ) {
				unlink( $file );
			}
		}
	}

	public function addAccessLog() {
		remove_action( 'template_redirect', [ $this, 'addAccessLog' ] );
		remove_action( 'shutdown', [ $this, 'addAccessLog' ] );

		if ( ( defined( 'REST_REQUEST' ) && REST_REQUEST )
			|| ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
			return;
		}

		$path = urldecode( $_SERVER['REQUEST_URI'] );
		$file = basename( parse_url( $path, PHP_URL_PATH ) );
		$code = http_response_code();

		if ( in_array( $file, [ 'admin-ajax.php', 'wp-cron.php' ] )
			|| in_array( $code, [ 301, 302 ] ) ) {
			return;
		}

		$user = is_user_logged_in() ? wp_get_current_user() : false;
		$data = [
			'ip'       => str_pad( $_SERVER['REMOTE_ADDR'], 15, ' ', STR_PAD_RIGHT ),
			'date'     => $this->getCurrentTime(),
			'username' => $user ? $user->user_login : '',
			'method'   => $_SERVER['REQUEST_METHOD'],
			'path'     => $path,
			'port'     => $_SERVER['SERVER_PORT'],
			'code'     => $code,
			'agent'    => isset( $_SERVER['HTTP_USER_AGENT'] ) ? $_SERVER['HTTP_USER_AGENT'] : '',
			'referer'  => isset( $_SERVER['HTTP_REFERER'] ) ? urldecode( $_SERVER['HTTP_REFERER'] ) : '',
		];

		$log = sprintf(
			'%s - [%s]%s "%s %s :%s" %s - %s%s' . PHP_EOL,
			$data['ip'],
			$data['date']['time'],
			$data['username'] ? ( ' {' . $data['username'] . '}' ) : '',
			$data['method'],
			$data['path'],
			$data['port'],
			$data['code'],
			$data['agent'],
			( $data['referer'] && ( strpos( $data['referer'], site_url( '/' ) ) === false ) ) ? ( ' [' . $data['referer'] . ']' ) : ''
		);

		$path = $this->createDirectory();
		$path .= $data['date']['file'] . '-' . ( $user ? 'users' : 'visitors' ) . '.log';
		$file = fopen( $path, 'a' );
		fwrite( $file, $log );
		fclose( $file );
	}

	private function getCurrentTime() {
		$data = [
			'file' => date( 'Ymd', current_time( 'timestamp', 1 ) ),
			'time' => date( 'd-M-Y H:i:s e', current_time( 'timestamp', 1 ) ),
		];

		return $data;
	}

	private function createDirectory() {
		$path = ABSPATH . 'wp-content/logs/';

		if ( ! file_exists( $path ) ) {
			mkdir( $path, 0775, true );
			chmod( $path, 0775 );
		}

		return $path;
	}
}
