<?php

if ( ! function_exists( 'front_wpjmr_user_comment_order' ) ) {
    function front_wpjmr_user_comment_order() {
        $user_comment_order = get_option( 'comment_order', 'asc' );
        if ( isset( $_REQUEST['uco'] ) ) :
            $user_comment_order = sanitize_text_field( $_REQUEST['uco'] );
        elseif ( isset( $_COOKIE[ 'user_comment_order' ] ) ) :
            $user_comment_order = intval( $_COOKIE[ 'user_comment_order' ] );
        endif;

        return $user_comment_order;
    }
}

if ( ! function_exists( 'front_wpjmr_reverse_comments' ) ) {
    function front_wpjmr_reverse_comments( $comments ) {
        if( is_singular( 'company' ) ) {
            $user_comment_order = front_wpjmr_user_comment_order();
            if( $user_comment_order !== get_option( 'comment_order', 'asc' ) ) {
                return array_reverse($comments);
            }
        }
        return $comments;
    }
}
add_filter( 'comments_array', 'front_wpjmr_reverse_comments' );

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

                        <div class="search_keywords col-lg-5 mb-4 mb-lg-0">
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
                        <div class="search_location col-lg-5 mb-4 mb-lg-0">
                            <!-- Input -->
                            <label for="search_location" class="d-block">
                                <span class="h6 d-block text-dark font-weight-semi-bold mb-0"><?php echo esc_html( $args['location_title_text'] ) ?></span>
                            </label>
                            <div class="js-focus-state">
                                <div class="input-group">
                                    <input type="text" name="search_location" id="search_location" class="form-control" placeholder="<?php echo esc_attr( $args['location_placeholder_text'] ) ?>" aria-label="<?php echo esc_attr( $args['location_placeholder_text'] ) ?>" aria-describedby="locationInputAddon" value="<?php echo esc_attr( isset( $_GET['search_location'] ) ? front_clean( wp_unslash( $_GET['search_location'] ) ) : '' ); ?>" />
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                        <span class="fas fa-map-marker-alt" id="locationInputAddon"></span>
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