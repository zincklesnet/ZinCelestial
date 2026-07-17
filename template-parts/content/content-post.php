<?php
/**
 * ZinCelestial v5.0.0 — Content Post Card
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('zc-post-card card h-100 border-0 shadow-sm'); ?>>
  <?php if ( has_post_thumbnail() ) : ?>
  <a href="<?php the_permalink(); ?>" class="zc-post-card-img overflow-hidden" style="height:200px;">
    <?php the_post_thumbnail('zc-card', ['class'=>'card-img-top w-100 h-100 object-fit-cover','loading'=>'lazy']); ?>
  </a>
  <?php endif; ?>
  <div class="card-body d-flex flex-column p-4">
    <div class="zc-post-meta d-flex align-items-center gap-2 mb-2 small text-muted">
      <?php zc_category_pill(); ?>
      <span><i class="bi bi-clock me-1"></i><?php echo esc_html(get_the_date()); ?></span>
    </div>
    <h2 class="card-title h5 fw-bold mb-2">
      <a href="<?php the_permalink(); ?>" class="text-decoration-none stretched-link"><?php the_title(); ?></a>
    </h2>
    <p class="card-text text-muted small mb-3 flex-grow-1"><?php echo esc_html(wp_trim_words(get_the_excerpt(), 20)); ?></p>
    <div class="zc-post-footer d-flex align-items-center gap-3 small text-muted mt-auto pt-2 border-top">
      <?php echo get_avatar(get_the_author_meta('ID'), 24, '', '', ['class'=>'rounded-circle']); ?>
      <span><?php the_author(); ?></span>
      <span class="ms-auto"><i class="bi bi-chat me-1"></i><?php comments_number('0','1','%'); ?></span>
    </div>
  </div>
</article>
