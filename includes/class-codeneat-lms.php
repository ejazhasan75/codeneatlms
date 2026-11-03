<?php

if (!defined('ABSPATH')) {
    exit;
}

class Codeneat_LMS {
    private static $instance = null;

    public static function instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function __construct() {
        add_action('init', [$this, 'bootstrap'], 0);
    }

    public function bootstrap() {
        Codeneat_LMS_Roles::register();
        $cpts = new Codeneat_LMS_CPTs();
        $cpts->register();

        $admin = new Codeneat_LMS_Admin();
        $admin->register();

        $rest = new Codeneat_LMS_REST();
        $rest->register();

        $shortcodes = new Codeneat_LMS_Shortcodes();
        $shortcodes->register();
    }

    public static function activate() {
        Codeneat_LMS_Roles::register();
        flush_rewrite_rules();
    }

    public static function deactivate() {
        flush_rewrite_rules();
    }

    public static function register_school_request($data = []) {
        $school_name = isset($data['school_name']) ? sanitize_text_field(wp_unslash($data['school_name'])) : '';
        $school_email = isset($data['school_email']) ? sanitize_email(wp_unslash($data['school_email'])) : '';
        $admin_name = isset($data['admin_name']) ? sanitize_text_field(wp_unslash($data['admin_name'])) : '';
        $admin_email = isset($data['admin_email']) ? sanitize_email(wp_unslash($data['admin_email'])) : '';

        if (empty($school_name) || empty($school_email) || empty($admin_name) || empty($admin_email)) {
            return [
                'success' => false,
                'message' => 'All school and admin fields are required.',
            ];
        }

        $school_id = wp_insert_post([
            'post_type'   => 'cn_school',
            'post_title'  => $school_name,
            'post_status' => 'pending',
        ]);

        if (is_wp_error($school_id)) {
            return [
                'success' => false,
                'message' => 'The school could not be created.',
            ];
        }

        update_post_meta($school_id, 'cn_school_email', $school_email);
        update_post_meta($school_id, 'cn_school_admin_name', $admin_name);
        update_post_meta($school_id, 'cn_school_admin_email', $admin_email);

        $user = get_user_by('email', $admin_email);

        if (!$user) {
            $password = wp_generate_password(18, true, true);
            $user_id = wp_create_user($admin_email, $password, $admin_email);
            if (!is_wp_error($user_id)) {
                wp_update_user([
                    'ID' => $user_id,
                    'display_name' => $admin_name,
                    'first_name' => $admin_name,
                    'role' => 'school_admin',
                ]);
            }
        }

        return [
            'success' => true,
            'message' => 'School registration submitted successfully.',
            'school_id' => $school_id,
        ];
    }
}
