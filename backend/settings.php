<?php

/**
 * Add the settings fields to the settings page
 */
// Exit if accessed directly

if (!defined('ABSPATH')) {

	exit;
}

// Add a textfield to store the OpenAI API key

function openai_settings_field() {

	// Get the value of the setting we've registered with register_setting()

	$setting = get_option('openai_settings');

	// Output the field

	?>

	<input type="text" name="openai_settings[openai_api_key]" value="<?php echo isset($setting['openai_api_key']) ? $setting['openai_api_key'] : ''; ?>" />

	<?php

}

// Register the settings field

function openai_register_settings() {

	register_setting('openai_settings', 'openai_settings');

	add_settings_field('openai_api_key', 'OpenAI API Key', 'openai_settings_field', 'general');

}

add_action('admin_init', 'openai_register_settings');

