<?php
// Edits the labels of the RESUME post_type and of it's taxonomies(2)
add_action( 'wp_loaded', 'change_company_labels', 20 );
function change_company_labels()
{
  $p_object = get_post_type_object( 'company' );

  if ( ! $p_object )
  return FALSE;
  // see get_post_type_labels()
  $p_object->labels->name               = 'Projects';
  $p_object->labels->singular_name      = 'Project';
  $p_object->labels->add_new            = 'Add project';
  $p_object->labels->add_new_item       = 'Add new project';
  $p_object->labels->all_items          = 'All projects';
  $p_object->labels->edit_item          = 'Edit project';
  $p_object->labels->name_admin_bar     = 'Project';
  $p_object->labels->menu_name          = 'Projects';
  $p_object->labels->new_item           = 'New project';
  $p_object->labels->not_found          = 'No projects found';
  $p_object->labels->not_found_in_trash = 'No projects found in trash';
  $p_object->labels->search_items       = 'Search projects';
  $p_object->labels->view_item          = 'View project';

  return TRUE;
}

// Add fields to Projects on the frontend
add_filter( 'submit_company_form_fields', 'cosmos_frontend_company_form_fields' );
function cosmos_frontend_company_form_fields( $fields ) {
  foreach (cosmos_get_contributors() as $key => $value) {
    $contributors[$value->ID] = $value->post_title;
  }
  $fields['company_fields']['company_github'] = array(
      'label' => __( 'Github', 'job_manager' ),
      'type' => 'text',
      'required' => false,
      'placeholder'   => __( 'https://github.com/', 'job_manager' ),
      'priority' => 60
  );
  $fields['company_fields']['company_documentation'] = array(
      'label' => __( 'Documentation', 'job_manager' ),
      'type' => 'text',
      'required' => false,
      'placeholder'   => __( 'https://', 'job_manager' ),
      'priority' => 60
  );
  $fields['company_fields']['company_medium'] = array(
      'label' => __( 'Medium', 'job_manager' ),
      'type' => 'text',
      'required' => false,
      'placeholder'   => __( 'https://medium.com', 'job_manager' ),
      'priority' => 60
  );
  $fields['company_fields']['company_discord'] = array(
      'label' => __( 'Discord', 'job_manager' ),
      'type' => 'text',
      'required' => false,
      'placeholder'   => __( 'https://discord.com', 'job_manager' ),
      'priority' => 60
  );
  $fields['company_fields']['company_telegram'] = array(
      'label' => __( 'Telegram', 'job_manager' ),
      'type' => 'text',
      'required' => false,
      'placeholder'   => __( 'https://telegram.org', 'job_manager' ),
      'priority' => 60
  );
  $fields['company_fields']['contributors_contributed_to'] = array(
    'label'         => __( 'Contributors that have contributed to this project', 'job_manager' ),
    'type'          => 'multiselect',
    'options'       => $contributors,
    'required'      => false,
    'placeholder'   => '',
    'priority'      => 60,
    'personal_data' => true,
  );
  return $fields;
}

