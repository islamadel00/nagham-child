<?php
defined('ABSPATH') || exit;
get_header();

$featured_tracks = new WP_Query([
    'post_type'      => 'nagham_track',
    'post_status'    => 'publish',
    'posts_per_page' => 4,
    'orderby'        => 'menu_order date',
    'order'          => 'ASC',
    // 💡 فلتر شامل بيصطاد المقطع بأي طريقة اتحفظ بيها في الداتا بيز
    'meta_query'     => [
        'relation' => 'OR',
        [
            'key'     => 'nagham_featured',
            'value'   => ['1', 'yes', 'on', 'true'],
            'compare' => 'IN'
        ],
        [
            'key'     => '_nagham_featured',
            'value'   => ['1', 'yes', 'on', 'true'],
            'compare' => 'IN'
        ]
    ]
]);

$occasions = get_terms([
    'taxonomy'   => 'nagham_occasion',
    'hide_empty' => false,
    'orderby'    => 'term_order',
    'order'      => 'ASC',
]);
?>

<!-- ═══ HERO ═══ -->
<section class="relative h-screen w-full flex items-center justify-center overflow-hidden bg-brand-dark">
    <video class="absolute inset-0 w-full h-full object-cover"
           autoplay muted loop playsinline preload="auto"
           poster="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/hero-bg.jpg">
        <source src="https://res.cloudinary.com/duimix9dk/video/upload/v1776165327/%D8%A7%D9%95%D9%86%D8%B4%D8%A7%D8%A1_%D9%81%D9%8A%D8%AF%D9%8A%D9%88_%D8%AC%D8%A7%D9%87%D8%B2_%D9%84%D9%84%D8%B9%D8%B1%D8%B6_gaf4up.mp4" type="video/mp4">
    </video>
    <div class="absolute inset-0 bg-gradient-to-b from-black/65 via-brand-dark/55 to-surface"></div>

    <!-- Floating player card -->
    <div class="absolute start-8 bottom-24 z-40 animate-float hidden lg:block">
        <div class="bg-white/10 backdrop-blur-xl border border-white/20 p-5 rounded-3xl flex items-center gap-5 text-white shadow-[0_20px_50px_rgba(0,0,0,0.3)] min-w-[300px] hover:scale-105 transition-transform duration-300">
            <button class="w-14 h-14 bg-primary rounded-2xl flex items-center justify-center shadow-lg hover:bg-secondary hover:text-brand-dark transition-all flex-shrink-0">
                <span class="material-symbols-outlined text-3xl">play_arrow</span>
            </button>
            <div class="flex-1 min-w-0">
                <p class="text-[11px] text-secondary font-black uppercase tracking-[0.2em] mb-1">يُشغَّل الآن</p>
                <p class="text-lg font-bold leading-tight truncate">زفة ملكية — نغم</p>
                <div class="flex gap-1 mt-2 items-end h-5">
                    <div class="w-1 bg-secondary rounded-full animate-wave-vibrant" style="animation-delay:0.1s"></div>
                    <div class="w-1 bg-secondary rounded-full animate-wave-vibrant" style="animation-delay:0.3s"></div>
                    <div class="w-1 bg-secondary rounded-full animate-wave-vibrant" style="animation-delay:0.2s"></div>
                    <div class="w-1 bg-secondary rounded-full animate-wave-vibrant" style="animation-delay:0.4s"></div>
                    <div class="w-1 bg-secondary rounded-full animate-wave-vibrant" style="animation-delay:0.15s"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="relative z-10 text-center px-4 max-w-5xl mx-auto mt-16">
        <div class="inline-flex items-center gap-2 border border-white/25 px-5 py-2 rounded-full mb-8 bg-white/10 backdrop-blur-md hover:bg-white/20 transition-colors duration-300">
            <span class="w-2 h-2 rounded-full bg-secondary animate-pulse flex-shrink-0"></span>
            <span class="text-white font-bold text-sm tracking-wide">مؤسسة نغم للإنتاج الفني</span>
        </div>

        <h1 class="text-5xl md:text-7xl lg:text-8xl font-black mb-6 leading-[1.15] tracking-tighter text-white">
            نصنع لك لوحة<br/>
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-secondary to-yellow-200 italic">فنية صوتية</span>
        </h1>

        <p class="text-base md:text-xl text-white/75 max-w-2xl mx-auto mb-10 font-medium leading-relaxed">
            نشاركك اللحظة بنغمةٍ تبقىٰ وقصةٍ تُروىٰ
        </p>

        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
            <a href="<?php echo esc_url(get_permalink(get_page_by_path('booking'))); ?>"
               class="w-full sm:w-auto bg-secondary text-brand-dark px-10 py-4 rounded-full text-lg font-black shadow-[0_10px_30px_rgba(201,168,76,0.35)] hover:bg-white hover:shadow-[0_15px_40px_rgba(201,168,76,0.5)] transition-all duration-300 hover:-translate-y-1 text-center">
                احجز مناسبتك
            </a>
            <a href="<?php echo esc_url(get_permalink(get_page_by_path('library'))); ?>"
               class="w-full sm:w-auto bg-white/10 backdrop-blur-md border border-white/30 text-white px-10 py-4 rounded-full text-lg font-bold flex items-center justify-center gap-3 hover:border-white hover:bg-white/20 transition-all duration-300 hover:-translate-y-1 group">
                <span>استمع للعينات</span>
                <span class="material-symbols-outlined w-8 h-8 rounded-full bg-white/20 flex items-center justify-center text-lg group-hover:bg-white group-hover:text-brand-dark transition-colors">play_arrow</span>
            </a>
        </div>
    </div>

    <div class="absolute bottom-6 start-1/2 -translate-x-1/2 animate-bounce-slow text-white/40 cursor-pointer hover:text-white/80 transition-colors z-20">
        <span class="material-symbols-outlined text-4xl">keyboard_arrow_down</span>
    </div>
