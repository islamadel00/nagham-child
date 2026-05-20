<?php
defined('ABSPATH') || exit;

// ─── 1. تسجيل صناديق البيانات (Meta Boxes) ──────────────────────────
add_action('add_meta_boxes', function () {
    add_meta_box(
        'nagham_track_fields',
        'بيانات المقطع الصوتي',
        'nagham_render_track_metabox',
        'nagham_track', 'normal', 'high'
    );
    add_meta_box(
        'nagham_booking_fields',
        'تفاصيل الحجز',
        'nagham_render_booking_metabox',
        'nagham_booking', 'normal', 'high'
    );
});

// ─── 2. تصميم واجهة رفع وتحرير المقطع ──────────────────────────────
function nagham_render_track_metabox($post) {
    wp_nonce_field('nagham.save_track', 'nagham_track_nonce');
    
    $file     = get_post_meta($post->ID, '_nagham_audio_file', true);
    $duration = get_post_meta($post->ID, '_nagham_duration', true);
    $featured = get_post_meta($post->ID, '_nagham_featured', true);
    $plays    = (int) get_post_meta($post->ID, '_nagham_plays', true);
    ?>
    <table class="form-table" style="direction:rtl">
        <tr>
            <th style="width:180px"><label>ملف الصوت</label></th>
            <td>
                <div style="display:flex; gap:10px; align-items:center; margin-bottom:10px;">
                    <input type="text" name="nagham_audio_file" id="nagham_audio_file_path"
                           value="<?php echo esc_attr($file); ?>" 
                           style="width:70%; background:#f9f9f9; padding:8px;" readonly placeholder="ارفع ملفاً من الزر الجانبي...">
                    
                    <button type="button" class="button nagham-media-upload-btn" style="height:35px;">
                        <span class="dashicons dashicons-cloud-upload" style="margin-top:6px; margin-left:5px;"></span>
                        ارفع المقطع
                    </button>
                </div>
                
                <input type="hidden" name="nagham_audio_attachment_id" id="nagham_audio_attachment_id" value="">
                
                <p class="description">
                    <strong>نصيحة:</strong> ارفع الملف مباشرة، وسيقوم النظام بتنظيف الاسم (للانجليزية) ونقله للمجلد المحمي تلقائياً عند الحفظ.
                </p>
            </td>
        </tr>
        <tr>
            <th><label>مدة العينة</label></th>
            <td>
                <input type="text" name="nagham_duration" value="<?php echo esc_attr($duration); ?>" placeholder="0:45" style="width:100px">
            </td>
        </tr>
        <tr>
            <th><label>مميز في الرئيسية</label></th>
            <td>
                <label>
                    <input type="checkbox" name="nagham_featured" value="1" <?php checked($featured, '1'); ?>>
                    يظهر في قسم المميزات بالصفحة الرئيسية
                </label>
            </td>
        </tr>
        <tr>
            <th><label>إحصائيات</label></th>
            <td>تم الاستماع لهذا المقطع <strong><?php echo $plays; ?></strong> مرة.</td>
        </tr>
    </table>
    <?php
}

// ─── 3. تصميم واجهة الحجوزات (كما هي) ──────────────────────────────
function nagham_render_booking_metabox($post) {
    $fields = [
        '_nagham_client_name'   => 'اسم العميل',
        '_nagham_client_phone'  => 'رقم الجوال',
        '_nagham_occasion_type' => 'نوع المناسبة',
        '_nagham_event_date'    => 'تاريخ المناسبة',
        '_nagham_event_city'    => 'المدينة',
        '_nagham_submitted_at'  => 'وقت الإرسال',
    ];
    echo '<table class="form-table" style="direction:rtl">';
    foreach ($fields as $key => $label) {
        $val = get_post_meta($post->ID, $key, true);
        echo '<tr><th style="width:160px">' . esc_html($label) . '</th>';
        echo '<td><strong>' . esc_html($val ?: '—') . '</strong></td></tr>';
    }
    $status = get_post_meta($post->ID, '_nagham_status', true) ?: 'new';
    $opts = ['new'=>'جديد','contacted'=>'تم التواصل','confirmed'=>'مؤكد','completed'=>'مكتمل','cancelled'=>'ملغي'];
    echo '<tr><th>حالة الحجز</th><td>';
    wp_nonce_field('nagham.save_booking', 'nagham_booking_nonce');
    echo '<select name="_nagham_status">';
    foreach ($opts as $val => $label) {printf('<option value="%s"%s>%s</option>',$val,selected($status,$val,false),$label);}
    echo '</select></td></tr></table>';
}

// ─── 4. حفظ البيانات (Logic) ─────────────────────────────────────
add_action('save_post_nagham_track', function ($post_id) {
    if (!isset($_POST['nagham_track_nonce']) || !wp_verify_nonce($_POST['nagham_track_nonce'], 'nagham.save_track')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    update_post_meta($post_id, '_nagham_duration', sanitize_text_field($_POST['nagham_duration'] ?? ''));
    update_post_meta($post_id, '_nagham_featured', isset($_POST['nagham_featured']) ? '1' : '');

    // لو اليوزر عدل اسم الملف يدوياً
    if (isset($_POST['nagham_audio_file'])) {
        update_post_meta($post_id, '_nagham_audio_file', sanitize_text_field($_POST['nagham_audio_file']));
    }
});

add_action('save_post_nagham_booking', function ($post_id) {
    if (!isset($_POST['nagham_booking_nonce']) || !wp_verify_nonce($_POST['nagham_booking_nonce'], 'nagham.save_booking')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (isset($_POST['_nagham_status'])) {
        update_post_meta($post_id, '_nagham_status', sanitize_text_field($_POST['_nagham_status']));
    }
});