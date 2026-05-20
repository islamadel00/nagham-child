<?php get_header(); ?>

<section class="pt-32 pb-20 bg-[#080808] relative overflow-hidden">
    <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/stardust.png')] opacity-30"></div>
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-full bg-primary/10 blur-[120px] rounded-full pointer-events-none"></div>
    
    <div class="max-w-7xl mx-auto px-6 text-center relative z-10">
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/5 border border-white/10 mb-6 backdrop-blur-sm">
            <span class="w-1.5 h-1.5 rounded-full bg-primary animate-pulse"></span>
            <span class="text-white font-bold text-[10px] tracking-[3px] uppercase">أصدقاء وشركاء</span>
        </div>
        
        <h1 class="text-4xl md:text-6xl font-black text-white mb-6 tracking-tighter">شركاء <span class="text-primary italic">النجاح</span></h1>
        <p class="text-white/60 text-lg max-w-2xl mx-auto leading-relaxed">
            نفخر بثقة نخبة من الكيانات والمؤسسات الرائدة التي شاركناها أجمل اللحظات وصنعنا معها هوية صوتية لا تُنسى.
        </p>
    </div>
</section>

<section class="py-20 bg-[#fafafa]">
    <div class="max-w-7xl mx-auto px-6">
        <h2 class="text-2xl font-black text-brand-dark mb-10 text-center md:text-right">شركاء استراتيجيون</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php
            $featured_query = new WP_Query([
                'post_type' => 'partner',
                'posts_per_page' => -1,
                'meta_key' => '_is_featured_partner',
                'meta_value' => 'yes'
            ]);

            if ($featured_query->have_posts()) :
                while ($featured_query->have_posts()) : $featured_query->the_post();
                    $logo = get_the_post_thumbnail_url(get_the_ID(), 'large');
                    $link = get_post_meta(get_the_ID(), '_partner_url', true);
                    $tag = !empty($link) ? 'a' : 'div';
                    $href = !empty($link) ? 'href="' . esc_url($link) . '" target="_blank"' : '';
            ?>
                <<?php echo $tag; ?> <?php echo $href; ?> class="group bg-white rounded-[2rem] p-8 border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-500 cursor-pointer text-center flex flex-col items-center justify-center">
                    <div class="h-32 flex items-center justify-center mb-6">
                        <img src="<?php echo esc_url($logo); ?>" alt="<?php echo esc_attr( sprintf( 'شعار %s', get_the_title() ) ); ?>" class="max-h-full max-w-full object-contain transition-transform duration-500 group-hover:scale-105">
                    </div>
                    <h3 class="font-bold text-brand-dark text-lg group-hover:text-primary transition-colors"><?php the_title(); ?></h3>
                </<?php echo $tag; ?>>
            <?php 
                endwhile; wp_reset_postdata(); 
            else: 
                echo '<p class="text-gray-400">لم يتم تحديد شركاء استراتيجيين بعد.</p>';
            endif; 
            ?>
        </div>
    </div>
</section>

<section class="pb-24 bg-[#fafafa]">
    <div class="max-w-7xl mx-auto px-6 border-t border-gray-200 pt-20">
        <h2 class="text-2xl font-black text-brand-dark mb-10 text-center md:text-right">مؤسسات وثقت بنا</h2>
        
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4 md:gap-6">
            <?php
            $regular_query = new WP_Query([
                'post_type' => 'partner',
                'posts_per_page' => -1,
                'meta_query' => [
                    'relation' => 'OR',
                    [
                        'key' => '_is_featured_partner',
                        'compare' => 'NOT EXISTS'
                    ],
                    [
                        'key' => '_is_featured_partner',
                        'value' => 'yes',
                        'compare' => '!='
                    ]
                ]
            ]);

            if ($regular_query->have_posts()) :
                while ($regular_query->have_posts()) : $regular_query->the_post();
                    $logo = get_the_post_thumbnail_url(get_the_ID(), 'medium');
                    $link = get_post_meta(get_the_ID(), '_partner_url', true);
                    $tag = !empty($link) ? 'a' : 'div';
                    $href = !empty($link) ? 'href="' . esc_url($link) . '" target="_blank"' : '';
            ?>
                <<?php echo $tag; ?> <?php echo $href; ?> class="bg-white rounded-2xl p-6 border border-gray-100 hover:border-primary/40 hover:shadow-md transition-all duration-300 flex flex-col items-center justify-center gap-4 group cursor-pointer text-center">
                    <div class="h-20 flex items-center justify-center w-full">
                        <img src="<?php echo esc_url($logo); ?>" alt="<?php echo esc_attr( sprintf( 'شعار %s', get_the_title() ) ); ?>" class="max-h-full max-w-full object-contain transition-transform duration-300 group-hover:scale-110">
                    </div>
                    <h4 class="font-bold text-brand-dark/80 text-sm group-hover:text-primary transition-colors"><?php the_title(); ?></h4>
                </<?php echo $tag; ?>>
            <?php 
                endwhile; wp_reset_postdata(); 
            endif; 
            ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>