<?php
/**
 * Plugin Name: Recspec Events
 * Version: 1.0
 * Description: Creates a custom post type which allows a user to events with pagination and shortcode support.
 * Plugin URI: https://recspec.co/
 * Author: Recspec
 * Text Domain: recspec-events
 */

if ( ! defined( 'ABSPATH' ) || ! class_exists( 'RecspecEvents' ) ) return;

class RecspecEvents {

	private static $instance = null;

	public function __construct() {

		add_action( 'init', array( $this, 'initialize' ), 0, 0 );

	}

	public static function instance() {
		self::$instance ?? self::$instance;

		return self::$instance = new RecspecEvents();
	}

	public function initialize() {

		// Bail early if called directly from functions.php or plugin file.
		if ( ! did_action( 'plugins_loaded' ) ) return;

		require_once plugin_dir_path( __FILE__ ) . 'admin/register-cpt.php';
		require_once plugin_dir_path( __FILE__ ) . 'admin/acf-fields.php';
		require_once plugin_dir_path( __FILE__ ) . 'admin/admin-editor.php';
		require_once plugin_dir_path( __FILE__ ) . 'frontend/enqueue.php';
		require_once plugin_dir_path( __FILE__ ) . 'frontend/shortcode.php';

	}


} // End RecspecEvents class

RecspecEvents::instance();
