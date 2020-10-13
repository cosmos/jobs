<?php
/**
 * WP Ultimate CSV Importer plugin file.
 *
 * Copyright (C) 2010-2020, Smackcoders Inc - info@smackcoders.com
 */

namespace Smackcoders\FCSV;

if ( ! defined( 'ABSPATH' ) )
    exit; // Exit if accessed directly

class CommentsImport {
    private static $comments_instance = null;

    public static function getInstance() {
		
		if (CommentsImport::$comments_instance == null) {
			CommentsImport::$comments_instance = new CommentsImport;
			return CommentsImport::$comments_instance;
		}
		return CommentsImport::$comments_instance;
    }

    public function comments_import_function($data_array , $mode , $hash_key , $line_number) {
		global $wpdb;
		$core_instance = CoreFieldsImport::getInstance();
		global $core_instance;
		$helpers_instance = ImportHelpers::getInstance();
		$log_table_name = $wpdb->prefix ."import_detail_log";
		$returnArr = [];

		$updated_row_counts = $helpers_instance->update_count($hash_key);
		$created_count = $updated_row_counts['created'];
		$updated_count = $updated_row_counts['updated'];
		$skipped_count = $updated_row_counts['skipped'];
		
		$commentid = '';
		$post_id = $data_array['comment_post_ID'];
		$post_exists = $wpdb->get_row("SELECT * FROM {$wpdb->prefix}posts WHERE id = '" . $post_id . "' and post_status in ('publish','draft','future','private','pending')", ARRAY_A);
		$valid_status = array('1', '0', 'spam');
		if(empty($data_array['comment_approved'])) {
			$data_array['comment_approved'] = 0;
		}
		if(!in_array($data_array['comment_approved'], $valid_status)) {
			$data_array['comment_approved'] = 0;
		}
		$data_array['comment_approved'] = trim($data_array['comment_approved']);
		if(!empty($data_array['user_id'])){
			$user_login=$data_array['user_id'];
				$u_id =  $wpdb->get_results("SELECT ID FROM {$wpdb->prefix}users WHERE  user_login = '$user_login'");		
			foreach($u_id as $user_id){
				$users=$user_id->ID;
				$data_array['user_id']=$users;
			}
			}
		if ($post_exists) {
			if($mode == 'Insert'){
				$retID = wp_insert_comment($data_array);
				$mode_of_affect = 'Inserted';
				
				if(is_wp_error($retID) || $retID == '') {
					
					$core_instance->detailed_log[$line_number]['Message'] = "Skipped, Due to unknown post ID.";	
					$fields = $wpdb->get_results("UPDATE $log_table_name SET skipped = $skipped_count WHERE hash_key = '$hash_key'");
				
					$returnArr['MODE'] = $mode_of_affect;
					return $returnArr;
				}
				$core_instance->detailed_log[$line_number]['Message'] = 'Inserted Comment ID: ' . $retID;		
				$fields = $wpdb->get_results("UPDATE $log_table_name SET created = $created_count WHERE hash_key = '$hash_key'");
			}
			if($mode == 'Update'){
				$ID_result =  $wpdb->get_results("SELECT comment_ID FROM {$wpdb->prefix}comments WHERE comment_post_ID = $post_id order by comment_ID DESC ");		
				if ( is_array( $ID_result ) && ! empty( $ID_result ) ) {

					$retID = $ID_result[0]->comment_ID;		
					$data_array['comment_ID'] = $retID;
					wp_update_comment( $data_array );
					$mode_of_affect = 'Updated';

					$core_instance->detailed_log[$line_number]['Message'] = 'Updated Comment ID: ' . $retID;	
					$fields = $wpdb->get_results("UPDATE $log_table_name SET updated = $updated_count WHERE hash_key = '$hash_key'");
				}else{
					
					$retID = wp_insert_comment($data_array);
					$mode_of_affect = 'Inserted';
					
					if(is_wp_error($retID) || $retID == '') {	
						$core_instance->detailed_log[$line_number]['Message'] = "Skipped, Due to unknown post ID.";
						$fields = $wpdb->get_results("UPDATE $log_table_name SET skipped = $skipped_count WHERE hash_key = '$hash_key'");
						
						$returnArr['MODE'] = $mode_of_affect;
						return $returnArr;
					}
					$core_instance->detailed_log[$line_number]['Message'] = 'Inserted Comment ID: ' . $retID;		
					$fields = $wpdb->get_results("UPDATE $log_table_name SET created = $created_count WHERE hash_key = '$hash_key'");
				}
			}
		}else {
			$retID = $commentid;
			$core_instance->detailed_log[$line_number]['Message'] = "Skipped, Due to unknown post ID.";
			$fields = $wpdb->get_results("UPDATE $log_table_name SET skipped = $skipped_count WHERE hash_key = '$hash_key'");
		}
			
		$returnArr['ID'] = $retID;
		$returnArr['MODE'] = $mode_of_affect;
		return $returnArr;
		}
		
