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

define( 'ADVAY_THEME_VERSION', '2.21.1' );

require get_template_directory() . '/inc/success-stories.php';

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
		'https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:wght@500;600&family=Inter:wght@400;500;600;700;800&family=Space+Grotesk:wght@500;600;700&display=swap',
		array(),
		null
	);

	wp_enqueue_style(
		'advay-style',
		get_stylesheet_uri(),
		array( 'advay-fonts' ),
		ADVAY_THEME_VERSION
	);

	if ( is_front_page() || advay_is_onboarding_page() || advay_is_receiving_page() ) {
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
	}

	$theme_deps = is_front_page() ? array( 'leaflet' ) : array();
	wp_enqueue_script(
		'advay-theme',
		get_template_directory_uri() . '/assets/js/theme.js',
		$theme_deps,
		ADVAY_THEME_VERSION,
		true
	);

	if ( advay_is_onboarding_page() ) {
		wp_enqueue_script(
			'advay-onboarding',
			get_template_directory_uri() . '/assets/js/onboarding.js',
			array( 'gsap-scrolltrigger', 'advay-theme' ),
			ADVAY_THEME_VERSION,
			true
		);
	}

	if ( advay_is_receiving_page() ) {
		/* Sticky+scroll journey works without GSAP; GSAP is optional polish. */
		wp_enqueue_script(
			'advay-warehouse-journey',
			get_template_directory_uri() . '/assets/js/warehouse-journey.js',
			array( 'advay-theme' ),
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
		array( 'label' => __( 'Onboarding', 'advay-theme' ), 'url' => advay_onboarding_url() ),
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

function advay_intake_email_url() {
	return apply_filters( 'advay_contact_email_url', 'mailto:hello@eliteprepcenter.com' );
}

function advay_intake_phone_url() {
	return apply_filters( 'advay_contact_call_url', 'tel:+18555550199' );
}

/**
 * Floating dock — MD phone display and dial link.
 */
function advay_dock_phone_label() {
	return apply_filters( 'advay_dock_phone_label', '+1 (212) 814-8815' );
}

function advay_dock_phone_url() {
	return apply_filters( 'advay_dock_phone_url', 'tel:+12128148815' );
}

/**
 * Floating dock — MD email.
 */
function advay_dock_email_label() {
	return apply_filters( 'advay_dock_email_label', 'odi@eliteprepcenter.com' );
}

function advay_dock_email_url() {
	return apply_filters( 'advay_dock_email_url', 'mailto:odi@eliteprepcenter.com' );
}

/**
 * Floating dock — Calendly / Google Meet booking.
 */
function advay_dock_calendly_url() {
	return apply_filters( 'advay_dock_calendly_url', 'https://calendly.com/odi-eliteprepcenter/30min' );
}

/**
 * SVG icons for the floating contact dock.
 *
 * @param string $name Icon key.
 * @return string SVG markup.
 */
function advay_contact_dock_icon( $name ) {
	$attrs = 'viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.85" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"';

	$icons = array(
		'phone' => '<svg ' . $attrs . '><path d="M5 4h4l2 5-2.5 1.5a11 11 0 0 0 5 5L15 13l5 2v4a2 2 0 0 1-2 2A16 16 0 0 1 3 6a2 2 0 0 1 2-2z"/></svg>',
		'email' => '<svg ' . $attrs . '><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/></svg>',
		'meet'  => '<svg ' . $attrs . '><rect x="2" y="5" width="14" height="12" rx="2"/><path d="M16 9.5 22 6v12l-6-3.5"/><path d="M8 10h4"/><path d="M8 14h2"/></svg>',
	);

	return isset( $icons[ $name ] ) ? $icons[ $name ] : $icons['phone'];
}

/**
 * One-click onboarding page URL — existing page slug wins, else /onboarding/ rewrite.
 */
function advay_onboarding_url() {
	$page = get_page_by_path( 'onboarding' );
	if ( $page ) {
		return get_permalink( $page );
	}

	return home_url( '/onboarding/' );
}

/**
 * Our Story page URL.
 */
function advay_our_story_url() {
	$page = get_page_by_path( 'our-story' );
	if ( $page ) {
		return get_permalink( $page );
	}

	return home_url( '/our-story/' );
}

/**
 * Join Our Team page URL.
 */
function advay_join_team_url() {
	$page = get_page_by_path( 'join-our-team' );
	if ( $page ) {
		return get_permalink( $page );
	}

	return home_url( '/join-our-team/' );
}

/**
 * Managing Director profile page URL.
 */
function advay_managing_director_url() {
	$page = get_page_by_path( 'managing-director' );
	if ( $page ) {
		return get_permalink( $page );
	}

	return home_url( '/managing-director/' );
}

/**
 * Line icons for MD ecosystem flow.
 *
 * @param string $name Icon key.
 * @return string SVG markup.
 */
function advay_md_ecosystem_icon( $name ) {
	$attrs = 'viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"';

	$icons = array(
		'brands'         => '<svg ' . $attrs . '><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>',
		'manufacturing'  => '<svg ' . $attrs . '><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 1 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 1 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 1 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 1 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>',
		'supply'         => '<svg ' . $attrs . '><path d="M12 2 3 7v10l9 5 9-5V7z"/><path d="M3 7l9 5 9-5"/><path d="M12 12v10"/></svg>',
		'distribution'   => '<svg ' . $attrs . '><path d="M3 7h11v9H3z"/><path d="M14 10h3l3 3v3h-6"/><circle cx="7.5" cy="18.5" r="1.75"/><circle cx="17.5" cy="18.5" r="1.75"/></svg>',
		'customers'      => '<svg ' . $attrs . '><circle cx="9" cy="8" r="2.5"/><circle cx="16" cy="9" r="2"/><path d="M4 19c0-2.5 2.2-4 5-4s5 1.5 5 4"/><path d="M14 19c0-1.8 1.3-3 3.5-3"/></svg>',
		'sourcing'       => '<svg ' . $attrs . '><path d="M12 22c4-4 8-7.5 8-12a8 8 0 1 0-16 0c0 4.5 4 8 8 12z"/><path d="M12 10v4"/><path d="M12 7h.01"/></svg>',
		'quality'        => '<svg ' . $attrs . '><path d="M12 3 4 7v6c0 4.5 3.4 7.7 8 9 4.6-1.3 8-4.5 8-9V7z"/><path d="M9.5 12.5 11 14l3.5-3.5"/></svg>',
		'warehousing'    => '<svg ' . $attrs . '><path d="M3 10h18"/><path d="M5 10V19h14V10"/><path d="M9 10V6h6v4"/><path d="M12 3v4"/></svg>',
		'market'         => '<svg ' . $attrs . '><circle cx="12" cy="12" r="9"/><path d="M3 12h18"/><path d="M12 3a15 15 0 0 1 0 18"/><path d="M12 3a15 15 0 0 0 0 18"/></svg>',
		'longterm'       => '<svg ' . $attrs . '><path d="M12 3v18"/><path d="M7 8h10"/><path d="M7 16h10"/><path d="M5 12h14"/></svg>',
		'own'            => '<svg ' . $attrs . '><rect x="4" y="8" width="16" height="12" rx="2"/><path d="M8 8V6a4 4 0 0 1 8 0v2"/></svg>',
		'people'         => '<svg ' . $attrs . '><circle cx="12" cy="8" r="3"/><path d="M5 20c0-3.3 3.1-6 7-6s7 2.7 7 6"/></svg>',
		'curious'        => '<svg ' . $attrs . '><circle cx="11" cy="11" r="7"/><path d="M21 21l-4.3-4.3"/></svg>',
		'empower'        => '<svg ' . $attrs . '><path d="M12 2v4"/><path d="M8 4h8"/><path d="M7 8h10l-1 12H8z"/></svg>',
		'community'      => '<svg ' . $attrs . '><path d="M3 9l9-6 9 6v11H3z"/><path d="M9 20V12h6v8"/></svg>',
		'future'         => '<svg ' . $attrs . '><path d="M12 3v18"/><path d="M7 8l5-5 5 5"/></svg>',
		'rocket'         => '<svg ' . $attrs . '><path d="M4.5 16.5c-1.5 4.5 0 6 4.5 4.5 4.5-1.5 6 0 4.5-4.5-4.5-4.5-6-4.5-4.5 0z"/><path d="M12 15l3-3"/><path d="M9 12l6-6 3 3-6 6"/></svg>',
		'ventures'       => '<svg ' . $attrs . '><path d="M3 21h18"/><path d="M6 21V9l6-4 6 4v12"/><path d="M10 21v-6h4v6"/></svg>',
		'mentor'         => '<svg ' . $attrs . '><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c0 2 2.7 3 6 3s6-1 6-3v-5"/></svg>',
	);

	return isset( $icons[ $name ] ) ? $icons[ $name ] : $icons['supply'];
}

function advay_onboarding_icon( $name ) {
	$icons = array(
		'phone'  => '<svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.75" aria-hidden="true"><path d="M5 4h4l2 5-2.5 1.5a11 11 0 0 0 5 5L15 13l5 2v4a2 2 0 0 1-2 2A16 16 0 0 1 3 6a2 2 0 0 1 2-2z"/></svg>',
		'gear'   => '<svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.75" aria-hidden="true"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 1 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 1 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 1 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 1 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>',
		'screen' => '<svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.75" aria-hidden="true"><rect x="3" y="4" width="18" height="12" rx="2"/><path d="M8 20h8M12 16v4"/></svg>',
		'box'    => '<svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.75" aria-hidden="true"><path d="M12 2 3 7v10l9 5 9-5V7z"/><path d="M3 7l9 5 9-5M12 12v10"/></svg>',
	);

	echo isset( $icons[ $name ] ) ? $icons[ $name ] : $icons['box']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

/**
 * Line icons for homepage hub (flow steps, facts, onboarding).
 *
 * @param string $name Icon key.
 * @param int    $size Pixel size.
 * @return string SVG markup.
 */
function advay_home_hub_icon( $name, $size = 22 ) {
	$attrs = sprintf(
		'viewBox="0 0 24 24" width="%1$d" height="%1$d" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"',
		(int) $size
	);

	$icons = array(
		'warehouse' => '<svg ' . $attrs . '><path d="M3 10h18"/><path d="M5 10V19h14V10"/><path d="M9 10V6h6v4"/><path d="M12 3v4"/><circle cx="12" cy="15" r="1.5" fill="currentColor" stroke="none"/></svg>',
		'receive'   => '<svg ' . $attrs . '><path d="M4 8h16v11H4z"/><path d="M8 8V5h8v3"/><path d="M12 12v4"/><path d="M10 14l2 2 2-2"/></svg>',
		'prep'      => '<svg ' . $attrs . '><path d="M8 4h8a1 1 0 0 1 1 1v1H7V5a1 1 0 0 1 1-1z"/><rect x="7" y="6" width="10" height="14" rx="1.5"/><path d="M10 11h4"/><path d="M10 14h4"/><path d="M10 17h2"/></svg>',
		'pack'      => '<svg ' . $attrs . '><path d="M12 2 3 7v10l9 5 9-5V7z"/><path d="M3 7l9 5 9-5"/><path d="M12 12v10"/></svg>',
		'ship'      => '<svg ' . $attrs . '><path d="M3 7h11v9H3z"/><path d="M14 10h3l3 3v3h-6"/><circle cx="7.5" cy="18.5" r="1.75"/><circle cx="17.5" cy="18.5" r="1.75"/></svg>',
		'report'    => '<svg ' . $attrs . '><path d="M7 4h7l4 4v12H7z"/><path d="M14 4v4h4"/><path d="M10 13v5"/><path d="M13 11v7"/><path d="M16 15v3"/></svg>',
		'experience' => '<svg ' . $attrs . '><circle cx="12" cy="12" r="8"/><path d="M12 8v4l2.5 2"/></svg>',
		'units'      => '<svg ' . $attrs . '><path d="M3 15h7v5H3z"/><path d="M7 11h7v9H7z"/><path d="M11 7h7v13h-7z"/></svg>',
		'tat'        => '<svg ' . $attrs . '><path d="M9 3h6"/><path d="M12 3v2"/><circle cx="12" cy="14" r="7"/><path d="M12 14V10"/><path d="M12 14l2.5 2"/></svg>',
		'people'    => '<svg ' . $attrs . '><circle cx="9" cy="8" r="2.5"/><circle cx="16" cy="9" r="2"/><path d="M4 19c0-2.5 2.2-4 5-4s5 1.5 5 4"/><path d="M14 19c0-1.8 1.3-3 3.5-3"/></svg>',
		'box'       => '<svg ' . $attrs . '><path d="M12 2 3 7v10l9 5 9-5V7z"/><path d="M3 7l9 5 9-5"/></svg>',
		'target'    => '<svg ' . $attrs . '><circle cx="12" cy="12" r="8"/><circle cx="12" cy="12" r="4"/><circle cx="12" cy="12" r="1" fill="currentColor" stroke="none"/></svg>',
		'sku'       => '<svg ' . $attrs . '><path d="M7 4h7l4 4v12H7z"/><path d="M14 4v4h4"/><path d="M10 12l2 2 4-4"/></svg>',
		'inbound'   => '<svg ' . $attrs . '><path d="M3 7h11v9H3z"/><path d="M14 10h3l3 3v3h-6"/><circle cx="7.5" cy="18.5" r="1.75"/><circle cx="17.5" cy="18.5" r="1.75"/></svg>',
		'forward'   => '<svg ' . $attrs . '><path d="M3 12h13"/><path d="M12 7l5 5-5 5"/><path d="M19 5v14"/></svg>',
		'shield'    => '<svg ' . $attrs . '><path d="M12 3 4 7v6c0 4.5 3.4 7.7 8 9 4.6-1.3 8-4.5 8-9V7z"/><path d="M9.5 12.5 11 14l3.5-3.5"/></svg>',
		'funnel'    => '<svg ' . $attrs . '><path d="M5 4h14l-5.5 6.5V18l-3 1.5V10.5z"/></svg>',
		'growth'    => '<svg ' . $attrs . '><path d="M4 18h16"/><path d="M6 14l3-3 3 2 4-4 3-2"/><path d="M17 7h3v3"/></svg>',
		'chart-bars' => '<svg ' . $attrs . '><path d="M5 19V12"/><path d="M9 19V9"/><path d="M13 19V14"/><path d="M17 19V7"/><path d="M6 10l2.5-2.5 2.5 2 3.5-4.5"/></svg>',
		'arrow-circle' => '<svg ' . $attrs . '><circle cx="12" cy="12" r="8"/><path d="M9 15l6-6"/><path d="M11 9h4v4"/></svg>',
		'clock-circle' => '<svg ' . $attrs . '><circle cx="12" cy="12" r="8"/><path d="M12 8v4.5l2.5 2.5"/></svg>',
		'insight-head' => '<svg ' . $attrs . '><path d="M8 20h8"/><path d="M12 20v-2"/><path d="M7 14c-2.2-1.6-3.5-4-3.5-6.8C3.5 4.5 7.2 2 12 2s8.5 2.5 8.5 5.2c0 2.8-1.3 5.2-3.5 6.8"/><path d="M12 6.5a2.5 2.5 0 0 0-2.5 2.5c0 1.2.6 2 1.5 2.5"/><path d="M12 6.5a2.5 2.5 0 0 1 2.5 2.5c0 1.2-.6 2-1.5 2.5"/><path d="M12 11v2.5"/></svg>',
		'warn-triangle' => '<svg ' . $attrs . '><path d="M12 4 3 19h18L12 4z"/><path d="M12 9v4"/><circle cx="12" cy="15.5" r="0.75" fill="currentColor" stroke="none"/></svg>',
		'dollar-circle' => '<svg ' . $attrs . '><circle cx="12" cy="12" r="8"/><path d="M12 7.5v9"/><path d="M9.5 10c0-1 1-1.5 2.5-1.5s2.5.5 2.5 1.5-1 1.5-2.5 1.5-2.5.5-2.5 1.5 1 1.5 2.5 1.5 2.5-.5 2.5-1.5"/></svg>',
	);

	$icon = isset( $icons[ $name ] ) ? $icons[ $name ] : $icons['box'];

	return $icon;
}

function advay_register_onboarding_route() {
	add_rewrite_rule( '^onboarding/?$', 'index.php?advay_onboarding=1', 'top' );
	add_rewrite_rule( '^blog/?$', 'index.php?advay_blog=1', 'top' );
	add_rewrite_rule( '^blog/page/([0-9]{1,})/?$', 'index.php?advay_blog=1&paged=$matches[1]', 'top' );
	add_rewrite_rule( '^receiving/?$', 'index.php?advay_receiving=1', 'top' );
	add_rewrite_rule( '^our-story/?$', 'index.php?advay_our_story=1', 'top' );
	add_rewrite_rule( '^join-our-team/?$', 'index.php?advay_join_team=1', 'top' );
	add_rewrite_rule( '^managing-director/?$', 'index.php?advay_managing_director=1', 'top' );
	add_rewrite_rule( '^success-stories/([^/]+)/?$', 'index.php?advay_success_story=$matches[1]', 'top' );
}
add_action( 'init', 'advay_register_onboarding_route' );

function advay_onboarding_query_var( $vars ) {
	$vars[] = 'advay_onboarding';
	$vars[] = 'advay_blog';
	$vars[] = 'advay_receiving';
	$vars[] = 'advay_our_story';
	$vars[] = 'advay_join_team';
	$vars[] = 'advay_managing_director';
	$vars[] = 'advay_success_story';
	return $vars;
}
add_filter( 'query_vars', 'advay_onboarding_query_var' );

function advay_custom_page_template( $template ) {
	if ( (int) get_query_var( 'advay_onboarding' ) === 1 ) {
		$onboarding = get_template_directory() . '/page-onboarding.php';
		if ( file_exists( $onboarding ) ) {
			return $onboarding;
		}
	}

	if ( (int) get_query_var( 'advay_blog' ) === 1 ) {
		$blog = get_template_directory() . '/page-blog.php';
		if ( file_exists( $blog ) ) {
			return $blog;
		}
	}

	if ( (int) get_query_var( 'advay_receiving' ) === 1 ) {
		$receiving = get_template_directory() . '/page-receiving.php';
		if ( file_exists( $receiving ) ) {
			return $receiving;
		}
	}

	if ( (int) get_query_var( 'advay_our_story' ) === 1 ) {
		$story = get_template_directory() . '/page-our-story.php';
		if ( file_exists( $story ) ) {
			return $story;
		}
	}

	if ( (int) get_query_var( 'advay_join_team' ) === 1 ) {
		$join = get_template_directory() . '/page-join-team.php';
		if ( file_exists( $join ) ) {
			return $join;
		}
	}

	if ( (int) get_query_var( 'advay_managing_director' ) === 1 ) {
		$md = get_template_directory() . '/page-managing-director.php';
		if ( file_exists( $md ) ) {
			return $md;
		}
	}

	$success_story = sanitize_key( (string) get_query_var( 'advay_success_story' ) );
	if ( $success_story && advay_success_story_exists( $success_story ) ) {
		$ss = get_template_directory() . '/page-success-story.php';
		if ( file_exists( $ss ) ) {
			return $ss;
		}
	}

	return $template;
}
add_filter( 'template_include', 'advay_custom_page_template' );

function advay_flush_onboarding_rewrite() {
	advay_register_onboarding_route();
	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'advay_flush_onboarding_rewrite' );

function advay_maybe_flush_onboarding_rewrite() {
	if ( get_option( 'advay_routes_flushed' ) !== ADVAY_THEME_VERSION ) {
		advay_flush_onboarding_rewrite();
		update_option( 'advay_routes_flushed', ADVAY_THEME_VERSION );
		// Clean up legacy option key.
		delete_option( 'advay_onboarding_rewrite_flushed' );
	}
}
add_action( 'init', 'advay_maybe_flush_onboarding_rewrite', 99 );

function advay_is_onboarding_page() {
	return (int) get_query_var( 'advay_onboarding' ) === 1;
}

function advay_is_blog_page() {
	return (int) get_query_var( 'advay_blog' ) === 1;
}

function advay_is_receiving_page() {
	if ( (int) get_query_var( 'advay_receiving' ) === 1 ) {
		return true;
	}
	/* Real WP page with slug "receiving" also uses page-receiving.php */
	return function_exists( 'is_page' ) && is_page( 'receiving' );
}

function advay_is_our_story_page() {
	if ( (int) get_query_var( 'advay_our_story' ) === 1 ) {
		return true;
	}

	return function_exists( 'is_page' ) && is_page( 'our-story' );
}

function advay_is_join_team_page() {
	if ( (int) get_query_var( 'advay_join_team' ) === 1 ) {
		return true;
	}

	return function_exists( 'is_page' ) && is_page( 'join-our-team' );
}

function advay_is_managing_director_page() {
	if ( (int) get_query_var( 'advay_managing_director' ) === 1 ) {
		return true;
	}

	return function_exists( 'is_page' ) && is_page( 'managing-director' );
}

function advay_is_success_story_page() {
	$slug = sanitize_key( (string) get_query_var( 'advay_success_story' ) );
	return '' !== $slug && advay_success_story_exists( $slug );
}

/**
 * Success story page URL.
 *
 * @param string $slug Story slug.
 */
function advay_success_story_url( $slug = 'no-knife-body' ) {
	$slug = sanitize_key( $slug );
	if ( ! advay_success_story_exists( $slug ) ) {
		$slug = 'no-knife-body';
	}

	return home_url( '/success-stories/' . $slug . '/' );
}

/**
 * Custom rewrite routes must not inherit the front-page / home query flags.
 * Without this, /receiving/ loads with body.home and homepage assets (Leaflet).
 */
function advay_fix_custom_route_query( $query ) {
	if ( is_admin() || ! $query->is_main_query() ) {
		return;
	}

	$onboarding = (int) $query->get( 'advay_onboarding' ) === 1;
	$blog       = (int) $query->get( 'advay_blog' ) === 1;
	$receiving  = (int) $query->get( 'advay_receiving' ) === 1;
	$our_story  = (int) $query->get( 'advay_our_story' ) === 1;
	$join_team  = (int) $query->get( 'advay_join_team' ) === 1;
	$md_page    = (int) $query->get( 'advay_managing_director' ) === 1;
	$ss_page    = '' !== sanitize_key( (string) $query->get( 'advay_success_story' ) );

	if ( ! $onboarding && ! $blog && ! $receiving && ! $our_story && ! $join_team && ! $md_page && ! $ss_page ) {
		return;
	}

	$query->is_home       = false;
	$query->is_front_page = false;
	$query->is_archive    = false;
	$query->is_singular   = true;
	$query->is_page       = true;
}
add_action( 'parse_query', 'advay_fix_custom_route_query' );

/**
 * Body classes for custom routes (strip misleading home/blog).
 */
function advay_custom_route_body_class( $classes ) {
	if ( advay_is_receiving_page() ) {
		$classes   = array_values( array_diff( $classes, array( 'home', 'blog' ) ) );
		$classes[] = 'page-receiving';
		$classes[] = 'wj-journey';
		/* Keep warehouse journey assets even when rewrite var is absent. */
	}

	if ( advay_is_onboarding_page() ) {
		$classes   = array_values( array_diff( $classes, array( 'home', 'blog' ) ) );
		$classes[] = 'page-onboarding';
	}

	if ( advay_is_blog_page() ) {
		$classes   = array_values( array_diff( $classes, array( 'home' ) ) );
		$classes[] = 'page-blog-custom';
	}

	if ( advay_is_our_story_page() ) {
		$classes   = array_values( array_diff( $classes, array( 'home', 'blog' ) ) );
		$classes[] = 'page-our-story';
	}

	if ( advay_is_join_team_page() ) {
		$classes   = array_values( array_diff( $classes, array( 'home', 'blog' ) ) );
		$classes[] = 'page-join-team';
	}

	if ( advay_is_managing_director_page() ) {
		$classes   = array_values( array_diff( $classes, array( 'home', 'blog' ) ) );
		$classes[] = 'page-managing-director';
	}

	if ( advay_is_success_story_page() ) {
		$classes   = array_values( array_diff( $classes, array( 'home', 'blog' ) ) );
		$classes[] = 'page-success-story';
	}

	return $classes;
}
add_filter( 'body_class', 'advay_custom_route_body_class' );

/**
 * Page title for custom routes.
 */
function advay_custom_route_document_title( $parts ) {
	if ( advay_is_managing_director_page() ) {
		$parts['title'] = __( 'Odi Ikpe', 'advay-theme' );
		$parts['tagline'] = __( 'Managing Director', 'advay-theme' );
	}

	if ( advay_is_success_story_page() ) {
		$story = advay_get_success_story( sanitize_key( (string) get_query_var( 'advay_success_story' ) ) );
		$parts['title'] = $story['brand'];
		$parts['tagline'] = __( 'Success Story', 'advay-theme' );
	}

	return $parts;
}
add_filter( 'document_title_parts', 'advay_custom_route_document_title' );

/**
 * Receiving / warehouse journey page URL.
 */
function advay_receiving_url( $hash = '' ) {
	$page = get_page_by_path( 'receiving' );
	$base = $page ? get_permalink( $page ) : home_url( '/receiving/' );
	if ( $hash ) {
		return trailingslashit( $base ) . '#' . ltrim( $hash, '#' );
	}
	return $base;
}

function advay_receiving_document_title( $title ) {
	if ( advay_is_receiving_page() ) {
		$title['title'] = __( 'Receiving & Inspection', 'advay-theme' );
	}
	return $title;
}
add_filter( 'document_title_parts', 'advay_receiving_document_title' );

/**
 * Custom SEO title for single posts (from Doc SEO pack / seeder).
 *
 * @param array $parts Title parts.
 * @return array
 */
function advay_seo_document_title( $parts ) {
	if ( ! is_singular( 'post' ) ) {
		return $parts;
	}
	$custom = get_post_meta( get_the_ID(), '_advay_seo_title', true );
	if ( is_string( $custom ) && '' !== trim( $custom ) ) {
		$parts['title'] = $custom;
	}
	return $parts;
}
add_filter( 'document_title_parts', 'advay_seo_document_title', 20 );

/**
 * Meta description + basic Article schema for blog posts.
 */
function advay_seo_head_tags() {
	if ( ! is_singular( 'post' ) ) {
		return;
	}
	$post_id = get_the_ID();
	$desc    = get_post_meta( $post_id, '_advay_seo_description', true );
	if ( ! is_string( $desc ) || '' === trim( $desc ) ) {
		$desc = has_excerpt( $post_id ) ? get_the_excerpt( $post_id ) : wp_trim_words( wp_strip_all_tags( get_post_field( 'post_content', $post_id ) ), 28 );
	}
	$desc = wp_strip_all_tags( $desc );
	if ( $desc ) {
		echo '<meta name="description" content="' . esc_attr( $desc ) . '" />' . "\n";
	}

	$schema = array(
		'@context'         => 'https://schema.org',
		'@type'            => 'Article',
		'headline'         => get_the_title( $post_id ),
		'datePublished'    => get_the_date( 'c', $post_id ),
		'dateModified'     => get_the_modified_date( 'c', $post_id ),
		'mainEntityOfPage' => get_permalink( $post_id ),
		'author'           => array(
			'@type' => 'Organization',
			'name'  => get_bloginfo( 'name' ),
		),
		'publisher'        => array(
			'@type' => 'Organization',
			'name'  => get_bloginfo( 'name' ),
		),
	);
	if ( $desc ) {
		$schema['description'] = $desc;
	}
	if ( has_post_thumbnail( $post_id ) ) {
		$schema['image'] = array( get_the_post_thumbnail_url( $post_id, 'full' ) );
	}
	echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>' . "\n";
}
add_action( 'wp_head', 'advay_seo_head_tags', 5 );

function advay_pricing_url() {
	$page = get_page_by_path( 'pricing' );
	return $page ? get_permalink( $page ) : trailingslashit( home_url( '/' ) );
}

function advay_services_url( $hash = '' ) {
	$hash = ltrim( (string) $hash, '#' );

	$journey_hashes = array( 'receiving', 'labeling', 'kitting', 'outbound', 'returns' );
	if ( in_array( $hash, $journey_hashes, true ) ) {
		return advay_receiving_url( $hash );
	}

	$page = get_page_by_path( 'services' );
	if ( $page ) {
		$url = get_permalink( $page );
		if ( $hash ) {
			$url = trailingslashit( $url ) . '#' . $hash;
		}
		return $url;
	}

	if ( 'platforms' === $hash ) {
		return trailingslashit( home_url( '/' ) ) . '#services';
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
	if ( advay_is_blog_page() ) {
		return home_url( '/blog/' );
	}

	$posts_page = (int) get_option( 'page_for_posts' );
	if ( $posts_page ) {
		return get_permalink( $posts_page );
	}

	$page = get_page_by_path( 'blog' );
	if ( $page ) {
		return get_permalink( $page );
	}

	return home_url( '/blog/' );
}

/**
 * Evergreen demo posts for /blog/ mega menu + empty archive fallback.
 *
 * @return array<int, array<string, string>>
 */
function advay_demo_blog_posts() {
	$blog = advay_blog_url();

	return array(
		array(
			'slug'      => 'fba-walmart-wfs-prep-playbooks',
			'title'     => __( 'FBA & Walmart WFS prep playbooks for growing brands', 'advay-theme' ),
			'excerpt'   => __( 'How lean sellers keep inbound moving when Amazon and Walmart rules change — labels, polybags, expiration dates, and what to fix before your next shipment.', 'advay-theme' ),
			'content'   => __( "Inbound mistakes are expensive. A missing FNSKU, the wrong polybag thickness, or an expiration date that does not match the ASN can trigger chargebacks before the pallet clears the dock.\n\nThis playbook covers the prep checks ElitePrep runs on every Amazon FBA and Walmart WFS shipment: carton counts, label placement, lot/expiry handling for supplements, and how to catch issues in receiving — not after you have already paid freight.\n\nUse it as a pre-ship checklist whether you prep in-house or hand the work to a 3PL that already knows both marketplaces.", 'advay-theme' ),
			'category'  => __( 'Guides', 'advay-theme' ),
			'read_time' => __( '6 min read', 'advay-theme' ),
			'image'     => 'images/svc-warehouse.jpg',
			'date'      => '2026-07-12 10:00:00',
			'url'       => $blog,
		),
		array(
			'slug'      => 'marketplace-policy-changes-sellers-should-watch',
			'title'     => __( 'Marketplace policy changes sellers should watch', 'advay-theme' ),
			'excerpt'   => __( 'Inbound rule updates, chargeback triggers, and prep specs that catch brands off guard — and how to stay ahead without rebuilding your whole operation.', 'advay-theme' ),
			'content'   => __( "Marketplace prep rules do not stay still. Amazon and Walmart both tighten labeling, packaging, and appointment windows — often with little notice beyond a seller-central banner.\n\nWe track the changes that actually hit prep centers: expiration windows, opaque bag requirements, overbox rules, and LTL appointment SLAs. When a rule shifts, the brands that move first avoid the scramble of rework and rejected loads.\n\nBookmark this roundup and share it with whoever signs off your next inbound.", 'advay-theme' ),
			'category'  => __( 'Updates', 'advay-theme' ),
			'read_time' => __( '5 min read', 'advay-theme' ),
			'image'     => 'images/brand-littlebay.jpg',
			'date'      => '2026-06-28 10:00:00',
			'url'       => $blog,
		),
		array(
			'slug'      => 'scale-fulfillment-without-a-warehouse',
			'title'     => __( 'How lean brands scale fulfillment without running a warehouse', 'advay-theme' ),
			'excerpt'   => __( 'When DIY prep stops working and a generic 3PL starts costing you in chargebacks — what to look for in a partner that actually knows FBA and WFS.', 'advay-theme' ),
			'content'   => __( "Most brands outgrow garage prep the same way: volume jumps, SKUs multiply, and one person can no longer keep every carton compliant.\n\nA generic 3PL can move boxes — but if they treat FBA and WFS like parcel ecommerce, you pay for it in chargebacks and missed windows. The right partner already speaks marketplace prep, gives you a receiving window, and sends digital proof of what landed.\n\nHere is how lean brands decide when to stop DIY, what to ask a prep center before the first pallet, and how ElitePrep structures that handoff.", 'advay-theme' ),
			'category'  => __( 'Stories', 'advay-theme' ),
			'read_time' => __( '7 min read', 'advay-theme' ),
			'image'     => 'images/brand-gainz.jpg',
			'date'      => '2026-06-14 10:00:00',
			'url'       => $blog,
		),
	);
}

/**
 * Demo category labels for blog filter when no WP categories exist.
 *
 * @return array<int, string>
 */
function advay_demo_blog_categories() {
	return array(
		__( 'Guides', 'advay-theme' ),
		__( 'Updates', 'advay-theme' ),
		__( 'Stories', 'advay-theme' ),
		__( 'Compliance', 'advay-theme' ),
	);
}

/**
 * Create 3 published demo posts once (local Studio / empty blog).
 */
function advay_maybe_seed_demo_blog_posts() {
	if ( is_admin() && ! wp_doing_ajax() && ! ( defined( 'REST_REQUEST' ) && REST_REQUEST ) ) {
		/* Still allow seeding from front-end so Studio sites get content without WP-CLI. */
	}

	if ( get_option( 'advay_blog_demos_seeded' ) === '2.3.7b' ) {
		return;
	}

	$demos = advay_demo_blog_posts();
	foreach ( $demos as $demo ) {
		$existing = get_page_by_path( $demo['slug'], OBJECT, 'post' );
		$post_id  = 0;

		if ( $existing ) {
			$post_id = (int) $existing->ID;
		} else {
			$cat_id = 0;
			$term   = get_term_by( 'name', $demo['category'], 'category' );
			if ( ! $term || is_wp_error( $term ) ) {
				$created = wp_insert_term( $demo['category'], 'category' );
				if ( ! is_wp_error( $created ) ) {
					$cat_id = (int) $created['term_id'];
				}
			} else {
				$cat_id = (int) $term->term_id;
			}

			$paragraphs = array_filter( array_map( 'trim', preg_split( "/\n\n+/", $demo['content'] ) ) );
			$body       = '';
			foreach ( $paragraphs as $p ) {
				$body .= "<!-- wp:paragraph -->\n<p>" . wp_strip_all_tags( $p ) . "</p>\n<!-- /wp:paragraph -->\n\n";
			}

			$inserted = wp_insert_post(
				array(
					'post_title'   => $demo['title'],
					'post_name'    => $demo['slug'],
					'post_content' => $body,
					'post_excerpt' => $demo['excerpt'],
					'post_status'  => 'publish',
					'post_type'    => 'post',
					'post_date'    => $demo['date'],
					'post_author'  => 1,
				),
				true
			);

			if ( is_wp_error( $inserted ) || ! $inserted ) {
				continue;
			}

			$post_id = (int) $inserted;
			if ( $cat_id ) {
				wp_set_post_categories( $post_id, array( $cat_id ) );
			}
		}

		if ( ! $post_id || has_post_thumbnail( $post_id ) ) {
			continue;
		}

		/* Attach theme image as featured image. */
		$rel  = $demo['image'];
		$file = get_template_directory() . '/assets/' . ltrim( $rel, '/' );
		if ( ! file_exists( $file ) ) {
			continue;
		}

		require_once ABSPATH . 'wp-admin/includes/file.php';
		require_once ABSPATH . 'wp-admin/includes/media.php';
		require_once ABSPATH . 'wp-admin/includes/image.php';

		$bits = wp_upload_bits( basename( $file ), null, file_get_contents( $file ) ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
		if ( ! empty( $bits['error'] ) || empty( $bits['file'] ) ) {
			continue;
		}

		$filetype  = wp_check_filetype( basename( $bits['file'] ), null );
		$attach_id = wp_insert_attachment(
			array(
				'post_mime_type' => $filetype['type'],
				'post_title'     => sanitize_file_name( pathinfo( $bits['file'], PATHINFO_FILENAME ) ),
				'post_content'   => '',
				'post_status'    => 'inherit',
			),
			$bits['file'],
			$post_id
		);
		if ( is_wp_error( $attach_id ) ) {
			continue;
		}

		$meta = wp_generate_attachment_metadata( $attach_id, $bits['file'] );
		wp_update_attachment_metadata( $attach_id, $meta );
		set_post_thumbnail( $post_id, $attach_id );
	}

	update_option( 'advay_blog_demos_seeded', '2.3.7b' );
}
add_action( 'init', 'advay_maybe_seed_demo_blog_posts', 25 );

/**
 * Estimated reading time for a post.
 */
function advay_reading_time( $post_id = null ) {
	$post_id = $post_id ? (int) $post_id : get_the_ID();
	$content = get_post_field( 'post_content', $post_id );
	$words   = str_word_count( wp_strip_all_tags( (string) $content ) );
	$mins    = max( 1, (int) ceil( $words / 200 ) );

	/* translators: %d: minutes */
	return sprintf( _n( '%d min read', '%d min read', $mins, 'advay-theme' ), $mins );
}

/**
 * Fallback blog card image when no featured image is set.
 */
function advay_blog_fallback_image( $post_id = null ) {
	$images = array(
		'images/brand-gainz.jpg',
		'images/brand-littlebay.jpg',
		'images/brand-anola.jpg',
		'images/svc-warehouse.jpg',
		'images/client-success.jpg',
	);

	$post_id = $post_id ? (int) $post_id : get_the_ID();
	$index   = $post_id % count( $images );

	return advay_asset_uri( $images[ $index ] );
}

/**
 * Client brand logos used across homepage slider and onboarding.
 *
 * @return array<int, array{name: string, src: string}>
 */
function advay_brand_logos() {
	static $cache = null;
	if ( null !== $cache ) {
		return $cache;
	}

	$logos = array(
		array( 'name' => 'Little Caribbean Kitchen', 'file' => 'images/brand-littlebay.jpg' ),
		array( 'name' => 'Gainz & Airplanes', 'file' => 'images/brand-gainz.jpg' ),
		array( 'name' => "Anola's Creations", 'file' => 'images/brand-anola.jpg' ),
		array( 'name' => 'Ajayi Popcorn', 'file' => 'images/brand-ajayi.jpg' ),
		array( 'name' => 'Daka Vitamins', 'file' => 'images/brand-daka.png' ),
		array( 'name' => 'No Knife Body', 'file' => 'images/brand-noknife.png' ),
	);

	$cache = array();
	foreach ( $logos as $logo ) {
		$path = get_template_directory() . '/assets/' . $logo['file'];
		if ( file_exists( $path ) ) {
			$cache[] = array(
				'name' => $logo['name'],
				'src'  => advay_asset_uri( $logo['file'] ),
			);
		}
	}

	return $cache;
}

function advay_asset_uri( $relative ) {
	return get_template_directory_uri() . '/assets/' . ltrim( $relative, '/' );
}

/**
 * Theme image with local file check and optional remote placeholder.
 */
function advay_theme_image( $relative, $fallback = '' ) {
	$path = get_template_directory() . '/assets/' . ltrim( $relative, '/' );
	if ( file_exists( $path ) ) {
		return advay_asset_uri( $relative );
	}
	if ( $fallback ) {
		return $fallback;
	}
	return advay_asset_uri( 'images/company-placeholder.svg' );
}

/**
 * Founder portraits for client success rotation.
 * Left-column copy stays fixed; photos fade. Caption stays on MD.
 *
 * @return array<int, array{src: string, caption: string}>
 */
function advay_founder_portraits() {
	$people = array(
		array(
			'file'    => 'images/founder1.png',
			'caption' => __( 'Director of Client Success, Cole Sweetser', 'advay-theme' ),
		),
		array(
			'file'    => 'images/founder2.png',
			'caption' => __( 'Managing Director, Odi Ikpe', 'advay-theme' ),
		),
		array(
			'file'    => 'images/founder3.jpeg',
			'caption' => __( 'Director of Client Success, Cole Sweetser', 'advay-theme' ),
		),
		array(
			'file'    => 'images/founder4.jpeg',
			'caption' => __( 'Managing Director, Odi Ikpe', 'advay-theme' ),
		),
	);

	$out = array();
	foreach ( $people as $person ) {
		$path = get_template_directory() . '/assets/' . $person['file'];
		if ( file_exists( $path ) ) {
			$out[] = array(
				'src'     => advay_asset_uri( $person['file'] ),
				'caption' => $person['caption'],
			);
		}
	}

	return $out;
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
			'id'       => 'amazon',
			'label'    => __( 'Amazon FBA', 'advay-theme' ),
			'logo'     => advay_asset_uri( 'images/logo-amazon.png' ),
			'headline' => __( 'Amazon-ready, without the risk.', 'advay-theme' ),
			'body'     => __( 'Amazon eliminated its own prep service and raised defect penalties up to $5.72/unit. One mislabeled shipment can now cost more than it saves. We receive, inspect, label, and ship your inventory to FBA standards, accurately and on time, so those penalties never touch your margin.', 'advay-theme' ),
		),
		array(
			'id'       => 'walmart',
			'label'    => __( 'Walmart WFS', 'advay-theme' ),
			'logo'     => advay_asset_uri( 'images/logo-walmart.png' ),
			'headline' => __( 'Walmart-ready, backed by Walmart itself.', 'advay-theme' ),
			'body'     => __( 'We\'re one of a small number of agencies accepted into Walmart\'s Partner Incubation Program, vetted and approved to move inventory into Walmart Fulfillment Services the right way, the first time. Launch clean on the marketplace still in its early growth window.', 'advay-theme' ),
		),
		array(
			'id'       => 'tiktok',
			'label'    => __( 'TikTok Shop', 'advay-theme' ),
			'logo'     => advay_asset_uri( 'images/logo-tiktok.png' ),
			'headline' => __( 'Ride the wave, don\'t miss it.', 'advay-theme' ),
			'body'     => __( 'A viral moment can turn into a stockout in hours. We keep your inventory prepped and ready to ship the second demand spikes, so a trending video turns into revenue, not a backlog and a bad review.', 'advay-theme' ),
		),
		array(
			'id'       => 'dtc',
			'label'    => __( 'DTC Fulfillment', 'advay-theme' ),
			'logo'     => '',
			'wordmark' => __( 'DTC', 'advay-theme' ),
			'headline' => __( 'Direct to your customer. Direct from us.', 'advay-theme' ),
			'body'     => __( 'Orders from your own site or any major platform, picked and packed with 24-hour processing and two daily carrier pickups. You stay the seller of record the entire way through, we just make sure it ships on time, every time.', 'advay-theme' ),
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
 * Story videos.
 * First (tall) card: assets/video/testimonials.mp4
 * Optional overrides: assets/video/testimonials/{slug}.mp4
 */
function advay_story_video( $slug ) {
	$slug = sanitize_key( (string) $slug );

	/* Primary success-story clip for the tall/first card. */
	if ( 'tall' === $slug ) {
		$primary = get_template_directory() . '/assets/video/testimonials.mp4';
		if ( file_exists( $primary ) ) {
			return advay_asset_uri( 'video/testimonials.mp4' );
		}
	}

	$file = get_template_directory() . '/assets/video/testimonials/' . $slug . '.mp4';
	if ( file_exists( $file ) ) {
		return advay_asset_uri( 'video/testimonials/' . $slug . '.mp4' );
	}

	$demo = array(
		'tall'                        => '',
		'square'                      => 'https://videos.pexels.com/video-files/3195394/3195394-sd_640_360_25fps.mp4',
		'gainz-airplanes'             => 'https://videos.pexels.com/video-files/4761412/4761412-sd_640_360_25fps.mp4',
		'littlebay-caribbean-kitchen' => 'https://videos.pexels.com/video-files/4259140/4259140-sd_640_360_25fps.mp4',
	);

	return isset( $demo[ $slug ] ) ? $demo[ $slug ] : '';
}
