<?php if(!defined('ABSPATH'))exit;
$opts = get_option('zincelestial_options', zc_default_options());
function zca_or($o,$k,$f=''){return isset($o[$k])?$o[$k]:$f;}
?>
<div class="zca-wrap">
<div class="zca-page-header">
  <div class="zca-page-header__left">
    <div class="zca-page-header__icon">❤</div>
    <div><div class="zca-page-header__title">Reactions System</div>
    <div class="zca-page-header__sub">Animated reactions, viral overlays, trending scores, and BP activity sync</div></div>
  </div>
</div>
<div class="zca-content">
  <div class="zca-tabs-nav">
    <button class="zca-tab-btn" data-zc-tab="general"><span class="zca-tab-icon">⚙</span> General</button>
    <button class="zca-tab-btn" data-zc-tab="types"><span class="zca-tab-icon">😀</span> Reaction Types</button>
    <button class="zca-tab-btn" data-zc-tab="viral"><span class="zca-tab-icon">🔥</span> Viral & Trending</button>
    <button class="zca-tab-btn" data-zc-tab="display"><span class="zca-tab-icon">🖼</span> Display</button>
  </div>
  <div class="zca-tab-panels">

    <div class="zca-tab-panel" data-zc-panel="general">
      <div class="zca-grid zca-grid--2">
        <div class="zca-card">
          <div class="zca-card__header"><div class="zca-card__icon">⚙</div><span class="zca-card__title">Core Toggles</span></div>
          <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Enable Reactions System</div><div class="zca-toggle-row__desc">Master toggle for the entire reactions system</div></div><label class="zca-toggle"><input type="checkbox" name="reactions_enabled" data-option="reactions_enabled" <?php checked(zca_or($opts,'reactions_enabled','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
          <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">BuddyPress Activity Sync</div><div class="zca-toggle-row__desc">Sync reactions with BP activity reactions plugin</div></div><label class="zca-toggle"><input type="checkbox" name="reactions_bp_sync" data-option="reactions_bp_sync" <?php checked(zca_or($opts,'reactions_bp_sync','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
          <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Multisite Sync</div><div class="zca-toggle-row__desc">Sync reaction counts across all network sites</div></div><label class="zca-toggle"><input type="checkbox" name="reactions_multisite_sync" data-option="reactions_multisite_sync" <?php checked(zca_or($opts,'reactions_multisite_sync','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
          <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Guest Reactions</div><div class="zca-toggle-row__desc">Allow non-logged-in users to react</div></div><label class="zca-toggle"><input type="checkbox" name="reactions_guests" data-option="reactions_guests" <?php checked(zca_or($opts,'reactions_guests','0'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
          <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Reactions on Pages</div><div class="zca-toggle-row__desc">Show reactions on WordPress pages</div></div><label class="zca-toggle"><input type="checkbox" name="reactions_on_pages" data-option="reactions_on_pages" <?php checked(zca_or($opts,'reactions_on_pages','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
          <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Reactions on Galleries</div><div class="zca-toggle-row__desc">Show reactions on media gallery items</div></div><label class="zca-toggle"><input type="checkbox" name="reactions_on_galleries" data-option="reactions_on_galleries" <?php checked(zca_or($opts,'reactions_on_galleries','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
        </div>
        <div class="zca-card">
          <div class="zca-card__header"><div class="zca-card__icon">⚡</div><span class="zca-card__title">Scoring & Points</span></div>
          <div class="zca-field">
            <label class="zca-label">Points Per Reaction Received<span class="zca-hint">ZCreds awarded to post author</span></label>
            <div class="zca-slider-wrap">
              <input type="range" class="zca-slider" name="reaction_points_per_receive" data-option="reaction_points_per_receive" min="0" max="10" value="<?php echo esc_attr(zca_or($opts,'reaction_points_per_receive','1')); ?>" data-unit=" pts">
              <span class="zca-slider-value"><?php echo esc_attr(zca_or($opts,'reaction_points_per_receive','1')); ?> pts</span>
            </div>
          </div>
          <div class="zca-field">
            <label class="zca-label">Points Per Reaction Given<span class="zca-hint">ZCreds awarded to reactor</span></label>
            <div class="zca-slider-wrap">
              <input type="range" class="zca-slider" name="reaction_points_per_give" data-option="reaction_points_per_give" min="0" max="5" value="<?php echo esc_attr(zca_or($opts,'reaction_points_per_give','0')); ?>" data-unit=" pts">
              <span class="zca-slider-value"><?php echo esc_attr(zca_or($opts,'reaction_points_per_give','0')); ?> pts</span>
            </div>
          </div>
          <div class="zca-field">
            <label class="zca-label">Viral Score Threshold<span class="zca-hint">Reactions needed to mark as viral/trending</span></label>
            <div class="zca-slider-wrap">
              <input type="range" class="zca-slider" name="viral_threshold" data-option="viral_threshold" min="5" max="500" value="<?php echo esc_attr(zca_or($opts,'viral_threshold','50')); ?>" data-unit="">
              <span class="zca-slider-value"><?php echo esc_attr(zca_or($opts,'viral_threshold','50')); ?></span>
            </div>
          </div>
          <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Award GamiPress Points</div><div class="zca-toggle-row__desc">Connect reactions to GamiPress point system</div></div><label class="zca-toggle"><input type="checkbox" name="reactions_award_points" data-option="reactions_award_points" <?php checked(zca_or($opts,'reactions_award_points','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
        </div>
      </div>
    </div>

    <div class="zca-tab-panel" data-zc-panel="types">
      <div class="zca-card">
        <div class="zca-card__header"><div class="zca-card__icon">😀</div><span class="zca-card__title">Reaction Types — 8 Animated Reactions</span></div>
        <div class="zca-notice zca-notice--info"><span class="zca-notice__icon">ℹ</span><div>Toggle each reaction type on/off. All reactions are animated SVG/CSS with hover burst effects. The most popular reaction shows as an overlay badge on post thumbnails (VBuzz/Boombox style).</div></div>
        <div class="zca-table-wrap">
          <table class="zca-table">
            <thead><tr><th>Emoji</th><th>Name</th><th>Label</th><th>Weight</th><th>Enabled</th></tr></thead>
            <tbody>
            <?php
            $reactions = [
              ['🔥','fire',   'Fire',   '5'],
              ['⭐','star',   'Star',   '4'],
              ['❤','love',   'Love',   '4'],
              ['😮','wow',    'Wow',    '3'],
              ['😂','laugh',  'Laugh',  '2'],
              ['😢','sad',    'Sad',    '2'],
              ['😡','angry',  'Angry',  '2'],
              ['🚀','rocket', 'Rocket', '5'],
            ];
            foreach($reactions as $rx):
              $key = 'reaction_enabled_'.$rx[1];
            ?>
            <tr>
              <td style="font-size:20px;"><?php echo $rx[0]; ?></td>
              <td><code class="zca-code"><?php echo $rx[1]; ?></code></td>
              <td>
                <input type="text" class="zca-input" name="reaction_label_<?php echo $rx[1]; ?>" data-option="reaction_label_<?php echo $rx[1]; ?>" value="<?php echo esc_attr(zca_or($opts,'reaction_label_'.$rx[1],$rx[2])); ?>" style="width:100px;">
              </td>
              <td>
                <div class="zca-slider-wrap" style="gap:6px;">
                  <input type="range" class="zca-slider" name="reaction_weight_<?php echo $rx[1]; ?>" data-option="reaction_weight_<?php echo $rx[1]; ?>" min="1" max="10" value="<?php echo esc_attr(zca_or($opts,'reaction_weight_'.$rx[1],$rx[3])); ?>" data-unit="" style="width:80px;">
                  <span class="zca-slider-value"><?php echo esc_attr(zca_or($opts,'reaction_weight_'.$rx[1],$rx[3])); ?></span>
                </div>
              </td>
              <td>
                <label class="zca-toggle"><input type="checkbox" name="<?php echo $key; ?>" data-option="<?php echo $key; ?>" <?php checked(zca_or($opts,$key,'1'),'1'); ?>><span class="zca-toggle__slider"></span></label>
              </td>
            </tr>
            <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class="zca-tab-panel" data-zc-panel="viral">
      <div class="zca-card">
        <div class="zca-card__header"><div class="zca-card__icon">🔥</div><span class="zca-card__title">Viral & Trending Overlay</span></div>
        <div class="zca-notice zca-notice--primary"><span class="zca-notice__icon">🔥</span><div><div class="zca-notice__title">VBuzz / Boombox Style</div>The top reaction emoji is displayed as an animated badge in the corner of each post/gallery thumbnail — just like VBuzz and Boombox themes. Trending posts get a special "🔥 Trending" badge.</div></div>
        <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Reaction Overlay on Thumbnails</div><div class="zca-toggle-row__desc">Show top reaction in corner of post cards</div></div><label class="zca-toggle"><input type="checkbox" name="reactions_overlay" data-option="reactions_overlay" <?php checked(zca_or($opts,'reactions_overlay','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
        <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Trending Badge</div><div class="zca-toggle-row__desc">Show "🔥 Trending" badge on viral posts</div></div><label class="zca-toggle"><input type="checkbox" name="trending_badge" data-option="trending_badge" <?php checked(zca_or($opts,'trending_badge','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
        <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Viral Submission Bar</div><div class="zca-toggle-row__desc">Show viral score progress bar on post cards</div></div><label class="zca-toggle"><input type="checkbox" name="viral_progress_bar" data-option="viral_progress_bar" <?php checked(zca_or($opts,'viral_progress_bar','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
        <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Hot Posts Widget</div><div class="zca-toggle-row__desc">Trending/hot posts sidebar widget by reaction count</div></div><label class="zca-toggle"><input type="checkbox" name="hot_posts_widget" data-option="hot_posts_widget" <?php checked(zca_or($opts,'hot_posts_widget','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
        <div class="zca-field zca-mt">
          <label class="zca-label">Trending Window (Hours)<span class="zca-hint">Reactions in last N hours count for trending</span></label>
          <div class="zca-slider-wrap">
            <input type="range" class="zca-slider" name="trending_window_hours" data-option="trending_window_hours" min="1" max="168" value="<?php echo esc_attr(zca_or($opts,'trending_window_hours','24')); ?>" data-unit="h">
            <span class="zca-slider-value"><?php echo esc_attr(zca_or($opts,'trending_window_hours','24')); ?>h</span>
          </div>
        </div>
        <div class="zca-field">
          <label class="zca-label">Overlay Position</label>
          <select class="zca-select" name="reaction_overlay_position" data-option="reaction_overlay_position">
            <option value="top-right" <?php selected(zca_or($opts,'reaction_overlay_position','top-right'),'top-right'); ?>>Top Right</option>
            <option value="top-left" <?php selected(zca_or($opts,'reaction_overlay_position','top-right'),'top-left'); ?>>Top Left</option>
            <option value="bottom-right" <?php selected(zca_or($opts,'reaction_overlay_position','top-right'),'bottom-right'); ?>>Bottom Right</option>
            <option value="bottom-left" <?php selected(zca_or($opts,'reaction_overlay_position','top-right'),'bottom-left'); ?>>Bottom Left</option>
          </select>
        </div>
      </div>
    </div>

    <div class="zca-tab-panel" data-zc-panel="display">
      <div class="zca-card">
        <div class="zca-card__header"><div class="zca-card__icon">🖼</div><span class="zca-card__title">Reaction Bar Display</span></div>
        <div class="zca-field">
          <label class="zca-label">Reaction Bar Position</label>
          <select class="zca-select" name="reaction_bar_position" data-option="reaction_bar_position">
            <option value="below-content" <?php selected(zca_or($opts,'reaction_bar_position','below-content'),'below-content'); ?>>Below Content</option>
            <option value="above-content" <?php selected(zca_or($opts,'reaction_bar_position','below-content'),'above-content'); ?>>Above Content</option>
            <option value="sticky" <?php selected(zca_or($opts,'reaction_bar_position','below-content'),'sticky'); ?>>Sticky Bottom</option>
          </select>
        </div>
        <div class="zca-field">
          <label class="zca-label">Reaction Button Size</label>
          <div class="zca-slider-wrap">
            <input type="range" class="zca-slider" name="reaction_btn_size" data-option="reaction_btn_size" min="24" max="64" value="<?php echo esc_attr(zca_or($opts,'reaction_btn_size','36')); ?>" data-unit="px" data-token="reaction-size">
            <span class="zca-slider-value"><?php echo esc_attr(zca_or($opts,'reaction_btn_size','36')); ?>px</span>
          </div>
        </div>
        <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Animated Reaction Burst</div><div class="zca-toggle-row__desc">Play CSS animation burst when clicking a reaction</div></div><label class="zca-toggle"><input type="checkbox" name="reaction_burst_anim" data-option="reaction_burst_anim" <?php checked(zca_or($opts,'reaction_burst_anim','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
        <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Show Count Beside Emoji</div><div class="zca-toggle-row__desc">Display reaction count number next to each emoji</div></div><label class="zca-toggle"><input type="checkbox" name="reaction_show_count" data-option="reaction_show_count" <?php checked(zca_or($opts,'reaction_show_count','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
        <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Hover Tooltip with Name</div><div class="zca-toggle-row__desc">Show reaction name label on hover</div></div><label class="zca-toggle"><input type="checkbox" name="reaction_hover_tooltip" data-option="reaction_hover_tooltip" <?php checked(zca_or($opts,'reaction_hover_tooltip','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
        <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Show Reactor Avatars</div><div class="zca-toggle-row__desc">Show small avatars of users who reacted</div></div><label class="zca-toggle"><input type="checkbox" name="reaction_show_avatars" data-option="reaction_show_avatars" <?php checked(zca_or($opts,'reaction_show_avatars','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
      </div>
    </div>

  </div>
</div>
</div>
