<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$hubs = array(
	array(
		'id'      => 'amazon',
		'label'   => __( 'Amazon Fulfillment Center', 'advay-theme' ),
		'addr'    => __( '2439 Center Square Rd, Logan Township, NJ', 'advay-theme' ),
		'meta'    => __( '22 min · 17 miles', 'advay-theme' ),
		'miles'   => __( '17 miles', 'advay-theme' ),
		'drive'   => __( '22 min drive', 'advay-theme' ),
		'market'  => __( 'Amazon FBA', 'advay-theme' ),
		'img'     => advay_asset_uri( 'images/amazon.svg' ),
		'photo'   => 'images/amazon.jpeg',
		'tz'      => __( 'Eastern Time (ET)', 'advay-theme' ),
		'tzname'  => 'America/New_York',
		'color'   => '#FF9900',
	),
	array(
		'id'      => 'walmart',
		'label'   => __( 'Walmart Fulfillment Center', 'advay-theme' ),
		'addr'    => __( '2401 East State St Ext, Hamilton Township, NJ', 'advay-theme' ),
		'meta'    => __( '47 min · 44 miles', 'advay-theme' ),
		'miles'   => __( '44 miles', 'advay-theme' ),
		'drive'   => __( '47 min drive', 'advay-theme' ),
		'market'  => __( 'Walmart WFS', 'advay-theme' ),
		'img'     => advay_asset_uri( 'images/walmart.svg' ),
		'photo'   => 'images/walmart.jpeg',
		'tz'      => __( 'Eastern Time (ET)', 'advay-theme' ),
		'tzname'  => 'America/New_York',
		'color'   => '#0071CE',
	),
	array(
		'id'      => 'tiktok',
		'label'   => __( 'FBT Fulfilment by TikTok', 'advay-theme' ),
		'addr'    => __( '245 Mountain Ave, Middlesex, NJ 08846', 'advay-theme' ),
		'meta'    => __( '38 min · 36 miles', 'advay-theme' ),
		'miles'   => __( '36 miles', 'advay-theme' ),
		'drive'   => __( '38 min drive', 'advay-theme' ),
		'market'  => __( 'TikTok Shop', 'advay-theme' ),
		'img'     => advay_asset_uri( 'images/tiktok.svg' ),
		'photo'   => 'images/tiktok.jpeg',
		'tz'      => __( 'Eastern Time (ET)', 'advay-theme' ),
		'tzname'  => 'America/New_York',
		'color'   => '#FE2C55',
	),
);

$front = advay_acf_front_id();
foreach ( $hubs as $i => &$hub_ref ) {
	$n = $i + 1;
	$hub_ref['label']  = advay_get_acf( 'home_map_hub_' . $n . '_label', $hub_ref['label'], $front );
	$hub_ref['addr']   = advay_get_acf( 'home_map_hub_' . $n . '_addr', $hub_ref['addr'], $front );
	$hub_ref['miles']  = advay_get_acf( 'home_map_hub_' . $n . '_miles', $hub_ref['miles'], $front );
	$hub_ref['drive']  = advay_get_acf( 'home_map_hub_' . $n . '_drive', $hub_ref['drive'], $front );
	$hub_ref['market'] = advay_get_acf( 'home_map_hub_' . $n . '_market', $hub_ref['market'], $front );
	$hub_ref['meta']   = advay_get_acf( 'home_map_hub_' . $n . '_meta', $hub_ref['meta'], $front );
	$photo_path = get_template_directory() . '/assets/' . $hub_ref['photo'];
	$hub_ref['photo'] = file_exists( $photo_path ) ? advay_asset_uri( $hub_ref['photo'] ) : '';
}
unset( $hub_ref );

