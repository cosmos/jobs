<?php
/**
 * Server-side rendering of the `fgb/dark-footer` block.
 *
 * @package FrontGB
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Renders the `fgb/dark-footer` block on server.
 *
 * @since 1.0
 *
 * @param array $attributes The block attributes.
 *
 * @return string Returns the post content with latest posts added.
 */
if ( ! function_exists( 'frontgb_render_dark_footer_block' ) ) {
    function frontgb_render_dark_footer_block( $attributes ) {
        ob_start();
        if( function_exists( 'front_display_footer_dark' ) ) {
            front_display_footer_dark( $attributes );
        }
        return ob_get_clean();
    }
}

if ( ! function_exists( 'front_display_footer_dark' ) ) {
    function front_display_footer_dark( $args = array() ) {
        $defaults = array(
            'className'                 => '',
            'footerVersion'             => 'v1',
            'enableContainer'           => true,
            'isContainerFluid'          => false,
            'enableLightLogo'           => true,
            'enableLogoSiteTitle'       => false,
            'logoImageUrl'              => '',
            'customLogoWidth'           => '',
            'enableCopyright'           => true,
            'copyRightText'             => '',
            'footerStaticContentId'     => '',
            'footerWidgetColumn1'       => '',
            'footerWidgetColumn2'       => '',
            'footerWidgetColumn3'       => '',
            'footerWidgetColumn4'       => '',     
        );

        $args = wp_parse_args( $args, $defaults );
        extract( $args );

        $container_class = '';

        if( $enableContainer ) {

            if ( $isContainerFluid == false ) {
                $container_class = 'container ';
            }
            else {
                $container_class = 'container-fluid ';
            }
        }

        if ( $enableLightLogo == true ) {
            add_filter( 'front_use_footer_svg_logo_light', '__return_true');
        } 
        else {
            add_filter( 'front_use_footer_svg_logo_light', '__return_false');
        }

        if ( $enableLogoSiteTitle == true ) {
            add_filter( 'front_use_footer_svg_logo_with_site_title', '__return_true');
        } 
        else {
            add_filter( 'front_use_footer_svg_logo_with_site_title', '__return_false');
        }

        switch ( $footerVersion ) {
            case 'v1':?>
               <footer id="SVGcurvedShape" class="site-footer site-footer__dark footer-dark-v1<?php echo ( empty( $className ) ? '' : ' ' ); ?><?php echo esc_attr( $className ); ?>">
                    <figure>
                        <img class="js-svg-injector" src="<?php echo front_get_assets_url() . 'svg/components/curved-2.svg'; ?>" alt="Image Description" data-parent="#SVGcurvedShape">
                    </figure>
                    <div class="bg-dark">
                        <div class="<?php echo esc_attr( $container_class ); ?>space-2 space-md-3">
                            <div class="row justify-content-lg-between">
                                <div class="col-lg-4 d-flex align-items-start flex-column mb-7 mb-lg-0">
                                    <?php if( ! empty( $logoImageUrl ) ) : ?>
                                        <a class="d-flex align-items-center mb-lg-auto" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                                            <img src="<?php echo esc_url( $logoImageUrl ); ?>" alt="<?php echo get_bloginfo( 'name' ); ?>" style="width: <?php echo esc_attr( empty( $customLogoWidth ) ? 130 : $customLogoWidth ) . 'px' ?>">
                                        </a><?php
                                    else :
                                        if ( function_exists( 'front_footer_logo' ) ) {
                                            front_footer_logo();
                                        } 
                                    endif;
                                    if ( $enableCopyright == true ): ?>
                                        <p class="small text-white-50 mb-0 mt-lg-auto"><?php if ( ! empty( $copyRightText ) ) { echo wp_kses_post( $copyRightText ); } else if ( function_exists( 'front_copyright_text' ) ) { front_copyright_text(); } ?></p>
                                    <?php endif ?> 
                                </div>
                                <?php if ( is_active_sidebar( $footerWidgetColumn1 ) || is_active_sidebar( $footerWidgetColumn2 ) || is_active_sidebar( $footerWidgetColumn3 ) ) : ?>
                                    <?php if ( is_active_sidebar( $footerWidgetColumn1 ) ) : ?>
                                        <div class="col-6 col-md-4 col-lg-2 mb-7 mb-md-0">
                                            <?php dynamic_sidebar( $footerWidgetColumn1 ); ?>
                                        </div>
                                    <?php endif; ?>
                                    <?php if ( is_active_sidebar( $footerWidgetColumn2 ) ) : ?>
                                        <div class="col-6 col-md-4 col-lg-2 mb-7 mb-md-0">
                                            <?php dynamic_sidebar( $footerWidgetColumn2 ); ?>
                                        </div>
                                    <?php endif; ?>
                                    <?php if ( is_active_sidebar( $footerWidgetColumn3 ) ) : ?>
                                        <div class="col-6 col-md-4 col-lg-3">
                                            <?php dynamic_sidebar( $footerWidgetColumn3 ); ?>
                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </footer>
            <?php break;

            case 'v2';?>
                <footer class="site-footer site-footer__dark footer-dark-v2 bg-dark<?php echo ( empty( $className ) ? '' : ' ' ); ?><?php echo esc_attr( $className ); ?>">
                    <div class="<?php echo esc_attr( $container_class ); ?>space-top-2">
                        <?php if ( is_active_sidebar( $footerWidgetColumn1 ) || is_active_sidebar( $footerWidgetColumn2 ) || is_active_sidebar( $footerWidgetColumn3 ) || is_active_sidebar( $footerWidgetColumn4 ) ) : ?>
                            <div class="row justify-content-lg-between mb-7">
                                <?php if ( is_active_sidebar( $footerWidgetColumn1 ) ) : ?>
                                    <div class="col-6 col-md-4 col-lg-2 mb-7 mb-lg-0">
                                        <?php dynamic_sidebar( $footerWidgetColumn1 ); ?>
                                    </div>
                                <?php endif; ?>
                                <?php if ( is_active_sidebar( $footerWidgetColumn2 ) ) : ?>
                                    <div class="col-6 col-md-4 col-lg-2 mb-7 mb-lg-0">
                                        <?php dynamic_sidebar( $footerWidgetColumn2 ); ?>
                                    </div>
                                <?php endif; ?>
                                <?php if ( is_active_sidebar( $footerWidgetColumn3 ) ) : ?>
                                    <div class="col-6 col-md-4 col-lg-2 mb-7 mb-lg-0">
                                        <?php dynamic_sidebar( $footerWidgetColumn3 ); ?>
                                    </div>
                                <?php endif; ?>
                                <?php if ( is_active_sidebar( $footerWidgetColumn4 ) ) : ?>
                                    <div class="col-sm-6 col-md-5 col-lg-3 col-lg-3">
                                        <?php dynamic_sidebar( $footerWidgetColumn4 ); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                        <div class="row justify-content-between align-items-center space-1">
                            <div class="col-5">
                                <?php if( ! empty( $logoImageUrl ) ) : ?>
                                    <a class="d-inline-flex align-items-center mb-3" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                                        <img src="<?php echo esc_url( $logoImageUrl ); ?>" alt="<?php echo get_bloginfo( 'name' ); ?>" style="width: <?php echo esc_attr( empty( $customLogoWidth ) ? 130 : $customLogoWidth ) . 'px' ?>">
                                    </a><?php
                                    else :
                                        if ( function_exists( 'front_footer_logo' ) ) {
                                            front_footer_logo();
                                        } 
                                endif;
                                ?>
                            </div>
                            <?php if ( $enableCopyright == true ): ?>
                            <div class="col-6 text-right">
                                <p class="small mb-0 text-secondary"><?php if ( ! empty( $copyRightText ) ) { echo wp_kses_post( $copyRightText ); } else if ( function_exists( 'front_copyright_text' ) ) { front_copyright_text(); } ?></p>
                            </div>
                            <?php endif ?> 
                        </div>
                    </div>
                </footer>
            <?php break;

            case 'v3': ?>
                <footer class="site-footer site-footer__dark footer-dark-v3 bg-dark<?php echo ( empty( $className ) ? '' : ' ' ); ?><?php echo esc_attr( $className ); ?>">
                    <div class="<?php echo esc_attr( $container_class ); ?>text-center space-2">
                        <?php if( ! empty( $logoImageUrl ) ) : ?>
                            <a class="d-inline-flex align-items-center mb-3" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                                <img src="<?php echo esc_url( $logoImageUrl ); ?>" alt="<?php echo get_bloginfo( 'name' ); ?>" style="width: <?php echo esc_attr( empty( $customLogoWidth ) ? 130 : $customLogoWidth ) . 'px' ?>">
                            </a><?php
                            else :
                                if ( function_exists( 'front_footer_logo' ) ) {
                                    front_footer_logo();
                                } 
                        endif;
                        if ( $enableCopyright == true ): ?>
                            <p class="small text-secondary"><?php if ( ! empty( $copyRightText ) ) { echo wp_kses_post( $copyRightText ); } else if ( function_exists( 'front_copyright_text' ) ) { front_copyright_text(); } ?></p>
                        <?php endif ?> 
                    </div>
                </footer>
            <?php break;

            case 'v4' ?>
                <footer class="site-footer site-footer__dark footer-dark-v4 bg-dark<?php echo ( empty( $className ) ? '' : ' ' ); ?><?php echo esc_attr( $className ); ?>">
                    <div class="<?php echo esc_attr( $container_class ); ?>space-2">
                        <div class="row mb-7">
                            <div class="col-lg-3 mb-5 mb-lg-0">
                                <?php if( ! empty( $logoImageUrl ) ) : ?>
                                    <a class="d-inline-flex align-items-center mb-2" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                                        <img src="<?php echo esc_url( $logoImageUrl ); ?>" alt="<?php echo get_bloginfo( 'name' ); ?>" style="width: <?php echo esc_attr( empty( $customLogoWidth ) ? 130 : $customLogoWidth ) . 'px' ?>">
                                    </a><?php
                                    else :
                                        if ( function_exists( 'front_footer_logo' ) ) {
                                            front_footer_logo();
                                        } 
                                endif;
                                ?>
                            </div>
                            <?php if ( is_active_sidebar( $footerWidgetColumn1 ) || is_active_sidebar( $footerWidgetColumn2 ) || is_active_sidebar( $footerWidgetColumn3 ) ) : ?>
                                <?php if ( is_active_sidebar( $footerWidgetColumn1 ) ) : ?>
                                    <div class="col-6 col-lg-2 mb-5 mb-lg-0">
                                        <?php dynamic_sidebar( $footerWidgetColumn1 ); ?>
                                    </div>
                                <?php endif; ?>
                                <?php if ( is_active_sidebar( $footerWidgetColumn2 ) ) : ?>
                                    <div class="col-6 col-lg-2 mb-5 mb-lg-0">
                                        <?php dynamic_sidebar( $footerWidgetColumn2 ); ?>
                                    </div>
                                <?php endif; ?>
                                <?php if ( is_active_sidebar( $footerWidgetColumn3 ) ) : ?>
                                    <div class="col-lg-5">
                                        <?php dynamic_sidebar( $footerWidgetColumn3 ); ?>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                        <?php if ( $enableCopyright == true ): ?>
                            <p class="small text-white-70 mb-0"><?php if ( ! empty( $copyRightText ) ) { echo wp_kses_post( $copyRightText ); } else if ( function_exists( 'front_copyright_text' ) ) { front_copyright_text(); } ?></p>
                        <?php endif ?> 
                    </div>
                </footer>
            <?php break;
        }
    }
}

