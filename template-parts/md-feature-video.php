<?php
/**
 * Managing Director feature video (shared embed).
 *
 * @package Advay_Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$wrapper_class = ! empty( $args['wrapper_class'] ) ? $args['wrapper_class'] : 'md-feature-video';
$video_class   = ! empty( $args['video_class'] ) ? $args['video_class'] : '';
$video_url     = ! empty( $args['video_url'] ) ? $args['video_url'] : advay_md_feature_video_url();
$poster        = ! empty( $args['poster'] ) ? $args['poster'] : '';
$aria_label    = ! empty( $args['aria_label'] ) ? $args['aria_label'] : __( 'Managing Director video message', 'advay-theme' );
?>
<div class="<?php echo esc_attr( $wrapper_class ); ?>">
	<video
		class="<?php echo esc_attr( $video_class ); ?>"
		autoplay
		muted
		loop
		playsinline
		webkit-playsinline
		preload="metadata"
		aria-label="<?php echo esc_attr( $aria_label ); ?>"
		<?php echo $poster ? 'poster="' . esc_url( $poster ) . '"' : ''; ?>
	>
		<source src="<?php echo esc_url( $video_url ); ?>" type="video/mp4">
	</video>
	<button type="button" class="md-video-mute" aria-pressed="false" aria-label="<?php esc_attr_e( 'Turn sound on', 'advay-theme' ); ?>"></button>
</div>
