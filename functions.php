<?php
/**
 * Advay Theme functions.
 *
 * Compatible with title-tag, featured images, nav menus, and SEO plugins
 * that hook into wp_head / document_title / schema.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'ADVAY_THEME_VERSION', '2.0.2' );

function advay_theme_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'responsive-embeds' );

	register_nav_menus(
		array(
			'primary' => __( 'Primary Menu', 'advay-theme' ),
			'footer'  => __( 'Footer Menu', 'advay-theme' ),
			'legal'   => __( 'Legal Menu', 'advay-theme' ),
		)
	);
}
add_action( 'after_setup_theme', 'advay_theme_setup' );

function advay_enqueue_assets() {
	wp_enqueue_style(
		'advay-fonts',
		'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap',
		array(),
		null
	);

	wp_enqueue_style(
		'advay-style',
		get_stylesheet_uri(),
		array( 'advay-fonts' ),
		ADVAY_THEME_VERSION
	);

	if ( is_front_page() ) {
		wp_enqueue_style(
			'leaflet',
			'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css',
			array(),
			'1.9.4'
		);
		wp_enqueue_script(
			'leaflet',
			'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js',
			array(),
			'1.9.4',
			true
		);
		wp_enqueue_script(
			'gsap',
			'https://cdn.jsdelivr.net/npm/gsap@3.12.7/dist/gsap.min.js',
			array(),
			'3.12.7',
			true
		);
		wp_enqueue_script(
			'gsap-scrolltrigger',
			'https://cdn.jsdelivr.net/npm/gsap@3.12.7/dist/ScrollTrigger.min.js',
			array( 'gsap' ),
			'3.12.7',
			true
		);
	}

	$theme_deps = is_front_page() ? array( 'leaflet' ) : array();
	wp_enqueue_script(
		'advay-theme',
		get_template_directory_uri() . '/assets/js/theme.js',
		$theme_deps,
		ADVAY_THEME_VERSION,
		true
	);

	if ( is_front_page() ) {
		wp_enqueue_script(
			'advay-fit-story',
			get_template_directory_uri() . '/assets/js/fit-story.js',
			array(),
			ADVAY_THEME_VERSION,
			true
		);
	}
}
add_action( 'wp_enqueue_scripts', 'advay_enqueue_assets' );

/**
 * Fallback primary nav: homepage section hashes only (no invented page paths).
 * Used only when no menu is assigned to the Primary location.
 */
function advay_primary_menu_fallback() {
	$home  = trailingslashit( home_url( '/' ) );
	$items = array(
		array(
			'label' => __( 'Company', 'advay-theme' ),
			'url'   => $home . '#company',
			'mega'  => 'company',
			'class' => 'has-mega is-wide is-company',
		),
		array(
			'label' => __( 'What we do', 'advay-theme' ),
			'url'   => $home . '#services',
			'mega'  => 'what',
			'class' => 'has-mega is-wide',
		),
		array(
			'label' => __( 'Success stories', 'advay-theme' ),
			'url'   => $home . '#testimonials',
			'mega'  => 'stories',
			'class' => 'has-mega is-wide is-stories',
		),
		array(
			'label' => __( 'Blogs', 'advay-theme' ),
			'url'   => advay_blog_url(),
			'mega'  => 'learn',
			'class' => 'has-mega is-blogs',
		),
	);

	echo '<ul class="menu">';
	foreach ( $items as $item ) {
		printf(
			'<li class="%s"><a class="%s" href="%s">%s%s</a>',
			esc_attr( $item['class'] ),
			$item['mega'] ? 'nav-trigger' : '',
			esc_url( $item['url'] ),
			esc_html( $item['label'] ),
			$item['mega'] ? '<span class="nav-caret" aria-hidden="true"></span>' : ''
		);
		if ( $item['mega'] ) {
			advay_primary_mega_markup( $item['mega'] );
		}
		echo '</li>';
	}
	echo '</ul>';
}

