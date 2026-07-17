<?php if(!defined('ABSPATH'))exit;
$opts = get_option('zincelestial_options', zc_default_options());
function zca_osb($o,$k,$f=''){return isset($o[$k])?$o[$k]:$f;}
$sidebars = wp_get_sidebars_widgets();
?>
<div class="zca-wrap">
<div class="zca-page-header">
  <div class="zca-page-header__left">
    <div class="zca-page-header__icon">📑</div>
    <div><div class="zca-page-header__title">Sidebars & Widget Areas</div>
    <div class="zca-page-header__sub">Default sidebar positions, width, and registered widget area overview</div></div>
  </div>
</div>
<div class="zca-content">
  <div class="zca-tabs-nav">
    <button class="zca-tab-btn" data-zc-tab="positions"><span class="zca-tab-icon">📌</span> Positions</button>
    <button class="zca-tab-btn" data-zc-tab="widths"><span class="zca-tab-icon">📏</span> Widths</button>
    <button class="zca-tab-btn" data-zc-tab="areas"><span class="zca-tab-icon">🧩</span> Widget Areas</button>
  </div>
  <div class="zca-tab-panels">

    <div class="zca-tab-panel" data-zc-panel="positions">
      <div class="zca-grid zca-grid--2">
        <div class="zca-card">
          <div class="zca-card__header"><div class="zca-card__icon">📌</div><span class="zca-card__title">Default Sidebar Position</span></div>
          <div class="zca-notice zca-notice--info"><span class="zca-notice__icon">ℹ</span><div>This sets the global default. Individual pages/posts can override via the ZinCelestial Page Options meta box.</div></div>
          <?php
          $contexts = [
            'blog'       => ['Blog / Archive',       'blog_layout'],
            'single'     => ['Single Post',          'single_layout'],
            'page'       => ['Static Page',          'page_layout'],
            'buddypress' => ['BuddyPress Pages',     'bp_layout'],
            'woocommerce'=> ['WooCommerce Shop',     'woo_layout'],
            'bbpress'    => ['bbPress Forums',       'bbp_layout'],
          ];
          foreach($contexts as $ctx => [$label, $key]): ?>
          <div class="zca-field">
            <label class="zca-label"><?php echo esc_html($label); ?></label>
            <select class="zca-select" name="zincelestial_options[<?php echo $key; ?>]" data-option="<?php echo $key; ?>">
              <option value="right-sidebar" <?php selected(zca_osb($opts,$key,'right-sidebar'),'right-sidebar'); ?>>Right Sidebar</option>
              <option value="left-sidebar"  <?php selected(zca_osb($opts,$key),'left-sidebar'); ?>>Left Sidebar</option>
              <option value="both-sidebars" <?php selected(zca_osb($opts,$key),'both-sidebars'); ?>>Both Sidebars</option>
              <option value="full-width"    <?php selected(zca_osb($opts,$key),'full-width'); ?>>Full Width (No Sidebar)</option>
            </select>
          </div>
          <?php endforeach; ?>
        </div>
        <div class="zca-card">
          <div class="zca-card__header"><div class="zca-card__icon">🔩</div><span class="zca-card__title">Panel Toggles</span></div>
          <div class="zca-toggle-row">
            <div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Left Panel</div><div class="zca-toggle-row__desc">Fixed left slide-out panel for navigation/widgets</div></div>
            <label class="zca-toggle"><input type="checkbox" name="zincelestial_options[left_panel_enabled]" <?php checked(zca_osb($opts,'left_panel_enabled','0'),'1'); ?>><span class="zca-toggle-slider"></span></label>
          </div>
          <div class="zca-toggle-row">
            <div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Right Panel</div><div class="zca-toggle-row__desc">Fixed right slide-out panel (suggestions, ads, etc.)</div></div>
            <label class="zca-toggle"><input type="checkbox" name="zincelestial_options[right_panel_enabled]" <?php checked(zca_osb($opts,'right_panel_enabled','0'),'1'); ?>><span class="zca-toggle-slider"></span></label>
          </div>
          <div class="zca-field">
            <label class="zca-label">Left Panel Width (px)</label>
            <input type="number" class="zca-input" name="zincelestial_options[left_panel_width]" value="<?php echo esc_attr(zca_osb($opts,'left_panel_width','280')); ?>" min="200" max="600">
          </div>
          <div class="zca-field">
            <label class="zca-label">Right Panel Width (px)</label>
            <input type="number" class="zca-input" name="zincelestial_options[right_panel_width]" value="<?php echo esc_attr(zca_osb($opts,'right_panel_width','280')); ?>" min="200" max="600">
          </div>
        </div>
      </div>
    </div>

    <div class="zca-tab-panel" data-zc-panel="widths">
      <div class="zca-card">
        <div class="zca-card__header"><div class="zca-card__icon">📏</div><span class="zca-card__title">Sidebar Widths</span></div>
        <div class="zca-grid zca-grid--2">
          <?php
          $widths = [
            ['Right Sidebar Width (px)','sidebar_right_width','300'],
            ['Left Sidebar Width (px)', 'sidebar_left_width', '280'],
            ['BP Sidebar Width (px)',   'sidebar_bp_width',   '280'],
            ['WC Sidebar Width (px)',   'sidebar_woo_width',  '280'],
          ];
          foreach($widths as [$label,$key,$def]): ?>
          <div class="zca-field">
            <label class="zca-label"><?php echo esc_html($label); ?></label>
            <div class="input-group">
              <input type="number" class="zca-input" name="zincelestial_options[<?php echo $key; ?>]" value="<?php echo esc_attr(zca_osb($opts,$key,$def)); ?>" min="200" max="600">
              <span class="zca-input-addon">px</span>
            </div>
            <div class="zca-field-hint">Min 200 — Max 600</div>
          </div>
          <?php endforeach; ?>
        </div>
        <div class="zca-toggle-row">
          <div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Sticky Sidebar</div><div class="zca-toggle-row__desc">Keep sidebar in view while scrolling the main content</div></div>
          <label class="zca-toggle"><input type="checkbox" name="zincelestial_options[sidebar_sticky]" <?php checked(zca_osb($opts,'sidebar_sticky','0'),'1'); ?>><span class="zca-toggle-slider"></span></label>
        </div>
        <div class="zca-field">
          <label class="zca-label">Sticky Offset (px from top)</label>
          <input type="number" class="zca-input" name="zincelestial_options[sidebar_sticky_offset]" value="<?php echo esc_attr(zca_osb($opts,'sidebar_sticky_offset','90')); ?>" min="0" max="300">
          <div class="zca-field-hint">Accounts for sticky header height. Default: 90px</div>
        </div>
      </div>
    </div>

    <div class="zca-tab-panel" data-zc-panel="areas">
      <div class="zca-card">
        <div class="zca-card__header"><div class="zca-card__icon">🧩</div><span class="zca-card__title">Registered Widget Areas</span></div>
        <?php
        $areas = [
          'zc-sidebar-right'      => 'Right Sidebar',
          'zc-sidebar-left'       => 'Left Sidebar',
          'zc-sidebar-buddypress' => 'BuddyPress Sidebar',
          'zc-right-panel-widget' => 'Right Panel Widgets',
          'zc-footer-1'           => 'Footer Column 1',
          'zc-footer-2'           => 'Footer Column 2',
          'zc-footer-3'           => 'Footer Column 3',
          'zc-footer-4'           => 'Footer Column 4',
          'zc-woo-sidebar'        => 'WooCommerce Sidebar',
          'zc-bbpress-sidebar'    => 'bbPress Sidebar',
          'zc-shop-banner'        => 'Shop Banner',
        ];
        ?>
        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:10px;padding:16px;">
          <?php foreach($areas as $id => $label):
            $has = !empty($sidebars[$id]);
            $count = $has ? count($sidebars[$id]) : 0;
          ?>
          <div style="background:<?php echo $has?'rgba(52,211,153,.06)':'rgba(100,116,139,.06)'; ?>;border:1px solid <?php echo $has?'rgba(52,211,153,.25)':'rgba(100,116,139,.2)'; ?>;border-radius:8px;padding:10px;">
            <div style="color:<?php echo $has?'#34d399':'#64748b'; ?>;font-size:.65rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;"><?php echo $has?'● ACTIVE':'○ EMPTY'; ?></div>
            <div style="color:var(--zca-text,#e2e8f0);font-size:.8rem;font-weight:600;margin-top:4px;"><?php echo esc_html($label); ?></div>
            <div style="color:var(--zca-muted,#94a3b8);font-size:.7rem;margin-top:2px;"><?php echo esc_html($id); ?></div>
            <?php if($has): ?><div style="color:#34d399;font-size:.7rem;margin-top:4px;"><?php echo $count; ?> widget<?php echo $count!==1?'s':''; ?></div><?php endif; ?>
          </div>
          <?php endforeach; ?>
        </div>
        <div class="zca-card__footer">
          <a href="<?php echo esc_url(admin_url('widgets.php')); ?>" class="zca-btn zca-btn--secondary zca-btn--sm"><i class="bi bi-puzzle me-1"></i> Manage Widgets</a>
        </div>
      </div>
    </div>

  </div>
  <div class="zca-card-actions">
    <button class="zca-btn zca-btn--primary" onclick="zcaSaveOptions()"><i class="bi bi-floppy me-1"></i> Save Sidebar Settings</button>
    <button class="zca-btn zca-btn--ghost" onclick="zcaResetSection('sidebars')">Reset Section</button>
  </div>
</div>
</div>