		public function menu_import_function($data_array , $mode , $hash_key , $line_number){
			global $wpdb;
		
			$menu_title = $data_array['menu_title'];
			$check_term_exists = term_exists($menu_title, 'nav_menu');

			if(is_array($check_term_exists)){
				$insert_term_id = $check_term_exists['term_id'];
				$insert_taxo_id = $check_term_exists['term_taxonomy_id'];
			}
			else{
				$insert_term = wp_insert_term($menu_title, 'nav_menu');
				$insert_term_id = $insert_term['term_id'];
				$insert_taxo_id = $insert_term['term_taxonomy_id'];
			}
			
			$menu_item_types = explode(',', $data_array['_menu_item_type']);
			$menu_item_objects = explode(',', $data_array['_menu_item_object']);
			$menu_item_objects_ids = explode(',', $data_array['_menu_item_object_id']);
			$menu_item_urls = explode(',', $data_array['_menu_item_url']);

			$temp = 0;
			foreach($menu_item_types as $menu_types){

				$menu_object_titles = $menu_item_objects_ids[$temp];
				$menu_objects = $menu_item_objects[$temp];
	
				if($menu_types == 'custom'){
					$post_title = $menu_object_titles;
				}
				else{
					$post_title = '';
				}

				// posts table entry
				$nav_post_arr = array(
							'post_title' => $post_title,
							'post_status' => 'publish',
							'post_type' => 'nav_menu_item',
							'menu_order' => $temp + 1
						);

				$inserted_post_id = wp_insert_post($nav_post_arr);

				if($menu_types == 'post_type'){
					$post_title_id = $wpdb->get_var("SELECT ID FROM {$wpdb->prefix}posts WHERE post_title = '$menu_object_titles' AND post_type = '$menu_objects' AND  post_status = 'publish' ");
				}
				elseif($menu_types == 'taxonomy'){
					$get_menu_term_id = get_term_by('name', $menu_object_titles, $menu_objects);
					$post_title_id = $get_menu_term_id->term_id;
				}
				else{
					$post_title_id = $inserted_post_id;
				}

				// postmeta table entry
				update_post_meta($inserted_post_id, '_menu_item_type', $menu_types);
				update_post_meta($inserted_post_id, '_menu_item_menu_item_parent', 0);
				update_post_meta($inserted_post_id, '_menu_item_object_id', $post_title_id);
				update_post_meta($inserted_post_id, '_menu_item_object', $menu_objects);
				update_post_meta($inserted_post_id, '_menu_item_target', '');
				update_post_meta($inserted_post_id, '_menu_item_classes', 'a:1:{i:0;s:0:"";}');
				update_post_meta($inserted_post_id, '_menu_item_xfn', '');
				update_post_meta($inserted_post_id, '_menu_item_url', $menu_item_urls[$temp]);

				// terms relationship table entry
				$wpdb->insert($wpdb->prefix.'term_relationships',
						array('object_id' => $inserted_post_id,
									'term_taxonomy_id' => $insert_taxo_id
						),
						array('%d','%d')
				);

				$temp++;
			}

			$menu_auto_add = $data_array['menu_auto_add'];
		
			$get_auto_add = get_option("nav_menu_options");
        foreach($get_auto_add as $auto_key => $auto_value){
            if($auto_key == 'auto_add'){
                if(empty($auto_value)){
									if($menu_auto_add == 'yes'){
										$get_auto_add['auto_add'] = array($insert_term_id);
										update_option("nav_menu_options", $get_auto_add);
									}
                }
                else{
									if(!in_array($insert_term_id , $auto_value) && $menu_auto_add == 'yes'){
                    array_push($auto_value, $insert_term_id);
										$get_auto_add['auto_add'] = $auto_value;
										update_option("nav_menu_options", $get_auto_add);
									}
                }
            }
				}
				
			$data_array_copy = $data_array;
			$exclude_keys = array('menu_title', '_menu_item_type', '_menu_item_object', '_menu_item_object_id', '_menu_item_url', 'menu_auto_add');
			foreach($exclude_keys as $exclude_key){
				unset($data_array_copy[$exclude_key]);
			}

			foreach($data_array_copy as $data_key => $data_value){
				if($data_value == 'yes'){
					$locations = get_theme_mod( 'nav_menu_locations' );
					$locations[$data_key] = $insert_term_id;
					set_theme_mod ( 'nav_menu_locations', $locations );
				}
			}
		}


