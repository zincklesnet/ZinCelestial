<?php
if(!defined('ABSPATH'))exit;
class ZC_Compatibility{
  public static function init(){
    add_action('after_setup_theme',array('ZC_Compatibility','check'));
    add_filter('zc_sidebar_layout',array('ZC_Compatibility','override_layout'));
  }
  public static function check(){
    // Child theme compatibility
    if(is_child_theme()&&get_template()!=='zincelestial'){
      add_action('admin_notices',function(){
        echo '<div class="notice notice-warning"><p>'.esc_html__('ZinCelestial: Child theme detected from different parent. Some features may not work correctly.','zincelestial').'</p></div>';
      });
    }
  }
  public static function override_layout($layout){
    if(function_exists('is_buddypress')&&is_buddypress())return'none';
    if(function_exists('is_bbpress')&&is_bbpress()){
      $bbp_layout=zc_option('bbpress_sidebar_layout','right');
      return$bbp_layout;
    }
    if(function_exists('is_woocommerce')&&(is_woocommerce()||is_cart()||is_checkout()))return'none';
    return$layout;
  }
}
ZC_Compatibility::init();
