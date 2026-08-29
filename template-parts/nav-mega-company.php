<?php
/**
 * Company mega panel — image cards with thematic placeholders.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$cards = advay_mega_company_cards();
?>
<div class="mega-panel mega-company" role="region" aria-label="<?php esc_attr_e( 'Company', 'advay-theme' ); ?>">
	<?php foreach ( $cards as $card ) : ?>
		<a class="co-card" href="<?php echo esc_url( $card['url'] ); ?>">
			<span class="co-top">
				<strong><?php echo esc_html( $card['title'] ); ?></strong>
				<span class="co-arrow" aria-hidden="true"></span>
			</span>
			<em class="co-desc"><?php echo esc_html( $card['desc'] ); ?></em>
			<span class="co-thumb">
				<img src="<?php echo esc_url( $card['img'] ); ?>" alt="<?php echo esc_attr( $card['alt'] ); ?>" loading="lazy" decoding="async">
			</span>
		</a>
	<?php endforeach; ?>
</div>
