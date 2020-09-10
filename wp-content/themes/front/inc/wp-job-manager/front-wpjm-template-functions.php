<?php

if ( ! function_exists( 'front_wpjm_custom_submit_job_form_fields' ) ) {
    function front_wpjm_custom_submit_job_form_fields( $fields ) {
        if ( $max = get_option( 'job_manager_max_skills' ) ) {
            $max = ' ' . sprintf( esc_html__( 'Maximum of %d.', 'front' ), $max );
        }

        $fields['job']['contact_email'] = array(
            'label'         => esc_html__( 'Branch/Contact Email', 'front' ),
            'type'          => 'text',
            'required'      => false,
            'placeholder'   => esc_html__( 'you@yourdomain.com', 'front' ),
            'priority'      => 2,
        );

        $fields['job']['contact_phone'] = array(
            'label'         => esc_html__( 'Branch/Contact No.', 'front' ),
            'type'          => 'text',
            'required'      => false,
            'placeholder'   => esc_html__( 'Branch/Contact phome no', 'front' ),
            'priority'      => 2,
        );

        $fields['job']['job_qualification'] = array(
            'label'         => esc_html__( 'Job Qualification', 'front' ),
            'type'          => 'text',
            'required'      => false,
            'placeholder'   => esc_html__( 'Qualification required to apply this job', 'front' ),
            'priority'      => 2,
        );

        $fields['job']['application']['priority'] = 2;

        $fields['job']['contact_address'] = array(
            'label'         => esc_html__( 'Branch/Contact Address', 'front' ),
            'type'          => 'textarea',
            'required'      => false,
            'placeholder'   => esc_html__( 'Branch/Contact Address', 'front' ),
            'priority'      => 2,
        );

        if ( get_option('job_manager_enable_skills') ) {
            $fields['job']['job_listing_skills'] = array(
                'label'         => esc_html__( 'Job Skills', 'front' ),
                'type'          => 'tag-input',
                'required'      => false,
                'placeholder'   => esc_html__( 'Relevant skills to this Job', 'front' ),
                'description'   => esc_html__( 'list of relevant skills seperate with Enter key', 'front' ) . $max,
                'priority'      => 3,
            );
        }

        if ( get_option('job_manager_enable_salary') ) {
            $fields['job']['job_listing_salary'] = array(
                'label'       => esc_html__( 'Job Salary', 'front' ),
                'type'        => 'term-multiselect',
                'taxonomy'    => 'job_listing_salary',
                'required'    => false,
                'placeholder' => esc_html__( 'Choose a salary &hellip;', 'front' ),
                'priority'    => 4
            );
        }

        if ( get_option('job_manager_enable_project_length') ) {
            $fields['job']['job_listing_project_length'] = array(
                'label'       => esc_html__( 'Project Length', 'front' ),
                'type'        => 'term-multiselect',
                'taxonomy'    => 'job_listing_project_length',
                'required'    => false,
                'placeholder' => esc_html__( 'Choose a project length &hellip;', 'front' ),
                'priority'    => 4
            );
        }

        if ( get_option('job_manager_enable_working_environment') ) {
            $fields['job']['job_listing_working_environment'] = array(
                'label'         => esc_html__( 'Working Environment', 'front' ),
                'type'          => 'term-multiselect',
                'taxonomy'      => 'job_listing_working_environment',
                'required'      => false,
                'placeholder' => esc_html__( 'Choose a Job Working environment &hellip;', 'front' ),
                'priority'      => 4,
            );
        }

        $fields['job']['job_about'] = array(
            'label'         => esc_html__( 'Short Desciption', 'front' ),
            'type'          => 'textarea',
            'required'      => false,
            'placeholder'   => esc_html__( 'short description about job', 'front' ),
            'priority'      => 4,
        );

        $fields['job']['job_responsibility'] = array(
            'label'         => esc_html__( 'Job Resposibility', 'front' ),
            'add_row'       => esc_html__( 'Add Resposibility', 'front' ),
            'type'          => 'repeated', // repeated
            'required'      => false,
            'placeholder'   => '',
            'priority'      => 11,
            'fields'        => array(
                'notes'         => array(
                    'label'       => esc_html__( 'Notes', 'front' ),
                    'type'        => 'textarea',
                    'required'    => false,
                    'placeholder' => '',
                ),
            ),
        );

        $fields['job']['job_requirement'] = array(
            'label'         => esc_html__( 'Job Requirement', 'front' ),
            'add_row'       => esc_html__( 'Add Requirement', 'front' ),
            'type'          => 'repeated', // repeated
            'required'      => false,
            'placeholder'   => '',
            'priority'      => 11,
            'fields'        => array(
                'notes'         => array(
                    'label'       => esc_html__( 'Notes', 'front' ),
                    'type'        => 'textarea',
                    'required'    => false,
                    'placeholder' => '',
                ),
            ),
        );

        $fields['job']['job_bonus_point'] = array(
            'label'         => esc_html__( 'Bonus Points', 'front' ),
            'add_row'       => esc_html__( 'Add Bonus Points', 'front' ),
            'type'          => 'repeated', // repeated
            'required'      => false,
            'placeholder'   => '',
            'priority'      => 11,
            'fields'        => array(
                'notes'         => array(
                    'label'       => esc_html__( 'Notes', 'front' ),
                    'type'        => 'textarea',
                    'required'    => false,
                    'placeholder' => '',
                ),
            ),
        );

        $fields['company']['company_about'] = array(
            'label'         => ( front_is_mas_wp_company_manager_activated() && get_option( 'job_manager_job_submission_required_company' ) ) ? __( 'About Branch', 'front' ) : esc_html__( 'About Company / Branch', 'front' ),
            'type'          => 'textarea',
            'required'      => false,
            'placeholder'   => ( front_is_mas_wp_company_manager_activated() && get_option( 'job_manager_job_submission_required_company' ) ) ? __( 'short description about branch', 'front' ) : esc_html__( 'short description about company/branch', 'front' ),
            'priority'      => 6,
        );

        return $fields;
    }
}

if ( ! function_exists( 'front_wpjm_custom_submit_job_form_validate_fields' ) ) {
    function front_wpjm_custom_submit_job_form_validate_fields( $is_valid, $group_fields, $values  ) {
        foreach ( $group_fields as $group_key => $fields ) {
            foreach ( $fields as $key => $field ) {
                if ( 'job_listing_skills' === $key ) {
                    if ( is_string( $values[ $group_key ][ $key ] ) ) {
                        $raw_skills = explode( ',', $values[ $group_key ][ $key ] );
                    } else {
                        $raw_skills = $values[ $group_key ][ $key ];
                    }
                    $max = get_option( 'job_manager_max_skills', 10 );

                    if ( $max && sizeof( $raw_skills ) > $max ) {
                        return new WP_Error( 'validation-error', sprintf( esc_html__( 'Please enter no more than %d skills.', 'front' ), $max ) );
                    }
                }
            }
        }
        return $is_valid;
    }
}

if ( ! function_exists( 'front_wpjm_custom_submit_job_form_fields_get_job_data' ) ) {
    function front_wpjm_custom_submit_job_form_fields_get_job_data( $group_fields, $job  ) {
        foreach ( $group_fields as $group_key => $fields ) {
            foreach ( $fields as $key => $field ) {
                if ( 'job_listing_skills' === $key ) {
                    $group_fields[ $group_key ][ $key ]['value'] = implode( ', ', wp_get_object_terms( $job->ID, 'job_listing_skill', array( 'fields' => 'names' ) ) );
                } elseif( isset( $field['type'] ) && ( $field['type'] == 'term-multiselect' ) && isset( $field['taxonomy'] ) ) {
                    $group_fields[ $group_key ][ $key ]['value'] = wp_get_object_terms( $job->ID, $field['taxonomy'], array( 'fields' => 'ids' ) );
                }
            }
        }
        return $group_fields;
    }
}

