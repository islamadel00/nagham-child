<!DOCTYPE html>
<html <?php language_attributes(); ?> dir="rtl">
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script src="https://cdn.tailwindcss.com"></script>
<script>
tailwind.config = {
  darkMode: "class",
  theme: {
    extend: {
      colors: {
        "primary":       "#7B5EA7",
        "secondary":     "#C9A84C",
        "brand-dark":    "#3D2B6B",
        "surface":       "#FAF8F5",
        "on-background": "#1b1c1a",
      },
      animation: {
        'marquee':      'marquee 30s linear infinite',
        'pulse-gentle': 'pulse-gentle 2s infinite',
        'float':        'float 3s ease-in-out infinite',
        'bounce-slow':  'bounce 2s infinite',
        'wave-vibrant': 'wave-vibrant 1.2s ease-in-out infinite',
      },
      keyframes: {
        marquee:        { '0%':{ transform:'translateX(0%)' }, '100%':{ transform:'translateX(100%)' } },
        'pulse-gentle': { '0%,100%':{ transform:'scale(1)', boxShadow:'0 0 0 0 rgba(37,211,102,0.7)' }, '50%':{ transform:'scale(1.15)', boxShadow:'0 0 0 25px rgba(37,211,102,0)' } },
        float:          { '0%,100%':{ transform:'translateY(0)' }, '50%':{ transform:'translateY(-10px)' } },
        'wave-vibrant': { '0%,100%':{ height:'6px' }, '50%':{ height:'18px' } },
      }
    }
  }
}
</script>
<link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;900&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
<style>
*,*::before,*::after{box-sizing:border-box}
html { scroll-behavior: smooth; } /* عشان ينزل لسكشن الأعمال بنعومة */
body{font-family:'Tajawal',sans-serif;background-color:#FAF8F5;color:#1b1c1a;overflow-x:hidden}
.material-symbols-outlined{font-variation-settings:'FILL' 0,'wght' 400,'GRAD' 0,'opsz' 24}

/* Navbar */
#ngm-navbar{transition:background .35s ease,box-shadow .35s ease;background:transparent}
#ngm-navbar.scrolled{background:rgba(255,255,255,.95);backdrop-filter:blur(20px);-webkit-backdrop-filter:blur(20px);box-shadow:0 1px 20px rgba(0,0,0,.07)}
#ngm-navbar .nav-link{color:rgba(255,255,255,.9);transition:color .3s ease;font-weight:700}
#ngm-navbar.scrolled .nav-link{color:#1b1c1a}
#ngm-navbar .nav-link:hover,#ngm-navbar.scrolled .nav-link:hover{color:#7B5EA7}
#ngm-navbar .nav-link.active{color:#fff;border-bottom:2px solid #C9A84C;padding-bottom:2px}
#ngm-navbar.scrolled .nav-link.active{color:#7B5EA7;border-bottom-color:#7B5EA7}
#ngm-navbar .nav-logo-text{color:#fff;transition:color .3s ease}
#ngm-navbar.scrolled .nav-logo-text{color:#7B5EA7}
#ngm-navbar .nav-cta{background:#C9A84C;color:#fff;transition:background .3s ease,transform .2s ease}
#ngm-navbar .nav-cta:hover{background:#b8943f;transform:translateY(-1px)}
#ngm-navbar.scrolled .nav-cta{background:#7B5EA7}
#ngm-navbar.scrolled .nav-cta:hover{background:#3D2B6B}
#ngm-navbar .custom-logo{height:75px;width:auto;object-fit:contain;filter:brightness(0) invert(1);transition:filter .3s ease}
#ngm-navbar.scrolled .custom-logo{filter:none}

/* ─── Desktop Dropdown Styles ─── */
.nav-dropdown {
  opacity: 0;
  visibility: hidden;
  transform: translateY(15px);
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  pointer-events: none;
}
.group:hover .nav-dropdown {
  opacity: 1;
  visibility: visible;
  transform: translateY(0);
  pointer-events: auto;
}
/* عشان نربط بين الكلمة والقائمة المنسدلة ومتقفلش لما الماوس ينزل */
.nav-dropdown::before {
  content: '';
  position: absolute;
  top: -15px;
  left: 0;
  right: 0;
  height: 15px;
}

/* ─── Mobile Menu Styles ─── */
#ngm-mobile-menu{
  display:grid;
  grid-template-rows:0fr;
  transition:grid-template-rows .35s ease,opacity .35s ease;
  opacity:0;
  background:rgba(255,255,255,.97);
  backdrop-filter:blur(20px);
  border-top:1px solid rgba(0,0,0,.06);
  overflow:hidden;
}
#ngm-mobile-menu.open{grid-template-rows:1fr;opacity:1}
#ngm-mobile-menu-inner{overflow:hidden;padding:0 2rem}
#ngm-mobile-menu.open #ngm-mobile-menu-inner{padding:1.25rem 2rem}

