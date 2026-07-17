<?php
/**
 * ZinCelestial v5.0.0 — bbPress Page Template
 * Wrapper for all bbPress forum/topic/reply pages
 */
get_header();
?>
<div class="container-fluid zc-content-wrapper zc-bbp-page px-3 px-lg-4 py-4">
  <div class="row g-4">
    <div class="col-12 col-lg-9">
      <?php while ( have_posts() ) : the_post(); ?>
        <div class="zc-bbp-content">
          <?php the_content(); ?>
        </div>
      <?php endwhile; ?>
    </div>
    <div class="col-12 col-lg-3">
      <?php get_sidebar('buddypress'); ?>
    </div>
  </div>
</div>
<?php get_footer(); ?>
