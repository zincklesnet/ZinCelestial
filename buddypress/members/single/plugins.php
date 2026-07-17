<?php
/**
 * ZinCelestial v5.0.0 — BuddyPress Member Plugins Template
 * Catchall for third-party plugin sub-nav items
 */
bp_nouveau_member_hook('before','plugins_content');
do_action('bp_template_content');
bp_nouveau_member_hook('after','plugins_content');
