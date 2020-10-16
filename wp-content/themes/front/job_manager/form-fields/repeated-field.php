<?php
/**
 * Form field that is repeated multiple times.
 *
 * This template can be overridden by copying it to yourtheme/job_manager/form-fields/repeated-field.php.
 *
 * @see         https://wpjobmanager.com/document/template-overrides/
 * @author      Automattic
 * @package     WP Job Manager
 * @category    Template
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! empty( $field['value'] ) && is_array( $field['value'] ) ) : ?>
	<?php foreach ( $field['value'] as $index => $value ) : ?>
		<div class="wp-job-manager-data-row">
			<input type="hidden" class="repeated-row-index" name="repeated-row-<?php echo esc_attr( $key ); ?>[]" value="<?php echo absint( $index ); ?>" />
			<a href="#" class="wp-job-manager-remove-row"><?php esc_html_e( 'Remove', 'front' ); ?></a>
			<?php foreach ( $field['fields'] as $subkey => $subfield ) : ?>
				<fieldset class="fieldset-<?php esc_attr( $subkey ); ?>">
					<?php echo '<label for="' . esc_attr( $subkey ) . '">' . $subfield['label'] . ( $subfield['required'] ? '' : ' <small>' . esc_html__( '(optional)', 'front' ) . '</small>' ) . '</label>'; ?>
					<div class="field">
						<?php
							// Get name and value
							$subfield['name']  = $key . '_' . $subkey . '_' . $index;
							$subfield['value'] = $value[ $subkey ];
							get_job_manager_template( 'form-fields/' . $subfield['type'] . '-field.php', array( 'key' => $subkey, 'field' => $subfield ) );
						?>
					</div>
				</fieldset>
			<?php endforeach; ?>
		</div>
	<?php endforeach; ?>
<?php endif; ?>

<a href="#" class="wp-job-manager-add-row btn btn-sm btn-soft-secondary" data-row="<?php

	ob_start();
	?>
		<div class="wp-job-manager-data-row">
			<input type="hidden" class="repeated-row-index" name="repeated-row-<?php echo esc_attr( $key ); ?>[]" value="%%repeated-row-index%%" />
			<a href="#" class="wp-job-manager-remove-row"><?php esc_html_e( 'Remove', 'front' ); ?></a>
			<?php if ( isset( $field['fields'] ) ) : ?>
				<?php foreach ( $field['fields'] as $subkey => $subfield ) : ?>
					<fieldset class="fieldset-<?php esc_attr( $subkey ); ?>">
						<?php echo '<label for="' . esc_attr( $subkey ) . '">' . $subfield['label'] . ( $subfield['required'] ? '' : ' <small>' . esc_html__( '(optional)', 'front' ) . '</small>' ) . '</label>'; ?>
						<div class="field">
							<?php
								$subfield['name']  = $key . '_' . $subkey . '_%%repeated-row-index%%';
								get_job_manager_template( 'form-fields/' . $subfield['type'] . '-field.php', array( 'key' => $subkey, 'field' => $subfield ) );
							?>
						</div>
					</fieldset>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>
	<?php
	echo esc_attr( ob_get_clean() );

?>">+ <?php echo esc_html( ! empty( $field['add_row'] ) ? $field['add_row'] : __( 'Add Row', 'front' ) ); ?></a>
<?php if ( ! empty( $field['description'] ) ) :
	echo '<small class="description">' . $field['description'] . '</small>';
endif; ?>
