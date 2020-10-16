<?php
/**
 * Template tags used in my account
 */

if ( ! function_exists( 'front_myaccount_page_header' ) ) {
    function front_myaccount_page_header() {
    	if ( ( front_is_woocommerce_activated() && is_account_page() )) {
            remove_action( 'front_page', 'front_page_header', 10 );
	        if ( is_user_logged_in() ) {
		        ?><div class="bg-primary">
		        	<div class="container space-top-1 pb-3">
		        		<div class="row">
		        			<div class="col-lg-5 order-lg-2 text-lg-right mb-4 mb-lg-0">
		        				<div class="d-flex d-lg-inline-block justify-content-between justify-content-lg-end align-items-center align-items-lg-start">
	                                
	                                <?php woocommerce_breadcrumb(); ?>
		        					
	                                <div class="d-lg-none">
	                                    <button type="button" class="navbar-toggler btn u-hamburger u-hamburger--white"
	                                            aria-label="Toggle navigation"
	                                            aria-expanded="false"
	                                            aria-controls="breadcrumbNavBar"
	                                            data-toggle="collapse"
	                                            data-target="#breadcrumbNavBar">
	                                      <span id="breadcrumbHamburgerTrigger" class="u-hamburger__box">
	                                        <span class="u-hamburger__inner"></span>
	                                      </span>
	                                    </button>
	                                </div>

		        				</div>
		        			</div>
			        		<div class="col-lg-7 order-lg-1">
			        			<?php front_myaccount_user_info() ?>
			        		</div>
				    	</div>

		        	</div>
		        	<div class="container space-bottom-1 space-bottom-lg-0">
		        		<div class="d-lg-flex justify-content-lg-between align-items-lg-center">
	                        <!-- Navbar -->
	                        <div class="u-header u-header-left-aligned-nav u-header--bg-transparent-lg u-header--white-nav-links z-index-4">
					            <div class="u-header__section bg-transparent">
					            	<?php front_account_navigation(); ?>
					            </div>
				            </div>
				        </div>
		        	</div>
		        </div><?php
		    }
	    }
    }
}

if ( ! function_exists( 'front_myaccount_user_info' ) ) {
    function front_myaccount_user_info() {
        if ( front_is_woocommerce_activated() && is_user_logged_in() ) {
            $current_user_id = get_current_user_id();
            ?>
            <div class="media d-block d-sm-flex align-items-sm-center">
                <a class="u-lg-avatar position-relative mb-3 mb-sm-0 mr-3" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID', $current_user_id ) ) ); ?>" rel="author"><?php echo get_avatar(  get_the_author_meta( 'ID', $current_user_id ), 80, '', '', array( 'class' => 'img-fluid rounded-circle' ) ); ?></a>
                <div class="media-body">
                    <h1 class="h3 text-white font-weight-medium mb-1"><?php printf( esc_html__( 'Howdy, %s!', 'front' ), get_the_author_meta( 'display_name', $current_user_id ) ); ?></h1>
                    <span class="d-block text-white"><?php echo get_the_author_meta( 'email', $current_user_id ); ?></span>
                </div>
            </div><?php
        }
    }
}

if ( ! function_exists( 'front_modify_wc_breadcrumb_args' ) ) {
    function front_modify_wc_breadcrumb_args( $default_args ) {
    	if ( is_account_page() ) {
    		$class = 'breadcrumb-white';
    	} else {
    		$class = 'justify-content-sm-end';
    	}

        $args = array(
			'delimiter'   => '',
			'wrap_before' => '<ol class="woocommerce-breadcrumb breadcrumb breadcrumb-no-gutter mb-0 ' . esc_attr( $class ) . '">',
			'wrap_after'  => '</ol>',
			'before'      => '<li class="breadcrumb-item">',
			'after'       => '</li>',
		);

		return wp_parse_args( $args, $default_args );
    }
}

