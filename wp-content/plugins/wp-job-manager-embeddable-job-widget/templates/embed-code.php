<?php
/**
 * Embedded job listing code.
 *
 * This template can be overridden by copying it to yourtheme/wp-job-manager-embeddable-job-widget/embed-code.php.
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
<script type='text/javascript' src='<?php echo JOB_MANAGER_EMBEDDABLE_JOB_WIDGET_PLUGIN_URL; ?>/assets/js/embed.js'></script>
<div id="embeddable-job-widget">
	<div id="embeddable-job-widget-heading">Jobs From <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></a></div>
	<div id="embeddable-job-widget-content"></div>
</div>