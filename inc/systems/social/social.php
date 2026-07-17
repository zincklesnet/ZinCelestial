<?php
if(!defined("ABSPATH"))exit;
if(!defined('ABSPATH'))exit;
class ZC_System_Social{
  public static function init(){
    add_action('init',array('ZC_System_Social','setup'));
    add_action('wp_ajax_zc_follow_user',array('ZC_System_Social','follow_user'));
    add_action('wp_ajax_zc_unfollow_user',array('ZC_System_Social','unfollow_user'));
    add_action('wp_ajax_nopriv_zc_follow_user',array('ZC_System_Social','login_required'));
    add_shortcode('zc_follow_btn',array('ZC_System_Social','follow_btn_shortcode'));
    add_shortcode('zc_friends_count',array('ZC_System_Social','friends_count_sc'));
  }
  public static function setup(){do_action('zc_social_ready');}
  public static function follow_user(){
    check_ajax_referer('zc_nonce','nonce');
    if(!is_user_logged_in()){wp_send_json_error();return;}
    $target=intval($_POST['target_id']??0);
    $current=get_current_user_id();
    if(!$target||$target===$current){wp_send_json_error();return;}
    $following=(array)get_user_meta($current,'zc_following',true);
    if(!in_array($target,$following)){
      $following[]=$target;
      update_user_meta($current,'zc_following',array_unique($following));
      // Increment follower count
      $count=(int)get_user_meta($target,'zc_followers_count',true);
      update_user_meta($target,'zc_followers_count',$count+1);
    }
    wp_send_json_success(array('following'=>true,'count'=>(int)get_user_meta($target,'zc_followers_count',true)));
  }
  public static function unfollow_user(){
    check_ajax_referer('zc_nonce','nonce');
    if(!is_user_logged_in()){wp_send_json_error();return;}
    $target=intval($_POST['target_id']??0);
    $current=get_current_user_id();
    $following=(array)get_user_meta($current,'zc_following',true);
    if(($key=array_search($target,$following))!==false){
      unset($following[$key]);
      update_user_meta($current,'zc_following',array_values($following));
      $count=(int)get_user_meta($target,'zc_followers_count',true);
      if($count>0)update_user_meta($target,'zc_followers_count',$count-1);
    }
    wp_send_json_success(array('following'=>false,'count'=>(int)get_user_meta($target,'zc_followers_count',true)));
  }
  public static function login_required(){wp_send_json_error(__('Please log in','zincelestial'));}
  public static function is_following($follower_id,$target_id){
    $following=(array)get_user_meta($follower_id,'zc_following',true);
    return in_array($target_id,$following);
  }
  public static function follow_btn_shortcode($atts){
    $a=shortcode_atts(array('user_id'=>0),$atts);
    if(!$a['user_id']||!is_user_logged_in())return '';
    $following=self::is_following(get_current_user_id(),$a['user_id']);
    return sprintf('<button class="zc-follow-btn%s" data-target="%d" data-nonce="%s">%s</button>',
      $following?' zc-follow-btn--following':'',intval($a['user_id']),wp_create_nonce('zc_nonce'),
      $following?esc_html__('Following','zincelestial'):esc_html__('Follow','zincelestial'));
  }
  public static function friends_count_sc($atts){
    $a=shortcode_atts(array('user_id'=>get_current_user_id()),$atts);
    if(function_exists('friends_get_friend_user_ids')){
      return count(friends_get_friend_user_ids($a['user_id']));
    }
    return (int)get_user_meta($a['user_id'],'zc_followers_count',true);
  }
}
ZC_System_Social::init();
