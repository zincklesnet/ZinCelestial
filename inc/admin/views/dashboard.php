<?php if(!defined('ABSPATH'))exit;
$opts    = get_option('zincelestial_options', []);
$safe    = !empty($opts['safe_mode']) && $opts['safe_mode'] == '1';
$density = isset($opts['admin_ui_density']) ? $opts['admin_ui_density'] : 'comfortable';
$version = defined('ZC_VERSION') ? ZC_VERSION : '4.2.0';
?>
<div class="wrap zca-wrap zca-density-<?php echo esc_attr($density); ?>">
<div class="zca-app-main-inner">

<!-- ══ Safe Mode Banner (when ON) ══ -->
<?php if($safe): ?>
<div class="zca-safe-mode-banner">
  <span class="zca-sm-icon">🛡️</span>
  <div class="zca-sm-body">
    <p class="zca-sm-title">ZinCelestial Safe Mode is ACTIVE</p>
    <p class="zca-sm-desc">All modules are disabled. The theme is running in minimal fallback mode. Disable Safe Mode to restore full functionality.</p>
  </div>
  <button class="zca-sm-btn" onclick="document.getElementById('zc-safe-mode-toggle').checked=false;document.getElementById('zc-safe-mode-toggle').dispatchEvent(new Event('change'));">
    🔓 Disable Safe Mode
  </button>
</div>
<?php endif; ?>

<!-- ══ Page Header ══ -->
<div class="zca-page-header">
  <div class="zca-page-header-left">
    <div class="zca-page-icon">✦</div>
    <div>
      <h1 class="zca-page-title">ZinCelestial Dashboard</h1>
      <p class="zca-page-sub">WordPress Multisite Frontend Theme &nbsp;•&nbsp; <span style="color:var(--zca-primary);font-weight:700;">v<?php echo esc_html($version); ?></span></p>
    </div>
  </div>
  <div class="zca-page-actions">
    <a href="<?php echo esc_url(home_url('/')); ?>" target="_blank" class="zca-btn zca-btn-ghost zca-btn-sm">
      <i class="bi bi-eye"></i> View Site
    </a>
    <a href="<?php echo esc_url(admin_url('customize.php')); ?>" class="zca-btn zca-btn-secondary zca-btn-sm">
      <i class="bi bi-palette"></i> Customizer
    </a>
    <button class="zca-btn zca-btn-primary zca-btn-sm" id="zca-save-btn" onclick="zcaSaveOptions()">
      <i class="bi bi-floppy"></i> Save All Changes
    </button>
  </div>
</div>

<!-- ══ SAFE MODE CARD — most prominent element ══ -->
<div class="zca-card zca-card-accent <?php echo $safe ? 'zca-card-warning' : ''; ?>" style="border: 2px solid <?php echo $safe ? 'var(--zca-warning)' : 'var(--zca-primary)'; ?>;">
  <div class="zca-card-header">
    <h3 class="zca-card-title">
      <span class="zca-card-title-icon">🛡️</span>
      Safe Mode
      <?php if($safe): ?>
        <span class="zca-badge zca-badge-warning">ACTIVE</span>
      <?php else: ?>
        <span class="zca-badge zca-badge-muted">OFF</span>
      <?php endif; ?>
    </h3>
    <span style="font-size:.8rem;color:var(--zca-muted);">Critical safety switch — disables all modules instantly</span>
  </div>
  <div style="display:grid;grid-template-columns:1fr auto;gap:24px;align-items:center;">
    <div>
      <p style="margin:0 0 8px;font-size:.9rem;color:var(--zca-text);line-height:1.6;">
        When <strong>Safe Mode</strong> is enabled, all ZinCelestial modules (reactions, compose bar, GamiPress bar, BuddyPress enhancements, WooCommerce customizations, and more) are completely disabled. The theme falls back to minimal Twenty Twenty-Five compatible rendering.
      </p>
      <p style="margin:0;font-size:.8rem;color:var(--zca-muted);">Use Safe Mode to troubleshoot conflicts, plugin issues, or CSS problems without deactivating the theme.</p>
    </div>
    <div style="text-align:center;flex-shrink:0;">
      <label class="zca-toggle" style="width:60px;height:30px;" title="Toggle Safe Mode">
        <input type="checkbox" id="zc-safe-mode-toggle" name="zincelestial_options[safe_mode]"
               value="1" <?php checked($safe); ?> onchange="zcaToggleSafeMode(this)">
        <span class="zca-toggle-slider" style="border-radius:15px;"></span>
      </label>
      <p style="font-size:.7rem;color:var(--zca-muted);margin:8px 0 0;"><?php echo $safe ? '<span style="color:var(--zca-warning);font-weight:700;">ENABLED</span>' : 'Disabled'; ?></p>
    </div>
  </div>
