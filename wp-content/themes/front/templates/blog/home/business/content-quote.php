<?php
/**
 * Template used to display Home Blog Business Quote post
 *
 * @package front
 */
$content = get_the_content();

preg_match( '/<cite>(.*?)<\/cite>/s', $content, $matches );

$cite = '';
$cite_quote = '';

if ( isset( $matches[1] ) ) {
    $cite = $matches[1];
}

$content = str_replace( $cite, '', wp_strip_all_tags( $content ) );

?>
<article class="card bg-primary text-center position-relative transition-3d-hover mt-1">
    <a class="card-body py-9 px-7" href="<?php echo esc_url( get_permalink() ); ?>">
        <!-- SVG Quote -->
        <figure class="mx-auto mb-3">
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="40px" height="40px"
            viewBox="0 0 8 8" style="enable-background:new 0 0 8 8;" xml:space="preserve">
            <path class="fill-white" opacity=".7" d="M3,1.3C2,1.7,1.2,2.7,1.2,3.6c0,0.2,0,0.4,0.1,0.5c0.2-0.2,0.5-0.3,0.9-0.3c0.8,0,1.5,0.6,1.5,1.5c0,0.9-0.7,1.5-1.5,1.5
            C1.4,6.9,1,6.6,0.7,6.1C0.4,5.6,0.3,4.9,0.3,4.5c0-1.6,0.8-2.9,2.5-3.7L3,1.3z M7.1,1.3c-1,0.4-1.8,1.4-1.8,2.3
            c0,0.2,0,0.4,0.1,0.5c0.2-0.2,0.5-0.3,0.9-0.3c0.8,0,1.5,0.6,1.5,1.5c0,0.9-0.7,1.5-1.5,1.5c-0.7,0-1.1-0.3-1.4-0.8
            C4.4,5.6,4.4,4.9,4.4,4.5c0-1.6,0.8-2.9,2.5-3.7L7.1,1.3z"/>
        </svg>
    </figure>
    <!-- End SVG Quote -->

    <h3 class="h4 text-white mb-4"><?php echo esc_html( $content ); ?></h3>
    <?php if ( ! empty( $cite ) ) : ?>
        <small class="d-block text-white-70"><?php echo esc_html( $cite ); ?></small>
    <?php endif; ?>
</a>
</article>