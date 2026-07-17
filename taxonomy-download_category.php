<?php get_header(); ?>
<div class="zc-layout zc-layout--right zc-container">
  <main id="primary" class="zc-main" role="main">
    <header class="zc-page-header">
      <?php the_archive_title('<h1 class="zc-page-header__title">','</h1>'); ?>
      <?php the_archive_description('<div class="zc-archive-description">','</div>'); ?>
    </header>
    <?php if(have_posts()): ?>
      <div class="zc-downloads-grid">
        <?php while(have_posts()): the_post(); get_template_part('template-parts/content/content-download'); endwhile; ?>
      </div>
      <?php the_posts_pagination(); ?>
    <?php else: ?><?php get_template_part('template-parts/content/content-none'); ?><?php endif; ?>
  </main>
  <aside id="sidebar-right" class="zc-sidebar zc-sidebar--right"><?php get_sidebar(); ?></aside>
</div>
<?php get_footer();
