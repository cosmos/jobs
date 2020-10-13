<?php
/**
 * Import Users plugin file.
 *
 * Copyright (C) 2010-2020, Smackcoders Inc - info@smackcoders.com
 */

namespace Smackcoders\SMUSERS;

if ( ! defined( 'ABSPATH' ) )
exit; // Exit if accessed directly

class MediaHandling{
	private static $instance=null;
	public $header_array;
	public $value_array;

	public function __construct(){
		
		require_once(ABSPATH.'wp-load.php');
		require_once(ABSPATH . 'wp-admin/includes/image.php');
		require_once(ABSPATH . 'wp-admin/includes/file.php');
		add_action('wp_ajax_image_options', array($this , 'imageOptions'));
		add_action('wp_ajax_delete_image' , array($this , 'deleteImage'));
		add_action('wp_ajax_media_report' , array($this , 'mediaReport'));
	}

	public static function imageOptions(){		
		$media_settings['use_ExistingImage'] = $_POST['use_ExistingImage'];
		$media_settings['overwriteImage'] = $_POST['overwriteImage'];
		$media_settings['title'] = $_POST['title'];
		$media_settings['caption'] = $_POST['caption'];
		$media_settings['alttext'] = $_POST['alttext'];		
		$media_settings['description'] = $_POST['description'];
		$media_settings['file_name'] = $_POST['file_name'];					
		$media_settings['thumbnail'] = $_POST['thumbnail'];
		$media_settings['media_handle_option'] = $_POST['media_handle_option'];		
		$media_settings['medium'] = $_POST['medium'];		
		$media_settings['medium_large'] = $_POST['medium_large'];		
		$media_settings['large'] = $_POST['large'];		
		$media_settings['custom'] = $_POST['custom'];
		$media_settings['custom_slug'] = $_POST['custom_slug'];
		$media_settings['custom_slug'] = $_POST['custom_width'];
		$media_settings['custom_height'] = $_POST['custom_height'];
		$image_info = array(
				'media_settings'  => $media_settings
				);
		update_option( 'smack_image_options', $image_info );
		$result['success'] = 'true';
		echo wp_json_encode($result);
		wp_die();
	}
	public static function getInstance() {
		if (MediaHandling::$instance == null) {
			MediaHandling::$instance = new MediaHandling;
			//MediaHandling::$instance->featured_image();
			return MediaHandling::$instance;
		}
		return MediaHandling::$instance;
	}

	public function deleteImage(){
		$image = $_POST['image'];
		$media_dir = wp_get_upload_dir();
		$names = glob($media_dir['path'].'/'.'*.*');
		foreach($names as $values){
			if (strpos($values, $image) !== false) {
				unlink($values);
			}
		}   
		$result['success'] = 'true';
		echo wp_json_encode($result);
		wp_die();     
	}
	public function media_handling($img_url , $post_id , $data_array = null  ,$module = null, $image_type = null ,$hash_key = null, $header_array = null , $value_array = null){
		$encodedurl = urlencode($img_url);
		$img_url = urldecode($encodedurl);
		$media_handle = get_option('smack_image_options');	
		$image_name = basename($img_url);
		$image_title = sanitize_file_name( pathinfo( $image_name, PATHINFO_FILENAME ) );
		global $wpdb;

		if($media_handle['media_settings']['media_handle_option'] == 'true'){
			if($media_handle['media_settings']['use_ExistingImage'] == 'true'){
				$guid_url = $img_url;
				$attachment_id = $wpdb->get_results("select ID from {$wpdb->prefix}posts where guid = '$guid_url'" ,ARRAY_A);
				if(!empty($attachment_id)){
					foreach($attachment_id as $value){
						$attach_id = $value['ID'];
						if(!wp_get_attachment_url($attach_id)){
							$attach_id = $this->image_function($img_url , $post_id , $data_array, '', 'use_existing_image',$header_array , $value_array );
						}
					}
				}
				else{
					$attach_id = $this->image_function($img_url , $post_id , $data_array , '', 'use_existing_image',$header_array , $value_array);
				}
			}
			elseif($media_handle['media_settings']['overwriteImage'] == 'true'){
				$get_id = $wpdb->get_results("SELECT ID FROM {$wpdb->prefix}posts WHERE post_title = '$image_title' AND post_type = 'attachment' limit 1");
				if(!empty($get_id)){
					foreach($get_id as $value){
						$attach_id = $value->ID;
						$this->overwrite($attach_id , $img_url);
						if(!empty($data_array['featured_image'])) {
							set_post_thumbnail( $post_id, $attach_id );
						}
					}
				}
				else{
					$attach_id = $this->image_function($img_url , $post_id , $data_array,'','',$header_array , $value_array);
				}
			}
			else{
				$attach_id = $this->image_function($img_url , $post_id , $data_array,'','',$header_array , $value_array);
			}
		}
		else{
			$guid_url = $img_url;
			$attachment_id = $wpdb->get_results("select ID from {$wpdb->prefix}posts where guid = '$guid_url'" ,ARRAY_A);

			if(!empty($attachment_id)){

				foreach($attachment_id as $value){
					$attach_id = $value['ID'];
					if($_wp_attachment_metadata = get_post_meta($attach_id, '_wp_attachment_metadata', true)){
						// When an attachment is available on Media and not has attachment link
						if(!is_array($_wp_attachment_metadata)){
							$attach_id = $this->image_function($img_url , $post_id , $data_array,'','',$header_array , $value_array);
						}
					}
					//set_post_thumbnail( $post_id, $attach_id );
				}
			}
		}
		return $attach_id;
	}

