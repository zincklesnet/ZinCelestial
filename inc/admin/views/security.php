<?php if(!defined('ABSPATH'))exit;
$opts = get_option('zincelestial_options', zc_default_options());
function zca_osec($o,$k,$f=''){return isset($o[$k])?$o[$k]:$f;}
?>
<div class="zca-wrap">
<div class="zca-page-header">
  <div class="zca-page-header__left">
    <div class="zca-page-header__icon">🔒</div>
    <div><div class="zca-page-header__title">Security</div>
    <div class="zca-page-header__sub">Hardening, headers, login protection, XML-RPC, and REST API</div></div>
  </div>
</div>
<div class="zca-content">
  <div class="zca-tabs-nav">
    <button class="zca-tab-btn" data-zc-tab="hardening"><span class="zca-tab-icon">🛡</span> Hardening</button>
    <button class="zca-tab-btn" data-zc-tab="login"><span class="zca-tab-icon">🔑</span> Login</button>
    <button class="zca-tab-btn" data-zc-tab="headers"><span class="zca-tab-icon">📋</span> HTTP Headers</button>
    <button class="zca-tab-btn" data-zc-tab="api"><span class="zca-tab-icon">🔌</span> API Access</button>
  </div>
  <div class="zca-tab-panels">

    <div class="zca-tab-panel" data-zc-panel="hardening">
      <div class="zca-grid zca-grid--2">
        <div class="zca-card">
          <div class="zca-card__header"><div class="zca-card__icon">🛡</div><span class="zca-card__title">Core Hardening</span></div>
          <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Disable File Editor</div><div class="zca-toggle-row__desc">Prevent theme/plugin editing via admin (DISALLOW_FILE_EDIT)</div></div><label class="zca-toggle"><input type="checkbox" name="disable_file_edit" data-option="disable_file_edit" <?php checked(zca_osec($opts,'disable_file_edit','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
          <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Disable XML-RPC</div><div class="zca-toggle-row__desc">Block XML-RPC endpoint (reduces brute-force attack surface)</div></div><label class="zca-toggle"><input type="checkbox" name="disable_xmlrpc" data-option="disable_xmlrpc" <?php checked(zca_osec($opts,'disable_xmlrpc','0'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
          <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Hide WP Version</div><div class="zca-toggle-row__desc">Remove WordPress version from head and feeds</div></div><label class="zca-toggle"><input type="checkbox" name="hide_wp_version" data-option="hide_wp_version" <?php checked(zca_osec($opts,'hide_wp_version','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
          <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Block User Enumeration</div><div class="zca-toggle-row__desc">Redirect ?author=N requests to prevent user ID enumeration</div></div><label class="zca-toggle"><input type="checkbox" name="block_user_enum" data-option="block_user_enum" <?php checked(zca_osec($opts,'block_user_enum','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
          <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Disable Directory Listing</div><div class="zca-toggle-row__desc">Add Options -Indexes via PHP</div></div><label class="zca-toggle"><input type="checkbox" name="disable_dir_listing" data-option="disable_dir_listing" <?php checked(zca_osec($opts,'disable_dir_listing','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
          <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Remove WP Generator Meta</div><div class="zca-toggle-row__desc">Remove &lt;meta name="generator"&gt; tag</div></div><label class="zca-toggle"><input type="checkbox" name="remove_generator" data-option="remove_generator" <?php checked(zca_osec($opts,'remove_generator','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
          <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Block Bad Bots</div><div class="zca-toggle-row__desc">Block known malicious user agents</div></div><label class="zca-toggle"><input type="checkbox" name="block_bad_bots" data-option="block_bad_bots" <?php checked(zca_osec($opts,'block_bad_bots','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
        </div>
        <div class="zca-card">
          <div class="zca-card__header"><div class="zca-card__icon">🔐</div><span class="zca-card__title">Content Security</span></div>
          <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Nonce Verification on AJAX</div><div class="zca-toggle-row__desc">Require WP nonce on all theme AJAX actions</div></div><label class="zca-toggle"><input type="checkbox" name="ajax_nonce_check" data-option="ajax_nonce_check" <?php checked(zca_osec($opts,'ajax_nonce_check','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
          <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Sanitize All Theme Options</div><div class="zca-toggle-row__desc">Force sanitize_text_field on all saved options</div></div><label class="zca-toggle"><input type="checkbox" name="sanitize_options" data-option="sanitize_options" <?php checked(zca_osec($opts,'sanitize_options','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
          <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Escape All Output</div><div class="zca-toggle-row__desc">Force esc_html/esc_attr on all theme output</div></div><label class="zca-toggle"><input type="checkbox" name="escape_output" data-option="escape_output" <?php checked(zca_osec($opts,'escape_output','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
          <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Login Honeypot</div><div class="zca-toggle-row__desc">Hidden honeypot field on login form to trap bots</div></div><label class="zca-toggle"><input type="checkbox" name="login_honeypot" data-option="login_honeypot" <?php checked(zca_osec($opts,'login_honeypot','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
        </div>
      </div>
    </div>

    <div class="zca-tab-panel" data-zc-panel="login">
      <div class="zca-grid zca-grid--2">
        <div class="zca-card">
          <div class="zca-card__header"><div class="zca-card__icon">🔑</div><span class="zca-card__title">Login Protection</span></div>
          <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Custom Login URL</div><div class="zca-toggle-row__desc">Move wp-login.php to a custom URL slug</div></div><label class="zca-toggle"><input type="checkbox" name="custom_login_url" data-option="custom_login_url" <?php checked(zca_osec($opts,'custom_login_url','0'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
          <div class="zca-field">
            <label class="zca-label">Login Slug<span class="zca-hint">e.g. "members/login" replaces wp-login.php</span></label>
            <input type="text" class="zca-input" name="login_slug" data-option="login_slug" value="<?php echo esc_attr(zca_osec($opts,'login_slug','login')); ?>" placeholder="login">
          </div>
          <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Limit Login Attempts</div><div class="zca-toggle-row__desc">Block IP after X failed login attempts</div></div><label class="zca-toggle"><input type="checkbox" name="limit_login_attempts" data-option="limit_login_attempts" <?php checked(zca_osec($opts,'limit_login_attempts','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
          <div class="zca-field">
            <label class="zca-label">Max Login Attempts</label>
            <div class="zca-slider-wrap">
              <input type="range" class="zca-slider" name="max_login_attempts" data-option="max_login_attempts" min="3" max="20" value="<?php echo esc_attr(zca_osec($opts,'max_login_attempts','5')); ?>" data-unit=" tries">
              <span class="zca-slider-value"><?php echo esc_attr(zca_osec($opts,'max_login_attempts','5')); ?> tries</span>
            </div>
          </div>
          <div class="zca-field">
            <label class="zca-label">Lockout Duration (minutes)</label>
            <div class="zca-slider-wrap">
              <input type="range" class="zca-slider" name="lockout_duration" data-option="lockout_duration" min="5" max="1440" value="<?php echo esc_attr(zca_osec($opts,'lockout_duration','30')); ?>" data-unit=" min">
              <span class="zca-slider-value"><?php echo esc_attr(zca_osec($opts,'lockout_duration','30')); ?> min</span>
            </div>
          </div>
        </div>
        <div class="zca-card">
          <div class="zca-card__header"><div class="zca-card__icon">🎨</div><span class="zca-card__title">Custom Login Page</span></div>
          <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Custom Login Page Styling</div><div class="zca-toggle-row__desc">Apply ZinCelestial branding to wp-login.php</div></div><label class="zca-toggle"><input type="checkbox" name="custom_login_style" data-option="custom_login_style" <?php checked(zca_osec($opts,'custom_login_style','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
          <div class="zca-field">
            <label class="zca-label">Login Page Background</label>
            <div class="zca-color-row">
              <div class="zca-color-swatch"><input type="color" name="login_bg" data-option="login_bg" value="<?php echo esc_attr(zca_osec($opts,'login_bg','#07070f')); ?>"></div>
              <input type="text" class="zca-color-hex" value="<?php echo esc_attr(strtoupper(zca_osec($opts,'login_bg','#07070f'))); ?>" maxlength="7">
              <div class="zca-color-preview" style="background:<?php echo esc_attr(zca_osec($opts,'login_bg','#07070f')); ?>"></div>
            </div>
          </div>
          <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Show Logo on Login</div><div class="zca-toggle-row__desc">Display site logo above login form</div></div><label class="zca-toggle"><input type="checkbox" name="login_show_logo" data-option="login_show_logo" <?php checked(zca_osec($opts,'login_show_logo','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
          <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Social Login Buttons</div><div class="zca-toggle-row__desc">Show Google/Facebook login buttons on login page</div></div><label class="zca-toggle"><input type="checkbox" name="social_login_btns" data-option="social_login_btns" <?php checked(zca_osec($opts,'social_login_btns','0'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
        </div>
      </div>
    </div>

    <div class="zca-tab-panel" data-zc-panel="headers">
      <div class="zca-card">
        <div class="zca-card__header"><div class="zca-card__icon">📋</div><span class="zca-card__title">HTTP Security Headers</span></div>
        <div class="zca-notice zca-notice--warning"><span class="zca-notice__icon">⚠</span><div><div class="zca-notice__title">Caution</div>Strict security headers can break some features. Test thoroughly after enabling.</div></div>
        <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">X-Content-Type-Options</div><div class="zca-toggle-row__desc">nosniff — prevents MIME type sniffing</div></div><label class="zca-toggle"><input type="checkbox" name="header_xcto" data-option="header_xcto" <?php checked(zca_osec($opts,'header_xcto','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
        <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">X-Frame-Options</div><div class="zca-toggle-row__desc">SAMEORIGIN — prevent clickjacking</div></div><label class="zca-toggle"><input type="checkbox" name="header_xfo" data-option="header_xfo" <?php checked(zca_osec($opts,'header_xfo','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
        <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">X-XSS-Protection</div><div class="zca-toggle-row__desc">1; mode=block — legacy XSS filter</div></div><label class="zca-toggle"><input type="checkbox" name="header_xxss" data-option="header_xxss" <?php checked(zca_osec($opts,'header_xxss','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
        <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Referrer-Policy</div><div class="zca-toggle-row__desc">strict-origin-when-cross-origin</div></div><label class="zca-toggle"><input type="checkbox" name="header_referrer" data-option="header_referrer" <?php checked(zca_osec($opts,'header_referrer','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
        <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Strict-Transport-Security (HSTS)</div><div class="zca-toggle-row__desc">max-age=31536000 — forces HTTPS for 1 year</div></div><label class="zca-toggle"><input type="checkbox" name="header_hsts" data-option="header_hsts" <?php checked(zca_osec($opts,'header_hsts','0'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
        <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Permissions-Policy</div><div class="zca-toggle-row__desc">Restrict camera, microphone, geolocation access</div></div><label class="zca-toggle"><input type="checkbox" name="header_permissions" data-option="header_permissions" <?php checked(zca_osec($opts,'header_permissions','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
      </div>
    </div>

    <div class="zca-tab-panel" data-zc-panel="api">
      <div class="zca-card">
        <div class="zca-card__header"><div class="zca-card__icon">🔌</div><span class="zca-card__title">REST API & Feeds</span></div>
        <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Require Auth for REST API</div><div class="zca-toggle-row__desc">Block unauthenticated REST API requests</div></div><label class="zca-toggle"><input type="checkbox" name="require_rest_auth" data-option="require_rest_auth" <?php checked(zca_osec($opts,'require_rest_auth','0'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
        <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Remove User Endpoints from REST</div><div class="zca-toggle-row__desc">Hide /wp/v2/users from public REST API</div></div><label class="zca-toggle"><input type="checkbox" name="remove_rest_users" data-option="remove_rest_users" <?php checked(zca_osec($opts,'remove_rest_users','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
        <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Disable RSS/Atom Feeds</div><div class="zca-toggle-row__desc">Block built-in WP feeds</div></div><label class="zca-toggle"><input type="checkbox" name="disable_feeds" data-option="disable_feeds" <?php checked(zca_osec($opts,'disable_feeds','0'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
        <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">ZinCelestial REST API</div><div class="zca-toggle-row__desc">Enable theme's own 9 REST endpoints (zincelestial/v1/)</div></div><label class="zca-toggle"><input type="checkbox" name="zc_rest_api_enabled" data-option="zc_rest_api_enabled" <?php checked(zca_osec($opts,'zc_rest_api_enabled','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
      </div>
    </div>

  </div>
</div>
</div>
