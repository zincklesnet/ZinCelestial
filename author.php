<?php
/**
 * ZinCelestial v5.0.0 — Author Archive Template
 */
get_header();
$author = get_queried_object();
?>
<div class="container-fluid zc-content-wrapper px-3 px-lg-4 py-4">
  <div class="row g-4">
    <div class="col-12 col-lg-9">
      <div class="zc-author-card card mb-4 border-0 shadow-sm">
        <div class="card-body d-flex align-items-center gap-4 p-4">
          <?php echo get_avatar($author->ID, 96, '', '', ['class'=>'rounded-circle zc-author-avatar']); ?>
          <div>
            <h1 class="h3 fw-bold mb-1"><?php echo esc_html($author->display_name); ?></h1>
            <?php if ($author->description) : ?>
            <p class="text-muted mb-2"><?php echo esc_html($author->description); ?></p>
            <?php endif; ?>
            <span class="badge bg-primary"><?php printf(esc_html__('%d Posts','zincelestial'), count_user_posts($author->ID)); ?></span>
          </div>
        </div>
      </div>
      <?php if ( have_posts() ) : ?>
        <div class="row g-4">
          <?php while(have_posts()) : the_post(); ?>
          <div class="col-12 col-md-6">
            <?php get_template_part('template-parts/content/content','post'); ?>
          </div>
          <?php endwhile; ?>
        </div>
        <?php the_posts_pagination(); ?>
      <?php else : ?>
        <?php get_template_part('template-parts/content/content','none'); ?>
      <?php endif; ?>
    </div>
    <div class="col-12 col-lg-3"><?php get_sidebar(); ?></div>
  </div>
</div>
<?php get_footer(); ?>
