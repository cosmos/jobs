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
require(__DIR__.'/inc/functions-jobs.php');

// Adds the child theme compiled assets
function cosmos_job_board_assets() {
  wp_enqueue_style( 'cosmos-job-board-stylesheet', get_stylesheet_directory_uri() . '/dist/css/main.css', array('front-style'), '1.0.0', 'all' );
  wp_enqueue_script( 'cosmos-job-board-scripts', get_stylesheet_directory_uri() . '/dist/js/main.js', array('jquery'), '1.0.0', true );
}
add_action('wp_enqueue_scripts', 'cosmos_job_board_assets');

function cosmos_job_board_admin_assets() {
  wp_enqueue_style( 'cosmos-admin-styles', get_stylesheet_directory_uri() . '/dist/css/admin.css');
}
add_action('admin_enqueue_scripts', 'cosmos_job_board_admin_assets');

// Redirects a user back to a page after login or registration
add_filter('woocommerce_login_redirect', 'cosmos_login_redirect', 10, 3);
add_filter('woocommerce_registration_redirect', 'cosmos_login_redirect', 10, 3);
function cosmos_login_redirect() {
  if ( (isset($_GET['action']) && $_GET['action'] != 'logout') || (isset($_POST['login_location']) && !empty($_POST['login_location'])) ) {
    $location = $_GET['action'];
    wp_safe_redirect($location);
    exit();
  }
}

// Removes unused roles
$wp_roles = new WP_Roles();
$wp_roles->remove_role("editor");
$wp_roles->remove_role("author");
$wp_roles->remove_role("contributor");
$wp_roles->remove_role("subscriber");
$wp_roles->remove_role("customer");
$wp_roles->remove_role("shop_manager");


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

// Gets the post ID outside of the loop
add_action('wp_enqueue_scripts', 'cosmos_get_post_id'); 
function cosmos_get_post_id() {
  global $post;
  return $post->ID;
}

// Gets all the projects
add_action('init', 'cosmos_get_projects'); 
function cosmos_get_projects() {
  $args = array(
    'post_type'               => 'company',
    'numberposts'             => -1,
    'post_status'             => 'publish',
    'orderby'                 => 'name',
    'order'                   => 'ASC'
  );
  $projects = get_posts($args);
  return $projects;
}

// Gets all the contributors
add_action('init', 'cosmos_get_contributors'); 
function cosmos_get_contributors() {
  $args = array(
    'post_type'               => 'resume',
    'numberposts'             => -1,
    'post_status'             => 'publish',
    'orderby'                 => 'name',
    'order'                   => 'ASC'
  );
  $contributors = get_posts($args);
  return $contributors;
}

// Adds the ability for project owners to be able to edit projects with other owners.
$edit_contributor = get_role('employer');
$edit_contributor->add_cap('edit_posts');
$edit_contributor->add_cap('edit_others_posts');

if ( ! function_exists( 'cosmos_header_user_account_submenu' ) ) {
    function cosmos_header_user_account_submenu() {
        $header_account_view = apply_filters( 'front_header_topbar_user_account_view', 'dropdown' );
        $my_account_page_url = get_permalink( get_option('woocommerce_myaccount_page_id') );
        $woocommerce = function_exists( 'front_is_woocommerce_activated' ) && front_is_woocommerce_activated();
        $job_manager = function_exists( 'front_is_wp_job_manager_activated' ) && front_is_wp_job_manager_activated();
        $job_resume_manager = function_exists( 'front_is_wp_resume_manager_activated' ) && front_is_wp_resume_manager_activated();
        $job_company_manager = function_exists( 'front_is_mas_wp_company_manager_activated' ) && front_is_mas_wp_company_manager_activated();
        ?>

        <div id="cosmos-account-dropdown" class="" aria-labelledby="account-dropdown-invoker">
            <?php
            if ( is_user_logged_in() ) {
                front_header_user_job_account_submenu();
                if ( $woocommerce ) {
                    front_user_account_nav_menu();
                }
                if ( ! $woocommerce ) {
                    ?>
                    <a class="dropdown-item" href="<?php echo esc_url( wp_logout_url() ); ?>">
                        <span class="fas fa-sign-out-alt dropdown-item-icon"></span><?php echo esc_html__( 'Logout', 'front' ); ?>
                    </a>
                    <?php
                }
            }
            else if ( $woocommerce ) {
                ?><div class="card"><?php
                    front_header_user_account_login_form();
                    front_header_user_account_register_form();
                    front_header_user_account_forget_password_form();
                ?></div><?php
            } else {
                front_header_user_account_job_login_form();
                front_header_user_account_job_register_form();
                front_header_user_account_job_forget_password_form();
            }
            ?>
        </div><?php
    }
}

// Sends email when a listing is approved https://wpjobmanager.com/document/tutorial-send-email-employer-job-listing-approved/
function listing_published_send_email($post_id) {
  if( 'job_listing' != get_post_type( $post_id ) ) {
    return;
  }
  $post = get_post($post_id);
  $author = get_userdata($post->post_author);

  $message = "
    Hi ".$author->display_name.",
    Your listing, ".$post->post_title." has just been approved at ".get_permalink( $post_id ).". Well done!
  ";
  wp_mail($author->user_email, "Your job listing is online", $message);
}
add_action('pending_to_publish', 'listing_published_send_email');
add_action('pending_payment_to_publish', 'listing_published_send_email');

// Sends an email when a resume is approved https://wpjobmanager.com/document/tutorial-send-email-employer-job-listing-approved/
function resume_published_send_email($post_id) {
   if( 'resume' != get_post_type( $post_id ) ) {
    return;
  }
   $post = get_post($post_id);
   $author = get_userdata($post->post_author);

   $message = "
      Hi ".$author->display_name.",
      Your contributor profile, ".$post->post_title." has just been approved at ".get_permalink( $post_id ).". Well done!
   ";
   wp_mail($author->user_email, "Your contributor profile is online", $message);
}
add_action('pending_to_publish', 'resume_published_send_email');
add_action('pending_payment_to_publish', 'resume_published_send_email');

// Sends an email when a resume expires https://wpjobmanager.com/document/tutorial-send-email-employer-job-listing-approved/
function resume_expired_send_email( $new_status, $old_status, $post ) {
    if ( 'resume' !== $post->post_type || 'expired' !== $new_status || $old_status === $new_status ) {
        return;
    }
    $author = get_userdata( $post->post_author );
 
    $message = "
        Hi " . $author->display_name . ",
        Your contributor profile, " . $post->post_title . " has now expired: " . get_permalink( $post_id );
    wp_mail( $author->user_email, "Your job resume has expired", $message );
}
add_action( 'transition_post_status', 'resume_expired_send_email', 10, 3 );

// Block non-administrators from accessing the WordPress back-end
function wpabsolute_block_users_backend() {
  if ( is_admin() && ! current_user_can( 'administrator' ) && ! wp_doing_ajax() ) {
    wp_redirect( home_url('/my-account/') );
    exit;
  }
}
add_action( 'init', 'wpabsolute_block_users_backend' );

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