.mobile-dropdown-content {
  max-height: 0;
  opacity: 0;
  transition: all 0.4s ease;
  overflow: hidden;
}
.mobile-dropdown-content.open {
  max-height: 400px; /* رقم كبير يسمح بفتح كل العناصر */
  opacity: 1;
  margin-bottom: 0.5rem;
}

.marquee-fade{mask-image:linear-gradient(to right,transparent,black 12%,black 88%,transparent);-webkit-mask-image:linear-gradient(to right,transparent,black 12%,black 88%,transparent)}
@keyframes wave{0%,100%{height:8px}50%{height:24px}}
.animate-wave{animation:wave 1.5s ease-in-out infinite}
</style>
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<nav id="ngm-navbar" class="fixed top-0 w-full z-50">
  <div class="flex items-center justify-between w-full px-6 md:px-8 py-4 max-w-7xl mx-auto">

    <div class="flex items-center gap-2 flex-shrink-0">
      <?php
      if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) {
          $custom_logo_id = get_theme_mod( 'custom_logo' );
          $logo_url = wp_get_attachment_image_url( $custom_logo_id , 'full' );
          echo '<a href="' . esc_url( home_url( '/' ) ) . '" class="flex items-center">';
          echo '<img src="' . esc_url( $logo_url ) . '" alt="' . get_bloginfo( 'name' ) . '" class="custom-logo">';
          echo '</a>';
      } else {
          echo '<a href="' . esc_url( home_url( '/' ) ) . '" class="flex items-center gap-2">';
          echo '<span class="nav-logo-text text-2xl font-black">نغم</span>';
          echo '<span class="material-symbols-outlined nav-logo-text text-xl">music_note</span>';
          echo '</a>';
      }
      ?>
    </div>

    <div class="hidden md:flex items-center justify-center flex-1 gap-6 lg:gap-8 text-base">
      <a href="<?php echo esc_url(home_url('/')); ?>" class="nav-link <?php echo is_front_page() ? 'active' : ''; ?>">الرئيسية</a>
      <a href="<?php echo esc_url(home_url('/library')); ?>" class="nav-link <?php echo is_page('library') ? 'active' : ''; ?>">المكتبة</a>
      
      <div class="group relative">
        <a href="#service_audio" class="nav-link flex items-center gap-1 cursor-pointer <?php echo is_page('services') ? 'active' : ''; ?>">
            الخدمات
            <span class="material-symbols-outlined text-[18px] transition-transform duration-300 group-hover:rotate-180">expand_more</span>
        </a>
        
        <div class="nav-dropdown absolute top-full start-1/2 -translate-x-1/2 mt-4 w-56 bg-white rounded-2xl shadow-[0_20px_40px_rgba(0,0,0,0.1)] border border-gray-100 p-3 flex flex-col z-50">
            <a href="<?php echo esc_url(home_url('/product/zaffa/')); ?>" class="block px-4 py-2.5 text-sm font-bold text-gray-600 hover:bg-surface hover:text-primary rounded-xl transition-colors">زفة الزواج</a>
            <a href="<?php echo esc_url(home_url('/product/shilat/')); ?>" class="block px-4 py-2.5 text-sm font-bold text-gray-600 hover:bg-surface hover:text-primary rounded-xl transition-colors">شيلات</a>
            <a href="<?php echo esc_url(home_url('/product/newborn/')); ?>" class="block px-4 py-2.5 text-sm font-bold text-gray-600 hover:bg-surface hover:text-primary rounded-xl transition-colors">المواليد</a>
            <a href="<?php echo esc_url(home_url('/product/graduation/')); ?>" class="block px-4 py-2.5 text-sm font-bold text-gray-600 hover:bg-surface hover:text-primary rounded-xl transition-colors">التخرج</a>
            <a href="<?php echo esc_url(home_url('/product/birthday/')); ?>" class="block px-4 py-2.5 text-sm font-bold text-gray-600 hover:bg-surface hover:text-primary rounded-xl transition-colors">أيام ميلاد</a>
            <a href="<?php echo esc_url(home_url('/product/anniversary/')); ?>" class="block px-4 py-2.5 text-sm font-bold text-gray-600 hover:bg-surface hover:text-primary rounded-xl transition-colors">ذكرى الزواج</a>
            <div class="h-px bg-gray-100 my-1 mx-2"></div>
            <a href="<?php echo esc_url(home_url('/product/custom/')); ?>" class="block px-4 py-2.5 text-sm font-black text-secondary hover:bg-surface rounded-xl transition-colors flex items-center justify-between">
                طلب VIP <span class="material-symbols-outlined text-[16px]">stars</span>
            </a>
        </div>
      </div>

      <a href="<?php echo esc_url(home_url('/#ngm-library-preview')); ?>" class="nav-link">أعمالنا</a>
      <a href="<?php echo esc_url(home_url('/about')); ?>" class="nav-link <?php echo is_page('about') ? 'active' : ''; ?>">من نحن</a>
    </div>

    <div class="flex items-center gap-3 flex-shrink-0">
      <a href="<?php echo esc_url(home_url('/booking')); ?>" class="nav-cta hidden md:inline-flex items-center px-5 py-2.5 rounded-full font-bold text-sm shadow-md">
        احجز الآن
      </a>
      <button id="ngm-mobile-menu-btn" class="md:hidden p-1" aria-label="القائمة" aria-expanded="false">
        <span class="material-symbols-outlined nav-logo-text text-3xl" id="ngm-hamburger-icon">menu</span>
      </button>
    </div>
  </div>

  <div id="ngm-mobile-menu" role="navigation" aria-label="القائمة المحمولة">
    <div id="ngm-mobile-menu-inner" class="flex flex-col gap-1">
      <a href="<?php echo esc_url(home_url('/')); ?>" class="font-bold text-primary py-3 border-b border-zinc-100 text-base">الرئيسية</a>
      <a href="<?php echo esc_url(home_url('/library')); ?>" class="font-bold text-on-background hover:text-primary py-3 border-b border-zinc-100 text-base transition-colors">المكتبة</a>
      
      <div class="border-b border-zinc-100 flex flex-col">
          <div class="flex items-center justify-between cursor-pointer group" id="mobile-services-toggle">
              <a href="<?php echo esc_url(home_url('/services')); ?>" class="font-bold text-on-background group-hover:text-primary py-3 text-base transition-colors flex-1">الخدمات</a>
              <span class="material-symbols-outlined text-gray-400 group-hover:text-primary transition-transform duration-300" id="mobile-services-icon">expand_more</span>
          </div>
          <div id="mobile-services-dropdown" class="mobile-dropdown-content flex flex-col px-4 border-r-2 border-primary/20 mr-2 mb-1">
              <a href="<?php echo esc_url(home_url('/product/zaffa/')); ?>" class="py-2.5 text-sm font-bold text-gray-500 hover:text-primary">زفة الزواج</a>
              <a href="<?php echo esc_url(home_url('/product/shilat/')); ?>" class="py-2.5 text-sm font-bold text-gray-500 hover:text-primary">شيلات</a>
              <a href="<?php echo esc_url(home_url('/product/newborn/')); ?>" class="py-2.5 text-sm font-bold text-gray-500 hover:text-primary">المواليد</a>
              <a href="<?php echo esc_url(home_url('/product/graduation/')); ?>" class="py-2.5 text-sm font-bold text-gray-500 hover:text-primary">التخرج</a>
              <a href="<?php echo esc_url(home_url('/product/birthday/')); ?>" class="py-2.5 text-sm font-bold text-gray-500 hover:text-primary">أيام ميلاد</a>
              <a href="<?php echo esc_url(home_url('/product/anniversary/')); ?>" class="py-2.5 text-sm font-bold text-gray-500 hover:text-primary">ذكرى الزواج</a>
              <a href="<?php echo esc_url(home_url('/product/custom/')); ?>" class="py-2.5 text-sm font-black text-secondary">طلب VIP</a>
          </div>
      </div>

      <a href="<?php echo esc_url(home_url('/#ngm-library-preview')); ?>" class="font-bold text-on-background hover:text-primary py-3 border-b border-zinc-100 text-base transition-colors mobile-close-link">أعمالنا</a>
      
      <a href="<?php echo esc_url(home_url('/about')); ?>" class="font-bold text-on-background hover:text-primary py-3 text-base transition-colors">من نحن</a>
      <a href="<?php echo esc_url(home_url('/booking')); ?>" class="bg-primary text-white px-6 py-3 rounded-full font-bold text-center mt-3 mb-1 hover:bg-brand-dark transition-colors">احجز الآن</a>
    </div>
  </div>
