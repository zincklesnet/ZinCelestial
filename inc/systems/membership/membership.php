<?php
if(!defined("ABSPATH"))exit;
if(!defined('ABSPATH'))exit;
class ZC_System_Membership{
  public static function init(){
    add_action('init',array('ZC_System_Membership','setup'));
    add_filter('the_content',array('ZC_System_Membership','content_gating'),5);
    add_action('wp_ajax_zc_check_access',array('ZC_System_Membership','check_access'));
    add_shortcode('zc_members_only',array('ZC_System_Membership','members_only_sc'));
    add_shortcode('zc_premium_only',array('ZC_System_Membership','premium_only_sc'));
  }
  public static function setup(){do_action('zc_membership_ready');}
  public static function has_access($user_id=null,$post_id=null){
    if(!$user_id)$user_id=get_current_user_id();
    if(!$post_id)$post_id=get_the_ID();
    $required=get_post_meta($post_id,'_zc_membership_required',true);
    if(!$required)return true;
    if(!$user_id)return false;
    if($required==='premium')return zc_user_is_premium($user_id);
    if(function_exists('pmpro_hasMembershipLevel'))return pmpro_hasMembershipLevel($required,$user_id);
    if(function_exists('memberpress_has_membership'))return true;
    return current_user_can('read');
  }
  public static function content_gating($content){
    if(!is_singular())return $content;
    $post_id=get_the_ID();
    if(!self::has_access(get_current_user_id(),$post_id)){
      return '<div class="zc-content-gate">'.
        '<div class="zc-content-gate__icon">🔒</div>'.
        '<h3 class="zc-content-gate__title">'.esc_html__('Premium Content','zincelestial').'</h3>'.
        '<p>'.esc_html__('This content is available to premium members only.','zincelestial').'</p>'.
        '<a href="'.esc_url(zc_option('membership_signup_url',wp_login_url(get_permalink()))).'" class="zc-btn zc-btn--primary">'.esc_html__('Upgrade to Premium','zincelestial').'</a>'.
        '</div>';
    }
    return $content;
  }
  public static function check_access(){
    check_ajax_referer('zc_nonce','nonce');
    $post_id=intval($_POST['post_id']??0);
    wp_send_json_success(array('access'=>self::has_access(get_current_user_id(),$post_id)));
  }
  public static function members_only_sc($atts,$content=''){
    if(!is_user_logged_in())return '<div class="zc-gate-msg">'.esc_html__('Please log in to view this content.','zincelestial').'</div>';
    return do_shortcode($content);
  }
  public static function premium_only_sc($atts,$content=''){
    if(!zc_user_is_premium())return '<div class="zc-gate-msg">'.esc_html__('Premium membership required.','zincelestial').'</div>';
    return do_shortcode($content);
  }
}
ZC_System_Membership::init();
