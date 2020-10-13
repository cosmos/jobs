<?php
/**
 * WP Ultimate CSV Importer plugin file.
 *
 * Copyright (C) 2010-2020, Smackcoders Inc - info@smackcoders.com
 */

namespace Smackcoders\FCSV;

if (!defined('ABSPATH'))
	exit; // Exit if accessed directly

class LearnPressImport
{
	private static $learnpress_instance = null;

	public static function getInstance()
	{
		if (LearnPressImport::$learnpress_instance == null) {
			LearnPressImport::$learnpress_instance = new LearnPressImport;
			return LearnPressImport::$learnpress_instance;
		}
		return LearnPressImport::$learnpress_instance;
    }
    
    public function set_learnpress_values($header_array, $value_array, $map, $post_id, $type){
        $post_values = [];
		$helpers_instance = ImportHelpers::getInstance();
		$post_values = $helpers_instance->get_header_values($map, $header_array, $value_array);

		$this->learnpress_values_import($post_values, $post_id, $type, $header_array ,$value_array);
    }

    public function learnpress_values_import($post_values, $post_id, $type, $header_array ,$value_array){
        global $wpdb;	
		if($type == 'lp_course'){
           
            if(isset($post_values['curriculum_name'])){
                $get_curriculum_names = explode('|', $post_values['curriculum_name']);

                if(isset($post_values['curriculum_description'])){
                    $get_curriculum_description = explode('|', $post_values['curriculum_description']);
                }

                if(isset($post_values['lesson_name'])){
                    $get_lesson_names = explode('|', $post_values['lesson_name']);
                }
                if(isset($post_values['lesson_description'])){
                    $get_lesson_description = explode('|', $post_values['lesson_description']);
                }
                
                if(isset($post_values['quiz_name'])){
                    $get_quiz_names = explode('|', $post_values['quiz_name']);
                }
                if(isset($post_values['quiz_description'])){
                    $get_quiz_description = explode('|', $post_values['quiz_description']);
                }

                $temp = 0;
                foreach($get_curriculum_names as $curriculum_name){

                    $curriculums_description = isset($get_curriculum_description[$temp]) ? $get_curriculum_description[$temp] : '';
                    $wpdb->insert( 
                        "{$wpdb->prefix}learnpress_sections", 
                        array("section_name" => $curriculum_name, "section_course_id" => $post_id, "section_description" => $curriculums_description),
                        array('%s', '%d', '%s')
                    );
                    $inserted_section_id = $wpdb->insert_id;

                    if(isset($post_values['lesson_name'])){
                        $individual_lesson_names = explode(',', $get_lesson_names[$temp]);

                        if(isset($post_values['lesson_description'])){
                            $indivdual_lesson_description = explode(',', $get_lesson_description[$temp]);
                        }
                       
                        $get_all_lesson_names = $wpdb->get_results("SELECT post_title FROM {$wpdb->prefix}posts WHERE post_type = 'lp_lesson' AND post_status = 'publish' ", ARRAY_A);
                        $all_lesson_names = array_column($get_all_lesson_names, 'post_title');

                        $i = 0;
                        foreach($individual_lesson_names as $lesson_names){
                            if(in_array($lesson_names, $all_lesson_names)){
                                $lesson_post_id = $wpdb->get_var("SELECT ID from {$wpdb->prefix}posts WHERE post_title = '$lesson_names' and post_type = 'lp_lesson' ");   
                            
                                $check_assigned_to_course = $wpdb->get_var("SELECT section_id FROM {$wpdb->prefix}learnpress_section_items WHERE item_id = $lesson_post_id AND item_type = 'lp_lesson' ");
                                if(empty($check_assigned_to_course)){
                                    LearnPressImport::$learnpress_instance->insert_lesson_details($inserted_section_id, $lesson_post_id, $post_values);
                                }

                            }else{
                                $lessons_description = isset($indivdual_lesson_description[$i]) ? $indivdual_lesson_description[$i] : '';

                                $lesson_array['post_title'] = $lesson_names;
                                $lesson_array['post_content'] = $lessons_description;
                                $lesson_array['post_type'] = 'lp_lesson';
                                $lesson_array['post_status'] = 'publish';
                        
                                $lesson_post_id = wp_insert_post($lesson_array);
                                LearnPressImport::$learnpress_instance->insert_lesson_details($inserted_section_id, $lesson_post_id, $post_values);
                            }
                            
                            $i++;
                        }   
                    }
        
                    if(isset($post_values['quiz_name'])){
                        $individual_quiz_names = explode(',', $get_quiz_names[$temp]);

                        if(isset($post_values['quiz_description'])){
                            $individual_quiz_description = explode(',', $get_quiz_description[$temp]);
                        }
                        else{
                            $individual_quiz_description = [];
                        }
    
                        $get_all_quiz_names = $wpdb->get_results("SELECT post_title FROM {$wpdb->prefix}posts WHERE post_type = 'lp_quiz' AND post_status = 'publish' ", ARRAY_A);
                        $all_quiz_names = array_column($get_all_quiz_names, 'post_title');

                        $j = 0;
                        foreach($individual_quiz_names as $quiz_names){
                            if(in_array($quiz_names, $all_quiz_names)){
                                $quiz_post_id = $wpdb->get_var("SELECT ID from {$wpdb->prefix}posts WHERE post_title = '$quiz_names' and post_type = 'lp_quiz' ");   
                            
                                $check_assigned_to_course = $wpdb->get_var("SELECT section_id FROM {$wpdb->prefix}learnpress_section_items WHERE item_id = $quiz_post_id AND item_type = 'lp_quiz' ");
                                if(empty($check_assigned_to_course)){
                                    LearnPressImport::$learnpress_instance->insert_quiz_details($inserted_section_id, $quiz_post_id, $post_values);
                                }
                            }else{
                                $quizs_description = isset($individual_quiz_description[$j]) ? $individual_quiz_description[$j] : '';
                                $quiz_array['post_title'] = $quiz_names;
                                $quiz_array['post_content'] = $quizs_description;
                                $quiz_array['post_type'] = 'lp_quiz';
                                $quiz_array['post_status'] = 'publish';
                
                                $quiz_post_id = wp_insert_post($quiz_array);
                                LearnPressImport::$learnpress_instance->insert_quiz_details($inserted_section_id, $quiz_post_id, $post_values);
                            }
                            
                            $j++;
                        }
                    }
                    $temp++;
                }   
            }

            $course_setting_array = [];
            $course_setting_array['_lp_duration'] = isset($post_values['_lp_duration']) ? $post_values['_lp_duration'] : '10 week';
            $course_setting_array['_lp_max_students'] = isset($post_values['_lp_max_students']) ? $post_values['_lp_max_students'] : 1000;
            $course_setting_array['_lp_students'] = isset($post_values['_lp_students']) ? $post_values['_lp_students'] : 0;
            $course_setting_array['_lp_retake_count'] = isset($post_values['_lp_retake_count']) ? $post_values['_lp_retake_count'] : 0;
            $course_setting_array['_lp_featured'] = isset($post_values['_lp_featured']) ? $post_values['_lp_featured'] : 'no';
            $course_setting_array['_lp_block_lesson_content'] = isset($post_values['_lp_block_lesson_content']) ? $post_values['_lp_block_lesson_content'] : 'no';
            $course_setting_array['_lp_external_link_buy_course'] = isset($post_values['_lp_external_link_buy_course']) ? $post_values['_lp_external_link_buy_course'] : '';
            $course_setting_array['_lp_submission'] = isset($post_values['_lp_submission']) ? $post_values['_lp_submission'] : 'yes';
            $course_setting_array['_lp_course_result'] = isset($post_values['_lp_course_result']) ? $post_values['_lp_course_result'] : 'evaluate_lesson';
            $course_setting_array['_lp_passing_condition'] = isset($post_values['_lp_passing_condition']) ? $post_values['_lp_passing_condition'] : 80;
            $course_setting_array['_lp_price'] = isset($post_values['_lp_price']) ? $post_values['_lp_price'] : 0;
            $course_setting_array['_lp_sale_price'] = isset($post_values['_lp_sale_price']) ? $post_values['_lp_sale_price'] : 0;
            $course_setting_array['_lp_required_enroll'] = isset($post_values['_lp_required_enroll']) ? $post_values['_lp_required_enroll'] : 'yes';
            $course_setting_array['_lp_course_author'] = isset($post_values['_lp_course_author']) ? $post_values['_lp_course_author'] : 1;
            $course_setting_array['_lp_course_status'] = 'publish';
            
            foreach ($course_setting_array as $course_key => $course_value) {
                update_post_meta($post_id, $course_key, $course_value);
            }
		}

        if($type == 'lp_lesson' || $type == 'lp_quiz' || $type == 'lp_question'){
            if(isset($post_values['course_id']) && $post_values['curriculum_name']){
                $course_id = $post_values['course_id'];
                $curriculum_name = $post_values['curriculum_name'];
                $get_section_id = $wpdb->get_var("SELECT section_id FROM {$wpdb->prefix}learnpress_sections WHERE section_course_id = $course_id AND section_name = '$curriculum_name' ");
            }
            else{
                $get_section_id = '';
            }

            if($type == 'lp_lesson'){
                LearnPressImport::$learnpress_instance->insert_lesson_details($get_section_id, $post_id, $post_values);
            }
            if($type == 'lp_quiz'){
                LearnPressImport::$learnpress_instance->insert_quiz_details($get_section_id, $post_id, $post_values);
            }  
            if($type == 'lp_question'){
                LearnPressImport::$learnpress_instance->insert_question_details($get_section_id, $post_id, $post_values, 0);
            }
        }
   
        if($type == 'lp_order'){
            LearnPressImport::$learnpress_instance->insert_order_details($post_id, $post_values);
        }
	}
	
