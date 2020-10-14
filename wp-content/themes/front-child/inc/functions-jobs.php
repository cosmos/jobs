<?php
	if( ! function_exists( 'front_single_job_listing_company' ) ) {
	    function front_single_job_listing_company() {
	        ?>
	        <div class="mb-4">
	            <?php
			    		$company_id = get_post_meta(cosmos_get_post_id())['_company_id'][0];
			    		$company_name = get_post_meta(cosmos_get_post_id())['_company_name'][0];
			    		$company_image = get_post_meta($company_id, '_company_logo')[0];
								if (!empty($company_image)) {
									$image = $company_image;
								}else{
									$image = get_the_company_logo( null, 'thumbnail' ) ? get_the_company_logo( null, 'thumbnail' ) : apply_filters( 'job_manager_default_company_logo', JOB_MANAGER_PLUGIN_URL . '/assets/images/company.png' ); 
								}
	            if( !empty( $company_excerpt = front_get_the_job_listing_company_excerpt() ) ) :
	                if( ( $pos = strrpos( $company_excerpt , '<p>' ) ) !== false ) {
	                    $search_length  = strlen( '<p>' );
	                    $company_excerpt = substr_replace( $company_excerpt , '<p class="mb-0">' , $pos , $search_length );
	                }
	                ?>
	            		<img class="u-clients mb-4" src="<?php echo $image; ?>" alt="<?php echo $company_name; ?>">
	                <h4 class="h6"><?php esc_html_e( 'About', 'front' ); ?></h4>
	                <div class="font-size-1 text-secondary text-lh-md"><?php echo wp_kses_post( $company_excerpt ); ?></div>
	                <?php
	            endif;
	            if( !empty( $company = front_get_the_job_listing_company() ) ) :
	                ?>
	                    <a class="font-size-1 btn btn-primary mt-3" href="<?php the_permalink( $company ); ?>"><?php esc_html_e( 'View project profile', 'front' ); ?></a>
	                <?php
	            endif;
	            ?>
	        </div>
	        <?php

	    }
	}

	if( ! function_exists( 'front_single_job_listing_summary' ) ) {
	    function front_single_job_listing_summary() {
	        ?>
	        <div class="card border-0 shadow-sm mb-3">
	            <header id="SVGwave1BottomShapeID1" class="card-header border-bottom-0 bg-primary text-white p-0 pb-2 mb-4">
	                <div class="pt-5 px-5">
	                    <h3 class="h5"><?php esc_html_e( 'Job Summary', 'front' ) ?></h3>
	                </div>
	               <!--  TAS <figure class="ie-wave-1-bottom mt-n5">
	                    <img class="js-svg-injector" src="<?php echo get_template_directory_uri() . '/assets/svg/components/wave-1-bottom.svg' ?>" alt="wave-1-bottom" data-parent="#SVGwave1BottomShapeID1">
	                </figure> -->
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

	// Shows the correct project logo
	add_action( 'single_job_listing_job_header', 'cosmos_single_job_listing_job_header_job_data', 10 );
	add_action( 'after_setup_theme', 'cosmos_remove_single_job_listing_job_header_job_data');
	function cosmos_remove_single_job_listing_job_header_job_data() {
	  remove_action( 'single_job_listing_job_header', 'front_single_job_listing_job_header_job_data', 10 );
	}

	if( ! function_exists( 'cosmos_single_job_listing_job_header_job_data' ) ) {
	    function cosmos_single_job_listing_job_header_job_data() {
	    		$company_id = get_post_meta(cosmos_get_post_id())['_company_id'][0];
	    		$company_name = get_post_meta(cosmos_get_post_id())['_company_name'][0];
	    		$company_image = get_post_meta($company_id, '_company_logo')[0];
						if (!empty($company_image)) {
							$image = $company_image;
						}else{
							$image = get_the_company_logo( null, 'thumbnail' ) ? get_the_company_logo( null, 'thumbnail' ) : apply_filters( 'job_manager_default_company_logo', JOB_MANAGER_PLUGIN_URL . '/assets/images/company.png' ); 
						}
	        ?>
	        <div class="media align-items-center mb-5">
	            <div class="u-lg-avatar mr-4 position-relative">
	            		<img class="img-fluid rounded-circle" src="<?php echo $image; ?>" alt="<?php echo $company_name; ?>">
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


