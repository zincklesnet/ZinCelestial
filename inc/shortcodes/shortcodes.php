<?php
if(!defined('ABSPATH'))exit;
/**
 * ZinCelestial Bootstrap Element Library — Shortcodes v4.0
 * 19 shortcodes covering all Bootstrap 5 components + ZinCelestial custom widgets
 */

// ── [zc_alert] ────────────────────────────────────────────────────────────────
add_shortcode('zc_alert', function($atts, $content='') {
  $a = shortcode_atts(['type'=>'primary','dismissible'=>'0','icon'=>''], $atts);
  $d = $a['dismissible']==='1' ? ' alert-dismissible fade show' : '';
  $ic = $a['icon'] ? '<i class="bi bi-'.esc_attr($a['icon']).' me-2" aria-hidden="true"></i>' : '';
  $btn = $a['dismissible']==='1' ? '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="'.esc_attr__('Close','zincelestial').'"></button>' : '';
  return '<div class="alert alert-'.esc_attr($a['type']).$d.'" role="alert">'.$ic.do_shortcode($content).$btn.'</div>';
});

// ── [zc_button] ───────────────────────────────────────────────────────────────
add_shortcode('zc_button', function($atts, $content='') {
  $a = shortcode_atts(['type'=>'primary','size'=>'','outline'=>'0','pill'=>'0','icon'=>'','href'=>'#','target'=>'_self','class'=>''], $atts);
  $cls = 'btn btn-'.($a['outline']==='1'?'outline-':'').esc_attr($a['type']);
  if($a['size']) $cls .= ' btn-'.esc_attr($a['size']);
  if($a['pill']==='1') $cls .= ' rounded-pill';
  if($a['class']) $cls .= ' '.esc_attr($a['class']);
  $ic = $a['icon'] ? '<i class="bi bi-'.esc_attr($a['icon']).' me-1" aria-hidden="true"></i>' : '';
  return '<a href="'.esc_url($a['href']).'" class="'.$cls.'" target="'.esc_attr($a['target']).'">'.$ic.do_shortcode($content).'</a>';
});

// ── [zc_badge] ────────────────────────────────────────────────────────────────
add_shortcode('zc_badge', function($atts, $content='') {
  $a = shortcode_atts(['color'=>'primary','pill'=>'1'], $atts);
  $p = $a['pill']==='1' ? ' rounded-pill' : '';
  return '<span class="badge text-bg-'.esc_attr($a['color']).$p.'">'.do_shortcode($content).'</span>';
});

// ── [zc_card] ─────────────────────────────────────────────────────────────────
add_shortcode('zc_card', function($atts, $content='') {
  $a = shortcode_atts(['title'=>'','subtitle'=>'','image'=>'','footer'=>'','shadow'=>'sm','hover'=>'1','class'=>''], $atts);
  $sh = $a['shadow'] ? ' shadow-'.$a['shadow'] : '';
  $hv = $a['hover']==='1' ? ' zc-card-hover' : '';
  $cls = 'card zc-card'.$sh.$hv.($a['class']?' '.esc_attr($a['class']):'');
  $out = '<div class="'.$cls.'">';
  if($a['image']) {
    $src = is_numeric($a['image']) ? wp_get_attachment_image_url($a['image'],'medium') : esc_url($a['image']);
    if($src) $out .= '<img src="'.esc_url($src).'" class="card-img-top" alt="'.esc_attr($a['title']).'">';
  }
  $out .= '<div class="card-body">';
  if($a['title'])    $out .= '<h5 class="card-title">'.esc_html($a['title']).'</h5>';
  if($a['subtitle']) $out .= '<h6 class="card-subtitle mb-2 text-muted">'.esc_html($a['subtitle']).'</h6>';
  $out .= '<div class="card-text">'.do_shortcode($content).'</div>';
  $out .= '</div>';
  if($a['footer']) $out .= '<div class="card-footer text-muted">'.esc_html($a['footer']).'</div>';
  $out .= '</div>';
  return $out;
});

