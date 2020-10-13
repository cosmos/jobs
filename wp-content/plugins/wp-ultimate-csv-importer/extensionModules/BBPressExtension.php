<?php
/**
 * WP Ultimate CSV Importer plugin file.
 *
 * Copyright (C) 2010-2020, Smackcoders Inc - info@smackcoders.com
 */

namespace Smackcoders\FCSV;

if ( ! defined( 'ABSPATH' ) )
	exit; // Exit if accessed directly

class BBPressExtension extends ExtensionHandler{
	private static $instance = null;

	public static function getInstance() {		
		if (BBPressExtension::$instance == null) {
			BBPressExtension::$instance = new BBPressExtension;
		}
		return BBPressExtension::$instance;
	}


	public function processExtension($data){        
		$import_type = $data;
		$response = [];
		//$import_type = $this->import_type_as($import_type);
		if(is_plugin_active('bbpress/bbpress.php')){   
			if($import_type == 'forum'){
				$bbpress_meta_fields = array(
					'Type' => '_bbp_forum_type',
					'Status' => '_bbp_status',
					'Visibility' => 'Visibility',
					'Forum Moderators' => 'bbp_moderators'

				);

			}

			if($import_type == 'topic'){            
				$bbpress_meta_fields = array(
					'Forum ID' => '_bbp_forum_id',
					'Topic Status' => 'topic_status',
					'Author' => 'author',
					'Author IP' => '_bbp_author_ip',
					'Topic Type' =>'topic_type',
				);
			}

			if($import_type == 'reply'){            
				$bbpress_meta_fields = array(
					'Forum ID' => '_bbp_forum_id',
					'Topic ID' => '_bbp_topic_id',
					'Reply Status' => 'reply_status',
					'Reply author' => 'reply_author',
					'Author IP' => '_bbp_author_ip',
					'Reply' => 'reply'
				);
			}
		}

		$bbpress_meta_field_key = $this->convert_static_fields_to_array($bbpress_meta_fields);

		if($data == 'forum'){
			$response['forum_attributes_fields'] = $bbpress_meta_field_key; 
		}
		if($data == 'topic'){
			$response['topic_attributes_fields'] = $bbpress_meta_field_key; 
		}  
		if($data == 'reply'){
			$response['reply_attributes_fields'] = $bbpress_meta_field_key; 
		}   
		return $response;

	}

	public function extensionSupportedImportType($import_type ){
		if(is_plugin_active('bbpress/bbpress.php')){
			if($import_type == 'forum' || $import_type == 'topic' || $import_type == 'reply') { 
				return true;
			}else{
				return false;
			}
		}
	}
}
