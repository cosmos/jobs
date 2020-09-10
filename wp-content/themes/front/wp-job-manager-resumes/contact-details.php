<?php
/**
 * Displays contact details when viewing a single resume.
 *
 * This template can be overridden by copying it to yourtheme/wp-job-manager-resumes/contact-details.php.
 *
 * @see         https://wpjobmanager.com/document/template-overrides/
 * @author      Automattic
 * @package     WP Job Manager - Resume Manager
 * @category    Template
 * @version     1.13.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $resume_preview;

if ( $resume_preview ) {
	return;
}

if ( resume_manager_user_can_view_contact_details( $post->ID ) ) :
    ?>
    <div class="resume_contact contact position-relative">
        <?php do_action( 'resume_contact_start' ); ?>

        <button type="button" class="resume_contact_button btn btn-block btn-sm btn-soft-primary transition-3d-hover"data-toggle="modal" data-target="#contactDetails">
            <?php esc_html_e( 'Contact', 'front' ); ?>
        </button>
        <div class="contact_details modal fade" id="contactDetails" tabindex="-1" role="dialog" aria-labelledby="contactModalTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="contactModalTitle"><?php esc_html_e( 'Contact', 'front' ) ?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                    <?php do_action( 'resume_manager_contact_details' ); ?>
                    </div>
                </div>
            </div>
        </div>
        <?php do_action( 'resume_contact_end' ); ?>
    </div>
<?php else : ?>

	<?php get_job_manager_template_part( 'access-denied', 'contact-details', 'wp-job-manager-resumes', RESUME_MANAGER_PLUGIN_DIR . '/templates/' ); ?>

<?php endif; ?>
