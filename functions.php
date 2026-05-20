<?php
defined('ABSPATH') || exit;

// ─── 1. تحميل استايلات أسترا (الأب) ──────────────────────────
add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style('astra-parent-style', get_template_directory_uri() . '/style.css');
});

// ─── 2. تحميل ملفات الثيم الابن (Nagham Assets) ─────────────────
add_action('wp_enqueue_scripts', function () {
    $v = wp_get_theme()->get('Version');
    wp_enqueue_style('nagham-style', get_stylesheet_directory_uri() . '/assets/css/nagham.css', ['astra-parent-style'], $v);
    wp_enqueue_script('nagham-main', get_stylesheet_directory_uri() . '/assets/js/nagham.js', [], $v, true);

    wp_localize_script('nagham-main', 'NAGHAM', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('nagham_nonce'),
        'home_url' => home_url(),
    ]);
}, 20);

// ─── 3. إعدادات الثيم (دعم الصور المصغرة والووكومرس) ────────────────
add_action('after_setup_theme', function () {
    add_theme_support('post-thumbnails');
    add_theme_support('title-tag');
    add_theme_support('woocommerce');
});

// ─── 4. تنظيف Astra ──────────────────────────────────────────
add_filter('astra_fonts_url', '__return_empty_string');
add_filter('astra_schema_enabled', '__return_false');

// ─── 5. استدعاء الموديلات الخارجية ───────────────────────────────
$modules = ['inc/post-types.php', 'inc/meta-boxes.php', 'inc/audio-protection.php', 'inc/booking-handler.php', 'inc/library-filter.php', 'inc/admin-columns.php'];
foreach ($modules as $module) {
    $path = get_stylesheet_directory() . '/' . $module;
    if (file_exists($path)) require_once $path;
}

// ─── 6. محرك الصوت الموحد (الاسم + الرابط + رفع من المكتبة) ──────────────────────────────
add_action('add_meta_boxes', 'nagham_unified_audio_metabox');
function nagham_unified_audio_metabox() {
    add_meta_box('nagham_audio_meta', 'المقاطع الصوتية (العينات)', 'nagham_unified_audio_callback', 'product', 'normal', 'high');
}

function nagham_unified_audio_callback($post) {
    wp_nonce_field('nagham_save_audio_data', 'nagham_audio_nonce');
    
    // جلب المقاطع (النظام الجديد)
    $audios = get_post_meta($post->ID, '_nagham_advanced_audios', true);
    
    // نظام التوافق مع المقاطع القديمة عشان متضيعش
    if (empty($audios) || !is_array($audios)) {
        $old_urls = get_post_meta($post->ID, '_nagham_audio_files', true);
        $audios = [];
        if (is_array($old_urls)) {
            foreach ($old_urls as $url) {
                $audios[] = ['title' => '', 'url' => $url];
            }
        } else {
            $very_old = get_post_meta($post->ID, '_nagham_audio_file', true);
            if ($very_old) {
                $audios[] = ['title' => '', 'url' => $very_old];
            }
        }
    }
    ?>
    <div id="nagham-audio-wrapper">
        <p style="color: #666; font-size: 13px; margin-bottom: 15px;">أضف اسم المقطع ورابطه. يمكنك كتابة الرابط يدوياً أو استخدام زر <b>"اختيار من المكتبة"</b>.</p>
        
        <div id="nagham-audio-list">
            <?php if (!empty($audios)) : foreach ($audios as $audio) : ?>
                <div class="nagham-audio-row" style="margin-bottom: 10px; padding: 15px; border: 1px solid #ddd; background: #f9f9f9; border-radius: 8px; display: flex; gap: 10px; align-items: center;">
                    <input type="text" name="nagham_audio_titles[]" value="<?php echo esc_attr($audio['title']); ?>" class="nagham-audio-title-input" placeholder="اسم المقطع (مثال: زفة الدخول)" style="flex: 1; padding: 8px;" />
                    <input type="url" name="nagham_audio_urls[]" value="<?php echo esc_url($audio['url']); ?>" class="nagham-audio-url-input" placeholder="رابط المقطع (URL)" style="flex: 2; padding: 8px; direction: ltr;" />
                    <button type="button" class="button nagham-media-upload-btn">اختيار من المكتبة</button>
                    <button type="button" class="remove-nagham-audio button button-link-delete" style="color: #d63638;">حذف</button>
                </div>
            <?php endforeach; endif; ?>
        </div>
        
        <button type="button" id="add-nagham-audio" class="button button-primary" style="margin-top: 10px;">+ إضافة مقطع صوتي جديد</button>
    </div>
    <?php
}

