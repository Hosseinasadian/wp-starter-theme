<?php
require_once trailingslashit(Theme_ROOT_PATH) . 'inc/tgm/class-tgm-plugin-activation.php';

add_action('tgmpa_register', 'starter_required_plugins');
function starter_required_plugins()
{

	$plugins = array(
		array(
			'name' => __('Redux', 'starter-theme'),
			'slug' => 'redux-framework',
			'required' => true,
			'force_activation' => true,
			'force_deactivation' => true,
		),

		array(
			'name' => __('One Click Demo Import', 'pezeshkyar'),
			'slug' => 'one-click-demo-import',
			'required' => false,
		),

		array(
			'name' => __('Elementor', 'starter-theme'),
			'slug' => 'elementor',
			'required' => false,
		),

		array(
			'name' => __('Woocommerce', 'pezeshkyar'),
			'slug' => 'woocommerce',
			'required' => false,
		),

	);

	$config = array(
		'id' => 'starter-theme',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'domain' => 'tgmpa',
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu' => 'tgmpa-install-plugins', // Menu slug.
		'parent_slug' => 'themes.php',            // Parent menu slug.
		'capability' => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
		'has_notices' => true,                    // Show admin notices or not.
		'dismissable' => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg' => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message' => '',                      // Message to output right before the plugins table.

	);

	tgmpa($plugins, $config);
}
