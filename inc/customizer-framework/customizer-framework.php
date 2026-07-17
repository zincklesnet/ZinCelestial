<?php
if(!defined('ABSPATH'))exit;
// ZinCelestial Customizer Framework - Extended controls
class ZC_Customizer_Framework{
  public static function init(){
    add_action('customize_register',array('ZC_Customizer_Framework','register_controls'),5);
  }
  public static function register_controls($wp_customize){
    // Register custom control classes if needed
    do_action('zc_register_customizer_controls',$wp_customize);
  }
}
ZC_Customizer_Framework::init();
