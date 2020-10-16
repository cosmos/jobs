<?php
/**
 * Job dashboard shortcode content.
 *
 * This template can be overridden by copying it to yourtheme/job_manager/job-dashboard.php.
 *
 * @see         https://wpjobmanager.com/document/template-overrides/
 * @author      Automattic
 * @package     wp-job-manager
 * @category    Template
 * @version     1.32.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
?>
<div id="job-manager-job-dashboard" class="table-responsive-md">
    <p><?php esc_html_e( 'Your listings are shown in the table below.', 'front' ); ?></p>
    <?php
        $job_resume_manager = function_exists( 'front_is_wp_resume_manager_activated' ) && front_is_wp_resume_manager_activated();
        $job_company_manager = function_exists( 'front_is_mas_wp_company_manager_activated' ) && front_is_mas_wp_company_manager_activated();
        $user = wp_get_current_user();
        $jobs_dashboard_link = apply_filters( 'front_header_topbar_user_account_view', 'dropdown' );

        if ( ( $job_resume_manager || $job_company_manager ) && $jobs_dashboard_link == 'modal' ) {
            ?><p><?php
            if ( $job_resume_manager && get_option( 'resume_manager_candidate_dashboard_page_id' ) && ! ( in_array( 'employer', (array) $user->roles ) ) ) {
                ?>
                <a class="link-muted mr-5" href="<?php echo esc_url( get_permalink( get_option( 'resume_manager_candidate_dashboard_page_id' ) ) ); ?>">
                    <?php echo esc_html__( 'Candidate Dashboard', 'front' ); ?>
                </a>
                <?php
            }
            if ( $job_company_manager && mas_wpjmc_get_page_id( 'company_dashboard' ) && in_array( 'employer', (array) $user->roles ) || in_array( 'administrator', (array) $user->roles ) ) {
                ?>
                <a class="link-muted" href="<?php echo esc_url( get_permalink( mas_wpjmc_get_page_id( 'company_dashboard' ) ) ); ?>">
                    <?php echo esc_html__( 'Company Dashboard', 'front' ); ?>
                </a>
                <?php
            }
            ?></p><?php
        }
    ?>
    <table class="job-manager-jobs table">
        <thead>
            <tr>
                <?php foreach ( $job_dashboard_columns as $key => $column ) : ?>
                    <th class="<?php echo esc_attr( $key ); ?> text-nowrap"><?php echo esc_html( $column ); ?></th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php if ( ! $jobs ) : ?>
                <tr>
                    <td colspan="<?php echo intval( count( $job_dashboard_columns ) ); ?>"><?php esc_html_e( 'You do not have any active listings.', 'front' ); ?></td>
                </tr>
            <?php else : ?>
                <?php foreach ( $jobs as $job ) : ?>
                    <tr>
                        <?php foreach ( $job_dashboard_columns as $key => $column ) : ?>
                            <td class="<?php echo esc_attr( $key ); ?> text-nowrap">
                                <?php if ('job_title' === $key ) : ?>
                                    <?php if ( $job->post_status == 'publish' ) : ?>
                                        <a class="text-body" href="<?php echo esc_url( get_permalink( $job->ID ) ); ?>"><?php wpjm_the_job_title( $job ); ?></a>
                                    <?php else : ?>
                                        <?php wpjm_the_job_title( $job ); ?> <small>(<?php the_job_status( $job ); ?>)</small>
                                    <?php endif; ?>
                                    <?php echo is_position_featured( $job ) ? '<span class="featured-job-icon" title="' . esc_attr__( 'Featured Job', 'front' ) . '"></span>' : ''; ?>
                                    <ul class="job-dashboard-actions d-flex list-inline mb-0 align-items-md-center">
                                        <?php
                                            $actions = [];

                                            switch ( $job->post_status ) {
                                                case 'publish' :
                                                    if ( wpjm_user_can_edit_published_submissions() ) {
                                                        $actions[ 'edit' ] = [ 'label' => esc_html__( 'Edit', 'front' ), 'nonce' => false ];
                                                    }
                                                    if ( is_position_filled( $job ) ) {
                                                        $actions['mark_not_filled'] = [ 'label' => esc_html__( 'Mark not filled', 'front' ), 'nonce' => true ];
                                                    } else {
                                                        $actions['mark_filled'] = [ 'label' => esc_html__( 'Mark filled', 'front' ), 'nonce' => true ];
                                                    }

                                                    $actions['duplicate'] = [ 'label' => esc_html__( 'Duplicate', 'front' ), 'nonce' => true ];
                                                    break;
                                                case 'expired' :
                                                    if ( job_manager_get_permalink( 'submit_job_form' ) ) {
                                                        $actions['relist'] = [ 'label' => esc_html__( 'Relist', 'front' ), 'nonce' => true ];
                                                    }
                                                    break;
                                                case 'pending_payment' :
                                                case 'pending' :
                                                    if ( job_manager_user_can_edit_pending_submissions() ) {
                                                        $actions['edit'] = [ 'label' => esc_html__( 'Edit', 'front' ), 'nonce' => false ];
                                                    }
                                                break;
                                                case 'draft' :
                                                case 'preview' :
                                                    $actions['continue'] = [ 'label' => esc_html__( 'Continue Submission', 'front' ), 'nonce' => true ];
                                                    break;
                                            }

                                            $actions['delete'] = [ 'label' => esc_html__( 'Delete', 'front' ), 'nonce' => true ];
                                            $actions           = apply_filters( 'job_manager_my_job_actions', $actions, $job );

                                            foreach ( $actions as $action => $value ) {
                                                $action_url = add_query_arg( [ 'action' => $action, 'job_id' => $job->ID ] );
                                                if ( $value['nonce'] ) {
                                                    $action_url = wp_nonce_url( $action_url, 'job_manager_my_job_actions' );
                                                }
                                                echo '<li class="list-inline-item"><a href="' . esc_url( $action_url ) . '" class="job-dashboard-action-' . esc_attr( $action ) . ' ' . esc_attr( $action === "delete" ? "text-danger" : "text-secondary" ) . ' small">' . esc_html( $value['label'] ) . '</a></li>';
                                            }
                                        ?>
                                    </ul>
                                <?php elseif ('date' === $key ) : ?>
                                    <?php echo esc_html( date_i18n( get_option( 'date_format' ), strtotime( $job->post_date ) ) ); ?>
                                <?php elseif ('expires' === $key ) : ?>
                                    <?php echo esc_html( $job->_job_expires ? date_i18n( get_option( 'date_format' ), strtotime( $job->_job_expires ) ) : '&ndash;' ); ?>
                                <?php elseif ('filled' === $key ) : ?>
                                    <?php echo is_position_filled( $job ) ? '&#10004;' : '&ndash;'; ?>
                                <?php else : ?>
                                    <?php do_action( 'job_manager_job_dashboard_column_' . $key, $job ); ?>
                                <?php endif; ?>
                            </td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
    <?php get_job_manager_template( 'pagination.php', [ 'max_num_pages' => $max_num_pages ] ); ?>
</div>