if ( ! function_exists( 'front_wpjm_update_job_data' ) ) {
    function front_wpjm_update_job_data( $job_id, $values  ) {
        if ( get_option( 'job_manager_enable_skills' ) && isset( $values['job']['job_listing_skills'] ) ) {

            $tags     = array();
            $raw_tags = $values['job']['job_listing_skills'];

            if ( is_string( $raw_tags ) ) {
                // Explode and clean
                $raw_tags = array_filter( array_map( 'sanitize_text_field', explode( ',', $raw_tags ) ) );

                if ( ! empty( $raw_tags ) ) {
                    foreach ( $raw_tags as $tag ) {
                        if ( $term = get_term_by( 'name', $tag, 'job_listing_skill' ) ) {
                            $tags[] = $term->term_id;
                        } else {
                            $term = wp_insert_term( $tag, 'job_listing_skill' );

                            if ( ! is_wp_error( $term ) ) {
                                $tags[] = $term['term_id'];
                            }
                        }
                    }
                }
            } else {
                $tags = array_map( 'absint', $raw_tags );
            }

            wp_set_object_terms( $job_id, $tags, 'job_listing_skill', false );
        }
    }
}

/*
 * Single Job
 */

if ( ! function_exists( 'front_modify_single_job_listing_hooks' ) ) {
    function front_modify_single_job_listing_hooks() {
        $style = front_get_wpjm_single_job_style();

        do_action( 'front_modify_single_job_listing_hooks_before', $style );

        remove_action( 'single_job_listing_start', 'job_listing_meta_display', 20 );
        remove_action( 'single_job_listing_start', 'job_listing_company_display', 30 );

        if ( $style == 'style-2' ) {
            remove_action( 'single_job_listing_content_area_before', 'front_single_job_listing_hero_section', 10 );
            remove_action( 'single_job_listing_start', 'front_single_job_listing_content_open', 10 );
            remove_action( 'single_job_listing', 'front_single_job_listing_content', 10 );
            remove_action( 'single_job_listing', 'front_single_job_listing_sidebar', 20 );
            remove_action( 'single_job_listing_end', 'front_single_job_listing_content_close', 10 );
            remove_action( 'single_job_listing_end', 'front_single_job_listing_related_jobs', 20 );

            add_action( 'single_job_listing_start', 'front_single_job_listing_v2_content_open', 10 );
            add_action( 'single_job_listing', 'front_single_job_listing_v2_content', 10 );
            add_action( 'single_job_listing_end', 'front_single_job_listing_v2_content_close', 20 );
        }

        do_action( 'front_modify_single_job_listing_hooks_after', $style );
    }
}

if ( ! function_exists( 'front_single_job_listing_jetpack_sharing_filters' ) ) {
    function front_single_job_listing_jetpack_sharing_filters() {

        if ( apply_filters( 'front_enable_front_jetpack_sharing', true ) ) {
            $options = get_option( 'sharing-options' );

            if ( isset( $options['global']['button_style'] ) && 'icon' == $options['global']['button_style'] ) {
                add_filter( 'jetpack_sharing_display_classes', 'front_job_listing_sharing_display_classes', 10, 4 );
                add_filter( 'jetpack_sharing_headline_html', 'front_job_listing_sharing_headline_html', 10, 3 );
                add_filter( 'jetpack_sharing_display_markup', 'front_job_listing_sharing_display_markup', 10, 2 );
            }
        }
    }
}

if ( ! function_exists( 'front_job_listing_sharing_display_classes' ) ) {
    function front_job_listing_sharing_display_classes( $klasses, $sharing_source, $id, $args ) {

        if ( 'icon' == $sharing_source->button_style ) {
            if ( ( $key = array_search( 'sd-button', $klasses ) ) !== false ) {
                unset( $klasses[$key] );
            }

            $klasses[] = 'btn';
            $klasses[] = 'btn-icon';
            $klasses[] = 'btn-soft-secondary';
            $klasses[] = 'btn-bg-transparent';
        }

        return $klasses;
    }
}

if ( ! function_exists( 'front_job_listing_sharing_headline_html' ) ) {
    function front_job_listing_sharing_headline_html( $heading_html, $sharing_label, $action ) {
        return '<div class="mb-4"><h3 class="h5">%s</h3></div>';
    }
}

if ( ! function_exists( 'front_job_listing_sharing_display_markup' ) ) {
    function front_job_listing_sharing_display_markup( $sharing_content, $enabled ) {

        $sharing_content = str_replace( 'class="robots-nocontent ', 'class="', $sharing_content );
        $sharing_content = str_replace( 'class="sd-content"', '', $sharing_content );
        $sharing_content = str_replace( '<ul>', '<ul class="list-inline mb-0">', $sharing_content );
        $sharing_content = str_replace( '<li class="share-', '<li class="list-inline-item list-inline-item-', $sharing_content );
        $sharing_content = str_replace( '<span></span>', '<span class="btn-icon__inner"></span>', $sharing_content );
        $sharing_content = str_replace( '<li><a href="#" class="sharing-anchor sd-button share-more"><span>', '<li class="list-inline-item"><a href="#" class="btn btn-sm btn-icon btn-soft-secondary btn-bg-transparent sharing-anchor share-more"><span class="fas fa-ellipsis-h btn-icon__inner"></span><span class="sr-only">', $sharing_content );
        $sharing_content = str_replace( '<li class="list-inline-item list-inline-item-end"></li>', '', $sharing_content );
        return $sharing_content;
    }
}

// Style 1

if( ! function_exists( 'front_single_job_listing_hero_section' ) ) {
    function front_single_job_listing_hero_section() {
        ?>
        <div class="container">
            <div class="border-bottom space-top-2">
                <?php do_action( 'single_job_listing_job_header' ); ?>
            </div>
        </div>
        <?php
    }
}

if( ! function_exists( 'front_single_job_listing_job_header_job_data' ) ) {
    function front_single_job_listing_job_header_job_data() {
        ?>
        <div class="media align-items-center mb-5">
            <div class="u-lg-avatar mr-4 position-relative">
                <?php front_the_company_logo( 'thumbnail', 'img-fluid rounded-circle', false ); ?>
                <?php front_the_job_status(); ?>
            </div>
            <div class="media-body">
                <div class="row">
                    <?php do_action( 'single_job_listing_job_header_job_data' ); ?>
                </div>
            </div>
        </div>
        <?php
    }
}

if( ! function_exists( 'front_single_job_listing_job_header_job_data_left' ) ) {
    function front_single_job_listing_job_header_job_data_left() {
        do_action( 'single_job_listing_job_header_job_data_left_before' );
        ?>
        <div class="mb-3 mb-lg-0 <?php echo esc_attr( candidates_can_apply() ? 'col-lg-6' : 'col-lg-12' );  ?>">
            <?php
            do_action( 'single_job_listing_job_header_job_title_before' );
            the_title( '<h1 class="h4 mb-1">', '</h1>' );
            $company = front_get_the_job_listing_company();
            if( front_is_mas_wp_job_manager_company_review_activated() && $company && ( $review_average = mas_wpjmcr_get_reviews_average( $company->ID ) ) ) :
                ?>
                <div class="reviews-average">
                    <span class='text-warning font-size-1 mr-2'>
                        <?php for ( $i = 0; $i < mas_wpjmcr_get_max_stars(); $i++ ) : ?>
                            <span class="<?php echo esc_attr( $i < $review_average ? 'fas' : 'far' ); ?> fa-star"></span>
                        <?php endfor; ?>
                    </span>
                    <span class="font-weight-semi-bold">
                        <?php echo number_format( $review_average, 2, '.', ''); ?>
                    </span>
                    <small class="text-muted">
                        (<?php echo sprintf( _n( '%s review', '%s reviews', intval( mas_wpjmcr_get_reviews_count( $company->ID ) ), 'front' ), intval( mas_wpjmcr_get_reviews_count( $company->ID ) ) ); ?>)
                    </small>
                </div><!-- .reviews-average -->
                <?php
            endif;
            do_action( 'single_job_listing_job_header_job_title_after' );
            ?>
        </div>
        <?php
        do_action( 'single_job_listing_job_header_job_data_left_after' );
    }
}

if( ! function_exists( 'front_single_job_listing_job_header_job_data_right' ) ) {
    function front_single_job_listing_job_header_job_data_right() {
        do_action( 'single_job_listing_job_header_job_data_right_before' );
        if( candidates_can_apply() ) :
            ?>
            <div class="col-lg-6">
                <div class="d-flex justify-content-md-end align-items-center">
                    <?php
                    do_action( 'single_job_listing_job_header_job_apply_before' );
                    front_single_job_listing_application();
                    do_action( 'single_job_listing_job_header_job_apply_after' );
                    ?>
                </div>
            </div>
            <?php
        endif;
        do_action( 'single_job_listing_job_header_job_data_right_after' );
    }
}

