<?php
if(!defined('ABSPATH'))exit;
class ZC_Color_Mode{
  public static function init(){
    add_action('wp_ajax_zc_save_color_mode',array('ZC_Color_Mode','save_ajax'));
    add_action('wp_ajax_nopriv_zc_save_color_mode',array('ZC_Color_Mode','save_ajax'));
    add_action('wp_ajax_zc_save_scheme',array('ZC_Color_Mode','save_scheme_ajax'));
    add_action('wp_ajax_nopriv_zc_save_scheme',array('ZC_Color_Mode','save_scheme_ajax'));
  }
  public static function save_ajax(){
    check_ajax_referer('zc_nonce','nonce');
    $mode=sanitize_key($_POST['mode']??'dark');
    $allowed=array('dark','light','auto','scheduled');
    if(!in_array($mode,$allowed)){wp_send_json_error('Invalid mode');return;}
    if(is_user_logged_in()){
      update_user_meta(get_current_user_id(),'zc_color_mode',$mode);
    }
    // Also set cookie for non-logged-in users
    setcookie('zc_color_mode',$mode,time()+YEAR_IN_SECONDS,COOKIEPATH,COOKIE_DOMAIN,is_ssl(),true);
    wp_send_json_success(array('mode'=>$mode));
  }
  public static function save_scheme_ajax(){
    check_ajax_referer('zc_nonce','nonce');
    $scheme=sanitize_key($_POST['scheme']??'cosmic');
    $free=array('cosmic','aurora','nova');
    $premium=array('zenith','ember','twilight','nebula','solaris','quantum');
    if(in_array($scheme,$premium)&&!zc_user_is_premium()){
      wp_send_json_error(__('Premium scheme requires a premium account.','zincelestial'));return;
    }
    if(!in_array($scheme,array_merge($free,$premium))){
      wp_send_json_error('Invalid scheme');return;
    }
    if(is_user_logged_in()){
      update_user_meta(get_current_user_id(),'zc_template_scheme',$scheme);
    }
    wp_send_json_success(array('scheme'=>$scheme));
  }
  public static function get_mode_for_user(){
    if(is_user_logged_in()){
      $mode=get_user_meta(get_current_user_id(),'zc_color_mode',true);
      if($mode)return $mode;
    }
    if(isset($_COOKIE['zc_color_mode']))return sanitize_key($_COOKIE['zc_color_mode']);
    return zc_option('default_color_mode','dark');
  }
}
ZC_Color_Mode::init();
