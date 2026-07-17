<?php
/**
 * ZinCelestial v4.0 — BuddyPress Groups Directory
 */
defined('ABSPATH') || exit;
get_header();
?>
<div class="zc-bp-page">
  <div class="container py-4">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
      <h1 class="h2 mb-0">
        <i class="bi bi-collection-fill me-2 text-primary"></i>
        <?php esc_html_e('Groups','zincelestial'); ?>
      </h1>
      <?php if(is_user_logged_in()): ?>
      <a href="<?php echo esc_url(bp_get_groups_directory_permalink().'create/'); ?>" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-circle me-1"></i><?php esc_html_e('Create Group','zincelestial'); ?>
      </a>
      <?php endif; ?>
    </div>

    <!-- Filter -->
    <div class="card shadow-sm mb-4">
      <div class="card-body py-3">
        <div class="row g-2">
          <div class="col-md-7"><?php bp_directory_groups_search_form(); ?></div>
          <div class="col-md-3">
            <select class="form-select form-select-sm" onchange="bp_filter_request('groups','filter',this.value,0)">
              <option value="active"><?php esc_html_e('Recently Active','zincelestial'); ?></option>
              <option value="popular"><?php esc_html_e('Most Members','zincelestial'); ?></option>
              <option value="newest"><?php esc_html_e('Newest','zincelestial'); ?></option>
              <option value="alphabetical"><?php esc_html_e('Alphabetical','zincelestial'); ?></option>
            </select>
          </div>
        </div>
      </div>
    </div>

    <div id="groups-dir-list" class="groups">
      <?php bp_get_template_part('groups/groups-loop'); ?>
    </div>
  </div>
</div>
<?php get_footer(); ?>
