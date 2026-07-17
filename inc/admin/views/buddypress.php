<?php if(!defined('ABSPATH'))exit;
$opts = get_option('zincelestial_options', zc_default_options());
function zca_obp($o,$k,$f=''){return isset($o[$k])?$o[$k]:$f;}
$bp_active = function_exists('buddypress');
?>
<div class="zca-wrap">
<div class="zca-page-header">
  <div class="zca-page-header__left">
    <div class="zca-page-header__icon">👥</div>
    <div><div class="zca-page-header__title">BuddyPress</div>
    <div class="zca-page-header__sub">Members, activity, groups, profiles, and social features</div></div>
  </div>
  <div class="zca-page-header__right">
    <?php if($bp_active): ?>
    <span class="zca-badge" style="background:rgba(52,211,153,0.2);color:#34d399;border:1px solid rgba(52,211,153,0.35);">● BuddyPress Active</span>
    <?php else: ?>
    <span class="zca-badge" style="background:rgba(248,113,113,0.2);color:#f87171;border:1px solid rgba(248,113,113,0.35);">⚠ BuddyPress Inactive</span>
    <?php endif; ?>
  </div>
</div>
<div class="zca-content">
<?php if(!$bp_active): ?>
<div class="zca-notice zca-notice--warning"><span class="zca-notice__icon">⚠</span><div><div class="zca-notice__title">BuddyPress Not Active</div>Install and activate the BuddyPress plugin to use these settings.</div></div>
<?php endif; ?>

  <div class="zca-tabs-nav">
    <button class="zca-tab-btn" data-zc-tab="members"><span class="zca-tab-icon">👤</span> Members</button>
    <button class="zca-tab-btn" data-zc-tab="activity"><span class="zca-tab-icon">📰</span> Activity</button>
    <button class="zca-tab-btn" data-zc-tab="groups"><span class="zca-tab-icon">🏘</span> Groups</button>
    <button class="zca-tab-btn" data-zc-tab="profile"><span class="zca-tab-icon">🪪</span> Profiles</button>
    <button class="zca-tab-btn" data-zc-tab="messages"><span class="zca-tab-icon">💬</span> Messages</button>
  </div>
  <div class="zca-tab-panels">

    <!-- Members -->
    <div class="zca-tab-panel" data-zc-panel="members">
      <div class="zca-grid zca-grid--2">
        <div class="zca-card">
          <div class="zca-card__header"><div class="zca-card__icon">👤</div><span class="zca-card__title">Member Display</span></div>
          <div class="zca-field">
            <label class="zca-label">Members Per Page</label>
            <div class="zca-slider-wrap">
              <input type="range" class="zca-slider" name="bp_members_per_page" data-option="bp_members_per_page" min="4" max="60" value="<?php echo esc_attr(zca_obp($opts,'bp_members_per_page','20')); ?>" data-unit="">
              <span class="zca-slider-value"><?php echo esc_attr(zca_obp($opts,'bp_members_per_page','20')); ?></span>
            </div>
          </div>
          <div class="zca-field">
            <label class="zca-label">Default Members View</label>
            <select class="zca-select" name="bp_members_default_view" data-option="bp_members_default_view">
              <option value="grid" <?php selected(zca_obp($opts,'bp_members_default_view','grid'),'grid'); ?>>Grid (Cards)</option>
              <option value="list" <?php selected(zca_obp($opts,'bp_members_default_view','grid'),'list'); ?>>List</option>
            </select>
          </div>
          <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Show Verified Badge</div><div class="zca-toggle-row__desc">Display ✓ verified icon on verified member profiles</div></div><label class="zca-toggle"><input type="checkbox" name="bp_show_verified_badge" data-option="bp_show_verified_badge" <?php checked(zca_obp($opts,'bp_show_verified_badge','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
          <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Show Online Status</div><div class="zca-toggle-row__desc">Green dot indicator for recently active users</div></div><label class="zca-toggle"><input type="checkbox" name="bp_show_online_status" data-option="bp_show_online_status" <?php checked(zca_obp($opts,'bp_show_online_status','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
          <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Show GamiPress Points on Card</div><div class="zca-toggle-row__desc">Display ZCreds/Rubies on member card</div></div><label class="zca-toggle"><input type="checkbox" name="bp_show_points_on_card" data-option="bp_show_points_on_card" <?php checked(zca_obp($opts,'bp_show_points_on_card','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
          <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Show Rank Badge on Card</div><div class="zca-toggle-row__desc">Display current rank on member card</div></div><label class="zca-toggle"><input type="checkbox" name="bp_show_rank_badge" data-option="bp_show_rank_badge" <?php checked(zca_obp($opts,'bp_show_rank_badge','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
          <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Follow / Friend Button</div><div class="zca-toggle-row__desc">Show follow/friend button on member cards</div></div><label class="zca-toggle"><input type="checkbox" name="bp_show_follow_btn" data-option="bp_show_follow_btn" <?php checked(zca_obp($opts,'bp_show_follow_btn','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
        </div>
        <div class="zca-card">
          <div class="zca-card__header"><div class="zca-card__icon">🖼</div><span class="zca-card__title">Avatars & Cover Photos</span></div>
          <div class="zca-field">
            <label class="zca-label">Avatar Size (px)</label>
            <div class="zca-slider-wrap">
              <input type="range" class="zca-slider" name="bp_avatar_size" data-option="bp_avatar_size" min="40" max="200" value="<?php echo esc_attr(zca_obp($opts,'bp_avatar_size','100')); ?>" data-unit="px">
              <span class="zca-slider-value"><?php echo esc_attr(zca_obp($opts,'bp_avatar_size','100')); ?>px</span>
            </div>
          </div>
          <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Enable Cover Photos</div><div class="zca-toggle-row__desc">Allow members to set a profile cover photo</div></div><label class="zca-toggle"><input type="checkbox" name="bp_cover_photos" data-option="bp_cover_photos" <?php checked(zca_obp($opts,'bp_cover_photos','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
          <div class="zca-field">
            <label class="zca-label">Cover Photo Height</label>
            <div class="zca-slider-wrap">
              <input type="range" class="zca-slider" name="bp_cover_height" data-option="bp_cover_height" min="120" max="500" value="<?php echo esc_attr(zca_obp($opts,'bp_cover_height','300')); ?>" data-unit="px" data-token="bp-cover-height">
              <span class="zca-slider-value"><?php echo esc_attr(zca_obp($opts,'bp_cover_height','300')); ?>px</span>
            </div>
          </div>
          <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Gravatar Fallback</div><div class="zca-toggle-row__desc">Use Gravatar when no avatar is uploaded</div></div><label class="zca-toggle"><input type="checkbox" name="bp_gravatar_fallback" data-option="bp_gravatar_fallback" <?php checked(zca_obp($opts,'bp_gravatar_fallback','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
          <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Round Avatars</div><div class="zca-toggle-row__desc">Circular avatar style (border-radius: 50%)</div></div><label class="zca-toggle"><input type="checkbox" name="bp_round_avatars" data-option="bp_round_avatars" <?php checked(zca_obp($opts,'bp_round_avatars','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
        </div>
      </div>
    </div>

    <!-- Activity -->
    <div class="zca-tab-panel" data-zc-panel="activity">
      <div class="zca-card">
        <div class="zca-card__header"><div class="zca-card__icon">📰</div><span class="zca-card__title">Activity Feed Settings</span></div>
        <div class="zca-grid zca-grid--2">
          <div class="zca-field">
            <label class="zca-label">Activity Items Per Page</label>
            <div class="zca-slider-wrap">
              <input type="range" class="zca-slider" name="bp_activity_per_page" data-option="bp_activity_per_page" min="5" max="50" value="<?php echo esc_attr(zca_obp($opts,'bp_activity_per_page','20')); ?>" data-unit="">
              <span class="zca-slider-value"><?php echo esc_attr(zca_obp($opts,'bp_activity_per_page','20')); ?></span>
            </div>
          </div>
          <div class="zca-field">
            <label class="zca-label">Activity Load Style</label>
            <select class="zca-select" name="bp_activity_load" data-option="bp_activity_load">
              <option value="ajax" <?php selected(zca_obp($opts,'bp_activity_load','ajax'),'ajax'); ?>>AJAX Load More</option>
              <option value="infinite" <?php selected(zca_obp($opts,'bp_activity_load','ajax'),'infinite'); ?>>Infinite Scroll</option>
              <option value="pagination" <?php selected(zca_obp($opts,'bp_activity_load','ajax'),'pagination'); ?>>Pagination</option>
            </select>
          </div>
        </div>
        <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Enable Reactions on Activity</div><div class="zca-toggle-row__desc">Show animated reaction system on activity posts</div></div><label class="zca-toggle"><input type="checkbox" name="bp_activity_reactions" data-option="bp_activity_reactions" <?php checked(zca_obp($opts,'bp_activity_reactions','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
        <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Real-Time Activity Updates</div><div class="zca-toggle-row__desc">Auto-refresh activity via heartbeat API</div></div><label class="zca-toggle"><input type="checkbox" name="bp_realtime_activity" data-option="bp_realtime_activity" <?php checked(zca_obp($opts,'bp_realtime_activity','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
        <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Media in Activity Posts</div><div class="zca-toggle-row__desc">Allow images/video in activity updates (RTMedia)</div></div><label class="zca-toggle"><input type="checkbox" name="bp_activity_media" data-option="bp_activity_media" <?php checked(zca_obp($opts,'bp_activity_media','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
        <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Link Previews</div><div class="zca-toggle-row__desc">Auto-generate rich link previews in activity</div></div><label class="zca-toggle"><input type="checkbox" name="bp_link_previews" data-option="bp_link_previews" <?php checked(zca_obp($opts,'bp_link_previews','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
        <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Emoji Support in Activity</div><div class="zca-toggle-row__desc">Emoji picker in activity compose box</div></div><label class="zca-toggle"><input type="checkbox" name="bp_emoji_support" data-option="bp_emoji_support" <?php checked(zca_obp($opts,'bp_emoji_support','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
      </div>
    </div>

    <!-- Groups -->
    <div class="zca-tab-panel" data-zc-panel="groups">
      <div class="zca-card">
        <div class="zca-card__header"><div class="zca-card__icon">🏘</div><span class="zca-card__title">Group Settings</span></div>
        <div class="zca-grid zca-grid--2">
          <div class="zca-field">
            <label class="zca-label">Groups Per Page</label>
            <div class="zca-slider-wrap">
              <input type="range" class="zca-slider" name="bp_groups_per_page" data-option="bp_groups_per_page" min="4" max="48" value="<?php echo esc_attr(zca_obp($opts,'bp_groups_per_page','16')); ?>" data-unit="">
              <span class="zca-slider-value"><?php echo esc_attr(zca_obp($opts,'bp_groups_per_page','16')); ?></span>
            </div>
          </div>
          <div class="zca-field">
            <label class="zca-label">Default Groups View</label>
            <select class="zca-select" name="bp_groups_default_view" data-option="bp_groups_default_view">
              <option value="grid" <?php selected(zca_obp($opts,'bp_groups_default_view','grid'),'grid'); ?>>Grid</option>
              <option value="list" <?php selected(zca_obp($opts,'bp_groups_default_view','grid'),'list'); ?>>List</option>
            </select>
          </div>
        </div>
        <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Group Cover Photos</div><div class="zca-toggle-row__desc">Allow groups to have a cover photo</div></div><label class="zca-toggle"><input type="checkbox" name="bp_group_covers" data-option="bp_group_covers" <?php checked(zca_obp($opts,'bp_group_covers','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
        <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Group Hierarchy</div><div class="zca-toggle-row__desc">Enable parent/child group relationships</div></div><label class="zca-toggle"><input type="checkbox" name="bp_group_hierarchy" data-option="bp_group_hierarchy" <?php checked(zca_obp($opts,'bp_group_hierarchy','0'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
        <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Group ZCreds Economy</div><div class="zca-toggle-row__desc">Enable Group ZCreds point type in groups</div></div><label class="zca-toggle"><input type="checkbox" name="bp_group_zcreds" data-option="bp_group_zcreds" <?php checked(zca_obp($opts,'bp_group_zcreds','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
        <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Group Documents</div><div class="zca-toggle-row__desc">Allow document uploads within groups</div></div><label class="zca-toggle"><input type="checkbox" name="bp_group_docs" data-option="bp_group_docs" <?php checked(zca_obp($opts,'bp_group_docs','0'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
      </div>
    </div>

    <!-- Profile -->
    <div class="zca-tab-panel" data-zc-panel="profile">
      <div class="zca-card">
        <div class="zca-card__header"><div class="zca-card__icon">🪪</div><span class="zca-card__title">Profile Page Layout</span></div>
        <div class="zca-field">
          <label class="zca-label">Profile Layout Style</label>
          <select class="zca-select" name="bp_profile_layout" data-option="bp_profile_layout">
            <option value="cover-top" <?php selected(zca_obp($opts,'bp_profile_layout','cover-top'),'cover-top'); ?>>Cover Top (Default)</option>
            <option value="sidebar-left" <?php selected(zca_obp($opts,'bp_profile_layout','cover-top'),'sidebar-left'); ?>>Left Sidebar</option>
            <option value="sidebar-right" <?php selected(zca_obp($opts,'bp_profile_layout','cover-top'),'sidebar-right'); ?>>Right Sidebar</option>
            <option value="minimal" <?php selected(zca_obp($opts,'bp_profile_layout','cover-top'),'minimal'); ?>>Minimal</option>
          </select>
        </div>
        <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Show Social Links on Profile</div><div class="zca-toggle-row__desc">Display Twitter/Instagram etc. from xProfile fields</div></div><label class="zca-toggle"><input type="checkbox" name="bp_profile_social_links" data-option="bp_profile_social_links" <?php checked(zca_obp($opts,'bp_profile_social_links','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
        <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Show Achievements on Profile</div><div class="zca-toggle-row__desc">GamiPress badges & quests displayed on profile</div></div><label class="zca-toggle"><input type="checkbox" name="bp_profile_achievements" data-option="bp_profile_achievements" <?php checked(zca_obp($opts,'bp_profile_achievements','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
        <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Profile Completion Indicator</div><div class="zca-toggle-row__desc">Show progress bar for profile completeness</div></div><label class="zca-toggle"><input type="checkbox" name="bp_profile_completion" data-option="bp_profile_completion" <?php checked(zca_obp($opts,'bp_profile_completion','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
      </div>
    </div>

    <!-- Messages -->
    <div class="zca-tab-panel" data-zc-panel="messages">
      <div class="zca-card">
        <div class="zca-card__header"><div class="zca-card__icon">💬</div><span class="zca-card__title">Messaging Options</span></div>
        <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Enable Private Messages</div><div class="zca-toggle-row__desc">Allow members to send private messages</div></div><label class="zca-toggle"><input type="checkbox" name="bp_private_messages" data-option="bp_private_messages" <?php checked(zca_obp($opts,'bp_private_messages','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
        <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Better Messages Integration</div><div class="zca-toggle-row__desc">Replace BP messages with Better Messages plugin</div></div><label class="zca-toggle"><input type="checkbox" name="bp_better_messages" data-option="bp_better_messages" <?php checked(zca_obp($opts,'bp_better_messages','0'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
        <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">BuddyMeet Video Calls</div><div class="zca-toggle-row__desc">Enable video call button in messages</div></div><label class="zca-toggle"><input type="checkbox" name="bp_buddymeet" data-option="bp_buddymeet" <?php checked(zca_obp($opts,'bp_buddymeet','1'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
        <div class="zca-toggle-row"><div class="zca-toggle-row__info"><div class="zca-toggle-row__label">Message Requests (Guests)</div><div class="zca-toggle-row__desc">Allow guests to send message requests</div></div><label class="zca-toggle"><input type="checkbox" name="bp_message_requests" data-option="bp_message_requests" <?php checked(zca_obp($opts,'bp_message_requests','0'),'1'); ?>><span class="zca-toggle__slider"></span></label></div>
      </div>
    </div>

  </div>
</div>
</div>
