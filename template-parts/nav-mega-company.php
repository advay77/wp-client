<?php
/**
 * Company mega panel — four image cards.
 *
 * Card links point only to real destinations (on-page anchors and the blog
 * archive); no invented /careers/ or /newsroom/ URLs are generated.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$home = trailingslashit( home_url( '/' ) );

$cards = array(
	array(
		'title' => __( 'Our Story', 'advay-theme' ),
		'desc'  => __( 'Learn how ElitePrep Center has grown over the years.', 'advay-theme' ),
		'url'   => $home . '#company',
		'img'   => advay_asset_uri( 'images/company-cards.png' ),
	),
	array(
		'title' => __( 'Our Team', 'advay-theme' ),
		'desc'  => __( 'Meet the team running the warehouse floor.', 'advay-theme' ),
		'url'   => $home . '#leadership',
		'img'   => advay_asset_uri( 'images/client-success.jpg' ),
	),
);
?>
<div class="mega-panel mega-company" role="region" aria-label="<?php esc_attr_e( 'Company', 'advay-theme' ); ?>">
	<?php foreach ( $cards as $card ) : ?>
		<a class="co-card" href="<?php echo esc_url( $card['url'] ); ?>">
			<span class="co-top">
				<strong><?php echo esc_html( $card['title'] ); ?></strong>
				<span class="co-arrow" aria-hidden="true"></span>
			</span>
			<em class="co-desc"><?php echo esc_html( $card['desc'] ); ?></em>
			<span class="co-thumb" style="background-image:url('<?php echo esc_url( $card['img'] ); ?>')"></span>
		</a>
	<?php endforeach; ?>
</div>
