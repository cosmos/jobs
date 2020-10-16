<?php

if ( ! function_exists( 'front_wpjmr_custom_submit_resume_form_fields' ) ) {
    function front_wpjmr_custom_submit_resume_form_fields( $fields ) {
        if ( $max = get_option( 'resume_manager_max_skills' ) ) {
            $max = ' ' . sprintf( esc_html__( 'Maximum of %d.', 'front' ), $max );
        }
        $fields['resume_fields']['resume_skills']['type'] = 'tag-input';
        $fields['resume_fields']['resume_skills']['placeholder'] =  esc_html__( 'List of Relevant skills', 'front' );
        $fields['resume_fields']['resume_skills']['description'] =  esc_html__( 'list of relevant skills seperate with Enter key', 'front' ) . $max;

        $fields['resume_fields']['candidate_website'] = array(
            'label'       => esc_html__( 'Website', 'front' ),
            'type'        => 'text',
            'placeholder' => esc_html__( 'your website link', 'front' ),
            'priority'    => 6,
            'required'    => false
        );
        $fields['resume_fields']['candidate_twitter'] = array(
            'label'       => esc_html__( 'Twitter', 'front' ),
            'type'        => 'text',
            'placeholder' => esc_html__( 'your twitter page link', 'front' ),
            'priority'    => 6,
            'required'    => false
        );
        $fields['resume_fields']['candidate_facebook'] = array(
            'label'       => esc_html__( 'Facebook', 'front' ),
            'type'        => 'text',
            'placeholder' => esc_html__( 'your facebook page link', 'front' ),
            'priority'    => 6,
            'required'    => false
        );
        $fields['resume_fields']['candidate_pay_scale'] = array(
            'label'       => esc_html__( 'Salary', 'front' ),
            'type'        => 'text',
            'placeholder' => esc_html__( 'expected salery per hr/m/a', 'front' ),
            'priority'    => 6,
            'required'    => false
        );
        $fields['resume_fields']['candidate_work_done'] = array(
            'label'       => esc_html__( 'Jobs Done', 'front' ),
            'type'        => 'text',
            'placeholder' => esc_html__( 'works done yet', 'front' ),
            'priority'    => 6,
            'required'    => false
        );
        $fields['resume_fields']['candidate_success_rate'] = array(
            'label'       => esc_html__( 'Success rate', 'front' ),
            'type'        => 'text',
            'placeholder' => esc_html__( 'rate of successful jobs yet', 'front' ),
            'priority'    => 6,
            'required'    => false
        );
        $fields['resume_fields']['candidate_twitter'] = array(
            'label'       => esc_html__( 'Twitter', 'front' ),
            'type'        => 'text',
            'placeholder' => esc_html__( 'your twitter page link', 'front' ),
            'priority'    => 6,
            'required'    => false
        );
        $fields['resume_fields']['candidate_bio'] = array(
            'label'       => esc_html__( 'Candidate Bio', 'front' ),
            'type'        => 'textarea',
            'placeholder' => esc_html__( 'short notes about your self', 'front' ),
            'priority'    => 8,
            'required'    => false
        );
        $fields['resume_fields']['candidate_rewards'] = array(
            'label'       => esc_html__( 'Rewards', 'front' ),
            'add_row'     => esc_html__( 'Add Rewards', 'front' ),
            'type'        => 'repeated', // repeated
            'required'    => false,
            'placeholder' => '',
            'priority'    => 12,
            'fields'      => array(
                'reward_title' => array(
                    'label'       => esc_html__( 'Reward Title', 'front' ),
                    'type'        => 'text',
                    'required'    => true,
                    'placeholder' => '',
                    'description' => ''
                ),
                'reward_image' => array(
                    'label'       => esc_html__( 'Image', 'front' ),
                    'type'        => 'file',
                    'required'    => true,
                    'placeholder' => '',
                    'description' => ''
                ),
            )
        );
        $fields['resume_fields']['candidate_languages'] = array(
            'label'       => esc_html__( 'Languages', 'front' ),
            'add_row'     => esc_html__( 'Add Languages', 'front' ),
            'type'        => 'repeated', // repeated
            'required'    => false,
            'placeholder' => '',
            'priority'    => 12,
            'fields'      => array(
                'language_name' => array(
                    'label'       => esc_html__( 'Language', 'front' ),
                    'type'        => 'text',
                    'required'    => true,
                    'placeholder' => '',
                    'description' => ''
                ),
                'language_level' => array(
                    'label'       => esc_html__( 'Level of known', 'front' ),
                    'type'        => 'text',
                    'required'    => true,
                    'placeholder' => '',
                    'description' => ''
                ),
            )
        );
        return $fields;
    }
}

