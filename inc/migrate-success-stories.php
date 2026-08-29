<?php
/**
 * Idempotent Success Story migration (WP-CLI only).
 *
 * Usage:
 *   studio wp advay migrate-success-stories
 *   studio wp advay migrate-success-stories --dry-run
 *
 * Never hooked to init / frontend. Does not delete PHP array data.
 * Skips slugs that already have a success_story post (any status).
 * Does not overwrite existing CPT / ACF content.
 *
 * @package Advay_Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Map theme asset URL / relative founder path for a slug.
 *
 * @param string $slug Story slug.
 * @return array{relative: string, url: string}
 */
function advay_migrate_ss_image_map( $slug ) {
	$map = array(
		'no-knife-body'               => 'images/founders/no-knife-body.png',
		'ajayi-popcorn'               => 'images/founders/ajayi-popcorn.jpg',
		'daka-vitamins'               => 'images/founders/daka-vitamins.jpg',
		'gainz-airplanes'             => 'images/founders/gainz-airplanes.jpg',
		'littlebay-caribbean-kitchen' => 'images/founders/littlebay.png',
	);

	$rel = isset( $map[ $slug ] ) ? $map[ $slug ] : '';
	return array(
		'relative' => $rel,
		'url'      => $rel ? advay_theme_image( $rel ) : '',
	);
}

/**
 * Find or import a theme image into the Media Library.
 *
 * @param string $relative Path under theme assets/.
 * @return int Attachment ID or 0.
 */
function advay_migrate_ss_ensure_attachment( $relative ) {
	$relative = ltrim( (string) $relative, '/' );
	if ( '' === $relative ) {
		return 0;
	}

	$basename = basename( $relative );
	$existing = get_posts(
		array(
			'post_type'      => 'attachment',
			'post_status'    => 'inherit',
			'posts_per_page' => 1,
			'meta_key'       => '_advay_theme_asset',
			'meta_value'     => $relative,
			'fields'         => 'ids',
		)
	);
	if ( ! empty( $existing[0] ) ) {
		return (int) $existing[0];
	}

	/* Also match by filename already in library. */
	$by_name = get_posts(
		array(
			'post_type'      => 'attachment',
			'post_status'    => 'inherit',
			'posts_per_page' => 1,
			's'              => $basename,
			'fields'         => 'ids',
		)
	);
	if ( ! empty( $by_name[0] ) ) {
		update_post_meta( (int) $by_name[0], '_advay_theme_asset', $relative );
		return (int) $by_name[0];
	}

	$path = get_template_directory() . '/assets/' . $relative;
	if ( ! file_exists( $path ) || ! is_readable( $path ) ) {
		return 0;
	}

	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/media.php';
	require_once ABSPATH . 'wp-admin/includes/image.php';

	$tmp = wp_tempnam( $basename );
	if ( ! $tmp || ! copy( $path, $tmp ) ) {
		return 0;
	}

	$file_array = array(
		'name'     => $basename,
		'tmp_name' => $tmp,
	);

	$id = media_handle_sideload( $file_array, 0 );
	if ( is_wp_error( $id ) ) {
		@unlink( $tmp ); // phpcs:ignore WordPress.PHP.NoSilencedErrors.Discouraged
		return 0;
	}

	update_post_meta( (int) $id, '_advay_theme_asset', $relative );
	return (int) $id;
}

/**
 * Any success_story post with this slug (any status) — for duplicate prevention.
 *
 * @param string $slug Post name.
 * @return WP_Post|null
 */
function advay_migrate_ss_find_any( $slug ) {
	$posts = get_posts(
		array(
			'name'             => sanitize_key( $slug ),
			'post_type'        => 'success_story',
			'post_status'      => array( 'publish', 'draft', 'pending', 'private', 'future' ),
			'numberposts'      => 1,
			'suppress_filters' => true,
		)
	);
	return ! empty( $posts[0] ) ? $posts[0] : null;
}

/**
 * Migrate one story from PHP array → CPT + ACF. Idempotent.
 *
 * @param string $slug    Story slug.
 * @param bool   $dry_run Preview only.
 * @return array{status: string, message: string, post_id?: int}
 */
