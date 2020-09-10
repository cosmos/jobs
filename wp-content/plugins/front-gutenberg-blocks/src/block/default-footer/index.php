<?php
/**
 * Server-side rendering of the `fgb/default-footer` block.
 *
 * @package FrontGB
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Renders the `fgb/default-footer` block on server.
 *
 * @since 1.0
 *
 * @param array $attributes The block attributes.
 *
 * @return string Returns the post content with latest posts added.
 */
if ( ! function_exists( 'frontgb_render_deafult_footer_block' ) ) {
    function frontgb_render_deafult_footer_block( $attributes ) {
        ob_start();
        if( function_exists( 'front_display_footer_default' ) ) {
            front_display_footer_default( $attributes );
        }
        return ob_get_clean();
    }
}

if ( ! function_exists( 'front_display_footer_default' ) ) {
    function front_display_footer_default( $args = array() ) {
        $defaults = array(
            'className'                 => '',
            'footerVersion'             => 'v1',
            'enableContainer'           => true,
            'isContainerFluid'          => false,
            'enableLightLogo'           => false,
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
            'footerPrimaryMenuID'       => 0,
            'footerSocialMenuID'        => 0,
            'footerPrimaryMenuSlug'     => '',
            'footerSocialMenuSlug'      => '',
            'contactBlockTitle'         => 'contact us',
            'contactCallUsNumber'       => '+1 (062) 109-9222',
            'contactSupportAddress'     => 'support@htmlstream.com',
            'contactSupportAddressLink' => '#',
            'footerTitle'               => 'Ready to make<br><strong class="text-primary">something amazing?</strong>',
            'buttonText'                => 'Start a New Project',
            'buttonUrl'                 => '#',
            'buttonSize'                => 'btn-sm',
            'buttonNewTab'              => false,
            'buttonDesign'              => 'default',
            'buttonBackground'          => 'primary',
            'buttonIsWide'              => false,
            'buttonIsWideSM'            => false,
            'buttonIsBlock'             => false,
            'buttonBorderRadius'        => 'default',
            'buttonIsTransition'        => true,
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
            case 'v1': ?>
                <footer class="site-footer site-footer__default style-v1<?php echo ( empty( $className ) ? '' : ' ' ); ?><?php echo esc_attr( $className ); ?>">
                    <?php if ( is_active_sidebar( $footerWidgetColumn1 ) || is_active_sidebar( $footerWidgetColumn2 ) || is_active_sidebar( $footerWidgetColumn3 ) || is_active_sidebar( $footerWidgetColumn4 ) ) : ?>
                    <div class="footer-widgets border-bottom">
                        <div class="<?php echo esc_attr( $container_class ); ?>space-2">
                            <div class="row justify-content-md-between">
                                <?php if ( ! empty( $footerWidgetColumn1 ) && is_active_sidebar( $footerWidgetColumn1 ) ) : ?>
                                <div class="col-sm-4 col-lg-2 mb-lg-0">
                                    <?php dynamic_sidebar( $footerWidgetColumn1 ); ?>
                                </div>
                                <?php endif; ?>

                                <?php if ( ! empty( $footerWidgetColumn2 ) && is_active_sidebar( $footerWidgetColumn2 ) ) : ?>
                                <div class="col-sm-4 col-lg-2 mb-lg-0">
                                    <?php dynamic_sidebar( $footerWidgetColumn2 ); ?>
                                </div>
                                <?php endif; ?>

                                <?php if ( ! empty( $footerWidgetColumn3 ) && is_active_sidebar( $footerWidgetColumn3 ) ) : ?>
                                <div class="col-sm-4 col-lg-2 mb-lg-0">
                                    <?php dynamic_sidebar( $footerWidgetColumn3 ); ?>
                                </div>
                                <?php endif; ?>

                                <?php if ( ! empty( $footerWidgetColumn4 ) && is_active_sidebar( $footerWidgetColumn4 ) ) : ?>
                                <div class="col-md-6 col-lg-4">
                                    <?php dynamic_sidebar( $footerWidgetColumn4 ); ?>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    <div class="<?php echo esc_attr( $container_class ); ?>text-center space-1">
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
                            <p class="small text-muted"><?php if ( ! empty( $copyRightText ) ) { echo wp_kses_post( $copyRightText ); } else if ( function_exists( 'front_copyright_text' ) ) { front_copyright_text(); } ?></p>
                        <?php endif ?>
                    </div>
                </footer>
            <?php break;

            case 'v2'; ?>
                <footer class="<?php echo esc_attr( $container_class ); ?>site-footer site-footer__default style-v2<?php echo ( empty( $className ) ? '' : ' ' ); ?><?php echo esc_attr( $className ); ?>">
                    <div class="footer-static-v2">
                        <?php 
                        if( function_exists( 'front_is_mas_static_content_activated' ) && front_is_mas_static_content_activated() && ! empty( $footerStaticContentId ) ) {
                
                            $static_block = get_post( $footerStaticContentId );
                            $content = isset( $static_block->post_content ) ? $static_block->post_content : '';
                            echo '<div class="footer-static-content">' . apply_filters( 'the_content', $content ) . '</div>';
                        }
                        ?>
                    </div>
                    <?php if( function_exists( 'front_is_mas_static_content_activated' ) && front_is_mas_static_content_activated() && ! empty( $footerStaticContentId ) ) : ?>
                        <hr class="my-0">
                    <?php endif; ?>
                    <div class="row space-2"> 
                        <div class="col-6 col-lg-3 mb-7 mb-lg-0">
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
                                <p class="small text-muted"><?php if ( ! empty( $copyRightText ) ) { echo wp_kses_post( $copyRightText ); } else if ( function_exists( 'front_copyright_text' ) ) { front_copyright_text(); } ?></p>
                            <?php endif ?>    
                        </div>
                        <?php if ( is_active_sidebar( $footerWidgetColumn1 ) || is_active_sidebar( $footerWidgetColumn2 ) || is_active_sidebar( $footerWidgetColumn3 ) ) :
                            if ( ! empty( $footerWidgetColumn1 ) && is_active_sidebar( $footerWidgetColumn1 ) ) : ?>
                            <div class="col-6 col-lg-3 mb-7 mb-lg-0">
                                <?php dynamic_sidebar( $footerWidgetColumn1 ); ?>
                            </div>
                            <?php endif; ?>

                            <?php if ( ! empty( $footerWidgetColumn2 ) && is_active_sidebar( $footerWidgetColumn2 ) ) : ?>
                            <div class="col-6 col-lg-3 mb-7 mb-lg-0">
                                <?php dynamic_sidebar( $footerWidgetColumn2 ); ?>
                            </div>
                            <?php endif; ?>

                            <?php if ( ! empty( $footerWidgetColumn3 ) && is_active_sidebar( $footerWidgetColumn3 ) ) : ?>
                            <div class="col-6 col-lg-3 mb-7 mb-lg-0">
                                <?php dynamic_sidebar( $footerWidgetColumn3 ); ?>
                            </div>
                            <?php endif;
                        endif; ?>
                    </div>
                </footer>
            <?php break;

            case 'v3': ?>
                <footer class="<?php echo esc_attr( $container_class ); ?>site-footer site-footer__default style-v3 space-top-2 space-top-md-3<?php echo ( empty( $className ) ? '' : ' ' ); ?><?php echo esc_attr( $className ); ?>">
                    <div class="border-bottom">
                        <div class="row mb-7">
                            <div class="col-6 col-lg-3 mb-7 mb-lg-0 column">
                                <?php if( ! empty( $logoImageUrl ) ) : ?>
                                    <a class="d-inline-flex align-items-center mb-3" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                                        <img src="<?php echo esc_url( $logoImageUrl ); ?>" alt="<?php echo get_bloginfo( 'name' ); ?>" style="width: <?php echo esc_attr( empty( $customLogoWidth ) ? 130 : $customLogoWidth ) . 'px' ?>">
                                    </a><?php
                                else :
                                    if ( function_exists( 'front_footer_logo' ) ) {
                                        front_footer_logo();
                                    } 
                                endif;?>
                            </div>
                            <?php if ( is_active_sidebar( $footerWidgetColumn1 ) || is_active_sidebar( $footerWidgetColumn2 ) || is_active_sidebar( $footerWidgetColumn3 ) || is_active_sidebar( $footerWidgetColumn4 ) ) :
                                if ( is_active_sidebar( $footerWidgetColumn1 ) ) : ?>
                                <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-4 mb-md-0 column">
                                    <?php dynamic_sidebar( $footerWidgetColumn1 ); ?>
                                </div>
                                <?php endif; ?>

                                <?php if ( is_active_sidebar( $footerWidgetColumn2 ) ) : ?>
                                <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-4 mb-md-0 column">
                                    <?php dynamic_sidebar( $footerWidgetColumn2 ); ?>
                                </div>
                                <?php endif; ?>

                                <?php if ( is_active_sidebar( $footerWidgetColumn3 ) ) : ?>
                                <div class="col-sm-4 col-md-3 col-lg-2 mb-4 mb-md-0 column">
                                    <?php dynamic_sidebar( $footerWidgetColumn3 ); ?>
                                </div>
                                <?php endif; ?>
                                <?php if ( is_active_sidebar( $footerWidgetColumn4 ) ) : ?>
                                <div class="col-md-3 col-lg-2 column">
                                    <?php dynamic_sidebar( $footerWidgetColumn4 ); ?>
                                </div>
                                <?php endif;
                            endif; ?>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center py-7">
                        <?php if ( $enableCopyright == true ): ?>
                            <p class="small text-muted mb-0"><?php if ( ! empty( $copyRightText ) ) { echo wp_kses_post( $copyRightText ); } else if ( function_exists( 'front_copyright_text' ) ) { front_copyright_text(); } ?></p>
                        <?php endif;
                        $nav_menu_args = array(
                            'theme_location'  => 'footer_social_menu',
                            'container'       => false,
                            'menu_class'      => 'footer-social-menu list-inline mb-0',
                            'icon_class'      => array( 'btn-icon__inner' ),
                            'item_class'      => array( 'list-inline-item' ),
                            'anchor_class'    => array( 'btn', 'btn-sm', 'btn-icon' ),
                            'depth'           => 0,
                            'walker'          => new Front_Walker_Social_Media(),
                        );

                        if( $footerSocialMenuID > 0 ) {
                            $nav_menu_args['menu'] = $footerSocialMenuID;
                        } elseif( ! empty( $footerSocialMenuSlug ) ) {
                            $nav_menu_args['menu'] = $footerSocialMenuSlug;
                        }

                        if ( has_nav_menu( 'footer_social_menu' ) || $footerSocialMenuID > 0 || ! empty( $footerSocialMenuSlug ) ) {
                            wp_nav_menu( $nav_menu_args );
                        } else {
                            ?><p class="mb-0 text-right"><a href="<?php echo esc_url( admin_url( 'nav-menus.php' ) ); ?>" title="<?php echo esc_attr__( 'Add a social menu', FRONTGB_I18N ); ?>"><?php echo esc_html__( 'Add a social menu', FRONTGB_I18N ) ?></a></p><?php
                        }
                        ?>
                    </div>
                </footer>
            <?php break;

            case 'v4': ?>
                <footer class="<?php echo esc_attr( $container_class ); ?>space-2 site-footer site-footer__default style-v4<?php echo ( empty( $className ) ? '' : ' ' ); ?><?php echo esc_attr( $className ); ?>">
                    <div class="text-center">
                        <?php
                            if( function_exists( 'front_is_mas_static_content_activated' ) && front_is_mas_static_content_activated() && ! empty( $footerStaticContentId ) ) {
                    
                                $static_block = get_post( $footerStaticContentId );
                                $content = isset( $static_block->post_content ) ? $static_block->post_content : '';
                                echo '<div class="footer-static-content">' . apply_filters( 'the_content', $content ) . '</div>';
                            }
                        ?>
                    </div>
                    <?php if( function_exists( 'front_is_mas_static_content_activated' ) && front_is_mas_static_content_activated() && ! empty( $footerStaticContentId ) ): ?>
                        <hr class="my-7">
                    <?php endif; ?>
                    <div class="row align-items-md-center">
                        <div class="col-md-4 mb-4 mb-md-0">
                            <div class="d-flex align-items-center logo-v4">
                                <?php if( ! empty( $logoImageUrl ) ) : ?>
                                    <a class="d-inline-flex mr-3" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                                        <img src="<?php echo esc_url( $logoImageUrl ); ?>" alt="<?php echo get_bloginfo( 'name' ); ?>" style="width: <?php echo esc_attr( empty( $customLogoWidth ) ? 130 : $customLogoWidth ) . 'px' ?>">
                                    </a><?php
                                else :
                                    if ( function_exists( 'front_footer_logo' ) ) {
                                        front_footer_logo();
                                    } 
                                endif;
                                if ( $enableCopyright == true ): ?>
                                    <p class="small mb-0"><?php if ( ! empty( $copyRightText ) ) { echo wp_kses_post( $copyRightText ); } else if ( function_exists( 'front_copyright_text' ) ) { front_copyright_text(); } ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4 mb-4 mb-sm-0">
                            <?php
                                $nav_menu_args = array(
                                    'theme_location'     => 'footer_primary_menu',
                                    'depth'              => 0,
                                    'container'          => false,
                                    'menu_class'         => 'footer-primary-menu list-inline',
                                    'fallback_cb'        => 'Front_Walker_Bootstrap_Nav_Menu::fallback',
                                    'walker'             => new Front_Walker_Bootstrap_Nav_Menu(),
                                );

                                if( $footerPrimaryMenuID > 0 ) {
                                    $nav_menu_args['menu'] = $footerPrimaryMenuID;
                                } elseif( ! empty( $footerPrimaryMenuSlug ) ) {
                                    $nav_menu_args['menu'] = $footerPrimaryMenuSlug;
                                }

                                wp_nav_menu( $nav_menu_args );
                            ?>
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <?php
                                $nav_menu_args = array(
                                    'theme_location'  => 'footer_social_menu',
                                    'container'       => false,
                                    'menu_class'      => 'footer-social-menu list-inline mb-0',
                                    'icon_class'      => array( 'btn-icon__inner' ),
                                    'item_class'      => array( 'list-inline-item' ),
                                    'anchor_class'    => array( 'btn', 'btn-sm', 'btn-icon' ),
                                    'depth'           => 0,
                                    'walker'          => new Front_Walker_Social_Media(),
                                );

                                if( $footerSocialMenuID > 0 ) {
                                    $nav_menu_args['menu'] = $footerSocialMenuID;
                                } elseif( ! empty( $footerSocialMenuSlug ) ) {
                                    $nav_menu_args['menu'] = $footerSocialMenuSlug;
                                }

                                if ( has_nav_menu( 'footer_social_menu' ) || $footerSocialMenuID > 0 || ! empty( $footerSocialMenuSlug ) ) {
                                    wp_nav_menu( $nav_menu_args );
                                } else {
                                    ?><p class="mb-0 text-right"><a href="<?php echo esc_url( admin_url( 'nav-menus.php' ) ); ?>" title="<?php echo esc_attr__( 'Add a social menu', FRONTGB_I18N ); ?>"><?php echo esc_html__( 'Add a social menu', FRONTGB_I18N ) ?></a></p><?php
                                }
                            ?>
                        </div>
                    </div>
                </footer>
            <?php break;

            case 'v5': ?>
                <footer class="<?php echo esc_attr( $container_class ); ?>text-center space-2 site-footer site-footer__default style-v5<?php echo ( empty( $className ) ? '' : ' ' ); ?><?php echo esc_attr( $className ); ?>">
                    <?php if( ! empty( $logoImageUrl ) ) : ?>
                        <a class="d-inline-flex align-items-center mb-3" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                            <img src="<?php echo esc_url( $logoImageUrl ); ?>" alt="<?php echo get_bloginfo( 'name' ); ?>" style="width: <?php echo esc_attr( empty( $customLogoWidth ) ? 130 : $customLogoWidth ) . 'px' ?>">
                        </a><?php
                    else :
                        if ( function_exists( 'front_footer_logo' ) ) {
                            front_footer_logo();
                        } 
                    endif;
                    $nav_menu_args = array(
                        'theme_location'     => 'footer_primary_menu',
                        'depth'              => 0,
                        'container'          => false,
                        'menu_class'         => 'footer-primary-menu list-inline',
                        'fallback_cb'        => 'Front_Walker_Bootstrap_Nav_Menu::fallback',
                        'walker'             => new Front_Walker_Bootstrap_Nav_Menu(),
                    );

                    if( $footerPrimaryMenuID > 0 ) {
                        $nav_menu_args['menu'] = $footerPrimaryMenuID;
                    } elseif( ! empty( $footerPrimaryMenuSlug ) ) {
                        $nav_menu_args['menu'] = $footerPrimaryMenuSlug;
                    }

                    wp_nav_menu( $nav_menu_args );
                    if ( $enableCopyright == true ): ?>
                        <p class="small text-muted mb-0"><?php if ( ! empty( $copyRightText ) ) { echo wp_kses_post( $copyRightText ); } else if ( function_exists( 'front_copyright_text' ) ) { front_copyright_text(); } ?></p>
                    <?php endif; ?>
                </footer>
            <?php break;

            case 'v6': ?>
                <footer class="<?php echo esc_attr( $container_class ); ?>text-center space-2 site-footer site-footer__default style-v6<?php echo ( empty( $className ) ? '' : ' ' ); ?><?php echo esc_attr( $className ); ?>">
                    <?php
                    $nav_menu_args = array(
                        'theme_location'  => 'footer_social_menu',
                        'container'       => false,
                        'menu_class'      => 'footer-social-menu list-inline mb-0',
                        'icon_class'      => array( 'btn-icon__inner' ),
                        'item_class'      => array( 'list-inline-item' ),
                        'anchor_class'    => array( 'btn', 'btn-sm', 'btn-icon' ),
                        'depth'           => 0,
                        'walker'          => new Front_Walker_Social_Media(),
                    );

                    if( $footerSocialMenuID > 0 ) {
                        $nav_menu_args['menu'] = $footerSocialMenuID;
                    } elseif( ! empty( $footerSocialMenuSlug ) ) {
                        $nav_menu_args['menu'] = $footerSocialMenuSlug;
                    }

                    if ( has_nav_menu( 'footer_social_menu' ) || $footerSocialMenuID > 0 || ! empty( $footerSocialMenuSlug ) ) {
                        wp_nav_menu( $nav_menu_args );
                    } else {
                        ?><p class="mb-0 text-right"><a href="<?php echo esc_url( admin_url( 'nav-menus.php' ) ); ?>" title="<?php echo esc_attr__( 'Add a social menu', FRONTGB_I18N ); ?>"><?php echo esc_html__( 'Add a social menu', FRONTGB_I18N ) ?></a></p><?php
                    }

                    if ( $enableCopyright == true ): ?>
                        <p class="small text-muted mb-0"><?php if ( ! empty( $copyRightText ) ) { echo wp_kses_post( $copyRightText ); } else if ( function_exists( 'front_copyright_text' ) ) { front_copyright_text(); } ?></p>
                    <?php endif; ?>
                </footer>
            <?php break;

            case 'v7': ?>
                <footer class="<?php echo esc_attr( $container_class ); ?>space-2 text-center site-footer site-footer__default footer-default-v7<?php echo ( empty( $className ) ? '' : ' ' ); ?><?php echo esc_attr( $className ); ?>">
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
                        <p><?php if ( ! empty( $copyRightText ) ) { echo wp_kses_post( $copyRightText ); } else if ( function_exists( 'front_copyright_text' ) ) { front_copyright_text(); } ?></p>
                    <?php endif;

                    $nav_menu_args = array(
                        'theme_location'  => 'footer_social_menu',
                        'container'       => false,
                        'menu_class'      => 'footer-social-menu list-inline mb-0',
                        'icon_class'      => array( 'btn-icon__inner' ),
                        'item_class'      => array( 'list-inline-item' ),
                        'anchor_class'    => array( 'btn', 'btn-sm', 'btn-icon' ),
                        'depth'           => 0,
                        'walker'          => new Front_Walker_Social_Media(),
                    );

                    if( $footerSocialMenuID > 0 ) {
                        $nav_menu_args['menu'] = $footerSocialMenuID;
                    } elseif( ! empty( $footerSocialMenuSlug ) ) {
                        $nav_menu_args['menu'] = $footerSocialMenuSlug;
                    }

                    if ( has_nav_menu( 'footer_social_menu' ) || $footerSocialMenuID > 0 || ! empty( $footerSocialMenuSlug ) ) {
                        wp_nav_menu( $nav_menu_args );
                    } else {
                        ?><p class="mb-0 text-right"><a href="<?php echo esc_url( admin_url( 'nav-menus.php' ) ); ?>" title="<?php echo esc_attr__( 'Add a social menu', FRONTGB_I18N ); ?>"><?php echo esc_html__( 'Add a social menu', FRONTGB_I18N ) ?></a></p><?php
                    }
                    ?>
                </footer>
            <?php break;

            case 'v8': ?>
                <footer id="SVGFooter" class="gradient-overlay-half-indigo-v1 overflow-hidden site-footer site-footer__default footer-default-v8<?php echo ( empty( $className ) ? '' : ' ' ); ?><?php echo esc_attr( $className ); ?>">
                    <div class="<?php echo esc_attr( $container_class ); ?>space-2">
                        <?php
                            if( function_exists( 'front_is_mas_static_content_activated' ) && front_is_mas_static_content_activated() && ! empty( $footerStaticContentId ) ) {
                    
                                $static_block = get_post( $footerStaticContentId );
                                $content = isset( $static_block->post_content ) ? $static_block->post_content : '';
                                echo '<div class="footer-static-content">' . apply_filters( 'the_content', $content ) . '</div>';
                                ?><hr class="my-9"><?php
                            }
                        ?>
                        <div class="row footer-widgets">
                            <div class="column col-6 col-lg-3 mb-7 mb-lg-0">
                               <?php if( ! empty( $logoImageUrl ) ) : ?>
                                    <a class="d-inline-flex align-items-center" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                                        <img src="<?php echo esc_url( $logoImageUrl ); ?>" alt="<?php echo get_bloginfo( 'name' ); ?>" style="width: <?php echo esc_attr( empty( $customLogoWidth ) ? 130 : $customLogoWidth ) . 'px' ?>">
                                    </a><?php
                                    else :
                                        if ( function_exists( 'front_footer_logo' ) ) {
                                            front_footer_logo();
                                        } 
                                endif; 
                                ?>
                            </div>
                            <?php if ( is_active_sidebar( $footerWidgetColumn1 ) || is_active_sidebar( $footerWidgetColumn2 ) || is_active_sidebar( $footerWidgetColumn3 ) ) :
                                if ( is_active_sidebar( $footerWidgetColumn1 ) ) : ?>
                                    <div class="column col-6 col-lg-3 mb-7 mb-lg-0">
                                        <?php dynamic_sidebar( $footerWidgetColumn1 ); ?>
                                    </div>
                                <?php endif; ?>

                                <?php if ( is_active_sidebar( $footerWidgetColumn2 ) ) : ?>
                                    <div class="column col-6 col-lg-3 mb-7 mb-lg-0">
                                        <?php dynamic_sidebar( $footerWidgetColumn2 ); ?>
                                    </div>
                                <?php endif; ?>

                                <?php if ( is_active_sidebar( $footerWidgetColumn3 ) ) : ?>
                                    <div class="column col-6 col-lg-3">
                                        <?php dynamic_sidebar( $footerWidgetColumn3 ); ?>
                                    </div>
                                <?php endif;
                            endif; ?>
                        </div>
                    </div>

                    <figure class="ie-half-circle-1-1 w-35 position-absolute top-0 right-0 z-index-n1 mt-n11 mr-n11">
                        <img class="js-svg-injector" src="<?php echo front_get_assets_url() . 'svg/components/half-circle-1.svg'; ?>" alt="Image Description" data-parent="#SVGFooter">
                    </figure>

                    <figure class="ie-half-circle-2-1 w-25 position-absolute bottom-0 left-0 z-index-n1 mb-n11 ml-n11">
                        <img class="js-svg-injector" src="<?php echo front_get_assets_url() . 'svg/components/half-circle-2.svg'; ?>" alt="Image Description" data-parent="#SVGFooter">
                    </figure>
                </footer>
            <?php break;

            case 'v9': ?>
                <footer class="<?php echo esc_attr( $container_class ); ?>space-2 space-top-lg-3 site-footer site-footer__default footer-default-v9<?php echo ( empty( $className ) ? '' : ' ' ); ?><?php echo esc_attr( $className ); ?>">
                    <?php if ( is_active_sidebar( $footerWidgetColumn1 ) || is_active_sidebar( $footerWidgetColumn2 ) || is_active_sidebar( $footerWidgetColumn3 ) || is_active_sidebar( $footerWidgetColumn4 ) ) : ?>
                        <div class="row mb-11 footer-widgets">
                            <?php if ( is_active_sidebar( $footerWidgetColumn1 ) ) : ?>
                                <div class="column col-lg-3 mb-5 mb-lg-0">
                                    <?php dynamic_sidebar( $footerWidgetColumn1 ); ?>
                                </div>
                            <?php endif; ?>

                            <?php if ( is_active_sidebar( $footerWidgetColumn2 ) ) : ?>
                                <div class="column col-sm-4 col-lg-3">
                                    <?php dynamic_sidebar( $footerWidgetColumn2 ); ?>
                                </div>
                            <?php endif; ?>

                            <?php if ( is_active_sidebar( $footerWidgetColumn3 ) ) : ?>
                                <div class="column col-sm-4 col-lg-3">
                                    <?php dynamic_sidebar( $footerWidgetColumn3 ); ?>
                                </div>
                            <?php endif; ?>

                            <?php if ( is_active_sidebar( $footerWidgetColumn4 ) ) : ?>
                                <div class="column col-sm-4 col-lg-3">
                                    <?php dynamic_sidebar( $footerWidgetColumn4 ); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                    <div class="row align-items-lg-center">
                        <?php if ( $enableCopyright == true ): ?>
                        <div class="col-lg-6 mb-4 mb-lg-0">
                            <p class="small mb-0"><?php if ( ! empty( $copyRightText ) ) { echo wp_kses_post( $copyRightText ); } else if ( function_exists( 'front_copyright_text' ) ) { front_copyright_text(); } ?></p>
                        </div>
                        <?php endif; ?>
                        <div class="col-lg-6 text-lg-<?php echo esc_attr( $enableCopyright == false ? 'left' : 'right' ); ?>">
                            <?php 
                            $nav_menu_args = array(
                                'theme_location'  => 'footer_social_menu',
                                'container'       => false,
                                'menu_class'      => 'footer-social-menu list-inline mb-0',
                                'icon_class'      => array( 'btn-icon__inner' ),
                                'item_class'      => array( 'list-inline-item' ),
                                'anchor_class'    => array( 'btn', 'btn-sm', 'btn-icon' ),
                                'depth'           => 0,
                                'walker'          => new Front_Walker_Social_Media(),
                            );

                            if( $footerSocialMenuID > 0 ) {
                                $nav_menu_args['menu'] = $footerSocialMenuID;
                            } elseif( ! empty( $footerSocialMenuSlug ) ) {
                                $nav_menu_args['menu'] = $footerSocialMenuSlug;
                            }

                            if ( has_nav_menu( 'footer_social_menu' ) || $footerSocialMenuID > 0 || ! empty( $footerSocialMenuSlug ) ) {
                                wp_nav_menu( $nav_menu_args );
                            } else {
                                ?><p class="mb-0 text-right"><a href="<?php echo esc_url( admin_url( 'nav-menus.php' ) ); ?>" title="<?php echo esc_attr__( 'Add a social menu', FRONTGB_I18N ); ?>"><?php echo esc_html__( 'Add a social menu', FRONTGB_I18N ) ?></a></p><?php
                            } 
                            ?>
                        </div>
                    </div>
                </footer>
            <?php break;

            case 'v10': ?>
                <footer class="<?php echo esc_attr( $container_class ); ?>site-footer site-footer__default footer-default-v10<?php echo ( empty( $className ) ? '' : ' ' ); ?><?php echo esc_attr( $className ); ?>">
                    <div class="border-bottom space-2">
                        <div class="row justify-content-lg-between">
                            <?php if ( is_active_sidebar( $footerWidgetColumn1 ) || is_active_sidebar( $footerWidgetColumn2 ) || is_active_sidebar( $footerWidgetColumn3 ) ) : ?>
                                <?php if ( is_active_sidebar( $footerWidgetColumn1 ) ) : ?>
                                    <div class="column col-6 col-sm-4 col-lg-2 mb-7 mb-lg-0">
                                        <?php dynamic_sidebar( $footerWidgetColumn1 ); ?>
                                    </div>
                                <?php endif; ?>

                                <?php if ( is_active_sidebar( $footerWidgetColumn2 ) ) : ?>
                                    <div class="column col-6 col-sm-4 col-lg-2 mb-7 mb-lg-0">
                                        <?php dynamic_sidebar( $footerWidgetColumn2 ); ?>
                                    </div>
                                <?php endif; ?>

                                <?php if ( is_active_sidebar( $footerWidgetColumn3 ) ) : ?>
                                    <div class="column col-sm-4 col-lg-2 mb-7 mb-lg-0">
                                        <?php dynamic_sidebar( $footerWidgetColumn3 ); ?>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>
                            <?php if ( apply_filters( 'front_footer_contact_us', true )) : ?>
                                <div class="column col-lg-5 text-<?php echo  esc_attr( ( is_active_sidebar( $footerWidgetColumn1 ) || is_active_sidebar( $footerWidgetColumn2 ) || is_active_sidebar( $footerWidgetColumn3 ) ) ? 'right' : 'left' ); ?>">
                                    <span class="h1 font-weight-semi-bold"><?php echo esc_html( $contactBlockTitle ); ?></span>
                                    <small class="d-block font-weight-medium"><?php echo apply_filters( 'front_footer_block_contact_number_pretext', esc_html__( 'call us: ', FRONTGB_I18N ) ) ?><span class="text-secondary font-weight-normal"><?php echo wp_kses_post( $contactCallUsNumber ); ?></span></small>
                                    <small class="d-block font-weight-medium"><?php echo apply_filters( 'front_footer_block_contact_support_address_pretext', esc_html__( 'email us: ', FRONTGB_I18N ) ) ?><a class="font-weight-normal" href="<?php echo esc_url( $contactSupportAddressLink ); ?>"><?php echo wp_kses_post( $contactSupportAddress ); ?></a></small>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="row footer-bottom justify-content-sm-between align-items-md-center py-7">
                        <div class="d-flex align-items-center col-sm-8 mb-4 mb-sm-0">
                            <?php if ( $enableCopyright == true ): ?>
                                <span class="font-size-1 pl-0" style="margin-right: 11px;"><?php if ( ! empty( $copyRightText ) ) { echo wp_kses_post( $copyRightText ); } else if ( function_exists( 'front_copyright_text' ) ) { front_copyright_text(); } ?></span>
                            <?php endif;

                            $nav_menu_args = array(
                                'theme_location'     => 'footer_primary_menu',
                                'depth'              => 0,
                                'container'          => false,
                                'menu_class'         => 'footer-primary-menu list-inline',
                                'fallback_cb'        => 'Front_Walker_Bootstrap_Nav_Menu::fallback',
                                'walker'             => new Front_Walker_Bootstrap_Nav_Menu(),
                            );

                            if( $footerPrimaryMenuID > 0 ) {
                                $nav_menu_args['menu'] = $footerPrimaryMenuID;
                            } elseif( ! empty( $footerPrimaryMenuSlug ) ) {
                                $nav_menu_args['menu'] = $footerPrimaryMenuSlug;
                            }

                            wp_nav_menu( $nav_menu_args ); ?>
                        </div>

                        <div class="col-sm-4 text-sm-right footer-logo">
                            <?php if( ! empty( $logoImageUrl ) ) : ?>
                                <a class="d-inline-flex align-items-center" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                                    <img src="<?php echo esc_url( $logoImageUrl ); ?>" alt="<?php echo get_bloginfo( 'name' ); ?>" style="width: <?php echo esc_attr( empty( $customLogoWidth ) ? 130 : $customLogoWidth ) . 'px' ?>">
                                </a><?php
                                else :
                                    if ( function_exists( 'front_footer_logo' ) ) {
                                        front_footer_logo();
                                    } 
                            endif; 
                            ?>
                        </div>
                    </div>
                </footer>
            <?php break;

            case 'v11': ?>
                <footer class="border-top site-footer site-footer__default footer-default-v11<?php echo ( empty( $className ) ? '' : ' ' ); ?><?php echo esc_attr( $className ); ?>">
                    <div class="<?php echo esc_attr( $container_class ); ?>space-2">
                        <div class="row">
                            <div class="column col-sm-6 col-lg-4">
                                <div class="footer-logo">
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
                                <?php if ( $enableCopyright == true ): ?>
                                <div class="mb-4">
                                    <p class="small text-muted mb-0"><?php if ( ! empty( $copyRightText ) ) { echo wp_kses_post( $copyRightText ); } else if ( function_exists( 'front_copyright_text' ) ) { front_copyright_text(); } ?></p>
                                </div>
                                <?php endif; 

                                $nav_menu_args = array(
                                    'theme_location'  => 'footer_social_menu',
                                    'container'       => false,
                                    'menu_class'      => 'footer-social-menu list-inline mb-0',
                                    'icon_class'      => array( 'btn-icon__inner' ),
                                    'item_class'      => array( 'list-inline-item' ),
                                    'anchor_class'    => array( 'btn', 'btn-sm', 'btn-icon' ),
                                    'depth'           => 0,
                                    'walker'          => new Front_Walker_Social_Media(),
                                );

                                if( $footerSocialMenuID > 0 ) {
                                    $nav_menu_args['menu'] = $footerSocialMenuID;
                                } elseif( ! empty( $footerSocialMenuSlug ) ) {
                                    $nav_menu_args['menu'] = $footerSocialMenuSlug;
                                }

                                if ( has_nav_menu( 'footer_social_menu' ) || $footerSocialMenuID > 0 || ! empty( $footerSocialMenuSlug ) ) {
                                    wp_nav_menu( $nav_menu_args );
                                } else {
                                    ?><p class="mb-0 text-right"><a href="<?php echo esc_url( admin_url( 'nav-menus.php' ) ); ?>" title="<?php echo esc_attr__( 'Add a social menu', FRONTGB_I18N ); ?>"><?php echo esc_html__( 'Add a social menu', FRONTGB_I18N ) ?></a></p><?php
                                }
                                ?>
                            </div>
                            <?php if ( is_active_sidebar( $footerWidgetColumn1 ) || is_active_sidebar( $footerWidgetColumn2 ) ) : ?>
                                <?php if ( is_active_sidebar( $footerWidgetColumn1 ) ) : ?>
                                    <div class="column col-sm-3 col-lg-2 mb-4 mb-sm-0 ml-lg-auto">
                                        <?php dynamic_sidebar( $footerWidgetColumn1 ); ?>
                                    </div>
                                <?php endif; ?>

                                <?php if ( is_active_sidebar( $footerWidgetColumn2 ) ) : ?>
                                    <div class="column col-sm-3 col-lg-2 mb-4 mb-sm-0">
                                        <?php dynamic_sidebar( $footerWidgetColumn2 ); ?>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </footer>
            <?php break;

            case 'v12': ?>
                <footer class="site-footer site-footer__default style-v12<?php echo ( empty( $className ) ? '' : ' ' ); ?><?php echo esc_attr( $className ); ?>">
                    <div class="<?php echo esc_attr( $container_class ); ?> space-1">
                        <div class="row justify-content-sm-between">
                            <div class="col-sm-6 mb-4 mb-sm-0">
                                <?php 
                                $nav_menu_args = array(
                                    'theme_location'     => 'footer_primary_menu',
                                    'depth'              => 0,
                                    'container'          => false,
                                    'menu_class'         => 'footer-primary-menu list-inline',
                                    'fallback_cb'        => 'Front_Walker_Bootstrap_Nav_Menu::fallback',
                                    'walker'             => new Front_Walker_Bootstrap_Nav_Menu(),
                                );

                                if( $footerPrimaryMenuID > 0 ) {
                                    $nav_menu_args['menu'] = $footerPrimaryMenuID;
                                } elseif( ! empty( $footerPrimaryMenuSlug ) ) {
                                    $nav_menu_args['menu'] = $footerPrimaryMenuSlug;
                                }

                                wp_nav_menu( $nav_menu_args ); 
                                ?>
                                <?php if ( $enableCopyright == true ): ?>
                                    <p class="small text-muted mb-0"><?php if ( ! empty( $copyRightText ) ) { echo wp_kses_post( $copyRightText ); } else if ( function_exists( 'front_copyright_text' ) ) { front_copyright_text(); } ?></p>
                                <?php endif; ?>
                            </div>
                            <div class="col-sm-6 align-self-sm-end text-sm-right mb-4 mb-sm-0">
                                <?php 
                                $nav_menu_args = array(
                                    'theme_location'  => 'footer_social_menu',
                                    'container'       => false,
                                    'menu_class'      => 'footer-social-menu list-inline mb-0',
                                    'icon_class'      => array( 'btn-icon__inner' ),
                                    'item_class'      => array( 'list-inline-item' ),
                                    'anchor_class'    => array( 'btn', 'btn-sm', 'btn-icon' ),
                                    'depth'           => 0,
                                    'walker'          => new Front_Walker_Social_Media(),
                                );

                                if( $footerSocialMenuID > 0 ) {
                                    $nav_menu_args['menu'] = $footerSocialMenuID;
                                } elseif( ! empty( $footerSocialMenuSlug ) ) {
                                    $nav_menu_args['menu'] = $footerSocialMenuSlug;
                                }

                                if ( has_nav_menu( 'footer_social_menu' ) || $footerSocialMenuID > 0 || ! empty( $footerSocialMenuSlug ) ) {
                                    wp_nav_menu( $nav_menu_args );
                                } else {
                                    ?><p class="mb-0 text-right"><a href="<?php echo esc_url( admin_url( 'nav-menus.php' ) ); ?>" title="<?php echo esc_attr__( 'Add a social menu', FRONTGB_I18N ); ?>"><?php echo esc_html__( 'Add a social menu', FRONTGB_I18N ) ?></a></p><?php
                                } 
                                ?>
                            </div>
                        </div>
                    </div>
                </footer>
            <?php break;

            case 'v13': ?>
                <footer id="SVGwave7BottomShape" class="site-footer position-relative site-footer__default style-v13 border-top<?php echo ( empty( $className ) ? '' : ' ' ); ?><?php echo esc_attr( $className ); ?>">
                    <div class="<?php echo esc_attr( $container_class ); ?>space-top-2 space-top-md-3 space-bottom-2 footer-logo">
                        <?php if( ! empty( $logoImageUrl ) ) : ?>
                            <a class="d-inline-flex align-items-center mb-5" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                                <img src="<?php echo esc_url( $logoImageUrl ); ?>" alt="<?php echo get_bloginfo( 'name' ); ?>" style="width: <?php echo esc_attr( empty( $customLogoWidth ) ? 130 : $customLogoWidth ) . 'px' ?>">
                            </a><?php
                            else :
                                if ( function_exists( 'front_footer_logo' ) ) {
                                    front_footer_logo();
                                } 
                        endif; ?>
                        <div class="row">
                            <div class="col-sm-6 col-lg-4 mb-7 mb-sm-0">
                                <div class="mb-4">
                                    <h2><?php echo wp_kses_post( $footerTitle ); ?></h2> 
                                </div>
                                <?php front_display_button_component( 
                                    $defaults = array( 
                                        'text'            => $buttonText, 
                                        'newTab'          => $buttonNewTab,
                                        'url'             => $buttonUrl,
                                        'size'            => $buttonSize,
                                        'design'          => $buttonDesign,
                                        'background'      => $buttonBackground,
                                        'isWide'          => $buttonIsWide,
                                        'isWideSM'        => $buttonIsWideSM,
                                        'isBlock'         => $buttonIsBlock,
                                        'borderRadius'    => $buttonBorderRadius,
                                        'isTransition'    => $buttonIsTransition,
                                    ) 
                                ); ?>
                            </div>
                            <?php if ( is_active_sidebar( $footerWidgetColumn1 ) || is_active_sidebar( $footerWidgetColumn2 ) ) : ?>
                                <?php if ( is_active_sidebar( $footerWidgetColumn1 ) ): ?>
                                    <div class="col-sm-3 col-lg-2 mb-4 mb-sm-0 ml-lg-auto">
                                        <?php dynamic_sidebar( $footerWidgetColumn1 ); ?>
                                    </div>
                                <?php endif ?>
                                <?php if ( is_active_sidebar( $footerWidgetColumn2 ) ): ?>
                                    <div class="col-sm-3 col-lg-2">
                                        <?php dynamic_sidebar( $footerWidgetColumn2 ); ?>
                                    </div>
                                <?php endif ?>
                            <?php endif ?>
                        </div>
                    </div>
                    <div class="container space-1">
                        <div class="row justify-content-end">
                            <div class="col-md-5 text-right">
                                <?php 
                                $nav_menu_args = array(
                                    'theme_location'  => 'footer_social_menu',
                                    'container'       => false,
                                    'menu_class'      => 'footer-social-menu list-inline mb-0',
                                    'icon_class'      => array( 'btn-icon__inner' ),
                                    'item_class'      => array( 'list-inline-item' ),
                                    'anchor_class'    => array( 'btn', 'btn-sm', 'btn-icon' ),
                                    'depth'           => 0,
                                    'walker'          => new Front_Walker_Social_Media(),
                                );

                                if( $footerSocialMenuID > 0 ) {
                                    $nav_menu_args['menu'] = $footerSocialMenuID;
                                } elseif( ! empty( $footerSocialMenuSlug ) ) {
                                    $nav_menu_args['menu'] = $footerSocialMenuSlug;
                                }

                                if ( has_nav_menu( 'footer_social_menu' ) || $footerSocialMenuID > 0 || ! empty( $footerSocialMenuSlug ) ) {
                                    wp_nav_menu( $nav_menu_args );
                                } else {
                                    ?><p class="mb-0 text-right"><a href="<?php echo esc_url( admin_url( 'nav-menus.php' ) ); ?>" title="<?php echo esc_attr__( 'Add a social menu', FRONTGB_I18N ); ?>"><?php echo esc_html__( 'Add a social menu', FRONTGB_I18N ) ?></a></p><?php
                                } 
                                ?>
                            </div>
                        </div>
                    </div>
                    <figure class="ie-wave-7-bottom w-80 w-md-65 w-lg-50 position-absolute bottom-0 left-0">
                        <img class="injected-svg js-svg-injector" src="<?php echo front_get_assets_url() . 'svg/components/wave-7-bottom.svg'; ?>" alt="Image Description" data-parent="#SVGwave7BottomShape">
                    </figure>
                </footer>
            <?php break;

            case 'v14': ?>
                <footer class="position-lg-absolute right-lg-0 bottom-lg-0 left-lg-0 site-footer site-footer__default style-v14<?php echo ( empty( $className ) ? '' : ' ' ); ?><?php echo esc_attr( $className ); ?>">
                    <div class="<?php echo esc_attr( $container_class ); ?>site-footer__default--inner">
                        <div class="d-flex justify-content-between align-items-center space-1">
                            <?php if ( $enableCopyright == true ): ?>
                                <p class="small text-muted mb-0"><?php if ( ! empty( $copyRightText ) ) { echo wp_kses_post( $copyRightText ); } else if ( function_exists( 'front_copyright_text' ) ) { front_copyright_text(); } ?></p>
                            <?php endif; 

                            $nav_menu_args = array(
                                'theme_location'  => 'footer_social_menu',
                                'container'       => false,
                                'menu_class'      => 'footer-social-menu list-inline mb-0',
                                'icon_class'      => array( 'btn-icon__inner' ),
                                'item_class'      => array( 'list-inline-item' ),
                                'anchor_class'    => array( 'btn', 'btn-sm', 'btn-icon' ),
                                'depth'           => 0,
                                'walker'          => new Front_Walker_Social_Media(),
                            );

                            if( $footerSocialMenuID > 0 ) {
                                $nav_menu_args['menu'] = $footerSocialMenuID;
                            } elseif( ! empty( $footerSocialMenuSlug ) ) {
                                $nav_menu_args['menu'] = $footerSocialMenuSlug;
                            }

                            if ( has_nav_menu( 'footer_social_menu' ) || $footerSocialMenuID > 0 || ! empty( $footerSocialMenuSlug ) ) {
                                wp_nav_menu( $nav_menu_args );
                            } else {
                                ?><p class="mb-0 text-right"><a href="<?php echo esc_url( admin_url( 'nav-menus.php' ) ); ?>" title="<?php echo esc_attr__( 'Add a social menu', FRONTGB_I18N ); ?>"><?php echo esc_html__( 'Add a social menu', FRONTGB_I18N ) ?></a></p><?php
                            }
                            ?>
                        </div>
                    </div>
                </footer>
            <?php break;

            case 'v15': ?>
                <footer class="<?php echo esc_attr( $container_class ); ?>site-footer site-footer__default style-v15<?php echo ( empty( $className ) ? '' : ' ' ); ?><?php echo esc_attr( $className ); ?>">
                    <div class="row justify-content-lg-between space-2">
                        <?php if ( is_active_sidebar( $footerWidgetColumn1 ) || is_active_sidebar( $footerWidgetColumn2 ) || is_active_sidebar( $footerWidgetColumn3 ) ) : ?>
                            <?php if ( is_active_sidebar( $footerWidgetColumn1 ) ): ?>
                                <div class="col-6 col-md-4 col-lg-3 order-lg-2 ml-lg-auto mb-7 mb-lg-0">
                                    <?php dynamic_sidebar( $footerWidgetColumn1 ); ?>
                                </div>
                            <?php endif ?>

                            <?php if ( is_active_sidebar( $footerWidgetColumn2 ) ): ?>
                                <div class="col-6 col-md-4 col-lg-3 order-lg-3 mb-7 mb-lg-0">
                                    <?php dynamic_sidebar( $footerWidgetColumn2 ); ?>
                                </div>
                            <?php endif ?>

                            <?php if ( is_active_sidebar( $footerWidgetColumn3 ) ): ?>
                                <div class="col-md-4 col-lg-2 order-lg-4 mb-7 mb-lg-0">
                                    <?php dynamic_sidebar( $footerWidgetColumn3 ); ?>
                                </div>
                            <?php endif ?>
                        <?php endif; ?>
                        <div class="col-lg-3 order-lg-1">
                            <div class="d-flex align-items-start flex-column h-100 footer-logo">
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
                                    <p class="small text-muted mb-0"><?php if ( ! empty( $copyRightText ) ) { echo wp_kses_post( $copyRightText ); } else if ( function_exists( 'front_copyright_text' ) ) { front_copyright_text(); } ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <hr class="my-0">
                    <div class="row align-items-md-center space-1">
                        <div class="col-md-4 mb-4 mb-lg-0">
                            <?php 
                            $nav_menu_args = array(
                                'theme_location'  => 'footer_social_menu',
                                'container'       => false,
                                'menu_class'      => 'footer-social-menu list-inline mb-0',
                                'icon_class'      => array( 'btn-icon__inner' ),
                                'item_class'      => array( 'list-inline-item' ),
                                'anchor_class'    => array( 'btn', 'btn-sm', 'btn-icon' ),
                                'depth'           => 0,
                                'walker'          => new Front_Walker_Social_Media(),
                            );

                            if( $footerSocialMenuID > 0 ) {
                                $nav_menu_args['menu'] = $footerSocialMenuID;
                            } elseif( ! empty( $footerSocialMenuSlug ) ) {
                                $nav_menu_args['menu'] = $footerSocialMenuSlug;
                            }

                            if ( has_nav_menu( 'footer_social_menu' ) || $footerSocialMenuID > 0 || ! empty( $footerSocialMenuSlug ) ) {
                                wp_nav_menu( $nav_menu_args );
                            } else {
                                ?><p class="mb-0 text-right"><a href="<?php echo esc_url( admin_url( 'nav-menus.php' ) ); ?>" title="<?php echo esc_attr__( 'Add a social menu', FRONTGB_I18N ); ?>"><?php echo esc_html__( 'Add a social menu', FRONTGB_I18N ) ?></a></p><?php
                            } 
                            ?>
                        </div>
                        <div class="col-md-8 text-md-right">
                            <?php
                            $nav_menu_args = array(
                                'theme_location'     => 'footer_primary_menu',
                                'depth'              => 0,
                                'container'          => false,
                                'menu_class'         => 'footer-primary-menu list-inline',
                                'fallback_cb'        => 'Front_Walker_Bootstrap_Nav_Menu::fallback',
                                'walker'             => new Front_Walker_Bootstrap_Nav_Menu(),
                            );

                            if( $footerPrimaryMenuID > 0 ) {
                                $nav_menu_args['menu'] = $footerPrimaryMenuID;
                            } elseif( ! empty( $footerPrimaryMenuSlug ) ) {
                                $nav_menu_args['menu'] = $footerPrimaryMenuSlug;
                            }

                            wp_nav_menu( $nav_menu_args ); 
                            ?>
                        </div>
                    </div>
                </footer>
            <?php break;

            case 'v16': ?>
                <footer class="site-footer site-footer__default style-v16 border-top<?php echo ( empty( $className ) ? '' : ' ' ); ?><?php echo esc_attr( $className ); ?>">
                    <div class="<?php echo esc_attr( $container_class ); ?>">
                        <?php if ( is_active_sidebar( $footerWidgetColumn1 ) || is_active_sidebar( $footerWidgetColumn2 ) || is_active_sidebar( $footerWidgetColumn3 ) || is_active_sidebar( $footerWidgetColumn4 ) ) : ?>
                        <div class="border-bottom">
                            <div class="row justify-content-lg-between space-2">
                                <?php if ( is_active_sidebar( $footerWidgetColumn1 ) ): ?>
                                    <div class="col-6 col-sm-4 col-lg-2 mb-7 mb-lg-0">
                                        <?php dynamic_sidebar( $footerWidgetColumn1 ); ?>
                                    </div>
                                <?php endif ?>

                                <?php if ( is_active_sidebar( $footerWidgetColumn2 ) ): ?>
                                    <div class="col-6 col-sm-4 col-lg-2 mb-7 mb-lg-0">
                                        <?php dynamic_sidebar( $footerWidgetColumn2 ); ?>
                                    </div>
                                <?php endif ?>

                                <?php if ( is_active_sidebar( $footerWidgetColumn3 ) ): ?>
                                    <div class="col-sm-4 col-lg-2 mb-7 mb-lg-0">
                                        <?php dynamic_sidebar( $footerWidgetColumn3 ); ?>
                                    </div>
                                <?php endif ?>

                                <?php if ( is_active_sidebar( $footerWidgetColumn4 ) ): ?>
                                    <div class="col-md-7 col-lg-5">
                                        <div class="d-flex align-items-start flex-column h-100">
                                            <?php dynamic_sidebar( $footerWidgetColumn4 ); ?>
                                        </div>
                                    </div>
                                <?php endif ?>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php if ( $enableCopyright == true ): ?>
                        <div class="text-center py-7">
                            <p class="small text-muted mb-0"><?php if ( ! empty( $copyRightText ) ) { echo wp_kses_post( $copyRightText ); } else if ( function_exists( 'front_copyright_text' ) ) { front_copyright_text(); } ?></p>
                        </div>
                        <?php endif; ?>
                    </div>
                </footer>
            <?php break;

            case 'v17': ?>
                <footer class="container site-footer site-footer__default style-v17 text-center space-2">
                    <?php if( ! empty( $logoImageUrl ) ) : ?>
                        <a class="d-inline-flex align-items-center mb-2" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                            <img src="<?php echo esc_url( $logoImageUrl ); ?>" alt="<?php echo get_bloginfo( 'name' ); ?>" style="width: <?php echo esc_attr( empty( $customLogoWidth ) ? 130 : $customLogoWidth ) . 'px' ?>">
                        </a><?php
                        else :
                            if ( function_exists( 'front_footer_logo' ) ) {
                                front_footer_logo();
                            } 
                    endif;
                    if ( $enableCopyright == true ): ?>
                    <p class="small text-muted mb-0"><?php if ( ! empty( $copyRightText ) ) { echo wp_kses_post( $copyRightText ); } else if ( function_exists( 'front_copyright_text' ) ) { front_copyright_text(); } ?></p>
                    <?php endif; ?>
                </footer>
            <?php break;
        }
    }
}

