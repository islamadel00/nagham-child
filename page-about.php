<?php
/* Template Name: من نحن */
defined('ABSPATH') || exit;
get_header();
?>

<style>
/* ─── تخصيصات صفحة من نحن ─── */
.glass-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(201, 168, 76, 0.2);
    box-shadow: 0 20px 40px rgba(0,0,0,0.04);
}
.timeline-dot {
    position: absolute;
    right: -18px; /* for RTL */
    top: 0;
    width: 14px;
    height: 14px;
    border-radius: 50%;
    background-color: #C9A84C;
    border: 3px solid #FAF8F5;
    box-shadow: 0 0 0 4px rgba(201, 168, 76, 0.2);
}
.timeline-line {
    position: absolute;
    right: -13px; /* for RTL */
    top: 14px;
    bottom: -50px;
    width: 2px;
    background: linear-gradient(to bottom, #C9A84C, rgba(201,168,76,0.1));
}
.gallery-img-wrapper {
    overflow: hidden;
    border-radius: 1.5rem;
    position: relative;
    aspect-ratio: 4/3;
    background-color: #fcfcfc; 
    border: 1px solid #f1f1f1;
}
.gallery-img-wrapper img {
    width: 100%;
    height: 100%;
    object-fit: contain; 
    padding: 5px;
    transition: transform 0.7s ease, filter 0.5s ease;
    filter: grayscale(40%);
}
.gallery-img-wrapper:hover img {
    transform: scale(1.05); 
    filter: grayscale(0%);
}
</style>

<section class="relative min-h-[60vh] flex items-center justify-center overflow-hidden text-center pt-28 pb-16 bg-brand-dark w-full">
    <video class="absolute inset-0 w-full h-full object-cover opacity-75" autoplay muted loop playsinline preload="auto">
        <source src="https://darkslategray-goshawk-323284.hostingersite.com/wp-content/uploads/2026/05/WhatsApp-Video-2026-05-03-at-23.08.22.mp4" type="video/mp4">
    </video>
    
    <div class="absolute inset-0 bg-gradient-to-t from-surface via-brand-dark/40 to-transparent"></div>
    
    <div class="max-w-4xl mx-auto px-6 relative z-10 mt-10">
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-brand-dark/40 border border-white/20 mb-6 backdrop-blur-md shadow-lg">
            <span class="w-1.5 h-1.5 rounded-full bg-secondary animate-pulse"></span>
            <span class="text-secondary font-bold text-[10px] tracking-[3px] uppercase">من نحن</span>
        </div>
        
        <h1 class="text-4xl md:text-6xl lg:text-7xl font-black text-white mb-6 tracking-tighter drop-shadow-lg">نحن الحكاية <span class="text-transparent bg-clip-text bg-gradient-to-r from-secondary to-yellow-200 italic">وأنت النغم</span></h1>
        
        <p class="text-white/90 text-lg md:text-xl leading-relaxed mb-10 max-w-2xl mx-auto drop-shadow-lg font-medium">
            في نغم لا نلتقط اللحظة، بل نعيد صياغتها كأثر فني يبقى حين تصمت الحكايات.
        </p>
    </div>
</section>

<section class="py-16 md:py-20 bg-surface relative z-20">
    <div class="max-w-6xl mx-auto px-6">
        
        <div class="flex justify-center mb-12 -mt-24 relative z-30">
            <?php
            if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) {
                $custom_logo_id = get_theme_mod( 'custom_logo' );
                $logo_url = wp_get_attachment_image_url( $custom_logo_id , 'full' );
                echo '<div class="bg-surface p-4 rounded-[2rem] shadow-xl border border-gray-100">';
                echo '<img src="' . esc_url( $logo_url ) . '" alt="نغم" class="h-20 md:h-24 w-auto object-contain">';
                echo '</div>';
            }
            ?>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-10 lg:gap-16">
            
            <div class="bg-white p-10 rounded-[2.5rem] shadow-sm border border-gray-100 hover:-translate-y-2 transition-transform duration-500 relative overflow-hidden group">
                <div class="absolute -left-6 -top-6 w-32 h-32 bg-primary/5 rounded-full blur-2xl group-hover:bg-primary/10 transition-colors"></div>
                <span class="material-symbols-outlined text-5xl text-primary mb-6 relative z-10">auto_awesome</span>
                <h3 class="text-2xl font-black text-brand-dark mb-4 relative z-10">نجسد صوت اللحظة</h3>
                <p class="text-gray-500 leading-loose relative z-10 font-medium">
                    نجعلكم تعيشون الفرح مرتين؛ مرة في واقعه ومرة في نغمه. نحن رفاق دربكم، نحول مناسباتكم إلى أعمال فنية نابضة تُبنى بإحساس وتُصاغ بدقة.
                </p>
            </div>

            <div class="bg-white p-10 rounded-[2.5rem] shadow-sm border border-gray-100 hover:-translate-y-2 transition-transform duration-500 relative overflow-hidden group">
                <div class="absolute -left-6 -top-6 w-32 h-32 bg-secondary/5 rounded-full blur-2xl group-hover:bg-secondary/10 transition-colors"></div>
                <span class="material-symbols-outlined text-5xl text-secondary mb-6 relative z-10">music_cast</span>
                <h3 class="text-2xl font-black text-brand-dark mb-4 relative z-10">سر النوتة التي نكتبها لكم</h3>
                <p class="text-gray-500 leading-loose relative z-10 font-medium">
                    نعزف حكاياتكم أياً كانت، فقصتكم هي ملهمنا الأول، نلبي طلباتكم الخاصة ونحولها لأعمال فنية تليق بمحطاتكم الكبرى من تخرج وزواج ومواليد.
                </p>
            </div>

        </div>

        <div class="mt-20">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-black text-brand-dark mb-3">رؤيتنا ورسالتنا</h2>
                <p class="text-secondary font-bold tracking-widest">نغم.. تجربة تُترجم مشاعركم إلى صوت</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-4xl mx-auto">
                <div class="glass-card p-8 rounded-[2rem] text-center">
                    <div class="w-16 h-16 mx-auto bg-primary/10 text-primary rounded-full flex items-center justify-center mb-4"><span class="material-symbols-outlined text-3xl">visibility</span></div>
                    <h4 class="text-xl font-black text-brand-dark mb-3">رؤيتنا</h4>
                    <p class="text-gray-600 text-sm leading-relaxed">أن نكون الخيار الأول والأفضل للإبداع الفني في المملكة والخليج.</p>
                </div>
                
                <div class="glass-card p-8 rounded-[2rem] text-center">
                    <div class="w-16 h-16 mx-auto bg-secondary/10 text-secondary rounded-full flex items-center justify-center mb-4"><span class="material-symbols-outlined text-3xl">flag</span></div>
                    <h4 class="text-xl font-black text-brand-dark mb-3">رسالتنا</h4>
                    <p class="text-gray-600 text-sm leading-relaxed">تقديم حلول فنية متكاملة تتجاوز التوقعات وتليق بالمناسبات والإنجازات الاستثنائية.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-24 bg-white border-t border-gray-100" id="artist-identity">
    <div class="max-w-6xl mx-auto px-6">
        
        <div class="flex flex-col md:flex-row items-center gap-10 lg:gap-16 mb-16">
            <div class="w-full md:w-1/3">
                <div class="relative rounded-[2.5rem] overflow-hidden aspect-[4/5] shadow-2xl group border border-gray-100">
                    <img src="https://nagham.sa/wp-content/uploads/2026/05/WhatsApp-Image-2026-05-01-at-14.28.31.jpeg" alt="معاذ الجماز" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-brand-dark via-brand-dark/20 to-transparent"></div>
                    <div class="absolute bottom-6 w-full text-center">
                        <h2 class="text-3xl font-black text-white">معاذ الجماز</h2>
                        <p class="text-secondary font-bold text-sm tracking-widest mt-1 uppercase">الفنان المؤسس</p>
                    </div>
                </div>
            </div>
            
            <div class="w-full md:w-2/3">
                <div class="inline-flex items-center gap-2 px-3 py-1 bg-brand-dark/5 rounded-full mb-4">
                    <span class="text-brand-dark font-bold text-[10px] tracking-[2px] uppercase">مسيرة فنية</span>
                </div>
                <h3 class="text-3xl md:text-4xl font-black text-brand-dark mb-6 leading-tight">18 عاماً من الفن الأصيل<br/><span class="text-primary italic">والإحساس الجميل</span></h3>
                <p class="text-gray-600 text-lg leading-relaxed mb-6">
                    فنان سعودي رائد بدأ مسيرته الفنية عام 2008 وبرز بحضور مسرحي لافت وإحساس عالي. 
                    بمزيج فريد بين الهيبة المسرحية ودفء الإحساس، استطاع معاذ الجماز أن يكون خياراً استثنائياً لإحياء كبرى المناسبات، محولاً المحافل العادية إلى لحظات استثنائية تُنحت في الذاكرة.
                </p>
                
                <div class="grid grid-cols-2 gap-4 mt-8">
                    <div class="bg-surface p-4 rounded-2xl border border-gray-100">
                        <span class="block text-2xl font-black text-brand-dark mb-1">+1200</span>
                        <span class="text-xs text-gray-500 font-bold uppercase tracking-wide">ساعة ظهور تلفزيوني</span>
                    </div>
                    <div class="bg-surface p-4 rounded-2xl border border-gray-100">
                        <span class="block text-2xl font-black text-brand-dark mb-1">+50K</span>
                        <span class="text-xs text-gray-500 font-bold uppercase tracking-wide">عريس وعروس</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="block md:hidden w-full mb-20">
            <div class="relative rounded-[2.5rem] overflow-hidden shadow-xl border border-gray-100">
                <img src="https://darkslategray-goshawk-323284.hostingersite.com/wp-content/uploads/2026/05/WhatsApp-Image-2026-05-10-at-15.02.29.jpeg" 
                     alt="معاذ الجماز - أرشيف" 
                     class="w-full h-auto object-cover">
            </div>
        </div>
        <div class="relative border-r-[3px] border-r-gray-100 pr-8 md:pr-12 space-y-24">
            
            <div class="relative">
                <div class="timeline-dot"></div>
                <div class="timeline-line"></div>
                
                <div class="mb-6">
                    <span class="text-secondary font-black tracking-widest text-sm mb-2 block">2008 - 2015</span>
                    <h3 class="text-2xl md:text-3xl font-black text-brand-dark mb-2">مرحلة الانطلاقة</h3>
                    <p class="text-primary font-bold mb-4">ترسيخ الموهبة والسيادة على المنصات التنافسية.</p>
                </div>
                
                <p class="text-gray-600 mb-10 text-base md:text-lg leading-loose font-medium">
                    شهدت هذه المرحلة تحقيق نجاحات مبكرة بحصوله على المركز الأول لثلاثة مواسم متتالية في مسابقة منشد جامعة تبوك، والفوز بالمركز الأول في مسابقة "نجم الصوت الإنشادي" بجمعية الثقافة والفنون بتبوك كما تميز بالمشاركة في المحافل الرسمية والمؤتمرات الكبرى بحضور أصحاب السمو والمعالي، وبرز بقوة في البرامج التنافسية والجماهيرية على قناة المجد من خلال برنامجي المقابيس والسارية.
                </p>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="gallery-img-wrapper"><img src="https://darkslategray-goshawk-323284.hostingersite.com/wp-content/uploads/2026/05/WhatsApp-Image-2026-05-10-at-00.18.44.jpeg" alt="مرحلة الانطلاقة 1"></div>
                    <div class="gallery-img-wrapper"><img src="https://darkslategray-goshawk-323284.hostingersite.com/wp-content/uploads/2026/05/WhatsApp-Image-2026-05-10-at-00.11.53.jpeg" alt="مرحلة الانطلاقة 2"></div>
                    <div class="gallery-img-wrapper"><img src="https://darkslategray-goshawk-323284.hostingersite.com/wp-content/uploads/2026/05/WhatsApp-Image-2026-05-10-at-00.07.49-e1778404077548.jpeg" alt="مرحلة الانطلاقة 3"></div>
                    <div class="gallery-img-wrapper"><img src="https://darkslategray-goshawk-323284.hostingersite.com/wp-content/uploads/2026/05/WhatsApp-Image-2026-05-10-at-00.08.05.jpeg" alt="مرحلة الانطلاقة 4"></div>
                </div>
            </div>

            <div class="relative">
                <div class="timeline-dot"></div>
                <div class="timeline-line"></div>
                
                <div class="mb-6">
                    <span class="text-secondary font-black tracking-widest text-sm mb-2 block">2016 - 2026</span>
                    <h3 class="text-2xl md:text-3xl font-black text-brand-dark mb-2">مرحلة التمكن</h3>
                    <p class="text-primary font-bold mb-4">النضج الفني، التوسع الجماهيري، والريادة الإعلامية.</p>
                </div>
                
                <p class="text-gray-600 mb-10 text-base md:text-lg leading-loose font-medium">
                    بدأت بتقديم عمل "سيف المعالي" في برنامج شاعر المليون 2016 والذي حقق انتشاراً واسعاً، تلاها خوض تجربة إعلامية رائدة كمذيع لنفس البرنامج عام 2025 وتضمنت هذه المرحلة إحياء حفلات كبرى مثل حفل خريف عُمان واليوم الوطني السعودي، بالإضافة إلى ظهوره كمشارك ومقدم في أضخم البرامج الجماهيرية كـ (زد رصيدك، بيتنا الكبير، مكة تجمعنا، المعزب، وزاهر)، إلى جانب إحياء العديد من الحفلات والمناسبات الرسمية والخاصة داخل وخارج المملكة.
                </p>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="gallery-img-wrapper"><img src="https://nagham.sa/wp-content/uploads/2026/05/WhatsApp-Image-2026-05-01-at-14.28.37.jpeg" alt="مرحلة التمكن 1"></div>
                    <div class="gallery-img-wrapper"><img src="https://nagham.sa/wp-content/uploads/2026/05/WhatsApp-Image-2026-05-01-at-14.28.39.jpeg" alt="مرحلة التمكن 2"></div>
                    <div class="gallery-img-wrapper"><img src="https://nagham.sa/wp-content/uploads/2026/05/WhatsApp-Image-2026-05-01-at-14.28.41-1.jpeg" alt="مرحلة التمكن 3"></div>
                    <div class="gallery-img-wrapper"><img src="https://nagham.sa/wp-content/uploads/2026/05/WhatsApp-Image-2026-05-01-at-14.28.41-2.jpeg" alt="مرحلة التمكن 4"></div>
                </div>
            </div>

            <div class="relative">
                <div class="timeline-dot"></div>
                <div class="mb-6">
                    <span class="text-secondary font-black tracking-widest text-sm mb-2 block">حاضراً ومستقبلاً</span>
                    <h3 class="text-2xl md:text-3xl font-black text-brand-dark mb-2">مرحلة الارتقاء</h3>
                    <p class="text-primary font-bold mb-4">أبرز التعاونات وأهم الأعمال التي شكلت البصمة الحقيقية.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
                    <div class="bg-surface p-6 rounded-3xl border border-gray-100">
                        <h4 class="text-brand-dark font-black mb-4 flex items-center gap-2 text-lg"><span class="material-symbols-outlined text-primary">youtube_activity</span> النفوذ الرقمي والإنتاج</h4>
                        <div class="space-y-3 text-sm text-gray-600 leading-relaxed font-medium">
                            <p><strong class="text-brand-dark">94 مليون مشاهدة</strong> إجمالي القناة الرسمية على يوتيوب</p>
                            <p>أعمال بارزة مثل <span class="text-primary font-bold">«قمر 14»</span> بأكثر من 19 مليون مشاهدة، و <span class="text-primary font-bold">«مشتاق»</span> بـ 18 مليون، و <span class="text-primary font-bold">«راعي الكيف»</span> بأكثر من 8 ملايين.</p>
                            <p>حصل كليب «آمنة» على جائزة التميز الإعلامي 2020، وقدم شارات برامج مميزة كـ «إعمار اليمن» و«زاهر»</p>
                        </div>
                    </div>

                    <div class="bg-surface p-6 rounded-3xl border border-gray-100">
                        <h4 class="text-brand-dark font-black mb-4 flex items-center gap-2 text-lg"><span class="material-symbols-outlined text-primary">shield</span> المحافل الوطنية</h4>
                        <div class="space-y-3 text-sm text-gray-600 leading-relaxed font-medium">
                            <p>أعمال بارزة لكلية الملك فهد الأمنية والجوازات السعودية مثل <span class="text-primary font-bold">«نعاهدك على القسم»</span></p>
                            <p>أغنية <span class="text-primary font-bold">«بلادي أنت قاموس»</span> لليوم الوطني 2023، و <span class="text-primary font-bold">«ديرة الخير»</span> ليوم التأسيس 2024.</p>
                            <p>تعاون مع مدينة الملك خالد العسكرية لإنتاج عمل <span class="text-primary font-bold">«بنت الشهيد»</span></p>
                        </div>
                    </div>

                    <div class="bg-surface p-6 rounded-3xl border border-gray-100">
                        <h4 class="text-brand-dark font-black mb-4 flex items-center gap-2 text-lg"><span class="material-symbols-outlined text-primary">volunteer_activism</span> المسؤولية الاجتماعية</h4>
                        <div class="space-y-3 text-sm text-gray-600 leading-relaxed font-medium">
                            <p>خدمة ضيوف الرحمن عبر أعمال <span class="text-primary font-bold">«كلكم كفى ووفى»</span> و <span class="text-primary font-bold">«دمت وطناً للحالمين»</span>.</p>
                            <p>مبادرات إنسانية مع لجنة رعاية السجناء «تراحم»، وكليبات توعوية مثل «كفى» و«وقف الحياة»</p>
                            <p>إحياء حفلات الزواج الجماعي بأوبريتات مميزة في جدة والباحة برعاية رسمية</p>
                        </div>
                    </div>

                    <div class="bg-surface p-6 rounded-3xl border border-gray-100">
                        <h4 class="text-brand-dark font-black mb-4 flex items-center gap-2 text-lg"><span class="material-symbols-outlined text-primary">school</span> المحافل الأكاديمية والتجارية</h4>
                        <div class="space-y-3 text-sm text-gray-600 leading-relaxed font-medium">
                            <p>أوبريتات تخرج كبرى لجامعة الملك خالد وجامعة الإمام مثل <span class="text-primary font-bold">«قف بناصية الوفاء»</span>.</p>
                            <p>تعاونات تجارية بارزة مع قصور الحجر بأغنية <span class="text-primary font-bold">«نسانيس العلا»</span>، وشركة أركو بعمل <span class="text-primary font-bold">«سما سما»</span>.</p>
                            <p>مشاركات دولية هادفة لصالح جمعية المرأة العمانية بصلالة.</p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="gallery-img-wrapper"><img src="https://darkslategray-goshawk-323284.hostingersite.com/wp-content/uploads/2026/05/WhatsApp-Image-2026-05-10-at-00.09.09.jpeg" alt="مرحلة الارتقاء 1"></div>
                    <div class="gallery-img-wrapper"><img src="https://darkslategray-goshawk-323284.hostingersite.com/wp-content/uploads/2026/05/WhatsApp-Image-2026-05-10-at-00.08.52.jpeg" alt="مرحلة الارتقاء 2"></div>
                    <div class="gallery-img-wrapper"><img src="https://darkslategray-goshawk-323284.hostingersite.com/wp-content/uploads/2026/05/WhatsApp-Image-2026-05-10-at-00.08.32.jpeg" alt="مرحلة الارتقاء 3"></div>
                    <div class="gallery-img-wrapper"><img src="https://nagham.sa/wp-content/uploads/2026/05/WhatsApp-Image-2026-05-01-at-14.28.42.jpeg" alt="مرحلة الارتقاء 4"></div>
                </div>
            </div>

        </div>
    </div>