    public function insert_lesson_details($inserted_section_id, $lesson_post_id, $post_values){
        global $wpdb;
        if(isset($inserted_section_id)){
            $wpdb->insert( 
                "{$wpdb->prefix}learnpress_section_items", 
                array("section_id" => $inserted_section_id, "item_id" => $lesson_post_id, "item_type" => 'lp_lesson'),
                array('%d', '%d', '%s')
            );
        }
        
        if(isset($post_values['_lp_lesson_duration'])){
            update_post_meta($lesson_post_id, '_lp_duration', $post_values['_lp_lesson_duration']);
        }
        if(isset($post_values['_lp_preview'])){
            update_post_meta($lesson_post_id, '_lp_preview', $post_values['_lp_preview']);
        }
    }

    public function insert_quiz_details($inserted_section_id, $quiz_post_id, $post_values){
        global $wpdb;
        if(!empty($inserted_section_id)){
            $wpdb->insert( 
                "{$wpdb->prefix}learnpress_section_items", 
                array("section_id" => $inserted_section_id, "item_id" => $quiz_post_id, "item_type" => 'lp_quiz'),
                array('%d', '%d', '%s')
            );
        }
        
        $quiz_meta_array['_lp_show_hide_question'] = isset($post_values['_lp_show_hide_question']) ? $post_values['_lp_show_hide_question'] : 'no';
        $quiz_meta_array['_lp_review_questions'] = isset($post_values['_lp_review_questions']) ? $post_values['_lp_review_questions'] : 'no';
        $quiz_meta_array['_lp_show_result'] = isset($post_values['_lp_show_result']) ? $post_values['_lp_show_result'] : 'no';
        $quiz_meta_array['_lp_duration'] = isset($post_values['_lp_duration']) ? $post_values['_lp_duration'] : '10 minute';
        $quiz_meta_array['_lp_minus_points'] = isset($post_values['_lp_minus_points']) ? $post_values['_lp_minus_points'] : 0;
        $quiz_meta_array['_lp_minus_skip_questions'] = isset($post_values['_lp_minus_skip_questions']) ? $post_values['_lp_minus_skip_questions'] : 'no';
        $quiz_meta_array['_lp_passing_grade'] = isset($post_values['_lp_passing_grade']) ? $post_values['_lp_passing_grade'] : 80;
        $quiz_meta_array['_lp_retake_count'] = isset($post_values['_lp_quiz_retake_count']) ? $post_values['_lp_quiz_retake_count'] : 0;
        $quiz_meta_array['_lp_archive_history'] = isset($post_values['_lp_archive_history']) ? $post_values['_lp_archive_history'] : 'no';
        $quiz_meta_array['_lp_show_check_answer'] = isset($post_values['_lp_show_check_answer']) ? $post_values['_lp_show_check_answer'] : 0;
        $quiz_meta_array['_lp_show_hint'] = isset($post_values['_lp_show_hint']) ? $post_values['_lp_show_hint'] : 0;
        
        foreach ($quiz_meta_array as $quiz_key => $quiz_value) {
            update_post_meta($quiz_post_id, $quiz_key, $quiz_value);
        }

        if(isset($post_values['question_title'])){
            $get_question_titles = explode(',', $post_values['question_title']);

            $get_all_question_titles = $wpdb->get_results("SELECT post_title FROM {$wpdb->prefix}posts WHERE post_type = 'lp_question' AND post_status = 'publish' ", ARRAY_A);
            $all_questions_title = array_column($get_all_question_titles, 'post_title');

            $temp = 0;
            foreach($get_question_titles as $question_titles){
                if(in_array($question_titles, $all_questions_title)){
                    $question_post_id = $wpdb->get_var("SELECT ID from {$wpdb->prefix}posts WHERE post_title = '$question_titles' AND post_type = 'lp_question' AND post_status != 'trash' ");   
                       
                    $post_values['quiz_id'] = $quiz_post_id;
                    $check_assigned_to_quiz = $wpdb->get_var("SELECT quiz_question_id FROM {$wpdb->prefix}learnpress_quiz_questions WHERE question_id = $question_post_id  ");
                    if(empty($check_assigned_to_quiz)){
                        LearnPressImport::$learnpress_instance->insert_question_details($inserted_section_id, $question_post_id, $post_values, $temp);
                    }

                }else{
                    $question_array['post_title'] = $post_values['question_title'];
                    $question_array['post_content'] = isset($post_values['question_description']) ? $post_values['question_description'] : '';
                    $question_array['post_type'] = 'lp_question';
                    $question_array['post_status'] = 'publish';
        
                    $question_post_id = wp_insert_post($question_array);
                    $post_values['quiz_id'] = $quiz_post_id;
                    LearnPressImport::$learnpress_instance->insert_question_details($inserted_section_id, $question_post_id, $post_values, $temp);
                }

                $temp++;
            }
        }    
    }

