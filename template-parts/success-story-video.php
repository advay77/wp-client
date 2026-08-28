<?php
/**
 * Inline video player with play overlay.
 *
 * @package Advay_Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$video = isset( $args['video'] ) ? $args['video'] : '';
$label = isset( $args['label'] ) ? $args['label'] : __( 'Success story video', 'advay-theme' );

if ( ! $video ) {
	return;
}
?>
<div class="ss-video" data-ss-video>
	<video preload="metadata" playsinline>
		<source src="<?php echo esc_url( $video ); ?>" type="video/mp4">
	</video>
	<button type="button" class="ss-video-play" aria-label="<?php echo esc_attr( $label ); ?>">
		<span aria-hidden="true"></span>
	</button>
</div>
