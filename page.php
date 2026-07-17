<?php
/**
 * ZinCelestial v5.0.0 — Page Template
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
      <?php while ( have_posts() ) : the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class('zc-page-article'); ?>>
          <?php if ( ! is_front_page() ) : ?>
          <header class="zc-entry-header mb-4">
            <h1 class="zc-entry-title display-5 fw-bold"><?php the_title(); ?></h1>
          </header>
          <?php endif; ?>
          <div class="zc-entry-content entry-content">
            <?php the_content(); ?>
            <?php wp_link_pages(['before'=>'<div class="zc-page-links">','after'=>'</div>']); ?>
          </div>
        </article>
        <?php if ( comments_open() || get_comments_number() ) comments_template(); ?>
      <?php endwhile; ?>
    </div>

    <?php if ( $layout === 'right' && is_active_sidebar('zc-sidebar-right') ) : ?>
    <div class="col-12 col-lg-3"><aside class="zc-sidebar"><?php dynamic_sidebar('zc-sidebar-right'); ?></aside></div>
    <?php endif; ?>

  </div>
</div>
<?php get_footer(); ?>
