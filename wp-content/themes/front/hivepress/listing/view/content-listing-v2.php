<?php
/**
 * The template for displaying listing content within loops
 *
 */

defined( 'ABSPATH' ) || exit;

$card_bg_color = 'bg-success';
$card_bg_color_attribute_key = apply_filters( 'front_hp_listing_card_background_color_attribute_key', 'card_background_color' );
$fields = $listing->_get_fields();
if ( isset( $fields[$card_bg_color_attribute_key] ) ) {
    $value = $fields[$card_bg_color_attribute_key]->get_value();
    if( ! empty( $value ) && in_array( $value, array( 'bg-primary', 'bg-secondary', 'bg-success', 'bg-danger', 'bg-warning', 'bg-info', 'bg-light', 'bg-dark', 'bg-white', 'bg-transparent' ) ) ) {
        $card_bg_color = $value;
    }
}

?>
<a class="card card-frame h-100" href="<?php echo esc_url( hivepress()->router->get_url( 'listing_view_page', [ 'listing_id' => $listing->get_id() ] ) ); ?>">
	<div class="card-body rounded-top p-5 <?php echo esc_attr( $card_bg_color ); ?>">
		<div class="u-lg-avatar bg-white rounded p-2 mx-auto">
			<?php
            if ( has_post_thumbnail() ) {
                the_post_thumbnail( 'post-thumbnail', array( 'class' => 'img-fluid' ) );
            }
            ?>
		</div>
	</div>
	<div class="card-body p-4">
		<div class="d-flex align-items-center mb-1">
			<span class="d-block text-dark font-weight-medium"><?php the_title(); ?></span>
			<?php if ( $listing->is_verified() ): ?>
            <img class="ml-2" src="<?php echo esc_url( get_template_directory_uri() . '/assets/svg/components/top-vendor.svg' ); ?>" alt="<?php _e( 'Verified Icon', 'front' ); ?>" width="20">
            <?php endif; ?>
		</div>
		<span class="d-block text-secondary font-size-1"><?php the_excerpt(); ?></span>
	</div>
</a>