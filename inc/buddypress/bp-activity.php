<?php
if(!defined('ABSPATH'))exit;
class ZC_BP_Activity{
  public static function init(){
    if(!function_exists('buddypress'))return;
    add_action('bp_activity_posted_update',array('ZC_BP_Activity','after_post'),10,3);
    add_filter('bp_get_activity_css_class',array('ZC_BP_Activity','activity_class'));
    add_action('bp_activity_admin_nav',array('ZC_BP_Activity','admin_nav_items'));
    add_filter('bp_activity_excerpt_length',array('ZC_BP_Activity','excerpt_length'));
  }
  public static function after_post($content,$user_id,$activity_id){
    do_action('zc_bp_activity_posted',$content,$user_id,$activity_id);
  }
  public static function activity_class($class){
    return $class.' zc-activity-item';
  }
  public static function admin_nav_items($nav){}
  public static function excerpt_length($len){return intval(zc_option('bp_activity_excerpt',200));}
}
ZC_BP_Activity::init();
