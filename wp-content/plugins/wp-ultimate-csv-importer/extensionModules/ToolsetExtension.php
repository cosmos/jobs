<?php
/**
 * WP Ultimate CSV Importer plugin file.
 *
 * Copyright (C) 2010-2020, Smackcoders Inc - info@smackcoders.com
 */

namespace Smackcoders\FCSV;

if ( ! defined( 'ABSPATH' ) )
    exit; // Exit if accessed directly

class ToolsetExtension extends ExtensionHandler{
	private static $instance = null;

    public static function getInstance() {
		
		if (ToolsetExtension::$instance == null) {
			ToolsetExtension::$instance = new ToolsetExtension;
		}
		return ToolsetExtension::$instance;
    }

	/**
	* Provides Toolset fields for specific post type
	* @param string $data - selected import type
	* @return array - mapping fields
	*/
	public function processExtension($data) {
		global $wpdb;
		$response = [];
		$response['types_fields'] = null;
		return $response;		
			
	}
	
	/**
	* Toolset extension supported import types
	* @param string $import_type - selected import type
	* @return boolean
	*/
	public function extensionSupportedImportType($import_type ){
		if(is_plugin_active('types/wpcf.php')){
			if($import_type == 'nav_menu_item'){
				return false;
			}

			$import_type = $this->import_name_as($import_type);
			if($import_type == 'Posts' || $import_type == 'Pages' || $import_type == 'CustomPosts' || $import_type == 'Users' || $import_type == 'WooCommerce' || $import_type == 'Taxonomies' || $import_type == 'Categories' || $import_type == 'Tags' ) {
				return true;
			}
			else{
				return false;
			}
		}
	}
}