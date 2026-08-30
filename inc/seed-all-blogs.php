<?php
/**
 * Seed all 11 blogs from Doc extracts: structured HTML, SEO meta, related links, images.
 * Run: studio wp eval-file wp-content/themes/advay-theme/inc/seed-all-blogs.php
 */
if ( ! defined( 'ABSPATH' ) ) {
	require dirname( __DIR__, 4 ) . '/wp-load.php';
}

if ( ! function_exists( 'wp_insert_post' ) ) {
	fwrite( STDERR, "WordPress failed to load.\n" );
	exit( 1 );
}

/**
 * Clean export artifacts.
 *
 * @param string $text Raw text.
 * @return string
 */
function advay_blog_clean_text( $text ) {
	$text = preg_replace( '/^\xEF\xBB\xBF/', '', $text );
	$text = str_replace( array( "\r\n", "\r" ), "\n", $text );
	/* Missing space after comma before a letter. */
	$text = preg_replace( '/,([A-Za-z0-9])/', ', $1', $text );
	/* Space before comma. */
	$text = preg_replace( '/\s+,/', ',', $text );
	/* Strip internal-link placeholders; keep readable title if present. */
	$text = preg_replace( '/\[INTERNAL LINK OPPORTUNITY:\s*([^\]]+)\]/i', '$1', $text );
	$text = preg_replace( '/\[Internal Link Opportunity:\s*([^\]]+)\]/i', '$1', $text );
	return trim( $text );
}

/**
 * Clean a single line (spaces only; keep structure at paragraph level).
 *
 * @param string $line Line text.
 * @return string
 */
function advay_blog_clean_line( $line ) {
	$line = preg_replace( '/[ \t]{2,}/', ' ', $line );
	$line = preg_replace( '/,([A-Za-z0-9])/', ', $1', $line );
	$line = preg_replace( '/\s+,/', ',', $line );
	$line = preg_replace( '/\[INTERNAL LINK OPPORTUNITY:\s*([^\]]+)\]/i', '$1', $line );
	$line = preg_replace( '/\[Internal Link Opportunity:\s*([^\]]+)\]/i', '$1', $line );
	return trim( $line );
}

/**
 * Heuristic: is this line a section heading?
 *
 * @param string $line Line text.
 * @return bool
 */
function advay_blog_is_heading( $line ) {
	$len = mb_strlen( $line );
	if ( $len < 3 || $len > 110 ) {
		return false;
	}
	if ( preg_match( '/[.]$/', $line ) && ! preg_match( '/\?$/', $line ) ) {
		return false;
	}
	$known = array(
		'What is ', 'What are ', 'What happens ', 'What should ', 'What to ', 'What Each ',
		'How to ', 'How Does ', 'How do ', 'How much ', 'How long ', 'How are ', 'How is ', 'How fast ',
		'Why ', 'Who ', 'When ', 'Where ', 'Does ', 'Do I ', 'Is ', 'Can ',
		'Common ', 'Amazon ', 'Prep ', 'FBA ', 'Walmart ', 'TikTok ', 'Summary',
		'Frequently Asked', 'FAQ', 'Getting ', 'Sustainable ', 'Poly ', 'Box ', 'Barcode ',
		'Category ', 'The Single ', 'What a Backup ', 'FBA Fee ', 'WFS Fee ', 'Amazon FBA Fee',
		'Walmart WFS Fee', 'Fulfillment ', 'Packaging ', 'Labeling ', 'Expiration ',
		'Minimum ', 'Seller ', 'Primary ', 'Backup ', 'Multi-channel ', 'Technology ',
		'Cost ', 'In-house ', 'Outsourc', 'Hybrid ', 'Checklist ', 'Practical ',
		'Official ', 'Policy ', 'Dispatch ', 'Carrier ', 'Category consider',
		'End-to-end ', 'This guide ', 'What This Guide', 'Box and Carton',
		'Frustration-Free', 'Barcode Scan', 'Shelf Life', 'Label Format',
		'Turnaround ', 'Proximity ', 'Transparent ', 'Accuracy ', 'Location ',
		'GTIN ', 'Pallet ', 'Referral ', 'Storage ', 'Comparison ',
	);
	foreach ( $known as $prefix ) {
		if ( 0 === stripos( $line, $prefix ) ) {
			return true;
		}
	}
	if ( preg_match( '/\?$/', $line ) && $len < 100 ) {
		return true;
	}
	if ( preg_match( '/Requirements|Guide|Means|Changes|Matter|Options|Scale|Include|Know|Notes|Breakdown|Problem|Provides|Workflow|Setup|Checklist$/i', $line ) ) {
		return true;
	}
	return false;
}

