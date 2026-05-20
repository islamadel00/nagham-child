<?php
/**
 * Custom WooCommerce Single Product Template (Mobile Optimized & Dynamic Pricing)
 */
defined('ABSPATH') || exit;
get_header();

global $product;
if ( ! is_a( $product, 'WC_Product' ) ) {
    $product = wc_get_product( get_the_ID() );
}

// 💡 جلب المقاطع الصوتية بالنظام الجديد المتقدم
$audios = get_post_meta($product->get_id(), '_nagham_advanced_audios', true);

// 💡 نظام احتياطي للمنتجات القديمة
if (empty($audios) || !is_array($audios)) {
    $old_urls = get_post_meta($product->get_id(), '_nagham_audio_files', true);
    $audios = [];
    if (is_array($old_urls)) {
        foreach ($old_urls as $url) {
            $audios[] = ['title' => '', 'url' => $url];
        }
    } else {
        $very_old = get_post_meta($product->get_id(), '_nagham_audio_file', true);
        if ($very_old) {
            $audios[] = ['title' => '', 'url' => $very_old];
        }
    }
}
?>

<style>
body { background-color: #fafafa; }
.woocommerce-notices-wrapper { display: none; }

.nagham-custom-input { width: 100%; background-color: #f9fafb; border: 1px solid #f3f4f6; border-radius: 10px; padding: 10px 14px; font-size: 13px; color: #111; transition: all 0.3s ease; }
.nagham-custom-input:focus { background-color: #fff; border-color: #C9A84C; outline: none; box-shadow: 0 0 0 3px rgba(201,168,76,0.1); }
.nagham-form-label { display: flex; align-items: center; gap: 4px; font-size: 11px; font-weight: 800; color: #4b5563; margin-bottom: 4px; }
.nagham-submit-btn { width: 100%; background-color: #050505; color: #fff; border-radius: 12px; padding: 12px; font-weight: 900; font-size: 15px; display: flex; justify-content: center; align-items: center; gap: 8px; transition: all 0.3s; border: none; cursor: pointer; }
.nagham-submit-btn:hover { background-color: #7b5ea7; transform: translateY(-2px); box-shadow: 0 8px 15px rgba(123,94,167,0.2); }
</style>

<section class="relative w-full h-[40vh] lg:h-[55vh] min-h-[300px] flex items-center justify-center overflow-hidden bg-brand-dark pt-16">
    <video class="absolute inset-0 w-full h-full object-cover opacity-40" autoplay muted loop playsinline preload="auto">
        <source src="https://res.cloudinary.com/duimix9dk/video/upload/v1776699019/8513955-uhd_3840_2160_25fps_1_bktwjm.mp4" type="video/mp4">
    </video>
    <div class="absolute inset-0 bg-gradient-to-b from-transparent via-brand-dark/20 to-[#fafafa]"></div>
    <div class="relative z-10 text-center px-4 max-w-4xl mx-auto mt-8">
        <span class="text-secondary font-bold text-[9px] md:text-[10px] tracking-[3px] uppercase mb-2 block">Nagham Collection</span>
        <h1 class="text-3xl md:text-5xl lg:text-6xl font-black text-white mb-3 drop-shadow-lg">
            <?php echo get_the_title(); ?>
        </h1>
        <p class="text-white/80 text-xs md:text-base font-medium max-w-xl mx-auto px-4 line-clamp-2 md:line-clamp-none">
            <?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?>
        </p>
    </div>
</section>

<section class="pb-24 pt-6 md:pt-8 relative z-20">
    <div class="max-w-6xl mx-auto px-4 md:px-6">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <div class="lg:col-span-7 space-y-6 order-1">
                
                <div class="relative rounded-[1.5rem] md:rounded-[2rem] overflow-hidden shadow-xl aspect-video bg-gray-100 group">
                    <?php if (has_post_thumbnail()) : ?>
                        <?php the_post_thumbnail('full', ['class' => 'w-full h-full object-cover']); ?>
                    <?php else: ?>
                        <img src="https://images.unsplash.com/photo-1519225421980-715cb0215aed?auto=format&fit=crop&w=800&q=80" class="w-full h-full object-cover">
                    <?php endif; ?>
                </div>

                <?php if (!empty($audios)) : ?>
                    <div class="space-y-3 mt-4">
                        <?php foreach ($audios as $index => $audio) : 
                            $audio_url = $audio['url'];
                            if(empty($audio_url)) continue; 
                            
                            $song_title = $audio['title'];
                            
                            if (empty($song_title)) {
                                $file_name = basename(parse_url($audio_url, PHP_URL_PATH));
                                $clean_name = urldecode(str_replace(['.mp3', '.m4a', '-', '_'], ['', '', ' ', ' '], $file_name));
                                $song_title = $clean_name ?: 'عينة صوتية ' . ($index + 1);
                            }
                        ?>
                            <div class="nagham-audio-player-container group relative overflow-hidden bg-white rounded-2xl p-3 md:p-4 border border-gray-100 shadow-sm hover:shadow-md hover:border-primary/30 transition-all duration-300 flex items-center gap-2 md:gap-3">
                                
                                <button type="button" class="skip-backward-btn flex-shrink-0 text-gray-300 hover:text-primary transition-colors">
                                    <span class="material-symbols-outlined text-[20px]">replay_5</span>
                                </button>

                                <button type="button" class="play-audio-btn relative z-10 w-10 h-10 md:w-12 md:h-12 bg-surface text-brand-dark rounded-full flex items-center justify-center shadow-sm border border-gray-100 group-hover:bg-primary group-hover:text-white transition-all duration-300 flex-shrink-0">
                                    <span class="play-icon material-symbols-outlined text-xl md:text-2xl ml-0.5">play_arrow</span>
                                </button>

                                <button type="button" class="skip-forward-btn flex-shrink-0 text-gray-300 hover:text-primary transition-colors">
                                    <span class="material-symbols-outlined text-[20px]">forward_5</span>
                                </button>

                                <div class="flex-1 flex flex-col justify-center relative z-10 overflow-hidden px-2">
                                    <h4 class="text-xs md:text-sm font-bold text-brand-dark mb-1.5 truncate" title="<?php echo esc_attr($song_title); ?>"><?php echo esc_html($song_title); ?></h4>
                                    <div class="flex items-center gap-3">
                                        <div class="flex items-end gap-[3px] h-4 opacity-40 group-[.playing]:opacity-100 transition-opacity duration-300">
                                            <div class="eq-bar h-1"></div>
                                            <div class="eq-bar h-2"></div>
                                            <div class="eq-bar h-1"></div>
                                            <div class="eq-bar h-3"></div>
                                            <div class="eq-bar h-1"></div>
                                        </div>
                                        <div class="flex-1 h-[4px] bg-gray-100 rounded-full relative cursor-pointer progress-container overflow-hidden">
                                            <div class="progress-bar absolute left-0 top-0 h-full bg-primary rounded-full w-0 pointer-events-none transition-all duration-100"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="audio-time relative z-10 text-[10px] text-gray-400 font-mono font-bold w-8 text-left flex-shrink-0">
                                    0:00
                                </div>

                                <audio class="nagham-product-audio" src="<?php echo esc_url($audio_url); ?>" preload="none"></audio>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <div class="grid grid-cols-3 gap-2 md:gap-4 text-center px-2 pt-4">
                    <div>
                        <div class="text-base md:text-lg font-black text-brand-dark flex items-center justify-center gap-1">4.9 <span class="material-symbols-outlined text-secondary text-sm">star</span></div>
                        <div class="text-[8px] md:text-[9px] text-gray-400 font-bold uppercase mt-1">تقييم العملاء</div>
                    </div>
                    <div class="border-x border-gray-100">
                        <div class="text-base md:text-lg font-black text-brand-dark">+100K</div>
                        <div class="text-[8px] md:text-[9px] text-gray-400 font-bold uppercase mt-1">عميل سعيد</div>
                    </div>
                    <div>
                        <div class="text-base md:text-lg font-black text-brand-dark flex items-center justify-center gap-1">+1M <span class="material-symbols-outlined text-brand-dark text-sm opacity-50">visibility</span></div>
                        <div class="text-[8px] md:text-[9px] text-gray-400 font-bold uppercase mt-1">مشاهدة</div>
                    </div>
                </div>

                <div class="prose prose-sm md:prose-base text-gray-500 max-w-none bg-white p-5 md:p-6 rounded-[1.5rem] border border-gray-50 shadow-sm mt-6">
                    <?php the_content(); ?>
                </div>

            </div>

            <div class="lg:col-span-5 sticky top-28 order-2 mb-8 lg:mb-0">
                <div class="bg-white rounded-[1.5rem] p-5 md:p-6 shadow-[0_10px_40px_rgba(0,0,0,0.06)] border border-gray-100">
                    
                    <div class="text-center mb-5">
                        <h2 class="text-lg font-black text-brand-dark mb-1">طلب تنفيذ الخدمة</h2>
                        <p class="text-gray-400 text-[10px]">يرجى تعبئة البيانات بدقة</p>
                    </div>

                    <form class="cart" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data'>
                        
                        <?php 
                        $form_type = get_post_meta($product->get_id(), '_nagham_form_type', true);
                        if (empty($form_type)) $form_type = 'zaffa'; 
                        ?>

                        <div class="space-y-3 mb-5">
                            <?php if ($form_type === 'zaffa') : ?>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                    <div><label class="nagham-form-label"><span class="text-secondary">•</span> اسم العريس</label><input type="text" name="nagham_groom_name" class="nagham-custom-input" required></div>
                                    <div><label class="nagham-form-label"><span class="text-secondary">♡</span> اسم العروس</label><input type="text" name="nagham_bride_name" class="nagham-custom-input" required></div>
                                </div>
                                
                            <?php elseif ($form_type === 'anniversary') : ?>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-3">
                                    <div><label class="nagham-form-label"><span class="text-secondary">💍</span> اسم الزوج</label><input type="text" name="nagham_husband_name" class="nagham-custom-input" required></div>
                                    <div><label class="nagham-form-label"><span class="text-secondary">💖</span> اسم الزوجة</label><input type="text" name="nagham_wife_name" class="nagham-custom-input" required></div>
                                </div>
                                <div><label class="nagham-form-label"><span class="text-secondary">⏳</span> عدد سنوات الزواج (أو التاريخ)</label><input type="text" name="nagham_anniversary_years" class="nagham-custom-input" placeholder="مثال: الذكرى الخامسة" required></div>
                                
                            <?php elseif ($form_type === 'graduation') : ?>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                    <div><label class="nagham-form-label"><span class="text-secondary">🎓</span> اسم الخريج</label><input type="text" name="nagham_grad_name" class="nagham-custom-input" required></div>
                                    <div><label class="nagham-form-label"><span class="text-secondary">📚</span> التخصص</label><input type="text" name="nagham_grad_major" class="nagham-custom-input" placeholder="اختياري"></div>
                                </div>
                                
                            <?php elseif ($form_type === 'newborn') : ?>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                    <div><label class="nagham-form-label"><span class="text-secondary">👶</span> اسم المولود</label><input type="text" name="nagham_newborn_name" class="nagham-custom-input" required></div>
                                    <div><label class="nagham-form-label"><span class="text-secondary">👨‍👩‍👦</span> الأب/الأم</label><input type="text" name="nagham_parents_name" class="nagham-custom-input" required></div>
                                </div>
                                
                            <?php elseif ($form_type === 'birthday') : ?>
                                <div><label class="nagham-form-label"><span class="text-secondary">🎂</span> اسم صاحب الميلاد</label><input type="text" name="nagham_bday_name" class="nagham-custom-input" required></div>
                                
                            <?php elseif ($form_type === 'shelat') : ?>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                    <div><label class="nagham-form-label"><span class="text-secondary">🎤</span> المُهدى إليه</label><input type="text" name="nagham_shela_name" class="nagham-custom-input" required></div>
                                    <div><label class="nagham-form-label"><span class="text-secondary">📝</span> الموضوع</label><input type="text" name="nagham_shela_topic" class="nagham-custom-input" required></div>
                                </div>
                                
                            <?php elseif ($form_type === 'custom') : ?>
                                <div><label class="nagham-form-label"><span class="text-secondary">✨</span> نوع العمل المطلوب</label><input type="text" name="nagham_custom_type" class="nagham-custom-input" required></div>
                            <?php endif; ?>

                            <div>
                                <label class="nagham-form-label"><span class="material-symbols-outlined text-[12px] text-secondary">calendar_month</span> تاريخ التسليم المتوقع</label>
                                <input type="date" name="nagham_event_date" class="nagham-custom-input" required>
                            </div>

                            <div>
                                <label class="nagham-form-label"><span class="material-symbols-outlined text-[12px] text-secondary">edit_note</span> ملاحظات (اختياري)</label>
                                <textarea name="nagham_notes" class="nagham-custom-input" rows="2" placeholder="أضف تفاصيلك..."></textarea>
                            </div>
                        </div>

                        <div class="border-t border-gray-100 pt-5">
                            
                            <?php 
                            if ( $product->is_type( 'variable' ) ) : 
                                $variations = $product->get_available_variations(); 
                                if(!empty($variations)):
                            ?>
                                <div class="mb-5 p-4 bg-surface rounded-2xl border border-primary/10">
                                    <label class="block text-brand-dark font-black mb-3 text-xs">نوع التنفيذ:</label>
                                    <div class="grid grid-cols-2 gap-3">
                                        <?php foreach ( $variations as $index => $var ) : 
                                            $attr_val = current($var['attributes']); 
                                            $attr_key = key($var['attributes']); 
                                            
                                            $tooltip_text = 'تفاصيل التنفيذ';
                                            if (strpos($attr_val, 'جاهزة') !== false) {
                                                $tooltip_text = 'يتم تعديل أسماء العرسان فقط على لحن وزفة مسجلة مسبقاً.';
                                            } elseif (strpos($attr_val, 'جديد') !== false) {
                                                $tooltip_text = 'تلحين، وتوزيع، وتسجيل حصري من الصفر بكلمات وألحان خاصة لكم.';
                                            }
                                        ?>
                                            <label class="relative cursor-pointer group" onclick="document.getElementById('nagham_var_id').value='<?php echo $var['variation_id']; ?>'; document.getElementById('nagham_attr').name='<?php echo esc_attr($attr_key); ?>'; document.getElementById('nagham_attr').value='<?php echo esc_attr($attr_val); ?>';">
                                                <input type="radio" name="nagham_ui_selector" class="peer sr-only" <?php echo $index === 0 ? 'checked' : ''; ?>>
                                                <div class="p-3 rounded-xl border-2 border-transparent bg-white shadow-sm peer-checked:border-primary peer-checked:bg-primary/5 transition-all text-center flex flex-col justify-center items-center h-full relative">
                                                    
                                                    <div class="absolute top-2 left-2 group/tooltip">
                                                        <span class="material-symbols-outlined text-[15px] text-gray-300 hover:text-secondary cursor-help transition-colors">info</span>
                                                        <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-36 p-2.5 bg-gray-900 text-white text-[10px] leading-relaxed rounded-lg opacity-0 invisible group-hover/tooltip:opacity-100 group-hover/tooltip:visible transition-all duration-300 z-20 pointer-events-none shadow-xl">
                                                            <?php echo $tooltip_text; ?>
                                                            <div class="absolute top-full left-1/2 -translate-x-1/2 border-4 border-transparent border-t-gray-900"></div>
                                                        </div>
                                                    </div>

                                                    <span class="font-bold text-brand-dark block text-[11px] md:text-xs"><?php echo esc_html($attr_val); ?></span>
                                                    <span class="text-primary font-black text-xs md:text-sm mt-1"><?php echo wp_kses_post($var['price_html']); ?></span>
                                                </div>
                                            </label>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                                
                                <input type="hidden" name="add-to-cart" value="<?php echo absint($product->get_id()); ?>" />
                                <input type="hidden" name="product_id" value="<?php echo absint($product->get_id()); ?>" />
                                <input type="hidden" name="variation_id" id="nagham_var_id" value="<?php echo $variations[0]['variation_id']; ?>" />
                                <input type="hidden" name="<?php echo esc_attr(key($variations[0]['attributes'])); ?>" id="nagham_attr" value="<?php echo esc_attr(current($variations[0]['attributes'])); ?>" />
                                
                            <?php 
                                endif;
                            else : 
                            ?>
                                <div class="mb-5 flex justify-between items-end bg-surface p-4 rounded-2xl border border-primary/10">
                                    <span class="text-brand-dark font-black text-sm">سعر الخدمة:</span>
                                    <span class="text-primary font-black text-lg"><?php echo $product->get_price_html(); ?></span>
                                </div>
                                <input type="hidden" name="add-to-cart" value="<?php echo absint($product->get_id()); ?>" />
                            <?php endif; ?>

                            <button type="submit" class="nagham-submit-btn">
                                تأكيد الحجز
                                <span class="material-symbols-outlined text-lg">arrow_back</span>
                            </button>
                        </div>
                    </form>
                    
                </div>
            </div>

        </div>
    </div>
</section>

<?php get_footer(); ?>