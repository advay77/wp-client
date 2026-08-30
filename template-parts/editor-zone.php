<?php
/**
 * Client-editable content zone.
 *
 * Renders whatever the client builds in the WordPress editor or Elementor.
 * Outputs nothing at all when the page content is empty, so designed layouts
 * are unaffected until the client actually adds something.
 *
 * @package Advay_Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$advay_zone_id = get_queried_object_id();
if ( ! $advay_zone_id ) {
	return;
}

$advay_zone_post = get_post( $advay_zone_id );
if ( ! $advay_zone_post || '' === trim( (string) $advay_zone_post->post_content ) ) {
	return;
}

/*
 * Pages that were originally built in Elementor still carry that old layout
 * in post_content. This theme deliberately replaces those designs, so never
 * re-render them here - it would duplicate the page and emit a second H1.
 * Content written in the block/classic editor still shows normally.
 */
if ( 'builder' === get_post_meta( $advay_zone_id, '_elementor_edit_mode', true ) ) {
	return;
}

$advay_zone_html = apply_filters( 'the_content', $advay_zone_post->post_content );
if ( '' === trim( wp_strip_all_tags( $advay_zone_html ) ) && false === strpos( $advay_zone_html, '<img' ) ) {
	return;
}
?>
<section class="editor-zone">
	<div class="container"><?php echo $advay_zone_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
</section>
