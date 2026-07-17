<?php if ( ! defined( 'ABSPATH' ) ) exit;
if ( ! current_user_can( 'manage_network_options' ) ) wp_die( 'Insufficient permissions' );
$opts = get_site_option( 'zincelestial_network_options', [] );
$modules = [
  'buddypress'     => [ 'BuddyPress Integration',    'bi-people-fill',        'BuddyPress member profiles, groups, activity, BP templates' ],
  'woocommerce'    => [ 'WooCommerce Integration',   'bi-bag-fill',           'Shop pages, product cards, cart, WC CSS overrides' ],
  'bbpress'        => [ 'bbPress Forums',            'bi-chat-left-dots-fill','Forum templates, bbPress CSS integration' ],
  'reactions'      => [ 'Reactions System',          'bi-emoji-smile-fill',   'Post/activity reaction buttons and counts' ],
  'compose_bar'    => [ 'Compose Bar',               'bi-pencil-fill',        'Global compose/post bar on frontend' ],
  'gamipress_bar'  => [ 'GamiPress Points Bar',      'bi-trophy-fill',        'Sticky XP/points bar (requires GamiPress plugin)' ],
  'helpdesk'       => [ 'Help Desk',                 'bi-headset',            'Support ticket system, [zc_my_tickets] shortcode' ],
  'analytics'      => [ 'Analytics Dashboard',       'bi-bar-chart-fill',     'Chart.js analytics dashboard page' ],
  'calendar_page'  => [ 'Calendar Page',             'bi-calendar3',          'FullCalendar events page in admin panel' ],
  'library'        => [ 'Element Library',           'bi-collection-fill',    'Bootstrap component generator + shortcode library' ],
  'post_meta'      => [ 'Post Meta Options',         'bi-file-richtext-fill', 'Per-post layout/subheader/background controls' ],
  'category_colors'=> [ 'Category Colors',           'bi-droplet-fill',       'Color picker on taxonomy terms, frontend display' ],
  'header_sections'=> [ 'Header Zone Builder',       'bi-layout-text-window-reverse', 'Left/Center/Right header zone configuration' ],
  'dark_mode'      => [ 'Dark Mode Toggle',          'bi-moon-fill',          'Frontend dark/light mode toggle for users' ],
];
?>
<div class="wrap zca-wrap">
<div class="d-flex justify-content-between align-items-center mb-4">
  <h1 class="zca-page-title mb-0"><i class="bi bi-toggles me-2"></i>Network Modules</h1>
  <button class="btn btn-primary" id="zcaSaveNetworkModules"><i class="bi bi-floppy me-1"></i>Save Module Settings</button>
</div>
<div class="alert alert-info small mb-4"><i class="bi bi-info-circle me-2"></i>
  These network-level module defaults apply to all subsites that haven't overridden them in Site Management.
  Subsites with "Use Own Settings" enabled manage their modules independently.
  <strong>All modules default to OFF.</strong>
</div>
<div class="row g-3">
  <?php foreach($modules as $key=>[$title,$icon,$desc]): ?>
  <div class="col-md-6 col-lg-4">
    <div class="card border-0 shadow-sm h-100">
      <div class="card-body">
        <div class="d-flex align-items-start gap-3">
          <div style="width:40px;height:40px;border-radius:8px;background:rgba(124,111,247,.15);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            <i class="bi <?php echo $icon;?>" style="color:#7c6ff7;font-size:1.1rem;"></i>
          </div>
          <div class="flex-grow-1">
            <div class="d-flex justify-content-between align-items-center">
              <h6 class="mb-0 fw-semibold"><?php echo $title;?></h6>
              <div class="form-check form-switch mb-0">
                <input class="form-check-input" type="checkbox" role="switch"
                       name="network_module_<?php echo $key;?>"
                       id="nm_<?php echo $key;?>" value="1"
                       <?php checked($opts['network_module_'.$key]??'0','1');?>>
              </div>
            </div>
            <p class="text-muted small mb-0 mt-1"><?php echo $desc;?></p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php endforeach;?>
</div>
<script>
(function($){
  $('#zcaSaveNetworkModules').on('click', function(){
    var opts = {};
    $('[name^="network_module_"]').each(function(){
      opts[$(this).attr('name')] = $(this).is(':checked') ? '1' : '0';
    });
    $.post(ZC_Admin.ajax_url, { action:'zc_network_save', nonce:ZC_Admin.nonce, options:opts }, function(r){
      if(r.success) alert('Network modules saved!');
    });
  });
})(jQuery);
</script>
</div>
