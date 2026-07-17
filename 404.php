<?php get_header(); ?>

<main class="zc-main py-5">
    <div class="container text-center">
        <h1 class="display-5 mb-3"><?php esc_html_e( 'Page not found', 'zincelestial' ); ?></h1>
        <p class="mb-4 text-muted">
            <?php esc_html_e( 'The page you are looking for doesn’t exist or has been moved.', 'zincelestial' ); ?>
        </p>
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-primary">
            <?php esc_html_e( 'Back to home', 'zincelestial' ); ?>
        </a>
    </div>
</main>

<?php get_footer(); ?>
