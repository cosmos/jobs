<?php
/**
 * Display single product advanced reviews (comments)
 *
 */
global $product;

$product_id 		= $product->get_id();
$review_count 		= $product->get_review_count();
$avg_rating_number 	= number_format( $product->get_average_rating(), 1 );
$rating_counts 		= Front_WC_Helper::get_ratings_counts( $product );

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! comments_open() ) {
	return;
}

?>
<div id="reviewSection" class="front-advanced-reviews">
	<div class="advanced-review row space-bottom-2 space-bottom-lg-3">
		<div class="col-lg-4 mb-7 mb-lg-0">
			<div class="border-bottom pb-4 mb-4">
				<div class="card border-0 bg-primary text-white p-4 mb-3">
					<div class="d-flex justify-content-center align-items-center">
						<span class="display-4 font-weight-semi-bold"><?php echo esc_html( $avg_rating_number ); ?></span>
							<div class="ml-3">
								<div class="star-rating" title="<?php printf( esc_attr__( 'Rated %s out of 5', 'front' ), $avg_rating_number ); ?>">
									<small class="<?php echo esc_attr( ( $avg_rating_number >= 1 ) ? 'fas fa-star' : 'far fa-star' ); ?>"></small>
								    <small class="<?php echo esc_attr( ( $avg_rating_number >= 2 ) ? 'fas fa-star' : 'far fa-star' ); ?>"></small>
								    <small class="<?php echo esc_attr( ( $avg_rating_number >= 3 ) ? 'fas fa-star' : 'far fa-star' ); ?>"></small>
								    <small class="<?php echo esc_attr( ( $avg_rating_number >= 4 ) ? 'fas fa-star' : 'far fa-star' ); ?>"></small>
								    <small class="<?php echo esc_attr( ( $avg_rating_number >= 5 ) ? 'fas fa-star' : 'far fa-star' ); ?>"></small>
								</div>
								<div class="font-weight-normal"><?php echo esc_html( sprintf( _n( '%s review', '%s reviews', $review_count, 'front' ), $review_count ) ); ?></div>
							</div>
					</div>
				</div>
				<h3 class="h4"><?php echo esc_html__('Rating breakdown', 'front'); ?></h3>
				<ul class="list-unstyled">
					<?php for( $rating = 5; $rating > 0; $rating-- ) : ?>
					<li class="py-1">
						<a class="row align-items-center mx-gutters-2 font-size-1">
							<div class="col-3">
								<span class="text-dark"><?php echo sprintf( esc_html__( '%s stars', 'front' ), $rating ); ?></span>
							</div>
							<?php
								$rating_percentage = 0;
								if ( isset( $rating_counts[$rating] ) && $review_count > 0 ) {
									$rating_percentage = (round( $rating_counts[$rating] / $review_count, 2 ) * 100 );
								}
							?>

							<div class="col-7">
		                    	<div class="js-hr-progress progress" style="height: 4px;">
								  	<div class="js-hr-progress-bar progress-bar" role="progressbar" style="width: <?php echo esc_attr( $rating_percentage ); ?>%;"></div>
								</div>
			                 </div>
							<?php if ( isset( $rating_counts[$rating] ) ) : ?>
							<div class="col-2 text-right"><span class="text-secondary"><?php echo esc_html( $rating_counts[$rating] ); ?></span></div>
							<?php else : ?>
							<div class="col-2 text-right zero"><span class="text-secondary">0</span></div>
							<?php endif; ?>
						</a>
					</li>
					<?php endfor; ?>
				</ul>
			</div>

			<?php if ( $avg_rating_number > 0 ) { ?>
				<span class="d-block display-4 font-weight-medium"><?php echo esc_attr( ($avg_rating_number * 20) ); ?>%</span>
	          	<p class="small"><?php echo esc_html('of customers recommend this product', 'front'); ?></p>
	      	<?php } ?>
		</div>

		<div class="col-lg-8">
			<div class="pl-lg-4">

				<div id="reviews">
					<?php if ( have_comments() ) : ?>

						<ol class="commentlist list-unstyled">
							<?php wp_list_comments( apply_filters( 'woocommerce_product_review_list_args', array( 'callback' => 'woocommerce_comments' ) ) ); ?>
						</ol>

						<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
							echo '<nav class="woocommerce-pagination">';
							paginate_comments_links( apply_filters( 'woocommerce_comment_pagination_args', array(
								'prev_text' => '&larr;',
								'next_text' => '&rarr;',
								'type'      => 'list',
							) ) );
							echo '</nav>';
						endif; ?>

					<?php else : ?>

						<p class="woocommerce-noreviews border-bottom pb-4 mb-4"><?php esc_html_e( 'There are no reviews yet.', 'front' ); ?></p>

					<?php endif; ?>

					<?php if ( get_option( 'woocommerce_review_rating_verification_required' ) === 'no' || wc_customer_bought_product( '', get_current_user_id(), $product_id ) ) : ?>
						<div class="d-sm-flex justify-content-sm-end">
			              	<a href="#reviewModal" class="btn btn-primary btn-pill transition-3d-hover px-5 mb-2" data-modal-target="#reviewModal"><?php echo esc_html__( 'Write a review', 'front' ); ?></a>
			            </div>
			        <?php else : ?>
			        	<div class="alert alert-info">
							<p class="woocommerce-verification-required font-size-sm mb-0"><?php esc_html_e( 'Only logged in customers who have purchased this product may leave a review.', 'front' ); ?></p>
								
						</div>

				<?php endif; ?>
				</div>

			</div>
		</div>
	</div>

	<?php if ( get_option( 'woocommerce_review_rating_verification_required' ) === 'no' || wc_customer_bought_product( '', get_current_user_id(), $product_id ) ) : ?>

		<div id="reviewModal" class="js-modal-window u-modal-window rounded" style="width: 500px;">
			<div class="card border-0">

				<header class="card-header bg-light py-3 px-5">
		          	<div class="d-flex justify-content-between align-items-center">
		            	<h3 class="h6 mb-0"><?php esc_html_e( 'Add a review', 'front' ) ?></h3>

		            	<button type="button" class="close" aria-label="Close" onclick="Custombox.modal.close();">
		              		<span aria-hidden="true">&times;</span>
		            	</button>
		          	</div>
		        </header>

		        <div class="card-body p-5">
					<?php
						$commenter = wp_get_current_commenter();

						$comment_form = array(
							'title_reply'          => have_comments() ? esc_html__( 'Add a review', 'front' ) : sprintf( esc_html__( 'Be the first to review &ldquo;%s&rdquo;', 'front' ), get_the_title() ),
							'title_reply_to'       => esc_html__( 'Leave a Reply to %s', 'front' ),
							'comment_notes_before' => '',
							'comment_notes_after'  => '',
							'fields'               => array(
								'author' => '<p class="comment-form-author mb-4">' . '<label for="author" class="form-label">' . esc_html__( 'Name', 'front' ) . ' <span class="required">*</span></label> ' .
								            '<input id="author" class="form-control" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" aria-required="true" /></p>',
								'email'  => '<p class="comment-form-email mb-4"><label for="email" class="form-label">' . esc_html__( 'Email', 'front' ) . ' <span class="required">*</span></label> ' .
								            '<input id="email" name="email" class="form-control" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30" aria-required="true" /></p>',
							),
							'label_submit'  => esc_html__( 'Save', 'front' ),
							'logged_in_as'  => '',
							'comment_field' => ''
						);

						if ( $account_page_url = wc_get_page_permalink( 'myaccount' ) ) {
							$comment_form['must_log_in'] = wp_kses_post( '<p class="must-log-in mb-4">' .  sprintf( __( 'You must be <a href="%s">logged in</a> to post a review.', 'front' ), esc_url( $account_page_url ) ) . '</p>' );
						}

						if ( get_option( 'woocommerce_enable_review_rating' ) === 'yes' ) {
							$comment_form['comment_field'] = '<p class="comment-form-rating mb-4"><label for="rating" class="form-label">' . esc_html__( 'Your Rating', 'front' ) .'</label><select name="rating" id="rating">
								<option value="">' . esc_html__( 'Rate&hellip;', 'front' ) . '</option>
								<option value="5">' . esc_html__( 'Perfect', 'front' ) . '</option>
								<option value="4">' . esc_html__( 'Good', 'front' ) . '</option>
								<option value="3">' . esc_html__( 'Average', 'front' ) . '</option>
								<option value="2">' . esc_html__( 'Not that bad', 'front' ) . '</option>
								<option value="1">' . esc_html__( 'Very Poor', 'front' ) . '</option>
							</select></p>';
						}

						$comment_form['comment_field'] .= '<p class="comment-form-comment mb-4"><label for="comment" class="form-label">' . esc_html__( 'Your Review', 'front' ) . '</label><textarea class="form-control" id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></p>';

						comment_form( apply_filters( 'woocommerce_product_review_comment_form_args', $comment_form ) );
					?>
				</div>
			</div>
		</div>

		<?php endif; ?>

	<div class="clear"></div>
</div>
