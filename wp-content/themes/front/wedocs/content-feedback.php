<?php global $post; ?>
<!-- Resolved -->
<div class="text-center border-top border-bottom my-6 py-6 wedocs-feedback-wrap wedocs-hide-print">
    <?php
    $positive = (int) get_post_meta( $post->ID, 'positive', true );
    $negative = (int) get_post_meta( $post->ID, 'negative', true );

    $positive_title = $positive ? sprintf( _n( '%d person found this useful', '%d persons found this useful', $positive, 'front' ), number_format_i18n( $positive ) ) : esc_html__( 'No votes yet', 'front' );
    $negative_title = $negative ? sprintf( _n( '%d person found this not useful', '%d persons found this not useful', $negative, 'front' ), number_format_i18n( $negative ) ) : esc_html__( 'No votes yet', 'front' );
    ?>

    <h4 class="h6 mb-4"><span class="far fa-paper-plane mr-1"></span><?php esc_html_e( 'Was this article helpful to you?', 'front' ); ?></h4>

    <span class="vote-link-wrap">
        <a href="#" class="wedocs-tip positive btn btn-sm btn-primary btn-wide mb-2 mx-1" data-id="<?php the_ID(); ?>" data-type="positive" title="<?php echo esc_attr( $positive_title ); ?>">
            <?php esc_html_e( 'Yes', 'front' ); ?>

            <?php if (  0 && $positive ) { ?>
                <span class="count badge badge-light"><?php echo number_format_i18n( $positive ); ?></span>
            <?php } ?>
        </a>
        <a href="#" class="wedocs-tip negative btn btn-sm btn-soft-primary btn-wide mb-2 mx-1" data-id="<?php the_ID(); ?>" data-type="negative" title="<?php echo esc_attr( $negative_title ); ?>">
            <?php esc_html_e( 'No', 'front' ); ?>

            <?php if ( 0 && $negative ) { ?>
                <span class="count badge badge-light"><?php echo number_format_i18n( $negative ); ?></span>
            <?php } ?>
        </a>
    </span>
</div>
<!-- End Resolved -->