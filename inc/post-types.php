<?php
defined('ABSPATH') || exit;

// ─── CPT: المقاطع الصوتية ────────────────────────────────────────
add_action('init', function () {
    register_post_type('nagham_track', [
        'labels' => [
            'name'               => 'المقاطع الصوتية',
            'singular_name'      => 'مقطع صوتي',
            'add_new'            => 'إضافة مقطع',
            'add_new_item'       => 'إضافة مقطع جديد',
            'edit_item'          => 'تعديل المقطع',
            'search_items'       => 'بحث في المقاطع',
            'not_found'          => 'لا توجد مقاطع',
        ],
        'public'        => false,
        'show_ui'       => true,
        'show_in_menu'  => true,
        'show_in_rest'  => true,
        'menu_icon'     => 'dashicons-format-audio',
        'menu_position' => 5,
        'supports'      => ['title', 'thumbnail'],
        'rewrite'       => false,
    ]);

    // Taxonomy: نوع المناسبة
    register_taxonomy('nagham_occasion', 'nagham_track', [
        'labels' => [
            'name'          => 'نوع المناسبة',
            'singular_name' => 'مناسبة',
            'all_items'     => 'كل المناسبات',
            'add_new_item'  => 'إضافة مناسبة',
        ],
        'hierarchical'      => true,
        'show_ui'           => true,
        'show_in_rest'      => true,
        'show_admin_column' => true,
        'rewrite'           => false,
    ]);
});

// ─── CPT: الحجوزات ───────────────────────────────────────────────
add_action('init', function () {
    register_post_type('nagham_booking', [
        'labels' => [
            'name'          => 'الحجوزات',
            'singular_name' => 'حجز',
            'all_items'     => 'كل الحجوزات',
            'edit_item'     => 'تفاصيل الحجز',
            'search_items'  => 'بحث في الحجوزات',
            'not_found'     => 'لا توجد حجوزات',
        ],
        'public'        => false,
        'show_ui'       => true,
        'show_in_menu'  => true,
        'menu_icon'     => 'dashicons-calendar-alt',
        'menu_position' => 6,
        'supports'      => ['title'],
        'capabilities'  => ['create_posts' => 'do_not_allow'],
        'map_meta_cap'  => true,
    ]);
});
