<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * ZinCelestial — Post Meta Box v4.3
 * Fixes: Tab switching JS (vanilla JS, no jQuery dep), save field name mapping
 */
class ZC_Post_Meta {
    public static function init() {
        add_action( 'add_meta_boxes',       [ __CLASS__, 'register' ] );
        add_action( 'save_post',            [ __CLASS__, 'save' ], 10, 2 );
        add_action( 'admin_enqueue_scripts',[ __CLASS__, 'enqueue' ] );
    }

    public static function register() {
        $post_types = get_post_types( [ 'public' => true ], 'names' );
        foreach ( $post_types as $pt ) {
            add_meta_box(
                'zc-page-options',
                __( 'ZinCelestial Page Options', 'zincelestial' ),
                [ __CLASS__, 'render' ],
                $pt,
                'normal',
                'default'
            );
        }
    }

    public static function enqueue( $hook ) {
        if ( ! in_array( $hook, [ 'post.php', 'post-new.php' ], true ) ) return;
        wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_media();
        wp_enqueue_script( 'wp-color-picker' );
    }

    public static function render( $post ) {
        wp_nonce_field( 'zc_meta_save', 'zc_meta_nonce' );

        // Layout
        $layout    = get_post_meta( $post->ID, '_zc_content_layout',  true ) ?: 'default';
        $hide_left = get_post_meta( $post->ID, '_zc_hide_left_panel', true ) ?: 'default';
        $show_title= get_post_meta( $post->ID, '_zc_show_title',      true ) !== '0' ? '1' : '0';
        $r_sidebar = get_post_meta( $post->ID, '_zc_sidebar_right',   true );
        $l_sidebar = get_post_meta( $post->ID, '_zc_sidebar_left',    true );

        // Subheader
        $sub_override    = get_post_meta( $post->ID, '_zc_sub_override',    true );
        $sub_height      = get_post_meta( $post->ID, '_zc_sub_height',      true ) ?: '200';
        $sub_bg          = get_post_meta( $post->ID, '_zc_sub_bg',          true ) ?: '#0f0f1f';
        $sub_overlay     = get_post_meta( $post->ID, '_zc_sub_overlay',     true ) ?: 'rgba(0,0,0,0.4)';
        $sub_text_color  = get_post_meta( $post->ID, '_zc_sub_text_color',  true ) ?: '#e2e8f0';
        $sub_link_color  = get_post_meta( $post->ID, '_zc_sub_link_color',  true ) ?: '#a78bfa';
        $sub_breadcrumbs = get_post_meta( $post->ID, '_zc_sub_breadcrumbs', true );
        $sub_feat_img    = get_post_meta( $post->ID, '_zc_sub_feat_img',    true );
        $sub_banner      = get_post_meta( $post->ID, '_zc_sub_banner',      true );
        $sub_banner_id   = get_post_meta( $post->ID, '_zc_sub_banner_id',   true );

        // Background
        $bg_override = get_post_meta( $post->ID, '_zc_bg_override', true );
        $bg_type     = get_post_meta( $post->ID, '_zc_bg_type',     true ) ?: 'color';
        $bg_color    = get_post_meta( $post->ID, '_zc_bg_color',    true ) ?: '#07070f';
        $bg_image    = get_post_meta( $post->ID, '_zc_bg_image',    true );
        $bg_image_id = get_post_meta( $post->ID, '_zc_bg_image_id', true );
        $bg_repeat   = get_post_meta( $post->ID, '_zc_bg_repeat',   true ) ?: 'no-repeat';
        $bg_attach   = get_post_meta( $post->ID, '_zc_bg_attach',   true ) ?: 'fixed';
        $bg_size     = get_post_meta( $post->ID, '_zc_bg_size',     true ) ?: 'cover';
        $bg_gradient = get_post_meta( $post->ID, '_zc_bg_gradient', true ) ?: 'linear-gradient(135deg, #0f0f1f, #1e1b4b)';

        // Sidebar list
        $sidebars    = $GLOBALS['wp_registered_sidebars'] ?? [];
        $sidebar_opts= '<option value="">— Default —</option>';
        foreach ( $sidebars as $s ) {
            $sidebar_opts .= '<option value="' . esc_attr( $s['id'] ) . '" ' . selected( $r_sidebar, $s['id'], false ) . '>' . esc_html( $s['name'] ) . '</option>';
        }
        $sidebar_opts_l = str_replace( "selected( $r_sidebar", "selected( $l_sidebar", $sidebar_opts );
        // Rebuild for left sidebar properly
        $sidebar_opts_l = '<option value="">— Default —</option>';
        foreach ( $sidebars as $s ) {
            $sidebar_opts_l .= '<option value="' . esc_attr( $s['id'] ) . '" ' . selected( $l_sidebar, $s['id'], false ) . '>' . esc_html( $s['name'] ) . '</option>';
        }
        ?>
<style>
.zc-metabox { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; }
.zc-mb-tabs { display:flex; gap:0; margin:0 0 0; padding:0; list-style:none; border-bottom:2px solid #e2e8f0; background:#f8f9fa; border-radius:6px 6px 0 0; overflow:hidden; }
.zc-mb-tab-btn { background:none; border:none; padding:10px 18px; cursor:pointer; font-size:.875rem; font-weight:500; color:#64748b; border-bottom:3px solid transparent; margin-bottom:-2px; transition:all .15s; }
.zc-mb-tab-btn.active, .zc-mb-tab-btn:focus { color:#7c6ff7; border-bottom-color:#7c6ff7; background:#fff; outline:none; }
.zc-mb-tab-panel { display:none; padding:20px 4px 4px; }
.zc-mb-tab-panel.active { display:block; }
.zc-meta-row { display:grid; grid-template-columns:180px 1fr; gap:12px; align-items:start; padding:10px 0; border-bottom:1px solid #f1f5f9; }
.zc-meta-row:last-child { border-bottom:none; }
.zc-meta-label { font-weight:600; font-size:.8rem; color:#374151; padding-top:6px; }
.zc-meta-hint { font-size:.75rem; color:#9ca3af; margin-top:4px; }
.zc-toggle-field { display:flex; align-items:center; gap:8px; }
.zc-toggle-field input[type=checkbox] { width:18px; height:18px; accent-color:#7c6ff7; cursor:pointer; }
.zc-meta-section-title { font-size:.7rem; font-weight:700; text-transform:uppercase; letter-spacing:.08em; color:#94a3b8; padding:12px 0 6px; }
</style>
<div class="zc-metabox">
<!-- Tab Nav — Vanilla JS only, no jQuery dependency -->
<ul class="zc-mb-tabs" id="zc-mb-tablist">
  <li><button type="button" class="zc-mb-tab-btn active" data-target="zc-mb-layout">📐 Layout</button></li>
  <li><button type="button" class="zc-mb-tab-btn" data-target="zc-mb-subheader">🖼 Subheader</button></li>
  <li><button type="button" class="zc-mb-tab-btn" data-target="zc-mb-background">🎨 Background</button></li>
</ul>

<!-- TAB 1: Layout -->
<div id="zc-mb-layout" class="zc-mb-tab-panel active">
  <div class="zc-meta-row">
    <div class="zc-meta-label">Display Page Title</div>
    <div class="zc-toggle-field">
      <input type="checkbox" name="_zc_show_title" id="_zc_show_title" value="1" <?php checked( $show_title, '1' ); ?>>
      <label for="_zc_show_title">Show the page title in the subheader / page header area</label>
    </div>
  </div>
  <div class="zc-meta-row">
    <div class="zc-meta-label">Hide Left Panel Menu</div>
    <div>
      <select name="_zc_hide_left_panel" class="widefat">
        <option value="default" <?php selected( $hide_left, 'default' ); ?>>Default (follow global)</option>
        <option value="yes"     <?php selected( $hide_left, 'yes' ); ?>>Yes — Hide left panel</option>
        <option value="no"      <?php selected( $hide_left, 'no' ); ?>>No — Show left panel</option>
      </select>
    </div>
  </div>
  <div class="zc-meta-row">
    <div class="zc-meta-label">Content Layout</div>
    <div>
      <select name="_zc_content_layout" class="widefat">
        <option value="default"       <?php selected( $layout, 'default' ); ?>>Default (follow global)</option>
        <option value="full-width"    <?php selected( $layout, 'full-width' ); ?>>Full Width</option>
        <option value="left-sidebar"  <?php selected( $layout, 'left-sidebar' ); ?>>Left Sidebar</option>
        <option value="right-sidebar" <?php selected( $layout, 'right-sidebar' ); ?>>Right Sidebar</option>
        <option value="both-sidebars" <?php selected( $layout, 'both-sidebars' ); ?>>Both Sidebars</option>
      </select>
    </div>
  </div>
  <div class="zc-meta-row">
    <div class="zc-meta-label">Right Sidebar</div>
    <div><select name="_zc_sidebar_right" class="widefat"><?php echo $sidebar_opts; ?></select></div>
  </div>
  <div class="zc-meta-row">
    <div class="zc-meta-label">Left Sidebar</div>
    <div><select name="_zc_sidebar_left" class="widefat"><?php echo $sidebar_opts_l; ?></select></div>
  </div>
</div>

<!-- TAB 2: Subheader -->
<div id="zc-mb-subheader" class="zc-mb-tab-panel">
  <div class="zc-meta-row">
    <div class="zc-meta-label">Override Subheader</div>
    <div class="zc-toggle-field">
      <input type="checkbox" name="_zc_sub_override" id="_zc_sub_override" value="1" <?php checked( $sub_override, '1' ); ?>>
      <label for="_zc_sub_override">Overwrite global Subheader/Customizer settings for this post/page</label>
    </div>
  </div>
  <div class="zc-meta-row">
    <div class="zc-meta-label">Subheader Height (px)</div>
    <div><input type="number" name="_zc_sub_height" class="widefat" value="<?php echo esc_attr( $sub_height ); ?>" min="40" max="800" step="10"></div>
  </div>
  <div class="zc-meta-row">
    <div class="zc-meta-label">Background Color</div>
    <div><input type="text" name="_zc_sub_bg" class="widefat" value="<?php echo esc_attr( $sub_bg ); ?>" placeholder="#0f0f1f"></div>
  </div>
  <div class="zc-meta-row">
    <div class="zc-meta-label">Overlay Color</div>
    <div><input type="text" name="_zc_sub_overlay" class="widefat" value="<?php echo esc_attr( $sub_overlay ); ?>" placeholder="rgba(0,0,0,0.4)"></div>
  </div>
  <div class="zc-meta-row">
    <div class="zc-meta-label">Text Color</div>
    <div><input type="text" name="_zc_sub_text_color" class="widefat" value="<?php echo esc_attr( $sub_text_color ); ?>" placeholder="#e2e8f0"></div>
  </div>
  <div class="zc-meta-row">
    <div class="zc-meta-label">Link Color</div>
    <div><input type="text" name="_zc_sub_link_color" class="widefat" value="<?php echo esc_attr( $sub_link_color ); ?>" placeholder="#a78bfa"></div>
  </div>
  <div class="zc-meta-row">
    <div class="zc-meta-label">Show Breadcrumbs</div>
    <div class="zc-toggle-field">
      <input type="checkbox" name="_zc_sub_breadcrumbs" id="_zc_sub_breadcrumbs" value="1" <?php checked( $sub_breadcrumbs, '1' ); ?>>
      <label for="_zc_sub_breadcrumbs">Display breadcrumbs in the subheader</label>
    </div>
  </div>
  <div class="zc-meta-row">
    <div class="zc-meta-label">Featured Image as Header</div>
    <div class="zc-toggle-field">
      <input type="checkbox" name="_zc_sub_feat_img" id="_zc_sub_feat_img" value="1" <?php checked( $sub_feat_img, '1' ); ?>>
      <label for="_zc_sub_feat_img">Use the post's featured image as subheader banner</label>
    </div>
  </div>
  <div class="zc-meta-row">
    <div class="zc-meta-label">Custom Banner Image</div>
    <div>
      <div style="display:flex;gap:8px;align-items:center;">
        <input type="hidden" name="_zc_sub_banner_id" id="_zc_sub_banner_id" value="<?php echo esc_attr( $sub_banner_id ); ?>">
        <input type="text" name="_zc_sub_banner" id="_zc_sub_banner" class="widefat" value="<?php echo esc_url( $sub_banner ); ?>" placeholder="Image URL or select below" readonly>
        <button type="button" class="button" id="zc-banner-select">Select</button>
        <button type="button" class="button" id="zc-banner-clear">Clear</button>
      </div>
      <?php if ( $sub_banner ): ?>
      <img src="<?php echo esc_url( $sub_banner ); ?>" style="max-width:200px;max-height:60px;margin-top:8px;border-radius:4px;" id="zc-banner-preview">
      <?php else: ?>
      <img src="" style="max-width:200px;max-height:60px;margin-top:8px;border-radius:4px;display:none;" id="zc-banner-preview">
      <?php endif; ?>
    </div>
  </div>
</div>

<!-- TAB 3: Background -->
<div id="zc-mb-background" class="zc-mb-tab-panel">
  <div class="zc-meta-row">
    <div class="zc-meta-label">Override Background</div>
    <div class="zc-toggle-field">
      <input type="checkbox" name="_zc_bg_override" id="_zc_bg_override" value="1" <?php checked( $bg_override, '1' ); ?>>
      <label for="_zc_bg_override">Override the default background for this post/page only</label>
    </div>
  </div>
  <div class="zc-meta-row">
    <div class="zc-meta-label">Background Type</div>
    <div>
      <select name="_zc_bg_type" id="_zc_bg_type" class="widefat" onchange="zcBgTypeSwitch(this.value)">
        <option value="color"    <?php selected( $bg_type, 'color' ); ?>>Solid Color</option>
        <option value="gradient" <?php selected( $bg_type, 'gradient' ); ?>>Gradient</option>
        <option value="image"    <?php selected( $bg_type, 'image' ); ?>>Image</option>
        <option value="video"    <?php selected( $bg_type, 'video' ); ?>>Video (URL)</option>
      </select>
    </div>
  </div>
  <div id="zc-bg-color-row" class="zc-meta-row" style="<?php echo $bg_type !== 'color' ? 'display:none;' : ''; ?>">
    <div class="zc-meta-label">Background Color</div>
    <div><input type="text" name="_zc_bg_color" class="widefat" value="<?php echo esc_attr( $bg_color ); ?>" placeholder="#07070f"></div>
  </div>
  <div id="zc-bg-gradient-row" class="zc-meta-row" style="<?php echo $bg_type !== 'gradient' ? 'display:none;' : ''; ?>">
    <div class="zc-meta-label">Gradient CSS</div>
    <div>
      <input type="text" name="_zc_bg_gradient" class="widefat" value="<?php echo esc_attr( $bg_gradient ); ?>" placeholder="linear-gradient(135deg, #0f0f1f, #1e1b4b)">
      <p class="zc-meta-hint">Any valid CSS gradient value</p>
    </div>
  </div>
  <div id="zc-bg-image-row" class="zc-meta-row" style="<?php echo $bg_type !== 'image' ? 'display:none;' : ''; ?>">
    <div class="zc-meta-label">Background Image</div>
    <div>
      <div style="display:flex;gap:8px;align-items:center;">
        <input type="hidden" name="_zc_bg_image_id" id="_zc_bg_image_id" value="<?php echo esc_attr( $bg_image_id ); ?>">
        <input type="text" name="_zc_bg_image" id="_zc_bg_image" class="widefat" value="<?php echo esc_url( $bg_image ); ?>" readonly placeholder="Select from media library">
        <button type="button" class="button" id="zc-bgimg-select">Select</button>
        <button type="button" class="button" id="zc-bgimg-clear">Clear</button>
      </div>
      <?php if ( $bg_image ): ?>
      <img src="<?php echo esc_url( $bg_image ); ?>" id="zc-bgimg-preview" style="max-width:200px;max-height:60px;margin-top:8px;border-radius:4px;">
      <?php else: ?>
      <img src="" id="zc-bgimg-preview" style="max-width:200px;max-height:60px;margin-top:8px;border-radius:4px;display:none;">
      <?php endif; ?>
    </div>
  </div>
  <div id="zc-bg-props-row" class="zc-meta-row" style="<?php echo $bg_type !== 'image' ? 'display:none;' : ''; ?>">
    <div class="zc-meta-label">Image Properties</div>
    <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:8px;">
      <div>
        <label style="font-size:.75rem;color:#64748b;">Repeat</label>
        <select name="_zc_bg_repeat" class="widefat">
          <?php foreach ( [ 'no-repeat','repeat','repeat-x','repeat-y','round','space' ] as $v ): ?>
          <option value="<?php echo $v; ?>" <?php selected( $bg_repeat, $v ); ?>><?php echo $v; ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div>
        <label style="font-size:.75rem;color:#64748b;">Attachment</label>
        <select name="_zc_bg_attach" class="widefat">
          <?php foreach ( [ 'scroll','fixed','local' ] as $v ): ?>
          <option value="<?php echo $v; ?>" <?php selected( $bg_attach, $v ); ?>><?php echo $v; ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div>
        <label style="font-size:.75rem;color:#64748b;">Size</label>
        <select name="_zc_bg_size" class="widefat">
          <?php foreach ( [ 'cover','contain','auto','100% auto','100% 100%' ] as $v ): ?>
          <option value="<?php echo $v; ?>" <?php selected( $bg_size, $v ); ?>><?php echo $v; ?></option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>
  </div>
</div>
</div><!-- .zc-metabox -->

<script>
// Tab switching — pure vanilla JS, no jQuery required
(function(){
  function zcInitTabs(){
    var tabs = document.querySelectorAll('#zc-mb-tablist .zc-mb-tab-btn');
    if(!tabs.length) return;
    tabs.forEach(function(btn){
      btn.addEventListener('click', function(){
        tabs.forEach(function(b){ b.classList.remove('active'); });
        document.querySelectorAll('.zc-mb-tab-panel').forEach(function(p){ p.classList.remove('active'); });
        btn.classList.add('active');
        var target = document.getElementById(btn.getAttribute('data-target'));
        if(target) target.classList.add('active');
      });
    });
  }
  // Background type toggle
  window.zcBgTypeSwitch = function(val){
    var colorRow    = document.getElementById('zc-bg-color-row');
    var gradRow     = document.getElementById('zc-bg-gradient-row');
    var imgRow      = document.getElementById('zc-bg-image-row');
    var propsRow    = document.getElementById('zc-bg-props-row');
    if(colorRow)  colorRow.style.display  = val==='color'    ? '' : 'none';
    if(gradRow)   gradRow.style.display   = val==='gradient' ? '' : 'none';
    if(imgRow)    imgRow.style.display    = val==='image'    ? '' : 'none';
    if(propsRow)  propsRow.style.display  = val==='image'    ? '' : 'none';
  };
  // Media library pickers
  function zcMediaPicker(inputId, inputHiddenId, previewId){
    if(typeof wp === 'undefined' || !wp.media) return;
    var frame = wp.media({ title:'Select Image', button:{ text:'Use this image' }, multiple:false });
    frame.on('select', function(){
      var att = frame.state().get('selection').first().toJSON();
      var inp = document.getElementById(inputId);
      var hid = document.getElementById(inputHiddenId);
      var prv = document.getElementById(previewId);
      if(inp) inp.value = att.url;
      if(hid) hid.value = att.id;
      if(prv){ prv.src = att.url; prv.style.display=''; }
    });
    frame.open();
  }
  document.addEventListener('DOMContentLoaded', function(){
    zcInitTabs();
    // Banner picker
    var bannerBtn = document.getElementById('zc-banner-select');
    if(bannerBtn) bannerBtn.addEventListener('click', function(){ zcMediaPicker('_zc_sub_banner','_zc_sub_banner_id','zc-banner-preview'); });
    var bannerClr = document.getElementById('zc-banner-clear');
    if(bannerClr) bannerClr.addEventListener('click', function(){
      var inp=document.getElementById('_zc_sub_banner'); if(inp) inp.value='';
      var hid=document.getElementById('_zc_sub_banner_id'); if(hid) hid.value='';
      var prv=document.getElementById('zc-banner-preview'); if(prv){ prv.src=''; prv.style.display='none'; }
    });
    // BG Image picker
    var bgBtn = document.getElementById('zc-bgimg-select');
    if(bgBtn) bgBtn.addEventListener('click', function(){ zcMediaPicker('_zc_bg_image','_zc_bg_image_id','zc-bgimg-preview'); });
    var bgClr = document.getElementById('zc-bgimg-clear');
    if(bgClr) bgClr.addEventListener('click', function(){
      var inp=document.getElementById('_zc_bg_image'); if(inp) inp.value='';
      var hid=document.getElementById('_zc_bg_image_id'); if(hid) hid.value='';
      var prv=document.getElementById('zc-bgimg-preview'); if(prv){ prv.src=''; prv.style.display='none'; }
    });
  });
})();
</script>
        <?php
    }

    public static function save( $post_id, $post ) {
        if ( ! isset( $_POST['zc_meta_nonce'] ) || ! wp_verify_nonce( $_POST['zc_meta_nonce'], 'zc_meta_save' ) ) return;
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
        if ( ! current_user_can( 'edit_post', $post_id ) ) return;

        $text_fields = [
            '_zc_content_layout',
            '_zc_hide_left_panel',
            '_zc_sidebar_right',
            '_zc_sidebar_left',
            '_zc_sub_height',
            '_zc_sub_bg',
            '_zc_sub_overlay',
            '_zc_sub_text_color',
            '_zc_sub_link_color',
            '_zc_sub_banner',
            '_zc_sub_banner_id',
            '_zc_bg_type',
            '_zc_bg_color',
            '_zc_bg_gradient',
            '_zc_bg_image',
            '_zc_bg_image_id',
            '_zc_bg_repeat',
            '_zc_bg_attach',
            '_zc_bg_size',
        ];
        $checkbox_fields = [
            '_zc_show_title',
            '_zc_sub_override',
            '_zc_sub_breadcrumbs',
            '_zc_sub_feat_img',
            '_zc_bg_override',
        ];

        foreach ( $text_fields as $field ) {
            $val = sanitize_text_field( $_POST[ $field ] ?? '' );
            update_post_meta( $post_id, $field, $val );
        }
        foreach ( $checkbox_fields as $field ) {
            $val = isset( $_POST[ $field ] ) ? '1' : '0';
            update_post_meta( $post_id, $field, $val );
        }
    }
}
