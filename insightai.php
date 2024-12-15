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

// Constants
define ('PLUGIN_URL', plugin_dir_url(__DIR__));    // the URL of the plugin
define ('PLUGIN_DIR', plugin_dir_path(__FILE__));   // the directory of the plugin
define ('ASSETS', PLUGIN_URL . 'assets');          // the directory of the assets
define ('FRONTEND', PLUGIN_DIR . 'frontend');      // the directory of the frontend
define ('BACKEND', PLUGIN_DIR . 'backend');        // the directory of the backend
define ('INCLUDES', PLUGIN_DIR . 'includes');      // the directory of the includes

// Roles
define ('GROUP', INCLUDES . '/group');              // the directory of the group includes
define ('USER', INCLUDES . '/user');                // the directory of the user includes

// WooCommerce
define ('WOOCOMMERCE', FRONTEND . '/woocommerce');  // the directory of the woocommerce includes

// InsightAI
define ('INSIGHTAI', FRONTEND . '/insight-ai');      // the directory of the insightai includes


// Relations and Queries
include_once(USER . '/relations.php');
include_once(GROUP . '/relations.php');

// WooCommerce 
include_once(WOOCOMMERCE . '/checkout.php');
include_once(WOOCOMMERCE . '/single-product.php');
include_once(WOOCOMMERCE . '/cart.php');

// General includes 
include_once(BACKEND . '/menu.php');

include_once(FRONTEND . '/shortcodes.php');

// InsightAI
include_once(INSIGHTAI . '/pdfchat.php');