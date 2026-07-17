<?php
/**
 * ZinCelestial v5.0.0 — BuddyPress Group: Single Home
 */
bp_nouveau_group_hook('before','home_content');
?>
<div id="buddypress" class="buddypress-wrap zc-bp-group-home">
  <?php if ( bp_nouveau_group_has_nav() ) : ?>
  <nav id="object-nav" class="zc-bp-group-nav mb-4">
    <ul class="nav nav-pills flex-wrap">
      <?php bp_nouveau_group_primary_nav(); ?>
    </ul>
  </nav>
  <?php endif; ?>
  <div id="group-nav-content">
    <?php bp_nouveau_group_secondary_nav(); ?>
  </div>
</div>
<?php bp_nouveau_group_hook('after','home_content'); ?>