if( ! function_exists( 'front_single_job_listing_views' ) ) {
    function front_single_job_listing_views() {
        if( function_exists( 'front_get_jetpack_page_views' ) && function_exists( 'front_show_page_views' ) ) :
            ?>
            <div class="space-bottom-1">
                <?php front_show_page_views(); ?>
            </div>
            <?php
        endif;
    }
}

if( ! function_exists( 'front_single_job_listing_content_open' ) ) {
    function front_single_job_listing_content_open() {
        ?>
        <div class="container">
            <div class="border-bottom space-2">
                <div class="row">
        <?php
    }
}

if( ! function_exists( 'front_single_job_listing_content_close' ) ) {
    function front_single_job_listing_content_close() {
        ?>
                </div>
            </div>
        </div>
        <?php
    }
}

if( ! function_exists( 'front_single_job_listing_content' ) ) {
    function front_single_job_listing_content() {
        ?>
        <div class="col-lg-8 mb-9 mb-lg-0">
            <?php do_action( 'single_job_listing_content' ); ?>
        </div>
        <?php
    }
}

if( ! function_exists( 'front_single_job_listing_sidebar' ) ) {
    function front_single_job_listing_sidebar() {
        ?>
        <div class="col-lg-4">
            <div class="pl-lg-4">
                <?php do_action( 'single_job_listing_sidebar' ); ?>
            </div>
        </div>
        <?php
    }
}

if( ! function_exists( 'front_single_job_listing_description' ) ) {
    function front_single_job_listing_description() {
        if( !empty( wpjm_get_the_job_description() ) ) :
            ?>
            <div class="mb-4">
                <h2 class="h5"><?php esc_html_e( 'Job Description', 'front' ) ?></h2>
                <p class="text-muted font-size-1"><?php the_job_publish_date(); ?></p>
            </div>
            <div class="mb-7">
                <?php wpjm_the_job_description(); ?>
            </div>
            <?php
        else :
            ?>
            <div class="mb-4">
                <p class="text-muted font-size-1"><?php the_job_publish_date(); ?></p>
            </div>
            <?php
        endif;
    }
}

if( ! function_exists( 'front_single_job_listing_skills' ) ) {
    function front_single_job_listing_skills() {
        global $post;

        if ( taxonomy_exists( $taxonomy = 'job_listing_skill' ) ) :
            $skills = get_the_terms( $post->ID, $taxonomy );

            if ( is_wp_error( $skills ) || empty( $skills ) ) {
                return '';
            }

            $links = array();

            foreach ( $skills as $skill ) :
                $link = get_term_link( $skill, $taxonomy );
                if ( is_wp_error( $link ) ) :
                    return $link;
                endif;
                $links[] = '<a href="' . esc_url( $link ) . '" rel="tag" class="btn btn-xs btn-gray btn-pill">' . $skill->name . '</a>';
            endforeach;

            ?>
            <div class="mb-4">
                <h3 class="h5"><?php esc_html_e( 'Skills:', 'front' ) ?></h3>
            </div>
            <ul class="list-inline mb-7">
                <li class="list-inline-item pb-3">
                    <?php echo implode('</li><li class="list-inline-item pb-3">', $links); ?>
                </li>
            </ul>
            <?php
        endif;
    }
}

if( ! function_exists( 'front_single_job_listing_responsibilities' ) ) {
    function front_single_job_listing_responsibilities() {
        global $post;

        if ( $items = get_post_meta( $post->ID, '_job_responsibility', true ) ) : ?>
            <div class="mb-4">
                <h3 class="h5"><?php esc_html_e( 'Responsibilities', 'front' ) ?></h3>
            </div>
            <ul class="list-unstyled mb-7">
            <?php
                foreach( $items as $item ) : ?>
                    <li class="py-3">
                        <div class="media">
                            <span class="btn btn-xs btn-icon btn-soft-success rounded-circle mr-3">
                                <span class="fas fa-arrow-right btn-icon__inner"></span>
                            </span>
                            <div class="media-body text-secondary">
                                <?php echo wptexturize( $item['notes'] ); ?>
                            </div>
                        </div>
                    </li>
                <?php endforeach;
            ?>
            </ul>
        <?php endif;
    }
}

if( ! function_exists( 'front_single_job_listing_requirements' ) ) {
    function front_single_job_listing_requirements() {
        global $post;

        if ( $items = get_post_meta( $post->ID, '_job_requirement', true ) ) : ?>
            <div class="mb-4">
                <h3 class="h5"><?php esc_html_e( 'Requirements', 'front' ) ?></h3>
            </div>
            <ul class="list-unstyled mb-7">
            <?php
                foreach( $items as $item ) : ?>
                    <li class="py-3">
                        <div class="media">
                            <span class="btn btn-xs btn-icon btn-soft-primary rounded-circle mr-3">
                                <span class="fas fa-check btn-icon__inner"></span>
                            </span>
                            <div class="media-body text-secondary">
                                <?php echo wptexturize( $item['notes'] ); ?>
                            </div>
                        </div>
                    </li>
                <?php endforeach;
            ?>
            </ul>
        <?php endif;
    }
}

if( ! function_exists( 'front_single_job_listing_bonus_points' ) ) {
    function front_single_job_listing_bonus_points() {
        global $post;

        if ( $items = get_post_meta( $post->ID, '_job_bonus_point', true ) ) : ?>
            <div class="mb-4">
                <h3 class="h5"><?php esc_html_e( 'Bonus Points', 'front' ) ?></h3>
            </div>
            <ul class="list-unstyled mb-7">
            <?php
                foreach( $items as $item ) : ?>
                    <li class="py-3">
                        <div class="media">
                            <span class="btn btn-xs btn-icon btn-soft-danger rounded-circle mr-3">
                                <span class="fas fa-plus btn-icon__inner"></span>
                            </span>
                            <div class="media-body text-secondary">
                                <?php echo wptexturize( $item['notes'] ); ?>
                            </div>
                        </div>
                    </li>
                <?php endforeach;
            ?>
            </ul>
        <?php endif;
    }
}

if( ! function_exists( 'front_single_job_listing_share' ) ) {
    function front_single_job_listing_share() {
        if ( function_exists( 'sharing_display' ) && apply_filters( 'front_single_job_listing_share_enable', true ) ) {
            sharing_display( '', true );
        }
    }
}

if( ! function_exists( 'front_single_job_listing_summary' ) ) {
    function front_single_job_listing_summary() {
        ?>
        <div class="card border-0 shadow-sm mb-3">
            <header id="SVGwave1BottomShapeID1" class="svg-preloader card-header border-bottom-0 bg-primary text-white p-0">
                <div class="pt-5 px-5">
                    <h3 class="h5"><?php esc_html_e( 'Job Summary', 'front' ) ?></h3>
                </div>
                <figure class="ie-wave-1-bottom mt-n5">
                    <img class="js-svg-injector" src="<?php echo get_template_directory_uri() . '/assets/svg/components/wave-1-bottom.svg' ?>" alt="wave-1-bottom" data-parent="#SVGwave1BottomShapeID1">
                </figure>
            </header>
            <div class="card-body pt-1 px-5 pb-5">
                <?php
                if( ! empty( $website = front_get_the_job_listing_company_meta_data( '_company_website' ) ) ) :
                    if( substr( $website, 0, 7 ) === "http://" ) {
                        $website_trimed = str_replace( 'http://', '', $website);
                    } elseif( substr( $website, 0, 8 ) === "https://" ) {
                        $website_trimed = str_replace( 'https://', '', $website);
                    } else {
                        $website_trimed = $website;
                    }

                    ?>
                    <div class="media mb-3">
                        <div class="min-width-4 text-center text-primary mt-1 mr-3">
                            <span class="fas fa-globe"></span>
                        </div>
                        <div class="media-body">
                            <a class="font-weight-medium" href="<?php echo esc_url( $website ); ?>"><?php echo esc_html( $website_trimed ); ?></a>
                            <small class="d-block text-secondary"><?php esc_html_e( 'Website', 'front' ); ?></small>
                        </div>
                    </div>
                    <?php
                endif;
                front_single_job_listing_summary_icon_block_elements();
                ?>
            </div>
        </div>
        <?php
    }
}

