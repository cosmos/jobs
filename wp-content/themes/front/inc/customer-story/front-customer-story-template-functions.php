<?php
/**
 * Template functions used in Customer Story
 */

if ( ! function_exists( 'front_single_customer_story_title' ) ) {
    function front_single_customer_story_title() {
        $bg_image = apply_filters( 'front_single_customer_story_bg_image', get_template_directory_uri() . '/assets/svg/components/abstract-shapes-15.svg' );
        $bg_style = 'background-image: url( ' . esc_url( $bg_image ) . ' )';
        ?>
        <div class="bg-primary bg-img-hero" style="<?php echo $bg_style; ?>">
            <div class="container space-2 space-lg-3">
                <div class="w-lg-65 text-center mx-lg-auto">
                    <?php $enable_pretitle = apply_filters( 'front_single_customer_story_enable_pretitle', true ); 

                    if ( $enable_pretitle == true ): ?>
                        <span class="btn btn-xs btn-soft-white btn-pill mb-3"><?php echo apply_filters( 'front_single_customer_story_pretitle', esc_html__( 'Customer success story', 'front' ) ) ?></span>
                    <?php endif ?>
                    <?php the_title( '<h1 class="text-white font-weight-medium mb-0">', '</h1>' ); ?>
                </div>
            </div>
        </div>
        <?php
    }
}

if ( ! function_exists( 'front_single_customer_story_content_wrap_open' ) ) {
    function front_single_customer_story_content_wrap_open() {
        ?>
        <div class="container space-2 space-lg-0">
            <div class="row">
        <?php
    }
}

if ( ! function_exists( 'front_single_customer_story_content_wrap_close' ) ) {
    function front_single_customer_story_content_wrap_close() {
        ?>
            </div>
        </div>
        <?php
    }
}

