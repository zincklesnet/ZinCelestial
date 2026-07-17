<?php get_header(); ?>

<main class="zc-main py-4">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <?php while ( have_posts() ) : the_post(); ?>
                    <?php get_template_part( 'template-parts/content', 'single' ); ?>
                    <?php the_post_navigation(); ?>
                    <?php comments_template(); ?>
                <?php endwhile; ?>
            </div>
            <div class="col-lg-4">
                <?php get_sidebar(); ?>
            </div>
        </div>
    </div>
</main>

<?php get_footer(); ?>