function advay_nav_mega_type( $item ) {
	$classes = is_object( $item ) && isset( $item->classes ) ? (array) $item->classes : array();
	if ( in_array( 'mega-what', $classes, true ) ) {
		return 'what';
	}
	if ( in_array( 'mega-learn', $classes, true ) || in_array( 'mega-blogs', $classes, true ) ) {
		return 'learn';
	}
	if ( in_array( 'mega-company', $classes, true ) ) {
		return 'company';
	}

	if ( in_array( 'mega-stories', $classes, true ) ) {
		return 'stories';
	}

	$title = is_object( $item ) && isset( $item->title ) ? strtolower( trim( wp_strip_all_tags( $item->title ) ) ) : '';
	$map   = array(
		'what we do'      => 'what',
		'learn'           => 'learn',
		'blogs'           => 'learn',
		'blog'            => 'learn',
		'company'         => 'company',
		'success stories' => 'stories',
		'testimonials'    => 'stories',
	);
	if ( isset( $map[ $title ] ) ) {
		return $map[ $title ];
	}

	$url = is_object( $item ) && isset( $item->url ) ? $item->url : '';
	if ( false !== strpos( $url, '#testimonials' ) ) {
		return 'stories';
	}
	if ( false !== strpos( $url, '#how-it-works' ) ) {
		return 'learn';
	}
	if ( false !== strpos( $url, '#company' ) ) {
		return 'company';
	}
	if ( false !== strpos( $url, '#services' ) ) {
		return 'what';
	}

	return '';
}

function advay_primary_mega_markup( $type ) {
	$allowed = array( 'what', 'learn', 'company', 'stories' );
	if ( ! in_array( $type, $allowed, true ) ) {
		return;
	}
	get_template_part( 'template-parts/nav-mega', $type );
}

function advay_is_primary_nav( $args ) {
	return is_object( $args ) && isset( $args->theme_location ) && 'primary' === $args->theme_location;
}

function advay_nav_menu_css_class( $classes, $item, $args, $depth ) {
	if ( ! advay_is_primary_nav( $args ) || 0 !== (int) $depth ) {
		return $classes;
	}

	$type = advay_nav_mega_type( $item );
	if ( 'what' === $type ) {
		$classes[] = 'has-mega';
		$classes[] = 'is-wide';
	} elseif ( 'learn' === $type ) {
		$classes[] = 'has-mega';
		$classes[] = 'is-blogs';
	} elseif ( 'company' === $type ) {
		$classes[] = 'has-mega';
		$classes[] = 'is-wide';
		$classes[] = 'is-company';
	} elseif ( 'stories' === $type ) {
		$classes[] = 'has-mega';
		$classes[] = 'is-wide';
		$classes[] = 'is-stories';
	}

	return $classes;
}
add_filter( 'nav_menu_css_class', 'advay_nav_menu_css_class', 10, 4 );

function advay_nav_menu_link_attributes( $atts, $item, $args, $depth ) {
	if ( ! advay_is_primary_nav( $args ) || 0 !== (int) $depth ) {
		return $atts;
	}

	if ( advay_nav_mega_type( $item ) ) {
		$atts['class'] = trim( ( isset( $atts['class'] ) ? $atts['class'] : '' ) . ' nav-trigger' );
	}

	return $atts;
}
add_filter( 'nav_menu_link_attributes', 'advay_nav_menu_link_attributes', 10, 4 );

function advay_nav_menu_start_el( $item_output, $item, $depth, $args ) {
	if ( ! advay_is_primary_nav( $args ) || 0 !== (int) $depth ) {
		return $item_output;
	}

	$type = advay_nav_mega_type( $item );
	if ( ! $type ) {
		return $item_output;
	}

	$caret        = '<span class="nav-caret" aria-hidden="true"></span>';
	$item_output  = preg_replace( '/<\/a>/', $caret . '</a>', $item_output, 1 );
	ob_start();
	advay_primary_mega_markup( $type );
	$item_output .= ob_get_clean();

	return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'advay_nav_menu_start_el', 10, 4 );

function advay_footer_menu_fallback() {
	$home  = trailingslashit( home_url( '/' ) );
	$items = array(
		array( 'label' => __( 'What we do', 'advay-theme' ), 'url' => $home . '#services' ),
		array( 'label' => __( 'Success stories', 'advay-theme' ), 'url' => $home . '#testimonials' ),
		array( 'label' => __( 'Learn', 'advay-theme' ), 'url' => $home . '#how-it-works' ),
		array( 'label' => __( 'Company', 'advay-theme' ), 'url' => $home . '#company' ),
	);

	echo '<ul class="footer-menu">';
	foreach ( $items as $item ) {
		printf(
			'<li><a href="%s">%s</a></li>',
			esc_url( $item['url'] ),
			esc_html( $item['label'] )
		);
	}
	echo '</ul>';
}