if ( ! function_exists( 'front_single_customer_story_sticky_content' ) ) {
    function front_single_customer_story_sticky_content() {
        ?>
        <div id="stickyBlockStartPoint" class="col-lg-4 mt-lg-n11 mb-7 mb-lg-0">
            <div class="js-sticky-block card border-0 bg-white shadow-soft" data-parent="#stickyBlockStartPoint" data-sticky-view="lg" data-start-point="#stickyBlockStartPoint" data-end-point="#stickyBlockEndPoint" data-offset-top="24" data-offset-bottom="24">
                <div class="card-header text-center py-5 px-4">
                    <div class="max-width-27 mx-auto">
                        <?php
                            $clean_featured_logo_arr = get_post_meta( get_the_ID(), '_featured_logo', true );
                            $featured_logo_arr = json_decode( stripslashes( $clean_featured_logo_arr ), true );
                            if( ! empty( $featured_logo_arr['id'] ) ) {
                                echo wp_get_attachment_image( $featured_logo_arr['id'], 'full', '', array( 'class' => 'img-fluid' ) );
                            }
                        ?>
                    </div>
                </div>
                <div class="card-body p-4">
                    <?php
                        $additional_information_count = get_post_meta( get_the_ID(), '_additional_information_count', true );
                        if( $additional_information_count >= 1 ) {
                            $clean_additional_information_arr = get_post_meta( get_the_ID(), '_additional_information', true );
                            $additional_information_arr = json_decode( $clean_additional_information_arr, true );
                            echo '<div class="border-bottom pb-2 mb-4">';
                            for ( $i = 1; $i <= $additional_information_count; $i++ ) {
                                if( ! empty( $additional_information_arr['label'. $i] ) && ! empty( $additional_information_arr['value' . $i] ) ) {
                                    ?>
                                    <dl class="row font-size-1">
                                        <dt class="col-sm-4 text-dark"><?php echo esc_html( $additional_information_arr['label'. $i] ); ?></dt>
                                        <dd class="col-sm-8 text-secondary"><?php echo wp_kses_post( $additional_information_arr['value'. $i] ); ?></dd>
                                    </dl>
                                    <?php
                                }
                            }
                            echo '</div>';
                        }

                        $key_features_count = get_post_meta( get_the_ID(), '_key_features_count', true );
                        if( $key_features_count >= 1 ) {
                            $clean_key_features_arr = get_post_meta( get_the_ID(), '_key_features', true );
                            $key_features_arr = json_decode( $clean_key_features_arr, true );
                            ?><h4 class="h6 mb-3"><?php echo apply_filters( 'front_single_customer_story_key_features_title', esc_html__( 'Products used', 'front' ) ) ?></h4><?php
                            for ( $i = 1; $i <= $key_features_count; $i++ ) {
                                if( ! empty( $key_features_arr['title'. $i] ) && ! empty( $key_features_arr['description' . $i] ) && ! empty( $key_features_arr['imageID' . $i] ) ) {
                                    $icon_uniqid = uniqid( $i );
                                    ?>
                                    <dl class="row font-size-1 <?php if( $i > 1 ) { echo 'mb-0'; } ?>">
                                        <dt class="col-sm-4">
                                            <figure id="<?php echo esc_attr( $icon_uniqid ) ?>" class="ie-height-56 max-width-8 w-100">
                                                <?php if ( ! empty( $key_features_arr['link'. $i] ) ): ?>
                                                    <a href="<?php echo esc_attr( $key_features_arr['link' . $i] ); ?>" <?php if ( isset( $key_features_arr['linkNewTab' . $i] ) && $key_features_arr['linkNewTab' . $i] ): ?>target="_blank"<?php endif; ?>>
                                                <?php endif;
                                                    if( ! empty( $featured_logo_arr['id'] ) ) {
                                                        echo wp_get_attachment_image( $key_features_arr['imageID' . $i], 'full', '', array( 'class' => 'js-svg-injector', 'data-parent' => $icon_uniqid ) );
                                                    }
                                                if ( ! empty( $key_features_arr['link'. $i] ) ): ?>
                                                    </a>
                                                <?php endif; ?>
                                            </figure>
                                        </dt>
                                        <dd class="col-sm-8 text-secondary">
                                            <h4 class="font-size-1 font-weight-semi-bold mb-0">
                                                <?php if ( ! empty( $key_features_arr['link'. $i] ) ): ?>
                                                    <a class="text-secondary" href="<?php echo esc_attr( $key_features_arr['link' . $i] ); ?>" <?php if ( isset( $key_features_arr['linkNewTab' . $i] ) && $key_features_arr['linkNewTab' . $i] ): ?>target="_blank"<?php endif; ?>>
                                                <?php endif;
                                                    echo esc_html( $key_features_arr['title'. $i] );
                                                if ( ! empty( $key_features_arr['link'. $i] ) ): ?>
                                                    </a>
                                                <?php endif; ?>
                                            </h4>
                                            <p class="font-size-1 mb-0"><?php echo wp_kses_post( $key_features_arr['description'. $i] ); ?></p>
                                        </dd>
                                    </dl>
                                    <?php
                                }
                            }
                        }
                    ?>
                </div>
            </div>
        </div>
        <?php
    }
}

if ( ! function_exists( 'front_single_customer_story_content' ) ) {
    function front_single_customer_story_content() {
        ?>
        <div class="col-lg-8 space-lg-2">
            <div class="pl-lg-4">
                <?php the_content(); ?>
            </div>
        </div>
        <?php
    }
}

if ( ! function_exists( 'front_single_customer_story_after_static_content' ) ) {
    function front_single_customer_story_after_static_content() {
        $static_content_id = get_post_meta( get_the_ID(), '_custom_static_content_id', true );
        if( front_is_mas_static_content_activated() && ! empty( $static_content_id ) ) {
            echo do_shortcode( '[mas_static_content id=' . $static_content_id . ' wrap=0]' );
        }
    }
}