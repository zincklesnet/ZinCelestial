<?php
/**
 * ZinCelestial v5.0.0 — BuddyPress Group Header
 */
?>
<div class="zc-bp-group-header position-relative mb-5">
  <div class="zc-group-cover rounded-3 overflow-hidden" style="height:220px;background:var(--zc-gradient-primary);">
    <?php if ( function_exists('bp_group_use_cover_image_header') && bp_group_use_cover_image_header() ) : ?>
    <?php bp_group_cover_image(['class'=>'w-100 h-100 object-fit-cover']); ?>
    <?php endif; ?>
  </div>
  <div class="zc-group-header-info container-fluid px-4">
    <div class="d-flex align-items-end gap-4 mt-n4">
      <div class="zc-group-avatar-wrap flex-shrink-0">
        <div class="border border-4 border-body rounded-3 overflow-hidden" style="width:96px;height:96px;">
          <?php bp_current_group_avatar(['type'=>'full','width'=>88,'height'=>88,'class'=>'w-100 h-100 object-fit-cover']); ?>
        </div>
      </div>
      <div class="flex-grow-1 pb-1">
        <h1 class="h3 fw-bold mb-1"><?php bp_current_group_name(); ?></h1>
        <div class="d-flex flex-wrap gap-3 small text-muted">
          <span><i class="bi bi-people me-1"></i><?php bp_group_member_count(); ?></span>
          <span><i class="bi bi-shield me-1"></i><?php bp_group_status(); ?></span>
          <span><i class="bi bi-clock me-1"></i><?php bp_group_last_active(); ?></span>
        </div>
      </div>
      <div class="ms-auto pb-1 d-flex gap-2">
        <?php bp_nouveau_group_header_buttons(['container'=>'div','container_classes'=>'d-flex gap-2']); ?>
      </div>
    </div>
  </div>
</div>
