<?php

if (!defined('ABSPATH')) {
    exit;
}

class Codeneat_LMS_Admin {
    public function register() {
        add_action('admin_menu', [$this, 'register_menu_pages']);
    }

    public function register_menu_pages() {
        add_menu_page(
            'CodeNeat LMS',
            'CodeNeat LMS',
            'manage_options',
            'codeneat-lms',
            [$this, 'render_dashboard'],
            'dashicons-education',
            25
        );

        add_submenu_page('codeneat-lms', 'Overview', 'Overview', 'manage_options', 'codeneat-lms', [$this, 'render_dashboard']);
        add_submenu_page('codeneat-lms', 'Schools', 'Schools', 'manage_options', 'edit.php?post_type=cn_school');
        add_submenu_page('codeneat-lms', 'Classrooms', 'Classrooms', 'manage_options', 'edit.php?post_type=cn_classroom');
        add_submenu_page('codeneat-lms', 'Subjects', 'Subjects', 'manage_options', 'edit.php?post_type=cn_subject');
    }

    public function render_dashboard() {
        echo '<div class="wrap"><h1>CodeNeat LMS Dashboard</h1></div>';
    }
}
