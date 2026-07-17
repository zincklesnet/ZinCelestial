<?php if ( ! defined( 'ABSPATH' ) ) exit;
if ( ! current_user_can( 'manage_network_options' ) ) { wp_die( 'Insufficient permissions' ); }
$opts = get_site_option( 'zincelestial_network_options', [] );
$network_overrides = get_site_option( 'zc_network_site_overrides', [] );
$sites = get_sites( [ 'number' => 100, 'fields' => 'all' ] );
?>
<div class="wrap zca-wrap">
<div class="d-flex justify-content-between align-items-center mb-4">
  <h1 class="zca-page-title mb-0"><i class="bi bi-buildings me-2"></i>Site Management</h1>
  <button class="btn btn-primary" id="zcaSaveNetworkSites"><i class="bi bi-floppy me-1"></i>Save Site Settings</button>
</div>
<div class="alert alert-info small"><i class="bi bi-info-circle me-2"></i>
  <strong>Network vs Subsite:</strong> By default all subsites inherit network settings.
  Toggle "Use Own Settings" to let a subsite override network defaults independently.
  Network settings here are <strong>network-only</strong> — they cannot overlap with subsite settings.
</div>

<?php if ( ZC_GENESIS_ADMIN_ACTIVE ): ?>
<div class="alert alert-success small mb-3"><i class="bi bi-check-circle me-2"></i>
  <strong>Zinckles Genesis Admin Theme is ACTIVE.</strong>
  ZinCelestial admin CSS deferred — Genesis Admin controls all backend styling, Bootstrap, and color schemes.
</div>
<?php else: ?>
<div class="alert alert-warning small mb-3"><i class="bi bi-exclamation-triangle me-2"></i>
  Zinckles Genesis Admin Theme is <strong>NOT active</strong>. ZinCelestial will use WordPress default admin styling as fallback.
</div>
<?php endif; ?>

<div class="card shadow-sm border-0">
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover mb-0 align-middle">
        <thead class="table-dark">
          <tr>
            <th>#</th>
            <th>Site Name</th>
            <th>Domain</th>
            <th>Use Own Settings</th>
            <th>Color Scheme Override</th>
            <th>Module Enable Override</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ( $sites as $site ):
            $bid = $site->blog_id;
            $details = get_blog_details( $bid );
            $override = $network_overrides[ $bid ] ?? [];
            $own = !empty( $override['use_own'] );
          ?>
          <tr>
            <td><small class="text-muted">#<?php echo $bid; ?></small></td>
            <td><strong><?php echo esc_html( $details->blogname ); ?></strong><br>
                <small class="text-muted"><?php echo esc_html( $details->siteurl ); ?></small></td>
            <td><small><?php echo esc_html( $site->domain . $site->path ); ?></small></td>
            <td>
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch"
                       name="site_override[<?php echo $bid; ?>][use_own]"
                       id="site_own_<?php echo $bid; ?>" value="1" <?php checked( $own ); ?>
                       onchange="zcaToggleSiteRow(<?php echo $bid;?>, this.checked)">
                <label class="form-check-label small" for="site_own_<?php echo $bid; ?>">
                  <?php echo $own ? 'Own Settings' : 'Network Default'; ?>
                </label>
              </div>
            </td>
            <td>
              <select class="form-select form-select-sm site-scheme-select" style="width:160px;"
                      name="site_override[<?php echo $bid; ?>][scheme]"
                      <?php echo ! $own ? 'disabled' : ''; ?>>
                <?php foreach(['default'=>'Default','slate'=>'Slate','forest'=>'Forest','cosmic'=>'Cosmic','aurora'=>'Aurora'] as $v=>$l): ?>
                <option value="<?php echo $v;?>" <?php selected($override['scheme']??'default',$v);?>><?php echo $l;?></option>
                <?php endforeach;?>
              </select>
            </td>
            <td>
              <select class="form-select form-select-sm" style="width:160px;"
                      name="site_override[<?php echo $bid; ?>][modules]"
                      <?php echo ! $own ? 'disabled' : ''; ?>>
                <option value="inherit" <?php selected($override['modules']??'inherit','inherit');?>>Inherit Network</option>
                <option value="all_on"  <?php selected($override['modules']??'inherit','all_on');?>>All On</option>
                <option value="all_off" <?php selected($override['modules']??'inherit','all_off');?>>All Off</option>
                <option value="custom"  <?php selected($override['modules']??'inherit','custom');?>>Custom</option>
              </select>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<script>
(function($){
  function zcaToggleSiteRow(bid, enabled){
    $('[name^="site_override['+bid+']"]').not('[name$="[use_own]"]').prop('disabled', !enabled);
  }
  $('#zcaSaveNetworkSites').on('click', function(){
    var data = { action:'zc_network_save', nonce: ZC_Admin.nonce, options:{} };
    $('[name^="site_override"]').each(function(){
      data.options[$(this).attr('name')] = $(this).is(':checkbox') ? ($(this).is(':checked')?'1':'0') : $(this).val();
    });
    $.post(ZC_Admin.ajax_url, data, function(r){
      if(r.success) alert('Site settings saved!');
    });
  });
})(jQuery);
</script>
</div>
