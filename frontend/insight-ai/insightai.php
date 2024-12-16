<?php

function insightai_shortcode() {
    $file_path = plugin_dir_path(__FILE__) . '../../pdfpintar/public/index.php';
    if (file_exists($file_path)) {
        return file_get_contents($file_path);
    } else {
        return 'File not found.';
    }
}
add_shortcode('insightai', 'insightai_shortcode');