if ( ! function_exists( 'front_account_navigation' ) ) {
    function front_account_navigation() {
		?>
		<nav class="woocommerce-MyAccount-navigation js-breadcrumb-menu navbar navbar-expand-lg u-header__navbar u-header__navbar--no-space">
            <div id="breadcrumbNavBar" class="collapse navbar-collapse u-header__navbar-collapse">
                  <ul class="navbar-nav u-header__navbar-nav">
					<?php foreach ( wc_get_account_menu_items() as $endpoint => $label ) : ?>
						<li class="<?php echo wc_get_account_menu_item_classes( $endpoint ); ?> nav-item hs-has-sub-menu u-header__nav-item">
							<a class="nav-link u-header__nav-link" href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>"><?php echo esc_html( $label ); ?></a>
						</li>
				<?php endforeach; ?>
				</ul>
			</div>
		</nav><?php
	}
}

if ( ! function_exists( 'front_account_content_wrapper_start' ) ) {
    function front_account_content_wrapper_start() {
    	?>
    	<div class="bg-light">
    		<div class="container space-2">
    	<?php
    }
}

if ( ! function_exists( 'front_account_content_wrapper_end' ) ) {
    function front_account_content_wrapper_end() {
    	?>
    		</div>
    	</div>
    	<?php
    }
}

if ( ! function_exists( 'front_myaccount_partners' ) ) {
    function front_myaccount_partners() {
    	?>
		<div class="position-absolute right-0 bottom-0 left-0 text-center p-5">
        	<h4 class="h6 text-white-70 mb-3"><?php echo esc_html__( 'Front partners', 'front' ); ?></h4>
            <div class="d-flex justify-content-center">
              	<div class="mx-4">
                	<img class="u-clients" src="../wp-content/themes/front/assets/svg/clients-logo/slack-white.svg" alt="<?php echo esc_attr__( 'Image Description', 'front' ); ?>">
              	</div>
              	<div class="mx-4">
                	<img class="u-clients" src="../wp-content/themes/front/assets/svg/clients-logo/google-white.svg" alt="<?php echo esc_attr__( 'Image Description', 'front' ); ?>">
              	</div>
              	<div class="mx-4">
                	<img class="u-clients" src="../wp-content/themes/front/assets/svg/clients-logo/spotify-white.svg" alt="<?php echo esc_attr__( 'Image Description', 'front' ); ?>">
              	</div>
            </div>
        </div>
    	<?php
    }
}

if ( ! function_exists( 'front_registration_privacy_policy_text' ) ) {
    function front_registration_privacy_policy_text() {
    	if ( ! wc_privacy_policy_page_id() ) {
			return;
		}

		return wp_kses_post( front_replace_policy_page_link_placeholders( wc_get_privacy_policy_text( 'registration' )  ) );
	}
}

function front_replace_policy_page_link_placeholders( $text ) {
	$privacy_page_id = wc_privacy_policy_page_id();
	$terms_page_id   = wc_terms_and_conditions_page_id();
	$privacy_link    = $privacy_page_id ? '<a class="link-muted" href="' . esc_url( get_permalink( $privacy_page_id ) ) . '" class="woocommerce-privacy-policy-link" target="_blank">' . esc_html__( 'privacy policy', 'front' ) . '</a>' : esc_html__( 'privacy policy', 'front' );
	$terms_link      = $terms_page_id ? '<a class="link-muted" href="' . esc_url( get_permalink( $terms_page_id ) ) . '" class="woocommerce-terms-and-conditions-link" target="_blank">' . esc_html__( 'terms and conditions', 'front' ) . '</a>' : esc_html__( 'terms and conditions', 'front' );

	$find_replace = array(
		'[terms]'          => $terms_link,
		'[privacy_policy]' => $privacy_link,
	);

	return str_replace( array_keys( $find_replace ), array_values( $find_replace ), $text );
}

function front_registration_errors_validation($reg_errors, $sanitized_user_login, $user_email) {
    global $woocommerce;
    extract( $_POST );
    if( isset( $password ) && isset( $newPassword ) && strcmp( $newPassword, $password ) !== 0 ) {
        return new WP_Error( 'registration-error', esc_html__( 'Passwords do not match.', 'front' ) );
    }
    return $reg_errors;
}

