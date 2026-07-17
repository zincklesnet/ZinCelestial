<?php if ( ! defined( 'ABSPATH' ) ) exit;
$opts = get_option( 'zincelestial_options', [] );
function zca_d( $o, $k, $f='' ){ return isset($o[$k]) ? $o[$k] : $f; }
?>
<div class="wrap zca-wrap">
<div class="zca-page-header d-flex justify-content-between align-items-center mb-4">
  <div>
    <h1 class="zca-page-title mb-0"><i class="bi bi-palette me-2"></i><?php esc_html_e('Design & Colors','zincelestial'); ?></h1>
    <p class="text-muted small mb-0">Control spacing, padding, containers, and colors across all ZinCelestial schemes.</p>
  </div>
  <button class="btn btn-primary" onclick="zcaSaveOptions()"><i class="bi bi-floppy me-1"></i>Save Design Settings</button>
</div>

<!-- ══ TABS ══ -->
<ul class="nav nav-tabs mb-4" id="zcaDesignTabs">
  <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab-spacing"><i class="bi bi-arrows-angle-expand me-1"></i>Spacing</button></li>
  <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-containers"><i class="bi bi-layout-three-columns me-1"></i>Containers</button></li>
  <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-colors"><i class="bi bi-palette2 me-1"></i>Colors & Tokens</button></li>
  <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-schemes"><i class="bi bi-stars me-1"></i>Color Schemes</button></li>
</ul>

