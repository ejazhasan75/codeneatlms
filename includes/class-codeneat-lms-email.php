<?php

if (!defined('ABSPATH')) {
    exit;
}

class Codeneat_LMS_Email {
    /**
     * Email the school admin after a school registration request is submitted.
     *
     * @param string $school_name School name.
     * @param string $admin_email School admin email address.
     * @param int    $school_id   School post ID.
     * @return bool Whether WordPress accepted the email for sending.
     */
    public static function send_school_registration_email($school_name, $admin_email, $school_id) {
        $admin_email = sanitize_email($admin_email);

        if (!$admin_email || !is_email($admin_email)) {
            return false;
        }

        $subject = sprintf(
            __('School registration received: %s', 'codeneat-lms'),
            sanitize_text_field($school_name)
        );

        $message = sprintf(
            __("Hello,\n\nThank you for registering %1\$s. Your request has been received and is pending review.\n\nSchool reference: %2\$d\n\nRegards,\nCodeNeat LMS", 'codeneat-lms'),
            sanitize_text_field($school_name),
            absint($school_id)
        );

        return wp_mail($admin_email, $subject, $message);
    }

    /**
     * Email a teacher when they are invited to a school.
     *
     * @param string $teacher_name  Teacher name.
     * @param string $teacher_email Teacher email address.
     * @param int    $school_id     School post ID.
     * @return bool Whether WordPress accepted the email for sending.
     */
    public static function send_teacher_invite_email($teacher_name, $teacher_email, $school_id) {
        $teacher_email = sanitize_email($teacher_email);

        if (!$teacher_email || !is_email($teacher_email)) {
            return false;
        }

        $subject = __('Teacher invitation from CodeNeat LMS', 'codeneat-lms');
        $login_url = wp_login_url();

        $message = sprintf(
            __("Hello %1\$s,\n\nYou have been invited to join a school on CodeNeat LMS.\n\nSchool reference: %2\$d\nSign in at: %3\$s\n\nIf you were not expecting this invitation, you can ignore this email.\n\nRegards,\nCodeNeat LMS", 'codeneat-lms'),
            sanitize_text_field($teacher_name),
            absint($school_id),
            esc_url_raw($login_url)
        );

        return wp_mail($teacher_email, $subject, $message);
    }
}
