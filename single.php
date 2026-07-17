<?php
/**
 * ZinCelestial v5.0.0 — Single Post Template
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

        <article id="post-<?php the_ID(); ?>" <?php post_class('zc-single-post'); ?>>

          <?php if ( has_post_thumbnail() ) : ?>
          <div class="zc-hero-image mb-4 rounded-3 overflow-hidden">
            <?php the_post_thumbnail('zc-hero', ['class'=>'img-fluid w-100','loading'=>'eager']); ?>
          </div>
          <?php endif; ?>

          <header class="zc-entry-header mb-4">
            <?php zc_category_pill(); ?>
            <h1 class="zc-entry-title display-5 fw-bold mt-2"><?php the_title(); ?></h1>
            <div class="zc-entry-meta d-flex flex-wrap align-items-center gap-3 text-muted mt-2">
              <span><i class="bi bi-person me-1"></i>
                <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>"><?php the_author(); ?></a>
              </span>
              <span><i class="bi bi-calendar3 me-1"></i><?php echo esc_html(get_the_date()); ?></span>
              <?php if ( zc_option('show_read_time','0') === '1' ) : ?>
              <span><i class="bi bi-clock me-1"></i><?php echo esc_html(zc_read_time(get_the_ID())); ?></span>
              <?php endif; ?>
              <span><i class="bi bi-eye me-1"></i><?php echo esc_html(zc_format_count(zc_get_views(get_the_ID()))); ?></span>
            </div>
          </header>

          <div class="zc-entry-content entry-content">
            <?php the_content(); ?>
            <?php wp_link_pages(['before'=>'<div class="zc-page-links">','after'=>'</div>']); ?>
          </div>

          <footer class="zc-entry-footer mt-4 pt-3 border-top d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div class="zc-entry-tags">
              <?php the_tags('<span class="text-muted me-2"><i class="bi bi-tags"></i></span>','',''); ?>
            </div>
            <?php zc_sharing_bar(); ?>
          </footer>

        </article>

        <?php
        the_post_navigation([
            'prev_text' => '<span class="nav-subtitle text-muted"><i class="bi bi-chevron-left"></i> ' . __('Previous','zincelestial') . '</span><span class="nav-title">%title</span>',
            'next_text' => '<span class="nav-subtitle text-muted">' . __('Next','zincelestial') . ' <i class="bi bi-chevron-right"></i></span><span class="nav-title">%title</span>',
        ]);

        comments_template();
        ?>

      <?php endwhile; ?>
    </div>

    <?php if ( $layout === 'right' && is_active_sidebar('zc-sidebar-right') ) : ?>
    <div class="col-12 col-lg-3"><aside class="zc-sidebar"><?php dynamic_sidebar('zc-sidebar-right'); ?></aside></div>
    <?php endif; ?>

  </div>
</div>
<?php get_footer(); ?>
