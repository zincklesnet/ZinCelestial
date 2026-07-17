<?php
/**
 * ZinCelestial v5.0.0 — BuddyPress Account Activation
 */
get_header();
?>
<main id="primary" class="site-main">
<div class="zc-activation-page py-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-md-6 text-center">
        <?php do_action('bp_before_activation_page'); ?>
        <div class="card border-0 shadow p-5">
          <div class="mb-4">
            <i class="bi bi-envelope-check text-primary" style="font-size:4rem;"></i>
          </div>
          <h1 class="h3 fw-bold mb-3"><?php esc_html_e('Activate Your Account','zincelestial'); ?></h1>
          <?php bp_activation_page(); ?>
        </div>
        <?php do_action('bp_after_activation_page'); ?>
      </div>
    </div>
  </div>
</div>
</main>
<?php get_footer(); ?>
