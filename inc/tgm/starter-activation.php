<?php
require_once trailingslashit(Theme_ROOT_PATH) . 'inc/tgm/class-tgm-plugin-activation.php';

add_action('tgmpa_register', 'starter_required_plugins');
function starter_required_plugins()
{

	$plugins = array(
		array(
			'name' => __('Redux', 'alma'),
			'slug' => 'redux-framework',
			'required' => true,
			'force_activation' => true,
			'force_deactivation' => true,
		),

		array(
            'name' => __('Alma Core', 'alma'),
            'slug' => 'alma-core',
            'source' => get_template_directory() . '/inc/plugins/alma-core.zip',
            'required' => true,
            'version' => '1.1.3',
            'force_activation' => true,
            'force_deactivation' => true,
            'external_url' => '',
            'is_callable' => '',
        ),

		array(
			'name' => __('Elementor', 'alma'),
			'slug' => 'elementor',
			'required' => false,
		),

		array(
			'name' => __('Woocommerce', 'alma'),
			'slug' => 'woocommerce',
			'required' => false,
		),

		array(
			'name' => __('WP Statistics', 'alma'),
			'slug' => 'wp-statistics',
			'required' => false,
		),

		array(
            'name' => __('Wordpress Advanced Support Ticket', 'alma'),
            'slug' => 'alma-core',
            'source' => get_template_directory() . '/inc/plugins/wp-advanced-support-ticket.zip',
            'required' => false,
			'version' => '13.1.1',
        ),

		array(
			'name' => __('Posts Like Dislike', 'alma'),
			'slug' => 'posts-like-dislike',
			'required' => false,
		),

		array(
			'name' => __('Variation Swatches for WooCommerce', 'alma'),
			'slug' => 'woo-variation-swatches',
			'required' => false,
		),

		array(
			'name' => __('WordPress Mail SMTP Plugin', 'alma'),
			'slug' => 'wp-mail-smtp',
			'required' => false,
		),

		array(
			'name' => __('WordPress Parsi Date Plugin', 'alma'),
			'slug' => 'wp-parsidate',
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