// ── [zc_accordion] + [zc_accordion_item] ─────────────────────────────────────
add_shortcode('zc_accordion', function($atts, $content='') {
  $a = shortcode_atts(['id'=>'zc-acc-'.uniqid(),'flush'=>'0'], $atts);
  $f = $a['flush']==='1' ? ' accordion-flush' : '';
  $GLOBALS['zc_acc_id'] = esc_attr($a['id']);
  return '<div class="accordion'.$f.'" id="'.esc_attr($a['id']).'">'.do_shortcode($content).'</div>';
});
add_shortcode('zc_accordion_item', function($atts, $content='') {
  $a   = shortcode_atts(['title'=>'Item','open'=>'0'], $atts);
  $pid = isset($GLOBALS['zc_acc_id']) ? $GLOBALS['zc_acc_id'] : 'zc-acc';
  $id  = 'acc-'.uniqid();
  $show = $a['open']==='1' ? ' show' : '';
  $col  = $a['open']==='1' ? '' : ' collapsed';
  return '<div class="accordion-item">
    <h2 class="accordion-header">
      <button class="accordion-button'.$col.'" type="button" data-bs-toggle="collapse" data-bs-target="#'.$id.'" aria-expanded="'.($a['open']==='1'?'true':'false').'" aria-controls="'.$id.'">'.esc_html($a['title']).'</button>
    </h2>
    <div id="'.$id.'" class="accordion-collapse collapse'.$show.'" data-bs-parent="#'.$pid.'">
      <div class="accordion-body">'.do_shortcode($content).'</div>
    </div>
  </div>';
});

// ── [zc_tabs] + [zc_tab] ─────────────────────────────────────────────────────
add_shortcode('zc_tabs', function($atts, $content='') {
  $a = shortcode_atts(['style'=>'tabs','id'=>'zc-tabs-'.uniqid()], $atts);
  $GLOBALS['zc_tabs_id']      = esc_attr($a['id']);
  $GLOBALS['zc_tabs_style']   = esc_attr($a['style']);
  $GLOBALS['zc_tabs_nav']     = '';
  $GLOBALS['zc_tabs_content'] = '';
  $GLOBALS['zc_tabs_first']   = true;
  do_shortcode($content); // populates globals
  $nav_cls = $a['style']==='pills' ? 'nav-pills' : ($a['style']==='underline' ? 'nav-underline' : 'nav-tabs');
  return '<div class="zc-tabs-wrapper" id="'.esc_attr($a['id']).'">
    <ul class="nav '.$nav_cls.' mb-3" role="tablist">'.$GLOBALS['zc_tabs_nav'].'</ul>
    <div class="tab-content">'.$GLOBALS['zc_tabs_content'].'</div>
  </div>';
});
add_shortcode('zc_tab', function($atts, $content='') {
  $a    = shortcode_atts(['title'=>'Tab','active'=>'0'], $atts);
  $pid  = isset($GLOBALS['zc_tabs_id']) ? $GLOBALS['zc_tabs_id'] : 'zc-tabs';
  $id   = 'tab-'.uniqid();
  $first= isset($GLOBALS['zc_tabs_first']) && $GLOBALS['zc_tabs_first'];
  $active= ($a['active']==='1'||$first) ? ' active' : '';
  $GLOBALS['zc_tabs_first'] = false;
  $sel   = ($a['active']==='1'||$active) ? 'true' : 'false';
  $GLOBALS['zc_tabs_nav']     .= '<li class="nav-item" role="presentation"><button class="nav-link'.$active.'" id="'.$id.'-tab" data-bs-toggle="tab" data-bs-target="#'.$id.'" type="button" role="tab" aria-controls="'.$id.'" aria-selected="'.$sel.'">'.esc_html($a['title']).'</button></li>';
  $GLOBALS['zc_tabs_content'] .= '<div class="tab-pane fade'.($active?' show active':'').'" id="'.$id.'" role="tabpanel" aria-labelledby="'.$id.'-tab">'.do_shortcode($content).'</div>';
  return '';
});

// ── [zc_progress] ────────────────────────────────────────────────────────────
add_shortcode('zc_progress', function($atts) {
  $a = shortcode_atts(['value'=>'50','color'=>'primary','striped'=>'0','animated'=>'0','label'=>'','height'=>''], $atts);
  $v = min(100,max(0,(int)$a['value']));
  $cls = 'progress-bar bg-'.esc_attr($a['color']);
  if($a['striped']==='1') $cls .= ' progress-bar-striped';
  if($a['animated']==='1') $cls .= ' progress-bar-animated';
  $ht = $a['height'] ? ' style="height:'.esc_attr($a['height']).'px"' : '';
  return '<div class="progress mb-2"'.$ht.' role="progressbar" aria-valuenow="'.$v.'" aria-valuemin="0" aria-valuemax="100">
    <div class="'.$cls.'" style="width:'.$v.'%">'.($a['label']?esc_html($a['label']):($a['label']===''?'':'')).'</div>
  </div>';
});

