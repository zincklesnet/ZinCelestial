<?php if ( ! defined( 'ABSPATH' ) ) exit;
$opts  = get_option( 'zincelestial_options', [] );
function zca_hn( $o, $k, $f='' ){ return isset($o[$k])?$o[$k]:$f; }
// Get all registered menus
$menus = wp_get_nav_menus();
$menu_opts = '<option value="">— None —</option>';
foreach ( $menus as $m ) {
    $menu_opts .= '<option value="' . esc_attr( $m->term_id ) . '">' . esc_html( $m->name ) . '</option>';
}
?>
<div class="wrap zca-wrap">
<div class="d-flex justify-content-between align-items-center mb-4">
  <div>
    <h1 class="zca-page-title mb-0"><i class="bi bi-layout-text-window-reverse me-2"></i>Header & Navigation</h1>
    <p class="text-muted small mb-0">Control header layout, three zones (left/center/right), icons, and stickiness.</p>
  </div>
  <button class="btn btn-primary" onclick="zcaSaveOptions()"><i class="bi bi-floppy me-1"></i>Save Header Settings</button>
</div>

<!-- ══ HEADER ZONE DIAGRAM ══ -->
<div class="card shadow-sm border-0 mb-4">
  <div class="card-header fw-semibold"><i class="bi bi-grid-3x1-gap me-2"></i>Header Zone Layout Preview</div>
  <div class="card-body p-3">
    <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:12px;background:#0f0f1f;border-radius:10px;padding:14px;">
      <div style="background:rgba(124,111,247,.15);border:1px dashed #7c6ff7;border-radius:6px;padding:10px;text-align:center;">
        <div style="color:#7c6ff7;font-size:.7rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;">LEFT ZONE</div>
        <div style="color:#e2e8f0;font-size:.8rem;margin-top:4px;">Logo + Left Menu + Icons</div>
      </div>
      <div style="background:rgba(34,211,238,.1);border:1px dashed #22d3ee;border-radius:6px;padding:10px;text-align:center;">
        <div style="color:#22d3ee;font-size:.7rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;">CENTER ZONE</div>
        <div style="color:#e2e8f0;font-size:.8rem;margin-top:4px;">Center Menu or Search</div>
      </div>
      <div style="background:rgba(244,114,182,.1);border:1px dashed #f472b6;border-radius:6px;padding:10px;text-align:center;">
        <div style="color:#f472b6;font-size:.7rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;">RIGHT ZONE</div>
        <div style="color:#e2e8f0;font-size:.8rem;margin-top:4px;">Search, Cart, Notif, User</div>
      </div>
    </div>
  </div>
</div>

