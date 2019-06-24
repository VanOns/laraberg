<?php
/**
 * Server-side rendering of the `core/block` block.
 *
 * @package WordPress
 */

/**
 * Renders the `core/block` block on server.
 *
 * @param array $attributes The block attributes.
 *
 * @return string Rendered HTML of the referenced block.
 */
function gutenberg_render_block_core_block( $attributes ) {
	if ( empty( $attributes['ref'] ) ) {
		return '';
	}

	$reusable_block = get_post( $attributes['ref'] );
	if ( ! $reusable_block || 'wp_block' !== $reusable_block->post_type ) {
		return '';
	}

	if ( 'publish' !== $reusable_block->post_status || ! empty( $reusable_block->post_password ) ) {
		return '';
	}

	return do_blocks( $reusable_block->post_content );
}

/**
 * Registers the `core/block` block.
 */
function gutenberg_register_block_core_block() {
	register_block_type(
		'core/block',
		array(
			'attributes'      => array(
				'ref' => array(
					'type' => 'number',
				),
			),
			'render_callback' => 'gutenberg_render_block_core_block',
		)
	);
}
add_action( 'init', 'gutenberg_register_block_core_block', 20 );
