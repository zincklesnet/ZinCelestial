<?php
if(!defined('ABSPATH'))exit;
class ZC_BP_Hooks{
  public static function init(){
    if(!function_exists('buddypress'))return;
    add_action('bp_before_member_header',array('ZC_BP_Hooks','member_cover'));
    add_action('bp_after_member_header',array('ZC_BP_Hooks','member_gamipress'));
    add_action('bp_before_group_header',array('ZC_BP_Hooks','group_cover'));
    add_action('bp_before_activity_post_form',array('ZC_BP_Hooks','activity_compose_bar'));
    add_action('bp_activity_after_post_comment',array('ZC_BP_Hooks','activity_reactions'));
    add_action('bp_before_directory_members',array('ZC_BP_Hooks','members_header'));
    add_action('bp_before_directory_groups',array('ZC_BP_Hooks','groups_header'));
    add_filter('bp_avatar_upload_dir',array('ZC_BP_Hooks','avatar_dir'));
    add_filter('bp_get_activity_content_body',array('ZC_BP_Hooks','enhance_activity_content'));
  }
  public static function member_cover(){
    echo '<div class="zc-bp-cover-wrap">';
    do_action('zc_bp_member_cover',bp_displayed_user_id());
    echo '</div>';
  }
  public static function member_gamipress(){
    if(zc_option('show_gamipress_bar','1')==='1'){
      echo '<div class="zc-bp-gamipress-bar">';
      do_action('zc_gamipress_bar',bp_displayed_user_id());
      echo '</div>';
    }
  }
  public static function group_cover(){
    echo '<div class="zc-bp-group-cover-wrap">';
    do_action('zc_bp_group_cover',bp_get_current_group_id());
    echo '</div>';
  }
  public static function activity_compose_bar(){
    if(zc_option('show_compose_bar','1')==='1'){
      get_template_part('template-parts/global/compose-bar');
    }
  }
  public static function activity_reactions(){
    global $activities_template;
    if(empty($activities_template->activity))return;
    $post_id=$activities_template->activity->id;
    do_action('zc_reactions_bar',$post_id,'bp_activity');
  }
  public static function members_header(){
    echo '<div class="zc-bp-dir-header">';
    echo '<h1 class="zc-bp-dir-title">'.esc_html__('Members','zincelestial').'</h1>';
    echo '</div>';
  }
  public static function groups_header(){
    echo '<div class="zc-bp-dir-header">';
    echo '<h1 class="zc-bp-dir-title">'.esc_html__('Groups','zincelestial').'</h1>';
    echo '</div>';
  }
  public static function avatar_dir($dir){return $dir;}
  public static function enhance_activity_content($content){
    return $content;
  }
}
ZC_BP_Hooks::init();
