<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$stages = advay_inventory_journey_stages();
$total  = count( $stages );
?>
<section class="ij-section" id="services" data-inventory-journey aria-labelledby="ij-heading">
	<header class="ij-intro container">
		<p class="eyebrow"><?php esc_html_e( 'Services', 'advay-theme' ); ?></p>
		<h2 id="ij-heading"><?php esc_html_e( 'Follow the journey of your inventory.', 'advay-theme' ); ?></h2>
		<p><?php esc_html_e( 'Scroll through one continuous warehouse operation — from the moment your product arrives until it returns.', 'advay-theme' ); ?></p>
	</header>

	<div class="ij-pin-wrap">
		<div class="ij-pin" data-ij-pin>
			<div class="ij-canvas">
				<div class="ij-visual" data-ij-visual>
					<?php foreach ( $stages as $i => $stage ) : ?>
						<figure class="ij-layer" data-ij-layer="<?php echo (int) $i; ?>" aria-hidden="true">
							<?php if ( ! empty( $stage['video'] ) ) : ?>
								<video class="ij-media" data-ij-video muted playsinline preload="metadata" tabindex="-1">
									<source src="<?php echo esc_url( advay_asset_uri( $stage['video'] ) ); ?>" type="video/mp4">
								</video>
							<?php else : ?>
								<img
									class="ij-media"
									src="<?php echo esc_url( advay_asset_uri( $stage['image'] ) ); ?>"
									alt=""
									loading="<?php echo 0 === $i ? 'eager' : 'lazy'; ?>"
									decoding="async"
								>
							<?php endif; ?>
						</figure>
					<?php endforeach; ?>

					<div class="ij-protagonist" data-ij-protagonist aria-hidden="true">
						<div class="ij-pallet">
							<span class="ij-pallet-face ij-pallet-top"></span>
							<span class="ij-pallet-face ij-pallet-front"></span>
							<span class="ij-pallet-face ij-pallet-side"></span>
						</div>
					</div>

					<div class="ij-vignette" aria-hidden="true"></div>
				</div>

				<div class="ij-editorial">
					<?php foreach ( $stages as $i => $stage ) : ?>
						<article
							class="ij-copy"
							data-ij-copy="<?php echo (int) $i; ?>"
							id="<?php echo esc_attr( $stage['id'] ); ?>"
							<?php echo 0 === $i ? '' : 'aria-hidden="true"'; ?>
						>
							<p class="ij-stage-meta">
								<span class="ij-stage-num"><?php echo esc_html( $stage['num'] ); ?></span>
								<span class="ij-stage-total">/ <?php echo esc_html( sprintf( '%02d', $total ) ); ?></span>
							</p>
							<h3 class="ij-stage-name"><?php echo esc_html( $stage['name'] ); ?></h3>
							<p class="ij-tagline"><?php echo esc_html( $stage['tagline'] ); ?></p>
							<p class="ij-desc"><?php echo esc_html( $stage['copy'] ); ?></p>
						</article>
					<?php endforeach; ?>
				</div>

				<nav class="ij-progress" aria-label="<?php esc_attr_e( 'Inventory journey progress', 'advay-theme' ); ?>">
					<?php foreach ( $stages as $i => $stage ) : ?>
						<button
							type="button"
							class="ij-progress-step<?php echo 0 === $i ? ' is-active' : ''; ?>"
							data-ij-step="<?php echo (int) $i; ?>"
							aria-label="<?php echo esc_attr( sprintf( __( 'Stage %1$s: %2$s', 'advay-theme' ), $stage['num'], $stage['name'] ) ); ?>"
							aria-current="<?php echo 0 === $i ? 'step' : 'false'; ?>"
						>
							<span class="ij-progress-num"><?php echo esc_html( $stage['num'] ); ?></span>
							<?php if ( $i < $total - 1 ) : ?>
								<span class="ij-progress-line" aria-hidden="true"></span>
							<?php endif; ?>
						</button>
					<?php endforeach; ?>
				</nav>

				<div class="ij-rail" aria-hidden="true">
					<?php foreach ( $stages as $i => $stage ) : ?>
						<span class="ij-rail-label<?php echo 0 === $i ? ' is-active' : ''; ?>" data-ij-rail="<?php echo (int) $i; ?>">
							<?php echo esc_html( $stage['rail'] ); ?>
						</span>
						<?php if ( $i < $total - 1 ) : ?>
							<span class="ij-rail-arrow" aria-hidden="true">→</span>
						<?php endif; ?>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>

	<div class="ij-outro container">
		<p class="ij-outro-rail"><?php esc_html_e( 'ARRIVE → INSPECT → PREP → TRANSFORM → SHIP → RETURN', 'advay-theme' ); ?></p>
		<h2 class="ij-outro-heading">
			<?php esc_html_e( 'One partner.', 'advay-theme' ); ?><br>
			<?php esc_html_e( 'Every step of the', 'advay-theme' ); ?><br>
			<?php esc_html_e( 'inventory journey.', 'advay-theme' ); ?>
		</h2>
		<a class="button button-primary ij-outro-cta" href="<?php echo esc_url( advay_contact_page_url() ); ?>">
			<?php esc_html_e( 'Talk to ElitePrep', 'advay-theme' ); ?> →
		</a>
	</div>

	<div class="ij-fallback" aria-label="<?php esc_attr_e( 'Inventory journey overview', 'advay-theme' ); ?>">
		<?php foreach ( $stages as $i => $stage ) : ?>
			<article class="ij-fallback-item" id="<?php echo esc_attr( $stage['id'] ); ?>-static">
				<div class="ij-fallback-media">
					<img
						src="<?php echo esc_url( advay_asset_uri( $stage['image'] ) ); ?>"
						alt=""
						loading="lazy"
						decoding="async"
					>
				</div>
				<div class="ij-fallback-copy">
					<p class="ij-stage-meta">
						<span class="ij-stage-num"><?php echo esc_html( $stage['num'] ); ?></span>
						<span class="ij-stage-total">/ <?php echo esc_html( sprintf( '%02d', $total ) ); ?></span>
					</p>
					<h3 class="ij-stage-name"><?php echo esc_html( $stage['name'] ); ?></h3>
					<p class="ij-tagline"><?php echo esc_html( $stage['tagline'] ); ?></p>
					<p class="ij-desc"><?php echo esc_html( $stage['copy'] ); ?></p>
				</div>
			</article>
		<?php endforeach; ?>
	</div>
</section>
