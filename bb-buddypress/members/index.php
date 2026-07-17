<?php
/**
 * ZinCelestial — BB-BuddyPress Members Directory (BuddyBoss compat)
 *
 * @package ZinCelestial
 */
defined( 'ABSPATH' ) || exit;
// Falls back to main buddypress members directory template
locate_template( [ 'buddypress/members/index.php' ], true );
