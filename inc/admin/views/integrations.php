<?php if(!defined('ABSPATH'))exit;
$opts = get_option('zincelestial_options', zc_default_options());
function zca_oint($o,$k,$f=''){return isset($o[$k])?$o[$k]:$f;}
$active_plugins = apply_filters('active_plugins', get_option('active_plugins',[]));
function zc_plugin_active_check($slug){ return in_array($slug, apply_filters('active_plugins', get_option('active_plugins',[])), true); }
?>
<div class="zca-wrap">
<div class="zca-page-header">
  <div class="zca-page-header__left">
    <div class="zca-page-header__icon">🔗</div>
    <div><div class="zca-page-header__title">Integrations</div>
    <div class="zca-page-header__sub">Third-party plugin compatibility and frontend styling toggles</div></div>
  </div>
</div>
<div class="zca-content">
  <?php
  $integrations = [
    ['gamipress',   'GamiPress',            'gamipress/gamipress.php',          '🏆', 'Points, badges, ranks and achievements system.'],
    ['mycred',      'myCred',               'mycred/mycred.php',                '💰', 'Points management and rewards.'],
    ['zcreds',      'ZCreds',               'zcreds/zcreds.php',                '💎', 'ZinCelestial Credits system.'],
    ['elementor',   'Elementor',            'elementor/elementor.php',          '🎨', 'Page builder — compatibility mode.'],
    ['lifterlms',   'LifterLMS',            'lifterlms/lifterlms.php',          '📚', 'LMS courses and lessons.'],
    ['learndash',   'LearnDash',            'sfwd-lms/sfwd_lms.php',            '🎓', 'LMS courses, lessons, and quizzes.'],
    ['jobmanager',  'WP Job Manager',       'wp-job-manager/wp-job-manager.php','💼', 'Job listings and applications.'],
    ['edd',         'Easy Digital Downloads','easy-digital-downloads/easy-digital-downloads.php','⬇️', 'Digital product sales.'],
    ['dokan',       'Dokan',                'dokan-lite/dokan.php',             '🏪', 'Multi-vendor marketplace.'],
    ['pmprogate',   'Paid Memberships Pro', 'paid-memberships-pro/paid-memberships-pro.php','🔑', 'Membership access control.'],
    ['wcfm',        'WCFM Marketplace',     'wc-frontend-manager/wc_frontend_manager.php','🛒', 'Frontend vendor management.'],
    ['peepso',      'PeepSo',               'peepso/peepso.php',                '👥', 'Social community plugin.'],
    ['rtmedia',     'rtMedia',              'buddypress-media/index.php',        '🎬', 'Media uploads in BuddyPress.'],
  ];
  ?>

  <div class="zca-notice zca-notice--info"><span class="zca-notice__icon">ℹ</span><div>Enable frontend CSS/JS for each plugin. ZinCelestial only loads integration styles when the plugin is active. <strong>All defaults: Off</strong> — only enable what you use.</div></div>

  <div class="zca-grid zca-grid--3">
    <?php foreach($integrations as [$key, $name, $file, $icon, $desc]):
      $is_active = zc_plugin_active_check($file);
      $opt_key = 'integration_' . $key;
    ?>
    <div class="zca-card <?php echo $is_active ? '' : 'zca-card--dimmed'; ?>">
      <div class="zca-card__header">
        <div class="zca-card__icon"><?php echo $icon; ?></div>
        <span class="zca-card__title"><?php echo esc_html($name); ?></span>
        <span class="zca-badge <?php echo $is_active ? 'zca-badge--success' : 'zca-badge--muted'; ?>" style="margin-left:auto;font-size:.6rem;"><?php echo $is_active ? '● Active' : '○ Inactive'; ?></span>
      </div>
      <div style="padding:0 var(--zca-space-5) var(--zca-space-3);font-size:.8rem;color:var(--zca-muted,#94a3b8);"><?php echo esc_html($desc); ?></div>
      <div class="zca-toggle-row" style="padding:0 var(--zca-space-5) var(--zca-space-4);">
        <div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Enable ZC Styles</div></div>
        <label class="zca-toggle"><input type="checkbox" name="zincelestial_options[<?php echo $opt_key; ?>]" <?php checked(zca_oint($opts,$opt_key,'0'),'1'); ?> <?php echo !$is_active?'disabled':''; ?>><span class="zca-toggle-slider"></span></label>
      </div>
    </div>
    <?php endforeach; ?>
  </div>

  <div class="zca-card-actions">
    <button class="zca-btn zca-btn--primary" onclick="zcaSaveOptions()"><i class="bi bi-floppy me-1"></i> Save Integration Settings</button>
    <button class="zca-btn zca-btn--ghost" onclick="zcaResetSection('integrations')">Reset Section</button>
  </div>
</div>
</div>