// Add fields to Projects on the backend
add_filter( 'company_manager_company_fields', 'wpjms_admin_projects_form_fields' );
function wpjms_admin_projects_form_fields( $fields ) {
  $i = 10;
  // Gets all the contributors
  foreach (cosmos_get_contributors() as $key => $value) {
    $contributors[$value->ID] = $value->post_title;
  }
  $fields['_company_github'] = array(
    'label'         => __( 'Github', 'job_manager' ),
    'type'          => 'text',
    'placeholder'   => __( 'https://github.com/', 'job_manager' ),
    'description'   => 'Full URL',
    'priority'      => 80,
  );
  $fields['_company_documentation'] = array(
    'label'         => __( 'Documentation', 'job_manager' ),
    'type'          => 'text',
    'placeholder'   => __( 'https://', 'job_manager' ),
    'description'   => 'Full URL',
    'priority'      => 81,
  );
  $fields['_company_medium'] = array(
    'label'         => __( 'Medium', 'job_manager' ),
    'type'          => 'text',
    'placeholder'   => __( 'https://medium.com/', 'job_manager' ),
    'description'   => 'Full URL',
    'priority'      => 82,
  );
  $fields['_company_discord'] = array(
    'label'         => __( 'Discord', 'job_manager' ),
    'type'          => 'text',
    'placeholder'   => __( 'https://discord.com/', 'job_manager' ),
    'description'   => 'Full URL',
    'priority'      => 83,
  );
  $fields['_company_telegram'] = array(
    'label'         => __( 'Telegram', 'job_manager' ),
    'type'          => 'text',
    'placeholder'   => __( 'https://telegram.org/', 'job_manager' ),
    'description'   => 'Full URL',
    'priority'      => 84,
  );
  $fields['_contributors_contributed_to'] = array(
    'label'         => __( 'Contributors that have contributed to this project', 'job_manager' ),
    'type'          => 'multiselect',
    'options'       => $contributors,
    'required'      => false,
    'placeholder'   => '',
    'priority'      => 85,
    'personal_data' => true,
  );
  $fields['_company_logo'] = array(
    'label'         => __( 'Project Logo', 'job_manager' ),
    'type'          => 'file',
    'placeholder'   => __( '', 'job_manager' ),
    'description'   => '',
    'priority'      => 70,
  );
  return $fields;
}

// Add the additional project logos
add_action( 'single_company_sidebar', 'cosmos_single_company_linked_accounts', 30 );
add_action( 'after_setup_theme', 'cosmos_remove_front_single_company_linked_accounts');
function cosmos_remove_front_single_company_linked_accounts() {
  remove_action( 'single_company_sidebar', 'front_single_company_linked_accounts', 30 );
}
if( ! function_exists( 'cosmos_single_company_linked_accounts' ) ) {
    function cosmos_single_company_linked_accounts() {
        $args = apply_filters( 'front_single_company_linked_accounts_args', array(
            'website'   => array(
                'text'  => get_the_title(),
                'link'  => front_get_the_meta_data( '_company_website', null, 'company', true ),
                'image' => get_the_company_logo( null, 'thumbnail') ? get_the_company_logo( null, 'thumbnail') : apply_filters( 'job_manager_default_company_logo', JOB_MANAGER_PLUGIN_URL . '/assets/images/company.png' ),
            ),
            'twitter'   => array(
                'text'  => esc_html__( 'Twitter', 'front' ),
                'link'  => front_get_the_meta_data( '_company_twitter', null, 'company', true ),
                'image' => get_stylesheet_directory_uri() . '/dist/img/160x160/twitter.png',
            ),
            'facebook'  => array(
                'text'  => esc_html__( 'Facebook', 'front' ),
                'link'  => front_get_the_meta_data( '_company_facebook', null, 'company', true ),
                'image' => get_stylesheet_directory_uri() . '/dist/img/160x160/facebook.png',
            ),
            'github'  => array(
                'text'  => esc_html__( 'Github', 'front' ),
                'link'  => front_get_the_meta_data( '_company_github', null, 'company', true ),
                'image' => get_stylesheet_directory_uri() . '/dist/img/160x160/github.png',
            ),
            'documentation'  => array(
                'text'  => esc_html__( 'Documentation', 'front' ),
                'link'  => front_get_the_meta_data( '_company_documentation', null, 'company', true ),
                'image' => get_stylesheet_directory_uri() . '/dist/img/160x160/documentation.png',
            ),
            'medium'  => array(
                'text'  => esc_html__( 'Medium', 'front' ),
                'link'  => front_get_the_meta_data( '_company_medium', null, 'company', true ),
                'image' => get_stylesheet_directory_uri() . '/dist/img/160x160/medium.png',
            ),
            'discord'  => array(
                'text'  => esc_html__( 'Discord', 'front' ),
                'link'  => front_get_the_meta_data( '_company_discord', null, 'company', true ),
                'image' => get_stylesheet_directory_uri() . '/dist/img/160x160/discord.png',
            ),
            'telegram'  => array(
                'text'  => esc_html__( 'Telegram', 'front' ),
                'link'  => front_get_the_meta_data( '_company_telegram', null, 'company', true ),
                'image' => get_stylesheet_directory_uri() . '/dist/img/160x160/telegram.png',
            ),
        ) );
        
        if( is_array( $args ) && count( $args ) > 0 ) {
            if( ! empty( front_single_get_linked_accounts_content( $args ) ) ) {
                ?>
                <div class="border-top pt-5 mt-5">
                    <h4 class="font-size-1 font-weight-semi-bold text-uppercase mb-3"><?php esc_html_e( 'Linked Accounts', 'front' ); ?></h4>
                    <?php echo front_single_get_linked_accounts_content( $args ); ?>
                </div>
                <?php
            }
        }
    }
}

