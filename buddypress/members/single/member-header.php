<?php
/**
 * ZinCelestial v5.0.0 — BuddyPress Member Profile Header
 */
?>
<div class="zc-bp-member-header position-relative mb-5">
  <!-- Cover Photo -->
  <div class="zc-member-cover rounded-3 overflow-hidden" style="height:220px;background:var(--zc-gradient-primary);">
    <?php if ( function_exists('bp_displayed_user_use_cover_image_header') && bp_displayed_user_use_cover_image_header() ) : ?>
    <?php bp_displayed_user_cover_image(['class'=>'w-100 h-100 object-fit-cover']); ?>
    <?php endif; ?>
  </div>
  <!-- Avatar + Info Strip -->
  <div class="zc-member-header-info container-fluid px-4">
    <div class="d-flex align-items-end gap-4 mt-n4">
      <div class="zc-member-avatar-wrap flex-shrink-0">
        <div class="border border-4 border-body rounded-circle overflow-hidden" style="width:100px;height:100px;">
          <?php bp_displayed_user_avatar(['type'=>'full','width'=>96,'height'=>96,'class'=>'w-100 h-100 object-fit-cover']); ?>
        </div>
      </div>
      <div class="flex-grow-1 pb-1">
        <div class="d-flex align-items-center gap-2 flex-wrap">
          <h1 class="h3 fw-bold mb-0"><?php bp_displayed_user_fullname(); ?></h1>
          <?php do_action('zc_after_member_name'); ?>
        </div>
        <p class="text-muted small mb-0">
          <?php esc_html_e('Member since','zincelestial'); ?> <?php echo esc_html(bp_get_member_registered(bp_get_displayed_user_id())); ?>
          &nbsp;·&nbsp;
          <?php bp_last_activity(bp_displayed_user_id()); ?>
        </p>
      </div>
      <div class="ms-auto pb-1 d-flex gap-2 flex-wrap">
        <?php bp_nouveau_member_header_buttons(['container'=>'div','container_classes'=>'d-flex gap-2']); ?>
      </div>
    </div>
  </div>
</div>
