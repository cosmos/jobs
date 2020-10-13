<?php
/**
 * Import Woocommerce.
 *
 * Import Woocommerce plugin file.
 *
 * @package   Smackcoders\SMWC
 * @copyright Copyright (C) 2010-2020, Smackcoders Inc - info@smackcoders.com
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License, version 3 or higher
 *
 * @wordpress-plugin
 * Plugin Name: Import Woocommerce
 * Description: Import your WordPress Post, Page and Simple WooCommerce Product with Import Woocommerce. 
 * Version: 1.5.8
 * Text Domain: import-woocommerce
 * Domain Path: /languages
 * Author: smackcoders
 * Author URI: https://www.smackcoders.com
 * License:     GPL v3
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace Smackcoders\SMWC;

if ( ! defined( 'ABSPATH' ) )
exit; // Exit if accessed directly

require_once('SmackImportCommercePlugin.php');
require_once('SmackInstallImportWoocommerce.php');

require_once('importExtensions/WooCommerceCoreImport.php');

$import_extensions = glob( __DIR__ . '/importExtensions/*.php');
	foreach ($import_extensions as $import_extension_value) {
		require_once($import_extension_value);
	}


class WooComCSVHandler extends ImportHelpers {

	private static $instance = null;
	private static $import_config_instance = null;
	private static $uninstall = null ;
	private static $install = null ;

	public $version = '1.5.8';

	public function __construct(){ 							   
		$this->plugin = Plugin::getInstance();
	}

	public static function getInstance() {
		if (WooComCSVHandler::$instance == null) {
			WooComCSVHandler::$instance = new WooComCSVHandler;
# Custom content after plugin row meta ends
			WooComCSVHandler::$install = WcomInstall::getInstance();
			if ( ! function_exists( 'is_plugin_active' ) ) {
				require_once ABSPATH . 'wp-admin/includes/plugin.php';
			}

			self::init_hooks();
			add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ),  array(WooComCSVHandler::$install, 'plugin_row_meta'), 10, 2 );
			return WooComCSVHandler::$instance;
		}
		return WooComCSVHandler::$instance;
	}

	public static function init_hooks() {
		add_action( 'admin_notices', array(WooComCSVHandler::$instance,'admin_notice_importwcom'));
	}

	public  static function admin_notice_importwcom() {
		global $pagenow;
		$active_plugins = get_option( "active_plugins" );
		if ( $pagenow == 'plugins.php' && !in_array('wp-ultimate-csv-importer/wp-ultimate-csv-importer.php', $active_plugins) ) {
			?>
				<div class="notice notice-warning is-dismissible" >
				<p> Import Woocommerce is an addon of <a href="https://wordpress.org/plugins/wp-ultimate-csv-importer" target="blank" style="cursor: pointer;text-decoration:none">WP Ultimate CSV Importer</a> plugin, kindly install it to continue using import woocommerce. </p>
				<p>
				</div>
				<?php 
		}
	}

	public  function menu_testing_function(){
		?><div id="wp-csv-importer-admin"></div><?php
	}

	/**
	 * Generates unique key for each file.
	 * @param string $value - filename
	 * @return string hashkey
	 */
	public function convert_string2hash_key($value) {
		$file_name = hash_hmac('md5', "$value" . time() , 'secret');
		return $file_name;
	}


	/**
	 * Creates a folder in uploads.
	 * @return string path to that folder
	 */
	public function create_upload_dir(){

		$upload = wp_upload_dir();
		$upload_dir = $upload['basedir'];
		if(!is_dir($upload_dir)){
			return false;
		}else{
			$upload_dir = $upload_dir . '/smack_uci_uploads/imports/';	
			if (!is_dir($upload_dir)) {
				wp_mkdir_p( $upload_dir);
			}
			chmod($upload_dir, 0777);		
			return $upload_dir;
		}
		chmod($upload_dir, 0777);		
		return $upload_dir;
	}
}
add_action( 'plugins_loaded', 'Smackcoders\\SMWC\\onpluginsload' );
function onpluginsload(){
	$plugin = WooComCSVHandler::getInstance();
}
global $uci_woocomm;
$uci_woocomm = new WooComCSVHandler;
?>
