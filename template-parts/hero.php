<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$channels = advay_hero_channels();
$first    = reset( $channels );
?>
<section class="hero" aria-labelledby="hero-heading">
	<div class="hero-media" data-hero-media>
		<video
			id="hero-video"
			class="hero-video"
			autoplay
			muted
			loop
			playsinline
			preload="metadata"
		>
			<source src="<?php echo esc_url( $first['video'] ); ?>" type="video/mp4">
		</video>
		<div class="hero-overlay" aria-hidden="true"></div>
	</div>

	<div class="container hero-inner">
		<div class="hero-copy">
			<h1 id="hero-heading">
				<?php esc_html_e( 'Win on every Marketplace.', 'advay-theme' ); ?>
			</h1>
			<p class="lede">
				<?php esc_html_e( 'Grow listings, stay in stock, and expand on Amazon, Walmart, and TikTok Shop with a prep partner built for marketplace sellers.', 'advay-theme' ); ?>
			</p>
			<div class="hero-actions">
				<a class="button button-light" href="<?php echo esc_url( advay_contact_url() ); ?>">
					<?php esc_html_e( 'Grow with ElitePrep', 'advay-theme' ); ?>
					<span class="btn-arrow" aria-hidden="true"></span>
				</a>
				<a class="button button-ghost-light" href="<?php echo esc_url( home_url( '/#services' ) ); ?>">
					<?php esc_html_e( 'Learn more', 'advay-theme' ); ?>
					<span class="btn-arrow" aria-hidden="true"></span>
				</a>
			</div>
		</div>

		<div class="hero-tabs" role="tablist" aria-label="<?php esc_attr_e( 'Marketplace videos', 'advay-theme' ); ?>">
			<?php
			$i = 0;
			foreach ( $channels as $channel ) :
				$selected = 0 === $i ? 'true' : 'false';
				?>
				<button
					type="button"
					class="hero-tab"
					role="tab"
					id="tab-<?php echo esc_attr( $channel['id'] ); ?>"
					aria-selected="<?php echo esc_attr( $selected ); ?>"
					data-video="<?php echo esc_url( $channel['video'] ); ?>"
				>
					<span class="tab-logo<?php echo empty( $channel['logo'] ) ? ' is-wordmark' : ''; ?>">
						<?php if ( ! empty( $channel['logo'] ) ) : ?>
							<img src="<?php echo esc_url( $channel['logo'] ); ?>" alt="" width="72" height="24">
						<?php else : ?>
							<?php echo esc_html( isset( $channel['wordmark'] ) ? $channel['wordmark'] : $channel['label'] ); ?>
						<?php endif; ?>
					</span>
					<span class="tab-chevron" aria-hidden="true"></span>
					<span class="tab-label"><?php echo esc_html( $channel['label'] ); ?></span>
				</button>
				<?php
				$i++;
			endforeach;
			?>
		</div>
	</div>
</section>
