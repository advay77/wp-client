<?php
/**
 * Brand case-study slider.
 *
 * Logos act as tabs; clicking one reveals that brand's case-study panel
 * below. Demo content — "Read Case Study" links to the real blog archive,
 * no invented case-study URLs are generated.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$cs_url = advay_blog_url();

$brands = array(
	array(
		'name'     => 'Daka Vitamins',
		'file'     => 'images/brand-daka.png',
		'initials' => 'DV',
		'quote'    => __( 'Vitamin labeling and lot tracking used to slow every inbound. EPC keeps our FBA prep compliant so supplements stay in stock without account risk.', 'advay-theme' ),
		'author'   => __( 'Ada Okoro', 'advay-theme' ),
		'role'     => __( 'Founder, Daka Vitamins', 'advay-theme' ),
		'stats'    => array(
			array( 'n' => '99.8%', 'l' => __( 'Label accuracy', 'advay-theme' ) ),
			array( 'n' => '0', 'l' => __( 'Compliance holds', 'advay-theme' ) ),
		),
	),
	array(
		'name'     => 'Gainz & Airplanes',
		'file'     => 'images/brand-gainz.jpg',
		'initials' => 'GA',
		'quote'    => __( 'Supplement prep has zero room for labeling errors. EPC\'s inspection and FNSKU process keeps our Amazon account clean and in stock.', 'advay-theme' ),
		'author'   => __( 'Devon Cross', 'advay-theme' ),
		'role'     => __( 'Founder, Gainz & Airplanes', 'advay-theme' ),
		'stats'    => array(
			array( 'n' => '99.6%', 'l' => __( 'Prep accuracy', 'advay-theme' ) ),
			array( 'n' => '0', 'l' => __( 'Stranded inventory events', 'advay-theme' ) ),
		),
	),
	array(
		'name'     => 'Little Caribbean Kitchen',
		'file'     => 'images/brand-littlebay.jpg',
		'initials' => 'LC',
		'quote'    => __( 'We went from packing orders on the kitchen table to same-day dispatch. EPC handles receiving, prep, and shipping so we can focus on the food.', 'advay-theme' ),
		'author'   => __( 'Marlon Bay', 'advay-theme' ),
		'role'     => __( 'Founder, Little Caribbean Kitchen', 'advay-theme' ),
		'stats'    => array(
			array( 'n' => __( '24 hrs', 'advay-theme' ), 'l' => __( 'Order turnaround', 'advay-theme' ) ),
			array( 'n' => '3×', 'l' => __( 'Orders shipped / month', 'advay-theme' ) ),
		),
	),
	array(
		'name'     => 'Ajayi Popcorn',
		'file'     => 'images/brand-ajayi.jpg',
		'initials' => 'AP',
		'quote'    => __( 'Seasonal snack spikes used to break us. Now EPC scales fulfillment up and down with demand — no missed launches.', 'advay-theme' ),
		'author'   => __( 'Tunde Ajayi', 'advay-theme' ),
		'role'     => __( 'Founder, Ajayi Popcorn', 'advay-theme' ),
		'stats'    => array(
			array( 'n' => __( '2 Days', 'advay-theme' ), 'l' => __( 'Nationwide shipping', 'advay-theme' ) ),
			array( 'n' => '$1M+', 'l' => __( 'Peak-season volume', 'advay-theme' ) ),
		),
	),
);
?>
<section class="brands-section" aria-labelledby="brands-heading">
	<div class="container brands-wrap">
		<div class="brands-head">
			<h2 id="brands-heading" class="brands-title">
				<?php esc_html_e( 'Brands that said yes, and scaled through it', 'advay-theme' ); ?>
			</h2>
			<a class="brands-all" href="<?php echo esc_url( $cs_url ); ?>">
				<?php esc_html_e( 'See All Case Studies', 'advay-theme' ); ?>
				<span aria-hidden="true">&rsaquo;</span>
			</a>
		</div>

		<div class="cs-tabrow">
			<button class="brands-arrow" type="button" data-cs-prev aria-label="<?php esc_attr_e( 'Previous case study', 'advay-theme' ); ?>">
				<svg viewBox="0 0 24 24" width="20" height="20" fill="none"><path d="M15 5l-7 7 7 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
			</button>
			<ul class="cs-tabs" role="tablist" aria-label="<?php esc_attr_e( 'Brand case studies', 'advay-theme' ); ?>" data-cs-primary>
				<?php foreach ( $brands as $i => $brand ) : ?>
					<?php
					$path = get_template_directory() . '/assets/' . $brand['file'];
					$src  = file_exists( $path ) ? advay_asset_uri( $brand['file'] ) : '';
					$sel  = 0 === $i ? 'true' : 'false';
					?>
					<li class="cs-tab-item" role="presentation">
						<button
							class="cs-tab<?php echo 0 === $i ? ' is-active' : ''; ?>"
							type="button"
							role="tab"
							id="cs-tab-<?php echo esc_attr( $i ); ?>"
							aria-selected="<?php echo esc_attr( $sel ); ?>"
							aria-controls="cs-panel-<?php echo esc_attr( $i ); ?>"
							data-cs-index="<?php echo esc_attr( $i ); ?>"
						>
							<?php if ( $src ) : ?>
								<img class="cs-tab-logo" src="<?php echo esc_url( $src ); ?>" alt="<?php echo esc_attr( $brand['name'] ); ?>" loading="lazy" decoding="async">
							<?php else : ?>
								<span class="cs-tab-name"><?php echo esc_html( $brand['name'] ); ?></span>
							<?php endif; ?>
						</button>
					</li>
				<?php endforeach; ?>
			</ul>
			<button class="brands-arrow" type="button" data-cs-next aria-label="<?php esc_attr_e( 'Next case study', 'advay-theme' ); ?>">
				<svg viewBox="0 0 24 24" width="20" height="20" fill="none"><path d="M9 5l7 7-7 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
			</button>
		</div>

		<div class="cs-panels">
			<?php foreach ( $brands as $i => $brand ) : ?>
				<div
					class="cs-panel<?php echo 0 === $i ? ' is-active' : ''; ?>"
					id="cs-panel-<?php echo esc_attr( $i ); ?>"
					role="tabpanel"
					aria-labelledby="cs-tab-<?php echo esc_attr( $i ); ?>"
					data-cs-panel="<?php echo esc_attr( $i ); ?>"
					<?php echo 0 === $i ? '' : 'hidden'; ?>
				>
					<div class="cs-quote">
						<p class="cs-text"><?php echo esc_html( $brand['quote'] ); ?></p>
						<div class="cs-author">
							<span class="cs-avatar" aria-hidden="true"><?php echo esc_html( $brand['initials'] ); ?></span>
							<span class="cs-author-meta">
								<strong><?php echo esc_html( $brand['author'] ); ?></strong>
								<em><?php echo esc_html( $brand['role'] ); ?></em>
							</span>
						</div>
						<a class="cs-link" href="<?php echo esc_url( $cs_url ); ?>">
							<?php esc_html_e( 'Read Case Study', 'advay-theme' ); ?>
							<span aria-hidden="true">&rarr;</span>
						</a>
					</div>
					<div class="cs-stats">
						<?php foreach ( $brand['stats'] as $stat ) : ?>
							<div class="cs-stat">
								<strong><?php echo esc_html( $stat['n'] ); ?></strong>
								<span><?php echo esc_html( $stat['l'] ); ?></span>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
