/**
 * CB Mishra Portfolio – main.js
 * Fixes: dark default theme, mobile nav, smooth scroll, AJAX forms, scroll reveal
 */
(function () {
  'use strict';

  /* ======================================================
     1. THEME: DEFAULT = DARK, persists in localStorage
     ====================================================== */
  var html      = document.documentElement;
  var themeBtn  = document.getElementById('theme-toggle');
  var themeIcon = document.getElementById('theme-icon');
  var THEME_KEY = 'cbmishra_theme';

  function applyTheme(theme) {
    html.setAttribute('data-theme', theme);
    if (themeIcon) themeIcon.textContent = theme === 'dark' ? '🌙' : '☀️';
    try { localStorage.setItem(THEME_KEY, theme); } catch (e) {}
  }

  // On load: honour saved pref; if none → always start dark
  (function () {
    var saved;
    try { saved = localStorage.getItem(THEME_KEY); } catch (e) {}
    applyTheme(saved === 'light' ? 'light' : 'dark');
  })();

  if (themeBtn) {
    themeBtn.addEventListener('click', function () {
      applyTheme(html.getAttribute('data-theme') === 'dark' ? 'light' : 'dark');
    });
  }

  /* ======================================================
     2. HEADER SCROLL EFFECT
     ====================================================== */
  var header = document.getElementById('site-header');
  function syncHeader() {
    if (!header) return;
    header.classList.toggle('scrolled', window.scrollY > 20);
  }
  window.addEventListener('scroll', syncHeader, { passive: true });
  syncHeader();

  /* ======================================================
     3. ACTIVE NAV LINK (scroll spy – only on front page)
     ====================================================== */
  var navLinks = document.querySelectorAll('#primary-nav .nav-link, #mobile-nav .nav-link');
  var sections = document.querySelectorAll('section[id]');

  if (sections.length) {
    function updateActive() {
      var current = '';
      sections.forEach(function (s) {
        if (s.getBoundingClientRect().top <= 100) current = s.id;
      });
      navLinks.forEach(function (a) {
        var href = a.getAttribute('href') || '';
        a.classList.toggle('active', href === '#' + current);
      });
    }
    window.addEventListener('scroll', updateActive, { passive: true });
  }

  /* ======================================================
     4. MOBILE NAVIGATION TOGGLE
     ====================================================== */
  var mobileToggle = document.getElementById('mobile-toggle');
  var mobileNav    = document.getElementById('mobile-nav');
  var isOpen       = false;

  function setMobile(open) {
    isOpen = open;
    if (!mobileNav) return;
    mobileNav.classList.toggle('open', open);
    if (mobileToggle) {
      mobileToggle.setAttribute('aria-expanded', String(open));
      var spans = mobileToggle.querySelectorAll('span');
      spans[0].style.transform = open ? 'rotate(45deg) translate(5px, 5px)' : '';
      spans[1].style.opacity   = open ? '0' : '';
      spans[2].style.transform = open ? 'rotate(-45deg) translate(5px, -5px)' : '';
    }
    document.body.style.overflow = open ? 'hidden' : '';
  }

  if (mobileToggle) mobileToggle.addEventListener('click', function () { setMobile(!isOpen); });
  if (mobileNav) {
    mobileNav.querySelectorAll('a').forEach(function (a) {
      a.addEventListener('click', function () { setMobile(false); });
    });
  }
  document.addEventListener('click', function (e) {
    if (isOpen && mobileNav && !mobileNav.contains(e.target) && mobileToggle && !mobileToggle.contains(e.target)) {
      setMobile(false);
    }
  });
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' && isOpen) setMobile(false);
  });

  /* ======================================================
     5. SMOOTH SCROLL for anchor links (works same/cross page)
     ====================================================== */
  document.addEventListener('click', function (e) {
    var a = e.target.closest('a[href]');
    if (!a) return;
    var href = a.getAttribute('href') || '';

    // Is it a pure hash? (#section)
    if (/^#[^#]/.test(href)) {
      var id     = href.slice(1);
      var target = document.getElementById(id);
      if (target) {
        e.preventDefault();
        var hh  = parseInt(getComputedStyle(html).getPropertyValue('--header-height')) || 72;
        var top = target.getBoundingClientRect().top + window.pageYOffset - hh - 16;
        window.scrollTo({ top: top, behavior: 'smooth' });
      }
      return;
    }

    // Is it a home-page URL with a hash? (http://site.com/#section)
    var base = (window.cbmishraData && window.cbmishraData.homeUrl) || (location.protocol + '//' + location.host + '/');
    if (href.startsWith(base) && href.includes('#')) {
      var hash = href.split('#')[1];
      if (hash) {
        var el = document.getElementById(hash);
        if (el) {
          e.preventDefault();
          var hh2 = parseInt(getComputedStyle(html).getPropertyValue('--header-height')) || 72;
          window.scrollTo({ top: el.getBoundingClientRect().top + window.pageYOffset - hh2 - 16, behavior: 'smooth' });
          return;
        }
      }
    }
  });

  /* ======================================================
     6. SCROLL REVEAL
     ====================================================== */
  function initReveal() {
    var els = document.querySelectorAll('.reveal');
    if (!els.length) return;

    // Respect reduced motion
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
      els.forEach(function (el) { el.classList.add('visible'); });
      return;
    }

    if ('IntersectionObserver' in window) {
      var obs = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) {
            entry.target.classList.add('visible');
            obs.unobserve(entry.target);
          }
        });
      }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });
      els.forEach(function (el) { obs.observe(el); });
    } else {
      els.forEach(function (el) { el.classList.add('visible'); });
    }
  }
  initReveal();

  /* ======================================================
     7. COUNTER ANIMATION
     ====================================================== */
  function animateCounters() {
    var counters = document.querySelectorAll('.hero-stat-number');
    if (!counters.length || !('IntersectionObserver' in window)) return;

    var obs = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (!entry.isIntersecting) return;
        var el   = entry.target;
        var text = el.textContent.trim();
        var m    = text.match(/^(\d+)([+%]?)$/);
        if (!m) return;
        var target   = parseInt(m[1], 10);
        var suffix   = m[2] || '';
        var start    = performance.now();
        var dur      = 1600;

        (function tick(now) {
          var p   = Math.min((now - start) / dur, 1);
          var val = Math.floor((1 - Math.pow(1 - p, 3)) * target);
          el.textContent = val + suffix;
          if (p < 1) requestAnimationFrame(tick);
          else el.textContent = target + suffix;
        })(start);

        obs.unobserve(el);
      });
    }, { threshold: 0.5 });

    counters.forEach(function (el) { obs.observe(el); });
  }
  animateCounters();

  /* ======================================================
     8. AJAX FORM HANDLER (generic)
     ====================================================== */
  function bindForm(formId, action, successId) {
    var form = document.getElementById(formId);
    if (!form) return;

    form.addEventListener('submit', function (e) {
      e.preventDefault();

      // Validate required fields
      var valid = true;
      form.querySelectorAll('[required]').forEach(function (f) {
        f.style.borderColor = '';
        if (!f.value.trim()) {
          valid = false;
          f.style.borderColor = 'var(--accent-hire)';
          f.addEventListener('input', function () { this.style.borderColor = ''; }, { once: true });
        }
      });
      if (!valid) {
        var firstBad = form.querySelector('[required]');
        if (firstBad) firstBad.focus();
        return;
      }

      var btn      = form.querySelector('[type="submit"]');
      var btnText  = btn && btn.querySelector('.btn-text');
      var btnLoad  = btn && btn.querySelector('.btn-loading');
      var successEl = document.getElementById(successId);

      if (btn) btn.disabled = true;
      if (btnText) btnText.style.display = 'none';
      if (btnLoad) btnLoad.style.display = '';

      var data = new FormData(form);
      data.append('action', action);
      data.append('nonce', (window.cbmishraData && window.cbmishraData.nonce) || '');

      fetch((window.cbmishraData && window.cbmishraData.ajaxUrl) || '/wp-admin/admin-ajax.php', {
        method: 'POST',
        body: data,
        credentials: 'same-origin',
      })
        .then(function (r) { return r.json(); })
        .then(function (res) {
          if (res.success) {
            form.reset();
            if (successEl) {
              successEl.textContent = res.data.message;
              successEl.style.display = 'block';
              successEl.style.background = 'rgba(0,212,255,0.08)';
              successEl.style.border = '1px solid var(--border-strong)';
              successEl.style.color = 'var(--accent-primary)';
              successEl.style.padding = '14px 18px';
              successEl.style.borderRadius = '10px';
              successEl.style.fontWeight = '500';
              successEl.style.marginBottom = '20px';
              setTimeout(function () { successEl.style.display = 'none'; }, 10000);
            }
          } else {
            var msg = (res.data && res.data.message) ? res.data.message : 'Something went wrong. Please try again.';
            if (successEl) {
              successEl.textContent = '⚠️ ' + msg;
              successEl.style.display = 'block';
              successEl.style.background = 'rgba(255,107,53,0.08)';
              successEl.style.border = '1px solid rgba(255,107,53,0.3)';
              successEl.style.color = '#FF8A5C';
              successEl.style.padding = '14px 18px';
              successEl.style.borderRadius = '10px';
              successEl.style.marginBottom = '20px';
            } else {
              alert(msg);
            }
          }
        })
        .catch(function () {
          alert('Network error. Please check your connection and try again, or email directly.');
        })
        .finally(function () {
          if (btn) btn.disabled = false;
          if (btnText) btnText.style.display = '';
          if (btnLoad) btnLoad.style.display = 'none';
        });
    });
  }

  bindForm('hire-me-form',      'cbmishra_hire_form', 'hire-success');
  bindForm('appointment-form',  'cbmishra_appointment', 'appt-success');

})();
