<?php
/**
 * Success stories mega — lifestyle photo cards with brand names.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$stories = advay_success_story_nav_cards();
?>
<div class="mega-panel mega-stories" role="region" aria-label="<?php esc_attr_e( 'Success stories', 'advay-theme' ); ?>">
	<div class="stories-mega-cards">
		<?php foreach ( $stories as $story ) : ?>
			<a class="st-card" href="<?php echo esc_url( advay_success_story_url( $story['slug'] ) ); ?>">
				<img src="<?php echo esc_url( $story['src'] ); ?>" alt="<?php echo esc_attr( $story['alt'] ); ?>" loading="lazy" decoding="async">
				<span class="st-overlay">
					<span class="st-brand"><?php echo esc_html( $story['brand'] ); ?></span>
					<span class="st-more"><?php esc_html_e( 'Read More', 'advay-theme' ); ?></span>
				</span>
			</a>
		<?php endforeach; ?>
	</div>
</div>
