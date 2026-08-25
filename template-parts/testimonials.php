<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$quotes = array(
	array(
		'name'  => 'Candice Adams',
		'role'  => 'Founder & CEO',
		'quote' => 'Saltbox has been a game changer for our business. The space, the community, and the support helped us scale without the overhead of a traditional warehouse.',
		'brand' => 'CHIC GEEKS',
		'init'  => 'CA',
	),
	array(
		'name'  => 'Jonathan Simpson',
		'role'  => 'Founder',
		'quote' => 'We needed a partner that understood wholesale and marketplace growth. The team made fulfillment feel simple so we could focus on the brand.',
		'brand' => 'POCKET LATTE',
		'init'  => 'JS',
	),
	array(
		'name'  => 'Sarah Lesko',
		'role'  => 'Executive Director',
		'quote' => 'As a nonprofit we needed reliability more than anything. Prep, packing, and shipping just work—and that lets us put energy back into the mission.',
		'brand' => 'BRAS FOR GIRLS',
		'init'  => 'SL',
	),
);
?>
<section class="stories-section" id="testimonials" aria-labelledby="stories-heading">
	<div class="container">
		<header class="section-heading stories-heading">
			<p class="eyebrow"><?php esc_html_e( 'Clients', 'advay-theme' ); ?></p>
			<h2 id="stories-heading"><?php esc_html_e( 'Testimonials', 'advay-theme' ); ?></h2>
		</header>

		<div class="stories-grid">
			<article class="story-media is-tall">
				<video muted loop playsinline preload="metadata" poster="">
					<source src="<?php echo esc_url( advay_story_video( 'tall' ) ); ?>" type="video/mp4">
				</video>
				<div class="story-media-ui">
					<span class="story-chip"><?php esc_html_e( 'Colorado Threads', 'advay-theme' ); ?></span>
					<span class="story-mute" aria-hidden="true"></span>
				</div>
				<div class="story-media-copy">
					<p><?php esc_html_e( '“We finally have a warehouse rhythm that keeps Amazon and Walmart in stock.”', 'advay-theme' ); ?></p>
					<strong>Haley Lucero</strong>
					<span><?php esc_html_e( 'CEO of Colorado Threads', 'advay-theme' ); ?></span>
				</div>
			</article>

			<?php foreach ( array_slice( $quotes, 0, 2 ) as $item ) : ?>
				<blockquote class="story-card">
					<div class="story-person">
						<span class="story-avatar"><?php echo esc_html( $item['init'] ); ?></span>
						<div>
							<strong><?php echo esc_html( $item['name'] ); ?></strong>
							<span><?php echo esc_html( $item['role'] ); ?></span>
						</div>
					</div>
					<p>“<?php echo esc_html( $item['quote'] ); ?>”</p>
					<span class="story-brand"><?php echo esc_html( $item['brand'] ); ?></span>
				</blockquote>
			<?php endforeach; ?>

			<article class="story-media is-square">
				<video muted loop playsinline preload="metadata">
					<source src="<?php echo esc_url( advay_story_video( 'square' ) ); ?>" type="video/mp4">
				</video>
				<div class="story-media-ui">
					<span class="story-mute" aria-hidden="true"></span>
				</div>
			</article>

			<blockquote class="story-card is-wide">
				<div class="story-person">
					<span class="story-avatar"><?php echo esc_html( $quotes[2]['init'] ); ?></span>
					<div>
						<strong><?php echo esc_html( $quotes[2]['name'] ); ?></strong>
						<span><?php echo esc_html( $quotes[2]['role'] ); ?></span>
					</div>
				</div>
				<p>“<?php echo esc_html( $quotes[2]['quote'] ); ?>”</p>
				<span class="story-brand"><?php echo esc_html( $quotes[2]['brand'] ); ?></span>
			</blockquote>
		</div>
	</div>
</section>
