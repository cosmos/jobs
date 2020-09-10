<?php
/**
 * Front template functions.
 *
 * @package front
 */

if ( ! function_exists( 'front_display_comments' ) ) :
    /**
     * Front display comments
     *
     * @since  1.0.0
     */
    function front_display_comments() {
        // If comments are open or we have at least one comment, load up the comment template.
        if ( comments_open() || 0 !== intval( get_comments_number() ) ) :
            comments_template();
        endif;
    }
endif;

if ( ! function_exists( 'front_display_header' ) ) {
    function front_display_header( $args = array() ) {
        $defaults = array(
            'menuStyle' => 'navbar',
            'fullScreenNavStyle' => 'modal',
            'isContainerFluid' => false,
            'enablePostion' => false,
            'position' => 'abs-top',
            'positionScreen' => 'all-screens',
            'enableSticky' => false,
            'stickyPosition' => 'top',
            'stickyBreakpoint' => 'all-screens',
            'stickyScrollBehavior' => 'none',
            'enableToggleSection' => false,
            'enableShowHide' => false,
            'showHideBreakpoint' => 'all-screens',
            'showHideScrollBehavior' => 'none',
            'enableWhiteNavLinks' => false,
            'whiteNavLinksBreakpoint' => 'all-screens',
            'enableTransparent' => false,
            'transparentBreakpoint' => 'all-screens',
            'enableBorder' => false,
            'enableCollapsedLogo' => false,
            'enableFixEffect' => false,
            'background' => 'default',
            'enableTopBar' => true,
            'enableTopBarLeft' => true,
            'enableTopBarRight' => true,
            'enableLogoWhite' => false,
            'enableOffcanvasLogoWhite' => false,
            'logoAlign' => 'left',
            'logoAlignBreakpoint' => 'all-screens',
            'logoImageID' => 0,
            'logoImageUrl' => '',
            'offcanvasLogoImageUrl' => '',
            'logoScrollImageID' => 0,
            'logoScrollImageUrl' => '',
            'logoCollapsedImageID' => 0,
            'logoCollapsedImageUrl' => '',
            'navbarMenuID' => 0,
            'navbarMenuSlug' => '',
            'navbarResponsiveType' => 'collapse',
            'navbarCollapseBreakpoint' => 'md',
            'navbarAlign' => 'right',
            'navbarDropdownTrigger' => 'hover',
            'navbarScrollNav' => false,
            'enableButton' => true,
            'buttonUrl' => '#',
            'buttonNewTab' => true,
            'buttonText' => esc_html__( 'Buy Now', 'front' ),
            'buttonDesign' => 'default',
            'buttonBackground' => 'primary',
            'buttonSize' => 'default',
            'buttonIsWide' => false,
            'buttonIsWideSM' => false,
            'buttonIsBlock' => false,
            'buttonBorderRadius' => 'default',
            'buttonIcon' => '',
            'buttonIsIconAfterText' => false,
            'buttonIsIconButton' => false,
            'buttonIsTransition' => true,
            'enableCart'         => true,
            'enableMyAccount'    => true,
            'enableSearch'       => true,
            'offCanvasId'        => 0,
            'enableSeperateOffcanvasLogo' => false,
            'offcanvasLogoImageID' => '',
        );

        $args = wp_parse_args( $args, $defaults );
        extract( $args );

        $is_svg_with_site_title = apply_filters( 'front_header_logo_display_svg_with_site_title', false );
        $navbar_brand_text_class = $is_svg_with_site_title ? 'u-header__navbar-brand-text' : 'u-header__navbar-brand-text ml-0';

        $is_scroll_logo = ( ( $enableShowHide && $showHideScrollBehavior == 'changing-logo-on-scroll' ) || ( $enableSticky && $stickyScrollBehavior == 'changing-logo-on-scroll' ) ) ? true : false;
        $is_collapsed_logo = ( $enableTransparent && $enableCollapsedLogo ) ? true : false;

        // Default Logo Output
        if( empty( $logoImageUrl ) ) {
            $custom_logo_id = get_theme_mod( 'custom_logo' );
            if( $custom_logo_id ) {
                $logoImageUrl = wp_get_attachment_image_url( $custom_logo_id, 'full', false );
            }
        }

        if( ! empty( $logoImageUrl ) ) {
            $logoImageContent = sprintf( '<img src="%1$s" alt="%2$s" />', $logoImageUrl, get_bloginfo( 'name' ) );
            $logoImageClasses = array( 'navbar-brand', 'u-header__navbar-brand' );
            if( $is_scroll_logo ) {
                $logoImageClasses[] = 'u-header__navbar-brand-default';
            }
            $logoImageOutput = sprintf( '<a class="%1$s" href="%2$s">%3$s</a>', implode( ' ', $logoImageClasses ), get_home_url(), $logoImageContent );
        } else {
            $logoDefaultSVG = '';
            if( $is_svg_with_site_title ) {
                ob_start();
                front_get_template( 'assets/svg/logos/logo-short.svg' );
                $logoDefaultSVG = ob_get_clean();
            }
            $logoDefaultClasses = array( 'navbar-brand', 'u-header__navbar-brand', 'u-header__navbar-brand-center' );
            if( $is_scroll_logo ) {
                $logoDefaultClasses[] = 'u-header__navbar-brand-default';
            }
            if( $enableLogoWhite ) {
                if( $is_svg_with_site_title ) {
                    ob_start();
                    front_get_template( 'assets/svg/logos/logo-short-white.svg' );
                    $logoDefaultSVG = ob_get_clean();
                }
                $logoDefaultClasses[] = 'u-header__navbar-brand-text-white';
            }
            $logoDefaultContent = sprintf( '%1$s<span class="%2$s">%3$s</span>', $logoDefaultSVG, $navbar_brand_text_class, get_bloginfo( 'name' ) );
            $logoDefaultOutput = sprintf( '<a class="%1$s" href="%2$s">%3$s</a>', implode( ' ', $logoDefaultClasses ), get_home_url(), $logoDefaultContent );
        }

        $logoOutput = isset( $logoImageOutput ) ? $logoImageOutput : $logoDefaultOutput;

        // Scroll Logo Output
        if( $is_scroll_logo ) {
            if( ! empty( $logoScrollImageUrl ) ) {
                $logoScrollImageContent = sprintf( '<img src="%1$s" alt="%2$s" />', $logoScrollImageUrl, get_bloginfo( 'name' ) );
                $logoScrollImageClasses = array( 'navbar-brand', 'u-header__navbar-brand', 'u-header__navbar-brand-center', 'u-header__navbar-brand-on-scroll' );
                $logoScrollImageOutput = sprintf( '<a class="%1$s" href="%2$s">%3$s</a>', implode( ' ', $logoScrollImageClasses ), get_home_url(), $logoScrollImageContent );
            } else {
                $logoScrollDefaultSVG = '';
                if( $is_svg_with_site_title ) {
                    ob_start();
                    front_get_template( 'assets/svg/logos/logo-short.svg' );
                    $logoScrollDefaultSVG = ob_get_clean();
                }
                $logoScrollDefaultContent = sprintf( '%1$s<span class="%2$s">%3$s</span>', $logoScrollDefaultSVG, $navbar_brand_text_class, get_bloginfo( 'name' ) );
                $logoScrollDefaultClasses = array( 'navbar-brand', 'u-header__navbar-brand', 'u-header__navbar-brand-center', 'u-header__navbar-brand-on-scroll' );
                $logoScrollDefaultOutput = sprintf( '<a class="%1$s" href="%2$s">%3$s</a>', implode( ' ', $logoScrollDefaultClasses ), get_home_url(), $logoScrollDefaultContent );
            }

            $logoScrollOutput = isset( $logoScrollImageOutput ) ? $logoScrollImageOutput : $logoScrollDefaultOutput;

            $logoOutput .= $logoScrollOutput;
        }

        // Collapsed Logo Output
        if( $is_collapsed_logo ) {
            if( ! empty( $logoCollapsedImageUrl ) ) {
                $logoCollapsedImageContent = sprintf( '<img src="%1$s" alt="%2$s" />', $logoCollapsedImageUrl, get_bloginfo( 'name' ) );
                $logoCollapsedImageClasses = array( 'navbar-brand', 'u-header__navbar-brand', 'u-header__navbar-brand-center', 'u-header__navbar-brand-collapsed' );
                $logoCollapsedImageOutput = sprintf( '<a class="%1$s" href="%2$s">%3$s</a>', implode( ' ', $logoCollapsedImageClasses ), get_home_url(), $logoCollapsedImageContent );
            } else {
                $logoCollapsedDefaultSVG = '';
                if( $is_svg_with_site_title ) {
                    ob_start();
                    front_get_template( 'assets/svg/logos/logo-short.svg' );
                    $logoCollapsedDefaultSVG = ob_get_clean();
                }
                $logoCollapsedDefaultContent = sprintf( '%1$s<span class="%2$s">%3$s</span>', $logoCollapsedDefaultSVG, $navbar_brand_text_class, get_bloginfo( 'name' ) );
                $logoCollapsedDefaultClasses = array( 'navbar-brand', 'u-header__navbar-brand', 'u-header__navbar-brand-center', 'u-header__navbar-brand-collapsed' );
                $logoCollapsedDefaultOutput = sprintf( '<a class="%1$s" href="%2$s">%3$s</a>', implode( ' ', $logoCollapsedDefaultClasses ), get_home_url(), $logoCollapsedDefaultContent );
            }

            $logoCollapsedOutput = isset( $logoCollapsedImageOutput ) ? $logoCollapsedImageOutput : $logoCollapsedDefaultOutput;

            $logoOutput .= $logoCollapsedOutput;
        }

        if( $menuStyle == 'full-screen' )  {
            if( in_array( $fullScreenNavStyle, array( 'sidebar-left', 'sidebar-right' ) ) ) {
                if( $fullScreenNavStyle == 'sidebar-left' ) {
                    $animation_in = 'fadeInLeft';
                    $animation_out = 'fadeOutLeft';
                } else {
                    $animation_in = 'fadeInRight';
                    $animation_out = 'fadeOutRight';
                }
                ob_start();
                ?>
                <button id="sidebarHeaderInvoker" type="button" class="navbar-toggler d-block btn u-hamburger<?php if( $enableWhiteNavLinks ) { echo ' u-hamburger--white'; } ?> ml-auto target-of-invoker-has-unfolds" aria-controls="sidebarHeader" aria-haspopup="true" aria-expanded="false" data-unfold-event="click" data-unfold-hide-on-scroll="false" data-unfold-target="#sidebarHeader" data-unfold-type="css-animation" data-unfold-animation-in="<?php echo esc_attr( $animation_in ); ?>" data-unfold-animation-out="<?php echo esc_attr( $animation_out ); ?>" data-unfold-duration="500">
                    <span id="hamburgerTrigger" class="u-hamburger__box">
                        <span class="u-hamburger__inner"></span>
                    </span>
                </button>
                <?php
                $fullScreenCollapseBtn = ob_get_clean();
            } else {
                ob_start();
                ?>
                <button type="button" class="navbar-toggler d-block btn u-hamburger<?php if( $enableWhiteNavLinks ) { echo ' u-hamburger--white'; } ?> u-fullscreen--toggler" aria-label="<?php echo esc_attr__( 'Toggle navigation', 'front' ) ?>" aria-expanded="false" aria-controls="fullscreen" data-toggle="collapse" data-target="#fullscreen">
                    <span id="hamburgerTrigger" class="u-hamburger__box">
                        <span class="u-hamburger__inner"></span>
                    </span>
                </button>
                <?php
                $fullScreenCollapseBtn = ob_get_clean();
            }
        } else {
            ob_start();
            ?>
            <button type="button" class="navbar-toggler btn u-hamburger<?php if( $enableWhiteNavLinks && ! $is_collapsed_logo ) { echo ' u-hamburger--white'; } ?>" aria-label="<?php echo esc_attr__( 'Toggle navigation', 'front' ) ?>" aria-expanded="false" aria-controls="navBar" data-toggle="collapse" data-target="#navBar">
                <span id="hamburgerTrigger" class="u-hamburger__box">
                    <span class="u-hamburger__inner"></span>
                </span>
            </button>
            <?php
            $collapseBtn = ob_get_clean();
        }

        $headerClasses = array( 'u-header' );
        if( $isContainerFluid ) {
            $headerClasses[] = 'u-header--full-container';
        }
        if ( $is_collapsed_logo ) {
           $headerClasses[] = 'u-header--collapse-' . $transparentBreakpoint;
        }
        if( $enablePostion ) {
            $headerClasses[] = $positionScreen == 'all-screens' ? 'u-header--' . $position : 'u-header--' . $position . '-' . $positionScreen;
        }
        if( $enableSticky ) {
            $headerClasses[] = $stickyBreakpoint == 'all-screens' ? 'u-header--sticky-' . $stickyPosition : 'u-header--sticky-' . $stickyPosition . '-' . $stickyBreakpoint;
            if( $stickyPosition == 'top' && $enableToggleSection ) {
                $headerClasses[] = $stickyBreakpoint == 'all-screens' ? 'u-header--toggle-section' : 'u-header--toggle-section-' . $stickyBreakpoint;
            }
            if( $stickyScrollBehavior == 'toggle-topbar' ) {
                $headerClasses[] = 'u-header--hide-topbar';
            } elseif( $stickyScrollBehavior == 'white-bg-on-scroll' ) {
                $headerClasses[] = 'u-header--white-bg-on-scroll';
            }
        }
        if( $enableShowHide ) {
            $headerClasses[] = $showHideBreakpoint == 'all-screens' ? 'u-header--show-hide' : 'u-header--show-hide-' . $showHideBreakpoint;
        }
        if( $enableWhiteNavLinks ) {
            $headerClasses[] = $whiteNavLinksBreakpoint == 'all-screens' ? 'u-header--white-nav-links' : 'u-header--white-nav-links-' . $whiteNavLinksBreakpoint;
        }
        if( $enableTransparent ) {
            $headerClasses[] = $transparentBreakpoint == 'all-screens' ? 'u-header--bg-transparent' : 'u-header--bg-transparent-' . $transparentBreakpoint;
        }
        if( $menuStyle == 'navbar' && $navbarAlign != 'right' ) {
            $headerClasses[] = 'u-header-' . $navbarAlign . '-aligned-nav';
        }
        if( $logoAlign == 'center' ) {
            $headerClasses[] = $logoAlignBreakpoint == 'all-screens' ? 'u-header--center-aligned' : 'u-header--center-aligned-' . $logoAlignBreakpoint;
        }
        if( in_array( $background, array( 'dark', 'navbar-primary', 'navbar-gradient', 'navbar-dark' ) ) ) {
            $headerClasses[] = 'u-header--navbar-bg';
        }
        if( in_array( $background, array( 'dark', 'submenu-dark' ) ) ) {
            $headerClasses[] = 'u-header--sub-menu-dark-bg';
        }
        if( in_array( $background, array( 'white-to-dark-on-scroll', 'dark-to-white-on-scroll' ) ) ) {
            $headerClasses[] = 'u-header--change-appearance-md';
        }
        if( ! empty( $className ) ) {
            $headerClasses[] = $className;
        }
        $headerClasses = apply_filters( 'front_header_classes', $headerClasses );

        $sectionClasses = array( 'u-header__section' );
        if( $enablePostion && $position == 'floating' ) {
            $sectionClasses[] = 'u-header--floating__inner';
        }
        if( $enableTransparent && $enableBorder ) {
            $sectionClasses[] = 'u-header__section-divider';
        }
        if( in_array( $background, array( 'dark', 'navbar-dark', 'dark-to-white-on-scroll' ) ) ) {
            $sectionClasses[] = 'bg-dark';
        }
        if( in_array( $background, array( 'navbar-primary' ) ) ) {
            $sectionClasses[] = 'bg-primary';
        }
        if( in_array( $background, array( 'navbar-gradient' ) ) ) {
            $sectionClasses[] = 'gradient-half-primary-v1';
        }

        $topBarClasses = array( 'container', 'pt-2' );
        if( ( $enableShowHide && $showHideScrollBehavior == 'hide-topbar' ) || ( $enableSticky && $stickyScrollBehavior == 'hide-topbar' ) ) {
            $topBarClasses[] = 'u-header__hide-content';
        }
        $topBarClasses = apply_filters( 'front_header_topbar_classes', $topBarClasses );

        $containerClasses = array();
        $containerClasses[] = $isContainerFluid ? 'container-fluid' : 'container';

        if( $enablePostion && $position === 'floating' ) {
            list( $sectionClasses, $containerClasses ) = array( $containerClasses, $sectionClasses );
        }

        $navBarClasses = array( 'navbar' );
        if( $menuStyle == 'navbar' ) {
            $navBarClasses[] = 'js-mega-menu';
            if( $navbarResponsiveType == 'none' ) {
                $navBarClasses[] = 'navbar-expand';
            }
            if( $navbarResponsiveType == 'collapse' && $navbarCollapseBreakpoint ) {
                $navBarClasses[] = 'navbar-expand-' . $navbarCollapseBreakpoint;
            }
            $navBarClasses[] = 'u-header__navbar';
            $navBarClasses[] = 'u-header__navbar--no-space';
            if( $navbarResponsiveType == 'scroll' ) {
                $navBarClasses[] = 'u-header__navbar--top-space';
            }
        } elseif( $menuStyle == 'off-screen' || $menuStyle == 'full-screen' ) {
            $navBarClasses[] = 'navbar-expand';
            $navBarClasses[] = 'u-header__navbar';
        }

        ?>
        <header id="header" class="<?php echo esc_attr( implode( ' ', $headerClasses ) ); ?>" <?php if( $enableFixEffect ) { echo 'data-header-fix-moment="500" data-header-fix-effect="slide"'; } ?>>
            <?php do_action( 'front_before_header_content' ); ?>
            <div class="<?php echo esc_attr( implode( ' ', $sectionClasses ) ); ?>" <?php if( $background == 'white-to-dark-on-scroll' ) { echo 'data-header-fix-moment-classes="bg-white"'; } elseif( $background == 'dark-to-white-on-scroll' ) { echo 'data-header-fix-moment-classes="bg-dark"'; } ?>>
                <?php if( $enableTopBar ) : ?>
                    <div class="<?php echo esc_attr( implode( ' ', $topBarClasses ) ); ?>">
                        <div class="d-flex align-items-center">
                            <?php if( $enableTopBarLeft ) : ?>
                                <?php do_action( 'front_topbar_left' ); ?>
                            <?php endif; ?>

                            <?php if( $enableTopBarRight ) : ?>
                                <div class="ml-auto topbar-right">
                                    <?php do_action( 'front_topbar_right' ); ?>
                                </div>

                                <ul class="list-inline ml-2 mb-0">
                                    <?php do_action( 'front_topbar_icons' ); ?>
                                </ul>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
                <div id="logoAndNav" class="<?php echo esc_attr( implode( ' ', $containerClasses ) ); ?>">
                    <?php if( in_array( $menuStyle, array( 'navbar', 'off-screen', 'logo-only' ) ) && $logoAlign == 'center' ) : ?>
                        <div class="u-header__hide-content">
                            <div class="u-header--center-aligned__inner">
                                <?php
                                    echo front_kses_post_svg( $logoOutput );
                                    if( $menuStyle == 'navbar' && $navbarResponsiveType == 'collapse' ) {
                                        echo wp_kses_post( $collapseBtn );
                                    }
                                ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <nav class="<?php echo esc_attr( implode( ' ', $navBarClasses ) ); ?>" data-dropdown-trigger="<?php echo esc_attr( $navbarDropdownTrigger ); ?>">
                        <?php if( in_array( $menuStyle, array( 'navbar', 'off-screen', 'logo-only' ) ) && $logoAlign == 'left' ) {
                            if( $menuStyle == 'navbar' && $navbarAlign == 'center' ) {
                                echo '<div class="u-header-center-aligned-nav__col">';
                            }
                            echo front_kses_post_svg( $logoOutput );
                            if( $menuStyle == 'navbar' && $navbarResponsiveType == 'collapse' ) {
                                echo wp_kses_post( $collapseBtn );
                            }
                            if( $menuStyle == 'navbar' && $navbarAlign == 'center' ) {
                                echo '</div>';
                            }
                        } ?>

                        <?php if( $navbarDropdownTrigger == 'click' ) {
                            add_filter( 'front_navbar_dropdown_trigger_default', 'front_navbar_dropdown_trigger_toggle_click' );
                        } ?>

                        <?php if( $menuStyle == 'navbar' ) {
                            $nav_menu_container_class = '';
                            if( $navbarResponsiveType == 'collapse' ) {
                                $nav_menu_container_class = 'collapse navbar-collapse u-header__navbar-collapse';
                            }
                            if( $navbarResponsiveType == 'scroll' ) {
                                $nav_menu_container_class = 'u-header__navbar-nav-scroll u-header__navbar-body';
                            }

                            $nav_menu_menu_class = 'navbar-nav u-header__navbar-nav';
                            if( $navbarScrollNav ) {
                                wp_enqueue_script( 'front-hs-scroll-nav' );
                                $nav_menu_menu_class .= ' js-scroll-nav';
                            }

                            $nav_menu_args = array(
                                'theme_location'     => 'primary',
                                'depth'              => 0,
                                'container'          => 'div',
                                'container_class'    => $nav_menu_container_class,
                                'container_id'       => 'navBar',
                                'menu_class'         => $nav_menu_menu_class,
                                'fallback_cb'        => 'Front_Walker_Bootstrap_Nav_Menu::fallback',
                                'walker'             => new Front_Walker_Bootstrap_Nav_Menu(),
                            );

                            if( $navbarMenuID > 0 ) {
                                $nav_menu_args['menu'] = $navbarMenuID;
                            } elseif( ! empty( $navbarMenuSlug ) ) {
                                $nav_menu_args['menu'] = $navbarMenuSlug;
                            }

                            wp_nav_menu( $nav_menu_args );
                        } ?>

                        <?php if( $enableButton && $menuStyle == 'off-screen' ) : ?>
                            <div class="ml-auto">
                                <?php front_display_button_component( array(
                                    'url' => $buttonUrl,
                                    'newTab' => $buttonNewTab,
                                    'text' => $buttonText,
                                    'design' => $buttonDesign,
                                    'background' => $buttonBackground,
                                    'size' => $buttonSize,
                                    'isWide' => $buttonIsWide,
                                    'isWideSM' => $buttonIsWideSM,
                                    'isBlock' => $buttonIsBlock,
                                    'borderRadius' => $buttonBorderRadius,
                                    'icon' => $buttonIcon,
                                    'isIconAfterText' => $buttonIsIconAfterText,
                                    'isIconButton' => $buttonIsIconButton,
                                    'isTransition' => $buttonIsTransition,
                                ) ); ?>
                            </div>
                        <?php elseif( $enableButton && $menuStyle == 'navbar' && $navbarAlign == 'center' ) : ?>
                            <div class="u-header-center-aligned-nav__col u-header-center-aligned-nav__col-last-item">
                                <?php front_display_button_component( array(
                                    'url' => $buttonUrl,
                                    'newTab' => $buttonNewTab,
                                    'text' => $buttonText,
                                    'design' => $buttonDesign,
                                    'background' => $buttonBackground,
                                    'size' => $buttonSize,
                                    'isWide' => $buttonIsWide,
                                    'isWideSM' => $buttonIsWideSM,
                                    'isBlock' => $buttonIsBlock,
                                    'borderRadius' => $buttonBorderRadius,
                                    'icon' => $buttonIcon,
                                    'isIconAfterText' => $buttonIsIconAfterText,
                                    'isIconButton' => $buttonIsIconButton,
                                    'isTransition' => $buttonIsTransition,
                                ) ); ?>
                            </div>
                        <?php endif; ?>

                        <?php if( $menuStyle == 'full-screen' ) : ?>
                            <?php if( in_array( $fullScreenNavStyle, array( 'sidebar-left', 'sidebar-right' ) ) ) : ?>
                                <?php
                                    echo front_kses_post_svg( $logoOutput );
                                    echo wp_kses_post( $fullScreenCollapseBtn );
                                ?>
                            <?php else : ?>
                                <div class="d-flex justify-content-between w-100">
                                    <?php
                                        echo front_kses_post_svg( $logoOutput );
                                        echo wp_kses_post( $fullScreenCollapseBtn );
                                    ?>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </nav>
                    <?php if( $menuStyle == 'full-screen' && $fullScreenNavStyle == 'modal' ) : ?>
                        <div id="fullscreen"
                            class="u-fullscreen"
                            data-overlay-classes="u-fullscreen__overlay"
                        >
                            <div class="u-fullscreen__container">
                                <div class="container">
                                    <?php
                                        ob_start(); ?>
                                        <div class="row justify-content-md-between align-items-center">
                                            <div id="fullscreenWrapper" class="col-md-6">
                                                <?php
                                                    $offcanvas_menu_args = array(
                                                        'theme_location'     => 'offcanvas_menu',
                                                        'container'          => false,
                                                        'menu_class'         => 'u-fullscreen__nav offcanvas-menu-modal',
                                                        'fallback_cb'        => 'Front_Walker_Offcanvas_Modal_Menu::fallback',
                                                        'walker'             => new Front_Walker_Offcanvas_Modal_Menu(),
                                                    );

                                                    if( $offCanvasId > 0 ) {
                                                        $offcanvas_menu_args['menu'] = $offCanvasId;
                                                    }
                                                    wp_nav_menu( $offcanvas_menu_args );
                                                ?>
                                            </div>

                                            <div class="col-md-4 d-none d-md-inline-block">

                                                <?php if( apply_filters( 'front_header_fullscreen_modal_address_enable', true ) ) {
                                                    $address_title = apply_filters( 'front_header_fullscreen_modal_address_title', esc_html__( 'Address', 'front' ) );
                                                    $address_lines = apply_filters( 'front_header_fullscreen_modal_address_lines', array( '+1 (062) 109-9222', 'support@htmlstream.com', '153 Williamson Plaza, Maggieberg, MT 09514' ) );

                                                    if( ! empty( $address_title ) && ! empty( $address_lines ) ) :
                                                        ?>
                                                        <div class="mb-7">
                                                            <span class="d-block text-white font-weight-semi-bold mb-3"><?php echo wp_kses_post( $address_title ); ?></span>

                                                            <address class="mb-0">
                                                                <?php foreach ( $address_lines as $key => $address_line ) : ?>
                                                                    <span class="d-block text-white-70 mb-1"><?php echo wp_kses_post( $address_line ); ?></span>
                                                                <?php endforeach; ?>
                                                            </address>
                                                        </div>
                                                        <?php
                                                    endif;
                                                } ?>

                                                <?php if( apply_filters( 'front_header_fullscreen_modal_social_links_enable', true ) && has_nav_menu( 'footer_social_menu' ) ) {
                                                    $social_links_title = apply_filters( 'front_header_fullscreen_modal_social_links_title', esc_html__( 'Social', 'front' ) );
                                                    ?><span class="d-block text-white font-weight-semi-bold mb-3"><?php echo wp_kses_post( $social_links_title ); ?></span><?php
                                                    wp_nav_menu( array(
                                                        'theme_location'  => 'footer_social_menu',
                                                        'container'       => false,
                                                        'menu_class'      => 'footer-social-menu footer-social-menu-modal list-inline mb-0',
                                                        'icon_class'      => array( 'btn-icon__inner' ),
                                                        'item_class'      => array( 'list-inline-item' ),
                                                        'anchor_class'    => array( 'btn', 'btn-sm', 'btn-icon' , 'btn-soft-light', 'rounded-circle' ),
                                                        'depth'           => 0,
                                                        'walker'          => new Front_Walker_Social_Media(),
                                                    ) );
                                                } ?>
                                            </div>
                                        </div>
                                        <?php $fullscreenModalContent = ob_get_clean();
                                        echo apply_filters( 'front_header_fullscreen_modal_content', $fullscreenModalContent );
                                    ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php do_action( 'front_after_header_content' ); ?>
        </header>
        <?php if( $menuStyle == 'full-screen' && in_array( $fullScreenNavStyle, array( 'sidebar-left', 'sidebar-right' ) ) ) :
            if(is_rtl()) {
                if( $fullScreenNavStyle == 'sidebar-right' ) {
                    $u_sidebar_additional_class  = 'u-sidebar--left';
                } else {
                    $u_sidebar_additional_class  = '';
                }
            } else {
                if( $fullScreenNavStyle == 'sidebar-right' ) {
                    $u_sidebar_additional_class  = '';
                }
                else {
                    $u_sidebar_additional_class  = 'u-sidebar--left';
                }
            }

            ?>
            <aside id="sidebarHeader" class="u-sidebar <?php echo esc_attr( $u_sidebar_additional_class ); ?>  u-unfold--css-animation u-unfold--hidden" aria-labelledby="sidebarHeaderInvoker">
                <div class="u-sidebar__scroller">
                    <div class="u-sidebar__container">
                        <?php ob_start(); ?>
                        <div class="u-header-sidebar__footer-offset">
                            <div class="js-scrollbar u-sidebar__body">
                                <div id="headerSidebarContent" class="u-sidebar__content u-header-sidebar__content">
                                    <?php
                                    if ( $enableSeperateOffcanvasLogo == true ) {
                                        if( empty( $offcanvasLogoImageUrl ) ) {
                                            $offcanvas_custom_logo_id = get_theme_mod( 'custom_logo' );
                                            if( $offcanvas_custom_logo_id ) {
                                                $offcanvasLogoImageUrl = wp_get_attachment_image_url( $offcanvas_custom_logo_id, 'full', false );
                                            }
                                        }

                                        if( ! empty( $offcanvasLogoImageUrl ) ) {
                                            $offcanvasLogoImageContent = sprintf( '<img src="%1$s" alt="%2$s" />', $offcanvasLogoImageUrl, get_bloginfo( 'name' ) );
                                            $offcanvasLogoImageClasses = array( 'navbar-brand', 'u-header__navbar-brand' );
                                            $offcanvasLogoImageOutput = sprintf( '<a class="%1$s" href="%2$s">%3$s</a>', implode( ' ', $offcanvasLogoImageClasses ), get_home_url(), $offcanvasLogoImageContent );
                                        } else {
                                            $offcanvasLogoDefaultSVG = '';
                                            if( $is_svg_with_site_title ) {
                                                ob_start();
                                                front_get_template( 'assets/svg/logos/logo-short.svg' );
                                                $offcanvasLogoDefaultSVG = ob_get_clean();
                                            }
                                            $offcanvasLogoDefaultClasses = array( 'navbar-brand', 'u-header__navbar-brand', 'u-header__navbar-brand-center' );
                                            if( $enableOffcanvasLogoWhite ) {
                                                if( $is_svg_with_site_title ) {
                                                    ob_start();
                                                    front_get_template( 'assets/svg/logos/logo-short-white.svg' );
                                                    $offcanvasLogoDefaultSVG = ob_get_clean();
                                                }
                                                $offcanvasLogoDefaultClasses[] = 'u-header__navbar-brand-text-white';
                                            }
                                            $offcanvasLogoDefaultContent = sprintf( '%1$s<span class="%2$s">%3$s</span>', $offcanvasLogoDefaultSVG, $navbar_brand_text_class, get_bloginfo( 'name' ) );
                                            $offcanvasLogoDefaultOutput = sprintf( '<a class="%1$s" href="%2$s">%3$s</a>', implode( ' ', $offcanvasLogoDefaultClasses ), get_home_url(), $offcanvasLogoDefaultContent );
                                        }

                                        $offcanvasLogoOutput = isset( $offcanvasLogoImageOutput ) ? $offcanvasLogoImageOutput : $offcanvasLogoDefaultOutput;

                                        echo front_kses_post_svg( str_replace( "u-header__navbar-brand-center", "u-header__navbar-brand-vertical", $offcanvasLogoOutput ) );
                                    }
                                    else {
                                        echo front_kses_post_svg( str_replace( "u-header__navbar-brand-center", "u-header__navbar-brand-vertical", $logoOutput ) );
                                    }
                                    $offcanvas_menu_args = array(
                                        'theme_location'     => 'offcanvas_menu',
                                        'container'          => false,
                                        'menu_class'         => 'u-header-collapse__nav offcanvas-menu-sidebar',
                                        'fallback_cb'        => 'Front_Walker_Offcanvas_Sidebar_Menu::fallback',
                                        'walker'             => new Front_Walker_Offcanvas_Sidebar_Menu(),
                                    );

                                    if( $offCanvasId > 0 ) {
                                        $offcanvas_menu_args['menu'] = $offCanvasId;
                                    }
                                    wp_nav_menu( $offcanvas_menu_args );
                                    ?>
                                </div>
                            </div>
                        </div>
                        <footer id="SVGwaveWithDots" class="u-header-sidebar__footer offcanvas-sidebar-footer-menu">
                            <?php
                            $footer_svg_path = get_template_directory_uri();
                            $sidebar_footer_nav_menu      = apply_filters( 'front_sidebar_footer_nav_menu_ID', 0 );
                            $sidebar_footer_nav_menu_args = apply_filters( 'front_sidebar_footer_nav_menu_args', array(
                                'theme_location'  => 'sidebar_footer_menu',
                                'depth'           => 1,
                                'container'       => false,
                                'menu'            => $sidebar_footer_nav_menu,
                                'menu_class'      => "list-inline mb-0 front-user-account-sidebar-footer-menu",
                            ) );
                            if ( has_nav_menu( 'sidebar_footer_menu' ) ) {
                                wp_nav_menu( $sidebar_footer_nav_menu_args );
                            }
                            ?>
                            <div class="position-absolute right-0 bottom-0 left-0 z-index-n1">
                                <img class="js-svg-injector" src="<?php echo esc_url( $footer_svg_path ); ?>/assets/svg/components/wave-bottom-with-dots.svg" alt="Svg" data-parent="#SVGwaveWithDots">
                            </div>
                        </footer>
                        <?php $fullscreenSiderbarContent = ob_get_clean();
                        echo apply_filters( 'front_header_fullscreen_sidebar_content', $fullscreenSiderbarContent ); ?>
                    </div>
                </div>
            </aside>
        <?php endif;
    }
}

