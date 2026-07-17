<?php
if(!defined("ABSPATH"))exit;
if(!defined('ABSPATH'))exit;
class ZC_System_Economy{
  public static function init(){
    add_action('init',array('ZC_System_Economy','setup'));
    add_action('zc_react_saved',array('ZC_System_Economy','award_reaction_points'),10,3);
    add_action('wp_ajax_zc_transfer_points',array('ZC_System_Economy','transfer'));
    add_shortcode('zc_points_balance',array('ZC_System_Economy','balance_sc'));
  }
  public static function setup(){do_action('zc_economy_ready');}
  public static function award_reaction_points($user_id,$post_id,$type){
    if(!function_exists('gamipress_award_points_to_user'))return;
    $points_map=array('fire'=>5,'star'=>4,'love'=>3,'wow'=>3,'laugh'=>2,'sad'=>1,'angry'=>1,'rocket'=>6);
    $points=$points_map[$type]??1;
    $post_author=(int)get_post_field('post_author',$post_id);
    if($post_author&&$post_author!==$user_id){
      gamipress_award_points_to_user($post_author,$points,'zcreds',array('admin_id'=>0,'reason'=>sprintf(__('Reaction received on post #%d','zincelestial'),$post_id)));
    }
    // Award reactor points too
    gamipress_award_points_to_user($user_id,1,'zcreds',array('admin_id'=>0,'reason'=>__('Gave a reaction','zincelestial')));
  }
  public static function transfer(){
    check_ajax_referer('zc_nonce','nonce');
    if(!is_user_logged_in()){wp_send_json_error();return;}
    $to=intval($_POST['to_user']??0);
    $amount=intval($_POST['amount']??0);
    $type=sanitize_key($_POST['type']??'zcreds');
    if(!$to||$amount<=0){wp_send_json_error(__('Invalid transfer','zincelestial'));return;}
    $from=get_current_user_id();
    if(!function_exists('gamipress_get_user_points')){wp_send_json_error(__('Points system unavailable','zincelestial'));return;}
    $balance=gamipress_get_user_points($from,$type);
    if($balance<$amount){wp_send_json_error(__('Insufficient balance','zincelestial'));return;}
    gamipress_deduct_points_to_user($from,$amount,$type,array('admin_id'=>0,'reason'=>sprintf(__('Transferred to user #%d','zincelestial'),$to)));
    gamipress_award_points_to_user($to,$amount,$type,array('admin_id'=>0,'reason'=>sprintf(__('Received from user #%d','zincelestial'),$from)));
    wp_send_json_success(array('new_balance'=>gamipress_get_user_points($from,$type)));
  }
  public static function balance_sc($atts){
    $a=shortcode_atts(array('user_id'=>get_current_user_id(),'type'=>'zcreds'),$atts);
    if(!function_exists('gamipress_get_user_points'))return '0';
    return esc_html(number_format_i18n(gamipress_get_user_points($a['user_id'],$a['type'])));
  }
}
ZC_System_Economy::init();
