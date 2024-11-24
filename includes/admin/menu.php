<?php

function insightai_menu(): void
{
	add_menu_page('InsightAI', 'InsightAI', 'manage_options', 'insightai', 'insightai_dashboard');
}

