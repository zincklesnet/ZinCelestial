<?php
/**
 * ZinCelestial v5.0.0 — Footer Template
 */
?>
</main><!-- /#zc-main -->

<?php
/* ── Footer Widgets ───────────────────────────────────────────────────────── */
if ( zc_option('show_footer_widgets','0') === '1' ) :
    get_template_part('template-parts/footer/footer-widgets');
endif;

/* ── Footer Bottom Bar ────────────────────────────────────────────────────── */
if ( zc_option('show_footer_bottom','1') === '1' ) :
    get_template_part('template-parts/footer/footer-bottom');
endif;
?>

<?php
/* ── Scroll-to-Top Button ────────────────────────────────────────────────── */
if ( zc_option('scroll_to_top','0') === '1' ) :
    $pos   = zc_option('scroll_to_top_position','bottom-right');
    $style = zc_option('scroll_to_top_style','arrow');
    $size  = zc_option('scroll_to_top_size','md');
    $pos_css = $pos === 'bottom-left' ? 'bottom:28px;left:28px;' : 'bottom:28px;right:28px;';
    $icon    = $style === 'rocket' ? 'bi-rocket-takeoff' : 'bi-arrow-up';
    $sz_map  = ['sm'=>'32px','md'=>'44px','lg'=>'56px'];
    $sz      = $sz_map[$size] ?? '44px';
    ?>
<button id="zc-scroll-top" class="btn btn-primary zc-scroll-top rounded-circle border-0 shadow"
  style="<?php echo esc_attr($pos_css); ?>width:<?php echo esc_attr($sz); ?>;height:<?php echo esc_attr($sz); ?>;position:fixed;z-index:9999;display:none;align-items:center;justify-content:center;padding:0;"
  aria-label="<?php esc_attr_e('Back to top','zincelestial'); ?>">
  <i class="bi <?php echo esc_attr($icon); ?>"></i>
</button>
<?php endif; ?>

<?php
/* ── Scheme Switcher ─────────────────────────────────────────────────────── */
if ( zc_option('show_scheme_switcher','0') === '1' ) :
    $sp   = zc_option('scheme_switcher_position','bottom-left');
    $sp_css = $sp === 'bottom-right' ? 'bottom:80px;right:20px;' : 'bottom:80px;left:20px;';
    $schemes = ['cosmic','aurora','nova','zenith','ember','twilight'];
    $scheme_labels = ['cosmic'=>'Cosmic','aurora'=>'Aurora','nova'=>'Nova','zenith'=>'Zenith','ember'=>'Ember','twilight'=>'Twilight'];
    ?>
<div id="zc-scheme-switcher" class="zc-scheme-switcher" style="position:fixed;<?php echo esc_attr($sp_css); ?>z-index:9998;">
  <button class="btn btn-sm btn-dark rounded-pill shadow zc-switcher-toggle" data-bs-toggle="collapse" data-bs-target="#zcSchemePicker" aria-expanded="false">
    <i class="bi bi-palette me-1"></i> <?php esc_html_e('Theme','zincelestial'); ?>
  </button>
  <div class="collapse" id="zcSchemePicker">
    <div class="card card-body p-2 mt-1 shadow" style="min-width:140px;">
      <?php foreach($schemes as $s) : ?>
      <button class="btn btn-sm btn-outline-secondary mb-1 w-100 text-start zc-scheme-btn <?php echo (zc_option('color_scheme','cosmic')===$s)?'active':''; ?>" data-scheme="<?php echo esc_attr($s); ?>">
        <span class="zc-scheme-dot me-2" style="display:inline-block;width:10px;height:10px;border-radius:50%;background:var(--zc-primary-<?php echo esc_attr($s); ?>,var(--zc-primary));"></span>
        <?php echo esc_html($scheme_labels[$s]??$s); ?>
      </button>
      <?php endforeach; ?>
      <!-- Light/Dark toggle -->
      <hr class="my-1">
      <button class="btn btn-sm btn-outline-secondary w-100 text-start zc-mode-toggle">
        <i class="bi bi-moon me-2 zc-dark-icon"></i><i class="bi bi-sun me-2 zc-light-icon" style="display:none;"></i>
        <span class="zc-mode-label"><?php echo zc_option('color_mode','dark')==='dark' ? esc_html__('Dark Mode','zincelestial') : esc_html__('Light Mode','zincelestial'); ?></span>
      </button>
    </div>
  </div>
</div>
<?php endif; ?>

</div><!-- /#zc-page -->

<?php wp_footer(); ?>
</body>
</html>