// Adds a button to claim a project profile
add_action( 'single_company_sidebar', 'cosmos_add_project_claim_link', 40);
function cosmos_add_project_claim_link() {
  global $wp;
  $current_url = home_url( add_query_arg( array(), $wp->request ) );
  $html = null;
  if (is_user_logged_in()) {
    $html .= '<form action="'.get_stylesheet_directory_uri().'/inc/claim-project-email-form.php" method="post" id="claim_this_project_form" class="mt-5 text-center border-top pt-5">';
      $html .= '<div class="row">';
        $html .= '<div class="col-12">';
          $html .= '<div class="alert alert-success contact__msg text-center" style="display: none" role="alert">';
            $html .= 'You have successfully requested to claim this project.';
          $html .= '</div>';
        $html .= '</div>';
      $html .= '</div>';
      $html .= '<input type="hidden" name="project" id="project" value="'.$current_url.'" />';
      $html .= '<input type="hidden" name="user_email" id="user_email" value="'.wp_get_current_user()->data->user_email.'" />';
      $html .= '<input type="hidden" name="name" id="name" value="'.wp_get_current_user()->data->display_name.'" />';
      $html .= '<input type="hidden" name="mailto" id="mailto" value="'.get_bloginfo('admin_email').'" />';
      $html .= '<button name="submit" type="submit" id="submit" class="btn btn-sm btn-primary transition-3d-hoverbtn btn-sm btn-primary transition-3d-hover">Claim this project</button>';
    $html .= '</form>';
    
  } else {
      $html .= '<a href="'.home_url().'/my-account/?action='.$current_url.'" class="btn btn-sm btn-primary transition-3d-hoverbtn btn-sm btn-primary transition-3d-hover mt-5">Create account to claim this project</a>';    
  }
  echo $html;
}

// Changes the h2 header on the single project page
add_action( 'single_company_content', 'cosmos_single_company_description', 10 );
add_action( 'after_setup_theme', 'cosmos_remove_single_company_description');
function cosmos_remove_single_company_description() {
  remove_action( 'single_company_content', 'front_single_company_description', 10 );
}
if( ! function_exists( 'cosmos_single_company_description' ) ) {
  function cosmos_single_company_description() {
    if( !empty( get_the_content() ) ) : 
      ?>
      <div class="mb-4">
        <h2 class="h5"><?php esc_html_e( 'About Project', 'front' ) ?></h2>
      </div>
      <div class="border-bottom pb-5 mb-5">
        <?php the_content(); ?>
      </div>
      <?php
    endif;
  }
}

// Remove the comment section of the project page
add_action( 'after_setup_theme', 'cosmos_remove_project_comments');
function cosmos_remove_project_comments() {
  remove_action( 'single_company_content', 'front_single_company_comment', 20 );
}

