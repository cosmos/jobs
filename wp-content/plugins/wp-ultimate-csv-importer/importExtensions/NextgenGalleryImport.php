<?php
/**
 * WP Ultimate CSV Importer plugin file.
 *
 * Copyright (C) 2010-2020, Smackcoders Inc - info@smackcoders.com
 */

namespace Smackcoders\FCSV;

if ( ! defined( 'ABSPATH' ) )
exit; // Exit if accessed directly

class NextGenGalleryImport {
	private static $nextgengallery_core_instance = null,$media_instance,$smack_instance;

	public  function __construct(){
		add_action('wp_ajax_zip_ngg_upload', array($this , 'zip_ngg_upload'));
	}	

	public static function getInstance() {	
		if (self::$nextgengallery_core_instance == null) {
			self::$nextgengallery_core_instance = new NextGenGalleryImport();
			self::$smack_instance = SmackCSV::getInstance();
			return self::$nextgengallery_core_instance;
		}
		return self::$nextgengallery_core_instance;
	}

	public function zip_ngg_upload(){
		$zip_file_name = $_FILES['zipFile']['name'];
		$zip_folder_name = explode('.zip',$zip_file_name);
		$zip_folder_name = $zip_folder_name[0];
		$hash_key = self::$smack_instance->convert_string2hash_key($zip_file_name);
		$media_dir = wp_get_upload_dir();
		$upload_dir = self::$smack_instance->create_upload_dir();
		$path = $upload_dir . $hash_key . '.zip';
		$extract_path = $media_dir['path'] . '/';
		move_uploaded_file($_FILES['zipFile']['tmp_name'], $path);
		chmod($path, 0777);
		$zip = new \ZipArchive;
		$res = $zip->open($path);
		$get_ngg_options = get_option('ngg_options');
		$get_gallery_path = explode('/', $get_ngg_options['gallerypath']);
		$gallery_name=$zip_folder_name;
		global $wpdb;
		$gallery_table = $wpdb->prefix . 'ngg_gallery';
		$wpdb->insert( $gallery_table, array(
					'title' => $zip_folder_name ,
					'name'  => $zip_folder_name,
					'slug'   => $zip_folder_name,
					'path'    => 'wp-content/gallery/'.$gallery_name.'/'
					)
			     );
		$img_import_date = date('Y-m-d H:i:s');
		global $wpdb;
		$gallery_dir = WP_CONTENT_DIR . '/' . $get_gallery_path[1] . '/' . $gallery_name;
		$image_id = $wpdb->insert_id;
		$storage  = \C_Gallery_Storage::get_instance();
		$params = array('watermark' => false, 'reflection' => false);
		$result = $storage->generate_thumbnail($image_id, $params);
		$post_args = array('post_id' => $post_id);

		$copy_image = TRUE;

		$upload_dir = wp_upload_dir();
		$basedir = $upload_dir['basedir'];
		$gallery_abspath = $storage->get_gallery_abspath($gallery_id);
		$image_abspath = $storage->get_full_abspath($image_id);
		$url = $storage->get_full_url($image_id);

		$image = $storage->_image_mapper->find($image_id);

		if (strpos($image_abspath, $gallery_abspath) === 0) {
			$target_relpath = substr($image_abspath, strlen($gallery_abspath));
		} else {
			if ($gallery_id) {
				$target_relpath = path_join(strval($gallery_id), $target_basename);
			} else {
				$target_relpath = $target_basename;
			}
		}
		$target_relpath = trim($target_relpath, '\\/');
		$target_path = path_join($gallery_dir, $target_relpath);

		$image= file_get_contents($data_array['featured_image']);
		$max_count = 100;
		$count = 0;
		while (@file_exists($target_path) && $count <= $max_count) {
			$count++;
			$pathinfo = \M_I18n::mb_pathinfo($target_path);
			$dirname = $pathinfo['dirname'];
			$filename = $pathinfo['filename'];

			$extension = $pathinfo['extension'];
			$rand = mt_rand(1, 9999);
			$basename = $filename . '_' . sprintf('%04d', $rand) . '.' . $extension;
			$target_path = path_join($dirname, $basename);
		}
		$target_dir = dirname($target_path).'/'.$zip_folder_name;
		wp_mkdir_p($target_dir);
		if ($res === TRUE) {		
			$zip->extractTo($target_dir);
			$zip->close();
			$result['success'] = true;
		} else {
			$result['success'] = false;
		}	
		echo wp_json_encode($result);
		wp_die();
	}

