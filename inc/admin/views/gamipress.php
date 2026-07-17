<?php if(!defined('ABSPATH'))exit;
$opts = get_option('zincelestial_options', zc_default_options());
function zca_ogp($o,$k,$f=''){return isset($o[$k])?$o[$k]:$f;}
$gp_active = function_exists('gamipress_get_points_types');
?>
<div class="zca-wrap">
<div class="zca-page-header">
  <div class="zca-page-header__left">
    <div class="zca-page-header__icon">🏆</div>
    <div><div class="zca-page-header__title">GamiPress Header Bar</div>
    <div class="zca-page-header__sub">Vikinger-style XP bar, points, rank, badges, level display</div></div>
  </div>
  <div class="zca-page-header__right">
    <?php if($gp_active): ?>
    <span class="zca-badge" style="background:rgba(251,191,36,0.2);color:#fbbf24;border:1px solid rgba(251,191,36,0.35);">⭐ GamiPress Active</span>
    <?php else: ?>
    <span class="zca-badge" style="background:rgba(248,113,113,0.2);color:#f87171;border:1px solid rgba(248,113,113,0.35);">⚠ GamiPress Inactive</span>
    <?php endif; ?>
  </div>
</div>
<div class="zca-content">

  <!-- Preview -->
  <div class="zca-card zca-mb" style="background:linear-gradient(90deg,rgba(124,111,247,0.15),rgba(0,212,255,0.08));border-color:rgba(124,111,247,0.3);">
    <div class="zca-card__header"><div class="zca-card__icon">👁</div><span class="zca-card__title">Live Bar Preview (Vikinger bar-progress-info style)</span></div>
    <div style="display:flex;align-items:center;gap:14px;padding:14px 16px;background:var(--zca-surface);border-radius:var(--zca-radius-md);border:1px solid var(--zca-border);flex-wrap:wrap;">
      <div style="display:flex;align-items:center;gap:8px;">
        <div style="width:36px;height:36px;border-radius:50%;background:var(--zca-grad-main);display:flex;align-items:center;justify-content:center;font-size:16px;">👤</div>
        <div style="font-size:12px;font-weight:600;color:var(--zca-text);">admin</div>
      </div>
      <div style="flex:1;min-width:160px;">
        <div style="font-size:10px;color:var(--zca-muted);margin-bottom:3px;">Level 5 · XP: 2,400 / 3,000</div>
        <div style="height:6px;background:var(--zca-surface);border-radius:999px;border:1px solid var(--zca-border);overflow:hidden;">
          <div style="width:80%;height:100%;background:var(--zca-grad-main);border-radius:999px;"></div>
        </div>
      </div>
      <div style="display:flex;gap:10px;flex-wrap:wrap;">
        <span style="font-size:11px;font-weight:600;background:rgba(124,111,247,0.15);color:var(--zca-accent);border:1px solid rgba(124,111,247,0.25);padding:3px 10px;border-radius:999px;">⭐ 1,250 GZCreds</span>
        <span style="font-size:11px;font-weight:600;background:rgba(239,68,68,0.12);color:#f87171;border:1px solid rgba(239,68,68,0.25);padding:3px 10px;border-radius:999px;">💎 80 Rubies</span>
        <span style="font-size:11px;font-weight:600;background:rgba(251,191,36,0.12);color:#fbbf24;border:1px solid rgba(251,191,36,0.25);padding:3px 10px;border-radius:999px;">🥇 Gold Rank</span>
        <span style="font-size:11px;font-weight:600;background:rgba(52,211,153,0.12);color:#34d399;border:1px solid rgba(52,211,153,0.25);padding:3px 10px;border-radius:999px;">🏆 24 Badges</span>
      </div>
    </div>
  </div>

  <div class="zca-tabs-nav">
    <button class="zca-tab-btn" data-zc-tab="display"><span class="zca-tab-icon">👁</span> Display</button>
    <button class="zca-tab-btn" data-zc-tab="points"><span class="zca-tab-icon">💰</span> Points Types</button>
    <button class="zca-tab-btn" data-zc-tab="rank"><span class="zca-tab-icon">🥇</span> Rank & Level</button>
    <button class="zca-tab-btn" data-zc-tab="style"><span class="zca-tab-icon">🎨</span> Style</button>
  </div>
  <div class="zca-tab-panels">

    <div class="zca-tab-panel" data-zc-panel="display">
      <div class="zca-grid zca-grid--2">
        <div class="zca-card">
          <div class="zca-card__header"><div class="zca-card__icon">👁</div><span class="zca-card__title">Bar Visibility</span></div>
          <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Enable GamiPress Header Bar</div><div class="zca-toggle-row__desc">Show the Vikinger-style progress bar in header</div></div><label class="zca-toggle"><input type="checkbox" name="show_gamipress_bar" data-option="show_gamipress_bar" <?php checked(zca_ogp($opts,'show_gamipress_bar','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
          <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Show to Guests</div><div class="zca-toggle-row__desc">Show bar to non-logged-in users (with login prompt)</div></div><label class="zca-toggle"><input type="checkbox" name="gp_bar_show_guests" data-option="gp_bar_show_guests" <?php checked(zca_ogp($opts,'gp_bar_show_guests','0'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
          <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Collapsible Bar</div><div class="zca-toggle-row__desc">Users can minimize the GamiPress bar</div></div><label class="zca-toggle"><input type="checkbox" name="gp_bar_collapsible" data-option="gp_bar_collapsible" <?php checked(zca_ogp($opts,'gp_bar_collapsible','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
          <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">AJAX Refresh</div><div class="zca-toggle-row__desc">Auto-refresh bar stats without page reload</div></div><label class="zca-toggle"><input type="checkbox" name="gp_ajax_refresh" data-option="gp_ajax_refresh" <?php checked(zca_ogp($opts,'gp_ajax_refresh','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
          <div class="zca-field">
            <label class="zca-label">Refresh Interval<span class="zca-hint">Seconds between AJAX updates</span></label>
            <div class="zca-slider-wrap">
              <input type="range" class="zca-slider" name="gp_refresh_interval" data-option="gp_refresh_interval" min="10" max="120" value="<?php echo esc_attr(zca_ogp($opts,'gp_refresh_interval','30')); ?>" data-unit="s">
              <span class="zca-slider-value"><?php echo esc_attr(zca_ogp($opts,'gp_refresh_interval','30')); ?>s</span>
            </div>
          </div>
        </div>
        <div class="zca-card">
          <div class="zca-card__header"><div class="zca-card__icon">📊</div><span class="zca-card__title">Bar Elements</span></div>
          <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Show Avatar</div><div class="zca-toggle-row__desc">User avatar thumbnail in bar</div></div><label class="zca-toggle"><input type="checkbox" name="gp_show_avatar" data-option="gp_show_avatar" <?php checked(zca_ogp($opts,'gp_show_avatar','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
          <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Show XP Progress Bar</div><div class="zca-toggle-row__desc">Horizontal XP progress bar with level</div></div><label class="zca-toggle"><input type="checkbox" name="gp_show_xp_bar" data-option="gp_show_xp_bar" <?php checked(zca_ogp($opts,'gp_show_xp_bar','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
          <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Show Level</div><div class="zca-toggle-row__desc">Display current level number</div></div><label class="zca-toggle"><input type="checkbox" name="gp_show_level" data-option="gp_show_level" <?php checked(zca_ogp($opts,'gp_show_level','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
          <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Show Rank</div><div class="zca-toggle-row__desc">Display current rank title badge</div></div><label class="zca-toggle"><input type="checkbox" name="gp_show_rank" data-option="gp_show_rank" <?php checked(zca_ogp($opts,'gp_show_rank','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
          <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Show Badges Count</div><div class="zca-toggle-row__desc">Show "N Badges" count in bar</div></div><label class="zca-toggle"><input type="checkbox" name="gp_show_badges" data-option="gp_show_badges" <?php checked(zca_ogp($opts,'gp_show_badges','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
        </div>
      </div>
    </div>

    <div class="zca-tab-panel" data-zc-panel="points">
      <div class="zca-card">
        <div class="zca-card__header"><div class="zca-card__icon">💰</div><span class="zca-card__title">4 Point Types</span></div>
        <div class="zca-notice zca-notice--info"><span class="zca-notice__icon">ℹ</span><div>Toggle which point types are displayed in the GamiPress header bar. You have 4 point types: GZCreds, Rubies, Special ZCreds, and ZCreds.</div></div>
        <div class="zca-table-wrap">
          <table class="zca-table">
            <thead><tr><th>Point Type</th><th>Icon</th><th>Label Override</th><th>Show in Bar</th><th>Show on Profile</th></tr></thead>
            <tbody>
            <?php
            $point_types = [
              ['gzcreds',       'GZCreds',       '⭐', 'gp_show_gzcreds'],
              ['rubies',        'Rubies',         '💎', 'gp_show_rubies'],
              ['special_zcreds','Special ZCreds', '✨', 'gp_show_special_zcreds'],
              ['zcreds',        'ZCreds',         '🪙', 'gp_show_zcreds'],
            ];
            foreach($point_types as $pt):
            ?>
            <tr>
              <td><strong><?php echo esc_html($pt[1]); ?></strong></td>
              <td style="font-size:18px;"><?php echo $pt[2]; ?></td>
              <td><input type="text" class="zca-input" name="gp_label_<?php echo $pt[0]; ?>" data-option="gp_label_<?php echo $pt[0]; ?>" value="<?php echo esc_attr(zca_ogp($opts,'gp_label_'.$pt[0],$pt[1])); ?>" style="width:120px;" placeholder="<?php echo esc_attr($pt[1]); ?>"></td>
              <td><label class="zca-toggle"><input type="checkbox" name="<?php echo $pt[3]; ?>" data-option="<?php echo $pt[3]; ?>" <?php checked(zca_ogp($opts,$pt[3],'1'),'1'); ?>><span class="zca-toggle__slider"></span></label></td>
              <td><label class="zca-toggle"><input type="checkbox" name="<?php echo $pt[3]; ?>_profile" data-option="<?php echo $pt[3]; ?>_profile" <?php checked(zca_ogp($opts,$pt[3].'_profile','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></td>
            </tr>
            <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class="zca-tab-panel" data-zc-panel="rank">
      <div class="zca-card">
        <div class="zca-card__header"><div class="zca-card__icon">🥇</div><span class="zca-card__title">Rank & Level Settings</span></div>
        <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Show Rank Icon/Image</div><div class="zca-toggle-row__desc">Display rank thumbnail image in bar</div></div><label class="zca-toggle"><input type="checkbox" name="gp_show_rank_icon" data-option="gp_show_rank_icon" <?php checked(zca_ogp($opts,'gp_show_rank_icon','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
        <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Rank Up Notification</div><div class="zca-toggle-row__desc">Show animated toast when user levels up or ranks up</div></div><label class="zca-toggle"><input type="checkbox" name="gp_rankup_notification" data-option="gp_rankup_notification" <?php checked(zca_ogp($opts,'gp_rankup_notification','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
        <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Rank Leaderboard Widget</div><div class="zca-toggle-row__desc">Show top-ranked members widget in sidebar</div></div><label class="zca-toggle"><input type="checkbox" name="gp_leaderboard_widget" data-option="gp_leaderboard_widget" <?php checked(zca_ogp($opts,'gp_leaderboard_widget','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
        <div class="zca-field">
          <label class="zca-label">Leaderboard Size<span class="zca-hint">Number of top members shown</span></label>
          <div class="zca-slider-wrap">
            <input type="range" class="zca-slider" name="gp_leaderboard_size" data-option="gp_leaderboard_size" min="3" max="20" value="<?php echo esc_attr(zca_ogp($opts,'gp_leaderboard_size','10')); ?>" data-unit="">
            <span class="zca-slider-value"><?php echo esc_attr(zca_ogp($opts,'gp_leaderboard_size','10')); ?></span>
          </div>
        </div>
      </div>
    </div>

    <div class="zca-tab-panel" data-zc-panel="style">
      <div class="zca-card">
        <div class="zca-card__header"><div class="zca-card__icon">🎨</div><span class="zca-card__title">GamiPress Bar Style</span></div>
        <div class="zca-field">
          <label class="zca-label">Bar Background Color</label>
          <div class="zca-color-row">
            <div class="zca-color-swatch"><input type="color" name="gp_bar_bg" data-option="gp_bar_bg" value="<?php echo esc_attr(zca_ogp($opts,'gp_bar_bg','#07070f')); ?>"></div>
            <input type="text" class="zca-color-hex" value="<?php echo esc_attr(strtoupper(zca_ogp($opts,'gp_bar_bg','#07070f'))); ?>" maxlength="7">
            <div class="zca-color-preview" style="background:<?php echo esc_attr(zca_ogp($opts,'gp_bar_bg','#07070f')); ?>"></div>
          </div>
        </div>
        <div class="zca-field">
          <label class="zca-label">XP Bar Fill Color</label>
          <div class="zca-color-row">
            <div class="zca-color-swatch"><input type="color" name="gp_xp_bar_color" data-option="gp_xp_bar_color" value="<?php echo esc_attr(zca_ogp($opts,'gp_xp_bar_color','#7c6ff7')); ?>"></div>
            <input type="text" class="zca-color-hex" value="<?php echo esc_attr(strtoupper(zca_ogp($opts,'gp_xp_bar_color','#7c6ff7'))); ?>" maxlength="7">
            <div class="zca-color-preview" style="background:<?php echo esc_attr(zca_ogp($opts,'gp_xp_bar_color','#7c6ff7')); ?>"></div>
          </div>
        </div>
        <div class="zca-field">
          <label class="zca-label">Bar Height</label>
          <div class="zca-slider-wrap">
            <input type="range" class="zca-slider" name="gp_bar_height" data-option="gp_bar_height" min="36" max="72" value="<?php echo esc_attr(zca_ogp($opts,'gp_bar_height','48')); ?>" data-unit="px" data-token="gp-bar-height">
            <span class="zca-slider-value"><?php echo esc_attr(zca_ogp($opts,'gp_bar_height','48')); ?>px</span>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>
</div>
