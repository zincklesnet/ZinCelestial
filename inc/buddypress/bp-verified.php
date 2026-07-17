<?php
if(!defined('ABSPATH'))exit;
class ZC_BP_Verified{
  public static function init(){
    add_filter('bp_member_name',array('ZC_BP_Verified','add_badge'),10,2);
  }
  public static function is_verified($user_id){
    return (bool)get_user_meta($user_id,'zc_verified',true);
  }
  public static function add_badge($name,$user_id=null){
    if(!$user_id)return $name;
    if(self::is_verified($user_id)){
      $name.=' <span class="zc-verified-badge" title="'.esc_attr__('Verified','zincelestial').'">✓</span>';
    }
    return $name;
  }
}
ZC_BP_Verified::init();