// ── [zc_stat_card] ───────────────────────────────────────────────────────────
add_shortcode('zc_stat_card', function($atts) {
  $a = shortcode_atts(['value'=>'0','label'=>'Stat','icon'=>'graph-up','trend'=>'','trend_dir'=>'up','color'=>'primary'], $atts);
  $tr = $a['trend'] ? '<small class="zc-stat-trend zc-stat-trend--'.esc_attr($a['trend_dir']).'"><i class="bi bi-arrow-'.($a['trend_dir']==='up'?'up':'down').'-right me-1" aria-hidden="true"></i>'.esc_html($a['trend']).'</small>' : '';
  return '<div class="card zc-stat-card shadow-sm border-0">
    <div class="card-body d-flex align-items-center gap-3">
      <div class="zc-stat-icon bg-'.esc_attr($a['color']).'-subtle text-'.esc_attr($a['color']).' rounded-3 p-3">
        <i class="bi bi-'.esc_attr($a['icon']).'" style="font-size:1.5rem" aria-hidden="true"></i>
      </div>
      <div>
        <div class="zc-stat-value fw-bold fs-4">'.esc_html($a['value']).'</div>
        <div class="zc-stat-label text-muted small">'.esc_html($a['label']).'</div>
        '.$tr.'
      </div>
    </div>
  </div>';
});

// ── [zc_grid] ────────────────────────────────────────────────────────────────
add_shortcode('zc_grid', function($atts, $content='') {
  $a = shortcode_atts(['cols'=>'3','gap'=>'4'], $atts);
  $col_map = ['1'=>'12','2'=>'6','3'=>'4','4'=>'3','6'=>'2'];
  $bs_col  = isset($col_map[$a['cols']]) ? $col_map[$a['cols']] : '4';
  return '<div class="row g-'.esc_attr($a['gap']).' zc-grid" data-cols="'.esc_attr($a['cols']).'" data-bs-col="'.$bs_col.'">'.do_shortcode($content).'</div>';
});

// ── [zc_icon] ─────────────────────────────────────────────────────────────────
add_shortcode('zc_icon', function($atts) {
  $a = shortcode_atts(['name'=>'star','size'=>'1rem','color'=>'','class'=>''], $atts);
  $style = 'font-size:'.esc_attr($a['size']).';';
  if($a['color']) $style .= 'color:'.esc_attr($a['color']).';';
  return '<i class="bi bi-'.esc_attr($a['name']).' '.esc_attr($a['class']).'" style="'.esc_attr($style).'" aria-hidden="true"></i>';
});

// ── [zc_pricing] ─────────────────────────────────────────────────────────────
add_shortcode('zc_pricing', function($atts) {
  $a = shortcode_atts(['title'=>'Plan','price'=>'0','period'=>'/mo','features'=>'','btn_text'=>'Get Started','btn_href'=>'#','featured'=>'0','color'=>'primary'], $atts);
  $feats = array_filter(array_map('trim', explode(',', $a['features'])));
  $feat_html = '';
  foreach($feats as $f) $feat_html .= '<li class="mb-1"><i class="bi bi-check-circle-fill text-'.esc_attr($a['color']).' me-2"></i>'.esc_html($f).'</li>';
  $featured_cls = $a['featured']==='1' ? ' border-2 border-'.esc_attr($a['color']).' shadow-lg zc-pricing--featured' : '';
  return '<div class="card zc-pricing-card'.$featured_cls.'">'.($a['featured']==='1'?'<div class="card-header text-center bg-'.esc_attr($a['color']).' text-white fw-bold">Most Popular</div>':'').'
    <div class="card-body text-center">
      <h5 class="card-title">'.esc_html($a['title']).'</h5>
      <div class="zc-pricing__price display-5 fw-bold text-'.esc_attr($a['color']).'">'.esc_html($a['price']).'<small class="fs-6 text-muted fw-normal">'.esc_html($a['period']).'</small></div>
      <ul class="list-unstyled my-4 text-start">'.$feat_html.'</ul>
      <a href="'.esc_url($a['btn_href']).'" class="btn btn-'.($a['featured']==='1'?'':'outline-').esc_attr($a['color']).' w-100">'.esc_html($a['btn_text']).'</a>
    </div>
  </div>';
});

