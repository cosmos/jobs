<?php
/**
 * Top Bar Template
 *
 * @package Front
 */
?>
<?php if ( apply_filters( 'front_enable_topbar', true ) ): ?>
<div class="container u-header__hide-content pt-2">
    <div class="d-flex align-items-center">

        <?php do_action( 'front_topbar_left' ); ?>

        <div class="ml-auto">
            <?php do_action( 'front_topbar_right' ); ?>
        </div>

        <ul class="list-inline ml-2 mb-0">
            <?php do_action( 'front_topbar_icons' ); ?>
        </ul>
    </div>
</div>
<?php endif; ?>