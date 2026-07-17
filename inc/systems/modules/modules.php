<?php
if(!defined('ABSPATH'))exit;
class ZC_System_Modules{
  private static $modules=array();
  public static function init(){
    add_action('init',array('ZC_System_Modules','discover'),5);
    add_action('wp_ajax_zc_toggle_module',array('ZC_System_Modules','toggle'));
    add_shortcode('zc_module',array('ZC_System_Modules','module_shortcode'));
  }
  public static function register($slug,$args){
    self::$modules[$slug]=wp_parse_args($args,array('name'=>$slug,'description'=>'','version'=>'1.0','active'=>true,'callback'=>null));
  }
  public static function discover(){
    // Register built-in modules
    self::register('compose-bar',array('name'=>__('Compose Bar','zincelestial'),'description'=>__('Activity compose bar at top of feed','zincelestial'),'active'=>zc_option('show_compose_bar','1')==='1'));
    self::register('gamipress-bar',array('name'=>__('GamiPress Bar','zincelestial'),'description'=>__('XP/points/rank header bar','zincelestial'),'active'=>zc_option('show_gamipress_bar','1')==='1'));
    self::register('reactions',array('name'=>__('Reactions','zincelestial'),'description'=>__('Animated post reactions system','zincelestial'),'active'=>zc_option('reactions_enabled','1')==='1'));
    self::register('color-mode',array('name'=>__('Color Mode','zincelestial'),'description'=>__('Dark/Light/Auto color mode toggle','zincelestial'),'active'=>true));
    self::register('trending-overlay',array('name'=>__('Trending Overlay','zincelestial'),'description'=>__('Top reaction overlay on post thumbnails','zincelestial'),'active'=>zc_option('reactions_overlay','1')==='1'));
    self::register('scheme-switcher',array('name'=>__('Scheme Switcher','zincelestial'),'description'=>__('Frontend theme scheme switcher FAB','zincelestial'),'active'=>zc_option('show_scheme_switcher','1')==='1'));
    do_action('zc_register_modules');
  }
  public static function get_all(){return self::$modules;}
  public static function is_active($slug){return !empty(self::$modules[$slug]['active']);}
  public static function toggle(){
    check_ajax_referer('zc_admin_nonce','nonce');
    if(!current_user_can('edit_theme_options')){wp_send_json_error();return;}
    $slug=sanitize_key($_POST['module']??'');
    $state=rest_sanitize_boolean($_POST['active']??false);
    $opts=get_option('zincelestial_options',array());
    $map=array('compose-bar'=>'show_compose_bar','gamipress-bar'=>'show_gamipress_bar','reactions'=>'reactions_enabled','trending-overlay'=>'reactions_overlay','scheme-switcher'=>'show_scheme_switcher');
    if(isset($map[$slug])){
      $opts[$map[$slug]]=$state?'1':'0';
      update_option('zincelestial_options',$opts);
    }
    wp_send_json_success(array('module'=>$slug,'active'=>$state));
  }
  public static function module_shortcode($atts){
    $a=shortcode_atts(array('id'=>''),$atts);
    if(!$a['id']||!self::is_active($a['id']))return '';
    $module=self::$modules[$a['id']]??null;
    if(!$module)return '';
    ob_start();
    if(is_callable($module['callback'])){call_user_func($module['callback']);}
    return ob_get_clean();
  }
}
ZC_System_Modules::init();
