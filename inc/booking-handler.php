<?php
defined('ABSPATH') || exit;

add_action('wp_ajax_nopriv_nagham_submit_booking', 'nagham_handle_booking');
add_action('wp_ajax_nagham_submit_booking',        'nagham_handle_booking');

function nagham_handle_booking() {
    check_ajax_referer('nagham_nonce', 'nonce');

    // ─── Validate required fields ───────────────────────────────
    $required = ['client_name', 'client_phone', 'occasion_type', 'event_date'];
    foreach ($required as $field) {
        if (empty($_POST[$field])) {
            wp_send_json_error(['msg' => 'missing_field', 'field' => $field]);
        }
    }

    $name     = sanitize_text_field($_POST['client_name']);
    $phone    = sanitize_text_field($_POST['client_phone']);
    $occasion = sanitize_text_field($_POST['occasion_type']);
    $date     = sanitize_text_field($_POST['event_date']);
    $city     = sanitize_text_field($_POST['event_city'] ?? '');
    $notes    = sanitize_textarea_field($_POST['notes'] ?? '');

    // ─── Basic phone validation (Saudi) ─────────────────────────
    if (!preg_match('/^(05|5|\+9665)[0-9]{8}$/', $phone)) {
        wp_send_json_error(['msg' => 'invalid_phone']);
    }

    // ─── Duplicate check (same phone + same date) ───────────────
    $existing = get_posts([
        'post_type'  => 'nagham_booking',
        'meta_query' => [
            'relation' => 'AND',
            ['key' => '_nagham_client_phone', 'value' => $phone],
            ['key' => '_nagham_event_date',   'value' => $date],
        ],
        'posts_per_page' => 1,
    ]);
    if ($existing) {
        wp_send_json_error(['msg' => 'duplicate_booking']);
    }

    // ─── Create booking post ─────────────────────────────────────
    $post_id = wp_insert_post([
        'post_type'   => 'nagham_booking',
        'post_title'  => $name . ' — ' . $occasion . ' — ' . $date,
        'post_status' => 'publish',
    ]);

    if (is_wp_error($post_id)) {
        wp_send_json_error(['msg' => 'db_error']);
    }

    // ─── Save meta fields ────────────────────────────────────────
    $meta = [
        '_nagham_client_name'   => $name,
        '_nagham_client_phone'  => $phone,
        '_nagham_occasion_type' => $occasion,
        '_nagham_event_date'    => $date,
        '_nagham_event_city'    => $city,
        '_nagham_notes'         => $notes,
        '_nagham_status'        => 'new',
        '_nagham_ip'            => $_SERVER['REMOTE_ADDR'],
        '_nagham_submitted_at'  => current_time('mysql'),
    ];
    foreach ($meta as $key => $val) {
        update_post_meta($post_id, $key, $val);
    }

    // ─── Notify admin by email ───────────────────────────────────
    nagham_notify_new_booking($post_id);

    wp_send_json_success([
        'msg'        => 'booking_created',
        'booking_id' => $post_id,
        'whatsapp'   => 'https://wa.me/966550888678?text=' . urlencode(
            "مرحباً، اسمي $name\nقدّمت طلب حجز لـ $occasion بتاريخ $date\nأرقم الطلب: #$post_id"
        ),
    ]);
}
