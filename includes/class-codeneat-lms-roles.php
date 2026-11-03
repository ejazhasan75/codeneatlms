<?php

if (!defined('ABSPATH')) {
    exit;
}

class Codeneat_LMS_Roles {
    public static function register() {
        $roles = [
            'platform_admin' => [
                'name' => 'Platform Admin',
                'caps' => ['read' => true, 'manage_options' => true],
            ],
            'school_admin' => [
                'name' => 'School Admin',
                'caps' => ['read' => true, 'edit_posts' => true],
            ],
            'school_teacher' => [
                'name' => 'School Teacher',
                'caps' => ['read' => true, 'edit_posts' => true],
            ],
            'school_student' => [
                'name' => 'School Student',
                'caps' => ['read' => true],
            ],
        ];

        foreach ($roles as $slug => $data) {
            if (!get_role($slug)) {
                add_role($slug, $data['name'], $data['caps']);
            }
        }
    }
}
