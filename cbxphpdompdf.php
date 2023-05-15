<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://codeboxr.com
 * @since             1.0.0
 * @package           cbxphpdompdf
 *
 * @wordpress-plugin
 * Plugin Name:       CBX PHPDomPDF Library
 * Plugin URI:        https://codeboxr.com/php-dompdf-library-wordpress-plugin/
 * Description:       A pure PHP library for reading and writing pdp files https://github.com/dompdf/dompdf
 * Version:           1.0.0
 * Author:            Codeboxr
 * Author URI:        https://github.com/PHPOffice/PhpDomPDF
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       cbxphpdompdf
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

defined( 'CBXPHPDOMPDF_PLUGIN_NAME' ) or define( 'CBXPHPDOMPDF_PLUGIN_NAME', 'cbxphpdompdf' );
defined( 'CBXPHPDOMPDF_PLUGIN_VERSION' ) or define( 'CBXPHPDOMPDF_PLUGIN_VERSION', '1.0.0' );
defined( 'CBXPHPDOMPDF_BASE_NAME' ) or define( 'CBXPHPDOMPDF_BASE_NAME', plugin_basename( __FILE__ ) );
defined( 'CBXPHPDOMPDF_ROOT_PATH' ) or define( 'CBXPHPDOMPDF_ROOT_PATH', plugin_dir_path( __FILE__ ) );
defined( 'CBXPHPDOMPDF_ROOT_URL' ) or define( 'CBXPHPDOMPDF_ROOT_URL', plugin_dir_url( __FILE__ ) );

	register_activation_hook( __FILE__, array( 'CBXPhpDomPDP', 'activation' ) );

	/**
	 * Class CBXPhpDomPDP
	 */
class CBXPhpDomPDP {
	function __construct() {
		//load text domain
		load_plugin_textdomain('cbxphpdompdf', false, dirname(plugin_basename(__FILE__)) . '/languages/');

		add_filter( 'plugin_row_meta', array($this, 'plugin_row_meta'), 10, 2 );
	}

	/**
	 * Activation hook
	 */
	public static function activation() {
		/*$requirements = array(
			'PHP 7.1.0' => version_compare(PHP_VERSION, '7.1.0', '>='),
			'PHP extension XML' => extension_loaded('xml'),
			'PHP extension xmlwriter' => extension_loaded('xmlwriter'),
			'PHP extension mbstring' => extension_loaded('mbstring'),
			'PHP extension ZipArchive' => extension_loaded('zip'),
			'PHP extension GD (optional)' => extension_loaded('gd'),
			'PHP extension dom (optional)' => extension_loaded('dom'),
		);*/

		if (!CBXPhpDomPDP::php_version_check()) {

			// Deactivate the plugin
			deactivate_plugins(__FILE__);

			// Throw an error in the wordpress admin console
			$error_message = __('This plugin requires PHP version 7.1 or newer', 'cbxphpdompdf');
			die($error_message);
		}

		if (!CBXPhpDomPDP::php_zip_enabled_check()) {

			// Deactivate the plugin
			deactivate_plugins(__FILE__);

			// Throw an error in the wordpress admin console
			$error_message = __('This plugin requires PHP php_zip extension installed and enabled', 'cbxphpdompdf');
			die($error_message);
		}

		if (!CBXPhpDomPDP::php_xml_enabled_check()) {

			// Deactivate the plugin
			deactivate_plugins(__FILE__);

			// Throw an error in the wordpress admin console
			$error_message = __('This plugin requires PHP php_xml extension installed and enabled', 'cbxphpdompdf');
			die($error_message);
		}

		if (!CBXPhpDomPDP::php_gd_enabled_check()) {

			// Deactivate the plugin
			deactivate_plugins(__FILE__);

			// Throw an error in the wordpress admin console
			$error_message = __('This plugin requires PHP php_gd2 extension installed and enabled', 'cbxphpdompdf');
			die($error_message);
		}

		if (!CBXPhpDomPDP::php_mbstring_enabled_check()) {

			// Deactivate the plugin
			deactivate_plugins(__FILE__);

			// Throw an error in the wordpress admin console
			$error_message = __('This plugin requires PHP php_MBString extension installed and enabled', 'cbxphpdompdf');
			die($error_message);
		}

		if (!CBXPhpDomPDP::php_dom_enabled_check()) {

			// Deactivate the plugin
			deactivate_plugins(__FILE__);

			// Throw an error in the wordpress admin console
			$error_message = __('This plugin requires PHP DOM extension installed and enabled', 'cbxphpdompdf');
			die($error_message);
		}

	}//end method activation

	/**
	 * PHP version compatibility check
	 *
	 * @return bool
	 */
	public static function php_version_check(){
		if (version_compare(PHP_VERSION, '7.1.0', '<')) {
			return false;
		}

		return true;
	}//end method php_version_check

	/**
	 * php_zip enabled check
	 *
	 * @return bool
	 */
	public static function php_zip_enabled_check(){
		if (extension_loaded('zip')) {
			return true;
		}
		return false;
	}//end method php_zip_enabled_check

	/**
	 * php_xml enabled check
	 *
	 * @return bool
	 */
	public static function php_xml_enabled_check(){
		if (extension_loaded('xml')) {
			return true;
		}
		return false;
	}//end method php_xml_enabled_check

	/**
	 * php_gd2 enabled check
	 *
	 * @return bool
	 */
	public static function php_gd_enabled_check(){
		if (extension_loaded('gd')) {
			return true;
		}
		return false;
	}//end method php_gd_enabled_check

	/**
	 * php_mbstring enabled check
	 *
	 * @return bool
	 */
	public static function php_mbstring_enabled_check(){
		if (extension_loaded('mbstring')) {
			return true;
		}
		return false;
	}//end method php_mbstring_enabled_check

	/**
	 * php_dom enabled check
	 *
	 * @return bool
	 */
	public static function php_dom_enabled_check(){
		if (extension_loaded('dom')) {
			return true;
		}
		return false;
	}//end method php_dom_enabled_check

	/**
	 * Plugin support and doc page url
	 *
	 * @param $links
	 * @param $file
	 *
	 * @return array
	 */
	public function plugin_row_meta( $links, $file ) {

		if ( strpos( $file, 'cbxphpdompdf.php' ) !== false ) {
			$new_links = array(
				'support' => '<a href="https://codeboxr.com/php-dompdf-library-wordpress-plugin/" target="_blank">'.esc_html__('Support', 'cbxphpdompdf').'</a>',
				'doc'     => '<a href="https://github.com/dompdf/dompdf" target="_blank">'.esc_html__('PHP Dompdf Doc', 'cbxphpdompdf').'</a>'
			);

			$links = array_merge( $links, $new_links );
		}

		return $links;
	}

}//end method CBXPhpDomPDP


function cbxphpdompdf_load_plugin() {
	new CBXPhpDomPDP();
}

add_action( 'plugins_loaded', 'cbxphpdompdf_load_plugin', 5 );