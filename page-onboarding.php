<?php
/**
 * Template Name: Onboarding
 * Template Post Type: page
 *
 * One-Click Onboarding — /onboarding/ via rewrite or Page with this template.
 *
 * @package Advay_Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$slug    = 'onboarding';
$contact = advay_contact_url();
$wa_url  = advay_whatsapp_url();

$steps_defaults = array(
	array(
		'num'    => '01',
		'label'  => __( 'Alignment', 'advay-theme' ),
		'title'  => __( 'Alignment of requirements', 'advay-theme' ),
		'text'   => __( 'Tell us what you need, however\'s easiest. We map your setup to a plan before anything moves.', 'advay-theme' ),
		'tone'   => 'green',
		'icon'   => 'phone',
		'drawer' => array(
			'label' => __( 'What we align on', 'advay-theme' ),
			'items' => array(
				__( 'SKUs, pack sizes, and marketplace lanes (FBA, WFS, TikTok)', 'advay-theme' ),
				__( 'Prep specs, labeling rules, and any compliance needs', 'advay-theme' ),
				__( 'Receiving cadence, volume, and your go-live date', 'advay-theme' ),
			),
		),
	),
	array(
		'num'    => '02',
		'label'  => __( 'Setup', 'advay-theme' ),
		'title'  => __( 'Setup & activation', 'advay-theme' ),
		'text'   => __( 'Your account goes live in our WMS and gets connected to Amazon, so units can start moving.', 'advay-theme' ),
		'tone'   => 'amber',
		'icon'   => 'gear',
		'pills'  => array(
			array( 'label' => __( 'EPC WMS (Hopstack)', 'advay-theme' ), 'url' => '' ),
			array( 'label' => __( 'Amazon SPN', 'advay-theme' ), 'url' => '' ),
		),
		'drawer' => array(
			'label' => __( 'What you\'ll receive', 'advay-theme' ),
			'items' => array(
				__( 'Welcome email with your activation link', 'advay-theme' ),
				__( 'Placeholder SLA, if you\'ve opted in', 'advay-theme' ),
			),
		),
	),
	array(
		'num'    => '03',
		'label'  => __( 'Training', 'advay-theme' ),
		'title'  => __( 'Training', 'advay-theme' ),
		'text'   => __( 'A short, guided walkthrough of the tools and process, so nothing feels unfamiliar on day one.', 'advay-theme' ),
		'tone'   => 'blue',
		'icon'   => 'screen',
		'pills'  => array(
			array( 'label' => __( 'Training materials', 'advay-theme' ), 'url' => '' ),
		),
		'drawer' => array(
			'label' => __( 'What\'s included', 'advay-theme' ),
			'items' => array(
				__( 'WMS walkthrough — receiving, prep status, and outbound', 'advay-theme' ),
				__( 'How to read exception photos and chargeback flags', 'advay-theme' ),
				__( 'Who to ping when volume spikes or a spec changes', 'advay-theme' ),
			),
		),
	),
	array(
		'num'    => '04',
		'label'  => __( 'Live', 'advay-theme' ),
		'title'  => __( 'Ready to start receiving', 'advay-theme' ),
		'text'   => __( 'Your first shipment can land at the warehouse. From here, it\'s business as usual.', 'advay-theme' ),
		'tone'   => 'coral',
		'icon'   => 'box',
		'pills'  => array(
			array( 'label' => __( 'Receiving open', 'advay-theme' ), 'url' => $contact ),
		),
		'drawer' => array(
			'label' => __( 'Day-one checklist', 'advay-theme' ),
			'items' => array(
				__( 'Dock appointment booked and ASN shared', 'advay-theme' ),
				__( 'Labels, FNSKUs, and prep notes confirmed', 'advay-theme' ),
				__( 'Named ops owner on both sides — no ticket queue', 'advay-theme' ),
			),
		),
	),
);

$steps = array();
foreach ( $steps_defaults as $i => $def ) {
	$n     = $i + 1;
	$items = array();
	for ( $j = 1; $j <= 3; $j++ ) {
		$default_item = isset( $def['drawer']['items'][ $j - 1 ] ) ? $def['drawer']['items'][ $j - 1 ] : '';
		$item         = advay_page_acf( $slug, 'onboarding_step_' . $n . '_item_' . $j, $default_item );
		if ( '' !== (string) $item ) {
			$items[] = $item;
		}
	}
	if ( empty( $items ) && ! empty( $def['drawer']['items'] ) ) {
		$items = $def['drawer']['items'];
	}

	$step = array(
		'num'    => $def['num'],
		'label'  => advay_page_acf( $slug, 'onboarding_step_' . $n . '_label', $def['label'] ),
		'title'  => advay_page_acf( $slug, 'onboarding_step_' . $n . '_title', $def['title'] ),
		'text'   => advay_page_acf( $slug, 'onboarding_step_' . $n . '_text', $def['text'] ),
		'tone'   => $def['tone'],
		'icon'   => $def['icon'],
		'pills'  => isset( $def['pills'] ) ? $def['pills'] : array(),
		'drawer' => array(
			'label' => advay_page_acf( $slug, 'onboarding_step_' . $n . '_drawer_label', $def['drawer']['label'] ),
			'items' => $items,
		),
	);

	if ( 1 === $n ) {
		$step['pills'] = array(
			array(
				'label' => advay_page_acf( $slug, 'onboarding_pill_call_label', __( 'Call', 'advay-theme' ) ),
				'url'   => advay_intake_phone_url(),
			),
			array(
				'label' => advay_page_acf( $slug, 'onboarding_pill_email_label', __( 'Email', 'advay-theme' ) ),
				'url'   => advay_intake_email_url(),
			),
			array(
				'label' => advay_page_acf( $slug, 'onboarding_pill_whatsapp_label', __( 'WhatsApp', 'advay-theme' ) ),
				'url'   => $wa_url,
			),
			array(
				'label' => advay_page_acf( $slug, 'onboarding_pill_form_label', __( 'Fill a form', 'advay-theme' ) ),
				'url'   => $contact,
			),
			array(
				'label' => advay_page_acf( $slug, 'onboarding_pill_book_label', __( 'Book a meeting with the MD', 'advay-theme' ) ),
				'url'   => advay_dock_calendly_url(),
			),
		);
	}

	$steps[] = $step;
}

$ob_eyebrow = advay_page_acf( $slug, 'onboarding_eyebrow', __( 'How it works', 'advay-theme' ) );
$ob_heading = advay_page_acf( $slug, 'onboarding_heading', __( 'From first call to first shipment', 'advay-theme' ) );
$ob_lead    = advay_page_acf( $slug, 'onboarding_lead', __( 'Four steps, start to finish. No guesswork about what happens next — every brand moves through the same track, from alignment to receiving.', 'advay-theme' ) );

$ob_final_heading = advay_page_acf( $slug, 'onboarding_final_heading', __( 'Ready to start?', 'advay-theme' ) );
$ob_final_copy    = advay_page_acf( $slug, 'onboarding_final_copy', __( 'Tell us what you ship. You\'ll get a straight answer — a custom quote if we\'re a fit, a referral if we\'re not.', 'advay-theme' ) );
$ob_final_p       = advay_page_acf( $slug, 'onboarding_final_primary', '' );
$ob_final_s       = advay_page_acf( $slug, 'onboarding_final_secondary', '' );
$ob_final_p_label = advay_acf_link_title( $ob_final_p, __( 'Get a custom quote', 'advay-theme' ) );
$ob_final_p_url   = advay_acf_link_url( $ob_final_p, $contact );
$ob_final_s_label = advay_acf_link_title( $ob_final_s, __( 'Book a call with MD', 'advay-theme' ) );
$ob_final_s_url   = advay_acf_link_url( $ob_final_s, $contact );

get_header();
?>

<main id="main-content" class="ob-page">
	<section class="ob-hero">
		<div class="container ob-hero-inner" data-ob-reveal>
			<p class="ob-eyebrow"><?php echo esc_html( $ob_eyebrow ); ?></p>
			<h1><?php echo esc_html( $ob_heading ); ?></h1>
			<p class="ob-lead">
				<?php echo esc_html( $ob_lead ); ?>
			</p>
			<div class="ob-progress" aria-hidden="true">
				<?php for ( $i = 0; $i < 4; $i++ ) : ?>
					<span class="ob-progress-dot<?php echo 0 === $i ? ' is-on' : ''; ?>" data-ob-progress-dot="<?php echo esc_attr( $i ); ?>"></span>
				<?php endfor; ?>
			</div>
		</div>
	</section>

	<section class="ob-timeline" aria-label="<?php esc_attr_e( 'Onboarding steps', 'advay-theme' ); ?>" data-ob-timeline>
		<div class="container ob-timeline-wrap">
			<div class="ob-spine" aria-hidden="true">
				<span class="ob-spine-track"></span>
				<span class="ob-spine-fill" data-ob-spine-fill></span>
				<span class="ob-spine-beam" data-ob-spine-beam></span>
			</div>
			<ol class="ob-steps">
				<?php foreach ( $steps as $step_index => $step ) : ?>
					<li class="ob-step ob-step--<?php echo esc_attr( $step['tone'] ); ?><?php echo 0 === $step_index ? ' is-active' : ''; ?>" data-ob-reveal data-step-index="<?php echo esc_attr( $step_index ); ?>">
						<div class="ob-rail" aria-hidden="true">
							<span class="ob-node">
								<?php advay_onboarding_icon( $step['icon'] ); ?>
							</span>
							<span class="ob-line"></span>
						</div>

						<div class="ob-step-meta">
							<span class="ob-step-kicker">
								<?php
								printf(
									/* translators: %s: step number */
									esc_html__( 'Step %s', 'advay-theme' ),
									esc_html( $step['num'] )
								);
								?>
							</span>
						</div>

						<article class="ob-card">
							<h2><?php echo esc_html( $step['title'] ); ?></h2>
							<p><?php echo esc_html( $step['text'] ); ?></p>

							<?php if ( ! empty( $step['pills'] ) ) : ?>
								<div class="ob-pills">
									<?php foreach ( $step['pills'] as $pill ) : ?>
										<?php if ( ! empty( $pill['url'] ) ) : ?>
											<a class="ob-pill" href="<?php echo esc_url( $pill['url'] ); ?>"><?php echo esc_html( $pill['label'] ); ?></a>
										<?php else : ?>
											<span class="ob-pill"><?php echo esc_html( $pill['label'] ); ?></span>
										<?php endif; ?>
									<?php endforeach; ?>
								</div>
							<?php endif; ?>

							<?php if ( ! empty( $step['drawer'] ) ) : ?>
								<div class="ob-drawer">
									<button
										class="ob-drawer-toggle"
										type="button"
										data-ob-toggle
										aria-expanded="false"
									>
										<span><?php echo esc_html( $step['drawer']['label'] ); ?></span>
										<span class="ob-drawer-chevron" aria-hidden="true"></span>
									</button>
									<div class="ob-drawer-panel" data-ob-panel hidden>
										<ol>
											<?php foreach ( $step['drawer']['items'] as $item ) : ?>
												<li><?php echo esc_html( $item ); ?></li>
											<?php endforeach; ?>
										</ol>
									</div>
								</div>
							<?php endif; ?>
						</article>
					</li>
				<?php endforeach; ?>
			</ol>
		</div>
	</section>

	<section class="ob-final">
		<div class="container ob-final-inner" data-ob-reveal>
			<h2><?php echo esc_html( $ob_final_heading ); ?></h2>
			<p><?php echo esc_html( $ob_final_copy ); ?></p>
			<div class="ob-final-actions">
			<a class="button button-primary" href="<?php echo esc_url( $ob_final_p_url ); ?>">
				<?php echo esc_html( $ob_final_p_label ); ?>
				<span class="btn-arrow" aria-hidden="true"></span>
			</a>
			<a class="button button-ghost ob-final-call" href="<?php echo esc_url( $ob_final_s_url ); ?>">
				<?php echo esc_html( $ob_final_s_label ); ?>
			</a>
			</div>
		</div>
	</section>
</main>

<?php
get_footer();
