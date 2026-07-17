<?php if(!defined('ABSPATH'))exit;
$opts = get_option('zincelestial_options', zc_default_options());
function zca_oft($o,$k,$f=''){return isset($o[$k])?$o[$k]:$f;}
?>
<div class="zca-wrap">
<div class="zca-page-header">
  <div class="zca-page-header__left">
    <div class="zca-page-header__icon">🔻</div>
    <div><div class="zca-page-header__title">Footer</div>
    <div class="zca-page-header__sub">Widget columns, bottom bar, copyright, and footer styling</div></div>
  </div>
</div>
<div class="zca-content">
  <div class="zca-tabs-nav">
    <button class="zca-tab-btn" data-zc-tab="layout"><span class="zca-tab-icon">📐</span> Layout</button>
    <button class="zca-tab-btn" data-zc-tab="widgets"><span class="zca-tab-icon">🧩</span> Widgets</button>
    <button class="zca-tab-btn" data-zc-tab="bottom"><span class="zca-tab-icon">📋</span> Bottom Bar</button>
    <button class="zca-tab-btn" data-zc-tab="style"><span class="zca-tab-icon">🎨</span> Style</button>
  </div>
  <div class="zca-tab-panels">

    <div class="zca-tab-panel" data-zc-panel="layout">
      <div class="zca-grid zca-grid--2">
        <div class="zca-card">
          <div class="zca-card__header"><div class="zca-card__icon">📐</div><span class="zca-card__title">Footer Layout</span></div>
          <div class="zca-field">
            <label class="zca-label">Widget Columns</label>
            <select class="zca-select" name="zincelestial_options[footer_columns]" data-option="footer_columns">
              <?php foreach([1,2,3,4] as $n): ?>
              <option value="<?php echo $n; ?>" <?php selected(zca_oft($opts,'footer_columns','4'),$n); ?>><?php echo $n; ?> Column<?php echo $n>1?'s':''; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="zca-field">
            <label class="zca-label">Footer Width</label>
            <select class="zca-select" name="zincelestial_options[footer_width]" data-option="footer_width">
              <option value="container" <?php selected(zca_oft($opts,'footer_width','container'),'container'); ?>>Contained (1200px)</option>
              <option value="container-fluid" <?php selected(zca_oft($opts,'footer_width'),'container-fluid'); ?>>Full Width</option>
              <option value="container-xl" <?php selected(zca_oft($opts,'footer_width'),'container-xl'); ?>>Extra Wide (1400px)</option>
            </select>
          </div>
          <div class="zca-toggle-row">
            <div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Enable Footer Widgets</div></div>
            <label class="zca-toggle"><input type="checkbox" name="zincelestial_options[footer_widgets_enabled]" <?php checked(zca_oft($opts,'footer_widgets_enabled','1'),'1'); ?>><span class="zca-toggle-slider"></span></label>
          </div>
          <div class="zca-toggle-row">
            <div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Enable Footer Bottom Bar</div></div>
            <label class="zca-toggle"><input type="checkbox" name="zincelestial_options[footer_bottom_enabled]" <?php checked(zca_oft($opts,'footer_bottom_enabled','1'),'1'); ?>><span class="zca-toggle-slider"></span></label>
          </div>
          <div class="zca-toggle-row">
            <div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Scroll To Top Button</div><div class="zca-toggle-row__desc">Floating button to scroll back to top of page</div></div>
            <label class="zca-toggle"><input type="checkbox" name="zincelestial_options[scroll_top_enabled]" <?php checked(zca_oft($opts,'scroll_top_enabled','1'),'1'); ?>><span class="zca-toggle-slider"></span></label>
          </div>
          <div class="zca-field">
            <label class="zca-label">Scroll-to-Top Position</label>
            <select class="zca-select" name="zincelestial_options[scroll_top_position]" data-option="scroll_top_position">
              <option value="bottom-right" <?php selected(zca_oft($opts,'scroll_top_position','bottom-right'),'bottom-right'); ?>>Bottom Right</option>
              <option value="bottom-left" <?php selected(zca_oft($opts,'scroll_top_position'),'bottom-left'); ?>>Bottom Left</option>
              <option value="bottom-center" <?php selected(zca_oft($opts,'scroll_top_position'),'bottom-center'); ?>>Bottom Center</option>
            </select>
          </div>
        </div>
        <div class="zca-card">
          <div class="zca-card__header"><div class="zca-card__icon">🖼️</div><span class="zca-card__title">Footer Brand</span></div>
          <div class="zca-toggle-row">
            <div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Show Logo in Footer</div></div>
            <label class="zca-toggle"><input type="checkbox" name="zincelestial_options[footer_show_logo]" <?php checked(zca_oft($opts,'footer_show_logo','1'),'1'); ?>><span class="zca-toggle-slider"></span></label>
          </div>
          <div class="zca-field">
            <label class="zca-label">Footer Logo URL</label>
            <input type="url" class="zca-input" name="zincelestial_options[footer_logo_url]" value="<?php echo esc_attr(zca_oft($opts,'footer_logo_url','')); ?>" placeholder="Leave blank to use theme logo">
          </div>
          <div class="zca-field">
            <label class="zca-label">Footer Tagline</label>
            <input type="text" class="zca-input" name="zincelestial_options[footer_tagline]" value="<?php echo esc_attr(zca_oft($opts,'footer_tagline','')); ?>" placeholder="Empowering communities worldwide">
          </div>
        </div>
      </div>
    </div>

    <div class="zca-tab-panel" data-zc-panel="widgets">
      <div class="zca-notice zca-notice--info"><span class="zca-notice__icon">ℹ</span><div>Footer widget areas are registered in <strong>Appearance → Widgets</strong>. ZinCelestial registers up to 4 footer columns. The number of visible columns is controlled by the Layout tab setting.</div></div>
      <div class="zca-card">
        <div class="zca-card__header"><div class="zca-card__icon">🧩</div><span class="zca-card__title">Footer Widget Areas</span></div>
        <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:12px;padding:16px;">
          <?php for($i=1;$i<=4;$i++): ?>
          <div style="background:rgba(124,111,247,.06);border:1px dashed var(--zca-border,#2a2a4a);border-radius:10px;padding:12px;text-align:center;">
            <div style="color:var(--zca-primary,#7c6ff7);font-size:.7rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;">Footer Column <?php echo $i; ?></div>
            <div style="color:var(--zca-muted,#94a3b8);font-size:.75rem;margin-top:6px;">zc-footer-<?php echo $i; ?></div>
            <?php if(is_active_sidebar('zc-footer-'.$i)): ?>
            <div style="color:#34d399;font-size:.7rem;margin-top:6px;">● Active</div>
            <?php else: ?>
            <div style="color:#64748b;font-size:.7rem;margin-top:6px;">○ Empty</div>
            <?php endif; ?>
          </div>
          <?php endfor; ?>
        </div>
        <div class="zca-card__footer">
          <a href="<?php echo esc_url(admin_url('widgets.php')); ?>" class="zca-btn zca-btn--secondary zca-btn--sm"><i class="bi bi-puzzle me-1"></i> Manage Widgets</a>
        </div>
      </div>
    </div>

    <div class="zca-tab-panel" data-zc-panel="bottom">
      <div class="zca-card">
        <div class="zca-card__header"><div class="zca-card__icon">📋</div><span class="zca-card__title">Bottom Bar Content</span></div>
        <div class="zca-field">
          <label class="zca-label">Copyright Text <span class="zca-field-hint d-inline">(supports <code>{year}</code> token)</span></label>
          <input type="text" class="zca-input" name="zincelestial_options[footer_copyright]" value="<?php echo esc_attr(zca_oft($opts,'footer_copyright','© {year} '.get_bloginfo('name').'. All rights reserved.')); ?>">
        </div>
        <div class="zca-field">
          <label class="zca-label">Footer Bottom Alignment</label>
          <select class="zca-select" name="zincelestial_options[footer_bottom_align]" data-option="footer_bottom_align">
            <option value="space-between" <?php selected(zca_oft($opts,'footer_bottom_align','space-between'),'space-between'); ?>>Copyright Left, Links Right</option>
            <option value="center" <?php selected(zca_oft($opts,'footer_bottom_align'),'center'); ?>>Centered</option>
            <option value="flex-start" <?php selected(zca_oft($opts,'footer_bottom_align'),'flex-start'); ?>>All Left</option>
          </select>
        </div>
        <div class="zca-toggle-row">
          <div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Show Footer Menu</div><div class="zca-toggle-row__desc">Display the "Footer Menu" nav location in the bottom bar</div></div>
          <label class="zca-toggle"><input type="checkbox" name="zincelestial_options[footer_bottom_menu]" <?php checked(zca_oft($opts,'footer_bottom_menu','1'),'1'); ?>><span class="zca-toggle-slider"></span></label>
        </div>
        <div class="zca-toggle-row">
          <div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Show Social Icons</div></div>
          <label class="zca-toggle"><input type="checkbox" name="zincelestial_options[footer_social_icons]" <?php checked(zca_oft($opts,'footer_social_icons','0'),'1'); ?>><span class="zca-toggle-slider"></span></label>
        </div>
      </div>
    </div>

    <div class="zca-tab-panel" data-zc-panel="style">
      <div class="zca-card">
        <div class="zca-card__header"><div class="zca-card__icon">🎨</div><span class="zca-card__title">Footer Colors</span></div>
        <div class="zca-notice zca-notice--info"><span class="zca-notice__icon">ℹ</span><div>Footer inherits your active color scheme by default. Override specific colors here.</div></div>
        <div class="zca-grid zca-grid--2">
          <div class="zca-field">
            <label class="zca-label">Footer Background</label>
            <div class="zca-color-row">
              <input type="color" value="<?php echo esc_attr(zca_oft($opts,'footer_bg_color','#0f0f1f')); ?>" name="zincelestial_options[footer_bg_color]">
              <input type="text"  value="<?php echo esc_attr(zca_oft($opts,'footer_bg_color','#0f0f1f')); ?>" class="zca-input zca-input--sm">
            </div>
          </div>
          <div class="zca-field">
            <label class="zca-label">Footer Text Color</label>
            <div class="zca-color-row">
              <input type="color" value="<?php echo esc_attr(zca_oft($opts,'footer_text_color','#94a3b8')); ?>" name="zincelestial_options[footer_text_color]">
              <input type="text"  value="<?php echo esc_attr(zca_oft($opts,'footer_text_color','#94a3b8')); ?>" class="zca-input zca-input--sm">
            </div>
          </div>
        </div>
        <div class="zca-field">
          <label class="zca-label">Footer Top Padding (px)</label>
          <input type="range" class="form-range" name="zincelestial_options[footer_pad_top]" min="0" max="120" value="<?php echo esc_attr(zca_oft($opts,'footer_pad_top','60')); ?>" id="footer-pad-top">
          <span id="footer-pad-top-val"><?php echo esc_attr(zca_oft($opts,'footer_pad_top','60')); ?></span>px
        </div>
      </div>
    </div>

  </div><!-- /.zca-tab-panels -->
  <div class="zca-card-actions">
    <button class="zca-btn zca-btn--primary" onclick="zcaSaveOptions()"><i class="bi bi-floppy me-1"></i> Save Footer Settings</button>
    <button class="zca-btn zca-btn--ghost" onclick="zcaResetSection('footer')"><i class="bi bi-arrow-counterclockwise me-1"></i> Reset Section</button>
  </div>
</div>
</div>