	public function mediaReport(){
		global $wpdb;
		$list_of_images = $wpdb->get_results("select * from {$wpdb->prefix}ultimate_csv_importer_media GROUP BY `hash_key`,`image_type` ",ARRAY_A);
		foreach( $list_of_images as $list_key => $list_val )
		{
			if(!empty($list_val['hash_key'])){
				$file_name = $wpdb->get_results("select file_name from {$wpdb->prefix}smackcsv_file_events where hash_key = '{$list_val['hash_key']}'",ARRAY_A);
			}
			$filename[$list_key]= $file_name[0]['file_name'];
			$module[$list_key] = $list_val['module'];
			$image_type[$list_key] = $list_val['image_type'];
			$image_status[$list_key] = $list_val['status'];
			$number_of_images = $wpdb->get_results("select image_url from {$wpdb->prefix}ultimate_csv_importer_media where hash_key = '{$list_val['hash_key']}' and image_type = '{$image_type[$list_key]}' ",ARRAY_A);
			$count[$list_key] = count($number_of_images);
		}
		$response['file_name'] = $filename ;
		$response['module'] = $module ;
		$response['count'] = $count;
		$response['image_type'] = $image_type;
		$response['status'] = $image_status;
		echo wp_json_encode($response);
		wp_die();
	}

