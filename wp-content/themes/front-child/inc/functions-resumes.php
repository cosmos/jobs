<?php
// Add your own function to filter the fields
add_filter( 'submit_resume_form_fields', 'resume_file_required' );

// This is your function which takes the fields, modifies them, and returns them
function resume_file_required( $fields ) {

    // Here we target one of the job fields (candidate name) and change it's label
    $fields['resume_fields']['resume_content']['required'] = false;

    // And return the modified fields
    return $fields;
}