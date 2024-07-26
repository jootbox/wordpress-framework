<?php
/**
 * @package   WordPress Framework
 * @author    Jootbox
 * @license   All rights reserved
 * @copyright 2018-2023 Jootbox
 * @link      https://jootbox.eu/
 */

namespace Framework;

class Framework {

	public $acf;
	public $admin;
	public $cache;
	public $duplicator;
	public $forms;
	public $helpers;
	public $integration;
	public $loader;
	public $manage;
	public $options;
	public $polylang;
	public $posttype;
	public $redirects;
	public $roles;
	public $seo;
	public $settings;
	public $share;
	public $site;
	public $sitemap;
	public $taxonomy;
	public $tools;
	public $translate;

	public function __construct() {
		if ( ! $this->frameworkConfig() ) {
			exit();
		}

		$this->acf         = new Acf\_Core();
		$this->admin       = new Admin\_Core();
		$this->cache       = new Cache\_Core();
		$this->duplicator  = new Duplicator\_Core();
		$this->forms       = new Forms\_Core();
		$this->helpers     = new Helpers\_Core();
		$this->integration = new Integration\_Core();
		$this->loader      = new Loader\_Core();
		$this->manage      = new Manage\_Core();
		$this->options     = new Options\_Core();
		if (!defined('WPF_DISABLE_POLYLANG') ||
			(defined('WPF_DISABLE_POLYLANG') && WPF_DISABLE_POLYLANG === false)) {
			$this->polylang    = new Polylang\_Core();
		}
		$this->posttype    = new Posttype\_Core();
		$this->redirects   = new Redirects\_Core();
		$this->roles       = new Roles\_Core();
		$this->seo         = new Seo\_Core();
		$this->settings    = new Settings\_Core();
		$this->share       = new Share\_Core();
		$this->site        = new Site\_Core();
		$this->sitemap     = new Sitemap\_Core();
		$this->taxonomy    = new Taxonomy\_Core();
		$this->tools       = new Tools\_Core();
		$this->translate   = new Translate\_Core();
	}

	private function frameworkConfig() {
		$path = __DIR__ . '/../composer.json';
		if ( ! is_readable( $path ) ) {
			error_log( sprintf(
				'WordPress Framework: `%s` file not found in Framework\\Framework',
				'composer.json'
			) );
			return false;
		}

		$composer = json_decode( file_get_contents( $path ) );
		define( 'WPF_NAME', $composer->name );
		define( 'WPF_VERSION', $composer->version );
		define( 'WPF_PATH', get_template_directory() . '/vendor/' . $composer->name . '/' );
		define( 'WPF_ASSETS_PATH', get_template_directory() . '/vendor/' . $composer->name . '/assets/dist/' );
		define( 'WPF_ASSETS', get_template_directory_uri() . '/vendor/' . $composer->name . '/assets/dist/' );

		return true;
	}
}
