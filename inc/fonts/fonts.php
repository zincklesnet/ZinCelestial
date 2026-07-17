<?php
if(!defined('ABSPATH'))exit;
class ZC_Fonts{
  const GOOGLE_FONTS=['Inter','Syne','JetBrains Mono','Roboto','Poppins','Nunito','Raleway','Montserrat','Open Sans','Lato'];
  public static function init(){
    add_action('customize_register',array('ZC_Fonts','customizer'));
    add_filter('zc_available_fonts',array('ZC_Fonts','get_fonts'));
  }
  public static function get_fonts($fonts){
    return array_merge($fonts,self::GOOGLE_FONTS);
  }
  public static function customizer($wp_customize){
    do_action('zc_fonts_customizer',$wp_customize);
  }
  public static function get_font_stack($font){
    $stacks=array('Inter'=>"'Inter', system-ui, sans-serif",'Syne'=>"'Syne', sans-serif",'JetBrains Mono'=>"'JetBrains Mono', monospace");
    return$stacks[$font]??"'".$font."', sans-serif";
  }
}
ZC_Fonts::init();