    public function insert_question_details($inserted_section_id, $question_post_id, $post_values, $temp){
        global $wpdb;

        if(isset($post_values['_lp_mark'])){
            $lp_question_mark = explode(',',$post_values['_lp_mark']);
        }
        if(isset($post_values['_lp_explanation'])){
            $lp_question_explanation = explode(',',$post_values['_lp_explanation']);
        }
        if(isset($post_values['_lp_hint'])){
            $lp_question_hint = explode(',',$post_values['_lp_hint']);
        }
        if(isset($post_values['_lp_type'])){
            $lp_question_type = explode(',',$post_values['_lp_type']);
        }

        $question_meta_array['_lp_mark'] = isset($lp_question_mark[$temp]) ? $lp_question_mark[$temp] : 1;
        $question_meta_array['_lp_explanation'] = isset($lp_question_explanation[$temp]) ? $lp_question_explanation[$temp] : NULL;
        $question_meta_array['_lp_hint'] = isset($lp_question_hint[$temp]) ? $lp_question_hint[$temp] : NULL;
        $question_meta_array['_lp_type'] = isset($lp_question_type[$temp]) ? $lp_question_type[$temp] : 'true_or_false';

        foreach ($question_meta_array as $question_key => $question_value) {
            update_post_meta($question_post_id, $question_key, $question_value);
        }

        if(isset($post_values['quiz_id'])){
            $quiz_id = $post_values['quiz_id'];
            $question_order = 1;

            $get_question_order = $wpdb->get_var("SELECT question_order FROM {$wpdb->prefix}learnpress_quiz_questions WHERE quiz_id = $quiz_id ORDER BY quiz_question_id DESC LIMIT 1");
            if(!empty($get_question_order)){
                $question_order = $get_question_order + 1;
            }

            $wpdb->insert( 
                "{$wpdb->prefix}learnpress_quiz_questions", 
                array("quiz_id" => $quiz_id, "question_id" => $question_post_id, "question_order" => $question_order),
                array('%d', '%d', '%d')
            );

			if(!empty($inserted_section_id)){
				$check_assigned_to_course = $wpdb->get_var("SELECT section_item_id FROM {$wpdb->prefix}learnpress_section_items WHERE section_id = $inserted_section_id AND item_id = $quiz_id AND item_type = 'lp_quiz' ");
                $check_assigned_to_another_course = $wpdb->get_var("SELECT section_id FROM {$wpdb->prefix}learnpress_section_items WHERE item_id = $quiz_id AND item_type = 'lp_quiz' ");
                
                if(empty($check_assigned_to_course) && empty($check_assigned_to_another_course)){
                    $wpdb->insert( 
                        "{$wpdb->prefix}learnpress_section_items", 
                        array("section_id" => $inserted_section_id, "item_id" => $quiz_id, "item_type" => 'lp_quiz'),
                        array('%d', '%d', '%s')
                    );
                }
            }
        }

        if(isset($post_values['question_options'])){
            $get_separate_question_options = explode(',', $post_values['question_options']);
            $get_separate_options = explode('->', $get_separate_question_options[$temp]);
            
            foreach($get_separate_options as $option_values){
                $get_title_options = explode('|', $option_values);

                $answer_data = array(
                    'text' => $get_title_options[0],
                    'value' => md5( uniqid() ),
                    'is_true' => $get_title_options[1]
                );

                $answer_data = serialize($answer_data);
                $wpdb->insert( 
                    "{$wpdb->prefix}learnpress_question_answers", 
                    array("question_id" => $question_post_id, "answer_data" => $answer_data),
                    array('%d', '%s')
                );
            }
        }
    }