	public function image_function($f_img , $post_id , $data_array = null,$option_name = null, $use_existing_image = false,$header_array = null , $value_array = null){
		
		global $wpdb;
		$media_handle = get_option('smack_image_options');
		$media_settings = array_combine($header_array,$value_array);
		if(isset($media_handle['media_settings']['alttext'])) {
			$alttext ['_wp_attachment_image_alt'] = $media_settings[$media_handle['media_settings']['alttext']];
		} 
		if(preg_match_all('/\b(?:(?:https?|?:http?|ftp|file):\/\/|www\.|ftp\.)[-A-Z0-9+&@#\/%=~_|$?!:,.]*[A-Z0-9+&@#\/%=~_|$]/i', $f_img , $matchedlist, PREG_PATTERN_ORDER)) {
			$f_img = $f_img;
		}   
		else{
			$media_dir = wp_get_upload_dir();
			$names = glob($media_dir['path'].'/'.'*.*');
			foreach($names as $values){
				if (strpos($values, $f_img) !== false) {
					$f_img = $media_dir['url'].'/'.$f_img;
				}
			}            
		}
		$image_name = pathinfo($f_img);
		if(!empty($media_handle['media_settings']['file_name'])){	
			$file_type = wp_check_filetype( $f_img, null );
			$ext = '.'. $file_type['ext'];
			$fimg_name = $media_settings[$media_handle['media_settings']['file_name']].$ext;
		}		
		else{
			$fimg_name = $image_name['basename'];
		}

		$file_type = wp_check_filetype( $fimg_name, null );
		if($use_existing_image){
			if(empty($file_type['ext'])){
				$fimg_name = @basename($f_img);
				$fimg_name = str_replace(' ', '-', trim($fimg_name));
				$fimg_name = preg_replace('/[^a-zA-Z0-9._\-\s]/', '', $fimg_name);
			}
			$attachment_id = $wpdb->get_var("SELECT ID FROM ".$wpdb->prefix."posts WHERE post_type = 'attachment' AND guid LIKE '%$fimg_name'");

			if($attachment_id){
				if(!empty($data_array['featured_image'])){
					set_post_thumbnail( $post_id, $attachment_id );
					return $attachment_id;
				}else{
					return $attachment_id;
				}
			}
		}

		$attachment_title = sanitize_file_name( pathinfo( $fimg_name, PATHINFO_FILENAME ) );
		$file_type = wp_check_filetype( $fimg_name, null );  
		$dir = wp_upload_dir();
		$dirname = date('Y') . '/' . date('m');
		$uploaddir_paths = $dir ['basedir'] . '/' . $dirname ;
		$uploaddir_url = $dir ['baseurl'] . '/' . $dirname;
		$f_img = str_replace(" ","%20",$f_img);
		if(empty($file_type['ext'])){
			$fimg_name = @basename($f_img);
			$fimg_name = str_replace(' ', '-', trim($fimg_name));
			$fimg_name = preg_replace('/[^a-zA-Z0-9._\-\s]/', '', $fimg_name);
		}
		if ($uploaddir_paths != "" && $uploaddir_paths) {
			$uploaddir_path = $uploaddir_paths . "/" . $fimg_name;
		}
		//Removed curl and added wordpress http api	
		$response = wp_remote_get($f_img, array( 'timeout' => 10));  				
		$rawdata =  wp_remote_retrieve_body($response);
		$http_code = wp_remote_retrieve_response_code($response);
		if($http_code == 404){
			return null;
		}

		if ( $http_code != 200 && strpos( $rawdata, 'Not Found' ) != 0 ) {
			$rawdata = null;
		}
		if ($rawdata == false) {
			return null;
		} else {		

			if (file_exists($uploaddir_path)) {
				$i = 1;
				$exist = true;
				while($exist){
					$fimg_name = $attachment_title . "-" . $i . "." . $file_type['ext'];        
					$uploaddir_path = $uploaddir_paths . "/" . $fimg_name;

					if (file_exists($uploaddir_path)) {
						$i = $i + 1;
					}
					else{
						$exist = false;
					}
				}
			}

			$fp = fopen($uploaddir_path, 'x');
			fwrite($fp, $rawdata);
			fclose($fp);
		}
		if(empty($file_type['type'])){
			$file_type['type'] = 'image/jpeg';
		}
		$post_info = array(
				'guid'           => $uploaddir_url . "/" .  $fimg_name,
				'post_mime_type' => $file_type['type'],
				'post_title'     => $attachment_title,
				'post_content'   => '',
				'post_status'    => 'inherit',
				);
		//unset( $post_info['ID'] );
		$attach_id = wp_insert_attachment( $post_info,$uploaddir_path, $post_id );
		$attach_data = wp_generate_attachment_metadata( $attach_id, $uploaddir_path );
		wp_update_attachment_metadata( $attach_id,  $attach_data );
		if($media_handle['media_settings']['thumbnail'] = 'true') {
			$thumbnail_width = get_option('thumbnail_size_w');
			$thumbnail_height = get_option('thumbnail_size_h');
			$metadata = wp_get_attachment_metadata($attach_id);
			$metadata['width'] = $thumbnail_width;
			$metadata['height'] = $thumbnail_height;
			wp_update_attachment_metadata($attach_id,$metadata);
		}
		elseif($media_handle['media_settings']['medium_'] = 'true'){
			$medium_width = get_option('medium_size_w');
			$medium_height = get_option('medium_size_h');
			$metadata = wp_get_attachment_metadata($attach_id);
			$metadata['width'] = $medium_width;
			$metadata['height'] = $medium_height;
			wp_update_attachment_metadata($attach_id,$metadata);
		}
		elseif($media_handle['media_settings']['medium_large'] = 'true') {
			$medium_large_width = get_option('medium_large_size_w');
			$medium_large_height = get_option('medium_large_size_h');
			//add_image_size( 'medium_large', $medium_large_width, $medium_large_height, true );
			$metadata = wp_get_attachment_metadata($attach_id);
			$metadata['width'] = $medium_large_width;
			$metadata['height'] = $medium_large_height;
			wp_update_attachment_metadata($attach_id,$metadata);
		}
		elseif($media_handle['media_settings']['large'] = 'true'){
			$large_width = get_option('large_size_w');
			$large_height = get_option('large_size_h');
			$metadata = wp_get_attachment_metadata($attach_id);
			$metadata['width'] = $large_width;
			$metadata['height'] = $large_height;
			wp_update_attachment_metadata($attach_id,$metadata);
		}
		if(isset($media_handle['media_settings']['description'])){
			$media_handle['media_settings']['description'] = $media_settings[$media_handle['media_settings']['description']];
		}
		if(isset($media_handle['media_settings']['caption'])){
			$media_handle['media_settings']['caption'] = $media_settings[$media_handle['media_settings']['caption']];
		}
		if(isset($media_handle['media_settings']['title'])){
			$media_handle['media_settings']['title'] = $media_settings[$media_handle['media_settings']['title']];
		}
		if(isset($media_handle['media_settings']['caption']) || isset($media_handle['media_settings']['description'])){
			wp_update_post(array(
						'ID'           =>$attach_id,
						'post_content' =>$media_handle['media_settings']['description'],
						'post_excerpt' =>$media_handle['media_settings']['caption']
					    ));
		}
		if(isset($media_handle['media_settings']['title'])){
			wp_update_post(array(
						'ID'           =>$attach_id,
						'post_title'   =>$media_handle['media_settings']['title']
					    ));
		}
		if($attach_id != null && isset($alttext['_wp_attachment_image_alt'])){  
			update_post_meta($attach_id, '_wp_attachment_image_alt', $alttext['_wp_attachment_image_alt']);
		}
		if(!empty($data_array['featured_image'])) {
			set_post_thumbnail( $post_id, $attach_id );
		}
		delete_option( $option_name );
		return $attach_id;
	}