if ( ! function_exists( 'front_header' ) )  {
    /**
     * Header
     */
    function front_header() {
        global $post;

        $static_content_id = apply_filters( 'front_header_static_content_id', '' );

        if ( is_page() && isset( $post->ID ) ) {
            $clean_page_meta_values = get_post_meta( $post->ID, '_front_options', true );
            $page_meta_values = json_decode( stripslashes( $clean_page_meta_values ), true );
            if ( isset( $page_meta_values['isCustomHeader'] ) && $page_meta_values['isCustomHeader'] && ! empty( $page_meta_values['headerStaticContentID'] ) ) {
                $static_content_id = $page_meta_values['headerStaticContentID'];
            }
        }

        if( front_is_mas_static_content_activated() && ! empty( $static_content_id ) ) {
            echo do_shortcode( '[mas_static_content id=' . $static_content_id . ' wrap=0]' );
        } else {
            $args =  apply_filters( 'front_display_header_args', array(
                'enablePostion' => true,
                'position' => 'abs-top',
                'positionScreen' => 'md',
                'enableTransparent' => true,
                'transparentBreakpoint' => 'all-screens',
                'enableShowHide' => true,
                'showHideBreakpoint' => 'md',
                'enableFixEffect' => true,
            ) );
            front_display_header( $args );
        }
    }
}

if ( ! function_exists( 'front_topbar_links_mobile' ) ) :
    /**
     * Displays Jump To block in Top Bar Right
     *
     */
    function front_topbar_links_mobile() {
        if ( has_nav_menu( 'topbar_mobile' ) ) :
            require_once get_template_directory() .'/classes/walkers/class-front-walker-topbar-mobile.php';
        ?>
        <!-- Jump To -->
        <div class="d-inline-block d-sm-none position-relative mr-2">
            <a id="jumpToDropdownInvoker" class="dropdown-nav-link dropdown-toggle d-flex align-items-center" href="javascript:;" role="button"
            aria-controls="jumpToDropdown"
            aria-haspopup="true"
            aria-expanded="false"
            data-unfold-event="hover"
            data-unfold-target="#jumpToDropdown"
            data-unfold-type="css-animation"
            data-unfold-duration="300"
            data-unfold-delay="300"
            data-unfold-hide-on-scroll="true"
            data-unfold-animation-in="slideInUp"
            data-unfold-animation-out="fadeOut"><?php echo apply_filters( 'front_jumpto_text', esc_html__( 'Jump to', 'front' ) ); ?></a>
            <?php
                wp_nav_menu( array(
                    'theme_location' => 'topbar_mobile',
                    'container'      => false,
                    'depth'          => 1,
                    'menu_class'     => 'dropdown-menu dropdown-unfold',
                    'menu_id'        => 'jumpToDropdown',
                    'items_wrap'     => '<div id="%1$s" class="%2$s" aria-labelledby="jumpToDropdownInvoker">%3$s</div>',
                    'walker'         => new Front_Walker_Topbar_Mobile(),
                ) );
            ?>
        </div>
        <!-- End Jump To -->
        <?php
        endif;
    }
endif;

if ( ! function_exists( 'front_topbar_language_links_left' ) ) :
    /**
     * Displays Top Bar Language Links in Top Bar Left
     *
     */
    function front_topbar_language_links_left() {
        if( apply_filters( 'front_topbar_language_links_left_enable', true ) ) {
            $languages = array();

            if( function_exists( 'wpml_get_active_languages_filter' ) ) {
                $wpml_languages = wpml_get_active_languages_filter('');
                foreach ( $wpml_languages as $key => $value ) {
                    $value = (array) $value;
                    $flag_url = $value['country_flag_url'];
                    if( apply_filters( 'front_topbar_language_links_left_enable_svg_flag', true ) ) {
                        $flag_file_path = '/assets/vendor/flag-icon-css/flags/4x3/' . substr( $value['default_locale'], -2 ) . '.svg';
                        $located = front_locate_template( $flag_file_path );
                        if( file_exists( $located ) ) {
                            $flag_url = get_template_directory_uri() . $flag_file_path;
                        }
                    }
                    $languages[] = array(
                        'active' => $value['active'],
                        'language_code' => $value['language_code'],
                        'locale' => $value['default_locale'],
                        'name' => $value['native_name'],
                        'url' => $value['url'],
                        'translated_name' => $value['translated_name'],
                        'flag_url' => $flag_url
                    );
                }
            } elseif( function_exists( 'pll_current_language' ) && function_exists( 'pll_languages_list' ) ) {
                $pll_current_language = pll_current_language( 'slug' );
                $pll_languages_list = pll_languages_list( array( 'fields' => '' ) );
                foreach ( $pll_languages_list as $key => $value ) {
                    $value = (array) $value;
                    $flag_url = $value['flag_url'];
                    if( apply_filters( 'front_topbar_language_links_left_enable_svg_flag', true ) ) {
                        $flag_file_path = '/assets/vendor/flag-icon-css/flags/4x3/' . substr( $value['flag_code'], -2 ) . '.svg';
                        $located = front_locate_template( $flag_file_path );
                        if( file_exists( $located ) ) {
                            $flag_url = get_template_directory_uri() . $flag_file_path;
                        }
                    }
                    $languages[] = array(
                        'active' => $pll_current_language == $value['slug'],
                        'language_code' => $value['slug'],
                        'locale' => $value['locale'],
                        'name' => $value['name'],
                        'url' => $value['home_url'],
                        'translated_name' => $value['name'],
                        'flag_url' => $flag_url
                    );
                }
            }

            if( 1 < count( $languages ) ) {
                $found_key = array_search( 1, array_column( $languages, 'active' ) );
                ?>
                <div class="position-relative topbar-left-language-menu">
                    <a id="languageDropdownInvoker" class="dropdown-nav-link dropdown-toggle d-flex align-items-center" href="javascript:;" role="button" aria-controls="languageDropdown" aria-haspopup="true" aria-expanded="false" data-unfold-event="hover" data-unfold-target="#languageDropdown" data-unfold-type="css-animation" data-unfold-duration="300" data-unfold-delay="300" data-unfold-hide-on-scroll="true" data-unfold-animation-in="slideInUp" data-unfold-animation-out="fadeOut">
                        <img class="dropdown-item-icon" src="<?php echo esc_url( $languages[$found_key]['flag_url'] ); ?>" alt="<?php echo esc_attr( $languages[$found_key]['language_code'] ); ?>">
                        <span class="d-inline-block d-sm-none"><?php echo esc_html( $languages[$found_key]['language_code'] ); ?></span>
                        <span class="d-none d-sm-inline-block"><?php echo esc_html( $languages[$found_key]['name'] ); ?></span>
                    </a>
                    <div id="languageDropdown" class="dropdown-menu dropdown-unfold" aria-labelledby="languageDropdownInvoker">
                        <?php foreach( $languages as $lang ) {
                            if( $lang['active'] ) {
                                echo '<a class="dropdown-item active" href="' . esc_url( $lang['url'] ) . '">' . esc_html( $lang['translated_name'] ) . '</a>';
                            } else {
                                echo '<a class="dropdown-item" href="' . esc_url( $lang['url'] ) . '">' . esc_html( $lang['translated_name'] ) . '</a>';
                            }
                        } ?>
                    </div>
                </div>
                <?php
            }
        }
    }
endif;

if ( ! function_exists( 'front_topbar_links_left' ) ) :
    /**
     * Displays Top Bar Links in Top Bar Left
     *
     */
    function front_topbar_links_left() {
        if ( has_nav_menu( 'topbar_left' ) ) {

            require_once get_template_directory() . '/classes/walkers/class-front-walker-topbar.php';

            wp_nav_menu( apply_filters( 'front_nav_menu_topbar_left_args', array(
                'theme_location'  => 'topbar_left',
                'container'       => 'div',
                'container_class' => 'topbar-left-nav-menu d-none d-sm-inline-block',
                'menu_class'      => 'list-inline mb-0',
                'depth'           => 2,
                'walker'          => new Front_Walker_Topbar(),
            ) ) );
        }
    }
endif;

if ( ! function_exists( 'front_topbar_links_right' ) ) :
    /**
     * Displays Top Bar Links in Top Bar Right
     *
     */
    function front_topbar_links_right() {
        if ( has_nav_menu( 'topbar_right' ) ) {

            require_once get_template_directory() . '/classes/walkers/class-front-walker-topbar.php';

            wp_nav_menu( apply_filters( 'front_nav_menu_topbar_right_args', array(
                'theme_location'  => 'topbar_right',
                'container'       => 'div',
                'container_class' => 'd-none d-sm-inline-block ml-sm-auto',
                'menu_class'      => 'list-inline mb-0',
                'depth'           => 2,
                'walker'          => new Front_Walker_Topbar(),
            ) ) );
        }
    }
endif;

if ( ! function_exists( 'front_topbar' ) ) {
    function front_topbar( $args ) {
        if ( $args['enable_topbar'] ) {
            get_template_part( 'templates/header/topbar' );
        }
    }
}

if ( ! function_exists( 'front_navbar' ) ) {
    function front_navbar( $args ) {
            if ( empty( $args['navbar_class'] ) ) {
                $navbar_class = 'js-mega-menu navbar navbar-expand-md u-header__navbar u-header__navbar--no-space';
            } else {
                $navbar_class = $args['navbar_class'];
            }
        ?>
        <div id="logoAndNav" class="container">
            <!-- Nav -->
            <nav class="<?php echo esc_attr( $navbar_class ); ?>">

                <?php

                /**
                 *
                 */
                do_action( 'front_navbar_content', $args ); ?>

            </nav>
            <!-- End Nav -->
        </div><?php
    }
}

