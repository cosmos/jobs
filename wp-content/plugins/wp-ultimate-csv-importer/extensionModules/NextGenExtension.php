<?php
/**
 * WP Ultimate CSV Importer plugin file.
 *
 * Copyright (C) 2010-2020, Smackcoders Inc - info@smackcoders.com
 */

namespace Smackcoders\FCSV;

if ( ! defined( 'ABSPATH' ) )
    exit; // Exit if accessed directly

class NextGenExtension extends ExtensionHandler{
	private static $instance = null;
	
    public static function getInstance() {
		
		if (NextGenExtension::$instance == null) {
			NextGenExtension::$instance = new NextGenExtension;
		}
		return NextGenExtension::$instance;
    }

	/**
	* Provides Nextgen Gallery mapping fields for specific post type
	* @param string $data - selected import type
	* @return array - mapping fields
	*/
    public function processExtension($data) {
        $response = [];
        $nextgenFields = array(
			'FILENAME' => 'filename',
			'ALT & TITLE TEXT' => 'alttext',
			'DESCRIPTION' => 'description',
			'GALLERY NAME' => 'nextgen_gallery',
			'IMAGE' => 'image_url'

        );
		$next_gen_value = $this->convert_static_fields_to_array($nextgenFields);
		$response['nextgen_gallery_fields'] = $next_gen_value ;
		return $response;
    }

	/**
	* Nextgen Gallery extension supported import types
	* @param string $import_type - selected import type
	* @return boolean
	*/
    public function extensionSupportedImportType($import_type){
		if(is_plugin_active('nextgen-gallery/nggallery.php')){
			if($import_type == 'nav_menu_item'){
				return false;
			}

			$import_type = $this->import_name_as($import_type);
			if($import_type == 'Posts' || $import_type == 'Pages' || $import_type == 'WooCommerce' || $import_type == 'MarketPress' || $import_type == 'WPeCommerce' || $import_type == 'eShop' || $import_type =='CustomPosts' ) {
				return true;
			}
			else{
				return false;
			}
		}
	}
}