	public function image_import($data_array){
		$encodedurl = urlencode($data_array['featured_image']);
		$data_array['featured_image'] = urldecode($encodedurl);
		if(isset($data_array['alt_text'])) {
			$alttext ['_wp_attachment_image_alt'] = $data_array['alt_text'];
		} 
		if(preg_match_all('/\b(?:(?:https?|http|ftp|file):\/\/|www\.|ftp\.)[-A-Z0-9+&@#\/%=~_|$?!:,.]*[A-Z0-9+&@#\/%=~_|$]/i', $data_array['featured_image'] , $matchedlist, PREG_PATTERN_ORDER)) 
		{
			$f_img = $data_array['featured_image'];
		}   
		else{
			$media_dir = wp_get_upload_dir();
			$names = glob($media_dir['path'].'/'.'*.*');
			$f_img = $data_array['featured_image'];
			foreach($names as $values){
				if (strpos($values, $f_img) !== false) {
					$f_img = $media_dir['url'].'/'.$f_img;
				}
			}            
		}
		$image_name = pathinfo($f_img);
		$attachment_title = sanitize_file_name( pathinfo( $f_img, PATHINFO_FILENAME ) );             
		$file_type = wp_check_filetype( $f_img, null );        
		$dir = wp_upload_dir();
		$dirname = date('Y') . '/' . date('m');
		$uploaddir_paths = $dir ['basedir'] . '/' . $dirname ;
		$uploaddir_url = $dir ['baseurl'] . '/' . $dirname;
		if(empty($file_type['ext']) || empty($data_array['file_name'])){
			$fimg_name = @basename($f_img);
			$fimg_name = str_replace(' ', '-', trim($fimg_name));
			$fimg_name = preg_replace('/[^a-zA-Z0-9._\-\s]/', '', $fimg_name);
		}
		if(!empty($data_array['file_name'])){	
			$file_type = wp_check_filetype( $f_img, null );
			$ext = '.'. $file_type['ext'];
			$fimg_name = $data_array['file_name'].$ext;
		}	
		if ($uploaddir_paths != "" && $uploaddir_paths) {
			$uploaddir_path = $uploaddir_paths . "/" . $fimg_name;
		}
		if (strstr($f_img, 'https://drive.google.com')){
			$page_content = file_get_contents($f_img);
			$dom_obj = new \DOMDocument();
			$dom_obj->loadHTML($page_content);
			$meta_val = null;		
			foreach($dom_obj->getElementsByTagName('meta') as $meta) {
				if($meta->getAttribute('property')=='og:image'){ 
    				$meta_val = $meta->getAttribute('content');
					}
				}
			$ch = curl_init($meta_val);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
			$rawdata=curl_exec ($ch);	
		}
		//Removed curl and added wordpress http api
		else{
		if($file_type['ext'] == 'jpeg'){
			$response = wp_remote_get($f_img, array( 'timeout' => 30));		
		}else{
			$response = wp_remote_get($f_img, array( 'timeout' => 10));	
		}
		$rawdata =  wp_remote_retrieve_body($response);
		}
		$http_code = wp_remote_retrieve_response_code($response);
		
		if($http_code == 404){
			return null;
		}
		
		// When 
		if ( $http_code != 200 && strpos( $rawdata, 'Not Found' ) != 0 ) {
			return null;
		}
		
		if ($rawdata == false) {
		
			return null;
		} else {		
			
			if (file_exists($uploaddir_path)) {
				$i = 1;
				$exist = true;
				while($exist){
					$fimg_name = $attachment_title . "-" . $i . "." . $file_type['ext'];        
					$uploaddir_path = $uploaddir_paths . "/" . $fimg_name;

					if (file_exists($uploaddir_path)) {
						$i = $i + 1;
					}
					else{
						$exist = false;
					}
				}
			}
			$fp = fopen($uploaddir_path, 'x');
			fwrite($fp, $rawdata);
			fclose($fp);
		}
		if(empty($file_type['type'])){
			$file_type['type'] = 'image/jpeg';
		}
		//Removed curl and added wordpress http api
		$post_info = array(
				'guid'           => $uploaddir_url . "/" .  $fimg_name,
				'post_mime_type' => $file_type['type'],
				'post_title'     => $attachment_title,
				'post_content'   => '',
				'post_status'    => 'inherit',
				);
		unset( $post_info['ID'] );
		$attach_id = wp_insert_attachment( $post_info,$uploaddir_path );
		$attach_data = wp_generate_attachment_metadata( $attach_id, $uploaddir_path );
		wp_update_attachment_metadata( $attach_id,  $attach_data );
		wp_update_post(array(
					'ID'           => $attach_id,
					'post_title'   => $data_array['title'],
					'post_content' => $data_array['description'],
					'post_excerpt' => $data_array['caption']
				    ));
		if($attach_id != null && isset($alttext['_wp_attachment_image_alt'])){  
			update_post_meta($attach_id, '_wp_attachment_image_alt', $alttext['_wp_attachment_image_alt']);
		}
		return $attach_id;
	}


