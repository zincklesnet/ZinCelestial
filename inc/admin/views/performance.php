<?php if(!defined('ABSPATH'))exit;
$opts = get_option('zincelestial_options', zc_default_options());
function zca_operf($o,$k,$f=''){return isset($o[$k])?$o[$k]:$f;}
?>
<div class="zca-wrap">
<div class="zca-page-header">
  <div class="zca-page-header__left">
    <div class="zca-page-header__icon">⚡</div>
    <div><div class="zca-page-header__title">Performance</div>
    <div class="zca-page-header__sub">Lazy load, preload, caching, script defer, and optimization</div></div>
  </div>
</div>
<div class="zca-content">
  <div class="zca-tabs-nav">
    <button class="zca-tab-btn" data-zc-tab="loading"><span class="zca-tab-icon">⚡</span> Loading</button>
    <button class="zca-tab-btn" data-zc-tab="cache"><span class="zca-tab-icon">💾</span> Cache</button>
    <button class="zca-tab-btn" data-zc-tab="scripts"><span class="zca-tab-icon">📜</span> Scripts & Styles</button>
    <button class="zca-tab-btn" data-zc-tab="images"><span class="zca-tab-icon">🖼</span> Images</button>
  </div>
  <div class="zca-tab-panels">

    <div class="zca-tab-panel" data-zc-panel="loading">
      <div class="zca-grid zca-grid--2">
        <div class="zca-card">
          <div class="zca-card__header"><div class="zca-card__icon">⚡</div><span class="zca-card__title">Critical Loading</span></div>
          <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Critical CSS Inline</div><div class="zca-toggle-row__desc">Inline above-the-fold CSS in &lt;head&gt;</div></div><label class="zca-toggle"><input type="checkbox" name="critical_css_inline" data-option="critical_css_inline" <?php checked(zca_operf($opts,'critical_css_inline','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
          <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Preload Hero Image</div><div class="zca-toggle-row__desc">Add &lt;link rel=preload&gt; for featured images</div></div><label class="zca-toggle"><input type="checkbox" name="enable_preload" data-option="enable_preload" <?php checked(zca_operf($opts,'enable_preload','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
          <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">DNS Prefetch</div><div class="zca-toggle-row__desc">Prefetch external domain DNS</div></div><label class="zca-toggle"><input type="checkbox" name="dns_prefetch" data-option="dns_prefetch" <?php checked(zca_operf($opts,'dns_prefetch','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
          <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Preconnect to Google Fonts</div><div class="zca-toggle-row__desc">Early connection to fonts.googleapis.com</div></div><label class="zca-toggle"><input type="checkbox" name="preconnect_gfonts" data-option="preconnect_gfonts" <?php checked(zca_operf($opts,'preconnect_gfonts','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
          <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Prefetch Next Page</div><div class="zca-toggle-row__desc">Prefetch next pagination page on hover</div></div><label class="zca-toggle"><input type="checkbox" name="prefetch_next_page" data-option="prefetch_next_page" <?php checked(zca_operf($opts,'prefetch_next_page','0'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
        </div>
        <div class="zca-card">
          <div class="zca-card__header"><div class="zca-card__icon">📊</div><span class="zca-card__title">Resource Limits</span></div>
          <div class="zca-field">
            <label class="zca-label">Max Heartbeat Interval (sec)<span class="zca-hint">WordPress admin heartbeat frequency</span></label>
            <div class="zca-slider-wrap">
              <input type="range" class="zca-slider" name="heartbeat_interval" data-option="heartbeat_interval" min="15" max="120" value="<?php echo esc_attr(zca_operf($opts,'heartbeat_interval','60')); ?>" data-unit="s">
              <span class="zca-slider-value"><?php echo esc_attr(zca_operf($opts,'heartbeat_interval','60')); ?>s</span>
            </div>
          </div>
          <div class="zca-field">
            <label class="zca-label">Post Revisions to Keep</label>
            <div class="zca-slider-wrap">
              <input type="range" class="zca-slider" name="post_revisions" data-option="post_revisions" min="0" max="20" value="<?php echo esc_attr(zca_operf($opts,'post_revisions','5')); ?>" data-unit="">
              <span class="zca-slider-value"><?php echo esc_attr(zca_operf($opts,'post_revisions','5')); ?></span>
            </div>
          </div>
          <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Limit Heartbeat to Editor Only</div><div class="zca-toggle-row__desc">Disable heartbeat API on frontend</div></div><label class="zca-toggle"><input type="checkbox" name="limit_heartbeat" data-option="limit_heartbeat" <?php checked(zca_operf($opts,'limit_heartbeat','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
          <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Disable Emoji Scripts</div><div class="zca-toggle-row__desc">Remove WP emoji detection JS/CSS</div></div><label class="zca-toggle"><input type="checkbox" name="disable_emoji" data-option="disable_emoji" <?php checked(zca_operf($opts,'disable_emoji','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
          <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Disable oEmbed</div><div class="zca-toggle-row__desc">Remove oEmbed discovery links from head</div></div><label class="zca-toggle"><input type="checkbox" name="disable_oembed" data-option="disable_oembed" <?php checked(zca_operf($opts,'disable_oembed','0'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
        </div>
      </div>
    </div>

    <div class="zca-tab-panel" data-zc-panel="cache">
      <div class="zca-card">
        <div class="zca-card__header"><div class="zca-card__icon">💾</div><span class="zca-card__title">Browser & Object Caching</span></div>
        <div class="zca-notice zca-notice--info"><span class="zca-notice__icon">ℹ</span><div>ZinCelestial sets browser cache headers and transient TTLs. For full page caching, use a dedicated plugin like WP Rocket or W3 Total Cache.</div></div>
        <div class="zca-grid zca-grid--2">
          <div class="zca-field">
            <label class="zca-label">Transient Cache TTL (hours)</label>
            <div class="zca-slider-wrap">
              <input type="range" class="zca-slider" name="transient_ttl" data-option="transient_ttl" min="1" max="72" value="<?php echo esc_attr(zca_operf($opts,'transient_ttl','12')); ?>" data-unit="h">
              <span class="zca-slider-value"><?php echo esc_attr(zca_operf($opts,'transient_ttl','12')); ?>h</span>
            </div>
          </div>
          <div class="zca-field">
            <label class="zca-label">Static Asset Cache (days)</label>
            <div class="zca-slider-wrap">
              <input type="range" class="zca-slider" name="static_cache_days" data-option="static_cache_days" min="1" max="365" value="<?php echo esc_attr(zca_operf($opts,'static_cache_days','30')); ?>" data-unit="d">
              <span class="zca-slider-value"><?php echo esc_attr(zca_operf($opts,'static_cache_days','30')); ?>d</span>
            </div>
          </div>
        </div>
        <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Cache GamiPress Queries</div><div class="zca-toggle-row__desc">Transient cache for points/rank lookups</div></div><label class="zca-toggle"><input type="checkbox" name="cache_gamipress" data-option="cache_gamipress" <?php checked(zca_operf($opts,'cache_gamipress','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
        <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Cache User Meta</div><div class="zca-toggle-row__desc">Object cache for frequent user meta lookups</div></div><label class="zca-toggle"><input type="checkbox" name="cache_user_meta" data-option="cache_user_meta" <?php checked(zca_operf($opts,'cache_user_meta','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
        <div class="zca-mt"><button class="zca-btn zca-btn--danger zca-btn--sm" onclick="if(confirm('Flush all ZinCelestial transient caches?')){}">🗑 Flush All Caches</button></div>
      </div>
    </div>

    <div class="zca-tab-panel" data-zc-panel="scripts">
      <div class="zca-grid zca-grid--2">
        <div class="zca-card">
          <div class="zca-card__header"><div class="zca-card__icon">📜</div><span class="zca-card__title">JavaScript</span></div>
          <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Defer Non-Critical JS</div><div class="zca-toggle-row__desc">Add defer attribute to non-critical scripts</div></div><label class="zca-toggle"><input type="checkbox" name="defer_js" data-option="defer_js" <?php checked(zca_operf($opts,'defer_js','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
          <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Async External Scripts</div><div class="zca-toggle-row__desc">Load third-party scripts asynchronously</div></div><label class="zca-toggle"><input type="checkbox" name="async_external" data-option="async_external" <?php checked(zca_operf($opts,'async_external','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
          <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Minify JS</div><div class="zca-toggle-row__desc">Minify ZinCelestial JS files</div></div><label class="zca-toggle"><input type="checkbox" name="minify_js" data-option="minify_js" <?php checked(zca_operf($opts,'minify_js','0'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
          <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Remove jQuery Migrate</div><div class="zca-toggle-row__desc">Remove deprecated jQuery migrate script</div></div><label class="zca-toggle"><input type="checkbox" name="remove_jquery_migrate" data-option="remove_jquery_migrate" <?php checked(zca_operf($opts,'remove_jquery_migrate','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
        </div>
        <div class="zca-card">
          <div class="zca-card__header"><div class="zca-card__icon">🎨</div><span class="zca-card__title">CSS</span></div>
          <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Minify CSS</div><div class="zca-toggle-row__desc">Minify ZinCelestial CSS output</div></div><label class="zca-toggle"><input type="checkbox" name="minify_css" data-option="minify_css" <?php checked(zca_operf($opts,'minify_css','0'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
          <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Load CSS Async</div><div class="zca-toggle-row__desc">Non-blocking CSS loading for non-critical sheets</div></div><label class="zca-toggle"><input type="checkbox" name="css_async" data-option="css_async" <?php checked(zca_operf($opts,'css_async','0'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
          <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Conditional Asset Loading</div><div class="zca-toggle-row__desc">Only load plugin CSS when that plugin's content is present</div></div><label class="zca-toggle"><input type="checkbox" name="conditional_assets" data-option="conditional_assets" <?php checked(zca_operf($opts,'conditional_assets','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
        </div>
      </div>
    </div>

    <div class="zca-tab-panel" data-zc-panel="images">
      <div class="zca-card">
        <div class="zca-card__header"><div class="zca-card__icon">🖼</div><span class="zca-card__title">Image Optimization</span></div>
        <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Lazy Load Images</div><div class="zca-toggle-row__desc">Native loading="lazy" on all images</div></div><label class="zca-toggle"><input type="checkbox" name="enable_lazy_load" data-option="enable_lazy_load" <?php checked(zca_operf($opts,'enable_lazy_load','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
        <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Lazy Load Iframes</div><div class="zca-toggle-row__desc">Native loading="lazy" on iframes (YouTube embeds)</div></div><label class="zca-toggle"><input type="checkbox" name="lazy_load_iframes" data-option="lazy_load_iframes" <?php checked(zca_operf($opts,'lazy_load_iframes','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
        <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">WebP Auto-Convert</div><div class="zca-toggle-row__desc">Serve WebP versions when browser supports it</div></div><label class="zca-toggle"><input type="checkbox" name="webp_images" data-option="webp_images" <?php checked(zca_operf($opts,'webp_images','0'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
        <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">LQIP Placeholders</div><div class="zca-toggle-row__desc">Show blurred low-quality placeholder while loading</div></div><label class="zca-toggle"><input type="checkbox" name="lqip_placeholder" data-option="lqip_placeholder" <?php checked(zca_operf($opts,'lqip_placeholder','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
        <div class="zca-field">
          <label class="zca-label">Image Lazy Load Threshold (px)<span class="zca-hint">Distance from viewport to start loading</span></label>
          <div class="zca-slider-wrap">
            <input type="range" class="zca-slider" name="lazy_threshold" data-option="lazy_threshold" min="0" max="1000" value="<?php echo esc_attr(zca_operf($opts,'lazy_threshold','300')); ?>" data-unit="px">
            <span class="zca-slider-value"><?php echo esc_attr(zca_operf($opts,'lazy_threshold','300')); ?>px</span>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>
</div>