// Gets the owners attributed to a project
// TAS removed per VLBETA
// add_action('single_company_sidebar','cosmos_owners_attributed_to_a_project', 30 );
// function cosmos_owners_attributed_to_a_project() {
//   global $wpdb;
//   $html = null;
//   $i = 0;
//   $all_authors = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}term_taxonomy WHERE taxonomy = 'author'", OBJECT );
//   $term_relationships = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}term_relationships WHERE object_id = '".cosmos_get_post_id()."'", OBJECT );
//   if (is_object($term_relationships) || is_array($term_relationships)) {
//     foreach ($term_relationships as $key => $value) {
//       foreach ($all_authors as $key2 => $value2) {
//         if ($value->term_taxonomy_id == $value2->term_taxonomy_id) {
//           $pattern = '/([a-z0-9_\.\-])+\@(([a-z0-9\-])+\.)+([a-z0-9]{2,4})+/i';
//           preg_match_all($pattern, $value2->description, $matches);
//           $email_addresses[] = $matches[0][0];
//         }
//       }
//     }
//   }
//   if (!empty($email_addresses)) {
//     $html .= '<div class="border-top pt-5 mt-5">';
//     $html .= '<h4 class="font-size-1 font-weight-semi-bold text-uppercase mb-3">Project owners</h4>';
//     foreach ($email_addresses as $key => $value) {
//       $post_id = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}postmeta WHERE meta_key = '_candidate_email' AND meta_value = '".$value."'", OBJECT );
//       if (!empty($post_id)) {
//         ++$i;
//         $contributor_name = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}postmeta WHERE meta_key = '_candidate_name' AND post_id = '".$post_id[0]->post_id."'", OBJECT );
//         if ($i == 1) {
//           $html .= $title;
//         }
//         $html .= '<a href="'.home_url().'/resume/'.get_post($post_id[0]->post_id)->post_name.'" class="btn btn-soft-primary btn-xs mb-3 mr-3 transition-3d-hoverbtn btn-pill transition-3d-hover" >';
//           $html .= $contributor_name[0]->meta_value;
//         $html .= '</a>';
//       }
//     } 
//     $html .= '</div>';
//   }
//   echo $html;
// }

// Gets the contributors attributed to a project - PILLS
// TAS removed per VLBETA in favor for CARDS below add_action('single_company_sidebar','cosmos_contributors_attributed_to_a_project_pills', 30 );
// function cosmos_contributors_attributed_to_a_project_pills() {
//   global $wpdb;
//   $html = null;
  // $contributors = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}postmeta WHERE post_id = '".cosmos_get_post_id()."' AND meta_key = '_contributors_contributed_to'", OBJECT );
  // $contributors = unserialize($contributors[0]->meta_value);
//   if (!empty($contributors)) {
//     $html .= '<div class="border-top pt-5 mt-5">';
//     $html .= '<h4 class="font-size-1 font-weight-semi-bold text-uppercase mb-3">Project contributors</h4>';
//     foreach ($contributors as $key => $value) {
//       $html .= '<a href="'.home_url().'/resume/'.get_post($value)->post_name.'" class="btn btn-soft-primary btn-xs mb-3 mr-3 transition-3d-hoverbtn btn-pill transition-3d-hover" >';
//         $html .= get_post($value)->post_title;
//       $html .= '</a>';
//     }
//     $html .= '</div>';
//   }
//   echo $html;
// } 

