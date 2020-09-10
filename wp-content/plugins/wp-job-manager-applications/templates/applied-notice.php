<?php
/**
 * Notice shown when a user has already applied for a job.
 *
 * This template can be overridden by copying it to yourtheme/wp-job-manager-applications/applied-notice.php.
 *
 * @see         https://wpjobmanager.com/document/template-overrides/
 * @author      Automattic
 * @package     wp-job-manager-applications
 * @category    Template
 * @version     1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="job-manager-applications-applied-notice">
	<?php _e( 'You have already applied for this job.', 'wp-job-manager-applications' ); ?>
</div>
