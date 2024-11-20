<?php
function insightai_menu(): void
{
add_menu_page('InsightAI', 'InsightAI', 'manage_options', 'insightai', 'insightai_dashboard');
add_submenu_page('insightai', 'User Dashboard', 'User Dashboard', 'manage_options', 'insightai-user-dashboard', 'insightai_user_dashboard_page');
add_submenu_page('insightai', 'Settings', 'Settings', 'manage_options', 'insightai-settings', 'insightai_settings_page');
}


// include the admin dashboard page
function insightai_dashboard(): void
{
include(plugin_dir_path(__FILE__) . 'views/admin/dashboard.php');
}

// include the settings page

function insightai_settings_page(): void
{
include(plugin_dir_path(__FILE__) . 'views/admin/settings.php');
}