// ── [zc_countdown] ───────────────────────────────────────────────────────────
add_shortcode('zc_countdown', function($atts) {
  $a  = shortcode_atts(['date'=>'','style'=>'boxes'], $atts);
  $id = 'zc-cd-'.uniqid();
  wp_add_inline_script('zincelestial-core', "
    (function(){
      var el=document.getElementById('{$id}');if(!el)return;
      var end=new Date('{$a['date']}').getTime();
      var iv=setInterval(function(){
        var now=new Date().getTime(),d=end-now;
        if(d<0){clearInterval(iv);el.innerHTML='<span class=\"text-muted\">".__('Ended','zincelestial')."</span>';return;}
        var days=Math.floor(d/864e5),hrs=Math.floor((d%864e5)/36e5),min=Math.floor((d%36e5)/6e4),sec=Math.floor((d%6e4)/1e3);
        el.querySelector('.zc-cd-d').textContent=('0'+days).slice(-2);
        el.querySelector('.zc-cd-h').textContent=('0'+hrs).slice(-2);
        el.querySelector('.zc-cd-m').textContent=('0'+min).slice(-2);
        el.querySelector('.zc-cd-s').textContent=('0'+sec).slice(-2);
      },1000);
    })();
  ", 'after');
  return '<div id="'.$id.'" class="zc-countdown zc-countdown--'.esc_attr($a['style']).' d-flex gap-3 flex-wrap">
    <div class="zc-cd-unit text-center"><div class="zc-cd-val display-6 fw-bold"><span class="zc-cd-d">00</span></div><div class="zc-cd-label text-muted small">'.__('Days','zincelestial').'</div></div>
    <div class="zc-cd-unit text-center"><div class="zc-cd-val display-6 fw-bold"><span class="zc-cd-h">00</span></div><div class="zc-cd-label text-muted small">'.__('Hours','zincelestial').'</div></div>
    <div class="zc-cd-unit text-center"><div class="zc-cd-val display-6 fw-bold"><span class="zc-cd-m">00</span></div><div class="zc-cd-label text-muted small">'.__('Mins','zincelestial').'</div></div>
    <div class="zc-cd-unit text-center"><div class="zc-cd-val display-6 fw-bold"><span class="zc-cd-s">00</span></div><div class="zc-cd-label text-muted small">'.__('Secs','zincelestial').'</div></div>
  </div>';
});

// ── [zc_member_card] ─────────────────────────────────────────────────────────
add_shortcode('zc_member_card', function($atts) {
  $a = shortcode_atts(['user_id'=>'0','size'=>'md','show_stats'=>'1'], $atts);
  $uid = (int)$a['user_id'] ?: get_current_user_id();
  if(!$uid) return '';
  $user = get_userdata($uid);
  if(!$user) return '';
  $avatar = get_avatar_url($uid, ['size'=>80]);
  $profile_url = function_exists('bp_members_get_user_url') ? bp_members_get_user_url($uid) : get_author_posts_url($uid);
  return '<div class="card zc-member-card text-center p-3">
    <img src="'.esc_url($avatar).'" class="rounded-circle mx-auto mb-2 zc-member-avatar" width="64" height="64" alt="'.esc_attr($user->display_name).'">
    <h6 class="card-title mb-0"><a href="'.esc_url($profile_url).'">'.esc_html($user->display_name).'</a></h6>
    <small class="text-muted">@'.esc_html($user->user_login).'</small>
  </div>';
});

// ── [zc_breadcrumb] ───────────────────────────────────────────────────────────
add_shortcode('zc_breadcrumb', function($atts) {
  $a = shortcode_atts(['separator'=>'/'], $atts);
  $items = [];
  $items[] = '<li class="breadcrumb-item"><a href="'.esc_url(home_url('/')).'">'.esc_html__('Home','zincelestial').'</a></li>';
  if(is_single()||is_page()) {
    $items[] = '<li class="breadcrumb-item active" aria-current="page">'.esc_html(get_the_title()).'</li>';
  } elseif(is_category()) {
    $items[] = '<li class="breadcrumb-item active">'.esc_html(single_cat_title('',false)).'</li>';
  }
  return '<nav aria-label="breadcrumb"><ol class="breadcrumb">'.implode('',$items).'</ol></nav>';
});

// ── [zc_bar_progress_info] ───────────────────────────────────────────────────
add_shortcode('zc_bar_progress_info', function($atts) {
  $a  = shortcode_atts(['show_xp'=>'1','show_credits'=>'1','show_rank'=>'1','show_badges'=>'1','style'=>'pills'], $atts);
  $uid = get_current_user_id();
  if(!$uid) return '';
  $out = '<div class="zc-bar-progress-info d-flex flex-wrap gap-2 align-items-center">';
  if($a['show_xp']==='1' && function_exists('gamipress_get_user_points')) {
    $xp = gamipress_get_user_points($uid,'points');
    $out .= '<span class="badge bg-primary-subtle text-primary"><i class="bi bi-lightning-fill me-1"></i>'.number_format($xp).' XP</span>';
  }
  if($a['show_credits']==='1' && function_exists('gamipress_get_user_points')) {
    $cr = gamipress_get_user_points($uid,'gzcreds');
    $out .= '<span class="badge bg-warning-subtle text-warning"><i class="bi bi-coin me-1"></i>'.number_format($cr).' Credits</span>';
  }
  if($a['show_rank']==='1' && function_exists('gamipress_get_user_rank')) {
    $rank = gamipress_get_user_rank($uid);
    if($rank) $out .= '<span class="badge bg-success-subtle text-success"><i class="bi bi-trophy-fill me-1"></i>'.esc_html($rank->post_title).'</span>';
  }
  $out .= '</div>';
  return $out;
});

// ── [zc_my_tickets] — Frontend ticket display (multisite synced) ──────────────
add_shortcode( 'zc_my_tickets', function( $atts ) {
    if ( ! is_user_logged_in() ) {
        return '<div class="alert alert-warning"><i class="bi bi-lock me-2"></i>' . esc_html__( 'Please log in to view your tickets.', 'zincelestial' ) . '</div>';
    }
    $atts = shortcode_atts( [ 'limit' => 20, 'status' => 'all' ], $atts, 'zc_my_tickets' );
    $user_id = get_current_user_id();
    $all_tickets = get_site_option( 'zc_helpdesk_tickets', [] );
    $user_tickets = array_filter( $all_tickets, fn($t) => (int)($t['user_id']??0) === $user_id );
    if ( $atts['status'] !== 'all' ) {
        $user_tickets = array_filter( $user_tickets, fn($t) => ($t['status']??'open') === $atts['status'] );
    }
    krsort( $user_tickets );
    $user_tickets = array_slice( $user_tickets, 0, (int)$atts['limit'], true );

    // Enqueue Bootstrap Icons on frontend
    wp_enqueue_style( 'bootstrap-icons', 'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css', [], '1.11.3' );

    ob_start();
    if ( empty( $user_tickets ) ):
    ?>
    <div class="zc-tickets-empty text-center py-5">
      <i class="bi bi-inbox display-4 d-block mb-3 text-muted"></i>
      <h5 class="text-muted"><?php esc_html_e( 'No tickets found.', 'zincelestial' ); ?></h5>
      <?php if ( function_exists( 'bp_is_active' ) ): ?>
      <a href="<?php echo esc_url( home_url( '/support/' ) ); ?>" class="btn btn-primary mt-3"><i class="bi bi-plus-circle me-1"></i>Open a Ticket</a>
      <?php endif; ?>
    </div>
    <?php else: ?>
    <div class="zc-my-tickets">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0"><i class="bi bi-ticket me-2"></i><?php esc_html_e( 'My Support Tickets', 'zincelestial' ); ?></h5>
        <span class="badge bg-primary"><?php echo count( $user_tickets ); ?> tickets</span>
      </div>
      <div class="table-responsive">
        <table class="table table-hover table-bordered align-middle">
          <thead class="table-dark">
            <tr>
              <th><?php esc_html_e( 'Ticket ID', 'zincelestial' ); ?></th>
              <th><?php esc_html_e( 'Subject', 'zincelestial' ); ?></th>
              <th><?php esc_html_e( 'Status', 'zincelestial' ); ?></th>
              <th><?php esc_html_e( 'Priority', 'zincelestial' ); ?></th>
              <th><?php esc_html_e( 'Created', 'zincelestial' ); ?></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ( $user_tickets as $tid => $t ):
              $status   = $t['status']   ?? 'open';
              $priority = $t['priority'] ?? 'low';
              $scls = [ 'open' => 'danger', 'in-progress' => 'warning', 'resolved' => 'success' ][ $status ] ?? 'secondary';
              $pcls = [ 'high' => 'danger', 'medium' => 'warning', 'low' => 'secondary' ][ $priority ] ?? 'secondary';
            ?>
            <tr>
              <td><code class="text-primary fw-semibold"><?php echo esc_html( $tid ); ?></code></td>
              <td class="fw-semibold"><?php echo esc_html( $t['subject'] ?? '—' ); ?></td>
              <td><span class="badge bg-<?php echo $scls; ?> text-uppercase"><?php echo esc_html( $status ); ?></span></td>
              <td><span class="badge bg-<?php echo $pcls; ?>"><?php echo esc_html( $priority ); ?></span></td>
              <td><small class="text-muted"><?php echo esc_html( date( 'M j, Y', strtotime( $t['created'] ?? 'now' ) ) ); ?></small></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
    <?php endif;
    return ob_get_clean();
} );