$map_eyebrow = advay_get_acf( 'home_map_eyebrow', __( 'Coverage', 'advay-theme' ), $front );
$map_heading = advay_get_acf( 'home_map_heading', __( 'Strategically Located', 'advay-theme' ), $front );
$map_lead    = advay_get_acf( 'home_map_lead', __( 'One Franklinville hub. Three marketplace doors. Same-day lanes into Amazon, Walmart, and TikTok Shop.', 'advay-theme' ), $front );
$map_banner_title = advay_get_acf( 'home_map_banner_title', __( 'ELITE PREP CENTER (EPC)', 'advay-theme' ), $front );
$map_banner_addr  = advay_get_acf( 'home_map_banner_addr', __( '1736 Dutch Mill Road, Franklinville, NJ 08322', 'advay-theme' ), $front );
$map_onboard      = advay_get_acf( 'home_map_onboard_label', __( 'One-click onboarding', 'advay-theme' ), $front );
?>
<section class="map-section" id="location" aria-labelledby="map-heading">
	<div class="map-glow" aria-hidden="true"></div>
	<div class="container map-intro">
		<p class="eyebrow"><?php echo esc_html( $map_eyebrow ); ?></p>
		<h2 id="map-heading"><?php echo esc_html( $map_heading ); ?></h2>
		<p class="lead map-lead">
			<?php echo esc_html( $map_lead ); ?>
		</p>
	</div>
	<div class="container">
		<div class="map-canvas">
			<div class="map-banner">
				<strong><?php echo esc_html( $map_banner_title ); ?></strong>
				<span><?php echo esc_html( $map_banner_addr ); ?></span>
			</div>
			<div class="map-stage">
				<a class="map-onboard-btn" href="<?php echo esc_url( advay_onboarding_url() ); ?>">
					<?php echo esc_html( $map_onboard ); ?>
				</a>
				<div id="epc-map" class="epc-map" role="img" aria-label="<?php esc_attr_e( 'Map of Elite Prep Center and nearby fulfillment centers', 'advay-theme' ); ?>"></div>
				<div class="map-detail" id="map-detail" role="region" aria-label="<?php esc_attr_e( 'Fulfillment center details', 'advay-theme' ); ?>" hidden>
					<button class="map-detail-close" type="button" data-detail-close aria-label="<?php esc_attr_e( 'Close details', 'advay-theme' ); ?>">&times;</button>

					<div class="map-detail-info">
						<span class="map-detail-market" data-detail-market></span>
						<strong class="map-detail-name" data-detail-name></strong>

						<div class="map-detail-keyfacts">
							<span class="map-detail-kf">
								<b data-detail-miles></b>
								<i><?php esc_html_e( 'from EPC', 'advay-theme' ); ?></i>
							</span>
							<span class="map-detail-kf">
								<b data-detail-drive></b>
								<i><?php esc_html_e( 'drive time', 'advay-theme' ); ?></i>
							</span>
						</div>

						<dl class="map-detail-rows">
							<div class="map-detail-row">
								<dt><?php esc_html_e( 'Address', 'advay-theme' ); ?></dt>
								<dd data-detail-addr></dd>
							</div>
							<div class="map-detail-row">
								<dt><?php esc_html_e( 'Time zone', 'advay-theme' ); ?></dt>
								<dd data-detail-tz></dd>
							</div>
							<div class="map-detail-row">
								<dt><?php esc_html_e( 'Local time now', 'advay-theme' ); ?></dt>
								<dd data-detail-localtime>&mdash;</dd>
							</div>
						</dl>
					</div>

					<div class="map-detail-photo">
						<img src="" alt="" data-detail-photo>
						<span class="map-detail-photo-fallback" data-detail-fallback aria-hidden="true">
							<img src="" alt="" data-detail-img>
						</span>
					</div>
				</div>
			</div>
			<div class="map-hubs">
				<?php foreach ( $hubs as $hub ) : ?>
					<button
						class="map-hub map-hub-<?php echo esc_attr( $hub['id'] ); ?>"
						type="button"
						style="--hub-color: <?php echo esc_attr( $hub['color'] ); ?>;"
						data-hub="<?php echo esc_attr( $hub['id'] ); ?>"
						data-name="<?php echo esc_attr( $hub['label'] ); ?>"
						data-addr="<?php echo esc_attr( $hub['addr'] ); ?>"
						data-meta="<?php echo esc_attr( $hub['meta'] ); ?>"
						data-miles="<?php echo esc_attr( $hub['miles'] ); ?>"
						data-drive="<?php echo esc_attr( $hub['drive'] ); ?>"
						data-market="<?php echo esc_attr( $hub['market'] ); ?>"
						data-img="<?php echo esc_url( $hub['img'] ); ?>"
						data-photo="<?php echo esc_url( $hub['photo'] ); ?>"
						data-tz="<?php echo esc_attr( $hub['tz'] ); ?>"
						data-tzname="<?php echo esc_attr( $hub['tzname'] ); ?>"
						data-color="<?php echo esc_attr( $hub['color'] ); ?>"
						aria-expanded="false"
						aria-controls="map-detail"
					>
						<span class="map-badge">
							<img src="<?php echo esc_url( $hub['img'] ); ?>" alt="<?php echo esc_attr( $hub['label'] ); ?>">
						</span>
						<span>
							<strong><?php echo esc_html( $hub['label'] ); ?></strong>
							<em><?php echo esc_html( $hub['addr'] ); ?></em>
							<b><?php echo esc_html( $hub['meta'] ); ?></b>
						</span>
						<span class="map-hub-cue" aria-hidden="true"><?php esc_html_e( 'Click to expand', 'advay-theme' ); ?></span>
					</button>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</section>
