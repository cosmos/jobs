<?php
/**
 * Import Woocommerce plugin file.
 *
 * Copyright (C) 2010-2020, Smackcoders Inc - info@smackcoders.com
 */

namespace Smackcoders\SMWC;

if ( ! defined( 'ABSPATH' ) )
exit; // Exit if accessed directly

require_once('ImportHelpers.php');
require_once('MediaHandling.php');

class WooCommerceCoreImport extends ImportHelpers {
	private static $woocommerce_core_instance = null,$media_instance;

	public static function getInstance() {

		if (WooCommerceCoreImport::$woocommerce_core_instance == null) {
			WooCommerceCoreImport::$woocommerce_core_instance = new WooCommerceCoreImport;
			WooCommerceCoreImport::$media_instance = new MediaHandling();
			return WooCommerceCoreImport::$woocommerce_core_instance;
		}
		return WooCommerceCoreImport::$woocommerce_core_instance;
	}

		public function woocommerce_product_import($data_array, $mode , $check , $hash_key , $line_number) {

			$helpers_instance = ImportHelpers::getInstance();
			global $wpdb; 
			global $core_instance;

			$log_table_name = $wpdb->prefix ."import_detail_log";
			$data_array['PRODUCTSKU'] = trim($data_array['PRODUCTSKU']);

			$returnArr = array();
			$assigned_author = '';
			$mode_of_affect = 'Inserted';

			// Assign post type
			$data_array['post_type'] = 'product';
			$data_array = $core_instance->import_core_fields($data_array);
			$post_type = $data_array['post_type'];

			if($check == 'ID'){	
				$ID = $data_array['ID'];	
				$get_result =  $wpdb->get_results("SELECT ID FROM {$wpdb->prefix}posts WHERE ID = '$ID' AND post_type = '$post_type' AND post_status != 'trash' order by ID DESC ");			
			}
			if($check == 'post_title'){
				$title = $data_array['post_title'];
				$get_result =  $wpdb->get_results("SELECT ID FROM {$wpdb->prefix}posts WHERE post_title = '$title' AND post_type = '$post_type' AND post_status != 'trash' order by ID DESC ");		
			}
			if($check == 'post_name'){
				$name = $data_array['post_name'];
				$get_result =  $wpdb->get_results("SELECT ID FROM {$wpdb->prefix}posts WHERE post_name = '$name' AND post_type = '$post_type' AND post_status != 'trash' order by ID DESC ");	
			}
			if($check == 'PRODUCTSKU'){
				$sku = $data_array['PRODUCTSKU'];
				$get_result =  $wpdb->get_results("SELECT DISTINCT p.ID FROM {$wpdb->prefix}posts p join {$wpdb->prefix}postmeta pm ON p.ID = pm.post_id WHERE p.post_type = 'product' AND p.post_status != 'trash' and pm.meta_value = '$sku' ");
			}

			$updated_row_counts = $helpers_instance->update_count($hash_key);
			$created_count = $updated_row_counts['created'];
			$updated_count = $updated_row_counts['updated'];
			$skipped_count = $updated_row_counts['skipped'];

			if ($mode == 'Insert') {

				if (is_array($get_result) && !empty($get_result)) {
#skipped
					$core_instance->detailed_log[$line_number]['Message'] = "Skipped, Due to duplicate Product found!.";
					$fields = $wpdb->get_results("UPDATE $log_table_name SET skipped = $skipped_count WHERE hash_key = '$hash_key'");
					return array('MODE' => $mode);
				}else{

					$post_id = wp_insert_post($data_array); 
					set_post_format($post_id , $data_array['post_format']);	

					if(is_wp_error($post_id) || $post_id == '') {
# skipped
						$core_instance->detailed_log[$line_number]['Message'] = "Can't insert this Product. " . $post_id->get_error_message();
						$fields = $wpdb->get_results("UPDATE $log_table_name SET skipped = $skipped_count WHERE hash_key = '$hash_key'");
						return array('MODE' => $mode);
					}else {
						//WPML support on post types
						global $sitepress;
						if($sitepress != null) {
							$helpers_instance->UCI_WPML_Supported_Posts($data_array, $post_id);
						}
					}
					$core_instance->detailed_log[$line_number]['Message'] = 'Inserted Product ID: ' . $post_id . ', ' . $assigned_author;	
					$fields = $wpdb->get_results("UPDATE $log_table_name SET created = $created_count WHERE hash_key = '$hash_key'");
				}	
			}	
			if($mode == 'Update'){

				if (is_array($get_result) && !empty($get_result)) {
					$post_id = $get_result[0]->ID;
					$data_array['ID'] = $post_id;
					wp_update_post($data_array);
					set_post_format($post_id , $data_array['post_format']);		
					$core_instance->detailed_log[$line_number]['Message'] = 'Updated Product ID: ' . $post_id . ', ' . $assigned_author;
					$fields = $wpdb->get_results("UPDATE $log_table_name SET updated = $updated_count WHERE hash_key = '$hash_key'");

				}else{
					$post_id = wp_insert_post($data_array); 
					set_post_format($post_id , $data_array['post_format']);

					if(is_wp_error($post_id) || $post_id == '') {
# skipped
						$core_instance->detailed_log[$line_number]['Message'] = "Can't insert this Product. " . $post_id->get_error_message();
						$fields = $wpdb->get_results("UPDATE $log_table_name SET skipped = $skipped_count WHERE hash_key = '$hash_key'");
						return array('MODE' => $mode);
					}
					$core_instance->detailed_log[$line_number]['Message'] = 'Inserted Product ID: ' . $post_id . ', ' . $assigned_author;
					$fields = $wpdb->get_results("UPDATE $log_table_name SET created = $created_count WHERE hash_key = '$hash_key'");	
				}
			}
			$returnArr['ID'] = $post_id;
			$returnArr['MODE'] = $mode_of_affect;
			if (!empty($data_array['post_author'])) {
				$returnArr['AUTHOR'] = isset($assigned_author) ? $assigned_author : '';
			}
			return $returnArr;
		}

	}

	global $uci_woocomm_instance;
	$uci_woocomm_instance = new WooCommerceCoreImport;
