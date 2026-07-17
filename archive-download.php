<?php get_header(); $layout = zc_sidebar_layout(); ?>
<div class="zc-layout zc-layout--<?php echo esc_attr($layout); ?> zc-container">
  <?php if(in_array($layout,array('left','both'))): ?><aside id="sidebar-left" class="zc-sidebar zc-sidebar--left"><?php get_sidebar('left'); ?></aside><?php endif; ?>
  <main id="primary" class="zc-main" role="main">
    <header class="zc-page-header"><h1 class="zc-page-header__title"><?php esc_html_e('Downloads','zincelestial'); ?></h1></header>
    <?php if(have_posts()): ?>
      <div class="zc-downloads-grid">
        <?php while(have_posts()): the_post(); get_template_part('template-parts/content/content-download'); endwhile; ?>
      </div>
      <?php the_posts_pagination(); ?>
    <?php else: ?><?php get_template_part('template-parts/content/content-none'); ?><?php endif; ?>
  </main>
  <?php if(in_array($layout,array('right','both'))): ?><aside id="sidebar-right" class="zc-sidebar zc-sidebar--right"><?php get_sidebar(); ?></aside><?php endif; ?>
</div>
<?php get_footer();
