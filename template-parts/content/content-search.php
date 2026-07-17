<?php
/**
 * ZinCelestial v5.0.0 — Search Result Item
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('zc-search-result d-flex gap-3 p-3 rounded-3 border mb-3'); ?>>
  <?php if ( has_post_thumbnail() ) : ?>
  <div class="flex-shrink-0" style="width:80px;height:80px;">
    <a href="<?php the_permalink(); ?>">
      <?php the_post_thumbnail('thumbnail', ['class'=>'rounded-2 w-100 h-100 object-fit-cover']); ?>
    </a>
  </div>
  <?php endif; ?>
  <div class="flex-grow-1">
    <h3 class="h6 fw-bold mb-1"><a href="<?php the_permalink(); ?>" class="text-decoration-none"><?php the_title(); ?></a></h3>
    <p class="small text-muted mb-1"><?php echo esc_html(wp_trim_words(get_the_excerpt(),15)); ?></p>
    <span class="small text-muted"><i class="bi bi-calendar3 me-1"></i><?php echo esc_html(get_the_date()); ?></span>
  </div>
</article>
