<?php
/**
 * ZinCelestial v4.0 — WooCommerce Archive/Shop Template
 * BS5 layout with sidebar support.
 *
 * @package ZinCelestial
 */
defined('ABSPATH') || exit;
get_header('shop');
?>
<?php
$cols    = (int) zc_option('woo_columns', 3);
$layout  = zc_option('woo_layout', 'right-sidebar');
$sidebar = zc_option('woo_sidebar', '1') === '1' && is_active_sidebar('zc-woo-sidebar');
$main_col = 'col-12';
if($sidebar){
  $main_col = $layout === 'left-sidebar' ? 'col-12 col-lg-9 order-lg-2' : 'col-12 col-lg-9';
}
?>
<div class="zc-woo-wrap">
  <div class="container py-4">
    <!-- Shop header -->
    <?php do_action('woocommerce_before_main_content'); ?>

    <div class="row g-4">

      <!-- Left Sidebar -->
      <?php if($sidebar && $layout === 'left-sidebar'): ?>
      <aside class="col-12 col-lg-3 order-lg-1 zc-sidebar zc-woo-sidebar">
        <?php dynamic_sidebar('zc-woo-sidebar'); ?>
      </aside>
      <?php endif; ?>

      <!-- Main content -->
      <div class="<?php echo esc_attr($main_col); ?>">

        <?php if(woocommerce_product_loop()): ?>

        <!-- Toolbar row -->
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-4">
          <div class="zc-woo-result-count text-muted small">
            <?php woocommerce_result_count(); ?>
          </div>
          <div class="d-flex gap-2 align-items-center">
            <select class="form-select form-select-sm" style="width:auto" onchange="location.href=this.value">
              <?php
              $orderby_options = WC()->query->get_catalog_ordering_args();
              $current = isset($_GET['orderby']) ? sanitize_text_field(wp_unslash($_GET['orderby'])) : apply_filters('woocommerce_default_catalog_orderby', get_option('woocommerce_default_catalog_orderby', 'menu_order'));
              foreach(WC()->query->get_catalog_ordering_args() as $id => $args):
                $url = add_query_arg('orderby', $id, remove_query_arg(['paged'], get_pagenum_link()));
              ?>
              <option value="<?php echo esc_url($url); ?>" <?php selected($current, $id); ?>><?php echo esc_html(wc_get_product_sort_label($id)); ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>

        <?php do_action('woocommerce_before_shop_loop'); ?>

        <?php woocommerce_product_loop_start(); ?>

          <?php if(wc_get_loop_prop('total')): ?>
            <?php while(have_posts()): the_post(); ?>
              <?php wc_get_template_part('content', 'product'); ?>
            <?php endwhile; ?>
          <?php endif; ?>

        <?php woocommerce_product_loop_end(); ?>

        <?php do_action('woocommerce_after_shop_loop'); ?>

        <?php else: ?>
          <?php do_action('woocommerce_no_products_found'); ?>
        <?php endif; ?>

        <!-- Pagination -->
        <div class="zc-woo-pagination mt-4">
          <?php woocommerce_pagination(); ?>
        </div>

      </div><!-- .main col -->

      <!-- Right Sidebar -->
      <?php if($sidebar && $layout !== 'left-sidebar'): ?>
      <aside class="col-12 col-lg-3 zc-sidebar zc-woo-sidebar">
        <?php dynamic_sidebar('zc-woo-sidebar'); ?>
      </aside>
      <?php endif; ?>

    </div><!-- .row -->

    <?php do_action('woocommerce_after_main_content'); ?>

  </div><!-- .container -->
</div>
<?php get_footer('shop'); ?>
