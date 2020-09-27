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
                'image' => get_template_directory_uri() . '/assets/img/160x160/img19.png',
            ),
            'facebook'  => array(
                'text'  => esc_html__( 'Facebook', 'front' ),
                'link'  => front_get_the_meta_data( '_company_facebook', null, 'company', true ),
                'image' => get_template_directory_uri() . '/assets/img/160x160/img20.png',
            ),
            'github'  => array(
                'text'  => esc_html__( 'Github', 'front' ),
                'link'  => front_get_the_meta_data( '_company_github', null, 'company', true ),
                'image' => get_template_directory_uri() . '/assets/img/160x160/img20.png',
            ),
            'documentation'  => array(
                'text'  => esc_html__( 'Documentation', 'front' ),
                'link'  => front_get_the_meta_data( '_company_documentation', null, 'company', true ),
                'image' => get_template_directory_uri() . '/assets/img/160x160/img20.png',
            ),
            'medium'  => array(
                'text'  => esc_html__( 'Medium', 'front' ),
                'link'  => front_get_the_meta_data( '_company_medium', null, 'company', true ),
                'image' => get_template_directory_uri() . '/assets/img/160x160/img20.png',
            ),
            'discord'  => array(
                'text'  => esc_html__( 'Discord', 'front' ),
                'link'  => front_get_the_meta_data( '_company_discord', null, 'company', true ),
                'image' => get_template_directory_uri() . '/assets/img/160x160/img20.png',
            ),
            'telegram'  => array(
                'text'  => esc_html__( 'Telegram', 'front' ),
                'link'  => front_get_the_meta_data( '_company_telegram', null, 'company', true ),
                'image' => get_template_directory_uri() . '/assets/img/160x160/img20.png',
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
  echo '<a title="Claim this project" href="mailto:'.get_bloginfo('admin_email').'?subject=Request to claim this project: '.$current_url.'" class="mt-5 btn btn-sm btn-primary transition-3d-hover">Claim this project</a>';
}

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


