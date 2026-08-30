<?php
/**
 * Success story page markup (shared by CPT single + legacy rewrite template).
 *
 * Expects $story array from advay_get_success_story().
 *
 * @package Advay_Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( empty( $story ) || ! is_array( $story ) ) {
	return;
}

$video_url          = isset( $story['video'] ) ? $story['video'] : '';
$hero_image         = isset( $story['hero_image'] ) ? $story['hero_image'] : '';
$before_list        = isset( $story['before'] ) ? $story['before'] : array();
$transform_before   = isset( $story['transform_before'] ) ? $story['transform_before'] : $before_list;
$transform_after    = isset( $story['transform_after'] ) ? $story['transform_after'] : ( isset( $story['after'] ) ? $story['after'] : array() );
$strategies         = isset( $story['strategies'] ) ? $story['strategies'] : array();
$results            = isset( $story['results'] ) ? $story['results'] : array();
$before_heading     = ! empty( $story['before_heading'] ) ? $story['before_heading'] : __( 'Before working together', 'advay-theme' );
$strategies_heading = ! empty( $story['strategies_heading'] ) ? $story['strategies_heading'] : __( 'What we changed', 'advay-theme' );
$founder_image      = ! empty( $story['founder_image'] ) ? $story['founder_image'] : advay_asset_uri( 'images/md-portrait.jpg' );
$founder_caption    = ! empty( $story['founder_caption'] ) ? $story['founder_caption'] : __( 'Managing Director, Odi Ikpe', 'advay-theme' );
?>

<main id="main-content" class="ss-page">
	<section class="ss-hero" aria-labelledby="ss-hero-heading">
		<div class="container ss-hero-grid">
			<div class="ss-hero-copy">
				<p class="ss-tag"><?php esc_html_e( 'Success story', 'advay-theme' ); ?></p>
				<p class="ss-brand"><?php echo esc_html( $story['brand'] ); ?></p>
				<h1 id="ss-hero-heading">
					<?php echo esc_html( $story['headline_prefix'] ); ?>
					<span class="ss-accent"><?php echo esc_html( $story['headline_highlight'] ); ?></span>
				</h1>
				<p class="ss-lead"><?php echo esc_html( $story['lead'] ); ?></p>
				<?php if ( $video_url ) : ?>
					<a class="ss-btn ss-btn--primary" href="#ss-hero-video">
						<?php esc_html_e( 'Watch their story', 'advay-theme' ); ?>
						<span class="ss-btn-play" aria-hidden="true"></span>
					</a>
				<?php endif; ?>
			</div>
			<div class="ss-hero-media" id="ss-hero-video">
				<?php if ( $video_url ) : ?>
					<?php
					get_template_part(
						'template-parts/success-story-video',
						null,
						array(
							'video' => $video_url,
							'label' => sprintf(
								/* translators: %s: brand name */
								__( '%s testimonial video', 'advay-theme' ),
								$story['brand']
							),
						)
					);
					?>
				<?php elseif ( $hero_image ) : ?>
					<figure class="ss-hero-photo">
						<img
							src="<?php echo esc_url( $hero_image ); ?>"
							alt="<?php echo esc_attr( $story['brand'] ); ?>"
							width="640"
							height="400"
							loading="eager"
							decoding="async"
						>
					</figure>
				<?php endif; ?>
			</div>
		</div>
	</section>

	<section class="ss-before" aria-labelledby="ss-before-heading">
		<div class="container">
			<div class="ss-before-panel">
				<div class="ss-before-col">
					<h2 id="ss-before-heading" class="ss-before-kicker">
						<span class="ss-before-kicker-icon" aria-hidden="true">
							<?php echo advay_home_hub_icon( 'warn-triangle', 18 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</span>
						<?php echo esc_html( $before_heading ); ?>
					</h2>
					<ul class="ss-list ss-list--before-panel">
						<?php foreach ( $before_list as $item ) : ?>
							<li><?php echo esc_html( $item ); ?></li>
						<?php endforeach; ?>
					</ul>
				</div>
				<div class="ss-before-divider" aria-hidden="true"></div>
				<blockquote class="ss-insight">
					<span class="ss-insight-icon" aria-hidden="true">
						<?php echo advay_home_hub_icon( 'insight-head', 34 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</span>
					<p>
						<?php echo esc_html( $story['insight_lead'] ); ?><strong><?php echo esc_html( $story['insight_bold'] ); ?></strong><?php echo esc_html( $story['insight_tail'] ); ?>
					</p>
				</blockquote>
			</div>
		</div>
	</section>

	<section class="ss-strategy" aria-labelledby="ss-strategy-heading">
		<div class="container">
			<h2 id="ss-strategy-heading" class="ss-section-title"><?php echo esc_html( $strategies_heading ); ?></h2>
			<div class="ss-strategy-grid<?php echo count( $strategies ) > 3 ? ' ss-strategy-grid--wide' : ''; ?>">
				<?php foreach ( $strategies as $index => $step ) : ?>
					<article class="ss-strategy-card">
						<span class="ss-strategy-icon" aria-hidden="true">
							<?php echo advay_home_hub_icon( $step['icon'], 26 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</span>
						<p class="ss-strategy-num"><?php echo esc_html( str_pad( (string) ( $index + 1 ), 2, '0', STR_PAD_LEFT ) ); ?></p>
						<h3><?php echo esc_html( $step['title'] ); ?></h3>
						<p class="ss-strategy-text"><?php echo esc_html( $step['text'] ); ?></p>
					</article>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<section class="ss-results" aria-labelledby="ss-results-heading">
		<div class="container">
			<h2 id="ss-results-heading" class="ss-section-title"><?php esc_html_e( 'The results', 'advay-theme' ); ?></h2>
			<ul class="ss-results-grid">
				<?php foreach ( $results as $stat ) : ?>
					<li>
						<span class="ss-results-icon" aria-hidden="true">
							<?php echo advay_home_hub_icon( $stat['icon'], 34 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</span>
						<strong><?php echo esc_html( $stat['value'] ); ?></strong>
						<span class="ss-results-label"><?php echo esc_html( $stat['label'] ); ?></span>
						<?php if ( ! empty( $stat['sublabel'] ) ) : ?>
							<span class="ss-results-sublabel"><?php echo esc_html( $stat['sublabel'] ); ?></span>
						<?php endif; ?>
					</li>
				<?php endforeach; ?>
			</ul>
			<p class="ss-results-summary"><?php echo esc_html( $story['results_summary'] ); ?></p>
		</div>
	</section>

	<section class="ss-quote" aria-labelledby="ss-quote-heading">
		<div class="container ss-quote-grid">
			<blockquote class="ss-quote-copy">
				<p id="ss-quote-heading"><?php echo advay_ss_format_quote( $story['quote'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped + allowlisted span in helper. ?></p>
				<footer>
					<strong><?php echo esc_html( $story['founder'] ); ?></strong>
					<span><?php echo esc_html( $story['founder_role'] ); ?></span>
				</footer>
			</blockquote>
			<div class="ss-quote-media">
				<figure class="ss-md-portrait">
					<img
						src="<?php echo esc_url( $founder_image ); ?>"
						alt="<?php echo esc_attr( $story['founder'] ); ?>"
						width="480"
						height="600"
						loading="lazy"
						decoding="async"
					>
					<figcaption class="ss-md-portrait-caption"><?php echo esc_html( $founder_caption ); ?></figcaption>
				</figure>
				<?php if ( $video_url ) : ?>
					<a class="ss-quote-link" href="#ss-hero-video">
						<span class="ss-link-play" aria-hidden="true"></span>
						<?php esc_html_e( 'Watch the full testimonial', 'advay-theme' ); ?>
					</a>
				<?php endif; ?>
			</div>
		</div>
	</section>

	<section class="ss-transform" aria-labelledby="ss-transform-heading">
		<div class="container">
			<h2 id="ss-transform-heading" class="ss-section-title"><?php esc_html_e( 'The transformation', 'advay-theme' ); ?></h2>
			<div class="ss-transform-wrap">
				<article class="ss-transform-box ss-transform-box--before">
					<h3>
						<span><?php esc_html_e( 'Before', 'advay-theme' ); ?></span>
						<span class="ss-transform-badge ss-transform-badge--before" aria-hidden="true"></span>
					</h3>
					<ul class="ss-list ss-list--before">
						<?php foreach ( $transform_before as $item ) : ?>
							<li><?php echo esc_html( $item ); ?></li>
						<?php endforeach; ?>
					</ul>
				</article>
				<span class="ss-transform-arrow" aria-hidden="true"></span>
				<article class="ss-transform-box ss-transform-box--after">
					<h3>
						<span><?php esc_html_e( 'After', 'advay-theme' ); ?></span>
						<span class="ss-transform-badge ss-transform-badge--after" aria-hidden="true"></span>
					</h3>
					<ul class="ss-list ss-list--after">
						<?php foreach ( $transform_after as $item ) : ?>
							<li><?php echo esc_html( $item ); ?></li>
						<?php endforeach; ?>
					</ul>
				</article>
			</div>
		</div>
	</section>

	<?php get_template_part( 'template-parts/editor-zone' ); ?>

	<section class="ss-cta">
		<div class="container ss-cta-inner">
			<h2><?php esc_html_e( 'Want a similar outcome for your business?', 'advay-theme' ); ?></h2>
			<p><?php esc_html_e( 'Get marketplace-ready prep, clear reporting, and a partner who knows your name.', 'advay-theme' ); ?></p>
			<a class="ss-btn ss-btn--cta" href="<?php echo esc_url( advay_onboarding_url() ); ?>">
				<?php esc_html_e( 'Let\'s start a conversation', 'advay-theme' ); ?>
				<span class="ss-btn-arrow" aria-hidden="true"></span>
			</a>
		</div>
	</section>
</main>
