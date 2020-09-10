<?php
/**
 * File for all Front Settings.
 * 
 * @package front
 */

if ( ! function_exists( 'front_get_settings' ) ) :
/**
 * Get Settings based on conditional tags
 */
function front_get_settings() {
    $settings = array(
        'body'   => array(),
        'header' => array(),
        'search_push_top' => array(),
        'header_section' => array(),
        'topbar' => array(),
        'logo_nav' => array(),
        'navbar' => array(),
        'navbar-brand' => array(),
        'navbar-toggler' => array(),
        'navbar-collapse' => array(),
        'navbar-nav' => array(),
    );
}
endif;

function front_classic_agency_settings() {
    $settings = array(
        'header' => array(
            'class' => 'u-header u-header--abs-top-md u-header--bg-transparent u-header--show-hide-md',
            'id'    => 'header',
            'data'  => array(
                'header-fix-moment' => '500',
                'header-fix-effect' => 'slide'
            )
        ),
        'search_push_top' => array(),
        'header_section' => array(),
        'topbar' => array(),
        'logo_nav' => array(),
        'navbar' => array(
            'class' => 'js-mega-menu navbar navbar-expand-md u-header__navbar u-header__navbar--no-space',
        ),
        'navbar-brand' => array(
            'class' => 'navbar-brand u-header__navbar-brand u-header__navbar-brand-center'
        ),
        'navbar-toggler' => array(),
        'navbar-collapse' => array(),
        'navbar-nav' => array(),
    );
}