if ( ! function_exists( 'front_woocommerce_edit_account_form_profile_pic_field' ) ) {
    function front_woocommerce_edit_account_form_profile_pic_field() {
        if( function_exists( 'mt_mpp_instantiate' ) ) {
            global $mt_pp;
            $user = wp_get_current_user();
            require_once(ABSPATH . "wp-admin" . '/includes/image.php');
            require_once(ABSPATH . "wp-admin" . '/includes/file.php');
            require_once(ABSPATH . "wp-admin" . '/includes/media.php');
            wp_enqueue_media();

            $default_pic = $mt_pp::get_plugin_url( 'img/mystery.png' );
            $metronet_image_id = get_user_option( 'metronet_image_id', $user->ID );

            $user = get_user_by( 'id', $user->ID );
            $post_args = array(
                'post_type'   => 'mt_pp',
                'author'      => $user->ID,
                'post_status' => 'publish',
            );

            $posts = get_posts( $post_args );
            if ( ! $posts ) {
                $metronet_post_id = wp_insert_post(
                    array(
                        'post_author' => $user->ID,
                        'post_type'   => 'mt_pp',
                        'post_status' => 'publish',
                        'post_title'  => $user->data->display_name,
                    )
                );
            } else {
                $post = end( $posts );
                $metronet_post_id = $post->ID;
            }

            ?><div class="front-pp-wrap mb-6 woocommerce-form-row woocommerce-form-row--wide form-group">
                <div class="media align-items-center">
                    <div class="u-lg-avatar mr-3">
                        <img class="img-fluid rounded-circle w-100 h-100" src="<?php echo get_avatar_url($user->ID); ?>" alt="<?php echo esc_attr__( 'Image Description', 'front' ); ?>" style="object-fit: cover;">
                    </div>
                    <div class="media-body">
                        <a href="#" class="front-pp-add-change btn btn-secondary btn-shadow btn-sm mb-2">
                            <?php echo esc_html__( 'Change profile picture', 'front' ); ?>
                        </a>
                        <a href="#" class="front-pp-remove btn btn-danger btn-shadow btn-sm mb-2<?php echo esc_attr( $metronet_image_id ? '' : ' d-none' ); ?>">
                            <?php echo esc_html__( 'Remove', 'front' ); ?>
                        </a>
                        <div class="p mb-0 font-size-ms text-muted"><?php echo esc_html__( 'Upload JPG, GIF or PNG image.', 'front' ); ?></div>
                        <input type="hidden" name="metronet_image_id" class="front-pp-file-field" value="<?php echo esc_attr( $metronet_image_id ); ?>">
                        <input type="hidden" name="metronet_post_id" id="metronet_post_id" value="<?php echo esc_attr( $metronet_post_id ); ?>" />
                        <input type="hidden" name="metronet_default_pic" id="metronet_default_pic" value="<?php echo esc_url( $default_pic ); ?>" />
                    </div>
                </div>
            </div><?php
        }
    }
}

if ( ! function_exists( 'front_woocommerce_save_account_form_profile_pic_field' ) ) {
    function front_woocommerce_save_account_form_profile_pic_field( $user_id ) {
        if ( ! current_user_can( 'edit_user', $user_id ) ) { return false; }
        if( function_exists( 'mt_mpp_instantiate' ) ) {
            $media_id = $_POST['metronet_image_id'];
            $metronet_post_id = $_POST['metronet_post_id'];
            update_user_option( $user_id, 'metronet_image_id', absint( $media_id ) );

            if( ! empty( $media_id ) ) {
                update_user_option( $user_id, 'metronet_avatar_override', 'on' );
                update_user_option( $user_id, 'metronet_post_id', absint( $metronet_post_id ) );
                set_post_thumbnail( $metronet_post_id, $media_id );
            } else {
                update_user_option( $user_id, 'metronet_avatar_override', 'off' );
                delete_post_meta( $metronet_post_id, '_thumbnail_id' );
            }
        }
    }
}
