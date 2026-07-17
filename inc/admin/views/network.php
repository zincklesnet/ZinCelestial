<?php if(!defined('ABSPATH'))exit;
$is_network_admin = is_network_admin();
$opts = get_option('zincelestial_options', zc_default_options());
$network_opts = get_site_option('zincelestial_network_options', []);
function zca_on($o,$k,$f=''){return isset($o[$k])?$o[$k]:$f;}
$sites = get_sites(['number'=>50]);
?>
<div class="zca-wrap">
<div class="zca-page-header">
  <div class="zca-page-header__left">
    <div class="zca-page-header__icon">🌐</div>
    <div><div class="zca-page-header__title">Network</div>
    <div class="zca-page-header__sub">Multisite network settings, per-site overrides, and network-wide theme control</div></div>
  </div>
  <div class="zca-page-header__right">
    <span class="zca-badge <?php echo is_multisite()?'zca-badge--success':'zca-badge--muted'; ?>">
      <?php echo is_multisite() ? '● Multisite Active' : '○ Single Site'; ?>
    </span>
  </div>
</div>
<div class="zca-content">
<?php if(!is_multisite()): ?>
<div class="zca-notice zca-notice--warning"><span class="zca-notice__icon">⚠</span><div><div class="zca-notice__title">WordPress Multisite Not Enabled</div>Network features are only available in WordPress Multisite installations.</div></div>
<?php endif; ?>

  <div class="zca-tabs-nav">
    <button class="zca-tab-btn" data-zc-tab="overview"><span class="zca-tab-icon">📊</span> Overview</button>
    <button class="zca-tab-btn" data-zc-tab="settings"><span class="zca-tab-icon">⚙️</span> Network Settings</button>
    <button class="zca-tab-btn" data-zc-tab="sites"><span class="zca-tab-icon">🌐</span> Sites (<?php echo count($sites); ?>)</button>
    <button class="zca-tab-btn" data-zc-tab="modules"><span class="zca-tab-icon">🧩</span> Module Control</button>
  </div>
  <div class="zca-tab-panels">

    <div class="zca-tab-panel" data-zc-panel="overview">
      <?php if(is_multisite()): ?>
      <div class="zca-grid zca-grid--4">
        <?php
        $site_count = get_blog_count();
        $user_count = get_user_count();
        $super_admins = get_super_admins();
        ?>
        <div class="zca-stat"><div class="zca-stat__num"><?php echo number_format($site_count); ?></div><div class="zca-stat__label">Sites</div></div>
        <div class="zca-stat"><div class="zca-stat__num"><?php echo number_format($user_count); ?></div><div class="zca-stat__label">Users</div></div>
        <div class="zca-stat"><div class="zca-stat__num"><?php echo count($super_admins); ?></div><div class="zca-stat__label">Super Admins</div></div>
        <div class="zca-stat"><div class="zca-stat__num"><?php echo get_site_option('active_sitewide_plugins') ? count(get_site_option('active_sitewide_plugins')) : 0; ?></div><div class="zca-stat__label">Network Plugins</div></div>
      </div>
      <?php endif; ?>
      <div class="zca-card" style="margin-top:20px;">
        <div class="zca-card__header"><div class="zca-card__icon">ℹ️</div><span class="zca-card__title">Network Info</span></div>
        <div style="padding:16px 20px;display:grid;grid-template-columns:1fr 1fr;gap:12px;">
          <div><div style="font-size:.7rem;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:var(--zca-muted,#94a3b8);">Network Name</div><div style="font-size:.875rem;color:var(--zca-text,#e2e8f0);margin-top:4px;"><?php echo esc_html(get_network()->site_name); ?></div></div>
          <div><div style="font-size:.7rem;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:var(--zca-muted,#94a3b8);">Network URL</div><div style="font-size:.875rem;color:var(--zca-text,#e2e8f0);margin-top:4px;"><?php echo esc_html(network_site_url()); ?></div></div>
          <div><div style="font-size:.7rem;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:var(--zca-muted,#94a3b8);">WordPress Version</div><div style="font-size:.875rem;color:var(--zca-text,#e2e8f0);margin-top:4px;"><?php echo esc_html(get_bloginfo('version')); ?></div></div>
          <div><div style="font-size:.7rem;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:var(--zca-muted,#94a3b8);">ZinCelestial</div><div style="font-size:.875rem;color:var(--zca-primary,#7c6ff7);margin-top:4px;font-weight:700;">v<?php echo defined('ZC_VERSION')?ZC_VERSION:'5.0.0'; ?></div></div>
        </div>
      </div>
    </div>

    <div class="zca-tab-panel" data-zc-panel="settings">
      <div class="zca-grid zca-grid--2">
        <div class="zca-card">
          <div class="zca-card__header"><div class="zca-card__icon">🔒</div><span class="zca-card__title">Network-Wide Controls</span></div>
          <div class="zca-toggle-row">
            <div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Lock Theme Settings for Sub-Sites</div><div class="zca-toggle-row__desc">Prevent sub-site admins from changing ZinCelestial settings</div></div>
            <label class="zca-toggle"><input type="checkbox" name="zincelestial_options[network_lock_settings]" <?php checked(zca_on($opts,'network_lock_settings','0'),'1'); ?>><span class="zca-toggle-slider"></span></label>
          </div>
          <div class="zca-toggle-row">
            <div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Force Network Scheme</div><div class="zca-toggle-row__desc">All sub-sites use the network default color scheme</div></div>
            <label class="zca-toggle"><input type="checkbox" name="zincelestial_options[network_force_scheme]" <?php checked(zca_on($opts,'network_force_scheme','0'),'1'); ?>><span class="zca-toggle-slider"></span></label>
          </div>
          <div class="zca-field">
            <label class="zca-label">Network Default Scheme</label>
            <select class="zca-select" name="zincelestial_options[network_default_scheme]">
              <?php foreach(['default','slate','forest','cosmic','aurora','nova','zenith','ember','twilight'] as $s): ?>
              <option value="<?php echo $s; ?>" <?php selected(zca_on($opts,'network_default_scheme','cosmic'),$s); ?>><?php echo ucfirst($s); ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="zca-toggle-row">
            <div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Network Safe Mode</div><div class="zca-toggle-row__desc">Enable safe mode across all network sites</div></div>
            <label class="zca-toggle"><input type="checkbox" name="zincelestial_options[network_safe_mode]" <?php checked(zca_on($opts,'network_safe_mode','0'),'1'); ?>><span class="zca-toggle-slider"></span></label>
          </div>
        </div>
        <div class="zca-card">
          <div class="zca-card__header"><div class="zca-card__icon">📤</div><span class="zca-card__title">Push Settings to All Sites</span></div>
          <div class="zca-notice zca-notice--warning"><span class="zca-notice__icon">⚠</span><div>This will push your current theme settings to ALL sub-sites and cannot be undone.</div></div>
          <div style="padding:0 20px 16px;">
            <button class="zca-btn zca-btn--danger zca-btn--sm" onclick="zcaPushNetworkSettings()" data-confirm="Push current settings to ALL sub-sites? This cannot be undone."><i class="bi bi-broadcast me-1"></i> Push to All Sites</button>
          </div>
        </div>
      </div>
    </div>

    <div class="zca-tab-panel" data-zc-panel="sites">
      <div class="zca-card">
        <div class="zca-card__header"><div class="zca-card__icon">🌐</div><span class="zca-card__title">Network Sites</span></div>
        <div style="overflow-x:auto;">
          <table class="zca-table" style="width:100%;">
            <thead><tr>
              <th>Site</th><th>URL</th><th>Theme</th><th>Status</th><th>Actions</th>
            </tr></thead>
            <tbody>
              <?php foreach($sites as $site):
                switch_to_blog($site->blog_id);
                $active_theme = wp_get_theme()->get('Name');
                $is_main = ($site->blog_id === get_main_site_id());
                restore_current_blog();
              ?>
              <tr>
                <td><strong><?php echo esc_html($site->blogname); ?></strong><?php if($is_main) echo '<span class="zca-badge zca-badge--primary ms-2" style="font-size:.55rem;">MAIN</span>'; ?></td>
                <td><a href="<?php echo esc_url($site->siteurl); ?>" target="_blank" style="color:var(--zca-primary,#7c6ff7);font-size:.8rem;"><?php echo esc_html($site->domain.$site->path); ?></a></td>
                <td style="font-size:.8rem;"><?php echo esc_html($active_theme); ?></td>
                <td><span class="zca-badge <?php echo $site->spam||$site->deleted?'zca-badge--danger':'zca-badge--success'; ?>"><?php echo $site->spam?'Spam':($site->deleted?'Deleted':'Active'); ?></span></td>
                <td><a href="<?php echo esc_url(get_admin_url($site->blog_id,'admin.php?page=zc-dashboard')); ?>" class="zca-btn zca-btn--ghost zca-btn--sm" target="_blank">ZC Settings</a></td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class="zca-tab-panel" data-zc-panel="modules">
      <div class="zca-notice zca-notice--info"><span class="zca-notice__icon">ℹ</span><div>Stage 1 modules shown. Stage 2 (paused) and Stage 3 (future) modules are hidden.</div></div>
      <?php
      $modules = [
        ['buddypress','BuddyPress','👥','Social community','enable_buddypress'],
        ['woocommerce','WooCommerce','🛒','E-commerce store','enable_woocommerce'],
        ['bbpress','bbPress','💬','Discussion forums','enable_bbpress'],
      ];
      ?>
      <div class="zca-grid zca-grid--3">
        <?php foreach($modules as [$key,$name,$icon,$desc,$opt]): ?>
        <div class="zca-card">
          <div class="zca-card__header"><div class="zca-card__icon"><?php echo $icon; ?></div><span class="zca-card__title"><?php echo $name; ?></span></div>
          <div style="padding:0 20px 8px;font-size:.8rem;color:var(--zca-muted,#94a3b8);"><?php echo $desc; ?></div>
          <div class="zca-toggle-row" style="padding:0 20px 16px;">
            <div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Enable Globally</div></div>
            <label class="zca-toggle"><input type="checkbox" name="zincelestial_options[<?php echo $opt; ?>]" <?php checked(zca_on($opts,$opt,'0'),'1'); ?>><span class="zca-toggle-slider"></span></label>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>

  </div>
  <div class="zca-card-actions">
    <button class="zca-btn zca-btn--primary" onclick="zcaSaveOptions()"><i class="bi bi-floppy me-1"></i> Save Network Settings</button>
  </div>
</div>
</div>
<script>
function zcaPushNetworkSettings(){
  if(!confirm('Push current settings to ALL sub-sites?')) return;
  jQuery.post(ZC_Admin.ajax_url,{action:'zc_network_push',nonce:ZC_Admin.nonce},function(r){
    if(r.success) zcaToast('✅ Settings pushed to all sites!','success');
    else zcaToast('❌ Push failed: '+(r.data||''),'danger');
  });
}
</script>
