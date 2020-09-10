<?php
/**
 * Filter in `[jobs]` shortcode for job types.
 *
 * This template can be overridden by copying it to yourtheme/job_manager/job-filter-job-types.php.
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
<?php if ( ! is_tax( 'job_listing_type' ) && empty( $job_types ) ) : ?>
	<ul class="job_types col-lg-12 list-inline mt-lg-4 mb-0">
		<?php foreach ( get_job_listing_types() as $type ) : ?>
			<li class="list-inline-item custom-control custom-checkbox d-inline-flex align-items-center text-muted">
				<input type="checkbox" name="filter_job_type[]" value="<?php echo esc_attr( $type->slug ); ?>" <?php checked( in_array( $type->slug, $selected_job_types ), true ); ?> id="job_type_<?php echo esc_attr( $type->slug ); ?>" class="custom-control-input <?php echo esc_attr( sanitize_title( $type->name ) ); ?>" />
				<label for="job_type_<?php echo esc_attr( $type->slug ); ?>" class=" custom-control-label">
					<small><?php echo esc_html( $type->name ); ?></small>
				</label>
			</li>
		<?php endforeach; ?>
	</ul>
	<input type="hidden" name="filter_job_type[]" value="" />
<?php elseif ( $job_types ) : ?>
	<?php foreach ( $job_types as $job_type ) : ?>
		<input type="hidden" name="filter_job_type[]" value="<?php echo esc_attr( sanitize_title( $job_type ) ); ?>" />
	<?php endforeach; ?>
<?php endif; ?>