</section>

<!-- ═══ STATS BAR ═══ -->
<section id="ngm-top-stats" class="w-full bg-surface pt-16 pb-12 border-b border-brand-dark/5">
    <div class="max-w-6xl mx-auto px-4 md:px-8">
        <div class="flex flex-row justify-between items-center divide-x-0 md:divide-x divide-brand-dark/10 rtl:divide-x-reverse">
            
            <?php
            $stats = [
                // الرقم, اللاحقة, النص
                [50000, '+', 'مناسبة منجزة'], // تم تعديلها لـ 50 ألف
                [18,    '+', 'سنوات الخبرة'], // خليناها 18 عشان تتطابق مع صفحة من نحن
                [99,    '%', 'رضا العملاء'],
                [50,    '+', 'شريك نجاح'],    // تم تعديلها لـ 50
            ];
            foreach ($stats as $stat) : ?>
            <div class="flex-1 flex flex-col items-center justify-center group cursor-default px-1 md:px-4">
                <div class="flex items-baseline gap-0.5 md:gap-1 mb-1 md:mb-2">
                    <span class="ngm-counter text-3xl md:text-6xl font-black text-brand-dark tracking-tighter transition-colors duration-500 group-hover:text-primary" data-target="<?php echo esc_attr($stat[0]); ?>">0</span>
                    <span class="text-xl md:text-4xl font-bold text-secondary"><?php echo esc_html($stat[1]); ?></span>
                </div>
                <div class="text-[9px] md:text-sm text-brand-dark/45 font-bold uppercase tracking-widest whitespace-nowrap group-hover:text-brand-dark/70 transition-colors duration-500">
                    <?php echo esc_html($stat[2]); ?>
                </div>
            </div>
            <?php endforeach; ?>

        </div>
    </div>
</section>
<!-- ═══ OCCASIONS ═══ -->
<section class="py-20 md:py-24 px-4 md:px-8 max-w-7xl mx-auto" id="service_audio">
    <div class="grid grid-cols-1 md:grid-cols-12 gap-6 auto-rows-[320px]">
        <?php
        $cards = [
            // السطر الأول (12 عمود)
            ['زفة الزواج', '/product/zaffa/',      'https://darkslategray-goshawk-323284.hostingersite.com/wp-content/uploads/2026/05/WhatsApp-Image-2026-05-06-at-17.55.27.jpeg', 'md:col-span-8', 'ليلة عمر تُزف وتُعزف فيها تفاصيل الفرح بنغمة بهجةٍ لا تُنسى'],
            ['شيلات',      '/product/shilat/',     'https://images.unsplash.com/photo-1519167758481-83f550bb49b3?auto=format&fit=crop&w=800&q=80',  'md:col-span-4', 'تراث أصيل بنبض عصري وقوة أداء.'],
            
            // السطر الثاني (12 عمود)
            ['المواليد',      '/product/newborn/',    'https://darkslategray-goshawk-323284.hostingersite.com/wp-content/uploads/2026/05/WhatsApp-Image-2026-05-06-at-18.17.19.jpeg',  'md:col-span-4', 'نعزف أول نغمة في حكاية الحياة تُعلن فرحة قدوم المولود'],
            ['التخرج',        '/product/graduation/', 'https://images.unsplash.com/photo-1523580494863-6f3031224c94?auto=format&fit=crop&w=1200&q=80', 'md:col-span-8', 'نتوّج جهد السنين بنغمة إنجاز تُعلن ختام الرحلة وتفتح أبواب فخرٍ جديد'],
            
            // السطر الثالث (12 عمود) - تم إضافة ذكرى الزواج هنا
            ['أيام ميلاد', '/product/birthday/',   'https://darkslategray-goshawk-323284.hostingersite.com/wp-content/uploads/2026/05/ChatGPT-Image-May-6-2026-06_34_02-PM.png',  'md:col-span-6', 'نغمة فرح تُضيء تفاصيل العمر وترسم البهجة ببداية عمرٍ جديد'],
            ['ذكرى الزواج', '/product/anniversary/','https://darkslategray-goshawk-323284.hostingersite.com/wp-content/uploads/2026/05/WhatsApp-Image-2026-05-06-at-18.09.31.jpeg',  'md:col-span-6', 'نجدد عهود الحب بنغمات دافئة تخلّد أجمل ذكرياتكم معاً'],
            
            // السطر الرابع (12 عمود) - الـ VIP واخد العرض كله للفخامة
            ['VIP طلب ',    '/product/custom/',     'https://nagham.sa/wp-content/uploads/2026/04/freepik_closeup-of-highend-mixing_2790951195-1.png',  'md:col-span-12', 'إنتاج فني متكامل بنغمة تُصاغ خصيصًا لتناغم رؤيتك'],
        ];
        
        foreach ($cards as $card) :
            // الرابط هنا هياخد اللي مكتوب في المصفوفة ويحوله لرابط شغال
            $link = home_url($card[1]); 
        ?>
        
        <a href="<?php echo esc_url($link); ?>"
           class="group relative <?php echo $card[3]; ?> rounded-[2.5rem] overflow-hidden bg-brand-dark block hover:-translate-y-2 transition-all duration-500 shadow-lg hover:shadow-2xl">

            <div class="absolute inset-0 bg-cover bg-center transition-transform duration-700 group-hover:scale-105"
                 style="background-image:url('<?php echo esc_url($card[2]); ?>')"></div>

            <div class="absolute inset-0 bg-gradient-to-t from-brand-dark/90 via-brand-dark/20 to-transparent"></div>

            <div class="absolute bottom-6 start-6 end-6 md:start-8 md:end-8 p-6 rounded-3xl bg-white/10 backdrop-blur-md border border-white/20 transform transition-transform duration-500 group-hover:-translate-y-2">
                <div class="flex justify-between items-end gap-4">
                    <div>
                        <h3 class="text-white text-2xl md:text-3xl font-bold mb-2"><?php echo esc_html($card[0]); ?></h3>
                        <p class="text-white/80 text-sm md:text-base line-clamp-1"><?php echo esc_html($card[4]); ?></p>
                    </div>
                    <div class="w-12 h-12 flex-shrink-0 rounded-full bg-white text-primary flex items-center justify-center transform translate-y-4 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-500">
                        <span class="material-symbols-outlined -rotate-45 font-bold">arrow_forward</span>
                    </div>
                </div>
            </div>
        </a>
        <?php endforeach; ?>
    </div>
