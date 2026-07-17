<?php
/**
 * ZinCelestial v4.0 — BuddyPress Activity Directory
 */
defined('ABSPATH') || exit;
get_header();
?>
<div class="zc-bp-page">
  <div class="container py-4">
    <div class="row g-4">

      <!-- Main Activity Feed -->
      <div class="col-12 col-lg-8">
        <div class="d-flex align-items-center justify-content-between mb-3">
          <h1 class="h3 mb-0"><i class="bi bi-activity me-2 text-primary"></i><?php esc_html_e('Activity','zincelestial'); ?></h1>
        </div>

        <!-- Activity Scope Nav -->
        <ul class="nav nav-pills mb-4 zc-bp-activity-nav" id="activity-filter-links">
          <li class="nav-item">
            <a class="nav-link active" href="<?php echo esc_url(bp_get_activity_directory_permalink()); ?>" data-bp-scope="all">
              <?php esc_html_e('All','zincelestial'); ?>
            </a>
          </li>
          <?php if(is_user_logged_in()): ?>
          <li class="nav-item">
            <a class="nav-link" href="#" data-bp-scope="friends">
              <?php esc_html_e('Friends','zincelestial'); ?>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#" data-bp-scope="groups">
              <?php esc_html_e('Groups','zincelestial'); ?>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#" data-bp-scope="mentions">
              <?php esc_html_e('@Mentions','zincelestial'); ?>
            </a>
          </li>
          <?php endif; ?>
        </ul>

        <!-- Post Form -->
        <?php if(is_user_logged_in() && zc_option('show_compose_bar','1') !== '1'): ?>
        <div class="card shadow-sm mb-4">
          <div class="card-body">
            <?php bp_activity_post_form(); ?>
          </div>
        </div>
        <?php endif; ?>

        <!-- Activity List -->
        <div id="activity-stream" class="zc-activity-stream">
          <?php bp_get_template_part('activity/activity-loop'); ?>
        </div>
      </div><!-- .col-lg-8 -->

      <!-- Sidebar -->
      <div class="col-12 col-lg-4">
        <!-- Who's Online -->
        <?php if(function_exists('bp_whos_online_widget')): ?>
        <div class="card shadow-sm mb-4">
          <div class="card-header fw-semibold"><i class="bi bi-circle-fill text-success me-2" style="font-size:.6rem"></i><?php esc_html_e("Who's Online",'zincelestial'); ?></div>
          <div class="card-body"><?php bp_whos_online_widget(); ?></div>
        </div>
        <?php endif; ?>
        <!-- Recently Active -->
        <div class="card shadow-sm mb-4">
          <div class="card-header fw-semibold"><i class="bi bi-clock-history me-2"></i><?php esc_html_e('Recently Active','zincelestial'); ?></div>
          <div class="card-body">
            <?php if(bp_has_members(['type'=>'active','per_page'=>10])): ?>
            <div class="d-flex flex-wrap gap-2">
              <?php while(bp_members()): bp_the_member(); ?>
              <a href="<?php bp_member_permalink(); ?>" data-bs-toggle="tooltip" title="<?php bp_member_name(); ?>">
                <?php bp_member_avatar(['type'=>'thumb','width'=>36,'height'=>36,'class'=>'rounded-circle']); ?>
              </a>
              <?php endwhile; ?>
            </div>
            <?php endif; ?>
          </div>
        </div>
        <!-- Sidebar widgets -->
        <?php if(is_active_sidebar('zc-buddypress-sidebar')): ?>
        <div class="zc-bp-sidebar-widgets">
          <?php dynamic_sidebar('zc-buddypress-sidebar'); ?>
        </div>
        <?php endif; ?>
      </div><!-- .col-lg-4 -->

    </div><!-- .row -->
  </div><!-- .container -->
</div><!-- .zc-bp-page -->
<?php get_footer(); ?>
