<?php
/**
 * ZinCelestial v4.0 — BuddyPress Members Directory
 * BS5 responsive card grid with search, filter, pagination.
 */
defined('ABSPATH') || exit;
get_header();
?>
<div class="zc-bp-page">
  <div class="container py-4">

    <!-- Page header -->
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
      <h1 class="h2 mb-0">
        <i class="bi bi-people-fill me-2 text-primary"></i>
        <?php esc_html_e('Members','zincelestial'); ?>
        <?php if(bp_get_total_member_count()): ?>
        <span class="badge bg-secondary fw-normal fs-6 ms-2"><?php echo esc_html(bp_get_total_member_count()); ?></span>
        <?php endif; ?>
      </h1>
      <div class="d-flex gap-2 flex-wrap">
        <?php if(bp_is_active('friends') && is_user_logged_in()): ?>
        <a href="<?php echo esc_url(bp_loggedin_user_domain().'friends/'); ?>" class="btn btn-outline-primary btn-sm">
          <i class="bi bi-person-heart me-1"></i><?php esc_html_e('My Friends','zincelestial'); ?>
        </a>
        <?php endif; ?>
      </div>
    </div>

    <!-- Search + filter bar -->
    <div class="card shadow-sm mb-4">
      <div class="card-body py-3">
        <div class="row g-2 align-items-end">
          <div class="col-md-6">
            <?php bp_directory_members_search_form(); ?>
          </div>
          <div class="col-md-4">
            <select id="members-order-by" class="form-select form-select-sm" onchange="bp_filter_request('members','filter',this.value,0)">
              <option value="active"  <?php selected(bp_get_members_component_link(), 'active'); ?>><?php esc_html_e('Recently Active','zincelestial'); ?></option>
              <option value="newest"  <?php selected(bp_get_members_component_link(), 'newest'); ?>><?php esc_html_e('Newest Members','zincelestial'); ?></option>
              <option value="popular" <?php selected(bp_get_members_component_link(), 'popular'); ?>><?php esc_html_e('Most Friends','zincelestial'); ?></option>
            </select>
          </div>
          <div class="col-md-2 text-end">
            <div class="btn-group btn-group-sm" role="group">
              <button class="btn btn-outline-secondary active" id="zc-grid-view" title="<?php esc_attr_e('Grid view','zincelestial'); ?>"><i class="bi bi-grid-3x3-gap-fill"></i></button>
              <button class="btn btn-outline-secondary" id="zc-list-view" title="<?php esc_attr_e('List view','zincelestial'); ?>"><i class="bi bi-list-ul"></i></button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Members list -->
    <div id="members-dir-list" class="zc-bp-members-dir members">
      <?php bp_get_template_part('members/members-loop'); ?>
    </div>

  </div><!-- .container -->
</div><!-- .zc-bp-page -->
<script>
document.getElementById('zc-grid-view')?.addEventListener('click',function(){
  document.getElementById('members-dir-list')?.classList.remove('zc-bp-list-view');
  this.classList.add('active');
  document.getElementById('zc-list-view')?.classList.remove('active');
});
document.getElementById('zc-list-view')?.addEventListener('click',function(){
  document.getElementById('members-dir-list')?.classList.add('zc-bp-list-view');
  this.classList.add('active');
  document.getElementById('zc-grid-view')?.classList.remove('active');
});
</script>
<?php get_footer(); ?>