if ( ! function_exists( 'frontgb_register_dark_footer_block' ) ) {
    /**
     * Registers the `fgb/dark-footer` block on server.
     */
    function frontgb_register_dark_footer_block() {
        if ( ! function_exists( 'register_block_type' ) ) {
            return;
        }

        register_block_type(
            'fgb/dark-footer',
            array(
                'attributes' => array(
                    'className' => array(
                        'type' => 'string',
                    ),
                    'footerVersion' => array(
                        'type' => 'string',
                        'default' => 'v1',
                    ),
                    'enableContainer'  => array(
                        'type' => 'boolean',
                        'default' => true,
                    ),
                    'isContainerFluid'  => array(
                        'type' => 'boolean',
                        'default' => false,
                    ),
                    'enableLightLogo' => array(
                        'type' => 'boolean',
                        'default' => true,
                    ),
                    'enableLogoSiteTitle' => array(
                        'type' => 'boolean',
                        'default' => true,
                    ),
                    'logoImageUrl' => array(
                        'type' => 'string',
                    ),
                    'customLogoWidth' => array(
                        'type' => 'number',
                    ),
                    'enableCopyright'  => array(
                        'type' => 'boolean',
                        'default' => true,
                    ),
                    'copyRightText' => array(
                        'type' => 'string',
                    ),
                    'footerWidgetColumn1' => array(
                        'type' => 'string',
                    ),
                    'footerWidgetColumn2' => array(
                        'type' => 'string',
                    ),
                    'footerWidgetColumn3' => array(
                        'type' => 'string',
                    ),
                    'footerWidgetColumn4' => array(
                        'type' => 'string',
                    ),
                ),
                'render_callback' => 'frontgb_render_dark_footer_block',
            )
        );
    }
    add_action( 'init', 'frontgb_register_dark_footer_block' );
}