<?php
/**
 * ZinCelestial v5.0.0 — BuddyPress Members Directory
 */
bp_nouveau_before_members_directory_content();
?>
<div class="zc-bp-directory zc-members-directory">
  <div class="zc-bp-dir-header d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
    <h1 class="h3 fw-bold mb-0">
      <i class="bi bi-people me-2 text-primary"></i>
      <?php esc_html_e('Members','zincelestial'); ?>
    </h1>
    <div class="d-flex gap-2 align-items-center">
      <div class="input-group input-group-sm zc-dir-search" style="width:220px;">
        <span class="input-group-text"><i class="bi bi-search"></i></span>
        <input type="search" class="form-control" placeholder="<?php esc_attr_e('Search Members…','zincelestial'); ?>" id="members-dir-search">
      </div>
    </div>
  </div>

  <div class="card border-0 shadow-sm mb-4 p-3">
    <div class="d-flex flex-wrap gap-2 align-items-center justify-content-between">
      <?php bp_nouveau_members_secondary_nav(); ?>
      <div class="zc-dir-order ms-auto">
        <?php bp_nouveau_sort_by_select(['newest','active','popular','alphabetical']); ?>
      </div>
    </div>
  </div>

  <div id="buddypress" class="buddypress-wrap">
    <div class="members" data-bp-list="members">
      <?php bp_get_template_part('members/list'); ?>
    </div>
  </div>
</div>
<?php bp_nouveau_after_members_directory_content(); ?>
