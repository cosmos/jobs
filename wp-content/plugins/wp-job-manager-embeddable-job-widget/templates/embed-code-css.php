<?php
/**
 * Embedded job listing inline CSS.
 *
 * This template can be overridden by copying it to yourtheme/wp-job-manager-embeddable-job-widget/embed-code-css.php.
 *
 * @see         https://wpjobmanager.com/document/template-overrides/
 * @author      Automattic
 * @package     WP Job Manager - Embeddable Job Widget
 * @category    Template
 * @version     1.0.2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<style type='text/css'>
	#embeddable-job-widget * { margin:0 ; padding: 0; font-size: 1em; line-height: 1.25em; }
	#embeddable-job-widget { border: 1px solid #ccc; border-bottom-width: 3px; padding: 1em; }
	#embeddable-job-widget-heading { font-weight: bold; font-size: 1.25em; margin: 0; padding: 0 0 0.8em; border-bottom: 1px solid #ccc; }
	#embeddable-job-widget ul li { border-bottom: 1px solid #eee; display: block; }
	#embeddable-job-widget ul li a, #embeddable-job-widget ul li.no-results { padding: 1em 0; margin: 0; display: block; text-decoration: none; }
	#embeddable-job-widget ul li a .embeddable-job-widget-listing-title { font-weight: bold; margin-bottom: .5em; text-decoration: underline; }
	#embeddable-job-widget ul li a .embeddable-job-widget-listing-meta { text-decoration: none; }
	#embeddable-job-widget ul li:last-child { border-bottom: 0; }
	#embeddable-job-widget ul li:last-child a { padding-bottom: 0; }
	#embeddable-job-widget-pagination { overflow: hidden; padding: 1em 0 0; margin: 1em 0 0 0; border-top: 1px solid #eee; }
	#embeddable-job-widget-pagination .embeddable-job-widget-next { float: right; }
	#embeddable-job-widget-pagination .embeddable-job-widget-prev { float: left; }
</style>