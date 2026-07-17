<?php get_header(); ?>
<div class="zc-layout zc-layout--right zc-container">
  <main id="primary" class="zc-main" role="main">
    <?php while(have_posts()): the_post(); ?>
      <article id="sfwd-group-<?php the_ID(); ?>" <?php post_class('zc-sfwd-group-single'); ?>>
        <header class="zc-article__header"><?php the_title('<h1 class="zc-article__title">','</h1>'); ?></header>
        <div class="zc-article__content entry-content"><?php the_content(); ?></div>
        <?php do_action('zc_after_sfwd_group_content', get_the_ID()); ?>
      </article>
    <?php endwhile; ?>
  </main>
  <aside id="sidebar-right" class="zc-sidebar zc-sidebar--right"><?php get_sidebar(); ?></aside>
</div>
<?php get_footer();