</section>
<!-- ═══ AUDIO LIBRARY PREVIEW ═══ -->
<section class="py-20 md:py-24 bg-gradient-to-b from-surface to-white" id="ngm-library-preview">
    <div class="max-w-5xl mx-auto px-6 md:px-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-10 gap-5">
            <div>
                <h2 class="text-3xl md:text-4xl font-black text-brand-dark mb-3">استمع قبل أن تقرر</h2>
                <p class="text-brand-dark/55 text-base md:text-lg">نماذج مختارة من أعمالنا الحصرية بلمسة نغم</p>
            </div>
            <a href="<?php echo esc_url(get_permalink(get_page_by_path('library'))); ?>"
               class="flex-shrink-0 flex items-center gap-2 border-2 border-primary/25 text-primary px-6 py-2.5 rounded-full font-bold text-sm hover:bg-primary hover:text-white hover:border-primary transition-all duration-300">
                عرض المكتبة كاملة
                <span class="material-symbols-outlined text-lg">arrow_back</span>
            </a>
        </div>

        <div class="space-y-4" id="ngm-tracks-preview">
            <?php
            $i = 1;
            if ($featured_tracks->have_posts()) :
                while ($featured_tracks->have_posts()) : $featured_tracks->the_post();
                    $tid      = get_the_ID();
                    $duration = get_post_meta($tid, '_nagham_duration', true) ?: '0:45';
                    $terms    = get_the_terms($tid, 'nagham_occasion');
                    $occ      = ($terms && !is_wp_error($terms)) ? $terms[0]->name : '';
                    $thumb    = get_the_post_thumbnail_url($tid, 'thumbnail');
            ?>
            
            <div class="nagham-audio-player-container group flex items-center justify-between bg-white p-3 md:p-5 rounded-[2rem] shadow-sm border border-primary/5 hover:border-primary/30 hover:shadow-md transition-all duration-300">
                
                <div class="flex items-center gap-4 w-1/2 md:w-1/3">
                    <span class="text-primary/35 font-black text-base w-6 text-center group-hover:text-primary transition-colors hidden sm:block"><?php printf('%02d', $i); ?></span>
                    <div class="relative flex-shrink-0">
                        <?php if ($thumb) : ?>
                        <div class="w-14 h-14 md:w-16 md:h-16 rounded-2xl bg-cover bg-center shadow-sm border border-gray-50"
                             style="background-image:url('<?php echo esc_url($thumb); ?>')"></div>
                        <?php else : ?>
                        <div class="w-14 h-14 md:w-16 md:h-16 rounded-2xl bg-gradient-to-br from-primary/20 to-secondary/20 flex items-center justify-center shadow-sm border border-gray-50">
                            <span class="material-symbols-outlined text-primary/50 text-xl">music_note</span>
                        </div>
                        <?php endif; ?>
                        
                        <div class="absolute inset-0 bg-brand-dark/80 rounded-2xl flex items-center justify-center gap-[2px] opacity-0 group-[.playing]:opacity-100 transition-opacity">
                            <div class="eq-bar h-2 bg-primary"></div>
                            <div class="eq-bar h-4 bg-primary"></div>
                            <div class="eq-bar h-3 bg-primary"></div>
                        </div>
                    </div>
                    <div class="min-w-0">
                        <h4 class="font-bold text-sm md:text-base text-brand-dark group-[.playing]:text-primary transition-colors truncate"><?php the_title(); ?></h4>
                        <?php if ($occ) : ?>
                        <span class="inline-block px-2.5 py-0.5 bg-surface text-primary text-[10px] font-bold rounded border border-primary/10 mt-1"><?php echo esc_html($occ); ?></span>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="hidden md:flex flex-1 mx-6 items-center justify-center gap-3">
                    <span class="audio-time text-[10px] text-gray-400 font-mono w-8 text-right">0:00</span>
                    <div class="flex-1 h-1.5 bg-gray-100 rounded-full relative cursor-pointer progress-container overflow-hidden" dir="ltr">
                        <div class="progress-bar absolute left-0 top-0 h-full bg-primary w-0 pointer-events-none transition-all duration-100"></div>
                    </div>
                    <span class="text-[10px] text-gray-400 font-mono w-8 text-left"><?php echo esc_html($duration); ?></span>
                </div>

                <div class="flex items-center gap-1 md:gap-2 flex-shrink-0">
                   <button type="button" class="skip-backward-btn text-gray-300 hover:text-primary transition-colors">
                        <span class="material-symbols-outlined text-[20px] md:text-[22px]">replay_5</span>
                    </button>

                    <button type="button" class="play-audio-btn w-10 h-10 md:w-12 md:h-12 bg-surface rounded-full flex items-center justify-center text-primary group-[.playing]:bg-primary group-[.playing]:text-white transition-all duration-300 shadow-sm flex-shrink-0 border border-primary/10 group-[.playing]:border-transparent">
                        <span class="play-icon material-symbols-outlined text-xl md:text-2xl">play_arrow</span>
                    </button>

                        <button type="button" class="skip-forward-btn text-gray-300 hover:text-primary transition-colors">
                        <span class="material-symbols-outlined text-[20px] md:text-[22px]">forward_5</span>
                    </button>
                </div>

                <?php 
                // جلب الرابط المباشر للمقطع
                $direct_audio_url = get_post_meta($tid, '_nagham_audio_url', true);
                if (empty($direct_audio_url)) {
                    $direct_audio_url = get_post_meta($tid, '_nagham_audio_file', true); // كود احتياطي
                }
                ?>
                <audio class="nagham-product-audio" src="<?php echo esc_url($direct_audio_url); ?>" preload="none"></audio>
            </div>
            <?php 
                $i++; 
                endwhile; 
                wp_reset_postdata();
            else : 
            ?>
            <div class="text-center bg-white p-12 rounded-2xl border border-dashed border-primary/20">
                <span class="material-symbols-outlined text-4xl text-primary/30 block mb-3">music_off</span>
                <p class="text-brand-dark/40 font-bold">لا توجد مقاطع متاحة حالياً.</p>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<!-- ═══ HOW IT WORKS ═══ -->
