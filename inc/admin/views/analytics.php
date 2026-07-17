<?php if(!defined('ABSPATH'))exit;
$period = isset($_GET['period']) ? sanitize_key($_GET['period']) : '30';
$allowed = ['7','30','90','365'];
if(!in_array($period,$allowed,true)) $period='30';
// Quick stat helpers
function _zca_posts_count($days){ global $wpdb; return (int)$wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM {$wpdb->posts} WHERE post_status='publish' AND post_type='post' AND post_date >= DATE_SUB(NOW(), INTERVAL %d DAY)",$days)); }
function _zca_users_count($days){ global $wpdb; return (int)$wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM {$wpdb->users} WHERE user_registered >= DATE_SUB(NOW(), INTERVAL %d DAY)",$days)); }
function _zca_comments_count($days){ global $wpdb; return (int)$wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM {$wpdb->comments} WHERE comment_approved='1' AND comment_date >= DATE_SUB(NOW(), INTERVAL %d DAY)",$days)); }
?>
<div class="wrap zca-wrap">
<div class="d-flex justify-content-between align-items-center mb-4">
  <h1 class="zca-page-title mb-0"><i class="bi bi-graph-up-arrow me-2"></i><?php esc_html_e('Analytics','zincelestial'); ?></h1>
  <div class="btn-group" role="group">
    <?php foreach(['7'=>'7 Days','30'=>'30 Days','90'=>'90 Days','365'=>'1 Year'] as $val=>$lbl): ?>
    <a href="<?php echo esc_url(add_query_arg(['page'=>'zc-analytics','period'=>$val],admin_url('admin.php'))); ?>" class="btn btn-<?php echo $period===$val?'primary':'outline-secondary'; ?> btn-sm"><?php echo esc_html($lbl); ?></a>
    <?php endforeach; ?>
  </div>
</div>
<!-- Stat cards -->
<div class="row g-4 mb-4">
  <?php
  $stats=[
    ['label'=>__('New Posts','zincelestial'),'value'=>_zca_posts_count($period),'icon'=>'file-earmark-text-fill','color'=>'primary','delta'=>'+'],
    ['label'=>__('New Users','zincelestial'),'value'=>_zca_users_count($period),'icon'=>'people-fill','color'=>'success','delta'=>'+'],
    ['label'=>__('New Comments','zincelestial'),'value'=>_zca_comments_count($period),'icon'=>'chat-dots-fill','color'=>'info','delta'=>'+'],
    ['label'=>__('Total Posts','zincelestial'),'value'=>wp_count_posts()->publish,'icon'=>'archive-fill','color'=>'warning','delta'=>''],
    ['label'=>__('Total Users','zincelestial'),'value'=>count_users()['total_users'],'icon'=>'person-badge-fill','color'=>'danger','delta'=>''],
    ['label'=>__('Total Comments','zincelestial'),'value'=>wp_count_comments()->approved,'icon'=>'chat-fill','color'=>'secondary','delta'=>''],
  ];
  foreach($stats as $s): ?>
  <div class="col-6 col-lg-2">
    <div class="card shadow-sm text-center h-100">
      <div class="card-body py-3">
        <i class="bi bi-<?php echo esc_attr($s['icon']); ?> text-<?php echo esc_attr($s['color']); ?>" style="font-size:2rem"></i>
        <div class="fw-bold fs-4 mt-2"><?php echo esc_html(number_format($s['value'])); ?></div>
        <small class="text-muted"><?php echo esc_html($s['label']); ?></small>
      </div>
    </div>
  </div>
  <?php endforeach; ?>
</div>
<!-- Charts -->
<div class="row g-4">
  <div class="col-lg-6">
    <div class="card shadow-sm">
      <div class="card-header fw-semibold"><i class="bi bi-bar-chart-fill me-2"></i><?php esc_html_e('Posts by Category','zincelestial'); ?></div>
      <div class="card-body"><canvas id="zcaCatChart" height="220"></canvas></div>
    </div>
  </div>
  <div class="col-lg-6">
    <div class="card shadow-sm">
      <div class="card-header fw-semibold"><i class="bi bi-people-fill me-2"></i><?php esc_html_e('User Roles Distribution','zincelestial'); ?></div>
      <div class="card-body"><canvas id="zcaRoleChart" height="220"></canvas></div>
    </div>
  </div>
</div>
<?php
// Data for charts
$cats = get_categories(['hide_empty'=>false,'number'=>8]);
$cat_labels = wp_list_pluck($cats,'name');
$cat_counts = wp_list_pluck($cats,'count');
$editable_roles = get_editable_roles();
$role_labels=[]; $role_counts=[];
foreach($editable_roles as $r=>$d){ $users=get_users(['role'=>$r,'fields'=>'ID','number'=>1000]); $role_labels[]=translate_user_role($d['name']); $role_counts[]=count($users); }
?>
<script>
document.addEventListener('DOMContentLoaded',function(){
  if(typeof Chart==='undefined') return;
  var zca_colors=['#7c6ff7','#0ea5e9','#22c55e','#f59e0b','#ef4444','#8b5cf6','#06b6d4','#84cc16'];
  new Chart(document.getElementById('zcaCatChart'),{type:'bar',data:{labels:<?php echo wp_json_encode($cat_labels); ?>,datasets:[{label:'<?php echo esc_js(__('Posts','zincelestial')); ?>',data:<?php echo wp_json_encode($cat_counts); ?>,backgroundColor:zca_colors}]},options:{responsive:true,plugins:{legend:{display:false}}}});
  new Chart(document.getElementById('zcaRoleChart'),{type:'doughnut',data:{labels:<?php echo wp_json_encode($role_labels); ?>,datasets:[{data:<?php echo wp_json_encode($role_counts); ?>,backgroundColor:zca_colors}]},options:{responsive:true}});
});
</script>
</div>
