<?php
if(!defined("ABSPATH"))exit;
if(!defined('ABSPATH'))exit;
class ZC_System_Core{
  public static function init(){
    add_action('init',array('ZC_System_Core','setup'),1);
    add_action('wp',array('ZC_System_Core','context'));
    add_filter('zc_system_active',array('ZC_System_Core','is_active'),10,2);
  }
  public static function setup(){
    define('ZC_SYSTEM_CORE','3.0');
    do_action('zc_core_loaded');
  }
  public static function context(){
    do_action('zc_context_ready');
  }
  public static function is_active($active,$system){return $active;}
}
ZC_System_Core::init();
