
<?php

add_shortcode('group_documents_dashboard', 'group_documents_dashboard_shortcode');

function group_documents_dashboard_shortcode() {
    ob_start();
    include_once(INSIGHTAI . '/documents-dashboard.php');
    return ob_get_clean();
}

add_shortcode('group_documents', 'group_documents_shortcode');

function group_documents_shortcode() {
    ob_start();
    include_once(INSIGHTAI . '/pdfchat.php');
    return ob_get_clean();
}

function insightai_shortcode() {
    ob_start();
    include_once(ABSPATH . '//pdfpintar/public/index.php');
    return ob_get_clean();
}
add_shortcode('insightai', 'insightai_shortcode');
