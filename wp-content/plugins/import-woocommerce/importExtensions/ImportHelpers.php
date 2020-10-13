<?php
/**
 * Import Woocommerce plugin file.
 *
 * Copyright (C) 2010-2020, Smackcoders Inc - info@smackcoders.com
 */

namespace Smackcoders\SMWC;

if ( ! defined( 'ABSPATH' ) )
    exit; // Exit if accessed directly

class ImportHelpers {
    private static $helpers_instance = null;

    public static function getInstance() {
		
		if (ImportHelpers::$helpers_instance == null) {
			ImportHelpers::$helpers_instance = new ImportHelpers;
			return ImportHelpers::$helpers_instance;
		}
		return ImportHelpers::$helpers_instance;
    }
    
    public function assign_post_status($data_array) {
		if (isset($data_array['is_post_status']) && $data_array['is_post_status'] != 'on') {
			$data_array ['post_status'] = $data_array['is_post_status'];
			unset($data_array['is_post_status']);
		}
		if (isset($data_array ['post_type']) && $data_array ['post_type'] == 'page') {
			$data_array ['post_status'] = 'publish';
		} else {
			if(isset($data_array['post_status']) || isset($data_array['coupon_status'])) {
				if(isset($data_array['post_status'])) {
					$data_array['post_status'] = strtolower( $data_array['post_status'] );
				} else {
					$data_array['post_status'] = strtolower( $data_array['coupon_status'] );
				}
				$data_array['post_status'] = trim($data_array['post_status']);
				if ($data_array['post_status'] != 'publish' && $data_array['post_status'] != 'private' && $data_array['post_status'] != 'draft' && $data_array['post_status'] != 'pending' && $data_array['post_status'] != 'sticky') {
					$stripPSF = strpos($data_array['post_status'], '{');
					if ($stripPSF === 0) {
						$poststatus = substr($data_array['post_status'], 1);
						$stripPSL = substr($poststatus, -1);
						if ($stripPSL == '}') {
							$postpwd = substr($poststatus, 0, -1);
							$data_array['post_status'] = 'publish';
							$data_array ['post_password'] = $postpwd;
						} else {
							$data_array['post_status'] = 'publish';
							$data_array ['post_password'] = $poststatus;
						}
					} else {
						$data_array['post_status'] = 'publish';
					}
				}
				if ($data_array['post_status'] == 'sticky') {
					$data_array['post_status'] = 'publish';
					$sticky = true;
				}
				else {
				}
			} else {
				$data_array['post_status'] = 'publish';
			}
		}
		return $data_array;
	}

	public function import_post_types($import_type, $importAs = null) {	
		$import_type = trim($import_type);
		
		$module = array('Posts' => 'post', 'Pages' => 'page', 'Users' => 'user', 'Comments' => 'comments', 'Taxonomies' => $importAs, 'CustomerReviews' =>'wpcr3_review', 'Categories' => 'categories', 'Tags' => 'tags', 'eShop' => 'post', 'WooCommerce' => 'product', 'WPeCommerce' => 'wpsc-product','WPeCommerceCoupons' => 'wpsc-product', 'MarketPress' => 'product', 'MarketPressVariations' => 'mp_product_variation','WooCommerceVariations' => 'product', 'WooCommerceOrders' => 'product', 'WooCommerceCoupons' => 'product', 'WooCommerceRefunds' => 'product', 'CustomPosts' => $importAs);
		foreach (get_taxonomies() as $key => $taxonomy) {
			$module[$taxonomy] = $taxonomy;
		}
		if(array_key_exists($import_type, $module)) {
			return $module[$import_type];
		}
		else {
			return $import_type;
		}
	}
	
	public function UCI_WPML_Supported_Posts ($data_array, $pId) {
		global $sitepress, $wpdb;
		$get_trid = $wpdb->get_results("select trid from {$wpdb->prefix}icl_translations ORDER BY translation_id DESC limit 1");
		$trid = $get_trid[0]->trid;
		if(empty($data_array['translated_post_title']) && !empty($data_array['language_code'])){
			$wpdb->insert( $wpdb->prefix.'icl_translations', array('element_type' => 'post_'.$data_array['post_type'],'language_code' => $data_array['language_code'],'element_id' => $pId , 'trid' => $trid + 1));
		}
		elseif(!empty($data_array['language_code']) && !empty($data_array['translated_post_title'])){
			$update_query = $wpdb->prepare("select ID,post_type from $wpdb->posts where post_title = %s and post_type=%s order by ID DESC",$data_array['translated_post_title'] , $data_array['post_type']);
			$ID_result = $wpdb->get_results($update_query);
			if(is_array($ID_result) && !empty($ID_result)) {
				$element_id = $ID_result[0]->ID;
				$post_type = $ID_result[0]->post_type;
			}else{
				return false;
			}
			/* Update Multi-language */
			$update = $wpdb->prepare("select translation_id from $wpdb->posts where element_id = %s  order by ID DESC",$pId);
			$result_ID = $wpdb->get_results($update); 
			if(is_array($result_ID) && !empty($result_ID)) {
				$upelement_id = $result_ID[0]->ID;
			}
			$trid_id = $sitepress->get_element_trid($element_id,'post_'.$post_type);
			$translate_lcode = $sitepress->get_language_for_element($element_id,'post_'.$post_type);
			if(!empty($result_ID)){  
				$wpdb->update($wpdb->prefix.'icl_translations', array(
				'element_type' => 'post_'.$data_array['post_type'],
				'trid'      => $trid_id,
				'language_code'  => $data_array['language_code'],
				'source_language_code' => $translate_lcode
				
			), array('element_id' => $pId ), array( '%s', '%s', '%s', '%s' ), array( '%d' ) );
			} else{
				$wpdb->insert( $wpdb->prefix.'icl_translations', array( 'element_type' => 'post_'.$data_array['post_type'],'trid' => $trid_id, 'language_code' => $data_array['language_code'], 'source_language_code' => $translate_lcode ,'element_id' => $pId));
			}
		}
	}

