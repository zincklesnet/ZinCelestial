/**
 * ZinCelestial v5.2.0 — Admin Panel JavaScript
 *
 * FIXES v5.2.0:
 *  - Tab system: data-zc-tab / data-zc-panel fully working
 *  - jQuery loaded BEFORE this script (dependency chain in enqueue.php confirmed)
 *  - Auto-save with 800ms debounce
 *  - Section reset buttons (AJAX)
 *  - Export / Import JSON
 *  - WP Color Picker sync
 *  - Range slider live display
 *  - Toggle module show/hide
 *  - WP Media image pickers
 *  - Ctrl+S save shortcut
 *  - Toast notifications (top-right)
 *  - Safe mode toggle with dedicated nonce
 *  - Copy snippet to clipboard
 *  - Accordion sections
 */

/* global ZCA, jQuery, wp */
(function ($) {
    'use strict';

    // ─── Tab System ──────────────────────────────────────────────────────────────
    function zcInitTabs() {
        // Click handler on any [data-zc-tab] trigger
        $(document).on('click', '[data-zc-tab]', function (e) {
            e.preventDefault();
            var target  = $(this).data('zc-tab');
            var $wrap   = $(this).closest('.zca-tabs-wrapper, [data-zc-tabs], .zca-tab-group');

            // Deactivate all triggers + hide all panels within this wrapper
            if ($wrap.length) {
                $wrap.find('[data-zc-tab]').removeClass('active zca-tab-btn--active');
                $wrap.find('[data-zc-panel]').removeClass('active').hide();
            } else {
                // Global fallback
                $('[data-zc-tab="' + target + '"]').closest('.zca-tabs-nav')
                    .find('[data-zc-tab]').removeClass('active zca-tab-btn--active');
                // Find the nearest panel container
                var $panelContainer = $('[data-zc-panel="' + target + '"]').closest('.zca-tab-panels, .zca-panels');
                $panelContainer.find('[data-zc-panel]').removeClass('active').hide();
            }

            // Activate clicked trigger
            $(this).addClass('active zca-tab-btn--active');

            // Show target panel
            $('[data-zc-panel="' + target + '"]').addClass('active').show();
        });

        // Auto-activate first tab in every wrapper on page load
        $('.zca-tabs-wrapper, [data-zc-tabs], .zca-tab-group').each(function () {
            var $first = $(this).find('[data-zc-tab]').first();
            if ($first.length && !$(this).find('[data-zc-tab].active').length) {
                $first.trigger('click');
            }
        });
    }

    // ─── Collect all options from the page ──────────────────────────────────────
    function zcCollectOptions() {
        var opts = {};
        $('.zca-wrap :input[name]').each(function () {
            var $el  = $(this);
            var name = $el.attr('name');
            if (!name) return;
            // Strip wrapper: options[key] → key
            var clean = name.replace(/^[^\[]+\[/, '').replace(/\]$/, '');
            if (!clean) clean = name;
            if ($el.is(':checkbox')) {
                opts[clean] = $el.is(':checked') ? '1' : '0';
            } else if ($el.is(':radio')) {
                if ($el.is(':checked')) opts[clean] = $el.val();
            } else {
                opts[clean] = $el.val();
            }
        });
        return opts;
    }

    // ─── Save options via AJAX ───────────────────────────────────────────────────
    var saveTimer;

    function zcSaveOptions(showToast) {
        var opts = zcCollectOptions();
        $.ajax({
            url:    ZCA.ajaxUrl,
            method: 'POST',
            data: {
                action:  'zca_save_options',
                nonce:   ZCA.nonce,
                options: JSON.stringify(opts),
            },
            success: function (res) {
                if (showToast !== false) {
                    zcToast(res.success ? '✓ Settings saved' : '✗ Save failed', res.success ? 'success' : 'danger');
                }
            },
            error: function () {
                zcToast('✗ Connection error — check admin-ajax.php', 'danger');
            },
        });
    }

    // Expose globally for inline onclick attributes
    window.zcaSaveOptions = function () { zcSaveOptions(true); };

    // Auto-save on any input change (debounced 800ms)
    function zcInitAutoSave() {
        $(document).on('change input', '.zca-wrap :input', function () {
            clearTimeout(saveTimer);
            saveTimer = setTimeout(function () { zcSaveOptions(false); }, 800);
        });
    }

    // ─── Safe Mode AJAX ──────────────────────────────────────────────────────────
    function zcInitSafeMode() {
        $(document).on('change', '#zc-safe-mode-toggle', function () {
            var enabled = $(this).is(':checked') ? '1' : '0';
            $.ajax({
                url:    ZCA.ajaxUrl,
                method: 'POST',
                data: {
                    action:    'zca_save_safe_mode',
                    nonce:     ZCA.safeModeNonce,
                    safe_mode: enabled,
                },
                success: function (res) {
                    if (res.success) {
                        var msg = enabled === '1'
                            ? '🛡 Safe Mode ENABLED — reloading…'
                            : '🔓 Safe Mode DISABLED — reloading…';
                        zcToast(msg, 'warning');
                        setTimeout(function () { location.reload(); }, 1500);
                    } else {
                        zcToast('✗ ' + (res.data || 'Save failed'), 'danger');
                    }
                },
            });
        });
    }

    // ─── Section Reset ───────────────────────────────────────────────────────────
    function zcInitReset() {
        $(document).on('click', '[data-zca-reset]', function (e) {
            e.preventDefault();
            if (!confirm('Reset this section to defaults? This cannot be undone.')) return;
            var section = $(this).data('zca-reset');
            $.ajax({
                url:    ZCA.ajaxUrl,
                method: 'POST',
                data: {
                    action:  'zca_reset_section',
                    nonce:   ZCA.nonce,
                    section: section,
                },
                success: function (res) {
                    if (res.success) {
                        zcToast('Section reset to defaults', 'info');
                        setTimeout(function () { location.reload(); }, 1000);
                    } else {
                        zcToast('✗ Reset failed', 'danger');
                    }
                },
            });
        });
    }

    // ─── Export / Import ─────────────────────────────────────────────────────────
    function zcInitExportImport() {
        // Export
        $(document).on('click', '#zca-export-btn', function (e) {
            e.preventDefault();
            var opts = zcCollectOptions();
            var blob = new Blob([JSON.stringify(opts, null, 2)], { type: 'application/json' });
            var url  = URL.createObjectURL(blob);
            var a    = document.createElement('a');
            a.href     = url;
            a.download = 'zincelestial-settings-' + new Date().toISOString().slice(0, 10) + '.json';
            a.click();
            URL.revokeObjectURL(url);
            zcToast('Settings exported as JSON', 'success');
        });

        // Import — click trigger
        $(document).on('click', '#zca-import-btn', function (e) {
            e.preventDefault();
            $('#zca-import-file').trigger('click');
        });

        // Import — file chosen
        $(document).on('change', '#zca-import-file', function (e) {
            var file = e.target.files[0];
            if (!file) return;
            var reader = new FileReader();
            reader.onload = function (ev) {
                try {
                    var opts = JSON.parse(ev.target.result);
                    $.ajax({
                        url:    ZCA.ajaxUrl,
                        method: 'POST',
                        data: {
                            action:  'zca_import_options',
                            nonce:   ZCA.nonce,
                            options: JSON.stringify(opts),
                        },
                        success: function (res) {
                            if (res.success) {
                                zcToast('Settings imported — reloading…', 'success');
                                setTimeout(function () { location.reload(); }, 1200);
                            } else {
                                zcToast('✗ Import failed', 'danger');
                            }
                        },
                    });
                } catch (err) {
                    zcToast('✗ Invalid JSON file', 'danger');
                }
            };
            reader.readAsText(file);
        });
    }

    // ─── WP Color Picker ─────────────────────────────────────────────────────────
    function zcInitColorPickers() {
        if (typeof $.fn.wpColorPicker !== 'function') return;
        $('.zca-color-picker').wpColorPicker({
            change: function () {
                clearTimeout(saveTimer);
                saveTimer = setTimeout(function () { zcSaveOptions(false); }, 1200);
            },
            clear: function () {
                clearTimeout(saveTimer);
                saveTimer = setTimeout(function () { zcSaveOptions(false); }, 1200);
            },
        });
    }

    // ─── Range Sliders ───────────────────────────────────────────────────────────
    function zcInitRangeSliders() {
        function updateDisplay($range) {
            var unit = $range.data('unit') || '';
            var $disp = $range.siblings('.zca-slider-value, .zca-range-display, [data-range-display]');
            if ($disp.length) $disp.text($range.val() + unit);
        }
        // Live update
        $(document).on('input change', 'input[type="range"]', function () {
            updateDisplay($(this));
        });
        // Init
        $('input[type="range"]').each(function () { updateDisplay($(this)); });
    }

    // ─── Module Toggle Show/Hide ──────────────────────────────────────────────────
    function zcInitToggles() {
        // Show/hide dependent rows when a module toggle changes
        $(document).on('change', '[data-zca-module-toggle]', function () {
            var module = $(this).data('zca-module-toggle');
            var $rows  = $('[data-zca-module="' + module + '"]');
            if ($(this).is(':checked')) {
                $rows.slideDown(200);
            } else {
                $rows.slideUp(200);
            }
        });
        // Init on page load
        $('[data-zca-module-toggle]').each(function () {
            var module = $(this).data('zca-module-toggle');
            var $rows  = $('[data-zca-module="' + module + '"]');
            if ($(this).is(':checked')) {
                $rows.show();
            } else {
                $rows.hide();
            }
        });
    }

    // ─── WP Media Image Picker ────────────────────────────────────────────────────
    function zcInitImagePickers() {
        $(document).on('click', '.zca-image-select', function (e) {
            e.preventDefault();
            var $btn     = $(this);
            var $preview = $btn.siblings('.zca-image-preview');
            var $input   = $btn.siblings('input[type="hidden"]');

            var frame = wp.media({
                title:    'Select or Upload Image',
                button:   { text: 'Use this image' },
                multiple: false,
            });
            frame.on('select', function () {
                var attachment = frame.state().get('selection').first().toJSON();
                $input.val(attachment.url).trigger('change');
                if ($preview.length) {
                    $preview.html(
                        '<img src="' + attachment.url + '" style="max-width:100%;max-height:90px;border-radius:8px;margin-top:6px;" />'
                    );
                }
            });
            frame.open();
        });

        $(document).on('click', '.zca-image-remove', function (e) {
            e.preventDefault();
            $(this).siblings('input[type="hidden"]').val('').trigger('change');
            $(this).siblings('.zca-image-preview').html('');
        });
    }

    // ─── Accordion Sections ───────────────────────────────────────────────────────
    function zcInitAccordions() {
        $(document).on('click', '.zca-accordion-header', function () {
            var $body = $(this).next('.zca-accordion-body');
            var $icon = $(this).find('.zca-accordion-icon');
            $body.slideToggle(200);
            $icon.toggleClass('bi-chevron-down bi-chevron-up');
        });
    }

    // ─── Keyboard shortcut Ctrl+S ─────────────────────────────────────────────────
    function zcInitKeyboard() {
        $(document).on('keydown', function (e) {
            if ((e.ctrlKey || e.metaKey) && e.key === 's') {
                e.preventDefault();
                zcSaveOptions(true);
            }
        });
    }

    // ─── Copy snippet ─────────────────────────────────────────────────────────────
    function zcInitCopySnippet() {
        $(document).on('click', '[data-zca-copy]', function (e) {
            e.preventDefault();
            var text = String($(this).data('zca-copy') || $(this).siblings('code').text());
            if (navigator.clipboard) {
                navigator.clipboard.writeText(text).then(function () {
                    zcToast('Copied to clipboard!', 'success');
                }).catch(function () {
                    zcToast('Copy failed — please copy manually', 'danger');
                });
            } else {
                // Fallback
                var $tmp = $('<textarea>').val(text).appendTo('body').select();
                try { document.execCommand('copy'); zcToast('Copied!', 'success'); } catch(err) {}
                $tmp.remove();
            }
        });
    }

    // ─── Scheme preview swatches ──────────────────────────────────────────────────
    function zcInitSchemeSwatches() {
        $(document).on('click', '.zca-scheme-swatch', function () {
            var scheme = $(this).data('scheme');
            if (!scheme) return;
            // Set the hidden/select input
            $('[name*="color_scheme"]').val(scheme).trigger('change');
            // Update active swatch
            $('.zca-scheme-swatch').removeClass('active');
            $(this).addClass('active');
        });
    }

    // ─── Toast Notifications ──────────────────────────────────────────────────────
    function zcToast(msg, type) {
        type = type || 'success';
        var $stack = $('#zca-toast-stack');
        if (!$stack.length) {
            $stack = $('<div id="zca-toast-stack" style="position:fixed;top:1rem;right:1rem;z-index:999999;display:flex;flex-direction:column;gap:.5rem;max-width:320px;"></div>').appendTo('body');
        }
        var icons = {
            success: 'check-circle-fill',
            danger:  'x-circle-fill',
            warning: 'exclamation-triangle-fill',
            info:    'info-circle-fill',
        };
        var icon  = icons[type] || 'info-circle-fill';
        var bgMap = {
            success: 'rgba(52,211,153,.15)',
            danger:  'rgba(248,113,113,.15)',
            warning: 'rgba(251,191,36,.15)',
            info:    'rgba(96,165,250,.15)',
        };
        var colorMap = {
            success: '#34d399',
            danger:  '#f87171',
            warning: '#fbbf24',
            info:    '#60a5fa',
        };
        var id  = 'zca-toast-' + Date.now();
        var $t  = $([
            '<div id="' + id + '" style="',
            'background:' + (bgMap[type]||bgMap.info) + ';',
            'border:1px solid ' + (colorMap[type]||colorMap.info) + '33;',
            'border-left:3px solid ' + (colorMap[type]||colorMap.info) + ';',
            'border-radius:10px;',
            'padding:.65rem 1rem;',
            'display:flex;align-items:center;gap:.6rem;',
            'font-size:.85rem;font-weight:600;',
            'color:' + (colorMap[type]||colorMap.info) + ';',
            'opacity:0;transform:translateX(20px);',
            'transition:opacity .2s ease,transform .2s ease;',
            'box-shadow:0 4px 16px rgba(0,0,0,.3);',
            '">',
            '<i class="bi bi-' + icon + '"></i>',
            '<span>' + msg + '</span>',
            '</div>',
        ].join('')).appendTo($stack);

        setTimeout(function () {
            $t.css({ opacity: 1, transform: 'translateX(0)' });
        }, 10);
        setTimeout(function () {
            $t.css({ opacity: 0, transform: 'translateX(20px)' });
            setTimeout(function () { $t.remove(); }, 250);
        }, 3500);
    }

    // Expose globally
    window.zcToast = zcToast;

    // ─── INIT ────────────────────────────────────────────────────────────────────
    $(document).ready(function () {
        zcInitTabs();
        zcInitAutoSave();
        zcInitSafeMode();
        zcInitReset();
        zcInitExportImport();
        zcInitColorPickers();
        zcInitRangeSliders();
        zcInitToggles();
        zcInitImagePickers();
        zcInitAccordions();
        zcInitKeyboard();
        zcInitCopySnippet();
        zcInitSchemeSwatches();
    });

})(jQuery);