function advay_migrate_success_story_slug( $slug, $dry_run = false ) {
	$slug    = sanitize_key( $slug );
	$stories = advay_success_stories_data();
	if ( ! isset( $stories[ $slug ] ) ) {
		return array(
			'status'  => 'error',
			'message' => 'Unknown PHP slug: ' . $slug,
		);
	}

	$existing = advay_migrate_ss_find_any( $slug );
	if ( $existing ) {
		return array(
			'status'  => 'skipped',
			'message' => 'Already exists (ID ' . $existing->ID . ') — not overwritten',
			'post_id' => (int) $existing->ID,
		);
	}

	$data  = $stories[ $slug ];
	$title = isset( $data['brand'] ) ? wp_strip_all_tags( $data['brand'] ) : $slug;

	if ( $dry_run ) {
		return array(
			'status'  => 'would_create',
			'message' => 'Would create success_story "' . $title . '" with slug ' . $slug,
		);
	}

	$post_id = wp_insert_post(
		array(
			'post_type'   => 'success_story',
			'post_status' => 'publish',
			'post_title'  => $title,
			'post_name'   => $slug,
		),
		true
	);

	if ( is_wp_error( $post_id ) ) {
		return array(
			'status'  => 'error',
			'message' => $post_id->get_error_message(),
		);
	}

	$img     = advay_migrate_ss_image_map( $slug );
	$att_id  = $img['relative'] ? advay_migrate_ss_ensure_attachment( $img['relative'] ) : 0;
	if ( $att_id ) {
		set_post_thumbnail( $post_id, $att_id );
	}

	$fields = array(
		'ss_brand'              => isset( $data['brand'] ) ? $data['brand'] : '',
		'ss_headline_prefix'    => isset( $data['headline_prefix'] ) ? $data['headline_prefix'] : '',
		'ss_headline_highlight' => isset( $data['headline_highlight'] ) ? $data['headline_highlight'] : '',
		'ss_lead'               => isset( $data['lead'] ) ? $data['lead'] : '',
		'ss_video_url'          => isset( $data['video'] ) ? $data['video'] : '',
		'ss_before_heading'     => isset( $data['before_heading'] ) ? $data['before_heading'] : '',
		'ss_strategies_heading' => isset( $data['strategies_heading'] ) ? $data['strategies_heading'] : '',
		'ss_insight_lead'       => isset( $data['insight_lead'] ) ? $data['insight_lead'] : '',
		'ss_insight_bold'       => isset( $data['insight_bold'] ) ? $data['insight_bold'] : '',
		'ss_insight_tail'       => isset( $data['insight_tail'] ) ? $data['insight_tail'] : '',
		'ss_quote'              => isset( $data['quote'] ) ? $data['quote'] : '',
		'ss_founder'            => isset( $data['founder'] ) ? $data['founder'] : '',
		'ss_founder_role'       => isset( $data['founder_role'] ) ? $data['founder_role'] : '',
		'ss_founder_caption'    => isset( $data['founder_caption'] ) ? $data['founder_caption'] : '',
		'ss_results_summary'    => isset( $data['results_summary'] ) ? $data['results_summary'] : '',
	);

	if ( isset( $data['before'] ) && is_array( $data['before'] ) ) {
		foreach ( array_values( $data['before'] ) as $i => $item ) {
			if ( $i >= 2 ) {
				break;
			}
			$fields[ 'ss_before_' . ( $i + 1 ) ] = $item;
		}
	}

	if ( isset( $data['transform_before'] ) && is_array( $data['transform_before'] ) ) {
		foreach ( array_values( $data['transform_before'] ) as $i => $item ) {
			if ( $i >= 4 ) {
				break;
			}
			$fields[ 'ss_transform_before_' . ( $i + 1 ) ] = $item;
		}
	}

	if ( isset( $data['transform_after'] ) && is_array( $data['transform_after'] ) ) {
		foreach ( array_values( $data['transform_after'] ) as $i => $item ) {
			if ( $i >= 4 ) {
				break;
			}
			$fields[ 'ss_transform_after_' . ( $i + 1 ) ] = $item;
		}
	}

	if ( isset( $data['strategies'] ) && is_array( $data['strategies'] ) ) {
		foreach ( array_values( $data['strategies'] ) as $i => $step ) {
			if ( $i >= 5 ) {
				break;
			}
			$n = $i + 1;
			$fields[ 'ss_strategy_' . $n . '_icon' ]  = isset( $step['icon'] ) ? $step['icon'] : 'target';
			$fields[ 'ss_strategy_' . $n . '_title' ] = isset( $step['title'] ) ? $step['title'] : '';
			$fields[ 'ss_strategy_' . $n . '_text' ]  = isset( $step['text'] ) ? $step['text'] : '';
		}
	}

	if ( isset( $data['results'] ) && is_array( $data['results'] ) ) {
		foreach ( array_values( $data['results'] ) as $i => $stat ) {
			if ( $i >= 4 ) {
				break;
			}
			$n = $i + 1;
			$fields[ 'ss_result_' . $n . '_icon' ]     = isset( $stat['icon'] ) ? $stat['icon'] : 'chart-bars';
			$fields[ 'ss_result_' . $n . '_value' ]    = isset( $stat['value'] ) ? $stat['value'] : '';
			$fields[ 'ss_result_' . $n . '_label' ]    = isset( $stat['label'] ) ? $stat['label'] : '';
			$fields[ 'ss_result_' . $n . '_sublabel' ] = isset( $stat['sublabel'] ) ? $stat['sublabel'] : '';
		}
	}

	foreach ( $fields as $key => $value ) {
		if ( function_exists( 'update_field' ) ) {
			update_field( $key, $value, $post_id );
		} else {
			update_post_meta( $post_id, $key, $value );
		}
	}

	if ( $att_id && function_exists( 'update_field' ) ) {
		update_field( 'ss_hero_image', $att_id, $post_id );
		update_field( 'ss_founder_image', $att_id, $post_id );
	} elseif ( $att_id ) {
		update_post_meta( $post_id, 'ss_hero_image', $att_id );
		update_post_meta( $post_id, 'ss_founder_image', $att_id );
	}

	return array(
		'status'  => 'created',
		'message' => 'Created ID ' . $post_id . ' — /success-stories/' . $slug . '/',
		'post_id' => (int) $post_id,
	);
}

