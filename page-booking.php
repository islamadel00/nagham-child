<?php
/*
 * Template Name: صفحة الحجز الشاملة
 */
defined('ABSPATH') || exit;
get_header();
?>

<style>
/* إصلاح النافبار ليظهر بوضوح في هذه الصفحة الفاتحة */
#ngm-navbar, header, nav {
    background-color: #080808 !important;
    border-bottom: 1px solid rgba(255, 255, 255, 0.05) !important;
}

/* ─── Booking Catalog Styles ─── */
.booking-hero-gradient {
    background: radial-gradient(circle at top right, rgba(201,168,76,0.05) 0%, transparent 40%),
                radial-gradient(circle at bottom left, rgba(123,94,167,0.05) 0%, transparent 40%);
    background-color: #fafafa;
}

.service-card {
    background: white;
    border: 1px solid rgba(0,0,0,0.03);
    transition: all 0.5s cubic-bezier(0.165, 0.84, 0.44, 1);
}

.service-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 30px 60px rgba(0,0,0,0.08);
    border-color: rgba(201,168,76,0.2);
}

.service-image-container::after {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, rgba(0,0,0,0.5) 0%, transparent 60%);
    opacity: 0.9;
}
</style>

<section class="pt-32 pb-16 booking-hero-gradient overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 text-center relative">
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white shadow-sm border border-gray-100 mb-6">
            <span class="w-1.5 h-1.5 rounded-full bg-primary animate-pulse"></span>
            <span class="text-brand-dark font-black text-[10px] tracking-[3px] uppercase">قائمة الخدمات الفنية</span>
        </div>
        
        <h1 class="text-4xl md:text-6xl lg:text-7xl font-black text-brand-dark mb-6 tracking-tighter">اختر <span class="text-primary italic">خدمتك</span> وابدأ رحلة الإبداع</h1>
        
        <p class="text-gray-500 text-lg md:text-xl max-w-2xl mx-auto leading-relaxed">
            بصمة صوتية استثنائية وإحساس متفرد.. نصوغ لك أرقى الزفات والشيلات بأداء حصري وأحدث التقنيات، لنخلد أجمل لحظاتك بنغمة لا تُنسى.
        </p>
    </div>
</section>

<section class="pb-12 bg-[#fafafa]">
    <div class="max-w-5xl mx-auto px-6">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center divide-x divide-x-reverse divide-gray-200">
            <div class="p-4">
                <span class="material-symbols-outlined text-secondary text-3xl mb-2">workspace_premium</span>
                <h4 class="font-bold text-brand-dark text-sm">جودة ماستر</h4>
            </div>
            <div class="p-4">
                <span class="material-symbols-outlined text-secondary text-3xl mb-2">speed</span>
                <h4 class="font-bold text-brand-dark text-sm">تنفيذ سريع</h4>
            </div>
            <div class="p-4">
                <span class="material-symbols-outlined text-secondary text-3xl mb-2">support_agent</span>
                <h4 class="font-bold text-brand-dark text-sm">دعم متواصل</h4>
            </div>
            <div class="p-4">
                <span class="material-symbols-outlined text-secondary text-3xl mb-2">lock</span>
                <h4 class="font-bold text-brand-dark text-sm">دفع آمن</h4>
            </div>
        </div>
    </div>
</section>

<section class="pb-24 bg-[#fafafa]">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 md:gap-10">
            <?php
            // استعلام عن منتجات ووكومرس (WooCommerce Products)
            $services_query = new WP_Query([
                'post_type'      => 'product', 
                'posts_per_page' => -1,
                'orderby'        => 'menu_order',
                'order'          => 'ASC',
                'post_status'    => 'publish'
            ]);

            $schema_items = []; // تجميع المنتجات للـ SEO Schema
            $position = 1;

            if ($services_query->have_posts()) :
                while ($services_query->have_posts()) : $services_query->the_post();
                    global $product;
                    
                    // تحديد السعر (يدعم المنتجات المتعددة والبسيطة)
                    $price_html = '';
                    if ($product->is_type('variable')) {
                        $min_price = $product->get_variation_price('min', true);
                        $price_html = '<span class="text-[10px] text-gray-400 font-bold block leading-none mb-1">يبدأ من</span>
                                       <span class="text-xl font-black text-brand-dark">' . $min_price . ' <small class="text-xs">ر.س</small></span>';
                    } else {
                        $price = $product->get_price();
                        $price_html = '<span class="text-[10px] text-gray-400 font-bold block leading-none mb-1">السعر</span>
                                       <span class="text-xl font-black text-brand-dark">' . $price . ' <small class="text-xs">ر.س</small></span>';
                    }

                    // جلب نوع الخدمة لتصنيفه
                    $form_type = get_post_meta(get_the_ID(), '_nagham_form_type', true);
                    $type_label = $form_type ? $form_type : 'خدمة صوتية';

                    // إضافة المنتج لمصفوفة الـ SEO
                    $schema_items[] = [
                        "@type" => "ListItem",
                        "position" => $position++,
                        "url" => get_the_permalink(),
                        "name" => get_the_title()
                    ];
            ?>
            <article class="service-card rounded-[2.5rem] overflow-hidden flex flex-col h-full group">
                <div class="service-image-container relative h-72 overflow-hidden bg-gray-100">
                    <?php if (has_post_thumbnail()) : ?>
                        <?php the_post_thumbnail('large', ['class' => 'w-full h-full object-cover group-hover:scale-110 transition-transform duration-700', 'alt' => get_the_title()]); ?>
                    <?php else: ?>
                        <div class="w-full h-full flex items-center justify-center">
                            <span class="material-symbols-outlined text-gray-300 text-5xl">music_video</span>
                        </div>
                    <?php endif; ?>
                    
                    <div class="absolute bottom-6 right-6 z-10">
                        <div class="bg-white px-4 py-2 rounded-xl shadow-lg border border-gray-50 text-center">
                            <?php echo $price_html; ?>
                        </div>
                    </div>
                </div>

                <div class="p-8 flex-grow flex flex-col">
                    <div class="flex items-center gap-2 mb-4">
                        <span class="w-2 h-2 rounded-full bg-secondary"></span>
                        <span class="text-[10px] font-black uppercase tracking-widest text-gray-400"><?php echo esc_html($type_label); ?></span>
                    </div>
                    
                    <h2 class="text-2xl font-black text-brand-dark mb-4 group-hover:text-primary transition-colors">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h2>
                    
                    <p class="text-gray-500 text-sm leading-relaxed mb-8 flex-grow">
                        <?php echo wp_trim_words(get_the_excerpt() ?: get_the_content(), 20, '...'); ?>
                    </p>

                    <a href="<?php the_permalink(); ?>" title="حجز <?php the_title(); ?>" class="w-full bg-gray-50 text-brand-dark py-4 rounded-2xl font-bold text-sm flex items-center justify-center gap-2 group-hover:bg-brand-dark group-hover:text-white transition-all duration-300">
                        طلب وتفاصيل الخدمة
                        <span class="material-symbols-outlined text-lg">arrow_back</span>
                    </a>
                </div>
            </article>
            <?php endwhile; wp_reset_postdata(); else: ?>
                <div class="col-span-full text-center py-20 bg-white rounded-[3rem] border border-dashed border-gray-200">
                    <span class="material-symbols-outlined text-5xl text-gray-200 mb-4">inventory_2</span>
                    <p class="text-gray-400 font-bold text-lg">جاري تجهيز الخدمات الفنية، يرجى العودة قريباً.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php if (!empty($schema_items)) : ?>
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "ItemList",
  "itemListElement": <?php echo json_encode($schema_items, JSON_UNESCAPED_UNICODE); ?>
}
</script>
<?php endif; ?>

