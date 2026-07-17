<?php
/**
 * ZinCelestial v5.2.0 — Main Index Template
 *
 * FIX #22: Blog loop only renders on blog/archive pages.
 *  - is_home()       → main blog page
 *  - is_archive()    → category/tag/date/author archives
 *  - is_search()     → search results
 * All other contexts (static front page, BuddyPress, WC) have their own templates.
 */
get_header();

$layout = zc_option( 'sidebar_layout', 'right' );
?>
<div class="container-fluid zc-content-wrapper px-3 px-lg-4 py-4">
  <div class="row g-4 <?php echo $layout === 'none' ? 'justify-content-center' : ''; ?>">

    <?php if ( $layout === 'left' && is_active_sidebar( 'zc-sidebar-left' ) ) : ?>
    <div class="col-12 col-lg-3 zc-sidebar-col">
      <?php get_sidebar( 'left' ); ?>
    </div>
    <?php endif; ?>

    <div class="col-12 <?php echo $layout !== 'none' ? 'col-lg-9' : 'col-lg-10'; ?> zc-main-col">

      <?php if ( is_home() || is_archive() || is_search() ) : ?>
        <?php if ( have_posts() ) : ?>
          <?php if ( is_home() && ! is_front_page() ) : ?>
          <div class="zc-blog-header mb-4">
            <h1 class="zc-page-title"><?php single_post_title( '', true ); ?></h1>
          </div>
          <?php endif; ?>

          <div class="row g-4 zc-post-grid">
            <?php while ( have_posts() ) : the_post(); ?>
              <div class="col-12 col-md-6 col-xl-4">
                <?php get_template_part( 'template-parts/content/content', 'post' ); ?>
              </div>
            <?php endwhile; ?>
          </div>

          <div class="zc-pagination mt-5">
            <?php
            the_posts_pagination( [
                'mid_size'  => 2,
                'prev_text' => '<i class="bi bi-chevron-left"></i> ' . __( 'Previous', 'zincelestial' ),
                'next_text' => __( 'Next', 'zincelestial' ) . ' <i class="bi bi-chevron-right"></i>',
            ] );
            ?>
          </div>

        <?php else : ?>
          <?php get_template_part( 'template-parts/content/content', 'none' ); ?>
        <?php endif; ?>

      <?php elseif ( is_front_page() ) : ?>
        <?php
        // Static front page — show page content, NOT blog loop
        while ( have_posts() ) :
            the_post();
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class( 'zc-front-page' ); ?>>
              <div class="entry-content">
                <?php the_content(); ?>
              </div>
            </article>
        <?php endwhile; ?>

      <?php else : ?>
        <?php
        // Fallback — any other page context
        while ( have_posts() ) :
            the_post();
            get_template_part( 'template-parts/content/content', 'post' );
        endwhile;
        ?>
      <?php endif; ?>

    </div>

    <?php if ( $layout === 'right' && is_active_sidebar( 'zc-sidebar-right' ) ) : ?>
    <div class="col-12 col-lg-3 zc-sidebar-col">
      <?php get_sidebar(); ?>
    </div>
    <?php endif; ?>

  </div>
</div>
<?php get_footer(); ?>
