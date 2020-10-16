<?php
/**
 * Template for the candidate dashboard (`[candidate_dashboard]`) shortcode.
 *
 * This template can be overridden by copying it to yourtheme/wp-job-manager-resumes/candidate-dashboard.php.
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

$submission_limit           = get_option( 'resume_manager_submission_limit' );
$submit_resume_form_page_id = get_option( 'resume_manager_submit_resume_form_page_id' );
?>
<div id="resume-manager-candidate-dashboard" class="table-responsive-md">
    <p><?php echo _n( 'Your resume can be viewed, edited or removed below.', 'Your resume(s) can be viewed, edited or removed below.', resume_manager_count_user_resumes(), 'front' ); ?></p>
    <table class="resume-manager-resumes table">
        <thead>
            <tr>
                <?php foreach ( $candidate_dashboard_columns as $key => $column ) : ?>
                    <th class="<?php echo esc_attr( $key ); ?> text-nowrap"><?php echo esc_html( $column ); ?></th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php if ( ! $resumes ) : ?>
                <tr>
                    <td colspan="<?php echo sizeof( $candidate_dashboard_columns ); ?>"><?php esc_html_e( 'You do not have any active resume listings.', 'front' ); ?></td>
                </tr>
            <?php else : ?>
                <?php foreach ( $resumes as $resume ) : ?>
                    <tr>
                        <?php foreach ( $candidate_dashboard_columns as $key => $column ) : ?>
                            <td class="<?php echo esc_attr( $key ); ?> text-nowrap">
                                <?php if ( 'resume-title' === $key ) : ?>
                                    <?php if ( $resume->post_status == 'publish' ) : ?>
                                        <a class="text-body" href="<?php echo get_permalink( $resume->ID ); ?>"><?php echo esc_html( $resume->post_title ); ?></a>
                                    <?php else : ?>
                                        <?php echo esc_html( $resume->post_title ); ?> <small>(<?php the_resume_status( $resume ); ?>)</small>
                                    <?php endif; ?>
                                    <ul class="candidate-dashboard-actions d-flex list-inline mb-0 align-items-md-center">
                                        <?php
                                            $actions = array();

                                            switch ( $resume->post_status ) {
                                                case 'publish' :
                                                    $actions['edit'] = array( 'label' => esc_html__( 'Edit', 'front' ), 'nonce' => false );
                                                    $actions['hide'] = array( 'label' => esc_html__( 'Hide', 'front' ), 'nonce' => true );
                                                break;
                                                case 'hidden' :
                                                    $actions['edit'] = array( 'label' => esc_html__( 'Edit', 'front' ), 'nonce' => false );
                                                    $actions['publish'] = array( 'label' => esc_html__( 'Publish', 'front' ), 'nonce' => true );
                                                break;
                                                case 'expired' :
                                                    if ( get_option( 'resume_manager_submit_resume_form_page_id' ) ) {
                                                        $actions['relist'] = array( 'label' => esc_html__( 'Relist', 'front' ), 'nonce' => true );
                                                    }
                                                break;
                                            }

                                            $actions['delete'] = array( 'label' => esc_html__( 'Delete', 'front' ), 'nonce' => true );

                                            $actions = apply_filters( 'resume_manager_my_resume_actions', $actions, $resume );

                                            foreach ( $actions as $action => $value ) {
                                                $action_url = add_query_arg( array( 'action' => $action, 'resume_id' => $resume->ID ) );
                                                if ( $value['nonce'] )
                                                    $action_url = wp_nonce_url( $action_url, 'resume_manager_my_resume_actions' );
                                                echo '<li class="list-inline-item"><a href="' . $action_url . '" class="candidate-dashboard-action-' . $action . ' ' . esc_attr( $action === "delete" ? "text-danger" : "text-secondary" ) . ' small">' . $value['label'] . '</a></li>';
                                            }
                                        ?>
                                    </ul>
                                <?php elseif ( 'candidate-title' === $key ) : ?>
                                    <?php the_candidate_title( '', '', true, $resume ); ?>
                                <?php elseif ( 'candidate-location' === $key ) : ?>
                                    <?php the_candidate_location( false, $resume ); ?></td>
                                <?php elseif ( 'resume-category' === $key ) : ?>
                                    <?php the_resume_category( $resume ); ?>
                                <?php elseif ( 'status' === $key ) : ?>
                                    <?php the_resume_status( $resume ); ?>
                                <?php elseif ( 'date' === $key ) : ?>
                                    <?php
                                    if ( ! empty( $resume->_resume_expires ) && strtotime( $resume->_resume_expires ) > current_time( 'timestamp' ) ) {
                                        printf( wp_kses_post( __( 'Expires %s', 'front' ) ), date_i18n( get_option( 'date_format' ), strtotime( $resume->_resume_expires ) ) );
                                    } else {
                                        echo date_i18n( get_option( 'date_format' ), strtotime( $resume->post_date ) );
                                    }
                                    ?>
                                <?php else : ?>
                                    <?php do_action( 'resume_manager_candidate_dashboard_column_' . $key, $resume ); ?>
                                <?php endif; ?>
                            </td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
        <?php if ( $submit_resume_form_page_id && ( resume_manager_count_user_resumes() < $submission_limit || ! $submission_limit ) ) : ?>
            <tfoot>
                <tr>
                    <td colspan="<?php echo sizeof( $candidate_dashboard_columns ); ?>">
                        <a class="btn btn-sm btn-primary" href="<?php echo esc_url( get_permalink( $submit_resume_form_page_id ) ); ?>"><?php esc_html_e( 'Add Resume', 'front' ); ?></a>
                    </td>
                </tr>
            </tfoot>
        <?php endif; ?>
    </table>
    <?php get_job_manager_template( 'pagination.php', array( 'max_num_pages' => $max_num_pages ) ); ?>
</div>