if( ! function_exists( 'front_submit_resume_form_fields_get_resume_data' ) ) {
    function front_submit_resume_form_fields_get_resume_data( $group_fields, $resume ){
        foreach ( $group_fields as $group_key => $fields ) {
            foreach ( $fields as $key => $field ) {
                if( isset( $field['type'] ) && ( $field['type'] == 'term-multiselect' ) && isset( $field['taxonomy'] ) ) {
                    $group_fields[ $group_key ][ $key ]['value'] = wp_get_object_terms( $resume->ID, $field['taxonomy'], array( 'fields' => 'ids' ) );
                }
            }
        }
        return $group_fields;
    }
}

/*
 * Single Resume
 */

if( ! function_exists( 'front_single_resume_content_open' ) ) {
    function front_single_resume_content_open() {
        ?><div class="container space-2"><div class="row"><?php
    }
}

if( ! function_exists( 'front_single_resume_sidebar' ) ) {
    function front_single_resume_sidebar() {
        ?>
        <div class="col-lg-4 mb-9 mb-lg-0">
            <div class="card shadow-sm p-5 mb-5">
                <?php do_action( 'single_resume_sidebar' ); ?>
            </div>
        </div>
        <?php
    }
}

if( ! function_exists( 'front_single_resume_content' ) ) {
    function front_single_resume_content() {
        ?>
        <div class="col-lg-8">
            <div class="pl-lg-4">
                <?php do_action( 'single_resume_content' ); ?>
            </div>
        </div>
        <?php
    }
}

if( ! function_exists( 'front_single_resume_content_close' ) ) {
    function front_single_resume_content_close() {
        ?></div></div><?php
    }
}

if( ! function_exists( 'front_single_resume_description' ) ) {
    function front_single_resume_description() {
        if( !empty( get_the_content() ) ) :
            ?>
            <div class="mb-4">
                <h2 class="h5"><?php esc_html_e( 'About Candidate', 'front' ) ?></h2>
            </div>
            <div class="mb-5">
                <?php echo apply_filters( 'the_resume_description', get_the_content() ); ?>
            </div>
            <?php
        endif;
    }
}

if( ! function_exists( 'front_single_resume_sidebar_details' ) ) {
    function front_single_resume_sidebar_details() {
        global $post;
        ?>
        <div class="text-center">
            <div class="<?php  echo esc_attr( ! get_the_candidate_photo() && apply_filters( 'front_enable_candidate_photo_default_text_placeholder', true )  ? 'btn btn-lg btn-icon btn-soft-primary rounded-circle mb-3' : 'mb-3 mx-auto' ); ?>" style="word-break: initial;">
                <?php front_the_candidate_photo( 'thumbnail', 'candidiate-image img-fluid rounded-circle max-width-15', '' ); ?>
            </div>
            <?php the_title( '<h1 class="h5">', '</h1>' ); ?>
            <ul class="list-inline text-secondary font-size-1 mb-4">
                <?php if( ! empty( front_get_the_meta_data( '_candidate_location', null, 'resume' ) ) ) : ?>
                    <li class="list-inline-item">
                        <small class="fas fa-map-marker-alt mr-1"></small>
                        <?php echo esc_html( front_get_the_meta_data( '_candidate_location', null, 'resume' ) ); ?>
                    </li>
                    <li class="list-inline-item text-muted">&bull;</li>
                <?php endif; ?>
                <li class="list-inline-item">
                    <?php echo wp_kses_post( sprintf( __( 'Joined %s', 'front' ), get_post_time( 'M Y' ) ) ); ?>
                </li>
            </ul>
            <?php
            if( ! empty( front_get_the_meta_data( '_candidate_email', null, 'resume' ) ) ) :
                get_job_manager_template( 'contact-details.php', array( 'post' => $post ), 'wp-job-manager-resumes', RESUME_MANAGER_PLUGIN_DIR . '/templates/' );
            endif;
            if ( resume_has_file() ) :
                get_job_manager_template( 'content-resume-file.php', array( 'post' => $post ), 'wp-job-manager-resumes', RESUME_MANAGER_PLUGIN_DIR . '/templates/' );
            endif;
            do_action( 'single_resume_details_after' );
            ?>
        </div>
        <?php
    }
}

