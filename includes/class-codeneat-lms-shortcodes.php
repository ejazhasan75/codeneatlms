<?php

if (!defined('ABSPATH')) {
    exit;
}

class Codeneat_LMS_Shortcodes {
    public function register() {
        add_shortcode('cnlms_school_registration_form', [$this, 'render_school_registration_form']);
    }

    public function render_school_registration_form() {
        ob_start();
        ?>
        <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
            <input type="hidden" name="action" value="cnlms_register_school" />
            <?php wp_nonce_field('cnlms_register_school'); ?>

            <p>
                <label>School Name</label><br />
                <input type="text" name="school_name" required />
            </p>

            <p>
                <label>School Email</label><br />
                <input type="email" name="school_email" required />
            </p>

            <p>
                <label>School Admin Name</label><br />
                <input type="text" name="admin_name" required />
            </p>

            <p>
                <label>School Admin Email</label><br />
                <input type="email" name="admin_email" required />
            </p>

            <p><button type="submit">Register School</button></p>
        </form>
        <?php
        return ob_get_clean();
    }
}

add_action('admin_post_cnlms_register_school', function () {
    if (!isset($_POST['_wpnonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['_wpnonce'])), 'cnlms_register_school')) {
        wp_die('Security check failed.');
    }

    $result = Codeneat_LMS::register_school_request([
        'school_name' => $_POST['school_name'] ?? '',
        'school_email' => $_POST['school_email'] ?? '',
        'admin_name' => $_POST['admin_name'] ?? '',
        'admin_email' => $_POST['admin_email'] ?? '',
    ]);

    $redirect = add_query_arg('cnlms_status', $result['success'] ? 'success' : 'error', home_url('/'));
    $redirect = add_query_arg('cnlms_message', urlencode($result['message']), $redirect);
    wp_safe_redirect($redirect);
    exit;
});
