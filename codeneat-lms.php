<?php
/**
 * Plugin Name: CodeNeat LMS
 * Plugin URI: https://codeneat.com
 * Description: Multi-school LMS foundation for the main site.
 * Version: 0.1.0
 * Author: CodeNeat
 * Text Domain: codeneat-lms
 */

if (!defined('ABSPATH')) {
    exit;
}

if (!defined('CNLMS_PLUGIN_FILE')) {
    define('CNLMS_PLUGIN_FILE', __FILE__);
}

if (!defined('CNLMS_PLUGIN_PATH')) {
    define('CNLMS_PLUGIN_PATH', plugin_dir_path(__FILE__));
}

if (!defined('CNLMS_PLUGIN_URL')) {
    define('CNLMS_PLUGIN_URL', plugin_dir_url(__FILE__));
}

require_once CNLMS_PLUGIN_PATH . 'includes/class-codeneat-lms.php';
require_once CNLMS_PLUGIN_PATH . 'includes/class-codeneat-lms-roles.php';
require_once CNLMS_PLUGIN_PATH . 'includes/class-codeneat-lms-cpts.php';
require_once CNLMS_PLUGIN_PATH . 'includes/class-codeneat-lms-admin.php';
require_once CNLMS_PLUGIN_PATH . 'includes/class-codeneat-lms-rest.php';
require_once CNLMS_PLUGIN_PATH . 'includes/class-codeneat-lms-email.php';
require_once CNLMS_PLUGIN_PATH . 'includes/class-codeneat-lms-shortcodes.php';

function codeneat_lms() {
    return Codeneat_LMS::instance();
}

register_activation_hook(__FILE__, ['Codeneat_LMS', 'activate']);
register_deactivation_hook(__FILE__, ['Codeneat_LMS', 'deactivate']);

codeneat_lms();
