<?php
/**
 * Form field that is repeated multiple times.
 *
 * This template can be overridden by copying it to yourtheme/wp-job-manager-resumes/form-fields/repeated-field.php.
 *
 * @see         https://wpjobmanager.com/document/template-overrides/
 * @author      Automattic
 * @package     WP Job Manager - Resume Manager
 * @category    Template
 * @version     1.13.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! empty( $field['value'] ) && is_array( $field['value'] ) ) : ?>
	<?php foreach ( $field['value'] as $index => $value ) : ?>
		<div class="resume-manager-data-row">
			<input type="hidden" class="repeated-row-index" name="repeated-row-<?php echo esc_attr( $key ); ?>[]" value="<?php echo absint( $index ); ?>" />
			<a href="#" class="resume-manager-remove-row"><?php esc_html_e( 'Remove', 'front' ); ?></a>
			<?php foreach ( $field['fields'] as $subkey => $subfield ) : ?>
				<fieldset class="fieldset-<?php echo esc_attr( $subkey ); ?>">
					<?php echo '<label for="' . esc_attr( $subkey ) . '">' . $subfield['label'] . ( $subfield['required'] ? '' : ' <small>' . esc_html__( '(optional)', 'front' ) . '</small>' ) . '</label>'; ?>
					<div class="field">
						<?php
							// Get name and value
							$subfield['name']  = $key . '_' . $subkey . '_' . $index;
							$subfield['value'] = $value[ $subkey ];
							$class->get_field_template( $subkey, $subfield );
						?>
					</div>
				</fieldset>
			<?php endforeach; ?>
		</div>
	<?php endforeach; ?>
<?php endif; ?>

<a href="#" class="resume-manager-add-row btn btn-sm btn-soft-secondary" data-row="<?php

	ob_start();
	?>
		<div class="resume-manager-data-row">
			<input type="hidden" class="repeated-row-index" name="repeated-row-<?php echo esc_attr( $key ); ?>[]" value="%%repeated-row-index%%" />
			<a href="#" class="resume-manager-remove-row"><?php esc_html_e( 'Remove', 'front' ); ?></a>
			<?php foreach ( $field['fields'] as $subkey => $subfield ) : ?>
				<fieldset class="fieldset-<?php echo esc_attr( $subkey ); ?>">
					<?php echo '<label for="' . esc_attr( $subkey ) . '">' . $subfield['label'] . ( $subfield['required'] ? '' : ' <small>' . esc_html__( '(optional)', 'front' ) . '</small>' ) . '</label>'; ?>
					<div class="field">
						<?php
							$subfield['name']  = $key . '_' . $subkey . '_%%repeated-row-index%%';
							$class->get_field_template( $subkey, $subfield );
						?>
					</div>
				</fieldset>
			<?php endforeach; ?>
		</div>
	<?php
	echo esc_attr( ob_get_clean() );

?>">+ <?php echo esc_html( ! empty( $field['add_row'] ) ? $field['add_row'] : __( 'Add URL', 'front' ) ); ?></a>
<?php if ( ! empty( $field['description'] ) ) :
	echo '<small class="description">' . $field['description'] . '</small>';
endif; ?>
