<?php
/**
 * Import Users plugin file.
 *
 * Copyright (C) 2010-2020, Smackcoders Inc - info@smackcoders.com
 */

namespace Smackcoders\SMUSERS;

if ( ! defined( 'ABSPATH' ) )
exit; // Exit if accessed directly

class BSIImport extends UsersImport {
	private static $bsi_instance = null;

	public static function getInstance() {
		if (BSIImport::$bsi_instance == null) {
			BSIImport::$bsi_instance = new BSIImport;
			global $bsi_instance;
			return BSIImport::$bsi_instance;
		}
		return BSIImport::$bsi_instance;
	}
	public function set_bsi_values($header_array ,$value_array , $map, $post_id , $type){
		$post_values = [];
		$helpers_instance = ImportHelpers::getInstance();	
		$post_values = $helpers_instance->get_header_values($map , $header_array , $value_array);

		$this->bsi_import_function($post_values, $post_id);    
	}

	public function bsi_import_function($data_array, $uID){
		foreach( $data_array as $daKey => $daVal ) {
			if(strpos($daKey, 'msi_') === 0) {
				$msi_custom_key = substr($daKey, 4);
				$msi_shipping_array[$msi_custom_key] = $daVal;
			} elseif(strpos($daKey, 'mbi_') === 0) {
				$mbi_custom_key = substr($daKey, 4);
				$mbi_billing_array[$mbi_custom_key] = $daVal;
			} else {
				update_user_meta($uID, $daKey, $daVal);
			}
		}
		//Import MarketPress Shipping Info
		if (!empty ($msi_shipping_array)) {
			$custom_key = 'mp_shipping_info';
			update_user_meta($uID, $custom_key, $msi_shipping_array);
		}
		//Import MarketPress Billing Info
		if (!empty ($mbi_billing_array)) {
			$custom_key = 'mp_billing_info';
			update_user_meta($uID, $custom_key, $mbi_billing_array);
		}
	}
}
global $billing_class;
$billing_class = new BSIImport();
