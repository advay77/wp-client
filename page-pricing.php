<?php
/**
 * Template Name: Pricing
 * Template Post Type: page
 *
 * Pricing page (slug: pricing).
 *
 * @package Advay_Theme
 */

get_header();

$groups = array(
	'prep'     => __( 'Prep', 'advay-theme' ),
	'inbound'  => __( 'Inbound', 'advay-theme' ),
	'storage'  => __( 'Storage', 'advay-theme' ),
	'outbound' => __( 'Outbound', 'advay-theme' ),
	'labor'    => __( 'Labor & extras', 'advay-theme' ),
);

$highlight_defaults = array(
	array(
		'label' => __( 'Item prep from', 'advay-theme' ),
		'value' => '$1.00',
		'note'  => __( 'per unit at 1–1,000 / month', 'advay-theme' ),
	),
	array(
		'label' => __( 'Pallet storage', 'advay-theme' ),
		'value' => '$40',
		'note'  => __( 'per pallet after 30 days', 'advay-theme' ),
	),
	array(
		'label' => __( '20ft unload', 'advay-theme' ),
		'value' => '$315',
		'note'  => __( 'per container', 'advay-theme' ),
	),
	array(
		'label' => __( 'Rush / weekend', 'advay-theme' ),
		'value' => '$90',
		'note'  => __( 'per hour, 2-hour minimum', 'advay-theme' ),
	),
);

$highlights = array();
foreach ( $highlight_defaults as $i => $row ) {
	$n            = $i + 1;
	$highlights[] = array(
		'label' => advay_page_acf( 'pricing', 'pricing_highlight_' . $n . '_label', $row['label'] ),
		'value' => advay_page_acf( 'pricing', 'pricing_highlight_' . $n . '_value', $row['value'] ),
		'note'  => advay_page_acf( 'pricing', 'pricing_highlight_' . $n . '_note', $row['note'] ),
	);
}
?>

<main id="main-content" class="pricing-page">
	<section class="pricing-hero">
		<div class="container">
			<p class="eyebrow"><?php esc_html_e( 'Get started', 'advay-theme' ); ?></p>
			<h1><?php esc_html_e( 'Pricing', 'advay-theme' ); ?></h1>
			<p class="lead"><?php esc_html_e( 'Published prep rates for Amazon FBA, Walmart WFS, and TikTok Shop. Volume programs and odd SKUs still get a custom quote.', 'advay-theme' ); ?></p>
		</div>
	</section>

	<section class="pricing-highlights">
		<div class="container highlights-grid">
			<?php foreach ( $highlights as $hl ) : ?>
				<article>
					<p><?php echo esc_html( $hl['label'] ); ?></p>
					<strong><?php echo esc_html( $hl['value'] ); ?></strong>
					<span><?php echo esc_html( $hl['note'] ); ?></span>
				</article>
			<?php endforeach; ?>
		</div>
	</section>

	<section class="pricing-board">
		<div class="container">
			<div class="pricing-toolbar">
				<div class="pricing-filters" role="tablist" aria-label="<?php esc_attr_e( 'Filter rates', 'advay-theme' ); ?>">
					<button type="button" class="is-active" data-filter="all"><?php esc_html_e( 'All', 'advay-theme' ); ?></button>
					<button type="button" data-filter="standard"><?php esc_html_e( 'Standard', 'advay-theme' ); ?></button>
					<button type="button" data-filter="addon"><?php esc_html_e( 'Add-on', 'advay-theme' ); ?></button>
				</div>
				<label class="pricing-search">
					<span><?php esc_html_e( 'Search', 'advay-theme' ); ?></span>
					<input type="search" id="pricing-search" placeholder="<?php esc_attr_e( 'Prep, storage, container…', 'advay-theme' ); ?>">
				</label>
			</div>

			<?php foreach ( $groups as $key => $label ) : ?>
				<div class="rate-group" data-group="<?php echo esc_attr( $key ); ?>">
					<h2><?php echo esc_html( $label ); ?></h2>
					<div class="rate-grid">
						<?php foreach ( advay_pricing_rows() as $row ) : ?>
							<?php if ( $row['cat'] !== $key ) { continue; } ?>
							<article
								class="rate-card"
								data-type="<?php echo esc_attr( $row['type'] ); ?>"
								data-search="<?php echo esc_attr( strtolower( $row['service'] . ' ' . $row['uom'] . ' ' . $row['notes'] ) ); ?>"
							>
								<div class="rate-top">
									<span class="rate-tag is-<?php echo esc_attr( $row['type'] ); ?>">
										<?php echo esc_html( 'addon' === $row['type'] ? __( 'Add-on', 'advay-theme' ) : __( 'Standard', 'advay-theme' ) ); ?>
									</span>
									<strong class="rate-price"><?php echo esc_html( $row['charge'] ); ?></strong>
								</div>
								<h3><?php echo esc_html( $row['service'] ); ?></h3>
								<p class="rate-meta">
									<?php echo esc_html( $row['uom'] ); ?>
									<?php if ( 'N/A' !== $row['volume'] ) : ?>
										· <?php echo esc_html( $row['volume'] ); ?>
									<?php endif; ?>
								</p>
								<?php if ( $row['notes'] ) : ?>
									<p class="rate-note"><?php echo esc_html( $row['notes'] ); ?></p>
								<?php endif; ?>
							</article>
						<?php endforeach; ?>
					</div>
				</div>
			<?php endforeach; ?>

			<p class="pricing-empty" hidden><?php esc_html_e( 'No rates match that search.', 'advay-theme' ); ?></p>

			<div class="pricing-cta">
				<p><?php esc_html_e( 'Need a SKU-level program? Send volume, marketplace, and timing.', 'advay-theme' ); ?></p>
				<a class="button button-primary" href="<?php echo esc_url( advay_contact_url() ); ?>">
					<?php esc_html_e( 'Get a custom quote', 'advay-theme' ); ?>
					<span class="btn-arrow" aria-hidden="true"></span>
				</a>
			</div>
		</div>
	</section>
</main>

<?php
get_footer();
