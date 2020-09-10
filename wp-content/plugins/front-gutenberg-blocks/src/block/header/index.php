<?php
/**
 * Server-side rendering of the `fgb/header` block.
 *
 * @package FrontGB
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Renders the `fgb/header` block on server.
 *
 * @since 1.0
 *
 * @param array $attributes The block attributes.
 *
 * @return string Returns the post content with latest posts added.
 */
if ( ! function_exists( 'frontgb_render_header_block' ) ) {
    function frontgb_render_header_block( $attributes ) {

        if ( $attributes['enableCart'] == false ) {
            add_filter( 'front_header_topbar_cart_enable', '__return_false' );
        }  else {
            add_filter( 'front_header_topbar_cart_enable', '__return_true' );
        }

        if ( $attributes['enableMyAccount'] == false ) {
            add_filter( 'front_header_header_user_account_enable', '__return_false' );
        } else {
            add_filter( 'front_header_header_user_account_enable', '__return_true' );
        }

        if ( $attributes['enableSearch'] == false ) {
            add_filter( 'front_header_topbar_search_enable', '__return_false' );
        } else {
            add_filter( 'front_header_topbar_search_enable', '__return_true' );
        }

        ob_start();
        if( function_exists( 'front_display_header' ) ) {
            front_display_header( $attributes );
        }
        return ob_get_clean();
    }
}

