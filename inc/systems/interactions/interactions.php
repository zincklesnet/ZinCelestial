<?php
if(!defined("ABSPATH"))exit;
if(!defined('ABSPATH'))exit;
class ZC_System_Interactions{
  public static function init(){
    add_action('init',array('ZC_System_Interactions','setup'));
    add_action('wp_ajax_zc_bookmark',array('ZC_System_Interactions','bookmark'));
    add_action('wp_ajax_zc_view_count',array('ZC_System_Interactions','view_count'));
    add_action('wp_ajax_nopriv_zc_view_count',array('ZC_System_Interactions','view_count'));
    add_action('wp',array('ZC_System_Interactions','track_view'));
    add_shortcode('zc_post_views',array('ZC_System_Interactions','views_shortcode'));
  }
  public static function setup(){do_action('zc_interactions_ready');}
  public static function track_view(){
    if(!is_singular())return;
    $post_id=get_the_ID();
    if(!$post_id)return;
    $key='zc_view_'.get_current_user_id().'_'.$post_id;
    if(!get_transient($key)){
      $views=(int)get_post_meta($post_id,'_zc_views',true);
      update_post_meta($post_id,'_zc_views',$views+1);
      set_transient($key,1,HOUR_IN_SECONDS);
    }
  }
  public static function bookmark(){
    check_ajax_referer('zc_nonce','nonce');
    if(!is_user_logged_in()){wp_send_json_error();return;}
    $post_id=intval($_POST['post_id']??0);
    if(!$post_id){wp_send_json_error();return;}
    $user_id=get_current_user_id();
    $bookmarks=(array)get_user_meta($user_id,'zc_bookmarks',true);
    if(in_array($post_id,$bookmarks)){
      $bookmarks=array_values(array_diff($bookmarks,array($post_id)));
      $saved=false;
    } else {
      $bookmarks[]=$post_id;
      $saved=true;
    }
    update_user_meta($user_id,'zc_bookmarks',array_unique($bookmarks));
    wp_send_json_success(array('saved'=>$saved,'count'=>count($bookmarks)));
  }
  public static function view_count(){
    $post_id=intval($_GET['post_id']??0);
    if(!$post_id){wp_send_json_error();return;}
    wp_send_json_success(array('views'=>(int)get_post_meta($post_id,'_zc_views',true)));
  }
  public static function views_shortcode($atts){
    $a=shortcode_atts(array('post_id'=>get_the_ID()),$atts);
    return number_format_i18n((int)get_post_meta($a['post_id'],'_zc_views',true));
  }
}
ZC_System_Interactions::init();
