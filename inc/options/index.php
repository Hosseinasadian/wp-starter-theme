<?php

if (!class_exists('Redux')) {
    return;
}

$opt_name = 'starter_options';

$theme = wp_get_theme(); // For use with some settings. Not necessary.

$args = array(
	'display_name' => $theme->get('Name'),
	'display_version' => $theme->get('Version'),
	'menu_title' => esc_html__('تنطیمات قالب', 'starter-theme'),
	'customizer' => true,
);

Redux::set_args($opt_name, $args);

require_once trailingslashit(Theme_ROOT_PATH) . 'inc/options/opt_general.php';