if( ! function_exists( 'front_single_job_listing_summary_icon_block_elements' ) ) {
    function front_single_job_listing_summary_icon_block_elements() {
        $args = apply_filters( 'front_single_job_listing_summary_icon_block_elements_args', array(
            'job_location' => array(
                'text_1' => get_the_job_location(),
                'text_2' => esc_html__( 'Location', 'front' ),
                'icon' => 'fas fa-map-marked-alt',
            ),
            'job_type' => array(
                'text_1' => front_get_taxomony_data( 'job_listing_type' ),
                'text_2' => esc_html__( 'Job Type', 'front' ),
                'icon' => 'fas fa-clock',
            ),
            'project_length' => array(
                'text_1' => front_get_taxomony_data( 'job_listing_project_length' ),
                'text_2' => esc_html__( 'Project length', 'front' ),
                'icon' => 'fas fa-business-time',
            ),
            'job_salary' => array(
                'text_1' => esc_html__( 'Salary', 'front' ),
                'text_2' => front_get_taxomony_data( 'job_listing_salary' ),
                'icon' => 'fas fa-money-bill-alt',
            ),
            'entry_level' => array(
                'text_1' => esc_html__( 'Entry level', 'front' ),
                'text_2' => front_get_the_meta_data( '_job_qualification' ),
                'icon' => 'fas fa-briefcase',
            ),
        ) );

        if( is_array( $args ) && count( $args ) > 0 ) {
            foreach( $args as $key => $arg) {
                if( isset( $arg['text_1'], $arg['text_2'], $arg['icon'] ) && !empty( $arg['text_1'] && $arg['text_2'] && $arg['icon'] ) ) :
                    ?>
                    <div class="media mb-3">
                        <div class="min-width-4 text-center text-primary mt-1 mr-3">
                            <span class="<?php echo esc_attr( $arg['icon'] ); ?>"></span>
                        </div>
                        <div class="media-body">
                            <span class="d-block font-weight-medium"><?php echo wp_kses_post( $arg['text_1'] ); ?></span>
                            <small class="d-block text-secondary"><?php echo wp_kses_post( $arg['text_2'] ); ?></small>
                        </div>
                    </div>
                    <?php
                endif;
            }
        }
    }
}

if( ! function_exists( 'front_single_job_listing_report_job' ) ) {
    function front_single_job_listing_report_job() {
        ?>
        <div class="text-center mb-9"></div>
        <?php
    }
}

if( ! function_exists( 'front_single_job_listing_company' ) ) {
    function front_single_job_listing_company() {
        ?>
        <div class="mb-4">
            <?php
            front_the_company_logo( 'thumbnail', 'u-clients mb-4' );
            if( !empty( $company_excerpt = front_get_the_job_listing_company_excerpt() ) ) :
                if( ( $pos = strrpos( $company_excerpt , '<p>' ) ) !== false ) {
                    $search_length  = strlen( '<p>' );
                    $company_excerpt = substr_replace( $company_excerpt , '<p class="mb-0">' , $pos , $search_length );
                }
                ?>
                <h4 class="h6"><?php esc_html_e( 'About', 'front' ); ?></h4>
                <div class="font-size-1 text-secondary text-lh-md"><?php echo wp_kses_post( $company_excerpt ); ?></div>
                <?php
            endif;
            if( !empty( $company = front_get_the_job_listing_company() ) ) :
                ?>
                <a class="font-size-1" href="<?php the_permalink( $company ); ?>"><?php esc_html_e( 'View company profile', 'front' ); ?></a>
                <?php
            endif;
            ?>
        </div>
        <?php
    }
}

if( ! function_exists( 'front_single_job_listing_contact_details' ) ) {
    function front_single_job_listing_contact_details() {
        ?>
        <div class="mb-7">
            <?php
            if( !empty( front_get_the_meta_data( '_contact_address' ) || front_get_the_job_listing_company_contact_email() || front_get_the_job_listing_company_contact_phone() ) ) :
                ?>
                <h4 class="h6"><?php esc_html_e( 'Contacts', 'front' ); ?></h4>
                <address class="text-secondary font-size-1">
                    <?php if( !empty( $contact_address = front_get_the_meta_data( '_contact_address' ) ) ) : ?>
                        <span class="d-block mb-2"><?php echo wp_kses_post( $contact_address ); ?></span>
                    <?php endif; ?>
                    <?php if( !empty( $company_contact_email = front_get_the_job_listing_company_contact_email() ) ) : ?>
                        <span class="d-block mb-2"><?php esc_html_e( 'Email:', 'front' ); ?> <a href="mailto:<?php echo sanitize_email( $company_contact_email ); ?>"><?php echo sanitize_email( $company_contact_email ); ?></a></span>
                    <?php endif; ?>
                    <?php if( !empty( $company_contact_phone = front_get_the_job_listing_company_contact_phone() ) ) : ?>
                        <span class="d-block"><?php esc_html_e( 'Phone:', 'front' ); ?> <a class="text-dark" href="tel:<?php echo esc_url( $company_contact_phone ); ?>"><?php echo esc_html( $company_contact_phone ); ?></a></span>
                    <?php endif; ?>
                </address>
                <?php
            endif;
            ?>
        </div>
        <?php
    }
}

if( ! function_exists( 'front_single_job_listing_related_jobs' ) ) {
    function front_single_job_listing_related_jobs( $post = null ) {
        $post = get_post( $post );
        $category_slugs = '';

        $slugs = wp_get_object_terms( $post->ID, 'job_listing_category', array( 'fields' => 'slugs' ) );
        if ( ! empty( $slugs ) && is_array( $slugs ) ) {
            $category_slugs = implode( ',', $slugs );
        }

        $args = apply_filters( 'front_single_job_listing_related_jobs_args', array(
            'title'     => esc_html__( 'Similar Jobs', 'front' ),
            'subtitle'  => esc_html__( 'The largest community on the web to find and list jobs that aren\'t restricted by commutes or a specific location.', 'front' ),
            'atts'      => array(
                'per_page'  => 3,
                'orderby'   => 'date',
                'order'     => 'desc',
                'view'      => 'grid',
                'categories'=> $category_slugs,
                'show_more' => false,
                'show_filters' => false,
                'columns'  => 3,
            ),
        ) );
        ?>
        <div class="container space-2">
            <div class="w-md-80 w-lg-50 text-center mx-md-auto mb-9">
                <h2 class="font-weight-medium"><?php echo apply_filters( 'front_single_job_listing_related_jobs_title', esc_html( $args['title'] ) ); ?></h2>
                <p><?php echo wp_kses_post( $args['subtitle'] ) ?></p>
            </div>
            <?php echo front_do_shortcode( 'jobs', $args['atts'] ); ?>
        </div>
        <?php
    }
}

// Style 2

if( ! function_exists( 'front_single_job_listing_v2_content_open' ) ) {
    function front_single_job_listing_v2_content_open() {
        ?><div class="container space-top-2 space-top-md-4"><?php
    }
}

if( ! function_exists( 'front_single_job_listing_v2_content' ) ) {
    function front_single_job_listing_v2_content() {
        do_action( 'single_job_listing_v2_content' );
    }
}

if( ! function_exists( 'front_single_job_listing_v2_content_max_width_open' ) ) {
    function front_single_job_listing_v2_content_max_width_open() {
        ?><div class="w-lg-80 mx-auto"><?php
    }
}

if( ! function_exists( 'front_single_job_listing_v2_content_header' ) ) {
    function front_single_job_listing_v2_content_header() {
        if( apply_filters( 'front_single_job_listing_v2_content_header_back_to_jobs_enable', true ) ) :
            if ( defined( 'JOBS_IS_ON_FRONT' ) ) {
                $link = home_url( '/' );
            } else {
                $link = get_permalink( front_wpjm_get_page_id( 'jobs' ) );
            }

            $link = apply_filters( 'front_single_job_listing_v2_content_header_back_to_jobs_link', $link );

            if( !empty( $link ) ) :
                ?>
                <div class="mb-9">
                    <a href="<?php echo esc_url( $link ); ?>" class="text-secondary">
                        <span class="fas fa-arrow-left small text-primary mr-2"></span>
                        <?php echo apply_filters( 'front_single_job_listing_v2_content_header_back_to_jobs_text', esc_html__( 'See All Jobs', 'front' ) ); ?>
                    </a>
                </div>
                <?php
            endif;
        endif;
        ?>
        <div class="row justify-content-md-between align-items-md-center mb-7">
            <?php do_action( 'single_job_listing_v2_job_header_job_data' ); ?>
        </div>
        <?php

    }
}

