<?php if(!defined('ABSPATH'))exit; ?>
<div class="wrap zca-wrap">
<h1 class="zca-page-title"><i class="bi bi-grid-3x3-gap-fill me-2"></i><?php esc_html_e('Bootstrap Element Library','zincelestial'); ?></h1>
<p class="text-muted mb-4"><?php esc_html_e('All Bootstrap 5 components available as shortcodes. Click "Copy" to insert into your content.','zincelestial'); ?></p>
<div class="row g-4">
<?php
$components = [
  ['name'=>'Alert','icon'=>'exclamation-triangle-fill','shortcode'=>'[zc_alert type="primary"]Your message here[/zc_alert]','desc'=>'Dismissible alerts in all semantic colors.'],
  ['name'=>'Button','icon'=>'hand-index-thumb-fill','shortcode'=>'[zc_button type="primary" href="#"]Click Me[/zc_button]','desc'=>'Styled buttons with outline, pill, and icon variants.'],
  ['name'=>'Badge','icon'=>'bookmark-fill','shortcode'=>'[zc_badge color="primary"]New[/zc_badge]','desc'=>'Small count and label indicators.'],
  ['name'=>'Card','icon'=>'card-text','shortcode'=>'[zc_card title="Card Title" shadow="sm"]Content here[/zc_card]','desc'=>'Content containers with optional image, header, footer.'],
  ['name'=>'Accordion','icon'=>'layout-text-sidebar','shortcode'=>'[zc_accordion][zc_accordion_item title="Item 1"]Content[/zc_accordion_item][/zc_accordion]','desc'=>'Collapsible FAQ-style content sections.'],
  ['name'=>'Tabs','icon'=>'layout-tabs-fill','shortcode'=>'[zc_tabs][zc_tab title="Tab 1"]Content[/zc_tab][/zc_tabs]','desc'=>'Tabbed content panels (tabs, pills, underline styles).'],
  ['name'=>'Progress Bar','icon'=>'activity','shortcode'=>'[zc_progress value="75" color="primary"]','desc'=>'Animated progress bars with striped and labeled options.'],
  ['name'=>'Stat Card','icon'=>'bar-chart-fill','shortcode'=>'[zc_stat_card value="1,234" label="Total Users" icon="people-fill" trend="+12%" trend_dir="up"]','desc'=>'Dashboard-style metric cards.'],
  ['name'=>'Grid','icon'=>'grid-fill','shortcode'=>'[zc_grid cols="3" gap="4"]...cards...[/zc_grid]','desc'=>'Responsive Bootstrap grid wrapper (1–6 columns).'],
  ['name'=>'Icon','icon'=>'star-fill','shortcode'=>'[zc_icon name="star-fill" size="1.5rem" color="#7c6ff7"]','desc'=>'Bootstrap Icons rendered inline via shortcode.'],
  ['name'=>'Pricing Card','icon'=>'credit-card-fill','shortcode'=>'[zc_pricing title="Pro" price="$29" period="/mo" features="Feature 1,Feature 2" btn_href="#" featured="1"]','desc'=>'Feature-rich pricing plan cards.'],
  ['name'=>'Countdown','icon'=>'stopwatch-fill','shortcode'=>'[zc_countdown date="2026-12-31" style="boxes"]','desc'=>'Real-time countdown timer to any date.'],
  ['name'=>'Member Card','icon'=>'person-circle','shortcode'=>'[zc_member_card user_id="1" size="md"]','desc'=>'BuddyPress member profile card widget.'],
  ['name'=>'Breadcrumb','icon'=>'signpost-split-fill','shortcode'=>'[zc_breadcrumb separator="/"]','desc'=>'Auto-generated breadcrumb navigation.'],
  ['name'=>'Progress Info Bar','icon'=>'trophy-fill','shortcode'=>'[zc_bar_progress_info show_xp="1" show_credits="1" show_rank="1"]','desc'=>'GamiPress XP/credits/rank badges inline.'],
];
foreach($components as $c): ?>
<div class="col-md-6 col-lg-4">
  <div class="card h-100 shadow-sm">
    <div class="card-body">
      <div class="d-flex align-items-center gap-2 mb-2">
        <i class="bi bi-<?php echo esc_attr($c['icon']); ?> text-primary" style="font-size:1.3rem"></i>
        <h5 class="card-title mb-0"><?php echo esc_html($c['name']); ?></h5>
      </div>
      <p class="card-text text-muted small"><?php echo esc_html($c['desc']); ?></p>
      <div class="bg-dark rounded p-2 mb-2">
        <code class="text-success small zc-sc-code" style="word-break:break-all;white-space:pre-wrap"><?php echo esc_html($c['shortcode']); ?></code>
      </div>
      <button type="button" class="btn btn-sm btn-outline-primary zca-copy-sc" data-sc="<?php echo esc_attr($c['shortcode']); ?>">
        <i class="bi bi-clipboard me-1"></i><?php esc_html_e('Copy Shortcode','zincelestial'); ?>
      </button>
    </div>
  </div>
</div>
<?php endforeach; ?>
</div>
<script>
document.querySelectorAll('.zca-copy-sc').forEach(function(btn){
  btn.addEventListener('click',function(){
    var sc=this.dataset.sc;
    navigator.clipboard.writeText(sc).then(function(){
      btn.innerHTML='<i class="bi bi-check2 me-1"></i>Copied!';
      btn.classList.replace('btn-outline-primary','btn-success');
      setTimeout(function(){
        btn.innerHTML='<i class="bi bi-clipboard me-1"></i>Copy Shortcode';
        btn.classList.replace('btn-success','btn-outline-primary');
      },2000);
    });
  });
});
</script>
</div>
