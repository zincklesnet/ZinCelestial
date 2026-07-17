<?php if(!defined('ABSPATH'))exit;
$opts = get_option('zincelestial_options', zc_default_options());
function zca_ot($o,$k,$f=''){return isset($o[$k])?$o[$k]:$f;}
$font_body    = zca_ot($opts,'font_body',"'Inter', system-ui, sans-serif");
$font_display = zca_ot($opts,'font_display',"'Syne', sans-serif");
$font_mono    = zca_ot($opts,'font_mono',"'JetBrains Mono', monospace");
$font_size    = zca_ot($opts,'font_size_base','16');
$line_height  = zca_ot($opts,'line_height','1.6');
$letter_space = zca_ot($opts,'letter_spacing','0');
?>
<div class="zca-wrap">
<div class="zca-page-header">
  <div class="zca-page-header__left">
    <div class="zca-page-header__icon">🔤</div>
    <div><div class="zca-page-header__title">Typography</div>
    <div class="zca-page-header__sub">Font families, sizes, line heights, and spacing scales</div></div>
  </div>
</div>
<div class="zca-content">
  <div class="zca-tabs-nav">
    <button class="zca-tab-btn" data-zc-tab="fonts"><span class="zca-tab-icon">🔤</span> Fonts</button>
    <button class="zca-tab-btn" data-zc-tab="scale"><span class="zca-tab-icon">📏</span> Size Scale</button>
    <button class="zca-tab-btn" data-zc-tab="headings"><span class="zca-tab-icon">H</span> Headings</button>
  </div>
  <div class="zca-tab-panels">

    <!-- Fonts -->
    <div class="zca-tab-panel" data-zc-panel="fonts">
      <div class="zca-grid zca-grid--2">
        <div class="zca-card">
          <div class="zca-card__header"><div class="zca-card__icon">📝</div><span class="zca-card__title">Body Font</span></div>
          <div class="zca-field">
            <label class="zca-label">Font Family</label>
            <select class="zca-select" name="font_body" data-option="font_body">
              <option value="'Inter', system-ui, sans-serif" <?php selected($font_body,"'Inter', system-ui, sans-serif"); ?>>Inter (Default)</option>
              <option value="'Roboto', sans-serif" <?php selected($font_body,"'Roboto', sans-serif"); ?>>Roboto</option>
              <option value="'Open Sans', sans-serif" <?php selected($font_body,"'Open Sans', sans-serif"); ?>>Open Sans</option>
              <option value="'Poppins', sans-serif" <?php selected($font_body,"'Poppins', sans-serif"); ?>>Poppins</option>
              <option value="'Nunito', sans-serif" <?php selected($font_body,"'Nunito', sans-serif"); ?>>Nunito</option>
              <option value="'DM Sans', sans-serif" <?php selected($font_body,"'DM Sans', sans-serif"); ?>>DM Sans</option>
              <option value="system-ui, sans-serif" <?php selected($font_body,"system-ui, sans-serif"); ?>>System Default</option>
            </select>
          </div>
          <div class="zca-font-preview">
            <div class="zca-font-preview__sample" style="font-family:<?php echo esc_attr($font_body); ?>">The quick brown fox jumps</div>
            <div class="zca-font-preview__body" style="font-family:<?php echo esc_attr($font_body); ?>">ZinCelestial gives you full control over your site's typography. Choose the perfect font to match your brand.</div>
            <div class="zca-font-preview__meta"><?php echo esc_html($font_body); ?></div>
          </div>
        </div>
        <div class="zca-card">
          <div class="zca-card__header"><div class="zca-card__icon">🎯</div><span class="zca-card__title">Display (Heading) Font</span></div>
          <div class="zca-field">
            <label class="zca-label">Font Family</label>
            <select class="zca-select" name="font_display" data-option="font_display">
              <option value="'Syne', sans-serif" <?php selected($font_display,"'Syne', sans-serif"); ?>>Syne (Default)</option>
              <option value="'Playfair Display', serif" <?php selected($font_display,"'Playfair Display', serif"); ?>>Playfair Display</option>
              <option value="'Raleway', sans-serif" <?php selected($font_display,"'Raleway', sans-serif"); ?>>Raleway</option>
              <option value="'Montserrat', sans-serif" <?php selected($font_display,"'Montserrat', sans-serif"); ?>>Montserrat</option>
              <option value="'Bebas Neue', sans-serif" <?php selected($font_display,"'Bebas Neue', sans-serif"); ?>>Bebas Neue</option>
              <option value="'Space Grotesk', sans-serif" <?php selected($font_display,"'Space Grotesk', sans-serif"); ?>>Space Grotesk</option>
              <option value="inherit" <?php selected($font_display,"inherit"); ?>>Same as Body</option>
            </select>
          </div>
          <div class="zca-font-preview">
            <div class="zca-font-preview__sample" style="font-family:<?php echo esc_attr($font_display); ?>;font-size:24px;">ZinCelestial Heading Style</div>
            <div class="zca-font-preview__body" style="font-family:<?php echo esc_attr($font_display); ?>;">H1 · H2 · H3 · H4 · H5 · H6</div>
            <div class="zca-font-preview__meta"><?php echo esc_html($font_display); ?></div>
          </div>
        </div>
        <div class="zca-card">
          <div class="zca-card__header"><div class="zca-card__icon">💻</div><span class="zca-card__title">Monospace Font</span></div>
          <div class="zca-field">
            <label class="zca-label">Font Family</label>
            <select class="zca-select" name="font_mono" data-option="font_mono">
              <option value="'JetBrains Mono', monospace" <?php selected($font_mono,"'JetBrains Mono', monospace"); ?>>JetBrains Mono (Default)</option>
              <option value="'Fira Code', monospace" <?php selected($font_mono,"'Fira Code', monospace"); ?>>Fira Code</option>
              <option value="'Source Code Pro', monospace" <?php selected($font_mono,"'Source Code Pro', monospace"); ?>>Source Code Pro</option>
              <option value="monospace" <?php selected($font_mono,"monospace"); ?>>System Mono</option>
            </select>
          </div>
          <div class="zca-font-preview">
            <div class="zca-font-preview__sample" style="font-family:<?php echo esc_attr($font_mono); ?>;font-size:14px;">const zincelestial = 'awesome';</div>
            <div class="zca-font-preview__meta"><?php echo esc_html($font_mono); ?></div>
          </div>
        </div>
        <div class="zca-card">
          <div class="zca-card__header"><div class="zca-card__icon">⚙</div><span class="zca-card__title">Font Loading</span></div>
          <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Load Google Fonts</div><div class="zca-toggle-row__desc">Load selected fonts from Google Fonts CDN</div></div><label class="zca-toggle"><input type="checkbox" name="load_google_fonts" data-option="load_google_fonts" <?php checked(zca_ot($opts,'load_google_fonts','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
          <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Preload Fonts</div><div class="zca-toggle-row__desc">Add font preload hints for faster rendering</div></div><label class="zca-toggle"><input type="checkbox" name="preload_fonts" data-option="preload_fonts" <?php checked(zca_ot($opts,'preload_fonts','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
          <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Font Display: Swap</div><div class="zca-toggle-row__desc">Use font-display:swap for FOIT prevention</div></div><label class="zca-toggle"><input type="checkbox" name="font_display_swap" data-option="font_display_swap" <?php checked(zca_ot($opts,'font_display_swap','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
        </div>
      </div>
    </div>

    <!-- Scale -->
    <div class="zca-tab-panel" data-zc-panel="scale">
      <div class="zca-card">
        <div class="zca-card__header"><div class="zca-card__icon">📏</div><span class="zca-card__title">Type Scale</span></div>
        <div class="zca-grid zca-grid--2">
          <div class="zca-field">
            <label class="zca-label">Base Font Size<span class="zca-hint">Body text size in px</span></label>
            <div class="zca-slider-wrap">
              <input type="range" class="zca-slider" name="font_size_base" data-option="font_size_base" min="12" max="22" value="<?php echo esc_attr($font_size); ?>" data-unit="px" data-token="font-size-base">
              <span class="zca-slider-value"><?php echo esc_attr($font_size); ?>px</span>
            </div>
          </div>
          <div class="zca-field">
            <label class="zca-label">Line Height<span class="zca-hint">Body line-height multiplier</span></label>
            <div class="zca-slider-wrap">
              <input type="range" class="zca-slider" name="line_height" data-option="line_height" min="1" max="2.5" step="0.1" value="<?php echo esc_attr($line_height); ?>" data-unit="">
              <span class="zca-slider-value"><?php echo esc_attr($line_height); ?></span>
            </div>
          </div>
          <div class="zca-field">
            <label class="zca-label">Letter Spacing<span class="zca-hint">Body tracking in em</span></label>
            <div class="zca-slider-wrap">
              <input type="range" class="zca-slider" name="letter_spacing" data-option="letter_spacing" min="-0.05" max="0.2" step="0.01" value="<?php echo esc_attr($letter_space); ?>" data-unit="em">
              <span class="zca-slider-value"><?php echo esc_attr($letter_space); ?>em</span>
            </div>
          </div>
          <div class="zca-field">
            <label class="zca-label">Paragraph Spacing<span class="zca-hint">Bottom margin on paragraphs</span></label>
            <div class="zca-slider-wrap">
              <input type="range" class="zca-slider" name="para_spacing" data-option="para_spacing" min="0" max="32" value="<?php echo esc_attr(zca_ot($opts,'para_spacing','16')); ?>" data-unit="px" data-token="para-spacing">
              <span class="zca-slider-value"><?php echo esc_attr(zca_ot($opts,'para_spacing','16')); ?>px</span>
            </div>
          </div>
        </div>
        <div class="zca-divider"></div>
        <div class="zca-field">
          <label class="zca-label">Live Preview</label>
          <div style="background:var(--zca-surface);border:1px solid var(--zca-border);border-radius:var(--zca-radius-md);padding:20px;">
            <p style="font-family:<?php echo esc_attr($font_display); ?>;font-size:26px;font-weight:700;margin-bottom:8px;color:var(--zca-text);">Heading One</p>
            <p style="font-family:<?php echo esc_attr($font_body); ?>;font-size:<?php echo esc_attr($font_size); ?>px;line-height:<?php echo esc_attr($line_height); ?>;color:var(--zca-muted);">This is body text at your configured size. ZinCelestial renders beautifully at any scale with your chosen font combination.</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Headings -->
    <div class="zca-tab-panel" data-zc-panel="headings">
      <div class="zca-card">
        <div class="zca-card__header"><div class="zca-card__icon">H</div><span class="zca-card__title">Heading Sizes</span></div>
        <?php
        $headings = ['h1'=>['H1','40'],['h2'=>['H2','32']],['h3'=>['H3','26']],['h4'=>['H4','20']],['h5'=>['H5','16']],['h6'=>['H6','14']]];
        $hdata = [['h1','H1','40'],['h2','H2','32'],['h3','H3','26'],['h4','H4','20'],['h5','H5','16'],['h6','H6','14']];
        foreach($hdata as $h):
        ?>
        <div class="zca-field">
          <label class="zca-label"><?php echo $h[1]; ?> Size</label>
          <div class="zca-slider-wrap">
            <input type="range" class="zca-slider" name="heading_<?php echo $h[0]; ?>_size" data-option="heading_<?php echo $h[0]; ?>_size" min="10" max="72" value="<?php echo esc_attr(zca_ot($opts,'heading_'.$h[0].'_size',$h[2])); ?>" data-unit="px" data-token="<?php echo $h[0]; ?>-size">
            <span class="zca-slider-value"><?php echo esc_attr(zca_ot($opts,'heading_'.$h[0].'_size',$h[2])); ?>px</span>
            <span style="font-size:<?php echo esc_attr(zca_ot($opts,'heading_'.$h[0].'_size',$h[2])); ?>px;font-family:<?php echo esc_attr($font_display); ?>;color:var(--zca-text);font-weight:700;line-height:1;"><?php echo $h[1]; ?></span>
          </div>
        </div>
        <?php endforeach; ?>
        <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Heading Font Weight: Bold</div><div class="zca-toggle-row__desc">Use 700 weight for all headings</div></div><label class="zca-toggle"><input type="checkbox" name="heading_bold" data-option="heading_bold" <?php checked(zca_ot($opts,'heading_bold','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
        <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Gradient Headings</div><div class="zca-toggle-row__desc">Apply primary gradient text to H1 and H2</div></div><label class="zca-toggle"><input type="checkbox" name="heading_gradient" data-option="heading_gradient" <?php checked(zca_ot($opts,'heading_gradient','0'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
      </div>
    </div>

  </div>
</div>
</div>
