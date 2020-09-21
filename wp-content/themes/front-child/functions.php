<?php
/**
 * Front Child
 *
 * @package front-child
 */

/**
 * Include all your custom code here
 */
// https://www.amberweinberg.com/wp-job-manager-plugin-custom-filters-functions/
// https://wpjobmanager.com/customization-snippets/

require(__DIR__.'/inc/functions-contributors.php');
require(__DIR__.'/inc/functions-projects.php');

function cosmos_job_board_assets() {
  wp_enqueue_style( 'cosmos-job-board-stylesheet', get_stylesheet_directory_uri() . '/dist/css/main.css', array(), '1.0.0', 'all' );
  wp_enqueue_script( 'cosmos-job-board-scripts', get_stylesheet_directory_uri() . '/dist/js/main.js', array('jquery'), '1.0.0', true );
}
add_action('wp_enqueue_scripts', 'cosmos_job_board_assets');

// This is just stuff that will be needed but has not been customized.
// Add field to frontend
add_filter( 'submit_resume_form_fields', 'wpjms_frontend_resume_form_fields' );
function wpjms_frontend_resume_form_fields( $fields ) {
  $fields['resume_fields']['candidate_color'] = array(
      'label' => __( 'Favourite Color', 'job_manager' ),
      'type' => 'text',
      'required' => true,
      'placeholder' => '',
      'priority' => 1
  );
  return $fields;
}

// Add a line to the notifcation email with custom field
add_filter( 'apply_with_resume_email_message', 'wpjms_color_field_email_message', 10, 2 );
function wpjms_color_field_email_message( $message, $resume_id ) {
  $message[] = "\n" . "Favourite Color: " . get_post_meta( $resume_id, '_candidate_color', true );  
  return $message;
}

// Add your own function to filter the fields
add_filter( 'submit_resume_form_fields', 'custom_submit_resume_form_fields' );

// This is your function which takes the fields, modifies them, and returns them
function custom_submit_resume_form_fields( $fields ) {

    // Here we target one of the job fields (candidate name) and change it's label
    $fields['resume_fields']['candidate_name']['label'] = "The Candidate Name";

    // And return the modified fields
    return $fields;
}
