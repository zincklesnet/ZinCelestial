<?php
/**
 * ZinCelestial v5.0.0 — BuddyPress Groups Directory
 */
bp_nouveau_before_groups_directory_content();
?>
<div class="zc-bp-directory zc-groups-directory">
  <div class="zc-bp-dir-header d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
    <h1 class="h3 fw-bold mb-0">
      <i class="bi bi-collection me-2 text-primary"></i>
      <?php esc_html_e('Groups','zincelestial'); ?>
    </h1>
    <div class="d-flex gap-2 align-items-center">
      <?php if ( is_user_logged_in() && bp_user_can_create_groups() ) : ?>
      <a href="<?php echo esc_url( trailingslashit( bp_get_groups_directory_permalink() ) . 'create/' ); ?>"
         class="btn btn-primary btn-sm">
        <i class="bi bi-plus-circle me-1"></i><?php esc_html_e('Create Group','zincelestial'); ?>
      </a>
      <?php endif; ?>
    </div>
  </div>

  <div class="card border-0 shadow-sm mb-4 p-3">
    <div class="d-flex flex-wrap gap-2 align-items-center justify-content-between">
      <?php bp_nouveau_groups_secondary_nav(); ?>
      <div class="zc-dir-order ms-auto">
        <div class="input-group input-group-sm" style="width:200px;">
          <span class="input-group-text"><i class="bi bi-search"></i></span>
          <input type="search" class="form-control" placeholder="<?php esc_attr_e('Search Groups…','zincelestial'); ?>" id="groups-dir-search">
        </div>
      </div>
    </div>
  </div>

  <div id="buddypress" class="buddypress-wrap">
    <div class="groups" data-bp-list="groups">
      <?php bp_get_template_part('groups/list'); ?>
    </div>
  </div>
</div>
<?php bp_nouveau_after_groups_directory_content(); ?>