if( ! function_exists( 'front_single_resume_sidebar_svg_icon_block' ) ) {
    function front_single_resume_sidebar_svg_icon_block() {
        $args = apply_filters( 'front_single_resume_sidebar_svg_icon_block_elements_args', array(
            'candidate_pay_scale'  => array(
                'text_1' => front_get_the_meta_data( '_candidate_pay_scale', null, 'resume' ),
                'text_2' => esc_html__( 'Working rate', 'front' ),
                'svg'    => '/assets/svg/icons/icon-35.svg',
            ),
            'candidate_work_done'  => array(
                'text_1' => front_get_the_meta_data( '_candidate_work_done', null, 'resume' ),
                'text_2' => esc_html__( 'Jobs done', 'front' ),
                'svg'    => '/assets/svg/icons/icon-37.svg',
            ),
            'candidate_success_rate'  => array(
                'text_1' => front_get_the_meta_data( '_candidate_success_rate', null, 'resume' ),
                'text_2' => esc_html__( 'Success rate', 'front' ),
                'svg'    => '/assets/svg/icons/icon-5.svg',
            ),
            'candidate_clients'  => array(
                'text_1' => front_get_the_meta_data( '_candidate_clients', null, 'resume' ),
                'text_2' => esc_html__( 'Repeat clients', 'front' ),
                'svg'    => '/assets/svg/icons/icon-7.svg',
            ),
        ) );

        $args['dataParent'] = '#SVGemployeeStatsIcon';

        if( is_array( $args ) && count( $args ) > 0 ) {
            if( ! empty( front_single_sidebar_get_svg_icon_block_content( $args ) ) ) {
                ?><div class="border-top pt-5 mt-5"><div id="SVGemployeeStatsIcon" class="row"><?php
                    echo front_single_sidebar_get_svg_icon_block_content( $args );
                ?></div></div><?php
            }
        }
    }
}

