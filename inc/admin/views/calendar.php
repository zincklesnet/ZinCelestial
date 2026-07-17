<?php if(!defined('ABSPATH'))exit;
// Get scheduled posts for calendar
$scheduled = get_posts(['post_status'=>'future','post_type'=>'post','numberposts'=>50,'fields'=>'ids']);
$cal_events=[];
foreach($scheduled as $pid){
  $cal_events[]=['id'=>$pid,'title'=>get_the_title($pid),'start'=>get_post_time('c',false,$pid),'url'=>get_edit_post_link($pid,false),'color'=>'#7c6ff7'];
}
$published = get_posts(['post_status'=>'publish','post_type'=>'post','numberposts'=>50,'date_query'=>[['after'=>'-60 days']],'fields'=>'ids']);
foreach($published as $pid){
  $cal_events[]=['id'=>'p'.$pid,'title'=>get_the_title($pid),'start'=>get_post_time('c',false,$pid),'url'=>get_permalink($pid),'color'=>'#22c55e'];
}
?>
<div class="wrap zca-wrap">
<h1 class="zca-page-title"><i class="bi bi-calendar3 me-2"></i><?php esc_html_e('Content Calendar','zincelestial'); ?></h1>
<div class="row g-3 mb-3">
  <div class="col-auto"><span class="badge" style="background:#7c6ff7;font-size:.85rem"><?php esc_html_e('Scheduled','zincelestial'); ?></span></div>
  <div class="col-auto"><span class="badge" style="background:#22c55e;font-size:.85rem"><?php esc_html_e('Published','zincelestial'); ?></span></div>
  <div class="col-auto"><span class="badge" style="background:#0ea5e9;font-size:.85rem"><?php esc_html_e('Events (if The Events Calendar is active)','zincelestial'); ?></span></div>
</div>
<div class="card shadow-sm">
  <div class="card-body p-0" style="min-height:520px">
    <div id="zcaCalendar"></div>
  </div>
</div>
<script>
document.addEventListener('DOMContentLoaded',function(){
  if(typeof FullCalendar==='undefined'){
    var s=document.createElement('script'); s.src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js';
    s.onload=initCal; document.head.appendChild(s);
    var lnk=document.createElement('link'); lnk.rel='stylesheet'; lnk.href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css';
    document.head.appendChild(lnk);
  } else { initCal(); }
  function initCal(){
    var calendar=new FullCalendar.Calendar(document.getElementById('zcaCalendar'),{
      initialView:'dayGridMonth',
      height:'auto',
      headerToolbar:{left:'prev,next today',center:'title',right:'dayGridMonth,timeGridWeek,listWeek'},
      events:<?php echo wp_json_encode($cal_events); ?>,
      eventClick:function(info){if(info.event.url){window.open(info.event.url,'_blank');info.jsEvent.preventDefault();}},
    });
    calendar.render();
  }
});
</script>
</div>