if ( ! function_exists( 'frontgb_register_header_block' ) ) {
    /**
     * Registers the `fgb/header` block on server.
     */
    function frontgb_register_header_block() {
        if ( ! function_exists( 'register_block_type' ) ) {
            return;
        }

        register_block_type(
            'fgb/header',
            array(
                'attributes' => array(
                    'className' => array(
                        'type' => 'string',
                    ),
                    'menuStyle' => array(
                        'type' => 'string',
                        'default' => 'navbar'
                    ),
                    'fullScreenNavStyle' => array(
                        'type' => 'string',
                        'default' => 'modal'
                    ),
                    'isContainerFluid' => array(
                        'type' => 'boolean',
                        'default' => false
                    ),
                    'enablePostion' => array(
                        'type' => 'boolean',
                        'default' => false
                    ),
                    'position' => array(
                        'type' => 'string',
                        'default' => 'abs-top'
                    ),
                    'positionScreen' => array(
                        'type' => 'string',
                        'default' => 'all-screens'
                    ),
                    'enableSticky' => array(
                        'type' => 'boolean',
                        'default' => false
                    ),
                    'stickyPosition' => array(
                        'type' => 'string',
                        'default' => 'top'
                    ),
                    'stickyBreakpoint' => array(
                        'type' => 'string',
                        'default' => 'all-screens'
                    ),
                    'stickyScrollBehavior' => array(
                        'type' => 'string',
                        'default' => 'none'
                    ),
                    'enableToggleSection' => array(
                        'type' => 'boolean',
                        'default' => false
                    ),
                    'enableShowHide' => array(
                        'type' => 'boolean',
                        'default' => false
                    ),
                    'showHideBreakpoint' => array(
                        'type' => 'string',
                        'default' => 'all-screens'
                    ),
                    'showHideScrollBehavior' => array(
                        'type' => 'string',
                        'default' => 'none'
                    ),
                    'enableWhiteNavLinks' => array(
                        'type' => 'boolean',
                        'default' => false
                    ),
                    'whiteNavLinksBreakpoint' => array(
                        'type' => 'string',
                        'default' => 'all-screens'
                    ),
                    'enableTransparent' => array(
                        'type' => 'boolean',
                        'default' => false
                    ),
                    'transparentBreakpoint' => array(
                        'type' => 'string',
                        'default' => 'all-screens'
                    ),
                    'enableBorder' => array(
                        'type' => 'boolean',
                        'default' => false
                    ),
                    'enableCollapsedLogo' => array(
                        'type' => 'boolean',
                        'default' => false
                    ),
                    'enableFixEffect' => array(
                        'type' => 'boolean',
                        'default' => false
                    ),
                    'background' => array(
                        'type' => 'string',
                        'default' => 'default'
                    ),
                    'enableTopBar' => array(
                        'type' => 'boolean',
                        'default' => true
                    ),
                    'enableTopBarLeft' => array(
                        'type' => 'boolean',
                        'default' => true
                    ),
                    'enableTopBarRight' => array(
                        'type' => 'boolean',
                        'default' => true
                    ),
                    'enableLogoWhite' => array(
                        'type' => 'boolean',
                        'default' => false
                    ),
                    'logoAlign' => array(
                        'type' => 'string',
                        'default' => 'left'
                    ),
                    'logoAlignBreakpoint' => array(
                        'type' => 'string',
                        'default' => 'all-screens'
                    ),
                    'logoImageID' => array(
                        'type' => 'number',
                        'default' => 0
                    ),
                    'logoImageUrl' => array(
                        'type' => 'string',
                        'default' => ''
                    ),
                    'logoScrollImageID' => array(
                        'type' => 'number',
                        'default' => 0
                    ),
                    'logoScrollImageUrl' => array(
                        'type' => 'string',
                        'default' => ''
                    ),
                    'logoCollapsedImageID' => array(
                        'type' => 'number',
                        'default' => 0
                    ),
                    'logoCollapsedImageUrl' => array(
                        'type' => 'string',
                        'default' => ''
                    ),
                    'navbarMenuID' => array(
                        'type' => 'number',
                        'default' => 0
                    ),
                    'navbarMenuSlug' => array(
                        'type' => 'string',
                        'default' => ''
                    ),
                    'navbarResponsiveType' => array(
                        'type' => 'string',
                        'default' => 'collapse'
                    ),
                    'navbarCollapseBreakpoint' => array(
                        'type' => 'string',
                        'default' => 'md'
                    ),
                    'navbarAlign' => array(
                        'type' => 'string',
                        'default' => 'right'
                    ),
                    'navbarDropdownTrigger' => array(
                        'type' => 'string',
                        'default' => 'hover'
                    ),
                    'navbarScrollNav' => array(
                        'type' => 'boolean',
                        'default' => false
                    ),
                    'enableButton' => array(
                        'type' => 'boolean',
                        'default' => true
                    ),
                    'buttonUrl' => array(
                        'type' => 'string',
                        'default' => '#'
                    ),
                    'buttonNewTab' => array(
                        'type' => 'boolean',
                        'default' => true
                    ),
                    'buttonText' => array(
                        'type' => 'string',
                        'default' => esc_html__( 'Buy Now', FRONTGB_I18N )
                    ),
                    'buttonDesign' => array(
                        'type' => 'string',
                        'default' => 'default'
                    ),
                    'buttonBackground' => array(
                        'type' => 'string',
                        'default' => 'primary'
                    ),
                    'buttonSize' => array(
                        'type' => 'string',
                        'default' => 'default'
                    ),
                    'buttonIsWide' => array(
                        'type' => 'boolean',
                        'default' => false
                    ),
                    'buttonIsWideSM' => array(
                        'type' => 'boolean',
                        'default' => false
                    ),
                    'buttonIsBlock' => array(
                        'type' => 'boolean',
                        'default' => false
                    ),
                    'buttonBorderRadius' => array(
                        'type' => 'string',
                        'default' => 'default'
                    ),
                    'buttonIcon' => array(
                        'type' => 'string',
                        'default' => ''
                    ),
                    'buttonIsIconAfterText' => array(
                        'type' => 'boolean',
                        'default' => false
                    ),
                    'buttonIsIconButton' => array(
                        'type' => 'boolean',
                        'default' => false
                    ),
                    'buttonIsTransition' => array(
                        'type' => 'boolean',
                        'default' => true
                    ),
                    'enableCart' => array(
                        'type' => 'boolean',
                        'default' => true
                    ),
                    'enableMyAccount' => array(
                        'type' => 'boolean',
                        'default' => true
                    ),
                    'enableSearch' => array(
                        'type' => 'boolean',
                        'default' => true
                    ),
                    'enableSeperateOffcanvasLogo' => array(
                        'type' => 'boolean',
                        'default' => false
                    ),
                    'enableOffcanvasLogoWhite' => array(
                        'type' => 'boolean',
                        'default' => false
                    ),
                    'offcanvasLogoImageUrl' => array(
                        'type' => 'string',
                        'default' => ''
                    ),
                    'offcanvasLogoImageID' => array(
                        'type' => 'number',
                        'default' => 0
                    ),
                ),
                'render_callback' => 'frontgb_render_header_block',
            )
        );
    }
    add_action( 'init', 'frontgb_register_header_block' );
}