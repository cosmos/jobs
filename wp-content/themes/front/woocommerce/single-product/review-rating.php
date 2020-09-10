<?php
/**
 * The template to display the reviewers star rating in reviews
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/review-rating.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $comment;
$rating = intval( get_comment_meta( $comment->comment_ID, 'rating', true ) );
?>
<div class="d-flex justify-content-between align-items-center text-secondary font-size-1 mb-3">
	<div class="text-warning">
		<?php if ( $rating && wc_review_ratings_enabled() ) { ?>
			<small class="<?php echo esc_attr( ( $rating >= 1 ) ? 'fas fa-star' : 'text-muted far fa-star' ); ?>"></small>
		    <small class="<?php echo esc_attr( ( $rating >= 2 ) ? 'fas fa-star' : 'text-muted far fa-star' ); ?>"></small>
		    <small class="<?php echo esc_attr( ( $rating >= 3 ) ? 'fas fa-star' : 'text-muted far fa-star' ); ?>"></small>
		    <small class="<?php echo esc_attr( ( $rating >= 4 ) ? 'fas fa-star' : 'text-muted far fa-star' ); ?>"></small>
		    <small class="<?php echo esc_attr( ( $rating >= 5 ) ? 'fas fa-star' : 'text-muted far fa-star' ); ?>"></small>
		<?php } ?>
	</div>

<time class="woocommerce-review__published-date" datetime="<?php echo esc_attr( get_comment_date( 'c' ) ); ?>"><?php echo esc_html( get_comment_date( wc_date_format() ) ); ?></time>
</div>