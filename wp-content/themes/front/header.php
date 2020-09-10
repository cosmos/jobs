<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package front
 */

?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=2.0">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>
<body <?php body_class();?> <?php front_body_styles(); ?>>

<?php do_action( 'front_before_site' ); ?>

<div id="page" class="hfeed site">
    
    <?php do_action( 'front_before_header' ); ?>

    <?php do_action( 'front_header' ); ?>

    <?php do_action( 'front_after_header' ); ?>

    <?php
    /**
     * Functions hooked in to front_before_content
     *
     * @hooked front_header_widget_region - 10
     * @hooked woocommerce_breadcrumb - 10
     */
    do_action( 'front_before_content' );
    ?>

    <main id="content" role="main">

        <?php
        do_action( 'front_content_top' );