<?php

if (!defined('ABSPATH')) {
    exit;
}

class Codeneat_LMS_REST {
    public function register() {
        add_action('rest_api_init', [$this, 'register_routes']);
    }

    public function register_routes() {
        register_rest_route('cn-lms/v1', '/health', [
            'methods' => WP_REST_Server::READABLE,
            'callback' => [$this, 'health_check'],
            'permission_callback' => '__return_true',
        ]);

        register_rest_route('cn-lms/v1', '/schools/register', [
            'methods' => WP_REST_Server::CREATABLE,
            'callback' => [$this, 'register_school'],
            'permission_callback' => '__return_true',
        ]);
    }

    public function health_check() {
        return [
            'success' => true,
            'message' => 'CodeNeat LMS API is active.',
            'version' => '0.1.0',
        ];
    }

    public function register_school(WP_REST_Request $request) {
        $result = Codeneat_LMS::register_school_request($request->get_params());

        if (!$result['success']) {
            return new WP_REST_Response($result, 400);
        }

        return new WP_REST_Response($result, 200);
    }
}
