<?php if(!defined('ABSPATH'))exit;
$opts = get_option('zincelestial_options', zc_default_options());
$current_scheme = isset($opts['default_scheme']) ? $opts['default_scheme'] : 'cosmic';
$schemes = [
  ['default',  'Default',   '#7c6ff7','#00d4ff','#07070f', false, 'The original ZinCelestial deep-space dark theme.'],
  ['slate',    'Slate',     '#64748b','#94a3b8','#0f172a', false, 'Cool slate blues — minimal and focused.'],
  ['forest',   'Forest',    '#22c55e','#4ade80','#052e16', false, 'Deep forest green — organic and fresh.'],
  ['cosmic',   'Cosmic',    '#8b5cf6','#c4b5fd','#0d0020', true,  'Deep purple cosmic nebula — premium signature theme.'],
  ['aurora',   'Aurora',    '#10b981','#6ee7b7','#001a0f', true,  'Northern lights — emerald and teal gradients.'],
  ['nova',     'Nova',      '#f59e0b','#fcd34d','#1a0a00', true,  'Supernova amber gold — warm and energetic.'],
  ['zenith',   'Zenith',    '#06b6d4','#67e8f9','#001a1f', true,  'Crystal cyan peak — crisp and futuristic.'],
  ['ember',    'Ember',     '#ef4444','#fca5a5','#1a0000', true,  'Ember red flame — bold and passionate.'],
  ['twilight', 'Twilight',  '#e879f9','#f5d0fe','#1a0020', true,  'Twilight magenta — dreamy and elegant.'],
];
?>
<div class="zca-wrap">
<div class="zca-page-header">
  <div class="zca-page-header__left">
    <div class="zca-page-header__icon">🎭</div>
    <div><div class="zca-page-header__title">Templates & Schemes</div>
    <div class="zca-page-header__sub">3 free + 6 premium color schemes — each inherits full ZinCelestial design system</div></div>
  </div>
  <div class="zca-page-header__right">
    <span class="zca-badge zca-badge--version">Active: <?php echo esc_html(ucfirst($current_scheme)); ?></span>
  </div>
</div>
<div class="zca-content">

  <div class="zca-notice zca-notice--primary"><span class="zca-notice__icon">🎨</span><div><div class="zca-notice__title">Click any scheme to activate it instantly</div>All CSS custom properties are inherited from the main theme. Schemes override color tokens only — all other settings remain unchanged. Users can be allowed to switch schemes from the frontend.</div></div>

  <!-- Free Schemes -->
  <div class="zca-section">
    <div class="zca-section-header">
      <div class="zca-section-header__icon">🆓</div>
      <span class="zca-section-header__title">Free Schemes (3)</span>
      <span class="zca-chip zca-chip--success" style="margin-left:auto">Available to All Users</span>
    </div>
    <div class="zca-grid zca-grid--3">
      <?php foreach($schemes as $s): if($s[4]) continue; ?>
      <div class="zca-scheme-card <?php echo $current_scheme===$s[0]?'is-active':''; ?>" data-scheme="<?php echo esc_attr($s[0]); ?>">
        <div class="zca-scheme-preview" style="background:linear-gradient(135deg,<?php echo esc_attr($s[2]); ?>,<?php echo esc_attr($s[3]); ?>);"></div>
        <div class="zca-scheme-name"><?php echo esc_html($s[1]); ?></div>
        <div class="zca-scheme-meta"><?php echo esc_html($s[6]); ?></div>
        <div style="display:flex;gap:6px;margin-top:10px;">
          <div style="width:16px;height:16px;border-radius:50%;background:<?php echo esc_attr($s[2]); ?>;border:2px solid rgba(255,255,255,0.2);"></div>
          <div style="width:16px;height:16px;border-radius:50%;background:<?php echo esc_attr($s[3]); ?>;border:2px solid rgba(255,255,255,0.2);"></div>
          <div style="width:16px;height:16px;border-radius:50%;background:<?php echo esc_attr($s[4]); ?>;border:2px solid rgba(255,255,255,0.2);"></div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>

  <!-- Premium Schemes -->
  <div class="zca-section">
    <div class="zca-section-header">
      <div class="zca-section-header__icon">⭐</div>
      <span class="zca-section-header__title">Premium Schemes (6)</span>
      <span class="zca-chip zca-chip--warning" style="margin-left:auto">Premium Members Only</span>
    </div>
    <div class="zca-grid zca-grid--3">
      <?php foreach($schemes as $s): if(!$s[4]) continue; ?>
      <div class="zca-scheme-card <?php echo $current_scheme===$s[0]?'is-active':''; ?>" data-scheme="<?php echo esc_attr($s[0]); ?>">
        <span class="zca-scheme-premium-badge">Premium</span>
        <div class="zca-scheme-preview" style="background:linear-gradient(135deg,<?php echo esc_attr($s[2]); ?>,<?php echo esc_attr($s[3]); ?>);"></div>
        <div class="zca-scheme-name"><?php echo esc_html($s[1]); ?></div>
        <div class="zca-scheme-meta"><?php echo esc_html($s[6]); ?></div>
        <div style="display:flex;gap:6px;margin-top:10px;">
          <div style="width:16px;height:16px;border-radius:50%;background:<?php echo esc_attr($s[2]); ?>;border:2px solid rgba(255,255,255,0.2);"></div>
          <div style="width:16px;height:16px;border-radius:50%;background:<?php echo esc_attr($s[3]); ?>;border:2px solid rgba(255,255,255,0.2);"></div>
          <div style="width:16px;height:16px;border-radius:50%;background:<?php echo esc_attr($s[4]); ?>;border:2px solid rgba(255,255,255,0.2);"></div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>

  <!-- Per-Scheme Settings -->
  <div class="zca-card">
    <div class="zca-card__header"><div class="zca-card__icon">⚙</div><span class="zca-card__title">Scheme Access Settings</span></div>
    <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Allow Frontend Scheme Switcher</div><div class="zca-toggle-row__desc">Members can change their personal scheme from the frontend profile settings</div></div><label class="zca-toggle"><input type="checkbox" name="show_scheme_switcher" data-option="show_scheme_switcher" <?php checked(!empty($opts['show_scheme_switcher'])&&$opts['show_scheme_switcher']!=='0'); ?>><span class="zca-toggle__slider"></span></label></div>
    <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Require Premium for Premium Schemes</div><div class="zca-toggle-row__desc">Gate premium schemes behind PMPro/UMP membership</div></div><label class="zca-toggle"><input type="checkbox" name="scheme_premium_gate" data-option="scheme_premium_gate" <?php checked(!empty($opts['scheme_premium_gate'])&&$opts['scheme_premium_gate']!=='0'); ?>><span class="zca-toggle__slider"></span></label></div>
    <div class="zca-field zca-mt">
      <label class="zca-label">Scheme Switcher Membership Level<span class="zca-hint">PMPro level ID required to access premium schemes</span></label>
      <input type="number" class="zca-input" name="scheme_premium_level_id" data-option="scheme_premium_level_id" value="<?php echo esc_attr(!empty($opts['scheme_premium_level_id'])?$opts['scheme_premium_level_id']:'1'); ?>" style="max-width:120px;">
    </div>
  </div>

</div>
</div>
