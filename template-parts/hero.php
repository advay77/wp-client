<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$channels = advay_hero_channels();
$first    = reset( $channels );
?>
<section class="hero" aria-labelledby="hero-heading" data-hero>
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
		<div class="hero-copy" data-hero-copy>
			<h1 id="hero-heading"><?php echo esc_html( $first['headline'] ); ?></h1>
			<p class="lede" data-hero-lede><?php echo esc_html( $first['body'] ); ?></p>
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

		<div class="hero-tabs" role="tablist" aria-label="<?php esc_attr_e( 'Marketplace channels', 'advay-theme' ); ?>">
			<?php
			$i = 0;
			foreach ( $channels as $channel ) :
				$selected = 0 === $i;
				?>
				<button
					type="button"
					class="hero-tab<?php echo $selected ? ' is-active' : ''; ?>"
					role="tab"
					id="tab-<?php echo esc_attr( $channel['id'] ); ?>"
					aria-selected="<?php echo $selected ? 'true' : 'false'; ?>"
					data-hero-tab
					data-video="<?php echo esc_url( $channel['video'] ); ?>"
					data-headline="<?php echo esc_attr( $channel['headline'] ); ?>"
					data-body="<?php echo esc_attr( $channel['body'] ); ?>"
				>
					<span class="tab-top">
						<span class="tab-logo<?php echo empty( $channel['logo'] ) ? ' is-wordmark' : ''; ?>">
							<?php if ( ! empty( $channel['logo'] ) ) : ?>
								<img src="<?php echo esc_url( $channel['logo'] ); ?>" alt="" width="72" height="24">
							<?php else : ?>
								<?php echo esc_html( isset( $channel['wordmark'] ) ? $channel['wordmark'] : $channel['label'] ); ?>
							<?php endif; ?>
						</span>
						<span class="tab-chevron" aria-hidden="true"></span>
					</span>
					<span class="tab-label"><?php echo esc_html( $channel['label'] ); ?></span>
				</button>
				<?php
				$i++;
			endforeach;
			?>
		</div>
	</div>
</section>
