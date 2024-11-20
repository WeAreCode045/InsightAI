<?php

/**
 * Add the settings fields to the settings page
 */
// Exit if accessed directly

if (!defined('ABSPATH')) {

	exit;
}

// Add the settings fields to the settings page

function insightai_openai_settings(): void
{
	add_settings_section('insightai_settings', 'InsightAI Settings', 'insightai_settings_section', 'insightai_settings');
	add_settings_field('insightai_openai_api_key', 'OpenAI API Key', 'insightai_openai_api_key', 'insightai_settings', 'insightai_settings');
	register_setting('insightai_settings', 'insightai_openai_api_key');
}

function_plugin_license_keys_settings(): void
{
	add_settings_section('plugin_license_keys_settings', 'Plugin License Keys Settings', 'plugin_license_keys_settings_section', 'plugin_license_keys_settings');
	add_settings_field('plugin_license_keys', 'Plugin License Keys', 'plugin_license_keys', 'plugin_license_keys_settings', 'plugin_license_keys_settings');
	register_setting('plugin_license_keys_settings', 'plugin_license_keys');
}

// Add the settings section description

function insightai_settings_section(): void
{
	echo '<p>Enter your OpenAI API key below. This key is required to use the InsightAI plugin.</p>';
}

function plugin_license_keys_settings_section(): void
{
	echo '<p>Enter your plugin license keys below. These keys are required to use the plugins.</p>';
}

// Add the settings field

function insightai_openai_api_key(): void
{
	$openai_api_key = get_option('insightai_openai_api_key');
	echo '<input type="text" id="insightai_openai_api_key" name="insightai_openai_api_key" value="' . esc_attr($openai_api_key) . '" />';
}

function plugin_license_keys(): void
{
	$plugin_license_keys = get_option('plugin_license_keys');
	echo '<input type="text" id="plugin_license_keys" name="plugin_license_keys" value="' . esc_attr($plugin_license_keys) . '" />';
}

// Add the settings page to the admin menu

function insightai_menu(): void
{
	add_menu_page('InsightAI', 'InsightAI', 'manage_options', 'insightai', 'insightai_dashboard');
	add_submenu_page('insightai', 'Settings', 'Settings', 'manage_options', 'insightai-settings', 'insightai_settings_page');
}


