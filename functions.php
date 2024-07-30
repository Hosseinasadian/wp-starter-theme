<?php
if (!defined('Theme_ROOT_URL')) {
	define('Theme_ROOT_URL', get_template_directory_uri());
}

if (!defined('Theme_ROOT_PATH')) {
	define('Theme_ROOT_PATH', get_template_directory());
}

if (!defined('THEME_VERSION')) {
	define('THEME_VERSION', '1.0.0');
}

function starter_theme_setup()
{
	load_theme_textdomain('starter-theme', get_template_directory() . '/languages');

	add_theme_support('automatic-feed-links');

	add_theme_support('title-tag');

	add_theme_support('post-thumbnails');

	register_nav_menus(
		array(
			'menu-1' => esc_html__('Primary', 'starter-theme'),
		)
	);

	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	add_theme_support(
		'custom-background',
		apply_filters(
			'starter_theme_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	add_theme_support('customize-selective-refresh-widgets');

	add_theme_support(
		'custom-logo',
		array(
			'height' => 250,
			'width' => 250,
			'flex-width' => true,
			'flex-height' => true,
		)
	);
}

add_action('after_setup_theme', 'starter_theme_setup');

function starter_theme_content_width()
{
	$GLOBALS['content_width'] = apply_filters('starter_theme_content_width', 640);
}

add_action('after_setup_theme', 'starter_theme_content_width', 0);

function starter_theme_widgets_init()
{
	register_sidebar(
		array(
			'name' => esc_html__('Sidebar', 'starter-theme'),
			'id' => 'sidebar-1',
			'description' => esc_html__('Add widgets here.', 'starter-theme'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget' => '</section>',
			'before_title' => '<h2 class="widget-title">',
			'after_title' => '</h2>',
		)
	);
}

add_action('widgets_init', 'starter_theme_widgets_init');

function starter_theme_scripts()
{
	wp_enqueue_style('starter-theme-style', get_stylesheet_uri(), array(), THEME_VERSION);
	wp_style_add_data('starter-theme-style', 'rtl', 'replace');

	wp_enqueue_script('starter-theme-navigation', get_template_directory_uri() . '/js/navigation.js', array(), THEME_VERSION, true);

	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}
}

add_action('wp_enqueue_scripts', 'starter_theme_scripts');

require get_template_directory() . '/inc/custom-header.php';

require get_template_directory() . '/inc/template-tags.php';

require get_template_directory() . '/inc/template-functions.php';

require get_template_directory() . '/inc/customizer.php';

if (defined('JETPACK__VERSION')) {
	require get_template_directory() . '/inc/jetpack.php';
}

require_once get_template_directory() . '/inc/tgm/starter-activation.php';

require_once get_template_directory() . '/inc/options/index.php';

require_once get_template_directory() . '/inc/demo-data/import.php';