if ( ! function_exists( 'front_blog_list_post_thumbnail' ) ) {
    function front_blog_list_post_thumbnail() {
        if ( ! front_can_show_post_thumbnail() ) {
            return;
        }

        ?><div class="article__media col-sm-5 mb-5 mb-sm-0">

            <?php if ( ! is_singular() ) : ?>
            <a class="article__thumbnail-inner" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
            <?php endif; ?>

            <?php
                $img_sz_name = front_get_image_size( 'blog_list_thumbnail', 'post-thumbnail' );
                the_post_thumbnail( $img_sz_name , array( 'class' => 'article__thumbnail img-fluid w-100 rounded' ) );
            ?>

            <?php if ( ! is_singular() ) : ?>
            </a>
            <?php endif; ?>

        </div><?php
    }
}

if ( ! function_exists( 'front_blog_list_post_body' ) ) {
    function front_blog_list_post_body() {
        $body_wrapper_class = 'article__body';
        if ( front_can_show_post_thumbnail() ) {
            $body_wrapper_class = ' col-sm-7';
        } else {
            $body_wrapper_class = ' col-sm-12';
        }

        ?><div class="<?php echo esc_attr( $body_wrapper_class ); ?>">
            <div class="pt-1 pr-4">
                <?php front_posted_on( '<small class="article__date d-block text-muted mb-3">', '</small>', 'text-muted' ); ?>
                <div class="<?php echo esc_attr( has_post_thumbnail() ? "mb-7" : "mb-4" ) ?>">
                <?php
                    the_title( sprintf( '<h2 class="article__title h5"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), front_sticky_indicator() . '</a></h2>' );
                    the_excerpt();
                ?>
                </div>
                <?php
                printf(
                    '<small class="article__author d-block text-secondary">%1$s <a href="%2$s" class="text-dark font-weight-semi-bold" rel="author">%3$s</a></small>',
                    esc_html__( 'by', 'front' ),
                    esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
                    esc_html( get_the_author() )
                );
                ?>
            </div>
        </div><?php
    }
}

if ( ! function_exists( 'front_posted_on' ) ) :
    /**
     * Prints HTML with meta information for the current post-date/time.
     */
    function front_posted_on( $before = '<span class="article__date">', $after = '</span>', $anchor_class = '', $echo = true, $human_readable = false ) {
        $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
        if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
            $time_string = '<time class="article__datetime entry-date published" datetime="%1$s">%2$s</time><time class="article__datetime updated" datetime="%3$s">%4$s</time>';
        }

        $anchor_class = 'article__link ' . $anchor_class;

        if ( $human_readable ) {
            $time_string = sprintf( _x( '%s ago', '%s = human-readable time difference', 'front' ),
            human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ) );
        } else {
            $time_string = sprintf(
                $time_string,
                esc_attr( get_the_date( DATE_W3C ) ),
                esc_html( get_the_date() ),
                esc_attr( get_the_modified_date( DATE_W3C ) ),
                esc_html( get_the_modified_date() )
            );
        }

        if ( $echo ) {

            printf(
                '%1$s<a href="%2$s" class="%5$s" rel="bookmark">%3$s</a>%4$s',
                $before,
                esc_url( get_permalink() ),
                $time_string,
                $after,
                $anchor_class
            );

        } else {

            return sprintf(
                '%1$s<a href="%2$s" rel="bookmark">%3$s</a>%4$s',
                $before,
                esc_url( get_permalink() ),
                $time_string,
                $after
            );
        }
    }
endif;

if ( ! function_exists( 'front_blog_list_pagination_spacing' ) ) {
    function front_blog_list_pagination_spacing() {
        ?><div class="space-bottom-2"></div><?php
    }
}

if ( ! function_exists( 'front_paging_nav' ) ) {
    /**
     * Display navigation to next/previous set of posts when applicable.
     */
    function front_paging_nav( $ul_class = 'mb-0' ) {
        global $wp_query;
        front_bootstrap_pagination( $wp_query, true, $ul_class );
    }
}

if ( ! function_exists( 'front_paging_nav_center' ) ) {
    function front_paging_nav_center() {
        front_paging_nav( 'justify-content-center' );
    }
}

if ( ! function_exists( 'front_comment_form' ) ) :
    /**
     * Documentation for function.
     */
    function front_comment_form( $order ) {
        $commenter  = wp_get_current_commenter();
        $consent    = empty( $commenter['comment_author_email'] ) ? '' : ' checked="checked"';

        if ( true === $order || strtolower( $order ) === strtolower( get_option( 'comment_order', 'asc' ) ) ) {

            comment_form(
                array(
                    'logged_in_as' => null,
                    'title_reply'  => null,
                    'fields'       => array(
                        'author'        => '<p class="js-form-message form-group mb-3"> <input id="author" class="form-control" placeholder="' . esc_attr__( 'Name', 'front' ) . '" aria-label="Name" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" maxlength="245" required="" data-msg="' . esc_attr__( 'Please enter your name.', 'front' ) . '" data-error-class="u-has-error" data-success-class="u-has-success"/></p>',
                        'email'         => '<p class="js-form-message form-group mb-3"> <input id="email" class="form-control" placeholder="' . esc_attr__( 'Email address', 'front' ) . '" aria-label="Email address" name="email" type="email" value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30" maxlength="100" aria-describedby="email-notes" required="" data-msg="' . esc_attr__( 'Please enter your name.', 'front' ) . '" data-error-class="u-has-error" data-success-class="u-has-success"/></p>',
                        'url'           => '<p class="js-form-message form-group mb-3"> <input id="url" class="form-control" placeholder="' . esc_attr__( 'Website', 'front' ) . '" name="url" type="url" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" maxlength="200" /></p>',
                        'cookies'       => '<p class="comment-form-cookies-consent d-flex align-items-baseline order-3"><input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" value="yes"' . $consent . ' />' .'<label class="text-muted pl-2 mb-0" for="wp-comment-cookies-consent">' . esc_html__( 'Save my name, email, and website in this browser for the next time I comment.', 'front' ) . '</label></p>',
                    ),
                    'comment_field' => '<p class="js-form-message form-group mb-3 comment-form-comment"> <textarea id="comment" class="form-control" placeholder="' . esc_attr__( 'Comment', 'front' ) . '" data-msg="' . esc_attr__( 'Please enter your message.', 'front' ) . '" name="comment" cols="45" rows="7" maxlength="65525" required="required"></textarea></p>',
                    'submit_field'  => '<p class="d-flex justify-content-center order-3">%1$s %2$s</p>',
                    'title_reply_before'   => '<h3 id="reply-title" class="comment-reply-title d-block">',
                )
            );
        }
    }
endif;

if ( ! function_exists( 'front_search_push_top' ) ) :
    /**
     * Displays Search Push Top
     */
    function front_search_push_top() {
        if ( front_get_topbar_search_style() == 'push_from_top' ) {
            get_template_part( '/templates/header/search', 'push-top' );
        }
    }
endif;

if ( ! function_exists( 'front_navbar_brand' ) ) :
    /**
     * Displays Navbar brand
     */
    function front_navbar_brand() {
        $style = 'brand';
        get_template_part( '/templates/header/navbar', $style );
    }
endif;

if ( ! function_exists( 'front_navbar_toggler' ) ) :
    /**
     * Navbar Toggler for Navbar
     */
    function front_navbar_toggler() {
        ?>
        <button type="button" class="navbar-toggler btn u-hamburger"
              aria-label="<?php echo esc_html__( 'Toggle navigation', 'front' ); ?>"
              aria-expanded="false"
              aria-controls="navBar"
              data-toggle="collapse"
              data-target="#navBar">
            <span id="hamburgerTrigger" class="u-hamburger__box">
                <span class="u-hamburger__inner"></span>
            </span>
        </button><?php
    }
endif;

if ( ! function_exists( 'front_navbar_nav' ) ) :
    /**
     * Displays Primary Navigation
     */
    function front_navbar_nav( $args ) {
        if ( $args['enable_navbar_nav'] ) {
            wp_nav_menu( array(
                'theme_location'     => 'primary',
                'depth'              => 0,
                'container'          => 'div',
                'container_class'    => 'collapse navbar-collapse u-header__navbar-collapse',
                'container_id'       => 'navBar',
                'menu_class'         => 'navbar-nav u-header__navbar-nav',
                'fallback_cb'        => 'Front_Walker_Bootstrap_Nav_Menu::fallback',
                'walker'             => new Front_Walker_Bootstrap_Nav_Menu(),
            ) );
        }
    }
endif;

if ( ! function_exists( 'front_footer_social_menu' ) ) :
    /**
     * Displays Footer Social menu
     */
    function front_footer_social_menu() {
        if ( has_nav_menu( 'footer_social_menu' ) ) {
            wp_nav_menu( array(
                'theme_location'     => 'footer_social_menu',
                'container'    => false,
                'menu_class'   => 'footer-social-menu list-inline mb-0',
                'icon_class'   => array( 'btn-icon__inner' ),
                'item_class'   => array( 'list-inline-item' ),
                'anchor_class' => array( 'btn', 'btn-sm', 'btn-icon' ),
                'depth'        => 0,
                'walker'       => new Front_Walker_Social_Media(),
            ) );
        }
        else {
            ?><p><a href="<?php echo esc_url( admin_url( 'nav-menus.php' ) ); ?>" title="<?php echo esc_attr__( 'Add a social menu', 'front' ); ?>"><?php echo esc_html__( 'Add a social menu', 'front' ) ?></a></p><?php
        }
    }
endif;

if ( ! function_exists( 'front_footer_primary_menu' ) ) :
    /**
     * Displays Footer Primary menu
     */
    function front_footer_primary_menu() {
        wp_nav_menu( array(
            'theme_location'     => 'footer_primary_menu',
            'depth'              => 0,
            'container'          => false,
            'menu_class'         => 'footer-primary-menu list-inline',
            'fallback_cb'        => 'Front_Walker_Bootstrap_Nav_Menu::fallback',
            'walker'             => new Front_Walker_Bootstrap_Nav_Menu(),
        ) );
    }
endif;



if ( ! function_exists( 'front_footer_static_content' ) ) {
    /**
     * Display the static content in footer
     */
    function front_footer_static_content() {
        if( apply_filters( 'front_enable_footer_static_block', true )) {
            $static_content_id = apply_filters( 'front_footer_static_block_id', '' );

            if( front_is_mas_static_content_activated() && ! empty( $static_content_id ) ) {
                echo do_shortcode( '[mas_static_content id=' . $static_content_id . ' class="footer-static-content"]' );
            }
        }
    }
}

if ( ! function_exists( 'front_footer_contact' ) ) {
    /**
     * Front Contact Info Block at the footer
     */
    function front_footer_contact() {

        $contact_block_title   = apply_filters( 'front_contact_block_title', esc_html__( 'contact us', 'front' ) );
        $call_us_number = apply_filters( 'front_footer_contact_number', '+1 (062) 109-9222' );
        $support_address = apply_filters( 'front_footer_contact_support_address', 'support@htmlstream.com' );
        $support_address_link = apply_filters( 'front_footer_contact_support_address_link', 'mailto:support@htmlstream.com' );

        if ( apply_filters( 'front_footer_contact_us', true )) { ?>
            <span class="h1 font-weight-semi-bold"><?php echo esc_html( $contact_block_title ); ?></span>
            <small class="d-block font-weight-medium"><?php apply_filters( 'front_footer_contact_number_pretext', 'call us: ' ) ?><span class="text-secondary font-weight-normal"><?php echo wp_kses_post( $call_us_number ); ?></span></small>
            <small class="d-block font-weight-medium"><?php apply_filters( 'front_footer_contact_support_address_pretext', 'email us: ' ) ?><a class="font-weight-normal" href="<?php echo esc_url( $support_address_link ); ?>"><?php echo wp_kses_post( $support_address ); ?></a></small>
        <?php }

    }
}

if ( ! function_exists( 'front_topbar_search_icon' ) ) :
    /**
     * Displays search icon in top bar
     */
    function front_topbar_search_icon() {
        $header_search_enable = apply_filters( 'front_header_topbar_search_enable', true );
        $search_style = front_get_topbar_search_style();

        if ( $search_style === 'classic' ) {
            $atts = array(
                'id'                         => 'searchClassicInvoker',
                'class'                      => 'btn btn-xs btn-icon btn-text-secondary',
                'href'                       => 'javascript:;',
                'role'                       => 'button',
                'aria-controls'              => 'searchClassic',
                'aria-haspopup'              => 'true',
                'aria-expanded'              => 'false',
                'data-unfold-target'         => '#searchClassic',
                'data-unfold-type'           => 'css-animation',
                'data-unfold-duration'       => '300',
                'data-unfold-delay'          => '300',
                'data-unfold-hide-on-scroll' => 'true',
                'data-unfold-animation-in'   => 'slideInUp',
                'data-unfold-animation-out'  => 'fadeOut',
            );
        } else {
            $atts = array(
                'class'              => 'btn btn-xs btn-icon btn-text-secondary',
                'href'               => 'javascript:;',
                'role'               => 'button',
                'aria-haspopup'      => 'true',
                'aria-expanded'      => 'false',
                'aria-controls'      => 'searchPushTop',
                'data-unfold-type'   => 'jquery-slide',
                'data-unfold-target' => '#searchPushTop',
            );
        }

        $atts       = apply_filters( 'front_topbar_search_icon_btn_atts', $atts, $search_style );
        $attributes = front_get_attributes( $atts );
        ?>
        <?php if ( $header_search_enable == true ): ?>
            <!-- Search -->
            <li class="list-inline-item position-relative">
                <a <?php printf( $attributes ); ?>>
                    <span class="fas fa-search btn-icon__inner"></span>
                </a>

                <?php if ( $search_style === 'classic' ) : ?>
                <!-- Input -->
                <div id="searchClassic" class="dropdown-menu dropdown-unfold dropdown-menu-right" aria-labelledby="searchClassicInvoker">
                    <div class="px-3" style="width:370px">
                        <?php get_template_part( 'templates/header/topbar-search', 'form' ); ?>
                    </div>
                </div>
                <!-- End Input -->
                <?php endif; ?>
            </li>
            <!-- End Search -->
        <?php endif;
    }
endif;

