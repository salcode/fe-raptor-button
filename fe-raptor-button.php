<?php
/**
 * Plugin Name: Raptor Button
 * Plugin URI: https://github.com/salcode/fe-raptor-button
 * Description: Add a Raptor to your website. This plugin provides examples used in my <a href="https://2017.baltimore.wordcamp.org/session/making-your-code-easy-to-extend/">Making Your Code Easy To Extend</a> talk at WordCamp Baltimore 2017. This plugin will add a button to the bottom of each page and clicking the button will bring out the raptor.
 * Version: 1.0.0
 * Author: Sal Ferrarello
 * Author URI: http://salferrarello.com/
 * License: Apache-2.0
 * License URI: https://spdx.org/licenses/Apache-2.0.html
 * Text Domain: fe-raptor-button
 * Domain Path: /languages
 *
 * @package fe-raptor-button
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Display button in the footer.
add_action( 'wp_footer', 'fe_raptor' );

// Enqueue JavaScript.
add_action( 'wp_enqueue_scripts', 'fe_raptor_js_enqueue' );

/**
 * Output the markup for the Raptor Button.
 */
function fe_raptor() {
	$btn_txt = __( 'Get Raptor', 'fe-raptor-button' );

	// Allow changing the button text with the filter 'fe_raptor_btn_txt'.
	$btn_txt = apply_filters( 'fe_raptor_btn_txt', $btn_txt );

	do_action( 'before_raptor_btn_template' );

	$tmpl = get_stylesheet_directory() . '/fe-raptor-button/btn.php';
	if ( ! file_exists( $tmpl ) ) {
		// Fallback to default template.
		$tmpl = __DIR__ . '/templates/btn.php';
	}
	// Display the template.
	include $tmpl;
}

/**
 * Register and enqueue plugin JavaScript.
 */
function fe_raptor_js_enqueue() {

	// Configuration for jQuery plugin raptorize.
	$js_config = array(
		'assetPath'   => plugins_url( '/assets/', __FILE__ ),
		'enableSound' => false,
	);

	// Allow changing this configuration via the filter 'fe_raptor_plugin_config'.
	$js_config = apply_filters( 'fe_raptor_plugin_config', $js_config );

	wp_register_script( 'raptorize', plugins_url( '/assets/js/jquery.raptorize.1.0-salcode.js', __FILE__ ), array( 'jquery' ), '1.0-salcode.1', false );
	wp_register_script( 'fe-raptor-button', plugins_url( '/assets/js/app.js', __FILE__ ), array( 'raptorize' ), '0.2.1', false );
	wp_localize_script( 'fe-raptor-button', 'feRaptorConfig', $js_config );

	wp_enqueue_script( 'fe-raptor-button' );
}