/**
 * Convert plain blog text to Gutenberg blocks.
 *
 * @param string $raw Title + body.
 * @return array{title:string,content:string,excerpt:string}
 */
function advay_blog_text_to_blocks( $raw ) {
	$raw   = preg_replace( '/^\xEF\xBB\xBF/', '', $raw );
	$raw   = str_replace( array( "\r\n", "\r" ), "\n", $raw );
	$lines = preg_split( "/\n/", $raw );
	$title = '';
	$body  = array();

	foreach ( $lines as $line ) {
		$line = advay_blog_clean_line( $line );
		if ( '' === $line ) {
			$body[] = '';
			continue;
		}
		if ( '' === $title ) {
			$title = $line;
			continue;
		}
		$body[] = $line;
	}

	$paras   = array();
	$buf     = array();
	$list    = array();
	$list_ol = true;
	$in_faq  = false;

	$flush_p = function () use ( &$buf, &$paras ) {
		if ( ! $buf ) {
			return;
		}
		$paras[] = array( 'type' => 'p', 'text' => implode( ' ', $buf ) );
		$buf     = array();
	};
	$flush_l = function () use ( &$list, &$paras, &$list_ol ) {
		if ( ! $list ) {
			return;
		}
		$paras[] = array(
			'type'  => $list_ol ? 'ol' : 'ul',
			'items' => $list,
		);
		$list = array();
	};

	foreach ( $body as $line ) {
		if ( '' === $line ) {
			$flush_p();
			$flush_l();
			continue;
		}

		/* Skip stray single letters / junk. */
		if ( preg_match( '/^[a-z]$/', $line ) ) {
			continue;
		}

		if ( preg_match( '/^frequently asked questions$/i', $line ) || preg_match( '/^faq$/i', $line ) ) {
			$flush_p();
			$flush_l();
			$in_faq  = true;
			$paras[] = array( 'type' => 'h2', 'text' => 'Frequently Asked Questions' );
			continue;
		}

		if ( preg_match( '/^summary:?$/i', $line ) ) {
			$flush_p();
			$flush_l();
			$paras[] = array( 'type' => 'h2', 'text' => 'Summary' );
			continue;
		}

		if ( preg_match( '/^\d+\.\s+(.+)$/', $line, $m ) ) {
			$flush_p();
			$list_ol = true;
			$list[]  = advay_blog_clean_line( $m[1] );
			continue;
		}

		if ( preg_match( '/^[-•]\s+(.+)$/', $line, $m ) ) {
			$flush_p();
			$list_ol = false;
			$list[]  = advay_blog_clean_line( $m[1] );
			continue;
		}

		$flush_l();

		$is_q = (bool) preg_match( '/\?$/', $line );
		if ( $in_faq && $is_q && mb_strlen( $line ) < 120 && ! $buf ) {
			$paras[] = array( 'type' => 'h3', 'text' => $line );
			continue;
		}

		if ( ! $in_faq && advay_blog_is_heading( $line ) && ! $buf ) {
			$level   = $is_q ? 'h3' : 'h2';
			$paras[] = array( 'type' => $level, 'text' => $line );
			continue;
		}

		$buf[] = $line;
	}
	$flush_p();
	$flush_l();

	$html = '';
	foreach ( $paras as $block ) {
		if ( 'h2' === $block['type'] ) {
			$text = esc_html( $block['text'] );
			$html .= "<!-- wp:heading -->\n<h2 class=\"wp-block-heading\">{$text}</h2>\n<!-- /wp:heading -->\n\n";
		} elseif ( 'h3' === $block['type'] ) {
			$text = esc_html( $block['text'] );
			$html .= "<!-- wp:heading {\"level\":3} -->\n<h3 class=\"wp-block-heading\">{$text}</h3>\n<!-- /wp:heading -->\n\n";
		} elseif ( 'ol' === $block['type'] || 'ul' === $block['type'] ) {
			$tag   = 'ol' === $block['type'] ? 'ol' : 'ul';
			$ordered = 'ol' === $block['type'] ? '{"ordered":true}' : '';
			$html .= "<!-- wp:list {$ordered} -->\n<{$tag} class=\"wp-block-list\">\n";
			foreach ( $block['items'] as $item ) {
				$html .= '<li>' . esc_html( $item ) . "</li>\n";
			}
			$html .= "</{$tag}>\n<!-- /wp:list -->\n\n";
		} else {
			$text = esc_html( $block['text'] );
			$html .= "<!-- wp:paragraph -->\n<p>{$text}</p>\n<!-- /wp:paragraph -->\n\n";
		}
	}

	$excerpt = '';
	foreach ( $paras as $block ) {
		if ( 'p' === $block['type'] ) {
			$excerpt = wp_trim_words( $block['text'], 32 );
			break;
		}
	}

	return array(
		'title'   => $title,
		'content' => trim( $html ),
		'excerpt' => $excerpt,
	);
}

