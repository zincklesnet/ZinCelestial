/**
 * ZinCelestial Core JS v5.0.0
 * Scroll-to-top, scheme switcher, color mode toggle, BP AJAX hooks,
 * header sticky, mobile offcanvas, search offcanvas, tooltips, animations.
 */
(function () {
  'use strict';

  /* ─── SCROLL TO TOP ────────────────────────────────────────────── */
  var scrollBtn = document.getElementById('zc-scroll-top');
  if (scrollBtn) {
    window.addEventListener('scroll', function () {
      scrollBtn.classList.toggle('is-visible', window.scrollY > 400);
    }, { passive: true });
    scrollBtn.addEventListener('click', function () {
      window.scrollTo({ top: 0, behavior: 'smooth' });
    });
  }

  /* ─── STICKY HEADER ─────────────────────────────────────────────── */
  var header = document.querySelector('.zc-header');
  if (header) {
    var lastScroll = 0;
    window.addEventListener('scroll', function () {
      var current = window.scrollY;
      if (current > 80) {
        header.classList.add('zc-header--scrolled');
      } else {
        header.classList.remove('zc-header--scrolled');
      }
      // Hide on scroll down > 200, show on scroll up
      if (current > 200 && current > lastScroll) {
        header.classList.add('zc-header--hidden');
      } else {
        header.classList.remove('zc-header--hidden');
      }
      lastScroll = current;
    }, { passive: true });
  }

  /* ─── SCHEME SWITCHER ────────────────────────────────────────────── */
  function zcSetScheme(scheme) {
    document.documentElement.setAttribute('data-zc-scheme', scheme);
    localStorage.setItem('zc-scheme', scheme);
    // Sync all scheme buttons
    document.querySelectorAll('.zc-scheme-btn').forEach(function (btn) {
      btn.classList.toggle('zc-scheme-btn--active', btn.dataset.scheme === scheme);
    });
    // AJAX save if user logged in
    if (typeof ZC_Frontend !== 'undefined' && ZC_Frontend.is_user_logged_in) {
      var fd = new FormData();
      fd.append('action', 'zc_save_user_scheme');
      fd.append('nonce', ZC_Frontend.nonce);
      fd.append('scheme', scheme);
      fetch(ZC_Frontend.ajax_url, { method: 'POST', body: fd, credentials: 'same-origin' }).catch(function () {});
    }
  }

  /* ─── COLOR MODE TOGGLE ──────────────────────────────────────────── */
  function zcSetMode(mode) {
    document.documentElement.setAttribute('data-zc-mode', mode);
    localStorage.setItem('zc-mode', mode);
    document.querySelectorAll('.zc-mode-toggle-btn, .zc-mode-btn').forEach(function (btn) {
      btn.setAttribute('aria-pressed', btn.dataset.mode === mode ? 'true' : 'false');
    });
    var icon = document.querySelector('.zc-mode-icon');
    if (icon) icon.textContent = mode === 'light' ? '☀' : '🌙';
  }

  /* ─── INIT: SCHEME SWITCHER PANEL ────────────────────────────────── */
  function initSchemeSwitcher() {
    var toggle = document.querySelector('.zc-scheme-switcher__toggle');
    var panel  = document.querySelector('.zc-scheme-switcher__panel');
    if (!toggle || !panel) return;

    toggle.addEventListener('click', function () {
      var expanded = toggle.getAttribute('aria-expanded') === 'true';
      toggle.setAttribute('aria-expanded', !expanded);
      panel.classList.toggle('zc-scheme-switcher--open');
    });

    // Close on outside click
    document.addEventListener('click', function (e) {
      if (!toggle.contains(e.target) && !panel.contains(e.target)) {
        toggle.setAttribute('aria-expanded', 'false');
        panel.classList.remove('zc-scheme-switcher--open');
      }
    });

    // Scheme buttons
    document.querySelectorAll('.zc-scheme-btn').forEach(function (btn) {
      btn.addEventListener('click', function () {
        zcSetScheme(this.dataset.scheme);
      });
    });

    // Mode toggle buttons
    document.querySelectorAll('.zc-mode-btn').forEach(function (btn) {
      btn.addEventListener('click', function () {
        zcSetMode(this.dataset.mode);
      });
    });

    // Single toggle button (light/dark flip)
    var modeToggle = document.querySelector('.zc-mode-toggle');
    if (modeToggle) {
      modeToggle.addEventListener('click', function () {
        var current = document.documentElement.getAttribute('data-zc-mode') || 'dark';
        zcSetMode(current === 'dark' ? 'light' : 'dark');
      });
    }

    // Restore saved preferences
    var savedScheme = localStorage.getItem('zc-scheme');
    var savedMode   = localStorage.getItem('zc-mode');
    if (savedScheme) zcSetScheme(savedScheme);
    if (savedMode)   zcSetMode(savedMode);
    else {
      // Respect system preference
      var prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
      zcSetMode(prefersDark ? 'dark' : 'light');
    }
  }

  /* ─── COPY TO CLIPBOARD ──────────────────────────────────────────── */
  document.addEventListener('click', function (e) {
    var btn = e.target.closest('[data-copy]');
    if (!btn) return;
    var text = btn.dataset.copy;
    if (navigator.clipboard) {
      navigator.clipboard.writeText(text).then(function () {
        zcToastFront('✅ Copied!', 'success');
      });
    }
  });

  /* ─── SHARE BUTTONS ──────────────────────────────────────────────── */
  document.addEventListener('click', function (e) {
    var btn = e.target.closest('.zc-share-btn--copy');
    if (!btn) return;
    e.preventDefault();
    var url = btn.dataset.url || window.location.href;
    if (navigator.clipboard) {
      navigator.clipboard.writeText(url).then(function () {
        var orig = btn.innerHTML;
        btn.innerHTML = '✅ Copied!';
        setTimeout(function () { btn.innerHTML = orig; }, 2000);
      });
    }
  });

  /* ─── FRONT-END TOAST ────────────────────────────────────────────── */
  window.zcToastFront = function (msg, type) {
    type = type || 'info';
    var stack = document.querySelector('.zc-toast-stack');
    if (!stack) {
      stack = document.createElement('div');
      stack.className = 'zc-toast-stack';
      document.body.appendChild(stack);
    }
    var t = document.createElement('div');
    t.className = 'zc-toast zc-toast--' + type;
    t.innerHTML = '<span>' + msg + '</span>';
    stack.appendChild(t);
    setTimeout(function () {
      t.style.opacity = '0';
      t.style.transition = 'opacity .3s';
      setTimeout(function () { t.remove(); }, 400);
    }, 3000);
  };

  /* ─── BUDDYPRESS AJAX LOAD HELPERS ─────────────────────────────── */
  // Intercept BP AJAX pagination links
  document.addEventListener('click', function (e) {
    var link = e.target.closest('[data-bp-ajax]');
    if (!link) return;
    e.preventDefault();
    var container = document.querySelector(link.dataset.bpTarget || '.bp-ajax-target');
    if (!container) return;
    container.style.opacity = '.5';
    container.style.pointerEvents = 'none';
    fetch(link.href, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
      .then(function (r) { return r.text(); })
      .then(function (html) {
        var parser = new DOMParser();
        var doc    = parser.parseFromString(html, 'text/html');
        var inner  = doc.querySelector(link.dataset.bpTarget || '.bp-ajax-target');
        if (inner) {
          container.innerHTML = inner.innerHTML;
        }
        container.style.opacity = '1';
        container.style.pointerEvents = '';
        window.scrollTo({ top: container.offsetTop - 80, behavior: 'smooth' });
      })
      .catch(function () {
        container.style.opacity = '1';
        container.style.pointerEvents = '';
      });
  });

  /* ─── SCROLL-REVEAL (simple IntersectionObserver) ─────────────── */
  if ('IntersectionObserver' in window) {
    var revealObs = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          entry.target.classList.add('zc-revealed');
          revealObs.unobserve(entry.target);
        }
      });
    }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });

    document.querySelectorAll('.zc-reveal').forEach(function (el) {
      revealObs.observe(el);
    });
  }

  /* ─── COMMENT FORM TOGGLE ────────────────────────────────────────── */
  document.addEventListener('click', function (e) {
    var rep = e.target.closest('.comment-reply-link');
    if (!rep) return;
    // BP/WP handles the actual move; we just scroll smoothly
    setTimeout(function () {
      var form = document.getElementById('respond');
      if (form) form.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }, 100);
  });

  /* ─── TOOLTIP INIT (Bootstrap 5) ─────────────────────────────────── */
  function initTooltips() {
    if (typeof bootstrap === 'undefined') return;
    document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(function (el) {
      if (!el._bsTooltip) el._bsTooltip = new bootstrap.Tooltip(el);
    });
  }

  /* ─── SEARCH FORM EXPAND ─────────────────────────────────────────── */
  var searchTrigger = document.getElementById('zc-search-trigger');
  if (searchTrigger) {
    searchTrigger.addEventListener('click', function () {
      var offcanvas = document.getElementById('zcSearchOffcanvas');
      if (offcanvas && typeof bootstrap !== 'undefined') {
        var oc = bootstrap.Offcanvas.getOrCreateInstance(offcanvas);
        oc.show();
        setTimeout(function () {
          var inp = offcanvas.querySelector('.zc-input, input[type="search"]');
          if (inp) inp.focus();
        }, 300);
      }
    });
  }

  /* ─── MOBILE NAV ACTIVE STATE ────────────────────────────────────── */
  var currentUrl = window.location.href;
  document.querySelectorAll('.zc-primary-nav .nav-link, .zc-offcanvas-nav .nav-link').forEach(function (link) {
    if (link.href && currentUrl.includes(link.href) && link.href !== window.location.origin + '/') {
      link.classList.add('active');
      link.setAttribute('aria-current', 'page');
    }
  });

  /* ─── WP ADMIN BAR OFFSET ────────────────────────────────────────── */
  function adjustForAdminBar() {
    var bar = document.getElementById('wpadminbar');
    if (bar) {
      var h = bar.offsetHeight;
      document.documentElement.style.setProperty('--zc-adminbar-h', h + 'px');
      document.querySelector('.zc-header--sticky, .zc-header[style*="sticky"]');
    }
  }

  /* ─── DOM READY ──────────────────────────────────────────────────── */
  document.addEventListener('DOMContentLoaded', function () {
    initSchemeSwitcher();
    initTooltips();
    adjustForAdminBar();

    // Lucide icons init (if library loaded)
    if (typeof lucide !== 'undefined') lucide.createIcons();

    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(function (a) {
      a.addEventListener('click', function (e) {
        var target = document.querySelector(this.getAttribute('href'));
        if (target) {
          e.preventDefault();
          target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
      });
    });

    // Image lazy load fallback
    document.querySelectorAll('img[loading="lazy"]').forEach(function (img) {
      if (!img.complete) {
        img.classList.add('zc-skeleton');
        img.addEventListener('load', function () { this.classList.remove('zc-skeleton'); });
      }
    });
  });

})();
