<?php
if(!defined('ABSPATH'))exit;
class ZC_BP_Members{
  public static function init(){
    if(!function_exists('buddypress'))return;
    add_filter('bp_core_get_user_domain',array('ZC_BP_Members','user_domain'),10,2);
    add_action('bp_displayed_user_nav',array('ZC_BP_Members','enhanced_nav'));
    add_filter('bp_member_avatar_url',array('ZC_BP_Members','avatar_url'),10,3);
    add_action('zc_bp_member_cover',array('ZC_BP_Members','render_cover'));
  }
  public static function user_domain($domain,$user_id){return $domain;}
  public static function enhanced_nav(){
    // Additional nav items hook
    do_action('zc_bp_member_nav_items');
  }
  public static function avatar_url($url,$params,$item_id){return $url;}
  public static function render_cover($user_id){
    $cover='';
    if(function_exists('youzify_get_profile_cover_image')){
      $cover=youzify_get_profile_cover_image($user_id);
    } elseif(function_exists('bp_attachments_get_attachment')){
      $cover=bp_attachments_get_attachment('url',array('object_dir'=>'members','item_id'=>$user_id));
    }
    if($cover){
      echo '<img src="'.esc_url($cover).'" class="zc-bp-member-cover" alt="'.esc_attr__('Cover photo','zincelestial').'">';
    } else {
      echo '<div class="zc-bp-member-cover zc-bp-member-cover--default"></div>';
    }
  }
}
ZC_BP_Members::init();
