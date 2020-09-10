<?php
/**
 * Form Embed Wizard.
 * Embed popup HTML template.
 *
 * @since 1.6.2
 */

if ( ! \defined( 'ABSPATH' ) ) {
	exit;
}

?>
<div id="wpforms-admin-form-embed-wizard-container" class="wpforms-admin-popup-container">
	<div id="wpforms-admin-form-embed-wizard" class="wpforms-admin-popup">
		<div class="wpforms-admin-popup-content">
			<h3><?php esc_html_e( 'Embed in a Page', 'wpforms-lite' ); ?></h3>
			<div class="wpforms-admin-popup-content-regular">
				<?php
				printf(
					wp_kses( /* translators: %s - Video tutorial toggle class. */
						__(
							'<p>We can help embed your form with just a few clicks!</p>
							<p>If you prefer to do it manually, or need to embed the form in a post or custom post type, <a href="#" class="%s">check out our video tutorial</a>.</p>',
							'wpforms-lite'
						),
						array(
							'p' => [],
							'a' => [
								'href'  => [],
								'class' => [],
							],
						)
					),
					'tutorial-toggle'
				);
				$pages_exists = wp_count_posts( 'page' )->publish > 0;
				printf(
					'<p>%s</p>',
					esc_html(
						$pages_exists ?
							__( 'Otherwise, select an option to proceed with the embed wizard.', 'wpforms-lite' ) :
							__( 'Otherwise, please name your new page to proceed with the embed wizard.', 'wpforms-lite' )
					)
				);

				$video_id = wpforms_is_gutenberg_active() ? '_29nTiDvmLw' : 'IxGVz3AjEe0';
				?>
				<iframe style="display: none;" src="https://youtube.com/embed/<?php echo esc_attr( $video_id ); ?>?rel=0&showinfo=0" frameborder="0" id="wpforms-admin-form-embed-wizard-tutorial" allowfullscreen width="450" height="256"></iframe>
			</div>
			<div class="wpforms-admin-popup-content-challenge">
				<?php
				printf(
					'<p>%s</p>',
					esc_html(
						$pages_exists ?
							__( 'Would you like to embed your form in an existing page or create a new one?', 'wpforms-lite' ) :
							__( 'Please name your new page to proceed.', 'wpforms-lite' )
					)
				);
				?>
			</div>
			<div id="wpforms-admin-form-embed-wizard-section-btns" class="wpforms-admin-popup-bottom">
				<button type="button" data-action="select-page" class="wpforms-admin-popup-btn"><?php esc_html_e( 'Select Existing Page', 'wpforms-lite' ); ?></button>
				<button type="button" data-action="create-page" class="wpforms-admin-popup-btn"><?php esc_html_e( 'Create New Page', 'wpforms-lite' ); ?></button>
			</div>
			<div id="wpforms-admin-form-embed-wizard-section-go" class="wpforms-admin-popup-bottom wpforms-admin-popup-flex" style="display: none;">
				<?php
				wp_dropdown_pages(
					[
						'show_option_none' => esc_html__( 'Select a Page', 'wpforms-lite' ),
						'id'               => 'wpforms-admin-form-embed-wizard-select-page',
						'name'             => '',
					]
				);
				?>
				<input type="text" id="wpforms-admin-form-embed-wizard-new-page-title" value="" placeholder="<?php esc_attr_e( 'Name Your Page', 'wpforms-lite' ); ?>">
				<button type="button" data-action="go" class="wpforms-admin-popup-btn"><?php esc_html_e( 'Let’s Go!', 'wpforms-lite' ); ?></button>
			</div>
		</div>
		<div class="wpforms-admin-popup-close">×</div>
	</div>
</div>