// Gets the contributors attributed to a project - CARDS
add_action('single_company_content','cosmos_contributors_attributed_to_a_project_cards', 15);
function cosmos_contributors_attributed_to_a_project_cards() {
  global $wpdb;
  $html = null;
  $contributors = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}postmeta WHERE post_id = '".cosmos_get_post_id()."' AND meta_key = '_contributors_contributed_to'", OBJECT );
  $logos = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}postmeta WHERE meta_key = '_company_logo'", OBJECT );
  //var_dump($contributors);
  $contributors = unserialize($contributors[0]->meta_value);
  if (!empty($contributors)) {
    $html .= '<div class="border-top pt-5 mt-5 border-bottom pb-2 mb-5">';
      $html .= '<h2 class="h5 mb-3">Contributors to the '.get_the_title().' project</h2>';
      $html .= '<div class="row">';
        foreach ($contributors as $key => $value) {
          $html .= '<div class="col-md-6 mb-5">';
            $html .= '<div class="card card-frame transition-3d-hover p-0">';
              $html .= '<a href="'.home_url().'/resume/'.get_post($value)->post_name.'">';
                $html .= '<div class="media p-3">'; 
                  $html .= '<div class="btn btn-lg btn-icon btn-soft-primary rounded-circle mb-3 image-cropper" style="word-break: initial;">';
                    $html .= front_the_candidate_photo( 'thumbnail', 'img-fluid profile-pic', '', $value, false );
                  $html .= '</div>';
                  $html .= '<div class="media-body px-4">';
                    $html .= '<h4 class="h6 text-dark mb-1">'.get_post($value)->post_title.'</h4>';
                    $html .= '<small class="d-block text-muted">';
                      $html .= get_post_meta($value, '_candidate_location')[0];
                      $html .= '<br>';
                      $html .= wp_kses_post( sprintf( __( 'Joined %s', 'front' ), get_post_time( 'M Y' ) ) );
                    $html .= '</small>';
                      // $html .= '<a href="'.home_url().'/company/'.get_post($value)->post_name.'" class="btn btn-soft-primary btn-xs transition-3d-hover btn btn-pill transition-3d-hover">View Project</a>';
                  $html .= '</div>';
                $html .= '</div>';
              $html .= '</a>';
            $html .= '</div>';
          $html .= '</div>';
        }
      $html .= '</div>';
    $html .= '</div>';
  }
  echo $html;
}

// Adds multi select pills to the company profile page
if ( ! function_exists( 'mas_wpjmc_enhanced_select_enabled' ) ) {
  function mas_wpjmc_enhanced_select_enabled( $enabled ) {
    if ( has_wpjm_shortcode( null, [ 'mas_submit_company_form', 'mas_company_dashboard' ] ) ) {
      $enabled = true;
    }
    return $enabled;
  }
}
add_filter( 'job_manager_enhanced_select_enabled' , 'mas_wpjmc_enhanced_select_enabled' );

if ( ! function_exists( 'mas_wpjmc_job_manager_shortcodes' ) ) {
  function mas_wpjmc_job_manager_shortcodes( $shortcodes ) {
    $shortcodes = array_unique( array_merge( $shortcodes, [ 'mas_submit_company_form', 'mas_company_dashboard' ] ) );
    return $shortcodes;
  }
}
add_filter( 'job_manager_shortcodes' , 'mas_wpjmc_job_manager_shortcodes' );

// changes the front end form labels on the project page
function cosmos_customize_submit_project_form_fields( $fields ) {
  $fields['company_fields']['company_name']['label'] = "Project Name";
  $fields['company_fields']['company_name']['placeholder'] = "Project Name";
  $fields['company_fields']['company_tagline']['label'] = "Project Tagline";
  $fields['company_fields']['company_location']['label'] = "Project Location";
  $fields['company_fields']['company_location']['description'] = "";
  $fields['company_fields']['company_location']['placeholder'] = "e.g. \"San Francisco, CA USA\"";
  $fields['company_fields']['company_tagline']['placeholder'] = "Project Tagline";
  $fields['company_fields']['company_logo']['label'] = "Project Logo";
  $fields['company_fields']['company_video']['placeholder'] = "A link to a video about the project";
  $fields['company_fields']['company_website']['label'] = "Project Website";
  $fields['company_fields']['company_website']['placeholder'] = "Project Website";
  $fields['company_fields']['company_website']['placeholder'] = "Project Website";
  $fields['company_fields']['company_facebook']['placeholder'] = "https://facebook.com/";
  $fields['company_fields']['company_revenue']['label'] = "Project Revenue";
  $fields['company_fields']['company_content']['label'] = "Project Content";
  unset( $fields['company_fields']['company_strength'] );
  unset( $fields['company_fields']['company_average_salary'] );
  unset( $fields['company_fields']['company_revenue'] );
  return $fields;
}
add_filter( 'submit_company_form_fields', 'cosmos_customize_submit_project_form_fields', 30 );

