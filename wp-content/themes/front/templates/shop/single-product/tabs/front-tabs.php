<?php
/**
 * Front Single Product tabs
 * 
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Filter tabs and allow third parties to add their own.
 *
 * Each tab is an array containing title, callback and priority.
 * @see woocommerce_default_product_tabs()
 */
$tabs = apply_filters( 'woocommerce_product_tabs', array() );

if ( ! empty( $tabs ) ) : ?>

	<?php 
	$header = '<ul class="fr-tabs list-unstyled d-none justify-content-center mx-md-auto mb-9">';
		foreach ( $tabs as $key => $tab ) : 
			$header .= '<li class="' . esc_attr( $key ) . '_tab">
				<a href="#tab-' . esc_attr( $key ) . '">' . apply_filters( 'woocommerce_product_' . $key . '_tab_title', esc_html( $tab['title'] ), $key ) . '</a>
			</li>';
		endforeach;
	$header .= '</ul>'; ?>

	<div class="front-tabs front-tabs-wrapper wc-tabs-wrapper">
		<?php foreach ( $tabs as $key => $tab ) : ?>
			<div class="front-tab" id="tab-<?php echo esc_attr( $key ); ?>">
				<div class="container space-top-2 space-top-lg-3">
					<div class="tab-content">
					<?php 
						$search 	= 'class="' . esc_attr( $key ) . '_tab"';
						$replace 	= 'class="' . esc_attr( $key ) . '_tab active"';
						$n_header 	= str_replace( $search, $replace, $header );
						echo wp_kses_post( $n_header );
						call_user_func( $tab['callback'], $key, $tab ); 
					?>
					</div>
				</div>
			</div>
		<?php endforeach; ?>
	</div>

<?php endif; ?>