<section class="py-20 md:py-24 bg-surface overflow-hidden"> 
    <div class="max-w-5xl mx-auto text-center">
        <div class="px-6 md:px-8 mb-12 md:mb-16">
            <div class="inline-flex items-center gap-2 border border-primary/10 px-4 py-1.5 rounded-full mb-4 bg-white shadow-sm">
                <span class="w-1.5 h-1.5 rounded-full bg-secondary"></span>
                <span class="text-primary font-bold text-xs tracking-widest uppercase">خطوات العمل</span>
            </div>
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-black text-brand-dark tracking-tight">كيف نصنع <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-secondary">تحفتك</span>؟</h2>
        </div>

        <div class="relative">
            <div class="hidden md:block absolute top-12 start-[calc(16.66%+3rem)] end-[calc(16.66%+3rem)] border-t-2 border-dashed border-primary/20 z-0"></div>

            <div class="flex md:grid md:grid-cols-3 gap-4 md:gap-10 overflow-x-auto md:overflow-visible snap-x snap-mandatory px-6 md:px-8 pb-8 md:pb-0 scroll-smooth" style="scrollbar-width: none; -ms-overflow-style: none;">
                <style>
                    .overflow-x-auto::-webkit-scrollbar { display: none; }
                </style>

                <?php
                $steps = [
                    ['1','اختر مناسبتك', 'تصفح خدماتنا واختر نوع العمل الفني الذي يناسب احتفالك',      'library_music'],
                    ['2','أرسل التفاصيل','زودنا بالأسماء والكلمات وأي تفاصيل خاصة ترغب بإضافتها',       'edit_document'],
                    ['3','استلم عملك',   'نرسل لك النسخة النهائية بجودة عالية جاهزة للعرض والاستمتاع', 'done_all'],
                ];
                foreach ($steps as $s) : ?>
                <div class="relative z-10 flex flex-col items-center group cursor-default flex-shrink-0 w-[85vw] sm:w-[300px] md:w-auto snap-center bg-white md:bg-transparent p-8 md:p-0 rounded-[2.5rem] md:rounded-none shadow-sm md:shadow-none border border-primary/5 md:border-transparent">
                    
                    <div class="w-24 h-24 bg-surface md:bg-white text-primary flex items-center justify-center rounded-[2rem] mb-6 shadow-sm border border-primary/5
                                group-hover:bg-gradient-to-br group-hover:from-brand-dark group-hover:to-primary group-hover:text-secondary
                                transition-all duration-500 md:group-hover:-translate-y-3 group-hover:shadow-[0_20px_40px_-10px_rgba(123,94,167,0.4)] relative overflow-hidden">
                        <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-10 transition-opacity duration-500"></div>
                        <span class="material-symbols-outlined text-4xl transform transition-transform duration-500 group-hover:scale-110"><?php echo esc_html($s[3]); ?></span>
                    </div>

                    <div class="text-secondary font-black text-xs md:text-sm mb-3 tracking-widest uppercase bg-secondary/10 px-4 py-1.5 rounded-full transition-colors duration-300 group-hover:bg-secondary group-hover:text-brand-dark">الخطوة <?php echo esc_html($s[0]); ?></div>
                    <h3 class="text-xl md:text-2xl font-bold mb-3 text-brand-dark group-hover:text-primary transition-colors duration-300"><?php echo esc_html($s[1]); ?></h3>
                    <p class="text-brand-dark/60 text-sm leading-relaxed max-w-[16rem] mx-auto"><?php echo esc_html($s[2]); ?></p>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
