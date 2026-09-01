<?php
/**
 * Template Name: Quote
 * Template Post Type: page
 *
 * Instant Quote — primary conversion page.
 *
 * @package Advay_Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$slug = 'quote';

$quote_eyebrow = advay_page_acf( $slug, 'quote_eyebrow', __( 'Get started', 'advay-theme' ) );
$quote_heading = advay_page_acf( $slug, 'quote_heading', __( 'Get an Instant Quote', 'advay-theme' ) );
$quote_lead    = advay_page_acf( $slug, 'quote_lead', __( 'Fill out the form below, text us, or schedule a meeting for an instant quote — and see your instant pricing report.', 'advay-theme' ) );

$reassurance_defaults = array(
	array(
		'value' => __( 'Pricing from $1/unit', 'advay-theme' ),
		'label' => __( 'Transparent prep pricing', 'advay-theme' ),
		'note'  => __( 'Per-unit rates with no hidden fees', 'advay-theme' ),
	),
	array(
		'value' => __( '24–36 hrs', 'advay-theme' ),
		'label' => __( 'Fast turnaround', 'advay-theme' ),
		'note'  => __( 'Inventory prepped and moving quickly', 'advay-theme' ),
	),
	array(
		'value' => __( 'No minimums', 'advay-theme' ),
		'label' => __( 'Start at any volume', 'advay-theme' ),
		'note'  => __( 'No account minimums to get started', 'advay-theme' ),
	),
);

$reassurance = array();
foreach ( $reassurance_defaults as $i => $row ) {
	$n              = $i + 1;
	$reassurance[] = array(
		'value' => advay_page_acf( $slug, 'quote_point_' . $n . '_value', $row['value'] ),
		'label' => advay_page_acf( $slug, 'quote_point_' . $n . '_label', $row['label'] ),
		'note'  => advay_page_acf( $slug, 'quote_point_' . $n . '_note', $row['note'] ),
	);
}

$quote_alt_heading = advay_page_acf( $slug, 'quote_alt_heading', __( 'Prefer to talk?', 'advay-theme' ) );
$quote_alt_lead    = advay_page_acf( $slug, 'quote_alt_lead', __( 'WhatsApp, email, or book time with our managing director — same team, your choice.', 'advay-theme' ) );

$contact_cta = advay_header_cta_secondary();

$contact_links = array(
	array(
		'label'    => advay_dock_whatsapp_label(),
		'url'      => advay_whatsapp_url(),
		'external' => true,
	),
	array(
		'label'    => advay_dock_email_label(),
		'url'      => advay_dock_email_url(),
		'external' => false,
	),
);

get_header();
?>

<main id="main-content" class="quote-page">
	<section class="quote-hero" aria-labelledby="quote-heading">
		<div class="container">
			<p class="eyebrow"><?php echo esc_html( $quote_eyebrow ); ?></p>
			<h1 id="quote-heading"><?php echo esc_html( $quote_heading ); ?></h1>
			<p class="lead"><?php echo esc_html( $quote_lead ); ?></p>
		</div>
	</section>

	<section class="quote-reassurance" aria-label="<?php esc_attr_e( 'Why sellers choose ElitePrep', 'advay-theme' ); ?>">
		<div class="container">
			<div class="quote-points">
				<?php foreach ( $reassurance as $point ) : ?>
					<article>
						<strong><?php echo esc_html( $point['value'] ); ?></strong>
						<p><?php echo esc_html( $point['label'] ); ?></p>
						<span><?php echo esc_html( $point['note'] ); ?></span>
					</article>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<section class="quote-form-section" aria-label="<?php esc_attr_e( 'Instant quote calculator', 'advay-theme' ); ?>">
		<div class="container quote-form-wrap">
			<div class="quote-form content-wrap">
				<?php
				if ( function_exists( 'gravity_form' ) ) {
					gravity_form( 7, false, false, false, null, true );
				} else {
					echo do_shortcode( '[gravityform id="7" title="false" ajax="true"]' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				}
				?>
			</div>
		</div>
	</section>

	<?php get_template_part( 'template-parts/editor-zone' ); ?>

	<section class="quote-alt" aria-labelledby="quote-alt-heading">
		<div class="container quote-alt-inner">
			<h2 id="quote-alt-heading"><?php echo esc_html( $quote_alt_heading ); ?></h2>
			<p class="lead"><?php echo esc_html( $quote_alt_lead ); ?></p>
			<div class="quote-alt-actions">
				<a class="button button-primary" href="<?php echo esc_url( $contact_cta['url'] ); ?>">
					<?php echo esc_html( $contact_cta['label'] ); ?>
				</a>
			</div>
			<div class="quote-contact-links">
				<?php foreach ( $contact_links as $link ) : ?>
					<a
						href="<?php echo esc_url( $link['url'] ); ?>"
						<?php echo $link['external'] ? 'target="_blank" rel="noopener noreferrer"' : ''; ?>
					>
						<?php echo esc_html( $link['label'] ); ?>
					</a>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
</main>

<?php
get_footer();