/**
 * Related posts HTML block.
 *
 * @param array $items Array of array{title,url}.
 * @return string
 */
function advay_blog_related_html( $items ) {
	/* Placeholder related blocks are no longer injected into post content. */
	return '';
}

/**
 * Attach featured image from theme assets.
 *
 * @param int    $post_id Post ID.
 * @param string $rel     Relative path under assets/.
 */
function advay_blog_set_featured( $post_id, $rel ) {
	if ( has_post_thumbnail( $post_id ) ) {
		return;
	}
	$img_path = get_template_directory() . '/assets/' . ltrim( $rel, '/' );
	if ( ! file_exists( $img_path ) ) {
		return;
	}
	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/media.php';
	require_once ABSPATH . 'wp-admin/includes/image.php';

	$upload = wp_upload_bits( basename( $img_path ), null, file_get_contents( $img_path ) );
	if ( ! empty( $upload['error'] ) ) {
		return;
	}
	$filetype  = wp_check_filetype( $upload['file'], null );
	$attach_id = wp_insert_attachment(
		array(
			'post_mime_type' => $filetype['type'],
			'post_title'     => sanitize_file_name( pathinfo( $img_path, PATHINFO_FILENAME ) ),
			'post_content'   => '',
			'post_status'    => 'inherit',
		),
		$upload['file'],
		(int) $post_id
	);
	if ( ! $attach_id || is_wp_error( $attach_id ) ) {
		return;
	}
	$meta = wp_generate_attachment_metadata( $attach_id, $upload['file'] );
	wp_update_attachment_metadata( $attach_id, $meta );
	set_post_thumbnail( (int) $post_id, $attach_id );
}

