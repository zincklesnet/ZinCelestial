<?php
if(!defined('ABSPATH'))exit;
class ZC_BP_Profile_Cover{
  public static function init(){
    add_action('wp_ajax_zc_upload_cover',array('ZC_BP_Profile_Cover','ajax_upload'));
    add_shortcode('zc_profile_cover',array('ZC_BP_Profile_Cover','shortcode'));
  }
  public static function ajax_upload(){
    check_ajax_referer('zc_nonce','nonce');
    if(!is_user_logged_in()){wp_send_json_error();return;}
    if(empty($_FILES['cover'])){wp_send_json_error(__('No file uploaded','zincelestial'));return;}
    require_once ABSPATH.'wp-admin/includes/image.php';
    require_once ABSPATH.'wp-admin/includes/file.php';
    require_once ABSPATH.'wp-admin/includes/media.php';
    $attachment_id=media_handle_upload('cover',0);
    if(is_wp_error($attachment_id)){wp_send_json_error($attachment_id->get_error_message());return;}
    $user_id=get_current_user_id();
    update_user_meta($user_id,'zc_cover_image_id',$attachment_id);
    wp_send_json_success(array('url'=>wp_get_attachment_url($attachment_id)));
  }
  public static function shortcode($atts){
    $a=shortcode_atts(array('user_id'=>get_current_user_id()),$atts);
    $cover_id=get_user_meta($a['user_id'],'zc_cover_image_id',true);
    if(!$cover_id)return '';
    return '<img src="'.esc_url(wp_get_attachment_url($cover_id)).'" class="zc-profile-cover" alt="'.esc_attr__('Profile cover','zincelestial').'">';
  }
}
ZC_BP_Profile_Cover::init();