if( ! function_exists( 'front_single_job_listing_v2_job_header_job_data_left' ) ) {
    function front_single_job_listing_v2_job_header_job_data_left() {
        do_action( 'single_job_listing_v2_job_header_job_data_before' );
        ?>
        <div class="mb-7 mb-md-0 <?php echo esc_attr( candidates_can_apply() ? 'col-md-9' : 'col-md-12' );  ?>">
            <?php
            do_action( 'single_job_listing_v2_job_header_job_title_before' );
            the_title( '<h1 class="h3 font-weight-semi-bold">', '</h1>' );
            ?>
            <p class="mb-0">
                <?php
                echo get_the_job_location();
                if( !empty( front_get_taxomony_data( 'job_listing_type' ) ) ) :
                    if( !empty( get_the_job_location() ) ) :
                        echo apply_filters( 'front_single_job_listing_v2_content_header_location_type_spliter_text', ', ' );
                    endif;
                    echo front_get_taxomony_data( 'job_listing_type' );
                endif;
                ?>
                <span class="btn btn-xs btn-soft-danger ml-2">
                    <?php echo front_get_taxomony_data( 'job_listing_salary' ); ?>
                </span>
            </p>
            <?php
            do_action( 'single_job_listing_v2_job_header_job_title_after' );
            ?>
        </div>
        <?php
        do_action( 'single_job_listing_v2_job_header_job_data_after' );
    }
}

if( ! function_exists( 'front_single_job_listing_v2_job_header_job_data_right' ) ) {
    function front_single_job_listing_v2_job_header_job_data_right() {
        do_action( 'single_job_listing_v2_job_header_job_data_right_before' );
        if( candidates_can_apply() ) :
            ?>
            <div class="col-md-3 text-md-right">
                <a class="js-go-to btn btn-primary transition-3d-hover" href="javascript:;" data-target="#applyForJob" data-compensation="#header" data-type="static" style="display: inline-block;">
                    <?php echo apply_filters( 'front_single_job_listing_v2_content_header_apply_job_button_text', esc_html__( 'Apply Now', 'front' ) ); ?>
                </a>
            </div>
            <?php
        endif;
        do_action( 'single_job_listing_v2_job_header_job_data_right_after' );
    }
}

if( ! function_exists( 'front_single_job_listing_v2_additional_space_open' ) ) {
    function front_single_job_listing_v2_additional_space_open() {
        ?><div class="mb-9"><?php
    }
}

if( ! function_exists( 'front_single_job_listing_v2_additional_space_close' ) ) {
    function front_single_job_listing_v2_additional_space_close() {
        ?></div><?php
    }
}

if( ! function_exists( 'front_single_job_listing_v2_company_description' ) ) {
    function front_single_job_listing_v2_company_description() {
        if( function_exists( 'front_get_the_job_listing_company_excerpt' ) && !empty( $company_excerpt = front_get_the_job_listing_company_excerpt() ) ) :
            ?>
            <hr class="mt-0 mb-7">
            <div class="mb-9 text-secondary text-lh-md"><?php echo wp_kses_post( $company_excerpt ); ?></div>
            <?php
        endif;
    }
}

if( ! function_exists( 'front_single_job_listing_v2_content_max_width_close' ) ) {
    function front_single_job_listing_v2_content_max_width_close() {
        ?></div><?php
    }
}

if( ! function_exists( 'front_single_job_listing_v2_apply_job_form' ) ) {
    function front_single_job_listing_v2_apply_job_form() {
        do_action( 'single_job_listing_v2_apply_job_form_before' );
        if ( candidates_can_apply() && $apply = get_the_job_application_method() ) :
            do_action( 'job_application_start', $apply );
            $form_pretitle = apply_filters( 'front_single_job_listing_v2_apply_job_form_pretitle_text', sprintf( esc_html__( 'Join %s', 'front' ), get_bloginfo( 'name' ) ) );
            $form_title    = apply_filters( 'front_single_job_listing_v2_apply_job_form_title_text', esc_html__( 'Apply for this Job', 'front' ) );
            wp_enqueue_script( 'front-hs-go-to' );
            ?>
            <div id="applyForJob" class="job_application_details container space-2">
                <div class="card shadow-sm py-10 px-7">
                    <div class="text-center mb-7">
                        <span class="btn btn-xs btn-soft-success btn-pill mb-2"><?php echo esc_html( $form_pretitle ); ?></span>
                        <h2 class="h3 font-weight-normal"><?php echo esc_html( $form_title ); ?></h2>
                    </div>
                    <?php do_action( 'job_manager_application_details_' . $apply->type, $apply ); ?>
                </div>
            </div>
            <?php
            do_action( 'job_application_end', $apply );
        endif;
        do_action( 'single_job_listing_v2_apply_job_form_after' );
    }
}

if( ! function_exists( 'front_single_job_listing_v2_content_close' ) ) {
    function front_single_job_listing_v2_content_close() {
        ?></div><?php
    }
}

/*
 * Job Listings
 */

if( ! function_exists( 'front_job_listing_loop_header' ) ) {
    function front_job_listing_loop_header() {
        $args =  apply_filters( 'front_job_header_search_block_args', array(
            'keywords_title_text'       => esc_html__( 'what', 'front' ),
            'keywords_subtitle_text'    => esc_html__( 'job title, keywords, or company', 'front' ),
            'keywords_placeholder_text' => esc_html__( 'Keyword or title', 'front' ),
            'location_title_text'       => esc_html__( 'where', 'front' ),
            'location_subtitle_text'    => esc_html__( 'city, state, or zip code', 'front' ),
            'location_placeholder_text' => esc_html__( 'City, state, or zip', 'front' ),
            'category_title_text'       => esc_html__( 'which', 'front' ),
            'category_subtitle_text'    => esc_html__( 'department, industry, or specialism', 'front' ),
            'category_placeholder_text' => esc_html__( 'All Category', 'front' ),
            'search_button_text'        => esc_html__( 'Find Jobs', 'front' ),
        ) );

        front_job_header_search_form( $args );
    }
}

if( ! function_exists( 'front_job_listing_loop_content_open' ) ) {
    function front_job_listing_loop_content_open() {
        ?><div class="container space-2"><?php
    }
}

if( ! function_exists( 'front_job_listing_loop_controlbar' ) ) {
    function front_job_listing_loop_controlbar() {
        $layout = front_get_wpjm_job_listing_layout();
        $style = front_get_wpjm_job_listing_style();

        if( $layout !== 'fullwidth' ) :
            ?><div class="row"><div class="col-lg-9<?php echo ( 'left-sidebar' === $layout ) ? esc_attr( ' ml-lg-auto' ) : ''; ?>"><?php
        endif;

        ?>
        <div class="mb-4">
            <ul class="list-inline d-md-flex align-items-md-center mb-0">
                <?php
                do_action( 'job_listing_loop_controlbar_controls_before' );

                if( $layout === 'fullwidth' ) {
                    if( get_option( 'job_manager_enable_categories' ) ) :
                        front_wpjm_job_control_bar_dropdown( esc_html__( 'Category', 'front' ) );
                    endif;
                    if( get_option( 'job_manager_enable_salary' ) ) :
                        front_wpjm_job_control_bar_dropdown( esc_html__( 'Salary', 'front' ), 'job_listing_salary' );
                    endif;
                } else {
                    ?>
                    <li class="list-inline-item col-sm-4 col-md-6 mb-3 px-0 mb-sm-0">
                        <?php if( !empty( Front_WPJM::get_current_page_query_args() ) ) : ?>
                            <h1 class="h5 mb-0"><?php esc_html_e( 'Search results', 'front' ); ?></h1>
                        <?php else : ?>
                            <h1 class="h5 mb-0"><?php echo esc_html__( 'Jobs', 'front' ); ?></h1>
                        <?php endif; ?>
                    </li>
                    <?php
                }

                ?>
                <li class="list-inline-item mb-2 ml-md-auto">
                    <?php front_wpjm_job_catalog_ordering(); ?>
                </li>
                <li class="list-inline-item mb-2">
                    <a id="front-job-view-switcher-grid" class="btn btn-xs btn-soft-primary<?php echo 'grid' == $style ? esc_attr( ' active' ) : ''; ?>" href="#">
                        <span class="fas fa-th-large mr-2"></span>
                        <?php esc_html_e( 'Grid', 'front' ); ?>
                    </a>
                </li>
                <li class="list-inline-item mb-2">
                    <a id="front-job-view-switcher-list" class="btn btn-xs btn-soft-primary<?php echo 'list' == $style ? esc_attr( ' active' ) : ''; ?>" href="#">
                        <span class="fas fa-list mr-2"></span>
                        <?php esc_html_e( 'List', 'front' ); ?>
                    </a>
                </li>
                <?php
                do_action( 'job_listing_loop_controlbar_controls_after' );
                ?>
            </ul>
        </div>
        <?php

        if( $layout !== 'fullwidth' ) :
            ?></div></div><?php
        endif;
    }
}

