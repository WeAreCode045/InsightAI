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

// Add a menu item to the admin menu for the plugin and add a submenu item to the menu item for the user dashboard page in user-dashboard.php

add_action('admin_menu', 'insightai_menu');



function insightai_menu(): void
{
	add_menu_page('InsightAI', 'InsightAI', 'manage_options', 'insightai', 'insightai_dashboard');
	add_submenu_page('insightai', 'User Dashboard', 'User Dashboard', 'manage_options', 'insightai-user-dashboard', 'insightai_user_dashboard_page');
}

function insightai_user_dashboard_page(): void
{
	include(plugin_dir_path(__FILE__) . 'views/user/dashboard.php');
}

// include the documents.php file in the includes/functions/vereniging directory

include(plugin_dir_path(__FILE__) . 'includes/functions/vereniging/documents.php');


// include the team.php file in the includes/functions/vereniging directory

include(plugin_dir_path(__FILE__) . 'includes/functions/vereniging/team.php');

// include the content.php file in the includes/functions/vereniging directory

include(plugin_dir_path(__FILE__) . 'includes/functions/vereniging/content.php');

// include the relations.php file in the includes/functions/vereniging directory

include(plugin_dir_path(__FILE__) . 'includes/functions/vereniging/relations.php');

// include the registratie.php file in the includes/functions/user directory

include(plugin_dir_path(__FILE__) . 'includes/functions/user/registratie.php');
