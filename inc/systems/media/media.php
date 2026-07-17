<?php
if(!defined('ABSPATH'))exit;
/**
 * ZinCelestial — Media System
 * v3.3 Fix: lazy_load() now guards against running during excerpt generation
 *           (doing_filter('get_the_excerpt') / doing_filter('the_excerpt'))
 *           which was the second leg of the fatal recursive chain.
 */
class ZC_System_Media{
  public static function init(){
    add_filter('upload_mimes',array('ZC_System_Media','allowed_mimes'));
    add_filter('wp_handle_upload',array('ZC_System_Media','after_upload'));
    add_action('wp_ajax_zc_media_delete',array('ZC_System_Media','delete_media'));
    add_filter('the_content',array('ZC_System_Media','lazy_load'),99);
    add_action('wp_head',array('ZC_System_Media','preconnect_cdn'));
  }

  public static function allowed_mimes($mimes){
    $mimes['svg']='image/svg+xml';
    $mimes['webp']='image/webp';
    $mimes['avif']='image/avif';
    return $mimes;
  }

  public static function after_upload($upload){
    do_action('zc_media_uploaded',$upload);
    return $upload;
  }

  public static function delete_media(){
    check_ajax_referer('zc_nonce','nonce');
    if(!is_user_logged_in()){wp_send_json_error();return;}
    $attachment_id=intval($_POST['attachment_id']??0);
    if(!$attachment_id){wp_send_json_error();return;}
    $author=(int)get_post_field('post_author',$attachment_id);
    if($author!==get_current_user_id()&&!current_user_can('delete_others_posts')){
      wp_send_json_error(__('Not allowed','zincelestial'));return;
    }
    wp_delete_attachment($attachment_id,true);
    wp_send_json_success();
  }

  /**
   * Add loading="lazy" to <img> tags in post content.
   *
   * Guard: skip entirely if we are currently generating an excerpt.
   * get_the_excerpt() → the_excerpt filter → the_content filter → this function
   * would form a recursive loop that causes a fatal TypeError.
   */
  public static function lazy_load($content){
    // ── Bug fix v3.3: bail out during any excerpt-related filter ──────────
    if(doing_filter('get_the_excerpt')||doing_filter('the_excerpt')){
      return $content;
    }
    if(zc_option('enable_lazy_load','1')!=='1')return $content;
    return preg_replace_callback('/<img([^>]*)>/i',function($m){
      if(strpos($m[1],'loading=')!==false)return $m[0];
      return '<img'.$m[1].' loading="lazy">';
    },$content);
  }

  public static function preconnect_cdn(){
    $cdn=zc_option('cdn_url','');
    if($cdn){
      echo '<link rel="preconnect" href="'.esc_url($cdn).'">'."\n";
    }
  }
}
ZC_System_Media::init();