<section class="py-10 bg-white border-t border-gray-50">
    <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row items-center justify-center gap-8 text-center md:text-right">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-[#25D366]/10 flex items-center justify-center text-[#25D366]">
                <span class="material-symbols-outlined">support_agent</span>
            </div>
            <div>
                <h3 class="text-brand-dark font-black text-sm">تحتاج مساعدة في اختيار الخدمة المناسبة؟</h3>
                <p class="text-gray-400 text-xs">فريق نغم جاهز للرد على استفساراتكم فوراً</p>
            </div>
        </div>
        <a href="https://wa.me/966550888678" target="_blank" rel="noopener noreferrer" class="px-8 py-3 bg-[#25D366] text-white rounded-xl text-xs font-black hover:bg-[#1da851] transition-all shadow-lg shadow-[#25D366]/20 flex items-center gap-2 hover:-translate-y-1">
            تواصل معنا واتساب
        </a>
    </div>
</section>

<section class="py-12 bg-[#fafafa] border-t border-gray-100">
    <div class="max-w-4xl mx-auto px-6 text-center">
        <h4 class="text-brand-dark font-black text-xs mb-8 uppercase tracking-[0.2em]">تابع أعمالنا وحصرياتنا على</h4>
        
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="https://www.tiktok.com/@nagham.sa1" target="_blank" class="flex items-center gap-3 w-full sm:w-auto px-6 py-4 bg-white border border-gray-200 rounded-2xl hover:border-black hover:shadow-lg hover:-translate-y-1 transition-all group">
                <div class="w-8 h-8 rounded-full bg-gray-50 flex items-center justify-center group-hover:bg-black group-hover:text-white transition-colors">
                    <span class="material-symbols-outlined text-sm">share</span>
                </div>
                <div class="text-left" dir="ltr">
                    <div class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">TikTok</div>
                    <div class="text-sm font-black text-brand-dark">nagham.sa1</div>
                </div>
            </a>

            <a href="https://www.instagram.com/nagham_co" target="_blank" class="flex items-center gap-3 w-full sm:w-auto px-6 py-4 bg-white border border-gray-200 rounded-2xl hover:border-[#E1306C] hover:shadow-lg hover:-translate-y-1 transition-all group">
                <div class="w-8 h-8 rounded-full bg-gray-50 flex items-center justify-center group-hover:bg-[#E1306C] group-hover:text-white transition-colors">
                    <span class="material-symbols-outlined text-sm">photo_camera</span>
                </div>
                <div class="text-left" dir="ltr">
                    <div class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Instagram</div>
                    <div class="text-sm font-black text-brand-dark">nagham_co</div>
                </div>
            </a>

            <a href="https://twitter.com/nagham_Co" target="_blank" class="flex items-center gap-3 w-full sm:w-auto px-6 py-4 bg-white border border-gray-200 rounded-2xl hover:border-brand-dark hover:shadow-lg hover:-translate-y-1 transition-all group">
                <div class="w-8 h-8 rounded-full bg-gray-50 flex items-center justify-center group-hover:bg-brand-dark group-hover:text-white transition-colors">
                    <span class="material-symbols-outlined text-sm">alternate_email</span>
                </div>
                <div class="text-left" dir="ltr">
                    <div class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">X Network</div>
                    <div class="text-sm font-black text-brand-dark">@nagham_Co</div>
                </div>
            </a>
        </div>
    </div>
</section>

<?php get_footer(); ?>