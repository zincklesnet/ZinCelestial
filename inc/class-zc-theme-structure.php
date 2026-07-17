<?php
if(!defined('ABSPATH'))exit;
/**
 * ZinCelestial Theme Structure Class
 * Mirrors ZinCelestial Reference's class-zincelestial-ref-theme-structure.php pattern
 */
class ZC_Theme_Structure{
  private static $instance=null;
  public static function get_instance(){
    if(is_null(self::$instance))self::$instance=new self();
    return self::$instance;
  }
  private function __construct(){
    add_action('after_setup_theme',array($this,'load'),1);
  }
  public function load(){
    do_action('zc_theme_structure_init',$this);
  }
  public function get_layout(){return zc_sidebar_layout();}
  public function get_scheme(){return zc_get_active_scheme();}
  public function get_option($key,$default=''){return zc_option($key,$default);}
  public function is_multisite(){return is_multisite();}
  public function get_container_class(){
    $classes=['zc-container'];
    if(zc_option('full_width_layout','0')==='1')$classes[]='zc-container--full';
    return implode(' ',$classes);
  }
  public function get_header_classes(){
    $classes=['zc-header'];
    if(zc_option('sticky_header','1')==='1')$classes[]='zc-header--sticky';
    if(zc_option('transparent_header','0')==='1')$classes[]='zc-header--transparent';
    return implode(' ',$classes);
  }
}
ZC_Theme_Structure::get_instance();