// changes the front end form labels on the project page
function cosmos_customize_submit_project_form_fields2( $fields ) {
  $fields['company']['company_name']['label'] = "Project Name";
  $fields['company']['company_name']['placeholder'] = "Enter the name of the project";
  $fields['company']['company_website']['label'] = "Project Website";
  $fields['company']['company_video']['label'] = "Project Video";
  $fields['company']['company_video']['placeholder'] = "A link to a video about your company";
  $fields['company']['company_twitter']['label'] = "Twitter";
  $fields['company']['company_logo']['label'] = "Logo";
  $fields['company']['company_about']['label'] = "About Project";
  $fields['company']['company_about']['placeholder'] = "Short description about the project";
  unset( $fields['company']['company_name'] );
  unset( $fields['company']['company_website'] );
  unset( $fields['company']['company_video'] );
  unset( $fields['company']['company_twitter'] );
  unset( $fields['company']['company_logo'] );
  unset( $fields['company']['company_about'] );
  return $fields;
}
add_filter( 'submit_job_form_fields', 'cosmos_customize_submit_project_form_fields2', 30 );

// Changes the job submit fields on the front end
add_action( 'after_setup_theme', 'cosmos_customize_submit_job_form_fields_filter');
function cosmos_customize_submit_job_form_fields_filter() {
  add_filter( 'submit_job_form_fields', 'cosmos_customize_submit_job_form_fields' );
}
function cosmos_customize_submit_job_form_fields( $fields ) {
  unset( $fields['resume_fields']['resume_category'] );
  unset( $fields['job']['contact_email'] );
  unset( $fields['job']['contact_address'] );
  unset( $fields['job']['application'] );
  unset( $fields['job']['contact_phone'] );
  unset( $fields['job']['job_qualification'] );
  unset( $fields['job']['job_listing_salary'] );
  unset( $fields['job']['job_listing_project_length'] );
  unset( $fields['job']['job_listing_working_environment'] );
  unset( $fields['job']['job_tags'] );
  unset( $fields['job']['job_deadline'] );
  $fields['job']['job_category']['priority'] = 3;
  $fields['job']['job_location']['placeholder'] = "e.g. \"San Francisco, CA USA\"";
  $fields['job']['job_location']['description'] = "Leave this blank if the possition is remote";
  $fields['job']['job_listing_skills']['placeholder'] = "Relevant skills";
  $fields['job']['job_listing_skills']['description'] = "List of relevant skills, use comma to separate";
  $fields['job']['job_description']['label'] = "Full Description";
  $fields['company']['company_id']['label'] = "Select A Project";
  $fields['company']['company_id']['option'] = "Select A Project";
  return $fields;
}

