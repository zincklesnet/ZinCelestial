<?php if(!defined('ABSPATH'))exit;
$opts = get_option('zincelestial_options', zc_default_options());
function zca_oc($o,$k,$f=''){return isset($o[$k])?$o[$k]:$f;}
?>
<div class="zca-wrap">
<div class="zca-page-header">
  <div class="zca-page-header__left">
    <div class="zca-page-header__icon">✍</div>
    <div><div class="zca-page-header__title">Compose Bar</div>
    <div class="zca-page-header__sub">Boombox-style #COMPOSE sticky quick-post bar</div></div>
  </div>
</div>
<div class="zca-content">

  <!-- Preview -->
  <div class="zca-card zca-mb" style="background:var(--zca-surface);">
    <div class="zca-card__header"><div class="zca-card__icon">👁</div><span class="zca-card__title">Bar Preview</span></div>
    <div style="display:flex;align-items:center;gap:12px;padding:12px 16px;background:var(--zca-card);border-radius:var(--zca-radius-md);border:1px solid var(--zca-border);">
      <div style="width:32px;height:32px;border-radius:50%;background:var(--zca-grad-main);flex-shrink:0;"></div>
      <div style="flex:1;background:var(--zca-surface);border:1px solid var(--zca-border);border-radius:20px;padding:8px 16px;color:var(--zca-muted);font-size:13px;">What's on your mind?</div>
      <button style="background:var(--zca-grad-main);color:#fff;border:none;border-radius:20px;padding:7px 16px;font-size:12px;font-weight:600;cursor:pointer;">Post</button>
    </div>
  </div>

  <div class="zca-grid zca-grid--2">
    <div class="zca-card">
      <div class="zca-card__header"><div class="zca-card__icon">⚙</div><span class="zca-card__title">Compose Bar Settings</span></div>
      <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Enable Compose Bar</div><div class="zca-toggle-row__desc">Show the Boombox-style sticky compose bar</div></div><label class="zca-toggle"><input type="checkbox" name="show_compose_bar" data-option="show_compose_bar" <?php checked(zca_oc($opts,'show_compose_bar','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
      <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Logged-In Only</div><div class="zca-toggle-row__desc">Only show compose bar to logged-in members</div></div><label class="zca-toggle"><input type="checkbox" name="compose_logged_in_only" data-option="compose_logged_in_only" <?php checked(zca_oc($opts,'compose_logged_in_only','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
      <div class="zca-field zca-mt">
        <label class="zca-label">Position</label>
        <select class="zca-select" name="compose_position" data-option="compose_position">
          <option value="below-header" <?php selected(zca_oc($opts,'compose_position','below-header'),'below-header'); ?>>Below Header</option>
          <option value="sticky-bottom" <?php selected(zca_oc($opts,'compose_position','below-header'),'sticky-bottom'); ?>>Sticky Bottom</option>
          <option value="inline" <?php selected(zca_oc($opts,'compose_position','below-header'),'inline'); ?>>Inline in Activity Feed</option>
        </select>
      </div>
      <div class="zca-field">
        <label class="zca-label">Placeholder Text</label>
        <input type="text" class="zca-input" name="compose_placeholder" data-option="compose_placeholder" value="<?php echo esc_attr(zca_oc($opts,'compose_placeholder',"What's on your mind?")); ?>" placeholder="What's on your mind?">
      </div>
      <div class="zca-field">
        <label class="zca-label">Compose Bar Background</label>
        <div class="zca-color-row">
          <div class="zca-color-swatch"><input type="color" name="compose_bg" data-option="compose_bg" value="<?php echo esc_attr(zca_oc($opts,'compose_bg','#0f0f1f')); ?>"></div>
          <input type="text" class="zca-color-hex" value="<?php echo esc_attr(strtoupper(zca_oc($opts,'compose_bg','#0f0f1f'))); ?>" maxlength="7">
          <div class="zca-color-preview" style="background:<?php echo esc_attr(zca_oc($opts,'compose_bg','#0f0f1f')); ?>"></div>
        </div>
      </div>
    </div>
    <div class="zca-card">
      <div class="zca-card__header"><div class="zca-card__icon">📎</div><span class="zca-card__title">Compose Features</span></div>
      <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Image Upload</div><div class="zca-toggle-row__desc">Allow photo uploads in compose modal</div></div><label class="zca-toggle"><input type="checkbox" name="compose_image_upload" data-option="compose_image_upload" <?php checked(zca_oc($opts,'compose_image_upload','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
      <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Video Upload</div><div class="zca-toggle-row__desc">Allow video file uploads (RTMedia integration)</div></div><label class="zca-toggle"><input type="checkbox" name="compose_video_upload" data-option="compose_video_upload" <?php checked(zca_oc($opts,'compose_video_upload','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
      <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Emoji Picker</div><div class="zca-toggle-row__desc">Emoji button in compose modal</div></div><label class="zca-toggle"><input type="checkbox" name="compose_emoji" data-option="compose_emoji" <?php checked(zca_oc($opts,'compose_emoji','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
      <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">GIF Support</div><div class="zca-toggle-row__desc">Allow GIF search and insertion</div></div><label class="zca-toggle"><input type="checkbox" name="compose_gif" data-option="compose_gif" <?php checked(zca_oc($opts,'compose_gif','0'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
      <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Post to Group</div><div class="zca-toggle-row__desc">Allow selecting a group to post to</div></div><label class="zca-toggle"><input type="checkbox" name="compose_post_to_group" data-option="compose_post_to_group" <?php checked(zca_oc($opts,'compose_post_to_group','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
      <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Privacy Selector</div><div class="zca-toggle-row__desc">Public / Friends / Only Me dropdown</div></div><label class="zca-toggle"><input type="checkbox" name="compose_privacy" data-option="compose_privacy" <?php checked(zca_oc($opts,'compose_privacy','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
      <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Mood / Feeling</div><div class="zca-toggle-row__desc">Add "Feeling 😊" selector to post</div></div><label class="zca-toggle"><input type="checkbox" name="compose_mood" data-option="compose_mood" <?php checked(zca_oc($opts,'compose_mood','0'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
    </div>
  </div>
</div>
</div>
