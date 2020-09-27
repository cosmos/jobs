<?php
// Add your own function to filter the fields
add_filter( 'submit_resume_form_fields', 'resume_file_required' );

// This is your function which takes the fields, modifies them, and returns them
function resume_file_required( $fields ) {

    // Here we target one of the job fields (candidate name) and change it's label
    $fields['resume_fields']['resume_content']['required'] = false;
		$fields['resume_fields']['candidate_name']['label'] = "The Candidate Name";

    // And return the modified fields
    return $fields;
}

// // Add a line to the notifcation email with custom field
// add_filter( 'apply_with_resume_email_message', 'wpjms_color_field_email_message', 10, 2 );
// function wpjms_color_field_email_message( $message, $resume_id ) {
//   $message[] = "\n" . "Favourite Color: " . get_post_meta( $resume_id, '_candidate_color', true );  
//   return $message;
// }

// // Add your own function to filter the fields
// add_filter( 'submit_resume_form_fields', 'custom_submit_resume_form_fields' );

// // This is your function which takes the fields, modifies them, and returns them
// function custom_submit_resume_form_fields( $fields ) {

//     // Here we target one of the job fields (candidate name) and change it's label
//     $fields['resume_fields']['candidate_name']['label'] = "The Candidate Name";

//     // And return the modified fields
//     return $fields;
// }
