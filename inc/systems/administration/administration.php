<?php
if(!defined('ABSPATH'))exit;
class ZC_System_Administration{
  public static function init(){
    add_action('admin_bar_menu',array('ZC_System_Administration','admin_bar_items'),999);
    add_action('wp_dashboard_setup',array('ZC_System_Administration','dashboard_widgets'));
    add_action('admin_notices',array('ZC_System_Administration','admin_notices'));
    add_filter('admin_footer_text',array('ZC_System_Administration','footer_text'));
    add_action('wp_ajax_zc_dismiss_notice',array('ZC_System_Administration','dismiss_notice'));
  }
  public static function admin_bar_items($wp_admin_bar){
    if(!current_user_can('edit_theme_options'))return;
    $wp_admin_bar->add_node(array('id'=>'zc-admin','title'=>'⚡ ZinCelestial','href'=>admin_url('admin.php?page=zc-dashboard')));
    $wp_admin_bar->add_node(array('id'=>'zc-customize','parent'=>'zc-admin','title'=>__('Customize','zincelestial'),'href'=>wp_customize_url()));
    $wp_admin_bar->add_node(array('id'=>'zc-performance','parent'=>'zc-admin','title'=>__('Performance','zincelestial'),'href'=>admin_url('admin.php?page=zc-performance')));
  }
  public static function dashboard_widgets(){
    wp_add_dashboard_widget('zc_status_widget',__('ZinCelestial Status','zincelestial'),array('ZC_System_Administration','status_widget'));
  }
  public static function status_widget(){
    echo '<div class="zc-status-widget">';
    echo '<p><strong>'.esc_html__('Theme Version','zincelestial').':</strong> '.ZC_VERSION.'</p>';
    echo '<p><strong>'.esc_html__('Active Scheme','zincelestial').':</strong> '.esc_html(zc_get_active_scheme()).'</p>';
    echo '<p><strong>'.esc_html__('Color Mode','zincelestial').':</strong> '.esc_html(zc_option('default_color_mode','dark')).'</p>';
    echo '<p><a href="'.esc_url(admin_url('admin.php?page=zc-dashboard')).'" class="button button-primary">'.esc_html__('Open ZinCelestial','zincelestial').'</a></p>';
    echo '</div>';
  }
  public static function admin_notices(){
    $dismissed=(array)get_user_meta(get_current_user_id(),'zc_dismissed_notices',true);
    if(!in_array('welcome',$dismissed)&&is_admin()&&current_user_can('edit_theme_options')){
      echo '<div class="notice notice-info zc-welcome-notice is-dismissible" data-notice="welcome">';
      echo '<p>'.sprintf(__('Welcome to ZinCelestial v%s! <a href="%s">Configure your theme</a>.','zincelestial'),ZC_VERSION,admin_url('admin.php?page=zc-dashboard')).'</p>';
      echo '</div>';
    }
  }
  public static function footer_text($text){
    return sprintf(__('ZinCelestial v%s by Zinckles','zincelestial'),ZC_VERSION);
  }
  public static function dismiss_notice(){
    check_ajax_referer('zc_admin_nonce','nonce');
    $notice=sanitize_key($_POST['notice']??'');
    if(!$notice)return;
    $dismissed=(array)get_user_meta(get_current_user_id(),'zc_dismissed_notices',true);
    $dismissed[]=$notice;
    update_user_meta(get_current_user_id(),'zc_dismissed_notices',array_unique($dismissed));
    wp_send_json_success();
  }
}
ZC_System_Administration::init();
