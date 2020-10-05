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

// Edits the canidates footer when in a list
function cosmos_resume_listing_list_card_footer_content() {
	$args = apply_filters( 'front_resume_listing_list_card_footer_content_args', array(
		'candidate_location'    => array(
			'title'     => esc_html__( 'candidate_location', 'front' ),
			'content'   => get_the_candidate_location(),
			'icon'      => 'fas fa-map-marker-alt',
		),
		'candidate_pay_scale'   => array(
			'title'     => esc_html__( 'Working rate', 'front' ),
			'content'   => front_get_the_meta_data( '_candidate_pay_scale', null, 'resume' ),
			'icon'      => 'fas fa-clock',
		),
		'candidate_work_done'  => array(
			'title'     => esc_html__( 'Projects', 'front' ),
			'content'   => front_get_the_meta_data( '_candidate_work_done', null, 'resume' ),
			'icon'      => 'fas fa-briefcase',
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
add_filter( 'resume_manager_resume_fields', 'cosmos_admin_resume_form_fields' );
function cosmos_admin_resume_form_fields( $fields ) {
	$i = 10;
	foreach ($fields as $key => $value) {
		$fields[$key] = array(
				'label'     		=> __( $value['label'], 'job_manager' ),
				'type'      		=> $value['type'],
				'placeholder'   => __( $value['placeholder'], 'job_manager' ),
				'description' 	=> $value['description'],
				'priority' 			=> $i,
		);
		$i = $i + 10;
	}
	// used to get all the active companies
	foreach (cosmos_get_projects() as $key => $value) {
	  $projects[$value->ID] = $value->post_title;
	}
	$fields['_candidate_github'] = array(
		'label'     		=> __( 'Github', 'job_manager' ),
		'type'      		=> 'text',
		'placeholder' 	=> __( 'https://github.com/', 'job_manager' ),
		'description' 	=> 'Full URL',
		'priority' 			=> 161,
	);
	$fields['_candidate_stackexchange'] = array(
		'label'     		=> __( 'Stack Exchange', 'job_manager' ),
		'type'      		=> 'text',
		'placeholder' 	=> __( 'https://stackexchange.com/', 'job_manager' ),
		'description' 	=> 'Full URL',
		'priority' 			=> 161,
	);
	$fields['_candidate_other'] = array(
		'label'     		=> __( 'Other', 'job_manager' ),
		'type'      		=> 'text',
		'placeholder' 	=> __( 'https://', 'job_manager' ),
		'description' 	=> 'Full URL',
		'priority' 			=> 162,
	);
  $fields['_projects_contributed_to'] = array(
    'label' 				=> __( 'Projects you have contributed to', 'job_manager' ),
		'type'          => 'multiselect',
		'options'  			=> $projects,
		'required'      => false,
		'placeholder'   => '',
		'priority'      => 163,
		'personal_data' => true,
  );
	return $fields;
}

// Add fields to frontend
add_filter( 'submit_resume_form_fields', 'cosmos_frontend_contributor_form_fields' );
function cosmos_frontend_contributor_form_fields( $fields ) {
	$i = 10;
	// used to get all the active companies
	foreach (cosmos_get_projects() as $key => $value) {
	  $projects[$value->ID] = $value->post_title;
	}
	$fields['resume_fields']['candidate_github'] = array(
		'label'     		=> __( 'Github', 'job_manager' ),
		'type'      		=> 'text',
		'placeholder'   => __( 'https://github.com/', 'job_manager' ),
		'description' 	=> '',
		'required'      => false,
		'priority' 			=> 6,
		'personal_data' => true,
	);
	$fields['resume_fields']['candidate_stackexchange'] = array(
		'label'     		=> __( 'Stack Exchange', 'job_manager' ),
		'type'      		=> 'text',
		'placeholder'   => __( 'https://stackexchange.com/', 'job_manager' ),
		'description' 	=> '',
		'required'      => false,
		'priority' 			=> 6,
		'personal_data' => true,
	);
	$fields['resume_fields']['candidate_other'] = array(
		'label'     		=> __( 'Other', 'job_manager' ),
		'type'      		=> 'text',
		'placeholder'   => __( 'https://', 'job_manager' ),
		'description' 	=> '',
		'required'      => false,
		'priority' 			=> 6,
		'personal_data' => true,
	);
  $fields['resume_fields']['projects_contributed_to'] = array(
    'label' 				=> __( 'Projects you have contributed to', 'job_manager' ),
		'type'          => 'multiselect',
		'options'  			=> $projects,
		'required'      => false,
		'placeholder'   => '',
		'priority'      => 4,
		'personal_data' => true,
  );
  return $fields;
}

// Removes the standard front linked accounts and adds in cosmos linked accounts
add_action( 'single_resume_sidebar', 'cosmos_single_resume_linked_accounts', 90 );
add_action( 'after_setup_theme', 'cosmos_remove_front_single_resume_linked_accounts');
function cosmos_remove_front_single_resume_linked_accounts() {
	remove_filter( 'single_resume_sidebar', 'front_single_resume_linked_accounts', 90 );
}
if( ! function_exists( 'cosmos_single_resume_linked_accounts' ) ) {
	function cosmos_single_resume_linked_accounts() {
		$args = apply_filters( 'front_single_resume_linked_accounts_args', array(
			'website' => array(
				'text'  => get_the_title(),
				'link'  => front_get_the_meta_data( '_candidate_website', null, 'resume', true ),
				'image' => get_the_candidate_photo() ? job_manager_get_resized_image( get_the_candidate_photo(), 'thumnail' ) : apply_filters( 'resume_manager_default_candidate_photo', RESUME_MANAGER_PLUGIN_URL . '/assets/images/candidate.png' ),
			),
			'twitter' => array(
				'text'  => esc_html__( 'Twitter', 'front' ),
				'link'  => front_get_the_meta_data( '_candidate_twitter', null, 'resume', true ),
				'image' => get_stylesheet_directory_uri() . '/dist/img/160x160/twitter.png',
			),
			'facebook'=> array(
				'text'  => esc_html__( 'Facebook', 'front' ),
				'link'  => front_get_the_meta_data( '_candidate_facebook', null, 'resume', true ),
				'image' => get_stylesheet_directory_uri() . '/dist/img/160x160/facebook.png',
			),
			'github'  => array(
				'text'  => esc_html__( 'Github', 'front' ),
				'link'  => front_get_the_meta_data( '_candidate_github', null, 'resume', true ),
				'image' => get_stylesheet_directory_uri() . '/dist/img/160x160/github.png',
			),
			'stackexchange'  => array(
				'text'  => esc_html__( 'Stack Exchange', 'front' ),
				'link'  => front_get_the_meta_data( '_candidate_stackexchange', null, 'resume', true ),
				'image' => get_stylesheet_directory_uri() . '/dist/img/160x160/stackexchange.png',
			),
			'other'  	=> array(
				'text'  => esc_html__( 'Other', 'front' ),
				'link'  => front_get_the_meta_data( '_candidate_other', null, 'resume', true ),
				'image' => get_stylesheet_directory_uri() . '/dist/img/160x160/other.png',
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
	
// Removes resume fields on the front end
function cosmos_remove_submit_job_form_fields( $fields ) {
  unset( $fields['resume_fields']['resume_category'] );
  unset( $fields['resume_fields']['candidate_work_done'] );
  unset( $fields['resume_fields']['candidate_success_rate'] );
  unset( $fields['resume_fields']['candidate_pay_scale'] );
  unset( $fields['resume_fields']['candidate_video'] );
  unset( $fields['resume_fields']['candidate_experience'] );
  return $fields;
}
add_filter( 'submit_resume_form_fields', 'cosmos_remove_submit_job_form_fields', 30 );


// Changes the fields on the front end for the contributors profile
add_filter( 'submit_resume_form_fields', 'cosmos_resume_change_fields', 30);
function cosmos_resume_change_fields( $fields ) {
	$fields['resume_fields']['resume_content']['required'] = false;
	$fields['resume_fields']['candidate_name']['label'] = "Contributor's Name";
	$fields['resume_fields']['candidate_bio']['priority'] = 4;
	$fields['resume_fields']['projects_contributed_to']['priority'] = 5;
	$fields['resume_fields']['candidate_photo']['priority'] = 6;
	$fields['resume_fields']['candidate_twitter']['priority'] = 7;
	$fields['resume_fields']['candidate_facebook']['priority'] = 7;
	$fields['resume_fields'][	'candidate_stackexchange']['priority'] = 7;
	$fields['resume_fields']['candidate_github']['priority'] = 7;
	$fields['resume_fields']['candidate_other']['priority'] = 7;
	$fields['resume_fields']['candidate_rewards']['label'] = 'Accolades/Awards';
		return $fields;
}

// Changes the h2 header on the single contributor page
add_action( 'single_resume_content', 'cosmos_single_contributor_description', 10 );
add_action( 'after_setup_theme', 'cosmos_remove_single_contributor_description');
function cosmos_remove_single_contributor_description() {
	remove_action( 'single_resume_content', 'front_single_resume_description', 10 );
}
if( ! function_exists( 'cosmos_single_contributor_description' ) ) {
	function cosmos_single_contributor_description() {
	  if( !empty( get_the_content() ) ) :
      ?>
      <div class="mb-4">
        <h2 class="h5"><?php esc_html_e( 'About Contributor', 'front' ) ?></h2>
      </div>
      <div class="mb-5">
        <?php echo apply_filters( 'the_resume_description', get_the_content() ); ?>
      </div>
      <?php
	  endif;
	}
}

// Removed the Rewards sectioon of a contributors sidebar
add_action( 'after_setup_theme', 'cosmos_remove_sidebar_rewards_categories');
function cosmos_remove_sidebar_rewards_categories() {
	remove_action( 'single_resume_sidebar', 'front_single_resume_sidebar_rewards_categories', 60 );
}

// Edits the title of Candidates and renames it Contributors
add_action( 'resume_listing_before_loop', 'cosmos_resume_listing_loop_controlbar', 10 );
add_action( 'after_setup_theme', 'cosmos_remove_listing_loop_controlbar');
function cosmos_remove_listing_loop_controlbar() {
	remove_action( 'resume_listing_before_loop', 'front_resume_listing_loop_controlbar', 10 );
}
if( ! function_exists( 'cosmos_resume_listing_loop_controlbar' ) ) {
    function cosmos_resume_listing_loop_controlbar() {
        $layout = front_get_wpjmr_resume_listing_layout();
        $style = front_get_wpjmr_resume_listing_style();

        if( $layout !== 'fullwidth' ) :
            ?><div class="row"><div class="col-lg-9<?php echo ( 'left-sidebar' === $layout ) ? esc_attr( ' ml-lg-auto' ) : ''; ?>"><?php
        endif;
        ?>
        <div class="mb-4">
            <ul class="list-inline d-md-flex align-items-md-center mb-0">
                <?php
                do_action( 'resume_listing_loop_controlbar_controls_before' );

                if( $layout === 'fullwidth' ) {
                    if( get_option( 'resume_manager_enable_categories' ) ) :
                        front_wpjm_job_control_bar_dropdown( esc_html__( 'Category', 'front' ), 'resume_category'  );
                    endif;
                } else {
                    ?>
                    <li class="list-inline-item col-sm-4 col-md-6 mb-3 px-0 mb-sm-0">
                        <?php if( !empty( Front_WPJMR::get_current_page_query_args() ) ) : ?>
                            <h1 class="h5 mb-0"><?php esc_html_e( 'Search results', 'front' ); ?></h1>
                        <?php else : ?>
                            <h1 class="h5 mb-0"><?php echo esc_html__( 'Contributors', 'front' ); ?></h1>
                        <?php endif; ?>
                    </li>
                    <?php
                }

                ?>
                <li class="list-inline-item mb-2 ml-md-auto">
                    <?php front_wpjmr_resume_catalog_ordering(); ?>
                </li>
                <li class="list-inline-item mb-2">
                    <a id="front-resume-view-switcher-grid" class="btn btn-xs btn-soft-primary<?php echo 'grid' == $style ? esc_attr( ' active' ) : ''; ?>" href="#">
                        <span class="fas fa-th-large mr-2"></span>
                        <?php esc_html_e( 'Grid', 'front' ); ?>
                    </a>
                </li>
                <li class="list-inline-item mb-2">
                    <a id="front-resume-view-switcher-list" class="btn btn-xs btn-soft-primary<?php echo 'list' == $style ? esc_attr( ' active' ) : ''; ?>" href="#">
                        <span class="fas fa-list mr-2"></span>
                        <?php esc_html_e( 'List', 'front' ); ?>
                    </a>
                </li>
                <?php
                do_action( 'resume_listing_loop_controlbar_controls_after' );
                ?>
            </ul>
        </div>
        <?php

        if( $layout !== 'fullwidth' ) :
            ?></div></div><?php
        endif;
    }
}

// Gets the projects attributed to a contributor - PILLS
// TAS removed via request from VLBETA in favor of the card view below add_action('single_resume_sidebar','cosmos_projects_attributed_to_a_contributor_pills', 90 );
// function cosmos_projects_attributed_to_a_contributor_pills() {
//   global $wpdb;
//   $html = null;
//   $projects = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}postmeta WHERE post_id = '".cosmos_get_post_id()."' AND meta_key = '_projects_contributed_to'", OBJECT );
//   $projects = unserialize($projects[0]->meta_value);
//   if (!empty($projects)) {
//     $html .= '<div class="border-top pt-5 mt-5">';
//     $html .= '<h4 class="font-size-1 font-weight-semi-bold text-uppercase mb-3">'.get_the_title().' contributes to these projects</h4>';
// 	  foreach ($projects as $key => $value) {
// 	    $html .= '<a href="'.home_url().'/company/'.get_post($value)->post_name.'" class="btn btn-soft-primary btn-xs mb-3 mr-3 transition-3d-hoverbtn btn-pill transition-3d-hover" >';
// 	      $html .= get_post($value)->post_title;
// 	    $html .= '</a>';
// 	  }
//     $html .= '</div>';
// 	}
//   echo $html;
// }

// Gets the projects attributed to a contributor - CARDS
add_action('single_resume_content','cosmos_projects_attributed_to_a_contributor_cards', 15);
function cosmos_projects_attributed_to_a_contributor_cards() {
  global $wpdb;
  $html = null;
  $projects = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}postmeta WHERE post_id = '".cosmos_get_post_id()."' AND meta_key = '_projects_contributed_to'", OBJECT );
  $logos = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}postmeta WHERE meta_key = '_company_logo'", OBJECT );
  $projects = unserialize($projects[0]->meta_value);
  if (!empty($projects)) {
    $html .= '<div class="border-top pt-5 mt-5 border-bottom pb-2 mb-5">';
	    $html .= '<h2 class="h5 mb-3">'.get_the_title().' contributes to these projects</h2>';
	    $html .= '<div class="row">';
			  foreach ($projects as $key => $value) {
					$html .= '<div class="col-md-4 mb-5">';
						$html .= '<div class="card contributors">';
							$logo =  get_the_company_logo( $value, 'thumbnail' ) ? get_the_company_logo( $value, 'thumbnail' ) : apply_filters( 'job_manager_default_company_logo', JOB_MANAGER_PLUGIN_URL . '/assets/images/company.png' );
							$html .= '<div class="card-image text-center p-5 pt-3">';
								$html .= '<img src="'.esc_url( $logo ).'" alt="'.get_the_title($value).' Logo">';
							$html .= '</div>';
						  $html .= '<div class="card-body">';
						    $html .= '<h5 class="card-title text-center">'.get_post($value)->post_title.'</h5>';
						    $html .= '<div class="text-center">';
						    	$html .= '<a href="'.home_url().'/company/'.get_post($value)->post_name.'" class="btn btn-soft-primary btn-xs mb-3  transition-3d-hover btn btn-pill transition-3d-hover">View Project</a>';
						    $html .= '</div>';
						  $html .= '</div>';
						$html .= '</div>';
					$html .= '</div>';
			  }
			$html .= '</div>';
    $html .= '</div>';
	}
  echo $html;
}

// Removes the bio if a user does not actually write anything in the sidebar
add_action( 'single_resume_sidebar', 'cosmos_single_resume_sidebar_bio', 30 );
add_action( 'after_setup_theme', 'cosmos_remove_single_resume_sidebar_bio');
function cosmos_remove_single_resume_sidebar_bio() {
	remove_action( 'single_resume_sidebar', 'front_single_resume_sidebar_bio', 30 );
}
if( ! function_exists( 'cosmos_single_resume_sidebar_bio' ) ) {
    function cosmos_single_resume_sidebar_bio() {
        if( empty( $candidate_bio = front_get_the_meta_data( '_candidate_bio', null, 'resume', true ) ) ) :
            // TAS $candidate_bio = get_the_excerpt();
        endif;

        if( ! empty( $candidate_bio ) ) :
            if( ( $pos = strrpos( $candidate_bio , '<p>' ) ) !== false ) {
                $search_length  = strlen( '<p>' );
                $candidate_bio    = substr_replace( $candidate_bio , '<p class="mb-0">' , $pos , $search_length );
            }
            ?>
            <div class="border-top pt-5 mt-5">
                <h2 class="font-size-1 font-weight-semi-bold text-uppercase mb-3"><?php esc_html_e( 'Bio', 'front' ); ?></h2>
                <div class="resume-excerpt font-size-1 text-secondary"><?php echo wp_kses_post( $candidate_bio ); ?></div>
            </div>
            <?php
        endif;
    }
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