		public function widget_import_function($post_values , $mode ,$hash_key , $line_number){
			
				foreach($post_values as $post_widget_key => $post_widget_value){
					if(!empty($post_widget_value)){
						$get_widget_id = explode('widget_', $post_widget_key);
						$get_total_posts = explode('|', $post_widget_value);
						foreach($get_total_posts as $per_post){

							$get_post_footer = explode('->', $per_post);
							$post_footer_number = $get_post_footer[1];
							$sidebar = 'sidebar-'.$post_footer_number;

							$get_post_details = explode(',', $get_post_footer[0]);
							
							$widget_data = [];

							if($post_widget_key == 'widget_recent-posts'){
								$widget_data['title'] = $get_post_details[0];
								$widget_data['number'] = $get_post_details[1];
								$widget_data['show_date'] = $get_post_details[2];
							}
							elseif($post_widget_key == 'widget_pages'){
								$widget_data['title'] = $get_post_details[0];
								$widget_data['sortby'] = $get_post_details[1];

								$exclude_ids = str_replace('/', ',', $get_post_details[2]);
								$widget_data['exclude'] = $exclude_ids;
							}
							elseif($post_widget_key == 'widget_recent-comments'){
								$widget_data['title'] = $get_post_details[0];
								$widget_data['number'] = $get_post_details[1];
							}
							elseif($post_widget_key == 'widget_archives'){
								$widget_data['title'] = $get_post_details[0];
								$widget_data['count'] = $get_post_details[1];
								$widget_data['dropdown'] = $get_post_details[2];
							}
							elseif($post_widget_key == 'widget_categories'){
								$widget_data['title'] = $get_post_details[0];
								$widget_data['count'] = $get_post_details[1];
								$widget_data['hierarchical'] = $get_post_details[2];
								$widget_data['dropdown'] = $get_post_details[3];
							}

							$this->insert_widget_in_sidebar( $get_widget_id[1], $widget_data, $sidebar );
						}	
					}
				}
		}

		public function insert_widget_in_sidebar( $widget_id, $widget_data, $sidebar ) {
			// Retrieve sidebars, widgets and their instances
			$sidebars_widgets = get_option( 'sidebars_widgets', array() );
			$widget_instances = get_option( 'widget_' . $widget_id, array() );
		
			// Retrieve the key of the next widget instance
			$numeric_keys = array_filter( array_keys( $widget_instances ), 'is_int' );
			//$next_key = $numeric_keys ? max( $numeric_keys ) + 1 : 2;
		
			if((count($numeric_keys) == 1) && (empty($widget_instances[$numeric_keys[0]]['title']))){
				$next_key = $numeric_keys[0];
			}else{
				$next_key = max( $numeric_keys ) + 1;
			}
			
		
			// Add this widget to the sidebar
			if ( ! isset( $sidebars_widgets[ $sidebar ] ) ) {
				$sidebars_widgets[ $sidebar ] = array();
			}

			$sidebar_key_id = $widget_id . '-' . $next_key;
			if(!in_array($sidebar_key_id, $sidebars_widgets[ $sidebar ])){
				$sidebars_widgets[ $sidebar ][] = $sidebar_key_id;
			}
		
			// Add the new widget instance
			$widget_instances[ $next_key ] = $widget_data;
		
			// Store updated sidebars, widgets and their instances
			update_option( 'sidebars_widgets', $sidebars_widgets );
			update_option( 'widget_' . $widget_id, $widget_instances );
		}
}