    public function insert_order_details($order_id, $post_values){
    
        global $wpdb;
        $order_key = strtoupper( uniqid( 'ORDER' ) );
        $order_currency = get_option("_order_currency");

        $order_meta_array = [];
        if(isset($post_values['user_id'])){
            $order_meta_array['_user_id'] = $post_values['user_id'];
        }
        else{
            $order_meta_array['_user_id'] = get_current_user_id();
        }

        $order_meta_array['_order_currency'] = $order_currency;
        $order_meta_array['_order_subtotal'] = isset($post_values['_order_subtotal']) ? $post_values['_order_subtotal'] : '';
        $order_meta_array['_order_total'] = isset($post_values['_order_total']) ? $post_values['_order_total'] : '';
        $order_meta_array['_prices_include_tax'] = 'no';
        $order_meta_array['_payment_method'] = '';
        $order_meta_array['_payment_method_title'] = '';
        $order_meta_array['_order_key'] = $order_key;
        $order_meta_array['_order_version'] = '3.0.0';

        foreach($order_meta_array as $order_key => $order_value){
            update_post_meta($order_id, $order_key, $order_value);
        }

        if(isset($post_values['item_id'])){

            $order_item_ids = explode(',', $post_values['item_id']);
            $order_item_quantity = explode(',', $post_values['item_quantity']);
            $order_item_subtotal = explode(',', $post_values['_item_subtotal']);
            $order_item_total = explode(',', $post_values['_item_total']);

            $temp = 0;
            foreach($order_item_ids as $order_item_id){
                $order_name = $wpdb->get_var("SELECT post_title FROM {$wpdb->prefix}posts WHERE ID = $order_item_id ");
            
                $wpdb->insert( 
                    "{$wpdb->prefix}learnpress_order_items", 
                    array("order_item_name" => $order_name, "order_id" => $order_id),
                    array('%s', '%d')
                );
                $lp_order_item_id = $wpdb->insert_id;

                $order_item_meta_array = [];
                $order_item_meta_array['_course_id'] = $order_item_id;
                $order_item_meta_array['_quantity'] = $order_item_quantity[$temp];
                $order_item_meta_array['_subtotal'] = $order_item_subtotal[$temp];
                $order_item_meta_array['_total'] = $order_item_total[$temp];
        
                foreach($order_item_meta_array as $order_item_meta_key => $order_item_meta_value){
                    if(empty($order_item_meta_value)){
                        $order_item_meta_value = 'NULL';
                    }

                    $wpdb->insert( 
                        "{$wpdb->prefix}learnpress_order_itemmeta", 
                        array("learnpress_order_item_id" => $lp_order_item_id, "meta_key" => $order_item_meta_key, "meta_value" => $order_item_meta_value),
                        array('%d', '%s', '%s')
                    );
                }

                $temp++;
            }
        }	
    }

