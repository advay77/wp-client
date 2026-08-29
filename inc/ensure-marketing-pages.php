<?php
/**
 * Marketing Pages — request bridge + CLI ensure (idempotent).
 *
 * When a real WP Page exists for a theme rewrite slug, convert the request
 * to a native page query so titles, Rank Math, and page ACF work.
 * When missing, legacy rewrite templates still render.
 *
 * CLI (never on init/frontend):
 *   studio wp advay ensure-marketing-pages
 *   studio wp advay ensure-marketing-pages --dry-run
 *
 * @package Advay_Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Slug → rewrite query-var map for virtual marketing routes.
 *
 * @return array<string, string> query_var => page slug
 */
function advay_marketing_rewrite_map() {
	return array(
		'advay_receiving'          => 'receiving',
		'advay_onboarding'         => 'onboarding',
		'advay_our_story'          => 'about-us',
		'advay_join_team'          => 'join-our-team',
		'advay_managing_director'  => 'managing-director',
		'advay_blog'               => 'blog',
	);
}

/**
 * Pages the client should have for CMS + SEO (slug => meta).
 *
 * @return array<string, array{title: string, template: string}>
 */
function advay_marketing_pages_spec() {
	return array(
		'receiving'          => array(
			'title'    => 'Receiving',
			'template' => 'page-receiving.php',
		),
		'onboarding'         => array(
			'title'    => 'Onboarding',
			'template' => 'page-onboarding.php',
		),
		'about-us'           => array(
			'title'    => 'Our Story',
			'template' => 'page-our-story.php',
		),
		'join-our-team'      => array(
			'title'    => 'Join Our Team',
			'template' => 'page-join-team.php',
		),
		'managing-director'  => array(
			'title'    => 'Managing Director',
			'template' => 'page-managing-director.php',
		),
		'blog'               => array(
			'title'    => 'Blog',
			'template' => 'page-blog.php',
		),
	);
}

/**
 * If a published Page exists for a rewrite route, serve it as a native page.
 *
 * Exception: when that page is the Reading → Posts page, do not force page_id
 * (that would make is_page() true and break the posts loop). Drop the virtual
 * query var and hand off to core so is_home() works.
 *
 * @param array<string, mixed> $query_vars Request vars.
 * @return array<string, mixed>
 */
function advay_marketing_page_request_bridge( $query_vars ) {
	foreach ( advay_marketing_rewrite_map() as $qv => $slug ) {
		if ( empty( $query_vars[ $qv ] ) ) {
			continue;
		}

		$page = get_page_by_path( $slug );
		if ( ! $page instanceof WP_Post || 'publish' !== $page->post_status ) {
			continue;
		}

		$posts_page_id = (int) get_option( 'page_for_posts' );
		if ( $posts_page_id && $posts_page_id === (int) $page->ID ) {
			// Drop the virtual route; let WordPress core resolve /blog/ as the posts archive.
			unset( $query_vars[ $qv ] );
			$query_vars['pagename'] = $page->post_name;
			unset( $query_vars['page_id'], $query_vars['name'] );
			break;
		}

		unset( $query_vars[ $qv ] );
		$query_vars['page_id'] = (int) $page->ID;
		// Avoid conflicting name-based resolution.
		unset( $query_vars['pagename'], $query_vars['name'] );
		break;
	}

	return $query_vars;
}
add_filter( 'request', 'advay_marketing_page_request_bridge', 5 );

/**
 * Create one marketing page if missing. Idempotent; does not overwrite.
 *
 * @param string $slug     Page slug.
 * @param array  $spec     title + template.
 * @param bool   $dry_run  Preview only.
 * @return array{status: string, message: string, post_id?: int}
 */
function advay_ensure_marketing_page( $slug, $spec, $dry_run = false ) {
	$existing = get_page_by_path( $slug );
	if ( $existing instanceof WP_Post ) {
		$template = get_page_template_slug( $existing->ID );
		$needed   = isset( $spec['template'] ) ? $spec['template'] : '';
		if ( $needed && $template !== $needed && 'publish' === $existing->post_status && ! $dry_run ) {
			update_post_meta( $existing->ID, '_wp_page_template', $needed );
			return array(
				'status'  => 'updated',
				'message' => 'Exists ID ' . $existing->ID . ' — set template ' . $needed,
				'post_id' => (int) $existing->ID,
			);
		}
		return array(
			'status'  => 'skipped',
			'message' => 'Already exists (ID ' . $existing->ID . ', status=' . $existing->post_status . ')',
			'post_id' => (int) $existing->ID,
		);
	}

	if ( $dry_run ) {
		return array(
			'status'  => 'would_create',
			'message' => 'Would create "' . $spec['title'] . '" slug=' . $slug . ' template=' . $spec['template'],
		);
	}

	$post_id = wp_insert_post(
		array(
			'post_type'    => 'page',
			'post_status'  => 'publish',
			'post_title'   => $spec['title'],
			'post_name'    => $slug,
			'post_content' => '',
		),
		true
	);

	if ( is_wp_error( $post_id ) ) {
		return array(
			'status'  => 'error',
			'message' => $post_id->get_error_message(),
		);
	}

	if ( ! empty( $spec['template'] ) ) {
		update_post_meta( $post_id, '_wp_page_template', $spec['template'] );
	}

	return array(
		'status'  => 'created',
		'message' => 'Created ID ' . $post_id . ' — ' . $spec['title'],
		'post_id' => (int) $post_id,
	);
}

/**
 * Ensure all marketing pages exist.
 *
 * @param bool $dry_run Preview only.
 * @return array<string, array{status: string, message: string, post_id?: int}>
 */
function advay_ensure_all_marketing_pages( $dry_run = false ) {
	$results = array();
	foreach ( advay_marketing_pages_spec() as $slug => $spec ) {
		$results[ $slug ] = advay_ensure_marketing_page( $slug, $spec, $dry_run );
	}
	return $results;
}

/**
 * Register WP-CLI command.
 */
function advay_register_ensure_marketing_pages_cli() {
	if ( ! defined( 'WP_CLI' ) || ! WP_CLI || ! class_exists( 'WP_CLI' ) ) {
		return;
	}

	WP_CLI::add_command(
		'advay ensure-marketing-pages',
		function ( $args, $assoc_args ) {
			$dry = isset( $assoc_args['dry-run'] );
			WP_CLI::log( $dry ? 'Dry run — no pages will be created.' : 'Ensuring marketing pages…' );

			$results = advay_ensure_all_marketing_pages( $dry );
			$created = 0;
			$skipped = 0;
			$updated = 0;
			$errors  = 0;

			foreach ( $results as $slug => $row ) {
				$line = $slug . ': [' . $row['status'] . '] ' . $row['message'];
				if ( 'error' === $row['status'] ) {
					WP_CLI::warning( $line );
					++$errors;
				} elseif ( 'skipped' === $row['status'] ) {
					WP_CLI::log( $line );
					++$skipped;
				} elseif ( 'updated' === $row['status'] ) {
					WP_CLI::success( $line );
					++$updated;
				} else {
					WP_CLI::success( $line );
					++$created;
				}
			}

			if ( ! $dry && ( $created > 0 || $updated > 0 ) ) {
				flush_rewrite_rules( false );
				WP_CLI::log( 'Rewrite rules flushed.' );
			}

			WP_CLI::log(
				sprintf(
					'Done. created/would_create=%d updated=%d skipped=%d errors=%d',
					$created,
					$updated,
					$skipped,
					$errors
				)
			);
		}
	);
}
add_action( 'cli_init', 'advay_register_ensure_marketing_pages_cli' );
