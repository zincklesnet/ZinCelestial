<?php
/**
 * ZinCelestial v4.0 — WooCommerce Product Loop Card
 * BS5 card with hover effect.
 */
defined('ABSPATH') || exit;
global $product;
if(empty($product) || !$product->is_visible()) return;
?>
<li <?php wc_product_class('zc-product-item col', $product); ?>>
  <div class="card h-100 shadow-sm zc-product-card position-relative">

    <!-- Sale badge -->
    <?php if($product->is_on_sale()): ?>
    <span class="badge bg-danger position-absolute top-0 start-0 m-2" style="z-index:2"><?php esc_html_e('Sale!','zincelestial'); ?></span>
    <?php endif; ?>

    <!-- Product image -->
    <a href="<?php the_permalink(); ?>" class="d-block overflow-hidden zc-product-img-wrap" style="aspect-ratio:1;background:#f8f9fa">
      <?php if(has_post_thumbnail()):
        $img = wp_get_attachment_image_src(get_post_thumbnail_id(), 'woocommerce_thumbnail');
      ?>
      <img src="<?php echo esc_url($img[0]); ?>" class="card-img-top w-100 h-100 object-fit-cover zc-product-thumbnail" alt="<?php the_title_attribute(); ?>" loading="lazy">
      <?php else: ?>
      <?php echo wc_placeholder_img('woocommerce_thumbnail','class="card-img-top"'); ?>
      <?php endif; ?>
      <!-- Overlay with quick actions -->
      <div class="zc-product-overlay position-absolute inset-0 d-flex align-items-center justify-content-center gap-2 opacity-0 zc-product-hover-overlay" style="top:0;left:0;right:0;bottom:0;background:rgba(0,0,0,.35);transition:opacity .2s">
        <button class="btn btn-sm btn-light rounded-circle p-2" title="<?php esc_attr_e('Add to wishlist','zincelestial'); ?>">
          <i class="bi bi-heart"></i>
        </button>
        <a href="<?php the_permalink(); ?>" class="btn btn-sm btn-light rounded-circle p-2" title="<?php esc_attr_e('Quick view','zincelestial'); ?>">
          <i class="bi bi-eye"></i>
        </a>
      </div>
    </a>

    <div class="card-body d-flex flex-column">
      <!-- Category -->
      <?php $cats = get_the_terms(get_the_ID(),'product_cat'); if($cats && !is_wp_error($cats)):
        $cat = reset($cats); ?>
      <span class="text-muted small mb-1"><?php echo esc_html($cat->name); ?></span>
      <?php endif; ?>

      <!-- Title -->
      <h5 class="card-title fs-6 mb-2">
        <a href="<?php the_permalink(); ?>" class="text-decoration-none stretched-link text-body">
          <?php the_title(); ?>
        </a>
      </h5>

      <!-- Rating -->
      <?php if(get_option('woocommerce_enable_review_rating') === 'yes'):
        $rating = $product->get_average_rating(); ?>
      <div class="d-flex align-items-center gap-1 mb-2">
        <?php echo wc_get_rating_html($rating); ?>
        <small class="text-muted">(<?php echo esc_html($product->get_review_count()); ?>)</small>
      </div>
      <?php endif; ?>

      <!-- Price -->
      <div class="mt-auto">
        <p class="fw-bold mb-3"><?php echo $product->get_price_html(); ?></p>
        <!-- Add to Cart -->
        <?php
        if($product->is_purchasable() && $product->is_in_stock()):
          woocommerce_template_loop_add_to_cart(['class'=>'btn btn-primary btn-sm w-100']);
        else:
          echo '<a href="' . esc_url(get_permalink()) . '" class="btn btn-outline-secondary btn-sm w-100">' . esc_html__('View Product','zincelestial') . '</a>';
        endif;
        ?>
      </div>
    </div>
  </div>
</li>
<style>.zc-product-card:hover .zc-product-hover-overlay{opacity:1!important;}.zc-product-img-wrap{cursor:pointer;}</style>
