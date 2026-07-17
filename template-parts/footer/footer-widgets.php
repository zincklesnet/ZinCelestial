<?php
/**
 * ZinCelestial v5.0.0 — Footer Widgets
 */
$cols = (int) zc_option('footer_widget_cols','4');
$cols = max(1, min(6, $cols));
$bs_col = 'col-12 col-sm-6 col-lg-' . round(12 / $cols);
$active_areas = [];
for ($i = 1; $i <= $cols; $i++) {
    if ( is_active_sidebar('zc-footer-' . $i) ) {
        $active_areas[] = $i;
    }
}
if ( empty($active_areas) ) return;
?>
<div class="zc-footer-widgets py-5">
  <div class="container-fluid px-3 px-lg-4">
    <div class="row g-4">
      <?php foreach ($active_areas as $i) : ?>
      <div class="<?php echo esc_attr($bs_col); ?>">
        <?php dynamic_sidebar('zc-footer-' . $i); ?>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>