if ( ! function_exists( 'frontgb_register_deafult_footer_block' ) ) {
    /**
     * Registers the `fgb/default-footer` block on server.
     */
    function frontgb_register_deafult_footer_block() {
        if ( ! function_exists( 'register_block_type' ) ) {
            return;
        }

        register_block_type(
            'fgb/default-footer',
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
                        'default' => false,
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
                    'footerPrimaryMenuID' => array(
                        'type' => 'number',
                        'default' => 0
                    ),
                    'footerSocialMenuID' => array(
                        'type' => 'number',
                        'default' => 0
                    ),
                    'footerPrimaryMenuSlug' => array(
                        'type' => 'string',
                    ),
                    'footerSocialMenuSlug' => array(
                        'type' => 'string',
                    ),
                    'footerStaticContentId'  => array(
                        'type' => 'number',
                    ),
                    'contactBlockTitle' => array(
                        'type' => 'string',
                        'default' => 'contact us',
                    ),
                    'contactCallUsNumber' => array(
                        'type' => 'string',
                        'default' => '+1 (062) 109-9222',
                    ),
                    'contactSupportAddress' => array(
                        'type' => 'string',
                        'default' => 'support@htmlstream.com',
                    ),
                    'contactSupportAddressLink' => array(
                        'type' => 'string',
                        'default' => '#',
                    ),
                    'footerTitle' => array(
                        'type' => 'string',
                        'default' => 'Ready to make<br><strong class="text-primary">something amazing?</strong>',
                    ),
                    'buttonText' => array(
                        'type' => 'string',
                        'default' => 'Start a New Project',
                    ),
                    'buttonUrl' => array(
                        'type' => 'string',
                        'default' => '#',
                    ),
                    'buttonSize'  => array(
                        'type' => 'string',
                        'default' => 'btn-sm',
                    ),
                    'buttonNewTab'  => array(
                        'type' => 'boolean',
                        'default' => false,
                    ),
                    'buttonDesign'  => array(
                        'type' => 'string',
                        'default' => 'default',
                    ),
                    'buttonBackground'  => array(
                        'type' => 'string',
                        'default' => 'primary',
                    ),
                    'buttonIsWide'  => array(
                        'type' => 'boolean',
                        'default' => false,
                    ),
                    'buttonIsWideSM'  => array(
                        'type' => 'boolean',
                        'default' => false,
                    ),
                    'buttonIsBlock'  => array(
                        'type' => 'boolean',
                        'default' => false,
                    ),
                    'buttonBorderRadius'  => array(
                        'type' => 'string',
                        'default' => 'default',
                    ),
                    'buttonIsTransition'  => array(
                        'type' => 'boolean',
                        'default' => true,
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
                    'footerStaticContentId' => array(
                        'type' => 'number',
                        'default' => 0
                    ),
                ),
                'render_callback' => 'frontgb_render_deafult_footer_block',
            )
        );
    }
    add_action( 'init', 'frontgb_register_deafult_footer_block' );
}