</div>

<!-- ══ Stat Cards row ══ -->
<div class="zca-stat-grid">
  <?php
  $u_count = function_exists('bp_get_total_member_count') ? bp_get_total_member_count() : get_option('user_count', count_users()['total_users'] ?? 0);
  $g_count = function_exists('groups_get_total_group_count') ? groups_get_total_group_count() : 0;
  $p_count = wp_count_posts('post');
  $posts   = $p_count ? $p_count->publish : 0;
  $wc_orders = function_exists('wc_get_orders') ? count(wc_get_orders(['limit'=>1,'return'=>'ids'])) : 0;
  $stats = [
    ['icon'=>'bi-people-fill', 'label'=>'Members', 'value'=>number_format($u_count), 'class'=>'primary', 'trend'=>'↑ active community'],
    ['icon'=>'bi-collection-fill', 'label'=>'Groups', 'value'=>number_format($g_count), 'class'=>'success', 'trend'=>'BuddyPress groups'],
    ['icon'=>'bi-file-text-fill', 'label'=>'Posts', 'value'=>number_format($posts), 'class'=>'info', 'trend'=>'Published content'],
    ['icon'=>'bi-bag-check-fill', 'label'=>'WC Active', 'value'=>class_exists('WooCommerce')?'Yes':'No', 'class'=>class_exists('WooCommerce')?'success':'danger', 'trend'=>class_exists('WooCommerce')?'WooCommerce ready':'Plugin inactive'],
  ];
  foreach($stats as $s): ?>
  <div class="zca-stat-card <?php echo esc_attr($s['class']); ?>">
    <div class="zca-stat-card-bg"></div>
    <div class="zca-stat-icon"><i class="bi <?php echo esc_attr($s['icon']); ?>"></i></div>
    <div class="zca-stat-value"><?php echo esc_html($s['value']); ?></div>
    <div class="zca-stat-label"><?php echo esc_html($s['label']); ?></div>
    <div class="zca-stat-trend up"><i class="bi bi-arrow-up-right"></i> <?php echo esc_html($s['trend']); ?></div>
  </div>
  <?php endforeach; ?>
</div>

<!-- ══ Admin UI Controls ══ -->
<div class="zca-card">
  <div class="zca-card-header">
    <h3 class="zca-card-title"><span class="zca-card-title-icon">🎛️</span> Admin UI Density &amp; Spacing</h3>
    <span class="zca-badge zca-badge-primary">v4.2 NEW</span>
  </div>
  <div class="zca-settings-grid">
    <!-- Card Padding -->
    <div class="zca-form-group">
      <label class="zca-form-label">Card Inner Padding <span class="zca-form-label-sub">(px)</span></label>
      <div class="zca-range-row">
        <input type="range" class="zca-range" id="zca-card-pad" min="12" max="56" step="4"
               value="<?php echo esc_attr(isset($opts['admin_card_padding']) ? $opts['admin_card_padding'] : 28); ?>"
               oninput="this.nextElementSibling.textContent=this.value+'px';document.querySelector('.zca-density-<?php echo esc_attr($density);?>').style.setProperty('--zca-card-pad',this.value+'px');">
        <span class="zca-range-val"><?php echo isset($opts['admin_card_padding']) ? $opts['admin_card_padding'] : 28; ?>px</span>
      </div>
      <input type="hidden" name="zincelestial_options[admin_card_padding]" value="<?php echo esc_attr(isset($opts['admin_card_padding']) ? $opts['admin_card_padding'] : 28); ?>">
      <p class="zca-form-hint">Controls inner padding on all admin panel cards</p>
    </div>
    <!-- Content Gap -->
    <div class="zca-form-group">
      <label class="zca-form-label">Content Area Gap <span class="zca-form-label-sub">(px)</span></label>
      <div class="zca-range-row">
        <input type="range" class="zca-range" id="zca-content-gap" min="8" max="64" step="4"
               value="<?php echo esc_attr(isset($opts['admin_content_gap']) ? $opts['admin_content_gap'] : 24); ?>"
               oninput="this.nextElementSibling.textContent=this.value+'px';">
        <span class="zca-range-val"><?php echo isset($opts['admin_content_gap']) ? $opts['admin_content_gap'] : 24; ?>px</span>
      </div>
      <p class="zca-form-hint">Space between WP admin sidebar and ZinCelestial content</p>
    </div>
    <!-- UI Density -->
    <div class="zca-form-group">
      <label class="zca-form-label">UI Density Preset</label>
      <?php $dens = isset($opts['admin_ui_density']) ? $opts['admin_ui_density'] : 'comfortable'; ?>
      <select class="zca-form-control" name="zincelestial_options[admin_ui_density]">
        <option value="compact"     <?php selected($dens,'compact'); ?>>Compact — tight, information-dense</option>
        <option value="comfortable" <?php selected($dens,'comfortable'); ?>>Comfortable — balanced (default)</option>
        <option value="spacious"    <?php selected($dens,'spacious'); ?>>Spacious — ZinCelestial Reference-style open layout</option>
      </select>
      <p class="zca-form-hint">Changes card padding, gaps, and section spacing globally</p>
    </div>
  </div>
