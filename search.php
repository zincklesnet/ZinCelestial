<?php get_header(); ?>

<main class="zc-main py-4">
    <div class="container">
        <header class="mb-4">
            <h1 class="h3">
                <?php printf( esc_html__( 'Search results for: %s', 'zincelestial' ), get_search_query() ); ?>
            </h1>
        </header>

        <div class="row">
            <div class="col-lg-8">
                <?php if ( have_posts() ) : ?>
                    <?php while ( have_posts() ) : the_post(); ?>
                        <?php get_template_part( 'template-parts/content', get_post_type() ); ?>
                    <?php endwhile; ?>

                    <?php the_posts_pagination(); ?>
                <?php else : ?>
                    <?php get_template_part( 'template-parts/content', 'none' ); ?>
                <?php endif; ?>
            </div>
            <div class="col-lg-4">
                <?php get_sidebar(); ?>
            </div>
        </div>
    </div>
</main>

<?php get_footer(); ?>
