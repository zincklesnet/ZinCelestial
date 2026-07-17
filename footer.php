<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>

<footer class="zc-footer mt-5 py-4 bg-light border-top">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <p class="mb-0">
                    &copy; <?php echo esc_html( date( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?> — ZinCelestial by Zinckles.
                </p>
            </div>
            <div class="col-md-6 text-md-end">
                <?php
                wp_nav_menu( [
                    'theme_location' => 'footer',
                    'container'      => false,
                    'menu_class'     => 'zc-footer-nav list-inline mb-0',
                    'fallback_cb'    => false,
                ] );
                ?>
            </div>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
