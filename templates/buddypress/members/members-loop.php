<?php defined('ABSPATH')||exit; ?>
<?php if(bp_has_members(bp_ajax_querystring('members'))): ?>
<div class="row g-4 zc-members-grid" id="member-list">
  <?php while(bp_members()): bp_the_member(); ?>
  <div class="col-6 col-md-4 col-lg-3 zc-member-col">
    <div class="card h-100 shadow-sm text-center zc-member-card position-relative">

      <?php if(function_exists('bp_is_user_online') && bp_is_user_online(bp_get_member_user_id())): ?>
      <span class="position-absolute top-0 end-0 translate-middle badge rounded-pill bg-success m-2" style="font-size:.6rem">●</span>
      <?php endif; ?>

      <div class="card-body py-4">
        <a href="<?php bp_member_permalink(); ?>" class="d-block mb-3">
          <?php bp_member_avatar(['type'=>'full','width'=>80,'height'=>80,'class'=>'rounded-circle border border-2 border-primary']); ?>
        </a>
        <h5 class="card-title mb-1">
          <a href="<?php bp_member_permalink(); ?>" class="text-decoration-none stretched-link">
            <?php bp_member_name(); ?>
            <?php if(function_exists('zc_bp_is_verified') && zc_bp_is_verified(bp_get_member_user_id())): ?>
            <i class="bi bi-patch-check-fill text-primary ms-1" style="font-size:.85rem" title="<?php esc_attr_e('Verified','zincelestial'); ?>"></i>
            <?php endif; ?>
          </a>
        </h5>
        <p class="text-muted small mb-2"><?php bp_member_last_active(); ?></p>

        <?php if(bp_get_member_latest_update()): ?>
        <p class="card-text small fst-italic text-truncate px-2"><?php bp_member_latest_update(); ?></p>
        <?php endif; ?>

        <?php if(is_user_logged_in() && bp_is_active('friends')): ?>
        <div class="mt-3 position-relative" style="z-index:2">
          <?php bp_add_friend_button(bp_get_member_user_id()); ?>
        </div>
        <?php endif; ?>
      </div>

      <?php if(bp_get_member_total_friend_count()): ?>
      <div class="card-footer text-muted small py-2">
        <i class="bi bi-people me-1"></i><?php bp_member_total_friend_count(); ?> <?php esc_html_e('friends','zincelestial'); ?>
      </div>
      <?php endif; ?>
    </div>
  </div>
  <?php endwhile; ?>
</div><!-- .zc-members-grid -->
<div class="zc-bp-pagination mt-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
  <div class="text-muted small"><?php bp_members_pagination_count(); ?></div>
  <nav><?php bp_members_pagination_links(); ?></nav>
</div>
<?php else: ?>
<div class="alert alert-info"><i class="bi bi-info-circle me-2"></i><?php esc_html_e('No members found.','zincelestial'); ?></div>
<?php endif; ?>
