<?php
/**
 * Front Child
 *
 * @package front-child
 */

/**
 * Include all your custom code here
 */

require(__DIR__.'/inc/functions-contributors.php');
require(__DIR__.'/inc/functions-projects.php');
require(__DIR__.'/inc/functions-home.php');

// Adds the child theme compiled assets
function cosmos_job_board_assets() {
  wp_enqueue_style( 'cosmos-job-board-stylesheet', get_stylesheet_directory_uri() . '/dist/css/main.css', array('front-style'), '1.0.0', 'all' );
  wp_enqueue_script( 'cosmos-job-board-scripts', get_stylesheet_directory_uri() . '/dist/js/main.js', array('jquery'), '1.0.0', true );
}
add_action('wp_enqueue_scripts', 'cosmos_job_board_assets');

// Here is where you unhook anything you want to unhook from the parent theme
function remove_parent_filters(){
  // Stuff goes in here // remove_filter
}
add_action( 'after_setup_theme', 'remove_parent_filters' );


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

// Prints out the handles of all style sheets and scripts
// function cosmos_print_scripts_styles() {
//   // Print all loaded Scripts
//   global $wp_scripts;
//   foreach( $wp_scripts->queue as $script ) :
//     echo $script . '  **  ';
//   endforeach;

//   // Print all loaded Styles (CSS)
//   global $wp_styles;
//   foreach( $wp_styles->queue as $style ) :
//     echo $style . '  ||  ';
//   endforeach;
// }

// add_action( 'wp_print_scripts', 'cosmos_print_scripts_styles' );



/**
 * Outputs the job listing class.
 *
 * @since 1.0.0
 * @param string      $class (default: '').
 * @param int|WP_Post $post_id (default: null).
 */
function cosmos_job_listing_class( $class = '', $post_id = null ) {
  // Separates classes with a single space, collates classes for post DIV.
  return 'class="' . esc_attr( join( ' ', cosmos_get_job_listing_class( $class, $post_id ) ) ) . '"';
}

/**
 * Gets the job listing class.
 *
 * @since 1.0.0
 * @param string      $class
 * @param int|WP_Post $post_id (default: null).
 * @return array
 */
function cosmos_get_job_listing_class( $class = '', $post_id = null ) {
  $post = get_post( $post_id );

  if ( empty( $post ) || 'job_listing' !== $post->post_type ) {
    return [];
  }

  $classes = [];

  if ( ! empty( $class ) ) {
    if ( ! is_array( $class ) ) {
      $class = preg_split( '#\s+#', $class );
    }
    $classes = array_merge( $classes, $class );
  }

  return get_post_class( $classes, $post->ID );
}