// Removes the LOCATION field from project search
if ( ! function_exists( 'front_companies_header_search_form' ) ) {
    /**
     * Display Companies Header Search Form
     */
    function front_companies_header_search_form( $args = array() ) {

        $defaults =  apply_filters( 'front_companies_header_search_form_default_args', array(
            'keywords_title_text'       => esc_html__( 'Company name or job title', 'front' ),
            'keywords_placeholder_text' => esc_html__( 'Company or title', 'front' ),
            'location_title_text'       => esc_html__( 'City, state, or zip', 'front' ),
            'location_placeholder_text' => esc_html__( 'City, state, or zip', 'front' ),
            'search_button_text'        => esc_html__( 'Search', 'front' ),
            'background_color'          => 'bg-light',
            'current_page_url'          => '',
            'enable_container'          => true,
        ) );

        $args = wp_parse_args( $args, $defaults );

        extract( $args );

        $current_page_url = ! empty($current_page_url) ? $current_page_url : MAS_WPJMC::get_current_page_url();
        $current_page_query_args = MAS_WPJMC::get_current_page_query_args();

        ?>
        <div class="company-filters<?php echo esc_attr( !empty( $background_color ) ? ' ' . $background_color : '' ); ?>">
            <div class="<?php echo esc_attr( !empty( $enable_container ) ? 'container space-2' : '' ); ?>">
                <!-- Search Jobs Form -->
                <form class="company_filters" action="<?php echo esc_attr( $current_page_url ); ?>">
                    <?php do_action( 'mas_job_manger_company_header_search_block_start' ); ?>
                    <div class="search_companies row mb-2">
                        <?php do_action( 'mas_job_manger_company_header_search_block_search_companies_start' ); ?>

                        <div class="search_keywords col-lg-10 mb-4 mb-lg-0">
                            <!-- Input -->
                            <label for="search_keywords" class="d-block">
                                <span class="h6 d-block text-dark font-weight-semi-bold mb-0"><?php echo esc_html( $args['keywords_title_text'] ) ?></span>
                            </label>
                            <div class="js-focus-state">
                                <div class="input-group">
                                    <input type="text" name="s" id="search_keywords" class="form-control" placeholder="<?php echo esc_attr( $args['keywords_placeholder_text'] ) ?>" aria-label="<?php echo esc_attr( $args['keywords_placeholder_text'] ) ?>" aria-describedby="keywordInputAddon" value="<?php echo get_search_query(); ?>" />
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                        <span class="fas fa-search" id="keywordInputAddon"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <!-- End Input -->
                        </div>
                        <div class="search_submit col-lg-2 align-self-lg-end">
                            <button type="submit" class="btn btn-block btn-primary transition-3d-hover">
                                <?php echo esc_html( $search_button_text ); ?>
                            </button>
                        </div>
                        <input type="hidden" name="paged" value="1" />
                        <?php 
                        if( is_array( $current_page_query_args ) && !empty(  $current_page_query_args  ) ) :
                            foreach ( $current_page_query_args as $key => $current_page_query_arg ) :
                                if( $key != 'search_keywords' && $key != 'search_location'  ) :
                                    ?><input type="hidden" name="<?php echo esc_attr( $key ); ?>" value="<?php echo esc_attr( $current_page_query_arg ); ?>" ><?php
                                endif;
                            endforeach;
                        endif;
                        ?>

                        <?php do_action( 'mas_job_manger_company_header_search_block_search_companies_end' ); ?>
                    </div>
                    <?php do_action( 'mas_job_manger_company_header_search_block_end' ); ?>
                    <!-- End Checkbox -->
                </form>
                <!-- End Search Jobs Form -->
            </div>
        </div>
        <?php
    }
}

// Lists the open jobs on the project page
if( ! function_exists( 'mas_wpjmc_single_company_job_listings' ) ) {
    function mas_wpjmc_single_company_job_listings() {
        global $post;
        $company_jobs = mas_wpjmc_get_the_company_job_listing();

        if( count( $company_jobs ) ) :
            ?>
              <div class="col-md-12">
                <div class="mas-company-jobs"><?php
                  ?><h2 class="mas-company-jobs__title h5"><?php
                      echo apply_filters( 'mas_wpjmc_company_jobs_title', esc_html__( 'Jobs by project', 'mas-wp-job-manager-company' ) );
                  ?></h2><?php

                  get_job_manager_template( 'job-listings-start.php' );

                  foreach( $company_jobs as $post ) :
                      setup_postdata($post);
                      do_action( 'job_listing_loop' );

                      get_job_manager_template_part( 'content-job_listing' );

                  endforeach; // End of the loop. 
                  wp_reset_postdata();

                  get_job_manager_template( 'job-listings-end.php' );
              ?>
                </div>
              </div>
              <?php
        endif;
    }
}
add_action( 'single_company', 'mas_wpjmc_single_company_job_listings', 50 );





