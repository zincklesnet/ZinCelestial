<?php
if(!defined('ABSPATH'))exit;
class ZC_System_Analytics{
  public static function init(){
    add_action('wp',array('ZC_System_Analytics','track_page_view'));
    add_action('wp_ajax_zc_analytics_data',array('ZC_System_Analytics','get_data'));
    add_action('wp_ajax_zc_track_event',array('ZC_System_Analytics','track_event'));
    add_action('wp_ajax_nopriv_zc_track_event',array('ZC_System_Analytics','track_event'));
    add_shortcode('zc_analytics_widget',array('ZC_System_Analytics','widget_shortcode'));
  }
  public static function track_page_view(){
    if(is_admin()||is_user_logged_in()&&current_user_can('manage_options'))return;
    $today=date('Y-m-d');
    $key='zc_pv_'.$today;
    $count=(int)get_transient($key);
    set_transient($key,$count+1,DAY_IN_SECONDS*2);
    do_action('zc_page_view_tracked');
  }
  public static function get_data(){
    if(!current_user_can('edit_theme_options')){wp_send_json_error();return;}
    $data=array();
    for($i=6;$i>=0;$i--){
      $day=date('Y-m-d',strtotime('-'.$i.' days'));
      $data[]=array('date'=>$day,'views'=>(int)get_transient('zc_pv_'.$day));
    }
    wp_send_json_success($data);
  }
  public static function track_event(){
    check_ajax_referer('zc_nonce','nonce');
    $event=sanitize_key($_POST['event']??'');
    $meta=array_map('sanitize_text_field',(array)($_POST['meta']??array()));
    if(!$event){wp_send_json_error();return;}
    do_action('zc_analytics_event',$event,$meta,get_current_user_id());
    wp_send_json_success();
  }
  public static function widget_shortcode($atts){
    if(!current_user_can('edit_theme_options'))return '';
    ob_start();
    echo '<div class="zc-analytics-widget" id="zc-analytics-widget">';
    echo '<div class="zc-analytics-widget__chart" id="zc-analytics-chart"></div>';
    echo '</div>';
    return ob_get_clean();
  }
}
ZC_System_Analytics::init();
