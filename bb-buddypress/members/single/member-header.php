<?php
/**
 * ZinCelestial — BB-BuddyPress Member Header (BuddyBoss compat)
 * Falls back to standard BP member header template.
 *
 * @package ZinCelestial
 */
defined( 'ABSPATH' ) || exit;
locate_template( [ 'buddypress/members/single/member-header.php' ], true );
