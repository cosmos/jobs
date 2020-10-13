<?php
/**
 * Import Users plugin file.
 *
 * Copyright (C) 2010-2020, Smackcoders Inc - info@smackcoders.com
 */

namespace Smackcoders\SMUSERS;

if ( ! defined( 'ABSPATH' ) )
exit; // Exit if accessed directly

require_once('MediaHandling.php');

class WPMembersImport extends UsersImport {
	private static $wpmembers_instance = null,$media_instance;

	public static function getInstance() {

		if (WPMembersImport::$wpmembers_instance == null) {
			WPMembersImport::$wpmembers_instance = new WPMembersImport;
			WPMembersImport::$media_instance = new MediaHandling;
			return WPMembersImport::$wpmembers_instance;
		}
		return WPMembersImport::$wpmembers_instance;
	}
	function set_wpmembers_values($header_array ,$value_array , $map, $post_id , $type){
		$post_values = [];
		$helpers_instance = ImportHelpers::getInstance();
		$post_values = $helpers_instance->get_header_values($map , $header_array , $value_array);		
		$this->wpmembers_import_function($post_values,$post_id,$header_array,$value_array);

	}

	public function wpmembers_import_function($data_array, $uID ,$header_array,$value_array) {

		$get_WPMembers_fields = get_option('wpmembers_fields');
		foreach ($get_WPMembers_fields as $key => $value) {
			$wpmembers[$value[2]] = $value[3];
		}
		if(!empty($data_array)) {
			foreach ($data_array as $custom_key => $custom_value) {
				if($wpmembers[$custom_key] == 'image' || $wpmembers[$custom_key] == 'file')
				{
					$imageid = WPMembersImport::$media_instance->media_handling($custom_value, $uID ,$data_array , $header_array, $value_array);
					update_user_meta($uID, $custom_key, $imageid);
				}
				else
					update_user_meta($uID, $custom_key, $custom_value);
			}
		}
	}
}
global $wpmember_class;
$wpmember_class = new WPMembersImport();