if ( ! function_exists( 'front_page_header' ) ) :
    /**
     * Display the page header
     *
     * @since 1.0.0
     */
    function front_page_header() {
        global $post;
        $hide_page_header = false;

        if ( isset( $post->ID ) ) {
            $clean_page_meta_values = get_post_meta( $post->ID, '_front_options', true );
            $page_meta_values = json_decode( stripslashes( $clean_page_meta_values ), true );
            if ( isset( $page_meta_values['hidePageHeader'] ) && $page_meta_values['hidePageHeader'] ) {
                $hide_page_header = $page_meta_values['hidePageHeader'];
            }
        }

        if( ! $hide_page_header ) {
            if ( is_page_template( 'template-privacy-policy.php' ) ): ?>
                <div class="dzsparallaxer auto-init height-is-based-on-content privacy use-loading mode-scroll ugb-hero-style-v9 gradient-half-primary-v1 animation-engine-js dzsprx-readyall loaded rounded-top-pseudo" data-options="{direction: &quot;normal&quot;}">
                    <div class="divimage dzsparallaxer--target" style="height: 100vh; transform: translate3d(0px, -137.085px, 0px);">
                    </div>
                <div class="card-header position-relative gradient-half-primary-v1 space-top-2 space-bottom-3 px-7 px-md-9"><h1 class="text-white font-weight-semi-bold" style="text-align:left">Privacy &amp; Policy</h1>
                    <p class="text-white-70" style="text-align:left">
                        <?php $u_time = get_the_time('U');
                            $u_modified_time = get_the_modified_time('U');
                            if ($u_modified_time >= $u_time + 86400) {
                            echo "Last modified: ";
                            the_modified_time('F jS, Y'); }
                            else {echo "Posted on "; the_time('F jS, Y');}
                        ?>
                    </p>
                </div>
                <figure class="position-absolute right-0 bottom-0 left-0">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" preserveAspectRatio="none" x="0px" y="0px" width="100%" height="140px" viewBox="0 0 300 100" style="margin-bottom: -8px; enable-background:new 0 0 300 100;" xml:space="preserve" class="injected-svg js-svg-injector" data-parent="#SVGbgShape">
                    <style type="text/css">
                    .wave-bottom-1-sm-0{fill:#FFFFFF;}
                    </style>
                    <g>
                    <defs>
                    <rect id="waveBottom1SMID1" width="300" height="100"></rect>
                    </defs>
                    <clipPath id="waveBottom1SMID2">
                    <use xlink:href="#waveBottom1SMID1" style="overflow:visible;"></use>
                    </clipPath>
                    <path class="wave-bottom-1-sm-0 fill-white" opacity=".4" clip-path="url(#waveBottom1SMID2)" d="M10.9,63.9c0,0,42.9-34.5,87.5-14.2c77.3,35.1,113.3-2,146.6-4.7C293.7,41,315,61.2,315,61.2v54.4H10.9V63.9z"></path>
                    <path class="wave-bottom-1-sm-0 fill-white" opacity=".4" clip-path="url(#waveBottom1SMID2)" d="M-55.7,64.6c0,0,42.9-34.5,87.5-14.2c77.3,35.1,113.3-2,146.6-4.7c48.7-4.1,69.9,16.2,69.9,16.2v54.4H-55.7     V64.6z"></path>
                    <path class="wave-bottom-1-sm-0 fill-white" opacity=".4" fill-opacity="0" clip-path="url(#waveBottom1SMID2)" d="M23.4,118.3c0,0,48.3-68.9,109.1-68.9c65.9,0,98,67.9,98,67.9v3.7H22.4L23.4,118.3z"></path>
                    <path class="wave-bottom-1-sm-0 fill-white" clip-path="url(#waveBottom1SMID2)" d="M-54.7,83c0,0,56-45.7,120.3-27.8c81.8,22.7,111.4,6.2,146.6-4.7c53.1-16.4,104,36.9,104,36.9l1.3,36.7l-372-3     L-54.7,83z"></path>
                    </g>
                    </svg>
                </figure>
                </div>

            <?php else: ?>
            <div class="container space-top-md-5 space-top-lg-4 page__header">
                <header class="mb-9">
                    <?php the_title( '<h1 class="font-weight-normal page-title">', '</h1>' ); ?>
                </header>
            </div>
            <?php endif;
        }
    }
endif;

if ( ! function_exists( 'front_page_content' ) ) :
    /**
     * Display the page content
     *
     * @since 1.0.0
     */
    function front_page_content() {
        global $post;

        $clean_page_meta_values = get_post_meta( $post->ID, '_front_options', true );
        $page_meta_values = json_decode( stripslashes( $clean_page_meta_values ), true );

        $article_content_additional_class = '';

        if ( ! ( isset( $page_meta_values['disableContainer'] ) && $page_meta_values['disableContainer'] ) ) {
            $article_content_additional_class .= ' container';
        }

        if( ! empty( $page_meta_values['contentClasses'] ) ) {
            $article_content_additional_class .= ' ' . $page_meta_values['contentClasses'];
        }

        ?>
        <div class="article__content article__content--page<?php echo esc_attr( $article_content_additional_class ); ?>">
            <?php if ( is_page_template( 'template-page-sidebar-left.php' ) || is_page_template( 'template-page-sidebar-right.php' ) ): ?>
                <div class="row no-gutters">
                    <div class="col-lg-9 mb-7 mb-lg-0 <?php echo esc_attr( is_page_template( 'template-page-sidebar-left.php' ) ? 'order-lg-2 pl-lg-5' : 'pr-lg-5' ); ?>">
                        <?php the_content(); ?>
                        <?php
                            wp_link_pages(
                                array(
                                    'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'front' ),
                                    'after'  => '</div>',
                                )
                            );
                        ?>
                    </div>
                    <?php get_sidebar(); ?>
                </div>
            <?php else: ?>
                <?php the_content(); ?>
                <?php
                    wp_link_pages(
                        array(
                            'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'front' ),
                            'after'  => '</div>',
                        )
                    );
                ?>
            <?php endif; ?>
        </div><!-- .entry-content -->
        <?php
    }
endif;

if ( ! function_exists( 'front_footer_widgets' ) ) :
    /**
     * Displays footer widgets
     *
     */
    function front_footer_widgets() {
        get_template_part( 'templates/footer/widgets/v1' );
    }
endif;

if ( ! function_exists( 'front_footer_copyright' ) ) :
    /**
     * Displays copyright notice at footer
     *
     */
    function front_footer_copyright() {
        ?>
        <!-- Copyright -->
        <div class="footer-copyright container text-center space-1">
            <?php front_footer_logo(); ?>
            <?php front_copyright_text(); ?>
        </div>
        <!-- End Copyright -->
        <?php
    }
endif;

if ( ! function_exists( 'front_footer_logo' ) ) :
    /**
     * Displays Logo in Footer
     *
     */
    function front_footer_logo() {
        $seperate_logo = apply_filters( 'front_separate_footer_logo', '' );
        if( apply_filters( 'front_enable_seperate_footer_logo', true ) && !empty( $seperate_logo ) ) {
            ?><a class="mb-3 d-inline-block" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php
                echo wp_get_attachment_image( $seperate_logo['id'], array( get_theme_support( 'custom-logo', 'width' ), get_theme_support( 'custom-logo', 'height' ) ) );
            ?></a><?php
        } elseif( has_custom_logo() ) {
            the_custom_logo();
        } elseif ( apply_filters( 'front_use_footer_svg_logo', false ) ) {
            ?><a class="d-inline-flex mb-3" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php
                if ( apply_filters( 'front_use_footer_svg_logo_light', false ) ) {
                    front_get_template( 'footer/footer-logo-light.php' );
                } else {
                    front_get_template( 'footer/footer-logo.php' );
                }
             ?></a><?php
        } else {
            ?><a class="d-inline-flex align-items-center mb-3" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php
                if ( apply_filters( 'front_use_footer_svg_logo_light', false ) ) {
                    if ( apply_filters( 'front_use_footer_svg_logo_with_site_title', false ) ) {
                        front_get_template( 'footer/footer-logo-light.php' );
                    }
                    ?><span class="brand brand-light"><?php bloginfo( 'name' ); ?></span><?php
                } else {
                    if ( apply_filters( 'front_use_footer_svg_logo_with_site_title', false ) ) {
                        front_get_template( 'footer/footer-logo.php' );
                    }
                    ?><span class="brand brand-primary"><?php bloginfo( 'name' ); ?></span><?php
                }
            ?></a><?php
        }
    }
endif;

if ( ! function_exists( 'front_copyright_text' ) ) :
    /**
     * Display Copyright Text
     *
     */
    function front_copyright_text() {
        $blog_name      = get_bloginfo( 'name' );
        $copyright_text = apply_filters( 'front_footer_copyright_text', wp_kses_post( sprintf( __( '&copy; %s. %s Htmlstream. All rights reserved', 'front' ), $blog_name, date( 'Y' ) ) ));
        echo wp_kses_post( $copyright_text );
    }

endif;

if ( ! function_exists( 'front_show_page_views' ) ) :
    function front_show_page_views() {
        if ( function_exists( 'front_get_jetpack_page_views' ) ) {
            global $post;
            $count = front_get_jetpack_page_views( $post->ID );
            $count_info = sprintf( _n( 'Viewed %s time', 'Viewed %s times', $count, 'front' ), front_number_format_i18n( $count ) );
            ?>
            <div class="small text-right text-secondary">
                <span class="fas fa-eye mr-1"></span>
                <?php echo wp_kses_post( $count_info ); ?>
            </div>
            <?php
            update_post_meta( $post->ID, '_jetpack_post_views_count', absint( $count ) );
        }
    }
endif;

if ( ! function_exists( 'front_single_post_classic_header' ) ) :
/**
 * Displays Single Post Header
 */
function front_single_post_classic_header() {
    ?><div class="dzsparallaxer <?php if ( has_post_thumbnail() ): ?>auto-init <?php endif; ?>height-is-based-on-content use-loading mode-scroll" data-options='{direction: "normal"}'>
        <!-- Apply your Parallax background image here -->
        <div class="divimage dzsparallaxer--target" style="height: 130%; <?php if ( has_post_thumbnail() ): ?>background-image: url(<?php echo esc_url( get_the_post_thumbnail_url( null, 'full' ) );?>);<?php endif; ?>"></div>
        <div class="js-scroll-effect position-relative" data-scroll-effect="smoothFadeToBottom">
            <div class="container space-top-2 space-bottom-1 space-top-md-5">
                <?php front_single_post_title(); ?>
                <?php front_single_post_header_author(); ?>
            </div>
        </div>
    </div><?php
}
endif;

if ( ! function_exists( 'front_single_post_simple_header' ) ) :
/**
 * Displays Single Post Simple Header
 */
function front_single_post_simple_header() {
    ?><!-- Hero Section -->
    <div class="d-lg-flex space-top-2 space-top-md-3 space-lg-0 position-relative">
        <div class="container d-lg-flex align-items-lg-center height-lg-100vh position-relative space-md-2 space-bottom-lg-0">
            <!-- Blog -->
            <div class="w-lg-40">

                <?php front_single_post_simple_goback_link(); ?>

                <?php front_single_post_simple_author(); ?>

                <?php front_single_post_simple_info(); ?>

            </div>
            <!-- End Blog -->
        </div>

        <?php front_single_post_simple_thumbnail(); ?>
    </div>
    <!-- End Hero Section --><?php
}
endif;

if ( ! function_exists( 'front_single_post_simple_goback_link' ) ):
/**
 * Single Post Simple GoBack
 */
function front_single_post_simple_goback_link() {
    $blog_page_id  = get_option( 'page_for_posts' );

    if ( $blog_page_id ) {
        $blog_page_url   = get_permalink( $blog_page_id );
        $blog_page_title = get_the_title( $blog_page_id );
    } else {
        $blog_page_url   = home_url();
        $blog_page_title = get_bloginfo( 'name' );
    }

    ?><!-- Link -->
    <div class="space-bottom-2 space-bottom-md-3">
        <a class="text-secondary" href="<?php echo esc_url( $blog_page_url ); ?>">
            <span class="fas fa-arrow-left small mr-2"></span>
            <?php echo sprintf( '%s %s', esc_html__( 'Go to', 'front' ), $blog_page_title ); ?>
        </a>
    </div>
    <!-- End Link --><?php
}
endif;

if ( ! function_exists( 'front_single_post_simple_info' ) ) :
/**
 * Single Post Simple Info
 */
function front_single_post_simple_info() {
    ?><!-- Info -->
    <div class="mb-4">
        <?php the_title( '<h1 class="text-primary font-weight-semi-bold">', '</h1>' ); ?>
        <p class="lead"><?php echo wp_kses_post( get_the_excerpt() ); ?></p>
    </div>
    <!-- End Info --><?php
}
endif;

if ( ! function_exists( 'front_single_post_simple_thumbnail' ) ) :
/**
 * Single Post Simple Thumbnail
 */
function front_single_post_simple_thumbnail() {
    ?><!-- Sidebar Image -->
    <div class="col-lg-6 position-lg-absolute top-lg-0 right-lg-0 px-lg-0">
        <div class="dzsparallaxer auto-init height-is-based-on-content use-loading mode-scroll min-height-lg-100vh"
        data-options='{direction: "normal"}'>
            <!-- Apply your Parallax background image here -->
            <div class="divimage dzsparallaxer--target" style="height: 130%; <?php if ( has_post_thumbnail() ): ?>background-image: url(<?php echo esc_url( get_the_post_thumbnail_url( null, 'full' ) );?>);<?php endif; ?>"></div>
        </div>
    </div>
    <!-- End Sidebar Image --><?php
}
endif;

if ( ! function_exists( 'front_single_post_simple_author' ) ) :
/**
 * Single Post Simple Author
 */
function front_single_post_simple_author() {
    ?><!-- Author -->
    <div class="media align-items-center mb-4">
        <div class="u-sm-avatar mr-3">
            <?php echo get_avatar( get_the_author_meta( 'ID' ), 100, '', '', array( 'class' => 'img-fluid rounded-circle' ) ); ?>
        </div>
        <div class="media-body">
            <h4 class="d-inline-block mb-0">
                <?php printf(
                    '<a href="%1$s" class="h6 d-block mb-0" rel="author">%2$s</a>',
                    esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
                    esc_html( get_the_author() )
                ); ?>
            </h4>

        </div>
    </div>
    <!-- End Author --><?php
}
endif;

if ( ! function_exists( 'front_single_post_title' ) ) {
    function front_single_post_title() {
        the_title( '<div class="article__header text-center w-lg-80 mx-auto space-bottom-2 space-bottom-md-3"><h1 class="article__title display-4 font-size-md-down-5 text-white font-weight-normal mb-0">', '</h1></div>' );
    }
}

if ( ! function_exists( 'front_single_post_header_author' ) ) :
/**
 * Displays Author Block in the Post Header
 */
function front_single_post_header_author() {
    ?><div class="article__author text-center">
        <div class="u-avatar mx-auto mb-2">
            <?php echo get_avatar( get_the_author_meta( 'ID' ), 100, '', '', array( 'class' => 'img-fluid rounded-circle' ) ); ?>
        </div>
        <span class="d-block">
        <?php
            printf(
                '<a href="%1$s" class="h6 text-white mb-0" rel="author">%2$s</a>',
                esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
                esc_html( get_the_author() )
            );
        ?>
        </span>
    </div><?php
}
endif;

if ( ! function_exists( 'front_single_post_classic_content' ) ) {
    function front_single_post_classic_content() { ?>
        <div class="article__content article__content--post container space-top-2 space-bottom-2">
            <div class="w-lg-60 mx-auto">
                <div class="mb-4">
                    <?php front_posted_on( '<span class="article__date text-muted">', '</span>', 'text-muted' ); ?>
                </div>
                <?php
                    the_content();

                    front_link_pages();
                ?>
            </div>
        </div><?php
    }
}

if ( ! function_exists( 'front_single_post_simple_content' ) ) :
function front_single_post_simple_content() {
    ?><!-- Article Content -->
    <div class="article__content article__content--post container space-2 space-md-3">
        <div class="w-lg-60 mx-auto">
            <div class="mb-4">
                <?php front_posted_on( '<span class="article__date text-muted">', '</span>', 'text-muted' ); ?>
            </div>
            <?php
                the_content();

                front_link_pages();

                front_single_post_share();
            ?>
        </div>
    </div>
    <!-- /.Article Content --><?php
}
endif;

if ( ! function_exists( 'front_link_pages' ) ) :
/**
 * Wrapper for wp_link_pages
 */
function front_link_pages() {
    $link_pages = wp_link_pages(
        array(
            'before' => '<div class="page-links"><span class="d-block text-secondary mb-4">' . esc_html__( 'Pages:', 'front' ) . '</span><nav class="pagination mb-0">',
            'after'  => '</nav></div>',
            'link_before' => '<span class="page-link">',
            'link_after'  => '</span>',
            'echo'   => 0,
        )
    );

    $link_pages = str_replace( 'post-page-numbers', 'post-page-numbers page-item', $link_pages );
    $link_pages = str_replace( 'current', 'current active', $link_pages );
    echo wp_kses_post( $link_pages );
}
endif;

if ( ! function_exists( 'front_single_post_classic_footer' ) ) :
/**
 * Displays Footer of Single Post
 */
function front_single_post_classic_footer() {
    ob_start();
    front_single_post_tags();
    front_single_post_share();
    front_single_post_author();
    front_single_post_nav();
    $output_content = ob_get_clean();

    if( ! empty( $output_content ) ) {
        echo sprintf( '<div class="container space-bottom-2 space-bottom-md-3"><div class="w-lg-60 mx-auto">%s</div></div>', $output_content );
    }
}
endif;

if ( ! function_exists( 'front_single_post_share' ) ) :
/**
 * Displays Sharing Block in Single post_tag
 */
 function front_single_post_share() {
     if ( apply_filters( 'front_single_post_share_enabled', true ) &&
            function_exists( 'sharing_display' ) ) {
         sharing_display( '', true );
     }
 }
endif;

if ( ! function_exists( 'front_single_post_tags' ) ) :
/**
 * Displays Single Post Tags in Post Footer
 */
function front_single_post_tags() {

    if ( apply_filters( 'front_single_post_tags_enabled', true ) ) :

        $tags_list = get_the_tag_list( '<ul class="list-inline text-center mb-0"><li class="list-inline-item pb-3">', '</li><li class="list-inline-item pb-3">', '</li></ul>' );
        if ( $tags_list ) {
            printf(
                '<div class="article__tags tags-links"><span class="sr-only">%1$s </span>%2$s</div>',
                esc_html__( 'Tags:', 'front' ),
                $tags_list
            ); // WPCS: XSS OK.
        }
    endif;
}
endif;

if ( ! function_exists( 'front_single_post_simple_footer' ) ) :
/**
 * Displays Footer of Single Post Simple
 */
function front_single_post_simple_footer() {
    ob_start();
    front_single_post_author();
    $output_content = ob_get_clean();

    if( ! empty( $output_content ) ) {
        echo sprintf( '<div class="container space-bottom-2"><div class="w-lg-60 mx-auto">%s</div></div>', $output_content );
    }
}
endif;

if ( ! function_exists( 'front_single_post_author' ) ) :
/**
 * Display Author Information in Single Post
 */
function front_single_post_author() {
    if ( apply_filters( 'front_single_post_author_enabled', true ) ) {
        if ( (bool) get_the_author_meta( 'description' ) ) : ?>

        <hr class="my-7">

        <!-- Author -->
        <div class="media">
            <div class="u-avatar mr-3">
                <?php echo get_avatar( get_the_author_meta( 'ID' ), 100, '', '', array( 'class' => 'img-fluid rounded-circle' ) ); ?>
            </div>
            <div class="media-body">
                <div class="row mb-3 mb-sm-0">
                    <div class="col-sm-9 mb-2">
                        <h4 class="d-inline-block mb-0">
                            <a class="article__author d-block h6 mb-0" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
                                <?php echo esc_html( get_the_author() ); ?>
                            </a>
                        </h4>
                        <?php $author_byline = get_the_author_meta( 'user_byline' ); ?>
                        <small class="d-block text-muted"><?php echo wp_kses_post( $author_byline ); ?>&nbsp;</small>
                    </div>
                    <div class="col-sm-3 text-sm-right">
                        <a href="<?php echo get_author_feed_link( get_the_author_meta( 'ID' ) ); ?>" class="btn btn-xs btn-soft-primary font-weight-semi-bold transition-3d-hover"><?php echo esc_html__( 'Follow', 'front' ); ?></a>
                    </div>
                </div>
                <p class="small"><?php the_author_meta( 'description' ); ?></p>
            </div>
        </div><?php

        endif;
    }
}
endif;

if ( ! function_exists( 'front_single_post_comment' ) ) {
    function front_single_post_comment() {
        if ( comments_open() || get_comments_number() ) {
            comments_template();
        }
    }
}

if ( ! function_exists( 'front_footer' ) ) {
    function front_footer() {
        global $post;

        $static_content_id = apply_filters( 'front_footer_static_content_id', '' );

        if ( is_page() && isset( $post->ID ) ) {
            $clean_page_meta_values = get_post_meta( $post->ID, '_front_options', true );
            $page_meta_values = json_decode( stripslashes( $clean_page_meta_values ), true );
            if ( isset( $page_meta_values['isCustomFooter'] ) && $page_meta_values['isCustomFooter'] && ! empty( $page_meta_values['footerStaticContentID'] ) ) {
                $static_content_id = $page_meta_values['footerStaticContentID'];
            }
        }

        if( front_is_mas_static_content_activated() && ! empty( $static_content_id ) ) {
            echo do_shortcode( '[mas_static_content id=' . $static_content_id . ' wrap=0]' );
        } else {
            $footer_style = front_get_footer_style();
            $footer_version = front_get_footer_version();

            get_template_part( 'templates/footer/' . $footer_style . '/' . $footer_version );
        }
    }
}

if ( ! function_exists( 'front_get_footer_style' ) ) {
    function front_get_footer_style() {
        return apply_filters( 'front_footer_style', 'default' );
    }
}

if ( ! function_exists( 'front_get_footer_version' ) ) {
    function front_get_footer_version() {
        return apply_filters( 'front_footer_version', 'v1' );
    }
}

if ( ! function_exists( 'front_get_default_footer_style' ) ) {
    function front_get_default_footer_style( $style ) {
        return $style;
    }
}

if ( ! function_exists( 'front_get_default_footer_version' ) ) {
    function front_get_default_footer_version( $version ) {

        if ( is_404() ) {
            $version = 'v14';
        }

        return $version;
    }
}


if ( ! function_exists( 'front_single_related_posts' ) ) {
    function front_single_related_posts() {

        if ( ! apply_filters( 'front_single_related_posts_enabled', true ) ) {
            return;
        }

        global $post;

        $orig_post = $post;

        $posts_per_page = apply_filters( 'front_related_posts_number', 3 );
        $tags           = wp_get_post_tags( $post->ID );
        $categories     = get_the_category( $post->ID );
        $related_posts  = false;
        $refetch        = false;

        if ( $tags ) {
            $tag_ids = array();

            foreach( $tags as $tag ) {
                $tag_ids[] = $tag->term_id;
            }

            $related_posts_query_args = apply_filters( 'front_related_posts_query_args', array(
                'tag__in'             => $tag_ids,
                'post__not_in'        => array( $post->ID ),
                'posts_per_page'      => $posts_per_page, // Number of related posts that will be shown.
                'ignore_sticky_posts' => 1,
                'post_type'           => $post->post_type,
                'orderby'             => 'comment_count',
                'order'               => 'DESC'
            ), 'tags', $tag_ids );

            $related_posts = new WP_Query( $related_posts_query_args );

            if ( $related_posts->found_posts < 3 ) {
                $refetch = true;
            } else {
                $refetch = false;
            }
        } else {
            $refetch = true;
        }


        if ( $refetch && $categories ) {
            $category_ids = array();

            foreach( $categories as $category ) {
                $category_ids[] = $category->term_id;
            }

            $related_posts_query_args = apply_filters( 'front_related_posts_query_args', array(
                'category__in'        => $category_ids,
                'post__not_in'        => array( $post->ID ),
                'posts_per_page'      => $posts_per_page, // Number of related posts that will be shown.
                'ignore_sticky_posts' => 1,
                'post_type'           => $post->post_type,
                'orderby'             => 'comment_count',
                'order'               => 'DESC'
            ), 'categories', $category_ids );

            unset( $related_posts );

            $related_posts = new WP_Query( $related_posts_query_args );

            if ( $related_posts->found_posts < 3 ) {
                $refetch = true;
            } else {
                $refetch = false;
            }

        } else {
            $refetch = true;
        }

        if ( $refetch ) {

            $related_posts_query_args = apply_filters( 'front_related_posts_query_args', array(
                'post_type'           => $post->post_type,
                'posts_per_page'      => $posts_per_page,
                'post__not_in'        => array( $post->ID ),
                'ignore_sticky_posts' => 1,
                'orderby'             => 'comment_count',
                'order'               => 'DESC'
            ), 'popular', false );

            unset( $related_posts );

            $related_posts = new WP_Query( $related_posts_query_args );
        }

        if ( $related_posts->have_posts() ):

        ?><div class="bg-light">
            <div class="container space-2 space-bottom-md-3">
                <div class="mb-5 mb-md-9 mt-md-8 text-center">
                    <h2 class="h3 font-weight-medium mb-0"><?php echo esc_html__( 'Related Articles', 'front' ); ?></h2>
                </div>
                <div class="card-deck d-block d-md-flex card-md-gutters-3">
                    <?php while ( $related_posts->have_posts() ) : $related_posts->the_post(); ?>
                        <div class="card border-0 mb-5 mb-md-0">
                            <?php the_post_thumbnail()?>
                            <div class="card-body p-5">
                                <small class="d-block text-secondary mb-1"><?php echo get_the_date(); ?></small>
                                <h3 class="h6 mb-0">
                                    <a href="<?php echo esc_url( get_the_permalink() ); ?>"><?php the_title() ?></a>
                                </h3>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </div><?php

        endif;

        $post = $orig_post;
        wp_reset_postdata();
    }
}


if ( ! function_exists( 'front_sticky_block_endpoint' ) ) :
/**
 * Displays Sticky Block Endpoint
 */
function front_sticky_block_endpoint() {
    ?><!-- Sticky Block End Point -->
    <div id="stickyBlockEndPoint"></div><?php
}
endif;

if ( ! function_exists( 'front_page_template_content' ) ) :
/**
 * Display the post content for a page template
 * @since 1.0.0
 */
function front_page_template_content() {
    while ( have_posts() ) : the_post();
        ?>
        <div class="entry__content">
            <?php the_content(); ?>
        </div>
        <?php
    endwhile; // end of the loop.
}
endif;

if ( ! function_exists( 'front_blog_business_cbp_wrap_start' ) ) :
/**
 * CBP Wrapper for Blog Business Start
 *
 */
function front_blog_business_cbp_wrap_start() {
    ?><div id="posts-content" class="cbp" data-animation="quicksand" data-x-gap="15" data-y-gap="15" data-load-more-selector="#cubeLoadMore" data-load-more-action="auto" data-load-items-amount="4" data-media-queries='[ {"width": 1500, "cols": 4},{"width": 1100, "cols": 4}, {"width": 800, "cols": 3}, {"width": 480, "cols": 2}, {"width": 380, "cols": 1}]'><?php
}
endif;

if ( ! function_exists( 'front_blog_business_cbp_wrap_end' ) ) :
/**
 * CBP Wrapper for Blog Business End
 *
 */
function front_blog_business_cbp_wrap_end() {
    ?></div><?php
}
endif;

if ( ! function_exists( 'front_blog_business_cpb_load_more' ) ) :
/**
 * CBP Load More
 *
 */
function front_blog_business_cpb_load_more( $post ) {
    ?><div id="cubeLoadMore" class="text-center">
        <a href="<?php echo esc_url( add_query_arg( array( 'ajax' => '1' ), get_the_permalink( $post ) ) ); ?>" class="cbp-l-loadMore-link link" rel="nofollow">
            <span class="cbp-l-loadMore-defaultText">
                <?php echo esc_html__( 'Load More', 'front' ); ?>
                <span class="link__icon ml-1">
                    <span class="link__icon-inner">&#43;</span>
                </span>
            </span>
            <span class="cbp-l-loadMore-loadingText"><?php echo esc_html__( 'Loading...', 'front' ); ?></span>
            <span class="cbp-l-loadMore-noMoreLoading"><?php echo esc_html__( 'No more works', 'front' ); ?></span>
        </a>
    </div><?php
}
endif;

if ( ! function_exists( 'front_blog_agency_cbp_wrap_start' ) ) :
/**
 * Blog Agency CBP Wrapper start
 */
function front_blog_agency_cbp_wrap_start() {
    ?><div class="cbp mb-7" data-layout="mosaic" data-animation="quicksand" data-x-gap="30" data-y-gap="30" data-load-more-selector="#cubeLoadMore" data-load-more-action="auto" data-load-items-amount="3" data-media-queries='[ {"width": 1500, "cols": 3}, {"width": 1100, "cols": 3}, {"width": 800, "cols": 3}, {"width": 480, "cols": 1}]'><?php
}
endif;

if ( ! function_exists( 'front_blog_agency_cbp_wrap_end' ) ) :
/**
 * CBP Wrapper for Blog Agency End
 *
 */
function front_blog_agency_cbp_wrap_end() {
    ?></div><?php
}
endif;

if ( ! function_exists( 'front_blog_agency_tag_list' ) ):
/**
 * Get the tag list used in Blog Agency loop
 */
function front_blog_agency_tag_list() {

    $tags_list = get_the_tag_list( '<ul class="list-inline mb-0"><li class="list-inline-item g-mb-10">', '</li><li class="list-inline-item pb-3">', '</li></ul>' );
    if ( $tags_list ) {
        printf( $tags_list ); // WPCS: XSS OK.
    }
}
endif;

if ( ! function_exists( 'front_sticky_indicator' ) ) :
/**
 * Sticky Indicator
 */
function front_sticky_indicator( $badge_style = 'secondary' ) {
    $sticky_indicator = '';

    if ( is_sticky() ) {
        $sticky_indicator = ' <span class="badge badge-'. esc_attr( $badge_style ) . '">' . esc_html__( 'Featured', 'front' ) . '</span>';
    }

    return $sticky_indicator;
}
endif;

if ( ! function_exists( 'front_single_post_nav' ) ) :
/**
 * Displays navigation for Single Posts
 */
function front_single_post_nav() {
    if ( apply_filters( 'front_single_post_nav_enabled', true ) && wp_count_posts()->publish > 1 ) :
    ?><div class="space-top-2">
        <nav class="navigation post-navigation" role="navigation">
            <h2 class="screen-reader-text"><?php echo esc_html__( 'Post navigation', 'front' ); ?></h2>
            <div class="nav-links row no-gutters">
                <div class="nav-previous col-sm-6">
                <?php
                    echo get_previous_post_link(
                        '%link',
                        '<div class="u-paging-modern text-right pr-7 mb-2 mb-md-0"><span class="d-block text-muted small meta-nav" aria-hidden="true">' . esc_html__( 'Prev', 'front' ) . '</span> ' .
                        '<div class="d-flex justify-content-end"><span class="screen-reader-text">' . esc_html__( 'Previous post:', 'front' ) . '</span>' .
                        '<span class="fas fa-arrow-left u-paging-modern__arrow-icon-prev text-muted"></span><span class="text-dark h6 post-title">%title</span></div></div>'
                    );
                ?>
                </div>
                <div class="nav-next col-sm-6">
                <?php
                    echo get_next_post_link(
                        '%link',
                        '<div class="u-paging-modern text-left pl-7"><span class="d-block text-muted small meta-nav" aria-hidden="true">' . esc_html__( 'Next', 'front' ) . '</span> ' .
                        '<div class="d-flex justify-content-start"><span class="screen-reader-text">' . esc_html__( 'Next post:', 'front' ) . '</span>' .
                        '<span class="text-dark h6 post-title">%title</span><span class="fas fa-arrow-right u-paging-modern__arrow-icon-next text-muted"></span></div></div>'
                    );
                ?>
                </div>
            </div>
        </nav>
    </div><?php
    endif;
}
endif;

if ( ! function_exists( 'front_custom_widget_nav_menu_options' ) ) :
    function front_custom_widget_nav_menu_options( $widget, $return, $instance ) {
        // Are we dealing with a nav menu widget?
        if ( 'nav_menu' == $widget->id_base ) {
            $is_social_icon_menu = isset( $instance['is_social_icon_menu'] ) ? $instance['is_social_icon_menu'] : '';
            ?>
                <p>
                    <input class="checkbox" type="checkbox" id="<?php echo esc_attr( $widget->get_field_id('is_social_icon_menu') ); ?>" name="<?php echo esc_attr( $widget->get_field_name('is_social_icon_menu') ); ?>" <?php checked( true , $is_social_icon_menu ); ?> />
                    <label for="<?php echo esc_attr( $widget->get_field_id('is_social_icon_menu') ); ?>">
                        <?php esc_html_e( 'Is Social Icon Menu', 'front' ); ?>
                    </label>
                </p>
            <?php
        }
    }
endif;

if ( ! function_exists( 'front_custom_widget_nav_menu_options_update' ) ) :
    function front_custom_widget_nav_menu_options_update( $instance, $new_instance, $old_instance, $widget ) {
        if ( 'nav_menu' == $widget->id_base ) {
            if ( isset( $new_instance['is_social_icon_menu'] ) && ! empty( $new_instance['is_social_icon_menu'] ) ) {
                $instance['is_social_icon_menu'] = 1;
            }
        }

        return $instance;
    }
endif;

if ( ! function_exists( 'front_custom_widget_nav_menu_args' ) ) :
    function front_custom_widget_nav_menu_args( $nav_menu_args, $nav_menu, $args, $instance ) {
        if( isset( $instance['is_social_icon_menu'] ) && ! empty( $instance['is_social_icon_menu'] ) ) {
            $social_nav_menu_args = array(
                'container'    => false,
                'menu_class'   => 'social-icon-menu list-inline mb-0',
                'icon_class'   => array( 'btn-icon__inner' ),
                'item_class'   => array( 'list-inline-item mb-3' ),
                'anchor_class' => array( 'btn', 'btn-sm', 'btn-icon' ),
                'depth'        => 1,
                'walker'       => new Front_Walker_Social_Media(),
            );

            $nav_menu_args = array_merge( $nav_menu_args, $social_nav_menu_args );
        }

        return $nav_menu_args;
    }
endif;

if ( ! function_exists( 'front_modify_widget_pages_args' ) ) {
    function front_modify_widget_pages_args( $args, $instance ) {
        require_once get_template_directory() . '/classes/walkers/class-front-walker-page.php';
        $args['walker'] = new Front_Walker_Page;
        return $args;
    }
}

if ( ! function_exists( 'front_modify_widget_categories_args' ) ) {
    function front_modify_widget_categories_args( $args, $instance ) {
        require_once get_template_directory() . '/classes/walkers/class-front-walker-category.php';
        $args['walker'] = new Front_Walker_Category;
        return $args;
    }
}

if ( ! function_exists( 'front_modify_widget_nav_menu_args' ) ) {
    function front_modify_widget_nav_menu_args( $nav_menu_args, $nav_menu, $args, $instance ) {
        require_once get_template_directory() . '/classes/walkers/class-front-walker-nav-menu.php';
        $nav_menu_args['walker'] = new Front_Walker_Nav_Menu;
        return $nav_menu_args;
    }
}

if ( ! function_exists( 'front_modify_archives_link' ) ) {
    function front_modify_archives_link( $link_html, $url, $text, $format, $before, $after, $selected ) {

        if ( 'html' == $format ) {
            $after = str_replace( '&nbsp;', '', $after );
            $after = str_replace( '(', '', $after );
            $after = str_replace( ')', '', $after );

            if ( ! empty( $after ) ) {
                $after = "<span class='badge bg-soft-secondary badge-pill ml-2'>$after</span>";
            }

            $link_html = "\t<li>$before<a class='list-group-item list-group-item-action d-flex align-items-center' href='$url'>$text$after</a></li>\n";
        }

        return $link_html;
    }
}

if ( ! function_exists( 'front_post_protected_password_form' ) ) :

    function front_post_protected_password_form() {
        global $post;

        $label = 'pwbox-'.( empty( $post->ID ) ? rand() : $post->ID ); ?>

        <form class="protected-post-form input-group front-protected-post-form" action="<?php echo esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ); ?>" method="post">
            <p><?php echo esc_html__( 'This content is password protected. To view it please enter your password below:', 'front' ); ?></p>
            <div class="d-flex align-items-center w-md-85">
                <label class="text-secondary mb-0" for="<?php echo esc_attr( $label ); ?>"><?php echo esc_html__( 'Password:', 'front' ); ?></label>
                <div class="d-flex flex-grow-1 ml-3" style="height: 52px;">
                    <input class="h-100 form-control rounded-left" name="post_password" id="<?php echo esc_attr( $label ); ?>" type="password" style="border-top-right-radius: 0; border-bottom-right-radius: 0;"/>
                    <input type="submit" name="Submit" class="btn btn-primary rounded-right h-100 w-md-30" value="<?php echo esc_attr( "Submit" ); ?>" style="border-top-left-radius: 0; border-bottom-left-radius: 0; transform: none;"/>
                </div>
            </div>
        </form><?php
    }
endif;

if ( ! function_exists( 'front_footer_primary_v6' ) ) :

    function front_footer_primary_v6() {

        $contact_info =  apply_filters( 'front_footer_primary_v6_contact_info', array(
            array(
                'contact_icon'      => 'fas fa-envelope',
                'contact_title'     => esc_html__( 'General enquiries', 'front' ),
                'contact_desc'      => esc_html__( 'hello@htmlstream.com', 'front' ),
                'contact_link'      => esc_html__( '#', 'front' ),
            ),
            array(
                'contact_icon'      => 'fas fa-phone',
                'contact_title'     => esc_html__( 'Phone Number', 'front' ),
                'contact_desc'      => esc_html__( '+1 (062) 109-9222', 'front' ),
                'contact_link'      => esc_html__( '#', 'front' ),
            ),
            array(
                'contact_icon'      => 'fas fa-map-marker-alt',
                'contact_title'     => esc_html__( 'Address', 'front' ),
                'contact_desc'      => esc_html__( '153 Williamson Plaza, 09514', 'front' ),
                'contact_link'      => esc_html__( '#', 'front' ),
            )
        ));

        $desiredLength = apply_filters( 'front_footer_primary_v6_contact_info_limit', 3 );

        $newArray = array();

        while( count( $newArray ) <= $desiredLength ){
            $newArray = array_merge($newArray, $contact_info);
        }

        $contact_info = array_slice( $newArray, 0, $desiredLength );

        for ( $i = 0; $i <= apply_filters( 'front_footer_primary_v6_contact_info_limit', 3 ) - 1; $i++ ) {
            ?>
            <div class="col-sm-6<?php echo esc_attr( $i == apply_filters( 'front_footer_primary_v6_contact_info_limit', 3 ) - 1 ? '' : ' mb-5' ); ?>">
                <span class="btn btn-icon btn-soft-white rounded-circle mb-3">
                    <span class="<?php echo esc_attr( $contact_info[$i]['contact_icon'] ); ?> btn-icon__inner"></span>
                </span>
                <h4 class="h6 mb-0"><?php echo wp_kses_post( $contact_info[$i]['contact_title'] ); ?></h4>
                <a class="text-white-70 font-size-1" href="<?php echo esc_url( $contact_info[$i]['contact_link'] ); ?>"><?php echo wp_kses_post( $contact_info[$i]['contact_desc'] ); ?></a>
            </div><?php
        }
    }
endif;

if ( ! function_exists( 'front_custom_sidebar_widget_wrapper' ) ) :

    function front_custom_sidebar_widget_wrapper( $sidebar ) {

        if (  empty( $sidebar['before_widget'] ) && empty( $sidebar['after_widget'] ) ) {
            $sidebar['before_widget'] = '<div id="%1$s" class="widget %2$s mb-4">';
            $sidebar['after_widget'] = '</div>';
        }

        if (  empty( $sidebar['before_title'] ) && empty( $sidebar['after_title'] ) ) {
            $sidebar['before_title'] = '<h3 class="h6 widget__title">';
            $sidebar['after_title'] = '</h3>';
        }

        return $sidebar;
    }
endif;

if ( ! function_exists( 'front_scroll_to_top' ) ) :

    function front_scroll_to_top() {
        $scroll_to_top_enable = apply_filters( 'front_scroll_to_top_enable', true );

        if ( $scroll_to_top_enable == true ) {
            ?>
            <a class="js-go-to u-go-to" href="#" data-position='{"bottom": 15, <?php if ( is_rtl() ): ?>"left"<?php else: ?>"right"<?php endif; ?>: 15 }' data-type="fixed" data-offset-top="400" data-compensation="#header" data-show-effect="slideInUp"
               data-hide-effect="slideOutDown">
                <span class="fas fa-arrow-up u-go-to__inner"></span>
            </a>
            <?php
        }
    }
endif;

if ( ! function_exists( 'front_before_footer_static_content' ) ) {

    function front_before_footer_static_content() {
        $footer_static_content_id = apply_filters( 'front_before_footer_static_content_id', '' );

        if( front_is_mas_static_content_activated() && ! empty( $footer_static_content_id ) ) {
            echo do_shortcode( '[mas_static_content id=' . $footer_static_content_id . ' wrap=0]' );
        }
    }
}

if ( ! function_exists( 'front_header_user_account' ) ) {
    /**
     * Display Header My Account
     *
     * @since  1.0.0
     * @uses   _activated() check if WooCommerce is activated
     * @return void
     */
    function front_header_user_account() {
        $woocommerce = function_exists( 'front_is_woocommerce_activated' ) && front_is_woocommerce_activated();
        $job_manager = function_exists( 'front_is_wp_job_manager_activated' ) && front_is_wp_job_manager_activated();
        $job_resume_manager = function_exists( 'front_is_wp_resume_manager_activated' ) && front_is_wp_resume_manager_activated();
        $job_company_manager = function_exists( 'front_is_mas_wp_company_manager_activated' ) && front_is_mas_wp_company_manager_activated();
        $header_user_account_enable = apply_filters( 'front_header_header_user_account_enable', true );
        $user = wp_get_current_user();

        if ( ( $woocommerce || $job_manager || $job_resume_manager || $job_company_manager ) && $header_user_account_enable == true ) {

            $header_account_view = apply_filters( 'front_header_topbar_user_account_view', 'dropdown' );
            $enable_user_name = apply_filters( 'front_header_topbar_user_account_enable_user_name', true );

            if ( $woocommerce && get_option('woocommerce_myaccount_page_id') ) {
                $modal_link = get_permalink( get_option('woocommerce_myaccount_page_id') );
            }
            else if ( $job_manager && get_option( 'job_manager_job_dashboard_page_id' ) && ( in_array( 'employer', (array) $user->roles ) || in_array( 'administrator', (array) $user->roles ) ) ) {
                $modal_link = get_permalink( get_option( 'job_manager_job_dashboard_page_id' ) );
            }
            else if ( $job_resume_manager && get_option( 'resume_manager_candidate_dashboard_page_id' ) && ! ( in_array( 'employer', (array) $user->roles ) ) ) {
                $modal_link = get_permalink( get_option( 'resume_manager_candidate_dashboard_page_id' ) );
            }
            else {
                $modal_link = '#';
            }

            if ( $header_account_view == 'sidebar-right' || $header_account_view == 'sidebar-left' ) {
                $user_account_link = 'javascript:;';
            } else if ( $header_account_view == 'modal' ) {
                $user_account_link = is_user_logged_in() ? $modal_link : '#loginModal';
            } else if ( $woocommerce && is_user_logged_in() ) {
                $user_account_link = get_permalink( get_option('woocommerce_myaccount_page_id') );
            } else {
                $user_account_link = '#';
            }

            if ( $header_account_view == 'dropdown' ) {
                $header_account_id = 'account-dropdown-invoker';
            }
            else if ( $header_account_view == 'sidebar-right' || $header_account_view == 'sidebar-left' ) {
                $header_account_id = 'sidebarMyAccountNavToggler';
            }
            else {
                $header_account_id = NULL;
            }

            $atts = apply_filters( 'front_user_account_link_atts', array(
                'id'    => $header_account_id,
                'class' => 'btn btn-xs btn-text-secondary ' . ( is_user_logged_in() ? 'u-sidebar--account__toggle-bg' : 'btn-icon' ) . ( ( $header_account_view == 'sidebar-right' || $header_account_view == 'sidebar-left' ) ? ' ml-1' : '' ) . ( $enable_user_name == false ? ' pl-1' : '' ),
                'href'  => $user_account_link,
                'role'  => 'button',
            ) );

            if ( $header_account_view == 'dropdown' || $header_account_view == 'sidebar-right' || $header_account_view == 'sidebar-left' ) {

                if ( $header_account_view == 'sidebar-left' ) {
                    $animation_in = 'fadeInLeft';
                    $animation_out = 'fadeOutLeft';
                }
                else if ( $header_account_view == 'sidebar-right' ) {
                    $animation_in = 'fadeInRight';
                    $animation_out = 'fadeOutRight';
                }
                else {
                    $animation_in = 'slideInUp';
                    $animation_out = 'fadeOut';
                }

                $atts['aria-controls'] = $header_account_view == 'dropdown' ? 'account-dropdown' : 'sidebarMyAccountContent';
                $atts['aria-haspopup'] = 'true';
                $atts['aria-expanded'] = 'false';
                $atts['data-unfold-event'] = ( $header_account_view == 'dropdown' && is_user_logged_in() ) ? 'hover' : 'click';
                $atts['data-unfold-target'] = $header_account_view == 'dropdown' ? '#account-dropdown' : '#sidebarMyAccountContent';
                $atts['data-unfold-type'] = 'css-animation';
                $atts['data-unfold-duration'] = $header_account_view == 'dropdown' ? '300' : '500';
                $atts['data-unfold-delay'] = $header_account_view == 'dropdown' ? '300' : NULL;
                $atts['data-unfold-hide-on-scroll'] = $header_account_view == 'dropdown' ? 'true' : 'false';
                $atts['data-unfold-animation-in'] = $animation_in;
                $atts['data-unfold-animation-out'] = $animation_out;
            }

            if ( $header_account_view == 'modal' ) {
                $atts['data-modal-target'] = '#loginModal';
                $atts['data-overlay-color'] = '#111722';
            }

            ?>
                <li class="list-inline-item position-relative">
                    <?php
                    global $current_user; ?>
                    <a <?php printf( front_get_attributes( $atts ) ); ?>>
                        <?php if ( is_user_logged_in() && ( $header_account_view == 'dropdown' || $header_account_view == 'modal' || $header_account_view == 'sidebar-right' || $header_account_view == 'sidebar-left' ) ) : ?>
                            <?php if ( $header_account_view == 'sidebar-right' || $header_account_view == 'sidebar-left' ): ?>
                                <span class="position-relative">
                            <?php endif ?>
                                <?php if ( $enable_user_name == true ): ?>
                                    <span class="u-sidebar--account__toggle-text"><?php echo apply_filters( 'front_user_account_login_text', get_the_author_meta( 'display_name', $current_user->ID ) ); ?></span>
                                <?php endif ?>
                                <img class="u-sidebar--account__toggle-img" src="<?php echo get_avatar_url( $current_user->ID ); ?>" alt="<?php echo esc_attr__( 'User', 'front' ); ?>">
                                <?php else: ?>
                                <span class="<?php echo esc_attr( apply_filters( 'front_user_account_menu_item_icon', 'fas fa-user-circle ' ) ); ?> btn-icon__inner font-size-1">
                                </span>
                            <?php if ( $header_account_view == 'sidebar-right' || $header_account_view == 'sidebar-left' ): ?>
                                </span>
                            <?php endif ?>
                        <?php endif ?>
                    </a>
                    <?php
                    if ( $header_account_view == 'dropdown' ) {
                        front_header_user_account_submenu();
                    }
                    ?>
                </li>
            <?php
        }
    }
}

if ( ! function_exists( 'front_header_user_job_account_submenu' ) ) {

    function front_header_user_job_account_submenu() {
        $job_manager = function_exists( 'front_is_wp_job_manager_activated' ) && front_is_wp_job_manager_activated();
        $job_resume_manager = function_exists( 'front_is_wp_resume_manager_activated' ) && front_is_wp_resume_manager_activated();
        $job_company_manager = function_exists( 'front_is_mas_wp_company_manager_activated' ) && front_is_mas_wp_company_manager_activated();
        $user = wp_get_current_user();
        $header_account_view = apply_filters( 'front_header_topbar_user_account_view', 'dropdown' );

        if ( $job_manager || $job_resume_manager || $job_company_manager ) {

            if ( $header_account_view == 'sidebar-left' || $header_account_view == 'sidebar-right' ) {
                ?><ul class="list-unstyled u-sidebar--account__list"><li class="u-sidebar--account__list-item"><?php
            }
            if ( $job_manager && get_option( 'job_manager_job_dashboard_page_id' ) && ( in_array( 'employer', (array) $user->roles ) || in_array( 'administrator', (array) $user->roles ) ) ) {
                ?>
                <a class="<?php echo esc_attr( $header_account_view == 'dropdown' ? 'dropdown-item' : 'u-sidebar--account__list-link' ); ?>" href="<?php echo esc_url( get_permalink( get_option( 'job_manager_job_dashboard_page_id' ) ) ); ?>">
                    <span class="<?php echo esc_attr( 'fas fa-home' . ( $header_account_view == 'dropdown' ? ' dropdown-item-icon' : ' u-sidebar--account__list-icon mr-2' ) ); ?>"></span><?php echo esc_html__( 'Job Dashboard', 'front' ); ?>
                </a>
                <?php
            }
            if ( $job_resume_manager && get_option( 'resume_manager_candidate_dashboard_page_id' ) && ! ( in_array( 'employer', (array) $user->roles ) ) ) {
                ?>
                <a class="<?php echo esc_attr( $header_account_view == 'dropdown' ? 'dropdown-item' : 'u-sidebar--account__list-link' ); ?>" href="<?php echo esc_url( get_permalink( get_option( 'resume_manager_candidate_dashboard_page_id' ) ) ); ?>">
                    <span class="fas fa-home dropdown-item-icon"></span><?php echo esc_html__( 'Candidate Dashboard', 'front' ); ?>
                </a>
                <?php
            }
            if ( $job_company_manager && mas_wpjmc_get_page_id( 'company_dashboard' ) && ( in_array( 'employer', (array) $user->roles ) || in_array( 'administrator', (array) $user->roles ) ) ) {
                ?>
                <a class="<?php echo esc_attr( $header_account_view == 'dropdown' ? 'dropdown-item' : 'u-sidebar--account__list-link' ); ?>" href="<?php echo esc_url( get_permalink( mas_wpjmc_get_page_id( 'company_dashboard' ) ) ); ?>">
                    <span class="fas fa-home dropdown-item-icon"></span><?php echo esc_html__( 'Company Dashboard', 'front' ); ?>
                </a>
                <?php
            }
            if ( $header_account_view == 'sidebar-left' || $header_account_view == 'sidebar-right' ) {
                ?></li></ul><?php
            }
        }
    }
}

if ( ! function_exists( 'front_header_user_account_submenu' ) ) {
    /**
     * Display Header My Account Sub Menu
     *
     * @since  1.0.0
     * @uses   front_is_woocommerce_activated() check if WooCommerce is activated
     * @return void
     */
    function front_header_user_account_submenu() {
        $header_account_view = apply_filters( 'front_header_topbar_user_account_view', 'dropdown' );
        $my_account_page_url = get_permalink( get_option('woocommerce_myaccount_page_id') );
        $woocommerce = function_exists( 'front_is_woocommerce_activated' ) && front_is_woocommerce_activated();
        $job_manager = function_exists( 'front_is_wp_job_manager_activated' ) && front_is_wp_job_manager_activated();
        $job_resume_manager = function_exists( 'front_is_wp_resume_manager_activated' ) && front_is_wp_resume_manager_activated();
        $job_company_manager = function_exists( 'front_is_mas_wp_company_manager_activated' ) && front_is_mas_wp_company_manager_activated();
        ?>

        <div id="account-dropdown" class="dropdown-menu dropdown-unfold dropdown-menu-right<?php echo esc_attr( is_user_logged_in() ? '' : ' py-0 user-not-loggedin' ) ?>" aria-labelledby="account-dropdown-invoker">
            <?php
            if ( is_user_logged_in() ) {
                front_header_user_job_account_submenu();
                if ( $woocommerce ) {
                    front_user_account_nav_menu();
                }
                if ( ! $woocommerce ) {
                    ?>
                    <a class="dropdown-item" href="<?php echo esc_url( wp_logout_url() ); ?>">
                        <span class="fas fa-sign-out-alt dropdown-item-icon"></span><?php echo esc_html__( 'Logout', 'front' ); ?>
                    </a>
                    <?php
                }
            }
            else if ( $woocommerce ) {
                ?><div class="card"><?php
                    front_header_user_account_login_form();
                    front_header_user_account_register_form();
                    front_header_user_account_forget_password_form();
                ?></div><?php
            } else {
                front_header_user_account_job_login_form();
                front_header_user_account_job_register_form();
                front_header_user_account_job_forget_password_form();
            }
            ?>
        </div><?php
    }
}

if ( ! function_exists( 'front_user_account_nav_menu' ) ) {
    function front_user_account_nav_menu() {
        $header_account_view = apply_filters( 'front_header_topbar_user_account_view', 'dropdown' );
        $user_account_nav_menu      = apply_filters( 'front_user_account_nav_menu_ID', 0 );
        $user_account_nav_menu_args = apply_filters( 'front_user_account_nav_menu_args', array(
            'theme_location' => 'user_account_menu',
            'container'   => false,
            'menu'        => $user_account_nav_menu,
            'menu_class'  => "list-unstyled" . ( $header_account_view == 'dropdown' ? ' front-user-account-menu-dropdown' : ' front-user-account-menu-sidebar' ),
        ) );

        if ( has_nav_menu( 'user_account_menu' ) ) {
            wp_nav_menu( $user_account_nav_menu_args );
        }
        else {
            if ( $header_account_view == 'sidebar-left' || $header_account_view == 'sidebar-right' ): ?>
                <ul class="list-unstyled u-sidebar--account__list">
            <?php endif;
            foreach ( wc_get_account_menu_items() as $endpoint => $label ) :

                switch ( $endpoint ) {
                    case 'dashboard':
                        $user_account_menu_item_icon = 'fas fa-home';
                    break;

                    case 'orders':
                        $user_account_menu_item_icon = 'fas fa-shopping-basket';
                    break;

                    case 'downloads':
                        $user_account_menu_item_icon = 'far fa-file-archive';
                    break;

                    case 'edit-address':
                        $user_account_menu_item_icon = 'fas fa-home';
                    break;

                    case 'edit-account':
                        $user_account_menu_item_icon = 'far fa-user';
                    break;

                    case 'customer-logout':
                        $user_account_menu_item_icon = 'fas fa-sign-out-alt';
                    break;

                    default:
                        $user_account_menu_item_icon = 'fas fa-cog';
                    break;
                }

                ?>
                <?php if ( $header_account_view == 'sidebar-left' || $header_account_view == 'sidebar-right' ): ?>
                    <li class="u-sidebar--account__list-item">
                <?php endif; ?>
                    <a class="<?php echo esc_attr( $header_account_view == 'dropdown' ? 'dropdown-item' : 'u-sidebar--account__list-link' ); ?>" href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>">
                        <span class="<?php echo esc_attr( $user_account_menu_item_icon . ( $header_account_view == 'dropdown' ? ' dropdown-item-icon' : ' u-sidebar--account__list-icon mr-2' ) ); ?>"></span>
                        <?php echo esc_html( $label ); ?>
                    </a>
                <?php if ( $header_account_view == 'modal' ): ?>
                    </li>
                <?php endif; ?>
            <?php endforeach;
            if ( $header_account_view == 'sidebar-left' || $header_account_view == 'sidebar-right' ) {
                ?></ul><?php
            }
        }
    }
}

if ( ! function_exists( 'front_header_user_account_modal_popup' ) ) {
    function front_header_user_account_modal_popup() {
        $header_account_view = apply_filters( 'front_header_topbar_user_account_view', 'dropdown' );
        $woocommerce = function_exists( 'front_is_woocommerce_activated' ) && front_is_woocommerce_activated();

        if ( $header_account_view == 'modal' && is_user_logged_in() == false ): ?>
            <div id="loginModal" class="js-login-window u-modal-window<?php echo esc_attr( is_user_logged_in() ? ' bg-white rounded' : '' ); ?>" style="width: 400px;">
                <div class="card">
                    <?php
                    if ( $woocommerce ) {
                        front_header_user_account_login_form();
                        front_header_user_account_register_form();
                        front_header_user_account_forget_password_form();
                    } else {
                        front_header_user_account_job_login_form();
                        front_header_user_account_job_register_form();
                        front_header_user_account_job_forget_password_form();
                    }
                    ?>
                </div>
            </div>
        <?php endif;
    }
}


if ( ! function_exists( 'front_header_user_account_login_form' ) ) {
    function front_header_user_account_login_form() {
        $header_account_view = apply_filters( 'front_header_topbar_user_account_view', 'dropdown' );
        $not_login_text      = apply_filters( 'front_user_account_not_login_text', sprintf( esc_html__( 'Login to %s', 'front' ), get_bloginfo( 'name' ) ) );
        ?>
        <form class="js-validate woocommerce-form woocommerce-form-login login" method="post">
            <div id="login" data-target-group="idForm" style="<?php echo esc_attr( ( isset( $_POST['register'] ) || isset( $_POST['recoverPassword'] ) ) ? 'display: none; opacity: 0;' : 'display: block; opacity: 1;' );  ?>">
                <?php if ( $header_account_view == 'modal' || $header_account_view == 'sidebar-left' || $header_account_view == 'sidebar-right' ): ?>
                    <header class="<?php echo esc_attr( $header_account_view == 'modal' ? 'card-header bg-light py-3 px-5' : 'text-center mb-7' ); ?>">
                        <?php if ( $header_account_view == 'modal' ): ?>
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="h6 mb-0"><?php echo apply_filters( 'front_user_account_not_login_text', esc_html__( 'Welcome Back!', 'front' ) ); ?></h3>
                            <button type="button" class="close" aria-label="Close" onclick="Custombox.modal.close();">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <?php else : ?>
                            <h2 class="h4 mb-0"><?php echo apply_filters( 'front_user_account_not_login_text', esc_html__( 'Welcome Back!', 'front' ) ); ?></h2>
                            <p><?php echo apply_filters( 'front_user_account_not_login_description', esc_html__( 'Login to manage your account.', 'front' ) ); ?></p>
                        <?php endif ?>
                    </header>
                <?php endif ?>
                <?php if ( $header_account_view == 'dropdown' ): ?>
                    <div class="card-header bg-light text-center py-3 px-5">
                        <h3 class="h6 mb-0"><?php echo esc_html( $not_login_text ); ?></h3>
                    </div>
                <?php endif ?>
                <?php if ( $header_account_view == 'modal' || $header_account_view == 'dropdown' ): ?>
                <div class="card-body p-5">
                <?php endif ?>
                    <?php do_action( 'front_myaccount_woocommerce_login_form_custom_field_before' ); ?>
                    <div class="form-group">
                        <div class="js-form-message js-focus-state">
                            <label class="sr-only" for="signinSrEmail"><?php esc_html_e( 'Email', 'front' ); ?></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="signinEmail">
                                        <span class="fas fa-user"></span>
                                    </span>
                                </div>
                                <input type="text" class="form-control" name="username" id="username" placeholder="<?php esc_attr_e( 'Email', 'front' ); ?>" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="js-form-message js-focus-state">
                            <label class="sr-only" for="signinSrPassword"><?php esc_html_e( 'Password', 'front' ); ?></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="signinPassword">
                                        <span class="fas fa-lock"></span>
                                    </span>
                                </div>
                                <input class="form-control" type="password" placeholder="<?php esc_attr_e( 'Password', 'front' ); ?>" name="password" id="password" autocomplete="current-password" />
                            </div>
                        </div>
                    </div>
                    <?php do_action( 'front_myaccount_woocommerce_login_form_custom_field_after' ); ?>
                    <span class="d-flex justify-content-end mb-4">
                        <a class="js-animation-link link-muted<?php echo esc_attr( $header_account_view != 'dropdown' ? ' small' : '' ) ?>" href="javascript:;" data-target="#forgotPassword" data-link-group="idForm" data-animation-in="fadeIn"><?php esc_html_e( 'Forgot Password?', 'front' ); ?></a>
                    </span>
                    <?php
                        if ( isset( $_POST['login'] ) && function_exists( 'is_account_page' ) && ! is_account_page() ) {
                            // show any error messages after form submission
                            ?><div class="mb-3"><?php woocommerce_output_all_notices(); ?></div><?php
                        }
                    ?>
                    <div class="mb-2">
                        <?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
                        <button type="submit" class="btn btn-block btn-primary transition-3d-hover<?php echo esc_attr( $header_account_view == 'dropdown' ? ' btn-sm' : '' ) ?>" name="login" value="<?php esc_attr_e( 'Log in', 'front' ); ?>"><?php esc_html_e( 'Login', 'front' ); ?></button>
                    </div>
                    <?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) : ?>
                        <div class="text-center<?php echo esc_attr( $header_account_view != 'dropdown' ? ' mb-4' : '' ) ?>">
                            <span class="text-muted<?php echo esc_attr( $header_account_view != 'dropdown' ? ' small' : '' ) ?>"><?php esc_html_e( 'Don\'t have an account?', 'front' ); ?></span>
                            <a class="js-animation-link<?php echo esc_attr( $header_account_view != 'dropdown' ? ' small' : '' ) ?>" href="javascript:;" data-target="#signup" data-link-group="idForm" data-animation-in="fadeIn">
                                <?php esc_html_e( 'Signup', 'front' ); ?>
                            </a>
                        </div>
                    <?php endif; ?>
                <?php if ( $header_account_view == 'modal' || $header_account_view == 'dropdown' ): ?>
                </div>
                <?php endif;
                if ( function_exists( 'woocommerce_social_login_buttons' ) ) {
                    woocommerce_social_login_buttons( wc_get_page_permalink( 'myaccount' ) );
                }
                ?>
            </div>
        </form><?php
    }
}

