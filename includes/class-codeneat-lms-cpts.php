<?php

if (!defined('ABSPATH')) {
    exit;
}

class Codeneat_LMS_CPTs {
    public function register() {
        add_action('init', [$this, 'register_post_types'], 10);
        add_action('init', [$this, 'register_taxonomies'], 11);
    }

    public function register_post_types() {
        register_post_type('cn_school', [
            'labels' => [
                'name' => 'Schools',
                'singular_name' => 'School',
            ],
            'public' => false,
            'show_ui' => true,
            'show_in_menu' => 'codeneat-lms',
            'supports' => ['title', 'editor'],
            'menu_icon' => 'dashicons-building',
        ]);

        register_post_type('cn_classroom', [
            'labels' => [
                'name' => 'Classrooms',
                'singular_name' => 'Classroom',
            ],
            'public' => false,
            'show_ui' => true,
            'show_in_menu' => 'codeneat-lms',
            'supports' => ['title', 'editor'],
            'menu_icon' => 'dashicons-groups',
        ]);

        register_post_type('cn_subject', [
            'labels' => [
                'name' => 'Subjects',
                'singular_name' => 'Subject',
            ],
            'public' => false,
            'show_ui' => true,
            'show_in_menu' => 'codeneat-lms',
            'supports' => ['title', 'editor'],
            'menu_icon' => 'dashicons-book-alt',
        ]);
    }

    public function register_taxonomies() {
        register_taxonomy('cn_subject_group', ['cn_subject'], [
            'labels' => [
                'name' => 'Subject Groups',
                'singular_name' => 'Subject Group',
            ],
            'public' => false,
            'show_ui' => true,
            'hierarchical' => true,
        ]);
    }
}