if( ! function_exists( 'front_job_listing_loop_sidebar_wrap_open' ) ) {
    function front_job_listing_loop_sidebar_wrap_open() {
        $layout = front_get_wpjm_job_listing_layout();
        if( $layout !== 'fullwidth' ) :
            ?><div class="row"><div id="primary" class="content-area col-lg-9<?php echo ( 'left-sidebar' === $layout ) ? esc_attr( ' order-lg-1' ) : ''; ?>"><?php
        endif;
    }
}

if( ! function_exists( 'front_job_listing_remove_active_filters' ) ) {
    function front_job_listing_remove_active_filters() {
        if( !empty( Front_WPJM::get_current_page_query_args() ) && apply_filters( 'front_job_listing_remove_active_filters_button_enable', true ) ) :
            ?>
                <a href="<?php echo esc_url( strtok( Front_WPJM::get_current_page_url(), '?' ) ); ?>" class="btn btn-sm btn-block btn-soft-secondary transition-3d-hover">
                    <?php esc_html_e( 'Clear All', 'front' ); ?>
                </a>
            <?php
        endif;
    }
}

if( ! function_exists( 'front_job_listing_loop_sidebar_wrap_close' ) ) {
    function front_job_listing_loop_sidebar_wrap_close() {
        $layout = front_get_wpjm_job_listing_layout();
        if( $layout !== 'fullwidth' ) :
            ?></div><?php do_action( 'job_listing_sidebar' ); ?></div><?php
        endif;
    }
}

if( ! function_exists( 'front_job_listing_sidebar' ) ) {
    function front_job_listing_sidebar() {
        get_sidebar( 'job' );
    }
}

if( ! function_exists( 'front_job_listing_loop_content_close' ) ) {
    function front_job_listing_loop_content_close() {
        ?></div><?php
    }
}

if ( ! function_exists( 'front_wpjm_pagination' ) ) {
    function front_wpjm_pagination() {
        global $wp_query;
        $total   = isset( $total ) ? $total : front_wpjm_get_loop_prop( 'total_pages' );
        $current = isset( $current ) ? $current : front_wpjm_get_loop_prop( 'current_page' );
        $base    = isset( $base ) ? $base : esc_url_raw( str_replace( 999999999, '%#%', remove_query_arg( '', get_pagenum_link( 999999999, false ) ) ) );
        $format  = isset( $format ) ? $format : '';
        if ( $total <= 1 ) {
            return;
        }

        $page_links = paginate_links( apply_filters( 'front_wpjm_pagination_args', array( // WPCS: XSS ok.
            'base'         => $base,
            'format'       => $format,
            'add_args'     => false,
            'type'         => 'array',
            'current'      => max( 1, $current ),
            'total'        => $total,
            'prev_text'    => '&#171;',
            'next_text'    => '&#187;',
            'mid_size'     => 1,
        ) ) );

        if( is_array( $page_links ) && count( $page_links ) > 0 ) :
            ?>
            <div class="py-3"></div>
            <nav class="wpjm-pagination" aria-label="Page Navigation">
                <ul class="pagination justify-content-center mb-0">
                <?php
                    foreach( $page_links as $key => $page_link ) :
                        ?>
                        <li class="page-item">
                            <?php echo wp_kses_post( $page_link ); ?>
                        </li>
                        <?php
                    endforeach;
                ?>
                </ul>
            </nav>
            <?php
        endif;
    }
}

/*
 * Job Listing Item
 */

// List

if( ! function_exists( 'front_job_listing_list_card_open' ) ) {
    function front_job_listing_list_card_open() {
        ?><div class="list card mw-100 mt-0 p-0"><?php
    }
}

if( ! function_exists( 'front_job_listing_list_card_body_open' ) ) {
    function front_job_listing_list_card_body_open() {
        ?><div class="card-body p-4"><?php
    }
}

if( ! function_exists( 'front_job_listing_list_card_body_content' ) ) {
    function front_job_listing_list_card_body_content() {
        ?>
        <div class="media d-block d-sm-flex">
            <div class="u-avatar mb-3 mb-sm-0 mr-4 position-relative">
                <?php front_the_company_logo( 'thumbnail' , 'img-fluid' , false ); ?>
                <?php front_the_job_status(); ?>
            </div>
            <div class="media-body">
                <div class="media mb-2">
                    <div class="media-body mb-2">
                        <h1 class="h5 mb-1">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h1>
                        <?php front_job_listing_body_content_meta( true ); ?>
                    </div>
                    <div class="d-flex ml-auto">
                        <?php do_action( 'job_listing_list_card_body_content_additional', 'list' ) ?>
                    </div>
                </div>
                <?php if( !empty( get_the_excerpt() ) ) : ?>
                    <div class="mb-5"><?php the_excerpt(); ?></div>
                <?php elseif( !empty( front_get_the_meta_data( '_job_about' ) ) ) : ?>
                    <div class="mb-5"><?php echo '<p>' . front_get_the_meta_data( '_job_about' ) . '</p>'; ?></div>
                <?php endif; ?>
                <div class="d-md-flex align-items-md-center">
                    <?php
                        front_job_listing_list_card_body_content_bottom();
                        if( !empty( front_get_taxomony_data( 'job_listing_type' ) ) ) :
                            ?>
                            <div class="ml-md-auto">
                                <span class="btn btn-xs btn-soft-danger btn-pill"><?php echo front_get_taxomony_data( 'job_listing_type' ); ?></span>
                            </div>
                            <?php
                        endif;
                    ?>
                </div>
            </div>
        </div>
        <?php
    }
}

if( ! function_exists( 'front_job_listing_list_card_body_content_bottom' ) ) {
    function front_job_listing_list_card_body_content_bottom() {
        $args = apply_filters( 'front_job_listing_list_card_body_content_bottom_args', array(
            'job_location'  => array(
                'title'     => esc_html__( 'Location', 'front' ),
                'content'   => get_the_job_location(),
                'icon'      => 'fas fa-map-marker-alt',
            ),
            'job_published' => array(
                'title'     => esc_html__( 'Posted', 'front' ),
                'content'   => wp_kses_post( sprintf( __( '%s ago', 'front' ), human_time_diff( get_post_time( 'U' ), current_time( 'timestamp' ) ) ) ),
                'icon'      => 'fas fa-calendar-alt',
            ),
            'job_salary'    => array(
                'title'     => esc_html__( 'Salary', 'front' ),
                'content'   => front_get_taxomony_data( 'job_listing_salary' ),
                'icon'      => '',
            ),
        ) );

        if( is_array( $args ) && count( $args ) > 0 ) :
            $i = 0;
            foreach( $args as $arg ) :
                if( isset( $arg['title'], $arg['content'] ) && !empty( $arg['title'] && $arg['content'] ) ) :
                    ?>
                    <div class="<?php echo !( $i+1 === count( $args ) ) ? 'u-ver-divider u-ver-divider--none-md pr-4 mb-3 mb-md-0 mr-4' : 'mb-3 mb-md-0'; ?>">
                        <h2 class="small text-secondary mb-0"><?php echo wp_kses_post( $arg['title'] ); ?></h2>
                        <?php if( isset( $arg['icon'] ) && !empty( $arg['icon'] ) ) : ?>
                            <small class="text-secondary align-middle mr-1 <?php echo esc_attr( $arg['icon'] ); ?>"></small>
                        <?php endif; ?>
                        <span class="align-middle"><?php echo wp_kses_post( $arg['content'] ); ?></span>
                    </div>
                    <?php
                    $i++;
                endif;
            endforeach;
        endif;
    }
}

if( ! function_exists( 'front_job_listing_list_card_body_close' ) ) {
    function front_job_listing_list_card_body_close() {
        ?></div><?php
    }
}

