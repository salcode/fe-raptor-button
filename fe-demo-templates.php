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
 * Text Domain: fe-demo-templates
 * Domain Path: /languages
 *
 * @package fe-demo-templates
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

add_action( 'wp_footer', 'fe_tf' );

/**
 * Output the markup for the Fe Demo Templates plugin in the footer.
 */
function fe_tf() {
	$btn_txt = __( 'Bring out the Raptor', 'fe-demo-templates' );
	$btn_txt = apply_filters( 'fe_raptorize_button_text', $btn_txt );

	// This is a list of possible templates, from most to least specific.
	$templates = array(
		// Check for a template in the theme with the Post ID.
		// e.g. themes/mytheme/fe-demo-templates/foot-13.php, where 13 is the post ID.
		sprintf(
			get_stylesheet_directory() . '/fe-demo-templates/foot-%s.php',
			get_the_ID()
		),
		// Check for a generic template in the theme.
		// e.g. themes/mytheme/fe-demo-templates/foot.php.
		get_stylesheet_directory() . '/fe-demo-templates/foot.php',
		// This is the path to the default template that is part of the plugin.
		__DIR__ . '/templates/foot.php',
	);
	// Allow the template list to be modified via the `fe_demo_templates-template_list` filter.
	$templates = apply_filters( 'fe_demo_templates-template_list', $templates );
	// Loop through each of the templates.
	foreach ( $templates as $tmpl ) {
		if ( file_exists( $tmpl ) ) {
			// If the template exists, display it.
			include $tmpl;
			// Break out of the foreach loop.
			break;
		}
	}
}

add_action( 'wp_enqueue_scripts', 'fe_demo_template_enqueue_js' );
function fe_demo_template_enqueue_js() {
	wp_register_script( 'raptorize', plugins_url( '/assets/js/jquery.raptorize.1.0-salcode.js', __FILE__ ), array( 'jquery' ), '1.0-salcode.1', true );
	wp_localize_script( 'raptorize', 'feDemoTemplateRaptor', array(
		'assetPath' => plugins_url( '/assets/', __FILE__ ),
	) );
	wp_register_script( 'fe_demo_template', plugins_url( '/assets/js/app.js', __FILE__ ), array( 'raptorize' ), '0.2.0', true );

	wp_enqueue_script( 'fe_demo_template' );
}