</section>

<section class="py-20 bg-brand-dark text-center relative overflow-hidden">
    <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1511285560929-80b456fea0bc?auto=format&fit=crop&w=1920&q=80')] bg-cover bg-center opacity-10"></div>
    <div class="absolute inset-0 bg-gradient-to-t from-brand-dark to-transparent"></div>
    
    <div class="max-w-4xl mx-auto px-6 relative z-10">
        <span class="material-symbols-outlined text-6xl text-secondary mb-6">celebration</span>
        <h2 class="text-3xl md:text-5xl font-black text-white mb-6">شريك اللحظات السعيدة</h2>
        <p class="text-white/80 text-lg md:text-xl leading-relaxed mb-10">
            بصوته الذي لامس مشاعر أكثر من <strong class="text-secondary text-2xl mx-1">50,000</strong> عريس وعروس، يواصل معاذ الجماز صياغة أجمل ذكريات النجاح، الزواج، واستقبال المواليد، ليكون الصوت الحاضر في كل فرح.
        </p>
        
        <div class="bg-white/10 backdrop-blur-md border border-white/20 p-8 rounded-3xl inline-block shadow-2xl">
            <p class="text-xl md:text-2xl font-bold text-white mb-4 italic">"نغم ليست خدمة فنية فقط بل تجربة استثنائية تعيش معكم الحكاية، وتحول مشاعركم إلى صوت، ولحظاتكم إلى نغم باقٍ."</p>
            <p class="text-secondary font-black tracking-widest text-sm">معاذ الجماز | مؤسس نغم</p>
        </div>
    </div>
</section>


<?php get_footer(); ?>