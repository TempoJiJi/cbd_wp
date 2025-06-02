<?php
/**
 * This file represents an example of the code that themes would use to register
 * the required plugins.
 *
 * It is expected that theme authors would copy and paste this code into their
 * functions.php file, and amend to suit.
 *
 * @see http://tgmpluginactivation.com/configuration/ for detailed documentation.
 *
 * @package    TGM-Plugin-Activation
 * @subpackage Example
 * @version    2.6.1 for parent theme Leksa for publication on ThemeForest
 * @author     Thomas Griffin, Gary Jones, Juliette Reinders Folmer
 * @copyright  Copyright (c) 2011, Thomas Griffin
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       https://github.com/TGMPA/TGM-Plugin-Activation
 */

/**
 * Include the TGM_Plugin_Activation class.
 *
 * Depending on your implementation, you may want to change the include call:
 *
 * Parent Theme:
 * require_once get_template_directory() . '/path/to/class-tgm-plugin-activation.php';
 *
 * Child Theme:
 * require_once get_stylesheet_directory() . '/path/to/class-tgm-plugin-activation.php';
 *
 * Plugin:
 * require_once dirname( __FILE__ ) . '/path/to/class-tgm-plugin-activation.php';
 */
require_once get_template_directory() . '/inc/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'leksa_register_required_plugins' );

/**
 * Register the required plugins for this theme.
 *
 * In this example, we register five plugins:
 * - one included with the TGMPA library
 * - two from an external source, one from an arbitrary source, one from a GitHub repository
 * - two from the .org repo, where one demonstrates the use of the `is_callable` argument
 *
 * The variables passed to the `tgmpa()` function should be:
 * - an array of plugin arrays;
 * - optionally a configuration array.
 * If you are not changing anything in the configuration array, you can remove the array and remove the
 * variable from the function call: `tgmpa( $plugins );`.
 * In that case, the TGMPA default settings will be used.
 *
 * This function is hooked into `tgmpa_register`, which is fired on the WP `init` action on priority 10.
 */
function leksa_register_required_plugins() {
	/*
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(

		array(
			'name'         => esc_html__('Elementor' , 'leksa'), // The plugin name.
			'slug'         => 'elementor', // The plugin slug (typically the folder name).
			'required'     => true, // If false, the plugin is only 'recommended' instead of required.
		),
        array(
			'name'         => esc_html__('Redux Framework' , 'leksa'), // The plugin name.
			'slug'         => 'redux-framework', // The plugin slug (typically the folder name).
			'required'     => true, // If false, the plugin is only 'recommended' instead of required.
		),
        array(
			'name'         => esc_html__('Advanced Custom Fields' , 'leksa'), // The plugin name.
			'slug'         => 'advanced-custom-fields', // The plugin slug (typically the folder name).
			'required'     => true, // If false, the plugin is only 'recommended' instead of required.
		),
        array(
			'name'         => esc_html__('ACF Photo Gallery Field' , 'leksa'), // The plugin name.
			'slug'         => 'navz-photo-gallery', // The plugin slug (typically the folder name).
			'required'     => true, // If false, the plugin is only 'recommended' instead of required.
		),
        array(
			'name'         => esc_html__('Contact Form 7' , 'leksa'), // The plugin name.
			'slug'         => 'contact-form-7', // The plugin slug (typically the folder name).
			'required'     => true, // If false, the plugin is only 'recommended' instead of required.
		),
        array(
			'name'         => esc_html__('One Click Demo İmport' , 'leksa'), // The plugin name.
			'slug'         => 'one-click-demo-import', // The plugin slug (typically the folder name).
			'required'     => true, // If false, the plugin is only 'recommended' instead of required.
		),
        array(
			'name'         => esc_html__('Material Design Icons for Page Builders' , 'leksa'), // The plugin name.
			'slug'         => 'material-design-icons-for-elementor', // The plugin slug (typically the folder name).
			'required'     => true, // If false, the plugin is only 'recommended' instead of required.
		),
        array(
			'name'         => esc_html__('Woocommerce' , 'leksa'), // The plugin name.
			'slug'         => 'woocommerce', // The plugin slug (typically the folder name).
			'required'     => true, // If false, the plugin is only 'recommended' instead of required.
		),
        array(
			'name'         => esc_html__('Pe Core' , 'leksa'), // The plugin name.
			'slug'         => 'pe-core', // The plugin slug (typically the folder name).
            'source'       => 'https://themes.pethemes.com/leksa/plugins/pe-core.zip', // The plugin source.
			'required'     => true, // If false, the plugin is only 'recommended' instead of required.
            'version'      => '1.4.0',
		),

	);

	
	$config = array(
		'id'           => 'leksa',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.

	
	);

	tgmpa( $plugins, $config );
}