<div class="row g-4">
  <!-- LEFT ZONE -->
  <div class="col-md-4">
    <div class="card shadow-sm border-0 h-100">
      <div class="card-header fw-semibold" style="background:rgba(124,111,247,.1);border-bottom:2px solid #7c6ff7;">
        <i class="bi bi-align-start me-2" style="color:#7c6ff7;"></i>Left Zone
      </div>
      <div class="card-body">
        <div class="mb-3">
          <label class="form-label fw-semibold small">Logo Position</label>
          <select class="form-select" name="zincelestial_options[header_logo_position]">
            <option value="left"   <?php selected(zca_hn($opts,'header_logo_position','left'),'left');?>>Left</option>
            <option value="center" <?php selected(zca_hn($opts,'header_logo_position','left'),'center');?>>Center</option>
          </select>
        </div>
        <div class="mb-3">
          <label class="form-label fw-semibold small">Left Zone Menu</label>
          <select class="form-select" name="zincelestial_options[header_left_menu]">
            <?php echo $menu_opts; ?>
          </select>
          <div class="form-text">Menu displayed in the left header zone</div>
        </div>
        <div class="mb-3">
          <label class="form-label fw-semibold small">Left Zone Icons</label>
          <div class="row g-2">
            <?php foreach(['logo'=>'Logo','search'=>'Search','home'=>'Home'] as $v=>$l): ?>
            <div class="col-auto">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="zincelestial_options[header_left_icons][]"
                       value="<?php echo $v;?>" id="lft_<?php echo $v;?>"
                       <?php checked(in_array($v, explode(',', zca_hn($opts,'header_left_icons','logo'))), true);?>>
                <label class="form-check-label small" for="lft_<?php echo $v;?>"><?php echo $l;?></label>
              </div>
            </div>
            <?php endforeach;?>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- CENTER ZONE -->
  <div class="col-md-4">
    <div class="card shadow-sm border-0 h-100">
      <div class="card-header fw-semibold" style="background:rgba(34,211,238,.08);border-bottom:2px solid #22d3ee;">
        <i class="bi bi-align-center me-2" style="color:#22d3ee;"></i>Center Zone
      </div>
      <div class="card-body">
        <div class="mb-3">
          <label class="form-label fw-semibold small">Center Zone Content</label>
          <select class="form-select" name="zincelestial_options[header_center_content]">
            <option value="none"   <?php selected(zca_hn($opts,'header_center_content','none'),'none');?>>Nothing</option>
            <option value="menu"   <?php selected(zca_hn($opts,'header_center_content','none'),'menu');?>>Menu</option>
            <option value="search" <?php selected(zca_hn($opts,'header_center_content','none'),'search');?>>Search Bar</option>
            <option value="logo"   <?php selected(zca_hn($opts,'header_center_content','none'),'logo');?>>Logo</option>
          </select>
        </div>
        <div class="mb-3">
          <label class="form-label fw-semibold small">Center Menu (if Menu selected)</label>
          <select class="form-select" name="zincelestial_options[header_center_menu]">
            <?php echo $menu_opts; ?>
          </select>
        </div>
        <div class="mb-3">
          <label class="form-label fw-semibold small">Search Bar Style</label>
          <select class="form-select" name="zincelestial_options[header_search_style]">
            <option value="pill"   <?php selected(zca_hn($opts,'header_search_style','pill'),'pill');?>>Pill / Rounded</option>
            <option value="box"    <?php selected(zca_hn($opts,'header_search_style','pill'),'box');?>>Square Box</option>
            <option value="icon"   <?php selected(zca_hn($opts,'header_search_style','pill'),'icon');?>>Icon Only</option>
          </select>
        </div>
      </div>
    </div>
  </div>

  <!-- RIGHT ZONE -->
  <div class="col-md-4">
    <div class="card shadow-sm border-0 h-100">
      <div class="card-header fw-semibold" style="background:rgba(244,114,182,.08);border-bottom:2px solid #f472b6;">
        <i class="bi bi-align-end me-2" style="color:#f472b6;"></i>Right Zone
      </div>
      <div class="card-body">
        <div class="mb-3">
          <label class="form-label fw-semibold small">Right Zone Menu</label>
          <select class="form-select" name="zincelestial_options[header_right_menu]">
            <?php echo $menu_opts; ?>
          </select>
        </div>
        <div class="mb-3">
          <label class="form-label fw-semibold small">Right Zone Icons</label>
          <div class="row g-2">
            <?php foreach([
              'search'=>'Search','notifications'=>'Notifications','cart'=>'Cart',
              'messages'=>'Messages','user'=>'User/Avatar','darkmode'=>'Dark Mode Toggle',
            ] as $v=>$l): ?>
            <div class="col-6">
              <div class="form-check">
                <input class="form-check-input" type="checkbox"
                       name="zincelestial_options[header_right_icons][]"
                       value="<?php echo $v;?>" id="rgt_<?php echo $v;?>"
                       <?php checked(in_array($v, explode(',', zca_hn($opts,'header_right_icons','search,notifications,cart,user'))), true);?>>
                <label class="form-check-label small" for="rgt_<?php echo $v;?>"><?php echo $l;?></label>
              </div>
            </div>
            <?php endforeach;?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- ══ ROW 2: Header behavior ══ -->
