<?php
if(!defined('ABSPATH'))exit;
class ZC_Security{
  public static function init(){
    add_action('init',array('ZC_Security','hardening'));
    add_action('login_init',array('ZC_Security','login_protection'));
    add_filter('wp_headers',array('ZC_Security','security_headers'));
    add_action('wp_head',array('ZC_Security','csp_nonce'),0);
    add_action('init',array('ZC_Security','disable_xmlrpc'));
    add_filter('rest_authentication_errors',array('ZC_Security','rest_auth_check'));
    add_action('wp_ajax_zc_reaction',array('ZC_Security','verify_reaction_nonce'));
    add_action('wp_ajax_nopriv_zc_get_reactions',array('ZC_Security','get_reactions_public'));
  }
  public static function hardening(){
    remove_action('wp_head','wp_generator');
    remove_action('wp_head','wlwmanifest_link');
    remove_action('wp_head','rsd_link');
    add_filter('the_generator',function(){return '';});
    if(zc_option('disable_file_edit','1')==='1'){
      if(!defined('DISALLOW_FILE_EDIT'))define('DISALLOW_FILE_EDIT',true);
    }
  }
  public static function login_protection(){
    if(zc_option('rename_login_url','0')==='1'){
      // Login URL customization hook
      do_action('zc_login_url_protection');
    }
  }
  public static function security_headers($headers){
    $headers['X-Content-Type-Options']='nosniff';
    $headers['X-Frame-Options']='SAMEORIGIN';
    $headers['X-XSS-Protection']='1; mode=block';
    $headers['Referrer-Policy']='strict-origin-when-cross-origin';
    if(is_ssl()){
      $headers['Strict-Transport-Security']='max-age=31536000; includeSubDomains';
    }
    return $headers;
  }
  public static function csp_nonce(){
    // CSP nonce generation for inline scripts
    if(!defined('ZC_CSP_NONCE')){
      define('ZC_CSP_NONCE',base64_encode(random_bytes(16)));
    }
  }
  public static function disable_xmlrpc(){
    if(zc_option('disable_xmlrpc','0')==='1'){
      add_filter('xmlrpc_enabled',function(){return false;});
    }
  }
  public static function rest_auth_check($result){
    if(!empty($result))return $result;
    if(!is_user_logged_in()&&zc_option('require_rest_auth','0')==='1'){
      $route=isset($_SERVER['REQUEST_URI'])?$_SERVER['REQUEST_URI']:'';
      if(strpos($route,'/wp-json/zc/')!==false){
        return new WP_Error('rest_not_logged_in',__('You must be logged in.','zincelestial'),array('status'=>401));
      }
    }
    return $result;
  }
  public static function verify_reaction_nonce(){
    check_ajax_referer('zc_nonce','nonce');
  }
  public static function get_reactions_public(){
    $post_id=intval($_GET['post_id']??0);
    if(!$post_id){wp_send_json_error('Invalid post ID');return;}
    $reactions=get_post_meta($post_id,'_zc_reactions',true)?:array();
    wp_send_json_success($reactions);
  }
}
ZC_Security::init();
