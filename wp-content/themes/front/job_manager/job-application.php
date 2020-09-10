<?php
/**
 * Show job application when viewing a single job listing.
 *
 * This template can be overridden by copying it to yourtheme/job_manager/job-application.php.
 *
 * @see         https://wpjobmanager.com/document/template-overrides/
 * @author      Automattic
 * @package     WP Job Manager
 * @category    Template
 * @version     1.31.1
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
?>
<?php if ( $apply = get_the_job_application_method() ) :
    ?>
    <div class="job_application application position-relative">
        <?php do_action( 'job_application_start', $apply ); ?>

        <button type="button" class="application_button button btn btn-sm btn-soft-primary transition-3d-hover" data-toggle="modal" data-target="#jobApplicationDetails">
            <?php esc_html_e( 'Apply for job', 'front' ); ?>
        </button>
        <div class="job_application_details modal fade" id="jobApplicationDetails" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle"><?php esc_html_e( 'Apply For Job', 'front' ) ?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                    <?php
                        /**
                         * job_manager_application_details_email or job_manager_application_details_url hook
                         */
                        do_action( 'job_manager_application_details_' . $apply->type, $apply );
                    ?>
                    </div>
                </div>
            </div>
        </div>
        <?php do_action( 'job_application_end', $apply ); ?>
    </div>
<?php endif; ?>