function advay_contact_url() {
	return trailingslashit( home_url( '/' ) ) . '#contact';
}

function advay_pricing_url() {
	$page = get_page_by_path( 'pricing' );
	return $page ? get_permalink( $page ) : trailingslashit( home_url( '/' ) );
}

function advay_services_url( $hash = '' ) {
	$page = get_page_by_path( 'services' );
	if ( $page ) {
		$url = get_permalink( $page );
		if ( $hash ) {
			$url = trailingslashit( $url ) . '#' . ltrim( $hash, '#' );
		}
		return $url;
	}

	return trailingslashit( home_url( '/' ) ) . '#services';
}

function advay_pricing_rows() {
	return array(
		array( 'cat' => 'prep', 'service' => __( 'Item prep, 1–1,000 / month', 'advay-theme' ), 'type' => 'standard', 'volume' => '1–1,000', 'uom' => __( 'Unit', 'advay-theme' ), 'charge' => '$1.00', 'notes' => '' ),
		array( 'cat' => 'prep', 'service' => __( 'Item prep, 1,001–5,000 / month', 'advay-theme' ), 'type' => 'standard', 'volume' => '1,001–5,000', 'uom' => __( 'Unit', 'advay-theme' ), 'charge' => '$0.85', 'notes' => '' ),
		array( 'cat' => 'prep', 'service' => __( 'Item prep, 5,001+ / month', 'advay-theme' ), 'type' => 'standard', 'volume' => '5,001+', 'uom' => __( 'Unit', 'advay-theme' ), 'charge' => '$0.70', 'notes' => '' ),
		array( 'cat' => 'prep', 'service' => __( 'Bundle / multi-pack', 'advay-theme' ), 'type' => 'standard', 'volume' => 'N/A', 'uom' => __( 'Unit', 'advay-theme' ), 'charge' => '$0.75', 'notes' => __( 'In addition to item prep.', 'advay-theme' ) ),
		array( 'cat' => 'prep', 'service' => __( 'FNSKU labeling', 'advay-theme' ), 'type' => 'standard', 'volume' => 'N/A', 'uom' => __( 'Unit', 'advay-theme' ), 'charge' => '$0.25', 'notes' => '' ),
		array( 'cat' => 'prep', 'service' => __( 'Polybag', 'advay-theme' ), 'type' => 'standard', 'volume' => 'N/A', 'uom' => __( 'Unit', 'advay-theme' ), 'charge' => '$0.20', 'notes' => '' ),
		array( 'cat' => 'prep', 'service' => __( 'Suffocation warning', 'advay-theme' ), 'type' => 'standard', 'volume' => 'N/A', 'uom' => __( 'Unit', 'advay-theme' ), 'charge' => '$0.10', 'notes' => '' ),
		array( 'cat' => 'prep', 'service' => __( 'Inspection', 'advay-theme' ), 'type' => 'standard', 'volume' => 'N/A', 'uom' => __( 'Unit', 'advay-theme' ), 'charge' => '$0.35', 'notes' => '' ),
		array( 'cat' => 'prep', 'service' => __( 'Fragile / bubble wrap', 'advay-theme' ), 'type' => 'addon', 'volume' => 'N/A', 'uom' => __( 'Unit', 'advay-theme' ), 'charge' => '$0.55', 'notes' => __( 'Added per unit.', 'advay-theme' ) ),
		array( 'cat' => 'prep', 'service' => __( 'Inserts', 'advay-theme' ), 'type' => 'addon', 'volume' => 'N/A', 'uom' => __( 'Unit', 'advay-theme' ), 'charge' => '$0.30', 'notes' => '' ),
		array( 'cat' => 'prep', 'service' => __( 'Product photos', 'advay-theme' ), 'type' => 'addon', 'volume' => 'N/A', 'uom' => __( 'Unit', 'advay-theme' ), 'charge' => '$1.50', 'notes' => '' ),
		array( 'cat' => 'prep', 'service' => __( 'Relabel', 'advay-theme' ), 'type' => 'addon', 'volume' => 'N/A', 'uom' => __( 'Unit', 'advay-theme' ), 'charge' => '$0.40', 'notes' => '' ),
		array( 'cat' => 'prep', 'service' => __( 'Carton rebuild', 'advay-theme' ), 'type' => 'addon', 'volume' => 'N/A', 'uom' => __( 'Carton', 'advay-theme' ), 'charge' => '$1.50', 'notes' => '' ),
		array( 'cat' => 'inbound', 'service' => __( 'Carton receive', 'advay-theme' ), 'type' => 'standard', 'volume' => 'N/A', 'uom' => __( 'Carton', 'advay-theme' ), 'charge' => '$1.25', 'notes' => '' ),
		array( 'cat' => 'inbound', 'service' => __( 'Pallet receive', 'advay-theme' ), 'type' => 'standard', 'volume' => 'N/A', 'uom' => __( 'Pallet', 'advay-theme' ), 'charge' => '$12.00', 'notes' => '' ),
		array( 'cat' => 'inbound', 'service' => __( '20ft container unload', 'advay-theme' ), 'type' => 'addon', 'volume' => 'N/A', 'uom' => __( 'Container', 'advay-theme' ), 'charge' => '$315.00', 'notes' => '' ),
		array( 'cat' => 'inbound', 'service' => __( '40ft container unload', 'advay-theme' ), 'type' => 'addon', 'volume' => 'N/A', 'uom' => __( 'Container', 'advay-theme' ), 'charge' => '$475.00', 'notes' => '' ),
		array( 'cat' => 'inbound', 'service' => __( 'Truck unload', 'advay-theme' ), 'type' => 'addon', 'volume' => 'N/A', 'uom' => __( 'Truck', 'advay-theme' ), 'charge' => '$185.00', 'notes' => '' ),
		array( 'cat' => 'storage', 'service' => __( 'Pallet storage', 'advay-theme' ), 'type' => 'addon', 'volume' => 'N/A', 'uom' => __( 'Pallet', 'advay-theme' ), 'charge' => '$40.00', 'notes' => __( 'Billed monthly after inventory is on hand more than 30 days.', 'advay-theme' ) ),
		array( 'cat' => 'storage', 'service' => __( 'Carton storage', 'advay-theme' ), 'type' => 'addon', 'volume' => 'N/A', 'uom' => __( 'Carton', 'advay-theme' ), 'charge' => '$4.00', 'notes' => __( 'Billed monthly after 30 days.', 'advay-theme' ) ),
		array( 'cat' => 'outbound', 'service' => __( 'FBM pick & pack', 'advay-theme' ), 'type' => 'standard', 'volume' => 'N/A', 'uom' => __( 'Unit', 'advay-theme' ), 'charge' => '$2.50', 'notes' => '' ),
		array( 'cat' => 'outbound', 'service' => __( 'Carton outbound', 'advay-theme' ), 'type' => 'standard', 'volume' => 'N/A', 'uom' => __( 'Carton', 'advay-theme' ), 'charge' => '$3.50', 'notes' => '' ),
		array( 'cat' => 'outbound', 'service' => __( 'Pallet outbound', 'advay-theme' ), 'type' => 'standard', 'volume' => 'N/A', 'uom' => __( 'Pallet', 'advay-theme' ), 'charge' => '$18.00', 'notes' => '' ),
		array( 'cat' => 'labor', 'service' => __( 'Rush / weekend work', 'advay-theme' ), 'type' => 'addon', 'volume' => 'N/A', 'uom' => __( 'Hourly', 'advay-theme' ), 'charge' => '$90.00', 'notes' => __( 'Two-hour minimum.', 'advay-theme' ) ),
		array( 'cat' => 'labor', 'service' => __( 'Special project labor', 'advay-theme' ), 'type' => 'addon', 'volume' => 'N/A', 'uom' => __( '15 min', 'advay-theme' ), 'charge' => '$22.50', 'notes' => __( 'Billed in 15-minute increments.', 'advay-theme' ) ),
		array( 'cat' => 'labor', 'service' => __( 'Returns inspection', 'advay-theme' ), 'type' => 'addon', 'volume' => 'N/A', 'uom' => __( 'Unit', 'advay-theme' ), 'charge' => '$1.75', 'notes' => '' ),
		array( 'cat' => 'labor', 'service' => __( 'Disposal', 'advay-theme' ), 'type' => 'addon', 'volume' => 'N/A', 'uom' => __( 'Unit', 'advay-theme' ), 'charge' => '$0.50', 'notes' => '' ),
		array( 'cat' => 'labor', 'service' => __( 'High-volume program', 'advay-theme' ), 'type' => 'standard', 'volume' => 'N/A', 'uom' => __( 'Unit', 'advay-theme' ), 'charge' => __( 'Custom', 'advay-theme' ), 'notes' => __( 'Ask for a SKU-level quote.', 'advay-theme' ) ),
	);
}

