<?php

/*


Plugin Name: Simple Color Swatches for WooCommerce


Plugin URI: https://markomalec.com


Description: Plugin for adding color swatches to your WooCommerce product loops


Version: 1.0.0


Author: Marko Malec


Author URI: https://markomalec.com


License: GPLv2 or later


Text Domain: colorswatches


*/
require_once( plugin_dir_path( __FILE__ ) . 'components/swatches-admin/settings-page.php' );
require_once( plugin_dir_path( __FILE__ ) . 'components/swatches-admin/metaboxes.php' );
require_once( plugin_dir_path( __FILE__ ) . 'components/product-loop/product-loop.php' );

function import_styles() {
    wp_enqueue_style( 'style',  plugin_dir_url( __FILE__ ) . 'assets/styles/main.css' );                     
}
add_action( 'wp_enqueue_scripts', 'import_styles' );

function import_scripts() {
    wp_enqueue_script( 'script', plugin_dir_url(__FILE__) . 'assets/js/events/image-change.js' );
}
add_action('wp_footer', 'import_scripts');

function enqueue_color_picker_scripts($hook) {
    if ('edit-tags.php' !== $hook && 'term.php' !== $hook) {
        return;
    }
    wp_enqueue_style('wp-color-picker');
    wp_enqueue_script('colorswatches-color-picker', plugin_dir_url(__FILE__) . 'assets/js/color-picker.js', array('wp-color-picker'), false, true);
}
add_action('admin_enqueue_scripts', 'enqueue_color_picker_scripts');

add_filter( 'plugin_action_links_ColorSwatchesPlugin/color-swatches.php', 'plugin_settings_link' );
function plugin_settings_link( $links ) {
	$url = esc_url( add_query_arg(
		'page',
		'malec-color-swatches',
		get_admin_url() . 'options-general.php'
	) );
	$settings_link = "<a href='$url'>" . __( 'Settings' ) . '</a>';
	array_push(
		$links,
		$settings_link
	);
	return $links;
}

