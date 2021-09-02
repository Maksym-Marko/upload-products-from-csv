<?php
/*
Plugin Name: Upload Products from CSV
Plugin URI: https://github.com/
Description: CSV file import.
Author: Marko Maksym
Version: 1.0
Author URI: https://github.com/
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/*
* Unique string - MXUTWFC
*/

/*
* Define MXUTWFC_PLUGIN_PATH
*
* E:\OpenServer\domains\my-domain.com\wp-content\plugins\upload-products-form-csv\upload-products-form-csv.php
*/
if ( ! defined( 'MXUTWFC_PLUGIN_PATH' ) ) {

	define( 'MXUTWFC_PLUGIN_PATH', __FILE__ );

}

/*
* Define MXUTWFC_PLUGIN_URL
*
* Return http://my-domain.com/wp-content/plugins/upload-products-form-csv/
*/
if ( ! defined( 'MXUTWFC_PLUGIN_URL' ) ) {

	define( 'MXUTWFC_PLUGIN_URL', plugins_url( '/', __FILE__ ) );

}

/*
* Define MXUTWFC_PLUGN_BASE_NAME
*
* 	Return upload-products-form-csv/upload-products-form-csv.php
*/
if ( ! defined( 'MXUTWFC_PLUGN_BASE_NAME' ) ) {

	define( 'MXUTWFC_PLUGN_BASE_NAME', plugin_basename( __FILE__ ) );

}

/*
* Define MXUTWFC_TABLE_SLUG
*/
if ( ! defined( 'MXUTWFC_TABLE_SLUG' ) ) {

	define( 'MXUTWFC_TABLE_SLUG', 'mxutwfc_mx_table' );

}

/*
* Define MXUTWFC_PLUGIN_ABS_PATH
* 
* E:\OpenServer\domains\my-domain.com\wp-content\plugins\upload-products-form-csv/
*/
if ( ! defined( 'MXUTWFC_PLUGIN_ABS_PATH' ) ) {

	define( 'MXUTWFC_PLUGIN_ABS_PATH', dirname( MXUTWFC_PLUGIN_PATH ) . '/' );

}

/*
* Define MXUTWFC_PLUGIN_VERSION
*/
if ( ! defined( 'MXUTWFC_PLUGIN_VERSION' ) ) {

	// version
	define( 'MXUTWFC_PLUGIN_VERSION', '1.0' ); // Must be replaced before production on for example '1.0'

}

/*
* Define MXUTWFC_MAIN_MENU_SLUG
*/
if ( ! defined( 'MXUTWFC_MAIN_MENU_SLUG' ) ) {

	// version
	define( 'MXUTWFC_MAIN_MENU_SLUG', 'mxutwfc-upload-products-form-csv-menu' );

}

/**
 * activation|deactivation
 */
require_once plugin_dir_path( __FILE__ ) . 'install.php';

/*
* Registration hooks
*/
// Activation
register_activation_hook( __FILE__, [ 'MXUTWFC_Basis_Plugin_Class', 'activate' ] );

// Deactivation
register_deactivation_hook( __FILE__, [ 'MXUTWFC_Basis_Plugin_Class', 'deactivate' ] );


/*
* Include the main MXUTWFCUploadProductsFormCSV class
*/
if ( ! class_exists( 'MXUTWFCUploadProductsFormCSV' ) ) {

	require_once plugin_dir_path( __FILE__ ) . 'includes/final-class.php';

	/*
	* Translate plugin
	*/
	add_action( 'plugins_loaded', 'mxutwfc_translate' );

	function mxutwfc_translate()
	{

		load_plugin_textdomain( 'mxutwfc-domain', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

	}

}