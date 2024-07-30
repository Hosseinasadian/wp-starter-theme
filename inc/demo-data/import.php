<?php

function starter_import_files()
{
	return [
		[
			'import_file_name' => __('First Demo', 'starter-theme'),
			'categories' => ['Category 1', 'Category 2'],
			'local_import_file' => trailingslashit(Theme_ROOT_PATH) . 'inc/demo-data/first-demo/content.xml',
			'local_import_widget_file' => trailingslashit(Theme_ROOT_PATH) . 'inc/demo-data/first-demo/widgets.wie',
			'local_import_customizer_file' => trailingslashit(Theme_ROOT_PATH) . 'inc/demo-data/first-demo/customizer.dat',
			'local_import_redux' => [
				[
					'file_path' => trailingslashit(Theme_ROOT_PATH) . 'inc/demo-data/first-demo/redux.json',
					'option_name' => 'starter_options',
				]
			],
			'local_import_elementor_kit'=>trailingslashit(Theme_ROOT_PATH) . 'inc/demo-data/first-demo/elementor-globals.json',
			'import_preview_image_url' => trailingslashit(Theme_ROOT_URL) . 'inc/demo-data/first-demo/screenshot.png',
			'preview_url' => 'https://google.com',
		],
		[
			'import_file_name' => __('Second Demo', 'starter-theme'),
			'categories' => ['Category 2', 'Category 3'],
			'local_import_file' => trailingslashit(Theme_ROOT_PATH) . 'inc/demo-data/second-demo/content.xml',
			'local_import_widget_file' => trailingslashit(Theme_ROOT_PATH) . 'inc/demo-data/second-demo/widgets.wie',
			'local_import_customizer_file' => trailingslashit(Theme_ROOT_PATH) . 'inc/demo-data/second-demo/customizer.dat',
			'local_import_redux' => [
				[
					'file_path' => trailingslashit(Theme_ROOT_PATH) . 'inc/demo-data/second-demo/redux.json',
					'option_name' => 'starter_options',
				]
			],
			'local_import_elementor_kit'=>trailingslashit(Theme_ROOT_PATH) . 'inc/demo-data/second-demo/elementor-globals.json',
			'import_preview_image_url' => trailingslashit(Theme_ROOT_URL) . 'inc/demo-data/second-demo/screenshot.png',
			'preview_url' => 'https://yahoo.com',
		],
	];
}

add_filter('ocdi/import_files', 'starter_import_files');

function starter_register_plugins($plugins)
{
	$theme_plugins = [
		[
			'name' => __('Redux', 'starter-theme'),
			'slug' => 'redux-framework',
			'required' => true,
		],
		[
			'name' => __('Elementor', 'starter-theme'),
			'slug' => 'elementor',
			'required' => false,
		],
		[
			'name' => __('Woocommerce', 'starter-theme'),
			'slug' => 'woocommerce',
			'preselected' => false,
		],
	];

	return array_merge($plugins, $theme_plugins);
}

add_filter('ocdi/register_plugins', 'starter_register_plugins');

function starter_after_import_setup($selected_import)
{
	$main_menu = get_term_by('name', esc_html__('Primary', 'starter-theme'), 'nav_menu');

	set_theme_mod('nav_menu_locations', array(
			'menu-1' => $main_menu->term_id,
		)
	);

	$front_page = get_posts(array(
		'name' => 'Home',
		'post_type' => 'page',
		'numberposts' => 1,
	));

	if (!empty($front_page)) {
		update_option('show_on_front', 'page');
		update_option('page_on_front', $front_page[0]->ID);
	}

	$blog_page = get_posts(array(
		'name' => 'Blog',
		'post_type' => 'page',
		'numberposts' => 1,
	));

	if (!empty($blog_page)) {
		update_option( 'page_for_posts', $blog_page[0]->ID );
	}

	starter_local_import_elementor_kit($selected_import);
	starter_update_elementor_locations();
}

add_action('ocdi/after_import', 'starter_after_import_setup');

function starter_local_import_elementor_kit($selected_import)
{
	// Check if Elementor is activated.
	if (!did_action('elementor/loaded')) {
		return;
	}

	if (!isset($selected_import['local_import_elementor_kit'])){
		return;
	}

	// Path to the kit file.
	$kit_file = $selected_import['local_import_elementor_kit'];

	if (!file_exists($kit_file)) {
		return;
	}

	// Get the kit data.
	$kit_data = json_decode(file_get_contents($kit_file), true);

	if (!$kit_data) {
		return;
	}

	$kit = \Elementor\Plugin::$instance->kits_manager->get_active_kit();

	// Import the kit settings
	$kit->import($kit_data);

}

function starter_update_elementor_locations()
{
	if (!did_action('elementor/loaded')) {
		return;
	}

	$elementor_instance = \Elementor\Plugin::instance();
	$kits_manager = $elementor_instance->kits_manager;
	$active_kit_id = $kits_manager->get_active_id();

	if (!$active_kit_id) {
		return;
	}

	$kit = $elementor_instance->documents->get($active_kit_id);

	if (!$kit) {
		return;
	}

	// Force regeneration of the kit's CSS file
	$css_file = \Elementor\Core\Files\CSS\Post::create($active_kit_id);
	$css_file->update();

	// Update kit settings
	$kit_settings = $kit->get_settings();
	$kit->save(['settings' => $kit_settings]);

	// Clear Elementor's cache
	\Elementor\Plugin::$instance->files_manager->clear_cache();

	$cache = new ElementorPro\Modules\ThemeBuilder\Classes\Conditions_Cache();
	$cache_cleared = $cache->regenerate();
}