if( ! function_exists( 'front_job_listing_list_card_close' ) ) {
    function front_job_listing_list_card_close() {
        ?></div><?php
    }
}

// Grid

if( ! function_exists( 'front_job_listing_grid_card_open' ) ) {
    function front_job_listing_grid_card_open() {
        ?><div class="grid card h-100 mw-100 mt-0 p-0"><?php
    }
}

if( ! function_exists( 'front_job_listing_grid_card_body_open' ) ) {
    function front_job_listing_grid_card_body_open() {
        ?><div class="card-body p-4"><?php
    }
}

if( ! function_exists( 'front_job_listing_grid_card_body_content_head' ) ) {
    function front_job_listing_grid_card_body_content_head() {
        ?>
        <div class="d-flex align-items-center mb-5">
            <?php do_action( 'job_listing_grid_card_body_content_head', 'grid' ); ?>
        </div>
        <?php
    }
}

if( ! function_exists( 'front_job_listing_grid_card_body_content' ) ) {
    function front_job_listing_grid_card_body_content() {
        ?>
        <div class="text-center">
            <div class="u-lg-avatar mx-auto mb-3 position-relative">
                <?php front_the_company_logo( 'thumbnail' , 'img-fluid' , false ); ?>
                <?php front_the_job_status(); ?>
            </div>
            <div class="mb-4">
                <h1 class="h5 mb-1">
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </h1>
                <?php front_job_listing_body_content_meta( false ); ?>
            </div>
            <?php
                if( !empty( front_get_the_meta_data( '_job_about' ) ) ) :
                    echo '<p>' . front_get_the_meta_data( '_job_about' ) . '</p>';
                elseif( !empty( front_get_the_meta_data( '_job_about' ) ) ) :
                    the_excerpt();
                endif;
            ?>
        </div>
        <?php
    }
}

if( ! function_exists( 'front_job_listing_grid_card_body_close' ) ) {
    function front_job_listing_grid_card_body_close() {
        ?></div><?php
    }
}

if( ! function_exists( 'front_job_listing_grid_card_footer' ) ) {
    function front_job_listing_grid_card_footer() {
        $args = apply_filters( 'front_job_listing_grid_card_footer_args', array(
            'job_location'  => array(
                'title'     => esc_html__( 'Location', 'front' ),
                'content'   => get_the_job_location(),
                'icon'      => 'fas fa-map-marker-alt',
            ),
            'job_salary'    => array(
                'title'     => esc_html__( 'Salary', 'front' ),
                'content'   => front_get_taxomony_data( 'job_listing_salary' ),
                'icon'      => '',
            ),
        ) );

        if( is_array( $args ) && count( $args ) > 0 ) :
            $i = 0;
            ?><div class="card-footer text-center py-4"><div class="row align-items-center"><?php
                foreach( $args as $arg ) :
                    if( isset( $arg['title'], $arg['content'] ) && !empty( $arg['title'] && $arg['content'] ) ) :
                        ?>
                        <div class="col-6<?php echo esc_attr( ( $i%2 == 0 && !( $i+1 === count( $args ) ) ) ? ' u-ver-divider' : '' ); ?>">
                            <h2 class="small text-secondary mb-0"><?php echo wp_kses_post( $arg['title'] ); ?></h2>
                            <?php if( isset( $arg['icon'] ) && !empty( $arg['icon'] ) ) : ?>
                                <small class="text-secondary align-middle mr-1 <?php echo esc_attr( $arg['icon'] ); ?>"></small>
                            <?php endif; ?>
                            <span class="align-middle"><?php echo wp_kses_post( $arg['content'] ); ?></span>
                        </div>
                        <?php
                        $i++;
                    endif;
                endforeach;
            ?></div></div><?php
        endif;
    }
}

if( ! function_exists( 'front_job_listing_grid_card_close' ) ) {
    function front_job_listing_grid_card_close() {
        ?></div><?php
    }
}

if( ! function_exists( 'front_job_listing_body_content_meta' ) ) {
    function front_job_listing_body_content_meta( $icon = true ) {
        ?>
        <ul class="list-inline font-size-1 text-muted mb-3">
            <?php do_action( 'job_listing_body_content_meta_before' ); ?>
            <li class="list-inline-item">
                <?php
                if( !empty( $company = front_get_the_job_listing_company() ) ) :
                    ?>
                    <a class="link-muted" href="<?php the_permalink( $company ); ?>">
                        <?php
                        if( $icon ) echo '<span class="fas fa-building mr-1"></span>';
                        echo esc_html( $company->post_title );
                        ?>
                    </a>
                    <?php
                else :
                    if( $icon ) echo '<span class="fas fa-building mr-1"></span>';
                    the_company_name();
                endif;
                ?>
            </li>
            <?php
            if( !empty( front_get_taxomony_data( 'job_listing_working_environment' ) ) ) :
                ?>
                <li class="list-inline-item text-muted">&bull;</li>
                <li class="list-inline-item">
                    <?php echo front_get_taxomony_data( 'job_listing_working_environment' ); ?>
                </li>
                <?php
            endif;
            do_action( 'job_listing_body_content_meta_after' );
            ?>
        </ul>
        <?php
    }
}

if( ! function_exists( 'front_job_listing_body_content_review' ) ) {
    function front_job_listing_body_content_review( $view = 'grid' ) {
        $company = front_get_the_job_listing_company();
        if( front_is_mas_wp_job_manager_company_review_activated() && $company && ( $review_average = mas_wpjmcr_get_reviews_average( $company->ID ) ) ) :
            $rating_dropdown_id = "ratingDropdown-" . get_the_ID() . $view;
            $rating_dropdown_invoker_id = "ratingDropdownInvoker-" . get_the_ID() . $view;
            wp_enqueue_script( 'front-hs-unfold' );
            ?>
            <div class="position-relative<?php echo esc_attr( $view == 'list' ? ' d-inline-block' : '' ); ?>">
                <a id="<?php echo esc_attr( $rating_dropdown_invoker_id ); ?>" class="btn btn-xs btn-soft-warning btn-pill" href="javascript:;" role="button" aria-controls="<?php echo esc_attr( $rating_dropdown_id ); ?>" aria-haspopup="true" aria-expanded="false" data-unfold-event="hover" data-unfold-target="#<?php echo esc_attr( $rating_dropdown_id ); ?>" data-unfold-type="css-animation" data-unfold-duration="300" data-unfold-delay="300" data-unfold-hide-on-scroll="true" data-unfold-animation-in="slideInUp" data-unfold-animation-out="fadeOut">
                    <?php echo number_format( $review_average, 1, '.', ''); ?>
                </a>
                <div id="<?php echo esc_attr( $rating_dropdown_id ); ?>" class="dropdown-menu dropdown-unfold p-3<?php echo esc_attr( $view == 'list' ? ' dropdown-menu-right' : '' ); ?>" aria-labelledby="<?php echo esc_attr( $rating_dropdown_invoker_id ); ?>" style="width: 190px;">
                    <div class="d-flex align-items-center mb-2">
                        <span class="text-warning mr-2"><?php echo number_format( $review_average, 1, '.', ''); ?></span>
                        <ul class="list-inline mb-0">
                            <li class="list-inline-item text-warning">
                                <?php for ( $i = 0; $i < mas_wpjmcr_get_max_stars(); $i++ ) : ?>
                                    <span class="<?php echo esc_attr( $i < $review_average ? 'fas' : 'far' ); ?> fa-star"></span>
                                <?php endfor; ?>
                            </li>
                        </ul>
                    </div>
                    <p class="text-dark mb-0"><?php esc_html_e( 'Overal Rating', 'front' ) ?></p>
                    <p class="mb-0">
                        <?php echo sprintf( _n( 'Based on %s review', 'Based on %s reviews', intval( mas_wpjmcr_get_reviews_count( $company->ID ) ), 'front' ), intval( mas_wpjmcr_get_reviews_count( $company->ID ) ) ); ?>
                    </p>
                </div>
            </div>
            <?php
        elseif( front_is_mas_wp_job_manager_company_review_activated() && $company && apply_filters( 'front_job_listing_show_nan_reviewe_label', false ) ) :
            ?>
            <div class="position-relative<?php echo esc_attr( $view == 'list' ? ' d-inline-block' : '' ); ?>">
                <a class="btn btn-xs btn-soft-warning btn-pill" href="<?php echo  esc_url( get_permalink( $company ) . '#comments' ); ?>">
                    <?php esc_html_e( 'NaN', 'front' ); ?>
                </a>
            </div>
            <?php
        endif;
    }
}

