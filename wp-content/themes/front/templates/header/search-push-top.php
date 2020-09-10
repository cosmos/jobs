<?php
/**
 * Search Push Top
 *
 * @package Front
 */
?>
<!-- Search -->
<div id="searchPushTop" class="u-search-push-top">
    <div class="container position-relative">
        <div class="u-search-push-top__content">
            <!-- Close Button -->
            <button type="button" class="close u-search-push-top__close-btn"
                aria-haspopup="true"
                aria-expanded="false"
                aria-controls="searchPushTop"
                data-unfold-type="jquery-slide"
                data-unfold-target="#searchPushTop">
                <span aria-hidden="true">&times;</span>
            </button>
            <!-- End Close Button -->

            <?php
                get_template_part( 'templates/header/topbar-search', 'form' );

                $static_content_id = apply_filters( 'front_search_push_top_static_content_id', '' );
                if( front_is_mas_static_content_activated() && ! empty( $static_content_id ) ) {
                    echo do_shortcode( '[mas_static_content id=' . $static_content_id . ' wrap=0]' );
                }
            ?>
        </div>
    </div>
</div>
<!-- End Search -->