<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
do_action( 'single_company_before' );
do_action( 'single_company_content_area_before' );
do_action( 'single_company_start' );
do_action( 'single_company' );
do_action( 'single_company_end' );
do_action( 'single_company_content_area_after' );
do_action( 'single_company_after' );