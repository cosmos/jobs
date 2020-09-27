<?php
// Edits the labels of the RESUME post_type and of it's taxonomies(2)
add_action( 'wp_loaded', 'change_resume_labels', 20 );

function change_resume_labels()
{
  $p_object = get_post_type_object( 'resume' );
  $t_object = get_taxonomy( 'resume_category' );
  $t2_object = get_taxonomy( 'resume_skill' );

  if ( ! $p_object && $t_object && $t2_object )
  return FALSE;
  // see get_post_type_labels()
  $p_object->labels->name               = 'Contributors';
  $p_object->labels->singular_name      = 'Contributor';
  $p_object->labels->add_new            = 'Add contributor';
  $p_object->labels->add_new_item       = 'Add new contributor';
  $p_object->labels->all_items          = 'All contributors';
  $p_object->labels->edit_item          = 'Edit contributor';
  $p_object->labels->name_admin_bar     = 'Contributor';
  $p_object->labels->menu_name          = 'Contributors';
  $p_object->labels->new_item           = 'New contributor';
  $p_object->labels->not_found          = 'No contributors found';
  $p_object->labels->not_found_in_trash = 'No contributors found in trash';
  $p_object->labels->search_items       = 'Search contributors';
  $p_object->labels->view_item          = 'View contributor';

  $t_object->labels->name               = 'Contributors categories';
  $t_object->labels->singular_name      = 'Contributor category';
  $t_object->labels->add_new            = 'Add contributor category';
  $t_object->labels->add_new_item       = 'Add new contributor category';
  $t_object->labels->all_items          = 'All contributors categories';
  $t_object->labels->edit_item          = 'Edit contributor category';
  $t_object->labels->name_admin_bar     = 'Contributor category';
  $t_object->labels->menu_name          = 'Contributor categories';
  $t_object->labels->new_item           = 'New contributor category';
  $t_object->labels->not_found          = 'No contributors categories found';
  $t_object->labels->not_found_in_trash = 'No contributors categories found in trash';
  $t_object->labels->search_items       = 'Search contributors categories';
  $t_object->labels->view_item          = 'View contributor category';

  $t2_object->labels->name               = 'Contributors skills';
  $t2_object->labels->singular_name      = 'Contributor skill';
  $t2_object->labels->add_new            = 'Add contributor skill';
  $t2_object->labels->add_new_item       = 'Add new contributor skill';
  $t2_object->labels->all_items          = 'All contributors skills';
  $t2_object->labels->edit_item          = 'Edit contributor skill';
  $t2_object->labels->name_admin_bar     = 'Contributor skill';
  $t2_object->labels->menu_name          = 'Contributor skills';
  $t2_object->labels->new_item           = 'New contributor skill';
  $t2_object->labels->not_found          = 'No contributors skills found';
  $t2_object->labels->not_found_in_trash = 'No contributors skills found in trash';
  $t2_object->labels->search_items       = 'Search contributors skills';
  $t2_object->labels->view_item          = 'View contributor skill';

  return TRUE;
}

// Edits the footer of a contributor on browse contributors
add_filter('resume_listing_list_content_area_after', 'cosmos_add_resume_listing_list_card_footer', 10);
add_action( 'after_setup_theme', 'cosmos_remove_resume_listing_list_content_area_after');
function cosmos_remove_resume_listing_list_content_area_after() {
  remove_action('resume_listing_list_content_area_after', 'front_resume_listing_list_card_footer', 10);
}

function cosmos_add_resume_listing_list_card_footer() {
  ob_start();
  $html = null;
  cosmos_resume_listing_list_card_footer_content();
  $footer_content = ob_get_clean();

  ob_start();
  do_action( 'resume_listing_list_card_footer_end' );
  $footer_end = ob_get_clean();

  if( ! empty( $footer_content ) || ! empty( $footer_end ) ) :
    $html .= '<div class="card-footer border-top-0 pt-0 px-4 pb-4">';
      $html .= '<div class="d-sm-flex align-items-sm-center">';
        $html .= wp_kses_post( $footer_content );
        $html .= wp_kses_post( $footer_end );
      $html .= '</div>';
    $html .= '</div>';
  endif;
  echo $html;
}

function cosmos_resume_listing_list_card_footer_content() {
  $args = apply_filters( 'front_resume_listing_list_card_footer_content_args', array(
    'candidate_location'    => array(
      'title'     => esc_html__( 'LocationsTAS', 'front' ),
      'content'   => get_the_candidate_location(),
      'icon'      => 'fas fa-map-marker-alt',
    ),
    'candidate_pay_scale'   => array(
      'title'     => esc_html__( 'Working rateTAS', 'front' ),
      'content'   => front_get_the_meta_data( '_candidate_pay_scale', null, 'resume' ),
      'icon'      => 'fas fa-clock',
    ),
    'candidate_work_done'  => array(
      'title'     => esc_html__( 'ProjectsTAS', 'front' ),
      'content'   => front_get_the_meta_data( '_candidate_work_done', null, 'resume' ),
      'icon'      => 'fas fa-briefcase',
    ),
    'candidate_location2'    => array(
      'title'     => esc_html__( 'Locations2TAS', 'front' ),
      'content'   => get_the_candidate_location(),
      'icon'      => 'fas fa-map-marker-alt',
    ),
  ) );

  if( is_array( $args ) && count( $args ) > 0 ) :
    $i = 0;
    $html = null;
    foreach( $args as $arg ) :
      if( isset( $arg['title'], $arg['content'] ) && !empty( $arg['title'] && $arg['content'] ) ) :
        $class = !( $i+1 === count( $args ) ) ? "u-ver-divider u-ver-divider--none-sm pr-4 mr-4 mb-3 mb-sm-0" : "mb-3 mb-md-0";
        $html .= '<div class="'.$class.'">';
          $html .= '<h2 class="small text-secondary mb-0">'.wp_kses_post( $arg["title"] ).'</h2>';
          if( isset( $arg['icon'] ) && !empty( $arg['icon'] ) ) :
              $html .= '<small class="text-secondary align-middle mr-1 '.esc_attr( $arg["icon"] ).'"></small>';
          endif;
          $html .= '<span class="align-middle font-size-1 font-weight-medium">'.wp_kses_post( $arg['content'] ).'</span>';
        $html .= '</div>';
        $i++;
      endif;
    endforeach;
  endif;
  echo $html;
}

// https://wpjobmanager.com/document/resume-manager-editing-submission-fields/
// Add fields to Contributors on the backend
add_filter( 'resume_manager_resume_fields', 'wpjms_admin_resume_form_fields' );
function wpjms_admin_resume_form_fields( $fields ) {
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
      'priority' => 161,
  );
  $fields['_candidate_stack_exchange'] = array(
      'label'     => __( 'Stack Exchange', 'job_manager' ),
      'type'      => 'text',
      'placeholder'   => __( 'https://stackexchange.com/', 'job_manager' ),
      'description' => 'Full URL',
      'priority' => 161,
  );
  $fields['_candidate_other'] = array(
      'label'     => __( 'Other', 'job_manager' ),
      'type'      => 'text',
      'placeholder'   => __( 'https://', 'job_manager' ),
      'description' => 'Full URL',
      'priority' => 162,
  );
  return $fields;
}