</div>

<!-- ══ Quick nav tiles ══ -->
<div class="zca-card">
  <div class="zca-card-header">
    <h3 class="zca-card-title"><span class="zca-card-title-icon">⚡</span> Quick Navigation</h3>
  </div>
  <div class="zca-tiles">
    <?php
    $quick = [
      ['zc-general',     '⚙️',  'General'],
      ['zc-design',      '🎨',  'Design'],
      ['zc-typography',  '🔤',  'Typography'],
      ['zc-header',      '🔝',  'Header'],
      ['zc-footer',      '⬇️',  'Footer'],
      ['zc-buddypress',  '👥',  'BuddyPress'],
      ['zc-woocommerce', '🛒',  'WooCommerce'],
      ['zc-bbpress',     '💬',  'bbPress'],
      ['zc-reactions',   '❤️',  'Reactions'],
      ['zc-gamipress',   '🏆',  'GamiPress'],
      ['zc-schemes',     '🌈',  'Schemes'],
      ['zc-performance', '⚡',  'Performance'],
      ['zc-security',    '🔒',  'Security'],
      ['zc-library',     '📚',  'Library'],
      ['zc-helpdesk',    '🎫',  'Help Desk'],
      ['zc-analytics',   '📊',  'Analytics'],
      ['zc-calendar',    '📅',  'Calendar'],
      ['zc-shortcodes',  '[ ]', 'Shortcodes'],
    ];
    foreach($quick as [$slug, $icon, $label]): ?>
    <a href="<?php echo esc_url(admin_url("admin.php?page={$slug}")); ?>" class="zca-tile">
      <span class="zca-tile-icon"><?php echo $icon; ?></span>
      <?php echo esc_html($label); ?>
    </a>
    <?php endforeach; ?>
  </div>
</div>

<!-- ══ Theme info / about ══ -->
<div class="zca-row">
  <div class="zca-col-6">
    <div class="zca-card" style="height:100%;">
      <div class="zca-card-header">
        <h3 class="zca-card-title"><span class="zca-card-title-icon">ℹ️</span> Theme Info</h3>
      </div>
      <?php
      $rows = [
        ['Version', 'v' . $version],
        ['Bootstrap', '5.3.3'],
        ['Bootstrap Icons', '1.11.3'],
        ['PHP Required', '8.0+'],
        ['WP Required', '6.0+'],
        ['Multisite', is_multisite() ? '✅ Active' : '❌ Not active'],
        ['BuddyPress', class_exists('BuddyPress') ? '✅ ' . (defined('BP_VERSION')?BP_VERSION:'Active') : '❌ Not active'],
        ['WooCommerce', class_exists('WooCommerce') ? '✅ ' . (defined('WC_VERSION')?WC_VERSION:'Active') : '❌ Not active'],
        ['bbPress', class_exists('bbPress') ? '✅ Active' : '❌ Not active'],
        ['GamiPress', function_exists('gamipress_get_user_points') ? '✅ Active' : '❌ Not active'],
        ['Safe Mode', $safe ? '<span style="color:var(--zca-warning);font-weight:700;">🛡️ ACTIVE</span>' : 'Off'],
      ];
      ?>
      <div class="zca-table-wrap">
        <table class="zca-table">
          <tbody>
            <?php foreach($rows as [$k,$v]): ?>
            <tr><td style="color:var(--zca-muted);width:50%;"><?php echo esc_html($k); ?></td><td><?php echo wp_kses_post($v); ?></td></tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div class="zca-col-6">
    <div class="zca-card" style="height:100%;">
      <div class="zca-card-header">
        <h3 class="zca-card-title"><span class="zca-card-title-icon">🔧</span> Quick Actions</h3>
      </div>
      <div style="display:flex;flex-direction:column;gap:12px;">
        <button class="zca-btn zca-btn-primary" onclick="zcaSaveOptions()"><i class="bi bi-floppy-fill"></i> Save All Options</button>
        <button class="zca-btn zca-btn-secondary" onclick="zcaExportOptions()"><i class="bi bi-download"></i> Export Options JSON</button>
        <label class="zca-btn zca-btn-ghost" style="cursor:pointer;">
          <i class="bi bi-upload"></i> Import Options JSON
          <input type="file" accept=".json" style="display:none;" onchange="zcaImportOptions(this)">
        </label>
        <button class="zca-btn zca-btn-danger" onclick="if(confirm('Reset ALL options to defaults?'))zcaResetOptions();"><i class="bi bi-arrow-counterclockwise"></i> Reset to Defaults</button>
        <a href="<?php echo esc_url(admin_url('themes.php')); ?>" class="zca-btn zca-btn-ghost"><i class="bi bi-brush"></i> Switch Theme</a>
      </div>
    </div>
  </div>
