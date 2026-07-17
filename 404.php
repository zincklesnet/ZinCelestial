<?php
/**
 * ZinCelestial v5.0.0 — 404 Template
 */
get_header();
?>
<div class="container zc-content-wrapper py-5 text-center">
  <div class="row justify-content-center">
    <div class="col-12 col-md-8 col-lg-6">
      <div class="display-1 fw-bold text-primary mb-3" style="font-size:8rem;opacity:.15;">404</div>
      <h1 class="h2 fw-bold mb-3"><?php esc_html_e('Page Not Found','zincelestial'); ?></h1>
      <p class="text-muted mb-4"><?php esc_html_e("The page you're looking for doesn't exist or has been moved.",'zincelestial'); ?></p>
      <div class="d-flex flex-wrap gap-3 justify-content-center mb-4">
        <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-primary btn-lg">
          <i class="bi bi-house me-2"></i><?php esc_html_e('Go Home','zincelestial'); ?>
        </a>
        <a href="javascript:history.back()" class="btn btn-outline-secondary btn-lg">
          <i class="bi bi-arrow-left me-2"></i><?php esc_html_e('Go Back','zincelestial'); ?>
        </a>
      </div>
      <?php get_search_form(); ?>
    </div>
  </div>
</div>
<?php get_footer(); ?>
