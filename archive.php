<?php
/**
 * ZinCelestial v5.0.0 — Archive Template
 */
get_header();
$layout = zc_option('sidebar_layout','right');
?>
<div class="container-fluid zc-content-wrapper px-3 px-lg-4 py-4">
  <div class="row g-4">

    <?php if ( $layout === 'left' && is_active_sidebar('zc-sidebar-left') ) : ?>
    <div class="col-12 col-lg-3"><aside class="zc-sidebar"><?php dynamic_sidebar('zc-sidebar-left'); ?></aside></div>
    <?php endif; ?>

    <div class="col-12 <?php echo $layout !== 'none' ? 'col-lg-9' : 'col-lg-10 mx-auto'; ?>">
      <header class="zc-archive-header mb-4 pb-3 border-bottom">
        <?php the_archive_title('<h1 class="zc-archive-title h2 fw-bold">','</h1>'); ?>
        <?php the_archive_description('<div class="zc-archive-description text-muted mt-2">','</div>'); ?>
      </header>

      <?php if ( have_posts() ) : ?>
        <div class="row g-4 zc-post-grid">
          <?php while ( have_posts() ) : the_post(); ?>
          <div class="col-12 col-md-6 col-xl-4">
            <?php get_template_part('template-parts/content/content','post'); ?>
          </div>
          <?php endwhile; ?>
        </div>
        <div class="zc-pagination mt-5">
          <?php the_posts_pagination([
              'mid_size'  => 2,
              'prev_text' => '<i class="bi bi-chevron-left"></i> ' . __('Previous','zincelestial'),
              'next_text' => __('Next','zincelestial') . ' <i class="bi bi-chevron-right"></i>',
          ]); ?>
        </div>
      <?php else : ?>
        <?php get_template_part('template-parts/content/content','none'); ?>
      <?php endif; ?>
    </div>

    <?php if ( $layout === 'right' && is_active_sidebar('zc-sidebar-right') ) : ?>
    <div class="col-12 col-lg-3"><aside class="zc-sidebar"><?php dynamic_sidebar('zc-sidebar-right'); ?></aside></div>
    <?php endif; ?>
  </div>
</div>
<?php get_footer(); ?>
