<?php
/**
 * Server-side rendering of the `core/shortcode` block.
 *
 * @package WordPress
 */

/**
 * Performs wpautop() on the shortcode block content.
 *
 * @param array  $attributes The block attributes.
 * @param string $content    The block content.
 *
 * @return string Returns the block content.
 */
function gutenberg_render_block_core_shortcode( $attributes, $content ) {
	return wpautop( $content );
}

/**
 * Registers the `core/shortcode` block on server.
 */
function gutenberg_register_block_core_shortcode() {
	register_block_type(
		'core/shortcode',
		array(
			'attributes'      => array(
				'text' => array(
					'type'   => 'string',
					'source' => 'html',
				),
			),
			'render_callback' => 'gutenberg_render_block_core_shortcode',
		)
	);
}
add_action( 'init', 'gutenberg_register_block_core_shortcode', 20 );
