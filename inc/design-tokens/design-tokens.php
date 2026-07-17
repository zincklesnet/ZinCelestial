<?php
if(!defined('ABSPATH'))exit;
/**
 * ZinCelestial — Design Tokens
 * v3.3 Fix: CSS custom property values were being run through esc_attr() which
 *           HTML-encodes single quotes in font-family strings — e.g.
 *           "'Inter', sans-serif" became "&#039;Inter&#039;, sans-serif",
 *           causing CSS to silently fail and the fallback design tokens to not
 *           apply. CSS values inside a <style> tag must NOT be HTML-escaped.
 *           Instead we sanitize each value type appropriately and strip any
 *           </style> injection attempts.
 *
 *           Also fixes: empty zc_option() calls returning '' caused CSS vars
 *           to output as `--zc-primary:;` (invalid). Fallbacks are now always
 *           hard-coded in get_tokens() so invalid values never reach the DOM.
 */
class ZC_Design_Tokens{
  public static function init(){
    add_action('wp_head',array('ZC_Design_Tokens','output_tokens'),5);
    add_action('admin_head',array('ZC_Design_Tokens','output_tokens'),5);
    add_action('customize_register',array('ZC_Design_Tokens','customizer_tokens'));
  }

  // ── Token definitions with guaranteed fallbacks ───────────────────────────
  public static function get_tokens(){
    return array(
      // Colors
      '--zc-primary'        => zc_option('color_primary','#7c6ff7'),
      '--zc-secondary'      => zc_option('color_secondary','#00d4ff'),
      '--zc-accent'         => zc_option('color_accent','#a78bfa'),
      '--zc-success'        => zc_option('color_success','#34d399'),
      '--zc-warning'        => zc_option('color_warning','#fbbf24'),
      '--zc-danger'         => zc_option('color_danger','#f87171'),
      '--zc-info'           => zc_option('color_info','#38bdf8'),
      // Backgrounds / surfaces
      '--zc-bg'             => zc_option('color_bg','#07070f'),
      '--zc-surface'        => zc_option('color_surface','#0f0f1f'),
      '--zc-card'           => zc_option('color_card','#161626'),
      '--zc-border'         => zc_option('color_border','#1e1e3a'),
      // Text
      '--zc-text'           => zc_option('color_text','#e2e8f0'),
      '--zc-text-muted'     => zc_option('color_text_muted','#94a3b8'),
      '--zc-text-faint'     => zc_option('color_text_faint','#64748b'),
      // Gradients (string values — safe passthrough)
      '--zc-gradient-primary'  => 'linear-gradient(135deg,'.zc_option('color_primary','#7c6ff7').','.zc_option('color_secondary','#00d4ff').')',
      '--zc-gradient-accent'   => 'linear-gradient(135deg,'.zc_option('color_accent','#a78bfa').','.zc_option('color_primary','#7c6ff7').')',
      // Sizing
      '--zc-header-h'       => intval(zc_option('header_height',72)).'px',
      '--zc-sidebar-w'      => intval(zc_option('sidebar_width',280)).'px',
      '--zc-radius-sm'      => '8px',
      '--zc-radius-md'      => intval(zc_option('border_radius',12)).'px',
      '--zc-radius-lg'      => (intval(zc_option('border_radius',12))*2).'px',
      '--zc-radius-full'    => '9999px',
      // Typography — MUST NOT be HTML-escaped (contain quotes & commas)
      '--zc-font-body'      => zc_option('font_body',"'Inter', system-ui, sans-serif"),
      '--zc-font-display'   => zc_option('font_display',"'Syne', sans-serif"),
      '--zc-font-mono'      => zc_option('font_mono',"'JetBrains Mono', monospace"),
      // Shadows
      '--zc-shadow-sm'      => '0 1px 3px rgba(0,0,0,.4)',
      '--zc-shadow-md'      => '0 4px 16px rgba(0,0,0,.5)',
      '--zc-shadow-lg'      => '0 8px 32px rgba(0,0,0,.6)',
      '--zc-shadow-glow'    => '0 0 24px '.zc_option('color_primary','#7c6ff7').'55',
      // Transitions
      '--zc-transition'     => '0.2s ease',
      '--zc-transition-slow'=> '0.4s ease',
    );
  }

  /**
   * Output CSS custom properties into <style> tag.
   *
   * CSS property VALUES must never be run through esc_attr() or esc_html() —
   * those functions convert quotes and break font-family and other string values.
   * Instead we sanitize each value with zc_sanitize_css_value() which strips
   * any </style> injection while leaving CSS syntax intact.
   */
  public static function output_tokens(){
    $tokens=self::get_tokens();
    echo '<style id="zc-design-tokens">:root{';
    foreach($tokens as $prop=>$value){
      // Sanitize property name — only allow valid CSS custom property chars
      $safe_prop=preg_replace('/[^a-z0-9\-]/','',$prop);
      if(strpos($safe_prop,'--')!==0)$safe_prop='--zc-fallback';
      // Sanitize value — strip </style> injection, keep CSS syntax intact
      $safe_val=self::sanitize_css_value($value);
      if($safe_val!==''){
        echo $safe_prop.':'.$safe_val.';';
      }
    }
    echo '}</style>'."\n";
  }

  /**
   * CSS value sanitizer — safe for inside <style> tags.
   * Strips </style> injection attempts. Does NOT HTML-encode.
   *
   * @param  string $value Raw CSS value
   * @return string        Safe CSS value
   */
  public static function sanitize_css_value($value){
    // Remove any attempt to close the style tag
    $value=str_ireplace(array('</style>','</Style>','</STYLE>'),'',(string)$value);
    // Remove any HTML tags
    $value=strip_tags($value);
    // Trim
    return trim($value);
  }

  public static function customizer_tokens($wp_customize){
    do_action('zc_customizer_tokens',$wp_customize);
  }
}
ZC_Design_Tokens::init();
