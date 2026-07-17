<?php
/**
 * ZinCelestial v5.0.0 — BuddyPress Member Profile: Single Home
 */
bp_nouveau_member_hook('before','home_content');
?>
<div id="buddypress" class="buddypress-wrap zc-bp-member-home">
  <?php if ( bp_nouveau_member_has_nav() ) : ?>
  <nav id="object-nav" class="zc-bp-profile-nav mb-4" aria-label="<?php esc_attr_e('Member navigation','zincelestial'); ?>">
    <ul class="nav nav-pills flex-wrap" role="tablist">
      <?php bp_nouveau_member_primary_nav(); ?>
    </ul>
  </nav>
  <?php endif; ?>

  <div class="row g-4">
    <div class="col-12 col-lg-9">
      <div id="member-nav-content">
        <?php bp_nouveau_member_secondary_nav(); ?>
      </div>
    </div>
  </div>
</div>
<?php bp_nouveau_member_hook('after','home_content'); ?>