	public function nextgenImport($header_array ,$value_array , $map , $post_id , $selected_type) {
		global $wpdb;
		foreach($map as $key => $value){
			$csv_value= trim($map[$key]);
			if(!empty($csv_value)){
				$get_key= array_search($csv_value , $header_array);
				if(isset($value_array[$get_key])){
					$csv_element = $value_array[$get_key];  
					$wp_element= trim($key);
					if(!empty($csv_element) && !empty($wp_element)){
						$post_values[$wp_element] = $csv_element;
					}
				}
			}
		}
		if(!empty($post_values['nextgen_gallery'])) {
			$thumbnailId = self::importImage($header_array ,$value_array , $map , $post_id , $selected_type,$post_values);
		}
		if($thumbnailId != null) {
			set_post_thumbnail( $post_id, $thumbnailId );
		}
	}

public  function importImage($header_array ,$value_array , $map , $post_id , $selected_type,$post_values) {
		$get_ngg_options = get_option('ngg_options');
		$get_gallery_path = explode('/', $get_ngg_options['gallerypath']);
		$gallery_name=$post_values['nextgen_gallery'];
		$gallery_dir = WP_CONTENT_DIR . '/' . $get_gallery_path[1] . '/' . $gallery_name;
		$names = glob($gallery_dir.'/'.'*.*');
		foreach($names as $values){
			if (strpos($values, $post_values['image_url']) !== false) {
				$fImg_name = content_url().'/'.$get_gallery_path[1] . '/' . $gallery_name.'/'.$post_values['image_url'];
			}
		}           		
		$path_parts = pathinfo($post_values['image_url']);
		$real_fImg_name=$path_parts['filename'];
		$fImg_name = @basename($post_values['image_url']);
		$fImg_name = str_replace(' ', '-', trim($fImg_name));
		$fImg_name = preg_replace('/[^a-zA-Z0-9._\-\s]/', '', $fImg_name);
		$fImg_name = urlencode($fImg_name);		
		global $wpdb;
		$gallery_table = $wpdb->prefix . 'ngg_gallery';
		$get_gallery_id = $wpdb->get_col($wpdb->prepare("select gid from $gallery_table where name='$gallery_name'"));	
		$gallery_id = $get_gallery_id[0];		
		$img_import_date = date('Y-m-d H:i:s');
		global $wpdb;
		$wpdb->insert( $wpdb->prefix .'ngg_pictures', array(
					'image_slug' => $real_fImg_name,
					'galleryid'  => $gallery_id,
					'filename'   => $fImg_name,
					'alttext'    => $real_fImg_name,
					'imagedate'  => $img_import_date,

					)
			     );
		$gallery_dir = WP_CONTENT_DIR . '/' . $get_gallery_path[1] . '/' . $gallery_name;
		$image_id = $wpdb->insert_id;
		$storage  = \C_Gallery_Storage::get_instance();
		$params = array('watermark' => false, 'reflection' => false);
		$result = $storage->generate_thumbnail($image_id, $params);
		$post_args = array('post_id' => $post_id);
		$copy_image = TRUE;
		$upload_dir = wp_upload_dir();
		$basedir = $upload_dir['basedir'];
		$gallery_abspath = $storage->get_gallery_abspath($gallery_id);
		$image_abspath = $storage->get_full_abspath($image_id);
		$url = $storage->get_full_url($image_id);

		$image = $storage->_image_mapper->find($image_id);

		if (strpos($image_abspath, $gallery_abspath) === 0) {
			$target_relpath = substr($image_abspath, strlen($gallery_abspath));
		} else {
			if ($gallery_id) {
				$target_relpath = path_join(strval($gallery_id), $target_basename);
			} else {
				$target_relpath = $target_basename;
			}
		}
		$target_relpath = trim($target_relpath, '\\/');
		$target_path = path_join($gallery_dir, $target_relpath);
		$image= file_get_contents($post_values['image_url']);
		file_put_contents(ABSPATH .'wp-content/gallery/'.$gallery_name.'/'.$fImg_name,$image);
		file_put_contents(ABSPATH .'wp-content/gallery/'.$gallery_name.'/thumbs/'.'thumbs_'.$fImg_name,$image);
		$max_count = 100;
		$count = 0;
		while (@file_exists($target_path) && $count <= $max_count) {
			$count++;
			$pathinfo = \M_I18n::mb_pathinfo($target_path);
			$dirname = $pathinfo['dirname'];
			$filename = $pathinfo['filename'];

			$extension = $pathinfo['extension'];
			$rand = mt_rand(1, 9999);
			$basename = $filename . '_' . sprintf('%04d', $rand) . '.' . $extension;
			$target_path = path_join($dirname, $basename);
		}
		$target_dir = dirname($target_path).'/'.$zip_folder_name;
		if ($copy_image) {
			@copy($image_abspath, $target_path);
			if (!$attachment_id) {
				$size = @getimagesize($target_path);
				$image_type = $size ? $size['mime'] : 'image/jpeg';
				$title = sanitize_file_name($image->alttext);
				$caption = sanitize_file_name($image->description);
				$attachment = array('post_title' => $title, 'post_content' => $caption, 'post_status' => 'attachment', 'post_parent' => 0, 'post_mime_type' => $image_type, 'guid' => $url);
				$attachment_id = wp_insert_attachment($attachment, $target_path);
			}
			update_post_meta($attachment_id, '_ngg_image_id', $image_id);
			wp_update_attachment_metadata($attachment_id, wp_generate_attachment_metadata($attachment_id, $target_path));
		}			
		wp_mkdir_p($target_dir);
		return $attachment_id;
	}

