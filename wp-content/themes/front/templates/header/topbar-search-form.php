<?php
/**
 * Search form in Search Push Top
 *
 * @package front
 */

do_action( 'pre_get_search_form' );

ob_start();
$blog_name   = get_bloginfo( 'name' );
$placeholder = sprintf( esc_html__( 'Search %s', 'front' ), $blog_name );
$form_size   = isset( $topbar_search_form_size ) ? ' ' . $topbar_search_form_size : '';
?>
<form role="search" method="get" class="js-focus-state input-group search-form<?php echo esc_attr( $form_size ); ?>" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <input type="search" class="form-control" placeholder="<?php echo esc_attr( $placeholder ); ?>" aria-label="<?php echo esc_attr( $placeholder ); ?>"  value="<?php echo esc_attr( get_search_query() ); ?>" name="s">
    <div class="input-group-append">
        <button type="submit" class="btn btn-primary"><?php echo esc_html__( 'Search', 'front' ); ?></button>
    </div>
</form>
<?php
$form   = ob_get_clean();
$result = apply_filters( 'get_search_form', $form );
printf( $result );