/**
 * ZinCelestial Color Mode JS v5.0.0
 * Handles light/dark persistence, system-preference detection,
 * scheme persistence, and smooth transitions.
 * Runs BEFORE DOMContentLoaded to prevent flash of wrong theme.
 */
(function () {
  'use strict';

  var SCHEME_KEY = 'zc-scheme';
  var MODE_KEY   = 'zc-mode';

  /* ─── Apply stored preferences immediately (before paint) ── */
  function applyEarly() {
    var scheme = localStorage.getItem(SCHEME_KEY);
    var mode   = localStorage.getItem(MODE_KEY);

    // If no mode saved, respect system preference
    if (!mode) {
      mode = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
    }

    var html = document.documentElement;
    if (scheme) html.setAttribute('data-zc-scheme', scheme);
    html.setAttribute('data-zc-mode', mode);

    // Also set BS theme attribute for Bootstrap components
    html.setAttribute('data-bs-theme', mode === 'light' ? 'light' : 'dark');
  }

  applyEarly();

  /* ─── Watch system preference changes ──────────────────────── */
  var mql = window.matchMedia('(prefers-color-scheme: dark)');
  mql.addEventListener('change', function (e) {
    // Only apply system preference if user hasn't manually set one
    if (!localStorage.getItem(MODE_KEY)) {
      var m = e.matches ? 'dark' : 'light';
      document.documentElement.setAttribute('data-zc-mode', m);
      document.documentElement.setAttribute('data-bs-theme', m === 'light' ? 'light' : 'dark');
      updateModeUI(m);
    }
  });

  /* ─── Update mode toggle UI elements ────────────────────────── */
  function updateModeUI(mode) {
    document.querySelectorAll('.zc-mode-icon').forEach(function (el) {
      el.textContent = mode === 'light' ? '☀' : '🌙';
    });
    document.querySelectorAll('[data-mode-toggle]').forEach(function (el) {
      el.setAttribute('aria-pressed', 'false');
    });
    document.querySelectorAll('[data-mode="' + mode + '"]').forEach(function (el) {
      el.setAttribute('aria-pressed', 'true');
    });
    var checkbox = document.querySelector('#zc-mode-checkbox');
    if (checkbox) checkbox.checked = (mode === 'light');
  }

  /* ─── Public API ─────────────────────────────────────────────── */
  window.ZCColorMode = {

    setMode: function (mode) {
      localStorage.setItem(MODE_KEY, mode);
      document.documentElement.setAttribute('data-zc-mode', mode);
      document.documentElement.setAttribute('data-bs-theme', mode === 'light' ? 'light' : 'dark');
      updateModeUI(mode);
      this._saveToServer({ color_mode: mode });
    },

    toggleMode: function () {
      var current = document.documentElement.getAttribute('data-zc-mode') || 'dark';
      this.setMode(current === 'dark' ? 'light' : 'dark');
    },

    setScheme: function (scheme) {
      localStorage.setItem(SCHEME_KEY, scheme);
      document.documentElement.setAttribute('data-zc-scheme', scheme);
      document.querySelectorAll('.zc-scheme-btn').forEach(function (btn) {
        btn.classList.toggle('zc-scheme-btn--active', btn.dataset.scheme === scheme);
        btn.setAttribute('aria-pressed', btn.dataset.scheme === scheme ? 'true' : 'false');
      });
      this._saveToServer({ scheme: scheme });
    },

    getMode: function () {
      return document.documentElement.getAttribute('data-zc-mode') || 'dark';
    },

    getScheme: function () {
      return document.documentElement.getAttribute('data-zc-scheme') || 'default';
    },

    _saveToServer: function (data) {
      if (typeof ZC_Frontend === 'undefined' || !ZC_Frontend.is_user_logged_in) return;
      var fd = new FormData();
      fd.append('action', 'zc_save_user_pref');
      fd.append('nonce', ZC_Frontend.nonce);
      Object.keys(data).forEach(function (k) { fd.append(k, data[k]); });
      fetch(ZC_Frontend.ajax_url, {
        method: 'POST',
        body: fd,
        credentials: 'same-origin'
      }).catch(function () {});
    }
  };

  /* ─── DOM-ready: wire up all toggle elements ─────────────────── */
  document.addEventListener('DOMContentLoaded', function () {

    // Single toggle button (flip dark↔light)
    document.querySelectorAll('.zc-mode-toggle, [data-mode-toggle="flip"]').forEach(function (el) {
      el.addEventListener('click', function () {
        window.ZCColorMode.toggleMode();
      });
    });

    // Explicit mode buttons (data-mode="light" / data-mode="dark")
    document.querySelectorAll('[data-mode]').forEach(function (el) {
      el.addEventListener('click', function () {
        var m = this.dataset.mode;
        if (m === 'light' || m === 'dark') window.ZCColorMode.setMode(m);
      });
    });

    // Checkbox toggle (checked = light)
    var modeChk = document.querySelector('#zc-mode-checkbox');
    if (modeChk) {
      modeChk.addEventListener('change', function () {
        window.ZCColorMode.setMode(this.checked ? 'light' : 'dark');
      });
    }

    // Scheme buttons
    document.querySelectorAll('[data-scheme]').forEach(function (el) {
      el.addEventListener('click', function () {
        window.ZCColorMode.setScheme(this.dataset.scheme);
      });
    });

    // Sync UI to current state
    var currentMode   = window.ZCColorMode.getMode();
    var currentScheme = window.ZCColorMode.getScheme();
    updateModeUI(currentMode);
    document.querySelectorAll('.zc-scheme-btn').forEach(function (btn) {
      btn.classList.toggle('zc-scheme-btn--active', btn.dataset.scheme === currentScheme);
    });

    // Expose switcher toggle panel behaviour
    var switcher = document.querySelector('.zc-scheme-switcher');
    var switcherToggle = switcher && switcher.querySelector('.zc-scheme-switcher__toggle');
    var switcherPanel  = switcher && switcher.querySelector('.zc-scheme-switcher__panel');
    if (switcherToggle && switcherPanel) {
      switcherToggle.addEventListener('click', function () {
        var open = switcher.classList.toggle('zc-scheme-switcher--open');
        this.setAttribute('aria-expanded', open ? 'true' : 'false');
      });
      document.addEventListener('click', function (e) {
        if (switcher && !switcher.contains(e.target)) {
          switcher.classList.remove('zc-scheme-switcher--open');
          switcherToggle.setAttribute('aria-expanded', 'false');
        }
      });
    }
  });

})();
