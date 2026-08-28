<?php
/**
 * One-shot: seed first 3 blogs from Google Doc text (body only, no related/SEO links).
 * Run: php wp-content/themes/advay-theme/inc/seed-blogs-1-3.php
 */
if ( ! defined( 'ABSPATH' ) ) {
	require dirname( __DIR__, 4 ) . '/wp-load.php';
}

if ( ! function_exists( 'wp_insert_post' ) ) {
	fwrite( STDERR, "WordPress failed to load.\n" );
	exit( 1 );
}

/**
 * Convert plain exported blog text into Gutenberg-ish HTML.
 *
 * @param string $raw Full text including title as first line.
 * @return array{title:string,content:string,excerpt:string}
 */
function advay_blog_text_to_html( $raw ) {
	$raw   = preg_replace( '/^\xEF\xBB\xBF/', '', $raw );
	$raw   = str_replace( array( "\r\n", "\r" ), "\n", $raw );
	$lines = preg_split( "/\n/", $raw );
	$title = '';
	$body  = array();

	foreach ( $lines as $line ) {
		$line = trim( $line );
		$line = preg_replace( '/^\xEF\xBB\xBF/', '', $line );
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
	$flush_p = function () use ( &$buf, &$paras ) {
		if ( ! $buf ) {
			return;
		}
		$paras[] = array( 'type' => 'p', 'text' => implode( ' ', $buf ) );
		$buf     = array();
	};
	$flush_l = function () use ( &$list, &$paras ) {
		if ( ! $list ) {
			return;
		}
		$paras[] = array( 'type' => 'ol', 'items' => $list );
		$list    = array();
	};

	foreach ( $body as $line ) {
		if ( '' === $line ) {
			$flush_p();
			$flush_l();
			continue;
		}

		if ( preg_match( '/^\d+\.\s+(.+)$/', $line, $m ) ) {
			$flush_p();
			$list[] = $m[1];
			continue;
		}

		$flush_l();

		$is_heading = (
			(bool) preg_match( '/\?$/', $line )
			|| (
				mb_strlen( $line ) < 90
				&& ! preg_match( '/[.]$/', $line )
				&& preg_match( '/^[A-Z0-9]/', $line )
				&& (
					preg_match( '/^(What |How |Why |Does |The |Common |Amazon |Prep |FBA |Who |Where |When |Getting |Sustainable |Poly |Box |Barcode |Category )/i', $line )
					|| preg_match( '/Requirements|Guide|Means|Changes|Matter|Options|Scale|Include|Know|Notes$/i', $line )
				)
			)
		);

		if ( $is_heading && ! $buf ) {
			$paras[] = array( 'type' => 'h2', 'text' => $line );
			continue;
		}

		$buf[] = $line;
	}
	$flush_p();
	$flush_l();

	$html = '';
	foreach ( $paras as $block ) {
		$text = esc_html( $block['text'] ?? '' );
		if ( 'h2' === $block['type'] ) {
			$html .= "<!-- wp:heading -->\n<h2 class=\"wp-block-heading\">{$text}</h2>\n<!-- /wp:heading -->\n\n";
		} elseif ( 'ol' === $block['type'] ) {
			$html .= "<!-- wp:list {\"ordered\":true} -->\n<ol class=\"wp-block-list\">\n";
			foreach ( $block['items'] as $item ) {
				$html .= '<li>' . esc_html( $item ) . "</li>\n";
			}
			$html .= "</ol>\n<!-- /wp:list -->\n\n";
		} else {
			$html .= "<!-- wp:paragraph -->\n<p>{$text}</p>\n<!-- /wp:paragraph -->\n\n";
		}
	}

	$excerpt = '';
	foreach ( $paras as $block ) {
		if ( 'p' === $block['type'] ) {
			$excerpt = wp_trim_words( $block['text'], 28 );
			break;
		}
	}

	return array(
		'title'   => $title,
		'content' => trim( $html ),
		'excerpt' => $excerpt,
	);
}

$posts = array(
	array(
		'file'     => __DIR__ . '/blog1.txt',
		'slug'     => 'amazon-fba-prep-guide-2026',
		'category' => 'Guides',
		'date'     => '2026-08-20 10:00:00',
		'image'    => 'images/svc-warehouse.jpg',
	),
	array(
		'file'     => __DIR__ . '/blog2.txt',
		'slug'     => 'launch-supplement-brands-amazon-2026',
		'category' => 'Guides',
		'date'     => '2026-08-18 10:00:00',
		'image'    => 'images/niche1.png',
	),
	array(
		'file'     => __DIR__ . '/blog3.txt',
		'slug'     => 'amazon-fba-packaging-requirements-2026',
		'category' => 'Compliance',
		'date'     => '2026-08-16 10:00:00',
		'image'    => 'images/brandfit2.png',
	),
);

$created = 0;
foreach ( $posts as $meta ) {
	if ( ! file_exists( $meta['file'] ) ) {
		fwrite( STDERR, "Missing {$meta['file']}\n" );
		continue;
	}

	$parsed = advay_blog_text_to_html( file_get_contents( $meta['file'] ) );
	$existing = get_page_by_path( $meta['slug'], OBJECT, 'post' );

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
		fwrite( STDERR, "Failed {$meta['slug']}\n" );
		continue;
	}

	if ( $cat_id ) {
		wp_set_post_categories( (int) $post_id, array( $cat_id ) );
	}

	if ( ! has_post_thumbnail( $post_id ) ) {
		$img_path = get_template_directory() . '/assets/' . $meta['image'];
		if ( file_exists( $img_path ) && function_exists( 'advay_sideload_featured_image' ) ) {
			/* Prefer direct attach if helper exists; else media_sideload. */
		}
		if ( file_exists( $img_path ) ) {
			require_once ABSPATH . 'wp-admin/includes/file.php';
			require_once ABSPATH . 'wp-admin/includes/media.php';
			require_once ABSPATH . 'wp-admin/includes/image.php';

			$upload = wp_upload_bits( basename( $img_path ), null, file_get_contents( $img_path ) );
			if ( empty( $upload['error'] ) ) {
				$filetype = wp_check_filetype( $upload['file'], null );
				$attach_id = wp_insert_attachment(
					array(
						'post_mime_type' => $filetype['type'],
						'post_title'     => sanitize_file_name( basename( $img_path ) ),
						'post_content'   => '',
						'post_status'    => 'inherit',
					),
					$upload['file'],
					(int) $post_id
				);
				if ( $attach_id && ! is_wp_error( $attach_id ) ) {
					$meta_data = wp_generate_attachment_metadata( $attach_id, $upload['file'] );
					wp_update_attachment_metadata( $attach_id, $meta_data );
					set_post_thumbnail( (int) $post_id, $attach_id );
				}
			}
		}
	}

	++$created;
	echo "OK: {$parsed['title']} -> " . get_permalink( $post_id ) . "\n";
}

echo "Done. Seeded/updated {$created} posts.\n";
