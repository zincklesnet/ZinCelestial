<?php
if(!defined('ABSPATH'))exit;
class ZC_BP_Groups{
  public static function init(){
    if(!function_exists('buddypress'))return;
    add_action('bp_group_header_actions',array('ZC_BP_Groups','header_actions'));
    add_action('zc_bp_group_cover',array('ZC_BP_Groups','render_cover'));
    add_filter('bp_get_group_description_excerpt',array('ZC_BP_Groups','group_excerpt'));
  }
  public static function header_actions(){do_action('zc_bp_group_header_actions');}
  public static function render_cover($group_id){
    $cover='';
    if(function_exists('bp_attachments_get_attachment')){
      $cover=bp_attachments_get_attachment('url',array('object_dir'=>'groups','item_id'=>$group_id));
    }
    if($cover){
      echo '<img src="'.esc_url($cover).'" class="zc-bp-group-cover" alt="'.esc_attr__('Group cover','zincelestial').'">';
    } else {
      echo '<div class="zc-bp-group-cover zc-bp-group-cover--default"></div>';
    }
  }
  public static function group_excerpt($excerpt){return $excerpt;}
}
ZC_BP_Groups::init();
