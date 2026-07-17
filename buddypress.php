<?php
/**
 * ZinCelestial v5.0.0 — BuddyPress Page Template
 *
 * BUG FIX #10: This file is required. Without it BP pages render blank.
 * It provides the wrapper for ALL BP pages (members, groups, activity, etc.)
 * The actual content is rendered by bp_content() which calls the BP template stack.
 */
get_header();
?>
<div class="container-fluid zc-content-wrapper zc-bp-page px-3 px-lg-4 py-4">
  <div class="row g-0">

    <?php do_action( 'zc_before_bp_content' ); ?>

    <div class="col-12">
      <?php
      /* Primary BuddyPress content — calls BP template stack */
      if ( function_exists( 'bp_content' ) ) {
          bp_content();
      } else {
          while ( have_posts() ) {
              the_post();
              the_content();
          }
      }
      ?>
    </div>

    <?php do_action( 'zc_after_bp_content' ); ?>

  </div>
</div>
<?php get_footer(); ?>