/**
 * Migrate all PHP success stories.
 *
 * @param bool $dry_run Preview only.
 * @return array<int, array{status: string, message: string, post_id?: int}>
 */
function advay_migrate_all_success_stories( $dry_run = false ) {
	$results = array();
	foreach ( advay_success_story_slugs() as $slug ) {
		$results[ $slug ] = advay_migrate_success_story_slug( $slug, $dry_run );
	}
	return $results;
}

/**
 * Register WP-CLI command when available.
 */
function advay_register_success_story_cli() {
	if ( ! defined( 'WP_CLI' ) || ! WP_CLI || ! class_exists( 'WP_CLI' ) ) {
		return;
	}

	WP_CLI::add_command(
		'advay migrate-success-stories',
		function ( $args, $assoc_args ) {
			$dry = isset( $assoc_args['dry-run'] );
			WP_CLI::log( $dry ? 'Dry run — no posts will be created.' : 'Migrating success stories…' );

			$results = advay_migrate_all_success_stories( $dry );
			$created = 0;
			$skipped = 0;
			$errors  = 0;

			foreach ( $results as $slug => $row ) {
				$line = $slug . ': [' . $row['status'] . '] ' . $row['message'];
				if ( 'error' === $row['status'] ) {
					WP_CLI::warning( $line );
					++$errors;
				} elseif ( 'skipped' === $row['status'] ) {
					WP_CLI::log( $line );
					++$skipped;
				} else {
					WP_CLI::success( $line );
					if ( 'created' === $row['status'] || 'would_create' === $row['status'] ) {
						++$created;
					}
				}
			}

			WP_CLI::log(
				sprintf(
					'Done. created/would_create=%d skipped=%d errors=%d',
					$created,
					$skipped,
					$errors
				)
			);
		}
	);
}
add_action( 'cli_init', 'advay_register_success_story_cli' );
