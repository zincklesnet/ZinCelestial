<?php defined('ABSPATH')||exit; ?>
<?php if(bp_has_groups(bp_ajax_querystring('groups'))): ?>
<div class="row g-4" id="groups-list">
  <?php while(bp_groups()): bp_the_group(); ?>
  <div class="col-12 col-md-6 col-lg-4">
    <div class="card h-100 shadow-sm zc-group-card">
      <?php if(bp_get_group_has_avatar()): ?>
      <div class="position-relative" style="height:120px;overflow:hidden;">
        <img src="<?php bp_group_avatar(['object'=>'group','type'=>'full','width'=>600,'height'=>120]); ?>" class="card-img-top w-100 h-100 object-fit-cover" alt="">
      </div>
      <?php endif; ?>
      <div class="card-body">
        <div class="d-flex gap-3 mb-3">
          <?php bp_group_avatar(['type'=>'thumb','width'=>56,'height'=>56,'class'=>'rounded-circle border border-2 border-primary flex-shrink-0']); ?>
          <div>
            <h5 class="card-title mb-1">
              <a href="<?php bp_group_permalink(); ?>" class="text-decoration-none stretched-link">
                <?php bp_group_name(); ?>
              </a>
            </h5>
            <span class="badge bg-<?php echo bp_get_group_type()==='public'?'success':(bp_get_group_type()==='private'?'warning':'secondary'); ?>">
              <?php bp_group_type(); ?>
            </span>
          </div>
        </div>
        <p class="card-text small text-muted"><?php bp_group_description_excerpt(); ?></p>
      </div>
      <div class="card-footer d-flex justify-content-between align-items-center text-muted small">
        <span><i class="bi bi-people me-1"></i><?php bp_group_member_count(); ?></span>
        <?php if(is_user_logged_in()): ?>
        <div class="position-relative" style="z-index:2"><?php bp_group_join_button(); ?></div>
        <?php endif; ?>
      </div>
    </div>
  </div>
  <?php endwhile; ?>
</div>
<div class="zc-bp-pagination mt-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
  <div class="text-muted small"><?php bp_groups_pagination_count(); ?></div>
  <nav><?php bp_groups_pagination_links(); ?></nav>
</div>
<?php else: ?>
<div class="alert alert-info"><i class="bi bi-info-circle me-2"></i><?php esc_html_e('No groups found.','zincelestial'); ?></div>
<?php endif; ?>