function advay_blog_url() {
	$posts_page = (int) get_option( 'page_for_posts' );
	if ( $posts_page ) {
		return get_permalink( $posts_page );
	}

	$page = get_page_by_path( 'blog' );
	if ( $page ) {
		return get_permalink( $page );
	}

	$link = get_post_type_archive_link( 'post' );
	if ( $link && untrailingslashit( $link ) !== untrailingslashit( home_url( '/' ) ) ) {
		return $link;
	}

	return home_url( '/blog/' );
}

function advay_asset_uri( $relative ) {
	return get_template_directory_uri() . '/assets/' . ltrim( $relative, '/' );
}

function advay_logo_url() {
	return advay_asset_uri( 'images/logo.png' );
}

/**
 * Marketplace hero videos. Local mp4 files in assets/video/ win if present.
 * Remote clips are used only when local mp4 files are absent.
 */
function advay_hero_channels() {
	$base   = advay_asset_uri( 'video/' );
	$folder = get_template_directory() . '/assets/video/';
	$remote = array(
		'amazon'  => 'https://videos.pexels.com/video-files/4484078/4484078-sd_640_360_25fps.mp4',
		'walmart' => 'https://videos.pexels.com/video-files/6169118/6169118-sd_640_360_24fps.mp4',
		'tiktok'  => 'https://videos.pexels.com/video-files/3195394/3195394-sd_640_360_25fps.mp4',
		'dtc'     => 'https://videos.pexels.com/video-files/3195394/3195394-sd_640_360_25fps.mp4',
	);

	$channels = array(
		array(
			'id'    => 'amazon',
			'label' => __( 'Amazon FBA', 'advay-theme' ),
			'logo'  => advay_asset_uri( 'images/amazon.svg' ),
		),
		array(
			'id'    => 'walmart',
			'label' => __( 'Walmart WFS', 'advay-theme' ),
			'logo'  => advay_asset_uri( 'images/walmart.svg' ),
		),
		array(
			'id'    => 'tiktok',
			'label' => __( 'TikTok Shop', 'advay-theme' ),
			'logo'  => advay_asset_uri( 'images/tiktok.svg' ),
		),
		array(
			'id'       => 'dtc',
			'label'    => __( 'DTC Fulfillment', 'advay-theme' ),
			'logo'     => '',
			'wordmark' => __( 'DTC', 'advay-theme' ),
		),
	);

	foreach ( $channels as &$channel ) {
		$id         = $channel['id'];
		$candidates = array( $id . '.mp4', strtoupper( $id ) . '.mp4', ucfirst( $id ) . '.mp4' );
		$found      = '';
		foreach ( $candidates as $name ) {
			if ( file_exists( $folder . $name ) ) {
				$found = $name;
				break;
			}
		}
		if ( $found ) {
			$channel['video'] = $base . $found . '?v=' . filemtime( $folder . $found );
		} else {
			$channel['video'] = $remote[ $id ];
		}
	}
	unset( $channel );

	return $channels;
}

/**
 * Story videos. Drop files at assets/video/testimonials/{slug}.mp4 to replace demos.
 */
function advay_story_video( $slug ) {
	$file = get_template_directory() . '/assets/video/testimonials/' . $slug . '.mp4';
	if ( file_exists( $file ) ) {
		return advay_asset_uri( 'video/testimonials/' . $slug . '.mp4' );
	}

	$demo = array(
		'tall'   => 'https://videos.pexels.com/video-files/3209298/3209298-sd_640_360_25fps.mp4',
		'square' => 'https://videos.pexels.com/video-files/3195394/3195394-sd_640_360_25fps.mp4',
	);

	return isset( $demo[ $slug ] ) ? $demo[ $slug ] : '';
}
