<?php
/**
 * Form for setting up a embedded job widget.
 *
 * This template can be overridden by copying it to yourtheme/wp-job-manager-embeddable-job-widget/form-embed-code-generator.php.
 *
 * @see         https://wpjobmanager.com/document/template-overrides/
 * @author      Automattic
 * @package     WP Job Manager - Embeddable Job Widget
 * @category    Template
 * @version     1.1.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<form class="job-manager-form">
	<fieldset>
		<label for="widget_keyword"><?php _e( 'Keyword', 'wp-job-manager-embeddable-job-widget' ); ?></label>
		<div class="field">
			<input type="text" id="widget_keyword" class="input-text" placeholder="<?php _e( 'Optionally choose a keyword to search', 'wp-job-manager-embeddable-job-widget' ); ?>" />
		</div>
	</fieldset>
	<fieldset>
		<label for="widget_location"><?php _e( 'Location', 'wp-job-manager-embeddable-job-widget' ); ?></label>
		<div class="field">
			<input type="text" id="widget_location" class="input-text" placeholder="<?php _e( 'Optionally choose a location to search', 'wp-job-manager-embeddable-job-widget' ); ?>" />
		</div>
	</fieldset>
	<fieldset>
		<label for="widget_per_page"><?php _e( 'Display Count', 'wp-job-manager-embeddable-job-widget' ); ?></label>
		<div class="field">
			<input type="text" id="widget_per_page" class="input-text" value="5" />
		</div>
	</fieldset>
	<fieldset>
		<label for="widget_pagination"><?php _e( 'Show Pagination?', 'wp-job-manager-embeddable-job-widget' ); ?></label>
		<div class="field">
			<input type="checkbox" id="widget_pagination" class="input-checkbox" />
		</div>
	</fieldset>
	<?php if ( get_option( 'job_manager_enable_categories' ) && wp_count_terms( 'job_listing_category' ) > 0 ) : ?>
		<fieldset>
			<label for="widget_categories"><?php _e( 'Categories', 'wp-job-manager-embeddable-job-widget' ); ?></label>
			<div class="field">
				<?php
					wp_enqueue_script( 'wp-job-manager-term-multiselect' );

					job_manager_dropdown_categories( array(
						'taxonomy'     => 'job_listing_category',
						'hierarchical' => 1,
						'name'         => 'widget_categories',
						'orderby'      => 'name',
						'hide_empty'   => false,
						'placeholder'  => __( 'Any category', 'wp-job-manager-embeddable-job-widget' )
					) );
				?>
			</div>
		</fieldset>
	<?php endif; ?>
	<fieldset>
		<label for="widget_job_type"><?php _e( 'Job Type', 'wp-job-manager-embeddable-job-widget' ); ?></label>
		<div class="field">
			<select data-placeholder="<?php _e( 'Any job type', 'wp-job-manager-embeddable-job-widget' ); ?>" id="widget_job_type" multiple="multiple" class="job-manager-enhanced-select">
				<?php
					$terms = get_job_listing_types();
					foreach ( $terms as $term ) {
						echo '<option value="' . esc_attr( $term->slug ) . '">' . esc_html( $term->name ) . '</option>';
					}
				?>
			</select>
		</div>
	</fieldset>
	<p>
		<input type="button" id="widget-get-code" value="<?php _e( 'Get Widget Embed Code', 'wp-job-manager-embeddable-job-widget' ); ?>" />
	</p>
	<div id="widget-code-wrapper">
		<div id="widget-code-preview">
			<h2><?php _e( 'Preview', 'wp-job-manager-embeddable-job-widget' ); ?></h2>
		</div>
		<div id="widget-code-content">
			<h2><?php _e( 'Code', 'wp-job-manager-embeddable-job-widget' ); ?></h2>
			<textarea readonly="readonly" id="widget-code" rows="10"></textarea>
		</div>
	</div>
</form>
