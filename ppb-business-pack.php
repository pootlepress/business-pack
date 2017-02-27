<?php
/*
 * Plugin Name: Pootle Pagebuilder Business Pack Pro
 * Plugin URI: http://pootlepress.com/
 * Description: Add Tabs, Accordions, Testimonials, Incrementing numbers and Google Maps easily in Pootle Pagebuilder Pro.
 * Author: Pootlepress
 * Version: 1.0.0
 * Author URI: http://pootlepress.com/
 * @developer shramee <me@shramee.me>
 */

/** Plugin admin class */
require 'inc/class-admin.php';
/** Plugin public class */
require 'inc/class-public.php';
/** Intantiating main plugin class */
Pootle_Pagebuilder_Business_Pack::instance( __FILE__ );

/**
 * Pootle Pagebuilder Business Pack Pro main class
 * @static string $token Plugin token
 * @static string $file Plugin __FILE__
 * @static string $url Plugin root dir url
 * @static string $path Plugin root dir path
 * @static string $version Plugin version
 */
class Pootle_Pagebuilder_Business_Pack{

	/**
	 * @var 	Pootle_Pagebuilder_Business_Pack Instance
	 * @access  private
	 * @since 	1.0.0
	 */
	private static $_instance = null;

	/**
	 * @var     string Token
	 * @access  public
	 * @since   1.0.0
	 */
	public static $token;

	/**
	 * @var     string Version
	 * @access  public
	 * @since   1.0.0
	 */
	public static $version;

	/**
	 * @var 	string Plugin main __FILE__
	 * @access  public
	 * @since 	1.0.0
	 */
	public static $file;

	/**
	 * @var 	string Plugin directory url
	 * @access  public
	 * @since 	1.0.0
	 */
	public static $url;

	/**
	 * @var 	string Plugin directory path
	 * @access  public
	 * @since 	1.0.0
	 */
	public static $path;

	/**
	 * @var 	Pootle_Pagebuilder_Business_Pack_Admin Instance
	 * @access  public
	 * @since 	1.0.0
	 */
	public $admin;

	/**
	 * @var 	Pootle_Pagebuilder_Business_Pack_Public Instance
	 * @access  public
	 * @since 	1.0.0
	 */
	public $public;

	/**
	 * Main Pootle Pagebuilder Business Pack Pro Instance
	 *
	 * Ensures only one instance of Storefront_Extension_Boilerplate is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 * @return Pootle_Pagebuilder_Business_Pack instance
	 */
	public static function instance( $file ) {
		if ( null == self::$_instance ) {
			self::$_instance = new self( $file );
		}
		return self::$_instance;
	} // End instance()

	/**
	 * Constructor function.
	 * @param string $file __FILE__ of the main plugin
	 * @access  private
	 * @since   1.0.0
	 */
	private function __construct( $file ) {

		self::$token   =   'ppb-business-pack-pro';
		self::$file    =   $file;
		self::$url     =   plugin_dir_url( $file );
		self::$path    =   plugin_dir_path( $file );
		self::$version =   '1.0.0';

		add_action( 'plugins_loaded', array( $this, 'init' ) );
	} // End __construct()

	/**
	 * Initiates the plugin
	 * @action init
	 * @since 1.0.0
	 */
	public function init() {

		if ( class_exists( 'Pootle_Page_Builder' ) ) {

			//Initiate admin
			$this->_admin();

			//Initiate public
			$this->_public();

			//Mark this add on as active
			add_filter( 'pootlepb_installed_add_ons', array( $this, 'add_on_active' ) );

		}
	} // End init()

	/**
	 * Initiates admin class and adds admin hooks
	 * @since 1.0.0
	 */
	private function _admin() {
		//Instantiating admin class
		$this->admin = Pootle_Pagebuilder_Business_Pack_Admin::instance();

		//Content block panel tabs
		add_filter( 'pootlepb_content_block_tabs',		array( $this->admin, 'content_block_tabs' ) );
		add_filter( 'pootlepb_le_content_block_tabs',	array( $this->admin, 'content_block_tabs' ) );
		//Content block panel fields
		add_filter( 'pootlepb_content_block_fields',	array( $this->admin, 'content_block_fields' ) );
		// Modules
		add_filter( 'pootlepb_modules',	array( $this->admin, 'modules' ) );
		// Page builder admin scripts
		add_action( 'pootlepb_enqueue_admin_scripts',	array( $this->admin, 'enqueue' ) );
		// Page builder admin scripts
		add_action( 'pootlepb_content_block_custom_field_' . $this::$token,		array( $this->admin, 'custom_field' ), 10, 2 );
	}

	/**
	 * Initiates public class and adds public hooks
	 * @since 1.0.0
	 */
	private function _public() {
		//Instantiating public class
		$this->public = Pootle_Pagebuilder_Business_Pack_Public::instance();

		//Adding front end JS and CSS in /assets folder
		add_action( 'wp_enqueue_scripts',					array( $this->public, 'enqueue' ) );
		//Add/Modify content block html attributes
		add_filter( 'pootlepb_render_content_block',	array( $this->public, 'content_block' ), 10, 2 );

	} // End enqueue()

	/**
	 * Marks this add on as active on
	 * @param array $active Active add ons
	 * @return array Active add ons
	 * @since 1.0.0
	 */
	public function add_on_active( $active ) {

		// To allows ppb add ons page to fetch name, description etc.
		$active[ self::$token ] = self::$file;

		return $active;
	}
}
