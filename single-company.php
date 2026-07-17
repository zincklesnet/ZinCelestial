<?php get_header(); ?>
<div class="zc-layout zc-layout--right zc-container">
  <main id="primary" class="zc-main" role="main">
    <?php while(have_posts()): the_post(); ?>
      <article id="company-<?php the_ID(); ?>" <?php post_class('zc-company-single'); ?>>
        <header class="zc-article__header">
          <?php the_title('<h1 class="zc-article__title">','</h1>'); ?>
        </header>
        <?php if(has_post_thumbnail()): ?><div class="zc-article__hero"><?php the_post_thumbnail('full',array('class'=>'zc-article__hero-img')); ?></div><?php endif; ?>
        <div class="zc-article__content entry-content"><?php the_content(); ?></div>
      </article>
    <?php endwhile; ?>
  </main>
  <aside id="sidebar-right" class="zc-sidebar zc-sidebar--right"><?php get_sidebar(); ?></aside>
</div>
<?php get_footer();