if( ! function_exists( 'front_job_listing_body_content_bookmark' ) ) {
    function front_job_listing_body_content_bookmark( $view = 'grid' ) {
        global $job_manager_bookmarks;
        ?>
        <div class="<?php echo esc_attr( $view === 'grid' ? 'ml-auto' : 'ml-2' ) ?>">
            <?php $job_manager_bookmarks->bookmark_form(); ?>
        </div>
        <?php
    }
}

// List Grid

if( ! function_exists( 'front_job_listing_list_grid_card_open' ) ) {
    function front_job_listing_list_grid_card_open() {
        ?><div class="list-grid card card-frame transition-3d-hover h-100 mw-100 mt-0 p-0"><?php
    }
}

if( ! function_exists( 'front_job_listing_list_grid_card_body_open' ) ) {
    function front_job_listing_list_grid_card_body_open() {
        ?><a href="<?php the_permalink(); ?>" class="card-body p-3"><?php
    }
}

if( ! function_exists( 'front_job_listing_list_grid_card_body_content' ) ) {
    function front_job_listing_list_grid_card_body_content() {
        ?>
        <div class="media">
            <div class="u-avatar position-relative">
                <?php front_the_company_logo( 'thumbnail' , 'img-fluid' , false ); ?>
                <?php front_the_job_status(); ?>
            </div>
            <div class="media-body px-4">
                <h4 class="h6 text-dark mb-1"><?php the_title(); ?></h4>
                <small class="d-block text-muted"><?php echo get_the_job_location(); ?></small>
            </div>
        </div>
        <?php
    }
}

if( ! function_exists( 'front_job_listing_list_grid_card_body_close' ) ) {
    function front_job_listing_list_grid_card_body_close() {
        ?></a><?php
    }
}

if( ! function_exists( 'front_job_listing_list_grid_card_close' ) ) {
    function front_job_listing_list_grid_card_close() {
        ?></div><?php
    }
}

// List Small

if( ! function_exists( 'front_job_listing_list_small_card_open' ) ) {
    function front_job_listing_list_small_card_open() {
        ?><a href="<?php the_permalink(); ?>" class="list-small card card-frame card-text-dark mw-100 mt-0 p-0"><?php
    }
}

if( ! function_exists( 'front_job_listing_list_small_card_body_open' ) ) {
    function front_job_listing_list_small_card_body_open() {
        ?><div href="<?php the_permalink(); ?>" class="card-body p-4"><?php
    }
}

if( ! function_exists( 'front_job_listing_list_small_card_body_content' ) ) {
    function front_job_listing_list_small_card_body_content() {
        ?>
        <div class="row justify-content-sm-between align-items-sm-center">
            <span class="col-sm-6 mb-2 mb-sm-0"><?php the_title(); ?></span>
            <span class="col-sm-6 text-primary text-sm-right">
                <?php echo get_the_job_location(); ?>
                <span class="fas fa-arrow-right small ml-2"></span>
            </span>
        </div>
        <?php
    }
}

if( ! function_exists( 'front_job_listing_list_small_card_body_close' ) ) {
    function front_job_listing_list_small_card_body_close() {
        ?></div><?php
    }
}

if( ! function_exists( 'front_job_listing_list_small_card_close' ) ) {
    function front_job_listing_list_small_card_close() {
        ?></a><?php
    }
}

// Grid Small

if( ! function_exists( 'front_job_listing_grid_small_card_open' ) ) {
    function front_job_listing_grid_small_card_open() {
        ?><div class="grid-small card card-frame text-center h-100 mw-100 mt-0 p-0"><?php
    }
}

if( ! function_exists( 'front_job_listing_grid_small_card_body_open' ) ) {
    function front_job_listing_grid_small_card_body_open() {
        ?><div class="card-body p-6"><?php
    }
}

if( ! function_exists( 'front_job_listing_grid_small_card_body_content' ) ) {
    function front_job_listing_grid_small_card_body_content() {
        ?>
        <div class="u-avatar mx-auto mb-4 position-relative">
            <?php front_the_company_logo( 'thumbnail', 'img-fluid rounded', false ); ?>
            <?php front_the_job_status(); ?>
        </div>
        <div class="mb-4">
            <h4 class="h6 mb-1"><?php the_title(); ?></h4>
            <p><?php echo get_the_job_location(); ?></p>
        </div>
        <a class="btn btn-sm btn-soft-primary btn-wide" href="<?php the_permalink(); ?>"><?php echo esc_html__( 'View Details', 'front' ); ?></a>
        <?php
    }
}

if( ! function_exists( 'front_job_listing_grid_small_card_body_close' ) ) {
    function front_job_listing_grid_small_card_body_close() {
        ?></div><?php
    }
}

if( ! function_exists( 'front_job_listing_grid_small_card_close' ) ) {
    function front_job_listing_grid_small_card_close() {
        ?></div><?php
    }
}

if ( ! function_exists( 'front_wp_job_manager_alert_form_body_class' ) ) {
    function front_wp_job_manager_alert_form_body_class( $classes ) {
        if( get_option( 'job_manager_alerts_page_id' ) && is_page( get_option( 'job_manager_alerts_page_id' ) ) ) {
            $classes[] = 'job-manager-alert-pages';
        }

        return $classes;
    }
}

if ( ! function_exists( 'front_wpjm_alert_link' ) ) {
    /**
     * alert link
     */
    function front_wpjm_alert_link( $links, $args ) {
        if ( is_user_logged_in() && get_option( 'job_manager_alerts_page_id' ) ) {
            if( isset( $links['alert'] ) ) {
                unset( $links['alert'] );
            }

            if ( isset( $_POST[ 'form_data' ] ) ) {
                parse_str( $_POST[ 'form_data' ], $params );
                $alert_regions = isset( $params[ 'search_region' ] ) ? absint( $params[ 'search_region' ] ) : '';
            } else {
                $alert_regions = '';
            }

            $links['alert_link'] = array(
                'name' => esc_html__( 'Add alert', 'front' ),
                'url'  => add_query_arg( array(
                    'action'         => 'add_alert',
                    'alert_job_type' => $args['filter_job_types'],
                    'alert_location' => urlencode( $args['search_location'] ),
                    'alert_cats'     => $args['search_categories'],
                    'alert_keyword'  => urlencode( $args['search_keywords'] ),
                    'alert_regions'  => $alert_regions,
                ), get_permalink( get_option( 'job_manager_alerts_page_id' ) ) )
            );
        }

        return $links;
    }
}

if( ! function_exists( 'front_wpjm_single_alert_link' ) ) {
    /**
     * Single listing alert link
     */
    function front_wpjm_single_alert_link() {
        global $post, $job_preview;

        if ( ! empty( $job_preview ) ) {
            return;
        }

        if ( is_user_logged_in() && get_option( 'job_manager_alerts_page_id' ) ) {
            $job_types = wpjm_get_the_job_types( $post );
            $args = array(
                'action'         => 'add_alert',
                'alert_name'     => urlencode( $post->post_title ),
                'alert_job_type' => wp_list_pluck( $job_types, 'slug' ),
                'alert_location' => urlencode( strip_tags( get_the_job_location( $post ) ) ),
                'alert_cats'     => taxonomy_exists( 'job_listing_category' ) ? wp_get_post_terms( $post->ID, 'job_listing_category', array( 'fields' => 'ids' ) ) : '',
                'alert_keyword'  => urlencode( $post->post_title ),
                'alert_regions'  => taxonomy_exists( 'job_listing_region' ) ? current( wp_get_post_terms( $post->ID, 'job_listing_region', array( 'fields' => 'ids' ) ) ) : '',
            );

            $args = apply_filters( 'job_manager_alerts_single_listing_link', $args );
            $link = add_query_arg( $args, get_permalink( get_option( 'job_manager_alerts_page_id' ) ) );

            ?>
            <p class="front-wpjm-single-alert-link text-center">
                <a href="<?php echo esc_url( $link ); ?>" class="front-wpjm-single-alert__button button btn btn-primary transition-3d-hover"><?php esc_html_e( 'Alert me to jobs like this', 'front' ); ?></a>
            </p>
            <?php
        }
    }
}
