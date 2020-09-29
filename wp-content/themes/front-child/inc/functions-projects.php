<?php





// Get logos for the additional fields I added then delete this comment.








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

add_filter( 'submit_company_form_fields', 'cosmos_frontend_company_form_fields' );
function cosmos_frontend_company_form_fields( $fields ) {
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
  return $fields;
}

// Add fields to Projects on the backend
add_filter( 'company_manager_company_fields', 'wpjms_admin_projects_form_fields' );
function wpjms_admin_projects_form_fields( $fields ) {
  $i = 10;
  foreach ($fields as $key => $value) {
    $fields[$key] = array(
        'label'     => __( $value['label'], 'job_manager' ),
        'type'      => $value['type'],
        'placeholder'   => __( $value['placeholder'], 'job_manager' ),
        'description' => $value['description'],
        'priority' => $i,
    );
    $i = $i + 10;
  }
  $fields['_company_github'] = array(
      'label'     => __( 'Github', 'job_manager' ),
      'type'      => 'text',
      'placeholder'   => __( 'https://github.com/', 'job_manager' ),
      'description' => 'Full URL',
      'priority' => 80,
  );
  $fields['_company_documentation'] = array(
      'label'     => __( 'Documentation', 'job_manager' ),
      'type'      => 'text',
      'placeholder'   => __( 'https://', 'job_manager' ),
      'description' => 'Full URL',
      'priority' => 81,
  );
  $fields['_company_medium'] = array(
      'label'     => __( 'Medium', 'job_manager' ),
      'type'      => 'text',
      'placeholder'   => __( 'https://medium.com/', 'job_manager' ),
      'description' => 'Full URL',
      'priority' => 82,
  );
  $fields['_company_discord'] = array(
      'label'     => __( 'Discord', 'job_manager' ),
      'type'      => 'text',
      'placeholder'   => __( 'https://discord.com/', 'job_manager' ),
      'description' => 'Full URL',
      'priority' => 83,
  );
  $fields['_company_telegram'] = array(
      'label'     => __( 'Telegram', 'job_manager' ),
      'type'      => 'text',
      'placeholder'   => __( 'https://telegram.org/', 'job_manager' ),
      'description' => 'Full URL',
      'priority' => 84,
  );
  return $fields;
}

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

// Adds a link to claim a project profile
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

// Gets the contributors attributed to a project
add_action('single_company_sidebar','cosmos_contributors_attributed_to_a_project', 30 );
function cosmos_contributors_attributed_to_a_project() {
  global $wpdb;
  $html = '<div class="border-top pt-5 mt-5">';
  $title = '<h4 class="font-size-1 font-weight-semi-bold text-uppercase mb-3">Contributors to this project</h4>';
  $all_authors = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}term_taxonomy WHERE taxonomy = 'author'", OBJECT );
  $term_relationships = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}term_relationships WHERE object_id = '".cosmos_get_post_id()."'", OBJECT );
  foreach ($term_relationships as $key => $value) {
    foreach ($all_authors as $key2 => $value2) {
      if ($value->term_taxonomy_id == $value2->term_taxonomy_id) {
        $pattern = '/([a-z0-9_\.\-])+\@(([a-z0-9\-])+\.)+([a-z0-9]{2,4})+/i';
        preg_match_all($pattern, $value2->description, $matches);
        $email_addresses[] = $matches[0][0];
      }
    }
  }
  foreach ($email_addresses as $key => $value) {
    $post_id = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}postmeta WHERE meta_key = '_candidate_email' AND meta_value = '".$value."'", OBJECT );
    if (!empty($post_id)) {
      ++$i;
      $contributor_name = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}postmeta WHERE meta_key = '_candidate_name' AND post_id = '".$post_id[0]->post_id."'", OBJECT );
      if ($i == 1) {
        $html .= $title;
      }
      $html .= '<a href="'.home_url().'/resume/'.get_post($post_id[0]->post_id)->post_name.'" class="btn btn-soft-primary btn-xs mb-3 mr-3 transition-3d-hoverbtn transition-3d-hover" >';
        $html .= $contributor_name[0]->meta_value;
      $html .= '</a>';
    }
  }
  $html .= '</div>';
  echo $html;
}