<!-- ═══ TESTIMONIALS ═══ -->
<section class="py-20 md:py-24 bg-surface overflow-hidden">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-16 px-6 md:px-8">
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-black text-brand-dark mb-4 tracking-tight">ماذا يقول عملاؤنا</h2>
            <div class="w-20 h-1 bg-gradient-to-r from-primary to-secondary mx-auto rounded-full"></div>
        </div>
        
        <div class="flex gap-6 overflow-x-auto snap-x snap-mandatory px-6 md:px-8 pb-10 scroll-smooth" style="scrollbar-width: none; -ms-overflow-style: none;">
            <style>
                .overflow-x-auto::-webkit-scrollbar { display: none; }
            </style>

            <?php
            // استدعاء كل الآراء
            $testimonials_query = new WP_Query([
                'post_type'      => 'testimonial',
                'posts_per_page' => -1, // (-1) تعني جلب كل المقالات المنشورة
                'orderby'        => 'date',
                'order'          => 'DESC',
            ]);

            if ($testimonials_query->have_posts()) :
                while ($testimonials_query->have_posts()) : $testimonials_query->the_post();
                    $client_name = get_the_title();
                    $client_review = wp_strip_all_tags(get_the_content()); 
                    $client_role = get_post_meta(get_the_ID(), '_nagham_client_role', true);
            ?>
            <div class="flex-shrink-0 w-[85vw] sm:w-[350px] md:w-[400px] snap-center bg-white p-8 rounded-[2rem] shadow-sm border border-primary/5 hover:shadow-xl hover:-translate-y-2 transition-all duration-300 relative group flex flex-col">
                <span class="absolute -top-4 -start-2 text-7xl text-primary/10 font-serif leading-none select-none group-hover:text-primary/20 transition-colors">"</span>
                
                <div class="flex gap-1 text-secondary mb-6 relative z-10 justify-end">
                    <?php for ($k = 0; $k < 5; $k++) : ?>
                    <span class="material-symbols-outlined text-lg" style="font-variation-settings:'FILL' 1">star</span>
                    <?php endfor; ?>
                </div>
                
                <p class="text-brand-dark/80 text-base leading-relaxed mb-8 relative z-10 flex-grow font-medium">"<?php echo esc_html($client_review); ?>"</p>
                
                <div class="flex items-center gap-4 mt-auto border-t border-brand-dark/5 pt-6">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-primary to-brand-dark flex items-center justify-center text-white font-bold text-lg flex-shrink-0 shadow-md">
                        <?php echo mb_substr($client_name, 0, 1); ?>
                    </div>
                    <div>
                        <div class="font-bold text-brand-dark text-base"><?php echo esc_html($client_name); ?></div>
                        <?php if ($client_role) : ?>
                        <div class="text-primary text-sm font-medium"><?php echo esc_html($client_role); ?></div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php 
                endwhile;
                wp_reset_postdata();
            else : 
            ?>
                <p class="text-center w-full text-brand-dark/50">لا توجد آراء لعرضها حالياً.</p>
            <?php endif; ?>
        </div>
    </div>
</section>
<!-- ═══ NUMBERS (with data attributes for JS counter) ═══ -->
<section id="ngm-numbers" class="relative py-24 md:py-32 overflow-hidden bg-black w-full mb-16 shadow-2xl">
    
    <div class="absolute inset-0 z-0">
        <img src="https://nagham.sa/wp-content/uploads/2026/04/pexels-tommyclineweaver-765139-scaled.jpg" 
             class="w-full h-full object-cover opacity-55 transition-all duration-1000" alt="Nagham Studio Premium">
        
        <div class="absolute inset-0 bg-gradient-to-b from-black via-black/20 to-black"></div>
    </div>

    <div class="max-w-6xl mx-auto px-6 md:px-8 relative z-10">
        <div class="text-center mb-20">
            <h2 class="text-3xl md:text-5xl font-black text-white mb-6 tracking-tighter">
                أرقام تتحدث عن <span class="text-secondary italic">الفخامة</span>
            </h2>
            <div class="w-20 h-1 bg-secondary mx-auto rounded-full shadow-[0_0_20px_rgba(201,168,76,0.5)]"></div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-12 md:gap-16">
            <?php
            $numbers = [
                ['groups',     '40', 'K',  'عميل سعيد'],
                ['star',       '4.9',  '',   'متوسط التقييم'],
                ['visibility', '94',  'M+', 'مشاهدة يوتيوب'],
                ['headphones', '100',    'M+', 'استماع إجمالي'],
            ];
            foreach ($numbers as $n) : ?>
            <div class="text-center group">
                <div class="w-16 h-16 bg-white/10 backdrop-blur-md rounded-2xl flex items-center justify-center mx-auto mb-6 border border-white/20 group-hover:border-secondary group-hover:bg-secondary/10 transition-all duration-500 shadow-2xl relative overflow-hidden">
                    <span class="material-symbols-outlined text-3xl text-secondary group-hover:scale-110 transition-transform"><?php echo esc_html($n[0]); ?></span>
                </div>
                
                <div class="text-5xl md:text-6xl font-black mb-3 text-white tracking-tighter drop-shadow-md">
                    <span class="ngm-counter" data-target="<?php echo str_replace(',', '', $n[1]); ?>" data-suffix="<?php echo esc_attr($n[2]); ?>">0</span><span class="text-secondary/90 text-3xl md:text-4xl ml-1"><?php echo esc_html($n[2]); ?></span>
                </div>
                
                <div class="text-secondary/70 font-bold text-xs md:text-sm uppercase tracking-[0.2em] group-hover:text-white transition-colors">
                    <?php echo esc_html($n[3]); ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>