<div class="tab-content">
  <!-- SPACING TAB -->
  <div class="tab-pane fade show active" id="tab-spacing">
    <div class="row g-4">

      <!-- Content Padding -->
      <div class="col-md-6">
        <div class="card shadow-sm border-0 h-100">
          <div class="card-header fw-semibold"><i class="bi bi-box me-2"></i>Content Area Padding</div>
          <div class="card-body">
            <p class="text-muted small mb-3">Controls inner padding of the main content zone on every page.</p>
            <div class="row g-3">
              <?php foreach([
                ['content_pad_top','Top','16'],['content_pad_right','Right','4'],
                ['content_pad_bottom','Bottom','16'],['content_pad_left','Left','4'],
              ] as [$key,$label,$def]): ?>
              <div class="col-6">
                <label class="form-label fw-semibold small"><?php echo $label; ?> <span class="text-muted">(px)</span></label>
                <div class="input-group">
                  <input type="number" class="form-control" name="zincelestial_options[<?php echo $key;?>]"
                         value="<?php echo esc_attr(zca_d($opts,$key,$def)); ?>" min="0" max="120" step="2"
                         oninput="zcaPreviewPad()">
                  <span class="input-group-text">px</span>
                </div>
              </div>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
      </div>

      <!-- Container Padding -->
      <div class="col-md-6">
        <div class="card shadow-sm border-0 h-100">
          <div class="card-header fw-semibold"><i class="bi bi-layout-split me-2"></i>Container Padding</div>
          <div class="card-body">
            <p class="text-muted small mb-3">Controls the outer page container's padding on each side. Min 4px left/right required.</p>
            <div class="row g-3">
              <?php foreach([
                ['container_pad_top','Top','0'],['container_pad_right','Right','4'],
                ['container_pad_bottom','Bottom','0'],['container_pad_left','Left','4'],
              ] as [$key,$label,$def]): ?>
              <div class="col-6">
                <label class="form-label fw-semibold small"><?php echo $label; ?> <span class="text-muted">(px)</span></label>
                <div class="input-group">
                  <input type="number" class="form-control" name="zincelestial_options[<?php echo $key;?>]"
                         value="<?php echo esc_attr(zca_d($opts,$key,$def)); ?>" min="0" max="80" step="2">
                  <span class="input-group-text">px</span>
                </div>
              </div>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
      </div>

      <!-- Admin UI Spacing -->
      <div class="col-12">
        <div class="card shadow-sm border-0">
          <div class="card-header fw-semibold"><i class="bi bi-display me-2"></i>Admin Panel Spacing</div>
          <div class="card-body">
            <div class="row g-4">
              <div class="col-md-4">
                <label class="form-label fw-semibold small">Admin Card Padding <span class="text-muted">(px)</span></label>
                <input type="range" class="form-range" min="12" max="56" step="4"
                       name="zincelestial_options[admin_card_padding]"
                       value="<?php echo esc_attr(zca_d($opts,'admin_card_padding','28')); ?>"
                       oninput="this.nextElementSibling.textContent=this.value+'px'">
                <output><?php echo esc_html(zca_d($opts,'admin_card_padding','28')); ?>px</output>
              </div>
              <div class="col-md-4">
                <label class="form-label fw-semibold small">Admin Content Gap <span class="text-muted">(px)</span></label>
                <input type="range" class="form-range" min="8" max="64" step="4"
                       name="zincelestial_options[admin_content_gap]"
                       value="<?php echo esc_attr(zca_d($opts,'admin_content_gap','32')); ?>"
                       oninput="this.nextElementSibling.textContent=this.value+'px'">
                <output><?php echo esc_html(zca_d($opts,'admin_content_gap','32')); ?>px</output>
              </div>
              <div class="col-md-4">
                <label class="form-label fw-semibold small">UI Density Preset</label>
                <select class="form-select" name="zincelestial_options[admin_ui_density]">
                  <?php foreach(['compact'=>'Compact','comfortable'=>'Comfortable (Default)','spacious'=>'Spacious'] as $v=>$l): ?>
                  <option value="<?php echo $v;?>" <?php selected(zca_d($opts,'admin_ui_density','comfortable'),$v);?>><?php echo $l;?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- CONTAINERS TAB -->
  <div class="tab-pane fade" id="tab-containers">
    <div class="row g-4">
      <div class="col-md-6">
        <div class="card shadow-sm border-0 h-100">
          <div class="card-header fw-semibold"><i class="bi bi-rulers me-2"></i>Container Sizes</div>
          <div class="card-body">
            <?php foreach([
              ['container_max_width','Max Container Width (px)','1280','400','2560','40'],
              ['content_max_width','Max Content Width (px)','900','400','1920','40'],
              ['sidebar_width','Sidebar Width (px)','280','160','480','20'],
            ] as [$key,$label,$def,$min,$max,$step]): ?>
            <div class="mb-3">
              <label class="form-label fw-semibold small"><?php echo $label; ?></label>
              <div class="input-group">
                <input type="number" class="form-control"
                       name="zincelestial_options[<?php echo $key;?>]"
                       value="<?php echo esc_attr(zca_d($opts,$key,$def)); ?>"
                       min="<?php echo $min;?>" max="<?php echo $max;?>" step="<?php echo $step;?>">
                <span class="input-group-text">px</span>
              </div>
            </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card shadow-sm border-0 h-100">
          <div class="card-header fw-semibold"><i class="bi bi-aspect-ratio me-2"></i>Border Radius & Shadows</div>
          <div class="card-body">
            <?php foreach([
              ['border_radius_sm','Border Radius SM (px)','6','0','24','2'],
              ['border_radius_md','Border Radius MD (px)','12','0','40','2'],
              ['border_radius_lg','Border Radius LG (px)','20','0','60','4'],
              ['border_radius_xl','Border Radius XL (px)','28','0','80','4'],
            ] as [$key,$label,$def,$min,$max,$step]): ?>
            <div class="mb-3">
              <label class="form-label fw-semibold small"><?php echo $label; ?></label>
              <div class="input-group">
                <input type="number" class="form-control"
                       name="zincelestial_options[<?php echo $key;?>]"
                       value="<?php echo esc_attr(zca_d($opts,$key,$def)); ?>"
                       min="<?php echo $min;?>" max="<?php echo $max;?>" step="<?php echo $step;?>">
                <span class="input-group-text">px</span>
              </div>
            </div>
            <?php endforeach; ?>
            <div class="mb-3">
              <label class="form-label fw-semibold small">Shadow Level</label>
              <select class="form-select" name="zincelestial_options[shadow_level]">
                <option value="none"   <?php selected(zca_d($opts,'shadow_level','medium'),'none'); ?>>None</option>
                <option value="subtle" <?php selected(zca_d($opts,'shadow_level','medium'),'subtle'); ?>>Subtle</option>
                <option value="medium" <?php selected(zca_d($opts,'shadow_level','medium'),'medium'); ?>>Medium (Default)</option>
                <option value="heavy"  <?php selected(zca_d($opts,'shadow_level','medium'),'heavy'); ?>>Heavy</option>
              </select>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- COLORS TAB -->
  <div class="tab-pane fade" id="tab-colors">
    <div class="row g-4">
      <div class="col-md-6">
        <div class="card shadow-sm border-0">
          <div class="card-header fw-semibold"><i class="bi bi-droplet-fill me-2"></i>Brand Colors</div>
          <div class="card-body">
            <?php foreach([
              ['color_primary','Primary Color','#7c6ff7'],
              ['color_secondary','Secondary Color','#22d3ee'],
              ['color_accent','Accent Color','#f472b6'],
              ['color_success','Success Color','#22c55e'],
              ['color_warning','Warning Color','#f59e0b'],
              ['color_danger','Danger Color','#ef4444'],
              ['color_bg','Background Color','#07070f'],
              ['color_surface','Surface/Card Color','#0f0f1f'],
              ['color_text','Text Color','#e2e8f0'],
              ['color_muted','Muted Text Color','#94a3b8'],
            ] as [$key,$label,$def]): ?>
            <div class="row mb-2 align-items-center">
              <div class="col-8"><label class="form-label mb-0 small fw-semibold"><?php echo $label;?></label></div>
              <div class="col-4 d-flex align-items-center gap-2">
                <input type="color" class="form-control form-control-color" style="width:38px;height:32px;padding:2px;"
                       name="zincelestial_options[<?php echo $key;?>]"
                       value="<?php echo esc_attr(zca_d($opts,$key,$def)); ?>">
                <input type="text" class="form-control form-control-sm" style="width:80px;"
                       value="<?php echo esc_attr(zca_d($opts,$key,$def)); ?>"
                       pattern="#[0-9a-fA-F]{6}" placeholder="<?php echo $def;?>">
              </div>
            </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card shadow-sm border-0">
          <div class="card-header fw-semibold"><i class="bi bi-type me-2"></i>Typography</div>
          <div class="card-body">
            <div class="mb-3">
              <label class="form-label fw-semibold small">Body Font</label>
              <select class="form-select" name="zincelestial_options[body_font]">
                <?php foreach(['Inter','Roboto','Open Sans','Lato','Nunito','Poppins','DM Sans','Manrope','Source Sans 3'] as $f): ?>
                <option value="<?php echo $f;?>" <?php selected(zca_d($opts,'body_font','Inter'),$f);?>><?php echo $f;?></option>
                <?php endforeach;?>
              </select>
            </div>
            <div class="mb-3">
              <label class="form-label fw-semibold small">Heading Font</label>
              <select class="form-select" name="zincelestial_options[heading_font]">
                <?php foreach(['Inter','Playfair Display','Raleway','Montserrat','Space Grotesk','Unbounded','Plus Jakarta Sans','Clash Display'] as $f): ?>
                <option value="<?php echo $f;?>" <?php selected(zca_d($opts,'heading_font','Inter'),$f);?>><?php echo $f;?></option>
                <?php endforeach;?>
              </select>
            </div>
            <div class="mb-3">
              <label class="form-label fw-semibold small">Base Font Size (px)</label>
              <input type="number" class="form-control" name="zincelestial_options[body_font_size]"
                     value="<?php echo esc_attr(zca_d($opts,'body_font_size','16'));?>" min="12" max="22" step="1">
            </div>
            <div class="mb-3">
              <label class="form-label fw-semibold small">Line Height</label>
              <input type="number" class="form-control" name="zincelestial_options[line_height]"
                     value="<?php echo esc_attr(zca_d($opts,'line_height','1.6'));?>" min="1.2" max="2.2" step="0.05">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- SCHEMES TAB -->
  <div class="tab-pane fade" id="tab-schemes">
    <div class="row g-3">
      <?php $current_scheme = zca_d($opts,'color_scheme','default');
      $schemes = [
        'default' => ['Default Dark','#07070f','#7c6ff7','#22d3ee'],
        'slate'   => ['Slate','#0f172a','#3b82f6','#06b6d4'],
        'forest'  => ['Forest','#052e16','#22c55e','#84cc16'],
        'cosmic'  => ['Cosmic','#12001f','#a855f7','#ec4899'],
        'aurora'  => ['Aurora','#000d1a','#38bdf8','#34d399'],
        'nova'    => ['Nova','#0a0a14','#f97316','#facc15'],
        'zenith'  => ['Zenith','#0d0d0d','#e2e8f0','#94a3b8'],
        'ember'   => ['Ember','#1a0500','#ef4444','#f97316'],
        'twilight'=> ['Twilight','#0d0011','#8b5cf6','#f472b6'],
      ];
      foreach($schemes as $sv=>[$sl,$sbg,$sp,$ss]): ?>
      <div class="col-6 col-md-4 col-lg-3">
        <label class="card border-2 <?php echo $current_scheme===$sv?'border-primary':'border-0 shadow-sm';?> cursor-pointer h-100" style="cursor:pointer;">
          <input type="radio" name="zincelestial_options[color_scheme]" value="<?php echo $sv;?>"
                 class="d-none" <?php checked($current_scheme,$sv);?>>
          <div class="card-body p-3" style="background:<?php echo $sbg;?>;border-radius:8px;">
            <div class="d-flex gap-1 mb-2">
              <div style="width:18px;height:18px;border-radius:50%;background:<?php echo $sp;?>"></div>
              <div style="width:18px;height:18px;border-radius:50%;background:<?php echo $ss;?>"></div>
              <div style="width:18px;height:18px;border-radius:50%;background:#fff;opacity:.2"></div>
            </div>
            <div class="fw-semibold text-white small"><?php echo $sl;?></div>
            <div style="color:<?php echo $sp;?>;font-size:.7rem;"><?php echo $sv;?></div>
          </div>
          <?php if($current_scheme===$sv): ?>
          <div class="card-footer text-center py-1 bg-primary text-white small">✓ Active</div>
          <?php endif;?>
        </label>
      </div>
      <?php endforeach;?>
    </div>
  </div>
</div><!-- .tab-content -->
</div><!-- .wrap -->
