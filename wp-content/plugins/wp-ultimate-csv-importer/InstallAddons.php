<?php
/**
 * WP Ultimate CSV Importer plugin file.
 *
 * Copyright (C) 2010-2020, Smackcoders Inc - info@smackcoders.com
 */

namespace Smackcoders\FCSV;

if ( ! defined( 'ABSPATH' ) )
exit; // Exit if accessed directly

/**
 * Class InstallAddons
 * @package Smackcoders\FCSV
 */

class InstallAddons {
	
    protected static $instance = null;
    private static $smack_csv_instance = null;

		public function __construct() {
					$this->plugin = Plugin::getInstance();
		}

		public static function getInstance() {
			if ( InstallAddons::$instance == null ) {
							InstallAddons::$instance = new InstallAddons;
							InstallAddons::$smack_csv_instance = SmackCSV::getInstance();
							InstallAddons::$instance->doHooks();
			}
        return InstallAddons::$instance;
    }

    public function doHooks()
		{
			add_action('wp_ajax_install_plugins',array($this,'install'));
    }
    
    public function install(){
			delete_option("WP_ULTIMATE_ADDONS_FAILED");
			
			$all_addons = $_POST['all_addons'];
			$selected_addons = $_POST['addons'];
			$last_iteration = $_POST['last_iteration'];
			self::plugin_install($selected_addons, $last_iteration);
			self::activate_all($all_addons);
			print "Plugin Installed";
			//die('Plugin Installed');  
		}

		public function activate_all($get_all_selected_addons){
			foreach($get_all_selected_addons as $selected_addon){
				if($selected_addon == 'Users'){
					activate_plugin('import-users/import-users.php');
				}
				elseif($selected_addon == 'WooCommerce'){
					activate_plugin('import-woocommerce/import-woocommerce.php');
				}
				elseif($selected_addon == 'Exporter'){
					activate_plugin('wp-ultimate-exporter/wp-ultimate-exporter.php');
				}
			}
			delete_option("WP_ULTIMATE_RECENT_SELECTED_ADDONS");
		}
	/**
	  Code for download and install plugin from org
	 **/

	public function plugin_install($crmtype, $last_iteration){
		update_option("WP_ULTIMATE_SELECTED_ADDON_{$crmtype}", 'checked');

		$get_recent_addons = get_option("WP_ULTIMATE_RECENT_SELECTED_ADDONS");
		if(empty($get_recent_addons)){
			update_option("WP_ULTIMATE_RECENT_SELECTED_ADDONS", $crmtype);
		}else{
			update_option("WP_ULTIMATE_RECENT_SELECTED_ADDONS", $get_recent_addons.','.$crmtype);
		}
	
		switch($crmtype){
			case 'Users':
				$plugin_slug = 'import-users/import-users.php';
				$plugin_zip = 'https://downloads.wordpress.org/plugin/import-users.zip';
				break;

			case 'WooCommerce':
				$plugin_slug = 'import-woocommerce/import-woocommerce.php';
				$plugin_zip = 'https://downloads.wordpress.org/plugin/import-woocommerce.zip';
				break;

			case 'Exporter':
				$plugin_slug = 'wp-ultimate-exporter/wp-ultimate-exporter.php';
				$plugin_zip = 'https://downloads.wordpress.org/plugin/wp-ultimate-exporter.zip';
				break;
		}

		$addons_array = array(
			'import-users/import-users.php' => 'Users',
			'import-woocommerce/import-woocommerce.php' => 'WooCommerce',
			'wp-ultimate-exporter/wp-ultimate-exporter.php' => 'Exporter',
		);

		if($last_iteration == 'yes'){
			$all_addons_array = array('Users', 'WooCommerce', 'Exporter');

			$get_recent_addons = get_option("WP_ULTIMATE_RECENT_SELECTED_ADDONS");
			$get_recent_addons = explode(',', $get_recent_addons);

			foreach($all_addons_array as $each_addon){
				$get_addon_status = get_option("WP_ULTIMATE_SELECTED_ADDON_{$each_addon}");
				if(empty($get_addon_status)){
					update_option("WP_ULTIMATE_SELECTED_ADDON_{$each_addon}", 'unchecked');
				}

				if(!in_array($each_addon, $get_recent_addons)){
					update_option("WP_ULTIMATE_SELECTED_ADDON_{$each_addon}", 'unchecked');
				}
			}
	
			foreach($all_addons_array as $each_addon){
				$get_addon_status = get_option("WP_ULTIMATE_SELECTED_ADDON_{$each_addon}");
				if($get_addon_status == 'unchecked'){
					$unchecked_plugin = array_search($each_addon, $addons_array);
					$active_plugins = get_option('active_plugins');
					if(in_array($unchecked_plugin, $active_plugins)){
						$uncheck_plugins = array($unchecked_plugin);
						delete_plugins($uncheck_plugins);
					}
				}	
			}
		}

		if ( self::is_plugin_installed( $plugin_slug ) ) {
			self::upgrade_plugin( $plugin_slug );
			$installed = true;
			die;
    } 
		else {
				$installed = self::install_plugin( $plugin_zip );
		}
	
		if ( $installed ) {
			$activate = activate_plugin( $plugin_slug );
			if ( is_null($activate) ) {
			 	//
			}
		} else {
			$failed_addons = get_option("WP_ULTIMATE_ADDONS_FAILED");
			if(empty($failed_addons)){
				update_option("WP_ULTIMATE_ADDONS_FAILED", $addons_array[$plugin_slug]);
			}
			else{
				$failed_addon = $failed_addons . ',' . $addons_array[$plugin_slug];
				update_option("WP_ULTIMATE_ADDONS_FAILED", $failed_addon);
			}
		}
		//wp_die();	
	}

	/**
	  Check whether the plugin is already installed
	 **/
	public function is_plugin_installed( $slug ) {
		if ( ! function_exists( 'get_plugins' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}
		$all_plugins = get_plugins();

		if ( !empty( $all_plugins[$slug] ) ) {
			return true;
		} else {
			return false;
		}
	}

	/**
	  Code for Install plugin 
	 **/
	public function install_plugin( $plugin_zip ) {
		include_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
		wp_cache_flush();
		$upgrader = new \Plugin_Upgrader();
		$installed = $upgrader->install( $plugin_zip );
		if ( !is_wp_error( $installed ) ) {
			return true;
		}
	}

	public function upgrade_plugin( $plugin_slug ) {
		include_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
		wp_cache_flush();
		$upgrader = new \Plugin_Upgrader();
		$upgraded = $upgrader->upgrade( $plugin_slug );
		return $upgraded;
	}	
}