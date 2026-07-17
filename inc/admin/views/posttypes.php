<?php if(!defined('ABSPATH'))exit;
$opts = get_option('zincelestial_options', zc_default_options());
function zca_opt($o,$k,$f=''){return isset($o[$k])?$o[$k]:$f;}
$post_types = get_post_types(['public'=>true],'objects');
?>
<div class="zca-wrap">
<div class="zca-page-header">
  <div class="zca-page-header__left">
    <div class="zca-page-header__icon">📋</div>
    <div><div class="zca-page-header__title">Post Types</div>
    <div class="zca-page-header__sub">Layout and sidebar defaults per content type</div></div>
  </div>
</div>
<div class="zca-content">
  <div class="zca-notice zca-notice--info"><span class="zca-notice__icon">ℹ</span><div>Set default layout and sidebar for each registered public post type. Individual posts can override via the ZinCelestial meta box.</div></div>
  <div class="zca-grid zca-grid--2">
    <?php foreach($post_types as $slug => $pt):
      $icon_map = ['post'=>'📝','page'=>'📄','product'=>'📦','download'=>'⬇️','sfwd-courses'=>'🎓','sfwd-lessons'=>'📚','job_listing'=>'💼'];
      $icon = isset($icon_map[$slug]) ? $icon_map[$slug] : '📋';
    ?>
    <div class="zca-card">
      <div class="zca-card__header">
        <div class="zca-card__icon"><?php echo $icon; ?></div>
        <span class="zca-card__title"><?php echo esc_html($pt->labels->singular_name); ?></span>
        <code style="font-size:.65rem;color:var(--zca-muted,#94a3b8);margin-left:auto;"><?php echo esc_html($slug); ?></code>
      </div>
      <div style="padding:0 var(--zca-space-5) var(--zca-space-4);">
        <div class="zca-field">
          <label class="zca-label">Archive Layout</label>
          <select class="zca-select" name="zincelestial_options[pt_<?php echo $slug; ?>_archive_layout]">
            <option value="right-sidebar" <?php selected(zca_opt($opts,'pt_'.$slug.'_archive_layout','right-sidebar'),'right-sidebar'); ?>>Right Sidebar</option>
            <option value="left-sidebar"  <?php selected(zca_opt($opts,'pt_'.$slug.'_archive_layout'),'left-sidebar'); ?>>Left Sidebar</option>
            <option value="full-width"    <?php selected(zca_opt($opts,'pt_'.$slug.'_archive_layout'),'full-width'); ?>>Full Width</option>
          </select>
        </div>
        <div class="zca-field">
          <label class="zca-label">Single Layout</label>
          <select class="zca-select" name="zincelestial_options[pt_<?php echo $slug; ?>_single_layout]">
            <option value="right-sidebar" <?php selected(zca_opt($opts,'pt_'.$slug.'_single_layout','right-sidebar'),'right-sidebar'); ?>>Right Sidebar</option>
            <option value="left-sidebar"  <?php selected(zca_opt($opts,'pt_'.$slug.'_single_layout'),'left-sidebar'); ?>>Left Sidebar</option>
            <option value="full-width"    <?php selected(zca_opt($opts,'pt_'.$slug.'_single_layout'),'full-width'); ?>>Full Width</option>
          </select>
        </div>
        <div class="zca-toggle-row">
          <div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Show Featured Image</div></div>
          <label class="zca-toggle"><input type="checkbox" name="zincelestial_options[pt_<?php echo $slug; ?>_show_thumb]" <?php checked(zca_opt($opts,'pt_'.$slug.'_show_thumb','1'),'1'); ?>><span class="zca-toggle-slider"></span></label>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
  <div class="zca-card-actions">
    <button class="zca-btn zca-btn--primary" onclick="zcaSaveOptions()"><i class="bi bi-floppy me-1"></i> Save Post Type Settings</button>
  </div>
</div>
</div>