if( ! function_exists( 'front_single_resume_sidebar_bio' ) ) {
    function front_single_resume_sidebar_bio() {
        if( empty( $candidate_bio = front_get_the_meta_data( '_candidate_bio', null, 'resume', true ) ) ) :
            $candidate_bio = get_the_excerpt();
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

if( ! function_exists( 'front_single_resume_sidebar_languages' ) ) {
    function front_single_resume_sidebar_languages() {
        global $post;
        if ( $items = get_post_meta( $post->ID, '_candidate_languages', true ) ) :
            ?>
            <div class="border-top pt-5 mt-5">
                <h3 class="font-size-1 font-weight-semi-bold text-uppercase mb-3"><?php esc_html_e( 'Languages', 'front' ); ?></h3>
                <?php
                foreach( $items as $item ) :
                    ?>
                    <span class="d-block font-size-1 font-weight-medium mb-1">
                        <?php
                            echo esc_html( $item['language_name'] );
                            if( ! empty ( $item['language_level'] ) ) :
                                ?> - <span class="text-muted font-weight-normal"><?php echo esc_html( $item['language_level'] ); ?></span><?php
                            endif;
                        ?>
                    </span>
                    <?php
                endforeach;
                ?>
            </div>
            <?php
        endif;
    }
}

if( ! function_exists( 'front_single_resume_sidebar_skills' ) ) {
    function front_single_resume_sidebar_skills() {
        global $post;

        if ( taxonomy_exists( $taxonomy = 'resume_skill' ) ) :
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
                $links[] = '<a href="' . esc_url( $link ) . '" rel="tag" class="btn btn-xs btn-gray mb-1">' . $skill->name . '</a>';
            endforeach;

            ?>
            <div class="border-top pt-5 mt-5">
                <h3 class="font-size-1 font-weight-semi-bold text-uppercase mb-3"><?php esc_html_e( 'Skills:', 'front' ) ?></h3>
                <?php
                    foreach ( $skills as $skill ) :
                        ?>
                        <a class="btn btn-xs btn-gray mb-1" href="<?php echo esc_url( get_term_link( $skill, $taxonomy ) ); ?>" rel="tag">
                            <?php echo esc_html( $skill->name ); ?>
                        </a>
                        <?php
                    endforeach;
                ?>
            </div>
            <?php
        endif;
    }
}

if( ! function_exists( 'front_single_resume_sidebar_rewards_categories' ) ) {
    function front_single_resume_sidebar_rewards_categories() {
        global $post;
        $items = get_post_meta( $post->ID, '_candidate_rewards', true );
        $categories = front_get_taxomony_data( 'resume_category' );
        if ( ! empty( $items ) || ! empty( $categories ) ) :
            wp_enqueue_script( 'front-hs-fancybox' );
            ?>
            <div class="border-top pt-5 mt-5">
                <?php if ( ! empty( $items ) ) : ?>
                    <h3 class="font-size-1 font-weight-semi-bold text-uppercase mb-3"><?php esc_html_e( 'Rewards', 'front' ); ?></h3>
                    <div class="mb-3">
                        <?php
                        foreach( $items as $item ) :
                            if( ! empty ( $item['reward_image'] ) ) :
                                ?>
                                <a class="js-fancybox" href="javascript:;" data-src="<?php echo esc_url( $item['reward_image'] ) ?>" data-fancybox="fancyboxGallery6" data-caption="<?php echo esc_attr( $item['reward_title'] ); ?>" data-speed="700" data-is-infinite="true">
                                    <img class="max-width-5 mr-1" src="<?php echo esc_url( $item['reward_image'] ) ?>" alt="Image Description" title="<?php echo esc_html( $item['reward_title'] ); ?>">
                                </a>
                                <?php
                            endif;
                        endforeach;
                        ?>
                    </div>
                <?php endif; ?>
                <?php if ( ! empty( $categories ) ) : ?>
                    <p class="small mb-0">
                        <?php echo wp_kses_post( sprintf( __( 'Industry expertise: %s', 'front' ), $categories ) ); ?>
                    </p>
                <?php endif; ?>
            </div>
            <?php
        endif;
    }
}

if( ! function_exists( 'front_single_resume_education' ) ) {
    function front_single_resume_education() {
        global $post;
        if ( $items = get_post_meta( $post->ID, '_candidate_education', true ) ) :
            ?>
            <div class="mb-4">
                <h2 class="h5"><?php esc_html_e( 'Education', 'front' ); ?></h2>
            </div>
            <!-- Education Info -->
            <div class="mb-5">
                <ul class="list-unstyled u-indicator-vertical-dashed">
                <?php foreach( $items as $item ) : ?>
                    <li class="media u-indicator-vertical-dashed-item">
                        <span class="btn btn-xs btn-icon btn-soft-success rounded-circle mr-3">
                        <span class="btn-icon__inner"><?php echo esc_html( mb_substr( $item['location'], 0 ,1 ) ); ?></span>
                        </span>
                        <div class="media-body">
                            <?php if( ! empty( $item['qualification'] ) ) : ?>
                                <h4 class="h6"><?php echo esc_html( $item['qualification'] ); ?></h4>
                            <?php endif; ?>
                            <ul class="list-unstyled font-size-1 text-secondary mb-0">
                                <li><?php echo esc_html( $item['location'] ); ?></li>
                                <?php if( ! empty( $item['date'] ) ) : ?>
                                    <li><?php echo esc_html( $item['date'] ); ?></li>
                                <?php endif; ?>
                                <?php if( ! empty( $item['notes'] ) ) : ?>
                                    <li><?php echo wp_kses_post( $item['notes'] ); ?></li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </li>
                <?php endforeach; ?>
                </ul>
            </div>
            <!-- End Education Info -->
            <?php
        endif;
    }
}

if( ! function_exists( 'front_single_resume_experience' ) ) {
    function front_single_resume_experience() {
        global $post;
        if ( $items = get_post_meta( $post->ID, '_candidate_experience', true ) ) :
            ?>
            <div class="mb-4">
                <h2 class="h5"><?php esc_html_e( 'Work experience', 'front' ); ?></h2>
            </div>
            <!-- Work Experience Info -->
            <div class="mb-5">
                <ul class="list-unstyled u-indicator-vertical-dashed">
                <?php foreach( $items as $item ) : ?>
                    <li class="media u-indicator-vertical-dashed-item">
                        <span class="btn btn-xs btn-icon btn-soft-success rounded-circle mr-3">
                        <span class="btn-icon__inner"><?php echo esc_html( mb_substr( $item['employer'], 0 ,1 ) ); ?></span>
                        </span>
                        <div class="media-body">
                            <?php if( ! empty( $item['job_title'] ) ) : ?>
                                <h4 class="h6"><?php echo esc_html( $item['job_title'] ); ?></h4>
                            <?php endif; ?>
                            <ul class="list-unstyled font-size-1 text-secondary mb-0">
                                <li>
                                    <?php if ( $company = get_page_by_title( $item['employer'], OBJECT, 'company' ) ) : ?>
                                        <a href="<?php echo get_the_permalink( $company ); ?>">
                                            <?php echo esc_html( $item['employer'] ); ?>
                                        </a>
                                    <?php else : ?>
                                        <?php echo esc_html( $item['employer'] ); ?>
                                    <?php endif; ?>
                                </li>
                                <?php if( ! empty( $item['date'] ) ) : ?>
                                    <li><?php echo esc_html( $item['date'] ); ?></li>
                                <?php endif; ?>
                                <?php if( ! empty( $item['notes'] ) ) : ?>
                                    <li><?php echo wp_kses_post( $item['notes'] ); ?></li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </li>
                <?php endforeach; ?>
                </ul>
            </div>
            <!-- End Work Experience Info -->
            <?php
        endif;
    }
}

if( ! function_exists( 'front_single_resume_linked_accounts' ) ) {
    function front_single_resume_linked_accounts() {
        $args = apply_filters( 'front_single_resume_linked_accounts_args', array(
            'website'   => array(
                'text'  => get_the_title(),
                'link'  => front_get_the_meta_data( '_candidate_website', null, 'resume', true ),
                'image' => get_the_candidate_photo() ? job_manager_get_resized_image( get_the_candidate_photo(), 'thumnail' ) : apply_filters( 'resume_manager_default_candidate_photo', RESUME_MANAGER_PLUGIN_URL . '/assets/images/candidate.png' ),
            ),
            'twitter'   => array(
                'text'  => esc_html__( 'Twitter', 'front' ),
                'link'  => front_get_the_meta_data( '_candidate_twitter', null, 'resume', true ),
                'image' => get_template_directory_uri() . '/assets/img/160x160/img19.png',
            ),
            'facebook'  => array(
                'text'  => esc_html__( 'Facebook', 'front' ),
                'link'  => front_get_the_meta_data( '_candidate_facebook', null, 'resume', true ),
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

/*
 * Resume Listings
 */

if( ! function_exists( 'front_resume_listing_loop_header' ) ) {
    function front_resume_listing_loop_header() {
        $args =  apply_filters( 'front_resume_header_search_block_args', array(
            'keywords_title_text'       => esc_html__( 'what', 'front' ),
            'keywords_subtitle_text'    => esc_html__( 'candidate name, position or keywords', 'front' ),
            'keywords_placeholder_text' => esc_html__( 'Keyword or name', 'front' ),
            'location_title_text'       => esc_html__( 'where', 'front' ),
            'location_subtitle_text'    => esc_html__( 'city, state, or zip code', 'front' ),
            'location_placeholder_text' => esc_html__( 'City, state, or zip', 'front' ),
            'category_title_text'       => esc_html__( 'which', 'front' ),
            'category_subtitle_text'    => esc_html__( 'department, industry, or specialism', 'front' ),
            'category_placeholder_text' => esc_html__( 'All Category', 'front' ),
            'search_button_text'        => esc_html__( 'Find Candidate', 'front' ),
        ) );

        front_resume_header_search_form( $args );
    }
}

if( ! function_exists( 'front_resume_listing_loop_content_open' ) ) {
    function front_resume_listing_loop_content_open() {
        ?><div class="container space-2"><?php
    }
}

if( ! function_exists( 'front_resume_listing_loop_controlbar' ) ) {
    function front_resume_listing_loop_controlbar() {
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
                            <h1 class="h5 mb-0"><?php echo esc_html__( 'Candidates', 'front' ); ?></h1>
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

if( ! function_exists( 'front_resume_listing_loop_sidebar_wrap_open' ) ) {
    function front_resume_listing_loop_sidebar_wrap_open() {
        $layout = front_get_wpjmr_resume_listing_layout();
        if( $layout !== 'fullwidth' ) :
            ?><div class="row"><div id="primary" class="content-area col-lg-9<?php echo ( 'left-sidebar' === $layout ) ? esc_attr( ' order-lg-1' ) : ''; ?>"><?php
        endif;
    }
}

if( ! function_exists( 'front_resume_listing_remove_active_filters' ) ) {
    function front_resume_listing_remove_active_filters() {
        if( !empty( Front_WPJMR::get_current_page_query_args() ) && apply_filters( 'front_resume_listing_remove_active_filters_button_enable', true ) ) :
            ?>
                <a href="<?php echo esc_url( strtok( Front_WPJMR::get_current_page_url(), '?' ) ); ?>" class="btn btn-sm btn-block btn-soft-secondary transition-3d-hover">
                    <?php esc_html_e( 'Clear All', 'front' ); ?>
                </a>
            <?php
        endif;
    }
}

if( ! function_exists( 'front_resume_listing_loop_sidebar_wrap_close' ) ) {
    function front_resume_listing_loop_sidebar_wrap_close() {
        $layout = front_get_wpjmr_resume_listing_layout();
        if( $layout !== 'fullwidth' ) :
            ?></div><?php do_action( 'resume_listing_sidebar' ); ?></div><?php
        endif;
    }
}

if( ! function_exists( 'front_resume_listing_sidebar' ) ) {
    function front_resume_listing_sidebar() {
        get_sidebar( 'resume' );
    }
}

if( ! function_exists( 'front_resume_listing_loop_content_close' ) ) {
    function front_resume_listing_loop_content_close() {
        ?></div><?php
    }
}

if ( ! function_exists( 'front_wpjmr_pagination' ) ) {
    function front_wpjmr_pagination() {
        global $wp_query;
        $total   = isset( $total ) ? $total : front_wpjmr_get_loop_prop( 'total_pages' );
        $current = isset( $current ) ? $current : front_wpjmr_get_loop_prop( 'current_page' );
        $base    = isset( $base ) ? $base : esc_url_raw( str_replace( 999999999, '%#%', remove_query_arg( '', get_pagenum_link( 999999999, false ) ) ) );
        $format  = isset( $format ) ? $format : '';
        if ( $total <= 1 ) {
            return;
        }

        $page_links = paginate_links( apply_filters( 'front_wpjmr_pagination_args', array( // WPCS: XSS ok.
            'base'         => $base,
            'format'       => $format,
            'add_args'     => false,
            'type'         => 'array',
            'current'      => max( 1, $current ),
            'total'        => $total,
            'prev_text'    => is_rtl() ? '&#187;' : '&#171;',
            'next_text'    => is_rtl() ? '&#171;' : '&#187;',
            'mid_size'     => 1,
        ) ) );

        if( is_array( $page_links ) && count( $page_links ) > 0 ) :
            ?>
            <div class="py-3"></div>
            <nav class="wpjmr-pagination" aria-label="Page Navigation">
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

if( ! function_exists( 'front_resume_listing_list_card_open' ) ) {
    function front_resume_listing_list_card_open() {
        ?><div class="list card"><?php
    }
}

if( ! function_exists( 'front_resume_listing_list_card_body_open' ) ) {
    function front_resume_listing_list_card_body_open() {
        ?><div class="card-body p-4"><?php
    }
}

if( ! function_exists( 'front_resume_listing_list_card_body_content' ) ) {
    function front_resume_listing_list_card_body_content() {
        ?>
        <!-- Header -->
        <div class="media align-items-center mb-4">
            <!-- Avatar -->
            <div class="<?php  echo esc_attr( ! get_the_candidate_photo() && apply_filters( 'front_enable_candidate_photo_default_text_placeholder', true )  ? 'btn btn-icon btn-soft-primary rounded-circle mr-4' : 'u-avatar position-relative mr-3' ); ?>" style="word-break: initial;">
                <?php front_the_candidate_photo( 'thumbnail', 'img-fluid rounded-circle', '' ); ?>
                <?php do_action( 'front_the_candidate_status' ); ?>
            </div>
            <!-- End Avatar -->
            <div class="media-body">
                <h1 class="h6 mb-0">
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </h1>
                <?php if( ! empty ( $candidate_title = front_get_the_meta_data( '_candidate_title', null, 'resume', true ) ) ) : ?>
                    <small class="text-secondary"><?php echo esc_html( $candidate_title ); ?></small>
                <?php endif; ?>
            </div>
            <?php do_action( 'resume_listing_list_card_body_content_bookmark', 'list' ) ?>
        </div>
        <!-- End Header -->
        <?php if( !empty( $candidate_bio = front_get_the_meta_data( '_candidate_bio', null, 'resume', true ) ) ) : ?>
            <div class="resume-excerpt font-size-1 text-secondary"><?php echo wp_kses_post( $candidate_bio ); ?></div>
        <?php elseif( !empty( get_the_excerpt() ) ) : ?>
            <div class="resume-excerpt font-size-1 text-secondary"><?php echo get_the_excerpt(); ?></div>
        <?php endif; ?>
        <?php
    }
}

if( ! function_exists( 'front_resume_listing_body_content_bookmark' ) ) {
    function front_resume_listing_body_content_bookmark( $view = 'grid' ) {
        global $job_manager_bookmarks;
        ?>
        <div class="<?php echo esc_attr( $view === 'grid' ? 'ml-auto' : 'align-self-start ml-auto' ) ?>">
            <?php $job_manager_bookmarks->bookmark_form(); ?>
        </div>
        <?php
    }
}

if( ! function_exists( 'front_resume_listing_list_card_footer' ) ) {
    function front_resume_listing_list_card_footer() {
        ob_start();
        front_resume_listing_list_card_footer_content();
        $footer_content = ob_get_clean();

        ob_start();
        do_action( 'resume_listing_list_card_footer_end' );
        $footer_end = ob_get_clean();

        if( ! empty( $footer_content ) || ! empty( $footer_end ) ) :
            ?>
            <div class="card-footer border-top-0 pt-0 px-4 pb-4">
                <div class="d-sm-flex align-items-sm-center">
                    <?php
                        echo wp_kses_post( $footer_content );
                        echo wp_kses_post( $footer_end );
                    ?>
                </div>
            </div>
            <?php
        endif;
    }
}

if( ! function_exists( 'front_resume_listing_list_card_footer_content' ) ) {
    function front_resume_listing_list_card_footer_content() {
        $args = apply_filters( 'front_resume_listing_list_card_footer_content_args', array(
            'candidate_location'    => array(
                'title'     => esc_html__( 'Location', 'front' ),
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
            foreach( $args as $arg ) :
                if( isset( $arg['title'], $arg['content'] ) && !empty( $arg['title'] && $arg['content'] ) ) :
                    ?>
                    <div class="<?php echo !( $i+1 === count( $args ) ) ? 'u-ver-divider u-ver-divider--none-sm pr-4 mr-4 mb-3 mb-sm-0' : 'mb-3 mb-md-0'; ?>">
                        <h2 class="small text-secondary mb-0"><?php echo wp_kses_post( $arg['title'] ); ?></h2>
                        <?php if( isset( $arg['icon'] ) && !empty( $arg['icon'] ) ) : ?>
                            <small class="text-secondary align-middle mr-1 <?php echo esc_attr( $arg['icon'] ); ?>"></small>
                        <?php endif; ?>
                        <span class="align-middle font-size-1 font-weight-medium"><?php echo wp_kses_post( $arg['content'] ); ?></span>
                    </div>
                    <?php
                    $i++;
                endif;
            endforeach;
        endif;
    }
}

if( ! function_exists( 'front_resume_listing_list_card_body_close' ) ) {
    function front_resume_listing_list_card_body_close() {
        ?></div><?php
    }
}

if( ! function_exists( 'front_resume_listing_list_card_close' ) ) {
    function front_resume_listing_list_card_close() {
        ?></div><?php
    }
}

// Grid

if( ! function_exists( 'front_resume_listing_grid_card_open' ) ) {
    function front_resume_listing_grid_card_open() {
        ?><div class="grid card"><?php
    }
}

if( ! function_exists( 'front_resume_listing_grid_card_body_open' ) ) {
    function front_resume_listing_grid_card_body_open() {
        ?><div class="card-body p-4"><?php
    }
}

if( ! function_exists( 'front_resume_listing_grid_card_body_content_head' ) ) {
    function front_resume_listing_grid_card_body_content_head() {
        ob_start();
        do_action( 'resume_listing_grid_card_body_content_head' );
        $head_content = ob_get_clean();
        if( !empty( $head_content ) ) {
            ?>
            <div class="d-flex align-items-center mb-5">
                <?php do_action( 'resume_listing_grid_card_body_content_head', 'grid' ); ?>
            </div>
            <?php
        }
    }
}

if( ! function_exists( 'front_resume_listing_grid_card_body_content' ) ) {
    function front_resume_listing_grid_card_body_content() {
        ?>
        <div class="text-center">
            <!-- Avatar -->
            <div class="<?php echo esc_attr( ! get_the_candidate_photo() && apply_filters( 'front_enable_candidate_photo_default_text_placeholder', true )  ? 'btn btn-lg btn-icon btn-soft-primary rounded-circle mb-3' : 'u-lg-avatar position-relative mx-auto mb-3' ); ?>" style="word-break: initial;">
                <?php front_the_candidate_photo( 'thumbnail', 'img-fluid rounded-circle' ); ?>
                <?php do_action( 'front_the_candidate_status' ); ?>
            </div>
            <!-- End Avatar -->
            <!-- Title -->
            <div class="mb-4">
                <h1 class="h5 mb-0">
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </h1>
                <?php if( ! empty ( $candidate_title = front_get_the_meta_data( '_candidate_title', null, 'resume', true ) ) ) : ?>
                    <small class="text-secondary"><?php echo esc_html( $candidate_title ); ?></small>
                <?php endif; ?>
            </div>
            <!-- End Title -->
            <?php if( !empty( $candidate_bio = front_get_the_meta_data( '_candidate_bio', null, 'resume', true ) ) ) : ?>
                <div class="resume-excerpt mb-0 text-secondary"><?php echo wp_kses_post( $candidate_bio ); ?></div>
            <?php elseif( !empty( get_the_excerpt() ) ) : ?>
                <div class="resume-excerpt mb-0 text-secondary"><?php echo get_the_excerpt(); ?></div>
            <?php endif; ?>
        </div>
        <?php
    }
}

if( ! function_exists( 'front_resume_listing_grid_card_body_close' ) ) {
    function front_resume_listing_grid_card_body_close() {
        ?></div><?php
    }
}

if( ! function_exists( 'front_resume_listing_grid_card_footer' ) ) {
    function front_resume_listing_grid_card_footer() {
        ob_start();
        front_resume_listing_grid_card_footer_content();
        $footer_content = ob_get_clean();

        if( ! empty( $footer_content ) ) :
            ?>
            <div class="card-footer text-center py-4">
                <div class="row align-items-center">
                    <?php
                        echo wp_kses_post( $footer_content );
                    ?>
                </div>
            </div>
            <?php
        endif;
    }
}

if( ! function_exists( 'front_resume_listing_grid_card_footer_content' ) ) {
    function front_resume_listing_grid_card_footer_content() {
        $args = apply_filters( 'front_resume_listing_grid_card_footer_content_args', array(
            'candidate_location'    => array(
                'title'     => esc_html__( 'Location', 'front' ),
                'content'   => get_the_candidate_location(),
                'icon'      => 'fas fa-map-marker-alt',
            ),
            'candidate_pay_scale'   => array(
                'title'     => esc_html__( 'Working rate', 'front' ),
                'content'   => front_get_the_meta_data( '_candidate_pay_scale', null, 'resume' ),
                'icon'      => '',
            ),
        ) );

        if( is_array( $args ) && count( $args ) > 0 ) :
            $i = 0;
            foreach( $args as $arg ) :
                if( isset( $arg['title'], $arg['content'] ) && ! empty( $arg['title'] && $arg['content'] ) ) :
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
        endif;
    }
}

if( ! function_exists( 'front_resume_listing_grid_card_close' ) ) {
    function front_resume_listing_grid_card_close() {
        ?></div><?php
    }
}
