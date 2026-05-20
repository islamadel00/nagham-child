<?php
/**
 * Nagham Audio Direct Streaming Module (Simplified & Fast)
 * تم استبدال نظام التوكن بنظام البث المباشر السريع
 */

defined('ABSPATH') || exit;

// ─── AJAX: نظام تشغيل الصوت المباشر والسريع ─────────────────────────────────
add_action('wp_ajax_nopriv_nagham_stream_direct', 'nagham_direct_stream');
add_action('wp_ajax_nagham_stream_direct', 'nagham_direct_stream');

function nagham_direct_stream() {
    $track_id = intval($_GET['id'] ?? 0);
    
    // جلب مسار الملف من الداتا بيز
    $file_path = get_post_meta($track_id, '_nagham_audio_file', true);
    
    if (!$file_path) { 
        status_header(404);
        exit('File not found'); 
    }

    // مسار الملف المحمي في هوستينجر
    $full_path = ABSPATH . 'nagham-audio/' . $file_path;
    
    // لو الملف موجود في المجلد المحمي، ذيعه فوراً
    if (file_exists($full_path)) {
        header('Content-Type: audio/mpeg');
        header('Content-Length: ' . filesize($full_path));
        header('Accept-Ranges: bytes');
        // إعطاء كاش للمتصفح عشان الأغنية تفتح في 0.1 ثانية المرة الجاية
        header('Cache-Control: public, max-age=31536000'); 
        readfile($full_path);
        exit;
    }
    
    // لو الملف مرفوع في مكتبة الوسائط العادية، اعمل تحويل مباشر للرابط
    wp_redirect($file_path);
    exit;
}

// ─── دالة وهمية (Dummy) لتجنب أي إيرور لو في ملف قديم بيسأل على التوكن ───
if (!function_exists('nagham_generate_audio_token')) {
    function nagham_generate_audio_token($track_id) {
        return 'no-token-needed';
    }
}