	function overwrite($post_id , $img_url){

		global $wpdb;
		$sql = "SELECT post_mime_type FROM {$wpdb->prefix}posts WHERE ID = $post_id";
		list($current_filetype) = $wpdb->get_row($sql, ARRAY_N);
		$current_filename = wp_get_attachment_url($post_id);

		$current_guid = $current_filename;
		$current_filename = substr($current_filename, (strrpos($current_filename, "/") + 1));

		$ID = $post_id;

		//$current_file = get_attached_file($ID, apply_filters( 'emr_unfiltered_get_attached_file', true ));
		$current_file = get_attached_file($ID);
		$current_path = substr($current_file, 0, (strrpos($current_file, "/")));
		$current_file = preg_replace("|(?<!:)/{2,}|", "/", $current_file);
		$current_filename = basename($current_file);
		$current_metadata = wp_get_attachment_metadata( $post_id );

		// $original_file_perms = fileperms($current_file) & 0777;

		$data = file_get_contents($img_url);

		$new_filename = basename($img_url);
		$file_type = wp_check_filetype( $new_filename, null );
		$new_filetype = $file_type["type"];
		if(empty($new_filetype['ext'])){
			$new_filename = @basename($img_url);
			$new_filename = str_replace(' ', '-', trim($new_filename));
			$new_filename = preg_replace('/[^a-zA-Z0-9._\-\s]/', '', $new_filename);
		}
		if(empty($new_filetype)){
			$new_filetype = 'image/jpeg';
		}

		$original_file_perms = fileperms($current_file) & 0777;

		$this->emr_delete_current_files( $current_file, $current_metadata , $post_id );

		$new_filename = wp_unique_filename( $current_path, $new_filename );
		$new_file = $current_path . "/" . $new_filename;
		file_put_contents($new_file, $data);

		@chmod($current_file, $original_file_perms);

		$new_filetitle = preg_replace('/\.[^.]+$/', '', basename($new_file));
		$new_guid = str_replace($current_filename, $new_filename, $current_guid);

		$post_date = gmdate( 'Y-m-d H:i:s' );

		$sql = $wpdb->prepare(
				"UPDATE {$wpdb->prefix}posts SET post_title = '$new_filetitle', post_name = '$new_filetitle', guid = '$new_guid', post_mime_type = '$new_filetype', post_date = '$post_date', post_date_gmt = '$post_date' WHERE ID = %d;",
				$post_id
				);
		$wpdb->query($sql);


		$sql = $wpdb->prepare(
				"SELECT meta_value FROM {$wpdb->prefix}postmeta WHERE meta_key = '_wp_attached_file' AND post_id = %d;",
				$post_id
				);

		$old_meta_name = $wpdb->get_row($sql, ARRAY_A);
		$old_meta_name = $old_meta_name["meta_value"];

		// Make new postmeta _wp_attached_file
		$new_meta_name = str_replace($current_filename, $new_filename, $old_meta_name);
		$sql = $wpdb->prepare(
				"UPDATE {$wpdb->prefix}postmeta SET meta_value = '$new_meta_name' WHERE meta_key = '_wp_attached_file' AND post_id = %d;",
				$post_id
				);
		$wpdb->query($sql);

		$new_metadata = wp_generate_attachment_metadata( $post_id, $new_file );
		wp_update_attachment_metadata( $post_id, $new_metadata );



		$current_base_url = $this->emr_get_match_url( $current_guid ); //  .wp-contet.uplodas/ dae name without ext

		$sql = $wpdb->prepare(
				"SELECT ID, post_content FROM {$wpdb->prefix}posts WHERE post_status = 'publish' AND post_content LIKE %s;",
				'%' . $current_base_url . '%'
				);


		$rs = $wpdb->get_results( $sql, ARRAY_A );

		$number_of_updates = 0;


		if ( ! empty( $rs ) ) {
			$search_urls  = $this->emr_get_file_urls( $current_guid, $current_metadata );
			$replace_urls = $this->emr_get_file_urls( $new_guid, $new_metadata );
			$replace_urls = $this->emr_normalize_file_urls( $search_urls, $replace_urls );

			foreach ( $rs AS $rows ) {

				$number_of_updates = $number_of_updates + 1;

				// replace old URLs with new URLs.
				$post_content = $rows["post_content"];

				$post_content = addslashes( str_replace( $search_urls, $replace_urls, $post_content ) );

				$sql = $wpdb->prepare(
						"UPDATE {$wpdb->prefix}posts SET post_content = '$post_content' WHERE ID = %d;",
						$rows["ID"]
						);

				$wpdb->query( $sql );
			}
		}
		update_attached_file( $post_id, $new_file );

	}