<div class="row g-4 mt-1">
  <div class="col-md-6">
    <div class="card shadow-sm border-0">
      <div class="card-header fw-semibold"><i class="bi bi-pin-fill me-2"></i>Header Behavior</div>
      <div class="card-body">
        <?php $toggles = [
          ['header_sticky','Sticky Header (scrolls with page)'],
          ['header_transparent','Transparent Header on Hero/Cover images'],
          ['header_mobile_hamburger','Show Hamburger on Mobile'],
          ['header_border_bottom','Show Bottom Border on Header'],
          ['header_boxed','Boxed Container (constrained width)'],
        ]; foreach($toggles as [$k,$l]): ?>
        <div class="form-check form-switch mb-2">
          <input class="form-check-input" type="checkbox" role="switch" id="<?php echo $k;?>"
                 name="zincelestial_options[<?php echo $k;?>]" value="1"
                 <?php checked(zca_hn($opts,$k,'0'),'1');?>>
          <label class="form-check-label small" for="<?php echo $k;?>"><?php echo $l;?></label>
        </div>
        <?php endforeach;?>
        <div class="mt-3">
          <label class="form-label fw-semibold small">Header Height (px)</label>
          <div class="input-group">
            <input type="number" class="form-control" name="zincelestial_options[header_height]"
                   value="<?php echo esc_attr(zca_hn($opts,'header_height','70'));?>" min="40" max="160" step="2">
            <span class="input-group-text">px</span>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="card shadow-sm border-0">
      <div class="card-header fw-semibold"><i class="bi bi-phone me-2"></i>Mobile Header</div>
      <div class="card-body">
        <div class="mb-3">
          <label class="form-label fw-semibold small">Mobile Menu Style</label>
          <select class="form-select" name="zincelestial_options[mobile_menu_style]">
            <option value="offcanvas" <?php selected(zca_hn($opts,'mobile_menu_style','offcanvas'),'offcanvas');?>>Offcanvas Slide-In</option>
            <option value="dropdown"  <?php selected(zca_hn($opts,'mobile_menu_style','offcanvas'),'dropdown');?>>Dropdown (Collapsed)</option>
            <option value="fullscreen"<?php selected(zca_hn($opts,'mobile_menu_style','offcanvas'),'fullscreen');?>>Fullscreen Overlay</option>
          </select>
        </div>
        <div class="mb-3">
          <label class="form-label fw-semibold small">Mobile Menu</label>
          <select class="form-select" name="zincelestial_options[header_mobile_menu]">
            <?php echo $menu_opts; ?>
          </select>
          <div class="form-text">Falls back to Primary if not set</div>
        </div>
        <?php $mtoggle = [
          ['mobile_show_search','Show Search on Mobile Header'],
          ['mobile_show_cart','Show Cart Icon on Mobile'],
          ['mobile_show_notifications','Show Notifications on Mobile'],
        ]; foreach($mtoggle as [$k,$l]): ?>
        <div class="form-check form-switch mb-1">
          <input class="form-check-input" type="checkbox" role="switch" id="<?php echo $k;?>"
                 name="zincelestial_options[<?php echo $k;?>]" value="1"
                 <?php checked(zca_hn($opts,$k,'0'),'1');?>>
          <label class="form-check-label small" for="<?php echo $k;?>"><?php echo $l;?></label>
        </div>
        <?php endforeach;?>
      </div>
    </div>
  </div>
</div>

<!-- ══ BuddyPress Visibility Diagnostic ══ -->
<div class="card shadow-sm border-warning border-2 mt-4">
  <div class="card-header fw-semibold text-warning"><i class="bi bi-exclamation-triangle me-2"></i>BuddyPress Frontend Visibility Diagnostic</div>
  <div class="card-body">
    <p class="mb-2 small">If BuddyPress pages are blank or not showing with ZinCelestial, here's the diagnosis checklist:</p>
    <div class="row g-3">
      <?php
      $bp_active   = function_exists('buddypress');
      $bp_pages    = $bp_active ? bp_get_option('bp-pages',[]) : [];
      $has_members = !empty($bp_pages['members']);
      $has_activity= !empty($bp_pages['activity']);
      $zc_bp_on    = zca_hn($opts,'enable_buddypress','0') === '1';
      $checks = [
        ['BuddyPress plugin active',          $bp_active],
        ['BuddyPress module enabled in ZinCelestial', $zc_bp_on],
        ['BuddyPress Members page assigned',  $has_members],
        ['BuddyPress Activity page assigned', $has_activity],
        ['ZinCelestial BP templates exist',   file_exists(get_template_directory().'/templates/buddypress/members/index.php')],
      ];
      foreach($checks as [$label,$pass]): ?>
      <div class="col-md-6">
        <div class="d-flex align-items-center gap-2 p-2 rounded" style="background:<?php echo $pass?'rgba(34,197,94,.1)':'rgba(239,68,68,.1)';?>">
          <i class="bi <?php echo $pass?'bi-check-circle-fill text-success':'bi-x-circle-fill text-danger';?>"></i>
          <span class="small"><?php echo esc_html($label);?></span>
        </div>
      </div>
      <?php endforeach;?>
    </div>
    <?php if(!$zc_bp_on): ?>
    <div class="alert alert-warning mt-3 mb-0 py-2 small">
      <i class="bi bi-info-circle me-2"></i>
      <strong>BuddyPress module is currently disabled.</strong>
      Enable it in ZinCelestial Dashboard → Modules to activate BP frontend templates and CSS.
    </div>
    <?php endif;?>
  </div>
</div>
</div><!-- .wrap -->
