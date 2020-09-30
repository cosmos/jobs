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
require(__DIR__.'/inc/functions-woocommerce-registration-fields.php');
require(__DIR__.'/inc/functions-woocommerce-my-account-menu-items.php');

// Adds the child theme compiled assets
function cosmos_job_board_assets() {
  wp_enqueue_style( 'cosmos-job-board-stylesheet', get_stylesheet_directory_uri() . '/dist/css/main.css', array('front-style'), '1.0.0', 'all' );
  wp_enqueue_script( 'cosmos-job-board-scripts', get_stylesheet_directory_uri() . '/dist/js/main.js', array('jquery'), '1.0.0', true );
}
add_action('wp_enqueue_scripts', 'cosmos_job_board_assets');

// Redirects a user back to a page after login or registration
add_filter('woocommerce_login_redirect', 'cosmos_login_redirect', 10, 3);
add_filter('woocommerce_registration_redirect', 'cosmos_login_redirect', 10, 3);
if ( (isset($_GET['action']) && $_GET['action'] != 'logout') || (isset($_POST['login_location']) && !empty($_POST['login_location'])) ) {
  function cosmos_login_redirect() {
    $location = $_GET['action'];
    wp_safe_redirect($location);
    exit();
  }
}

// Outputs the job listing class.
function cosmos_job_listing_class( $class = '', $post_id = null ) {
  // Separates classes with a single space, collates classes for post DIV.
  return 'class="' . esc_attr( join( ' ', cosmos_get_job_listing_class( $class, $post_id ) ) ) . '"';
}

// Gets the job listing class.
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

// Gets the postt ID outside of the loop
add_action('wp_enqueue_scripts', 'cosmos_get_post_id'); 
function cosmos_get_post_id() {
  global $post;
  return $post->ID;
}

// foreach (cosmos_get_projects() as $key => $value) {
//   var_dump($value->post_title);
// }

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