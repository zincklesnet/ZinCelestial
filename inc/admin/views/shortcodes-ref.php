<?php if(!defined('ABSPATH'))exit; ?>
<div class="zca-wrap">
<div class="zca-page-header">
  <div class="zca-page-header__left">
    <div class="zca-page-header__icon">⚡</div>
    <div><div class="zca-page-header__title">Shortcode Reference</div>
    <div class="zca-page-header__sub">All ZinCelestial Bootstrap shortcodes with live examples and copy snippets</div></div>
  </div>
</div>
<div class="zca-content">
  <?php
  $shortcodes = [
    ['[zc_alert]', '[zc_alert type="success" dismissible="1" icon="check-circle"]Your message here[/zc_alert]',
     'Alert / Notice box. type: primary|success|warning|danger|info. dismissible: 0|1. icon: Bootstrap Icon name.'],
    ['[zc_button]', '[zc_button type="primary" icon="star-fill" href="#" pill="1"]Click Me[/zc_button]',
     'Styled button/link. type: primary|secondary|success|danger|warning. outline: 0|1. pill: 0|1. size: sm|lg.'],
    ['[zc_badge]', '[zc_badge color="primary" pill="1"]New[/zc_badge]',
     'Inline badge/tag. color: primary|success|warning|danger|info|secondary.'],
    ['[zc_card]', '[zc_card title="Card Title" subtitle="Subtitle" shadow="md" hover="1"]Content here[/zc_card]',
     'Bootstrap 5 card with optional title, subtitle, image, footer. shadow: sm|md|lg.'],
    ['[zc_columns]', '[zc_columns][zc_column width="6"]Left[/zc_column][zc_column width="6"]Right[/zc_column][/zc_columns]',
     'Bootstrap grid row. Wrap [zc_column] elements inside. width: 1–12 (BS5 col units).'],
    ['[zc_column]', '[zc_column width="4" offset="1"]Content[/zc_column]',
     'Bootstrap column. Use inside [zc_columns]. width and offset use BS5 grid values.'],
    ['[zc_progress]', '[zc_progress value="75" color="primary" label="75% Complete" striped="1" animated="1"]',
     'Bootstrap progress bar. value: 0–100. color: primary|success|danger|warning|info. striped & animated: 0|1.'],
    ['[zc_accordion]', '[zc_accordion][zc_accordion_item title="Q1"]Answer 1[/zc_accordion_item][/zc_accordion]',
     'Collapsible accordion. Wrap [zc_accordion_item] elements inside.'],
    ['[zc_tabs]', '[zc_tabs][zc_tab title="Tab 1" icon="star"]Content 1[/zc_tab][/zc_tabs]',
     'Tabbed content panels. Wrap [zc_tab] elements inside. icon: Bootstrap Icon name (optional).'],
    ['[zc_icon]', '[zc_icon name="heart-fill" size="24" color="#e74c3c" class="me-2"]',
     'Bootstrap Icon SVG. name: any bi-* icon name. size: pixel size. color: hex or CSS value.'],
    ['[zc_avatar]', '[zc_avatar user_id="1" size="md" link="1" badge="1"]',
     'User avatar with optional profile link and online badge. size: xs|sm|md|lg|xl.'],
    ['[zc_member_card]', '[zc_member_card user_id="1" show_actions="1"]',
     'Full BuddyPress member card widget. Requires BuddyPress.'],
    ['[zc_activity_feed]', '[zc_activity_feed user_id="0" per_page="10" type="all"]',
     'Inline BuddyPress activity feed. user_id=0 = sitewide. Requires BuddyPress.'],
    ['[zc_stat_card]', '[zc_stat_card number="1,234" label="Members" icon="people-fill" color="primary" trend="+12%"]',
     'Dashboard stat card with number, label, icon, and optional trend indicator.'],
    ['[zc_divider]', '[zc_divider style="gradient" text="OR" spacing="md"]',
     'Styled horizontal divider. style: default|gradient|dotted|dashed. spacing: sm|md|lg.'],
    ['[zc_notice_box]', '[zc_notice_box title="Note" icon="info-circle" type="info"]Body text[/zc_notice_box]',
     'Styled notice / info box with icon and title. type: info|success|warning|danger.'],
    ['[zc_countdown]', '[zc_countdown date="2027-01-01" label="Until Launch" style="cards"]',
     'Countdown timer. date: ISO date string. style: cards|minimal|inline.'],
    ['[zc_testimonial]', '[zc_testimonial author="Jane Doe" role="Member" avatar="URL" rating="5"]Quote[/zc_testimonial]',
     'Testimonial card with author info, role, avatar, and star rating.'],
    ['[zc_cta]', '[zc_cta title="Join Today" btn_text="Sign Up" btn_url="#" bg="gradient"]Description text[/zc_cta]',
     'Call-to-action section block. bg: gradient|card|transparent.'],
  ];
  ?>
  <div class="zca-notice zca-notice--info"><span class="zca-notice__icon">💡</span><div>All ZinCelestial shortcodes use Bootstrap 5 markup and inherit your active color scheme. Click <strong>Copy</strong> to copy a snippet.</div></div>

  <div style="display:flex;flex-direction:column;gap:16px;">
    <?php foreach($shortcodes as $i => [$tag, $example, $desc]): ?>
    <div class="zca-card">
      <div class="zca-card__header" style="flex-wrap:wrap;gap:8px;">
        <code style="background:rgba(124,111,247,.15);color:var(--zca-primary,#7c6ff7);padding:4px 10px;border-radius:6px;font-size:.8rem;font-weight:700;"><?php echo esc_html($tag); ?></code>
        <span style="flex:1;color:var(--zca-muted,#94a3b8);font-size:.8rem;"><?php echo esc_html($desc); ?></span>
      </div>
      <div style="padding:0 20px 16px;">
        <div style="position:relative;">
          <textarea id="sc-<?php echo $i; ?>" readonly rows="2" style="width:100%;background:rgba(0,0,0,.3);border:1px solid var(--zca-border,#2a2a4a);border-radius:8px;color:var(--zca-text,#e2e8f0);font-family:monospace;font-size:.78rem;padding:10px 40px 10px 12px;resize:none;line-height:1.6;"><?php echo esc_html($example); ?></textarea>
          <button class="zca-copy-btn" data-copy-target="sc-<?php echo $i; ?>" style="position:absolute;top:8px;right:8px;background:rgba(124,111,247,.2);border:none;color:var(--zca-primary,#7c6ff7);border-radius:6px;padding:4px 10px;font-size:.7rem;font-weight:700;cursor:pointer;" title="Copy shortcode"><i class="bi bi-clipboard"></i> Copy</button>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
</div>
</div>
