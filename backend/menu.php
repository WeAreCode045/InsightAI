
<?php

function insightai_menu(): void
{
	add_menu_page('InsightAI', 'InsightAI', 'manage_options', 'insightai', 'insightai_dashboard', 'dashicons-analytics');
	add_submenu_page('insightai', 'Dashboard', 'Dashboard', 'manage_options', 'insightai', 'insightai_dashboard');
}

function insightai_dashboard(): void
{
	include(BACKEND . '/dashboard.php');
}


add_action('admin_menu', 'insightai_menu');


