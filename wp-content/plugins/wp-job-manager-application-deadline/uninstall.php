<?php
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit();
}

wp_clear_scheduled_hook( 'check_application_deadlines' );

$options = array(
	'job_manager_expire_when_deadline_passed'
);

foreach ( $options as $option ) {
	delete_option( $option );
}