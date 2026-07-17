<?php if(!defined('ABSPATH'))exit;
$opts = get_option('zincelestial_options', zc_default_options());
function zca_owc($o,$k,$f=''){return isset($o[$k])?$o[$k]:$f;}
$wc_active = class_exists('WooCommerce');
?>
<div class="zca-wrap">
<div class="zca-page-header">
  <div class="zca-page-header__left">
    <div class="zca-page-header__icon">🛒</div>
    <div><div class="zca-page-header__title">WooCommerce</div>
    <div class="zca-page-header__sub">Shop layout, cart, checkout, product pages, and marketplace settings</div></div>
  </div>
  <div class="zca-page-header__right">
    <span class="zca-badge" style="background:rgba(<?php echo $wc_active?'52,211,153':'248,113,113'; ?>,0.2);color:var(--zca-<?php echo $wc_active?'success':'danger'; ?>);border:1px solid rgba(<?php echo $wc_active?'52,211,153':'248,113,113'; ?>,0.35);"><?php echo $wc_active?'● WooCommerce Active':'⚠ WooCommerce Inactive'; ?></span>
  </div>
</div>
<div class="zca-content">
  <div class="zca-tabs-nav">
    <button class="zca-tab-btn" data-zc-tab="shop"><span class="zca-tab-icon">🏪</span> Shop</button>
    <button class="zca-tab-btn" data-zc-tab="product"><span class="zca-tab-icon">📦</span> Products</button>
    <button class="zca-tab-btn" data-zc-tab="cart"><span class="zca-tab-icon">🛒</span> Cart & Checkout</button>
    <button class="zca-tab-btn" data-zc-tab="marketplace"><span class="zca-tab-icon">🏬</span> Marketplace</button>
  </div>
  <div class="zca-tab-panels">

    <div class="zca-tab-panel" data-zc-panel="shop">
      <div class="zca-grid zca-grid--2">
        <div class="zca-card">
          <div class="zca-card__header"><div class="zca-card__icon">🏪</div><span class="zca-card__title">Shop Archive</span></div>
          <div class="zca-field">
            <label class="zca-label">Products Per Row</label>
            <div class="zca-radio-cards">
              <?php $ppr = zca_owc($opts,'wc_products_per_row','3'); ?>
              <label class="zca-radio-card"><input type="radio" name="wc_products_per_row" value="2" <?php checked($ppr,'2'); ?>><span class="zca-radio-card__inner"><span class="zca-radio-card__icon">▬▬</span>2</span></label>
              <label class="zca-radio-card"><input type="radio" name="wc_products_per_row" value="3" <?php checked($ppr,'3'); ?>><span class="zca-radio-card__inner"><span class="zca-radio-card__icon">▬▬▬</span>3</span></label>
              <label class="zca-radio-card"><input type="radio" name="wc_products_per_row" value="4" <?php checked($ppr,'4'); ?>><span class="zca-radio-card__inner"><span class="zca-radio-card__icon">▬▬▬▬</span>4</span></label>
              <label class="zca-radio-card"><input type="radio" name="wc_products_per_row" value="5" <?php checked($ppr,'5'); ?>><span class="zca-radio-card__inner"><span class="zca-radio-card__icon">5</span>5</span></label>
            </div>
          </div>
          <div class="zca-field">
            <label class="zca-label">Products Per Page</label>
            <div class="zca-slider-wrap">
              <input type="range" class="zca-slider" name="wc_products_per_page" data-option="wc_products_per_page" min="4" max="60" value="<?php echo esc_attr(zca_owc($opts,'wc_products_per_page','12')); ?>" data-unit="">
              <span class="zca-slider-value"><?php echo esc_attr(zca_owc($opts,'wc_products_per_page','12')); ?></span>
            </div>
          </div>
          <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">AJAX Filtering</div><div class="zca-toggle-row__desc">Filter/sort products without page reload</div></div><label class="zca-toggle"><input type="checkbox" name="wc_ajax_filter" data-option="wc_ajax_filter" <?php checked(zca_owc($opts,'wc_ajax_filter','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
          <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Quick View Modal</div><div class="zca-toggle-row__desc">Quick product view without leaving shop page</div></div><label class="zca-toggle"><input type="checkbox" name="wc_quick_view" data-option="wc_quick_view" <?php checked(zca_owc($opts,'wc_quick_view','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
          <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Wishlist Button on Cards</div><div class="zca-toggle-row__desc">♥ wishlist button on product thumbnails</div></div><label class="zca-toggle"><input type="checkbox" name="wc_wishlist_btn" data-option="wc_wishlist_btn" <?php checked(zca_owc($opts,'wc_wishlist_btn','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
          <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Sale Badge Style</div></div><label class="zca-toggle"><input type="checkbox" name="wc_custom_sale_badge" data-option="wc_custom_sale_badge" <?php checked(zca_owc($opts,'wc_custom_sale_badge','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
        </div>
        <div class="zca-card">
          <div class="zca-card__header"><div class="zca-card__icon">🎨</div><span class="zca-card__title">Shop Colors</span></div>
          <div class="zca-field">
            <label class="zca-label">Add to Cart Button Color</label>
            <div class="zca-color-row">
              <div class="zca-color-swatch"><input type="color" name="wc_btn_color" data-option="wc_btn_color" value="<?php echo esc_attr(zca_owc($opts,'wc_btn_color','#7c6ff7')); ?>"></div>
              <input type="text" class="zca-color-hex" value="<?php echo esc_attr(strtoupper(zca_owc($opts,'wc_btn_color','#7c6ff7'))); ?>" maxlength="7">
              <div class="zca-color-preview" style="background:<?php echo esc_attr(zca_owc($opts,'wc_btn_color','#7c6ff7')); ?>"></div>
            </div>
          </div>
          <div class="zca-field">
            <label class="zca-label">Price Color</label>
            <div class="zca-color-row">
              <div class="zca-color-swatch"><input type="color" name="wc_price_color" data-option="wc_price_color" value="<?php echo esc_attr(zca_owc($opts,'wc_price_color','#34d399')); ?>"></div>
              <input type="text" class="zca-color-hex" value="<?php echo esc_attr(strtoupper(zca_owc($opts,'wc_price_color','#34d399'))); ?>" maxlength="7">
              <div class="zca-color-preview" style="background:<?php echo esc_attr(zca_owc($opts,'wc_price_color','#34d399')); ?>"></div>
            </div>
          </div>
          <div class="zca-field">
            <label class="zca-label">Sale Price Color</label>
            <div class="zca-color-row">
              <div class="zca-color-swatch"><input type="color" name="wc_sale_color" data-option="wc_sale_color" value="<?php echo esc_attr(zca_owc($opts,'wc_sale_color','#f87171')); ?>"></div>
              <input type="text" class="zca-color-hex" value="<?php echo esc_attr(strtoupper(zca_owc($opts,'wc_sale_color','#f87171'))); ?>" maxlength="7">
              <div class="zca-color-preview" style="background:<?php echo esc_attr(zca_owc($opts,'wc_sale_color','#f87171')); ?>"></div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="zca-tab-panel" data-zc-panel="product">
      <div class="zca-card">
        <div class="zca-card__header"><div class="zca-card__icon">📦</div><span class="zca-card__title">Single Product Page</span></div>
        <div class="zca-grid zca-grid--2">
          <div class="zca-field">
            <label class="zca-label">Product Gallery Style</label>
            <select class="zca-select" name="wc_gallery_style" data-option="wc_gallery_style">
              <option value="slider" <?php selected(zca_owc($opts,'wc_gallery_style','slider'),'slider'); ?>>Image Slider</option>
              <option value="thumbnails" <?php selected(zca_owc($opts,'wc_gallery_style','slider'),'thumbnails'); ?>>Thumbnails Grid</option>
              <option value="zoom" <?php selected(zca_owc($opts,'wc_gallery_style','slider'),'zoom'); ?>>Hover Zoom</option>
            </select>
          </div>
          <div class="zca-field">
            <label class="zca-label">Tabs Style</label>
            <select class="zca-select" name="wc_tabs_style" data-option="wc_tabs_style">
              <option value="tabs" <?php selected(zca_owc($opts,'wc_tabs_style','tabs'),'tabs'); ?>>Tabs</option>
              <option value="accordion" <?php selected(zca_owc($opts,'wc_tabs_style','tabs'),'accordion'); ?>>Accordion</option>
            </select>
          </div>
        </div>
        <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Sticky Add to Cart Bar</div><div class="zca-toggle-row__desc">Floating add-to-cart bar that appears on scroll</div></div><label class="zca-toggle"><input type="checkbox" name="wc_sticky_atc" data-option="wc_sticky_atc" <?php checked(zca_owc($opts,'wc_sticky_atc','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
        <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">360° Product View</div><div class="zca-toggle-row__desc">Allow 360-degree product image spin</div></div><label class="zca-toggle"><input type="checkbox" name="wc_360_view" data-option="wc_360_view" <?php checked(zca_owc($opts,'wc_360_view','0'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
        <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Social Sharing on Products</div><div class="zca-toggle-row__desc">Share buttons on product pages</div></div><label class="zca-toggle"><input type="checkbox" name="wc_product_sharing" data-option="wc_product_sharing" <?php checked(zca_owc($opts,'wc_product_sharing','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
        <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Reactions on Products</div><div class="zca-toggle-row__desc">Show animated reaction system on products</div></div><label class="zca-toggle"><input type="checkbox" name="wc_product_reactions" data-option="wc_product_reactions" <?php checked(zca_owc($opts,'wc_product_reactions','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
        <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Recently Viewed Products</div><div class="zca-toggle-row__desc">Track and show recently viewed products</div></div><label class="zca-toggle"><input type="checkbox" name="wc_recently_viewed" data-option="wc_recently_viewed" <?php checked(zca_owc($opts,'wc_recently_viewed','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
      </div>
    </div>

    <div class="zca-tab-panel" data-zc-panel="cart">
      <div class="zca-grid zca-grid--2">
        <div class="zca-card">
          <div class="zca-card__header"><div class="zca-card__icon">🛒</div><span class="zca-card__title">Cart Settings</span></div>
          <div class="zca-field">
            <label class="zca-label">Cart Style</label>
            <select class="zca-select" name="wc_cart_style" data-option="wc_cart_style">
              <option value="slide-drawer" <?php selected(zca_owc($opts,'wc_cart_style','slide-drawer'),'slide-drawer'); ?>>Slide-Out Drawer</option>
              <option value="mini-cart" <?php selected(zca_owc($opts,'wc_cart_style','slide-drawer'),'mini-cart'); ?>>Mini Cart Dropdown</option>
              <option value="page" <?php selected(zca_owc($opts,'wc_cart_style','slide-drawer'),'page'); ?>>Cart Page</option>
            </select>
          </div>
          <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">AJAX Add to Cart</div><div class="zca-toggle-row__desc">Add to cart without page reload</div></div><label class="zca-toggle"><input type="checkbox" name="wc_ajax_cart" data-option="wc_ajax_cart" <?php checked(zca_owc($opts,'wc_ajax_cart','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
          <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Cart Upsells</div><div class="zca-toggle-row__desc">Show upsell products in cart sidebar</div></div><label class="zca-toggle"><input type="checkbox" name="wc_cart_upsells" data-option="wc_cart_upsells" <?php checked(zca_owc($opts,'wc_cart_upsells','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
          <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Free Shipping Progress Bar</div><div class="zca-toggle-row__desc">Show how much more to spend for free shipping</div></div><label class="zca-toggle"><input type="checkbox" name="wc_free_ship_bar" data-option="wc_free_ship_bar" <?php checked(zca_owc($opts,'wc_free_ship_bar','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
        </div>
        <div class="zca-card">
          <div class="zca-card__header"><div class="zca-card__icon">💳</div><span class="zca-card__title">Checkout</span></div>
          <div class="zca-field">
            <label class="zca-label">Checkout Style</label>
            <select class="zca-select" name="wc_checkout_style" data-option="wc_checkout_style">
              <option value="standard" <?php selected(zca_owc($opts,'wc_checkout_style','standard'),'standard'); ?>>Standard</option>
              <option value="multi-step" <?php selected(zca_owc($opts,'wc_checkout_style','standard'),'multi-step'); ?>>Multi-Step</option>
              <option value="one-page" <?php selected(zca_owc($opts,'wc_checkout_style','standard'),'one-page'); ?>>One Page</option>
            </select>
          </div>
          <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Guest Checkout</div><div class="zca-toggle-row__desc">Allow purchase without account</div></div><label class="zca-toggle"><input type="checkbox" name="wc_guest_checkout" data-option="wc_guest_checkout" <?php checked(zca_owc($opts,'wc_guest_checkout','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
          <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">ZCreds at Checkout</div><div class="zca-toggle-row__desc">Allow customers to pay with ZCreds points</div></div><label class="zca-toggle"><input type="checkbox" name="wc_zcreds_checkout" data-option="wc_zcreds_checkout" <?php checked(zca_owc($opts,'wc_zcreds_checkout','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
          <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Order Bump</div><div class="zca-toggle-row__desc">Show a one-click upsell offer at checkout</div></div><label class="zca-toggle"><input type="checkbox" name="wc_order_bump" data-option="wc_order_bump" <?php checked(zca_owc($opts,'wc_order_bump','0'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
        </div>
      </div>
    </div>

    <div class="zca-tab-panel" data-zc-panel="marketplace">
      <div class="zca-card">
        <div class="zca-card__header"><div class="zca-card__icon">🏬</div><span class="zca-card__title">Multi-Vendor Marketplace (WCFM / Dokan)</span></div>
        <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Enable Vendor Profiles</div><div class="zca-toggle-row__desc">Custom ZinCelestial vendor store pages</div></div><label class="zca-toggle"><input type="checkbox" name="wcfm_vendor_profiles" data-option="wcfm_vendor_profiles" <?php checked(zca_owc($opts,'wcfm_vendor_profiles','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
        <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Vendor Store Banner</div><div class="zca-toggle-row__desc">Show vendor store header banner</div></div><label class="zca-toggle"><input type="checkbox" name="wcfm_store_banner" data-option="wcfm_store_banner" <?php checked(zca_owc($opts,'wcfm_store_banner','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
        <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Vendor Ratings</div><div class="zca-toggle-row__desc">Show star ratings on vendor store pages</div></div><label class="zca-toggle"><input type="checkbox" name="wcfm_vendor_ratings" data-option="wcfm_vendor_ratings" <?php checked(zca_owc($opts,'wcfm_vendor_ratings','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
        <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Vendor Follow Button</div><div class="zca-toggle-row__desc">BP-style follow button on vendor stores</div></div><label class="zca-toggle"><input type="checkbox" name="wcfm_vendor_follow" data-option="wcfm_vendor_follow" <?php checked(zca_owc($opts,'wcfm_vendor_follow','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
        <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Map on Store Page</div><div class="zca-toggle-row__desc">Show vendor location map</div></div><label class="zca-toggle"><input type="checkbox" name="wcfm_vendor_map" data-option="wcfm_vendor_map" <?php checked(zca_owc($opts,'wcfm_vendor_map','0'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
      </div>
    </div>

  </div>
</div>
</div>