</nav>

<script>
(function(){
  var nav  = document.getElementById('ngm-navbar');
  var btn  = document.getElementById('ngm-mobile-menu-btn');
  var menu = document.getElementById('ngm-mobile-menu');
  var icon = document.getElementById('ngm-hamburger-icon');
  var open = false;

  // تأثير السكرول للنافبار
  function onScroll(){ nav.classList.toggle('scrolled', window.scrollY > 60); }
  window.addEventListener('scroll', onScroll, { passive:true });
  onScroll();

  // فتح وقفل المنيو في الموبايل
  btn && btn.addEventListener('click', function(e){
    e.stopPropagation();
    open = !open;
    menu.classList.toggle('open', open);
    icon.textContent = open ? 'close' : 'menu';
    btn.setAttribute('aria-expanded', open);
  });

  // 💡 القائمة المنسدلة للخدمات في الموبايل
  var servicesToggle = document.getElementById('mobile-services-toggle');
  var servicesDropdown = document.getElementById('mobile-services-dropdown');
  var servicesIcon = document.getElementById('mobile-services-icon');
  
  if(servicesToggle && servicesDropdown) {
      servicesToggle.addEventListener('click', function(e) {
          e.preventDefault(); // منع الذهاب لصفحة الخدمات عند الضغط على السهم
          servicesDropdown.classList.toggle('open');
          if(servicesDropdown.classList.contains('open')) {
              servicesIcon.style.transform = 'rotate(180deg)';
          } else {
              servicesIcon.style.transform = 'rotate(0deg)';
          }
      });
  }

  // قفل المنيو في الموبايل لو داس في أي حتة بره، أو لو داس على لينك (زي "أعمالنا")
  document.addEventListener('click', function(e){
    if(open && !nav.contains(e.target)){ 
        open=false; menu.classList.remove('open'); icon.textContent='menu'; 
    }
  });

  var mobileLinks = document.querySelectorAll('.mobile-close-link');
  mobileLinks.forEach(function(link) {
      link.addEventListener('click', function() {
          open=false; menu.classList.remove('open'); icon.textContent='menu';
      });
  });
})();
</script>

<main id="ngm-main">