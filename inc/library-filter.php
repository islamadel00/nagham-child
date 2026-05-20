<?php
defined('ABSPATH') || exit;

add_action('wp_ajax_nopriv_nagham_filter_library', 'nagham_handle_library_filter');
add_action('wp_ajax_nagham_filter_library',        'nagham_handle_library_filter');

function nagham_handle_library_filter() {
    check_ajax_referer('nagham_nonce', 'nonce');

    $occasion = sanitize_text_field($_POST['occasion'] ?? '');
    $paged    = max(1, intval($_POST['paged'] ?? 1));
    $per_page = 12;

    $args = [
        'post_type'      => 'nagham_track',
        'post_status'    => 'publish',
        'posts_per_page' => $per_page,
        'paged'          => $paged,
        'orderby'        => 'menu_order date',
        'order'          => 'ASC',
    ];

    if ($occasion && $occasion !== 'all') {
        $args['tax_query'] = [[
            'taxonomy' => 'nagham_occasion',
            'field'    => 'slug',
            'terms'    => $occasion,
        ]];
    }

    $query  = new WP_Query($args);
    $tracks = [];

    foreach ($query->posts as $post) {
        $token = nagham_generate_audio_token($post->ID);
        $terms = get_the_terms($post->ID, 'nagham_occasion');
        $tracks[] = [
            'id'       => $post->ID,
            'title'    => $post->post_title,
            'duration' => get_post_meta($post->ID, '_nagham_duration', true),
            'plays'    => (int) get_post_meta($post->ID, '_nagham_plays', true),
            'featured' => (bool) get_post_meta($post->ID, '_nagham_featured', true),
            'occasion' => $terms ? $terms[0]->name : '',
            'token'    => urlencode($token),
            'thumb'    => get_the_post_thumbnail_url($post->ID, 'medium') ?: '',
        ];
    }

    wp_send_json_success([
        'tracks'     => $tracks,
        'total'      => $query->found_posts,
        'pages'      => $query->max_num_pages,
        'current'    => $paged,
        'stream_url' => home_url('/nagham-stream/'),
    ]);
}
