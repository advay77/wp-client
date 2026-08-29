<?php
/**
 * Idempotent Pricing Rates migration (WP-CLI only).
 *
 * Usage:
 *   studio wp advay migrate-pricing-rates
 *   studio wp advay migrate-pricing-rates --dry-run
 *
 * Never hooked to init / frontend. Does not delete PHP defaults.
 * Skips rows whose _advay_pricing_key already exists. Does not overwrite.
 *
 * @package Advay_Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Find pricing_rate by migration key (any status).
 *
 * @param string $key Stable key.
 * @return WP_Post|null
 */
function advay_migrate_pricing_find_by_key( $key ) {
	$key = sanitize_key( $key );
	if ( '' === $key ) {
		return null;
	}

	$posts = get_posts(
		array(
			'post_type'        => 'pricing_rate',
			'post_status'      => array( 'publish', 'draft', 'pending', 'private', 'future' ),
			'posts_per_page'   => 1,
			'meta_key'         => '_advay_pricing_key',
			'meta_value'       => $key,
			'suppress_filters' => true,
		)
	);

	return ! empty( $posts[0] ) ? $posts[0] : null;
}

/**
 * Migrate one default row → CPT. Idempotent.
 *
 * @param array<string, string> $row     Default row.
 * @param int                   $order   menu_order.
 * @param bool                  $dry_run Preview only.
 * @return array{status: string, message: string, post_id?: int}
 */
function advay_migrate_pricing_row( $row, $order, $dry_run = false ) {
	$cat     = isset( $row['cat'] ) ? $row['cat'] : 'prep';
	$service = isset( $row['service'] ) ? wp_strip_all_tags( $row['service'] ) : '';
	$key     = advay_pricing_row_key( $cat, $service );

	$existing = advay_migrate_pricing_find_by_key( $key );
	if ( $existing ) {
		return array(
			'status'  => 'skipped',
			'message' => 'Already exists (ID ' . $existing->ID . ') — not overwritten',
			'post_id' => (int) $existing->ID,
		);
	}

	if ( $dry_run ) {
		return array(
			'status'  => 'would_create',
			'message' => 'Would create "' . $service . '" [' . $cat . '] key=' . $key,
		);
	}

	$post_id = wp_insert_post(
		array(
			'post_type'   => 'pricing_rate',
			'post_status' => 'publish',
			'post_title'  => $service,
			'menu_order'  => (int) $order,
		),
		true
	);

	if ( is_wp_error( $post_id ) ) {
		return array(
			'status'  => 'error',
			'message' => $post_id->get_error_message(),
		);
	}

	update_post_meta( $post_id, '_advay_pricing_key', $key );

	$fields = array(
		'pricing_category' => $cat,
		'pricing_type'     => isset( $row['type'] ) ? $row['type'] : 'standard',
		'pricing_volume'   => isset( $row['volume'] ) ? $row['volume'] : 'N/A',
		'pricing_uom'      => isset( $row['uom'] ) ? $row['uom'] : '',
		'pricing_charge'   => isset( $row['charge'] ) ? $row['charge'] : '',
		'pricing_notes'    => isset( $row['notes'] ) ? $row['notes'] : '',
	);

	foreach ( $fields as $fname => $fval ) {
		if ( function_exists( 'update_field' ) ) {
			update_field( $fname, $fval, $post_id );
		} else {
			update_post_meta( $post_id, $fname, $fval );
		}
	}

	return array(
		'status'  => 'created',
		'message' => 'Created ID ' . $post_id . ' — ' . $service,
		'post_id' => (int) $post_id,
	);
}

/**
 * Migrate all PHP pricing defaults.
 *
 * @param bool $dry_run Preview only.
 * @return array<int, array{status: string, message: string, post_id?: int}>
 */
function advay_migrate_all_pricing_rates( $dry_run = false ) {
	$results = array();
	$rows    = advay_pricing_rows_defaults();
	foreach ( $rows as $i => $row ) {
		$key             = advay_pricing_row_key( $row['cat'], $row['service'] );
		$results[ $key ] = advay_migrate_pricing_row( $row, ( $i + 1 ) * 10, $dry_run );
	}
	return $results;
}

/**
 * Register WP-CLI command.
 */
function advay_register_pricing_rate_cli() {
	if ( ! defined( 'WP_CLI' ) || ! WP_CLI || ! class_exists( 'WP_CLI' ) ) {
		return;
	}

	WP_CLI::add_command(
		'advay migrate-pricing-rates',
		function ( $args, $assoc_args ) {
			$dry = isset( $assoc_args['dry-run'] );
			WP_CLI::log( $dry ? 'Dry run — no posts will be created.' : 'Migrating pricing rates…' );

			$results = advay_migrate_all_pricing_rates( $dry );
			$created = 0;
			$skipped = 0;
			$errors  = 0;

			foreach ( $results as $key => $row ) {
				$line = $key . ': [' . $row['status'] . '] ' . $row['message'];
				if ( 'error' === $row['status'] ) {
					WP_CLI::warning( $line );
					++$errors;
				} elseif ( 'skipped' === $row['status'] ) {
					WP_CLI::log( $line );
					++$skipped;
				} else {
					WP_CLI::success( $line );
					++$created;
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
add_action( 'cli_init', 'advay_register_pricing_rate_cli' );