if ( ! function_exists( 'front_header_user_account_register_form' ) ) {
    function front_header_user_account_register_form() {
        $header_account_view = apply_filters( 'front_header_topbar_user_account_view', 'dropdown' );
        ?>
        <form class="js-validate woocommerce-form woocommerce-form-register register" method="post">
            <?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) : ?>
                <div id="signup" data-target-group="idForm" style="<?php echo esc_attr( isset( $_POST['register'] ) ? 'display: block; opacity: 1;' : 'display: none; opacity: 0;' );  ?>">
                    <?php if ( $header_account_view == 'modal' || $header_account_view == 'sidebar-left' || $header_account_view == 'sidebar-right' ): ?>
                        <header class="<?php echo esc_attr( $header_account_view == 'modal' ? 'card-header bg-light py-3 px-5' : 'text-center mb-7' ); ?>">
                        <?php if ( $header_account_view == 'modal' ): ?>
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="h6 mb-0"><?php echo apply_filters( 'front_user_account_register_text', esc_html__( 'Welcome to Front.', 'front' ) ); ?></h3>
                                <button type="button" class="close" aria-label="Close" onclick="Custombox.modal.close();">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <?php else: ?>
                                <h2 class="h4 mb-0"><?php echo apply_filters( 'front_user_account_register_text', esc_html__( 'Welcome to Front.', 'front' ) ); ?></h2>
                                <p><?php echo apply_filters( 'front_user_account_register_description', esc_html__( 'Fill out the form to get started.', 'front' ) ); ?></p>
                        <?php endif ?>
                        </header>
                    <?php endif ?>
                    <?php if ( $header_account_view == 'dropdown' ): ?>
                        <div class="card-header bg-light text-center py-3 px-5">
                            <h3 class="h6 mb-0"><?php echo apply_filters( 'front_user_account_register_text', esc_html__( 'Create a free Front account', 'front' ) ); ?></h3>
                        </div>
                    <?php endif ?>
                    <?php if ( $header_account_view == 'modal' || $header_account_view == 'dropdown' ): ?>
                    <div class="card-body p-5">
                    <?php endif ?>
                        <?php do_action( 'front_myaccount_woocommerce_register_form_custom_field_before' ); ?>
                        <?php if ( 'no' == get_option( 'woocommerce_registration_generate_username' ) ) : ?>
                        <div class="form-group">
                            <label class="sr-only" for="reg_username"><?php esc_html_e( 'Username', 'front' ); ?></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="reg_username">
                                        <span class="fas fa-user"></span>
                                    </span>
                                </div>
                                <input type="text" class="form-control woocommerce-Input woocommerce-Input--text input-text" name="username" placeholder="<?php esc_attr_e( 'Username', 'front' ); ?>" id="reg_username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
                            </div>
                        </div>
                        <?php endif; ?>
                        <div class="form-group">
                            <div class="js-form-message js-focus-state">
                                <label class="sr-only" for="signupSrEmail"><?php esc_html_e( 'Email', 'front' ); ?></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="signupEmail">
                                            <span class="<?php echo esc_attr( 'no' == get_option( 'woocommerce_registration_generate_username' ) ? 'fas fa-envelope' : 'fas fa-user' ) ?>"></span>
                                        </span>
                                    </div>
                                    <input type="email" class="form-control" name="email" id="reg_email" placeholder="<?php esc_attr_e( 'Email', 'front' ); ?>" autocomplete="email" value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>" aria-label="Email" aria-describedby="signupEmail" required="" data-msg="<?php esc_attr_e( 'Please enter a valid email address.', 'front' ); ?>" data-error-class="u-has-error" data-success-class="u-has-success"/>
                                </div>
                            </div>
                        </div>
                        <?php if ( 'no' == get_option( 'woocommerce_registration_generate_password' ) ) : ?>
                        <div class="form-group">
                            <div class="js-form-message js-focus-state">
                                <label class="sr-only" for="signupSrPassword"><?php esc_html_e( 'Password', 'front' ); ?></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="signupPassword">
                                            <span class="fas fa-lock"></span>
                                        </span>
                                    </div>
                                    <input type="password" class="form-control woocommerce-Input woocommerce-Input--text" name="newPassword" id="signupSrPassword" placeholder="<?php esc_attr_e( 'Password', 'front' ); ?>" aria-label="Password" aria-describedby="signupPassword" required
                                   data-msg="<?php esc_attr_e( 'Please enter your password.', 'front' ); ?>"
                                   data-error-class="u-has-error"
                                   data-success-class="u-has-success"
                                   data-pwstrength-container="#changePasswordForm"
                                   data-pwstrength-progress="#passwordStrengthProgress"
                                   data-pwstrength-verdict="#passwordStrengthVerdict"
                                   data-pwstrength-progress-extra-classes="bg-white height-4">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="js-form-message js-focus-state">
                                <label class="sr-only" for="signupSrConfirmPassword"><?php esc_html_e( 'Confirm Password', 'front' ); ?></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="signupConfirmPassword">
                                            <span class="fas fa-key"></span>
                                        </span>
                                    </div>
                                    <input type="password" class="form-control" name="password" id="signupSrConfirmPassword" placeholder="<?php esc_attr_e( 'Confirm Password', 'front' ); ?>" aria-label="Confirm Password" aria-describedby="signupConfirmPassword" required="" data-msg="<?php esc_attr_e( 'Password does not match the confirm password.', 'front' ); ?>" data-error-class="u-has-error" data-success-class="u-has-success">
                                </div>
                            </div>
                        </div>
                        <?php else : ?>
                            <p><?php esc_html_e( 'A password will be sent to your email address.', 'front' ); ?></p>
                        <?php endif; ?>

                        <?php do_action( 'front_myaccount_woocommerce_register_form_custom_field_after' ); ?>

                        <?php
                            if ( isset( $_POST['register'] ) && function_exists( 'is_account_page' ) && ! is_account_page() ) {
                                // show any error messages after form submission
                                ?><div class="mb-3"><?php woocommerce_output_all_notices(); ?></div><?php
                            }
                        ?>

                        <div class="mb-2">
                            <?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
                            <button type="submit" class="btn btn-block btn-primary transition-3d-hover<?php echo esc_attr( $header_account_view == 'dropdown' ? ' btn-sm' : '' ) ?>" name="register" value="<?php esc_attr_e( 'Register', 'front' ); ?>"><?php esc_html_e( 'Get Started', 'front' ); ?></button>
                        </div>
                        <div class="text-center<?php echo esc_attr( $header_account_view != 'dropdown' ? ' mb-4' : '' ) ?>">
                            <span class="text-muted<?php echo esc_attr( $header_account_view != 'dropdown' ? ' small' : '' ) ?>"><?php esc_html_e( 'Already have an account?', 'front' ); ?></span>
                                <a class="js-animation-link<?php echo esc_attr( $header_account_view != 'dropdown' ? ' small' : '' ) ?>" href="javascript:;" data-target="#login" data-link-group="idForm" data-animation-in="fadeIn">
                                    <?php esc_html_e( 'Login', 'front' ); ?>
                                </a>
                        </div>
                    <?php if ( $header_account_view == 'modal' || $header_account_view == 'dropdown' ): ?>
                    </div>
                    <?php endif ?>
                </div>
            <?php endif; ?>
        </form><?php
    }
}