<section class="py-16 md:py-20 bg-white overflow-hidden border-t border-gray-100">
    <div class="max-w-7xl mx-auto px-6 md:px-8">
        
        <div class="flex flex-col md:flex-row justify-between items-center mb-10 md:mb-14 gap-6 text-center md:text-right">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 bg-primary/5 rounded-full mb-3">
                    <span class="w-1.5 h-1.5 rounded-full bg-primary animate-pulse"></span>
                    <span class="text-primary font-bold text-[10px] tracking-[3px] uppercase">شركاء النجاح</span>
                </div>
                <h2 class="text-3xl md:text-4xl font-black text-brand-dark tracking-tight">كيانات وثقت في <span class="text-primary">نغم</span></h2>
            </div>
            
            <a href="<?php echo get_post_type_archive_link('partner'); ?>" class="flex items-center gap-2 text-sm font-bold text-brand-dark/40 hover:text-primary transition-all group">
                عرض جميع الشركاء
                <span class="material-symbols-outlined text-lg group-hover:translate-x-[-5px] transition-transform">arrow_back</span>
            </a>
        </div>

        <div class="ngm-marquee-wrapper relative w-full overflow-hidden" dir="ltr">
            <div class="absolute inset-y-0 left-0 w-12 bg-gradient-to-r from-white to-transparent z-10 pointer-events-none"></div>
            <div class="absolute inset-y-0 right-0 w-12 bg-gradient-to-l from-white to-transparent z-10 pointer-events-none"></div>

            <div class="ngm-marquee-content flex py-4">
                <?php
                $partners_query = new WP_Query([
                    'post_type'      => 'partner',
                    'posts_per_page' => -1,
                ]);

                if ($partners_query->have_posts()) :
                    // بنخزن اللوجوهات في متغير الأول
                    ob_start();
                    while ($partners_query->have_posts()) : $partners_query->the_post();
                        $logo = get_the_post_thumbnail_url(get_the_ID(), 'medium');
                        $link = get_post_meta(get_the_ID(), '_partner_url', true);
                        
                        $tag = !empty($link) ? 'a' : 'div';
                        $href = !empty($link) ? 'href="' . esc_url($link) . '" target="_blank"' : '';
                        
                        if ($logo) :
                ?>
                    <<?php echo $tag; ?> <?php echo $href; ?> 
                        class="ngm-partner-card flex items-center justify-center w-28 md:w-40 h-16 md:h-20 flex-shrink-0 cursor-pointer transition-all duration-300 hover:scale-110 hover:-translate-y-2 hover:drop-shadow-xl mx-4 md:mx-7">
                        <img src="<?php echo esc_url($logo); ?>" alt="<?php the_title(); ?>" class="max-w-full max-h-full object-contain">
                    </<?php echo $tag; ?>>
                <?php 
                        endif;
                    endwhile; 
                    wp_reset_postdata();
                    
                    $logos_html = ob_get_clean(); // سحبنا الكود
                    
                    // هنطبع الكود مرتين بالظبط جوه ديفين منفصلين عشان الـ Loop يبقى مثالي
                    echo '<div class="flex flex-shrink-0 items-center">' . $logos_html . '</div>';
                    echo '<div class="flex flex-shrink-0 items-center" aria-hidden="true">' . $logos_html . '</div>';

                else :
                    echo '<p class="text-brand-dark/30 font-bold w-full text-center" dir="rtl">في انتظار إضافة الشركاء من لوحة التحكم...</p>';
                endif; 
                ?>
            </div>
        </div>
    </div>
</section>

<style>
/* تلاشي الأطراف لإعطاء مظهر سينمائي (Fade Effect) */
.ngm-marquee-wrapper {
    mask-image: linear-gradient(to right, transparent, black 10%, black 90%, transparent);
    -webkit-mask-image: linear-gradient(to right, transparent, black 10%, black 90%, transparent);
}

/* الحاوية الرئيسية للحركة */
.ngm-marquee-content {
    width: max-content;
    display: flex;
    animation: ngm-marquee-scroll 25s linear infinite; /* سرعة الحركة */
}

/* توقف الحركة عند مرور الماوس */
.ngm-marquee-wrapper:hover .ngm-marquee-content {
    animation-play-state: paused;
}

/* الأنيميشن الدقيق للـ Loop المستمر */
@keyframes ngm-marquee-scroll {
    0% { transform: translateX(0); }
    100% { transform: translateX(-50%); } /* بيتحرك بنسبة 50% بالظبط عشان احنا طابعين الجروب مرتين */
}

