<?php
/**
 * ZinCelestial v5.0.0 — Right Side Panel
 */
if ( zc_option('enable_right_panel','0') !== '1' ) return;
?>
<div id="zc-right-panel" class="zc-right-panel d-none d-xl-flex flex-column">
  <div class="p-3">
    <?php if ( is_active_sidebar('zc-right-panel') ) : ?>
      <?php dynamic_sidebar('zc-right-panel'); ?>
    <?php else : ?>
    <h6 class="fw-bold mb-3"><?php esc_html_e('Suggested People','zincelestial'); ?></h6>
    <?php
    if ( function_exists('bp_has_members') && bp_has_members(['per_page'=>5]) ) :
      while (bp_members()) : bp_the_member(); ?>
      <div class="d-flex align-items-center gap-2 mb-3">
        <a href="<?php bp_member_permalink(); ?>"><?php bp_member_avatar(['width'=>36,'height'=>36,'class'=>'rounded-circle']); ?></a>
        <div class="flex-grow-1 min-w-0">
          <a href="<?php bp_member_permalink(); ?>" class="fw-semibold text-decoration-none text-truncate d-block"><?php bp_member_name(); ?></a>
          <span class="small text-muted"><?php bp_member_last_active(); ?></span>
        </div>
        <?php if ( function_exists('bp_add_friend_button') ) bp_add_friend_button(bp_get_member_user_id()); ?>
      </div>
      <?php endwhile;
    endif; ?>
    <?php endif; ?>
  </div>
</div>
