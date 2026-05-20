<?php
/* Template Name: المكتبة الصوتية */
defined('ABSPATH') || exit;
get_header();

$occasions = get_terms(['taxonomy' => 'nagham_occasion', 'hide_empty' => true, 'orderby' => 'name']);
?>

<style>
.library-content-bg { background-color: #f8f9fb; }
.frosted-glass-card { background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(15px); border: 1px solid rgba(255, 255, 255, 0.9); box-shadow: 0 10px 40px rgba(0,0,0,0.03); transition: all 0.4s ease; }
.frosted-glass-card:hover { background: #fff; transform: translateY(-5px); border-color: #C9A84C; }
.ngm-filter-tab.is-active { background: #1a1a1a !important; color: white !important; transform: scale(1.05); box-shadow: 0 10px 20px rgba(0,0,0,0.1); border-color: #1a1a1a !important; }
.eq-bar { width: 3px; border-radius: 2px; transition: height 0.2s ease; background: #C9A84C; }
.playing .eq-bar { animation: equalize 0.8s infinite alternate ease-in-out; }
.playing .eq-bar:nth-child(1) { animation-delay: 0.1s; }
.playing .eq-bar:nth-child(2) { animation-delay: 0.4s; }
.playing .eq-bar:nth-child(3) { animation-delay: 0.2s; }
@keyframes equalize { 0% { height: 4px; } 100% { height: 20px; } }
</style>

<section class="relative h-[65vh] min-h-[400px] flex items-center justify-center overflow-hidden bg-brand-dark w-full">
    <video class="absolute inset-0 w-full h-full object-cover opacity-60" autoplay muted loop playsinline preload="auto">
        <source src="https://nagham.sa/wp-content/uploads/2026/04/12336851-uhd_3840_2160_25fps-1.mp4" type="video/mp4">
    </video>
    <div class="absolute inset-0 bg-gradient-to-b from-black/60 via-brand-dark/40 to-[#f8f9fb]"></div>
    
    <div class="relative z-10 text-center px-4 max-w-5xl mx-auto mt-8">
        <div class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-full bg-[#C9A84C]/20 border border-[#C9A84C]/30 mb-6 max-w-full backdrop-blur-sm">
            <span class="w-1.5 h-1.5 rounded-full bg-[#C9A84C] animate-pulse shrink-0"></span>
            <span class="text-[#C9A84C] font-black text-[9px] sm:text-[10px] tracking-[2px] sm:tracking-[4px] uppercase text-center">نغمة | أرشيف فني يجمع أصالة الكلمة وإبداع الأداء</span>
        </div>
        <h1 class="text-4xl sm:text-6xl md:text-7xl font-black text-white mb-4 tracking-tighter">أرشيف <span class="text-[#C9A84C] italic">النغم</span></h1>
        <p class="text-white/80 text-sm md:text-lg max-w-2xl mx-auto">اكتشف أرشيفنا الفني حيث تلتقي الأصالة بالإبداع الصوتي الحديث.</p>
    </div>
</section>

<section class="relative py-20 library-content-bg min-h-screen">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 relative z-10">

        <div class="flex flex-wrap gap-2 md:gap-3 justify-center mb-12 md:mb-16">
            <button class="ngm-filter-tab is-active px-6 md:px-10 py-2.5 md:py-3.5 rounded-full font-black text-[10px] md:text-[11px] uppercase tracking-widest bg-white text-brand-dark shadow-sm border border-gray-100" data-occasion="all">الكل</button>
            <?php foreach ((array)$occasions as $term) : ?>
                <button class="ngm-filter-tab px-6 md:px-10 py-2.5 md:py-3.5 rounded-full font-black text-[10px] md:text-[11px] uppercase tracking-widest bg-white text-gray-400 shadow-sm border border-gray-100 hover:text-brand-dark" data-occasion="<?php echo esc_attr($term->slug); ?>"><?php echo esc_html($term->name); ?></button>
            <?php endforeach; ?>
        </div>

        <div id="ngm-tracks-grid" class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8">
            <?php
            $query = new WP_Query(['post_type' => 'nagham_track', 'post_status' => 'publish', 'posts_per_page' => -1, 'orderby' => 'menu_order date', 'order' => 'ASC']);
            if ($query->have_posts()) :
                while ($query->have_posts()) : $query->the_post();
                    $track_id = get_the_ID();
                    $duration = get_post_meta($track_id, '_nagham_duration', true) ?: '';
                    $terms    = get_the_terms($track_id, 'nagham_occasion');
                    $slugs = $terms ? implode(' ', wp_list_pluck($terms, 'slug')) : 'uncategorized';
            ?>
            <div class="nagham-audio-player-container track-item frosted-glass-card p-3 md:p-6 rounded-[2rem] flex items-center justify-between group" data-category="<?php echo esc_attr($slugs); ?>">
                
                <div class="flex items-center gap-3 md:gap-6 w-1/2 md:w-auto">
                    <div class="relative w-14 h-14 md:w-16 md:h-16 rounded-2xl bg-white shadow-inner flex-shrink-0 overflow-hidden border border-gray-50">
                        <?php if (has_post_thumbnail()) : the_post_thumbnail('thumbnail', ['class' => 'w-full h-full object-cover', 'alt' => get_the_title()]); else : ?>
                            <span class="material-symbols-outlined absolute inset-0 flex items-center justify-center text-gray-200 text-3xl md:text-4xl">audiotrack</span>
                        <?php endif; ?>
                        <div class="absolute inset-0 bg-[#3D2B6B]/90 flex items-center justify-center gap-[3px] opacity-0 group-[.playing]:opacity-100 transition-opacity">
                            <div class="eq-bar h-2"></div><div class="eq-bar h-4"></div><div class="eq-bar h-3"></div>
                        </div>
                    </div>
                    <div class="min-w-0">
                        <h4 class="text-brand-dark font-black text-sm md:text-lg mb-1 truncate max-w-[120px] sm:max-w-[200px]"><?php the_title(); ?></h4>
                        <?php if ($terms) : ?><span class="text-[9px] md:text-[10px] text-[#C9A84C] font-black uppercase tracking-[0.2em] bg-[#C9A84C]/10 px-2 py-0.5 rounded"><?php echo esc_html($terms[0]->name); ?></span><?php endif; ?>
                    </div>
                </div>

                <div class="hidden md:flex flex-1 mx-6 items-center justify-center gap-3">
                    <span class="audio-time text-[10px] text-gray-400 font-mono w-8 text-right">0:00</span>
                    <div class="flex-1 h-1.5 bg-gray-200 rounded-full relative cursor-pointer progress-container overflow-hidden">
                        <div class="progress-bar absolute left-0 top-0 h-full bg-[#7B5EA7] w-0 pointer-events-none transition-all duration-100"></div>
                    </div>
                    <span class="text-[10px] text-gray-400 font-mono w-8 text-left"><?php echo esc_html($duration); ?></span>
                </div>

                <div class="flex items-center gap-1 md:gap-2 flex-shrink-0">
                    <button type="button" class="skip-backward-btn text-gray-400 hover:text-primary transition-colors flex">
                        <span class="material-symbols-outlined text-[20px] md:text-[22px]">replay_5</span>
                    </button>

                    <button type="button" class="play-audio-btn w-10 h-10 md:w-12 md:h-12 rounded-full bg-white shadow-md flex items-center justify-center text-[#7B5EA7] group-[.playing]:bg-[#3D2B6B] group-[.playing]:text-white transition-all flex-shrink-0 border border-primary/5 group-[.playing]:border-transparent">
                        <span class="play-icon material-symbols-outlined text-xl md:text-2xl">play_arrow</span>
                    </button>

                    <button type="button" class="skip-forward-btn text-gray-400 hover:text-primary transition-colors flex">
                        <span class="material-symbols-outlined text-[20px] md:text-[22px]">forward_5</span>
                    </button>
                </div>
                
                <audio class="nagham-product-audio" src="<?php echo admin_url('admin-ajax.php?action=nagham_stream_direct&id=' . $track_id); ?>" preload="none"></audio>
            </div>
            <?php endwhile; wp_reset_postdata(); else: ?>
                <div class="col-span-1 md:col-span-2 text-center py-10">
                    <p class="text-gray-400 font-bold">لا توجد مقاطع حالياً.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<div id="ngm-sticky-bar" class="fixed bottom-0 left-0 w-full bg-white/95 backdrop-blur-2xl border-t border-gray-200 z-[999] py-3 md:py-4 px-2 md:px-10 shadow-[0_-10px_40px_rgba(0,0,0,0.08)] flex items-center" style="transform:translateY(100%); transition:transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);">
    <div class="max-w-6xl mx-auto flex items-center justify-between gap-2 md:gap-8 w-full">
        
        <div class="hidden md:flex items-center gap-4 w-1/4 min-w-[120px] truncate">
            <div class="truncate">
                <p id="ngm-bar-title" class="text-brand-dark font-black text-sm truncate">جاري التشغيل...</p>
                <p class="text-gray-400 text-[9px] uppercase font-bold tracking-widest">Nagham Audio</p>
            </div>
        </div>
        
        <div class="flex items-center gap-1.5 md:gap-4 flex-shrink-0 ml-2 md:ml-0">
            <button id="ngm-bar-skip-backward" class="text-gray-400 hover:text-[#7B5EA7] transition-colors">
                <span class="material-symbols-outlined text-[20px] md:text-xl">replay_5</span>
            </button>
            
            <button id="ngm-bar-play" class="w-10 h-10 md:w-12 md:h-12 rounded-full bg-[#3D2B6B] text-white flex items-center justify-center shadow-lg hover:bg-[#7B5EA7] transition-colors flex-shrink-0">
                <span class="material-symbols-outlined">pause</span>
            </button>
            
            <button id="ngm-bar-skip-forward" class="text-gray-400 hover:text-[#7B5EA7] transition-colors">
                <span class="material-symbols-outlined text-[20px] md:text-xl">forward_5</span>
            </button>
        </div>
        
        <div class="flex-1 flex items-center gap-1.5 md:gap-3 min-w-0 pr-1 md:pr-0">
            <span id="ngm-bar-time" class="text-[9px] md:text-[10px] text-gray-500 font-mono w-7 md:w-8 text-center flex-shrink-0">0:00</span>
            <div id="ngm-bar-progress-container" class="flex-1 bg-gray-200 h-1.5 md:h-2 rounded-full cursor-pointer relative overflow-hidden" dir="ltr">
                <div id="ngm-bar-progress" class="absolute left-0 top-0 h-full bg-[#7B5EA7] w-0 pointer-events-none transition-all duration-100"></div>
            </div>
            <span id="ngm-bar-duration" class="text-[9px] md:text-[10px] text-gray-500 font-mono w-7 md:w-8 text-center flex-shrink-0">0:00</span>
        </div>
        
        <button id="ngm-bar-close" class="w-8 h-8 md:w-10 md:h-10 rounded-full bg-gray-50 border border-gray-100 flex items-center justify-center text-gray-400 hover:text-red-500 hover:bg-red-50 transition-colors flex-shrink-0 ml-1">
            <span class="material-symbols-outlined text-base md:text-lg">close</span>
        </button>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // تزامن الشريط السفلي مع المشغل الموحد (nagham.js)
    setInterval(() => {
        const activeContainer = document.querySelector('.nagham-audio-player-container.playing');
        const stickyBar = document.getElementById('ngm-sticky-bar');
        
        if (activeContainer) {
            const audio = activeContainer.querySelector('audio');
            stickyBar.style.transform = 'translateY(0)';
            
            // تحديث العنوان (للديسكتوب)
            const titleEl = activeContainer.querySelector('h4');
            if(titleEl) document.getElementById('ngm-bar-title').innerText = titleEl.innerText;
            
            // تحديث أيقونة التشغيل
            document.getElementById('ngm-bar-play').innerHTML = audio.paused ? '<span class="material-symbols-outlined">play_arrow</span>' : '<span class="material-symbols-outlined">pause</span>';
            
            // تحديث الوقت وشريط التقدم
            if (isFinite(audio.duration) && audio.duration > 0) {
                document.getElementById('ngm-bar-progress').style.width = ((audio.currentTime / audio.duration) * 100) + '%';
                let cm = Math.floor(audio.currentTime / 60), cs = Math.floor(audio.currentTime % 60);
                document.getElementById('ngm-bar-time').innerText = `${cm}:${cs < 10 ? '0' : ''}${cs}`;
                let dm = Math.floor(audio.duration / 60), ds = Math.floor(audio.duration % 60);
                document.getElementById('ngm-bar-duration').innerText = `${dm}:${ds < 10 ? '0' : ''}${ds}`;
            }

            // ربط أزرار الشريط السفلي بالتقديم والتأخير
            document.getElementById('ngm-bar-play').onclick = () => audio.paused ? audio.play() : audio.pause();
            document.getElementById('ngm-bar-skip-forward').onclick = () => audio.currentTime = Math.min(audio.duration, audio.currentTime + 5);
            document.getElementById('ngm-bar-skip-backward').onclick = () => audio.currentTime = Math.max(0, audio.currentTime - 5);
            
            // زر الإغلاق
            document.getElementById('ngm-bar-close').onclick = () => { 
                audio.pause(); 
                activeContainer.classList.remove('playing'); 
                const icon = activeContainer.querySelector('.play-icon');
                if(icon) icon.innerText = 'play_arrow';
                stickyBar.style.transform = 'translateY(100%)'; 
            };
            
            // شريط التقدم التفاعلي
            document.getElementById('ngm-bar-progress-container').onclick = (e) => {
                const rect = e.currentTarget.getBoundingClientRect();
                audio.currentTime = ((e.clientX - rect.left) / rect.width) * audio.duration;
            };
        } else {
            stickyBar.style.transform = 'translateY(100%)';
        }
    }, 500);

    // فلتر الأقسام (لحظي JS)
    const filterBtns = document.querySelectorAll('.ngm-filter-tab');
    const trackItems = document.querySelectorAll('.track-item');
    filterBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            filterBtns.forEach(b => { b.classList.remove('is-active', 'bg-brand-dark', 'text-white'); b.classList.add('text-gray-400'); });
            btn.classList.add('is-active', 'bg-brand-dark', 'text-white'); btn.classList.remove('text-gray-400');
            const filter = btn.getAttribute('data-occasion');
            trackItems.forEach(item => { 
                item.style.display = (filter === 'all' || item.getAttribute('data-category').includes(filter)) ? 'flex' : 'none'; 
            });
        });
    });
});
</script>

<?php get_footer(); ?>