	public function nextgenGallery($data_array){
		$get_ngg_options = get_option('ngg_options');
		$get_gallery_path = explode('/', $get_ngg_options['gallerypath']);
		$gallery_name=$data_array['nextgen_gallery'];
		$gallery_dir = WP_CONTENT_DIR . '/' . $get_gallery_path[1] . '/' . $gallery_name;
		$names = glob($gallery_dir.'/'.'*.*');
		foreach($names as $values){
			if (strpos($values, $data_array['featured_image']) !== false) {
				$fImg_name = content_url().'/'.$get_gallery_path[1] . '/' . $gallery_name.'/'.$data_array['featured_image'];
			}
		}           		
		$path_parts = pathinfo($data_array['featured_image']);
		$real_fImg_name=$path_parts['filename'];
		$fImg_name = @basename($data_array['featured_image']);
		$fImg_name = str_replace(' ', '-', trim($fImg_name));
		$fImg_name = preg_replace('/[^a-zA-Z0-9._\-\s]/', '', $fImg_name);
		$fImg_name = urlencode($fImg_name);		
		global $wpdb;
		$gallery_table = $wpdb->prefix . 'ngg_gallery';
		$get_gallery_id = $wpdb->get_col($wpdb->prepare("select gid from $gallery_table where name='$gallery_name'"));	
		$gallery_id = $get_gallery_id[0];		
		$img_import_date = date('Y-m-d H:i:s');
		global $wpdb;
		$wpdb->insert( $wpdb->prefix .'ngg_pictures', array(
					'image_slug' => $real_fImg_name,
					'galleryid'  => $gallery_id,
					'filename'   => $fImg_name,
					'alttext'    => $real_fImg_name,
					'imagedate'  => $img_import_date,

					)
			     );
		$gallery_dir = WP_CONTENT_DIR . '/' . $get_gallery_path[1] . '/' . $gallery_name;
		$image_id = $wpdb->insert_id;
		$storage  = \C_Gallery_Storage::get_instance();
		$params = array('watermark' => false, 'reflection' => false);
		$result = $storage->generate_thumbnail($image_id, $params);
		$post_args = array('post_id' => $post_id);
		$copy_image = TRUE;
		$upload_dir = wp_upload_dir();
		$basedir = $upload_dir['basedir'];
		$gallery_abspath = $storage->get_gallery_abspath($gallery_id);
		$image_abspath = $storage->get_full_abspath($image_id);
		$url = $storage->get_full_url($image_id);

		$image = $storage->_image_mapper->find($image_id);

		if (strpos($image_abspath, $gallery_abspath) === 0) {
			$target_relpath = substr($image_abspath, strlen($gallery_abspath));
		} else {
			if ($gallery_id) {
				$target_relpath = path_join(strval($gallery_id), $target_basename);
			} else {
				$target_relpath = $target_basename;
			}
		}
		$target_relpath = trim($target_relpath, '\\/');
		$target_path = path_join($gallery_dir, $target_relpath);
		$image= file_get_contents($data_array['featured_image']);
		$max_count = 100;
		$count = 0;
		while (@file_exists($target_path) && $count <= $max_count) {
			$count++;
			$pathinfo = \M_I18n::mb_pathinfo($target_path);
			$dirname = $pathinfo['dirname'];
			$filename = $pathinfo['filename'];

			$extension = $pathinfo['extension'];
			$rand = mt_rand(1, 9999);
			$basename = $filename . '_' . sprintf('%04d', $rand) . '.' . $extension;
			$target_path = path_join($dirname, $basename);
		}
		$target_dir = dirname($target_path).'/'.$zip_folder_name;
		if ($copy_image) {
			@copy($image_abspath, $target_path);
			if (!$attachment_id) {
				$size = @getimagesize($target_path);
				$image_type = $size ? $size['mime'] : 'image/jpeg';
				$title = sanitize_file_name($image->alttext);
				$caption = sanitize_file_name($image->description);
				$attachment = array('post_title' => $title, 'post_content' => $caption, 'post_status' => 'attachment', 'post_parent' => 0, 'post_mime_type' => $image_type, 'guid' => $url);
				$attachment_id = wp_insert_attachment($attachment, $target_path);
			}
			update_post_meta($attachment_id, '_ngg_image_id', $image_id);
			wp_update_attachment_metadata($attachment_id, wp_generate_attachment_metadata($attachment_id, $target_path));
		}			
		wp_mkdir_p($target_dir);
	}
}
