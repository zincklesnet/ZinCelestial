<?php
if(!defined('ABSPATH'))exit;
class ZC_Reactions{
  const TYPES=['fire','star','love','wow','laugh','sad','angry','rocket'];
  const EMOJIS=['fire'=>'🔥','star'=>'⭐','love'=>'❤️','wow'=>'😮','laugh'=>'😂','sad'=>'😢','angry'=>'😠','rocket'=>'🚀'];
  public static function init(){
    add_action('wp_ajax_zc_react',array('ZC_Reactions','ajax_react'));
    add_action('wp_ajax_nopriv_zc_react',array('ZC_Reactions','ajax_react_nopriv'));
    add_action('wp_ajax_zc_get_reactions',array('ZC_Reactions','ajax_get'));
    add_action('wp_ajax_nopriv_zc_get_reactions',array('ZC_Reactions','ajax_get'));
    add_action('zc_after_post_content',array('ZC_Reactions','render_overlay_if_needed'));
    // BuddyPress activity reactions
    if(function_exists('bp_is_active')){
      add_action('bp_activity_entry_content',array('ZC_Reactions','render_bp_reactions'));
    }
    // Multisite sync
    if(is_multisite()){
      add_action('zc_react_saved',array('ZC_Reactions','sync_to_network'),10,3);
    }
  }
  public static function ajax_react(){
    check_ajax_referer('zc_nonce','nonce');
    if(!is_user_logged_in()){wp_send_json_error(__('Must be logged in','zincelestial'));return;}
    $post_id=intval($_POST['post_id']??0);
    $type=sanitize_key($_POST['type']??'');
    if(!$post_id||!in_array($type,self::TYPES)){wp_send_json_error('Invalid');return;}
    $result=self::save_reaction(get_current_user_id(),$post_id,$type);
    wp_send_json_success($result);
  }
  public static function ajax_react_nopriv(){
    wp_send_json_error(__('Please log in to react.','zincelestial'));
  }
  public static function ajax_get(){
    $post_id=intval($_GET['post_id']??0);
    if(!$post_id){wp_send_json_error('Invalid');return;}
    $reactions=get_post_meta($post_id,'_zc_reactions',true)?:array();
    $user_reaction='';
    if(is_user_logged_in()){
      $user_reaction=get_user_meta(get_current_user_id(),'_zc_reaction_'.$post_id,true)?:'';
    }
    wp_send_json_success(array('reactions'=>$reactions,'user_reaction'=>$user_reaction,'top'=>self::get_top($reactions)));
  }
  public static function save_reaction($user_id,$post_id,$type){
    $reactions=get_post_meta($post_id,'_zc_reactions',true)?:array();
    foreach(self::TYPES as $t){if(!isset($reactions[$t]))$reactions[$t]=0;}
    $current=get_user_meta($user_id,'_zc_reaction_'.$post_id,true);
    if($current){
      // Remove old reaction
      if(isset($reactions[$current])&&$reactions[$current]>0)$reactions[$current]--;
    }
    if($current===$type){
      // Toggle off
      delete_user_meta($user_id,'_zc_reaction_'.$post_id);
      $user_reaction='';
    } else {
      $reactions[$type]++;
      update_user_meta($user_id,'_zc_reaction_'.$post_id,$type);
      $user_reaction=$type;
    }
    update_post_meta($post_id,'_zc_reactions',$reactions);
    do_action('zc_react_saved',$user_id,$post_id,$user_reaction);
    return array('reactions'=>$reactions,'user_reaction'=>$user_reaction,'top'=>self::get_top($reactions));
  }
  public static function get_top($reactions){
    if(empty($reactions))return null;
    arsort($reactions);
    $top=array_key_first($reactions);
    return $reactions[$top]>0?array('type'=>$top,'emoji'=>self::EMOJIS[$top]??'','count'=>$reactions[$top]):null;
  }
  public static function render_overlay($post_id){
    $reactions=get_post_meta($post_id,'_zc_reactions',true)?:array();
    $top=self::get_top($reactions);
    if(!$top)return;
    echo '<div class="zc-reaction-overlay zc-reaction-overlay--'.esc_attr($top['type']).'" title="'.esc_attr(sprintf(__('Top reaction: %s','zincelestial'),$top['type'])).'">';
    echo '<span class="zc-reaction-overlay__emoji">'.esc_html($top['emoji']).'</span>';
    echo '<span class="zc-reaction-overlay__count">'.intval($top['count']).'</span>';
    echo '</div>';
  }
  public static function render_overlay_if_needed($post_id){
    if(zc_option('reactions_overlay','1')==='1')self::render_overlay($post_id);
  }
  public static function render_bp_reactions(){
    global $activities_template;
    if(empty($activities_template->activity))return;
    $activity_id=$activities_template->activity->id;
    $post_id=!empty($activities_template->activity->secondary_item_id)?$activities_template->activity->secondary_item_id:0;
    if(!$post_id)return;
    do_action('zc_reactions_bar',$post_id,'activity');
  }
  public static function sync_to_network($user_id,$post_id,$type){
    // Store reaction data in network-wide table for cross-site aggregation
    $network_reactions=get_site_option('zc_network_reactions_'.get_current_blog_id(),array());
    $network_reactions[$post_id][$user_id]=$type;
    update_site_option('zc_network_reactions_'.get_current_blog_id(),$network_reactions);
  }
  public static function get_viral_score($post_id){
    $reactions=get_post_meta($post_id,'_zc_reactions',true)?:array();
    $total=array_sum($reactions);
    $views=(int)get_post_meta($post_id,'_zc_views',true);
    if(!$views||!$total)return 0;
    return round(($total/$views)*100,2);
  }
}
ZC_Reactions::init();