	function emr_delete_current_files( $current_file, $metadta = null , $post_id ) {
		// Delete old file

		// Find path of current file
		$current_path = substr($current_file, 0, (strrpos($current_file, "/")));

		// Check if old file exists first
		if (file_exists($current_file)) {
			// Now check for correct file permissions for old file
			clearstatcache();
			if (is_writable($current_file)) {
				// Everything OK; delete the file
				unlink($current_file);
			}
			else {
				// File exists, but has wrong permissions. Let the user know.
				printf( esc_html__('The file %1$s can not be deleted by the web server, most likely because the permissions on the file are wrong.'), $current_file);
				exit;	
			}
		}

		// Delete old resized versions if this was an image
		$suffix = substr($current_file, (strlen($current_file)-4));
		$prefix = substr($current_file, 0, (strlen($current_file)-4));

		if (strtolower($suffix) === ".pdf") {
			$prefix .= "-pdf";
			$suffix = ".jpg";
		}

		$imgAr = array(".png", ".gif", ".jpg", ".jpeg");
		if (in_array($suffix, $imgAr)) {
			// It's a png/gif/jpg based on file name
			// Get thumbnail filenames from metadata
			if ( empty( $metadata ) ) {
				$metadata = wp_get_attachment_metadata( $post_id );
			}
			//		var_dump($metadata);exit;

			if (is_array($metadata)) { // Added fix for error messages when there is no metadata (but WHY would there not be? I don't know…)
				foreach($metadata["sizes"] AS $thissize) {
					// Get all filenames and do an unlink() on each one;
					$thisfile = $thissize["file"];
					// Create array with all old sizes for replacing in posts later
					$oldfilesAr[] = $thisfile;
					// Look for files and delete them
					if (strlen($thisfile)) {
						$thisfile = $current_path . "/" . $thissize["file"];
						if (file_exists($thisfile)) {
							unlink($thisfile);
						}
					}
				}
			}

		}
	}

