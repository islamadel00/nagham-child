'use strict';

document.addEventListener('DOMContentLoaded', function() {
    // 1. مشغل الصوت لصفحة المنتجات والخدمات (أبسط وأسرع نظام)
    const players = document.querySelectorAll('.nagham-audio-player-container');
    
    players.forEach(player => {
        const audio = player.querySelector('audio');
        const playBtn = player.querySelector('.play-audio-btn');
        const playIcon = player.querySelector('.play-icon');
        const timeDisplay = player.querySelector('.audio-time');
        const progressBar = player.querySelector('.progress-bar');
        const progressContainer = player.querySelector('.progress-container');
        const skipForward = player.querySelector('.skip-forward-btn');
        const skipBackward = player.querySelector('.skip-backward-btn');

        if(playBtn && audio) {
            playBtn.addEventListener('click', function(e) {
                e.preventDefault(); 
                
                // إيقاف أي أغنية تانية شغالة في الموقع عشان مفيش صوتين يشتغلوا مع بعض
                document.querySelectorAll('audio').forEach(a => {
                    if(a !== audio && !a.paused) {
                        a.pause();
                        // تصفير شكل الأغاني التانية
                        const otherContainer = a.closest('.nagham-audio-player-container');
                        if (otherContainer) {
                            otherContainer.classList.remove('playing');
                            const otherIcon = otherContainer.querySelector('.play-icon');
                            if (otherIcon) otherIcon.innerText = 'play_arrow';
                        }
                    }
                });

                if (audio.paused) {
                    audio.play();
                    if(playIcon) playIcon.innerText = 'pause';
                    player.classList.add('playing');
                } else {
                    audio.pause();
                    if(playIcon) playIcon.innerText = 'play_arrow';
                    player.classList.remove('playing');
                }
            });

            audio.addEventListener('timeupdate', function() {
                if (isFinite(audio.duration)) {
                    let mins = Math.floor(audio.currentTime / 60);
                    let secs = Math.floor(audio.currentTime % 60);
                    if(timeDisplay) timeDisplay.innerText = mins + ':' + (secs < 10 ? '0' : '') + secs;
                    if(progressBar) progressBar.style.width = ((audio.currentTime / audio.duration) * 100) + '%';
                }
            });

            if(progressContainer && progressBar) {
                progressContainer.addEventListener('click', function(e) {
                    if(isFinite(audio.duration)) {
                        const rect = progressContainer.getBoundingClientRect();
                        audio.currentTime = ((e.clientX - rect.left) / rect.width) * audio.duration;
                    }
                });
            }

            if (skipForward) skipForward.onclick = (e) => { e.preventDefault(); if(isFinite(audio.duration)) audio.currentTime = Math.min(audio.duration, audio.currentTime + 5); };
            if (skipBackward) skipBackward.onclick = (e) => { e.preventDefault(); if(isFinite(audio.duration)) audio.currentTime = Math.max(0, audio.currentTime - 5); };
            
            audio.addEventListener('ended', function() {
                if(playIcon) playIcon.innerText = 'play_arrow';
                if(timeDisplay) timeDisplay.innerText = '0:00';
                if(progressBar) progressBar.style.width = '0%';
                player.classList.remove('playing');
            });
        }
    });

    // 2. فورم الحجز
    const form = document.querySelector('#ngm-booking-form');
    if (form) {
        form.addEventListener('submit', async e => {
            e.preventDefault();
            const btn = form.querySelector('[type="submit"]');
            const errEl = form.querySelector('#ngm-form-error');
            const sukEl = form.querySelector('#ngm-form-success');

            btn.disabled = true;
            btn.textContent = 'جاري الإرسال...';
            if (errEl) errEl.textContent = '';

            const fd = new FormData(form);
            fd.append('action', 'nagham_submit_booking');
            fd.append('nonce', NAGHAM.nonce);

            try {
                const res = await fetch(NAGHAM.ajax_url, { method: 'POST', body: fd });
                const data = await res.json();

                if (data.success) {
                    form.style.display = 'none';
                    if (sukEl) {
                        sukEl.innerHTML = `<p>تم استقبال طلبك بنجاح!</p><a href="${data.data.whatsapp}" target="_blank" class="ngm-btn ngm-btn-whatsapp">تابع على واتساب</a>`;
                        sukEl.style.display = 'block';
                    }
                } else {
                    if (errEl) errEl.textContent = data.data?.msg || 'حدث خطأ.';
                    btn.disabled = false;
                    btn.textContent = 'إرسال الطلب';
                }
            } catch(err) {
                if (errEl) errEl.textContent = 'تعذّر الاتصال بالإنترنت.';
                btn.disabled = false;
                btn.textContent = 'إرسال الطلب';
            }
        });
    }
});