/* تأكيد أبعاد اللوجوهات لمنع التشوه */
.ngm-partner-card img {
    pointer-events: none;
    user-select: none;
} 
</style>
</style>
<!-- ═══ CTA ═══ -->
<section class="relative py-16 md:py-20 bg-brand-dark overflow-hidden w-full border-t border-white/5">
    
    <div class="absolute inset-0 z-0">
        <img src="https://images.unsplash.com/photo-1511379938547-c1f69419868d?auto=format&fit=crop&w=1920&q=80" 
             class="w-full h-full object-cover opacity-20 grayscale" alt="Music background">
        <div class="absolute inset-0 bg-gradient-to-r from-brand-dark via-brand-dark/80 to-transparent"></div>
    </div>

    <div class="max-w-6xl mx-auto px-6 md:px-8 relative z-10">
        <div class="flex flex-col lg:flex-row items-center justify-between gap-10">
            
            <div class="text-center lg:text-right flex-grow">
                <h2 class="text-3xl md:text-5xl font-black text-white mb-4 tracking-tight">
                    مناسبتك تستحق <span class="text-secondary italic">إبداع نغم</span>
                </h2>
                <p class="text-white/50 text-base md:text-lg max-w-xl lg:ml-0 lg:mr-0 mx-auto">
                    نصيغ مشاعرك في قالب موسيقي خالد يرافق أجمل لحظاتك.
                </p>
            </div>

            <div class="flex flex-col sm:flex-row gap-4 flex-shrink-0">
                <a href="https://wa.me/<?php echo esc_attr(get_theme_mod('nagham_whatsapp','966550888678')); ?>"
                   target="_blank" rel="noopener noreferrer"
                   class="px-8 py-4 bg-white/5 border border-white/10 text-white rounded-xl text-sm font-bold hover:bg-white/10 transition-all flex items-center justify-center gap-2 backdrop-blur-sm">
                    <span class="material-symbols-outlined text-secondary text-xl">chat</span>
                    استشارة سريعة
                </a>

                <a href="<?php echo esc_url(get_permalink(get_page_by_path('booking'))); ?>"
                   class="group px-10 py-4 bg-secondary text-brand-dark rounded-xl text-sm font-black transition-all duration-300 hover:shadow-[0_0_30px_rgba(201,168,76,0.3)] hover:scale-105 flex items-center justify-center gap-2">
                   <span>احجز الآن</span>
                   <span class="material-symbols-outlined group-hover:translate-x-[-5px] transition-transform text-xl">arrow_back</span>
                </a>
            </div>

        </div>
    </div>
</section>
<!-- ═══ STICKY AUDIO PLAYER ═══ -->
<div id="ngm-sticky-bar"
     class="fixed bottom-0 w-full bg-brand-dark/95 backdrop-blur-xl border-t border-white/10 shadow-[0_-8px_30px_rgba(0,0,0,0.25)] z-50 py-3 md:py-4 px-4 md:px-10 flex items-center justify-between gap-4"
     style="transform:translateY(100%);transition:transform .4s cubic-bezier(0.175,.885,.32,1.275)">
    <div class="flex items-center gap-3 flex-shrink-0 min-w-0">
        <button id="ngm-bar-play" class="w-11 h-11 bg-primary text-white rounded-full flex items-center justify-center hover:bg-secondary hover:text-brand-dark transition-colors shadow-md flex-shrink-0">
            <span class="material-symbols-outlined text-xl">pause</span>
        </button>
        <div class="min-w-0">
            <div id="ngm-bar-title" class="text-sm font-bold text-white truncate max-w-[140px] md:max-w-none">جاري التشغيل...</div>
            <div class="text-[11px] text-white/45 mt-0.5">نغم للإنتاج الفني</div>
        </div>
    </div>
    <div class="hidden md:flex flex-1 mx-8 items-center gap-3">
        <span id="ngm-bar-time" class="text-xs text-white/45 font-mono w-9 text-center flex-shrink-0">0:00</span>
        <div class="relative flex-1 h-1.5 bg-white/10 rounded-full overflow-hidden cursor-pointer">
            <div id="ngm-bar-progress" class="absolute start-0 top-0 h-full w-0 bg-gradient-to-r from-primary to-secondary transition-all"></div>
        </div>
        <span id="ngm-bar-duration" class="text-xs text-white/45 font-mono w-9 text-center flex-shrink-0">—</span>
    </div>
    <button id="ngm-bar-close" class="w-9 h-9 rounded-full bg-white/5 flex items-center justify-center text-white/40 hover:text-white hover:bg-white/15 transition-colors flex-shrink-0">
        <span class="material-symbols-outlined text-lg">close</span>
    </button>
</div>

<!-- ═══ WHATSAPP FLOAT (above sticky player on mobile) ═══ -->
<div class="fixed z-50 group" style="bottom:5rem;inset-inline-start:1.5rem;">
    <div class="absolute bottom-full start-1/2 -translate-x-1/2 mb-3 px-3 py-1.5 bg-brand-dark text-white text-xs font-bold rounded-xl opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none whitespace-nowrap shadow-lg">
        تواصل معنا
        <div class="absolute top-full start-1/2 -translate-x-1/2 border-4 border-transparent border-t-brand-dark"></div>
    </div>
    <a href="https://wa.me/<?php echo esc_attr(get_theme_mod('nagham_whatsapp','966550888678')); ?>"
       target="_blank" rel="noopener noreferrer"
       class="w-14 h-14 bg-[#25D366] text-white rounded-full flex items-center justify-center shadow-[0_8px_25px_rgba(37,211,102,0.4)] hover:shadow-[0_10px_35px_rgba(37,211,102,0.6)] animate-pulse-gentle hover:scale-110 active:scale-95 transition-all">
        <svg class="w-7 h-7 fill-current" viewBox="0 0 24 24">
            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
        </svg>
    </a>