	function emr_get_match_url($url) {
		$url = $this->emr_remove_scheme($url);
		$url = $this->emr_maybe_remove_query_string($url);
		$url = $this->emr_remove_size_from_filename($url, true);
		$url = $this->emr_remove_domain_from_filename($url);

		return $url;
	}

	function emr_remove_scheme( $url ) {
		return preg_replace( '/^(?:http|https):/', '', $url );
	}

	function emr_maybe_remove_query_string( $url ) {
		$parts = explode( '?', $url );

		return reset( $parts );
	}

	function emr_remove_size_from_filename( $url, $remove_extension = false ) {
		$url = preg_replace( '/^(\S+)-[0-9]{1,4}x[0-9]{1,4}(\.[a-zA-Z0-9\.]{2,})?/', '$1$2', $url );

		if ( $remove_extension ) {
			$ext = pathinfo( $url, PATHINFO_EXTENSION );
			$url = str_replace( ".$ext", '', $url );
		}

		return $url;
	}

	function emr_remove_domain_from_filename($url) {
		// Holding place for possible future function
		$url = str_replace($this->emr_remove_scheme(get_bloginfo('url')), '', $url);
		return $url;
	}


	function emr_get_file_urls( $guid, $metadata ) {
		$urls = array();

		$guid = $this->emr_remove_scheme( $guid );
		$guid= $this->emr_remove_domain_from_filename($guid);

		$urls['guid'] = $guid;

		if ( empty( $metadata ) ) {
			return $urls;
		}

		$base_url = dirname( $guid );

		if ( ! empty( $metadata['file'] ) ) {
			$urls['file'] = trailingslashit( $base_url ) . wp_basename( $metadata['file'] );
		}

		if ( ! empty( $metadata['sizes'] ) ) {
			foreach ( $metadata['sizes'] as $key => $value ) {
				$urls[ $key ] = trailingslashit( $base_url ) . wp_basename( $value['file'] );
			}
		}

		return $urls;
	}

	function emr_normalize_file_urls( $old, $new ) {
		$result = array();

		if ( empty( $new['guid'] ) ) {
			return $result;
		}

		$guid = $new['guid'];

		foreach ( $old as $key => $value ) {
			$result[ $key ] = empty( $new[ $key ] ) ? $guid : $new[ $key ];
		}

		return $result;
	}
}