	public function get_header_values($map , $header_array , $value_array){

		$post_values = [];
			foreach($map as $key => $value){
				$csv_value= trim($map[$key]);
				if(!empty($csv_value)){
					$pattern = "/({([a-z A-Z 0-9 | , _ -]+)(.*?)(}))/";
					if(preg_match_all($pattern, $csv_value, $matches, PREG_PATTERN_ORDER)){		
						$csv_element = $csv_value;
						foreach($matches[2] as $value){
	
							$get_key = array_search($value , $header_array);
							if(isset($value_array[$get_key])){
								$csv_value_element = $value_array[$get_key];	
								$value = '{'.$value.'}';
								$csv_element = str_replace($value, $csv_value_element, $csv_element);
							}
						}
						
						$math = 'MATH';
						if (strpos($csv_element, $math) !== false) {		
							$equation = str_replace('MATH', '', $csv_element);
							$csv_element = $this->evalmath($equation);
						}
							
						$wp_element= trim($key);
						if(!empty($csv_element) && !empty($wp_element)){
							$post_values[$wp_element] = $csv_element;
						}
					}
					
					elseif(!in_array($csv_value , $header_array)){
						$wp_element= trim($key);
						$post_values[$wp_element] = $csv_value;
					}	
					
					else{
							$get_key= array_search($csv_value , $header_array);		
							if(!empty($value_array[$get_key])){
								$csv_element = $value_array[$get_key];	
					
								$wp_element = trim($key);
								if(!empty($csv_element) && !empty($wp_element)){
									$post_values[$wp_element] = $csv_element;
								}
							}
					}
				}
			}
		return $post_values;
	}

	public function evalmath($equation) {
		
		$result = 0;
		
		// sanitize imput
		$equation = preg_replace("/[^0-9+\-.*\/()%]/","",$equation);
	
		// convert percentages to decimal
		$equation = preg_replace("/([+-])([0-9]{1})(%)/","*(1\$1.0\$2)",$equation);
		$equation = preg_replace("/([+-])([0-9]+)(%)/","*(1\$1.\$2)",$equation);
		//$equation = preg_replace("/([0-9]+)(%)/",".\$1",$equation);
	
		if ( $equation != "" )
		{
			$result = @eval("return " . $equation . ";" );
		}
	
		if ($result === null)
		{
			//throw new Exception("Unable to calculate equation");
			$result = "Unable to calculate equation";
		}
		if($result === FALSE){
			$result = 'false';
		}
		
		return $result;	
	}

	public function update_log($message , $status , $verify , $post_id , $hash_key){
		
		global $wpdb;
		$importlog_table_name = $wpdb->prefix ."import_log_detail";
				
		$wpdb->insert($importlog_table_name, array(
			'hash_key' => $hash_key,
			'message' => "{$message}",
			'status' => "{$status}",
			'verify' => "{$verify}",
			'post_id' => $post_id,
						
			),
			array('%s', '%s', '%s', '%s', '%d')
			);
	}

	public function update_error_log($message , $hash_key , $post_id){
		global $wpdb;
		$importlog_table_name = $wpdb->prefix ."import_log_detail";
				
		$wpdb->insert($importlog_table_name, array(
			'hash_key' => $hash_key,
			'message' => "{$message}",
			'post_id' => $post_id
						
			),
			array('%s', '%s', '%d')
			);
	}

	public function update_category_log($category , $post_id){
		global $wpdb;
		$wpdb->update($wpdb->prefix.'import_log_detail', array(
			'categories' => "{$category}"
			), 
			array('post_id' => $post_id)
		);
	}

	public function update_tag_log($tag , $post_id){
		global $wpdb;
		$wpdb->update($wpdb->prefix.'import_log_detail', array(
			'tags' => "{$tag}"
			), 
			array('post_id' => $post_id)
		);
	}
	public function update_status_log($status , $verify , $post_id){
		global $wpdb;
		$wpdb->update($wpdb->prefix.'import_log_detail', array(
			'status' => "{$status}",
			'verify' => "{$verify}"
			), 
			array('post_id' => $post_id)
		);
	}

	public function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }

        return $bytes;
	}

	public function update_count($hash_key){
		$response = [];
		global $wpdb;
		$log_table_name = $wpdb->prefix ."import_detail_log";
		$get_data =  $wpdb->get_results("SELECT skipped , created , updated FROM $log_table_name WHERE hash_key = '$hash_key' ");
			$skipped = $get_data[0]->skipped;
			$response['skipped'] = $skipped + 1;
			$created = $get_data[0]->created;
			$response['created'] = $created + 1;
			$updated = $get_data[0]->updated;
			$response['updated'] = $updated + 1;

		return $response;
	}
	
}