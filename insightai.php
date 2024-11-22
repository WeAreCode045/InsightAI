<?php
/*
Plugin Name: InsightAI
Plugin URI: https://code045.nl/insightai
Description: Get Insights from your data with InsightAI - The AI powered document analysis tool.
Version: 1.0
Author: Code045
Author URI: https://code045.nl
License: GPL2
*/

function insightai_enqueue_assets(): void
{
    wp_enqueue_style('insightai-styles', plugins_url('css/styles.css', __FILE__));
    wp_enqueue_script('insightai-scripts', plugins_url('js/scripts.js', __FILE__));
}
add_action('admin_enqueue_scripts', 'insightai_enqueue_assets');


//include the shortcode file

include(plugin_dir_path(__FILE__) . 'includes/shortcodes.php');

// include the admin menu file

include(plugin_dir_path(__FILE__) . 'includes/admin/menu.php');

// include the admin settings file

include(plugin_dir_path(__FILE__) . 'includes/admin/settings.php');

// include the user relations file

include(plugin_dir_path(__FILE__) . 'includes/user/relations.php');
include(plugin_dir_path(__FILE__) . 'includes/verenigingen/relations.php');