if ( ! function_exists( 'front_header_user_account_forget_password_form' ) ) {
    function front_header_user_account_forget_password_form() {
        $header_account_view = apply_filters( 'front_header_topbar_user_account_view', 'dropdown' );
        ?>
        <form class="js-validate forget-password" method="post">
            <div id="forgotPassword" data-target-group="idForm" class="animated fadeIn" style="<?php echo esc_attr( isset( $_POST['recoverPassword'] ) ? 'display: block; opacity: 1;' : 'display: none; opacity: 0;' );  ?>">
                <?php if ( $header_account_view == 'modal' || $header_account_view == 'sidebar-left' || $header_account_view == 'sidebar-right' ): ?>
                    <header class="<?php echo esc_attr( $header_account_view == 'modal' ? 'card-header bg-light py-3 px-5' : 'text-center mb-7' ); ?>">
                        <?php if ( $header_account_view == 'modal' ): ?>
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="h6 mb-0"><?php echo apply_filters( 'front_user_account_recover_password_text', esc_html__( 'Recover Password.', 'front' ) ); ?></h3>
                                <button type="button" class="close" aria-label="Close" onclick="Custombox.modal.close();">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <?php else : ?>
                            <h2 class="h4 mb-0"><?php echo apply_filters( 'front_user_account_recover_password_text', esc_html__( 'Recover Password.', 'front' ) ); ?></h2>
                            <p><?php echo apply_filters( 'front_user_account_recover_password_description', esc_html__( 'Enter your email address and an email with instructions will be sent to you.', 'front' ) ); ?></p>
                        <?php endif ?>
                    </header>
                <?php endif ?>
                <?php if ( $header_account_view == 'dropdown' ): ?>
                    <div class="card-header bg-light text-center py-3 px-5">
                        <h3 class="h6 mb-0"><?php echo apply_filters( 'front_user_account_recover_password_text', esc_html__( 'Recover password', 'front' ) ); ?></h3>
                    </div>
                <?php endif ?>
                <?php if ( $header_account_view == 'modal' || $header_account_view == 'dropdown' ): ?>
                <div class="card-body p-5">
                <?php endif ?>
                    <div class="form-group">
                        <div class="js-form-message js-focus-state">
                            <label class="sr-only" for="recoverSrEmail"><?php esc_html_e( 'Your email', 'front' ); ?></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="recoverEmail">
                                        <span class="fas fa-user"></span>
                                    </span>
                                </div>
                                <input type="email" class="form-control" name="user_login" id="recoverSrEmail" placeholder="<?php esc_attr_e( 'Your email', 'front' ); ?>" aria-label="Your email" aria-describedby="recoverEmail" required="" data-msg="<?php esc_attr_e( 'Please enter a valid email address.', 'front' ); ?>" data-error-class="u-has-error" data-success-class="u-has-success">
                            </div>
                        </div>
                    </div>
                    <?php do_action( 'front_myaccount_woocommerce_lostpassword_form_custom_field' ); ?>
                    <?php
                        if ( isset( $_POST['recoverPassword'] ) && function_exists( 'is_account_page' ) && ! is_account_page() ) {
                            // show any error messages after form submission
                            ?><div class="mb-3"><?php woocommerce_output_all_notices(); ?></div><?php
                        }
                    ?>
                    <div class="mb-2">
                        <input type="hidden" name="wc_reset_password" value="true" />
                        <button type="submit" name="recoverPassword" class="btn btn-block btn-primary transition-3d-hover<?php echo esc_attr( $header_account_view == 'dropdown' ? ' btn-sm' : '' ) ?>"><?php esc_html_e( 'Recover Password', 'front' ); ?></button>
                    </div>
                    <?php wp_nonce_field( 'lost_password', 'woocommerce-lost-password-nonce' ); ?>
                    <div class="text-center<?php echo esc_attr( $header_account_view != 'dropdown' ? ' mb-4' : '' ) ?>">
                        <span class="text-muted<?php echo esc_attr( $header_account_view != 'dropdown' ? ' small' : '' ) ?>"><?php esc_html_e( 'Remember your password?', 'front' ); ?></span>
                          <a class="js-animation-link<?php echo esc_attr( $header_account_view != 'dropdown' ? ' small' : '' ) ?>" href="javascript:;" data-target="#login" data-link-group="idForm" data-animation-in="fadeIn">
                            Login
                          </a>
                    </div>
                <?php if ( $header_account_view == 'modal' || $header_account_view == 'dropdown' ): ?>
                </div>
                <?php endif ?>
            </div>
        </form><?php
    }
}


