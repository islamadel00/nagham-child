<?php
/**
 * The template for displaying the footer.
 */
?>
</main> <style>
    .nagham-footer-logo {
        height: 55px !important;
        width: auto !important;
        max-width: 100% !important;
        object-fit: contain !important;
        display: block !important;
    }
</style>

<footer class="bg-[#080808] text-white pt-12 pb-6 px-6 md:px-8 relative overflow-hidden border-t border-white/5 mt-auto">
    
    <div class="absolute top-0 left-0 w-full h-px bg-gradient-to-r from-transparent via-secondary/40 to-transparent"></div>

    <div class="max-w-7xl mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-10">

            <div class="lg:col-span-2">
                <div class="mb-5">
                    <img src="https://nagham.sa/wp-content/uploads/2026/04/cropped-cropped-cropped-logonagham.png" class="nagham-footer-logo mb-5 brightness-0 invert opacity-90" alt="نغم للإنتاج الفني">
                </div>
                
                <p class="text-white/60 text-xs md:text-sm leading-relaxed mb-6 max-w-sm">
                    مؤسسة سعودية متخصصة في الإبداع الصوتي. نجمع بين الأصالة والحداثة لنصيغ ذكرياتكم في قوالب موسيقية خالدة.
                </p>

                <div class="flex items-center gap-3">
                    <a href="https://www.tiktok.com/@nagham.sa" target="_blank" class="w-8 h-8 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center hover:bg-secondary hover:text-brand-dark transition-all duration-300">
                        <span class="material-symbols-outlined text-lg">share</span>
                    </a>
                    <a href="https://www.youtube.com/@nagham.sa" target="_blank" class="w-8 h-8 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center hover:bg-secondary hover:text-brand-dark transition-all duration-300">
                        <span class="material-symbols-outlined text-lg">play_circle</span>
                    </a>
                    <a href="https://www.instagram.com/nagham.sa" target="_blank" class="w-8 h-8 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center hover:bg-secondary hover:text-brand-dark transition-all duration-300">
                        <span class="material-symbols-outlined text-lg">share</span>
                    </a>
                    <a href="https://twitter.com/nagham.sa" target="_blank" class="w-8 h-8 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center hover:bg-secondary hover:text-brand-dark transition-all duration-300">
                        <span class="material-symbols-outlined text-lg">share</span>
                    </a>
                </div>
            </div>

            <div>
                <h4 class="text-[10px] font-black mb-5 text-secondary tracking-[0.2em] uppercase">خريطة الموقع</h4>
                <ul class="space-y-3">
                    <li>
                        <a href="<?php echo esc_url(home_url('/')); ?>" class="text-white/70 text-sm hover:text-secondary transition-colors flex items-center gap-2">
                            <span class="w-1 h-1 rounded-full bg-secondary/40"></span>
                            الرئيسية
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo esc_url(home_url('/library')); ?>" class="text-white/70 text-sm hover:text-secondary transition-colors flex items-center gap-2">
                            <span class="w-1 h-1 rounded-full bg-secondary/40"></span>
                            المكتبة
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo esc_url(home_url('/services')); ?>" class="text-white/70 text-sm hover:text-secondary transition-colors flex items-center gap-2">
                            <span class="w-1 h-1 rounded-full bg-secondary/40"></span>
                            الخدمات
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo esc_url(home_url('/about')); ?>" class="text-white/70 text-sm hover:text-secondary transition-colors flex items-center gap-2">
                            <span class="w-1 h-1 rounded-full bg-secondary/40"></span>
                            من نحن
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo esc_url(home_url('/booking')); ?>" class="text-white/70 text-sm hover:text-secondary transition-colors flex items-center gap-2">
                            <span class="w-1 h-1 rounded-full bg-secondary/40"></span>
                            الحجز
                        </a>
                    </li>
                </ul>
            </div>

            <div>
                <h4 class="text-[10px] font-black mb-5 text-secondary tracking-[0.2em] uppercase">تواصل معنا</h4>
                <div class="space-y-4">
                    <div class="flex items-center gap-3 text-white/70">
                        <span class="material-symbols-outlined text-secondary text-sm">location_on</span>
                        <span class="text-xs">الرياض، المملكة العربية السعودية</span>
                    </div>
                    <div class="flex items-center gap-3 text-white/70">
                        <span class="material-symbols-outlined text-secondary text-sm">call</span>
                        <a href="tel:+966550888678" class="text-xs hover:text-white transition-colors" dir="ltr">+966 55 088 8678</a>
                    </div>
                    <a href="https://wa.me/966550888678" class="inline-flex items-center gap-2 bg-secondary/10 border border-secondary/20 text-secondary px-4 py-2 rounded-lg text-xs font-bold hover:bg-secondary hover:text-brand-dark transition-all">
                        <span class="material-symbols-outlined text-sm">chat</span>
                        محادثة واتساب
                    </a>
                </div>
            </div>

        </div>

        <div class="pt-6 border-t border-white/5 flex flex-col md:flex-row items-center justify-between gap-4">
            <p class="text-white/30 text-[10px] font-medium">
                © <?php echo date('Y'); ?> نغم للإنتاج الفني. جميع الحقوق محفوظة.
            </p>
            <div class="flex gap-2 grayscale opacity-40">
                <span class="text-[9px] border border-white/10 px-2 py-0.5 rounded text-white/50 uppercase">Mada</span>
                <span class="text-[9px] border border-white/10 px-2 py-0.5 rounded text-white/50 uppercase">Visa</span>
                <span class="text-[9px] border border-white/10 px-2 py-0.5 rounded text-white/50 uppercase">Mastercard</span>
            </div>
        </div>
    </div>
</footer>
<button id="ngm-custom-scroll-top" class="fixed bottom-6 right-6 z-[999] w-12 h-12 flex items-center justify-center bg-secondary text-white rounded-full shadow-[0_10px_20px_rgba(201,168,76,0.3)] opacity-0 pointer-events-none translate-y-10 transition-all duration-500 hover:bg-brand-dark hover:shadow-[0_10px_25px_rgba(61,43,107,0.4)] hover:-translate-y-1" aria-label="العودة للأعلى">
    <span class="material-symbols-outlined text-2xl font-bold">arrow_upward</span>
</button>



<script>
document.addEventListener('DOMContentLoaded', function() {
    var scrollTopBtn = document.getElementById('ngm-custom-scroll-top');
    
    // إظهار وإخفاء الزرار بناءً على السكرول
    window.addEventListener('scroll', function() {
        if (window.scrollY > 400) {
            // إظهار الزرار
            scrollTopBtn.classList.remove('opacity-0', 'pointer-events-none', 'translate-y-10');
            scrollTopBtn.classList.add('opacity-100', 'pointer-events-auto', 'translate-y-0');
        } else {
            // إخفاء الزرار
            scrollTopBtn.classList.add('opacity-0', 'pointer-events-none', 'translate-y-10');
            scrollTopBtn.classList.remove('opacity-100', 'pointer-events-auto', 'translate-y-0');
        }
    });

    // الصعود للأعلى بنعومة عند الضغط
    scrollTopBtn.addEventListener('click', function() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
});
</script><?php wp_footer(); ?>

</body>
</html>