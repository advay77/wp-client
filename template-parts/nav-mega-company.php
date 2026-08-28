<?php
/**
 * Company mega panel — image cards with thematic placeholders.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$home = trailingslashit( home_url( '/' ) );

$cards = array(
	array(
		'title' => __( 'Our Story', 'advay-theme' ),
		'desc'  => __( 'Learn how ElitePrep Center has grown over the years.', 'advay-theme' ),
		'url'   => advay_our_story_url(),
		'img'   => 'https://images.unsplash.com/photo-1581092160562-40aa08e78837?auto=format&fit=crop&w=900&q=80',
		'alt'   => __( 'Warehouse trucks and inbound dock operations', 'advay-theme' ),
	),
	array(
		'title' => __( 'Our Managing Director', 'advay-theme' ),
		'desc'  => __( 'Meet the man behind EPC and learn what drives the business forward.', 'advay-theme' ),
		'url'   => advay_managing_director_url(),
		'img'   => advay_theme_image(
			'images/client-success.jpg',
			'https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&w=900&q=80'
		),
		'alt'   => __( 'Managing Director at ElitePrep Center', 'advay-theme' ),
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
			<span class="co-thumb">
				<img src="<?php echo esc_url( $card['img'] ); ?>" alt="<?php echo esc_attr( $card['alt'] ); ?>" loading="lazy" decoding="async">
			</span>
		</a>
	<?php endforeach; ?>
</div>