if ( ! function_exists( 'front_header_user_account_content_sidebar' ) ) {
    function front_header_user_account_content_sidebar() {

        $header_account_view = apply_filters( 'front_header_topbar_user_account_view', 'dropdown' );
        $footer_svg_path = get_template_directory_uri();
        $current_user = new WP_User( get_current_user_id() );
        $woocommerce = function_exists( 'front_is_woocommerce_activated' ) && front_is_woocommerce_activated();
        $job_manager = function_exists( 'front_is_wp_job_manager_activated' ) && front_is_wp_job_manager_activated();
        $job_resume_manager = function_exists( 'front_is_wp_resume_manager_activated' ) && front_is_wp_resume_manager_activated();
        $job_company_manager = function_exists( 'front_is_mas_wp_company_manager_activated' ) && front_is_mas_wp_company_manager_activated();
        $user = wp_get_current_user();

        $user_account_sidebar_footer_nav_menu      = apply_filters( 'front_user_account_sidebar_footer_nav_menu_ID', 0 );
        $user_account_sidebar_footer_nav_menu_args = apply_filters( 'front_user_account_sidebar_footer_nav_menu_args', array(
            'theme_location'  => 'sidebar_footer_menu',
            'depth'           => 1,
            'container'       => false,
            'menu'            => $user_account_sidebar_footer_nav_menu,
            'menu_class'      => "list-inline mb-0 front-user-account-sidebar-footer-menu",
        ) );

        if ( $header_account_view == 'sidebar-left' ) {
            $animation_in = 'fadeInLeft';
            $animation_out = 'fadeOutLeft';
        }
        else {
            $animation_in = 'fadeInRight';
            $animation_out = 'fadeOutRight';
        }
        ?>
        <?php if ( $header_account_view == 'sidebar-left' || $header_account_view == 'sidebar-right' ):
            if(is_rtl()) {
                if( $header_account_view == 'sidebar-right' ) {
                    $myaccount_sidebar_additional_class  = ' my-account-sidebar-left left-0';
                } else {
                    $myaccount_sidebar_additional_class  = '';
                }
            } else {
                if( $header_account_view == 'sidebar-right' ) {
                    $myaccount_sidebar_additional_class  = '';
                }
                else {
                    $myaccount_sidebar_additional_class  = ' my-account-sidebar-left left-0';
                }
            } ?>

            <aside id="sidebarMyAccountContent" class="myaccount-sidebar u-sidebar<?php echo esc_attr( $myaccount_sidebar_additional_class ); ?>" aria-labelledby="sidebarMyAccountNavToggler">
                <div class="u-sidebar__scroller">
                    <div class="u-sidebar__container">
                        <div class="u-sidebar--account__footer-offset">
                            <div class="d-flex<?php echo esc_attr( is_user_logged_in() ? ' justify-content-between' : '' ); ?> align-items-center pt-4 px-7">
                                <?php if ( is_user_logged_in() ): ?>
                                    <h3 class="h6 mb-0"><?php echo esc_html_e( 'My Account', 'front' ); ?></h3>
                                <?php endif; ?>
                                <button type="button" class="close ml-auto target-of-invoker-has-unfolds"
                                    aria-controls="sidebarMyAccountContent"
                                    aria-haspopup="true"
                                    aria-expanded="true"
                                    data-unfold-event="click"
                                    data-unfold-hide-on-scroll="false"
                                    data-unfold-target="#sidebarMyAccountContent"
                                    data-unfold-type="css-animation"
                                    data-unfold-animation-in="<?php echo esc_attr( $animation_in ); ?>"
                                    data-unfold-animation-out="<?php echo esc_attr( $animation_out ); ?>"
                                    data-unfold-duration="500"
                                >
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="js-scrollbar u-sidebar__body">
                                <?php if ( is_user_logged_in() ): ?>
                                    <header class="d-flex align-items-center u-sidebar--account__holder mt-3">
                                        <div class="position-relative">
                                            <img class="u-sidebar--account__holder-img mCS_img_loaded" src="<?php echo get_avatar_url( get_current_user_id() ); ?>" alt="User">
                                            <span class="badge badge-xs badge-outline-success badge-pos rounded-circle"></span>
                                        </div>
                                        <div class="ml-3">
                                            <span class="font-weight-semi-bold"><?php echo get_the_author_meta( 'display_name', get_current_user_id() ); ?></span>
                                            <span class="u-sidebar--account__holder-text">
                                                <?php if ( NULL != get_the_author_meta( 'description', get_current_user_id() ) ):
                                                    echo get_the_author_meta( 'description', get_current_user_id() );
                                                    else :
                                                    if ( !empty( $current_user->roles ) && is_array( $current_user->roles ) ) {
                                                        foreach ( $current_user->roles as $role ) {
                                                            echo esc_html( ucfirst( str_replace( '_', ' ' , $role ) ) );
                                                        }
                                                    }
                                                endif; ?>
                                            </span>
                                        </div>
                                        <div class="btn-group position-relative ml-auto mb-auto">
                                            <a id="sidebar-account-settings-invoker" class="btn btn-xs btn-icon btn-text-secondary rounded" href="javascript:;" role="button" aria-controls="sidebar-account-settings" aria-haspopup="true" aria-expanded="false" data-toggle="dropdown" data-unfold-event="click" data-unfold-target="#sidebar-account-settings" data-unfold-type="css-animation" data-unfold-duration="300" data-unfold-delay="300" data-unfold-animation-in="slideInUp" data-unfold-animation-out="fadeOut">
                                                <span class="fas fa-ellipsis-v btn-icon__inner"></span>
                                            </a>
                                            <div id="sidebar-account-settings" class="dropdown-menu dropdown-unfold dropdown-menu-right u-unfold--css-animation u-unfold--hidden fadeOut" aria-labelledby="sidebar-account-settings-invoker">
                                                <?php if ( function_exists( 'front_is_woocommerce_activated' ) && front_is_woocommerce_activated() ): ?>
                                                    <?php foreach ( wc_get_account_menu_items() as $endpoint => $label ) : ?>
                                                        <?php if ( $endpoint == 'customer-logout' || $endpoint == 'dashboard' || $endpoint == 'edit-account' ): ?>
                                                            <?php if ( $endpoint == 'customer-logout' ): ?>
                                                               <div class="dropdown-divider"></div>
                                                            <?php endif; ?>
                                                                <a class="dropdown-item" href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>">
                                                                    <?php echo esc_html( $label ); ?>
                                                                </a>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                <?php endif ?>
                                                <?php if ( ! $woocommerce ): ?>
                                                    <a class="dropdown-item" href="<?php echo esc_url( wp_logout_url() ); ?>">
                                                        <?php echo esc_html__( 'Logout', 'front' ); ?>
                                                    </a>
                                                <?php endif ?>
                                            </div>
                                        </div>
                                    </header>
                                <?php endif; ?>
                                <div class="u-sidebar__content u-header-sidebar__content">
                                    <?php
                                    if ( is_user_logged_in() ) {
                                        front_header_user_job_account_submenu();
                                    }
                                    if ( $woocommerce ): ?>
                                        <?php if ( is_user_logged_in() ): ?>
                                            <?php front_user_account_nav_menu(); ?>
                                        <?php else :
                                            front_header_user_account_login_form();
                                            front_header_user_account_register_form();
                                            front_header_user_account_forget_password_form();
                                        endif; ?>
                                    <?php endif ?>
                                    <?php if ( is_user_logged_in() && ! $woocommerce ): ?>
                                        <a class="u-sidebar--account__list-link" href="<?php echo esc_url( wp_logout_url() ); ?>">
                                            <span class="fas fa-sign-out-alt u-sidebar--account__list-icon mr-2"></span><?php echo esc_html__( 'Logout', 'front' ); ?>
                                        </a>
                                    <?php endif ?>
                                    <?php
                                        if ( ! is_user_logged_in() && ! $woocommerce  ) {
                                            front_header_user_account_job_login_form();
                                            front_header_user_account_job_register_form();
                                            front_header_user_account_job_forget_password_form();
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <footer id="SVGwaveWithDots" class="u-sidebar__footer u-sidebar__footer--account">
                            <?php
                            if ( has_nav_menu( 'sidebar_footer_menu' ) ) {
                                wp_nav_menu( $user_account_sidebar_footer_nav_menu_args );
                            }
                            ?>
                            <div class="position-absolute right-0 bottom-0 left-0">
                                <img class="js-svg-injector" src="<?php echo esc_url( $footer_svg_path ); ?>/assets/svg/components/wave-bottom-with-dots.svg" alt="Svg" data-parent="#SVGwaveWithDots">
                            </div>
                        </footer>
                    </div>
                </div>
            </aside>
        <?php endif;
    }
}

if ( ! function_exists( 'front_header_user_account_job_login_form' ) ) {
    function front_header_user_account_job_login_form() {
        $header_account_view = apply_filters( 'front_header_topbar_user_account_view', 'dropdown' );
        $woocommerce         = function_exists( 'front_is_woocommerce_activated' ) && front_is_woocommerce_activated();
        $not_login_text      = apply_filters( 'front_user_account_not_login_text', sprintf( esc_html__( 'Login to %s', 'front' ), get_bloginfo( 'name' ) ) );
        ?>
        <form class="js-validate login" method="post">
            <div id="login" data-target-group="idForm" style="<?php echo esc_attr( isset( $_POST['register'] ) ? 'display: none; opacity: 0;' : 'display: block; opacity: 1;' );  ?>">
                <?php if ( $header_account_view == 'modal' || $header_account_view == 'sidebar-left' || $header_account_view == 'sidebar-right' ): ?>
                    <header class="<?php echo esc_attr( $header_account_view == 'modal' ? 'card-header bg-light py-3 px-5' : 'text-center mb-7' ); ?>">
                        <?php if ( $header_account_view == 'modal' ): ?>
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="h6 mb-0"><?php echo apply_filters( 'front_user_account_not_login_text', esc_html__( 'Welcome Back!', 'front' ) ); ?></h3>
                            <button type="button" class="close" aria-label="Close" onclick="Custombox.modal.close();">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <?php else : ?>
                            <h2 class="h4 mb-0"><?php echo apply_filters( 'front_user_account_not_login_text', esc_html__( 'Welcome Back!', 'front' ) ); ?></h2>
                            <p><?php echo apply_filters( 'front_user_account_not_login_description', esc_html__( 'Login to manage your account.', 'front' ) ); ?></p>
                        <?php endif ?>
                    </header>
                <?php endif ?>
                <?php if ( $header_account_view == 'dropdown' ): ?>
                    <div class="card-header bg-light text-center py-3 px-5">
                        <h3 class="h6 mb-0"><?php echo esc_html( $not_login_text ); ?></h3>
                    </div>
                <?php endif ?>
                <?php if ( $header_account_view == 'modal' || $header_account_view == 'dropdown' ): ?>
                <div class="card-body p-5">
                <?php endif ?>
                    <?php do_action( 'front_job_login_form_custom_field_before' ); ?>
                    <div class="form-group">
                        <div class="js-form-message js-focus-state">
                            <label class="sr-only" for="signinSrEmail"><?php esc_html_e( 'Email', 'front' ); ?></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="signinEmail">
                                        <span class="fas fa-user"></span>
                                    </span>
                                </div>
                                <input type="text" class="form-control" name="username" id="username" placeholder="<?php esc_attr_e( 'Email', 'front' ); ?>" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="js-form-message js-focus-state">
                            <label class="sr-only" for="signinSrPassword"><?php esc_html_e( 'Password', 'front' ); ?></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="signinPassword">
                                        <span class="fas fa-lock"></span>
                                    </span>
                                </div>
                                <input class="form-control" type="password" placeholder="<?php esc_attr_e( 'Password', 'front' ); ?>" name="password" id="password" autocomplete="current-password" />
                            </div>
                        </div>
                    </div>
                    <?php do_action( 'front_job_login_form_custom_field_after' ); ?>
                    <span class="d-flex justify-content-end mb-4">
                        <a class="js-animation-link link-muted<?php echo esc_attr( $header_account_view != 'dropdown' ? ' small' : '' ) ?>" href="javascript:;" data-target="#forgotPassword" data-link-group="idForm" data-animation-in="fadeIn"><?php esc_html_e( 'Forgot Password?', 'front' ); ?></a>
                    </span>
                    <?php
                        if ( isset( $_POST['login'] ) ) {
                            // show any error messages after form submission
                            ?><div class="mb-3"><?php front_show_error_messages(); ?></div><?php
                        }
                    ?>
                    <div class="mb-2">
                        <input type="hidden" id="front_login_nonce" name="front_login_nonce" value="<?php echo wp_create_nonce('front-login-nonce'); ?>"/>
                        <input type="hidden" name="front_login_check" value="1"/>
                        <?php  wp_nonce_field( 'ajax-login-nonce', 'login-security' );  ?>
                        <button type="submit" class="btn btn-block btn-primary transition-3d-hover<?php echo esc_attr( $header_account_view == 'dropdown' ? ' btn-sm' : '' ) ?>" name="login" value="<?php esc_attr_e( 'Log in', 'front' ); ?>"><?php esc_html_e( 'Login', 'front' ); ?></button>
                    </div>
                    <?php if ( ! $woocommerce && get_option( 'users_can_register' ) ) : ?>
                        <div class="text-center<?php echo esc_attr( $header_account_view != 'dropdown' ? ' mb-4' : '' ) ?>">
                            <span class="text-muted<?php echo esc_attr( $header_account_view != 'dropdown' ? ' small' : '' ) ?>"><?php esc_html_e( 'Don\'t have an account?', 'front' ); ?></span>
                            <a class="js-animation-link<?php echo esc_attr( $header_account_view != 'dropdown' ? ' small' : '' ) ?>" href="javascript:;" data-target="#signup" data-link-group="idForm" data-animation-in="fadeIn">
                                <?php esc_html_e( 'Signup', 'front' ); ?>
                            </a>
                        </div>
                    <?php endif; ?>
                <?php if ( $header_account_view == 'modal' || $header_account_view == 'dropdown' ): ?>
                </div>
                <?php endif ?>
            </div>
        </form><?php
    }
}

// logs a member in after submitting a form
if ( ! function_exists( 'front_job_login_member' ) ) {
    function front_job_login_member() {
        if( isset( $_POST['front_login_check'] )  && wp_verify_nonce( $_POST['front_login_nonce'], 'front-login-nonce') ) {

            // this returns the user ID and other info from the user name
            if ( is_email( $_POST['username'] ) ) {
                $user =  get_user_by( 'email', $_POST['username'] );
            } else {
                $user =  get_user_by( 'login', $_POST['username'] );
            }

            if( ! $user ) {
                // if the user name doesn't exist
                front_form_errors()->add('empty_username', esc_html__('Invalid username or email address','front'));
            }

            do_action( 'front_job_login_form_custom_field_validation' );

            if ( ! empty( $user ) ) {
                 if( ! isset($_POST['password']) || $_POST['password'] == '' ) {
                    // if no password was entered
                    front_form_errors()->add('empty_password', esc_html__('Please enter a password','front'));
                }

                if( isset( $_POST['password'] ) && ! empty( $_POST['password'] ) ){
                    // check the user's login with their password
                    if( ! wp_check_password( $_POST['password'], $user->user_pass, $user->ID ) ) {
                        // if the password is incorrect for the specified user
                        front_form_errors()->add('empty_password', esc_html__('Incorrect password','front'));
                    }
                }

                // retrieve all error messages
                $errors = front_form_errors()->get_error_messages();

                // only log the user in if there are no errors
                if( empty( $errors ) ) {

                    $creds = array();
                    $creds['user_login'] = $user->user_login;
                    $creds['user_password'] = $_POST['password'];
                    $creds['remember'] = true;

                    $user = wp_signon( $creds, false );
                    // send the newly created user to the home page after logging them in
                    if ( is_wp_error($user) ){
                        echo wp_kses_post( $user->get_error_message() );
                    } else {
                        $oUser = get_user_by( 'login', $creds['user_login'] );
                        $aUser = get_object_vars( $oUser );
                        $sRole = $aUser['roles'][0];

                        if( get_option( 'job_manager_job_dashboard_page_id' ) ) {
                            $job_url = get_permalink( get_option( 'job_manager_job_dashboard_page_id' ) );
                        } else {
                            $job_url = home_url( '/' );
                        }

                        if( get_option( 'resume_manager_candidate_dashboard_page_id' ) ) {
                            $resume_url = get_permalink( get_option( 'resume_manager_candidate_dashboard_page_id' ) );
                        } else {
                            $resume_url= home_url( '/' );
                        }

                        switch( $sRole ) {
                            case 'candidate':
                                $redirect_url = $resume_url;
                                break;
                            case 'employer':
                                $redirect_url = $job_url;
                                break;

                            default:
                                $redirect_url = home_url( '/' );
                                break;
                        }

                        wp_redirect( $redirect_url );
                    }
                    exit;
                }
            }
        }
    }
}

add_action( 'wp_loaded', 'front_job_login_member' );

if ( ! function_exists( 'front_header_user_account_job_register_form' ) ) {
    function front_header_user_account_job_register_form() {
        $header_account_view = apply_filters( 'front_header_topbar_user_account_view', 'dropdown' );
        $register_user_name_enabled = apply_filters( 'front_job_register_user_name_enabled', true );
        ?>
        <form class="js-validate register" method="post">
            <?php if ( get_option( 'users_can_register' ) ) : ?>
                <div id="signup" data-target-group="idForm" style="<?php echo esc_attr( isset( $_POST['register'] ) ? 'display: block; opacity: 1;' : 'display: none; opacity: 0;' );  ?>">
                    <?php if ( $header_account_view == 'modal' || $header_account_view == 'sidebar-left' || $header_account_view == 'sidebar-right' ): ?>
                        <header class="<?php echo esc_attr( $header_account_view == 'modal' ? 'card-header bg-light py-3 px-5' : 'text-center mb-7' ); ?>">
                        <?php if ( $header_account_view == 'modal' ): ?>
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="h6 mb-0"><?php echo apply_filters( 'front_user_account_register_text', esc_html__( 'Welcome to Front.', 'front' ) ); ?></h3>
                                <button type="button" class="close" aria-label="Close" onclick="Custombox.modal.close();">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <?php else: ?>
                                <h2 class="h4 mb-0"><?php echo apply_filters( 'front_user_account_register_text', esc_html__( 'Welcome to Front.', 'front' ) ); ?></h2>
                                <p><?php echo apply_filters( 'front_user_account_register_description', esc_html__( 'Fill out the form to get started.', 'front' ) ); ?></p>
                        <?php endif ?>
                        </header>
                    <?php endif ?>
                    <?php if ( $header_account_view == 'dropdown' ): ?>
                        <div class="card-header bg-light text-center py-3 px-5">
                            <h3 class="h6 mb-0"><?php echo apply_filters( 'front_user_account_register_text', esc_html__( 'Create a free Front account', 'front' ) ); ?></h3>
                        </div>
                    <?php endif ?>
                    <?php if ( $header_account_view == 'modal' || $header_account_view == 'dropdown' ): ?>
                    <div class="card-body p-5">
                    <?php endif ?>
                        <?php do_action( 'front_job_register_form_custom_field_before' ); ?>
                        <?php if ( $register_user_name_enabled ) : ?>
                        <div class="form-group">
                            <label class="sr-only" for="reg_username"><?php esc_html_e( 'Username', 'front' ); ?></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="reg_username">
                                        <span class="fas fa-user"></span>
                                    </span>
                                </div>
                                <input type="text" class="form-control input-text" name="username" id="reg_username" placeholder="<?php esc_attr_e( 'Username', 'front' ); ?>" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
                            </div>
                        </div>
                        <?php endif; ?>
                        <div class="form-group">
                            <div class="js-form-message js-focus-state">
                                <label class="sr-only" for="reg_email"><?php esc_html_e( 'Email', 'front' ); ?></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="signupEmail">
                                            <span class="<?php echo esc_attr( $register_user_name_enabled == true ? 'fas fa-envelope' : 'fas fa-user' ) ?>"></span>
                                        </span>
                                    </div>
                                    <input type="email" class="form-control" name="email" id="reg_email" placeholder="<?php esc_attr_e( 'Email', 'front' ); ?>" autocomplete="email" value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>" aria-label="Email" aria-describedby="signupEmail" required="" data-msg="<?php esc_attr_e( 'Please enter a valid email address.', 'front' ); ?>" data-error-class="u-has-error" data-success-class="u-has-success"/>
                                </div>
                            </div>
                        </div>
                        <?php if ( apply_filters( 'front_job_register_password_enabled', true ) ) : ?>
                        <div class="form-group">
                            <div class="js-form-message js-focus-state">
                                <label class="sr-only" for="signupSrPassword"><?php esc_html_e( 'Password', 'front' ); ?></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="signupPassword">
                                            <span class="fas fa-lock"></span>
                                        </span>
                                    </div>
                                    <input type="password" class="form-control" name="password" id="signupSrPassword" placeholder="<?php esc_attr_e( 'Password', 'front' ); ?>" aria-label="Password" aria-describedby="signupPassword" required="" data-msg="<?php esc_attr_e( 'Your password is invalid. Please try again.', 'front' ); ?>" data-error-class="u-has-error" data-success-class="u-has-success">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="js-form-message js-focus-state">
                                <label class="sr-only" for="signupSrConfirmPassword"><?php esc_html_e( 'Confirm Password', 'front' ); ?></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="signupConfirmPassword">
                                            <span class="fas fa-key"></span>
                                        </span>
                                    </div>
                                    <input type="password" class="form-control" name="confirmPassword" id="signupSrConfirmPassword" placeholder="<?php esc_attr_e( 'Confirm Password', 'front' ); ?>" aria-label="Confirm Password" aria-describedby="signupConfirmPassword" required="" data-msg="<?php esc_attr_e( 'Password does not match the confirm password.', 'front' ); ?>" data-error-class="u-has-error" data-success-class="u-has-success">
                                </div>
                            </div>
                        </div>
                        <?php else : ?>
                            <p><?php esc_html_e( 'A password will be sent to your email address.', 'front' ); ?></p>
                        <?php endif; ?>
                        <?php do_action( 'front_job_register_form_custom_field_after' ); ?>
                        <?php if( apply_filters( 'front_job_register_user_role_enabled', true ) && function_exists( 'front_is_wp_job_manager_activated' ) && front_is_wp_job_manager_activated() ) : ?>
                            <p>
                                <label for="front_register_user_role"><?php echo esc_html__( 'I want to register as', 'front' ); ?></label>
                                <select name="front_user_role" id="front_register_user_role" class="input chosen-select">
                                    <option value="candidate"><?php echo esc_html__( 'Candidate', 'front' ); ?></option>
                                    <option value="employer"><?php echo esc_html__( 'Employer', 'front' ); ?></option>
                                </select>
                            </p>
                        <?php endif; ?>
                        <?php
                            if ( isset( $_POST['register'] ) ) {
                                // show any error messages after form submission
                                ?><div class="mb-3"><?php front_show_error_messages(); ?></div><?php
                            }
                        ?>
                        <div class="mb-2">
                            <input type="hidden" name="front_job_register_nonce" value="<?php echo wp_create_nonce('front_job-register-nonce'); ?>"/>
                            <input type="hidden" name="front_job_register_check" value="1"/>
                            <?php  wp_nonce_field( 'ajax-register-nonce', 'register-security' );  ?>
                            <button type="submit" class="btn btn-block btn-primary transition-3d-hover<?php echo esc_attr( $header_account_view == 'dropdown' ? ' btn-sm' : '' ) ?>" name="register" value="<?php esc_attr_e( 'Register', 'front' ); ?>"><?php esc_html_e( 'Get Started', 'front' ); ?></button>
                        </div>
                        <div class="text-center<?php echo esc_attr( $header_account_view != 'dropdown' ? ' mb-4' : '' ) ?>">
                            <span class="text-muted<?php echo esc_attr( $header_account_view != 'dropdown' ? ' small' : '' ) ?>"><?php esc_html_e( 'Already have an account?', 'front' ); ?></span>
                                <a class="js-animation-link<?php echo esc_attr( $header_account_view != 'dropdown' ? ' small' : '' ) ?>" href="javascript:;" data-target="#login" data-link-group="idForm" data-animation-in="fadeIn">
                                    <?php esc_html_e( 'Login', 'front' ); ?>
                                </a>
                        </div>
                    <?php if ( $header_account_view == 'modal' || $header_account_view == 'dropdown' ): ?>
                    </div>
                    <?php endif ?>
                </div>
            <?php endif; ?>
        </form><?php
    }
}

// register a new user
if ( ! function_exists( 'front_job_add_new_member' ) ) {
    function front_job_add_new_member() {
        if ( isset( $_POST["front_job_register_check"] ) && wp_verify_nonce( $_POST['front_job_register_nonce'], 'front_job-register-nonce' ) ) {
            $register_user_name_enabled = apply_filters( 'front_job_register_user_name_enabled', true );
            $default_role = 'subscriber';
            $available_roles = array( 'subscriber' );

            if ( function_exists( 'front_is_wp_job_manager_activated' ) && front_is_wp_job_manager_activated() ) {
                $available_roles[] = 'employer';
            }

            if ( function_exists( 'front_is_wp_resume_manager_activated' ) && front_is_wp_resume_manager_activated() ) {
                $available_roles[] = 'candidate';
                $default_role = 'candidate';
            }

            $user_email     = sanitize_email( $_POST["email"] );
            $user_role      = ! empty( $_POST["front_user_role"] ) && in_array( $_POST["front_user_role"], $available_roles ) ? sanitize_text_field( $_POST["front_user_role"] ) : $default_role;

            if ( ! empty( $_POST["username"] ) ) {
                $user_login = sanitize_user( $_POST["username"] );
            } else {
                $user_login = sanitize_user( current( explode( '@', $user_email ) ), true );

                // Ensure username is unique.
                $append     = 1;
                $o_user_login = $user_login;

                while ( username_exists( $user_login ) ) {
                    $user_login = $o_user_login . $append;
                    $append++;
                }
            }

            if( username_exists( $user_login ) && $register_user_name_enabled ) {
                // Username already registered
                front_form_errors()->add('username_unavailable', esc_html__('Username already taken','front'));
            }
            if( ! validate_username( $user_login ) && $register_user_name_enabled ) {
                // invalid username
                front_form_errors()->add('username_invalid', esc_html__('Invalid username','front'));
            }
            if( $user_login == '' && $register_user_name_enabled ) {
                // empty username
                front_form_errors()->add('username_empty', esc_html__('Please enter a username','front'));
            }
            if( ! is_email( $user_email ) ) {
                //invalid email
                front_form_errors()->add('email_invalid', esc_html__('Invalid email','front'));
            }
            if( email_exists( $user_email ) ) {
                //Email address already registered
                front_form_errors()->add('email_used', esc_html__('Email already registered','front'));
            }


            $password = wp_generate_password();
            $password_generated = true;

            if ( apply_filters( 'front_job_register_password_enabled', true ) && ! empty( $_POST['password'] ) && ! empty( $_POST['confirmPassword'] ) ) {
                $password = $_POST['password'];
                $password_generated = false;
            }

            if ( $_POST['password'] != $_POST['confirmPassword'] ) {
                //Mismatched Password
                front_form_errors()->add( 'wrong_password', esc_html__('Password you entered is mismatched','front' ));
            }

            do_action( 'front_job_register_form_custom_field_validation' );

            $errors = front_form_errors()->get_error_messages();

            // only create the user in if there are no errors
            if( empty( $errors ) ) {

                $new_user_data = array(
                    'user_login'        => $user_login,
                    'user_pass'         => $password,
                    'user_email'        => $user_email,
                    'role'              => $user_role,
                );

                $new_user_id = wp_insert_user( $new_user_data );

                if( $new_user_id ) {
                    // send an email to the admin alerting them of the registration
                    if( apply_filters( 'front_job_wc_new_user_notification', false ) && front_job_is_woocommerce_activated() ) {
                        wc()->mailer()->customer_new_account( $new_user_id, $new_user_data, $password_generated );
                    } else {
                        wp_new_user_notification( $new_user_id, null, 'both' );
                    }

                    // log the new user in
                    $creds = array();
                    $creds['user_login'] = $user_login;
                    $creds['user_password'] = $password;
                    $creds['remember'] = true;

                    $user = wp_signon( $creds, false );
                    // send the newly created user to the home page after logging them in
                    if ( is_wp_error( $user ) ) {
                        echo wp_kses_post( $user->get_error_message() );
                    } else {
                        $oUser = get_user_by( 'login', $creds['user_login'] );
                        $aUser = get_object_vars( $oUser );
                        $sRole = $aUser['roles'][0];
                        if( get_option( 'job_manager_job_dashboard_page_id' ) ) {
                            $job_url = get_permalink( get_option( 'job_manager_job_dashboard_page_id' ) );
                        } else {
                            $job_url = home_url( '/' );
                        }

                        if( get_option( 'resume_manager_candidate_dashboard_page_id' ) ) {
                            $resume_url = get_permalink( get_option( 'resume_manager_candidate_dashboard_page_id' ) );
                        } else {
                            $resume_url= home_url( '/' );
                        }

                        switch( $sRole ) {
                            case 'candidate':
                                $redirect_url = $resume_url;
                                break;
                            case 'employer':
                                $redirect_url = $job_url;
                                break;

                            default:
                                $redirect_url = home_url( '/' );
                                break;
                        }

                        wp_redirect( $redirect_url );
                    }
                    exit;
                }
            }
        }
    }
}

add_action( 'wp_loaded', 'front_job_add_new_member' );

if ( ! function_exists( 'front_header_user_account_job_forget_password_form' ) ) {
    function front_header_user_account_job_forget_password_form() {
        $header_account_view = apply_filters( 'front_header_topbar_user_account_view', 'dropdown' );
        ?>
        <form class="js-validate forget-password" name="lostpasswordform" id="lostpasswordform" action="<?php echo wp_lostpassword_url(); ?>" method="post">
            <div id="forgotPassword" data-target-group="idForm" class="animated fadeIn" style="display: none; opacity: 0;">
                <?php if ( $header_account_view == 'modal' || $header_account_view == 'sidebar-left' || $header_account_view == 'sidebar-right' ): ?>
                    <header class="<?php echo esc_attr( $header_account_view == 'modal' ? 'card-header bg-light py-3 px-5' : 'text-center mb-7' ); ?>">
                        <?php if ( $header_account_view == 'modal' ): ?>
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="h6 mb-0"><?php echo apply_filters( 'front_user_account_recover_password_text', esc_html__( 'Recover Password.', 'front' ) ); ?></h3>
                                <button type="button" class="close" aria-label="Close" onclick="Custombox.modal.close();">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <?php else : ?>
                            <h2 class="h4 mb-0"><?php echo apply_filters( 'front_user_account_recover_password_text', esc_html__( 'Recover Password.', 'front' ) ); ?></h2>
                            <p><?php echo apply_filters( 'front_user_account_recover_password_description', esc_html__( 'Enter your email address and an email with instructions will be sent to you.', 'front' ) ); ?></p>
                        <?php endif ?>
                    </header>
                <?php endif ?>
                <?php if ( $header_account_view == 'dropdown' ): ?>
                    <div class="card-header bg-light text-center py-3 px-5">
                        <h3 class="h6 mb-0"><?php echo apply_filters( 'front_user_account_recover_password_text', esc_html__( 'Recover password', 'front' ) ); ?></h3>
                    </div>
                <?php endif ?>
                <?php if ( $header_account_view == 'modal' || $header_account_view == 'dropdown' ): ?>
                <div class="card-body p-5">
                <?php endif ?>
                    <div class="form-group">
                        <div class="js-form-message js-focus-state">
                            <label class="sr-only" for="recoverSrEmail"><?php esc_html_e( 'Your email', 'front' ); ?></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="recoverEmail">
                                        <span class="fas fa-user"></span>
                                    </span>
                                </div>
                                <input type="email" class="form-control" name="user_login" id="recoverSrEmail" placeholder="<?php esc_attr_e( 'Your email', 'front' ); ?>" aria-label="Your email" aria-describedby="recoverEmail" required="" data-msg="<?php esc_attr_e( 'Please enter a valid email address.', 'front' ); ?>" data-error-class="u-has-error" data-success-class="u-has-success">
                            </div>
                        </div>
                    </div>
                    <?php do_action( 'front_job_lost_password_form_custom_field' ); ?>
                    <div class="mb-2">
                        <button type="submit" class="btn btn-block btn-primary transition-3d-hover<?php echo esc_attr( $header_account_view == 'dropdown' ? ' btn-sm' : '' ) ?>"><?php esc_html_e( 'Recover Password', 'front' ); ?></button>
                    </div>
                    <div class="text-center<?php echo esc_attr( $header_account_view != 'dropdown' ? ' mb-4' : '' ) ?>">
                        <span class="text-muted<?php echo esc_attr( $header_account_view != 'dropdown' ? ' small' : '' ) ?>"><?php esc_html_e( 'Remember your password?', 'front' ); ?></span>
                          <a class="js-animation-link<?php echo esc_attr( $header_account_view != 'dropdown' ? ' small' : '' ) ?>" href="javascript:;" data-target="#login" data-link-group="idForm" data-animation-in="fadeIn">
                            Login
                          </a>
                    </div>
                <?php if ( $header_account_view == 'modal' || $header_account_view == 'dropdown' ): ?>
                </div>
                <?php endif ?>
            </div>
        </form><?php
    }
}

if ( ! function_exists( 'front_form_errors' ) ) {
    // used for tracking error messages
    function front_form_errors(){
        static $wp_error; // Will hold global variable safely
        return isset( $wp_error ) ? $wp_error : ( $wp_error = new WP_Error( null, null, null ) );
    }
}

if ( ! function_exists( 'front_show_error_messages' ) ) {
    function front_show_error_messages() {
        if( $codes = front_form_errors()->get_error_codes() ) {
            echo '<div class="notification closeable error">';
                // Loop error codes and display errors
               foreach( $codes as $code ) {
                    $message = front_form_errors()->get_error_message( $code );
                    echo '<span class="error text-danger">' . $message . '</span><br/>';
                }
            echo '</div>';
        }
    }
}

if ( ! function_exists( 'front_custom_job_form' ) ) {
    function front_custom_job_form() {
        $is_registration_enabled = get_option( 'users_can_register' );
        $register_user_name_enabled = apply_filters( 'front_job_register_user_name_enabled', true );

        $login_tab_pane    = ' active';
        $register_tab_pane = '';
        if ( isset( $_POST['register'] ) ) {
            $login_tab_pane    = '';
            $register_tab_pane = ' active';
        }

        $front_my_account_login_form_welcome_text = sprintf( '%s <span class="font-weight-semi-bold">%s</span>', esc_html__( 'Welcome', 'front' ), esc_html__( 'back', 'front' ));
        $front_my_account_register_form_welcome_text = sprintf( '%s <span class="font-weight-semi-bold">%s</span>', esc_html__( 'Welcome to', 'front' ), esc_html__( 'Front', 'front' ));
    ?>
        <div class="<?php echo esc_attr( is_page_template( 'template-login.php' ) ? 'row no-gutters' : 'container space-2' ); ?>">
            <div class="<?php echo esc_attr( is_page_template( 'template-login.php' ) ? 'col-md-8 col-lg-7 col-xl-6 offset-md-2 offset-lg-2 offset-xl-3 space-3 space-lg-0' : 'w-md-75 w-lg-50 mx-md-auto' ); ?>" id="customer_login">

                <?php do_action( 'front_job_before_customer_login_form' ); ?>

                <?php if ( $is_registration_enabled ) : ?>

                    <div class="tab-content<?php echo esc_attr( is_page_template( 'template-login.php' ) ? ' mt-5' : '' ); ?>">

                        <div class="tab-pane<?php echo esc_attr( $login_tab_pane ); ?>" id="customer-login-form" aria-labelledby="login-tab">

                <?php endif; ?>
                        <div class="mb-7">
                            <h2 class="h3 text-primary font-weight-normal mb-0"><?php echo apply_filters( 'front_my_account_login_form_title', wp_kses_post( $front_my_account_login_form_welcome_text ) ); ?></h2>

                            <p><?php echo apply_filters( 'front_my_account_login_form_desc', esc_html__( 'Login to manage your account.', 'front' ) ); ?></p>
                        </div>

                        <form class="login" method="post">

                            <?php do_action( 'front_job_login_form_start' ); ?>

                            <div class="form-group">
                                <label class="form-label" for="username"><?php esc_html_e( 'Email Address', 'front' ); ?></label>
                                <input type="text" class="form-control input-text" name="username" id="username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" />

                            </div>

                            <div class="form-group">
                                <label class="form-label" for="password">
                                    <span class="d-flex justify-content-between align-items-center"><?php esc_html_e( 'Password', 'front' ); ?>
                                        <a class="link-muted text-capitalize font-weight-normal" href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Forgot Password?', 'front' ); ?>

                                        </a>
                                    </span>
                                </label>
                                <input class="form-control input-text" type="password" name="password" id="password" autocomplete="current-password" />
                            </div>

                            <?php do_action( 'front_job_login_form' ); ?>

                            <?php
                                if ( isset( $_POST['login'] ) ) {
                                    // show any error messages after form submission
                                    front_show_error_messages();
                                }
                            ?>

                            <div class="row align-items-center mb-5">
                                <?php if ( $is_registration_enabled ) : ?>
                                    <div class="col-6">
                                        <span class="small text-muted"><?php esc_html_e( 'Don&#039;t have an account?', 'front' ); ?></span>
                                        <a id="register-tab" class="small login login-register-tab-switcher" href="#customer-register-form" aria-controls="customer-register-form" aria-selected="true"><?php esc_html_e( 'Signup', 'front' ); ?></a>
                                    </div>

                                    <div class="col-6 text-right">
                                        <input type="hidden" id="front_login_nonce" name="front_login_nonce" value="<?php echo wp_create_nonce('front-login-nonce'); ?>"/>
                                        <input type="hidden" name="front_login_check" value="1"/>
                                        <?php  wp_nonce_field( 'ajax-login-nonce', 'login-security' );  ?>
                                        <button type="submit" class="btn btn-primary transition-3d-hover" name="login" value="<?php esc_attr_e( 'Log in', 'front' ); ?>"><?php esc_html_e( 'Get Started', 'front' ); ?></button>
                                    </div>
                                   <?php else: ?>

                                    <div class="col-12 text-right">
                                        <input type="hidden" id="front_login_nonce" name="front_login_nonce" value="<?php echo wp_create_nonce('front-login-nonce'); ?>"/>
                                        <input type="hidden" name="front_login_check" value="1"/>
                                        <?php  wp_nonce_field( 'ajax-login-nonce', 'login-security' );  ?>
                                        <button type="submit" class="btn btn-primary transition-3d-hover" name="login" value="<?php esc_attr_e( 'Log in', 'front' ); ?>"><?php esc_html_e( 'Get Started', 'front' ); ?></button>
                                    </div>
                                    <?php endif; ?>
                                </div>

                            <?php do_action( 'front_job_login_form_end' ); ?>

                        </form>
                <?php if ( $is_registration_enabled ) : ?>
                    </div>

                    <div class="tab-pane<?php echo esc_attr( $register_tab_pane ); ?>" id="customer-register-form" aria-labelledby="register-tab">
                        <div class="mb-7">
                            <h2 class="h3 text-primary font-weight-normal mb-0"><?php echo apply_filters( 'front_my_account_register_form_title', wp_kses_post( $front_my_account_register_form_welcome_text ) );?></h2>
                        <p><?php echo apply_filters( 'front_my_account_register_form_desc', esc_html__( 'Fill out the form to get started.', 'front' ) ); ?></p>
                        </div>

                        <form method="post" class="register" <?php do_action( 'front_job_register_form_tag' ); ?> >

                            <?php do_action( 'front_job_register_form_start' ); ?>

                            <?php if ( $register_user_name_enabled ) : ?>

                                <div class="form-group">
                                    <label class="form-label" for="reg_username"><?php esc_html_e( 'Username', 'front' ); ?>&nbsp;<span class="required">*</span></label>
                                    <input type="text" class="form-control input-text" name="username" id="reg_username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
                                </div>

                            <?php endif; ?>

                            <div class="form-group">
                                <label class="form-label" for="reg_email"><?php esc_html_e( 'Email address', 'front' ); ?></label>
                                <input type="email" class="form-control input-text" name="email" id="reg_email" autocomplete="email" value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
                            </div>

                            <?php if ( apply_filters( 'front_job_register_password_enabled', true ) ) : ?>

                                <div class="form-group js-form-message">
                                    <label class="form-label" for="reg_password"><?php esc_html_e( 'Password', 'front' ); ?></label>
                                    <input id="reg_password" type="password" class="form-control input-text" name="password" aria-label="<?php esc_attr_e( 'Enter your password', 'front' ); ?>" required
                                       data-msg="<?php esc_attr_e( 'Please enter your password.', 'front' ); ?>"
                                       data-error-class="u-has-error"
                                       data-success-class="u-has-success"
                                       data-pwstrength-container="#changePasswordForm"
                                       data-pwstrength-progress="#passwordStrengthProgress"
                                       data-pwstrength-verdict="#passwordStrengthVerdict"
                                       data-pwstrength-progress-extra-classes="bg-white height-4">

                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="con_password"><?php esc_html_e( 'Confirm Password', 'front' ); ?></label>
                                    <input type="password" class="form-control input-text" name="confirmPassword" id="con_password" autocomplete="new-password" />
                                </div>

                            <?php else : ?>

                                <p><?php esc_html_e( 'A password will be sent to your email address.', 'front' ); ?></p>

                            <?php endif; ?>

                            <?php do_action( 'front_job_register_form' ); ?>

                            <?php if( apply_filters( 'front_job_register_user_role_enabled', true ) && function_exists( 'front_is_wp_job_manager_activated' ) && front_is_wp_job_manager_activated() ) : ?>
                                <p>
                                    <label for="front_register_user_role"><?php echo esc_html__( 'I want to register as', 'front' ); ?></label>
                                    <select name="front_user_role" id="front_register_user_role" class="input chosen-select">
                                        <option value="candidate"><?php echo esc_html__( 'Candidate', 'front' ); ?></option>
                                        <option value="employer"><?php echo esc_html__( 'Employer', 'front' ); ?></option>
                                    </select>
                                </p>
                            <?php endif; ?>

                            <?php
                                if ( isset( $_POST['register'] ) ) {
                                    // show any error messages after form submission
                                    front_show_error_messages();
                                }
                            ?>

                            <div class="row align-items-center mb-5">
                                <div class="col-5 col-sm-6">
                                    <span class="small text-muted"><?php esc_html_e( 'Already have an account?', 'front' ); ?></span>
                                    <a id="login-tab" class="small login login-register-tab-switcher" href="#customer-login-form" aria-controls="customer-login-form" aria-selected="true"><?php echo esc_html__( 'Login', 'front' ); ?></a>
                                </div>

                                <div class="col-7 col-sm-6 text-right">
                                    <input type="hidden" name="front_job_register_nonce" value="<?php echo wp_create_nonce('front_job-register-nonce'); ?>"/>
                                    <input type="hidden" name="front_job_register_check" value="1"/>
                                    <?php  wp_nonce_field( 'ajax-register-nonce', 'register-security' );  ?>
                                    <button type="submit" class="btn btn-primary transition-3d-hover button" name="register" value="<?php esc_attr_e( 'Register', 'front' ); ?>"><?php esc_html_e( 'Get Started', 'front' ); ?></button>
                                </div>
                            </div>

                            <?php do_action( 'front_job_register_form_end' ); ?>

                        </form>
                    </div>

                </div>

                <?php endif; ?>
            </div>
        </div><?php
    }
}
