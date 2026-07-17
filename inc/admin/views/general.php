<?php if(!defined('ABSPATH'))exit;
$opts = get_option('zincelestial_options', zc_default_options());
function zca_o($opts,$key,$fallback=''){return isset($opts[$key])?$opts[$key]:$fallback;}
?>
<div class="zca-wrap">
<div class="zca-page-header">
  <div class="zca-page-header__left">
    <div class="zca-page-header__icon">⚙</div>
    <div>
      <div class="zca-page-header__title">General Settings</div>
      <div class="zca-page-header__sub">Site behavior, layout, defaults, and modes</div>
    </div>
  </div>
  <div class="zca-page-header__right">
    <span class="zca-badge zca-badge--version">Auto-Saves</span>
  </div>
</div>
<div class="zca-content">

  <!-- Tabs -->
  <div class="zca-tabs-nav">
    <button class="zca-tab-btn" data-zc-tab="site"><span class="zca-tab-icon">🌐</span> Site</button>
    <button class="zca-tab-btn" data-zc-tab="layout"><span class="zca-tab-icon">📐</span> Layout</button>
    <button class="zca-tab-btn" data-zc-tab="content"><span class="zca-tab-icon">📝</span> Content</button>
    <button class="zca-tab-btn" data-zc-tab="darkmode"><span class="zca-tab-icon">🌙</span> Dark Mode</button>
  </div>
  <div class="zca-tab-panels">

    <!-- Site -->
    <div class="zca-tab-panel" data-zc-panel="site">
      <div class="zca-grid zca-grid--2">
        <div class="zca-card">
          <div class="zca-card__header"><div class="zca-card__icon">🎨</div><span class="zca-card__title">Appearance Mode</span></div>
          <div class="zca-field">
            <label class="zca-label">Default Color Mode</label>
            <select class="zca-select" name="default_color_mode" data-option="default_color_mode">
              <option value="dark" <?php selected(zca_o($opts,'default_color_mode'),'dark'); ?>>🌙 Dark (Default)</option>
              <option value="light" <?php selected(zca_o($opts,'default_color_mode'),'light'); ?>>☀ Light</option>
              <option value="system" <?php selected(zca_o($opts,'default_color_mode'),'system'); ?>>💻 System Preference</option>
            </select>
          </div>
          <div class="zca-field">
            <label class="zca-label">Default Scheme</label>
            <select class="zca-select" name="default_scheme" data-option="default_scheme">
              <option value="default" <?php selected(zca_o($opts,'default_scheme'),'default'); ?>>Default</option>
              <option value="slate"   <?php selected(zca_o($opts,'default_scheme'),'slate'); ?>>Slate</option>
              <option value="forest"  <?php selected(zca_o($opts,'default_scheme'),'forest'); ?>>Forest</option>
              <option value="cosmic"  <?php selected(zca_o($opts,'default_scheme'),'cosmic'); ?>>✨ Cosmic (Premium)</option>
              <option value="aurora"  <?php selected(zca_o($opts,'default_scheme'),'aurora'); ?>>🌌 Aurora (Premium)</option>
              <option value="nova"    <?php selected(zca_o($opts,'default_scheme'),'nova'); ?>>💫 Nova (Premium)</option>
              <option value="zenith"  <?php selected(zca_o($opts,'default_scheme'),'zenith'); ?>>🏔 Zenith (Premium)</option>
              <option value="ember"   <?php selected(zca_o($opts,'default_scheme'),'ember'); ?>>🔥 Ember (Premium)</option>
              <option value="twilight"<?php selected(zca_o($opts,'default_scheme'),'twilight'); ?>>🌆 Twilight (Premium)</option>
            </select>
          </div>
          <div class="zca-toggle-row">
            <div class="zca-toggle-row__info">
              <div class="zca-toggle-row__label">Show Scheme Switcher</div>
              <div class="zca-toggle-row__desc">Allow users to change their scheme in the frontend</div>
            </div>
            <label class="zca-toggle"><input type="checkbox" name="show_scheme_switcher" data-option="show_scheme_switcher" <?php checked(zca_o($opts,'show_scheme_switcher','1'),'1'); ?>><span class="zca-toggle__slider"></span></label>
          </div>
          <div class="zca-toggle-row">
            <div class="zca-toggle-row__info">
              <div class="zca-toggle-row__label">Sharing Bar</div>
              <div class="zca-toggle-row__desc">Show social sharing bar on posts and pages</div>
            </div>
            <label class="zca-toggle"><input type="checkbox" name="show_sharing_bar" data-option="show_sharing_bar" <?php checked(zca_o($opts,'show_sharing_bar','1'),'1'); ?>><span class="zca-toggle__slider"></span></label>
          </div>
        </div>
        <div class="zca-card">
          <div class="zca-card__header"><div class="zca-card__icon">📄</div><span class="zca-card__title">Excerpts & Reading</span></div>
          <div class="zca-field">
            <label class="zca-label">Excerpt Word Length<span class="zca-hint">Words shown in post excerpts</span></label>
            <div class="zca-slider-wrap">
              <input type="range" class="zca-slider" name="excerpt_length" data-option="excerpt_length" min="10" max="100" value="<?php echo esc_attr(zca_o($opts,'excerpt_length','30')); ?>" data-unit=" words">
              <span class="zca-slider-value"><?php echo esc_attr(zca_o($opts,'excerpt_length','30')); ?> words</span>
            </div>
          </div>
          <div class="zca-toggle-row">
            <div class="zca-toggle-row__info">
              <div class="zca-toggle-row__label">Disable Google Fonts</div>
              <div class="zca-toggle-row__desc">Use system fonts for better privacy & speed</div>
            </div>
            <label class="zca-toggle"><input type="checkbox" name="disable_google_fonts" data-option="disable_google_fonts" <?php checked(zca_o($opts,'disable_google_fonts','0'),'1'); ?>><span class="zca-toggle__slider"></span></label>
          </div>
          <div class="zca-field zca-mt">
            <label class="zca-label">Custom CSS Class on Body<span class="zca-hint">Additional classes on &lt;body&gt; tag</span></label>
            <input type="text" class="zca-input" name="body_class_extra" data-option="body_class_extra" value="<?php echo esc_attr(zca_o($opts,'body_class_extra','')); ?>" placeholder="my-class another-class">
          </div>
        </div>
      </div>
    </div><!-- /site -->

    <!-- Layout -->
    <div class="zca-tab-panel" data-zc-panel="layout">
      <div class="zca-card">
        <div class="zca-card__header"><div class="zca-card__icon">📐</div><span class="zca-card__title">Sidebar & Panel Layout</span></div>
        <div class="zca-field">
          <label class="zca-label">Default Sidebar Position</label>
          <div class="zca-radio-cards">
            <?php $sl = zca_o($opts,'sidebar_layout','right'); ?>
            <label class="zca-radio-card"><input type="radio" name="sidebar_layout" value="left" <?php checked($sl,'left'); ?>><span class="zca-radio-card__inner"><span class="zca-radio-card__icon">◁▌</span>Left</span></label>
            <label class="zca-radio-card"><input type="radio" name="sidebar_layout" value="right" <?php checked($sl,'right'); ?>><span class="zca-radio-card__inner"><span class="zca-radio-card__icon">▌▷</span>Right</span></label>
            <label class="zca-radio-card"><input type="radio" name="sidebar_layout" value="both" <?php checked($sl,'both'); ?>><span class="zca-radio-card__inner"><span class="zca-radio-card__icon">◁▌▷</span>Both</span></label>
            <label class="zca-radio-card"><input type="radio" name="sidebar_layout" value="none" <?php checked($sl,'none'); ?>><span class="zca-radio-card__inner"><span class="zca-radio-card__icon">▬</span>None</span></label>
          </div>
        </div>
        <div class="zca-grid zca-grid--2 zca-mt">
          <div class="zca-field">
            <label class="zca-label">Sidebar Width<span class="zca-hint">The slide-out panel width</span></label>
            <div class="zca-slider-wrap">
              <input type="range" class="zca-slider" name="sidebar_width" data-option="sidebar_width" min="200" max="400" value="<?php echo esc_attr(zca_o($opts,'sidebar_width','280')); ?>" data-unit="px" data-token="sidebar-width">
              <span class="zca-slider-value"><?php echo esc_attr(zca_o($opts,'sidebar_width','280')); ?>px</span>
            </div>
          </div>
          <div class="zca-field">
            <label class="zca-label">Global Border Radius<span class="zca-hint">Corner radius for cards & elements</span></label>
            <div class="zca-slider-wrap">
              <input type="range" class="zca-slider" name="border_radius" data-option="border_radius" min="0" max="32" value="<?php echo esc_attr(zca_o($opts,'border_radius','12')); ?>" data-unit="px" data-token="radius">
              <span class="zca-slider-value"><?php echo esc_attr(zca_o($opts,'border_radius','12')); ?>px</span>
            </div>
          </div>
        </div>
      </div>
    </div><!-- /layout -->

    <!-- Content -->
    <div class="zca-tab-panel" data-zc-panel="content">
      <div class="zca-card">
        <div class="zca-card__header"><div class="zca-card__icon">📝</div><span class="zca-card__title">Content Settings</span></div>
        <div class="zca-grid zca-grid--2">
          <div class="zca-field">
            <label class="zca-label">Read More Text</label>
            <input type="text" class="zca-input" name="read_more_text" data-option="read_more_text" value="<?php echo esc_attr(zca_o($opts,'read_more_text','Read More')); ?>" placeholder="Read More">
          </div>
          <div class="zca-field">
            <label class="zca-label">Posts Per Page (Archive)</label>
            <div class="zca-input-number">
              <input type="number" name="posts_per_page_arch" data-option="posts_per_page_arch" value="<?php echo esc_attr(zca_o($opts,'posts_per_page_arch','12')); ?>" min="1" max="50">
              <span class="zca-input-unit">posts</span>
            </div>
          </div>
        </div>
        <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Show Author Bio Box</div><div class="zca-toggle-row__desc">Display author biography below single posts</div></div><label class="zca-toggle"><input type="checkbox" name="show_author_bio" data-option="show_author_bio" <?php checked(zca_o($opts,'show_author_bio','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
        <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Show Related Posts</div><div class="zca-toggle-row__desc">Display related posts section at end of single posts</div></div><label class="zca-toggle"><input type="checkbox" name="show_related_posts" data-option="show_related_posts" <?php checked(zca_o($opts,'show_related_posts','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
        <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Enable Table of Contents</div><div class="zca-toggle-row__desc">Auto-generate TOC for long posts</div></div><label class="zca-toggle"><input type="checkbox" name="enable_toc" data-option="enable_toc" <?php checked(zca_o($opts,'enable_toc','0'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
        <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Breadcrumbs</div><div class="zca-toggle-row__desc">Show breadcrumb navigation on inner pages</div></div><label class="zca-toggle"><input type="checkbox" name="show_breadcrumbs" data-option="show_breadcrumbs" <?php checked(zca_o($opts,'show_breadcrumbs','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
      </div>
    </div><!-- /content -->

    <!-- Dark Mode -->
    <div class="zca-tab-panel" data-zc-panel="darkmode">
      <div class="zca-card">
        <div class="zca-card__header"><div class="zca-card__icon">🌙</div><span class="zca-card__title">Scheduled Dark Mode</span></div>
        <div class="zca-notice zca-notice--info"><span class="zca-notice__icon">ℹ</span><div><div class="zca-notice__title">Auto Schedule</div>Automatically switch the site to dark mode between the hours set below. Requires color mode system to be active.</div></div>
        <div class="zca-grid zca-grid--2">
          <div class="zca-field">
            <label class="zca-label">Dark Mode Starts (Hour)</label>
            <div class="zca-slider-wrap">
              <input type="range" class="zca-slider" name="dark_from" data-option="dark_from" min="0" max="23" value="<?php echo esc_attr(zca_o($opts,'dark_from','20')); ?>" data-unit=":00">
              <span class="zca-slider-value"><?php echo esc_attr(zca_o($opts,'dark_from','20')); ?>:00</span>
            </div>
          </div>
          <div class="zca-field">
            <label class="zca-label">Dark Mode Ends (Hour)</label>
            <div class="zca-slider-wrap">
              <input type="range" class="zca-slider" name="dark_to" data-option="dark_to" min="0" max="23" value="<?php echo esc_attr(zca_o($opts,'dark_to','7')); ?>" data-unit=":00">
              <span class="zca-slider-value"><?php echo esc_attr(zca_o($opts,'dark_to','7')); ?>:00</span>
            </div>
          </div>
        </div>
        <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Remember User Preference</div><div class="zca-toggle-row__desc">Store the user's chosen mode in localStorage</div></div><label class="zca-toggle"><input type="checkbox" name="remember_color_mode" data-option="remember_color_mode" <?php checked(zca_o($opts,'remember_color_mode','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
      </div>
    </div><!-- /darkmode -->

  </div><!-- .zca-tab-panels -->
</div><!-- .zca-content -->
</div><!-- .zca-wrap -->
