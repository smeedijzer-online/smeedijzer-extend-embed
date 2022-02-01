<?php
/**
 * Plugin Name: Smeedijzer Embed
 * Plugin URI: https://github.com/smeedijzer-online/smeedijzer-extend-embed
 * Description: Extends embed
 * Version: 1.0.0
 * Author: Smeedijzer
 *
 * @package smeedijzer-extend-embed
 */

defined( 'ABSPATH' ) || exit;

/**
 * Registers all block assets so that they can be enqueued through Gutenberg in
 * the corresponding context.
 */
add_action( 'init', function() {
	// Automatically load dependencies and version.
	$asset_file = include plugin_dir_path( __FILE__ ) . 'build/index.asset.php';

	wp_register_script(
		'smeedijzer-extend-embed',
		plugins_url( 'build/index.js', __FILE__ ),
		$asset_file['dependencies'],
		$asset_file['version'],
		true
	);

    wp_embed_register_handler( 'avrotros', '/^https?:\/\/(.*)\.avrotros\.nl\/embed\/([A-Za-z0-9\-_]+)/i', 'wp_embed_handler_avrotros' );
} );

/**
 * Enqueue block editor assets for this example.
 */
add_action( 'enqueue_block_editor_assets', function() {
	wp_enqueue_script( 'smeedijzer-extend-embed' );
} );

/**
 * Avrotros embed handler
 * @example https://eenvandaag.avrotros.nl/embed/530788
 */
function wp_embed_handler_avrotros( $matches, $attr, $url, $rawattr ) {
    $embed = sprintf(
        '<iframe src=https://%1$s.avrotros.nl/embed/%2$s/ width="560" height="315" frameborder="0" allow="encrypted-media" allowfullscreen></iframe>',
        esc_attr($matches[1]),
        esc_attr($matches[2]),
    );

    return $embed;
}
