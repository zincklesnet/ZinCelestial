<?php if(!defined('ABSPATH'))exit;
$opts = get_option('zincelestial_options', zc_default_options());
function zca_obbp($o,$k,$f=''){return isset($o[$k])?$o[$k]:$f;}
$bbp_active = class_exists('bbPress');
?>
<div class="zca-wrap">
<div class="zca-page-header">
  <div class="zca-page-header__left">
    <div class="zca-page-header__icon">💬</div>
    <div><div class="zca-page-header__title">bbPress Forums</div>
    <div class="zca-page-header__sub">Forum layout, styles, user roles, and integration settings</div></div>
  </div>
  <div class="zca-page-header__right">
    <?php if($bbp_active): ?>
    <span class="zca-badge" style="background:rgba(52,211,153,.2);color:#34d399;border:1px solid rgba(52,211,153,.35);">● bbPress Active</span>
    <?php else: ?>
    <span class="zca-badge" style="background:rgba(248,113,113,.2);color:#f87171;border:1px solid rgba(248,113,113,.35);">⚠ bbPress Not Active</span>
    <?php endif; ?>
  </div>
</div>
<div class="zca-content">
<?php if(!$bbp_active): ?>
<div class="zca-notice zca-notice--warning"><span class="zca-notice__icon">⚠</span><div><div class="zca-notice__title">bbPress Not Active</div><div>Install and activate the <strong>bbPress</strong> plugin to unlock these settings. When active, ZinCelestial will style all forum pages with Bootstrap 5 components.</div></div></div>
<?php endif; ?>

  <div class="zca-tabs-nav">
    <button class="zca-tab-btn" data-zc-tab="layout"><span class="zca-tab-icon">📐</span> Layout</button>
    <button class="zca-tab-btn" data-zc-tab="display"><span class="zca-tab-icon">🎨</span> Display</button>
    <button class="zca-tab-btn" data-zc-tab="roles"><span class="zca-tab-icon">👤</span> Roles</button>
    <button class="zca-tab-btn" data-zc-tab="integration"><span class="zca-tab-icon">🔗</span> Integration</button>
  </div>
  <div class="zca-tab-panels">

    <div class="zca-tab-panel" data-zc-panel="layout">
      <div class="zca-grid zca-grid--2">
        <div class="zca-card">
          <div class="zca-card__header"><div class="zca-card__icon">📐</div><span class="zca-card__title">Forum Page Layout</span></div>
          <div class="zca-field">
            <label class="zca-label">Forum Archive Layout</label>
            <select class="zca-select" name="zincelestial_options[bbp_layout]" data-option="bbp_layout">
              <option value="default" <?php selected(zca_obbp($opts,'bbp_layout','default'),'default'); ?>>Default (Right Sidebar)</option>
              <option value="full-width" <?php selected(zca_obbp($opts,'bbp_layout'),'full-width'); ?>>Full Width</option>
              <option value="left-sidebar" <?php selected(zca_obbp($opts,'bbp_layout'),'left-sidebar'); ?>>Left Sidebar</option>
              <option value="both-sidebars" <?php selected(zca_obbp($opts,'bbp_layout'),'both-sidebars'); ?>>Both Sidebars</option>
            </select>
          </div>
          <div class="zca-field">
            <label class="zca-label">Topics Per Page</label>
            <input type="number" class="zca-input" name="zincelestial_options[bbp_per_page]" value="<?php echo esc_attr(zca_obbp($opts,'bbp_per_page','15')); ?>" min="5" max="100">
          </div>
          <div class="zca-field">
            <label class="zca-label">Replies Per Page</label>
            <input type="number" class="zca-input" name="zincelestial_options[bbp_replies_per_page]" value="<?php echo esc_attr(zca_obbp($opts,'bbp_replies_per_page','15')); ?>" min="5" max="100">
          </div>
        </div>
        <div class="zca-card">
          <div class="zca-card__header"><div class="zca-card__icon">📊</div><span class="zca-card__title">Forum Features</span></div>
          <div class="zca-toggle-row">
            <div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Show Forum Statistics</div><div class="zca-toggle-row__desc">Display topic/reply counts on forum header</div></div>
            <label class="zca-toggle"><input type="checkbox" name="zincelestial_options[bbp_show_stats]" <?php checked(zca_obbp($opts,'bbp_show_stats','1'),'1'); ?>><span class="zca-toggle-slider"></span></label>
          </div>
          <div class="zca-toggle-row">
            <div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Show Last Activity</div><div class="zca-toggle-row__desc">Display last post time on topic/forum lists</div></div>
            <label class="zca-toggle"><input type="checkbox" name="zincelestial_options[bbp_show_last_activity]" <?php checked(zca_obbp($opts,'bbp_show_last_activity','1'),'1'); ?>><span class="zca-toggle-slider"></span></label>
          </div>
          <div class="zca-toggle-row">
            <div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Show Online Status</div><div class="zca-toggle-row__desc">Show who's online dot next to usernames</div></div>
            <label class="zca-toggle"><input type="checkbox" name="zincelestial_options[bbp_online_status]" <?php checked(zca_obbp($opts,'bbp_online_status','0'),'1'); ?>><span class="zca-toggle-slider"></span></label>
          </div>
          <div class="zca-toggle-row">
            <div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Enable Rich Text Editor</div><div class="zca-toggle-row__desc">Use WP editor for topic and reply forms</div></div>
            <label class="zca-toggle"><input type="checkbox" name="zincelestial_options[bbp_rich_editor]" <?php checked(zca_obbp($opts,'bbp_rich_editor','0'),'1'); ?>><span class="zca-toggle-slider"></span></label>
          </div>
        </div>
      </div>
    </div>

    <div class="zca-tab-panel" data-zc-panel="display">
      <div class="zca-grid zca-grid--2">
        <div class="zca-card">
          <div class="zca-card__header"><div class="zca-card__icon">🎨</div><span class="zca-card__title">Visual Settings</span></div>
          <div class="zca-field">
            <label class="zca-label">Forum Card Style</label>
            <select class="zca-select" name="zincelestial_options[bbp_card_style]" data-option="bbp_card_style">
              <option value="modern" <?php selected(zca_obbp($opts,'bbp_card_style','modern'),'modern'); ?>>Modern (Bootstrap Card)</option>
              <option value="list" <?php selected(zca_obbp($opts,'bbp_card_style'),'list'); ?>>List View</option>
              <option value="compact" <?php selected(zca_obbp($opts,'bbp_card_style'),'compact'); ?>>Compact</option>
              <option value="table" <?php selected(zca_obbp($opts,'bbp_card_style'),'table'); ?>>Table</option>
            </select>
          </div>
          <div class="zca-toggle-row">
            <div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Forum Icons</div><div class="zca-toggle-row__desc">Show Bootstrap Icons next to forum titles</div></div>
            <label class="zca-toggle"><input type="checkbox" name="zincelestial_options[bbp_forum_icons]" <?php checked(zca_obbp($opts,'bbp_forum_icons','1'),'1'); ?>><span class="zca-toggle-slider"></span></label>
          </div>
          <div class="zca-toggle-row">
            <div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Member Avatars in Replies</div><div class="zca-toggle-row__desc">Show avatar photos alongside replies</div></div>
            <label class="zca-toggle"><input type="checkbox" name="zincelestial_options[bbp_reply_avatars]" <?php checked(zca_obbp($opts,'bbp_reply_avatars','1'),'1'); ?>><span class="zca-toggle-slider"></span></label>
          </div>
          <div class="zca-toggle-row">
            <div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Sticky Topics Badge</div><div class="zca-toggle-row__desc">Show "Pinned" badge on sticky topics</div></div>
            <label class="zca-toggle"><input type="checkbox" name="zincelestial_options[bbp_sticky_badge]" <?php checked(zca_obbp($opts,'bbp_sticky_badge','1'),'1'); ?>><span class="zca-toggle-slider"></span></label>
          </div>
        </div>
        <div class="zca-card">
          <div class="zca-card__header"><div class="zca-card__icon">🏷️</div><span class="zca-card__title">Labels & Counts</span></div>
          <div class="zca-toggle-row">
            <div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Show Vote Counts</div><div class="zca-toggle-row__desc">Display reply vote counts if voting enabled</div></div>
            <label class="zca-toggle"><input type="checkbox" name="zincelestial_options[bbp_show_votes]" <?php checked(zca_obbp($opts,'bbp_show_votes','0'),'1'); ?>><span class="zca-toggle-slider"></span></label>
          </div>
          <div class="zca-toggle-row">
            <div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Mark Best Answer</div><div class="zca-toggle-row__desc">Allow topic authors to mark best reply</div></div>
            <label class="zca-toggle"><input type="checkbox" name="zincelestial_options[bbp_best_answer]" <?php checked(zca_obbp($opts,'bbp_best_answer','0'),'1'); ?>><span class="zca-toggle-slider"></span></label>
          </div>
          <div class="zca-toggle-row">
            <div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Forum Breadcrumbs</div></div>
            <label class="zca-toggle"><input type="checkbox" name="zincelestial_options[bbp_breadcrumbs]" <?php checked(zca_obbp($opts,'bbp_breadcrumbs','1'),'1'); ?>><span class="zca-toggle-slider"></span></label>
          </div>
        </div>
      </div>
    </div>

    <div class="zca-tab-panel" data-zc-panel="roles">
      <div class="zca-card">
        <div class="zca-card__header"><div class="zca-card__icon">👤</div><span class="zca-card__title">BuddyPress Role Integration</span></div>
        <div class="zca-notice zca-notice--info"><span class="zca-notice__icon">ℹ</span><div>When BuddyPress is active, bbPress roles can sync with BP member types. Configure member type → forum role mapping below.</div></div>
        <div class="zca-toggle-row">
          <div class="zca-toggle-row__info"><div class="zca-toggle-row__label">BP Member Type → Forum Role Sync</div><div class="zca-toggle-row__desc">Automatically assign bbPress roles based on BuddyPress member type</div></div>
          <label class="zca-toggle"><input type="checkbox" name="zincelestial_options[bbp_bp_role_sync]" <?php checked(zca_obbp($opts,'bbp_bp_role_sync','0'),'1'); ?>><span class="zca-toggle-slider"></span></label>
        </div>
        <div class="zca-toggle-row">
          <div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Show Forum Tab on BP Profile</div><div class="zca-toggle-row__desc">Add a "Forums" tab to member profiles</div></div>
          <label class="zca-toggle"><input type="checkbox" name="zincelestial_options[bbp_bp_profile_tab]" <?php checked(zca_obbp($opts,'bbp_bp_profile_tab','1'),'1'); ?>><span class="zca-toggle-slider"></span></label>
        </div>
      </div>
    </div>

    <div class="zca-tab-panel" data-zc-panel="integration">
      <div class="zca-card">
        <div class="zca-card__header"><div class="zca-card__icon">🔗</div><span class="zca-card__title">Sidebar & Widgets</span></div>
        <div class="zca-field">
          <label class="zca-label">bbPress Sidebar</label>
          <select class="zca-select" name="zincelestial_options[bbp_sidebar]" data-option="bbp_sidebar">
            <option value="zc-bbpress-sidebar" <?php selected(zca_obbp($opts,'bbp_sidebar','zc-bbpress-sidebar'),'zc-bbpress-sidebar'); ?>>bbPress Sidebar</option>
            <option value="zc-sidebar-right" <?php selected(zca_obbp($opts,'bbp_sidebar'),'zc-sidebar-right'); ?>>Main Right Sidebar</option>
            <option value="none" <?php selected(zca_obbp($opts,'bbp_sidebar'),'none'); ?>>No Sidebar</option>
          </select>
        </div>
        <div class="zca-toggle-row">
          <div class="zca-toggle-row__info"><div class="zca-toggle-row__label">ZinCelestial Forum CSS</div><div class="zca-toggle-row__desc">Load ZC bbPress Bootstrap styling</div></div>
          <label class="zca-toggle"><input type="checkbox" name="zincelestial_options[bbp_custom_css]" <?php checked(zca_obbp($opts,'bbp_custom_css','1'),'1'); ?>><span class="zca-toggle-slider"></span></label>
        </div>
      </div>
    </div>
  </div><!-- /.zca-tab-panels -->

  <div class="zca-card-actions">
    <button class="zca-btn zca-btn--primary" onclick="zcaSaveOptions()"><i class="bi bi-floppy me-1"></i> Save bbPress Settings</button>
    <button class="zca-btn zca-btn--ghost" onclick="zcaResetSection('bbpress')"><i class="bi bi-arrow-counterclockwise me-1"></i> Reset Section</button>
  </div>
</div><!-- /.zca-content -->
</div><!-- /.zca-wrap -->
