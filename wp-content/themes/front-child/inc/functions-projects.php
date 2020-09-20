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
  $fields['_candidate_github'] = array(
      'label'     => __( 'Github', 'job_manager' ),
      'type'      => 'text',
      'placeholder'   => __( 'https://github.com/', 'job_manager' ),
      'description' => 'Full URL',
      'priority' => 80,
  );
  $fields['_candidate_documentation'] = array(
      'label'     => __( 'Documentation', 'job_manager' ),
      'type'      => 'text',
      'placeholder'   => __( 'https://', 'job_manager' ),
      'description' => 'Full URL',
      'priority' => 81,
  );
  $fields['_candidate_medium'] = array(
      'label'     => __( 'Medium', 'job_manager' ),
      'type'      => 'text',
      'placeholder'   => __( 'https://medium.com/', 'job_manager' ),
      'description' => 'Full URL',
      'priority' => 82,
  );
  $fields['_candidate_discord'] = array(
      'label'     => __( 'Discord', 'job_manager' ),
      'type'      => 'text',
      'placeholder'   => __( 'https://discord.com/', 'job_manager' ),
      'description' => 'Full URL',
      'priority' => 83,
  );
  $fields['_candidate_telegram'] = array(
      'label'     => __( 'Telegram', 'job_manager' ),
      'type'      => 'text',
      'placeholder'   => __( 'https://telegram.org/', 'job_manager' ),
      'description' => 'Full URL',
      'priority' => 84,
  );
  return $fields;
}
