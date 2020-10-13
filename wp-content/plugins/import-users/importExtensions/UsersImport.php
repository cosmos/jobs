<?php
/**
 * Import Users plugin file.
 *
 * Copyright (C) 2010-2020, Smackcoders Inc - info@smackcoders.com
 */

namespace Smackcoders\SMUSERS;

if ( ! defined( 'ABSPATH' ) )
exit; // Exit if accessed directly

class UsersImport{
	private static $users_instance = null,$send_user_password;

	public static function getInstance() {
		if (UsersImport::$users_instance == null) {
			UsersImport::$users_instance = new UsersImport;
			return UsersImport::$users_instance;
		}
		return UsersImport::$users_instance;
	}

	public function users_import_function ($data_array, $mode , $hash_key , $line_number) {
	
		global $wpdb,$core_instance;
		$helpers_instance = ImportHelpers::getInstance();
		$returnArr = array();
		$log_table_name = $wpdb->prefix ."import_detail_log";

		$updated_row_counts = $helpers_instance->update_count($hash_key);
		$created_count = $updated_row_counts['created'];
		$updated_count = $updated_row_counts['updated'];
		$skipped_count = $updated_row_counts['skipped'];

		$data_array['role'] = trim($data_array['role']);
		if ( isset( $data_array['role'] ) && $data_array['role'] != '') {
			$user_capability = '';
			if ( !is_numeric( $data_array['role'] ) ) {	
				$roles = $this->getRoles();	
				if(array_key_exists($data_array['role'], $roles)) {
					$user_capability = $data_array['role'];
				}
			} else {
				for ( $i = 0; $i <= $data_array['role']; $i ++ ) {
					$user_capability .= $i . ",";
				}
				$roles = $this->getRoles('cap');
				if(in_array( $user_capability, $roles )) {
					foreach ( $roles as $rkey => $rval ) {
						if ( $rval == $user_capability ) {
							$user_capability = $rkey;
						}
					}
				} else {
					$user_capability = ''; #TODO: Add log message for assigning the default role
				}
			}
			if($user_capability != '')
				$data_array['role'] = $user_capability;
			else
				$data_array['role'] = 'subscriber'; #TODO: Add log message for assigning the default role
		} else {
			$data_array['role'] = 'subscriber'; #TODO: Add log message for assigning the default role
		}
		$user_email = $data_array['user_email'];

		if ( $mode == 'Insert' ) {
			if ( empty( $data_array['user_pass'] ) ) {	
				$data_array['user_pass'] = wp_generate_password( 12, false );		
				$additional_meta_info = array(
						'user_login' => $data_array['user_login'],
						'user_pass'  => $data_array['user_pass'],
						'user_email' => $data_array['user_email'],
						'role'       => $data_array['role']
						);	
				$data_array['smack_uci_import'] = $additional_meta_info;	
			} 
			else{	
				if (strlen($data_array['user_pass'])!== 34 && $data_array['user_pass'][0]!=='$'){
					$data_array['user_pass'] = wp_hash_password($data_array['user_pass']);
				} 	
				$additional_meta_info = array(
					'user_login' => $data_array['user_login'],
					'user_pass'  => $data_array['user_pass'],
					'user_email' => $data_array['user_email'],
					'role'       => $data_array['role']
				);	
				$data_array['smack_uci_import'] = $additional_meta_info;	
			}
			$retID = wp_insert_user($data_array);
			if ( !is_wp_error($retID) && !empty( $data_array['user_pass'] ) ) {
				$wpdb->get_results("UPDATE {$wpdb->prefix}users SET user_pass = '{$data_array['user_pass']}' WHERE ID  = $retID");		
			}
			$mode_of_affect = 'Inserted';

			if ( is_wp_error( $retID ) ) {
				$core_instance->detailed_log[$line_number]['Message'] = "Skipped, Due to duplicate User found with same email!.";
				$fields = $wpdb->get_results("UPDATE $log_table_name SET skipped = $skipped_count WHERE hash_key = '$hash_key'");
				return array('MODE' => $mode);
			}
			$core_instance->detailed_log[$line_number]['Message'] = 'Inserted User ID: ' . $retID;
			$fields = $wpdb->get_results("UPDATE $log_table_name SET created = $created_count WHERE hash_key = '$hash_key'");

		} else {
			if ( $mode == 'Update') {

				$update_query = $wpdb->prepare( "select ID from {$wpdb->prefix}users where user_email = %s order by ID DESC", $user_email );
				$ID_result    = $wpdb->get_results( $update_query );
				if ( is_array( $ID_result ) && ! empty( $ID_result ) ) {
					$retID = $ID_result[0]->ID;
					$data_array['ID'] = $retID;
					wp_update_user( $data_array );
					$mode_of_affect = 'Updated';

					$core_instance->detailed_log[$line_number]['Message'] = 'Updated User ID: ' . $retID;
					$fields = $wpdb->get_results("UPDATE $log_table_name SET updated = $updated_count WHERE hash_key = '$hash_key'");

				}else{
					$retID = wp_insert_user($data_array);
					$mode_of_affect = 'Inserted';

					if ( is_wp_error( $retID ) ) {

						$core_instance->detailed_log[$line_number]['Message'] = "Skipped, Due to duplicate User found with same email!.";
						$fields = $wpdb->get_results("UPDATE $log_table_name SET skipped = $skipped_count WHERE hash_key = '$hash_key'");
						return array('MODE' => $mode);
					}
					$core_instance->detailed_log[$line_number]['Message'] = 'Inserted User ID: ' . $retID;
					$fields = $wpdb->get_results("UPDATE $log_table_name SET created = $created_count WHERE hash_key = '$hash_key'");
				}
			}
		}
		$metaData = array();
		foreach ( $data_array as $daKey => $daVal ) {

			switch ( $daKey ) {
				case 'biographical_info' :
					$metaData['description'] = $data_array[ $daKey ];
					break;
				case 'disable_visual_editor' :
					$metaData['rich_editing'] = $data_array[ $daKey ];
					break;
				case 'enable_keyboard_shortcuts':
					$metaData['comment_shortcuts'] = $data_array[ $daKey ];
					break;
				case 'admin_color':
					$metaData['admin_color'] = $data_array[ $daKey ];
					break;
				case 'show_toolbar':
					$metaData['show_admin_bar_front'] = $data_array[ $daKey ];
					break;
				case 'smack_uci_import':
					$metaData['smack_uci_import'] = $data_array[ $daKey ];
			}
		}

		if ( ! empty ( $metaData ) ) {
			foreach ( $metaData as $meta_key => $meta_value ) {
				update_user_meta( $retID, $meta_key, $meta_value );
			}
		}
		$core_instance->detailed_log[$line_number]['Email'] = $data_array['user_email'];
		$core_instance->detailed_log[$line_number]['Role'] = $data_array['role'];
		$ucisettings = get_option('sm_uci_pro_settings');
		if($ucisettings['send_user_password'] == "true") {
			$send_user_password = new SendPassword;
			$send_user_password->send_login_credentials_to_users();	
		}
		$returnArr['ID'] = $retID;
		$returnArr['MODE'] = $mode_of_affect;
		return $returnArr;
	}

	public function getRoles($capability = null) {
		global $wp_roles;
		$roles = array();
		if($capability != null) {
			foreach ( $wp_roles->roles as $rkey => $rval ) {
				$roles[ $rkey ] = '';
				for ( $cnt = 0; $cnt < count( $rval['capabilities'] ); $cnt ++ ) {
					$findval = "level_" . $cnt;
					if ( array_key_exists( $findval, $rval['capabilities'] ) ) {
						$roles[ $rkey ] = $roles[ $rkey ] . $cnt . ',';
					}
				}
			}
		} else {
			if ( ! isset( $wp_roles ) )
				$wp_roles = new \WP_Roles();

			$roles = $wp_roles->get_names();
		}
		return $roles;
	}
}