$posts = array(
	array(
		'file'     => 'blog01.txt',
		'slug'     => 'amazon-fba-prep-guide',
		'category' => 'Guides',
		'date'     => '2026-08-20 10:00:00',
		'image'    => 'images/svc-warehouse.jpg',
		'seo_title'=> 'Amazon FBA Prep Guide: Everything Sellers Need to Know',
		'seo_desc' => 'Amazon FBA prep explained: labeling, polybagging, bundling, and what changed in 2026. Prep requirements, common errors, and when to use a prep center.',
		'related'  => array( 'amazon-fba-packaging-requirements', 'fnsku-vs-upc', 'amazon-fba-prep-center-new-jersey', 'walmart-wfs-prep-requirements' ),
	),
	array(
		'file'     => 'blog02.txt',
		'slug'     => 'launch-supplement-brand-on-amazon',
		'category' => 'Guides',
		'date'     => '2026-08-18 10:00:00',
		'image'    => 'images/niche1.png',
		'seo_title'=> 'How to Launch a Supplement Brand on Amazon (2026 Guide)',
		'seo_desc' => 'Launch a supplement brand on Amazon: FDA labeling, Amazon TIC verification, COAs, FBA prep, expiration rules, and listing compliance for dietary supplements.',
		'related'  => array( 'amazon-fba-expiration-date-requirements', 'amazon-fba-prep-guide', 'fnsku-vs-upc', 'amazon-fba-packaging-requirements' ),
	),
	array(
		'file'     => 'blog03.txt',
		'slug'     => 'amazon-fba-packaging-requirements',
		'category' => 'Compliance',
		'date'     => '2026-08-16 10:00:00',
		'image'    => 'images/brandfit2.png',
		'seo_title'=> 'Amazon FBA Packaging Requirements: Complete 2026 Guide',
		'seo_desc' => 'A complete guide to Amazon FBA packaging requirements in 2026: poly bags, suffocation warnings, box limits, barcodes, and drop-test rules.',
		'related'  => array( 'fnsku-vs-upc', 'amazon-fba-expiration-date-requirements', 'amazon-fba-prep-guide' ),
	),
	array(
		'file'     => 'blog04.txt',
		'slug'     => 'fnsku-vs-upc',
		'category' => 'Compliance',
		'date'     => '2026-08-14 10:00:00',
		'image'    => 'images/brandfit2.png',
		'seo_title'=> 'FNSKU vs UPC: Which Barcode for Amazon FBA in 2026?',
		'seo_desc' => 'FNSKU vs UPC for Amazon FBA explained: what each barcode identifies, who must use which one in 2026, and how to avoid shipment rejections.',
		'related'  => array( 'amazon-fba-prep-guide', 'amazon-fba-packaging-requirements', 'walmart-wfs-prep-requirements' ),
	),
	array(
		'file'     => 'blog05.txt',
		'slug'     => 'amazon-fba-expiration-date-requirements',
		'category' => 'Compliance',
		'date'     => '2026-08-12 10:00:00',
		'image'    => 'images/niche3.png',
		'seo_title'=> 'Amazon FBA Expiration Date Requirements (2026 Guide)',
		'seo_desc' => 'Amazon FBA expiration date rules explained: minimum shelf life, label format, font size, and how to avoid disposal of food and supplement inventory.',
		'related'  => array( 'launch-supplement-brand-on-amazon', 'amazon-fba-packaging-requirements', 'amazon-fba-prep-guide' ),
	),
	array(
		'file'     => 'blog06.txt',
		'slug'     => 'amazon-fba-prep-center-new-jersey',
		'category' => 'Guides',
		'date'     => '2026-08-10 10:00:00',
		'image'    => 'images/client-success.jpg',
		'seo_title'=> 'What to Look for in an Amazon FBA Prep Center in NJ',
		'seo_desc' => 'A buyer\'s checklist for choosing an Amazon FBA prep center in New Jersey: turnaround time, pricing, compliance, and location advantages to evaluate.',
		'related'  => array( 'amazon-fba-prep-guide', 'why-brands-use-backup-3pl', 'walmart-wfs-prep-requirements' ),
	),
	array(
		'file'     => 'blog07.txt',
		'slug'     => 'walmart-wfs-prep-requirements',
		'category' => 'Compliance',
		'date'     => '2026-08-08 10:00:00',
		'image'    => 'images/walmart.jpeg',
		'seo_title'=> 'Walmart WFS Prep Requirements: A Guide for Sellers (2026)',
		'seo_desc' => 'A complete guide to Walmart WFS prep requirements in 2026, covering labeling, packaging, palletizing, and how it compares to Amazon FBA.',
		'related'  => array( 'fnsku-vs-upc', 'amazon-fba-vs-walmart-wfs-fees-2026', 'why-brands-use-backup-3pl', 'amazon-fba-prep-guide' ),
	),
	array(
		'file'     => 'blog08.txt',
		'slug'     => 'why-brands-use-backup-3pl',
		'category' => 'Guides',
		'date'     => '2026-08-06 10:00:00',
		'image'    => 'images/brandfit3.png',
		'seo_title'=> 'Why Do Brands Use a Backup 3PL? (2026 Guide)',
		'seo_desc' => 'Why growing brands use a backup 3PL: single-point-of-failure risks, disruption coverage, and how a secondary warehouse keeps orders moving.',
		'related'  => array( 'amazon-fba-prep-center-new-jersey', 'dtc-fulfillment-setup-guide-ecommerce-2026', 'walmart-wfs-prep-requirements' ),
	),
	array(
		'file'     => 'blog09.txt',
		'slug'     => 'amazon-fba-vs-walmart-wfs-fees-2026',
		'category' => 'Guides',
		'date'     => '2026-08-04 10:00:00',
		'image'    => 'images/brandfit3.png',
		'seo_title'=> 'Amazon FBA vs Walmart WFS Fees 2026: Full Comparison',
		'seo_desc' => 'Amazon FBA vs Walmart WFS fees compared for 2026: referral fees, fulfillment costs, storage rates, and which model fits different sellers.',
		'related'  => array( 'walmart-wfs-prep-requirements', 'amazon-fba-prep-guide', 'amazon-fba-prep-center-new-jersey' ),
	),
	array(
		'file'     => 'blog10.txt',
		'slug'     => 'tiktok-shop-fulfillment-guide-brands-2026',
		'category' => 'Guides',
		'date'     => '2026-08-02 10:00:00',
		'image'    => 'images/tiktok.jpeg',
		'seo_title'=> 'TikTok Shop Fulfillment Guide for Brands (2026)',
		'seo_desc' => 'TikTok Shop fulfillment for brands in 2026: SLAs, FBT vs seller shipping, LDR/OTDR metrics, 3PL setup, and multi-channel inventory.',
		'related'  => array( 'dtc-fulfillment-setup-guide-ecommerce-2026', 'why-brands-use-backup-3pl', 'walmart-wfs-prep-requirements' ),
	),
	array(
		'file'     => 'blog11.txt',
		'slug'     => 'dtc-fulfillment-setup-guide-ecommerce-2026',
		'category' => 'Guides',
		'date'     => '2026-08-01 10:00:00',
		'image'    => 'images/svc-warehouse.jpg',
		'seo_title'=> 'DTC Fulfillment Setup Guide for Ecommerce (2026)',
		'seo_desc' => 'How ecommerce brands set up DTC fulfillment in 2026: in-house vs 3PL, costs, Shopify integration, multi-channel inventory, and evaluation checklist.',
		'related'  => array( 'tiktok-shop-fulfillment-guide-brands-2026', 'why-brands-use-backup-3pl', 'amazon-fba-prep-guide' ),
	),
);

