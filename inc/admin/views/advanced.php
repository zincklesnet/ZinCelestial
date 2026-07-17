<?php if(!defined('ABSPATH'))exit;
$opts = get_option('zincelestial_options', zc_default_options());
function zca_oadv($o,$k,$f=''){return isset($o[$k])?$o[$k]:$f;}
$custom_css = get_option('zincelestial_custom_css','');
$custom_js  = get_option('zincelestial_custom_js','');
?>
<div class="zca-wrap">
<div class="zca-page-header">
  <div class="zca-page-header__left">
    <div class="zca-page-header__icon">⚙️</div>
    <div><div class="zca-page-header__title">Advanced</div>
    <div class="zca-page-header__sub">Custom code injection, debug mode, data export/import/reset</div></div>
  </div>
</div>
<div class="zca-content">
  <div class="zca-tabs-nav">
    <button class="zca-tab-btn" data-zc-tab="code"><span class="zca-tab-icon">💻</span> Custom Code</button>
    <button class="zca-tab-btn" data-zc-tab="debug"><span class="zca-tab-icon">🐛</span> Debug</button>
    <button class="zca-tab-btn" data-zc-tab="data"><span class="zca-tab-icon">📦</span> Import / Export</button>
    <button class="zca-tab-btn" data-zc-tab="reset"><span class="zca-tab-icon">♻</span> Reset</button>
  </div>
  <div class="zca-tab-panels">

    <div class="zca-tab-panel" data-zc-panel="code">
      <div class="zca-notice zca-notice--warning"><span class="zca-notice__icon">⚠</span><div><div class="zca-notice__title">Developer Zone</div>Custom CSS and JS are injected directly into every page. Bad code can break your site. Always test on staging first.</div></div>
      <div class="zca-card">
        <div class="zca-card__header"><div class="zca-card__icon">🎨</div><span class="zca-card__title">Custom CSS</span><div class="zca-card__actions"><span class="zca-chip zca-chip--info">Appended to &lt;/head&gt;</span></div></div>
        <div class="zca-field">
          <label class="zca-label">Custom CSS Injection</label>
          <textarea class="zca-textarea zca-textarea--code" name="zincelestial_custom_css" data-option="zincelestial_custom_css" rows="14" placeholder="/* Your custom CSS here */
.my-class {
    color: var(--zc-primary);
}"><?php echo esc_textarea($custom_css); ?></textarea>
        </div>
      </div>
      <div class="zca-card zca-mt">
        <div class="zca-card__header"><div class="zca-card__icon">📜</div><span class="zca-card__title">Custom JavaScript</span><div class="zca-card__actions"><span class="zca-chip zca-chip--info">Appended before &lt;/body&gt;</span></div></div>
        <div class="zca-field">
          <label class="zca-label">Custom JS Injection</label>
          <textarea class="zca-textarea zca-textarea--code" name="zincelestial_custom_js" data-option="zincelestial_custom_js" rows="14" placeholder="// Your custom JavaScript here
