<?php
defined('ABSPATH') || exit;

// ─── Booking List Columns ────────────────────────────────────────
add_filter('manage_nagham_booking_posts_columns', function ($cols) {
    return [
        'cb'            => $cols['cb'],
        'title'         => 'اسم العميل',
        'occasion_type' => 'المناسبة',
        'event_date'    => 'التاريخ',
        'phone'         => 'الجوال',
        'status'        => 'الحالة',
        'date'          => 'وقت الحجز',
    ];
});

add_action('manage_nagham_booking_posts_custom_column', function ($col, $post_id) {
    $colors = [
        'new'       => '#d63638',
        'contacted' => '#dba617',
        'confirmed' => '#00a32a',
        'completed' => '#2271b1',
        'cancelled' => '#999999',
    ];
    $labels = [
        'new'       => 'جديد',
        'contacted' => 'تم التواصل',
        'confirmed' => 'مؤكد',
        'completed' => 'مكتمل',
        'cancelled' => 'ملغي',
    ];
    switch ($col) {
        case 'occasion_type':
            echo esc_html(get_post_meta($post_id, '_nagham_occasion_type', true));
            break;
        case 'event_date':
            echo esc_html(get_post_meta($post_id, '_nagham_event_date', true));
            break;
        case 'phone':
            $p  = get_post_meta($post_id, '_nagham_client_phone', true);
            $wa = 'https://wa.me/966' . ltrim($p, '0');
            echo '<a href="' . esc_url($wa) . '" target="_blank">' . esc_html($p) . '</a>';
            break;
        case 'status':
            $s = get_post_meta($post_id, '_nagham_status', true) ?: 'new';
            $c = $colors[$s] ?? '#999';
            $l = $labels[$s] ?? $s;
            echo '<span style="color:' . $c . ';font-weight:600">' . $l . '</span>';
            break;
    }
}, 10, 2);

// ─── Filter by Status ────────────────────────────────────────────
add_action('restrict_manage_posts', function ($post_type) {
    if ($post_type !== 'nagham_booking') return;
    $current = $_GET['booking_status'] ?? '';
    $opts    = [
        ''          => 'كل الحالات',
        'new'       => 'جديد',
        'contacted' => 'تم التواصل',
        'confirmed' => 'مؤكد',
        'completed' => 'مكتمل',
        'cancelled' => 'ملغي',
    ];
    echo '<select name="booking_status">';
    foreach ($opts as $val => $label) {
        printf('<option value="%s"%s>%s</option>',
            $val, selected($current, $val, false), $label);
    }
    echo '</select>';
});

add_filter('parse_query', function ($query) {
    global $pagenow;
    if ($pagenow !== 'edit.php') return;
    if (empty($_GET['booking_status'])) return;
    if (($query->query['post_type'] ?? '') !== 'nagham_booking') return;
    $query->query_vars['meta_key']   = '_nagham_status';
    $query->query_vars['meta_value'] = sanitize_text_field($_GET['booking_status']);
});

// ─── Track List: show play count ────────────────────────────────
add_filter('manage_nagham_track_posts_columns', function ($cols) {
    $cols['occasion'] = 'المناسبة';
    $cols['plays']    = 'الاستماعات';
    $cols['duration'] = 'المدة';
    return $cols;
});

add_action('manage_nagham_track_posts_custom_column', function ($col, $post_id) {
    switch ($col) {
        case 'plays':
            echo (int) get_post_meta($post_id, '_nagham_plays', true);
            break;
        case 'duration':
            echo esc_html(get_post_meta($post_id, '_nagham_duration', true) ?: '—');
            break;
        case 'occasion':
            $terms = get_the_terms($post_id, 'nagham_occasion');
            echo $terms ? esc_html($terms[0]->name) : '—';
            break;
    }
}, 10, 2);
