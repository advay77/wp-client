<?php
/**
 * Brand case-study slider.
 *
 * Logos act as tabs; clicking one reveals that brand's case-study panel
 * below. "Read Case Study" links to each brand's success story page.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$brands = advay_home_brands_case_studies();
$front  = advay_acf_front_id();
$brands_title = advay_get_acf(
	'home_brands_title',
	__( 'Brands that said yes, and scaled through it', 'advay-theme' ),
	$front
);
$see_all = advay_get_acf( 'home_brands_see_all_label', __( 'See All Case Studies', 'advay-theme' ), $front );
$read_cs = advay_get_acf( 'home_brands_read_label', __( 'Read Case Study', 'advay-theme' ), $front );
?>
<section class="brands-section" aria-labelledby="brands-heading">
	<div class="container brands-wrap">
		<div class="brands-head">
			<h2 id="brands-heading" class="brands-title">
				<?php echo esc_html( $brands_title ); ?>
			</h2>
			<a class="brands-all" href="<?php echo esc_url( home_url( '/#testimonials' ) ); ?>">
				<?php echo esc_html( $see_all ); ?>
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
					$src = ! empty( $brand['logo_src'] ) ? $brand['logo_src'] : '';
					$sel = 0 === $i ? 'true' : 'false';
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
						<a class="cs-link" href="<?php echo esc_url( advay_success_story_url( $brand['slug'] ) ); ?>">
							<?php echo esc_html( $read_cs ); ?>
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