    public function learnpress_orders_import($data_array , $mode , $hash_key , $line_number){
        $returnArr = array();	
        global $wpdb;
        $helpers_instance = ImportHelpers::getInstance();
        $core_instance = CoreFieldsImport::getInstance();
        global $core_instance;

        $log_table_name = $wpdb->prefix ."import_detail_log";

        $updated_row_counts = $helpers_instance->update_count($hash_key);
        $created_count = $updated_row_counts['created'];
        $skipped_count = $updated_row_counts['skipped'];
        
        $data_array['post_type'] = 'lp_order';
        if(isset($data_array['order_status'])) {
            $data_array['post_status'] = $data_array['order_status'];
        }
        /* Assign order date */
        if(!isset( $data_array['order_date'] )) {
            $data_array['post_date'] = current_time('Y-m-d H:i:s');
        } else {
            if(strtotime( $data_array['order_date'] )) {
                $data_array['post_date'] = date( 'Y-m-d H:i:s', strtotime( $data_array['order_date'] ) );
            } else {
                $data_array['post_date'] = current_time('Y-m-d H:i:s');
            }
        }
        if ($mode == 'Insert') {	
            $retID = wp_insert_post( $data_array );
            $mode_of_affect = 'Inserted';
            
            if(is_wp_error($retID) || $retID == '') {
                $core_instance->detailed_log[$line_number]['Message'] = "Can't insert this LP Order. " . $retID->get_error_message();
                $wpdb->get_results("UPDATE $log_table_name SET skipped = $skipped_count WHERE hash_key = '$hash_key'");
                return array('MODE' => $mode, 'ERROR_MSG' => $retID->get_error_message());
            }
            $core_instance->detailed_log[$line_number]['Message'] = 'Inserted LP Order ID: ' . $retID;
            $wpdb->get_results("UPDATE $log_table_name SET created = $created_count WHERE hash_key = '$hash_key'");

        } 
        $returnArr['ID'] = $retID;
        $returnArr['MODE'] = $mode_of_affect;
        return $returnArr;
    }
}

// public function generate_customer_id() {
// 	if ( is_user_logged_in() ) {
// 		return get_current_user_id();
// 	} else {
// 		require_once( ABSPATH . 'wp-includes/class-phpass.php' );
// 		$hasher = new PasswordHash( 12, false );
// 		return md5( $hasher->get_random_bytes( 32 ) );
// 	}
// }