</div>

</div><!-- /zca-app-main-inner -->
</div><!-- /wrap zca-wrap -->

<script>
function zcaToggleSafeMode(el){
  var val = el.checked ? '1' : '0';
  var data = new FormData();
  data.append('action','zc_save_options');
  data.append('nonce','<?php echo wp_create_nonce("zc_options_nonce"); ?>');
  data.append('options[safe_mode]', val);
  fetch(ajaxurl,{method:'POST',body:data})
    .then(r=>r.json())
    .then(d=>{
      if(d.success){ location.reload(); }
      else{ alert('Save failed: '+(d.data||'unknown error')); }
    });
}
function zcaSaveOptions(){
  var btn = document.getElementById('zca-save-btn');
  if(btn){ btn.disabled=true; btn.innerHTML='<span class="zca-spinner"></span> Saving…'; }
  var data = new FormData();
  data.append('action','zc_save_options');
  data.append('nonce','<?php echo wp_create_nonce("zc_options_nonce"); ?>');
  document.querySelectorAll('[name^="zincelestial_options"]').forEach(function(el){
    var key = el.name.match(/\[(.+)\]/);
    if(key) data.append('options['+key[1]+']', el.type==='checkbox'?(el.checked?'1':'0'):el.value);
  });
  fetch(ajaxurl,{method:'POST',body:data})
    .then(r=>r.json())
    .then(function(d){
      if(btn){ btn.disabled=false; btn.innerHTML='<i class="bi bi-check2"></i> Saved!'; setTimeout(()=>{ btn.innerHTML='<i class="bi bi-floppy"></i> Save All Changes'; },2000); }
      if(!d.success) alert('Save error: '+(d.data||''));
    });
}
function zcaExportOptions(){
  var data = new FormData();
  data.append('action','zc_export_options');
  data.append('nonce','<?php echo wp_create_nonce("zc_options_nonce"); ?>');
  fetch(ajaxurl,{method:'POST',body:data}).then(r=>r.blob()).then(blob=>{
    var a=document.createElement('a'); a.href=URL.createObjectURL(blob);
    a.download='zincelestial-options.json'; a.click();
  });
}
function zcaImportOptions(input){
  var file=input.files[0]; if(!file)return;
  var reader=new FileReader();
  reader.onload=function(e){
    var data=new FormData(); data.append('action','zc_import_options');
    data.append('nonce','<?php echo wp_create_nonce("zc_options_nonce"); ?>');
    data.append('json',e.target.result);
    fetch(ajaxurl,{method:'POST',body:data}).then(r=>r.json()).then(d=>{ if(d.success)location.reload(); else alert(d.data||'Import failed'); });
  };
  reader.readAsText(file);
}
function zcaResetOptions(){
  var data=new FormData(); data.append('action','zc_reset_options');
  data.append('nonce','<?php echo wp_create_nonce("zc_options_nonce"); ?>');
  fetch(ajaxurl,{method:'POST',body:data}).then(r=>r.json()).then(d=>{ if(d.success)location.reload(); else alert(d.data||'Reset failed'); });
}
</script>
