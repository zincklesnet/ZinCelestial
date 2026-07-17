<?php
if(!defined("ABSPATH"))exit;
if(!defined('ABSPATH'))exit;
class ZC_System_Marketing{
  public static function init(){
    add_action('init',array('ZC_System_Marketing','setup'));
    add_action('wp_footer',array('ZC_System_Marketing','announcement_bar'));
    add_shortcode('zc_referral_link',array('ZC_System_Marketing','referral_link_sc'));
    add_action('wp_ajax_zc_track_referral',array('ZC_System_Marketing','track_referral'));
    add_action('wp_ajax_nopriv_zc_track_referral',array('ZC_System_Marketing','track_referral'));
  }
  public static function setup(){do_action('zc_marketing_ready');}
  public static function announcement_bar(){
    $msg=zc_option('topbar_announcement','');
    if(!$msg)return;
    echo '<div class="zc-announcement-bar">'.wp_kses_post($msg).'<button class="zc-announcement-bar__close" aria-label="'.esc_attr__('Dismiss','zincelestial').'">×</button></div>';
  }
  public static function referral_link_sc($atts){
    if(!is_user_logged_in())return '';
    $user_id=get_current_user_id();
    $code=get_user_meta($user_id,'zc_referral_code',true);
    if(!$code){$code=substr(md5($user_id.time()),0,8);update_user_meta($user_id,'zc_referral_code',$code);}
    $link=add_query_arg('ref',$code,home_url('/'));
    return '<span class="zc-referral-link"><input class="zc-referral-input" type="text" value="'.esc_attr($link).'" readonly><button class="zc-copy-btn" data-copy="'.esc_attr($link).'">'.esc_html__('Copy','zincelestial').'</button></span>';
  }
  public static function track_referral(){
    $code=sanitize_key($_GET['ref']??'');
    if(!$code)return;
    $users=get_users(array('meta_key'=>'zc_referral_code','meta_value'=>$code,'number'=>1));
    if($users){
      $referrer=$users[0]->ID;
      $count=(int)get_user_meta($referrer,'zc_referral_count',true);
      update_user_meta($referrer,'zc_referral_count',$count+1);
      if(function_exists('gamipress_award_points_to_user')){
        gamipress_award_points_to_user($referrer,10,'zcreds',array('admin_id'=>0,'reason'=>__('Referral visit','zincelestial')));
      }
    }
    wp_send_json_success();
  }
}
ZC_System_Marketing::init();
