<?php
/**
 * ZinCelestial v5.0.0 — BuddyPress Member Card
 */
?>
<li id="member-<?php bp_member_user_id(); ?>" <?php bp_member_class('zc-member-card card border-0 shadow-sm text-center'); ?>>
  <div class="card-body p-4">
    <div class="zc-member-avatar mb-3 position-relative d-inline-block">
      <a href="<?php bp_member_permalink(); ?>">
        <?php bp_member_avatar(['type'=>'full','width'=>72,'height'=>72,'class'=>'rounded-circle border border-3 border-primary-subtle']); ?>
      </a>
      <?php if ( function_exists('bp_member_is_online') && bp_member_is_online() ) : ?>
      <span class="position-absolute bottom-0 end-0 bg-success border border-2 border-white rounded-circle" style="width:14px;height:14px;"></span>
      <?php endif; ?>
    </div>
    <h3 class="h6 fw-bold mb-1">
      <a href="<?php bp_member_permalink(); ?>" class="text-decoration-none"><?php bp_member_name(); ?></a>
    </h3>
    <p class="small text-muted mb-3"><?php bp_member_last_active(); ?></p>
    <div class="d-flex justify-content-center gap-2">
      <?php bp_nouveau_members_loop_buttons(['container'=>'div','container_classes'=>'d-flex gap-2']); ?>
    </div>
  </div>
</li>