$dir     = __DIR__ . '/blogs';
$created = array(); /* slug => id */
$ok      = 0;

/* Pass 1: create/update posts without related block. */
foreach ( $posts as $meta ) {
	$path = $dir . '/' . $meta['file'];
	if ( ! file_exists( $path ) ) {
		echo "Missing {$path}\n";
		continue;
	}

	$parsed   = advay_blog_text_to_blocks( file_get_contents( $path ) );
	$existing = get_page_by_path( $meta['slug'], OBJECT, 'post' );
	/* Also match older slugs from first seed. */
	if ( ! $existing && 'amazon-fba-prep-guide' === $meta['slug'] ) {
		$existing = get_page_by_path( 'amazon-fba-prep-guide-2026', OBJECT, 'post' );
	}
	if ( ! $existing && 'launch-supplement-brand-on-amazon' === $meta['slug'] ) {
		$existing = get_page_by_path( 'launch-supplement-brands-amazon-2026', OBJECT, 'post' );
	}
	if ( ! $existing && 'amazon-fba-packaging-requirements' === $meta['slug'] ) {
		$existing = get_page_by_path( 'amazon-fba-packaging-requirements-2026', OBJECT, 'post' );
	}

	$cat_id = 0;
	$term   = get_term_by( 'name', $meta['category'], 'category' );
	if ( ! $term || is_wp_error( $term ) ) {
		$created_term = wp_insert_term( $meta['category'], 'category' );
		if ( ! is_wp_error( $created_term ) ) {
			$cat_id = (int) $created_term['term_id'];
		}
	} else {
		$cat_id = (int) $term->term_id;
	}

	$args = array(
		'post_title'   => $parsed['title'],
		'post_name'    => $meta['slug'],
		'post_content' => $parsed['content'],
		'post_excerpt' => $parsed['excerpt'],
		'post_status'  => 'publish',
		'post_type'    => 'post',
		'post_date'    => $meta['date'],
		'post_author'  => 1,
	);

	if ( $existing ) {
		$args['ID'] = (int) $existing->ID;
		$post_id    = wp_update_post( $args, true );
	} else {
		$post_id = wp_insert_post( $args, true );
	}

	if ( is_wp_error( $post_id ) || ! $post_id ) {
		echo "Failed {$meta['slug']}\n";
		continue;
	}

	$post_id = (int) $post_id;
	if ( $cat_id ) {
		wp_set_post_categories( $post_id, array( $cat_id ) );
	}

	update_post_meta( $post_id, '_advay_seo_title', $meta['seo_title'] );
	update_post_meta( $post_id, '_advay_seo_description', $meta['seo_desc'] );
	update_post_meta( $post_id, '_yoast_wpseo_title', $meta['seo_title'] );
	update_post_meta( $post_id, '_yoast_wpseo_metadesc', $meta['seo_desc'] );
	update_post_meta( $post_id, 'rank_math_title', $meta['seo_title'] );
	update_post_meta( $post_id, 'rank_math_description', $meta['seo_desc'] );

	advay_blog_set_featured( $post_id, $meta['image'] );

	$created[ $meta['slug'] ] = array(
		'id'      => $post_id,
		'title'   => $parsed['title'],
		'content' => $parsed['content'],
		'related' => $meta['related'],
	);
	++$ok;
	echo "OK pass1: {$parsed['title']}\n";
}

/* Pass 2: append related article links now that all URLs exist. */
foreach ( $created as $slug => $row ) {
	$items = array();
	foreach ( $row['related'] as $rel_slug ) {
		if ( empty( $created[ $rel_slug ] ) ) {
			continue;
		}
		$items[] = array(
			'title' => $created[ $rel_slug ]['title'],
			'url'   => get_permalink( $created[ $rel_slug ]['id'] ),
		);
	}
	$content = $row['content'] . "\n\n" . advay_blog_related_html( $items );
	wp_update_post(
		array(
			'ID'           => $row['id'],
			'post_content' => $content,
		)
	);
	echo 'OK related: ' . $slug . ' -> ' . get_permalink( $row['id'] ) . "\n";
}

echo "Done. Seeded/updated {$ok} posts.\n";