add_action('save_post', 'nagham_save_unified_audio');
function nagham_save_unified_audio($post_id) {
    if (!isset($_POST['nagham_audio_nonce']) || !wp_verify_nonce($_POST['nagham_audio_nonce'], 'nagham_save_audio_data')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    $titles = isset($_POST['nagham_audio_titles']) ? $_POST['nagham_audio_titles'] : [];
    $urls = isset($_POST['nagham_audio_urls']) ? $_POST['nagham_audio_urls'] : [];
    $audios = [];

    for ($i = 0; $i < count($urls); $i++) {
        if (!empty($urls[$i])) {
            $audios[] = [
                'title' => sanitize_text_field($titles[$i]),
                'url' => esc_url_raw($urls[$i])
            ];
        }
    }
    update_post_meta($post_id, '_nagham_advanced_audios', $audios);
}

// سكريبت رفع الوسائط ودمج الاسم
add_action('admin_footer', function() {
    $screen = get_current_screen();
    if (!$screen || !in_array($screen->post_type, ['product', 'nagham_track'])) return;
    wp_enqueue_media(); 
    ?>
    <script>
    jQuery(document).ready(function($) {
        $('body').on('click', '.nagham-media-upload-btn', function(e) {
            e.preventDefault();
            var btn = $(this);
            var urlField = btn.siblings('.nagham-audio-url-input');
            var titleField = btn.siblings('.nagham-audio-title-input');
            
            var frame = wp.media({ 
                title: 'اختر المقطع الصوتي', 
                button: { text: 'استخدام هذا المقطع' }, 
                multiple: false, 
                library: { type: 'audio' } 
            });
            
            frame.on('select', function() {
                var attachment = frame.state().get('selection').first().toJSON();
                urlField.val(attachment.url); 
                if(titleField.val() === '') {
                    titleField.val(attachment.title);
                }
            });
            
            frame.open();
        });

        $('#add-nagham-audio').on('click', function(e) {
            e.preventDefault();
            var newRow = `
                <div class="nagham-audio-row" style="margin-bottom: 10px; padding: 15px; border: 1px solid #ddd; background: #f9f9f9; border-radius: 8px; display: flex; gap: 10px; align-items: center;">
                    <input type="text" name="nagham_audio_titles[]" class="nagham-audio-title-input" placeholder="اسم المقطع (مثال: زفة الدخول)" style="flex: 1; padding: 8px;" />
                    <input type="url" name="nagham_audio_urls[]" class="nagham-audio-url-input" placeholder="رابط المقطع (URL)" style="flex: 2; padding: 8px; direction: ltr;" />
                    <button type="button" class="button nagham-media-upload-btn">اختيار من المكتبة</button>
                    <button type="button" class="remove-nagham-audio button button-link-delete" style="color: #d63638;">حذف</button>
                </div>
            `;
            $('#nagham-audio-list').append(newRow);
        });

        $('body').on('click', '.remove-nagham-audio', function(e) {
            e.preventDefault();
            $(this).closest('.nagham-audio-row').remove();
        });
    });
    </script>
    <?php
});


// ─── 7. TESTIMONIALS (آراء العملاء - النسخة الأصلية لاستعادة الداتا) ───
function nagham_register_testimonials_cpt() {
    register_post_type( 'testimonial', [
        'labels' => [
            'name' => 'آراء العملاء',
            'singular_name' => 'رأي عميل',
            'menu_name' => 'آراء العملاء',
            'add_new' => 'إضافة رأي جديد',
            'add_new_item' => 'إضافة رأي عميل جديد',
        ],
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_icon' => 'dashicons-testimonial',
        'supports' => [ 'title', 'editor' ],
    ]);
}
add_action( 'init', 'nagham_register_testimonials_cpt' );

add_action( 'add_meta_boxes', function() {
    add_meta_box('nagham_testimonial_details', 'تفاصيل العميل', 'nagham_testimonial_details_callback', 'testimonial', 'normal', 'high');
});

function nagham_testimonial_details_callback( $post ) {
    wp_nonce_field( 'nagham.save_testimonial_details', 'nagham_testimonial_details_nonce' );
    $role = get_post_meta( $post->ID, '_nagham_client_role', true );
    echo '<p><label>دور العميل (مثال: عروس، عريس):</label><br>';
    echo '<input type="text" name="nagham_client_role" value="'.esc_attr($role).'" class="widefat"></p>';
}

add_action( 'save_post_testimonial', function($post_id) {
    if (!isset($_POST['nagham_testimonial_details_nonce']) || !wp_verify_nonce($_POST['nagham_testimonial_details_nonce'], 'nagham.save_testimonial_details')) return;
    if (isset($_POST['nagham_client_role'])) update_post_meta($post_id, '_nagham_client_role', sanitize_text_field($_POST['nagham_client_role']));
});

// ─── 8. PARTNERS (شركاء النجاح - النسخة الأصلية لاستعادة الداتا) ─────
function nagham_register_partners_cpt() {
    register_post_type('partner', [
        'labels' => [
            'name' => 'شركاء النجاح',
            'singular_name' => 'شريك',
            'add_new' => 'إضافة شريك جديد',
            'add_new_item' => 'إضافة لوجو شريك جديد',
        ],
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_icon' => 'dashicons-groups',
        'supports' => ['title', 'thumbnail'],
        'has_archive' => true,
    ]);
}
add_action('init', 'nagham_register_partners_cpt');

add_action('add_meta_boxes', function() {
    add_meta_box('partner_link', 'رابط موقع الشريك', 'nagham_partner_link_callback', 'partner', 'side');
});

function nagham_partner_link_callback($post) {
    $value = get_post_meta($post->ID, '_partner_url', true);
    echo '<input type="url" name="partner_url" value="' . esc_attr($value) . '" style="width:100%" placeholder="https://..." />';
}

add_action('save_post_partner', function($post_id) {
    if (isset($_POST['partner_url'])) {
        update_post_meta($post_id, '_partner_url', esc_url_raw($_POST['partner_url']));
    }
});

// ─── 9. تخصيصات ووكومرس وحفظ الفاتورة ────────────────────────────
add_filter( 'woocommerce_checkout_fields' , function($fields) {
    unset($fields['billing']['billing_company'], $fields['billing']['billing_country'], $fields['billing']['billing_address_1'], $fields['billing']['billing_address_2'], $fields['billing']['billing_city'], $fields['billing']['billing_state'], $fields['billing']['billing_postcode']);
    return $fields;
});

// حقول تعديل المنتج
add_action( 'woocommerce_product_options_general_product_data', function() {
    global $post;
    echo '<div class="options_group">';
    // 💡 تم إضافة 'anniversary'=>'ذكرى الزواج' هنا عشان تظهرلك في الداشبورد
    woocommerce_wp_select(['id' => '_nagham_form_type', 'label' => 'نوع الخدمة (لتغيير الفورم)', 'options' => ['zaffa'=>'زفة','graduation'=>'تخرج','newborn'=>'مواليد','birthday'=>'ميلاد','shelat'=>'شيلات','custom'=>'طلب خاص', 'anniversary'=>'ذكرى الزواج']]);
    $audio = get_post_meta($post->ID, '_nagham_audio_file', true);
    echo '<p class="form-field"><label>صوت المعاينة</label><input type="text" name="_nagham_audio_file" value="'.esc_attr($audio).'" style="width:50%"/><button class="button nagham-media-upload-btn">رفع</button></p>';
    echo '</div>';
});

add_action( 'woocommerce_process_product_meta', function($post_id) {
    if(isset($_POST['_nagham_form_type'])) update_post_meta($post_id, '_nagham_form_type', $_POST['_nagham_form_type']);
    if(isset($_POST['_nagham_audio_file'])) update_post_meta($post_id, '_nagham_audio_file', $_POST['_nagham_audio_file']);
});

// 💡 هنا ضفتلك كلللل الحقول (القديمة والجديدة) عشان ولا معلومة تضيع من الفاتورة
$nagham_all_fields = [
    'nagham_groom_name' => 'اسم العريس', 
    'nagham_bride_name' => 'اسم العروس', 
    'nagham_grad_name' => 'اسم الخريج', 
    'nagham_grad_major' => 'التخصص',
    'nagham_newborn_name' => 'اسم المولود', 
    'nagham_parents_name' => 'اسم الأب/الأم',
    'nagham_bday_name' => 'اسم صاحب الميلاد',
    'nagham_shela_name' => 'المُهدى إليه',
    'nagham_shela_topic' => 'الموضوع',
    'nagham_custom_type' => 'نوع العمل المطلوب',
    // حقول ذكرى الزواج الجديدة:
    'nagham_husband_name' => 'اسم الزوج', 
    'nagham_wife_name' => 'اسم الزوجة', 
    'nagham_anniversary_years' => 'سنوات الزواج / التاريخ',
    // الحقول العامة:
    'nagham_event_date' => 'تاريخ التسليم المتوقع', 
    'nagham_notes' => 'الملاحظات'
];

add_filter( 'woocommerce_add_cart_item_data', function($cart_item_data, $product_id) {
    global $nagham_all_fields;
    foreach($nagham_all_fields as $key => $label) {
        if(!empty($_POST[$key])) $cart_item_data[$key] = sanitize_text_field($_POST[$key]);
    }
    if(!empty($_POST['nagham_attr'])) $cart_item_data['nagham_execution_type'] = sanitize_text_field($_POST['nagham_attr']);
    return $cart_item_data;
}, 10, 2);

add_filter( 'woocommerce_get_item_data', function($item_data, $cart_item) {
    global $nagham_all_fields;
    foreach($nagham_all_fields as $key => $label) {
        if(!empty($cart_item[$key])) $item_data[] = ['name' => $label, 'value' => $cart_item[$key]];
    }
    if(!empty($cart_item['nagham_execution_type'])) $item_data[] = ['name' => 'نوع التنفيذ', 'value' => $cart_item['nagham_execution_type']];
    return $item_data;
}, 10, 2);

add_action( 'woocommerce_checkout_create_order_line_item', function( $item, $cart_item_key, $values, $order ) {
    global $nagham_all_fields;
    foreach($nagham_all_fields as $key => $label) {
        if(!empty($values[$key])) $item->add_meta_data($label, $values[$key]);
    }
    if(!empty($values['nagham_execution_type'])) $item->add_meta_data('نوع التنفيذ', $values['nagham_execution_type']);
}, 10, 4 );

// محرك الحجز السريع
add_action('template_redirect', 'nagham_process_custom_booking_form', 1);
function nagham_process_custom_booking_form() {
    if ( isset($_POST['add-to-cart']) && isset($_POST['nagham_event_date']) ) {
        $product_id = absint($_POST['add-to-cart']);
        $variation_id = isset($_POST['variation_id']) ? absint($_POST['variation_id']) : 0;
        if ($product_id > 0) {
            if ( function_exists('wc_empty_cart') ) WC()->cart->empty_cart();
            global $nagham_all_fields;
            $cart_item_data = [];
            foreach($nagham_all_fields as $key => $label) {
                if(!empty($_POST[$key])) $cart_item_data[$key] = sanitize_textarea_field(wp_unslash($_POST[$key]));
            }
            if(!empty($_POST['nagham_attr'])) $cart_item_data['nagham_execution_type'] = sanitize_text_field(wp_unslash($_POST['nagham_attr']));
            WC()->cart->add_to_cart( $product_id, 1, $variation_id, [], $cart_item_data );
            wp_safe_redirect( wc_get_checkout_url() );
            exit;
        }
    }
}

// إضافة مربع "شريك مهم" في لوحة التحكم
add_action('add_meta_boxes', 'ngm_add_featured_partner_meta_box');
function ngm_add_featured_partner_meta_box() {
    add_meta_box('ngm_featured_partner', 'تمييز الشريك', 'ngm_featured_partner_callback', 'partner', 'side', 'high');
}

function ngm_featured_partner_callback($post) {
    wp_nonce_field('ngm_save_featured_partner', 'ngm_featured_partner_nonce');
    $is_featured = get_post_meta($post->ID, '_is_featured_partner', true);
    ?>
    <p>
        <label>
            <input type="checkbox" name="is_featured_partner" value="yes" <?php checked($is_featured, 'yes'); ?> />
            <strong>عرض كـ "شريك استراتيجي مهم" في أعلى صفحة الشركاء</strong>
        </label>
    </p>
    <?php
}

add_action('save_post', 'ngm_save_featured_partner_meta_box');
function ngm_save_featured_partner_meta_box($post_id) {
    if (!isset($_POST['ngm_featured_partner_nonce']) || !wp_verify_nonce($_POST['ngm_featured_partner_nonce'], 'ngm_save_featured_partner')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    if (isset($_POST['is_featured_partner'])) {
        update_post_meta($post_id, '_is_featured_partner', 'yes');
    } else {
        delete_post_meta($post_id, '_is_featured_partner');
    }
}





// ─── 10. Tailwind CSS ─────────────────────────────────────────
// CDN + config loaded directly in header.php (includes darkMode, animations, keyframes).
// Duplicate removed to prevent double-loading. Do not add back here.




