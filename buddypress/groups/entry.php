<?php
/**
 * ZinCelestial v5.0.0 — BuddyPress Group Card
 */
?>
<li id="group-<?php bp_group_id(); ?>" <?php bp_group_class('zc-group-card card border-0 shadow-sm'); ?>>
  <div class="card-body p-4">
    <div class="d-flex gap-3 align-items-start">
      <a href="<?php bp_group_permalink(); ?>" class="flex-shrink-0">
        <?php bp_group_avatar(['type'=>'full','width'=>64,'height'=>64,'class'=>'rounded-3']); ?>
      </a>
      <div class="flex-grow-1 min-w-0">
        <h3 class="h6 fw-bold mb-1">
          <a href="<?php bp_group_permalink(); ?>" class="text-decoration-none"><?php bp_group_name(); ?></a>
          <?php if ( 'public' !== bp_get_group_status() ) : ?>
          <span class="badge bg-secondary ms-1 small"><?php bp_group_status(); ?></span>
          <?php endif; ?>
        </h3>
        <p class="small text-muted mb-2 text-truncate"><?php bp_group_description_excerpt(); ?></p>
        <div class="d-flex flex-wrap gap-2 small text-muted">
          <span><i class="bi bi-people me-1"></i><?php bp_group_member_count(); ?></span>
          <span><i class="bi bi-clock me-1"></i><?php bp_group_last_active(); ?></span>
        </div>
      </div>
    </div>
    <div class="mt-3 pt-2 border-top d-flex gap-2">
      <?php bp_nouveau_groups_loop_buttons(['container'=>'div','container_classes'=>'d-flex gap-2']); ?>
    </div>
  </div>
</li>
