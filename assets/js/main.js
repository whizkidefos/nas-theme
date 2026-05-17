/**
 * NAS Theme — Main JavaScript
 * National Association of Seadogs (Pyrates Confraternity)
 */

(function () {
    'use strict';

    // ============================================================
    // HEADER SCROLL
    // ============================================================
    const header = document.getElementById('nasHeader');
    if (header) {
        window.addEventListener('scroll', () => {
            header.classList.toggle('scrolled', window.scrollY > 50);
        }, { passive: true });
    }

    // ============================================================
    // MOBILE NAV
    // ============================================================
    const hamburger = document.getElementById('nasHamburger');
    const mobileNav = document.getElementById('nasMobileNav');
    if (hamburger && mobileNav) {
        hamburger.addEventListener('click', () => {
            const isOpen = mobileNav.classList.toggle('open');
            hamburger.classList.toggle('active', isOpen);
            hamburger.setAttribute('aria-expanded', isOpen);
            document.body.style.overflow = isOpen ? 'hidden' : '';
        });
    }

    // ============================================================
    // HERO CANVAS — Particle field
    // ============================================================
    const canvas = document.getElementById('nasHeroCanvas');
    if (canvas) {
        const ctx = canvas.getContext('2d');
        let particles = [];
        let animFrame;

        function resizeCanvas() {
            canvas.width  = canvas.offsetWidth;
            canvas.height = canvas.offsetHeight;
        }

        function createParticles() {
            particles = [];
            const count = Math.floor((canvas.width * canvas.height) / 12000);
            for (let i = 0; i < count; i++) {
                particles.push({
                    x:  Math.random() * canvas.width,
                    y:  Math.random() * canvas.height,
                    vx: (Math.random() - 0.5) * 0.4,
                    vy: (Math.random() - 0.5) * 0.4,
                    r:  Math.random() * 2 + 0.5,
                    a:  Math.random() * 0.5 + 0.1,
                    gold: Math.random() > 0.7,
                });
            }
        }

        function drawParticles() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            particles.forEach(p => {
                ctx.beginPath();
                ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
                ctx.fillStyle = p.gold
                    ? `rgba(255,221,0,${p.a})`
                    : `rgba(150,5,13,${p.a})`;
                ctx.fill();

                p.x += p.vx;
                p.y += p.vy;
                if (p.x < 0) p.x = canvas.width;
                if (p.x > canvas.width) p.x = 0;
                if (p.y < 0) p.y = canvas.height;
                if (p.y > canvas.height) p.y = 0;
            });

            // Draw connecting lines
            for (let i = 0; i < particles.length; i++) {
                for (let j = i + 1; j < particles.length; j++) {
                    const dx = particles[i].x - particles[j].x;
                    const dy = particles[i].y - particles[j].y;
                    const dist = Math.sqrt(dx * dx + dy * dy);
                    if (dist < 100) {
                        ctx.beginPath();
                        ctx.moveTo(particles[i].x, particles[i].y);
                        ctx.lineTo(particles[j].x, particles[j].y);
                        ctx.strokeStyle = `rgba(150,5,13,${0.08 * (1 - dist / 100)})`;
                        ctx.lineWidth = 0.5;
                        ctx.stroke();
                    }
                }
            }

            animFrame = requestAnimationFrame(drawParticles);
        }

        resizeCanvas();
        createParticles();
        drawParticles();

        window.addEventListener('resize', () => {
            resizeCanvas();
            createParticles();
        }, { passive: true });
    }

    // ============================================================
    // SMOOTH SCROLL — History page anchors
    // ============================================================
    document.querySelectorAll('a[href^="#"]').forEach(link => {
        link.addEventListener('click', e => {
            const target = document.querySelector(link.getAttribute('href'));
            if (target) {
                e.preventDefault();
                const offset = 100;
                window.scrollTo({ top: target.offsetTop - offset, behavior: 'smooth' });

                // Update nav active state
                document.querySelectorAll('.nas-history-nav-link').forEach(l => l.classList.remove('active'));
                link.classList.add('active');
            }
        });
    });

    // History nav active on scroll
    const historySections = ['our-story', 'philosophy', 'structure'];
    if (historySections.some(id => document.getElementById(id))) {
        window.addEventListener('scroll', () => {
            let current = '';
            historySections.forEach(id => {
                const el = document.getElementById(id);
                if (el && window.scrollY >= el.offsetTop - 150) current = id;
            });
            document.querySelectorAll('.nas-history-nav-link').forEach(link => {
                link.classList.toggle('active', link.getAttribute('href') === '#' + current);
            });
        }, { passive: true });
    }

    // ============================================================
    // TABS (frontend)
    // ============================================================
    document.querySelectorAll('.nas-tabs, .nas-itt-tabs').forEach(tabGroup => {
        const tabs = tabGroup.querySelectorAll('.nas-tab');
        tabs.forEach((tab, i) => {
            tab.addEventListener('click', () => {
                tabs.forEach(t => { t.classList.remove('active'); t.setAttribute('aria-selected','false'); });
                tab.classList.add('active');
                tab.setAttribute('aria-selected','true');

                const tabId = tab.dataset.tab;
                const parent = tabGroup.parentElement;
                parent.querySelectorAll('.nas-tab-content').forEach(content => {
                    content.classList.toggle('active', content.id === 'tab-' + tabId);
                });
            });
        });
    });

    // ============================================================
    // ACCORDION
    // ============================================================
    document.querySelectorAll('.nas-accordion-trigger').forEach(trigger => {
        trigger.addEventListener('click', () => {
            const expanded = trigger.getAttribute('aria-expanded') === 'true';
            const answer = trigger.nextElementSibling;

            // Close siblings
            trigger.closest('.nas-questions-accordion')
                ?.querySelectorAll('.nas-accordion-trigger')
                .forEach(t => {
                    t.setAttribute('aria-expanded', 'false');
                    t.nextElementSibling?.classList.remove('open');
                });

            if (!expanded) {
                trigger.setAttribute('aria-expanded', 'true');
                answer.classList.add('open');
            }
        });
    });

    // ============================================================
    // DECK FILTER
    // ============================================================
    const filterBtns = document.querySelectorAll('.nas-filter-btn');
    const deckCards  = document.querySelectorAll('.nas-deck-card');
    if (filterBtns.length && deckCards.length) {
        filterBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                filterBtns.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');

                const filter = btn.dataset.filter;
                deckCards.forEach(card => {
                    const show = filter === 'all' || card.dataset.country === filter;
                    card.classList.toggle('hidden', !show);
                    card.style.animation = show ? 'fadeInUp 0.4s ease both' : '';
                });
            });
        });
    }

    // ============================================================
    // QUIZ
    // ============================================================
    const quiz = document.getElementById('nasQuiz');
    if (quiz) {
        let currentQ = 0;
        let score = 0;
        let answered = false;
        const total = parseInt(quiz.dataset.total);
        const progress = document.getElementById('nasQuizProgress');
        const qNum = document.getElementById('nasQNum');

        function updateProgress() {
            if (progress) progress.style.width = ((currentQ + 1) / total * 100) + '%';
            if (qNum) qNum.textContent = currentQ + 1;
        }

        function goToQ(index) {
            quiz.querySelectorAll('.nas-quiz-q').forEach((q, i) => {
                q.classList.toggle('active', i === index);
            });
            currentQ = index;
            answered = false;
            updateProgress();
        }

        quiz.querySelectorAll('.nas-quiz-option').forEach(btn => {
            btn.addEventListener('click', function () {
                const qEl = this.closest('.nas-quiz-q');
                if (qEl.dataset.answered === 'true') return;
                qEl.dataset.answered = 'true';

                const correct = qEl.dataset.correct;
                const chosen = this.dataset.letter;

                qEl.querySelectorAll('.nas-quiz-option').forEach(b => {
                    b.classList.add('disabled');
                    if (b.dataset.letter === correct) b.classList.add('correct');
                });

                if (chosen === correct) {
                    score++;
                    this.classList.add('correct');
                } else {
                    this.classList.add('wrong');
                }

                const explanation = qEl.querySelector('.nas-quiz-explanation');
                if (explanation) explanation.style.display = 'block';
            });
        });

        quiz.querySelectorAll('.nas-quiz-next').forEach(btn => {
            btn.addEventListener('click', () => {
                const nextIdx = currentQ + 1;
                if (nextIdx < total) goToQ(nextIdx);
            });
        });

        quiz.querySelectorAll('.nas-quiz-prev').forEach(btn => {
            btn.addEventListener('click', () => {
                if (currentQ > 0) goToQ(currentQ - 1);
            });
        });

        quiz.querySelectorAll('.nas-quiz-finish').forEach(btn => {
            btn.addEventListener('click', () => {
                document.getElementById('nasQuizQuestions').style.display = 'none';
                const results = document.getElementById('nasQuizResults');
                results.style.display = 'block';
                document.getElementById('nasQuizScore').textContent = score;
                const feedback = document.getElementById('nasQuizFeedback');
                const pct = score / total;
                if (pct >= 0.8) {
                    feedback.textContent = '⚓ Excellent! You know your NAS history well. Non Nobis Solum!';
                    feedback.style.color = '#4ade80';
                } else if (pct >= 0.5) {
                    feedback.textContent = 'Good effort, Pyrate! Study a bit more and try again.';
                    feedback.style.color = '#FFDD00';
                } else {
                    feedback.textContent = 'Keep studying. Every great Seadog started somewhere.';
                    feedback.style.color = '#ff6b6b';
                }
            });
        });

        document.getElementById('nasQuizRetry')?.addEventListener('click', () => {
            score = 0; currentQ = 0;
            quiz.querySelectorAll('.nas-quiz-q').forEach(q => {
                q.dataset.answered = 'false';
                q.querySelectorAll('.nas-quiz-option').forEach(b => {
                    b.classList.remove('correct','wrong','disabled');
                });
                q.querySelectorAll('.nas-quiz-explanation').forEach(e => e.style.display = 'none');
            });
            document.getElementById('nasQuizResults').style.display = 'none';
            document.getElementById('nasQuizQuestions').style.display = 'block';
            goToQ(0);
        });

        updateProgress();
    }

    // ============================================================
    // COUNTDOWN TIMER
    // ============================================================
    const countdown = document.getElementById('nasCountdown');
    if (countdown) {
        const target = new Date(countdown.dataset.target).getTime();
        const daysEl  = document.getElementById('countDays');
        const hoursEl = document.getElementById('countHours');
        const minsEl  = document.getElementById('countMins');
        const secsEl  = document.getElementById('countSecs');

        function updateCountdown() {
            const now  = Date.now();
            const diff = target - now;
            if (diff <= 0) {
                location.reload();
                return;
            }
            const d = Math.floor(diff / 86400000);
            const h = Math.floor((diff % 86400000) / 3600000);
            const m = Math.floor((diff % 3600000) / 60000);
            const s = Math.floor((diff % 60000) / 1000);
            if (daysEl)  daysEl.textContent  = String(d).padStart(2, '0');
            if (hoursEl) hoursEl.textContent = String(h).padStart(2, '0');
            if (minsEl)  minsEl.textContent  = String(m).padStart(2, '0');
            if (secsEl)  secsEl.textContent  = String(s).padStart(2, '0');
        }
        updateCountdown();
        setInterval(updateCountdown, 1000);
    }

    // ============================================================
    // AJAX FORM HELPER
    // ============================================================
    function submitAjaxForm(formId, msgId, action, onSuccess) {
        const form = document.getElementById(formId);
        const msgEl = document.getElementById(msgId);
        if (!form) return;

        form.addEventListener('submit', async function (e) {
            e.preventDefault();
            if (msgEl) { msgEl.className = 'nas-form-message'; msgEl.textContent = ''; }

            const submitBtn = form.querySelector('[type=submit]');
            const btnText   = form.querySelector('.nas-btn-text');
            const btnLoad   = form.querySelector('.nas-btn-loading');

            if (submitBtn) submitBtn.disabled = true;
            if (btnText)   btnText.style.display = 'none';
            if (btnLoad)   btnLoad.style.display = 'inline';

            const data = new FormData(form);
            data.append('action', action);
            data.append('nonce', NAS.nonce);

            try {
                const res = await fetch(NAS.ajaxUrl, { method: 'POST', body: data });
                const json = await res.json();

                if (json.success) {
                    if (msgEl) {
                        msgEl.className = 'nas-form-message success';
                        msgEl.textContent = json.data.message;
                    }
                    if (onSuccess) onSuccess(form, json);
                    form.reset();
                } else {
                    if (msgEl) {
                        msgEl.className = 'nas-form-message error';
                        msgEl.textContent = json.data.message || 'An error occurred. Please try again.';
                    }
                }
            } catch (err) {
                if (msgEl) {
                    msgEl.className = 'nas-form-message error';
                    msgEl.textContent = 'Network error. Please check your connection and try again.';
                }
            } finally {
                if (submitBtn) submitBtn.disabled = false;
                if (btnText)   btnText.style.display = '';
                if (btnLoad)   btnLoad.style.display = 'none';
            }
        });
    }

    // Application form
    submitAjaxForm('nasApplicationForm', 'nasAppMessage', 'nas_submit_application', (form) => {
        form.closest('.nas-join-form-wrap').innerHTML = `
            <div class="nas-success-wrap" style="text-align:center;padding:64px 32px">
                <div style="font-size:60px;margin-bottom:24px">⚓</div>
                <h3 style="font-family:var(--font-display);font-size:1.8rem;color:var(--nas-gold);margin-bottom:16px">Application Received!</h3>
                <p style="color:var(--nas-gray-light)">Thank you for applying to the National Association of Seadogs. 
                A confirmation has been sent to your email. We will be in touch shortly.</p>
                <p style="margin-top:16px;font-style:italic;color:var(--nas-red)">Non Nobis Solum.</p>
            </div>`;
    });

    // Newsletter forms
    ['nasNewsletterForm', 'nasSidebarNL', 'nasJoinNL'].forEach((id, i) => {
        const msgIds = ['nasNLMessage', 'nasSidebarNLMsg', 'nasJoinNLMsg'];
        submitAjaxForm(id, msgIds[i], 'nas_newsletter');
    });

    // ============================================================
    // INTERSECT OBSERVER — Animate on scroll
    // ============================================================
    if ('IntersectionObserver' in window) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('.nas-project-card, .nas-news-card, .nas-deck-card, .nas-tenet-card, .nas-timeline-content').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(30px)';
            el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(el);
        });
    }

})();
