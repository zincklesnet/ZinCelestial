<?php
/**
 * ZinCelestial v5.0.0 — Search Results Template
 */
get_header();
?>
<div class="container-fluid zc-content-wrapper px-3 px-lg-4 py-4">
  <div class="row g-4">
    <div class="col-12 col-lg-9">
      <header class="zc-archive-header mb-4 pb-3 border-bottom">
        <h1 class="h2 fw-bold">
          <?php printf( esc_html__( 'Search Results for: %s', 'zincelestial' ), '<span class="text-primary">' . get_search_query() . '</span>' ); ?>
        </h1>
        <p class="text-muted">
          <?php printf( esc_html__( '%d results found', 'zincelestial' ), (int) $wp_query->found_posts ); ?>
        </p>
      </header>
      <div class="mb-4">
        <?php get_search_form(); ?>
      </div>
      <?php if ( have_posts() ) : ?>
        <div class="row g-4">
          <?php while ( have_posts() ) : the_post(); ?>
          <div class="col-12 col-md-6">
            <?php get_template_part( 'template-parts/content/content', 'post' ); ?>
          </div>
          <?php endwhile; ?>
        </div>
        <div class="mt-5">
          <?php the_posts_pagination([
              'prev_text' => '<i class="bi bi-chevron-left"></i>',
              'next_text' => '<i class="bi bi-chevron-right"></i>',
          ]); ?>
        </div>
      <?php else : ?>
        <?php get_template_part( 'template-parts/content/content', 'none' ); ?>
      <?php endif; ?>
    </div>
    <div class="col-12 col-lg-3">
      <?php get_sidebar(); ?>
    </div>
  </div>
</div>
<?php get_footer(); ?>