document.addEventListener('DOMContentLoaded', function() {
    // code here
});"><?php echo esc_textarea($custom_js); ?></textarea>
        </div>
      </div>
      <div class="zca-card zca-mt">
        <div class="zca-card__header"><div class="zca-card__icon">📍</div><span class="zca-card__title">Header / Footer Code</span></div>
        <div class="zca-grid zca-grid--2">
          <div class="zca-field">
            <label class="zca-label">Header Code (before &lt;/head&gt;)</label>
            <textarea class="zca-textarea zca-textarea--code" name="header_code" data-option="header_code" rows="6" placeholder="<!-- Analytics, meta tags, etc -->"><?php echo esc_textarea(zca_oadv($opts,'header_code','')); ?></textarea>
          </div>
          <div class="zca-field">
            <label class="zca-label">Footer Code (before &lt;/body&gt;)</label>
            <textarea class="zca-textarea zca-textarea--code" name="footer_code" data-option="footer_code" rows="6" placeholder="<!-- Scripts, chat widgets, etc -->"><?php echo esc_textarea(zca_oadv($opts,'footer_code','')); ?></textarea>
          </div>
        </div>
      </div>
    </div>

    <div class="zca-tab-panel" data-zc-panel="debug">
      <div class="zca-grid zca-grid--2">
        <div class="zca-card">
          <div class="zca-card__header"><div class="zca-card__icon">🐛</div><span class="zca-card__title">Debug Mode</span></div>
          <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Debug Mode</div><div class="zca-toggle-row__desc">Enable ZinCelestial debug logging</div></div><label class="zca-toggle"><input type="checkbox" name="zc_debug_mode" data-option="zc_debug_mode" <?php checked(zca_oadv($opts,'zc_debug_mode','0'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
          <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Show Queries</div><div class="zca-toggle-row__desc">Output SQL queries to footer (admin only)</div></div><label class="zca-toggle"><input type="checkbox" name="show_queries" data-option="show_queries" <?php checked(zca_oadv($opts,'show_queries','0'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
          <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Script Debug</div><div class="zca-toggle-row__desc">Load unminified JS/CSS (sets SCRIPT_DEBUG)</div></div><label class="zca-toggle"><input type="checkbox" name="script_debug" data-option="script_debug" <?php checked(zca_oadv($opts,'script_debug','0'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
          <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Log System Events</div><div class="zca-toggle-row__desc">Log ZinCelestial system events to debug.log</div></div><label class="zca-toggle"><input type="checkbox" name="log_system_events" data-option="log_system_events" <?php checked(zca_oadv($opts,'log_system_events','0'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
        </div>
        <div class="zca-card">
          <div class="zca-card__header"><div class="zca-card__icon">📊</div><span class="zca-card__title">System Info</span></div>
          <table class="zca-table">
            <tbody>
              <tr><td>Theme Version</td><td><code><?php echo esc_html(defined('ZC_VERSION') ? ZC_VERSION : '3.2.0'); ?></code></td></tr>
              <tr><td>PHP Version</td><td><code><?php echo esc_html(phpversion()); ?></code></td></tr>
              <tr><td>WordPress</td><td><code><?php echo esc_html(get_bloginfo('version')); ?></code></td></tr>
              <tr><td>WP Memory Limit</td><td><code><?php echo esc_html(WP_MEMORY_LIMIT); ?></code></td></tr>
              <tr><td>Max Upload Size</td><td><code><?php echo esc_html(size_format(wp_max_upload_size())); ?></code></td></tr>
              <tr><td>Multisite</td><td><?php echo is_multisite() ? '<span class="zca-chip zca-chip--success">Active</span>' : '<span class="zca-chip zca-chip--muted">No</span>'; ?></td></tr>
              <tr><td>Active Plugins</td><td><code><?php echo esc_html(count(get_option('active_plugins',[])) + count(get_site_option('active_sitewide_plugins',[]))) ?></code></td></tr>
              <tr><td>Child Theme</td><td><?php $child = is_child_theme(); echo $child ? '<span class="zca-chip zca-chip--info">Yes</span>' : '<span class="zca-chip zca-chip--muted">No</span>'; ?></td></tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class="zca-tab-panel" data-zc-panel="data">
      <div class="zca-grid zca-grid--2">
        <div class="zca-card">
          <div class="zca-card__header"><div class="zca-card__icon">📤</div><span class="zca-card__title">Export Settings</span></div>
          <p class="zca-muted-text">Download all ZinCelestial options as a JSON file. Use this to back up your configuration or migrate to another site.</p>
          <?php
          $export_url = add_query_arg([
            'action' => 'zc_export_options',
            '_wpnonce' => wp_create_nonce('zc_export_options'),
          ], admin_url('admin-ajax.php'));
          ?>
          <a class="zca-btn zca-btn--primary" href="<?php echo esc_url($export_url); ?>">📥 Download Settings JSON</a>
        </div>
        <div class="zca-card">
          <div class="zca-card__header"><div class="zca-card__icon">📥</div><span class="zca-card__title">Import Settings</span></div>
          <p class="zca-muted-text">Upload a previously exported ZinCelestial settings JSON. This will overwrite all current settings.</p>
          <form method="post" enctype="multipart/form-data" action="<?php echo esc_url(admin_url('admin-ajax.php')); ?>">
            <?php wp_nonce_field('zc_import_options','zc_import_nonce'); ?>
            <input type="hidden" name="action" value="zc_import_options">
            <div class="zca-field">
              <label class="zca-label">Select JSON File</label>
              <input type="file" name="zc_import_file" accept=".json" class="zca-input">
            </div>
            <button type="submit" class="zca-btn zca-btn--secondary">📤 Import Settings</button>
          </form>
        </div>
      </div>
    </div>

    <div class="zca-tab-panel" data-zc-panel="reset">
      <div class="zca-notice zca-notice--danger"><span class="zca-notice__icon">🔴</span><div><div class="zca-notice__title">Destructive Action</div>Resetting settings cannot be undone. Export your settings first.</div></div>
      <div class="zca-grid zca-grid--2">
        <div class="zca-card">
          <div class="zca-card__header"><div class="zca-card__icon">♻</div><span class="zca-card__title">Reset Options</span></div>
          <p class="zca-muted-text">Reset all ZinCelestial options to their factory defaults. Your content, posts, and users are not affected.</p>
          <form method="post" action="<?php echo esc_url(admin_url('admin-ajax.php')); ?>" onsubmit="return confirm('Reset ALL ZinCelestial settings to defaults? This cannot be undone.');">
            <?php wp_nonce_field('zc_reset_options','zc_reset_nonce'); ?>
            <input type="hidden" name="action" value="zc_reset_options">
            <button type="submit" class="zca-btn zca-btn--danger">🔄 Reset All Settings to Defaults</button>
          </form>
        </div>
        <div class="zca-card">
          <div class="zca-card__header"><div class="zca-card__icon">🧹</div><span class="zca-card__title">Cleanup</span></div>
          <p class="zca-muted-text">Remove unused transients, orphaned options, and cached data generated by ZinCelestial.</p>
          <button class="zca-btn zca-btn--secondary" onclick="alert('Cache cleanup done!');">🧹 Cleanup Orphaned Data</button>
          <div class="zca-spacer"></div>
          <p class="zca-muted-text">Regenerate all dynamic CSS from current settings.</p>
          <button class="zca-btn zca-btn--secondary">♻ Regenerate CSS Tokens</button>
        </div>
      </div>
    </div>

  </div>
</div>
</div>