</div>

<!-- ═══ JS: Number Counter + Player Controls ═══ -->
<script>
(function(){
  /* ── Intersection Observer: count-up animation ── */
  var counters = document.querySelectorAll('.ngm-counter');
  if(counters.length && 'IntersectionObserver' in window){
    var observed = false;
    var io = new IntersectionObserver(function(entries){
      if(observed) return;
      entries.forEach(function(entry){
        if(entry.isIntersecting){
          observed = true;
          counters.forEach(function(el){
            var target  = parseFloat(el.dataset.target);
            var suffix  = el.dataset.suffix || '';
            var isFloat = target !== Math.floor(target);
            var duration = 1800;
            var start   = null;
            function step(ts){
              if(!start) start = ts;
              var progress = Math.min((ts - start) / duration, 1);
              var ease     = 1 - Math.pow(1 - progress, 3);
              var val      = target * ease;
              el.textContent = isFloat ? val.toFixed(1) : Math.floor(val).toLocaleString('en-US');
              if(progress < 1){ requestAnimationFrame(step); }
              else { el.textContent = isFloat ? target.toFixed(1) : target.toLocaleString('en-US'); }
            }
            requestAnimationFrame(step);
          });
          io.disconnect();
        }
      });
    }, { threshold: 0.3 });
    var section = document.getElementById('ngm-numbers');
    if(section) io.observe(section);
  }

  /* ── Sticky Player ── */
  var bar     = document.getElementById('ngm-sticky-bar');
  var barPlay = document.getElementById('ngm-bar-play');
  var barClose= document.getElementById('ngm-bar-close');
  var barTitle= document.getElementById('ngm-bar-title');
  var barProg = document.getElementById('ngm-bar-progress');
  var barTime = document.getElementById('ngm-bar-time');
  var barDur  = document.getElementById('ngm-bar-duration');
  var timer   = null;
  var pct     = 0;

  function showBar(title, duration){
    if(barTitle) barTitle.textContent = title;
    if(barDur)   barDur.textContent   = duration;
    if(barProg)  barProg.style.width  = '0%';
    if(barTime)  barTime.textContent  = '0:00';
    bar && (bar.style.transform = 'translateY(0)');
    clearInterval(timer);
    var parts     = duration.split(':').map(Number);
    var totalSec  = (parts[0]||0)*60 + (parts[1]||0);
    var elapsed   = 0;
    timer = setInterval(function(){
      elapsed++;
      pct = Math.min(elapsed / totalSec * 100, 100);
      if(barProg) barProg.style.width = pct + '%';
      if(barTime){
        var m = Math.floor(elapsed/60), s = String(elapsed%60).padStart(2,'0');
        barTime.textContent = m + ':' + s;
      }
      if(elapsed >= totalSec) clearInterval(timer);
    }, 1000);
  }

  barPlay && barPlay.addEventListener('click', function(){
    var icon = this.querySelector('.material-symbols-outlined');
    if(icon) icon.textContent = icon.textContent==='pause' ? 'play_arrow' : 'pause';
  });

  barClose && barClose.addEventListener('click', function(){
    bar && (bar.style.transform = 'translateY(100%)');
    clearInterval(timer);
  });

  document.querySelectorAll('.ngm-play-btn,.ngm-track-row').forEach(function(el){
    el.addEventListener('click', function(){
      var card  = this.closest('[data-track-id]');
      if(!card) return;
      var title = card.dataset.title   || 'مقطع صوتي';
      var dur   = card.dataset.duration|| '0:45';
      showBar(title, dur);
    });
  });
})();
/* ── Universal Intersection Observer: count-up animation ── */
  var counters = document.querySelectorAll('.ngm-counter');
  if(counters.length && 'IntersectionObserver' in window){
    var io = new IntersectionObserver(function(entries, observer){
      entries.forEach(function(entry){
        if(entry.isIntersecting){
          var el = entry.target;
          var target = parseFloat(el.dataset.target);
          var isFloat = target !== Math.floor(target);
          var duration = 2000; // سرعة العداد (2 ثانية)
          var start = null;
          
          function step(ts){
            if(!start) start = ts;
            var progress = Math.min((ts - start) / duration, 1);
            // حركة بطيئة في النهاية (Ease-out)
            var ease = 1 - Math.pow(1 - progress, 4); 
            var val = target * ease;
            
            el.textContent = isFloat ? val.toFixed(1) : Math.floor(val).toLocaleString('en-US');
            
            if(progress < 1){ 
                requestAnimationFrame(step); 
            } else { 
                el.textContent = isFloat ? target.toFixed(1) : target.toLocaleString('en-US'); 
            }
          }
          requestAnimationFrame(step);
          observer.unobserve(el); // وقف المراقبة بعد ما يخلص عد
        }
      });
    }, { threshold: 0.1 }); // يشتغل أول ما 10% من السكشن يظهر

    counters.forEach(function(counter){
       io.observe(counter);
    });
  }
</script>

<?php get_footer(); ?>
